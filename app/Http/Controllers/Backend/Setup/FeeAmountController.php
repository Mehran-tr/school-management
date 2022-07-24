<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\FeeCategory;
use App\Models\FeeCategoryAmount;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class FeeAmountController extends Controller
{
    public function viewFeeAmount()
    {
        $data['allData'] = FeeCategoryAmount::all();
//        $data['allData'] = FeeCategoryAmount::select('fee_category_id')->groupBy('fee_category_id')->get();

        return view('backend.setup.fee_amount.view_fee_amount', $data);
    }

    public function feeAmountAdd()
    {
        $data['fee_categories'] = FeeCategory::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.fee_amount.add_fee_amount',$data);
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

    public function feeAmountEdit($fee_category_id)
    {
        $data['editData'] = FeeCategoryAmount::where('fee_category_id',$fee_category_id)->orderBy('class_id','ASC')->get();

        $data['fee_categories'] = FeeCategory::all();
        $data['classes'] = StudentClass::all();

        return view('backend.setup.fee_amount.edit_fee_amount',$data);
    }


    public function feeAmountUpdate(Request $request,$fee_category_id)
    {

        if ($request->class_id == null){
            $notification = [
                'message' => 'Sorry You do not select any class amount',
                'alert-type' => 'error'
            ];
            return redirect()->route("edit.fee.amount",$fee_category_id)->with($notification);
        }else{
            $countClass = count($request->class_id);
            FeeCategoryAmount::where('fee_category_id',$fee_category_id)->delete();
                for ($i = 0;$i < $countClass;$i++){
                    $fee_amount = new FeeCategoryAmount();
                    $fee_amount->fee_category_id = $request->fee_category_id;
                    $fee_amount->class_id = $request->class_id[$i];
                    $fee_amount->amount = $request->amount[$i];
                    $fee_amount->save();
                }
        }
            $notification = [
                'message' => 'Data Updated Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route("fee.amount.view")->with($notification);

    }

    public function feeAmountDetails($fee_category_id)
    {
        $data['detailsData'] = FeeCategoryAmount::where('fee_category_id',$fee_category_id)->orderBy('class_id','ASC')->get();

        return view('backend.setup.fee_amount.details_fee_amount',$data);
    }
}
