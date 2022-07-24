<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\AssignSubject;
use App\Models\SchoolSubject;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class AssignSubjectController extends Controller
{
    public function viewAssignSubject()
    {
        $data['allData'] = AssignSubject::all();

        return view('backend.setup.assign_subject.view_assign_subject', $data);
    }

    public function addAssignSubject()
    {
        $data['subjects'] = SchoolSubject::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.assign_subject.add_assign_subject',$data);
    }

    public function feeAmountStore(Request $request)
    {

        $countClass = count($request->class_id);

        if ( $countClass!= null){
            for ($i = 0;$i < $countClass;$i++){
                $fee_amount = new FeeCategoryAmount();
                $fee_amount->fee_category_id = $request->fee_category_id;
                $fee_amount->class_id = $request->class_id[$i];
                $fee_amount->amount = $request->amount[$i];
                $fee_amount->save();
            }
        }
        $notification = [
            'message' => 'Fee Amount Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route("fee.amount.view")->with($notification);
    }

    public function assignSubjectStore(Request $request)
    {
        $subjectCount = count($request->subject_id);

        if ( $subjectCount!= null){
            for ($i = 0;$i < $subjectCount;$i++){
                $assign_subject = new AssignSubject();
                $assign_subject->class_id = $request->class_id;
                $assign_subject->subject_id = $request->subject_id[$i];
                $assign_subject->full_mark = $request->full_mark[$i];
                $assign_subject->pass_mark = $request->pass_mark[$i];
                $assign_subject->subjective_mark = $request->subjective_mark[$i];
                $assign_subject->save();
            }
        }
        $notification = [
            'message' => 'Subject Assign Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route("assign.subject.view")->with($notification);
    }

    public function editAssignSubject($class_id)
    {
        $data['editData'] = AssignSubject::where('class_id',$class_id)->orderBy('subject_id','ASC')->get();

        $data['subjects'] = SchoolSubject::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.assign_subject.edit_assign_subject',$data);
    }

    public function assignSubjectUpdate(Request $request,$class_id)
    {
        if ($request->subject_id == null){
            $notification = [
                'message' => 'Sorry You do not select any subject',
                'alert-type' => 'error'
            ];
            return redirect()->route("assign.subject.edit",$class_id)->with($notification);
        }else{
            $countClass = count($request->subject_id);
            AssignSubject::where('class_id',$class_id)->delete();
            for ($i = 0;$i < $countClass;$i++){
                $assign_subject = new AssignSubject();
                $assign_subject->class_id = $request->class_id;
                $assign_subject->subject_id = $request->subject_id[$i];
                $assign_subject->full_mark = $request->full_mark[$i];
                $assign_subject->pass_mark = $request->pass_mark[$i];
                $assign_subject->subjective_mark = $request->subjective_mark[$i];
                $assign_subject->save();
            }
        }
        $notification = [
            'message' => 'Data Updated Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route("assign.subject.view")->with($notification);
    }

    public function assignSubjectDetails($class_id)
    {
        $data['detailsData'] = AssignSubject::where('class_id',$class_id)->orderBy('subject_id','ASC')->get();

        return view('backend.setup.assign_subject.details_assign_subject',$data);
    }
}
