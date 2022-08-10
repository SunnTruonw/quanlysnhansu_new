<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Room\ValidateAddRoom;
use App\Http\Requests\Admin\Room\ValidateEditRoom;
use App\Models\Room;
use App\Traits\DeleteRecordTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminRoomController extends Controller
{
    use StorageImageTrait,DeleteRecordTrait;

    private $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function index(Request $request)
    {
        $data  = $this->room;
        if ($request->input('keyword')) {
            $data = $data->where(function ($query) {
                $query->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ]);
            });
        }

        $data = $data->where('active', 1)->orderBy('created_at','desc')->latest()->paginate(15);

        $totalCategory = $this->room->where('active', 1)->get()->count();
        return view('admin.pages.room.index',[
            'data' => $data,
            'totalCategory' => $totalCategory,
            'keyword' => $request->input('keyword') ?? '',
        ]);
    }

    public function add(Request $request)
    {
        return view('admin.pages.room.add');
    }

    public function store(ValidateAddRoom $request)
    {
        try {
            DB::beginTransaction();

            $dataRoomCreate = [
                'name' => $request->input('name'),
                'description' => $request->input('description') ?? '',
                'active' => $request->input('active'),
                'order' => $request->input('order'),
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "category");
            if (!empty($dataUploadAvatar)) {
                $dataRoomCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            $room = $this->room->create($dataRoomCreate);

            DB::commit();
            return redirect()->route('admin.room.index')->with("alert", "Thêm phòng ban thành công");
            
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.room.index')->with("error", "Thêm phòng ban không thành công");
        }
    }

    public function edit(Request $request, $id)
    {
        $data = $this->room->find($id);

        return view('admin.pages.room.edit',[
            'data' => $data,
        ]);
    }

    public function update(ValidateEditRoom $request, $id)
    {
        try {
            $dataRoomUpdate = [
                'name' => $request->input('name'),
                'description' => $request->input('description') ?? '',
                'active' => $request->input('active'),
                'order' => $request->input('order'),
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "room");
            if (!empty($dataUploadAvatar)) {
                $path = $this->room->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataRoomUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            $this->room->find($id)->update($dataRoomUpdate);

            $room = $this->room->find($id);

            DB::commit();
            return redirect()->route('admin.room.index')->with("alert", "Sửa phòng ban thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.room.index')->with("error", "Sửa phòng ban không thành công");
        }
    }

    public function delete($id)
    {
        return $this->deleteTrait($this->room, $id);
    }
}
