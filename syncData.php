<?php
$con = mysqli_connect("localhost","hyperise","Hyperise@2022","hyperise_demo");

	if($con){
		$table = $_POST['table'];
		if($table == 'galleries_a'){
    		$sql = "select g.* 
    		        from galleries as g
    		        left join department as d on d.d_id = g.department
    		        where g.is_delete = 0
    		        AND d.shortname = 'a'
		        ";
		}
		if($table == 'galleries_b'){
    		$sql = "select g.* 
    		        from galleries as g
    		        left join department as d on d.d_id = g.department
    		        where g.is_delete = 0
    		        AND d.shortname = 'b'
		        ";
		}
		if($table == 'galleries_c'){
    		$sql = "select g.* 
    		        from galleries as g
    		        left join department as d on d.d_id = g.department
    		        where g.is_delete = 0
    		        AND d.shortname = 'c'
		        ";
		}
		if($table == 'galleries_d'){
    		$sql = "select g.* 
    		        from galleries as g
    		        left join department as d on d.d_id = g.department
    		        where g.is_delete = 0
    		        AND d.shortname = 'd'
		        ";
		}
		$result = mysqli_query($con,$sql);
		$response=array();
		
		if($result){
			while($row=mysqli_fetch_array($result)){
				
				// $img = $row[2];
				$img = "https://apraize.inlancer.in/assets/upload/gallery/original/".$row[2];
				array_push($response,array('id'=>$row[0],'name'=>$row[1],'image'=>$img));
				
			}
		}
		mysqli_close($con);
		echo json_encode(array('response'=>$response));
	}
?>