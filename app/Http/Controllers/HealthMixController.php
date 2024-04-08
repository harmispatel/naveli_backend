<?php

namespace App\Http\Controllers;

use App\Models\HealthMix;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class HealthMixController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('permission:healthMix.index|healthMix.create|healthMix.edit|healthMix.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:healthMix.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:healthMix.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:healthMix.destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        try {
            $healthMix = HealthMix::all();

            if ($request->ajax()) {

                if (isset($request->healthmix_type_filter)) {
                    $healthMix = $healthMix->where('health_type', $request->healthmix_type_filter);
                }

                return DataTables::of($healthMix)
                    ->addIndexColumn()
                    ->addColumn('health_type', function ($health) {
                        $healthmix_category_id = $health->health_type;
                        switch ($healthmix_category_id) {
                            case '1':
                                $message = "EXPERT ADVICE";
                                break;
                            case '2':
                                $message = "CYCLE WISDOM";
                                break;
                            case '3':
                                $message = "GROOVE WITH NEOW";
                                break;
                            case '4':
                                $message = "CELEBS SPEAK";
                                break;
                            case '5':
                                $message = "TESTIMONIALS";
                                break;
                            case '6':
                                $message = "FUN CORNER";
                                break;
                            case '8':
                                $message = "EMPOWHER";
                                break;
                            default:
                                $message = "-----";

                        }

                        return $message;
                    })
                    ->addColumn('actions', function ($health) {
                        return '<div class="btn-group">
                            <a href=' . route("healthMix.edit", ["id" => encrypt($health->id)]) . ' class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                            <a onclick="deleteUsers(\'' . $health->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                            </div>';
                    })
                    ->rawColumns(['actions','health_type'])
                    ->make(true);
            }

            return view('admin.healthmix.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Internal Server Error!');
        }
    }

    public function create()
    {
        return view('admin.healthmix.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'health_type' => 'required',
            'file_type' => 'required',
            'media' => 'required',
            'hashtags' => 'required',
            'description' => 'required',
        ]);

        try {

            $input = $request->except('_token', 'media','file_type');

            if($request->hasFile('media')){

                $media = $request->media;
                $fileExtenstion = $media->getClientOriginalExtension();

                if(in_array($fileExtenstion, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                    $input['media_type'] = 'image';
                }else{
                    return redirect()->back()->withErrors(['media' => 'Only jpg, jpeg, png.. Image files are allowed!'])->withInput();
                }
                $media_url = $this->addSingleImage('healthmix', $media, $old_image = '');
                $input['media'] = $media_url;
            }else{
                $result = preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/|v\/)|youtu\.be\/)[\w-]+(&\S*)?$/', $request->media);
                if($result == 0){
                    return redirect()->back()->withErrors(['media' => 'The media URL is not valid.'])->withInput();
                }else {
                    $input['media'] = $request->media;
                    $input['media_type'] = $request->file_type;
                }
            }

            $healthMix = HealthMix::create($input);

            return redirect()->route('healthMix.create')->with('message', 'A New Healthmix Created SuccessFully');
        } catch (\Throwable $th) {
            return redirect()->route('healthMix.create')->with('error', 'Internal Server Error!');
        }

    }

    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $healthMix = HealthMix::find($id);

        return view('admin.healthmix.edit', compact('healthMix'));
        } catch (\Throwable $th) {
            return redirect()->route('healthMix.index')->with('error', 'Internal Server Error!');
        }

    }

    public function update(Request $request)
    {
        $request->validate([
            'health_type' => 'required',
            'file_type' => 'required',
            'hashtags' => 'required',
            'description' => 'required',
            'media' => 'required',
        ]);

        try {
            $id = decrypt($request->id);

            $healthMix = HealthMix::find($id);
            $healthMix->health_type = $request->health_type;
            $healthMix->hashtags = $request->hashtags;
            $healthMix->description = $request->description;

            if ($request->hasFile('media')) {

                File::delete(public_path('/images/uploads/healthmix/' . $healthMix->media));
                $media = $request->media;
                $fileExtenstion = $media->getClientOriginalExtension();

                if (in_array($fileExtenstion, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                    $healthMix->media_type = 'image';
                }else{
                    return redirect()->back()->withErrors(['media' => 'Only jpg, jpeg, png.. Image files are allowed!'])->withInput();
                }
                $file_url = $this->addSingleImage('healthmix', $media, $old_image = '');
                $healthMix->media = $file_url;
            }else{
                $result = preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/|v\/)|youtu\.be\/)[\w-]+(&\S*)?$/', $request->media);
                if($result == 0){
                    return redirect()->back()->withErrors(['media' => 'The media URL is not valid.'])->withInput();
                }else {
                    $healthMix->media = $request->media;
                    $healthMix->media_type = $request->file_type;
                }
            }

            $healthMix->save();

            return redirect()->route('healthMix.index')->with('message', 'Healthmix Updated Successfully');

        } catch (\Throwable $th) {
            return redirect()->route('healthMix.index')->with('error', 'Internal Server Error!');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $HealthMix = HealthMix::find($id);
            File::delete(public_path('/images/uploads/healthmix/' . $HealthMix->media));
            $HealthMix->delete();

            return response()->json([
                'success' => 1,
                'message' => "HealthMix deleted Successfully..",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }
}
