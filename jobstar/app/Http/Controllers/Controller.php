<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator, Input, Redirect, Response, Authorizer, Hash, Str, DB, Auth;
use App\Library\SiteHelpers;

class Controller extends BaseController
{

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

        function validateDatas($data,$rules)
        {
        $validator = Validator::make($data,$rules); 
        // if(count($niceNames) > 0){
        //     $validator->setAttributeNames($niceNames); 
        // }
        if($validator->passes()){
            return true;
        } else {
            $messages   = $validator->messages();
            $error      = $messages->getMessages();
            $val        = 'Error';
            if(count($error) > 0){
                foreach ($error as $key => $value) {    
                    $val= $value[0];
                    break;          
                }
            }
            $message['status'] = 'error';
            $message['message'] = $val;
            response()->json($message, 422)->send();exit();
        }
    }
    function createSlug($name, $tbl, $col){

            $slug = \Str::slug($name).'-';
            if ( isset(\Auth::user()->id ) && \Auth::user()->id != '' ){
                $max_id = \Auth::user()->id;
                
            }else{
                $max_id= \DB::table($tbl)->max($col);
                $max_id += 1;
            }

            return $slug.$max_id;

    }
    function sendemail($view,$data,$from,$to,$subject)
    {
        try {
            \Mail::send($view,$data,function($message) use ($from,$to,$subject) {
                $message->to($to)->subject($subject);
                $message->from($from);
            });
        } catch (Exception $e) {
            
        }
        return;
    }
}
