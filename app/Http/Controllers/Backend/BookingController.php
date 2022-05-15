<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //All Bookings
    public function index()
    {
        Carbon::setLocale('ar');
        if (!\auth()->user()->ability('superAdmin', 'manage_bookings,show_bookings')) {
            return redirect('admin/index');
        }
        $bookings = Booking::with('category', 'product')
        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')
        ->paginate(\request()->limit_by ?? 10);
        return view('backend.bookings.index', compact('bookings'));
    }

    //Pending Bookings
    public function pending()
    {
        Carbon::setLocale('ar');
        if (!\auth()->user()->ability('superAdmin', 'manage_bookings,show_bookings')) {
            return redirect('admin/index');
        }
        $bookings = Booking::with('category', 'product')
        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')
        ->whereStatus('0')
        ->whereDate('day', '>=', Carbon::today())
        ->paginate(\request()->limit_by ?? 10);
        return view('backend.bookings.pending', compact('bookings'));
    }

    //Comming Bookings
    public function comming()
    {
        Carbon::setLocale('ar');
        if (!\auth()->user()->ability('superAdmin', 'manage_bookings,show_bookings')) {
            return redirect('admin/index');
        }
        $bookings = Booking::with('category', 'product')
        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')
        ->whereStatus('1')
        ->whereDate('day', '>=', Carbon::today())
        ->paginate(\request()->limit_by ?? 10);
        return view('backend.bookings.comming', compact('bookings'));
    }

    public function finished()
    {
        Carbon::setLocale('ar');
        if (!\auth()->user()->ability('superAdmin', 'manage_bookings,show_bookings')) {
            return redirect('admin/index');
        }
        $bookings = Booking::with('category', 'product')
        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')
        ->whereStatus('1')
        ->whereDate('day', '<=', Carbon::today())
        ->paginate(\request()->limit_by ?? 10);
        return view('backend.bookings.finished', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_bookings,create_bookings')) {
            return redirect('admin/index');
        }

        $categories = Category::whereStatus(1)->get(['id', 'name']);
        $tags       = Tag::whereStatus(1)->get(['id', 'name']);

        return view('backend.bookings.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_bookings,create_bookings')) {
            return redirect('admin/index');
        }

        $input['user_id']       = $request->user_id;
        $input['name']          = $request->name;
        $input['description']   = $request->description;
        $input['quantity']      = $request->quantity;
        $input['price']         = $request->price;
        $input['category_id']   = $request->category_id;
        $input['featured']      = $request->featured;
        $input['start_date']    = $request->start_date;
        $input['end_date']      = $request->end_date;
        $input['phone']         = $request->phone;
        $input['country_id']    = $request->country_id;
        $input['state_id']      = $request->state_id;
        $input['city_id']       = $request->city_id;
        $input['status']        = $request->status;

        $booking = Booking::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        $booking->tags()->attach($request->tags); //لان هذا علاقة مني تو مني

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $booking->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = ('images/product/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $booking->media()->create([
                    'file_name'     => $path,
                    'file_size'     => $file_size,
                    'file_type'     => $file_type,
                    'file_status'   => true,
                    'file_sort'     => $i,
                ]);
                $i++;
            }
        }

        Alert::success('Booking Created Successfully', 'Success Message');
        return redirect()->route('admin.bookings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_bookings,display_bookings')) {
            return redirect('admin/index');
        }

        return view('backend.bookings.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_bookings,update_bookings')) {
            return redirect('admin/index');
        }

        $categories = Category::whereStatus(1)->get(['id', 'name']);
        $tags       = Tag::whereStatus(1)->get(['id', 'name']);

        return view('backend.bookings.edit', compact('categories', 'tags', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookingRequest $request, Booking $booking)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_bookings,update_bookings')) {
            return redirect('admin/index');
        }

        $input['name']          = $request->name;
        $input['description']   = $request->description;
        $input['quantity']      = $request->quantity;
        $input['price']         = $request->price;
        $input['category_id']   = $request->category_id;
        $input['featured']      = $request->featured;
        $input['start_date']    = $request->start_date;
        $input['end_date']      = $request->end_date;
        $input['phone']         = $request->phone;
        $input['country_id']    = $request->country_id;
        $input['state_id']      = $request->state_id;
        $input['city_id']       = $request->city_id;
        $input['status']        = $request->status;

        $booking->update($input);

        $booking->tags()->sync($request->tags);

        if ($request->images && count($request->images) > 0) {
            $i = $booking->media()->count() + 1;
            foreach ($request->images as $file) {
                $filename = $booking->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = ('images/product/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $booking->media()->create([
                    'file_name'     => $path,
                    'file_size'     => $file_size,
                    'file_type'     => $file_type,
                    'file_status'   => true,
                    'file_sort'     => $i,
                ]);
                $i++;
            }
        }
        Alert::success('Booking Updated Successfully', 'Success Message');

        return redirect()->route('admin.bookings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_bookings,delete_bookings')) {
            return redirect('admin/index');
        }

        $booking->delete();

        Alert::success('Booking Deleted Successfully', 'Success Message');

        return redirect()->route('admin.bookings.index');

    }


    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $booking = Booking::findorfail($id);
            $booking->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function changeStatus(Request $request)
    {
        $booking = Booking::find($request->cat_id);
        $booking->status = $request->status;
        $booking->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }
}
