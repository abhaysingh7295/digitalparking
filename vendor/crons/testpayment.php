
<?php echo '<pre>'; print_r($_POST); echo '</pre>';

echo '<br/><br/>';

$merchantId = '2Ks2W7sANcvaW9';
$merchantTxnId = 'TEST_'.substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 15);


$checksumEncrypt = '{"amount":"1000.00","channel":"WEB","currency":"INR","customNote":"Test","customerName":"Deepak","email":"deepshar2009@gmail.com","furl":"http://thedigitalparking.com/digital-parking/vendor/crons/testpayment.php?fail=1","merchantId":"'.$merchantId.'","merchantTxnId":"'.$merchantTxnId.'","mobile":"9782303930","os":"ubuntu-14.04","productInfo":"auth","surl":"http://thedigitalparking.com/digital-parking/vendor/crons/testpayment.php?success=1"}0e36b6ed-218a-42e7-b890-af9a7f9228c5';


$hash_string = $checksumEncrypt;

echo $hash_string; echo '<br/><br/>';

$hash = hash('sha256', $hash_string);

 

//$hash = md5($hash_string);

echo $CHECKSUM = $hash;

echo '<br/><br/>';

echo time(); echo '<br/><br/>';


 ?>
<!doctype html>
	<html>
	<head>
		<title>Checkout</title>
	</head>
	<body>
		<form enctype='application/json' action="https://checkout-sandbox.freecharge.in/api/v1/co/pay/init" id="searchForm" method="post">
			<h1>Client Order Form</h1>
			<fieldset>
				<legend>Merchant / USER details</legend>

				<div>
					<label>amount <input id="amount" value="1000.00" name="amount" type="number" required></label>
				</div>

				<div>
					<label>channel <input id="channel" name="channel" type="text" value="WEB"></label>
				</div>

				<div>
					<label>currency <input id="currency" name="currency" type="text" value="INR" required></label>
				</div>

				<div>
					<label>customNote <input id="customNote" name="customNote" type="text" value="Test"></label>
				</div>
				<div>
					<label>customerName <input id="customerName" value="Deepak" name="customerName" type="text" ></label>
				</div>

				<div>
					<label>email <input id="email" value="deepshar2009@gmail.com" name="email" type="email" required></label>
				</div>

				<div>
						<label>furl <input id="furl" name="furl" type="text" value="http://thedigitalparking.com/digital-parking/vendor/crons/testpayment.php?fail=1" required></label>
				</div>

				<div>
					<label>merchantId<input id="merchantId" value="<?php echo $merchantId; ?>" name="merchantId" type="text" required></label>
				</div>
				<div>
					<label>merchantTxnId <input id="merchantTxnId" value="<?php echo $merchantTxnId; ?>" name="merchantTxnId" type="text" required></label>
				</div>

				<div>
					<label>mobile <input id="mobile" name="mobile" type="text" value="9782303930" required></label>
				</div>

				<div>
					<label>os <input id="os" name="os" type="text" value="ubuntu-14.04""></label>
				</div>
				
				<div>
					<label>productInfo <input id="productInfo" name="productInfo" type="text" value="auth"></label>
				</div>
				

				<div>
					<label>surl <input id="surl" name="surl" type="text" value="http://thedigitalparking.com/digital-parking/vendor/crons/testpayment.php?success=1" required></label>
				</div>
				<!-- this checksum field is to be calculated by the steps mentioned -->
				<div>
					<label>checksum <input id="checksum" name="checksum" type="text" value="<?php echo $CHECKSUM; ?>"></label>
				</div>


				<!-- <div>
					<label>metadata <input id="metadata" name="metadata" type="text" value="" ></label>
				</div> -->
			</fieldset>
			<button id="checkout" class="btn btn-lg btn-block signin">Checkout</button>
			<p id="msg"></p>
		</form>
	</body>
</html>