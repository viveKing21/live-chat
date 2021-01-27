<link rel="stylesheet" type="text/css" href="css/all.css">
<link rel="stylesheet" type="text/css" href="style/index.css">
<div class="containers">

	<div class="userArea">
		<img src="https://i.pinimg.com/originals/da/b2/31/dab231a410b1e8a1cbe2e7ba6463f99c.gif">
		<form action="chatHere.php" method="post" onsubmit="return validate(this)">
		<input type="text" name="name" placeholder="Name">
		<input type="submit" name="submit" >
		</form>
		<div class="showError">
			
		</div>
	</div>
	
</div>
<script type="text/javascript">
var error=document.querySelector(".showError");
function validate(form){
  var server=new XMLHttpRequest();
  server.onreadystatechange=function(){
	  if(server.readyState==4 && server.status==200)
	  {
	  	if(server.responseText=="A")
	  	{
		    if(form.name.value.length < 6 || form.name.value.length > 10)
		    {
                   error.innerText="*Name length must between 6 to 10";
                   form.name.classList.add("inputTextRed");
                   form.name.focus();
		    }
		    else if(form.name.value.search(/[a-z]/)=="-1")
		    {
			        error.innerText="*Atleast one character needed";
			        form.name.classList.add("inputTextRed");
			        form.name.focus();
		    }
		    else if(form.name.value.search(/[0-9]/)=="-1")
		    {
			        error.innerText="*Atleast one numeric value needed";
			        form.name.classList.add("inputTextRed");
			        form.name.focus();
		    }
		    else
		    {
			        error.innerText="";
			        form.name.classList.remove("inputTextRed");
			        form.name.classList.add("inputTextGreen");
			        form.setAttribute('onsubmit','validate(this)');
			        form.submit.click();
			        form.submit.setAttribute("disabled","true");
		    }
	    }
	    else
	    {
	 	            error.innerText="*Username is already exist (Try another)";
			        form.name.classList.add("inputTextRed");
			        form.name.focus();
	    }
	 }
	 
  }
  server.open("GET","commands/cmd.php?userName="+form.name.value,true);
  server.send();
     
return false;
}
</script>