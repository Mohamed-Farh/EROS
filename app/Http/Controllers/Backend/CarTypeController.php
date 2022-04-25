<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CarTypeRequest;
use App\Models\carProduct;
use App\Models\CarType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,show_cars')) {
            return redirect('admin/index');
        }

        $carTypes = CarType::withCount('products')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.carTypes.index', compact('carTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,create_cars')) {
            return redirect('admin/index');
        }

        return view('backend.carTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarTypeRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,create_cars')) {
            return redirect('admin/index');
        }
        $input['name']          = $request->name;
        $input['status']        = $request->status;

        if ($image = $request->file('cover')) {
            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
            $path = ('images/carType/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $input['cover']  = $path;
        }

        CarType::create($input);

        Alert::success('Car Type Created Successfully', 'Success Message');

        return redirect()->route('admin.carTypes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CarType $carType)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,show_cars')) {
            return redirect('admin/index');
        }
        // dd($carType);

        $carProducts = carProduct::with('firstMedia')

        ->where('car_type_id', $carType->id)

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.carProducts.index', compact('carType', 'carProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CarType $carType)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,update_cars')) {
            return redirect('admin/index');
        }

        return view('backend.carTypes.edit', compact('carType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarTypeRequest $request, CarType $carType)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,update_cars')) {
            return redirect('admin/index');
        }

        $input['name']          = $request->name;
        $input['slug']          = null;
        $input['status']        = $request->status;

        if ($image = $request->file('cover')) {

            if ($carType->cover != null && File::exists($carType->cover)) {
                unlink($carType->cover);
            }

            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
            $path = ('images/carType/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $input['cover']  = $path;
        }

        $carType->update($input);

        Alert::success('Car Type Updated Successfully', 'Success Message');

        return redirect()->route('admin.carTypes.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarType $carType)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,delete_cars')) {
            return redirect('admin/index');
        }

        if ($carType->cover != null && File::exists($carType->cover)) {
            unlink($carType->cover);
        }
        $carType->delete();

        Alert::success('Car Type Deleted Successfully', 'Success Message');

        return redirect()->route('admin.carTypes.index');

    }


    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,delete_cars')) {
            return redirect('admin/index');
        }

        $carType = CarType::whereId($request->car_id)->first();
        if ($carType) {
            if (File::exists($carType->cover)) {
                unlink($carType->cover);

                $carType->cover = null;
                $carType->save();
            }
        }
        return true;
    }


    public function massDestroy(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,delete_cars')) {
            return redirect('admin/index');
        }

        $ids = $request->ids;
        foreach ($ids as $id) {
            $carType = CarType::findorfail($id);
            if (File::exists($carType->cover)) :
                unlink($carType->cover);
            endif;
            $carType->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function updateStatus(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,update_cars')) {
            return redirect('admin/index');
        }

        $carType = CarType::find($request->cat_id);
        $carType->status = $request->status;
        $carType->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }

}

