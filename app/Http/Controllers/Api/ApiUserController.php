<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiUserController extends Controller
{

    public function index(Request $request)
    {
        if($request->page > 0 && is_numeric($request->page)){
            $currentPage = $request->page;
        }else{
            $currentPage = 1;
        }

        $previouPage = $currentPage - 5;
        $nextPage = $currentPage + 5;

        $data = Http::get('http://192.168.1.26:8080/QLNS/public/api/users?page='. $currentPage)->json();

        return view('api.users.index', [
            'dataRoot' => $data,
            'currentPage' => $currentPage ,
            'previouPage' => $previouPage,
            'nextPage' => $nextPage,
            'data' => $data['data'],
            'links' => $data['links'],
            'meta' => $data['meta'],
        ]);

    }

    public function add()
    {
        return view('api.users.add');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $client = new Client();
            $res = $client->request('POST', 'http://192.168.1.26:8080/QLNS/public/api/users', [
                'form_params' => [
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]
            ]);

            DB::commit();

            return redirect()->route('api.users.index')->with("alert", "Thêm thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            // dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('api.users.index')->with("error", "Thêm không thành công");
        }
    }

    public function edit()
    {
        $data = Http::get('http://192.168.1.26:8080/QLNS/public/api/users')->json();

        return view('api.users.edit',[
            'data' => $data,
        ]);
    }


    // public function update(Request $request)
    // {
    //     // dd($request->all());
    //     try {
    //         DB::beginTransaction();
    //         $client = new Client();

    //         $res = $client->request('PUT', 'http://192.168.1.26:8080/QLNS/public/api/users', [
    //             'form_params' => [
    //                 'full_name' => $request->full_name,
    //                 'email' => $request->email,
    //                 'phone' => $request->phone,
    //             ]
    //         ]);

    //         DB::commit();

    //         return redirect()->route('api.users.index')->with("alert", "Thêm thành công");
    //     } catch (\Exception $exception) {
    //         //throw $th;
    //         DB::rollBack();
    //         // dd($exception);
    //         Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
    //         return redirect()->route('api.users.index')->with("error", "Thêm không thành công");
    //     }
    // }
}
