<?php

//file to get one item
	$item = $_GET['placeid'];
	http_response_code(200);
	echo json_encode(
		array(
			"id" => "$item",
			"long" => "12.35126352",
			"lat" => "0.152632123",
			"title" => "somewhere only we know"
		)
	);
?>