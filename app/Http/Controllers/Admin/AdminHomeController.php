<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Documment;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{

    private $user;
    private $room;
    public function __construct(
        User $user,
        Room $room
    ) {
        $this->user = $user;
        $this->room = $room;
    }

    public function index(Request $request)
    {
        $totalRoot = $this->user->count();
        $totalUser = $this->user->where('active', 0)->count();
        $totalAdmin = $this->user->where('active', 1)->count();
        $totalRoom = $this->room->where('active', 1)->count();

        $time = $request->time ?? date("Y");

        // dd($time);

        $arrayMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            array_push($arrayMonth, $i);
        }

        //thống kê sô nhân viên nghỉ theo phòng ban
        $dataRoom = User::select(DB::raw('COUNT(*) as count'), 'rooms.name as name')
        ->where('users.active','=', false)// active = 0
        ->join('rooms', 'users.room_id', '=', 'rooms.id')
        ->groupBy('rooms.id')
        ->limit(10)
        ->pluck('count', 'name');



        // thống kê số nhân viên nhiên trong tháng
        $userLeave = Leave::select(DB::raw('COUNT(*) as count'),)
            // ->whereYear('time_leave', $time)
            ->whereIn(DB::raw('MONTH(time_leave)'), $arrayMonth)
            ->groupBy(DB::raw("MONTH(time_leave)"))
            ->pluck('count');

        $month = Leave::select(DB::raw('MONTH(time_leave) as month'))
            ->whereYear('time_leave', $time)
            ->whereIn(DB::raw('MONTH(time_leave)'), $arrayMonth)
            ->groupBy(DB::raw("MONTH(time_leave)"))
            ->pluck('month');


        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($month as $index => $mon) {
            if (!empty($userLeave)) {
                if (empty($userLeave[$index])) {
                    $userLeave[$index] = 0;
                }
                $data[$mon - 1] = $userLeave[$index];
            }
        }

        return view('admin.pages.index',[
            'data' => $data,
            'dataRoom' => $dataRoom,
            'totalAdmin' => $totalAdmin,
            'totalRoot' => $totalRoot,
            'totalUser' => $totalUser,
            'totalRoom' => $totalRoom,
        ]);
    }

    public function apiBieuDo(Request $request)
    {
        $years = $request->years;

        //truy xuất data 5 năm gần đây
        $range = \Carbon\Carbon::now()->subYears(5);

        $stats = DB::table('documments')
        ->where('date_off', '>=', $range)
        ->groupBy('getYear')
        ->orderBy('getYear', 'ASC')
        ->get([
            DB::raw('year(date_off) as getYear'),
            DB::raw('COUNT(*) as value')
        ]);


        return $stats;
    }

    public function userRooms(Request $request)
    {
    }
 }
