<?php

class soapController extends \BaseController {

	public function __construct()
	{
		$this->WSPath = 'http://www.webservicex.net/country.asmx?WSDL';
		$this->WSGetCountryMethod = 'GetCountries';
		$this->WSGetCurrencyByCountryMethod = 'GetCurrencyByCountry';
		$this->client = new \nusoap_client($this->WSPath, true);
		$this->client->soap_defencoding = 'UTF-8';
		$this->client->decode_utf8 = false;
	}

	public function GetCountries()
	{
		$return = '<select id="country" name="country" onchange="getCurrency()"><option value="0">Seleccione</option>';
		$response = $this->client->call($this->WSGetCountryMethod, array());
		$xml = simplexml_load_string($response["GetCountriesResult"]);
		$count = count($xml);

		for ($i=0; $i<$count-1; $i++) {
			$value = str_replace("'", "", $xml->Table[$i]->Name);
			$return.= "<option value='".(string) $value."'>".(string) $value."</option>";
		}

		$return.='</select>';
		return $return;
	}

	public function GetCurrency()
	{
		$query = rawurlencode(Request::get('search'));	
		$response = $this->client->call($this->WSGetCurrencyByCountryMethod, array('CountryName'=>$query));
		$xml = simplexml_load_string($response["GetCurrencyByCountryResult"]);

		$return = (string)$xml->Table[0]->Currency." (".(string)$xml->Table[0]->CurrencyCode.")";
		return $return;
	}
}