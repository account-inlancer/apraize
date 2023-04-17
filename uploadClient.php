<?php
$con = mysqli_connect("localhost","hyperise","Hyperise@2022","hyperise_demo");

if($con){
	$type = $_POST['type'];
	$uid = $_POST['uid'];
	$name = $_POST['name'];
	$city = $_POST['city'];
	$imagepath = $_POST['imagepath'];
	$remark = $_POST['remark'];
	$visit = @$_POST['visit'];
	$server_id = null;
	
	if($type == "add"){
	    $client_id = $_POST['client_id'];
	    $sql = "SELECT * FROM clients WHERE user_id='".$uid."' AND client_id='".$client_id."';";
		$result = mysqli_query($con,$sql);
		if(mysqli_num_rows($result)>0){
			$sql1 = "UPDATE clients SET name='".$name."', city='".$city."', imagepath='".$imagepath."', remark='".$remark."', visit='".$visit."' WHERE user_id='".$uid."' AND client_id='".$client_id."';";
		}else{
		    $sql1 = "INSERT INTO clients (user_id,client_id,name,city,imagepath,remark,visit) values ('".$uid."','".$client_id."','".$name."','".$city."','".$imagepath."','".$remark."','".$visit."');";
		}
		$result1 = mysqli_query($con,$sql1);	
		if($result1){
			$data_code = "2001";
			$sql2 = "SELECT * FROM clients WHERE user_id='".$uid."' AND client_id='".$client_id."';";
			$result2 = mysqli_query($con,$sql2);
			if(mysqli_num_rows($result2)>0){
				$row = mysqli_fetch_assoc($result2);
				$server_id = $row["id"];
			}
		}else{
			$data_code = "2002";
		}
	}
	if($type == "edit"){
		$server_id = $_POST['server_id'];
		$sql = "UPDATE clients SET name='".$name."', city='".$city."', imagepath='".$imagepath."', remark='".$remark."', visit='".$visit."' WHERE id='".$server_id."';";
		$result = mysqli_query($con,$sql);	
		if($result){
			$data_code = "2001";
		}else{
			$data_code = "2002";
		}
	}
	
	echo json_encode(array('response_code'=>$data_code,'server_id'=>$server_id));
	mysqli_close($con);
}
?>