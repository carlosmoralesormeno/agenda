<?php
header('Content-Type: application/json');

if(!empty($_POST)){
	$user = EventData::getById($_POST["id"]);
	$user->date_at = $_POST["date_at"];
	$user->time_at = $_POST["time_at"];
	$user->time_end = $_POST["time_end"];
	$user->update_ajax();
	
	$response['event'] = $user;
    echo json_encode($response);
}

?>