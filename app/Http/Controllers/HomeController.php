<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $home = Home::first();

        return view('admin.home.home',compact('home'));
    }

    public function homeCreateUpdate(Request $request){
        $request->validate([
           "title" => "required",
           "link" => "required"
        ]);

        try {
             $home = Home::first();

             if(isset($home) && $home->id > 0){
                
                $updatehome = $home->update([
                    'title' => $request->title,
                    'link' => $request->link
                ]);

                return redirect()->route('home.index')->with("message","HomePage Updated Successfully");
                
             }else{
            
                $storehome = new Home;
                $storehome->title = $request->title;
                $storehome->link = $request->link;

                $storehome->save();

                return redirect()->route('home.index')->with("message","HomePage Saved Successfully");
            
            }
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('home.index')->with("error","Internal Server Error");
        }
    }
}
