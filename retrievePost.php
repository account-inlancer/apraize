<?php
$con = mysqli_connect("localhost","hyperise","Hyperise@2022","hyperise_demo");
	
	if($con){
	    $sql = '';
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
		$t = time();
		if($result){
			while($row=mysqli_fetch_array($result)){
				$img = "http://app.cytozpharmaceuticals.com/assets/upload/gallery/original/".$row[2];
				array_push($response,array('id'=>$row[0],'title'=>$row[1],'body'=>$row[5],'image'=>$img));
			}
		}
	    mysqli_query($con, " INSERT INTO `message` (`id`, `msg_title`, `msg_body`, `user_id`, `post_image`, `dept_id`, `created_at`) VALUES (NULL,  'syncPost','".addslashes(json_encode($response))."', NULL, NULL, NULL, CURRENT_TIMESTAMP); ");

		mysqli_close($con);
		echo json_encode(array('response'=>$response,'server_time'=>$t));
	}
?>