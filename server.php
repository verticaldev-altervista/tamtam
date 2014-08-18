<?php
	$alt=$_GET['alt'];
	$room=$_GET['room'];if($room=='')$room=$_POST['room'];
	$user=$_GET['user'];if($user=='')$user=$_POST['user'];
	$message=$_GET['message'];if($message=='')$message=$_POST['message'];
	
	$delete=$_GET['delete'];
	if($delete!="" && $room!=""){
		unlink ("rooms/$room");
		echo "<script>location='./';</script>";
	}
	
	if($room!="" && $user!='' && $message!=''){
		$f=fopen("rooms/$room","a");
			fwrite($f,$user.":".$message."\n");
		fclose($f);
	}
	switch ($alt){
	case "html":
		echo str_replace("\n","<br>",join(@file("rooms/$room")));
		break;	
	default:
		echo join(@file("rooms/$room"));
		break;
	}
?>
