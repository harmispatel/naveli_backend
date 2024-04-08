<?php

namespace App\Http\Controllers;

use App\Models\{ForumComment,Forum,ForumCategory, User};
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class ForumCommentController extends Controller
{
    public function __construct(){
        $this->middleware('permission:forumcomments.index|forumcomments.reply|forumcomments.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:forumcomments.reply', ['only' => ['reply', 'storeReply']]);
        $this->middleware('permission:forumcomments.destroy', ['only' => ['destroy']]);
    }

   public function index(Request $request){
    if($request->ajax()){
        $getForumcomments = ForumComment::get();

        return DataTables::of($getForumcomments)
        ->addIndexColumn()
        ->addColumn('forum_title', function ($row) {
           $getForum = Forum::where('id',$row->forum_id)->first();
           return isset($getForum->title) ? $getForum->title :null;
        })
        ->addColumn('user', function ($row) {
            $getUser = User::where('id',$row->user_id)->first();
            return isset($getUser->name) ? $getUser->name : null;
        })
        ->addColumn('comment_time',function ($row){
            $created_time = $row->created_at;
            $createdAt = Carbon::parse($created_time);
            $now = Carbon::now();
           
            $diff = $createdAt->diff($now);
          
            if ($diff->y > 0) {
                $diffInHumanReadable = $diff->y . ' yr.';
            } elseif ($diff->m > 0) {
                $diffInHumanReadable = $diff->m . ' mo.';
            } elseif ($diff->d > 0) {
                $diffInHumanReadable = $diff->d . ' d.';
            } elseif ($diff->h > 0) {
                $diffInHumanReadable = $diff->h . ' hr.';
            } elseif ($diff->i > 0) {
                $diffInHumanReadable = $diff->i . ' min.';
            } else {
                $diffInHumanReadable = $diff->s . ' sec.';
            }
            return $diffInHumanReadable;
        })
        ->addColumn('actions', function ($row) {
            return '<div class="btn-group">
                <a href=' . route("forumcomments.reply", ["id" => encrypt($row->id)]) . ' class="btn btn-sm custom-btn me-1"><i class="bi bi-reply" aria-hidden="true"></i></a>
                <a onclick="deleteUsers(\'' . $row->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                </div>';
        })
        ->rawColumns(['actions','user','forum_title','comment_time'])
        ->make(true);
     }
      return view('admin.forums.forum-comments');
   }

   public function reply($id){
       try {

            $id = decrypt($id);
            $forumComment = ForumComment::find($id);
            return view('admin.forums.comment-reply',compact('forumComment'));

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something Went Wrong!');
       }
   }

   public function storeReply(Request $request){
        try {
            $id = decrypt($request->id);
            $findComment = ForumComment::find($id);
            if(isset($findComment)){
               $update = $findComment->update([
                 'admin_reply' => isset($request->reply) ? $request->reply : ''
               ]);
               return redirect()->route('forumcomments.index')->with('message', 'Reply Sent Successfully..');
            }else{
                return redirect()->route('forumcomments.index')->with('error', 'Id Not Found!');
            }
        } catch (\Throwable $th) {
            return redirect()->route('forumcomments.index')->with('error', 'Something Went Wrong!');
        }
   }

   public function destroy(Request $request){

        try {
            $id = $request->id;

            $forumComment = ForumComment::findOrFail($id);
            $forumComment->delete();
            return response()->json([
                'success' => 1,
                'message' => "ForumComment deleted Successfully..",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }
   }

}
