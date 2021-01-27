<?php
include("connect.php");
if(isset($_GET['removeComp']))
{
	

	$sql=$con->query("select *from users where name='".$_GET['removeComp']."'");
	$row=$sql->fetch();
	if($row[1]=="live")
	{
		$sql=$con->query("select *from users where name='".$_GET['removeComp']."'");
        $row=$sql->fetch();
       if(substr($row[2],0,1)=="a")
       {
         	$table=substr($row[2],1).$row[0];
       }
       else
       {
            $table=$row[0].substr($row[2],1);
       }
       $query=$con->query("drop table ".$table);
       if($query)
       {
       	  $con->query("delete from users where name='".$_GET['removeComp']."'");
	      $con->query("drop table ".$_GET['removeComp']);
       }
	}
	else
	{
		$con->query("delete from users where name='".$_GET['removeComp']."'");
	    $con->query("drop table ".$_GET['removeComp']);
	}
}
if(isset($_GET['myNameis']))
{
	$sql=$con->query("select *from users where name='".$_GET['myNameis']."' and status='live'");
    $row=$sql->fetch();
    if(substr($row[2],0,1)=="a")
    {
    	$table=substr($row[2],1).$row[0];
    }
    else
    {
        $table=$row[0].substr($row[2],1);
    }
    $result=$con->query("drop table ".$table);
    if($result)
    {
    	$con->query("update users set status='active',chatting='null' where name='".$_GET['myNameis']."' or name='".substr($row[2],1)."'");
    }
}
?>