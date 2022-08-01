<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\StudentClass;
use App\Models\StudentYear;
use Illuminate\Http\Request;

class StudentRoleController extends Controller
{
    public function studentRoleView()
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();

        return view('backend.student.role_generate.role_generate_view',$data);
    }

    public function getStudents(Request $request)
    {
//        dd($request->class_id);
        $allData = AssignStudent::with(['student'])->where('year_id',$request->year_id)->where('class_id',$request->class_id)->get();

        return response()->json($allData);
    }

    public function studentRoleStore(Request $request)
    {
        $year_id = $request->year_id;
        $class_id = $request->class_id;

        if ($request->student_id != null){
            for ($i = 0;$i < count($request->student_id);$i++){
                AssignStudent::where('year_id' , $year_id)->where('class_id', $class_id)->where('student_id',$request->student_id[$i])->update(['role' => $request->roll[$i]]);
            }
        }else{
            $notification = [
                'message' => 'Sorry there are no student',
                'alert-type'=> 'error'
            ];
            return redirect()->back()->with($notification);
        }
        $notification = [
            'message' => 'Well done role generated Successfully',
            'alert-type'=> 'success'
        ];
        return redirect()->route('role.generate.view')->with($notification);
    }
}
