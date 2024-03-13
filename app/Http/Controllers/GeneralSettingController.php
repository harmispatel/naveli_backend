<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GeneralSettingController extends Controller
{
    use ImageTrait;

    public function create()
    {
        $generalSetting = GeneralSetting::first();

        return view('admin.generalSetting.generalSetting', compact('generalSetting'));
    }

    public function store(Request $request)
    {
        try {
            $generallData = GeneralSetting::first();

            if ($generallData && $generallData->id > 0) {

                $generalSetting = GeneralSetting::find($request->id);
                $generalSetting->term_and_condition = $request->term_and_condition;
                $generalSetting->contact_us_page = $request->contact_us_page;
                $generalSetting->description = $request->description;
                $generalSetting->title_page = $request->title_page;

                if ($request->has('flash_screen')) {
                    File::delete(public_path('/images/uploads/general_image/' . $generalSetting->flash_screen));
                    $file = $request->file('flash_screen');
                    $image_url = $this->addSingleImage('general_image', $file, $old_image = '');
                    $generalSetting->flash_screen = $image_url;
                }

                $generalSetting->update();

                return redirect()->route('generalSetting')->with('message', 'Data updated Successfully');
            } else {
                $input = $request->except('_token', 'flash_screen');

                if ($request->has('flash_screen')) {
                    $file = $request->file('flash_screen');
                    $image_url = $this->addSingleImage('general_image', $file, $old_image = '');
                    $input['flash_screen'] = $image_url;
                }

                $generalSetting = GeneralSetting::create($input);

                return redirect()->route('generalSetting')->with('message', 'Data Saved Successfully');
            }
        } catch (\Throwable $th) {

            return redirect()->route('generalSetting')->with('error', 'Internal server error');
        }
    }
}
