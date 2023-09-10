<?php

namespace App\Http\Controllers\Backend\SiteSetting\Slider;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider\Slider;
use App\Models\Slider\SliderVideo;
use Image;
use App\Services\Slider\SliderService;

class SliderController extends Controller
{
    private $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }
    
    public function index($slider_master_id)
    {
        // $data['sliderVideo'] = SliderVideo::first();
        $data['slider'] =  $this->sliderService->getByMasterId($slider_master_id);
        
      //  dd($data['slider']->toArray());
        $data['slider_master_id'] = $slider_master_id;
        
    	return view('backend.site_setting.slider.slider-view')->with($data);
    }

    public function addSlider($slider_master_id)
    {
        $data['slider_master_id'] = $slider_master_id;
    	return view('backend.site_setting.slider.slider-add',$data);
    }

    public function storeSlider(Request $request)
    {
    	$request->validate([
    		// 'title' => 'required',
    		// 'description' => 'required',
    		'image' => 'required',

        ]);
        $this->sliderService->create($request);
        
    	return redirect()->route('site-setting.slider',$request->slider_master_id)->with('info','New Slider Upload Successfully.');


    }

    public function editSlider($slider_master_id,$id)
    {
       // $data['editData'] = SliderService::SingleData($slider_master_id,$id);
        $data['editData'] = $this->sliderService->getByID($id);
        $data['slider_master_id'] = $slider_master_id;
    	return view('backend.site_setting.slider.slider-add')->with($data);
    }

    public function updateSlider(Request $request, $id)
    {
        $request->validate([
            // 'title' => 'required',
            // 'description' => 'required',
            // 'image' => 'required',

        ]);
        $this->sliderService->update($request, $id);
       // $slider->updateEvent($request, $id);

    	return redirect()->route('site-setting.slider',$request->slider_master_id)->with('info','Slider Update Successfully');

    }

    public function deleteSlider(Request $request)
    {
        $this->sliderService->delete($request);
        //  
    	//        $slider->deleteEvent($request);
    }

    public function storeSliderVideo(Request $request)
    {
        // $data = SliderVideo::first();
        // $params = $request->all();
        // $params['show_video'] = $request->show_video ?? 0;
        // $params['opacity'] = $request->opacity;
        // if($request->hasFile('video'))
        // {
        //     if(!empty($data))
        //     {
        //         @unlink(public_path('upload/slider/'.$data->video));
        //     }
        //     $path = $request->file('video')->store('videos', ['disk' => 'my_files']);
        //     $params['video'] = $path;
        // }
        // if(!empty($data))
        // {
        //     $data->update($params);
        // }
        // else
        // {
        //     SliderVideo::create($params);
        // }
    	return redirect()->back()->with('info','Saved Successfully.');
    }
}
