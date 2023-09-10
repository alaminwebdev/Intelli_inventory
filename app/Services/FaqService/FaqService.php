<?php

namespace App\Services\FaqService;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\IService;

/**
 * Class FaqService
 * @package App\Services
 */
class FaqService implements IService
{
    
    public function getAll()
	{
		try{
			$data = Faq::all();
			return $data;
		}
		catch(\Exception $e){
			$d['error'] = 'Something wrong';
			return response()->json(["msg"=>$e->getMessage()]);
        }
	}
    public function create(Request $request)
    {            
        $faq = new Faq();
        $faq->faq_type = $request->faq_type;

        if(!is_null($request->faculty_id)) {
            $faq->ref_id = $request->faculty_id;

        }else if(!is_null($request->dept_id)) {
            $faq->ref_id = $request->dept_id;

        }else if(!is_null($request->program_id)) {
            $faq->ref_id = $request->program_id;

        }else if(!is_null($request->chsr_id)) {
            $faq->ref_id = $request->chsr_id;
        }else if(!is_null($request->cpc_id)) {
            $faq->ref_id = $request->cpc_id;
        }

        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->status = $request->status ?? 0;
        // dd($faq->toArray());
        $faq->save();
    }  
	public function getByID($id)
	{ 
        $data = Faq::find($id);
        
        return $data; 
	}
    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);
        $faq->faq_type = $request->faq_type;

        if(!is_null($request->faculty_id)) {
            $faq->ref_id = $request->faculty_id;

        }else if(!is_null($request->dept_id)) {
            $faq->ref_id = $request->dept_id;

        }else if(!is_null($request->program_id)) {
            $faq->ref_id = $request->program_id;

        }else if(!is_null($request->chsr_id)) {
            $faq->ref_id = $request->chsr_id;
        }

        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->status = $request->status ?? 0;
        // dd($faq->toArray());
        $faq->save();
 
        try{
            $faq->save();
            return true;

        }catch(Exception $e){
            return $e;
        }
    }

    public function delete($id)
    {
        $data = Faq::find($id);
        $data->delete();
        
        return true;
    }

}
