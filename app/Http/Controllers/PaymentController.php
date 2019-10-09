<?php

namespace App\Http\Controllers;

use \App\helpers\MakePayment;
use App\Http\Controllers\Api\LedgerController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\ProductController as ProductController;
use App\helpers\Sha256Generator;
use App\payment_transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class PaymentController extends BaseController
{

    public function __construct() {

        //
        $this->payment = new MakePayment();
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //in future may add any fucntion
		return view( 'client/youzan' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function membership_buy_vip(Request $request)
    {

        $member_id = Auth::guard('member')->user()->id ;
        $request->merge(['type' => 'upgrade_vip']); 
        $request->merge(['member_id' => $member_id]); 
        $request->merge(['pay_amount' => 120]); 
        // $data = ['payment_transaction_id' => '999', 'pay_final_amount' => '120', 'qrcode' => 'abc'];
        $data = $this->payment->Pay_Index($request);

        if (is_array($data)) {
            if (!empty($data['payment_transaction_id'])) {
                //submit vip upgrade
                $upgrade_vip = $this->submit_vip_upgrade($member_id);
                //store vip upgrade id
                if (empty($upgrade_vip->refid)) {
                    $data = ['payment_transaction_id' => '-1', 'pay_final_amount' => '0', 'qrcode' => null];
                } else {
                    payment_transaction::where('id', $data['payment_transaction_id'])->update(['refid' => $upgrade_vip->refid]);    
                }                
            }
        } else {
            $data = json_decode($data, true);
        }

        return view('client/membership_buy_vip', $data);
    }

    

    public function submit_vip_upgrade($memberid)
    {
        $request = new Request;
        $request->merge(['memberid' => $memberid]); 
        
        //retrieve package vip id
        $packageid = null;
        $product = new ApiProductController;
        $vip_package = json_decode(json_encode($product->list_package($request),true));
        // $packageid = $vip_package->original->records[0]->id;
        if (!empty($vip_package->original->records)) {
            foreach ($vip_package->original->records as $key => $value) {
                // var_dump($key);
                if (($value->min_point <= 0) && ($value->package_type == 2)) {
                    $packageid = $value->id;
                    // var_dump($packageid);
                    break;    
                }
            }    
        }
        
        //submit
        $request->merge(['packageid' => $packageid]); 
        $res = json_decode(json_encode($product->request_vip($request),true));
        return empty($res->original) ? $res : $res->original;
    }

    public function MonTradeQuery_vip()
    {
        $request = new Request;
        $data = payment_transaction::whereNotNull('refid')
        ->where(function ($query) {
            $query->whereNull('trade_state')
                  ->orWhere(function ($query) {
                    $query->where('trade_state', '<>', 'success')
                    ->Where('trade_state', '<>', 'expired');
                });
              })
        ->where('created_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())
        ->skip(0)->take(20)
        ->get();

        foreach($data as $r) {
            $request->merge(['pay_orderid' => $r->pay_orderid]);
            $res = $this->payment->Pay_Trade_query($request);
            $trade_status = null;
            $vip_package_result = null;
            if (!empty($res)) {
                $_res = json_decode($res);
                $trade_status = empty($_res->data[0]->trade_state) ? null : $_res->data[0]->trade_state;
                if ($trade_status == 'SUCCESS') {
                    //update confirm-vip
                    $product = new ProductController;
                    $request->merge(['id' => $r->refid]);
                    $vip_package = json_decode(json_encode($product->confirm_vip($request),true));
                    $vip_package_result = ['refid' => $r->refid, 'vip_package_result' => $vip_package->original];
                }
            }
            $result = ['pay_orderid' => $r->pay_orderid, 'trade_status' => $trade_status, 'vip_package_result' => $vip_package_result]; 
            var_dump($result);
            \Log::info(json_encode($result,true));
        }           

        return "completed";
        
    }

    public function MonTradeExpired_vip()
    {
        $request = new Request;
        $data = payment_transaction::whereNotNull('refid')
        ->where(function ($query) {
            $query->whereNull('trade_state')
                  ->orWhere(function ($query) {
                    $query->where('trade_state', '<>', 'success')
                    ->Where('trade_state', '<>', 'expired');
                });
              })
        ->where('created_at', '<', Carbon::now()->subMinutes(5)->toDateTimeString())
        ->skip(0)->take(20)
        ->get();

        foreach($data as $r) {
            //update to expired
            payment_transaction::where('id',$r->id)->update(['trade_state' => 'expired']);
            //update vip package - reject vip
            $vip_package_result = null;
            $product = new ProductController;
            $request->merge(['id' => $r->refid]);
            $request->merge(['note' => "订单已过期"]);
            
            $vip_package = json_decode(json_encode($product->reject_vip($request),true));
            $vip_package_result = ['refid' => $r->refid, 'vip_package_result' => $vip_package->original];
            $result = ['pay_orderid' => $r->pay_orderid, 'vip_package_result' => $vip_package_result]; 
            var_dump($result);
            \Log::info(json_encode($result,true));
        } 

        return "completed";
        
    }

    public function payment(Request $request)
    {
        try {

            $data['status'] = null;
            $type = $request->input('type');
            $member_id = $request->input('member_id');
            $pay_amount = $request->input('pay_amount');
            $data = $this->payment->Pay_Index($request);

            if (is_array($data)) {
                if (!empty($data['payment_transaction_id'])) {
                    //submit /api/buy-point
                    $p = $this->submit_buy_point($member_id, $pay_amount);
                    //store ref id
                    if (empty($p['refid'])) {
                        $data = ['payment_transaction_id' => '-1', 'pay_final_amount' => '0', 'qrcode' => null];
                    } else {
                        payment_transaction::where('id', $data['payment_transaction_id'])->update(['refid' => $p['refid']]);    
                    }                
                }
            } else {
                $data = json_decode($data, true);
            }

            return view('client/payment', $data);

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            //return $e->getMessage();
            return redirect()->back()->with('msg', '订单出现异常,请勿支付,请重新发起订单！');
        }
    }

    public function submit_buy_point($member_id, $pay_amount)
    {
        $request = new Request;
        $request->merge(['memberid' => $member_id]); 
        $request->merge(['points_to_add' => $pay_amount]);
        $ledger = new LedgerController;
        $res = $ledger->buy_point($request);
        return empty($res->original) ? $res : $res->original;
    }

    public function MonTradeQuery()
    {
        $request = new Request;
        $data = payment_transaction::whereNotNull('refid')
        ->where(function ($query) {
            $query->whereNull('trade_state')
                  ->orWhere(function ($query) {
                    $query->where('trade_state', '<>', 'success')
                    ->Where('trade_state', '<>', 'expired');
                });
              })
        ->where('created_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())
        ->skip(0)->take(20)
        ->get();

        foreach($data as $r) {
            $request->merge(['pay_orderid' => $r->pay_orderid]);
            $res = $this->payment->Pay_Trade_query($request);
            $trade_status = null;
            $package_result = null;
            if (!empty($res)) {
                $_res = json_decode($res);
                $trade_status = empty($_res->data[0]->trade_state) ? null : $_res->data[0]->trade_state;
                if ($trade_status == 'SUCCESS') {
                    if ($r->type == 'purchasepoint') {
                        //update confirm purchase point
                        $ledger = new LedgerController;
                        $request->merge(['refid' => $r->refid]);
                        $request->merge(['memberid' => $r->member_id]);
                        $p = $ledger->confirm_point_purchase($request);
                        $package_result = ['refid' => $r->refid, 'package_result' => json_encode($p, true)];    
                    }
                    
                }
            }
            $result = ['pay_orderid' => $r->pay_orderid, 'trade_status' => $trade_status, 'package_result' => $package_result]; 
            var_dump($result);
            \Log::info(json_encode($result,true));
        }           

        return "completed";
        
    }

    public function MonTradeExpired()
    {
        $request = new Request;
        $data = payment_transaction::whereNotNull('refid')
        ->where(function ($query) {
            $query->whereNull('trade_state')
                  ->orWhere(function ($query) {
                    $query->where('trade_state', '<>', 'success')
                    ->Where('trade_state', '<>', 'expired');
                });
              })
        ->where('created_at', '<', Carbon::now()->subMinutes(5)->toDateTimeString())
        ->skip(0)->take(20)
        ->get();

        foreach($data as $r) {
            //update to expired
            payment_transaction::where('id',$r->id)->update(['trade_state' => 'expired']);
            //update package - reject
            $package_result = null;

            if ($r->type == 'purchasepoint') {
                //update confirm purchase point
                $ledger = new LedgerController;
                $request->merge(['refid' => $r->refid]);
                $request->merge(['memberid' => $r->member_id]);
                $request->merge(['notes' => "订单已过期"]);
                $p = $ledger->reject_point_purchase($request);
                $package_result = ['refid' => $r->refid, 'package_result' => json_encode($p, true)];
                $result = ['pay_orderid' => $r->pay_orderid, 'package_result' => $package_result]; 
                var_dump($result);
                \Log::info(json_encode($result,true));    
            }            
        } 

        return "completed";
        
    }

}
