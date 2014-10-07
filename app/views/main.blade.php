<!DOCTYPE html>
<html>
<head>
	<title>RingVoz Test by Rafael Rosas</title>

	{{ HTML::style('//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css') }}
	{{ HTML::style('css/ui.jqgrid.css') }}	
	{{ HTML::style('css/jquery-multi-step-form.css') }}
	{{ HTML::style('css/main.css') }}
	{{ HTML::style('css/ccvalidate.css') }}
	{{ HTML::style('//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') }}
	{{ HTML::style('//fonts.googleapis.com/css?family=Ubuntu:300,400') }}

	{{ HTML::script('//code.jquery.com/jquery-2.1.1.min.js') }}
	{{ HTML::script('//code.jquery.com/ui/1.11.0/jquery-ui.js') }}
	{{ HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') }}
	{{ HTML::script('js/jquery-multi-step-form.js') }}
    {{ HTML::script('js/ccvalidate.js') }}
	{{ HTML::script('js/i18n/grid.locale-en.js') }}
	{{ HTML::script('js/jquery.jqGrid.min.js') }}

	<script>
	$(document).ready(function(){
    	$.multistepform({
        	container:'ringvoz-form-container',
        	form_method:'POST',
    	});
    	
    	$(".number").keypress(function (e) {
     		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        		return false;
    		}
   		});

    	var myEl = document.getElementById('goToStep2');
    	myEl.addEventListener('click', function() {
			if ($("#country").find('option:selected').val() == 0) {
				alert('Please select Country');
				return false;
			} else {
				if ($("#rechargeAmount").find('option:selected').val() == 0) {
					alert('Please select Recharge Amount');
					return false;
				} else {
					$('#next').click();
				}
			}
		}, false);

		var myEl1 = document.getElementById('recharge');
   		myEl1.addEventListener('click', function() {
    		$('.cc-container').ccvalidate({ onvalidate: function(isValid) {
                if (!isValid) {
					alert('Credit Card Data Invalid');
                    return false;
                } else {
                	$('#check-out').click();
                }
            }
        	});
		}, false);
	});
	</script>

	<script type="text/javascript">	
	function getCurrency(){
		$.ajax({
			url: "index.php/searchCurrency",
			type: "POST",
			data: { search: $("#country").val() },
    		success: function (data) {
				$("#countryCurrency").html('Your currency is : '+data);
				$("#currency").val(data);
			}
		});
	}
	</script>
	
</head>

<body>

<div id="ringvoz-form-container" class="row-fluid">
<ul id="multistepform-progressbar">
<li class="active">Step 1</li>
<li>Step 2</li>
<li>Step 3</li>
</ul>
<div class="form">
<form id="step1Form" action="">
	<h2 class="fs-title">Please Select</h2>
	<h3 class="fs-subtitle">The country and the recharge amount</h3>
	Country
	<br>
	{{json_decode($countries)}}
	<br>
	<span id="countryCurrency"></span>
	<br><br>
	Recharge Amount
	<br>
	{{json_decode($amounts)}}
	<br><br>
	<input type="hidden" id="step1H" name="step1H" value="1">
	<input type="hidden" id="currency" name="currency">
	<input type="button" id="goToStep2" name="goToStep2" class="button" value="Next">
	<input type="button" id="next" name="next" class="next button" value="Next" hidden>
</form>
</div>
<div class="form">
<form id="step2Form" action="">
	<h2 class="fs-title">Please Enter</h2>
	<h3 class="fs-subtitle">Your credit card information</h3>
	<div class="cc-container">
	Card Type
	<br>
	<select id="ccType" name="ccType" class="cc-ddl-type">
		<option value="mcd">Master Card</option>
        <option value="vis">Visa</option>
        <option value="amx">American Express</option>
        <option value="dnr">Diners Club</option>
        <option value="dis">Discover</option>
    </select>
	<br><br>
	Card Number
	<input type="text" id="ccNumber" name="ccNumber" class="number large cc-card-number" placeholder="Credit Card Number" maxlength="19" />
	<br>
	Expires on
	<br>
	Month: 
	<select id="ccMonth" name="ccMonth">
		<option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
   	</select>
    Year
    <select id="ccYear" name="ccYear">
    	<option value="2014">2014</option>
		<option value="2015">2015</option>
		<option value="2016">2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
   	</select>
    <br><br>
    CVV
    <input type="text" class="number small" id="ccCCV" name="ccCCV" placeholder="CVV" maxlength="3" />
    <br>
	<input type="button" name="previous" class="previous button" value="Previous">
	<input type="hidden" id="countryH" name="countryH">
	<input type="hidden" id="currencyH" name="currencyH">
	<input type="hidden" id="rechargeAmountH" name="rechargeAmountH">
	<input type="hidden" id="step2H" name="step2H" value="0">
	<input type="button" class="button" id="recharge" value="Recharge"> 
	<input type="button" name="next2" class="next button cc-checkout" id="check-out" value="Recharge" hidden>
</div>
</form>
</div>
<div class="form">
<form action="">
	<h2 class="fs-title">Summary</h2>
	<h3 class="fs-subtitle">Transaction Details</h3>
	<div id="summary" name="summary" class="box"></div>
	<br><br>
	<?php 
		//$grid = App::make('payPlatformController')->BuildGrid();
	?>	
	<input type="hidden" id="countryH2" name="countryH2">
	<input type="hidden" id="currencyH2" name="currencyH2">
	<input type="hidden" id="rechargeAmountH2" name="rechargeAmountH2">
	<input type="hidden" id="ccTypeH" name="ccTypeH">
	<input type="hidden" id="ccNumberH" name="ccNumberH">
	<input type="hidden" id="ccMonthH" name="ccMonthH">
	<input type="hidden" id="ccYearH" name="ccYearH">
	<input type="hidden" id="ccCCVH" name="ccCCVH">
	<input type="hidden" id="step3H" name="step3H" value="0">
	<input type="button" name="previous" class="previous button" value="Previous">
	<input type="button" id="next3" name="next3" class="next button" value="Finish">
</form>
</div>
</div>
	
</body>
</html>	