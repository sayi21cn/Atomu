<?php
	$error["error"]=$error["message"];
	unset($error["message"]);
	if(!APP_DEBUG){
		unset($error["line"]);
		unset($error["file"]);
		unset($error["trace"]);
	}
    echo json_encode($error);
?>