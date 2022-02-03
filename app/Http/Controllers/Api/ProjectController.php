<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Faker\Guesser\Name;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function createProject(Request $request){
    $request->validate([
        "name"=>"required",
        "description"=>"required",
        "duration"=>"required"
    ]);
    $student_id=auth()->user()->id;
    $project= new Project();
    $project->student_id="$student_id";
    $project->name="$request->name";
    $project->description="$request->description";
    $project->duration="$request->duration";
    $project->save();
    return response()->json([
        "status" =>1,
        "message"=>"Project has been created"
    ]);
    }
    public function listProject(){

        $student_id = auth()->user()->id;

        $projects = Project::where("student_id", $student_id)->get();

        return response()->json([
            "status" => 1,
            "message" => "Projects",
            "data" => $projects
        ]);
    }
    public function singleProject($id){
        $student_id = auth()->user()->id;

        if(Project::where([
            "id" => $id,
            "student_id" => $student_id
        ])->exists()){

            $details = Project::where([
                "id" => $id,
                "student_id" => $student_id
            ])->first();

            return response()->json([
                "status" => 1,
                "message" => "Project detail",
                "data" => $details
            ]);
        }else{

            return response()->json([
                "status" => 0,
                "message" => "Project not found"
            ]);
        }
    }
    public function deleteProject($id){
        $student_id = auth()->user()->id;

        if(Project::where([
            "id" => $id,
            "student_id" => $student_id
        ])->exists()){
            $details = Project::where([
                "id" => $id,
                "student_id" => $student_id
            ])->delete();
            return response()->json([
                "status"=>1,
                "message"=>"Project has been deleted successfully"
            ]);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Project not found"
            ]);
        }
        }

}
