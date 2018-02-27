<?php
	global $HTTP_COOKIE_VARS;
	$uid = $HTTP_COOKIE_VARS['coID'];
	$cek = '';
	$err ='';
	$content = '';
	$fileName = $_FILES["ImageFile2"]["name"]; // The file name
	$fileTmpLoc = $_FILES["ImageFile2"]["tmp_name"]; // File in the PHP tmp folder
	$fileType = $_FILES["ImageFile2"]["type"]; // The type of file it is
	$fileSize = $_FILES["ImageFile2"]["size"]; // File size in bytes
	$fileErrorMsg = $_FILES["ImageFile2"]["error"]; // 0 for false... and 1 for true
	if (!$fileTmpLoc) { // if file not chosen
	    $err .= "ERROR: Please browse for a file before clicking the upload button.";
	    exit();
	}
	
	$data = $_FILES["ImageFile2"];
	$namafile = explode(".", $fileName);
	
	$file_name_no_ext = isset($namafile[0]) ? $namafile[0] : null; // File name without the extension
	$file_extension = $namafile[count($namafile)-1];
	$fileNewName = md5( $file_name_no_ext[0].microtime() ).'.'.$file_extension ;
	
	if(move_uploaded_file($fileTmpLoc, "Media/pengguna/$fileNewName")){
	   
		$peng_id = $_POST['peng_id'];
		$ref_id = $_POST['ref_idupload2'];
		$isifile = $_POST['isifile'];
		$nmfile = $fileNewName;
		$nmfile_asli = $fileName;
		$jns_upload = $_POST['jns_upload'];
		$direktori='Media/pengguna/';
	
		
		$qryubah = "UPDATE gambar_upload SET stat = '2' WHERE id_upload='$peng_id' and jns_upload='7'"; $cek .= " || ".$qryubah;
	//	$qryubah = "UPDATE gambar_uploadmenu_pasif SET stat = '2' WHERE mnu_id='$mnu_id'"; $cek .= " || ".$qryubah;
		$aqryubah = mysql_query($qryubah);
		
	
		$qry = "INSERT INTO gambar_upload (id_upload, nmfile, nmfile_asli, stat, uid, tgl_create,jns_upload,direktori,stat2) values ('$peng_id','$nmfile', '$nmfile_asli', '1', '$uid', NOW(),'$jns_upload','$direktori','1')";	$cek .= $qry;	
		$aqry = mysql_query($qry);
		
		$content['data'] = "$fileName upload is complete";
		$content['nmfile_asli'] = $fileName;
		$content['nmfile'] = $fileName.$fileNewName;
		
	} else {
	    $err .= "move_uploaded_file function failed";
	}
	
	$err .=$fileTmpLoc. "|| Media/pengguna/".$fileNewName;
	
	
	$pageArr = array('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	$page = json_encode($pageArr);	
	echo $page;	
?>