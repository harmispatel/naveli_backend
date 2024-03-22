<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\{Ailment, Medicine, User,News,Post,UserSymptomsLogs,UserActivityStatus};
// use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageTrait;
use App\Http\Resources\newsResources;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Carbon;



class UserController extends BaseController
{
    use ImageTrait;

    // public function signup(Request $request)
    // {
    //     try {
    //         $checkEmailOrMobile = User::where('email', $request->email)->orWhere('mobile', $request->mobile)->first();

    //         if (isset($checkEmailOrMobile)) {
    //             return  $this->sendResponse(null, 'Email or phone number is already registered', false);
    //         }

    //         if (empty($request->email) &&  empty($request->mobile) && empty($request->password)) {
    //             return  $this->sendResponse(null, 'All field is required', false);
    //         } else {

    //             $input = $request->except('_token', 'password', 'device_token');

    //             $input['password'] = Hash::make($request->password);
    //             $input['unique_id'] = uuId();

    //             $user = User::create($input);
    //             return  $this->sendResponse($user, 'Signup Successfully', true);
    //         }
    //     } catch (\Throwable $th) {

    //         return  $this->sendError('Something Went Wrong.', [], 500);
    //     }
    // }

    // public function login(Request $request)
    // {
    //     try {
    //         $email = $request->email;
    //         $password = $request->password;
    //         $deviceToken = $request->device_token;
    //         $mobile = $request->mobile;

    //         if ($password && $email) {
    //             $checkEmail = User::where('email', $email)->first();
    //             if ($checkEmail) {
    //                 if ($checkEmail->status == 1) {
    //                     if (Auth::attempt(['email' => $email, 'password' => $request->password])) {
    //                         User::where('email', $email)->update(['device_token' => $deviceToken]);
    //                         $user = Auth::user();
    //                         $userDetail = $this->userResponse($user);
    //                         $token =  $user->createToken('token')->plainTextToken;
    //                         $data = ['user' => $userDetail, 'token' => $token];
    //                         return  $this->sendResponse($data, 'User login successful', true);
    //                     } else {
    //                         return  $this->sendResponse(null, 'Invalid credentials!', false);
    //                     }
    //                 } else {
    //                     return  $this->sendResponse(null, 'User is deacitve', false);
    //                 }
    //             } else {
    //                 return  $this->sendResponse(null, 'User not found!', false);
    //             }
    //         } else {
    //             $checkMobile = User::where('mobile', $mobile)->first();
    //             Auth::login($checkMobile);
    //             $checkMobile->update(['device_token' => $deviceToken]);
    //             $userDetail = $this->userResponse($checkMobile);
    //             $token =  $checkMobile->createToken('token')->plainTextToken;
    //             $data = ['user' => $userDetail, 'token' => $token];
    //             return  $this->sendResponse($data, 'User login successful', true);
    //         }
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return  $this->sendResponse(null, 'Something went wrong', false);
    //     }
    // }

    public function login(Request $request){

        try{
            $input = $request->except('_token');
            $mobile_no = $request->mobile;
            $role_id = $request->role_id;
            $deviceToken = $request->device_token;

            $getUserRegisterDetail = User::where('mobile',$mobile_no)->first();

            if(isset($getUserRegisterDetail)){

                if($getUserRegisterDetail->status == 1){

                        Auth::login($getUserRegisterDetail);
                        $getUserRegisterDetail->update(['device_token' => $deviceToken]);
                        $userDetail = $this->userResponse($getUserRegisterDetail);
                        $token =  $getUserRegisterDetail->createToken('token')->plainTextToken;

                        $data = ['user' => $userDetail, 'token' => $token];

                    return  $this->sendResponse($data, 'User Is Registered', true);
                }else{
                    return  $this->sendResponse(null, 'User is deactive!', false);
                }
            }

            $createNewRegistration = User::create($input);
            if(isset($createNewRegistration)){
                $createUsersActivity = UserActivityStatus::create([ 'user_id' => $createNewRegistration->id]);
            }
            Auth::login($createNewRegistration);
            $userDetail = $this->userResponse($createNewRegistration);
            $token =  $createNewRegistration->createToken('token')->plainTextToken;

             $data = ['user' => $userDetail, 'token' => $token];

            return  $this->sendResponse($data, 'New User Registered successfully', true);
        }catch(\Throwable $th){
             return  $this->sendResponse(null, 'Something went wrong', false);
        }
    }

    public function VerifyMobileNumber(Request $request)
    {
        try {

            $mobile =  $request->mobile;
            $role_id = $request->role_id;

            $checkVerify = User::where('mobile', $mobile)->first();
            if ($checkVerify) {
               if($role_id == $checkVerify->role_id){
                 return  $this->sendResponse(null, 'This phone-no is alredy exist', false);
               }else{
                return  $this->sendResponse(null, 'This phone-no is already used in another user role!', false);
               }
            } else {
                return  $this->sendResponse(null, 'This phone-no is ready for registration', true);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return  $this->sendResponse(null, 'Something went wrong', false);
        }
    }

    public function userList(Request $request)
    {
        try {
            $users = User::where('role_id', '!=', '1')
                ->where('status', 1)
                ->get();

            return  $this->sendResponse(UserResource::collection($users), 'User list retrieved successfully.', true);
        } catch (\Throwable $th) {
            return  $this->sendResponse(null, 'Something went wrong !', false);
        }
    }

    public function userDetail()
    {
        try {
            $demo = $this->userResponse(Auth::user());
            return  $this->sendResponse($demo, 'User login successful', true);
        } catch (\Throwable $th) {
            return  $this->sendResponse(null, 'Something went wrong', false);
        }
    }

    public function userUpdateDetails(Request $request){
        try {
            $id = Auth::user()->id;
            $user_role = Auth::user()->role_id;
            $name = $request->name;
            $birthdate = $request->birthdate;
            $gender = $request->gender;
            $relationship_status = $request->relationship_status;
            $average_cycle_length = $request->average_cycle_length;
            $previous_periods_begin = $request->previous_periods_begin;
            $previous_periods_month = $request->previous_periods_month;
            $average_period_length = $request->average_period_length;
            $hum_apke_he_kon = $request->hum_apke_he_kon;

            if($user_role == 2){

                if(isset($name) && isset($birthdate) && isset($gender) && isset($relationship_status)  && isset($previous_periods_begin)){

                    $getUserData = User::find($id);
                    $find_user_uid = $getUserData->unique_id;
                    $updateUserDetail = $getUserData->update([
                        'name' => $name,
                        'unique_id' => isset($find_user_uid) ? $find_user_uid : uuId($user_role,$gender),
                        'birthdate'=> $birthdate,
                        'gender' => $gender,
                        'gender_type' => isset($request->gender_type) ? $request->gender_type : null,
                        'relationship_status'=>$relationship_status,
                        'average_cycle_length'=> $average_cycle_length,
                        'previous_periods_begin'=>$previous_periods_begin,
                        'previous_periods_month'=>$previous_periods_month,
                        'average_period_length'=>$average_period_length,
                    ]);
                    $userData = $this->userResponse($getUserData);
                    $data = ['user' => $userData];
                    return  $this->sendResponse(null, 'Data Updated Successfully', true);
                }else{
                    return  $this->sendResponse(null, 'all fields are required !', false);
                }
            }

            if($user_role == 3){

                if(isset($name) && isset($birthdate) && isset($gender) && isset($relationship_status)  && isset($hum_apke_he_kon) ){

                    $getUserData = User::find($id);
                    $find_user_uid = $getUserData->unique_id;
                    $updateUserDetail = $getUserData->update([
                        'name' => $name,
                        'unique_id' => isset($find_user_uid) ? $find_user_uid : uuId($user_role,$gender),
                        'birthdate'=> $birthdate,
                        'gender' => $gender,
                        'gender_type' => isset($request->gender_type) ? $request->gender_type : null,
                        'relationship_status'=>$relationship_status,
                        'hum_apke_he_kon' => $hum_apke_he_kon,
                    ]);
                    $userData = $this->userResponse($getUserData);
                    $data = ['user' => $userData];
                    return  $this->sendResponse(null, 'Data Updated Successfully', true);
                }else{
                    return  $this->sendResponse(null, 'all fields are required !', false);
                }
            }

            if($user_role == 4){

                if(isset($name) && isset($birthdate) && isset($gender) && isset($relationship_status) ){

                    $getUserData = User::find($id);
                    $find_user_uid = $getUserData->unique_id;
                    $updateUserDetail = $getUserData->update([
                        'name' => $name,
                        'unique_id' => isset($find_user_uid) ? $find_user_uid : uuId($user_role,$gender),
                        'birthdate'=> $birthdate,
                        'gender' => $gender,
                        'gender_type' => isset($request->gender_type) ? $request->gender_type : null,
                        'relationship_status'=>$relationship_status,

                    ]);
                    $userData = $this->userResponse($getUserData);
                    $data = ['user' => $userData];
                    return  $this->sendResponse(null, 'Data Updated Successfully', true);
                }else{
                    return  $this->sendResponse(null, 'all fields are required !', false);
                }
            }

        } catch (\Throwable $th) {
            return  $this->sendResponse(null, 'Something went wrong', false);
        }

    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'birthdate' => 'required',
                'mobile' => 'required|digits:10', // or 'required|digits:10' for a 10-digit mobile number
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 404);
        }

        try {

            $input = $request->except('_token', 'id', 'password', 'image');
            $id = Auth::user()->id;

            if (!empty($request->password) || $request->password != null) {
                $input['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                $img = User::find($id);
                $old_image = $img->image;
                $file = $request->file('image');
                $image_url = $this->addSingleImage('user_images', $file, $old_image);
                $input['image'] = $image_url;
            }

            $user = User::find($id);

            if (!$user) {
                return $this->sendError('User not found', [], 404);
            }

            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $role_id = $user->role_id;
            $Role = Role::where('id', $role_id)->first();
            $user->assignRole($Role->name);

            $success = [
                'user' => $user,
            ];

            return $this->sendResponse($success, 'Data Updated SuccessFully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong', false);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $user = User::find($id);

            $img = isset($user->image) ? $user->image : '';

            if (!empty($img && file_exists('public/images/uploads/user_images/' . $img))) {
                unlink('public/images/uploads/user_images/' . $img);
            }

            $user = User::where('id', $id)->delete();

            $success = [
                'user' => $user,
            ];

            return $this->sendResponse($success, "User Deleted Successfully", true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong', false);
        }
    }

    public function logout(Request $request)
    {
        try {

            // $request->user()->tokens()->delete();
            Session::flush();
            // Auth::logout();
            return $this->sendResponse(null, "User Logout Successfully", true);
        } catch (\Throwable $th) {

            return $this->sendResponse(null, "Somthing went wrong", false);
        }
    }

    public function newsDetails(Request $request){
        try {
            $news = News::all();

            return $this->sendResponse(newsResources::collection($news),'list retrieved successfully.',true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Something went wrong!',false);
        }
    }

    public function medicineList(Request $request){
        try {
            $medicine = Medicine::all();

            return $this->sendResponse($medicine,'list retrieved successfully.',true);
        } catch (\Throwable $th) {

            return $this->sendResponse(null,'Something went wrong!',false);
        }
    }

    public function ailmentsList(Request $request){
        try {
            $ailmentsList = Ailment::all();

            return $this->sendResponse($ailmentsList,'list retrieved successfully.',true);
        } catch (\Throwable $th) {

            return $this->sendResponse(null,'Something went wrong!',false);
        }
    }

    public function getAllPosts(Request $request){

        try {
            $parent_title_id = $request->parent_title_id;
            $filter_by = (isset($request->filter_by) && !empty($request->filter_by)) ? $request->filter_by : "newest";
            $getPosts = Post::where('parent_title',$parent_title_id);
            if($filter_by == 'newest'){
                $getPosts = $getPosts->latest();
            }else{
                $getPosts = $getPosts->oldest();
            }
            $getPosts = $getPosts->get();

           if(empty($getPosts)){
              return $this->sendResponse(null,'Empty, No Data',true);
           }else{
               $data = ['PostsData' => PostResource::collection($getPosts)];
               return $this->sendResponse($data ,'Posts List Successfully Received',true);
           }
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Something went wrong!',false);
        }
    }

    public function storeUserSymptomsLogs(Request $request){

        try {
            $input = $request->except('user_id','date');

            $input['user_id'] = auth()->user()->id;

            $date = isset($request->date) ? $request->date : now()->toDateString();


            $userSymptomsitem = UserSymptomsLogs::whereDate('created_at',$date)->where('user_id',auth()->user()->id)->first();

            if(isset($userSymptomsitem)){
                $userSymptoms = $userSymptomsitem->update($input);
                return $this->sendResponse(null,'Data Updated SuccessFully',true);
            }else{
                $userSymptoms = UserSymptomsLogs::create($input);
                return $this->sendResponse(null,'Data Saved SuccessFully',true);
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null,'something went wrong',false);
        }

    }

    public function listuserSymptomsLogs(){

        try {

            $userSymptoms = UserSymptomsLogs::where('user_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->first();

            if(isset($userSymptoms)){
                return $this->sendResponse($userSymptoms,"Data RetrivedSuccessFully",true);
            }else{
                return $this->sendResponse(null,"Data Not Found",false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null,"Data Retrived SuccessFully",false);
        }
    }

    // public function postLikeOperation(Request $request)
    // {
    //     try {
    //         $post_id = isset($request->post_id) ? $request->post_id : null;
    //         $like = isset($request->like) ? $request->like : '';

    //         $post = Post::find($post_id);

    //         if (!$post) {
    //             return $this->sendResponse(null,'Post Not Found !',false);
    //         }

    //         if ($like) {
    //             $post->likes += 1;
    //         } else {
    //             $post->likes = max(0, $post->likes - 1);
    //         }

    //         // Save the updated post
    //         $post->save();

    //         return $this->sendResponse(null ,'Post like operation successful',true);
    //     } catch (\Exception $e) {
    //         return $this->sendResponse(null,'Something went wrong!',false);
    //     }
    // }

    public function storeUsersActivityCount()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return $this->sendResponse(null,'Users Not Authorize!',false);
            }

            // Increment active user count for the current date
            $date = now()->toDateString(); // Get current date
            $activity = UserActivityStatus::where('user_id', $user->id)
                                     ->whereDate('created_at', $date)
                                     ->first();

            if ($activity) {
                $activity->increment('activity_counts');
            } else {

               $activity = UserActivityStatus::create([
                    'user_id' => $user->id,
                    'activity_counts' => 1,
                ]);
            }
            return $this->sendResponse($activity ,'User activity counted successfully',true);

        } catch (\Exception $e) {
            return $this->sendResponse(null,'Something went wrong!',false);
        }
    }

    public function userResponse($userdata)
    {
        $data['id'] = $userdata->id;
        $data['name'] = $userdata->name;
        $data['email'] = $userdata->email;
        $data['role_id'] = $userdata->role_id;
        $data['uuId'] = $userdata->unique_id;
        $data['birthdate'] = $userdata->birthdate;
        $data['gender'] = isset($userdata->gender) ? strval($userdata->gender) : null;
        $data['gender_type'] = isset($userdata->gender_type) ? $userdata->gender_type : null ;
        $data['mobile'] = $userdata->mobile;
        $data['device_token'] = $userdata->device_token;
        $data['image'] = isset($userdata->image) ?  asset('/public/images/uploads/user_images/' . $userdata->image) : null;
        $data['relationship_status'] = isset($userdata->relationship_status) ? strval($userdata->relationship_status) : null;
        $data['average_cycle_length'] = $userdata->average_cycle_length;
        $data['previous_periods_begin'] = $userdata->previous_periods_begin;
        $data['previous_periods_month'] = $userdata->previous_periods_month;
        $data['average_period_length'] = $userdata->average_period_length;
        $data['hum_apke_he_kon'] = $userdata->hum_apke_he_kon;
        $data['status'] = $userdata->status;

        return $data;
    }


}
