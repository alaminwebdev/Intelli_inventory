<?php

namespace App\Services\Slider;

use App\Models\MenuPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\IService;
use App\Models\Slider\SliderMaster;

/**
 * Class PageService
 * @package App\Services
 */
class SliderMasterService implements IService
{
    
    public function getAll()
	{
		try{
			$data = SliderMaster::get();
			return $data;
		}
		catch(\Exception $e){
			$d['error'] = 'Something wrong';
			return response()->json(["msg"=>$e->getMessage()]);
        }
	}
    public function create(Request $request)
    {            
        // $params = $request->all();
        // dd($params);
        $sliderType = new SliderMaster;
        $sliderType->name = $request->name;
        $sliderType->animation_type = $request->animation_type;
        $sliderType->slider_type = $request->slider_type;

        // dd($sliderType);
        $sliderType->save();
    }  
	public function getByID($id)
	{ 
        $data = SliderMaster::find($id);
        
        return $data; 
	}
    public function update(Request $request, $id)
    {
        // $params = $request->all();
        // dd($params);
    	$sliderType = SliderMaster::find($id);

        // $sliderType = new SliderMaster;
        $sliderType->name = $request->name;
        $sliderType->animation_type = $request->animation_type;
        $sliderType->slider_type = $request->slider_type;

        // dd($sliderType);
        $sliderType->save();
 
        try{
            $sliderType->save();
            return true;

        }catch(Exception $e){
            return $e;
        }
    }

    public function delete($id)
    {
        $data = SliderMaster::find($id);
    	$data->delete();
        
        return true;
    }

}
