<?php
//selector01.php
include("navatas.php");
include("navbawah.php");
$SPg = isset($HTTP_GET_VARS["SPg"])?$HTTP_GET_VARS["SPg"]:"";
switch($SPg)
{
	case "01":
		include("inputuser.php");
	break;
	case "02":
		include("backup.php");
	break;
	case "03":
		include("restore.php");
	break;
	case "04":
		include("loginlist.php");
	break;
			
	default:
		include("home.php");
	break;
}
?>