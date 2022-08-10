<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Distrist;
use App\Helper\AddressHelper;

class AddressController extends Controller
{
    //
    private $cart;
    private $city;
    private $district;
    public function __construct(City $city, Distrist $district)
    {
        $this->city = $city;
        $this->district = $district;
    }
    public function getDistricts(Request $request)
    {
        $cityId=$request->cityId;
        $address=new AddressHelper();
        $data = $this->city->find($cityId)->districts()->orderby('name')->get();
        $districts=$address->districts($data,$cityId);
        return response()->json([
            "code" => 200,
            'data'=>$districts,
            "message" => "success"
        ], 200);
    }
}
