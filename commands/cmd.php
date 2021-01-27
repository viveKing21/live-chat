<?php
include("connect.php");
if(isset($_GET['userName']))
{
$check=$con->query("select *from users where name LIKE'".$_GET['userName']."____'");
if($check->rowCount() > 0)
  echo "NA";
else
  echo "A";
}
if(isset($_GET['showRequest']) && isset($_GET['myNameis']) )
{
	$con->query("insert into ".$_GET['showRequest']."(name,type)value('".$_GET['myNameis']."','recieve')");
	$con->query("insert into ".$_GET['myNameis']."(name,type)value('".$_GET['showRequest']."','sent')");
}
?>