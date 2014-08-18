<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width,initial-scale=1.0'>		
<script>
var server='http://verticaldev.altervista.org/tamtam/server.php';
function parseGetVars(){
  var args = new Array();
  var query = window.location.search.substring(1);
  if (query){
    var strList = query.split('&');
    for(str in strList){
      var parts = strList[str].split('=');
      args[unescape(parts[0])] = unescape(parts[1]);
    }
  }
  return args;
}
var get=parseGetVars();

function ahah(url,target){
  if (window.XMLHttpRequest){
	var req = new XMLHttpRequest();
  } else if (window.ActiveXObject){
	var req = new ActiveXObject("Microsoft.XMLHTTP");
  }
  if (req) {
	req.onreadystatechange = function(){ahahDone(req,url, target);};
	req.open('post', url, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.send('');
  }
}

function ahahDone(req,url,target){
  if (req.readyState == 4){ 
    if (req.status == 200){ 
      	document.getElementById(target).innerHTML = req.responseText;
    }else{
      	document.getElementById(target).innerHTML="ahah error:\n"+req.statusText;
    }
  }
}
</script>
</head>
<body>
<h1>minimalistic demo</h1>
room <input type='text' name='room' id='room' value="">
<input type="button" value='cancella' onclick="location=server+'?delete=yes&room='+room.value" target='display'> <br> 
<textarea name='display' id='display' style="width:320px;height:350px;"></textarea><br>
user <input type='text' name='user' id='user' value="" ><br>
<input type='text' name='message' id='message' style="width:270px;" onkeydown="if(event.keyCode==13){ahah(server+'?scope=text&room='+room.value+'&user='+user.value+'&message='+message.value,'display');message.value='';display.scrollTop = display.scrollHeight;}">
<button onclick="ahah(server+'?scope=text&room='+room.value+'&user='+user.value+'&message='+message.value,'display');message.value='';display.scrollTop = display.scrollHeight;" >invia</button><br>
</body>
<script>
	setInterval(function(){ahah(server+'?scope=text&room='+room.value,'display');display.scrollTop = display.scrollHeight;},5000);
	room.value=get['room'];
	user.value=get['user'];
	if (room.value=='undefined')room.value=prompt("please enter room name");
	if (user.value=='undefined')user.value=prompt("please enter username");
	ahah(server+'?scope=text&room='+room.value,'display');
	display.scrollTop = display.scrollHeight;
</script>

</html>
	
