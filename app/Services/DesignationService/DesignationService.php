<?php

namespace App\Services\DesignationService;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\IService;

/**
 * Class DesignationService
 * @package App\Services
 */
class DesignationService implements IService
{
    
    public function getAll()
	{
		try{
			$data = Designation::all();
			return $data;
		}
		catch(\Exception $e){
			$d['error'] = 'Something wrong';
			return response()->json(["msg"=>$e->getMessage()]);
        }
	}
    public function create(Request $request)
    {            
        $data = $request->all();
        
        Designation::create($data);
    }  
	public function getByID($id)
	{ 
        $data = Designation::find($id);
        
        return $data; 
	}
    public function update(Request $request, $id)
    {
        $data = Designation::find($id);
        $params = $request->except(['_token']);
        
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
        $user = Designation::find($id);
        $user->delete();
        
        return true;
    }

}
