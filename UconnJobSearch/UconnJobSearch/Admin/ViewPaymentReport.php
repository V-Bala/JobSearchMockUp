<html>
<head>
	<link rel="stylesheet" type="text/css" 
		href="search.css">
</head>
<body>

<?php
include_once 'JobSearch.php';

echo "<h2>Search Results:</h2><p>";

$searcher = new JobSearch($_POST);
$results = $searcher->viewPaymentReport();
//print(json_encode(($results)));
//And we display the results
foreach ($results as $result){
$pID = $result['PaymentID'];
	
echo "Payment ID: ";
echo $pID;
echo "<br>";
echo "Payment Amount: ";
echo $result['PAmount'];
echo "<br>";
echo "Payment Status: ";
echo $result['PStatus'];
echo "<br>";
echo "Payment Type: ";

$database = new DatabaseConnector();
$database->connect();

$query = "SELECT 1
		  FROM bankpayment
		  WHERE PaymentID = $pID";
if(!empty($database->query($query))) echo "Bank";
$query = "SELECT 1
		  FROM ccpayment
		  WHERE PaymentID = $pID";
if(!empty($database->query($query))) echo "Card";
$query = "SELECT 1
		  FROM invoice
		  WHERE PaymentID = $pID";
if(!empty($database->query($query))) echo "Invoice";
$query = "SELECT 1
		  FROM onlinepayment
		  WHERE PaymentID = $pID";
if(!empty($database->query($query))) echo "Online Service";
echo "<br>";
echo "Payment Date: ";
echo $result['PDate'];
echo "<br>";
echo "<br>";
}
//This counts the number or results - and if there wasn't any it gives them a little message explaining that
if (count($results)== 0)
{
echo "Sorry, but we can not find an entry to match your query...<br><br>";
}
?> 
<input type="button" name="back" value="Return to Administrator Page" 
onclick="window.location.href='AdminMainPage.php'"/>
</body>
</html>