<?php

namespace App\Helper;

class AddressHelper
{
    public function __construct()
    {

    }
    
    public function cities($data,$id = null, $startString = "")
    {
        foreach ($data as $value) {
            if ($id !== null) {
                if ($value['id'] == $id) {
                    $startString .= "<option value='" . strval($value['id']) . "' " . 'selected' . ">" . $value["name"] . "</option>";
                } else {
                    $startString .= "<option value='" . strval($value['id']) . "' >" . $value["name"] . "</option>";
                }
            }else{
                $startString .= "<option value='" . strval($value['id']) . "' >" . $value["name"] . "</option>";
            }
        }
        return $startString;
    }

    public function districts($data,$cityId,$id=null,$startString=""){
        foreach ($data as $value) {
            
            if ($id !== null) {
                if ($value['id'] == $id) {
                    $startString .= "<option value='" . $value['id'] . "' " . 'selected' . ">" . $value["name"] . "</option>";
                } else {
                    $startString .= "<option value='" . $value['id'] . "' >" . $value["name"] . "</option>";
                }
            }else{
                $startString .= "<option value='" . $value['id'] . "' >" . $value["name"] . "</option>";
            }

        }
        return $startString;
    }
}
