<?php
include("commands/connect.php");

if(isset($_POST['name']))
{
  $check=$con->query("select *from users where name LIKE '".$_POST['name']."____'");
  if($check->rowCount() > 0)
  {
    $con->query("delete from users where name LIKE '".$_POST['name']."____'");
    for($i=0; $i<$check->rowCount(); $i++)
    {
      $row=$check->fetch();
      $con->query("drop table ".$row[0]);
    }
  }
  $id=rand(10,10000);
  for($i=strlen($id); $i < 4; $i++)
  {
      $id=$id.rand(0,9);
  }
$_POST['name']=$_POST['name'].$id;
$name=substr($_POST['name'],0,strlen($_POST['name'])-4);
$con->query("insert into users(name,status,chatting)value('".$_POST['name']."','active','null')");
$con->query("create table ".$_POST['name']."(name varchar(100),type varchar(20))");
?>
<style type="text/css">
  body > *
  {
    user-select:none
  }
.chatAreaHere
{
  height:calc(100% - 38px);
  width:100%;
  padding-top:38px;
  position:relative;
  transition:.3s;
}
.addBlur > *
{
filter: blur(3px) ;

}
.chats
{
  height:100%;
  width:calc(100% - 20px);
  overflow-x: hidden;
  overflow-y: scroll;
  transform:rotate(180deg);
  padding:8px;
}
.chatAreaHere .chats div
{
  padding:4px;
  position:relative;
  transform:rotate(-180deg);
  padding-left:0;
  padding-right:0;
  float:left;
  width:100%;top:60px
}
.chatAreaHere .chats span
{
  padding:5px;
  background:#9def99;
  border-radius:5px;
  color:white;
  float:right;;
  max-width:45%;

}
/* width */
.chats::-webkit-scrollbar {
  width: 5px;z-index:99
}

/* Track */
.chats::-webkit-scrollbar-track {
  background: #d8d8d8;
}

/* Handle */
.chats::-webkit-scrollbar-thumb {
  background: #9c9c9c;
}

/* Handle on hover */
.chats::-webkit-scrollbar-thumb:hover {
  background: #555;
}
.chatAreaHere > div:last-child
{
  height:40px;
  width:calc(100% - 16px);
  position:absolute;
  padding:8px;
  bottom:0;
  left:0;
  background:#f2f2f291;
}
.chatAreaHere > div:last-child input
{
  width:100%;
  height:100%;
  padding-left:10px;
  padding-right:40px;
  border:1px solid #dadada;
  border-radius:5px;
  outline:none
}
.chatAreaHere > div:last-child i
{
  position:absolute;
  right: 13px;
  font-size:20px;
  top:11px;
  color:skyblue;
  padding:;
  height:27px;
  width:28px;
  border-radius:100%;
  padding-left:5px;
  padding-top:7px;
  transition:.5s
}
.chatAreaHere > div:last-child i:hover
{
  background: #e1f6ff;
}
.chatAreaHere > div:last-child:before
{
  content: "";
  position:absolute;height:100%;
  width:7px;
  background:#f2f2f2;
  left:0;
  top:0
}
button
{
  position:absolute;;
  top:10px;
  right:7px;
  border:none;
  outline:none;
  background:#ff9595;
  color:white;
  border-radius:2px;
  display:none;
  cursor:pointer;
}
button:hover
{
  background:#ff6f6f
}
[data-send-rqst],#msg
{
  user-select:all !important
}
.confirming
{
  position:absolute;
  width:30%;
  background:white;
  box-shadow:0 0 3px #00000040;
  padding-top:20px;
  top:44%;
  left:35%;
  text-align: center;
  z-index: 999;
  transform: scale(.5);
  transition:.3s linear;
  filter:blur(0px);
  visibility:hidden;
  pointer-events:none;
  overflow:hidden;
}
.confirm
{
  transform: scale(1);
  visibility:visible;
  pointer-events:auto;
}
.confirming input
{
  width:50%;
  background:#e4e4e4;
  float:left;
  border:none;
  margin-top:20px;
  transition: background .3s;
  outline: none;
  
}
.confirming input:hover
{
  background:#d2d2d2
}
.confirming input:nth-of-type(1)
{
    border-right:1px solid #cbcbcb
}
.onleft {
  font-size:12px;
  text-align: center;
  color:gray
}
.userArea img
{
  position:absolute;
  height:70%;
  width:70%;
  left:15%;
  top:15%
}
.timer
{
  padding:5px;
  padding-top:1;
  padding-bottom:0;
  color:#7d7d7d;
  background:white;
  box-shadow:0 0 5px #d0d0d0;
  position: absolute;
  top:10%;
  left:calc(50% - 20px);
  border-radius:3px;
  font-size:15px;
  transition:1s;
  z-index: 9999
}
.info
{
  position:absolute;
  bottom:20px;
  padding:5px;
  background:none;
  text-align: center;
  width:100%;
  font-weight:normal;
  color:#ffa4a4;
  
} 
</style>
<link rel="stylesheet" type="text/css" href="css/all.css">
<link rel="stylesheet" type="text/css" href="style/chat.css">
<div class="containers">

	<div class="userArea">
    <div class="timer">00:00</div>
    <h5 class="info">You can talk just for 30 minutes after that you'll be removed</h5>
    <img src="img/bot.gif" id="botImg">
	<p>
    <span><i class="fas fa-user-circle"></i>
     <?php echo $name;?>
    </span>
     Chatting with <b id="chatwith" style="font-weight:normal;">Bot</b>
     <button onclick="leaveChat()">leave</button>
   </p>
   <div class="chatAreaHere" style="display:none">
    <div class="confirming">
      Are your sure?<br>
      <input type="button" value="Yes" onclick="clickedYes()">
      <input type="button" value="No" onclick="clickedNo()">
    </div>
    <div class="chats">
   </div>
     <div><input type='text' placeholder="Type your message!" id="msg"><i class="fas fa-paper-plane" onclick="sendmsg(this)" id="sendArrow"></i></div>
   </div>
  <div class="notification">
    <div id="title">Request<i class="fas fa-sort-up upsideArrow"></i></div>
    <div class="showingRequest" data-check="down">
    </div>
  </div>
	</div>

	<div class="liveUsers">
        
		<p>Live Users</p>
		<div class="users">
	    </div>
	</div>
</div>
<script type="text/javascript">
//on exit or leave
  window.onbeforeunload=function(){
    navigator.sendBeacon("commands/delete.php?removeComp=<?php echo $_POST['name']?>");
  }

//fx for notification
document.getElementById('title').onclick=function(){
  var notify=document.querySelector('.showingRequest');

if(notify.getAttribute("data-check")=="down")
{
  notify.style.height="200px";
  notify.setAttribute("data-check","up");
  document.querySelector(".upsideArrow").style.transform="rotate(180deg) translateY(5px)";
}
else
{
  notify.style.height="0px";
  notify.setAttribute("data-check","down");
  document.querySelector(".upsideArrow").removeAttribute("style");
}
}

//showing live chats
var userShow=document.querySelector(".users");
var usersLive=document.getElementsByClassName("userSHOW");
setInterval(function(){
var server=new XMLHttpRequest();
server.onreadystatechange=function(){
  if(server.readyState==4 && server.status==200)
  {
     
      if(server.responseText=="<h3>No ones active</h3>" && userShow.innerHTML !=="<h3>No ones active</h3>")
      {
        userShow.innerHTML=server.responseText;
      }
      else if (server.responseText.slice(0,5)=="added"){
        if(usersLive.length > 0)
        userShow.innerHTML+=server.responseText.slice(5);
        else
        userShow.innerHTML=server.responseText.slice(5);
      }
      else if(server.responseText.slice(0,4)=="gone")
      {
        userShow.innerHTML=server.responseText.slice(4);
      }
  }
}
server.open("GET","commands/live.php?myName=<?php echo $_POST['name']?>&usersLive="+usersLive.length,true);
server.send();
if(usersLive.length > 0)
onuserLeft();
showingRequest();
if(document.getElementsByClassName("notificationRequest").length > 0)
checkRequest();
chatStarted();
},500);

//checking all user continuously
var count=0;
function onuserLeft(){
  if(usersLive[count])
  var getValue=usersLive[count].getAttribute("data-user");
  for(var i=0; i<usersLive.length; i++)
  {
    for(var j=0; j<usersLive.length; j++)
    {
      if(usersLive[i].getAttribute("data-user")==usersLive[j].getAttribute("data-user") && i !== j)
      {
         userShow.innerHTML="";
      }
      
    }
  }
  var server=new XMLHttpRequest();
  server.onreadystatechange=function(){
    if(server.readyState==4 && server.status==200)
    {
      if(server.responseText=="found")
      {
        count++;
          if(count >usersLive.length-1)
          {
            count=0;
          }
      }
      else
      {
        if(document.querySelector("[data-user='"+server.responseText+"']"))
        document.querySelector("[data-user='"+server.responseText+"']").remove();
        
      }
    }

  }
  server.open("GET","commands/live.php?checkMe="+getValue,true);
  server.send();

}
//sending request
function showRequest(element,name){
  var result=new XMLHttpRequest();
  result.onreadystatechange=function(){
    if(result.readyState==4 && result.status==200)
    {
           element.style="background:#8dc9ff";
           element.innerHTML="Request Sent";
    }
  }
  result.open("GET","commands/cmd.php?showRequest="+name+"&myNameis=<?php echo $_POST['name'];?>",true);
  result.send();
}

//showing request
 var requestBox=document.querySelector(".showingRequest");
  var notify=document.getElementsByClassName("notificationRequest");
function showingRequest(){ 
  var server=new XMLHttpRequest();
  server.onreadystatechange=function(){
   if(server.readyState==4 && server.status==200)
   {
    if(server.responseText=="<h3>No request available!</h3>" && requestBox.innerHTML !=="<h3>No request available!</h3>")
    {
       requestBox.innerHTML=server.responseText;
    }
    else if(server.responseText.slice(0,5)=="added")
    {
      if(requestBox.length > 0)
        requestBox.innerHTML+=server.responseText.slice(5);
      else
        requestBox.innerHTML=server.responseText.slice(5);
    }
    else if((server.responseText.slice(0,4)=="gone"))
    {
      requestBox.innerHTML=server.responseText;
    }
   
   }
  }
  server.open("GET","commands/request.php?myNameis=<?php echo $_POST['name'];?>&request_div="+notify.length+"",true);
  server.send();
}
var count_two=0;
function checkRequest(){
  if(notify[count_two])
  var requestVal=notify[count_two].getAttribute("data-check-request");

    for(var i=0; i<notify.length; i++)
  {
    for(var j=0; j<notify.length; j++)
    {
      if(notify[i].getAttribute("data-user")==notify[j].getAttribute("data-user") && i !== j)
      {
         notify.innerHTML="";
      }
      
    }
  }

  var serv=new XMLHttpRequest();
  serv.onreadystatechange=function(){
    if(serv.readyState==4 && serv.status==200)
    {
       if(serv.responseText=="found")
       {
            count_two++;
            if(count_two > notify.length-1)
            {
              count_two=0;
            }
       }
       else
       {
         if(document.querySelector("[data-check-request='"+serv.responseText+"']"))
        document.querySelector("[data-check-request='"+serv.responseText+"']").remove();
       }
    }
  }
  serv.open("GET","commands/request.php?checkRequest="+requestVal+"&myName=<?php echo $_POST['name'];?>",true);
  serv.send();
}

//chatStart
var iwasLive=false;
function chatStart(chatwith)
{
  var server=new XMLHttpRequest();
  server.open("GET","commands/chatStart.php?myNameis=<?php echo $_POST['name'];?>&chatwith="+chatwith,true);
  server.send();
}
  var classOFuSER=document.getElementsByClassName("userSHOW");
function chatStarted()
{
  var result=new XMLHttpRequest();
  result.onreadystatechange=function(){
    if(result.readyState==4 && result.status==200)
    {
      var checkLiveornot=result.responseText.split(" ");
       if(checkLiveornot[0] == "live")
       {
        if(chatwith.innerText !==checkLiveornot[1].slice(1,checkLiveornot[1].length-4))
          chatwith.innerText=checkLiveornot[1].slice(1,checkLiveornot[1].length-4);
         document.querySelector(".notification").style.display="none";
         document.querySelector(".chatAreaHere").style.display="block";
        document.querySelector('button').style.display="block";
        document.querySelector(".info").style.display="none";
        document.getElementById("botImg").style.display="none";
         if(!(document.getElementById("sendArrow").getAttribute("onclick")))
         {
          document.getElementById("sendArrow").setAttribute("onclick","sendmsg(this)");
         }
         showingMSG();
         iwasLive=true;
       }
       else
       {
        if(iwasLive && chatwith.innerText !=="")
        {
          var newItem = document.createElement("div");
           newItem.setAttribute("class","onleft");
           newItem.innerHTML=document.getElementById("chatwith").innerText+" left the chat";;
           var list = document.querySelector(".chats");
           list.insertBefore(newItem, list.childNodes[0]);
           document.getElementById("sendArrow").removeAttribute("onclick");

           iwasLive=false;
        }

       }
    }
  }
  result.open("GET","commands/chatStart.php?myNameisforchat=<?php echo $_POST['name'];?>",true);
  result.send();
}

function showingMSG(){

  if(document.getElementsByClassName("textMSG"))
  var textMSG=document.getElementsByClassName("textMSG");
  var chatShow=document.querySelector(".chats");
  var result=new XMLHttpRequest();
  result.onreadystatechange=function(){
    if(result.readyState==4 && result.status==200)
    {
       if(result.responseText.slice(0,3)=="add")
       {
           var newItem = document.createElement("div");
           newItem.setAttribute("class","textMSG");
           newItem.innerHTML=result.responseText.slice(3);
           var list = document.querySelector(".chats");
           list.insertBefore(newItem, list.childNodes[0]);
       }
    }
  }
  result.open("GET","commands/showingmsg.php?myNameis=<?php echo $_POST['name'];?>&textBox="+textMSG.length,true);
  result.send();

  }
  function sendmsg(element){

    if(msg.value.length == 0)
       msg.focus();
    else
    {element.style.setProperty("pointer-events","none");
      var result=new XMLHttpRequest();
      result.onreadystatechange=function(){
        if(result.readyState==4 && result.status==200)
        {
          element.style.setProperty("pointer-events","auto");
          msg.value="";
        }

      }
       result.open("GET","commands/showingmsg.php?tableFind=<?php echo $_POST['name'];?>&msg="+msg.value,true);
       result.send();
     }
  }

  function leaveChat(){
    document.querySelector(".chatAreaHere").classList.add("addBlur");
    document.querySelector(".confirming").classList.add("confirm");
  }
      function clickedYes(){
    var server=new XMLHttpRequest();
    server.onreadystatechange=function(){
      if(server.readyState==4 && server.status==200)
      {
        document.getElementById("sendArrow").removeAttribute("onclick");
        chatwith.innerText="";
        document.querySelector(".chats").innerHTML="";
        document.querySelector(".notification").style.display="block";
         document.querySelector(".chatAreaHere").style.display="none";
        document.querySelector('button').style.display="none";
        document.querySelector(".chatAreaHere").classList.remove("addBlur");
        document.querySelector(".confirming").classList.remove("confirm");
        document.querySelector(".info").style.display="block";
        document.getElementById("botImg").style.display="block";
      }
    }
    server.open("GET","commands/delete.php?myNameis=<?php echo $_POST['name'];?>",true);
    server.send();
    }
    function clickedNo(){
      document.querySelector(".chatAreaHere").classList.remove("addBlur");
    document.querySelector(".confirming").classList.remove("confirm");
    }

    setInterval(function(){
      if(document.querySelector('.chatAreaHere').style.display=="none")
      {

       if(classOFuSER.length !== 0)
         {
          for(var i=0; i<classOFuSER.length; i++)
          {
          classOFuSER[i].children[1].style.setProperty("pointer-events","auto");
          classOFuSER[i].style.cursor="pointer";
          }
         }
      }
      else
      {
         if(classOFuSER.length !== 0)
         {
          for(var i=0; i<classOFuSER.length; i++)
          {
          classOFuSER[i].children[1].style.setProperty("pointer-events","none");
          classOFuSER[i].style.cursor="not-allowed";
          }
         }
      }

    })

var timer=document.querySelector(".timer"),min="00",sec=0;
setInterval(function(){


if(sec==60)
{
  min++;
  sec=0;
  if(min < 10)
   min="0".concat(min);
}
if(sec < 10)
    sec="0".concat(sec);
timer.innerText=min+":"+sec;
sec++;
  
if(min>=30)
{
  if(alert("Time is Left, Thanks for visiting"))
  window.location.href="index.php";
}

},1000)

window.onload=timer.onmouseleave=function(){
  setTimeout(function(){
    timer.style.cssText="opacity:0;";
  },5000)
}
timer.onmouseenter=function(){
  timer.style.cssText="opacity:1;";
}
</script>




<?php 
}
else
header("Location: index.php");
?>