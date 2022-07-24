<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\StudentYear;
use Illuminate\Http\Request;

class StudentYearController extends Controller
{
    public function viewYear()
    {
        $data['allData'] = StudentYear::all();

        return view('backend.setup.student_year.view_year', $data);
    }

    public function studentYearAdd()
    {
        return view('backend.setup.student_year.add_year');
    }

    public function studentYearStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:student_Years,name',
        ]);
        $data = new StudentYear();
        $data->name = $request->name;
        $data->save();
        $notification = [
            'message' => 'Student Year Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route("student.year.view")->with($notification);
    }

    public function studentYearEdit($id)
    {
        $editData = StudentYear::find($id);
        return view('backend.setup.student_year.edit_year', compact('editData'));
    }

    public function studentYearUpdate(Request $request,$id)
    {
        $data = StudentYear::find($id);
        $validatedData = $request->validate([
            'name' => 'required|unique:student_years,name,'.$data->id,
        ]);

        $data->name = $request->name;
        $data->save();
        $notification = [
            'message' => 'Student Years Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route("student.year.view")->with($notification);
    }

    public function studentYearDelete($id)
    {
        $user = StudentYear::find($id);
        $user->delete();
        $notification = [
            'message' => 'Student Year Deleted Successfully',
            'alert-type'=> 'info'
        ];
        return redirect()->route("student.year.view")->with($notification);
    }
}
