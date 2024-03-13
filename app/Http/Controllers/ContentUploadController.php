<?php

namespace App\Http\Controllers;

use App\Models\ContentUpload;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentUploadController extends Controller
{
    use ImageTrait;

    public function getUserID()
    {

        try {
            $user = Auth::user();

            // Check if $user is an instance of the User model
            if ($user instanceof User) {
                $userId = $user->id;
                return response()->json(['user_id' => $userId, 'user_name' => $user->name]);
            }

            // Handle the case when $user is not an instance of User
            return response()->json(['error' => 'User not authenticated']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Internal server error');
        }

    }

    public function create()
    {

        $contentupload = ContentUpload::first();

        return view('admin.contentUpload.contentUpload', compact('contentupload'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required',
            'media_type' => 'required',
        ]);

        try {

            $contentupload = ContentUpload::first();
            if ($contentupload) {
                $cUpload = ContentUpload::find($request->id);
                $cUpload->title = $request->title;
                $cUpload->description = $request->description;
                $cUpload->user_id = $request->user_id;
                $cUpload->media_type = $request->media_type;

                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $image_url = $this->addSingleImage('contentUpload', $file, $old_image = '');
                    $cUpload->file = $image_url;
                }
                // dd($cUpload->file);

                $cUpload->save();

                return redirect()->route('ContentUpload')->with('message', 'Content Updated Successfully');

            } else {

                $input = $request->except('_token', 'file');

                if ($request->has('file')) {
                    $file = $request->file('file');
                    $image_url = $this->addSingleImage('contentUpload', $file, $old_image = '');
                    $input['file'] = $image_url;
                }

                $cUpload = ContentUpload::create($input);

                return redirect()->route('ContentUpload')->with('message', 'Content Saved Successfully');

            }

        } catch (\Throwable $th) {

            return redirect()->route('ContentUpload')->with('error', 'Internal server error');
        }
    }

}
