<?php

namespace App\Services\Slider;

use App\Models\Slider\Slider;
use App\Services\IService;
use Illuminate\Http\Request;

/**
 * Class SliderService
 * @package App\Services
 */
class SliderService implements IService
{

    public function getAll()
    {
        $data = Slider::orderBy('id','desc')->get();
        return $data;
    }

    public function getByID($id)
    {
        $data = Slider::find($id);
        return $data;
    }

    public function getByMasterId($slider_master_id)
	{
		try{
			$data = Slider::where('slider_master_id',$slider_master_id)->orderBy('id','desc')->get();
			return $data;
		}
		catch(\Exception $e){
			$d['error'] = 'Something wrong';
			return response()->json(["msg"=>$e->getMessage()]);
        }
	}
    public function create(Request $request)
    {            
        $params = $request->all();
        // dd($params);
        $params['show_description'] = $request->show_description ?? 0;
    	// if ($file = $request->file('image'))
        // {
        //     $config = array(
        //         'name'      => "image",
        //         'path'      => 'upload/slider',
        //         'width'     => 1440,
        //         'height'    => 600
        //     );
        //     $image = ImageHelper::uploadImage($config);
        //     $params['image'] = $image['filename'];
        // }
        if ($file = $request->file('image'))
        {
            $filename =date('Ymd') .'_'.time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/slider'), $filename);
            // $image=Image::make(public_path('upload/slider/').$filename);
            // $image->resize(1700,1100)->save(public_path('upload/slider/').$filename);
            $params['image']= $filename;

        }
        // dd($params);
    	Slider::create($params);
    }  
	public static function SingleData($slider_master_id,$id)
	{ 
        $data = Slider::where('slider_master_id',$slider_master_id)->where('id',$id)->firstOrFail();
        
        return $data; 
	}
    // 
    public function update( Request $request,$id)
    {
        $data = Slider::find($id);
        $params = $request->all();
        $params['show_description'] = $request->show_description ?? 0;
    	if ($file = $request->file('image'))
        {
            @unlink(public_path('upload/slider/'.$data->image));
            $filename =date('Ymd') .'_'.time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/slider'), $filename);
            // $image=Image::make(public_path('upload/slider/').$filename);
            // $image->resize(1700,1100)->save(public_path('upload/slider/').$filename);
            $params['image']= $filename;

        }
    	$data->update($params);
 
        try{
            $data->update($params);
            return true;

        }catch(Exception $e){
            return $e;
        }
    }

    public function delete($id)
    {
        $data = Slider::find($id);  
        @unlink(public_path('upload/slider/'.$data->image));
        $data->delete();
        return true;
    }
    // }(Request $request)
    // {
    //     $data = Slider::find($request->id);  

    //     $data->delete();
    //     return true;

    // } 
    // // 
    // public function statusChangeEvent(Request $request)
    // {
    //     $data = Newsletter::find($request->id);  
    //     $data->status = $request->status;
    //         $data->update();
    //         return true;

    // } 

}
