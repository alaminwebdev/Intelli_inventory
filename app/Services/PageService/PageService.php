<?php
namespace App\Services\pageService; 
use App\Models\MenuPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\IService;
/**
* Class pageService
* @package App\Services
*/
class pageService implements IService
{
    public function getAll()
    {
        try{
        $data = MenuPost ::where('status','1')->get();
        return $data;
       }
        catch(\Exception $e){
        $d['error'] = 'Something wrong';
        return response()->json(["msg"=>$e->getMessage()]);
        }
     }
    public function getByID($id)
    { 
        $data = MenuPost::find($id);
        return $data; 
    }
    public function create(Request $request)
    {            
        $post = new MenuPost();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->created_by = Auth::user()->id;
        $post->save();
    }  
    public function update(Request $request, $id)
    {
        $post = MenuPost::find($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->updated_by = Auth::user()->id;
        try{
            $post->save();
            return true;
        }        catch(\Exception $e){
        return $e;
        }
    }
    public function delete($id)
    {
        $deleteData = MenuPost::find($id);
        $deleteData->delete();
        return true;
    }
}

