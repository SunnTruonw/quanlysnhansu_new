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
        $data = Http::get('http://192.168.1.26:8080/QLNS/public/api/users')->json();
        $url = 'http://192.168.1.26:8080/QLNS/public/api/users?page=3';
        // dd(Http::get($url)->effectiveUri());
        // dd($data);

        // $perPage = 9;
        // $page = $request->input('page',1);

        // $total = $query->count();


        // $results = $query


        return view('api.users.index', [
            'dataRoot' => $data,
            'data' => $data['data'],
            'links' => $data['links'],
            'meta' => $data['meta'],
        ]);

    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        $results = ($total = $this->toBase()->getCountForPagination())
                                    ? $this->forPage($page, $perPage)->get($columns)
                                    : $this->model->newCollection();

        return $this->paginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
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

    // public function edit()
    // {
    //     return view('api.users.edit');
    // }


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
