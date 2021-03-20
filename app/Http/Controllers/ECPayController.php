<?php

namespace App\Http\Controllers;

use App\Mail\OrderPaid;
use Illuminate\Http\Request;
use App\Models\Order;
use \ECPay_PaymentMethod as ECPayMethod;

class ECPayController extends Controller
{
	public function getECPayCheckout(Order $order){
		try {
        
    	$obj = new \ECPay_AllInOne();
   
        //服務參數
        $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";   //服務位置
        $obj->HashKey     = '5294y06JbISpM5x9' ;                                           //測試用Hashkey，請自行帶入ECPay提供的HashKey
        $obj->HashIV      = 'v77hoKGq4kWxNNIS' ;                                           //測試用HashIV，請自行帶入ECPay提供的HashIV
        $obj->MerchantID  = '2000132';                                                     //測試用MerchantID，請自行帶入ECPay提供的MerchantID
        $obj->EncryptType = '1';                                                           //CheckMacValue加密類型，請固定填入1，使用SHA256加密


        //基本參數(請依系統規劃自行調整)
        $MerchantTradeNo = "Test".time() ;
		$obj->Send['ReturnURL']         = route('ecpay.listenPayResult', $order->id);    //付款完成通知回傳的網址
		// $obj->Send['OrderResultURL']    = route('ecpay.success', $order->id);    //付款完成通知回傳的網址
		$obj->Send['ClientBackURL']    = route('ecpay.success', $order->id);    //付款完成通知回傳的網址
        $obj->Send['MerchantTradeNo']   = $MerchantTradeNo;                          //訂單編號
        $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                       //交易時間
        $obj->Send['TotalAmount']       = 2000;                                      //交易金額
        $obj->Send['TradeDesc']         = "good to drink" ;                          //交易描述
        $obj->Send['ChoosePayment']     = ECPayMethod::Credit ;              //付款方式:Credit
        $obj->Send['IgnorePayment']     = ECPayMethod::GooglePay ;           //不使用付款方式:GooglePay

        //訂單的商品資料
        array_push($obj->Send['Items'], array('Name' => "歐付寶黑芝麻豆漿", 'Price' => (int)"2000",
                   'Currency' => "元", 'Quantity' => (int) "1", 'URL' => "dedwed"));


        //Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
        //以下參數不可以跟信用卡定期定額參數一起設定
        $obj->SendExtend['CreditInstallment'] = '' ;    //分期期數，預設0(不分期)，信用卡分期可用參數為:3,6,12,18,24
        $obj->SendExtend['InstallmentAmount'] = 0 ;    //使用刷卡分期的付款金額，預設0(不分期)
        $obj->SendExtend['Redeem'] = false ;           //是否使用紅利折抵，預設false
        $obj->SendExtend['UnionPay'] = false;          //是否為聯營卡，預設false;

        //Credit信用卡定期定額付款延伸參數(可依系統需求選擇是否代入)
        //以下參數不可以跟信用卡分期付款參數一起設定
        // $obj->SendExtend['PeriodAmount'] = '' ;    //每次授權金額，預設空字串
        // $obj->SendExtend['PeriodType']   = '' ;    //週期種類，預設空字串
        // $obj->SendExtend['Frequency']    = '' ;    //執行頻率，預設空字串
        // $obj->SendExtend['ExecTimes']    = '' ;    //執行次數，預設空字串
        
        # 電子發票參數
        /*
        $obj->Send['InvoiceMark'] = ECPay_InvoiceState::Yes;
        $obj->SendExtend['RelateNumber'] = "Test".time();
        $obj->SendExtend['CustomerEmail'] = 'test@ecpay.com.tw';
        $obj->SendExtend['CustomerPhone'] = '0911222333';
        $obj->SendExtend['TaxType'] = ECPay_TaxType::Dutiable;
        $obj->SendExtend['CustomerAddr'] = '台北市南港區三重路19-2號5樓D棟';
        $obj->SendExtend['InvoiceItems'] = array();
        // 將商品加入電子發票商品列表陣列
        foreach ($obj->Send['Items'] as $info)
        {
            array_push($obj->SendExtend['InvoiceItems'],array('Name' => $info['Name'],'Count' =>
                $info['Quantity'],'Word' => '個','Price' => $info['Price'],'TaxType' => ECPay_TaxType::Dutiable));
        }
        $obj->SendExtend['InvoiceRemark'] = '測試發票備註';
        $obj->SendExtend['DelayDay'] = '0';
        $obj->SendExtend['InvType'] = ECPay_InvType::General;
        */


        //產生訂單(auto submit至ECPay)
		// dd($obj);

        $obj->CheckOut();

    
    } catch (Exception $e) {
    	echo $e->getMessage();
    } 	

	}	
	public function listenPayResult(Request $request, Order $order){
		if($request->all()['RtnCode']){
			$data = $request->all();
		}
		return '1|OK';
	}

	public function getECPayCheckoutSuccess(Request $request, Order $order){
		dd($requesst->all());

		return redirect()->route('home')->withMessage('Payment successful');
	}
    //
}
