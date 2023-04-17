<?php
$con = mysqli_connect("localhost","hyperise","Hyperise@2022","hyperise_demo");
	$response = [];
	if($con){
		$version_code = $_POST['version_code'];
		$sql = "SELECT * FROM version WHERE version_code=(SELECT MAX(version_code) FROM version);";
		$result = mysqli_query($con,$sql);
		// $path = "img/";
		
		if($result){
			$row=mysqli_fetch_assoc($result);
			$v_code = $row['version_code'];
			if($v_code>$version_code){
				$data_code = "2001";
				$response['id'] = $row['id'];
				$response['v_code'] = $row['version_code'];
				$response['path'] = $row['path'];
				// array_push($response,array('id'=>$row['id'],'v_code'=>$row['version_code'],'path'=>$row['path']));
			}else{
				$data_code = "2002";
			}
			
				
				// $img = $row[3];
				// $image = base64_encode(file_get_contents($path.$img));
				
				// array_push($response,array('id'=>$row[0],'name'=>$row[1],'unit'=>$row[2],'mrp'=>$row[3],'ptr'=>$row[4],'pts'=>$row[5],'netrate'=>$row[6],'tax'=>$row[7],'hsn'=>$row[8],'notes'=>$row[9]));
		}
		mysqli_close($con);
		echo json_encode(array('data_code'=>'2002','response'=>$response));
	}
?>