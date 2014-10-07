<?php

class payPlatformController extends \BaseController {

	public function __construct()
	{
	}

	public function GetAmounts()
	{
		$return = '<select id="rechargeAmount" name="rechargeAmount"><option value="0">Seleccione</option>';
		for ($i=0; $i<=90; $i++) {
			$return.= "<option value='".$i."'>".$i."</option>";
		}

		$return.='</select>';
		return $return;
	}

	public function saveTransaction()
	{
		$transaction = new Transaction;
		$transaction->country = $_POST['country'];
		$transaction->currency = $_POST['currency'];
		$transaction->recharge_amount = $_POST['rechargeAmount'];
		$transaction->tax_amount = $_POST['taxAmount'];
		$transaction->total_amount = $_POST['totalAmount'];
		$transaction->card_type = $_POST['ccType'];
		$transaction->card_number = $_POST['ccNumber'];
		$transaction->card_expiration = $_POST['ccYear'].$_POST['ccMonth'];
		$transaction->card_cvv = $_POST['ccCCV'];
		$transaction->ip = $this->getIp();
		$transaction->save();
		return 1;
	}

	public function getIp() {
 		
 		if ( function_exists( 'apache_request_headers' ) ) {
			$headers = apache_request_headers(); 
		} else { 
			$headers = $_SERVER; 
		}
 
		if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			$ipAddress = $headers['X-Forwarded-For'];
		} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )) {
 			$ipAddress = $headers['HTTP_X_FORWARDED_FOR'];
		} else {
			$ipAddress = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ); 
		} 
		return $ipAddress;
	}

	public function BuildGrid()
	{
		{{
    		GridRender::setGridId("step3Grid")
    		->setGridOption('url',URL::to('/index.php/grid-data'))
    		->setGridOption('sortname','id')
    		->setGridOption('datatype','json')
    		->setGridOption('caption','My Payments')
    		->addColumn(array('label'=>'Product','index'=>'product','width'=>400))
    		->renderGrid();
    	}}
	}


	public function jsonGridTest()
	{

		$arr = array('page' => '1', 'total' => 1, 'records' => '1', 'rows' => array(array('id'=>'1', 'cell'=>array('adadadasd'))));		
		return json_encode($arr);
	}

}