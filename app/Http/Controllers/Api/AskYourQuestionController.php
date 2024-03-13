<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\AskYourQuestion;
use App\Http\Resources\AskYourQuestionResource;
use Illuminate\Http\Request;


class AskYourQuestionController extends BaseController
{
    public function userQuestionStore(Request $request){
        
        try {

            if(isset($request->name) && !empty($request->name) && isset($request->user_question) && !empty($request->user_question)){
                $input = $request->only('name','user_question');
                 $input['user_id'] = auth()->user()->id;
                $userQuestions = AskYourQuestion::create($input);   
       
              return $this->sendResponse($userQuestions,'User Question Saved SuccessFully.',true);
            }else{
                return $this->sendResponse(null,'All Fields are required.',false);
            }         
         
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Internal server error!',false);
        }
    }

    public function adminAnswerList(){
        
        try {
          
            $adminAnswers = AskYourQuestion::get();
            $adminAnswer = AskYourQuestionResource::collection($adminAnswers);
            
          return $this->sendResponse($adminAnswer,'User Question retrived SuccessFully',true);
        } catch (\Throwable $th) {
          
            return $this->sendResponse(null,'Internal server error!',false);
        }
    }
}
