<?php

namespace App\Http\Controllers\Backend\SiteSetting\Slider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider\Slider;
use App\Models\Slider\SliderMaster;
use App\Models\Slider\SliderVideo;
use Image;
use App\Services\Slider\SliderMasterService;

class SliderMasterController extends Controller
{
    private $sliderMasterService;

    public function __construct(SliderMasterService $sliderMasterService)
    {
        $this->sliderMasterService = $sliderMasterService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data['sliderMaster'] = $this->sliderMasterService->getAll();
        return view('backend.site_setting.slider_master.slider-master-view')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('backend.site_setting.slider_master.slider-master-add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
    		'name' => 'required',
    		'animation_type' => 'required',

    	]);
        $this->sliderMasterService->create($request);

    	return redirect()->route('site-setting.slider-master')->with('success','New Slider Type Saved Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['editData'] = $this->sliderMasterService->getByID($id);
    	return view('backend.site_setting.slider_master.slider-master-add')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
    		'name' => 'required',
    		'animation_type' => 'required',

        ]);
        
        $this->sliderMasterService->update($request,$id);

    	return redirect()->route('site-setting.slider-master')->with('info','Slider Type Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $this->sliderMasterService->delete($request->id);
    }
}
