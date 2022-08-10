<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helper\AddressHelper;

use App\Models\Category;
use App\Models\City;
use App\Models\Distrist;
use App\Models\Room;
use App\Models\Documment;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
        return view('auth.admin_login');
    }

    public function login(Request $request)
    {
        // validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        // attempt to log the user in
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->remember)) {
            //  return redirect()->intended('/admin');
            return redirect()->intended('/admin');
        }
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/admin/login');
    }

    public function showActiveUserForm(Request $request)
    {
        $params = $request->all();

        $address = new AddressHelper();
        $dataCity = $this->city->orderby('name')->get();
        $dataDistrict = $this->district->orderby('name')->get();
        $cities = $address->cities($dataCity);
        if(isset($params['district_id'])){
            $nameDistrict = $this->district->where('id', $params['district_id'])->first();

        }
        
        $data  = $this->user;
        if (isset($params['keyword']) && $params['keyword']) {
            $data = $data->where(function ($query) use ($params) {
                $query->where([
                    ['name', 'like', '%' . $params['keyword'] . '%']
                ]);
            });
        }

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

        
        $data = $data->orderBy('created_at','desc')->latest()->paginate(15);

        $totalCategory = $this->user->get()->count();

        return view('admin.pages.user.admin-show-active-user',[
            'data' => $data,
            'dataCity' => $dataCity,
            'totalCategory' => $totalCategory,
            'keyword' => $request->input('keyword') ?? '',
            'keyword' => $request->input('keyword') ?? '',
            'start_date' => $request->input('start_date') ?? '',
            'end_date' => $request->input('end_date') ?? '',
            'city_id' => $request->input('city_id') ?? '',
            'nameDistrict' => $nameDistrict->name ?? '',
        ]);
    }

    public function loadActiveUser($id)
    {
        // dd($id);
        $user   =  $this->user->find($id);
        $role = $user->role;
        if ($role=='user') {
            $roleUpdate = 'admin';
        } else {
            $roleUpdate = 'user';
        }

        $updateResult =  $user->update([
            'role' => $roleUpdate,
        ]);

        $user   =  $this->user->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-role', ['data' => $user, 'type' => 'nhân viên'])->render(),
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

            $newPass = $request->input('new-password');


            $this->user->where('id', $id)->update(['password' => \Hash::make($newPass)]);

            $user   =  $this->user->find($id);

            // dd($user);
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
