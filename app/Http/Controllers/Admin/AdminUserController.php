<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\ValidateAddUser;
use App\Http\Requests\Admin\User\ValidateEditUser;
use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\User;

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
    private $category;

    public function __construct(User $user, Category $category)
    {
        $this->user = $user;
        $this->category = $category;
    }
    public function index(Request $request)
    {
        $data  = $this->user;
        if ($request->input('keyword')) {
            $data = $data->where(function ($query) {
                $query->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ]);
            });
        }

        $data = $data->where('active', 1)->orderBy('created_at','desc')->latest()->paginate(15);

        $totalCategory = $this->user->where('active', 1)->get()->count();
        return view('admin.pages.user.index',[
            'data' => $data,
            'totalCategory' => $totalCategory,
            'keyword' => $request->input('keyword') ?? '',
            'name' => 'Danh mục nhân sự',
        ]);
    }

    public function add(Request $request)
    {
        $categoriesM = $this->category->where([
            ['active', 1],
            ['parent_id', 0],
        ])->latest()->get();

        return view('admin.pages.user.add',[
            'categoriesM' => $categoriesM,
        ]);
    }

    public function store(ValidateAddUser $request)
    {

        // dd($request->all());
        try {
            DB::beginTransaction();

            $dataUserCreate = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
                'content' => $request->input('content'),
                'active' => $request->input('active'),
            ];


            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "user");
            if (!empty($dataUploadAvatar)) {
                $dataUserCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            $user = $this->user->create($dataUserCreate);
            $dataUserDocmentCreate = [];

            $itemDataDocmentCreate= [
                'fullName' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'sex' => $request->input('sex'),
                'date_working' => $request->input('date_working'),
                'date_off' => $request->input('date_off'),
                'active' => $request->input('active'),
                'order' => $request->input('order'),
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

        $data = $this->user->find($id);

        $categoriesM = $this->category->where('parent_id', 0)->get();

        $data = $this->user->find($id);

        return view('admin.pages.user.edit',[
            'data' => $data,
            'categoriesM' => $categoriesM,
        ]);
    }

    public function update(ValidateEditUser $request, $id)
    {
        try {
            $dataCategoryUpdate = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description') ?? '',
                'content' => $request->input('content') ?? '',
                'active' => $request->input('active'),
                "category_id" => $request->category_id ? $request->category_id : 0,
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
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'sex' => $request->input('sex'),
                'date_working' => $request->input('date_working'),
                'date_off' => $request->input('date_off'),
                'active' => $request->input('active'),
                'order' => $request->input('order'),
            ];

            $dataUploadImage = $this->storageTraitUpload($request, "image_path", "user");
            if (!empty($dataUploadImage)) {
                $path = $this->user->find($id)->image_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryUpdate["image_path"] = $dataUploadImage["file_path"];
            }

            $dataUploadFile = $this->storageTraitUpload($request, "file", "user");
            if (!empty($dataUploadFile)) {
                $path = $this->user->find($id)->file;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryUpdate["file"] = $dataUploadFile["file_path"];
            }

            if ($user->docmment) {
                $user->docmment->update($dataCategoryUpdate);
            } else {
                $user->docmment->create($dataCategoryUpdate);
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
            dd($exception);
            DB::rollBack();
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
                "html" => view('admin.components.load-change-active', ['data' => $user, 'type' => 'danh mục'])->render(),
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
        return $this->deleteTrait($this->user, $id);
    }
}
