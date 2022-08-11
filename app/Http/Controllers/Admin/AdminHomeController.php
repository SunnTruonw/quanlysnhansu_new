<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;

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

    public function index()
    {
        $totalUser = $this->user->where('active', 1)->get()->count();
        $totalRoom = $this->room->where('active', 1)->get()->count();

        return view('admin.pages.index',[
            'totalUser' => $totalUser,
            'totalRoom' => $totalRoom,
        ]);
    }
}
