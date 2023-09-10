<?php

namespace App\Http\Controllers\Frontend;

use App;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Category;
use App\Models\Ministry;
use App\Models\PolicyAct;
use App\Models\Contact;
use App\Models\Slider;
use App\Models\NewsEvent;
use App\Models\Objective;
use App\Models\Personality;
use App\Models\ImportantLink;
use App\Models\VideoLink;
use App\Models\Comment;
use App\Models\GeneralFeedback;
use App\Models\Contactor;
use App\Models\SubComment;
use App\Models\User;
use Auth;

class FrontController extends Controller
{
    public function __construct(){

    }

    public function index()
    {
        $data = [];
        $data['is_active'] = "home";
        $data['sliders'] = Slider::all();
        return view('site.home',$data);
    }

    public function About()
    {
        $is_active = "about";
        return view('site.single_pages.about',compact('is_active'));
    }
    public function forParticipants()
    {
        $is_active = "participants";
        return view('site.single_pages.participants',compact('is_active'));
    }
    public function aboutDhaka()
    {
        $is_active = 'dhaka';
        return view('site.single_pages.about_dhaka',compact('is_active'));
    }

    public function Organizer()
    {
      $is_active = "organizer";
      return view('site.single_pages.organizer',compact('is_active'));
    }
    public function publicProgram()
    {
      $is_active = "program";
      return view('site.single_pages.public_program',compact('is_active'));
    }
    public function Gallery()
    {
        $is_active = "gallery";
        return view('site.single_pages.gallery',compact('is_active'));
    }


}
