<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;

use App\Models\BuddyRequest;

use App\Models\User;use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NaveliAccessController extends BaseController
{
    public function verifyUniqueId(Request $request)
    {
        try {
            $auth_user = Auth::user() ?? null;
            if (!$auth_user) {
                return $this->sendResponse(null, 'Auth User Not Found!', false);
            }
            $request_unique_id = $request->unique_id;
            if ($request_unique_id) {

                $get_user = User::where('unique_id', $request_unique_id)->first();

                if (isset($get_user)) {

                    $fetchSendedRequest = BuddyRequest::where('sender_id', $auth_user->id)
                        ->where('receiver_id', $get_user->id)
                        ->whereIn('status', ['pending', 'accepted'])
                        ->first();

                    $fetchSendedRequestOtherNeoW = BuddyRequest::where('sender_id', $auth_user->id)
                        ->whereIn('status', ['pending', 'accepted'])
                        ->first();

                    if (isset($fetchSendedRequestOtherNeoW)) {
                        return $this->sendResponse(null, 'Your Request Alredy Pending OR Accepted To Another Naveli', true);
                    }
                    if (isset($fetchSendedRequest)) {
                        return $this->sendResponse(null, 'Your Request Alredy Pending OR Accepted', true);
                    }

                    $storeUserRequests = new BuddyRequest();
                    $storeUserRequests->sender_id = $auth_user->id;
                    $storeUserRequests->receiver_id = $get_user->id;
                    $storeUserRequests->status = "pending";
                    $storeUserRequests->save();

                    //notification send

                    $firebaseToken = $get_user->device_token;

                    $userName = $get_user->name;

                    if (isset($firebaseToken) && !empty($firebaseToken)) {

                        $notification = $this->notificationSend($firebaseToken, $userName);

                    }

                    return $this->sendResponse(null, 'Your request has been sent successfully', true);

                }
                return $this->sendResponse(null, 'User Not Found For This Unique-Id', false);

            } else {
                return $this->sendResponse(null, 'Unique-Id required!', false);
            }
        } catch (\Throwable $th) {

            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }

    public function notificationSend($token, $userName)
    {

        $SERVER_API_KEY = env("SERVER_API_KEY");
        $logoImageUrl = env("LOGO_IMAGE_URL");

        $data = array(
            "registration_ids" => [$token],
            "notification" => [
                "title" => 'Account access',
                "body" => $userName . " want's to access your data",
                "image" => $logoImageUrl,
            ],
        );

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);

        // if ($response === false) {
        //     $error = curl_error($ch);
        //     error_log("FCM request failed: $error");
        //     return false;
        // }

        // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // if ($httpCode != 200) {
        //     error_log("FCM request returned HTTP code $httpCode");
        //     return false;
        // }

        return $response;

    }

    public function getBuddiesRequest()
    {
        try {
            $auth_user = Auth::user() ?? null;
            if (!$auth_user) {
                return $this->sendResponse(null, 'Auth User Not Found!', false);
            }

            $buddyRequests = BuddyRequest::where('receiver_id', $auth_user->id)
                ->with('sender:id,name,mobile')
                ->get();

            if ($buddyRequests->isEmpty()) {
                return $this->sendResponse([], 'No Any Requests For This User', true);
            }

            $senders = $buddyRequests->map(function ($request) {
                return [
                    'id' => $request->sender['id'],
                    'name' => $request->sender['name'],
                    'mobile' => $request->sender['mobile'],
                    'notification_id' => $request->id,
                    'notification_status' => $request->status,
                ];
            });

            return $this->sendResponse($senders, 'Request Received Successfully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }

    public function getSendingAccessRequests()
    {
        try {
            $auth_user = Auth::user() ?? null;
            if (!$auth_user) {
                return $this->sendResponse(null, 'Auth User Not Found!', false);
            }

            $getSendingAccessRequests = BuddyRequest::where('sender_id', $auth_user->id)
                ->with('receiver:id,unique_id,name,mobile')
                ->get();

            if ($getSendingAccessRequests->isEmpty()) {
                return $this->sendResponse([], 'No Any Requests Found', true);
            }

            $receivers = $getSendingAccessRequests->map(function ($request) {
                return [
                    'unique_id' => $request->receiver['unique_id'],
                    'name' => $request->receiver['name'],
                    'mobile' => $request->receiver['mobile'],
                    'notification_id' => $request->id,
                    'notification_status' => $request->status,
                ];
            });

            return $this->sendResponse($receivers, 'Sending Access Request Status Received', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }

    public function naveliResponseToBuddy(Request $request)
    {
        try {
            $naveliResponse = $request->input('naveli_response');
            $uniqueId = Auth::user()->unique_id ?? null;
            $notificationId = $request->input('notification_id');

            if (!$uniqueId || !$notificationId) {
                return $this->sendResponse(null, 'All Fields Are Required!', false);
            }

            $getRequestDetail = BuddyRequest::where('id', $notificationId)->first();
            if ($naveliResponse) {

                $userData = getUserData($uniqueId);
                if (isset($userData)) {
                    if ($getRequestDetail) {
                        $update = $getRequestDetail->update(['status' => 'accepted']);
                        return $this->sendResponse(null, 'Your Request Has Been Accepted.', true);
                    } else {
                        return $this->sendResponse(null, 'Notification Id Wrong!', false);
                    }
                } else {
                    return $this->sendResponse(null, 'UniqueId OR User Not Found!', false);
                }

            } else {
                if ($getRequestDetail) {
                    $update = $getRequestDetail->update(['status' => 'rejected']);
                    return $this->sendResponse(null, 'Your Request Has Been Rejected.', true);
                } else {
                    return $this->sendResponse(null, 'Notification Id Wrong!', false);
                }
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }
}
