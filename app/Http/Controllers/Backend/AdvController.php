<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AdvRequest;
use App\Models\Category;
use App\Models\Adv;
use App\Models\Tag;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use SebastianBergmann\Environment\Console;

class AdvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_advs,show_advs')) {
            return redirect('admin/index');
        }

        $advs = Adv::when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.advs.index', compact('advs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_advs,create_advs')) {
            return redirect('admin/index');
        }

        return view('backend.advs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_advs,create_advs')) {
            return redirect('admin/index');
        }

        $input['user_id']       = $request->user_id != '' ? $request->user_id : auth()->user()->id;
        $input['name']          = $request->name;
        $input['description']   = $request->description;
        $input['quantity']      = $request->quantity;
        $input['price']         = $request->price;
        $input['category']      = $request->category;
        $input['featured']      = $request->featured;
        $input['start_date']    = $request->start_date;
        $input['end_date']      = $request->end_date;
        $input['address']       = $request->address;
        $input['phone']         = $request->phone;
        $input['country_id']    = $request->country_id;
        $input['state_id']      = $request->state_id;
        $input['city_id']       = $request->city_id;
        $input['status']        = $request->status;

        $adv = Adv::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        $adv->tags()->attach($request->tags); //لان هذا علاقة مني تو مني

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $adv->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = ('images/advertisement/' . $filename);
                // Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($path, 100);
                Image::make($file->getRealPath())->resize(800, 550)->save($path, 100);

                $adv->media()->create([
                    'file_name'     => $path,
                    'file_size'     => $file_size,
                    'file_type'     => $file_type,
                    'file_status'   => true,
                    'file_sort'     => $i,
                ]);
                $i++;
            }
        }

        Alert::success('Adv Created Successfully', 'Success Message');
        return redirect()->route('admin.advs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Adv $adv)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_advs,display_advs')) {
            return redirect('admin/index');
        }

        return view('backend.advs.show', compact('adv'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Adv $adv)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_advs,update_advs')) {
            return redirect('admin/index');
        }

        return view('backend.advs.edit', compact('adv'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvRequest $request, Adv $adv)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_advs,update_advs')) {
            return redirect('admin/index');
        }

        $input['name']          = $request->name;
        $input['description']   = $request->description;
        $input['quantity']      = $request->quantity;
        $input['price']         = $request->price;
        $input['category']      = $request->category;
        $input['featured']      = $request->featured;
        $input['start_date']    = $request->start_date;
        $input['end_date']      = $request->end_date;
        $input['address']       = $request->address;
        $input['phone']         = $request->phone;
        $input['country_id']    = $request->country_id;
        $input['state_id']      = $request->state_id;
        $input['city_id']       = $request->city_id;
        $input['status']        = $request->status;

        $adv->update($input);

        $adv->tags()->sync($request->tags);

        if ($request->images && count($request->images) > 0) {
            $i = $adv->media()->count() + 1;

            foreach ($request->images as $file) {
                $filename = $adv->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = ('images/advertisement/' . $filename);
                // Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($path, 100);
                Image::make($file->getRealPath())->resize(800, 550)->save($path, 100);

                $adv->media()->create([
                    'file_name'     => $path,
                    'file_size'     => $file_size,
                    'file_type'     => $file_type,
                    'file_status'   => true,
                    'file_sort'     => $i,
                ]);
                $i++;
            }
        }
        Alert::success('Adv Updated Successfully', 'Success Message');

        return redirect()->route('admin.advs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adv $adv)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_advs,delete_advs')) {
            return redirect('admin/index');
        }

        if($adv->media()->count() > 0 )
        {
            foreach ($adv->media as $media)
            {
                if (File::exists($media->file_name)) {
                    unlink($media->file_name);
                }
                $media->delete();
            }
        }
        $adv->delete();

        Alert::success('Adv Deleted Successfully', 'Success Message');

        return redirect()->route('admin.advs.index');

    }



    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_advs,delete_advs')) {
            return redirect('admin/index');
        }

        $adv = Adv::findOrFail($request->adv_id);
        $image   = $adv->media()->whereId($request->image_id)->first();
        if ($image) {
            if (File::exists($image->file_name)) {
                unlink($image->file_name);
            }
        }
        $image->delete();
        return true;
    }

    public function advsDestroyAll(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $adv = Adv::findorfail($id);
            $image   = $adv->media()->whereId($request->image_id)->first();
            if ($image) {
                if (File::exists($image->file_name)) {
                    unlink($image->file_name);
                }
            }
            $adv->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);
    }

    public function changeStatus(Request $request)
    {
        $adv = Adv::find($request->cat_id);
        $adv->status = $request->status;
        $adv->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }
}
