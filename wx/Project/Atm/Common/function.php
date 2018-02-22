<?php
function check_premission($itm){
	$type = $_SESSION ['utype'];
	$permission = explode(",",$_SESSION ['permission']);
	if($type == "1"){
	    return 1;
	}else if(in_array($itm, $permission)){
		return 1;
	}else{
	    return 0;
	}
}

function is_roll($permission, $type, $itm){
	$permission = explode(',', $permission);
	if($type == "1"){
	    return 1;
	}else if(in_array($itm, $permission)){
		return 1;
	}else{
	    return 0;
	}
}
