<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MedicalRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Medical;
use App\Models\State;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MedicalNurseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_medicals,show_medicals')) {
            return redirect('admin/index');
        }

        $medicalNurses = Medical::where('medical_type', 'Nurse')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.medicalNurses.index', compact('medicalNurses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_medicals,create_medicals')) {
            return redirect('admin/index');
        }

        $countries = Country::whereStatus(1)->get(['id', 'name']);
        return view('backend.medicalNurses.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicalRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_medicals,create_medicals')) {
            return redirect('admin/index');
        }
        try {
            $input['user_id']       = $request->user_id;
            $input['name']          = $request->name;
            $input['gender']        = $request->gender;
            $input['medical_type']  = $request->medical_type;
            $input['type']          = $request->type;
            $input['speciality']    = $request->speciality;
            $input['description']   = $request->description;
            $input['address']       = $request->address;
            $input['work_hours']    = $request->work_hours;
            $input['exp_years']     = $request->exp_years;
            $input['phone']         = $request->phone;
            $input['country_id']    = $request->country_id;
            $input['state_id']      = $request->state_id;
            $input['city_id']       = $request->city_id;
            $input['status']        = $request->status;

            $medical = Medical::create($input);

            Alert::success('Medical Record Created Successfully', 'Success Message');
            return redirect()->route('admin.medicalNurses.index');
        }
        catch (\Exception $e){
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
    public function show(Medical $medical)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_medicals,show_medicals')) {
            return redirect('admin/index');
        }

        return view('backend.medicalNurses.show', compact('medical'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Medical $medicalNurse)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_medicals,update_medicals')) {
            return redirect('admin/index');
        }

        $countries = Country::whereStatus(1)->get(['id', 'name']);

        return view('backend.medicalNurses.edit', compact('countries', 'medicalNurse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MedicalRequest $request, Medical $medicalNurse)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_medicals,update_medicals')) {
            return redirect('admin/index');
        }
        try {
            $input['name']          = $request->name;
            $input['gender']        = $request->gender;
            $input['type']          = $request->type;
            $input['speciality']    = $request->speciality;
            $input['description']   = $request->description;
            $input['address']       = $request->address;
            $input['work_hours']    = $request->work_hours;
            $input['exp_years']     = $request->exp_years;
            $input['phone']         = $request->phone;
            $input['country_id']    = $request->country_id;
            $input['state_id']      = $request->state_id;
            $input['city_id']       = $request->city_id;
            $input['status']        = $request->status;

            $medicalNurse->update($input);

            Alert::success('Medical Record Updated Successfully', 'Success Message');
            return redirect()->route('admin.medicalNurses.index');
        }
        catch (\Exception $e){
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
    public function destroy(Medical $medicalNurse)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_medicals,delete_medicals')) {
            return redirect('admin/index');
        }

        $medicalNurse->delete();
        Alert::success('Medical Record Deleted Successfully', 'Success Message');
        return redirect()->back();
    }


    public function massDestroy(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_medicals,delete_medicals')) {
            return redirect('admin/index');
        }

        $ids = $request->ids;
        foreach ($ids as $id) {
            $medical = Medical::findorfail($id);
            $medical->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function updateStatus(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_medicals,update_medicals')) {
            return redirect('admin/index');
        }

        $medical = Medical::find($request->cat_id);
        $medical->status = $request->status;
        $medical->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }

}
