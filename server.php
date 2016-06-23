<?php

function get_sb(){
    if (!file_exists("rooms")){
		mkdir("rooms",0755);
	    $fp=fopen("rooms/$sbdir/index.php","a");fwrite($fp,"\n"); fclose($fp);
	}
    $hdir=opendir("rooms");
    while (false !== ($f= readdir($hdir)))
      if ($f[0]!='.' && $f!="index.php") $sbdir=$f;
    closedir($hdir);
  if ($sbdir==""){
    $sbdir=rand(1000,9000)."-".rand(1000,9000)."-".rand(1000,9000)."-".rand(1000,9000)."-".rand(1000,9000)."-".rand(1000,9000)."-".rand(1000,9000)."-".rand(1000,9000);
    //echo $sbdir;
    mkdir("rooms/".$sbdir,0755);
    $fp=fopen("rooms/$sbdir/index.php","a");fwrite($fp,"\n"); fclose($fp);
  }
  return $sbdir;
}

function data2ts($data) {
  $d = explode(' ',$data);
  $dt = explode('-',$d[0]);
  $or = explode(':',$d[1]);
  $y = $dt[0];
  $m = $dt[1];
  $d = $dt[2];
  $h = $or[0];
  $i = $or[1];
  $s = $or[2];
  return gmmktime($h, $i, $s, $m, $d, $y);
}
//------------------------------------------------------------------------------------------

	$scope=@$_GET['scope'];
	$room=@$_GET['room'];if($room=='')$room=@$_POST['room'];
	$user=@$_GET['user'];if($user=='')$user=@$_POST['user'];
	$message=@$_GET['message'];if($message=='')$message=@$_POST['message'];

	if ($user!=""){
		$user.=": ";
		$u=split(":",$user);
		$user=$u[0]."<<".md5($u[1]).">>";
	}	

	$delete=@$_GET['delete'];
	if($delete!="" && $room!=""){
		if(file_exists("rooms/".get_sb()."/".$room))unlink ("rooms/".get_sb()."/".$room);
		if(file_exists("rooms/".get_sb()."/".$room.".list"))unlink ("rooms/".get_sb()."/".$room.".list");		
		echo "<script>location='./';</script>";
	}
	
	if($room!="" && $user!=''){
		$lu=@file("rooms/".get_sb()."/".$room.".list");
		$listuser=join($lu);
		for($i=0;$i<count($lu);$i++){
			if( strpos($lu[$i],$user)!=false ||(time()- data2ts(substr($lu[$i],0,19))) >300){
				unset($lu[$i]);
			
				$listuser=join($lu);
				unlink ("rooms/".get_sb()."/".$room.".list");		
				$f=fopen("rooms/".get_sb()."/".$room.".list","w");
				fwrite($f,join($lu));
				fclose($f);
			}					
		}
		if(strpos($listuser,substr($user,0,-36))==false){
			$f=fopen("rooms/".get_sb()."/".$room.".list","a");
				fwrite($f,date("Y-m-d H:i:s")."-".$user."\n");
			fclose($f);			
		}
		else{
			if(strpos($listuser,substr($user,0,-36))!=false){
				if(strpos($listuser,$user)==false){
					$message="";
				}
			}
		}
	
		if($message!=""){
			$f=fopen("rooms/".get_sb()."/".$room,"a");
    			fwrite($f,substr($user,0,-36).":".$message."\n");
			fclose($f);
		}
	}

	switch ($scope){
	case "listhtml":
		$tmp=@file("rooms/".get_sb()."/".$room.".list");
		for ($i=0;$i<count($tmp);$i++)$tmp[$i]=substr($tmp[$i],0,-37)."\n";
		echo str_replace("\n","<br>",$tmp);
		break;
	case "list":
		$tmp=@file("rooms/".get_sb()."/".$room.".list");
		for ($i=0;$i<count($tmp);$i++)$tmp[$i]=substr($tmp[$i],0,-37)."\n";
		echo join($tmp);
		break;
	
	case "html":
		echo str_replace("\n","<br>",join(@file("rooms/".get_sb()."/".$room)));
		break;	
	default:
		echo join(@file("rooms/".get_sb()."/".$room));
		break;
	}
?>
