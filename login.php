<?php
$con = mysqli_connect("localhost","hyperise","Hyperise@2022","hyperise_demo");

if($con){
	$uname = $_POST['uname'];
	$password = $_POST['password'];
	$user_fcm = $_POST['user_fcm'];
	$response = array();
	$data = array();
	
	$sql = "SELECT * FROM appusers WHERE username='".$uname."' AND password='".$password."'";
	$result = mysqli_query($con,$sql);
	
	if(mysqli_num_rows($result)>0){
		$row = mysqli_fetch_assoc($result);
		$id = $row["id"];
		
        $update_sql = "UPDATE appusers SET user_fcm = '".$user_fcm."' WHERE id=".$id;
        
        if ($con->query($update_sql) === TRUE) {
        }

		$data_status['data_code'] = "2001";
		$a = $row["A"];
		if($a==1){
			array_push($response,array('u_id'=>$id,'dept_id'=>'0'));
		}
		$b = $row["B"];
		if($b==1){
			array_push($response,array('u_id'=>$id,'dept_id'=>'1'));
		}
		$c = $row["C"];
		if($c==1){
			array_push($response,array('u_id'=>$id,'dept_id'=>'2'));
		}
		$d = $row["D"];
		if($d==1){
			array_push($response,array('u_id'=>$id,'dept_id'=>'3'));
		}
		
	}else{
		$data_status['data_code'] = "2002";
	}
	
	echo json_encode(array('response_code'=>$data_status,'response'=>$response));
	mysqli_close($con);
}
?>