<?php
include "connect.php";
if(isset($_GET['chatwith']) && isset($_GET['myNameis']))
{
$with="b".$_GET['chatwith'];
$me="a".$_GET['myNameis'];
$a=$con->query("update users set status='live', chatting='".$with."' where name='".$_GET['myNameis']."'");
$b=$con->query("update users set status='live', chatting='".$me."' where name='".$_GET['chatwith']."'");
$c=$con->query("delete from ".$_GET['myNameis']." where name='".$_GET['chatwith']."'");
$d=$con->query("delete from ".$_GET['chatwith']." where name='".$_GET['myNameis']."'");
$e=$con->query("create table ".$_GET['myNameis'].$_GET['chatwith']."(name varchar(20),msg text(200))");
if($a && $b && $c && $b && $e)
	echo "start";
else
	echo "error";
}

if(isset($_GET['myNameisforchat']))
{
	$sql=$con->query("select *from users where name='".$_GET['myNameisforchat']."'");
	$row=$sql->fetch();
	$query=$con->query("select *from users where name='".substr($row[2],1)."'");
	if($query->rowCount() > 0)
	{
		if($row[1]=="live")
	    {
		echo "live ".$row[2];
	    }
	    else
	    	echo "notlive ".$row[2];
	}
	else
	{
		if($row[1]=="live")
	    {
		 $con->query("update users set status='active',chatting='null' where name='".$_GET['myNameisforchat']."'"); 
	    }
	    echo "notlive ".$row[2];
	}
}
?>