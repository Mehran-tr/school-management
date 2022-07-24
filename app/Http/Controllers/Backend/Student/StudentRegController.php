<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\DiscountStudent;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use App\Models\StudentYear;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class StudentRegController extends Controller
{
    public function studentRegView()
    {
        $data['years'] = StudentYear::all();
        $data['year_id'] = StudentYear::orderBy('id','desc')->first()->id;
        $data['class_id'] = StudentClass::orderBy('id','desc')->first()->id;
        $data['classes'] = StudentClass::all();
        $data['allData'] = AssignStudent::where('year_id',$data['year_id'])->where('class_id',$data['class_id'])->get();
        return view('backend.student.student_registration.student_view', $data);
    }


    public function studentClassYearWise(Request $request)
    {
        $data['years'] = StudentYear::all();
        $data['year_id'] = $request->year_id;
        $data['class_id'] =  $request->class_id;
        $data['classes'] = StudentClass::all();
        $data['allData'] = AssignStudent::where('year_id',$request->year_id)->where('class_id',$request->class_id)->get();
        return view('backend.student.student_registration.student_view', $data);
    }

    public function studentRegistrationAdd()
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['groups'] = StudentGroup::all();
        $data['shifts'] = StudentShift::all();

        return view('backend.student.student_registration.student_add',$data);
    }

    public function studentRegStore(Request $request)
    {
        DB::transaction(function () use($request){
            $checkYear = StudentYear::find($request->year_id)->name;
            $student = User::where('usertype','Student')->orderBy('id','DESC')->first();

            if ($student == null){
                $firstReg = 0;
                $studentId = $firstReg + 1;
                if ($studentId < 10){
                    $id_no = '000'.$studentId;
                }elseif ($studentId < 100){
                    $id_no = '00'.$studentId;
                }else{
                    $id_no = '0'.$studentId;
                }
            }else{
                $student = User::where('userType','Student')->orderBy('id','DESC')->first()->id;
                $studentId = $student + 1;
                if ($studentId < 10){
                    $id_no = '000'.$studentId;
                }elseif($studentId < 100){
                    $id_no = '00'.$studentId;
                }else{
                    $id_no = '0'.$studentId;
                }
            }

            $final_id_no = $checkYear.$id_no;
            $user = new User();
            $code = rand(0000,9999);
            $user->id_no = $final_id_no;
            $user->password = bcrypt($code);
            $user->usertype = 'Student';
            $user->code = $code;
            $user->name = $request->name;
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->religion = $request->religion;
            $user->dob = date('Y-m-d',strtotime($request->dob));

            if ($request->file('image')){
                $file = $request->file('image');
                $filename = date('YdmHi').$file->getClientOriginalName();
                $file->move(public_path('upload/student_images'),$filename);
                $user['image'] =  $filename;
            }

            $user->save();

            $assign_student = new AssignStudent();
            $assign_student->student_id = $user->id;
            $assign_student->year_id = $request->year_id;
            $assign_student->class_id = $request->class_id;
            $assign_student->group_id = $request->group_id;
            $assign_student->shift_id = $request->shift_id;
            $assign_student->save();


            $discount_student = new DiscountStudent();
            $discount_student->assign_student_id = $assign_student->id;
            $discount_student->fee_category_id = '1';
            $discount_student->discount = $request->discount;
            $discount_student->save();


        });
            $notification = [
                'message' => 'Student Registration Inserted Successfully',
                'alert-type'=> 'success'
            ];
            return redirect()->route('student.registration.view')->with($notification);
    }

    public function studentRegEdit($student_id)
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['groups'] = StudentGroup::all();
        $data['shifts'] = StudentShift::all();

        $data['editData'] = AssignStudent::with(['student','discount'])->where('student_id',$student_id)->first();

//        dd( $data['editData']->toArray() );
        return view('backend.student.student_registration.student_edit',$data);
    }

    public function studentRegUpdate(Request $request,$student_id)
    {
        DB::transaction(function () use($request ,$student_id){

            $user =  User::where('id',$student_id)->first();
            $user->name = $request->name;
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->religion = $request->religion;
            $user->dob = date('Y-m-d',strtotime($request->dob));

            if ($request->file('image')){
                $file = $request->file('image');
                @unlink(public_path('upload/student_images'.$user->image));
                $filename = date('YdmHi').$file->getClientOriginalName();
                $file->move(public_path('upload/student_images'),$filename);
                $user['image'] =  $filename;
            }

            $user->save();

            $assign_student = AssignStudent::where('id',$request->id)->where('student_id',$student_id)->first();
            $assign_student->year_id = $request->year_id;
            $assign_student->class_id = $request->class_id;
            $assign_student->group_id = $request->group_id;
            $assign_student->shift_id = $request->shift_id;
            $assign_student->save();


            $discount_student =  DiscountStudent::where('assign_student_id',$request->id)->first();
            $discount_student->discount = $request->discount;
            $discount_student->save();


        });
        $notification = [
            'message' => 'Student Registration Updated Successfully',
            'alert-type'=> 'success'
        ];
        return redirect()->route('student.registration.view')->with($notification);
    }

    public function studentRegPromotion($student_id)
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['groups'] = StudentGroup::all();
        $data['shifts'] = StudentShift::all();

        $data['editData'] = AssignStudent::with(['student','discount'])->where('student_id',$student_id)->first();

        return view('backend.student.student_registration.student_promotion',$data);
    }

    public function studentUpdatePromotion(Request $request,$student_id)
    {
        DB::transaction(function () use($request ,$student_id){

            $user =  User::where('id',$student_id)->first();
            $user->name = $request->name;
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->religion = $request->religion;
            $user->dob = date('Y-m-d',strtotime($request->dob));

            if ($request->file('image')){
                $file = $request->file('image');
                @unlink(public_path('upload/student_images'.$user->image));
                $filename = date('YdmHi').$file->getClientOriginalName();
                $file->move(public_path('upload/student_images'),$filename);
                $user['image'] =  $filename;
            }

            $user->save();

            $assign_student = new AssignStudent();
            $assign_student->student_id = $student_id;
            $assign_student->year_id = $request->year_id;
            $assign_student->class_id = $request->class_id;
            $assign_student->group_id = $request->group_id;
            $assign_student->shift_id = $request->shift_id;
            $assign_student->save();


            $discount_student = new DiscountStudent();
            $discount_student->assign_student_id = $assign_student->id;
            $discount_student->fee_category_id = '1';
            $discount_student->discount = $request->discount;
            $discount_student->save();


        });
        $notification = [
            'message' => 'Student Promotion Updated Successfully',
            'alert-type'=> 'success'
        ];
        return redirect()->route('student.registration.view')->with($notification);
    }

    public function studentRegDetails($student_id)
    {
        $data['details'] = AssignStudent::with(['student','discount'])->where('student_id',$student_id)->first();
        $pdf = PDF::loadView('backend.student.student_reg.student_details_pdf', $data);
        return $pdf->stream('document.pdf');
    }


    function generate_pdf() {
        $data = [
            'foo' => 'bar'
        ];
        $pdf = PDF::loadView('pdf.document', $data);
        return $pdf->stream('document.pdf');
    }
}
