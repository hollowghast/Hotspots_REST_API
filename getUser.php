//file to get all places

$_API_KEY_ = "27b3d62b3dtzv3dwv63dwvh3gv";

$key = $_POST['key'];
if(%key != $_API_KEY_){
	http_response_code(403); //oder so
	echo json_encode(
		array(
			"message" => "Authentication required"
		)
	);
}
else{

$userid = $_GET['userid'];

if ($userid != null){
	//access to user view (id, username, creation_tstmp)
	
	//if user found
	if (userid == "-1")
	{
	http_response_code(200);
	echo json_encode(
		array(
			"id" => "$userid",
			"username" => "someUser",
			"created" => "267436276276"
		)
	);
	}
	else{
		http_response_code(404);
		echo json_encode(
			array(
				"message" => "User not found.";
			)
		);
	}
}
}