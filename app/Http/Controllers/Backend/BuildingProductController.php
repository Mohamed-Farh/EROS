<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BuildingProductRequest;
use App\Models\BuildingCategory;
use App\Models\BuildingProduct;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Tag;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class BuildingProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,show_buildings,manage_buildingProducts,show_buildingProducts')) {
            return redirect('admin/index');
        }

        $buildingProducts = BuildingProduct::with('buildingCategory', 'firstMedia')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.building_products.index', compact('buildingProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, BuildingCategory $building)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,create_buildings,manage_buildingProducts,create_buildingProducts')) {
            return redirect('admin/index');
        }

        $buildings = BuildingCategory::whereStatus(1)->get(['id', 'name']);
        $building_id = $request->building;
        $countries = Country::whereStatus(1)->get(['id', 'name']);

        return view('backend.building_products.create', compact('buildings', 'building_id', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuildingProductRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,create_buildings,manage_buildingProducts,create_buildingProducts')) {
            return redirect('admin/index');
        }
        DB::beginTransaction();
        try {
            $input['user_id']       = $request->user_id;
            $input['name']          = $request->name;
            $input['description']   = $request->description;
            $input['address']       = $request->address;
            $input['size']          = $request->size;
            $input['bedroom']       = $request->bedroom;
            $input['bathroom']      = $request->bathroom;
            $input['hall']          = $request->hall;
            $input['price']         = $request->price;
            $input['phone']         = $request->phone;
            $input['building_category_id']   = $request->building_category_id;
            $input['country_id']    = $request->country_id;
            $input['state_id']      = $request->state_id;
            $input['city_id']       = $request->city_id;
            $input['rent']          = $request->rent;
            $input['status']        = $request->status;

            $product = BuildingProduct::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

            if ($request->images && count($request->images) > 0) {
                $i = 1;
                foreach ($request->images as $file) {
                    $filename = $product->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = ('images/builgingProduct/' . $filename);
                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);

                    $product->media()->create([
                        'file_name'     => $path,
                        'file_size'     => $file_size,
                        'file_type'     => $file_type,
                        'file_status'   => true,
                        'file_sort'     => $i,
                    ]);
                    $i++;
                }
            }
            DB::commit(); // insert data
            Alert::success('Building Product Created Successfully', 'Success Message');
            return redirect()->route('admin.buildings.show', $request->building_category_id);
        }
        catch (\Exception $e){
            DB::rollback();
            Alert::error('لقد حدث خظا ما , يرجي اعادة ادخال البيانات مرة اخري', 'Error Message');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BuildingCategory $building, BuildingProduct $buildingProduct)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,show_buildings,manage_buildingProducts,show_buildingProducts')) {
            return redirect('admin/index');
        }

        return view('backend.building_products.show', compact('buildingProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BuildingProduct $buildingProduct)
    {
        // dd($buildingProduct);
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,update_buildings,manage_buildingProducts,update_buildingProducts')) {
            return redirect('admin/index');
        }

        $categories = Category::whereStatus(1)->get(['id', 'name']);
        $countries = Country::whereStatus(1)->get(['id', 'name']);

        return view('backend.building_products.edit', compact('categories', 'countries', 'buildingProduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BuildingProductRequest $request, BuildingProduct $buildingProduct)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,update_buildings,manage_buildingProducts,update_buildingProducts')) {
            return redirect('admin/index');
        }
        DB::beginTransaction();

        try {
            $input['name']          = $request->name;
            $input['description']   = $request->description;
            $input['address']       = $request->address;
            $input['size']          = $request->size;
            $input['bedroom']       = $request->bedroom;
            $input['bathroom']      = $request->bathroom;
            $input['hall']          = $request->hall;
            $input['price']         = $request->price;
            $input['phone']         = $request->phone;
            $input['country_id']    = $request->country_id;
            $input['state_id']      = $request->state_id;
            $input['city_id']       = $request->city_id;
            $input['rent']          = $request->rent;
            $input['status']        = $request->status;

            $buildingProduct->update($input);

            if ($request->images && count($request->images) > 0) {
                $i = $buildingProduct->media()->count() + 1;
                foreach ($request->images as $file) {
                    $filename = $buildingProduct->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = ('images/builgingProduct/' . $filename);
                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);

                    $buildingProduct->media()->create([
                        'file_name'     => $path,
                        'file_size'     => $file_size,
                        'file_type'     => $file_type,
                        'file_status'   => true,
                        'file_sort'     => $i,
                    ]);
                    $i++;
                }
            }
            DB::commit(); // insert data
            Alert::success('Building Product Updated Successfully', 'Success Message');
            return redirect()->route('admin.buildings.show', $request->building_category_id);
        }
        catch (\Exception $e){
            DB::rollback();
            Alert::error('لقد حدث خظا ما , يرجي اعادة ادخال البيانات مرة اخري', 'Error Message');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuildingProduct $buildingProduct)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,delete_buildings,manage_buildingProducts,delete_buildingProducts')) {
            return redirect('admin/index');
        }

        if($buildingProduct->media()->count() > 0 )
        {
            foreach ($buildingProduct->media as $media)
            {
                if (File::exists($media->file_name)) {
                    unlink($media->file_name);
                }
                $media->delete();
            }
        }
        $buildingProduct->delete();

        Alert::success('Building Product Deleted Successfully', 'Success Message');

        return redirect()->back();

    }



    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,delete_buildings,manage_buildingProducts,delete_buildingProducts')) {
            return redirect('admin/index');
        }

        $product = BuildingProduct::findOrFail($request->buildingProduct_id);
        $image   = $product->media()->whereId($request->image_id)->first();
        if ($image) {
            if (File::exists($image->file_name)) {
                unlink($image->file_name);
            }
        }
        $image->delete();
        return true;
    }

    public function massDestroy(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,delete_buildings,manage_buildingProducts,delete_buildingProducts')) {
            return redirect('admin/index');
        }

        $ids = $request->ids;
        foreach ($ids as $id) {
            $product = BuildingProduct::findorfail($id);
            $image   = $product->media()->whereId($request->image_id)->first();
            if ($image) {
                if (File::exists($image->file_name)) {
                    unlink($image->file_name);
                }
            }
            $product->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function updateStatus(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_buildings,update_buildings,manage_buildingProducts,update_buildingProducts')) {
            return redirect('admin/index');
        }

        $product = BuildingProduct::find($request->cat_id);
        $product->status = $request->status;
        $product->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }


    public function get_state(Request $request)
    {
        $states = State::whereCountryId($request->country_id)->whereStatus(true)->get(['id', 'name'])->toArray();

        return response()->json($states);
    }


    public function get_city(Request $request)
    {
        $cities = City::whereStateId($request->state_id)->whereStatus(true)->get(['id', 'name'])->toArray();

        return response()->json($cities);
    }
}
