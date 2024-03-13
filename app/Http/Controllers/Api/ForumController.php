<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\ForumComment;
use App\Models\Forum;
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

                return $this->sendResponse([], 'Comment Saved SuccessFully', true);
            } else {
                return $this->sendResponse(null, 'All fields are required.', false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Somting went Wrong!', false);
        }
    }
}
