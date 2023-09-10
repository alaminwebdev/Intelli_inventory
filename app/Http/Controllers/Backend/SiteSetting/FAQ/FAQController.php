<?php

namespace App\Http\Controllers\Backend\SiteSetting\FAQ;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Program;
use App\Models\Faq;
use App\Services\FaqService\FaqService;

class FAQController extends Controller
{
    private $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }
    public function index()
    {
        $faq_lists = $this->faqService->getAll();

        // return view('backend.program.view', $data);
        return view('backend.faq.view',compact('faq_lists'));
    }

    public function Add()
    {
        $data = [];
        // $data['categories'] = ProgramCategory::all();
        // $data['faculties'] = Faculty::all();
        // $data['departments'] = Department::all();
        // $data['programs'] = Program::all();
    	// return view('backend.program.add',$data);
    	return view('backend.faq.add')->with($data);
    }

    public function Store(Request $request)
    {
        // return $request->all();
        // dd(!is_null($request->faculty_id));
        $request->validate([
            'faq_type' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ]);

        $this->faqService->create($request);

    	return redirect()->route('site-setting.faq')->with('success','FAQ added successfully!');
    }

    public function Edit($id)
    {
        $data['editData'] = $this->faqService->getByID($id);
        // $data['faculties'] = Faculty::all();
        // $data['departments'] = Department::all();
        // $data['programs'] = Program::all();
    	return view('backend.faq.add',$data);
    }

    public function Update(Request $request,$id)
    {
        // return $request->all();
        $this->faqService->update($request,$id);
    	return redirect()->route('site-setting.faq')->with('success','Data Updated successfully');
    }

    public function Delete(Request $request)
    {
    	$this->faqService->delete($request->id);

        return redirect()->route('site-setting.faq')->with('success','Data Deleted successfully');
    }

    //ajax
    public function multipleFacultyWiseDepartment(Request $request)
    {
        if(!$request->faculty_id){
            $request->faculty_id=[];
        }
        $facultyWiseDepartment = Department::whereIn('faculty_id',$request->faculty_id)->get();
        return response()->json($facultyWiseDepartment);
    }

    //ajax
    public function multipleDepartmentWiseProgram(Request $request)
    {
        if(!$request->department_id){
            $request->department_id=[];
        }
        $departmentWiseProgram = Program::whereIn('department_id',$request->department_id)->get();
        return response()->json($departmentWiseProgram);
    }
}
