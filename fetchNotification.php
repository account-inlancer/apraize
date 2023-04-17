<?php
$con = mysqli_connect("localhost","hyperise","Hyperise@2022","hyperise_demo");

if($con){
// 	$u_id = $_POST['uid'];
	$l_time = $_POST['l_time'];
	// $t = time();
	$response = array();
	$data_code = "2002";
	
	$sql = "SELECT * FROM message;";
	$result = mysqli_query($con,$sql);
	if($result){
		while($row = mysqli_fetch_array($result)){
			if(strtotime($row[6])>$l_time){
				array_push($response,array('id'=>$row[0],'title'=>$row[1],'msg'=>$row[2],'dept_id'=>$row[5],'update_time'=>strtotime($row[6])));
				// $sql1 = "UPDATE chat SET status='1' WHERE id='".$row[0]."';";
				// $result1 = mysqli_query($con,$sql1);
			}
		}
		if(!empty($response)){
			$data_code = "2001";
		}else{
			$data_code = "2002";
		}
	}else{
		$data_code = "2003";
	}
	
	echo json_encode(array('response_code'=>$data_code,'server_time'=>time(),'response'=>$response));
	mysqli_close($con);
}
?>