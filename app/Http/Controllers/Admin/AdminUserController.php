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
    public function index(Request $request)
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
            // dd($params['district_id']);
            $idProTranDistrict = $this->district->where([
                ['id', $params['district_id']]
            ])->pluck('id');

                $query->whereIn('district_id', $idProTranDistrict);
        });
        
        $data = $data->orderBy('created_at','desc')->latest()->paginate(15);

        $totalCategory = $this->user->get()->count();
        return view('admin.pages.user.index',[
            'data' => $data,
            'dataCity' => $dataCity,
            'totalCategory' => $totalCategory,
            'keyword' => $request->input('keyword') ?? '',
            'start_date' => $request->input('start_date') ?? '',
            'end_date' => $request->input('end_date') ?? '',
            'city_id' => $request->input('city_id') ?? '',
            'nameDistrict' => $nameDistrict->name ?? '',
        ]);
    }

    public function add(Request $request)
    {
        $address = new AddressHelper();

        $data = $this->city->orderby('name')->get();
        $cities = $address->cities($data);
        $rooms = $this->room->get();

        $categoriesM = $this->category->where([
            ['active', 1],
            ['parent_id', 0],
        ])->latest()->get();

        return view('admin.pages.user.add',[
            'categoriesM' => $categoriesM,
            'cities' => $cities,
            'rooms' => $rooms,
        ]);
    }

    public function store(ValidateAddUser $request)
    {
        // dd($request->all());
        try {
             DB::beginTransaction();
            $dataUserCreate = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => Hash::make($request->input('password')),
                'address' => $request->input('address'),
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

            $user = $this->user->create($dataUserCreate);

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
            dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user.index')->with("error", "Thêm danh mục không thành công");
        }
    }

    public function edit(Request $request, $id)
    {
        $address = new AddressHelper();

        $dataCity = $this->city->orderby('name')->get();
        $cities = $address->cities($dataCity);
        
        $data = $this->user->find($id);

        $categoriesM = $this->category->where('parent_id', 0)->get();
        $rooms = $this->room->get();


        return view('admin.pages.user.edit',[
            'data' => $data,
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
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'sex' => $request->input('sex'),
                'room_id' => $request->input('room_id'),
                'city_id' => $request->input('city_id'),
                'district_id' => $request->input('district_id'),
                'active' => $request->input('active'),
            ];

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


    public function loadActive($id)
    {
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
                "html" => view('admin.components.load-change-active', ['data' => $user, 'type' => 'nhân viên'])->render(),
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
        return $this->deleteTrait($this->room, $id);
    }
}
