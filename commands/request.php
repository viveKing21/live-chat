<?php
include "connect.php";
//showing request that available
if(isset($_GET['myNameis'])  && isset($_GET['request_div']))
{
$sql=$con->query("select *from ".$_GET['myNameis']." where type='recieve'");
if($sql->rowCount() > 0)
{
   if($sql->rowCount() > $_GET['request_div'])
   {
      echo "added";
      for($i=0; $i<$sql->rowCount(); $i++)
      {
      	$result=$sql->fetch();
      	echo "<div class='notificationRequest' data-check-request='".$result[0]."'><div>".substr($result[0],0,strlen($result[0])-4)."</div><div  onclick=chatStart('".$result[0]."')><i class='fas fa-comment'></i></div></div>";
      }
   }
   else if($sql->rowCount() < $_GET['request_div'])
   {
   	echo "gone";
   	   for($i=0; $i<$sql->rowCount(); $i++)
      {
      	$result=$sql->fetch();
      	echo "<div class='notificationRequest' data-check-request='".$result[0]."'><div>".substr($result[0],0,strlen($result[0])-4)."</div><div  onclick=chatStart('".$result[0]."')><i class='fas fa-comment'></i></div></div>";
      }

   }
}
else
	echo "<h3>No request available!</h3>";
}
//removing if use left the chat
if(isset($_GET['checkRequest']) && isset($_GET['myName']))
{
$sql=$con->query("select *from users where name='".$_GET['checkRequest']."'");
if($sql->rowCount() > 0)
	echo "found";
else
   {
   	$con->query("delete from ".$_GET['myName']." where name='".$_GET['checkRequest']."'");
   	echo $_GET['checkRequest'];
   } 
}
?>
