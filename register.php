<?php
require_once("file://localhost/Users/DomFibich/Sites/eatsnation/mobile/resources/php/inc/connect.inc.php");
# sanitize input
$phoneNumber= mysql_real_escape_string($_POST['input0']);
$desiredUserPassword = mysql_real_escape_string($_POST['input2']);
#create a hash of the password
$hashpwd = hash('sha256',$desiredUserPassword);
# adding salt to hash
$salt = createSalt();
$hash=hash('sha256', $salt.$hashpwd);

$query = "INSERT INTO `eatsnation`.`tbl_customers` (`customer_id`, `customer_phone_number`, `customer_verified`, `password`, `salt`) VALUES (NULL, '$phoneNumber', '0', '$hash', '$salt');";

#Attempt to create user. If succesfull return if the staus of "verified" user is verified. If verified redirect to homepage else return error
if (mysql_query($query))
{

	$query ="SELECT `customer_id`,`customer_phone_number`,`customer_verified` FROM `tbl_customers` WHERE customer_phone_number LIKE '$phoneNumber' LIMIT 0, 1;";

		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		echo("Thank you for being a part of eatsnation ".$row['customer_phone_number']);
}
else 
{
	echo("Apologies, the account could not be created");
}


mysql_close($con);

//creates a 3 character sequence
function createSalt()
{
    $string = md5(uniqid(rand(), true));
    return substr($string, 0, 3);
}

?>