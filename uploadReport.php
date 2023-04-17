<?php
// $con = mysqli_connect("localhost","dermatix_user","smJ4bJ39kHab29PpfjKq","dermatix_cytozapp");

if($con){
	$user_id = $_POST['user_id'];
	$co_worker = $_POST['co_worker'];
	$d_date = $_POST['d_date'];
	$from_place = $_POST['from_place'];
	$to_place = $_POST['to_place'];
	$fare = $_POST['fare'];
	$postage = $_POST['postage'];
	$tel_charge = $_POST['tel_charge'];
	$other = $_POST['other'];
	$other_cost = $_POST['other_cost'];
	$stationery = $_POST['stationery'];
	
	
	$sql = "INSERT INTO daily_expense (user_id,co_worker,d_date,from_place,to_place,fare,postage,tel_charge,other,other_cost,stationery) values ('".$user_id."','".$co_worker."','".$d_date."','".$from_place."','".$to_place."','".$fare."','".$postage."','".$tel_charge."','".$other."','".$other_cost."','".$stationery."');";
	
	$result = mysqli_query($con,$sql);	
	if($result)
	{
		$data_code = "2001";
	}
	else
	{
		$data_code = "2002";
	}
	
	echo json_encode(array('response_code'=>$data_code));
	mysqli_close($con);
}
?>