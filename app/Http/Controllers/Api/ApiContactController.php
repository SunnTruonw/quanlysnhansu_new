<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ValidateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class ApiContactController extends Controller
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function index()
    {
        $data = Contact::orderBy('id', 'DESC')->paginate(20);

        return ContactResource::collection($data);
    }


    public function add(Request $request,$id)
    {

    }

    public function store(ValidateContactRequest $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'phone'=>'required',
                'message' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            //save to database
            $contact = Contact::create([
                'title'     => $request->title,
                'email'   => $request->email,
                'phone'   => $request->phone,
                'message'   => $request->message
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Thêm thanh công',
                'data'    => $contact
            ], 201);

         } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Thêm không thành công',
            ], 409);
        }


    }

    public function edit(Request $request,$id)
    {
        $data = Contact::find($id);

        return ContactResource::collection($data);
    }

    public function update(ValidateContactRequest $request,$id)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'phone'=>'required',
                'message' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $contact = Contact::findOrFail($id);

            $contact->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thêm thành công',
                'data'    => $contact
            ], 200);

        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Thêm thất bại',
            ], 404);
        }
    }



    public function delete(Request $request, $id)
    {
        //find post by ID
        $contact = Contact::findOrfail($id);

        if($contact) {

            //delete contact
            $contact->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công',
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Thất bại',
        ], 404);
    }

    // public function showFormAPiNam()
    // {
    //     // return view('api')
    // }

    // public function callApiNam(Request $request)
    // {
    //     try {
    //         $client = new Client();
    //         $guzzleResponse = $client->get(
    //                 'http://192.168.1.26:8080/QLNS/public/api/users', [
    //                 'headers' => [
    //                     'Authorization'=>'Bearer'. session()->get('token.access_token')
    //                 ]
    //             ]);
    //         if ($guzzleResponse->getStatusCode() == 200) {
    //             $form_params = [
    //                 'email'             => 'xuantruong@gmail.com',
    //                 'phone'    => '0963507875',
    //                 'full_name'     => 'Hồ Xuân Trường',
    //             ];
    //             // $results = json_decode($guzzleResponse->getBody(),true);
    //             $response = $client->post($guzzleResponse, ['form_params' => $form_params]);
    //             $response = $response->getBody()->getContents();

    //             return dd($response);
    //         }

    //     } catch (RequestException $e) {
    //         return $e;
    //         // you can catch here 400 response errors and 500 response errors
    //         // see this https://stackoverflow.com/questions/25040436/guzzle-handle-400-bad-request/25040600
    //     } catch(Exception $e){
    //         //other errors
    //         return $e;
    //     }
    // }
}
