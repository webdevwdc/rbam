<?php

namespace App\Http\Controllers\User_Member\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth,\Session;
use App\Address;
use App\LedgerDetails, App\State, App\Member, App\PaymentProfile, App\PaymentAddress, App\PaymentAddressProfile, App\CbaTransaction, App\TransactionDetails, App\MemberUser;
use \Redirect;

class BillingController extends Controller
{
    public function ViewBill(){
        $referral = LedgerDetails::where('member_id',Auth::user()->id)
               ->where('account_code',4070)->get()->sum('amount');
        $referral = number_format($referral/100,2);

        $modal= new LedgerDetails();
        $cbabalance = $modal->GetMemberBarterBalance();
    	return view('user_member.member.billing.billing',compact('referral','cbabalance'));
    }

    /*load cba*/
    public function LoadCba(){
	  
       $member_id = Session::get('MEMBER_ID'); 
	   
	   $data['stateSelectionList'] 	= State::pluck('name','id')->prepend('Select','');
	   $paymentprofile 		= PaymentProfile::where('member_user_id', $member_id)->get();
       
       //dd($paymentprofile);

	   $data['cardlist'] = array();
	   foreach($paymentprofile as $pf){
		$data['cardlist'][$pf->id] = $pf->first_name.' '.$pf->last_name.' '.$this->ccMasking(\Crypt::decryptString($pf->credit_card)).' EXP:'.$pf->expiry_month.'/'.$pf->expiry_year;
		
	   }

        return view('user_member.member.billing.load-cba', $data);
	
    }

    public function PaymentProfile()
    {
        $data = array();
       $member_id = Session::get('MEMBER_ID');
       $data['lists'] = PaymentProfile::where('member_user_id',$member_id)->get();
         //print_r($data['lists']); die();
        return view('user_member.member.billing.profile-list', $data);
    }

    public function AddPaymentProfile()
    {
        $data = array();
       $data['stateSelectionList']      = State::pluck('name','id')->prepend('Select','');
       $data['address']                 = PaymentAddress::where('member_user_id', Auth::user()->id)->get();

        return view('user_member.member.billing.add', $data);
    }

    public function storePaymentProfile(Request $request){
        
	$member_id = Session::get('MEMBER_ID');
	
        $pprofile = new PaymentProfile();
        $pprofile->member_user_id   = $member_id;//Auth::user()->id;
        $pprofile->member_user_type = 'Member';
        $pprofile->credit_card  = \Crypt::encryptString($request->card_number);
        $pprofile->cvv          = $request->cvv_code;
        $pprofile->expiry_month = $request->expiration_month;
        $pprofile->expiry_year  = $request->expiration_year;
        $pprofile->first_name   = $request->first_name;
        $pprofile->last_name    = $request->last_name;
        $pprofile->save();

        $payAddrProf = new PaymentAddressProfile();
        
        if($request->billing_address=='create_new'){
	    
	    $member_id = Session::get('MEMBER_ID');
            $OldPayAddress = PaymentAddress::where('member_user_id', Auth::user()->id)->get();
            
            $address = new PaymentAddress();
            $address->member_user_id    = $member_id;//Auth::user()->id;
            $address->member_user_type  = 'Member';
            $address->address1          = $request->address1;
            $address->address2          = $request->address2;
            $address->city              = $request->city;
            $address->state_id          = $request->state_id;
            $address->zip               = $request->zip;
            
            if(count($OldPayAddress)){
                $address->is_default    = 'No';
            }else{
                $address->is_default    = 'Yes';
            }
            if($request->make_default){
                PaymentAddress::where('member_user_id', Auth::user()->id)->update(['is_default' => 'No']);
                $address->is_default    = 'Yes';
            }
            
            $address->save();
            $payAddrProf->payment_address_id = $address->id;
        }else{
            $payAddrProf->payment_address_id = $request->billing_address;
        }       
        
        $payAddrProf->payment_profile_id = $pprofile->id;       
        $payAddrProf->save();
        
        return back()->with('success','Payment profile created successfully');
    }

    public function ccMasking($number, $maskingCharacter = 'X') {
        return str_repeat($maskingCharacter, strlen($number) - 4) . substr($number, -4);
    }

    public function LoadCbaRedirect(Request $request){
        $data = array();
        $data['record'] = PaymentProfile::find($request->profile);
        $data['deposit_amount'] = $request->deposit_amount;
        $data['profile_id'] = $request->profile;
        
        // dd($data);

        return view('user_member.member.billing.load-cba-redirect', $data);
    }

    public function LoadCbaInsert(Request $request){
        $profile = PaymentProfile::find($request->profile_id);
        $token    = $request->input( 'token' );
        $total    = $request->deposit_amount;
        $key      = 'T_S_22fc3a33-fd5c-415d-bad7-cac5e94e99f6';
        $worldPay = new \Alvee\WorldPay\lib\Worldpay($key);
        
        $billing_address = array(
            'address1'    => $profile->paymentAddress[0]->address1,
            'address2'    => $profile->paymentAddress[0]->address2,
            'postalCode'  => $profile->paymentAddress[0]->zip,
            'city'        => $profile->paymentAddress[0]->city,
            'state'       => $profile->paymentAddress[0]->state->abbrev,
            'countryCode' => 'GB',
        );
     
        try {
            $response = $worldPay->createOrder(array(
               'token'             => $token,
               'amount'            => (int)($total . "00"),
               'currencyCode'      => 'GBP',
               'name'              => $profile->first_name.' '.$profile->last_name,
               'billingAddress'    => $billing_address,
               'orderDescription'  => 'Order description',
               'customerOrderCode' => $request->profile_id
            ));
            
            if ($response['paymentStatus'] === 'SUCCESS') {
               $worldpayOrderCode = $response['orderCode'];
               
              //echo "<pre>";
              //print_r($response);
              
              if($response['paymentStatus'] == 'SUCCESS'){
                $cba                        = new CbaTransaction();
                $cba->payment_profile_id    = $response['customerOrderCode'];
                $cba->amount                = $response['amount'];
                $cba->orderCode             = $response['orderCode'];
                $cba->token                 = $response['token'];
                $cba->response_code         = json_encode($response);
                $cba->save();


                /*entry in transactuion tabel*/
                $exchangeid = Session::get('EXCHANGE_ID');
		$uID = \Auth::user()->id;

                $memberUserData = MemberUser::where('user_id', $uID)->first();

                //$memberID = $memberUserData->member_id;
		$memberID = Session::get('MEMBER_ID');

                $transactions = TransactionDetails::create([
                   'type_id'=>21,
                   'customer_exchange_id'=>$exchangeid,
                   'customer_member_id'=> $memberID,
                   'customer_user_id'=>$uID,
                   'merchant_exchange_id'=>$exchangeid,
                ]);
                if($transactions){
                    /*two entry will be in ledger table*/
                    LedgerDetails::create([
                    'transaction_id'=>$transactions->id,
                    'amount'=>$response['amount'],
                    'account_code'=>3010,
                    'member_id'=>$memberID,
                    'exchange_id'=>$exchangeid,
                    ]);

                    LedgerDetails::create([
                    'transaction_id'=>$transactions->id,
                    'amount'=>$response['amount'],
                    'account_code'=>4120,
                    'member_id'=>0,
                    'exchange_id'=>$exchangeid,
                    ]);
                }
                /*entry in transactuion tabel*/
              }
              
              return Redirect::route('load-cba')->with('success','CBA Load Successfully');
             // LoadCbaTransaction::
              
              
              
            } else {
               // The card has been declined
               throw new \Alvee\WorldPay\lib\WorldpayException(print_r($response, true));
            }
        } catch (\Alvee\WorldPay\lib\WorldpayException $e) {
            echo 'Error code: ' . $e->getCustomCode() . '
                HTTP status code:' . $e->getHttpStatusCode() . '
                Error description: ' . $e->getDescription() . '
                Error message: ' . $e->getMessage();
     
            // The card has been declined
        } catch (\Exception $e) {
            // The card has been declined
            echo 'Error message: ' . $e->getMessage();
        }
    } 
}
