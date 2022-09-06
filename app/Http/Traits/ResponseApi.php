<?php
namespace App\Http\Traits;

trait ResponseApi
{
    private function successResponse(){
        return response()->json(['success'=>true],200);
    }

    private function successResponseWithData($data, $code = 200){
        return response()->json(['success' => true, 'data' => $data], $code);
    }

    private function errorResponse($message, $code=400){
        return response()->json(['error'=>$message,'code'=>$code], $code);
    }

}
