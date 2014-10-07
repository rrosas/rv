<?php

Route::ANY('/', function()
{
	$soapCountries = json_encode(App::make('soapController')->GetCountries());
	$amounts = json_encode(App::make('payPlatformController')->GetAmounts());	
	return View::make('main')->with(array('countries'=>$soapCountries, 'amounts'=>$amounts));
});

Route::POST('searchCurrency', 'soapController@GetCurrency');

Route::POST('saveTransaction', 'payPlatformController@saveTransaction');

Route::POST('grid-data', 'payPlatformController@jsonGridTest');