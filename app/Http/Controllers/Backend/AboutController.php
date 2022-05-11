<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SliderRequest;
use App\Models\About;
use App\Models\HomePage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AboutController extends Controller
{

    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,show_abouts')) {
            return redirect('admin/index');
        }

        $abouts = About::latest()->paginate(10);
        return view('backend.abouts.index', compact('abouts'));
    }


    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,show_abouts')) {
            return redirect('admin/index');
        }
        return view('backend.abouts.create');
    }


    public function store(SliderRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,show_abouts')) {
            return redirect('admin/index');
        }

        $input['title']         = $request->title;
        $input['text']          = $request->text;
        $input['video']         = $request->video;
        $input['status']        = $request->status;

        if ($image = $request->file('image')) {
            $filename = time() . md5(uniqid()) .'.'.$image->getClientOriginalExtension();
            $path = ('images/about/' . $filename);
            $path_data = ('images/about/' . $filename);
            // Image::make($image->getRealPath())->resize(600, 450, function ($constraint) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // })->save($path, 100);

            // Image::make($image->getRealPath())->resize(800, 550)->save($path, 100);
            // $input['image']  = $path_data;
            Image::make($image->getRealPath())->fit(800, 600, function ($constraint) {
                $constraint->upsize();
            })->save($path, 100);
            $input['image']  = $path_data;
        }

        About::create($input);
        Alert::success('About Created Successfully', 'Success Message');
        return redirect()->route('admin.abouts.index');

    }


    public function show($id)
    {
        //
    }

    public function edit(About $about)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,show_abouts')) {
            return redirect('admin/index');
        }
        return view('backend.abouts.edit', compact('about'));
    }


    public function update(SliderRequest $request, About $about)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,show_abouts')) {
            return redirect('admin/index');
        }
        $input['title']     = $request->title;
        $input['text']      = $request->text;
        $input['video']      = $request->video;
        $input['status']    = $request->status;

        if ($image = $request->file('image')) {

            if ($about->image != null && is_file($about->image)) {
                unlink($about->image);
            }

            $filename = time() . md5(uniqid()) .'.'.$image->getClientOriginalExtension();
            $path = ('images/about/' . $filename);
            Image::make($image->getRealPath())->fit(800, 600, function ($constraint) {
                $constraint->upsize();
            })->save($path, 100);
            $input['image']  = $path;

            // Image::make($image->getRealPath())->resize(800, 550)->save($path, 100);
            // $input['image']  = $path_data;
        }

        $about->update($input);
        Alert::success('About Updated Successfully', 'Success Message');
        return redirect()->route('admin.abouts.index');
    }


    public function destroy(About $about)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,show_abouts')) {
            return redirect('admin/index');
        }

        if ($about->image != null && is_file($about->image)) {
            unlink($about->image);
        }
        $about->delete();
        Alert::success('About Deleted Successfully', 'Success Message');
        return redirect()->route('admin.abouts.index');

    }


    public function removeImage(Request $request)
    {

        if (!\auth()->user()->ability('superAdmin', 'manage_home,show_abouts')) {
            return redirect('admin/index');
        }

        $about = About::whereId($request->slider_id)->first();
        if ($about) {
            if (is_file($about->image)) {
                unlink($about->image);

                $about->image = null;
                $about->save();
            }
        }
        return true;
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $about = About::findorfail($id);
            $image   = $about->media()->whereId($request->image_id)->first();
            if ($image) {
                if (File::exists($image->file_name)) {
                    unlink($image->file_name);
                }
            }
            $about->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function changeStatus(Request $request)
    {
        $about = About::find($request->cat_id);
        $about->status = $request->status;
        $about->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }

}

