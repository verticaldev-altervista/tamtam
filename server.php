<?php
	$scope=@$_GET['scope'];
	$room=@$_GET['room'];if($room=='')$room=@$_POST['room'];
	$user=@$_GET['user'];if($user=='')$user=@$_POST['user'];
	$message=@$_GET['message'];if($message=='')$message=@$_POST['message'];
	
	$delete=@$_GET['delete'];
	if($delete!="" && $room!=""){
		unlink ("rooms/$room");
		unlink ("rooms/$room".".list");		
		echo "<script>location='./';</script>";
	}
	
	if($room!="" && $user!='' && $message!=''){
		$lu=@file("rooms/$room".".list");
		$listuser=join($lu);
		for($i=0;$i<count($lu);$i++){
			if(date($lu[$i])< date('d-m-Y H:i:s',strtotime(date()."- 5 minuts"))||strpos($listuser,$user)!=false){
				unset($lu[$i]);
				$listuser=join($lu);
				unlink ("rooms/$room".".list");		
				$f=fopen("rooms/$room".".list","w");
				fwrite($f,join($lu));
				fclose($f);					
			}
		}
		if(strpos($listuser,$user)==false){
			$f=fopen("rooms/$room".".list","a");
				fwrite($f,date("Y-m-d H:i:s")."-".$user."\n");
			fclose($f);			
		}
		$f=fopen("rooms/$room","a");
			fwrite($f,$user.":".$message."\n");
		fclose($f);
	}
	switch ($scope){
	case "listhtml":
		echo str_replace("\n","<br>",join(@file("rooms/$room".".list")));
		break;
	case "list":
		echo join(@file("rooms/$room".".list"));
		break;
	
	
	case "html":
		echo str_replace("\n","<br>",join(@file("rooms/$room")));
		break;	
	default:
		echo join(@file("rooms/$room"));
		break;
	}
?>
