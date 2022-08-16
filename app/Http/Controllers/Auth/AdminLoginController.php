<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helper\AddressHelper;
use App\Http\Requests\Admin\AdminLoginRequest;

use App\Models\Category;
use App\Models\City;
use App\Models\Distrist;
use App\Models\Room;
use App\Models\Documment;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    private $user;
    private $district;
    private $room;
    private $documment;
    private $city;
    private $category;

    public function __construct(User $user, Category $category, City $city, Distrist $district, Room $room,Documment $documment)
    {
        $this->documment = $documment;
        $this->room = $room;
        $this->user = $user;
        $this->city = $city;
        $this->district = $district;
        $this->category = $category;
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return view('admin.pages.index');
        } else {
            return view('auth.admin_login');
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:8',
        ]);


        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect('/admin');
        } else {
            return redirect()->back()->with('status', 'Email hoặc Password không chính xác');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function showActiveUserForm(Request $request)
    {
        $authCheck = Auth::user();

        $params = $request->all();
        $where = [];
        $address = new AddressHelper();
        $dataCity = $this->city->orderby('name')->get();

        if(isset($params['district_id'])){
            $nameDistrict = $this->district->where('id', $params['district_id'])->first();
        }

        $data  = $this->user->where('status', 2);
        if (isset($params['keyword']) && $params['keyword']) {
            $data = $data->where(function ($query) use ($params) {
                $query->where([
                    ['name', 'like', '%' . $params['keyword'] . '%']
                ])->orWhere([
                    ['user_code', 'like', '%' . $params['keyword'] . '%']
                ])
                ->orWhere([
                    ['email', 'like', '%' . $params['keyword'] . '%']
                ])
                ->orWhere([
                    ['phone', 'like', '%' . $params['keyword'] . '%']
                ])
                ->orWhere([
                    ['address', 'like', '%' . $params['keyword'] . '%']
                ]);
            });
        }

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $dataDocuments = $this->documment
            ->when($params, function ($query) use ($params) {
                if (isset($params['start_date']) && isset($params['end_date'])) {
                    $query->whereBetween('date_working', [$params['start_date'], $params['end_date']]);
                } else {
                    $query->when(isset($params['start_date']), function ($q) use ($params) {
                        $q->where('date_working', '>=', $params['start_date']);
                    })
                    ->when(isset($params['end_date']), function ($q) use ($params) {
                        $q->where('date_working', '<=', $params['end_date']);
                    });
                }
            });

            $listIdUser = $dataDocuments->pluck('user_id');
            $data = $data->whereIn('id', $listIdUser);
        }

        $data = $data->when(isset($params['city_id']), function ($query) use ($params) {
            $idProTranCity = $this->city->where([
                ['id', $params['city_id']]
            ])->pluck('id');

            $query->whereIn('city_id', $idProTranCity);
        })
        ->when(isset($params['district_id']), function ($query) use ($params) {
            $idProTranDistrict = $this->district->where([
                ['id', $params['district_id']]
            ])->pluck('id');

                $query->whereIn('district_id', $idProTranDistrict);
        });

        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');

            switch ($key) {
                case 'active':
                    $where[] = ['active', '=', 1];
                    break;
                case 'no_active':
                    $where[] = ['active', '=', 0];
                    break;
                default:
                    break;
            }
        }

        if ($where) {
            $data = $data->where($where);
        }

        $data = $data->orderBy('created_at','desc')->latest()->paginate(15);

        $totalUser = $this->user->count();


        return view('admin.pages.user.admin-show-active-user',[
            'data' => $data,
            'authCheck' => $authCheck,
            'dataCity' => $dataCity,
            'totalCategory' => $totalUser,
            'keyword' => $request->input('keyword') ?? '',
            'start_date' => $request->input('start_date') ?? '',
            'end_date' => $request->input('end_date') ?? '',
            'city_id' => $request->input('city_id') ?? '',
            'nameDistrict' => $nameDistrict->name ?? '',
            'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",

        ]);
    }



    public function loadActiveUser($id)
    {
        $authCheck = Auth::user();

        $user   =  $this->user->find($id);
        $role = $user->role;
        if ($role=='user') {
            $roleUpdate = 'admin';
        } else {
            $roleUpdate = 'user';
        }

        if(Auth::user()->role == 'admin'){
            $updateResult =  $user->update([
                'role' => $roleUpdate,
                'status' => 1
            ]);//admin update
        }else{
            $updateResult =  $user->update([
                // 'role' => $roleUpdate,
                'status' => 2
            ]);//admin update//user update account của chính mình
        }

        $user  =  $this->user->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-role', ['data' => $user, 'type' => 'nhân viên','authCheck' => $authCheck])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function changePassword(Request $request, $id)
    {
        // dd($request->all());
        try {

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'min:8|required',
                'confirm_password' => 'required|same:new_password',
            ]);

            if (!(Hash::check($request->old_password, Auth::user()->password))) {
                // return response()->json(['html' => 'Mật khẩu của bạn không khớp với mật khẩu hiện tại.']);
                return redirect()->back()->with("error", "Mật khẩu của bạn không khớp với mật khẩu hiện tại.");
            }

            $newPass = $request->input('new_password');
            $this->user->where('id', $id)->update(['password' => Hash::make($newPass)]);

            $this->user->find($id);

            DB::commit();
            return redirect()->back()->with("alert", "Sửa mật khẩu thành công");
        } catch (\Exception $exception) {
            //throw $th;
            dd($exception);
            DB::rollBack();

            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->back()->with("error", "Sửa mật khẩu không thành công");
        }

    }
}
