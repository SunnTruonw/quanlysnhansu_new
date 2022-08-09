<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use App\Components\Recusive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait DeleteRecordTrait
{
    public function deleteTrait($model, $id)
    {
        try {
            $model->find($id)->delete();
            return response()->json([
                "code" => 200,
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function deleteImageTrait($model, $id)
    {
        try {
            $path=$model->find($id)->avatar_path;
            Storage::delete($this->makePathDelete($path));

            $model->find($id)->delete();
            return response()->json([
                "code" => 200,
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function makePathDelete($path){
        $path = Str::after($path, '/storage');
        return 'public'.$path;
    }
}
