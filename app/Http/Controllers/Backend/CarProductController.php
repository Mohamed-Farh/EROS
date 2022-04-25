<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CarProductRequest;
use App\Models\Building;
use App\Models\BuildingCategory;
use App\Models\BuildingProduct;
use App\Models\CarCategory;
use App\Models\CarProduct;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class CarProductController extends Controller
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

        $carProducts = CarProduct::with('category', 'firstMedia')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.carProducts.index', compact('carProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, CarCategory $carCategory)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,create_cars')) {
            return redirect('admin/index');
        }

        $carCategories = CarCategory::whereStatus(1)->get(['id', 'name']);
        $carCategory_id = $request->carCategory;
        $countries = Country::whereStatus(1)->get(['id', 'name']);

        return view('backend.carProducts.create', compact('carCategories', 'carCategory_id', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarProductRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,create_cars')) {
            return redirect('admin/index');
        }
        DB::beginTransaction();
        try {
            $input['user_id']       = $request->user_id;
            $input['name']          = $request->name;
            $input['description']   = $request->description;
            $input['address']       = $request->address;
            $input['year']          = $request->year;
            $input['color']         = $request->color;
            $input['rent']          = $request->rent;
            $input['price']         = $request->price;
            $input['manual']        = $request->manual;
            $input['distance']      = $request->distance;
            $input['motor']         = $request->motor;
            $input['sound']         = $request->sound;
            $input['seat']          = $request->seat;
            $input['phone']         = $request->phone;
            $input['car_category_id']   = $request->car_category_id;
            $input['car_type_id']       = $request->car_type_id;
            $input['country_id']    = $request->country_id;
            $input['state_id']      = $request->state_id;
            $input['city_id']       = $request->city_id;
            $input['status']        = $request->status;

            $carProduct = CarProduct::create($input);

            if ($request->images && count($request->images) > 0) {
                $i = 1;
                foreach ($request->images as $file) {
                    $filename = $carProduct->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = ('images/carProduct/' . $filename);
                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);

                    $carProduct->media()->create([
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
            Alert::success('Car Product Created Successfully', 'Success Message');
            return redirect()->route('admin.carCategories.show', $request->car_category_id);
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
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,show_cars')) {
            return redirect('admin/index');
        }

        return view('backend.carProducts.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CarProduct $carProduct)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,update_cars')) {
            return redirect('admin/index');
        }

        $countries = Country::whereStatus(1)->get(['id', 'name']);

        return view('backend.carProducts.edit', compact('countries', 'carProduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarProductRequest $request, CarProduct $carProduct)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,update_cars')) {
            return redirect('admin/index');
        }
        DB::beginTransaction();

        try {
            $input['name']          = $request->name;
            $input['description']   = $request->description;
            $input['address']       = $request->address;
            $input['year']          = $request->year;
            $input['color']         = $request->color;
            $input['rent']          = $request->rent;
            $input['price']         = $request->price;
            $input['manual']        = $request->manual;
            $input['distance']      = $request->distance;
            $input['motor']         = $request->motor;
            $input['sound']         = $request->sound;
            $input['seat']          = $request->seat;
            $input['phone']         = $request->phone;
            $input['country_id']    = $request->country_id;
            $input['car_type_id']       = $request->car_type_id;
            $input['state_id']      = $request->state_id;
            $input['city_id']       = $request->city_id;
            $input['status']        = $request->status;

            $carProduct->update($input);

            if ($request->images && count($request->images) > 0) {
                $i = $carProduct->media()->count() + 1;
                foreach ($request->images as $file) {
                    $filename = $carProduct->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = ('images/carProduct/' . $filename);
                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);

                    $carProduct->media()->create([
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
            Alert::success('Car Product Updated Successfully', 'Success Message');
            return redirect()->route('admin.carCategories.show', $carProduct->car_category_id);
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
    public function destroy(CarProduct $carProduct)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,delete_cars')) {
            return redirect('admin/index');
        }

        if($carProduct->media()->count() > 0 )
        {
            foreach ($carProduct->media as $media)
            {
                if (File::exists($media->file_name)) {
                    unlink($media->file_name);
                }
                $media->delete();
            }
        }
        $carProduct->delete();

        Alert::success('Car Product Deleted Successfully', 'Success Message');

        return redirect()->back();

    }



    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,delete_cars')) {
            return redirect('admin/index');
        }

        $carProduct = CarProduct::findOrFail($request->carProduct_id);
        $image   = $carProduct->media()->whereId($request->image_id)->first();
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
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,delete_cars')) {
            return redirect('admin/index');
        }

        $ids = $request->ids;
        foreach ($ids as $id) {
            $product = CarProduct::findorfail($id);
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
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,update_cars')) {
            return redirect('admin/index');
        }

        $product = CarProduct::find($request->cat_id);
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
