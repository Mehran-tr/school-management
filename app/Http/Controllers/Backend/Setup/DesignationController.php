<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function viewDesignation()
    {
        $data['allData'] = Designation::all();

        return view('backend.setup.designation.view_designation', $data);
    }

    public function designationAdd()
    {
        return view('backend.setup.designation.add_designation');
    }

    public function designationStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:designations,name',
        ]);
        $data = new Designation();
        $data->name = $request->name;
        $data->save();
        $notification = [
            'message' => 'Designation Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route("designation.view")->with($notification);
    }

    public function designationEdit($id)
    {
        $editData = Designation::find($id);
        return view('backend.setup.designation.edit_designation', compact('editData'));
    }

    public function designationUpdate(Request $request,$id)
    {
        $data = Designation::find($id);
        $validatedData = $request->validate([
            'name' => 'required|unique:designations,name,'.$data->id,
        ]);

        $data->name = $request->name;
        $data->save();
        $notification = [
            'message' => 'Data Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route("designation.view")->with($notification);
    }

    public function designationDelete($id)
    {
        $user = Designation::find($id);
        $user->delete();
        $notification = [
            'message' => 'Designation Deleted Successfully',
            'alert-type'=> 'info'
        ];
        return redirect()->route("designation.view")->with($notification);
    }
}
