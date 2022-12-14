<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Room\ValidateAddRoom;
use App\Http\Requests\Admin\Room\ValidateEditRoom;
use App\Models\Room;
use App\Traits\DeleteRecordTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $authCheck = Auth::user();
        $where = [];

        $data  = $this->room;
        if ($request->input('keyword')) {
            $data = $data->where(function ($query) {
                $query->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ]);
            });
        }

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

        $totalCategory = $this->room->count();
        return view('admin.pages.room.index',[
            'data' => $data,
            'authCheck' => $authCheck,
            'totalCategory' => $totalCategory,
            'keyword' => $request->input('keyword') ?? '',
            'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",

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
            return redirect()->route('admin.room.index')->with("alert", "Th??m ph??ng ban th??nh c??ng");

        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.room.index')->with("error", "Th??m ph??ng ban kh??ng th??nh c??ng");
        }
    }

    public function edit(Request $request, $id)
    {
        $authCheck = Auth::user();

        $data = $this->room->find($id);

        return view('admin.pages.room.edit',[
            'data' => $data,
            'authCheck' => $authCheck,
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
            return redirect()->route('admin.room.index')->with("alert", "S???a ph??ng ban th??nh c??ng");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.room.index')->with("error", "S???a ph??ng ban kh??ng th??nh c??ng");
        }
    }

    public function loadActive($id)
    {
        $authCheck = Auth::user();
        $room   =  $this->room->find($id);
        $active = $room->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $room->update([
            'active' => $activeUpdate,
        ]);

        $room   =  $this->room->find($id);

        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active-room', ['data' => $room, 'type' => 'ph??ng ban', 'authCheck' => $authCheck])->render(),
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

