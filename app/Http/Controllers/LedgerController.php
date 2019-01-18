<?php
/***
 *
 *
 ***/

namespace App\Http\Controllers;
use DB;
use App;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Wallet;
use Carbon\Carbon;



class LedgerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function remove_history($id)
	{
		$record = Ledger::find($id);
		if ($record)
		{		
			Ledger::destroy($id);
			return response()->json(['success' => true, 'record' => '']);
		}
		else{
			return response()->json(['success' => false, 'record' => '']);
		}
		
	}
	
	
	public function create($id)
	{		
		$record = Ledger::find($id);
		if ($record)
		{			
            Ledger::insert($record);
			return response()->json(['success' => true, 'record' => '']);
		}
		return response()->json(['success' => false, 'record' => '']);
	}
	public function update()
	{
		$insdata = [];
		$msg = Ledger::where('id', '=', $id)->update($insdata);
		if ($msg) return response()->json(['success' => true, 'record' => '']);
		else return response()->json(['success' => false, 'record' => '']);
	}
	public function get_wallet (Request $request)
	{
		$id     = $request->input('id');
		$record = Wallet::get_wallet_details($id);
		return response()->json(['success' => true, 'record' => $record]);
	}
	
	
	
	//Deprecated
	public function adjust_life (Request $request)
	{
		return FALSE;
		$inputs   = $request->input('datav');
		$memberid = $request->input('id');
		
		
		foreach ($inputs as $key=>$val)
		{
			$data[$val['name']] = $val['value'];			
		}
		
		$record = Wallet::update_ledger_life($memberid, $data['addlife'],'LACL',$data['tnotes']);
		
		if ($record['success']) return response()->json(['success' => true,'record'=>$record]);
		else return response()->json(['success' => false, 'message' => 'unknown wallet record']);
		
		return response()->json(['success' => false, 'message' => 'unknown record']);
		
	}
	
	
	public function adjust_life_point (Request $request)
	{
		$inputs   = $request->input('datav');
		$memberid = $request->input('id');
		$life     = 0;
		$point    = 0;
		foreach ($inputs as $key=>$val)
		{
			$data[$val['name']] = $val['value'];			
		}
		if ($data['addlife'] >= 1) 
		{
			$record = Wallet::update_ledger_life($memberid, $data['addlife'],'LACL',$data['tnotes']);	
			
			if ($record['success']) $result['life'] = $record['life'];
		}
		
		else if ($data['apoint'] >= 1) 
		{
			$record = Wallet::update_basic_wallet($memberid, 0,$data['apoint'],'ACP','credit',$data['tnotes']);
			
			if ($record['success']) $result['point'] = $record['point'];
		}	
		else 
		{
			return response()->json(['success' => false,'record'=>'']);
		}
		
		return response()->json(['success' => true,'record'=>$result]);
		
	}
	
	
	public function adjust_balance ($id = FALSE)
	{
		
	}
	
	
	
}
