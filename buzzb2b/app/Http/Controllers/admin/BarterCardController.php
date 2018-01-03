<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cardpool,\Session, \Redirect;
use Response;
use File;
use Excel;

class BarterCardController extends Controller
{
    public function ViewBarterCards(){
    	$cards = Cardpool::orderBy('created_at','DESC')->paginate(30);
    	return view('admin.bartercards.list',compact('cards'));
    }

    public function AddBarterCards(){
         $cards = new Cardpool();
         $cards_details = $cards->Bartercards();
    	return view('admin.bartercards.add',compact('cards_details'));
    }

    public function SaveBarterCards(Request $request){
    	$input = $request->all();

     	$exchangeid = session::get('EXCHANGE_ID');
        //$rand = 7046..rand(100000000000, 999999999999);
        for ($i=1; $i <=$input['number'] ; $i++) { 
         $generate = Cardpool::create([
             'number'=>7046..rand(100000000000, 999999999999),
             'type'=>1,
             'available'=>1,
             'download'=>1,
             'exchange_id'=>$exchangeid
            ]);
            
        }
        $data = Cardpool::select('number')->where('download',1)->get();

        $data_update = Cardpool::where('download',1)->get();
           foreach ($data_update as $value) {
             $value->download=0;
             $value->save();
           }
        Excel::create('BarterCards', function($excel) use($data) {
            $excel->sheet('Sheet 1', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('xls'); 
         

    	return Redirect::route('bartercard')->with('success','Barter Card Saved Successfully.');
    }

    public function EditBarterCard($id){
        $cards = Cardpool::where('number',$id)->first();
        if ($cards) {
            return view('admin.bartercards.add',compact('cards'));
        }
        return back()->with('error','Barter Card Not Found.');
    }
}
