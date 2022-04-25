<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CarRequest;
use App\Models\CarCategory;
use App\Models\carProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class CarCategoryController extends Controller
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

        $carCategories = CarCategory::withCount('products')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.carCategories.index', compact('carCategories'));
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

        return view('backend.carCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,create_cars')) {
            return redirect('admin/index');
        }
        $input['name']          = $request->name;
        $input['description']   = $request->description;
        $input['status']        = $request->status;

        if ($image = $request->file('cover')) {
            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
            $path = ('images/carCategory/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $input['cover']  = $path;
        }

        CarCategory::create($input);

        Alert::success('Car Category Created Successfully', 'Success Message');

        return redirect()->route('admin.carCategories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CarCategory $carCategory)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,show_cars')) {
            return redirect('admin/index');
        }
        // dd($carCategory);

        $carProducts = carProduct::with('firstMedia')

        ->where('car_category_id', $carCategory->id)

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.carProducts.index', compact('carCategory', 'carProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CarCategory $carCategory)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,update_cars')) {
            return redirect('admin/index');
        }

        return view('backend.carCategories.edit', compact('carCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarRequest $request, CarCategory $carCategory)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,update_cars')) {
            return redirect('admin/index');
        }

        $input['name']          = $request->name;
        $input['slug']          = null;
        $input['description']   = $request->description;
        $input['status']        = $request->status;

        if ($image = $request->file('cover')) {

            if ($carCategory->cover != null && File::exists($carCategory->cover)) {
                unlink($carCategory->cover);
            }

            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
            $path = ('images/carCategory/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $input['cover']  = $path;
        }

        $carCategory->update($input);

        Alert::success('Car Category Updated Successfully', 'Success Message');

        return redirect()->route('admin.carCategories.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarCategory $carCategory)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,delete_cars')) {
            return redirect('admin/index');
        }

        if ($carCategory->cover != null && File::exists($carCategory->cover)) {
            unlink($carCategory->cover);
        }
        $carCategory->delete();

        Alert::success('Car Category Deleted Successfully', 'Success Message');

        return redirect()->route('admin.carCategories.index');

    }


    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,delete_cars')) {
            return redirect('admin/index');
        }

        $carCategory = CarCategory::whereId($request->car_id)->first();
        if ($carCategory) {
            if (File::exists($carCategory->cover)) {
                unlink($carCategory->cover);

                $carCategory->cover = null;
                $carCategory->save();
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
            $carCategory = CarCategory::findorfail($id);
            if (File::exists($carCategory->cover)) :
                unlink($carCategory->cover);
            endif;
            $carCategory->delete();
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

        $carCategory = CarCategory::find($request->cat_id);
        $carCategory->status = $request->status;
        $carCategory->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }

}

