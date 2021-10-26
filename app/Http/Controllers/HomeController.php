<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClasssRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SigninRepository;
use Auth;
use Illuminate\Support\Facades\View;
use App\Repositories\MessageRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $classsRepo;
    protected $studentRepo;
    protected $signinRepo;
    //protected $global_test;
    public function __construct(ClasssRepository $classsRepo,StudentRepository $studentRepo,MessageRepository $messageRepo,SigninRepository $signinRepo)
    {
        $this->middleware(['auth','verified']);
        $this->classsRepo=$classsRepo;
        $this->studentRepo=$studentRepo;
        $this->signinRepo=$signinRepo;
        $this->messageRepo=$messageRepo;
        //$this->global_test="global_test123123";
        //View::share("global_test",$this->global_test);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }
    public function classs(){

        $school_classs=Auth::user()->school->classs;
        $school_batch=Auth::user()->school->batch;
        $all_student=$this->studentRepo->get_all_student();

        if(isset($_GET['success_msg'])){
            return redirect()->route('classs.classs')->with('success_msg', $_GET['success_msg']);
        }elseif(isset($_GET['error_msg'])){
            return redirect()->route('classs.classs')->with('error_msg', $_GET['error_msg']);
        }else{
            return view('classs.classs',['school_classs'=>$school_classs,'school_batch'=>$school_batch,'all_student'=>$all_student]);
        }
    }

    public function student($id){
        $this_classs=$this->classsRepo->find($id);
        $classs_student_db=json_decode($this->studentRepo->get_student($id),true);

        $price = array();
        foreach ($classs_student_db as $key => $row)
        {
            $price[$key] = $row['order'];
        }
        array_multisort($price, SORT_ASC, $classs_student_db);
        $classs_student=$classs_student_db;

        /*$classs_student=array();
        for( $i=1; $i<=count($classs_student_db); $i++){
            foreach($classs_student_db as $student){

                if($student->order==$i){
                    array_push($classs_student,$student);
                }

            }
        }*/
        if(isset($_GET['success_msg'])){
            return redirect()->route('classs.student',$id)->with('success_msg', $_GET['success_msg']);
        }elseif(isset($_GET['error_msg'])){
            return redirect()->route('classs.student',$id)->with('error_msg', $_GET['error_msg']);
        }else{
            return view('classs.student',['this_classs'=>$this_classs,'classs_student'=>$classs_student]);
        }
    }
    public function batch(){
        $school_classs=Auth::user()->school->classs;
        $school_batch=Auth::user()->school->batch;
        if(isset($_GET['success_msg'])){
            return redirect()->route('batch')->with('success_msg', $_GET['success_msg']);
        }elseif(isset($_GET['error_msg'])){
            return redirect()->route('batch')->with('error_msg', $_GET['error_msg']);
        }else{
            return view('batch',['school_classs'=>$school_classs,'school_batch'=>$school_batch]);
        }
    }
    public function basic(){
        return view('basic');
    }
    public function line(){
        $school=Auth::user()->school;
        return view('line',['school'=>$school]);
    }
    public function signin(){
        $today=date('Y-m-d');
        $school_classs=Auth::user()->school->classs;
        return view('signin.signin',['today'=>$today,'school_classs'=>$school_classs]);
    }
    public function signin_result($classs_id, $date){
        $classs=$this->classsRepo->find($classs_id);
        $classs_name=$classs->Classs_Name;
        $student=$classs->student;
        $signin=$this->signinRepo->get_signin($classs_id,$date);
        return view('signin.result',['signin'=>$signin,'date'=>$date,'student'=>$student,'classs_name'=>$classs_name]);
    }
    public function message(Request $request){
        //dd($request->all());
        $school_classs=Auth::user()->school->classs;
        //$school_batch=Auth::user()->school->batch;
        $all_student=$this->messageRepo->get_all_student();
        $all_message=$this->messageRepo->get_all_message();
        if(isset($_GET['success_msg'])){
            return redirect()->route('message')->with('success_msg', $_GET['success_msg']);
        }
        elseif(isset($_GET['error_msg'])){
            return redirect()->route('message')->with('error_msg', $_GET['error_msg']);
        }
        else{
            return view('message',['school_classs'=>$school_classs,'all_student'=>$all_student,'all_message'=>$all_message]);
        }

    }
    public function system(){
        return view('system');
    }

}
