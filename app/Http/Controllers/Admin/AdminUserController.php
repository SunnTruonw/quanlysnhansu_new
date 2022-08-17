<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\ValidateAddUser;
use App\Http\Requests\Admin\User\ValidateEditUser;
use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\User;
use App\Models\City;
use App\Models\Distrist;
use Illuminate\Support\Facades\Hash;
use App\Models\Documment;
use App\Models\Room;
use App\Helper\AddressHelper;
use App\Traits\DeleteRecordTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    use StorageImageTrait,DeleteRecordTrait;

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

    // Giải mã
    public function decrypt($message){
        $sifrelememetodu = "AES-128-CBC";
        $benimsifrem = "birgul.091!birgul!";
        $sifresicozulen = openssl_decrypt($message, $sifrelememetodu, $benimsifrem);
        return $sifresicozulen;
    }

    // Mã hóa
    public function encrypt($message){
        $sifrelememetodu = "AES-128-CBC";
        $benimsifrem = "birgul.091!birgul!";
        $sifresicozulen = openssl_encrypt($message, $sifrelememetodu, $benimsifrem);
        return $sifresicozulen;
    }


    public function index(Request $request)
    {
        // $data = $this->encrypt('sadasdasdasd');


        // dd($data);
        $authCheck = Auth::user();

        $params = $request->all();
        // dd(Crypt::encrypt($params['keyword']));
        $where = [];
        $address = new AddressHelper();
        $dataCity = $this->city->orderby('name')->get();

        if(isset($params['district_id'])){
            $nameDistrict = $this->district->where('id', $params['district_id'])->first();
        }

        $data  = $this->user;

        if (isset($params['keyword']) && $params['keyword']) {
            $data = $data->where(function ($query) use ($params) {
                $query->where([
                    ['name', 'like', '%' . $params['keyword'] . '%']
                ])->orWhere([
                    ['user_code', 'like', '%' . $params['keyword'] . '%']
                ])
                ->orWhere([
                    ['email', 'like', '%' . Crypt::encrypt($params['keyword']) . '%']
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

        // $data = $this->user->where('id', 500006)->paginate(15);
        $totalUser = $this->user->count();

        return view('admin.pages.user.index',[
            'data' => $data,
            'authCheck' => $authCheck,
            'dataCity' => $dataCity,
            'total' => $totalUser,
            'keyword' => $request->input('keyword') ?? '',
            'start_date' => $request->input('start_date') ?? '',
            'end_date' => $request->input('end_date') ?? '',
            'city_id' => $request->input('city_id') ?? '',
            'nameDistrict' => $nameDistrict->name ?? '',
            'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
        ]);
    }


    public function add(Request $request)
    {
        $htmlselect = $this->category->getHtmlOption();

        $address = new AddressHelper();

        $data = $this->city->orderby('name')->get();
        $cities = $address->cities($data);
        $rooms = Room::limit(100)->get();

        $categoriesM = Category::where([
            ['active', 1],
            ['parent_id', 0],
        ])->latest()->get();

        return view('admin.pages.user.add',[
            'categoriesM' => $categoriesM,
            'cities' => $cities,
            'rooms' => $rooms,
            'option' => $htmlselect,
        ]);
    }

    public function store(ValidateAddUser $request)
    {
        // dd($request->all());
        try {
             DB::beginTransaction();

            $userCode = substr(md5(mt_rand()), 0, 6);

            $dataUserCreate = [
                'user_code' => $userCode,
                'name' => $request->input('name'),
                'email' =>  Crypt::encrypt($request->input('email')),
                'phone' =>  Crypt::encrypt($request->input('phone')),
                'password' => Hash::make($request->input('password')),
                'address' => $request->input('address'),
                'wage' => $request->input('wage'),
                'sex' => $request->input('sex'),
                'role' => $request->input('role'),
                'room_id' => $request->input('room_id'),
                'city_id' => $request->input('city_id'),
                'district_id' => $request->input('district_id'),
                'active' => $request->input('active'),
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "user");
            if (!empty($dataUploadAvatar)) {
                $dataUserCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            // dd($dataUserCreate);

            $user = $this->user->create($dataUserCreate);

            // dd($user->email);

            $dataUserDocmentCreate = [];

            $itemDataDocmentCreate= [
                'description' => $request->input('description'),
                'content' => $request->input('content'),
                'date_working' => $request->input('date_working'),
                'date_off' => $request->input('date_off'),
                'active' => $request->input('active'),
                'order' => $request->input('order') ?? 0,
            ];

            $dataUploadImage = $this->storageTraitUpload($request, "image_path", "user");
            if (!empty($dataUploadImage)) {
                $itemDataDocmentCreate["image_path"] = $dataUploadImage["file_path"];
            }

            $dataUploadFile = $this->storageTraitUpload($request, "file", "user");
            if (!empty($dataUploadFile)) {
                $itemDataDocmentCreate["file"] = $dataUploadFile["file_path"];
            }

            $dataUserDocmentCreate[] = $itemDataDocmentCreate;

            $user->docmments()->createMany($dataUserDocmentCreate);


            // insert category to user
            if ($request->has("category")) {
                $category_ids = [];
                foreach ($request->input('category') as $categoryItem) {
                    if ($categoryItem) {
                        $categoryInstance = $this->category->find($categoryItem);
                        $category_ids[] = $categoryInstance->id;
                    }
                }

                $category = $user->categories()->attach($category_ids);
            }

            DB::commit();
            return redirect()->route('admin.user.index')->with("alert", "Thêm danh mục thành công");

        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            // dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user.index')->with("error", "Thêm danh mục không thành công");
        }
    }

    public function edit(Request $request, $id)
    {
        $authCheck = Auth::user();

        $address = new AddressHelper();

        $dataCity = $this->city->orderby('name')->get();
        $cities = $address->cities($dataCity);

        $data = $this->user->find($id);

        $categoriesM = $this->category->where('parent_id', 0)->get();
        $rooms = $this->room->limit(100)->get();


        return view('admin.pages.user.edit',[
            'data' => $data,
            'authCheck' => $authCheck,
            'dataCity' => $dataCity,
            'cities' => $cities,
            'rooms' => $rooms,
            'categoriesM' => $categoriesM,
        ]);
    }



    public function update(ValidateEditUser $request, $id)
    {
        // dd($request->all());
        try {
            $dataCategoryUpdate = [
                'name' => $request->input('name'),
                'email' =>  Crypt::encrypt($request->input('email')),
                'phone' =>  Crypt::encrypt($request->input('phone')),
                'address' => $request->input('address'),
                'wage' => $request->input('wage'),
                'sex' => $request->input('sex'),
                'room_id' => $request->input('room_id'),
                'city_id' => $request->input('city_id'),
                'district_id' => $request->input('district_id'),
                'active' => $request->input('active'),
            ];

            if(Auth::user()->role == 'admin'){
                $dataCategoryUpdate["status"] = 1;//admin update
            }else{
                $dataCategoryUpdate["status"] = 2;//user update account của chính mình
            }
                $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "user");
                if (!empty($dataUploadAvatar)) {
                    $path = $this->user->find($id)->avatar_path;
                    if ($path) {
                        Storage::delete($this->makePathDelete($path));
                    }
                    $dataCategoryUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
                }

                // dd($dataCategoryUpdate);

                $this->user->find($id)->update($dataCategoryUpdate);

                //insert data documment
                $user = $this->user->find($id);

                $dataUserDocmentUpdate = [
                    'description' => $request->input('description'),
                    'content' => $request->input('content'),
                    'date_working' => $request->input('date_working'),
                    'date_off' => $request->input('date_off'),
                    'active' => $request->input('active'),
                    'order' => $request->input('order') ?? 0,
                ];

                $dataUploadImage = $this->storageTraitUpload($request, "image_path", "user");
                if (!empty($dataUploadImage)) {
                    $path = $this->user->find($id)->image_path;
                    if ($path) {
                        Storage::delete($this->makePathDelete($path));
                    }
                    $dataUserDocmentUpdate["image_path"] = $dataUploadImage["file_path"];
                }

                $dataUploadFile = $this->storageTraitUpload($request, "file", "user");
                if (!empty($dataUploadFile)) {
                    $path = $this->user->find($id)->file;
                    if ($path) {
                        Storage::delete($this->makePathDelete($path));
                    }
                    $dataUserDocmentUpdate["file"] = $dataUploadFile["file_path"];
                }

                if ($user->docmments()) {
                    $user->docmments()->update($dataUserDocmentUpdate);
                } else {
                    $user->docmments()->create($dataUserDocmentUpdate);
                }

                // insert category to user
                if ($request->has("category")) {
                    $category_ids = [];
                    foreach ($request->input('category') as $categoryItem) {
                        if ($categoryItem) {
                            $categoryInstance = $this->category->find($categoryItem);
                            $category_ids[] = $categoryInstance->id;
                        }
                    }

                    $user->categories()->sync($category_ids);
                }


                DB::commit();
                return redirect()->route('admin.user.index')->with("alert", "Sửa danh mục thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user.index')->with("error", "Sửa danh mục không thành công");
        }
    }

    public function loadCalendar($id)
    {
        $data = $this->user->find($id)->calendars()->get();
        return response()->json([
            'code' => 200,
            'htmlCalendar' => view('admin.components.calendar-detail', [
                'data' => $data,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }

    public function loadActiveCalendar($id)
    {
        $calendar   =  $this->calendar->find($id);
        $active = $calendar->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $calendar->update([
            'active' => $activeUpdate,
        ]);

        $calendar   =  $this->calendar->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-calendar', ['data' => $calendar, 'type' => 'nhân viên'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }


    public function detail(Request $request, $id)
    {
        $data = $this->user->find($id);

        return response()->json([
            'code' => 200,
            'htmlUserDetail' => view('admin.components.user-detail', [
                'data' => $data,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }


    public function loadActive($id)
    {
        $authCheck = Auth::user();
        $user   =  $this->user->find($id);
        $active = $user->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $user->update([
            'active' => $activeUpdate,
        ]);

        $user   =  $this->user->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $user, 'type' => 'nhân viên', 'authCheck' => $authCheck])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function delete($id)
    {
        // dd($id);
        return $this->deleteTrait($this->user, $id);
    }
}
