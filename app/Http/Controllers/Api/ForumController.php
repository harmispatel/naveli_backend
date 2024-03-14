<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\ForumComment;
use App\Models\Forum;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ForumController extends BaseController
{
    public function forumsList()
    {

        try {
            $getForumsData = Forum::with('forumCategory', 'forumSubCategory')->get();

            $data = $getForumsData->map(function ($forum) {
                $diff = $forum->created_at->diffForHumans();
                if (strpos($diff, 'second') !== false) {
                    $diff = str_replace('seconds', 'sec.', $diff);
                } elseif (strpos($diff, 'minute') !== false) {
                    $diff = str_replace('minutes', 'min.', $diff);
                } elseif (strpos($diff, 'hour') !== false) {
                    $diff = str_replace('hours', 'hr.', $diff);
                } elseif (strpos($diff, 'day') !== false) {
                    $diff = str_replace('days', 'day', $diff);
                } elseif (strpos($diff, 'month') !== false) {
                    $diff = str_replace('months', 'mon.', $diff);
                } elseif (strpos($diff, 'year') !== false) {
                    $diff = str_replace('years', 'year', $diff);
                } else {
                    $diff = "";
                }

                return [
                    'id' => $forum->id,
                    'forum_category' => isset($forum->forum_category_id) ? [
                        'id' => $forum->forumCategory->id,
                        'name' => $forum->forumCategory->name,
                    ] : null,
                    'forum_sub_category' => isset($forum->forum_subcategory_id) ? [
                        'id' => $forum->forumSubCategory->id,
                        'name' => $forum->forumSubCategory->name,
                    ] : null,
                    'title' => $forum->title,
                    'description' => $forum->description,
                    'time' => $diff,
                ];
            });
            return $this->sendResponse($data, 'Forums listing retrived SuccessFully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }

    public function forumCommentStore(Request $request)
    {
        try {
            $input = $request->only('comment', 'forum_id');
            $input['user_id'] = auth()->user()->id;

            if (isset($request->forum_id) && !empty($request->forum_id) && isset($request->comment) && !empty($request->comment)) {
                $forumStore = ForumComment::create($input);

                return $this->sendResponse(null, 'Comment Saved SuccessFully', true);
            } else {
                return $this->sendResponse(null, 'All fields are required.', false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Somting went Wrong!', false);
        }
    }

    public function getUsersCommentList(Request $request){

       try {
            $forum_id = $request->forum_id;
            $getUserComments = ForumComment::where('forum_id',$forum_id)->with('forum','users')->get();

            if(count($getUserComments) > 0){

                $data = $getUserComments->map(function ($commentDetail,$getUserComments) {

                    $diff = $commentDetail->created_at->diffForHumans();

                if (strpos($diff, 'second') !== false) {
                    $diffInHumanReadable = str_replace('seconds', 'sec.', $diff);
                } elseif (strpos($diff, 'minute') !== false) {
                    $diffInHumanReadable = str_replace('minutes', 'min.', $diff);
                } elseif (strpos($diff, 'hour') !== false) {
                    $diffInHumanReadable = str_replace('hours', 'hr.', $diff);
                } elseif (strpos($diff, 'day') !== false) {
                    $diffInHumanReadable = str_replace('days', 'day', $diff);
                } elseif (strpos($diff, 'month') !== false) {
                    $diffInHumanReadable = str_replace('months', 'mon.', $diff);
                } elseif (strpos($diff, 'year') !== false) {
                    $diffInHumanReadable = str_replace('years', 'year', $diff);
                } else {
                    $diffInHumanReadable = "";
                }
                    return [
                        'id' => $commentDetail->id,
                        'user_detail' =>isset($commentDetail->user_id) ? [
                           'id' => $commentDetail->users->id,
                           'name' => $commentDetail->users->name,
                           'image' => isset($commentDetail->users->image) ? asset('public/images/uploads/user_images/' .$commentDetail->users->image) :null,
                        ]: null,
                        'comment' => $commentDetail->comment,
                        'admin_reply'=>$commentDetail->admin_reply,
                        'comment_time' => $diffInHumanReadable,
                    ];
                });
                return $this->sendResponse($data, 'User Comments Received For this Forum', true);
            }else{
                return $this->sendResponse(null, 'No Comments On This Forum', true);
            }
       } catch (\Throwable $th) {
        return $this->sendResponse(null, 'Somting went Wrong!', false);
       }

    }
}
