<?php
	$server="server.php";
	$room=$_GET['room'];
	$user=$_GET['user'];
	$message=$_GET['message'];
?>
<html>
<body>

<form name='chat' action="<?=$server?>?alt=html" method='post' enctype='multipart/form-data' target='display' onsubmit="message.value=messageEntry.value;messageEntry.value='';" >
room <input type='text' name='room' id='room' value="<?=$room ?>">
<input type="button" value='cancella' onclick="location='<?=$server?>?delete=yes&room='+document.chat.room.value" target='display'> <br> 
<iframe name='display' id='display' onload='display.scrollTo(0,10000);'></iframe>
<iframe name='listusers' id='listusers' onload='display.scrollTo(0,10000);'></iframe>
<br>
user <input type='text' name='user' value="<?=$user ?>" ><br>
<input type='hidden' name='message' value="<?=$message ?>" >
message <input type='text' name='messageEntry'><button >invia</button><br>
</form>
</body>
<script>
	setInterval(function(){display.location="<?=$server?>?scope=html&room="+document.chat.room.value;listusers.location="<?=$server?>?scope=listhtml&room="+document.chat.room.value;},5000);
	if (document.chat.room.value=='')document.chat.room.value=prompt("please enter room name");
	if (document.chat.user.value=='')document.chat.user.value=prompt("please enter username");
	document.chat.submit();
</script>
</html>
