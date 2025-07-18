<?php

namespace Modules\HourlyJob\App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\AdminNotification;
use App\Models\Bookmark;
use App\Models\JobHistory;
use App\Models\JobPost;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class HourlyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function hourly_jobs()
    {
        $all_jobs = JobPost::where('type','hourly')->latest()->paginate(10);
        return view('hourlyjob::backend.hourly-job.all-job',compact('all_jobs'));
    }


    // search job
    public function search_job(Request $request)
    {
        $all_jobs= JobPost::whereHas('job_creator')
            ->where('type','hourly')
            ->where('title', 'LIKE', "%". strip_tags($request->string_search) ."%")
            ->paginate(10);
        return $all_jobs->total() >= 1 ? view('hourlyjob::backend.hourly-job.search-result', compact('all_jobs'))->render() : response()->json(['status'=>__('nothing')]);
    }

    // pagination
    function pagination(Request $request)
    {
        if($request->ajax()){
            if(!empty($request->string_search)){
                $all_jobs= JobPost::whereHas('job_creator')
                    ->where('type','hourly')
                    ->where('title', 'LIKE', "%". strip_tags($request->string_search) ."%")
                    ->paginate(10);
            }else{
                $all_jobs = JobPost::whereHas('job_creator')
                    ->where('type','hourly')
                    ->latest()
                    ->paginate(10);
            }
            return view('hourlyjob::backend.hourly-job.search-result', compact('all_jobs'))->render();
        }
    }

    //  job details
    public function job_details($id=null)
    {
        JobPost::findOrFail($id);
        $job = JobPost::with(['job_category','job_history'])
            ->whereHas('job_creator')
            ->where('type','hourly')
            ->where('id',$id)->first();

        if($job){
            $user = User::with(['user_introduction','user_country','user_state','user_city'])->where('id',$job->user_id)->first();
            $complete_jobs_count = Order::where('is_project_job','job')->where('status',3)->where('user_id',$job->user_id)->get();
            AdminNotification::where('identity',$id)->update(['is_read'=>1]);
            return isset($job) ? view('hourlyjob::backend.hourly-job.job-details',compact(['job','user','complete_jobs_count'])) : back();
        }else{
            return back();
        }

    }

    //  job status change active-to-inactive-to-active
    public function change_status($id=null)
    {
        $job = JobPost::where('id',$id)->first();
        $user = User::where('id',$job->user_id)->first();

        $status = $job->status == 1 ? 0 : 1;
        JobPost::where('id',$id)->update(['status'=>$status]);

        if($status == 1){
            try {
                $message = get_static_option('job_approve_email_message') ?? __('Your job has been activate.');
                $message = str_replace(["@name","@job_id"],[$user->first_name.' '.$user->last_name, $id], $message);
                Mail::to($user->email)->send(new BasicMail([
                    'subject' => get_static_option('job_approve_email_subject') ?? __('Job Activate Email'),
                    'message' => $message
                ]));
            }
            catch (\Exception $e) {}
            client_notification($id, $job->user_id, 'Job', __('Your job has been activate'));
            return back()->with(toastr_success(__('Job Status Successfully Changed')));
        }else{
            try {
                $message = get_static_option('job_decline_email_message') ?? __('Your job has been rejected.');
                $message = str_replace(["@name","@job_id"],[$user->first_name.' '.$user->last_name, $id], $message);
                Mail::to($user->email)->send(new BasicMail([
                    'subject' => get_static_option('job_decline_email_subject') ?? __('Job Reject Email'),
                    'message' => $message
                ]));
            }
            catch (\Exception $e) {}
            client_notification($id, $job->user_id, 'Job', __('Your job has been rejected'));
            return back()->with(toastr_success(__('Job Successfully Rejected')));
        }
    }

    // delete single job
    public function delete_job($id)
    {
        JobHistory::where('job_id',$id)->delete();
        AdminNotification::where('identity',$id)->delete();
        Bookmark::where('identity',$id)->where('is_project_job','job')->delete();
        JobPost::find($id)->delete();
        return redirect()->back()->with(toastr_error(__('Job Successfully Deleted.')));
    }

    //hour settings
    public function hour_settings(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate(['minimum_hour_for_realtime_earning' => 'required']);
            $all_fields = ['minimum_hour_for_realtime_earning'];

            foreach ($all_fields as $field) {
                update_static_option($field, $request->$field);
            }
            toastr_success(__('Settings Updated Successfully.'));
            return back();
        }
        return view('hourlyjob::backend.hour-settings.hour-settings');
    }

}
