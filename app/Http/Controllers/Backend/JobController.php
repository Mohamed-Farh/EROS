<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\JobRequest;
use App\Models\Country;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JobController extends Controller
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

        $jobs = Job::with('jobCategory')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.jobs.index', compact('jobs'));
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

        $jobCategories = JobCategory::whereStatus(1)->get(['id', 'name']);
        $countries = Country::whereStatus(1)->get(['id', 'name']);

        return view('backend.jobs.create', compact('jobCategories', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,create_cars')) {
            return redirect('admin/index');
        }
        try {
            $input['user_id']       = $request->user_id;
            $input['name']          = $request->name;
            $input['gender']        = $request->gender;
            $input['speciality']    = $request->speciality;
            $input['description']   = $request->description;
            $input['address']       = $request->address;
            $input['exp_years']     = $request->exp_years;
            $input['phone']         = $request->phone;
            $input['job_category_id']  = $request->job_category_id;
            $input['country_id']    = $request->country_id;
            $input['state_id']      = $request->state_id;
            $input['city_id']       = $request->city_id;
            $input['status']        = $request->status;

            Job::create($input);
            Alert::success('Job Created Successfully', 'Success Message');
            return redirect()->route('admin.jobs.index');
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
    public function show(Request $request, Job $job)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,show_cars')) {
            return redirect('admin/index');
        }

        return view('backend.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,update_cars')) {
            return redirect('admin/index');
        }

        $jobCategories = JobCategory::whereStatus(1)->get(['id', 'name']);
        $countries = Country::whereStatus(1)->get(['id', 'name']);

        return view('backend.jobs.edit', compact('countries', 'jobCategories', 'job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, Job $job)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,update_cars')) {
            return redirect('admin/index');
        }
        try {
            $input['name']          = $request->name;
            $input['gender']        = $request->gender;
            $input['speciality']    = $request->speciality;
            $input['description']   = $request->description;
            $input['address']       = $request->address;
            $input['exp_years']     = $request->exp_years;
            $input['phone']         = $request->phone;
            $input['job_category_id']  = $request->job_category_id;
            $input['country_id']    = $request->country_id;
            $input['state_id']      = $request->state_id;
            $input['city_id']       = $request->city_id;
            $input['status']        = $request->status;

            $job->update($input);
            Alert::success('Job Updated Successfully', 'Success Message');
            return redirect()->route('admin.jobs.index');
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
    public function destroy(Job $job)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,delete_cars')) {
            return redirect('admin/index');
        }

        $job->delete();
        Alert::success('Job Deleted Successfully', 'Success Message');
        return redirect()->back();

    }


    public function massDestroy(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_cars,delete_cars')) {
            return redirect('admin/index');
        }

        $ids = $request->ids;
        foreach ($ids as $id) {
            $job = Job::findorfail($id);
            $job->delete();
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

        $job = Job::find($request->cat_id);
        $job->status = $request->status;
        $job->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }

}
