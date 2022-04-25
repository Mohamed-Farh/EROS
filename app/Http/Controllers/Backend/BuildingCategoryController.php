<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BuildingRequest;
use App\Models\BuildingCategory;
use App\Models\BuildingProduct;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class BuildingCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,show_buildings')) {
            return redirect('admin/index');
        }

        $buildings = BuildingCategory::withCount('products')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.buildings.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,create_buildings')) {
            return redirect('admin/index');
        }

        $main_buildings = BuildingCategory::get(['id', 'name']);

        return view('backend.buildings.create', compact('main_buildings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuildingRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,create_buildings')) {
            return redirect('admin/index');
        }
        $input['name']          = $request->name;
        $input['description']   = $request->description;
        $input['status']        = $request->status;

        if ($image = $request->file('cover')) {
            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
            $path = ('images/building/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $input['cover']  = $path;
        }

        BuildingCategory::create($input);

        Alert::success('BuildingCategory Created Successfully', 'Success Message');

        return redirect()->route('admin.buildings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BuildingCategory $building)
    {
        // dd($building);
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,show_buildings,manage_buildingProducts,show_buildingProducts')) {
            return redirect('admin/index');
        }

        $buildingProducts = BuildingProduct::with('buildingCategory', 'firstMedia')

        ->where('building_category_id', $building->id)

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.building_products.index', compact('building', 'buildingProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BuildingCategory $building)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,update_buildings')) {
            return redirect('admin/index');
        }

        $main_Categories = Category::whereNull('parent_id')->get(['id', 'name']);

        return view('backend.buildings.edit', compact('main_Categories', 'building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BuildingRequest $request, BuildingCategory $building)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,update_buildings')) {
            return redirect('admin/index');
        }

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['description']    = $request->description;
        $input['parent_id'] = $request->parent_id;
        $input['status']    = $request->status;

        if ($image = $request->file('cover')) {

            if ($building->cover != null && File::exists($building->cover)) {
                unlink($building->cover);
            }

            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
            $path = ('images/building/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $input['cover']  = $path;
        }

        $building->update($input);

        Alert::success('BuildingCategory Updated Successfully', 'Success Message');

        return redirect()->route('admin.buildings.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuildingCategory $building)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,delete_buildings')) {
            return redirect('admin/index');
        }

        if ($building->cover != null && File::exists($building->cover)) {
            unlink($building->cover);
        }
        $building->delete();

        Alert::success('BuildingCategory Deleted Successfully', 'Success Message');

        return redirect()->route('admin.buildings.index');

    }


    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,delete_buildings')) {
            return redirect('admin/index');
        }

        $buildingCategory = BuildingCategory::whereId($request->building_id)->first();
        if ($buildingCategory) {
            if (File::exists($buildingCategory->cover)) {
                unlink($buildingCategory->cover);

                $buildingCategory->cover = null;
                $buildingCategory->save();
            }
        }
        return true;
    }


    public function buildingsDestroyAll(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,delete_buildings')) {
            return redirect('admin/index');
        }

        $ids = $request->ids;
        foreach ($ids as $id) {
            $buildingCategory = BuildingCategory::findorfail($id);
            if (File::exists($buildingCategory->cover)) :
                unlink($buildingCategory->cover);
            endif;
            $buildingCategory->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function updateStatus(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,update_buildings')) {
            return redirect('admin/index');
        }

        $product = BuildingCategory::find($request->cat_id);
        $product->status = $request->status;
        $product->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }

}

