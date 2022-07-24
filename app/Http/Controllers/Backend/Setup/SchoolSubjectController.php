<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\SchoolSubject;
use Illuminate\Http\Request;

class SchoolSubjectController extends Controller
{
    public function viewSchoolSubject()
    {
        $data['allData'] = SchoolSubject::all();

        return view('backend.setup.school_subject.view_school_subject', $data);
    }

    public function schoolSubjectAdd()
    {
        return view('backend.setup.school_subject.add_school_subject');
    }

    public function schoolSubjectStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:school_subjects,name',
        ]);
        $data = new SchoolSubject();
        $data->name = $request->name;
        $data->save();
        $notification = [
            'message' => 'School Subject Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route("school.subject.view")->with($notification);
    }

    public function schoolSubjectEdit($id)
    {
        $editData = SchoolSubject::find($id);
        return view('backend.setup.school_subject.edit_school_subject', compact('editData'));
    }

    public function schoolSubjectUpdate(Request $request,$id)
    {
        $data = SchoolSubject::find($id);
        $validatedData = $request->validate([
            'name' => 'required|unique:school_subjects,name,'.$data->id,
        ]);

        $data->name = $request->name;
        $data->save();
        $notification = [
            'message' => 'School Subject Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route("school.subject.view")->with($notification);
    }

    public function schoolSubjectDelete($id)
    {
        $user = SchoolSubject::find($id);
        $user->delete();
        $notification = [
            'message' => 'School Subject Deleted Successfully',
            'alert-type'=> 'info'
        ];
        return redirect()->route("school.subject.view")->with($notification);
    }
}
