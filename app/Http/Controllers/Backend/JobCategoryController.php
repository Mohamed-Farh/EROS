<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\JobCategoryRequest;
use App\Models\JobCategory;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;


class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_jobs,show_jobs')) {
            return redirect('admin/index');
        }

        $jobCategories = JobCategory::with('jobs')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.jobCategories.index', compact('jobCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_jobs,create_jobs')) {
            return redirect('admin/index');
        }

        return view('backend.jobCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobCategoryRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_jobs,create_jobs')) {
            return redirect('admin/index');
        }

        JobCategory::create($request->validated());

        Alert::success('Job Category Created Successfully', 'Success Message');
        return redirect()->route('admin.jobCategories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(JobCategory $jobCategory)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_jobs,display_jobs')) {
            return redirect('admin/index');
        }

        return view('backend.jobCategories.show', compact('jobCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(JobCategory $jobCategory)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_jobs,update_jobs')) {
            return redirect('admin/index');
        }

        return view('backend.jobCategories.edit', compact('jobCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobCategoryRequest $request, JobCategory $jobCategory)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_jobs,update_jobs')) {
            return redirect('admin/index');
        }

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['status']    = $request->status;

        $jobCategory->update($input);

        Alert::success('Job Category Updated Successfully', 'Success Message');
        return redirect()->route('admin.jobCategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobCategory $jobCategory)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_jobs,delete_jobs')) {
            return redirect('admin/index');
        }

        $jobCategory->delete();

        Alert::success('Job Category Deleted Successfully', 'Success Message');
        return redirect()->route('admin.jobCategories.index');

    }


    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $JobCategory = JobCategory::findorfail($id);
            $JobCategory->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function updateStatus(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_jobs,update_jobs')) {
            return redirect('admin/index');
        }

        $medical = JobCategory::find($request->cat_id);
        $medical->status = $request->status;
        $medical->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }
}
