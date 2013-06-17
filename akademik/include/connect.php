<?php
$MySQL = new MySQL;
if ($MySQL->Connect($mysql_host,$mysql_user,$mysql_password,0))
	$serverStatus="Connect";
else
	$serverStatus="Not Connect";

if ($MySQL->Database($mysql_database,0))
	$dbStatus="Connect";
else
	$dbStatus="Not Connect";
	
$MySQL2 = new MySQL;
$MySQL2->conn[0]=$MySQL->conn[0];
//$MySQL3 = new MySQL;
//$MySQL3->conn[0]=$MySQL->conn[0];

$MySQL3 = new MySQL;
$MySQL3->conn[0]=$MySQL->conn[0];

?>
