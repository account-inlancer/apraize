<?php
$con = mysqli_connect("localhost","hyperise","Hyperise@2022","hyperise_demo");
	
	if($con){
		$table = $_POST['table'];
		$sql = "";
		
		if($table == 'pricelist_a'){
    		$sql = "select g.* 
    		        from pricelist as g
    		        left join department as d on d.d_id = g.department
    		        where g.is_delete = 0
    		        AND d.shortname = 'a'
		        ";
		}
		if($table == 'pricelist_b'){
    		$sql = "select g.* 
    		        from pricelist as g
    		        left join department as d on d.d_id = g.department
    		        where g.is_delete = 0
    		        AND d.shortname = 'b'
		        ";
		}
		if($table == 'pricelist_c'){
    		$sql = "select g.* 
    		        from pricelist as g
    		        left join department as d on d.d_id = g.department
    		        where g.is_delete = 0
    		        AND d.shortname = 'c'
		        ";
		}
		if($table == 'pricelist_d'){
    		$sql = "select g.* 
    		        from pricelist as g
    		        left join department as d on d.d_id = g.department
    		        where g.is_delete = 0
    		        AND d.shortname = 'd'
		        ";
		}
		
		$result = mysqli_query($con,$sql);
		$response=array();
		
		if($result){
			while($row=mysqli_fetch_array($result)){
				
				array_push($response,array('id'=>$row[0],'name'=>$row[1],'unit'=>$row[2],'mrp'=>$row[3],'ptr'=>$row[4],'pts'=>$row[5],'netrate'=>$row[6],'tax'=>$row[7],'hsn'=>$row[8],'notes'=>$row[9]));
			}
		}
		mysqli_close($con);
		echo json_encode(array('response'=>$response));
	}
?>