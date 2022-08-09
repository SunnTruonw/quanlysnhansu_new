<?php

namespace App\Components;


class Recusive{

    private $htmlselect;
    private $arrID;
    private $menu=[];

    public function __construct()
    {
        $this->htmlselect="";
        $this->arrID=[];
    }

    

    // get category đệ quy
    public  function categoryRecusive($data,$id,$parentKey,$parentId="",$startString="",$text=""){
        foreach ($data as $value) {
            # code...
            if($value[$parentKey]==$id){
                if(!empty($parentId)&&$value['id']==$parentId){
                $startString .= "<option value='".$value['id']."' ".'selected'.">".$text.$value["name"]."</option>";
                }else{
                $startString .= "<option value='".$value['id']."' >".$text.$value["name"]."</option>";
                }

                $startString .= $this->categoryRecusive($data,$value["id"], $parentKey, $parentId,"",$text."---");
            }
        }
        return $startString;
    }
}