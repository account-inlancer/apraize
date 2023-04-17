<?php
$con = mysqli_connect("localhost","hyperise","Hyperise@2022","hyperise_demo");

if($con){
	$uname = $_POST['uname'];
	$password = $_POST['password'];
	$user_fcm = $_POST['user_fcm'];
	$response = array();
	
	$sql = "SELECT * FROM appusers WHERE is_delete = 0 AND username='".$uname."' AND password='".$password."'";
	$result = mysqli_query($con,$sql);
	
	if(mysqli_num_rows($result)>0){
		$row = mysqli_fetch_assoc($result);
		$data_code = "2001";
		$id = $row["id"];
		$allow = $row["allowance"];
		
        $update_sql = "UPDATE appusers SET user_fcm = '".$user_fcm."' WHERE id=".$id;
        
        if ($con->query($update_sql) === TRUE) {
        }else{
            exit();
        }
		
		
		$a = $row["A"];
		if($a==1){
			array_push($response,array('u_id'=>$id,'dept_id'=>'0','allow'=>$allow));
		}
		$b = $row["B"];
		if($b==1){
			array_push($response,array('u_id'=>$id,'dept_id'=>'1','allow'=>$allow));
		}
		$c = $row["C"];
		if($c==1){
			array_push($response,array('u_id'=>$id,'dept_id'=>'2','allow'=>$allow));
		}
		$d = $row["D"];
		if($d==1){
			array_push($response,array('u_id'=>$id,'dept_id'=>'3','allow'=>$allow));
		}
		
	}else{
		$data_code = "2002";
	}
	
	echo json_encode(array('response_code'=>$data_code,'response'=>$response));
	mysqli_close($con);
}
?>