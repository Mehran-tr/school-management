<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\StudentGroup;
use Illuminate\Http\Request;

class StudentGroupController extends Controller
{
    public function viewGroup()
    {
        $data['allData'] = StudentGroup::all();

        return view('backend.setup.student_group.view_group', $data);
    }

    public function studentGroupAdd()
    {
        return view('backend.setup.student_group.add_group');
    }

    public function studentGroupStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:student_groups,name',
        ]);
        $data = new StudentGroup();
        $data->name = $request->name;
        $data->save();
        $notification = [
            'message' => 'Student Group Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route("student.group.view")->with($notification);
    }

    public function studentGroupEdit($id)
    {
        $editData = StudentGroup::find($id);
        return view('backend.setup.student_group.edit_group', compact('editData'));
    }

    public function studentGroupUpdate(Request $request,$id)
    {
        $data = StudentGroup::find($id);
        $validatedData = $request->validate([
            'name' => 'required|unique:student_groups,name,'.$data->id,
        ]);

        $data->name = $request->name;
        $data->save();
        $notification = [
            'message' => 'Student Group Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route("student.group.view")->with($notification);
    }

    public function studentGroupDelete($id)
    {
        $user = StudentGroup::find($id);
        $user->delete();
        $notification = [
            'message' => 'Student Group Deleted Successfully',
            'alert-type'=> 'info'
        ];
        return redirect()->route("student.group.view")->with($notification);
    }
}
