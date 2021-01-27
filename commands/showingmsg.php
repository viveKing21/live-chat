<?php

include "connect.php";
if(isset($_GET['myNameis']) && isset($_GET['textBox']))
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
    $query=$con->query("select *from ".strtolower($table));
    if($query->rowCount() > 0)
    {
    	if($query->rowCount() > $_GET['textBox'])
    	{
    		echo "add";
    		for($i=1; $i <=$query->rowCount(); $i++)
    		{
    			$row=$query->fetch();
    			if($i>$_GET['textBox'])
    			{
    			   if($row[0] !== $_GET['myNameis'])
    			    echo "<span data-send-rqst style='float:left; background:white; color:#424242'>".$row[1]."</span>";
    			   else
                    echo "<span data-send-rqst>".$row[1]."</span>";
    			}
    		}
    	}
    }
} 
if(isset($_GET['tableFind']) && isset($_GET['msg']))
{
	$sql=$con->query("select *from users where name='".$_GET['tableFind']."' and status='live'");
    $row=$sql->fetch();
    if(substr($row[2],0,1)=="a")
    {
    	$table=strtolower(substr($row[2],1).$row[0]);
    }
    else
    {
        $table=strtolower($row[0].substr($row[2],1));
    }
    $con->query("insert into ".$table."(name,msg)value('".$_GET['tableFind']."','".$_GET['msg']."')");
}
?>