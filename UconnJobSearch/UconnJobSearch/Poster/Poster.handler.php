<?php

function updateLogin($userInfo){
		$database = new DatabaseConnector();
		$database->connect();
		$errMsg = "";
	
		$username = $userInfo['username']; 
		$oldusername = $userInfo['oldusername'];
		$password = $userInfo['pass'];
		$fname = $userInfo['fname'];
		$lname = $userInfo['lname'];
		$street1 = $userInfo['street1'];
		$street2 = $userInfo['street2'];
		$city = $userInfo['city'];
		$zip = $userInfo['zip'];
		$state = $userInfo['state'];
		$email = $userInfo['email']; 
		$oldemail = $userInfo['oldemail'];
		$phone = $userInfo['phone'];
		$fax = $userInfo['fax'];
		$cell = $userInfo['cell'];
		$www = $userInfo['www'];
		$cname = $userInfo['CName'];
		$pcontactemail = $userInfo['PContactEmail'];
		$pposition = $userInfo['PPosition'];
		
		
		//validate username
		if(empty($username)){
			$errMsg .= "Missing username!\\n";
		} elseif (!ctype_alnum($username)) {
			$errMsg .= "Invalid username format! Alphanumeric characters only, please.\\n";
		} else {
			$query = "SELECT * FROM User WHERE UName <> '$oldusername'";
			$users = $database->query($query);
			foreach($users as $user){
				if ($user['UName']==$username){
					$errMsg .= "Username already used!\\n";
				}
			}
		}
		//validate password
		if(empty($password)){
			$errMsg .= "Missing password!\\n";
		}
		
		//validate email
		if(empty($email)){
			$errMsg .= "Missing email!\\n";
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errMsg .= "Invalid email format!\\n";
		} else {
			$query = "SELECT * FROM User WHERE UEmail <> '$oldemail'";
			$users = $database->query($query);
			foreach($users as $user){
				if ($user['UEmail']==$email){
					$errMsg .= "Email already used!\\n";
				}
			}
		}
		//validate names
		if(empty($fname)){
			$errMsg .= "Missing first name!\\n";
		}
		if(empty($lname)){
			$errMsg .= "Missing last name!\\n";
		}
		//phone number
		if(empty($phone)){
			$errMsg .= "Missing phone number!\\n";
		} elseif (!ctype_digit($userInfo['phone'])){
			$errMsg .= "Please use digits only for phone number!\\n";
		}
		//address
		if(empty($street1)){
			$errMsg .= "Missing address!\\n";
		}
		//city
		if(empty($city)){
			$errMsg .= "Missing city!\\n";
		}
		//zip
		if(empty($zip)){
			$errMsg .= "Missing zip-code!\\n";
		} elseif (!ctype_digit($zip)){
			$errMsg .= "Please only use digits for zip-code\\n";
		}
		if(!empty($fax)){
			if(!ctype_digit($fax)){
			$errMsg .= "Please use digits only for fax number!\\n";
			}
		}
		if(!empty($cell)){
			if(!ctype_digit($cell)){
			$errMsg .= "Please use digits only for cell number!\\n";
			}
		}
		if(!empty($www)){
			if(!filter_var($www, FILTER_VALIDATE_URL)){
				$errMsg .=	"Please format your homepage correctly!\\n";	
			}	
		}
	
		if(empty($errMsg)){
			$_SESSION['username'] = $username;
			$query = "UPDATE User SET UName='$username', UState='$state',
			UPasswd='$password', UFName='$fname', ULName = '$lname', 
			UStreet1='$street1', UStreet2='$street2', UCity='$city',
			UZip='$zip', UEmail='$email', UPhone='$phone', UFax='$fax',
			UCell='$cell', UHomePage = '$www' WHERE UName = '$oldusername'";
			$database->query($query);
			
			$query = "UPDATE Poster SET pposition= '$pposition', CName= '$cname', 
			pcontactemail = '$pcontactemail' WHERE UName = '$oldusername'";
			
			$results = $database->query($query);
			/**return $results;*/
		}

		$database->closeCon();

		return $errMsg;
}

?>
