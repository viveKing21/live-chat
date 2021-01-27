<?php
include("connect.php");
error_reporting(0);
if(isset($_GET['myName']) && isset($_GET['usersLive']))
{
$sql=$con->query("select *from users where status='active' && name!='".$_GET['myName']."'");

if($sql->rowCount() > 0)
{
	if($sql->rowCount() > $_GET['usersLive'])
	{
		echo "added";
	   for($i=1; $i<=$sql->rowCount(); $i++)
	   {
	   	$result=$sql->fetch();
	   	if($i > $_GET['usersLive'])
	   	{
	   	$sql_request=$con->query("select *from ".$_GET['myName']." where name='".$result[0]."' && type='sent'");
	   	if($sql_request->rowCount() > 0)
	   	{
	   		echo '<div class="userSHOW" data-user="'.$result[0].'"><div><i class="fas fa-user"></i>'.substr($result[0],0,strlen($result[0])-4).'</div>
				   <div style="background:#8dc9ff" onclick=showRequest("'.$result[0].'")>Request Sent</div></div>';
	   	}
	   	else
	   	{
	   		echo '<div class="userSHOW" data-user="'.$result[0].'"><div><i class="fas fa-user"></i>'.substr($result[0],0,strlen($result[0])-4).'</div>
				   <div onclick=showRequest(this,"'.$result[0].'")>Send Request</div></div>';
	   	}
	   	}
	   }		
	}
	if($sql->rowCount() < $_GET['usersLive'])
	{
	   echo "gone";
	   for($i=1; $i<=$sql->rowCount(); $i++)
	   {
	   	$result=$sql->fetch();
	   	$sql_request=$con->query("select *from ".$_GET['myName']." where name='".$result[0]."' && type='sent'");
	   	if($sql_request->rowCount() > 0)
	   	{
	   		echo '<div class="userSHOW" data-user="'.$result[0].'"><div><i class="fas fa-user"></i>'.substr($result[0],0,strlen($result[0])-4).'</div>
				   <div style="background:#8dc9ff" onclick=showRequest("'.$result[0].'")>Request Sent</div></div>';
	   	}
	   	else
	   	{
	   		echo '<div class="userSHOW" data-user="'.$result[0].'"><div><i class="fas fa-user"></i>'.substr($result[0],0,strlen($result[0])-4).'</div>
				   <div onclick=showRequest(this,"'.$result[0].'")>Send Request</div></div>';
	   	}
	   }
	}
}
else
{
	echo "<h3>No ones active</h3>";
}
}
if(isset($_GET['checkMe']))
{
	$sql=$con->query("select *from users where status='active' && name='".$_GET['checkMe']."'");
	if($sql->rowCount() > 0)
       echo "found";
	else
		echo $_GET['checkMe'];
}
?>