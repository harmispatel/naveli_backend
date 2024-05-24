<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home($def_locale){
        $home = Home::first();
        return view('admin.home.home',compact('home','def_locale'));
    }

    public function homeCreateUpdate(Request $request){

        if(!$request->language_code && empty($request->language_code)){
            return redirect()->back()->with('error','language code not found');
        }

        $request->validate([
           "title" => "required",
           "link" => "required"
        ]);

        try {
             $home = Home::first();

             if(isset($home) && $home->id > 0){

                $updatehome = $home->update([
                    'title_' . $request->language_code => $request->title,
                    'link' => $request->link
                ]);

                return redirect()->back()->with("message","HomePage Updated Successfully");

             }else{

                $storehome = new Home;
                if($request->language_code == 'hi'){
                    $storehome->title_hi = $request->title;
                }else{
                    $storehome->title_en = $request->title;
                }
                $storehome->link = $request->link;

                $storehome->save();

                return redirect()->back()->with("message","HomePage Saved Successfully");

            }
        } catch (\Throwable $th) {

            return redirect()->back()->with("error","Internal Server Error");
        }
    }
}
