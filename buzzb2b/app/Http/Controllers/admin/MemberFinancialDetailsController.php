<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member;
use Session;

class MemberFinancialDetailsController extends Controller
{
    public function ViewUserFinance($id){
    	$member = Member::where('id',$id)->first();
        $member->ex_purchase_comm_rate = $member->ex_purchase_comm_rate/100;
        $member->ex_sale_comm_rate = $member->ex_sale_comm_rate / 100;
        $member->ref_purchase_comm_rate = $member->ref_purchase_comm_rate / 100;
        $member->ref_sale_comm_rate = $member->ref_sale_comm_rate / 100;
        $member->sales_purchase_comm_rate = $member->sales_purchase_comm_rate / 100;
        $member->sales_sale_comm_rate = $member->sales_sale_comm_rate / 100;
        $member->giftcard_comm_rate = $member->giftcard_comm_rate / 100;


    	$val = $member->credit_limit/100;
        $member['credit_limit'] = number_format($val,2);

    	$exchangeid = session::get('EXCHANGE_ID');
    	$data['refsSelectionList'] = Member::where('exchange_id',$exchangeid)->pluck('name','id')->prepend('None','');
    	$data['salespersonSelectionList'] = Member::where('exchange_id',$exchangeid)->where('is_active_salesperson',1)->pluck('name','id')->prepend('None','');
    	
        return view('admin/members/financial_details',$data,compact('member'));
    }

    //updating finance details
    public function UpdateFinanceDetails(Request $request,$id){
        $this->validate($request,[
                'credit_limit'=>'numeric',
                'ref_purchase_comm_rate'=>'numeric',
                'ref_sale_comm_rate'=>'numeric',
                'sales_purchase_comm_rate'=>'numeric',
                'sales_sale_comm_rate'=>'numeric',
                'ex_purchase_comm_rate'=>'numeric',
                'ex_sale_comm_rate'=>'numeric',
                'giftcard_comm_rate'=>'numeric'

            ]);
        $input = $request->all();
        $member_details = Member::where('id',$id)->first();
        if($input['ref_member_id']=='' && $input['salesperson_member_id']==''){
            $member_details->credit_limit = $input['credit_limit']*100;

            $member_details->ref_member_id=0;
            $member_details->ref_purchase_comm_rate = 0;
            $member_details->ref_sale_comm_rate = 0;

            $member_details->salesperson_member_id = 0;
            $member_details->sales_purchase_comm_rate = 0;
            $member_details->sales_sale_comm_rate = 0;

            $member_details->ex_purchase_comm_rate = $input['ex_purchase_comm_rate'] * 100;
            $member_details->ex_sale_comm_rate = $input['ex_sale_comm_rate'] * 100;
            $member_details->accept_giftcards = $request['accept_giftcards'];
            $member_details->giftcard_comm_rate = $input['giftcard_comm_rate'] * 100;
            $member_details->save();    
            return back()->with('success','User finance details updated successfuilly');
        }

        /*if remember id blank*/
        if ($input['ref_member_id']=='') {
            $member_details->credit_limit = $input['credit_limit']*100;

            $member_details->ref_member_id=0;
            $member_details->ref_purchase_comm_rate = 0;
            $member_details->ref_sale_comm_rate = 0;

            $member_details->ex_purchase_comm_rate = $input['ex_purchase_comm_rate']*100;
            $member_details->salesperson_member_id = $input['salesperson_member_id'];
            $member_details->sales_purchase_comm_rate = $input['sales_purchase_comm_rate']*100;
            $member_details->sales_sale_comm_rate = $input['sales_sale_comm_rate']*100;
            $member_details->ex_sale_comm_rate = $input['ex_sale_comm_rate']*100;
            $member_details->accept_giftcards = $request['accept_giftcards'];
            $member_details->giftcard_comm_rate = $input['giftcard_comm_rate']*100;
            $member_details->save();    
            return back()->with('success','User finance details updated successfuilly');  
        }

        /*if sales person member id blank*/
        if($input['salesperson_member_id']==''){
            $member_details->credit_limit = $input['credit_limit']*100;

            $member_details->salesperson_member_id = 0;
            $member_details->sales_purchase_comm_rate = 0;
            $member_details->sales_sale_comm_rate = 0;

            $member_details->ex_purchase_comm_rate = $input['ex_purchase_comm_rate']*100;
            $member_details->ref_member_id = $input['ref_member_id'];
            $member_details->ref_purchase_comm_rate = $input['sales_purchase_comm_rate']*100;
            $member_details->ref_sale_comm_rate = $input['sales_sale_comm_rate']*100;
            $member_details->ex_sale_comm_rate = $input['ex_sale_comm_rate']*100;
            $member_details->accept_giftcards = $request['accept_giftcards'];
            $member_details->giftcard_comm_rate = $input['giftcard_comm_rate']*100;
            $member_details->save();    
            return back()->with('success','User finance details updated successfuilly');  
        }
        if(!empty($input['ref_member_id']) && !empty($input['salesperson_member_id']) ){
            $member_details->credit_limit = $input['credit_limit']*100;
            $member_details->ex_purchase_comm_rate = $input['ex_purchase_comm_rate']*100;
            $member_details->salesperson_member_id = $input['salesperson_member_id'];
            $member_details->sales_purchase_comm_rate = $input['sales_purchase_comm_rate']*100;
            $member_details->ref_member_id = $input['ref_member_id'];
            $member_details->ref_purchase_comm_rate = $input['ref_purchase_comm_rate']*100;
            $member_details->ref_sale_comm_rate = $input['ref_sale_comm_rate']*100;
            $member_details->sales_sale_comm_rate = $input['sales_sale_comm_rate']*100;
            $member_details->ex_sale_comm_rate = $input['ex_sale_comm_rate']*100;
            $member_details->accept_giftcards = $request['accept_giftcards'];
            $member_details->giftcard_comm_rate = $input['giftcard_comm_rate']*100;
            $member_details->save();    
            return back()->with('success','User finance details updated successfuilly');
        }
    	
    }
}
