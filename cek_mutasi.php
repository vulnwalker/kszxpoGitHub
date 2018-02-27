<?php

// cekmutasiphp?params=1
ob_start("ob_gzhandler");
	include("config.php"); 
	
	$params = $_REQUEST['params'];
	
	$par = explode(':',$params);
	
	if($par[0] == 1 ){
		
	
		//membetulkan data penghapusan jenis mutasi yang salah , karena penghapusan.id_bukuinduk diisi tujuan harusnya id asal
		echo " No , ID Penghapusan, ID Buku_Induk, ID Awal  <br>";
		$aqry = "select aa.id as idhps, aa.id_bukuinduk, aa.idbi_awal, bb.id from
			(select * from penghapusan where idbi_awal <> id_bukuinduk and mutasi=1)aa
			left JOIN 
			(select * from buku_induk where status_barang=3) bb ON aa.id_bukuinduk = bb.id
			where bb.id is null
			";
		$i = 1; $cek = '';
		$qry = mysql_query($aqry);
		while($isi = mysql_fetch_array($qry)){
			$sukses = FALSE; $cek = '';
			echo $i." ,  ".$isi['idhps'].', '.$isi['id_bukuinduk'].', '.$isi['idbi_awal'];
			
			
			$aqry = " select * from buku_induk where id = '".$isi['id_bukuinduk']."' ; "; $cek .= $aqry;
			$get = mysql_fetch_array(mysql_query($aqry));
			//if($get['id_lama'] == $isi['idbi_awal'] ){
				//$aqrybi = "select * from buku_induk where id='".$isi['idbi_awal']."';";  $cek .= ' '.$aqrybi;
				$aqrybi = "select * from buku_induk where id='".$get['id_lama']."';";  $cek .= ' '.$aqrybi;
				$bi =  mysql_fetch_array(mysql_query($aqrybi));
				$aqryhps = " update penghapusan set id_bukuinduk = '".$bi['id'].
					"', c1='".$bi['c1']."', c='".$bi['c']."', d='".$bi['d']."', e='".$bi['e']."', e1='".$bi['e1']."' ".
					" where id='".$isi['idhps']."' ;"; $cek .= ' '.$aqryhps;
				$hps = mysql_query( 
					$aqryhps);
				if($hps){
					$aqryhps2 = "call sp_jurnal_mutasi(".$isi['idhps'].");" ; $cek .= ' '.$aqryhps2;
					$hps2 = mysql_query($aqryhps2);
						$sukses= $hps2;				
				}
			//}else{
			//	$cek .= " id_lama <> idawal ";
			//}
			if($sukses ) {echo " FIX ";}else{
				echo " GAGAL ". $cek;
			}
			echo "<br>";
			if($i>20){
				ob_flush();
				flush();
			}
			
			$i++;
		}
		echo ' selesai' ;
	}
	//
?>