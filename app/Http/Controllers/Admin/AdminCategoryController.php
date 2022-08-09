<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\ValidateAddCategory;
use App\Http\Requests\Admin\Category\ValidateEditCategory;
use App\Models\Category;
use App\Traits\DeleteRecordTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    use StorageImageTrait,DeleteRecordTrait;

    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    public function index(Request $request)
    {
        $parentBr = null;
        
        $data  = $this->category;
        if ($request->input('keyword')) {
            $data = $data->where(function ($query) {
                $query->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ]);
            });
        }

        if ($request->has('parent_id')) {
            $data = $this->category->where('parent_id', $request->input('parent_id'))->orderBy("order")->orderBy("created_at", "desc")->paginate(15);
            if ($request->input('parent_id')) {
                $parentBr = $this->category->find($request->input('parent_id'));
            }
        } else {
            $data = $this->category->where('parent_id', 0)->orderBy("order")->orderBy("created_at", "desc")->paginate(15);
        }


        // $data = $data->where('active', 1)->orderBy('order')->latest()->paginate(15);

        $totalCategory = $this->category->where('active', 1)->get()->count();
        return view('admin.pages.category.index',[
            'data' => $data,
            'totalCategory' => $totalCategory,
            'keyword' => $request->input('keyword') ?? '',
            'name' => 'Danh mục nhân sự',
        ]);
    }

    public function add(Request $request)
    {
        if ($request->has("parent_id")) {
            $htmlselect = $this->category->getHtmlOptionAddWithParent($request->parent_id);
        } else {
            $htmlselect = $this->category->getHtmlOption();
        }

        $categories = $this->category->where('active', 1)->orderBy('order')->latest()->paginate(15);

        return view('admin.pages.category.add',[
            'categories' => $categories,
            'option' => $htmlselect,
        ]);
    }

    public function store(ValidateAddCategory $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $dataCategoryCreate = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description') ?? '',
                'content' => $request->input('content') ?? '',
                'active' => $request->input('active'),
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                'order' => $request->input('order'),
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "category");
            if (!empty($dataUploadAvatar)) {
                $dataCategoryCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }


            // dd($dataCategoryCreate);

            $category = $this->category->create($dataCategoryCreate);

            DB::commit();
            return redirect()->route('admin.category.index')->with("alert", "Thêm danh mục thành công");
            
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.category.index')->with("error", "Thêm danh mục không thành công");
        }
    }

    public function edit(Request $request, $id)
    {

        $data = $this->category->find($id);
        $parentId = $data->parent_id;
        $htmlselect = $this->category->getHtmlOptionEdit($parentId, $id);


        $categories = $this->category->where('active', 1)->orderBy('order')->latest()->get();

        $data = $this->category->find($id);
        return view('admin.pages.category.edit',[
            'data' => $data,
            'categories' => $categories,
            'option' => $htmlselect,
        ]);
    }

    public function update(ValidateEditCategory $request, $id)
    {
        try {
            $dataCategoryUpdate = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description') ?? '',
                'content' => $request->input('content') ?? '',
                'active' => $request->input('active'),
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                'order' => $request->input('order'),
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "category");
            if (!empty($dataUploadAvatar)) {
                $path = $this->category->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            // dd($dataCategoryUpdate);

            $this->category->find($id)->update($dataCategoryUpdate);

            $category = $this->category->find($id);


            DB::commit();
            return redirect()->route('admin.category.index')->with("alert", "Sửa danh mục thành công");
        } catch (\Exception $exception) {
            //throw $th;
            dd($exception);
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.category.index')->with("error", "Sửa danh mục không thành công");
        }
    }


    public function loadActive($id)
    {
        $category   =  $this->category->find($id);
        $active = $category->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $category->update([
            'active' => $activeUpdate,
        ]);

        $category   =  $this->category->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $category, 'type' => 'danh mục'])->render(),
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
        return $this->deleteTrait($this->category, $id);
    }
}
