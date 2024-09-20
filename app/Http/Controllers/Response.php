<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 27-11-2018
 * Time: 14:06
 */

namespace App\Http\Controllers;


class Response{
    public static function suc($data,$msg=null,$code=null){
        if($msg==null)
            $msg = "Data generated";
        if($code==null)
            $code = 200;

        $dataArray = array('code'=>200,'message'=>$msg,'data'=>$data);
        return response()->json(
            $dataArray,
            $code,
            ['Content-Type' => 'application/json']
        );
    }

    public static function err($msg,$code=null,$data=null){
        if($code==null)
            $code = 400;
        if($data==null)
            $data = '';

        $dataArray = array('code'=>$code,'message'=>$msg,'data'=>$data);
        return response()->json(
            $dataArray,
            $code,
            ['Content-Type' => 'application/json']
        );
    }
}