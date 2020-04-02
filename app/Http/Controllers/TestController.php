<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use App\Records;
class TestController extends Controller
{
    public function index()
    {
    	
    	$question=Question::get();
    	
    	
    	return view("index",["questions"=>$question]);
    }
    public function send(Request $request)
    {
    	$this->validate($request,[
    		"id"=>"required|numeric"
    	]);
    	if (Answer::where("uid",$request->input("id"))->where("is_correct",1)->count()>0) {
    		return json_encode(["msg"=>"correct"]);
    	}else{
    		return json_encode(["msg"=>"incorrect"]);

    	}
    }
    public function saverecord(Request $request)
    {
    	$this->validate($request,[
    		"grade"=>"required|numeric",
    		"name"=>"required|string",
    	]);
    	$rec=new Records;
    	$rec->name=$request->input("name");
    	$rec->grade=$request->input("grade");
    	$rec->save();
    	return 1;
    	
    }
}
