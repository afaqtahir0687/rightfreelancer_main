<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Project;
use App\Models\Portfolio;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserEarning;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserSkill;
use App\Models\UserWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\PromoteFreelancer\Entities\PromotionProjectList;
use Modules\CountryManage\Entities\Country;
use Modules\CountryManage\Entities\State;
use Modules\CountryManage\Entities\City;

class ProfileDetailsController extends Controller
{
    //freelancer profile details
    public function profile_details($username)
    {

        $user = User::with('user_introduction', 'freelancer_ratings')
        ->select(['id', 'username', 'image', 'hourly_rate', 'first_name', 'last_name', 'country_id', 'state_id', 'city_id', 'check_work_availability', 'user_verified_status', 'load_from'])
        ->where('username', $username)
        ->first();

       if($user){
        $countries = Country::all();
        $states = State::where('country_id', old('country', $user->country_id))->get();
        $cities = City::where('state_id', old('state', $user->state_id))->get();
           $user_work =  UserWork::where('user_id',$user->id)->first();
           $total_earning =  UserEarning::where('user_id',$user->id)->first();
           $complete_orders_in_total = Order::whereHas('user')->where('freelancer_id',$user->id)->where('status',3)->count();
           $complete_orders = Order::select('id','identity','status','freelancer_id')->whereHas('user')->whereHas('rating')->where('freelancer_id',$user->id)->where('status',3)->latest()->get();
           $active_orders_count = Order::where('freelancer_id',$user->id)->whereHas('user')->where('status',1)->count();
           $skills_according_to_category = isset($user_work) ? Skill::select(['id','skill'])->where('category_id',$user_work->category_id)->get() : '';

           $skills =  UserSkill::select('skill')->where('user_id',$user->id)->first()->skill ?? '';
           $portfolios = Portfolio::where('username',$username)->latest()->get();
           $educations = UserEducation::where('user_id',$user->id)->latest()->get();
           $experiences = UserExperience::where('user_id',$user->id)->latest()->get();
           $projects = Project::with('project_history')->whereHas('project_creator')->where('user_id',$user->id)->withCount('orders')->latest()->get();
           $average_rating = round($user->freelancer_ratings->avg('rating') ?? 0, 1);

           //pro profile view count
           if(moduleExists('PromoteFreelancer')) {
               if (Session::has('is_pro')) {
                   $current_date = \Carbon\Carbon::now()->toDateTimeString();
                   $find_package = PromotionProjectList::where('identity', $user->id)
                       ->where('type', 'profile')
                       ->where('expire_date', '>=', $current_date)
                       ->first();
                   if ($find_package) {
                       PromotionProjectList::where('id', $find_package->id)->update(['click' => $find_package->click + 1]);
                       Session::forget('is_pro');
                   }
               }
           }
           
           return view('frontend.profile-details.profile-details',compact([
               'username', 'skills_according_to_category', 'portfolios', 'skills', 'educations',
               'experiences', 'projects', 'user', 'total_earning', 'complete_orders',
               'complete_orders_in_total', 'active_orders_count', 'countries',
                'states', 'cities', 'average_rating',
           ]));
       }else{
           return back();
       }
    }
    //freelancer portfolio details
    public function portfolio_details(Request $request)
    {
        $portfolioDetails = Portfolio::where('id',$request->id)->first();
        $username = User::select('username')->where('id',$portfolioDetails->user_id)->first();
        $username = $username->username;
        return view('frontend.profile-details.portfolio-details',compact('portfolioDetails','username'))->render();
    }
}
