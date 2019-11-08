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
use App\Notification;
use App\Ledger;

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
		$record = \App\Ledger::all_ledger($id);
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
		$error    = TRUE;
		foreach ($inputs as $key=>$val)
		{
			$data[$val['name']] = $val['value'];			
		}						
		if ($data['addlife'] >= 1) 
		{
			$record = Wallet::update_ledger_life($memberid, $data['addlife'],'LACL',$data['tnotes']);	
			$error  = FALSE;
			if ($record['success']) $result['life'] = $record['life'];
		}
		
		if ($data['apoint'] >= 1) 
		{
			$record = Wallet::update_basic_wallet($memberid, 0,$data['apoint'],'ACP','credit',$data['tnotes']);
			$error  = FALSE;
			if ($record['success']) 
			{
				$result['point'] = $record['point'];
				$refid = $record['refid'];
				
				$notification = new Notification();
				$notification->member_id       = $memberid;
				$notification->title           = 'Ledger Update';
				$notification->notifiable_type = 'LEBUP';
				$notification->notifiable_id   = $refid;
				$notification->save();
				
				$notification = \App\Notification::with('ledger')->where('member_id',$memberid)->where('is_read',0)->orderby('created_at','DESC')->get();		
				$ndata        = ['count'=>$notification->count(), 'records' => $notification];				
				event(new \App\Events\EventDynamicChannel($memberid.'-'.'topup-notification','',$ndata ));
			}
		}
		
		if ($data['viplife'] >= 1) 
		{
			$record = Wallet::update_vip_wallet($memberid, $data['viplife'], 0,'AVL','credit',$data['tnotes']);
			$error  = FALSE;
			if ($record['success']) $result['point'] = $record['point'];
		}		
		
		if ($data['vapoint'] >= 1) 
		{
			$record = Wallet::update_vip_wallet($memberid, 0,$data['vapoint'],'AVP','credit',$data['tnotes']);
			$error  = FALSE;
			if ($record['success']) {
				$result['vippoint'] = $record['point'];
				$refid = $record['refid'];				
				$notification = new Notification();
				$notification->member_id       = $memberid;
				$notification->title           = 'Ledger Update';
				$notification->notifiable_type = 'LEVUP';
				$notification->notifiable_id   = $refid;
				$notification->save();
				
				$notification = \App\Notification::with('ledger')->where('member_id',$memberid)->where('is_read',0)->orderby('created_at','DESC')->get();		
				$ndata        = ['count'=>$notification->count(), 'records' => $notification];				
				event(new \App\Events\EventDynamicChannel($memberid.'-'.'topup-notification','',$ndata ));
			}
		}
		
		if ($error) 
		{
			return response()->json(['success' => false,'record'=>'']);
		}		
		return response()->json(['success' => true,'record'=>$result]);
		
	}
	
	
	public function adjust_balance ($id = FALSE)
	{
		
	}
	
	
	public function get_gameledger (Request $request)
	{		
		$id     = $request->id;
		$record = Ledger::all_ledger($id);		
		$result =  view('member.render_update', ['result' => $record['gameledger'] , 'id'=>$id])->render();	
		return response()->json(['success' => true,'id'=>$id , 'record'=>$result]);
	}
	
	public function update_gameledger (Request $request)
	{
		$is_save = '';
		$userid  = $request->id;	
		$gid     = [];	
		foreach($request->point as $key => $point)
		{
			if ($point>0)
			{
				$ledger = Ledger::find($key);
				$result = Ledger::credit($userid,$ledger->game_id,$point,'PAA', 'admin adjust point');
				
				$notification = new Notification();
				$notification->member_id       = $userid;
				$notification->title           = 'Ledger Update';
				$notification->notifiable_type = 'LEDUP';
				$notification->notifiable_id   = $result['id'];
				$notification->game_id         = $ledger->game_id;
				$notification->save();	

				$gid[$ledger->game_id] = $ledger->game_id;			
				
				$is_save = 'yes';
			}
			else
			{
				$point  = str_replace('-', '', $point);
				$ledger = Ledger::find($key);
				$result = Ledger::debit($userid,$ledger->game_id,$point,'PAA', 'admin adjust point');
				$notification = new Notification();
				$notification->member_id       = $userid;
				$notification->title           = 'Ledger Update';
				$notification->notifiable_type = 'LEDUP';
				$notification->notifiable_id   = $result['id'];
				$notification->game_id         = $ledger->game_id;
				$notification->save();
				$is_save = 'yes';
			}
		}		
		foreach($request->life as $key => $life)
		{
			if ($life>0)
			{
				$ledger = Ledger::find($key);					
				$result = Ledger::life($userid,$ledger->game_id,'credit',$life,'LAA', 'admin adjust point');
				
				$notification = new Notification();
				$notification->member_id       = $userid;
				$notification->title           = 'Ledger Update';
				$notification->notifiable_type = 'LELUP';
				$notification->notifiable_id   = $result['id'];
				$notification->game_id         = $ledger->game_id;
				$notification->save();
				$gid[$ledger->game_id] = $ledger->game_id;			
				$is_save = 'yes';
			}
		}
		
		foreach ($gid as $k=>$v)
		{
			$notification = \App\Notification::with('ledger')->where('member_id',$userid)->where('game_id',$k)->where('is_read',0)->orderby('created_at','DESC')->get();		
			$ndata        = ['count'=>$notification->count(), 'records' => $notification, 'gameid' => $k];				
			event(new \App\Events\EventDynamicChannel($userid.'-'.'topup-notification','',$ndata ));
		}
		if ($is_save)
		{
			//$notification = \App\Notification::with('ledger')->where('member_id',$userid)->where('is_read',0)->orderby('created_at','DESC')->get();		
			//$ndata        = ['count'=>$notification->count(), 'records' => $notification];				
			//event(new \App\Events\EventDynamicChannel($userid.'-'.'topup-notification','',$ndata ));
		}
		
		return response()->json(['success' => true]);
	}
	
}
