<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ServiceRequest;
use App\Models\Service;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class HomeServiceController extends Controller
{

    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,home_services')) {
            return redirect('admin/index');
        }

        $services = Service::whereType('services')->orderBy('id' ,'desc')->paginate(10);
        $head = 'Home Service';
        $route = '.services.';

        return view('backend.services.index', compact('services', 'head', 'route'));
    }


    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,home_services')) {
            return redirect('admin/index');
        }

        $head = 'Home Service';
        $route = '.services.';
        return view('backend.services.create', compact('head', 'route'));
    }


    public function store(ServiceRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,home_services')) {
            return redirect('admin/index');
        }

        $input['title']     = $request->title;
        $input['text']      = $request->text;
        $input['status']    = $request->status;
        $input['type']      = 'services';

        if ($image = $request->file('image')) {
            $filename = time() . md5(uniqid()) .'.'.$image->getClientOriginalExtension();
            $path = ('assets/home_services/' . $filename);
            $path_data = ('assets/home_services/' . $filename);
            // Image::make($image->getRealPath())->resize(450, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save($path, 100);
            // $input['image']  = $path_data;
            Image::make($image->getRealPath())->save($path, 100);
            $input['image']  = $path_data;
        }

        Service::create($input);

        return redirect()->route('admin.services.index')->with([
            'message' => 'Home Service Created Successfully',
            'alert-type' => 'success'
        ]);
    }


    public function show($id)
    {
        //
    }

    public function edit(Service $service)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,home_services')) {
            return redirect('admin/index');
        }

        $head = 'Home Service';
        $route = '.services.';
        $service = $service;
        return view('backend.services.edit', compact('service','head', 'route','service'));
    }


    public function update(ServiceRequest $request, Service $service)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,home_services')) {
            return redirect('admin/index');
        }

        $input['title']     = $request->title;
        $input['text']      = $request->text;
        $input['status']    = $request->status;

        if ($image = $request->file('image')) {

            if ($service->image != null && is_file(''.$service->image)) {
                unlink(''.$service->image);
            }

            $filename = time() . md5(uniqid()) .'.'.$image->getClientOriginalExtension();
            $path = ('assets/home_services/' . $filename);
            $path_data = ('assets/home_services/' . $filename);
            // Image::make($image->getRealPath())->resize(450, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save($path, 100);
            // $input['image']  = $path_data;
            Image::make($image->getRealPath())->save($path, 100);
            $input['image']  = $path_data;
        }

        $service->update($input);

        return redirect()->route('admin.services.index')->with([
            'message' => 'Home Service Updated Successfully',
            'alert-type' => 'success'
        ]);
    }


    public function destroy(Service $service)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_home,home_services')) {
            return redirect('admin/index');
        }

        if ($service->image != null && is_file($service->image)) {
            unlink($service->image);
        }
        $service->delete();

        return redirect()->route('admin.services.index')->with([
            'message' => 'Home Service Deleted Successfully',
            'alert-type' => 'success'
        ]);

    }


    public function removeImage(Request $request)
    {

        if (!\auth()->user()->ability('superAdmin', 'manage_home,home_services')) {
            return redirect('admin/index');
        }

        $service = Service::whereId($request->service_id)->first();
        if ($service) {
            if (is_file(''.$service->image)) {
                unlink(''.$service->image);

                $service->image = null;
                $service->save();
            }
        }
        return true;
    }

}


