<?php
try{
$con=new PDO("mysql:host=localhost;dbname=livechat","root");
}
catch(PDOException $e)
{
	echo ($e->getMessage());
}
?>