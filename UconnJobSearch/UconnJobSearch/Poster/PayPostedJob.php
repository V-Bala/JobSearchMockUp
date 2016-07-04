<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Tyler" />
</head>

<body>
<?php

require "./../includes/DatabaseConnector.php";

class PayJob{
	
	public function PayJob($Info){
			if (!$this->validate($Info)){
				header('Location: '. $_SERVER['HTTP_REFERER']);
			}else{	
			$this->pushPayment($Info); 
			echo("You have successfully paid for this job...Redirecting");
			header("refresh:5; url=/UconnJobSearch/Poster/PosterJobs.php");
		} 
	}
	
	public function pushPayment($Info){
		$jobid = $Info['jobid'];	
		$payment = $Info['type'];	
		if($payment == 'credit'){
			echo('Paying by credit card');
			$payment = $Info['type'];
			$cnumber = $Info['ccnumber'];
			$ctype = $Info['cctype'];
			$cexpirationdate = $Info['ccexpirdate'];	
			$database = new DatabaseConnector();
			$database->connect();
			$query = "SELECT PaymentID FROM postpay WHERE JobID =$jobid";
			$results = $database->query($query);
			$results = $results[0][0];
			$nextquery = "INSERT INTO ccpayment 
					(CCNumber, CCType, CCExpirDate, PaymentID)
					VALUES ('$cnumber', '$ctype', '$cexpirationdate', $results)";
			$lastquery = "UPDATE payment SET PStatus = 'Complete' WHERE PaymentID ='$results'";
			$finalquery = "INSERT INTO invoice  (PaymentID) VALUES ('$results')";
			$database->query($nextquery);
			$database->query($lastquery);
			$database->query($finalquery);
			$database->closeCon();
		}	

			if($payment == 'bank'){
			echo('Paying by Bank');
			$payment = $Info['type'];
			$baccountnumber = $Info['baccountnumber'];
			$bname = $Info['bname'];	
			$database = new DatabaseConnector();
			$database->connect();
			$query = "SELECT PaymentID FROM postpay WHERE JobID =$jobid";
			$results = $database->query($query);
			$results = $results[0][0];
			$nextquery = "INSERT INTO bankpayment 
					(BName, BAcctNumber, PaymentID)
					VALUES ('$bname', '$baccountnumber', '$results')";
			$lastquery = "UPDATE payment SET PStatus = 'Complete' WHERE PaymentID =$results";
			$finalquery = "INSERT INTO invoice  (PaymentID) VALUES ('$results')";
			$database->query($nextquery);
			$database->query($lastquery);
			$database->query($finalquery);
			$database->closeCon();
		}			

			if($payment == 'online'){
			echo('Paying by Online Service');
			$sname = $Info['sname'];
			$sfee = $Info['sfee'];	
			$database = new DatabaseConnector();
			$database->connect();
			$query = "SELECT PaymentID FROM postpay WHERE JobID =$jobid";
			$results = $database->query($query);
			$results = $results[0][0];
			$nextquery = "INSERT INTO onlinepayment 
					(SName, SFee, PaymentID)
					VALUES ('$sname', '$sfee', '$results')";
			$lastquery = "UPDATE payment SET PStatus = 'Complete' WHERE PaymentID =$results";
			$finalquery = "INSERT INTO invoice  (PaymentID) VALUES ('$results')";
			$database->query($nextquery);
			$database->query($lastquery);
			$database->query($finalquery);
			$database->closeCon();
		}
			
}

	public function validate($Info){
		$database = new DatabaseConnector();
		$database->connect();
		$errMsg = "";
		$errCnt = 0;
		$payment = $Info['type'];
		if($payment == 'credit'){
			$cnumber = $Info['ccnumber'];
			$ctype = $Info['cctype'];
			$cexpirationdate = $Info['ccexpirdate'];
			if (!ctype_digit($cnumber)) {
				$errMsg .= "Invalid credit card format! Numeric characters only, please.\\n";
				$errCnt++;	
			}	
		}
			if($payment == 'bank'){
			$bnumber = $Info['baccountnumber'];
			if (!ctype_digit($bnumber)) {
				$errMsg .= "Invalid bank account format! Numeric characters only, please.\\n";	
				$errCnt++;	
			}
			
		}
			
			if($payment == 'online'){
			$bnumber = $Info['baccountnumber'];
			if (!ctype_digit($sfee)) {
				$errMsg .= "Please Enter the correct Service Fee. \\n";		
				$errCnt++;	
		}
	}
	
		$database->closeCon();
		if($errCnt > 0){
			$_SESSION['errMsg'] = $errMsg;
			return false;
		} else{
			return true;
		}
	
}
	
}
session_start();
new PayJob($_POST);
?>
</body>
</html>
		