<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\User, App\Sitesetting, App\Role, App\Address, App\State, App\Exchange, App\Phone, App\MemberUser;
use \Session, \Validator,\Redirect, \Hash, \Auth, \Image;
use App\Mail\AdminPasswordRecovery;

class DashboardController extends Controller
{
    
    public function index(){
        
         
        $exchange_id    = session::get('EXCHANGE_ID');
        $member_id      = session::get('MEMBER_ID');
        $user_id        = session::get('ADMIN_ACCESS_ID');
        
        if((Session::get('ADMIN_ACCESS_ROLE') == 'agent'))
        {
            return redirect::route('agent_dashboard');
            exit();
        }
        
        $data       = array();
        
        $data['customers'] = array();
        
        $data['countrymaster'] = array();
        $data['province'] = array();
        $data['destination'] = array();
        
        $data['active_customers'] = array();
        
        $data['inactive_customers'] = array();
        
        $data['active_golf_cources'] = array();
        
        $data['inactive_golf_cources'] = array();
        //echo json_encode($data);die;
        
        return view('admin.dashboard.index',$data);
    }
    
    public function login(Request $request){
        $data = array();
        
        if(Auth::guard('admin')->check()){
            return redirect::route('admin_dashboard');
        }
        
        if( $request->isMethod('post') ){
            
            $data['email']          = '';
            $data['password']       = '';            
            
            $email                  = $request->get('email');
            $password               = $request->get('password');
            $checkAdminExists       = User::where('email', $email)->get();
            
            if( count($checkAdminExists) > 0 ){
                
                    $auth = auth()->guard('admin');
                    $userdata = array('email' => $email, 'password' => $password);
                    if($auth->attempt($userdata)){
                        $user_id            = $auth->authenticate()->id;
                        $user_first_name    = $auth->authenticate()->first_name;
                        $user_last_name     = $auth->authenticate()->last_name;
                        $user_name          = $user_first_name.' '.$user_last_name;
                        $user_email         = $auth->authenticate()->email;
                        $role_name          = $auth->authenticate()->roles[0]->name;

                        Session::put('ADMIN_ACCESS_ID', $user_id);
                        Session::put('ADMIN_ACCESS_NAME', $user_name);
                        Session::put('ADMIN_ACCESS_EMAIL', $user_email);
                        Session::put('ADMIN_ACCESS_ROLE', $role_name);
                        
                        $exchange   = Exchange::select('id', 'domain', 'name', 'city_name')->first();
                        $member     = MemberUser::where('user_id', $user_id)->first();

                        Session::put('EXCHANGE_ID', $exchange->id);
                        Session::put('MEMBER_ID', $member->id);
                        Session::put('EXCHANGE_CITY_NAME', $exchange->city_name);
                        
                        if($role_name == 'admin')
                        {
                            return redirect::route('admin_dashboard');
                        }
                        else
                        {
                            //return redirect::route('agent_dashboard');
                            return view('admin.dashboard.login',$data)->with('error','Invalid email address or/and password provided.');

                        }
                        
                    }else{
                        //die('103');
                        return redirect::back()->with('error', 'Invalid email address or/and password provided.');
                    }
                //}else{
                //    return redirect::back()->with('error', 'You have no permission to access this panel.');
                //}
            }else{
                return redirect::back()->with('error', 'Invalid email address or/and password provided.');
            }
        }
        return view('admin.dashboard.login',$data);
    }
    
    
    
    public function detail(){
        $data['details'] = User::find(Auth::guard('admin')->user()->id);
        return view('admin.dashboard.detail',$data);
    }
    
    public function detail_update(Request $request){
        $validator   = Validator::make($request->all(),[
                    'first_name'=>'required',
                    'last_name'=>'required'
                   ]);
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            $profile                      = User::find(Auth::guard('admin')->user()->id);
            $profile->first_name          = $request->first_name;
            $profile->last_name           = $request->last_name;
            $profile->save();
            return Redirect::back()->with('success','Profile updated successfully');            
        }
 
    }
    
    
    public function address()
    {
        $data['lists'] = Address::where('addressable_id', '=', Auth::guard('admin')->user()->id)->paginate(20);
        return view('admin.address.list', $data);
    }
    
    public function create_address()
    {
        $model = new State();
        $state= $model->AllCity();
        return view('admin.address.add',compact('state'));
    }
    
    public function store_address(Request $request)
    {
               $this->validate($request,[
                        'address1'  =>'required',
                        'city'      =>'required',
                        'state'     =>'required',
                        'zip'       =>'required'
                       ]);
        
       

            /***** Fetch Lat & Lng from given address starts here *****/
            
            $obj_state = State::select('name')->where('id', '=', $request->state)->get();
            $inputed_address = $request->address1.' '.$request->address2.' '.$request->city.' '.$obj_state[0]->name.' '.$request->zip;
            //echo "<pre>"; print_r($inputed_address); die();
            //$arr_cordinate = generate_coordinate($inputed_address);

            
            /***** Fetch Lat & Lng from given address ends here *****/
            
            if($request->is_default == 'Yes')
            {
                Address::where('addressable_id', '=', Auth::guard('admin')->user()->id)
                       ->where('addressable_type', '=', 'User')->update(array('is_default' => 'No'));
            }
    
            $address                = new Address();
            $address->addressable_id       = Auth::guard('admin')->user()->id;
            $address->addressable_type     = 'Member';            
            $address->address1      = $request->address1;
            $address->address2      = $request->address2;
            $address->city          = $request->city;
            $address->state_id      = $request->state;
            $address->zip           = $request->zip;
            $address->lat           = 0.00;//$arr_cordinate['lat'];
            $address->lng           = 0.00;//$arr_cordinate['lng'];
            $address->is_default    = $request->is_default;
            $address->save();
            
            return Redirect::back()->with('success','Address added successfully');            
        
    }
    
    public function edit_address($id)
    {
        $data['details']    = Address::find($id);
        $model = new State();
        $data['state']      = $model->AllCity();
        return view('admin.address.edit',$data);
    }
    
    public function update_address(Request $request, $id)
    {
        $validator   = Validator::make($request->all(), [
                        'address1'  =>'required',
                        'city'      =>'required',
                        'state'     =>'required',
                        'zip'       =>'required'
                       ]);
        
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            
            /***** Fetch Lat & Lng from given address starts here *****/
            
            $obj_state = State::select('name')->where('id', '=', $request->state)->get();
            $inputed_address = $request->address1.' '.$request->address2.' '.$request->city.' '.$obj_state[0]->name.' '.$request->zip;
            
            //$arr_cordinate = generate_coordinate($inputed_address);
            
            //echo "<pre>";print_r($arr_cordinate);exit();
            
            /***** Fetch Lat & Lng from given address ends here *****/
            
            if($request->is_default == 'Yes')
            {
                Address::where('id', '!=', $id)->update(array('is_default' => 'No'));
            }
            
            $address                    = Address::find($id);
            $address->addressable_id    = Auth::guard('admin')->user()->id;
            $address->addressable_type  = 'User';
            $address->address1          = $request->address1;
            $address->address2          = $request->address2;
            $address->city              = $request->city;
            $address->state_id          = $request->state;
            $address->zip               = $request->zip;
            $address->lat               = 0.00;//$arr_cordinate['lat'];
            $address->lng               = 0.00;//$arr_cordinate['lng'];
            $address->is_default        = $request->is_default;
            $address->save();
            
            return Redirect::back()->with('success','Address updated successfully');
            
        }
    }
    
    public function delete_address($id){
        $address = Address::find($id);
        if (!empty($address)){
            if ($address->is_default == 'Yes'){
                Session::flash('errmsg', "Default address can not be deleted");
                return Redirect::route('admin_manage_address');
            }
            $address->delete();
            Session::flash('succmsg', "Address deleted successfully");            
        }
        return Redirect::route('admin_manage_address');
    }
    
    public function change_default_address($id){
        $user_id             = Auth::guard('admin')->user()->id;
        $address             = Address::find($id);
        $address->is_default = 'Yes';
        $address->save();
        Address::where('addressable_id',$user_id)->where('addressable_type', 'User')->where('id','!=',$id)->update(array('is_default' => 'No'));
        return Redirect::route('admin_manage_address');
    }

    public function phone()
    {
        $keyword = Input::get('keyword','');
        
        if ($keyword == ''){
            $phones = Phone::where('phoneable_id', '=', Auth::guard('admin')->user()->id)->where('phoneable_type', 'User')->paginate(20);          
        } else {
            $phones = Phone::where('phoneable_id', '=', Auth::guard('admin')->user()->id)->where('phoneable_type', 'User')->where('number','like','%'.$keyword.'%')->paginate(20); 
        }
        foreach ($phones as $phone){
           $phone->phone_type = $phone->phoneType->name; 
        }
        return view('admin.phone.list', ['phones'=>$phones,'keyword'=>$keyword]);
    }
    
    public function create_phone()
    {
        $model = new State();
        $data['state'] = $model->AllCity();
        return view('admin.phone.add', $data);
    }
    
    public function store_phone(Request $request)
    {   
        $count = Phone::where('phoneable_id', '=', Auth::guard('admin')->user()->id)->count();
           $this->validate($request,[
            'phone_number'  =>'required|integer|digits:10',
             'phone_type'    =>'required',
            ]);
            
            $phone                    = new Phone();
            $phone->phoneable_id      = Auth::guard('admin')->user()->id;
            $phone->phoneable_type    = 'User';
            $phone->phone_type_id     = $request->phone_type;
            $phone->number            = $request->phone_number;
            $phone->is_primary        = $count == 0 ? 'Yes' : 'No';
            $phone->save();
            return back()->with('success','Phone Saved successfully');
    }
    
    public function edit_phone($id)
    {
        $data['details']    = Phone::find($id);
        return view('admin.phone.edit',$data);
    }
    
    public function update_phone(Request $request, $id)
    {
        $phone       = Phone::find($id);
        $validator   = Validator::make($request->all(), [
                            'phone_number'  =>'required|numeric|digits:10',
                            'phone_type'    =>'required',
                           ]);
        
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            
            $phone->phone_type_id   = $request->phone_type;
            $phone->number          = $request->phone_number;
            $phone->save();
            
            return Redirect::back()->with('success','Phone Number updated successfully');            
        }
    }
    
    public function delete_phone($id){
        $phone = Phone::find($id);
        if (!empty($phone)){
            if ($phone->is_primary == 'Yes'){
                Session::flash('errmsg', "Default phone can not be deleted");
                return Redirect::route('admin_manage_phone');
            }
            $phone->delete();
            Session::flash('succmsg', "Phone number deleted successfully");
        }
        return Redirect::route('admin_manage_phone');
    }
    
    public function change_default_phone($id){
        $user_id           = Auth::guard('admin')->user()->id;
        $phone             = Phone::find($id);
        $phone->is_primary = 'Yes';
        $phone->save();
        Phone::where('phoneable_id',$user_id)->where('phoneable_type', 'User')->where('id','!=',$id)->update(array('is_primary' => 'No'));
        return Redirect::route('admin_manage_phone');
    }
    
    public function profile_photo(){
        return view('admin.dashboard.profile_photo');        
    }
    
    public function profile_photo_update(){
        $user_id           = Auth::guard('admin')->user()->id;
        $user              = User::find($user_id);
        $file              = $_FILES['profile_picture']['name'];
        
        if (empty($file)){
            Session::flash('errmsg','Please choose an image');
            return Redirect::back();
        }
        $ext = pathinfo($file, PATHINFO_EXTENSION); 
        if (!in_array($ext,array('jpg','jpeg','png'))){
            Session::flash('errmsg','Image extension should be .jpg,.jpeg or .png');
            return Redirect::back();            
        }
        if ($_FILES['profile_picture']['size']> 3145728){
            Session::flash('errmsg','Image must be less than or equal to 3MB');
            return Redirect::back();            
        }
        
        $filename = $user_id.'_'.$file;
        $upload = move_uploaded_file($_FILES['profile_picture']['tmp_name'],'jacopo_admin/images/'.$filename);
        if ($upload){
            if (!empty($user->image) && file_exists('jacopo_admin/images/'.$user->image) && $filename!=$user->image){
                unlink('jacopo_admin/images/'.$user->image);                
            }
            
            list($width, $height) = getimagesize(public_path().'/jacopo_admin/images/'.$filename);
            $src = imagecreatefromjpeg(public_path().'/jacopo_admin/images/'.$filename);
            $dst = imagecreatetruecolor(100, 100);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, 100, 100, $width, $height);
            
            $user->image = $filename;
            $user->save();
            Session::flash('succmsg','Image uploaded successfully');
            return Redirect::back(); 
        } else {
            Session::flash('errmsg','Error in image upload');
            return Redirect::back();             
        }
    }
    
    public function password(){
        $data['details'] = User::find(Auth::guard('admin')->user()->id);
        //echo json_encode($data);die;

        return view('admin.dashboard.profile',$data);
    }
    
    public function password_update(Request $request){
      
       $this->validate($request,[
        'old_password'      => 'required|min:6',
        'new_password'      => 'required',
        'confirm_password'  => 'required',
       ]);
        $input = $request->all();
        if($input['new_password'] !=$input['confirm_password']){

           return redirect::back()->with("error","New Password and confirm New password not matched");
        }else{
            $old_password       = $request->get('old_password');
            $new_password       = $request->get('new_password');
            $confirm_password   = $request->get('confirm_password');
            
            $userdata = array('email' => Session::get('ADMIN_ACCESS_EMAIL'), 'password' => $old_password);
            $auth = auth()->guard('admin');
            if($v = $auth->attempt($userdata))
            {
                $profile = User::find(Auth::guard('admin')->user()->id);
                $profile->password = $new_password;
                $profile->save();
                return redirect::back()->with('success','Password updated successfully');
            }
            else
            {
                return redirect::back()->with("error","Old password doesn't matched");
            }   
        }
 
    }
    
    public function admin_forgot_password(){
        $data = array();
        return view('admin.dashboard.forgot_password',$data);
    }
    public function admin_forgot_password_action(Request $request){
        $email  = $request->email;
        $profile    = User::where('email',$email)->first();
        if(count($profile)>0){
            $new_pass = str_random(10);
            
            $site_from = Sitesetting::where('sitesettings_lebel','site_from_email')->first();
            $site_name = Sitesetting::where('sitesettings_lebel','site_name')->first();
            $data['from_email']     = $site_from->sitesettings_value;
            $data['form_name']      = $site_name->sitesettings_value ;
            $data['to_email']       = $email;
            $data['to_name']        = $profile->first_name;
            $data['password']       = $new_pass;
            
            \Mail::to($data['to_email'])->send(new AdminPasswordRecovery($data));
            
            $profile->password = $new_pass ;
            $profile->save();
            return Redirect::route('admin_forgot_password')->with('success','Password is sent to the email address. Please check in your inbox');
        }else{
            return Redirect::route('admin_forgot_password')->with('error','User name is not exists');
        }
    }
    
    public function logout(){
        \Auth::guard('admin')->logout();
        Session::flush();
        return Redirect::route('admin_login')->with('success', 'You have logged out successfully.');
    }
    
    public function switch_exchange(){
        
        $data['exchange_list'] = Exchange::select('id', 'domain', 'name', 'city_name')->get();
        //echo "<pre>";print_r($data['exchange_list']);exit();
        
        return view('admin.dashboard.switch_exchange',$data);
    }
    
    public function select_exchange($id)
    {
        Session::put('EXCHANGE_ID', $id);
        $data['exchange_detail'] = Exchange::where('id', '=', $id)->get();
        Session::put('EXCHANGE_CITY_NAME', $data['exchange_detail'][0]->city_name);
        return view('admin.dashboard.exchange_dashboard',$data);
    }
}
