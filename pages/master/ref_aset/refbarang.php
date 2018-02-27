<?php

class RefBarangObj  extends DaftarObj2{
	var $Prefix = 'RefBarang';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_barang'; //daftar
	var $TblName_Hapus = 'ref_barang';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('f1','f2','f','g','h','i','j','j1');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'BARANG';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'RefBarangForm';

	function setTitle(){
		return 'Daftar Barang';
	}
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>";
	}

	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;

		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";
	}

	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;

	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $a1 = $Main->DEF_KEPEMILIKAN;
	 $a = $Main->Provinsi[0];
	 $b = '00';
	 $c = $_REQUEST['c'];
	 $d = $_REQUEST['d'];
	 $e = $_REQUEST['e'];
	 $f = $_REQUEST['jenisBarang'];
	 $g = $_REQUEST['obyekBarang'];
	 $h = $_REQUEST['rincianObyekBarang'];
	 $i = $_REQUEST['subRincianObyekBarang'];
	 $getMaxSubSubRincianObyek = mysql_fetch_array(mysql_query("select max(j) from ref_barang where f='$f' and g='$g' and h='$h' and i='$i'"));
	 $j = $getMaxSubSubRincianObyek['max(j)'] + 1;
	 $j1 = $_REQUEST['j1'];
	$fn = sprintf("%02s", $f);
	$gn = sprintf("%02s", $g);
	$hn = sprintf("%02s", $h);
	$in = sprintf("%02s", $i);
	$jn = sprintf("%03s", $j);
	// $f = str_pad($f,2,"0",STR_PAD_LEFT);
	 //$f = str_pad("0",2,$f);
	 $kode_barang = $_REQUEST['kode_barang'];
	 $nama_barang = $_REQUEST['nama_barang'];
	 $kode_account_at = $_REQUEST['kaap64'];
	 $kode_account_bm = $_REQUEST['kabmp64'];
	 $kode_account_belanja_modal_pemeliharaan = $_REQUEST['kabpp64j'];
	 $kode_account_ap = $_REQUEST['kaapp64'];
	 $kode_account_beban_penyusutan = $_REQUEST['kabpp64'];
	 $kode_rekening_belanja_modal =  $_REQUEST['krbmp21'];
	 $kode_rekening_belanja_pemeliharaan =  $_REQUEST['krbpp21'];
	 $kodeRekeningSewa = $_REQUEST['kodeRekeningSewa'];


	 $nama_account = $_REQUEST['nama_account'];
	 $masa_manfaat = $_REQUEST['masa_manfaat'];
	 $residu = str_replace(",",".",$_REQUEST['residu']);
	 $cb=explode('.',$kode_barang);
	 $jml_data=count($cb);

	 //Mendapatkan kondisi untuk update
	for($i=0;$cb[$i]!='00' && $i<$jml_data;$i++){
	 	switch($i){
			case '0': $kondisi="concat(f,g,h,i,j) Like '%".$cb[0]."%'"; break;
			case '1': $kondisi="concat(f,g,h,i,j) Like '%".$cb[0].$cb[1]."%'"; break;
			case '2': $kondisi="concat(f,g,h,i,j) Like '%".$cb[0].$cb[1].$cb[2]."%'"; break;
			case '3': $kondisi="concat(f,g,h,i,j) Like '%".$cb[0].$cb[1].$cb[2].$cb[3]."%'"; break;
			case '4': $kondisi="concat(f,g,h,i,j) Like '%".$cb[0].$cb[1].$cb[2].$cb[3].$cb[4]."%'"; break;
		}
	 }
	 	 foreach ($_REQUEST as $key => $value) {
		  			$$key = $value;
	 	 }

		//  	if ($f1 == '' || $f2 == '' || $f == '' || $g == '' || $h == '' || $i == '' || $j == ''){
		// 		$err = "Periksa Kode Barang";
		// 	}elseif($satuan == ''){
		// 		$err = "Isi satuan";
		// 	}
 	 // if($err=='' && $nama_barang =='' ) $err= 'Nama Barang belum diisi';

 						$kode_jurnal_at = explode('.',$kode_account_at);
						 $ka=$kode_jurnal_at[0];
						 $kb=$kode_jurnal_at[1];
						 $kc=$kode_jurnal_at[2];
						 $kd=$kode_jurnal_at[3];
						 $ke=$kode_jurnal_at[4];
						 /*$kf=$kode_jurnal_at[5];*/

						 $kode_jurnal_bm = explode('.',$kode_account_bm);
						 $m1=$kode_jurnal_bm[0];
						 $m2=$kode_jurnal_bm[1];
						 $m3=$kode_jurnal_bm[2];
						 $m4=$kode_jurnal_bm[3];
						 $m5=$kode_jurnal_bm[4];
						 /*$m6=$kode_jurnal_bm[5];*/

						 $kode_jurnal_ap = explode('.',$kode_account_ap);
						 $l1=$kode_jurnal_ap[0];
						 $l2=$kode_jurnal_ap[1];
						 $l3=$kode_jurnal_ap[2];
						 $l4=$kode_jurnal_ap[3];
						 $l5=$kode_jurnal_ap[4];
						 /*$l6=$kode_jurnal_ap[5];	*/

						 $kode_jurnal_bp = explode('.',$kode_account_beban_penyusutan);
						 $n1=$kode_jurnal_bp[0];
						 $n2=$kode_jurnal_bp[1];
						 $n3=$kode_jurnal_bp[2];
						 $n4=$kode_jurnal_bp[3];
						 $n5=$kode_jurnal_bp[4];
						 /*$n6=$kode_jurnal_bp[5];*/

						 $kode_jurnal_belanja_pemeliharaan = explode('.',$kode_account_belanja_modal_pemeliharaan);
						 $o1=$kode_jurnal_belanja_pemeliharaan[0];
						 $o2=$kode_jurnal_belanja_pemeliharaan[1];
						 $o3=$kode_jurnal_belanja_pemeliharaan[2];
						 $o4=$kode_jurnal_belanja_pemeliharaan[3];
						 $o5=$kode_jurnal_belanja_pemeliharaan[4];
						 /*$o6=$kode_jurnal_belanja_pemeliharaan[5];*/

						 $kode_rek_belanja_modal = explode('.',$kode_rekening_belanja_modal);
						 $k11=$kode_rek_belanja_modal[0];
						 $l11=$kode_rek_belanja_modal[1];
						 $m11=$kode_rek_belanja_modal[2];
						 $n11=$kode_rek_belanja_modal[3];
						 $o11=$kode_rek_belanja_modal[4];


						 $kode_rek_belanja_pemeliharaan = explode('.',$kode_rekening_belanja_pemeliharaan);
						 $k12=$kode_rek_belanja_pemeliharaan[0];
						 $l12=$kode_rek_belanja_pemeliharaan[1];
						 $m12=$kode_rek_belanja_pemeliharaan[2];
						 $n12=$kode_rek_belanja_pemeliharaan[3];
						 $o12=$kode_rek_belanja_pemeliharaan[4];

						 $kodeRekeningSewa = explode('.',$kodeRekeningSewa);
						 $k13=$kodeRekeningSewa[0];
						 $l13=$kodeRekeningSewa[1];
						 $m13=$kodeRekeningSewa[2];
						 $n13=$kodeRekeningSewa[3];
						 $o13=$kodeRekeningSewa[4];


			if($fmST == 0){
				if($err==''){
				$aqry = "INSERT into ref_barang (f1,f2,f,g,h,i,j,j1,ka,kb,kc,kd,ke,kf,l1,l2,l3,l4,l5,l6,m1,m2,m3,m4,m5,m6,n1,n2,n3,n4,n5,n6,k11,l11,m11,n11,o11,k12,l12,m12,n12,o12,k13,l13,m13,n13,o13,o1,o2,o3,o4,o5,o6,nm_barang,satuan) values('0','0','$fn','$gn','$hn','$in','$jn','".$this->generate4digit($j1)."','$ka','$kb','$kc','$kd','$ke','$kf','$l1','$l2','$l3','$l4','$l5','$l6','$m1','$m2','$m3','$m4','$m5','$m6','$n1','$n2','$n3','$n4','$n5','$n6','$k11','$l11','$m11','$n11','$o11','$k12','$l12','$m12','$n12','$o12','$k13','$l13','$m13','$n13','$o13','$o1','$o2','$o3','$o4','$o5','$o6','$nama_barang','$satuan')";	$cek .= $aqry;
				$cek = $aqry;
					$qry = mysql_query($aqry);
				}else{
					$err="Gagal menyimpan barang";
				}
			}elseif($fmST == 1){
				if($err==''){
						$data = array(
										// 'f1' => '0',
									  // 'f2' => '0',
									  // 'f' => $f,
									  // 'g' => $g,
									  // 'h' => $h,
									  // 'i' => $i,
									  // 'j' => $j,
									  // 'j1' => $this->generate4digit($j1),
									  // 'ka' => $ka,
									  // 'kb' => $kb,
									  // 'kc' => $kc,
									  // 'kd' =>$kd,
									  // 'ke' => $ke,
									  // 'kf' => $kf,
									  // 'l1' => $l1,
									  // 'l2' => $l2,
									  // 'l3' =>$l3,
									  // 'l4'=>$l4,
									  // 'l5'=>$l5,
									  // 'l6'=>$l6,
									  // 'm1'=>$m1,
									  // 'm2'=>$m2,
									  // 'm3'=>$m3,
									  // 'm4'=>$m4,
									  // 'm5'=>$m5,
									  // 'm6'=>$m6,
									  // 'n1'=>$n1,
									  // 'n2'=>$n2,
									  // 'n3'=>$n3,
									  // 'n4'=>$n4,
									  // 'n5'=>$n5,
									  // 'n6'=>$n6,
									  // 'k11'=>$k11,
									  // 'l11'=>$l11,
									  // 'm11'=>$m11,
									  // 'n11'=>$n11,
									  // 'o11'=>$o11,
									  // 'k12'=>$k12,
									  // 'l12'=>$l12,
									  // 'm12'=>$m12,
									  // 'n12'=>$n12,
									  // 'o12'=>$o12,
									  // 'k13'=>$k13,
									  // 'l13'=>$l13,
									  // 'm13'=>$m13,
									  // 'n13'=>$n13,
									  // 'o13'=>$o13,
									  // 'o1'=>$o1,
									  // 'o2'=>$o2,
									  // 'o3'=>$o3,
									  // 'o4'=>$o4,
									  // 'o5'=>$o5,
									  // 'o6'=>$o6,
									  'nm_barang'=>$nama_barang,
									  'satuan'=>$satuan
									  );
					    $forWhere = '0'.".".'0'.".".$f.".".$g.".".$h.".".$i.".".$j.".".$this->generate4digit($j1);
						//$qry = mysql_query($aqry2);
						$qry = mysql_query(VulnWalkerUpdate('ref_barang',$data,"concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1) = '$forWhere'"));
						$cek = VulnWalkerUpdate('ref_barang',$data,"concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1) = '$forWhere'");
						if($qry==FALSE)
						{
							$err="Gagal menyimpan barang ";
						}else{

						}
					}

			}else{
			if($err==''){

				}
			}

			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
    }

	function generate4digit($angka){
		if(empty($angka))$angka="0000";
		return $angka;
	}
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}

	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	  switch($tipe){
			case 'saveNewObyekBarang':{
				foreach ($_REQUEST as $key => $value) {
		 			 $$key = $value;
		 		}
					if(empty($nama)){
						$err = "Isi nama";
					}else{
						$data = array(
														'f' => $jenisBarang,
														'g' => $newObyekBarang,
														'h' => '00',
														'i' => '00',
														'j' => '000',
														'j1' => '0000',
														'nm_barang' => $nama,
													);
						$query = VulnWalkerInsert("ref_barang",$data);
						mysql_query($query);
						$cek = $query;
					}
				 $f = $jenisBarang;
		 		 $g = $newObyekBarang;
		 		 $h = $rincianObyekBarang;
		 		 $i = $subRincianObyekBarang;
		 		 $j = $subSubRincianObyekBarang;
		 		 $comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		 		$comboObyek = cmbQuery('obyekBarang',$newObyekBarang,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --');
		 		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --');
		 		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --');
				$content = array(
				                'jenisBarang'=> $comboJenisBarang,
				                'obyekBarang'=> $comboObyek,
				                'rincianObyekBarang'=> $comboRincianObyek,
				                'subRincianObyekBarang'=> $comboSubRincianObyek,
				                );

			break;
			}
			case 'saveEditObyekBarang':{
				foreach ($_REQUEST as $key => $value) {
		 			 $$key = $value;
		 		}
					if(empty($nama)){
						$err = "Isi nama";
					}else{
						$data = array(

														'nm_barang' => $nama,
													);
						$query = VulnWalkerUpdate("ref_barang",$data,"f='$f' and g='$g' and h='00' and i='00' and j='000'");
						mysql_query($query);
						$cek = $query;
					}

		 		 $comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		 		$comboObyek = cmbQuery('obyekBarang',$newObyekBarang,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --');
		 		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --');
		 		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --');
				$content = array(
				                'jenisBarang'=> $comboJenisBarang,
				                'obyekBarang'=> $comboObyek,
				                'rincianObyekBarang'=> $comboRincianObyek,
				                'subRincianObyekBarang'=> $comboSubRincianObyek,
				                );

			break;
			}
			case 'saveEditRincianObyekBarang':{
				foreach ($_REQUEST as $key => $value) {
		 			 $$key = $value;
		 		}
					if(empty($nama)){
						$err = "Isi nama";
					}else{
						$data = array(

														'nm_barang' => $nama,
													);
						$query = VulnWalkerUpdate("ref_barang",$data,"f='$f' and g='$g' and h='$h' and i='00' and j='000'");
						mysql_query($query);
						$cek = $query;
					}

		 		 $comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		 		$comboObyek = cmbQuery('obyekBarang',$newObyekBarang,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --');
		 		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --');
		 		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --');
				$content = array(
				                'jenisBarang'=> $comboJenisBarang,
				                'obyekBarang'=> $comboObyek,
				                'rincianObyekBarang'=> $comboRincianObyek,
				                'subRincianObyekBarang'=> $comboSubRincianObyek,
				                );

			break;
			}
			case 'saveEditSubRincianObyekBarang':{
				foreach ($_REQUEST as $key => $value) {
		 			 $$key = $value;
		 		}
					if(empty($nama)){
						$err = "Isi nama";
					}else{
						$data = array(

														'nm_barang' => $nama,
													);
						$query = VulnWalkerUpdate("ref_barang",$data,"f='$f' and g='$g' and h='$h' and i='$i' and j='000'");
						mysql_query($query);
						$cek = $query;
					}

		 		 $comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		 		$comboObyek = cmbQuery('obyekBarang',$newObyekBarang,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --');
		 		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --');
		 		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --');
				$content = array(
				                'jenisBarang'=> $comboJenisBarang,
				                'obyekBarang'=> $comboObyek,
				                'rincianObyekBarang'=> $comboRincianObyek,
				                'subRincianObyekBarang'=> $comboSubRincianObyek,
				                );

			break;
			}
			case 'saveEditSubSubRincianObyekBarang':{
				foreach ($_REQUEST as $key => $value) {
		 			 $$key = $value;
		 		}
					if(empty($nama)){
						$err = "Isi nama";
					}else{
						$data = array(

														'nm_barang' => $nama,
														'satuan' => $satuanBarang,
													);
						$query = VulnWalkerUpdate("ref_barang",$data,"f='$f' and g='$g' and h='$h' and i='$i' and j='$j'");
						mysql_query($query);
						$cek = $query;
					}

		 		 $comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		 		$comboObyek = cmbQuery('obyekBarang',$newObyekBarang,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --');
		 		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --');
		 		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --');
				$content = array(
				                'jenisBarang'=> $comboJenisBarang,
				                'obyekBarang'=> $comboObyek,
				                'rincianObyekBarang'=> $comboRincianObyek,
				                'subRincianObyekBarang'=> $comboSubRincianObyek,
				                );

			break;
			}
			case 'saveNewRincianObyek':{
				foreach ($_REQUEST as $key => $value) {
		 			 $$key = $value;
		 		}
					if(empty($nama)){
						$err = "Isi nama";
					}else{
						$data = array(
														'f' => $jenisBarang,
														'g' => $obyekBarang,
														'h' => $newRincianObyekBarang,
														'i' => '00',
														'j' => '000',
														'j1' => '0000',
														'nm_barang' => $nama,
													);
						$query = VulnWalkerInsert("ref_barang",$data);
						mysql_query($query);
						$cek = $query;
					}
				 $f = $jenisBarang;
		 		 $g = $obyekBarang;
		 		 $h = $newRincianObyekBarang;
		 		 $i = $subRincianObyekBarang;
		 		 $j = $subSubRincianObyekBarang;
		 		 $comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		 		$comboObyek = cmbQuery('obyekBarang',$newObyekBarang,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --');
		 		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --');
		 		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --');
				$content = array(
				                'jenisBarang'=> $comboJenisBarang,
				                'obyekBarang'=> $comboObyek,
				                'rincianObyekBarang'=> $comboRincianObyek,
				                'subRincianObyekBarang'=> $comboSubRincianObyek,
				                );

			break;
			}
			case 'saveNewSubRincianObyek':{
				foreach ($_REQUEST as $key => $value) {
		 			 $$key = $value;
		 		}
					if(empty($nama)){
						$err = "Isi nama";
					}else{
						$data = array(
														'f' => $jenisBarang,
														'g' => $obyekBarang,
														'h' => $rincianObyekBarang,
														'i' => $newSubRincianObyekBarang,
														'j' => '000',
														'j1' => '0000',
														'nm_barang' => $nama,
													);
						$query = VulnWalkerInsert("ref_barang",$data);
						mysql_query($query);
						$cek = $query;
					}
				 $f = $jenisBarang;
		 		 $g = $obyekBarang;
		 		 $h = $rincianObyekBarang;
		 		 $i = $newSubRincianObyekBarang;
		 		 $j = $subSubRincianObyekBarang;
		 		 $comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		 		$comboObyek = cmbQuery('obyekBarang',$newObyekBarang,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --');
		 		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --');
		 		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --');
				$content = array(
				                'jenisBarang'=> $comboJenisBarang,
				                'obyekBarang'=> $comboObyek,
				                'rincianObyekBarang'=> $comboRincianObyek,
				                'subRincianObyekBarang'=> $comboSubRincianObyek,
				                );

			break;
			}
		case 'newObyekBarang':{
				$fm = $this->newObyekBarang();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
			}
		case 'editObyekBarang':{
				$fm = $this->editObyekBarang();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
			}
		case 'editRincianObyekBarang':{
				$fm = $this->editRincianObyekBarang();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
			}
		case 'editSubRincianObyekBarang':{
				$fm = $this->editSubRincianObyekBarang();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
			}
		case 'newRincianObyekBarang':{
				$fm = $this->newRincianObyekBarang();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
			}
		case 'newSubRincianObyekBarang':{
				$fm = $this->newSubRincianObyekBarang();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
			}
		case 'formBaru':{
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'jenisChanged':{
		  foreach ($_REQUEST as $key => $value) {
		        $$key = $value;
		 }
		 $f = $jenisBarang;
		 $g = $obyekBarang;
		 $h = $rincianObyekBarang;
		 $i = $subRincianObyekBarang;
		 $j = $subSubRincianObyekBarang;
		 $comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		$comboObyek = cmbQuery('obyekBarang',$g,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --');
		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --');
		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --');


		$content = array(
		                'jenisBarang'=> $comboJenisBarang,
		                'obyekBarang'=> $comboObyek,
		                'rincianObyekBarang'=> $comboRincianObyek,
		                'subRincianObyekBarang'=> $comboSubRincianObyek,
		                );

		break;
		}
		case 'obyekBarangChanged':{
		  foreach ($_REQUEST as $key => $value) {
		        $$key = $value;
		 }
		 $f = $jenisBarang;
		 $g = $obyekBarang;
		 $h = $rincianObyekBarang;
		 $i = $subRincianObyekBarang;
		 $j = $subSubRincianObyekBarang;
		 $comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		$comboObyek = cmbQuery('obyekBarang',$g,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --');
		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --');
		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --');


		$content = array(
		                'jenisBarang'=> $comboJenisBarang,
		                'obyekBarang'=> $comboObyek,
		                'rincianObyekBarang'=> $comboRincianObyek,
		                'subRincianObyekBarang'=> $comboSubRincianObyek,
		                );

		break;
		}
		case 'rincianObyekBarangChanged':{
		  foreach ($_REQUEST as $key => $value) {
		        $$key = $value;
		 }
		 $f = $jenisBarang;
		 $g = $obyekBarang;
		 $h = $rincianObyekBarang;
		 $i = $subRincianObyekBarang;
		 $j = $subSubRincianObyekBarang;
		 $comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		$comboObyek = cmbQuery('obyekBarang',$g,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --');
		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --');
		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --');


		$content = array(
		                'jenisBarang'=> $comboJenisBarang,
		                'obyekBarang'=> $comboObyek,
		                'rincianObyekBarang'=> $comboRincianObyek,
		                'subRincianObyekBarang'=> $comboSubRincianObyek,
		                );

		break;
		}

		case 'formEdit':{
			$fm = $this->setFormEdit();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'Hapus':{
			$fm = $this->Hapus_data();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

	   	case 'getdata':{

		$ref_pilihbarang = $_REQUEST['id'];
		$kode_barang = explode(' ',$ref_pilihbarang);
		$f=$kode_barang[0];
		$g=$kode_barang[1];
		$h=$kode_barang[2];
		$i=$kode_barang[3];
		$j=$kode_barang[4];

		//query ambil data ref_program
		$get = mysql_fetch_array( mysql_query("select * from ref_barang where f=$f and g=$g and h=$h and i=$i and j=$j"));
		$kode_barang=$get['f'].'.'.$get['g'].'.'.$get['h'].'.'.$get['i'].'.'.$get['j'];

		$fmThnAnggaran=  $_COOKIE['coThnAnggaran'];
			$kueri1="select max(thn_akun) as thn_akun from ref_jurnal where thn_akun <= '$fmThnAnggaran'";
			$tmax = mysql_fetch_array(mysql_query($kueri1));
			$kueri="select * from ref_jurnal
					where thn_akun = '".$tmax['thn_akun']."'
					and ka='".$get['m1']."' and kb='".$get['m2']."'
					and kc='".$get['m3']."' and kd='".$get['m4']."'
					and ke='".$get['m5']."' and kf='".$get['m6']."'"; //echo "$kueri";
			$row=mysql_fetch_array(mysql_query($kueri));

			$kode_account =$row['ka'].".".$row['kb'].".".$row['kc'].".".$row['kd'].".".$row['ke'].".".$row['kf'];





		$content = array('IDBARANG'=>$kode_barang, 'NMBARANG'=>$get['nm_barang'], 'kode_account'=>$kode_account, 'nama_account'=>$row['nm_account'], 'tahun_account'=>$row['thn_akun']  );
		break;
	   }

		case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	   }

	   default:{
			$other = $this->set_selector_other2($tipe);
			$cek = $other['cek'];
			$err = $other['err'];
			$content=$other['content'];
			$json=$other['json'];
	 break;
	 }
	 }//end switch

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }

	function windowShow(){
		$cek = ''; $err=''; $content='';
		$json = TRUE;	//$ErrMsg = 'tes';
		$form_name = $this->FormName;



			$FormContent = $this->genDaftarInitial();
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div',
						$FormContent,
						800,
						500,
						'Pilih Barang',
						'',
						"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >  &nbsp &nbsp ".
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';


		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function setPage_OtherScript(){
		$scriptload =

					"<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();
						});

					</script>";

		return
			 "<script type='text/javascript' src='js/master/ref_aset/refbarang.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>
			 <script type='text/javascript' src='js/master/ref_aset/refrekening.js' language='JavaScript' ></script>
			 <script type='text/javascript' src='js/master/ref_template/jquery.js' language='JavaScript' ></script>".

			$scriptload;
	}

	function Hapus_Validasi($id){//id -> multi id with space delimiter
		$errmsg ='';
		$kode_barang = explode(' ',$id);
		$f1=$kode_barang[0];
		$f2=$kode_barang[1];
		$f=$kode_barang[2];
		$g=$kode_barang[3];
		$h=$kode_barang[4];
		$i=$kode_barang[5];
		$j=$kode_barang[6];



		if($f2 =='0'){
		  $hasRow = mysql_num_rows(mysql_query("select * from ref_barang where f1 ='$f1' and f2!='0' "));
		  if($hasRow > 0){
		  	$errmsg = "Data tidak dapat di hapus";
		  }
		}else{
		   if($f =='0' ){
		   $hasRow = mysql_num_rows(mysql_query("select * from ref_barang where f1 ='$f1' and f2='$f2' and f !='0' and g ='00' and h ='00' and i ='00' and j = '000' "));
			  if($hasRow > 0){
			  	$errmsg = "Data tidak dapat di hapus";
		 	 }
		  }else{
			  	if( $g=='00'){
			  $hasRow = mysql_num_rows(mysql_query("select * from ref_barang where f1 ='$f1' and f2='$f2' and f='$f' and g !='00' and h ='00' and i ='00' and j = '000' "));
			  if($hasRow > 0){
			  	$errmsg = "Data tidak dapat di hapus";
			  }
			}else{
				if( $h=='00'){
		  $hasRow = mysql_num_rows(mysql_query("select * from ref_barang where f1 ='$f1' and f2='$f2' and f='$f' and g ='$g' and h !='00' and i ='00' and j = '000' "));
		  if($hasRow > 0){
		  	$errmsg = "Data tidak dapat di hapus";
		  }
		}else{
			if( $i=='00'){
		  $hasRow = mysql_num_rows(mysql_query("select * from ref_barang where f1 ='$f1' and f2='$f2' and f='$f' and g ='$g' and h='$h' and i!='00'  and j = '000' "));
		  if($hasRow > 0){
		  	$errmsg = "Data tidak dapat di hapus";
		  }
		}else{
			if( $j=='000'){
		  $hasRow = mysql_num_rows(mysql_query("select * from ref_barang where f1 ='$f1' and f2='$f2' and f='$f' and g ='$g' and h='$h'  and i='$i' and j!='000' "));
		  if($hasRow > 0){
		  	$errmsg = "Data tidak dapat di hapus";
		  }
		}
		}
		}
			}
		  }
		}

		return $errmsg;

}
function newObyekBarang($dt){
 global $SensusTmp, $Main;
 $REK_DIGIT_O=$Main->REK_DIGIT_O;

 $cek = ''; $err=''; $content='';
 $json = TRUE;	//$ErrMsg = 'tes';
 $form_name = $this->Prefix.'_formKB';
 $this->form_width = 650;
 $this->form_height = 80;

	$this->form_caption = 'Baru Obyek Barang';
	foreach ($_REQUEST as $key => $value) {
		 $$key = $value;
	}
	$getJenisBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$jenisBarang' and g='00' and h='00' and i='00' and j='000'"));
	$getMaxJenisBarang = mysql_fetch_array(mysql_query("select max(g) from ref_barang where f ='$jenisBarang' and g!='00' "));
	$maxObyekBarang = $getMaxJenisBarang['max(g)'] + 1;
 //items ----------------------
	$this->form_fields = array(

		'Kelompok' => array(
					'label'=>'Jenis',
					'labelWidth'=>100,
					'value'=>"<div style='float:left;'>
						<input type='text' value='".$getJenisBarang['nm_barang']."' style='width:500px;' readonly>
						<input type ='hidden' name='jenisBarang' id='jenisBarang' value='".$jenisBarang."'>
					</div>",
					 ),

		'kode_kelompok' => array(
					'label'=>'Obyek',
					'labelWidth'=>100,
					'value'=>"<div style='float:left;'>
						<input type='text' name='newObyekBarang' id='newObyekBarang' value='".genNumber($maxObyekBarang)."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Obyek' style='width:470px;'>
					</div>",
					 ),

		);
	//tombol
	$this->form_menubawah =
	"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".saveNewObyekBarang()' title='Simpan'>&nbsp&nbsp".
	"<input type='button' class='btn btn-success' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

	$form = $this->genFormKB();
	$content = $form;
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
}
function editObyekBarang($dt){
 global $SensusTmp, $Main;
 $REK_DIGIT_O=$Main->REK_DIGIT_O;

 $cek = ''; $err=''; $content='';
 $json = TRUE;	//$ErrMsg = 'tes';
 $form_name = $this->Prefix.'_formKB';
 $this->form_width = 650;
 $this->form_height = 80;

	$this->form_caption = 'Edit Obyek Barang';
	foreach ($_REQUEST as $key => $value) {
		 $$key = $value;
	}
	$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$jenisBarang' and g='$obyekBarang' and h='00' and i='00' and j='000'"));

 //items ----------------------
	$this->form_fields = array(



		'kode_kelompok' => array(
					'label'=>'Obyek',
					'labelWidth'=>100,
					'value'=>"<div style='float:left;'>
						<input type='text' name='newObyekBarang' id='newObyekBarang' value='".genNumber($obyekBarang)."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$getNamaBarang['nm_barang']."' placeholder='Nama Obyek' style='width:470px;'>
						<input type='hidden' name='f' id='f' value ='$jenisBarang'>
						<input type='hidden' name='g' id='g' value ='$obyekBarang'>
						<input type='hidden' name='h' id='h' value ='$rincianObyekBarang'>
						<input type='hidden' name='i' id='i' value ='$subRincianObyekBarang'>
						<input type='hidden' name='j' id='j' value ='$subSubRincianObyekBarang'>
					</div>",
					 ),

		);
	//tombol
	$this->form_menubawah =
	"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".saveEditObyekBarang()' title='Simpan'>&nbsp&nbsp".
	"<input type='button' class='btn btn-success' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

	$form = $this->genFormKB();
	$content = $form;
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
}
function editRincianObyekBarang($dt){
 global $SensusTmp, $Main;
 $REK_DIGIT_O=$Main->REK_DIGIT_O;

 $cek = ''; $err=''; $content='';
 $json = TRUE;	//$ErrMsg = 'tes';
 $form_name = $this->Prefix.'_formKB';
 $this->form_width = 650;
 $this->form_height = 80;

	$this->form_caption = 'Edit Obyek Barang';
	foreach ($_REQUEST as $key => $value) {
		 $$key = $value;
	}
	$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$jenisBarang' and g='$obyekBarang' and h='$rincianObyekBarang' and i='00' and j='000'"));

 //items ----------------------
	$this->form_fields = array(



		'kode_kelompok' => array(
					'label'=>'Obyek',
					'labelWidth'=>100,
					'value'=>"<div style='float:left;'>
						<input type='text' name='newObyekBarang' id='newObyekBarang' value='".genNumber($rincianObyekBarang)."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$getNamaBarang['nm_barang']."' placeholder='Nama Obyek' style='width:470px;'>
						<input type='hidden' name='f' id='f' value ='$jenisBarang'>
						<input type='hidden' name='g' id='g' value ='$obyekBarang'>
						<input type='hidden' name='h' id='h' value ='$rincianObyekBarang'>
						<input type='hidden' name='i' id='i' value ='$subRincianObyekBarang'>
						<input type='hidden' name='j' id='j' value ='$subSubRincianObyekBarang'>
					</div>",
					 ),

		);
	//tombol
	$this->form_menubawah =
	"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".saveEditRincianObyekBarang()' title='Simpan'>&nbsp&nbsp".
	"<input type='button' class='btn btn-success' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

	$form = $this->genFormKB();
	$content = $form;
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
}
function editSubRincianObyekBarang($dt){
 global $SensusTmp, $Main;
 $REK_DIGIT_O=$Main->REK_DIGIT_O;

 $cek = ''; $err=''; $content='';
 $json = TRUE;	//$ErrMsg = 'tes';
 $form_name = $this->Prefix.'_formKB';
 $this->form_width = 650;
 $this->form_height = 80;

	$this->form_caption = 'Edit Obyek Barang';
	foreach ($_REQUEST as $key => $value) {
		 $$key = $value;
	}
	$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$jenisBarang' and g='$obyekBarang' and h='$rincianObyekBarang' and i='$subRincianObyekBarang' and j='000'"));

 //items ----------------------
	$this->form_fields = array(



		'kode_kelompok' => array(
					'label'=>'Obyek',
					'labelWidth'=>100,
					'value'=>"<div style='float:left;'>
						<input type='text' name='newObyekBarang' id='newObyekBarang' value='".genNumber($subRincianObyekBarang)."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$getNamaBarang['nm_barang']."' placeholder='Nama Obyek' style='width:470px;'>
						<input type='hidden' name='f' id='f' value ='$jenisBarang'>
						<input type='hidden' name='g' id='g' value ='$obyekBarang'>
						<input type='hidden' name='h' id='h' value ='$rincianObyekBarang'>
						<input type='hidden' name='i' id='i' value ='$subRincianObyekBarang'>
						<input type='hidden' name='j' id='j' value ='$subSubRincianObyekBarang'>
					</div>",
					 ),

		);
	//tombol
	$this->form_menubawah =
	"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".saveEditSubRincianObyekBarang()' title='Simpan'>&nbsp&nbsp".
	"<input type='button' class='btn btn-success' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

	$form = $this->genFormKB();
	$content = $form;
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
}

function newRincianObyekBarang($dt){
 global $SensusTmp, $Main;
 $REK_DIGIT_O=$Main->REK_DIGIT_O;

 $cek = ''; $err=''; $content='';
 $json = TRUE;	//$ErrMsg = 'tes';
 $form_name = $this->Prefix.'_formKB';
 $this->form_width = 650;
 $this->form_height = 80;

	$this->form_caption = 'Baru Rincian Obyek Barang';
	foreach ($_REQUEST as $key => $value) {
		 $$key = $value;
	}
	$getObyekBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$jenisBarang' and g='$obyekBarang' and h='00' and i='00' and j='000'"));
	$getMaxObyekBarang = mysql_fetch_array(mysql_query("select max(h) from ref_barang where f ='$jenisBarang' and g='$obyekBarang' and h!='00' "));
	$maxRincianObyekBarang = $getMaxObyekBarang['max(h)'] + 1;
 //items ----------------------
	$this->form_fields = array(

		'Kelompok' => array(
					'label'=>'Jenis',
					'labelWidth'=>100,
					'value'=>"<div style='float:left;'>
						<input type='text' value='".$getObyekBarang['nm_barang']."' style='width:500px;' readonly>
						<input type ='hidden' name='jenisBarang' id='jenisBarang' value='".$jenisBarang."'>
						<input type ='hidden' name='obyekBarang' id='obyekBarang' value='".$obyekBarang."'>
					</div>",
					 ),

		'kode_kelompok' => array(
					'label'=>'Obyek',
					'labelWidth'=>100,
					'value'=>"<div style='float:left;'>
						<input type='text' name='newRincianObyekBarang' id='newRincianObyekBarang' value='".genNumber($maxRincianObyekBarang)."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Obyek' style='width:470px;'>
					</div>",
					 ),

		);
	//tombol
	$this->form_menubawah =
	"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".saveNewRincianObyek()' title='Simpan'>&nbsp&nbsp".
	"<input type='button' class='btn btn-success' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

	$form = $this->genFormKB();
	$content = $form;
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
}
function newSubRincianObyekBarang($dt){
 global $SensusTmp, $Main;
 $REK_DIGIT_O=$Main->REK_DIGIT_O;

 $cek = ''; $err=''; $content='';
 $json = TRUE;	//$ErrMsg = 'tes';
 $form_name = $this->Prefix.'_formKB';
 $this->form_width = 650;
 $this->form_height = 80;

	$this->form_caption = 'Baru Sub Rincian Obyek Barang';
	foreach ($_REQUEST as $key => $value) {
		 $$key = $value;
	}
	$getRincianObyekBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$jenisBarang' and g='$obyekBarang' and h='$rincianObyekBarang' and i='00' and j='000'"));
	$getMaxRincianObyekBarang = mysql_fetch_array(mysql_query("select max(i) from ref_barang where f ='$jenisBarang' and g='$obyekBarang' and h='$rincianObyekBarang' and i!='00' "));
	$maxSubRincianObyekBarang = $getMaxRincianObyekBarang['max(i)'] + 1;
 //items ----------------------
	$this->form_fields = array(

		'Kelompok' => array(
					'label'=>'Jenis',
					'labelWidth'=>100,
					'value'=>"<div style='float:left;'>
						<input type='text' value='".$getRincianObyekBarang['nm_barang']."' style='width:500px;' readonly>
						<input type ='hidden' name='jenisBarang' id='jenisBarang' value='".$jenisBarang."'>
						<input type ='hidden' name='obyekBarang' id='obyekBarang' value='".$obyekBarang."'>
						<input type ='hidden' name='rincianObyekBarang' id='rincianObyekBarang' value='".$rincianObyekBarang."'>
					</div>",
					 ),

		'kode_kelompok' => array(
					'label'=>'Obyek',
					'labelWidth'=>100,
					'value'=>"<div style='float:left;'>
						<input type='text' name='newSubRincianObyekBarang' id='newSubRincianObyekBarang' value='".genNumber($maxSubRincianObyekBarang)."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Obyek' style='width:470px;'>
					</div>",
					 ),

		);
	//tombol
	$this->form_menubawah =
	"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".saveNewSubRincianObyek()' title='Simpan'>&nbsp&nbsp".
	"<input type='button' class='btn btn-success' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

	$form = $this->genFormKB();
	$content = $form;
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
}
function genFormKB($withForm=TRUE, $params=NULL, $center=TRUE){
	$form_name = $this->Prefix.'_KBform';

	if($withForm){
		$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
			createDialog(
				$form_name.'_div',
				$this->setForm_content(),
				$this->form_width,
				$this->form_height,
				$this->form_caption,
				'',
				$this->form_menubawah.
				"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
				<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
				$this->form_menu_bawah_height,'',$params).
			"</form>";

	}else{
		$form=
			createDialog(
				$form_name.'_div',
				$this->setForm_content(),
				$this->form_width,
				$this->form_height,
				$this->form_caption,
				'',
				$this->form_menubawah.
				"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
				<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
				$this->form_menu_bawah_height,'',$params
			);
	}

	if($center){
		$form = centerPage( $form );
	}
	return $form;
}
	//form ==================================
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
		$cek =$cbid[0];

		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt['readonly']='';
		$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
		$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
		if(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.$fmSUBSUBKELOMPOK.'.';
		}
		$fm = $this->setForm($dt);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

  	function setFormEdit(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];

		$cek =$cbid[0];

		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		//get data
		$f1=$kode[0];
		$f2=$kode[1];
		$jenisBarang=$kode[2];
		$obyekBarang=$kode[3];
		$rincianObyekBarang=$kode[4];
		$subRincianObyekBarang=$kode[5];
		$subSubRincianObyekBarang=$kode[6];
		$j1=$kode[7];
		$bulan=date('Y-m-')."1";
		//query ambil data ref_barang
		$aqry = "select * from ref_barang where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1)='".$f1.'.'.$f2.'.'.$f.'.'.$g.'.'.$h.'.'.$i.'.'.$j.'.'.$j1."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));

		$cek = ''; $err=''; $content='';
	  $json = TRUE;	//$ErrMsg = 'tes';
	  $form_name = $this->Prefix.'_formKB';
	  $this->form_width = 650;
	  $this->form_height = 80;

	 	$this->form_caption = 'Edit Obyek Barang';
	 	foreach ($_REQUEST as $key => $value) {
	 		 $$key = $value;
	 	}
	 	$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$jenisBarang' and g='$obyekBarang' and h='$rincianObyekBarang' and i='$subRincianObyekBarang' and j='$subSubRincianObyekBarang'"));

	  //items ----------------------
	 	$this->form_fields = array(



	 		'kode_kelompok' => array(
	 					'label'=>'Nama',
	 					'labelWidth'=>100,
	 					'value'=>"<div style='float:left;'>
	 						<input type='text' name='newObyekBarang' id='newObyekBarang' value='$subSubRincianObyekBarang' style='width:30px;' readonly>
	 						<input type='text' name='nama' id='nama' value='".$getNamaBarang['nm_barang']."' placeholder='Nama Obyek' style='width:470px;'>
	 						<input type='hidden' name='f' id='f' value ='$jenisBarang'>
	 						<input type='hidden' name='g' id='g' value ='$obyekBarang'>
	 						<input type='hidden' name='h' id='h' value ='$rincianObyekBarang'>
	 						<input type='hidden' name='i' id='i' value ='$subRincianObyekBarang'>
	 						<input type='hidden' name='j' id='j' value ='$subSubRincianObyekBarang'>
	 					</div>",
	 					 ),
	 		'asdxzcasd' => array(
	 					'label'=>'Satuan',
	 					'labelWidth'=>100,
	 					'value'=>"<div style='float:left;'>
	 						<input type='text' name='satuanBarang' id='satuanBarang' value='".$getNamaBarang['satuan']."' style='width:100px;' >
	 					</div>",
	 					 ),

	 		);
	 	//tombol
	 	$this->form_menubawah =
	 	"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".saveEditSubSubRincianObyek()' title='Simpan'>&nbsp&nbsp".
	 	"<input type='button' class='btn btn-success' value='Batal' onclick ='".$this->Prefix.".Close()' >";

	 	$form = $this->genFormKB();
	 	$content = $form;

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function setForm($dt){
	 global $SensusTmp, $Main;
	 $cek = ''; $err=''; $content='';

	 $json = TRUE;	//$ErrMsg = 'tes';

	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 850;
	 $this->form_height = 200;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU';
		$readonly='';
		$chmod644 = "";
		$f1 = '0';
		$f2 = '0';
		$f = $_REQUEST['cmbJenis'];
		$g = $_REQUEST['cmbObyek'];
		$h = $_REQUEST['cmbRincianObyek'];
		$i = $_REQUEST['cmbSubRincianObyek'];
		$j = $_REQUEST['cmbSubSubRincianObyek'];


	  }else{
		$this->form_caption = 'EDIT';
		$chmod644 ="readonly";
		$f1 = '0';
		$f2 = '0';
		$f = $dt['f'];
		$g = $dt['g'];
		$h = $dt['h'];
		$i = $dt['i'];
		$j = $dt['j'];



	  }


    $pilihan = "<input type='hidden' value='1' id='cmbJenisBarang' name='cmbJenisBarang' >";
		$comboJenisBarang = cmbQuery('jenisBarang',$f,"select f,nm_barang from ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.jenisBarangChanged()"','-- JENIS --');
		$comboObyek = cmbQuery('obyekBarang',$g,"select g,nm_barang from ref_barang where f='$f' and g!='00' and h='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.obyekBarangChanged()"','-- OBYEK --')."&nbsp <input type='button' value='Baru' onclick =$this->Prefix.newObyekBarang();>&nbsp <input type='button' value='Edit' onclick =$this->Prefix.editObyekBarang();>";
		$comboRincianObyek = cmbQuery('rincianObyekBarang',$h,"select h,nm_barang from ref_barang where f='$f' and g='$g' and h!='00' and i='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.rincianObyekBarangChanged()"','-- RINCIAN OBYEK --')."&nbsp <input type='button' value='Baru' onclick =$this->Prefix.newRincianObyekBarang();>&nbsp <input type='button' value='Edit' onclick =$this->Prefix.editRincianObyekBarang();>";
		$comboSubRincianObyek = cmbQuery('subRincianObyekBarang',$i,"select i,nm_barang from ref_barang where f='$f' and g='$g' and h='$h' and i!='00' and j='000' and f!='08'",'style="width:500px;"onchange="'.$this->Prefix.'.subRincianObyekBarangChanged()"','-- SUB RINCIAN OBYEK --')."&nbsp <input type='button' value='Baru' onclick =$this->Prefix.newSubRincianObyekBarang();>&nbsp <input type='button' value='Edit' onclick =$this->Prefix.editSubRincianObyekBarang();>";

       //items ----------------------
		  $this->form_fields = array(

			'1' => array(
								'label'=>'Jenis',
								'labelWidth'=>100,
								'value'=>$pilihan.$comboJenisBarang
									 ),
			'2' => array(
								'label'=>'Obyek',
								'labelWidth'=>100,
								'value'=>$comboObyek
									 ),
			'3' => array(
								'label'=>'Rincian Obyek',
								'labelWidth'=>200,
								'value'=>$comboRincianObyek
									 ),
			'4' => array(
								'label'=>'Sub Rincian Obyek',
								'labelWidth'=>100,
								'value'=>$comboSubRincianObyek
									 ),
			'nama_barang' => array(
								'label'=>'NAMA BARANG',
								'labelWidth'=>100,
								'value'=>$dt['nm_barang'],
								'type'=>'text',
								'id'=>'nama_barang',
								'param'=>"style='width:500px;' size=50px"
									 ),
			'satuan' => array(
								'label'=>'SATUAN',
								'labelWidth'=>100,
								'value'=>$dt['satuan'],
								'type'=>'text',
								'id'=>'satuan',
								'param'=>"style='width:500px;' size=50px"
									 ),

			// 'krbmp21' => array(
			// 					'label'=>'BELANJA MODAL PERMEN 21',
			// 					'labelWidth'=>250,
			// 					'value'=>"<input type='text' name='krbmp21' value='".$kode_rek_bm."' size='10px' id='krbmp21' readonly>&nbsp
			// 							  <input type='text' name='nbmp21' value='".$na_rek_bm['nm_rekening']."' size='73px' id='nrbmp21' readonly>&nbsp
			// 							  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikrbmp21()'  title='Cari Jurnal Aset Tetap' >"
			// 						 ),
			// 'krbpp21' => array(
			// 					'label'=>'BELANJA PEMELIHARAAN PERMEN 21',
			// 					'labelWidth'=>250,
			// 					'value'=>"<input type='text' name='krbpp21' value='".$kode_rek_bp."' size='10px' id='krbpp21' readonly>&nbsp
			// 							  <input type='text' name='nrbpp21' value='".$na_rek_bp['nm_rekening']."' size='73px' id='nrbpp21' readonly>&nbsp
			// 							  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikrbpp21()'  title='Cari Jurnal Aset Tetap' >"
			// 						 ),
			// 'rekeningSewa' => array(
			// 					'label'=>'BELANJA SEWA PERMEN 21',
			// 					'labelWidth'=>250,
			// 					'value'=>"<input type='text' name='kodeRekeningSewa' value='".$kodeRekeningSwa."' size='10px' id='kodeRekeningSewa' readonly>&nbsp
			// 							  <input type='text' name='namaRekeningSewa' value='".$namaRekeningSewa['nm_rekening']."' size='73px' id='namaRekeningSewa' readonly>&nbsp
			// 							  <input type='button' value='Cari' onclick ='".$this->Prefix.".cariRekeningSewa()'  title='Cari Rekening Sewa' >"
			// 						 ),
			// 'kabmp64' => array(
			// 					'label'=>'BELANJA MODAL PERMEN 64',
			// 					'labelWidth'=>250,
			// 					'value'=>"<input type='text' name='kabmp64' value='".$kode_account_bm."' size='10px' id='kabmp64' readonly>&nbsp
			// 							  <input type='text' name='nabmp64' value='".$na_bm['nm_account']."' size='73px' id='nabmp64' readonly>&nbsp
			// 							  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikabmp64()'  title='Cari Jurnal Aset Tetap' >"
			// 						 ),
      //
			// 'kabpp64j' => array(
			// 					'label'=>'BELANJA PEMELIHARAAN PERMEN 64 ',
			// 					'labelWidth'=>250,
			// 					'value'=>"<input type='text' name='kabpp64j' value='".$kode_account_pemeliharaan."' size='10px' id='kabpp64j' readonly>&nbsp
			// 							  <input type='text' name='nabpp64j' value='".$na_akun_pemeliharaan['nm_account']."' size='73px' id='nabpp64j' readonly>&nbsp
			// 							  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikabpp64j()'  title='Cari Jurnal Belanja Modal Pemeliharaan' >"
			// 						 ),
			// 'kaap64' => array(
			// 					'label'=>'ASET PERMEN 64',
			// 					'labelWidth'=>250,
			// 					'value'=>"<input type='text' name='kaap64' value='".$kode_account_at."' size='10px' id='kaap64' readonly>&nbsp
			// 							  <input type='text' name='naap64' value='".$na_at['nm_account']."' size='73px' id='naap64' readonly>&nbsp
			// 							  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikaap64()'  title='Cari Aset Tetap' >"
			// 						 ),
			// 'kaapp64' => array(
			// 					'label'=>'AKUMULASI PENYUSUTAN PERMEN 64',
			// 					'labelWidth'=>250,
			// 					'value'=>"<input type='text' name='kaapp64' value='".$kode_account_ap."' size='10px' id='kaapp64' readonly>&nbsp
			// 							  <input type='text' name='naapp64' value='".$na_ap['nm_account']."' size='73px' id='naapp64' readonly>&nbsp
			// 							  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikaapp64()'  title='Cari Akun Akumulasi Penyusutan' >"
			// 						 ),
			// 'kabpp64' => array(
			// 					'label'=>'BEBAN PENYUSUTAN PERMEN 64',
			// 					'labelWidth'=>250,
			// 					'value'=>"<input type='text' name='kabpp64' value='".$kode_account_beban_penyusutan."' size='10px' id='kabpp64' readonly>&nbsp
			// 							  <input type='text' name='nabpp64' value='".$na_akun_beban_penyusutan['nm_account']."' size='73px' id='nabpp64' readonly>&nbsp
			// 							  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikabpp64()'  title='Cari Jurnal Aset Tetap' >"
			// 						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Batal kunjungan' > &nbsp &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $fmBIDANG = $_REQUEST['fmBIDANG'];
	 $fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
	 $fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
	 $fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
	if(empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
	{
		$nama_barang="NAMA BIDANG";
	}
	elseif(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK) || empty($fmKELOMPOK))
	{
		$nama_barang="NAMA KELOMPOK";
	}
	elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK) || empty($fmSUBKELOMPOK))
	{
		$nama_barang="NAMA SUB KELOMPOK";
	}
	elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
	{
		$nama_barang="NAMA SUB SUB KELOMPOK";
	}
	elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
	{
		$nama_barang="NAMA BARANG";
	}
	 $headerTable =
	 "<thead>
	 <tr>
	   <th class='th01' width='20' >No.</th>
	   $Checkbox
	   <th class='th01' align='left' width='100'>KODE BARANG</th>
	   <th class='th01' align='left' width='800'>NAMA BARANG</th>
	   <th class='th01' align='left' width='100'>SATUAN</th>
	   <th class='th01' align='left' width='200'>KODE REKENING BELANJA MODAL PERMEN 21</th>
	   <th class='th01' align='left' width='200'>KODE REKENING BELANJA PEMELIHARAAN PERMEN 21</th>
	   <th class='th01' align='left' width='200'>KODE REKENING BELANJA SEWA PERMEN 21</th>
	   <th class='th01' align='left' width='200'>KODE AKUN BELANJA MODAL PERMEN 64</th>
	   <th class='th01' align='left' width='200'>KODE AKUN BELANJA PEMELIHARAAN PERMEN 64</th>
	   <th class='th01' align='left' width='200'>KODE AKUN ASET PERMEN 64</th>
	   <th class='th01' align='left' width='200'>KODE AKUN AKUMULASI PENYUSUTAN</th>
	   <th class='th01' align='left' width='200'>KODE AKUN BEBAN PENYUSUTAN</th>



	   </tr>
	   </thead>";

		return $headerTable;
	}
	/*	   <th class='th01' align='left' width='100'>MASA MANFAAT (TAHUN)</th>
	   <th class='th01' align='left' width='100'>RESIDU (%)</th>	 */

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;

	 $aqry_at = "select * from ref_jurnal where ka='".$isi['ka']."' and kb='".$isi['kb']."' and kc='".$isi['kc']."' and kd='".$isi['kd']."' and ke='".$isi['ke']."' ";
	 $na_at=mysql_fetch_array(mysql_query($aqry_at));


	 $aqry_bm = "select * from ref_jurnal where ka='".$isi['m1']."' and kb='".$isi['m2']."' and kc='".$isi['m3']."' and kd='".$isi['m4']."' and ke='".$isi['m5']."' ";
	 $na_bm=mysql_fetch_array(mysql_query($aqry_bm));


	 $aqry_ap = "select * from ref_jurnal where ka='".$isi['l1']."' and kb='".$isi['l2']."' and kc='".$isi['l3']."' and kd='".$isi['l4']."' and ke='".$isi['l5']."' ";
	 $na_ap=mysql_fetch_array(mysql_query($aqry_ap));


	 //vw
	 $query_rek_bm = "select * from ref_rekening where k='".$isi['k11']."' and l='".$isi['l11']."' and m='".$isi['m11']."' and n='".$isi['n11']."' and o='".$isi['o11']."' ";
	 $na_rek_bm = mysql_fetch_array(mysql_query($query_rek_bm));
	 $kode_rek_bm=$isi['k11'].'.'.$isi['l11'].'.'.$isi['m11'].'.'.$isi['n11'].'.'.$isi['o11'];

	 $query_rek_bp = "select * from ref_rekening where k='".$isi['k12']."' and l='".$isi['l12']."' and m='".$isi['m12']."' and n='".$isi['n12']."' and o='".$isi['o12']."' ";
	 $na_rek_bp = mysql_fetch_array(mysql_query($query_rek_bp));
	 $kode_rek_bp=$isi['k12'].'.'.$isi['l12'].'.'.$isi['m12'].'.'.$isi['n12'].'.'.$isi['o12'];

	 $query_akun_pemeliharaan = "select * from ref_jurnal where ka='".$isi['o1']."' and kb='".$isi['o2']."' and kc='".$isi['o3']."' and kd='".$isi['o4']."' and ke='".$isi['o5']."'  ";
	 $na_akun_pemeliharaan=mysql_fetch_array(mysql_query($query_akun_pemeliharaan));


	 $query_akun_beban_penyusutan = "select * from ref_jurnal where ka='".$isi['n1']."' and kb='".$isi['n2']."' and kc='".$isi['n3']."' and kd='".$isi['n4']."' and ke='".$isi['n5']."' ";
	 $na_akun_beban_penyusutan=mysql_fetch_array(mysql_query($query_akun_beban_penyusutan));


	 /*if($isi['ke'] < 10)$isi['ke'] = "0".$isi['ke'];
	 if($isi['m5'] < 10)$isi['m5'] = "0".$isi['m5'];
	 if($isi['l5'] < 10)$isi['l5'] = "0".$isi['l5'];
	 if($isi['n5'] < 10)$isi['n5'] = "0".$isi['n5'];
	 if($isi['o5'] < 10)$isi['o5'] = "0".$isi['o5'];
	 if($isi['n13'] < 10)$isi['n13'] = "0".$isi['n13'];
	 if($isi['o13'] < 10)$isi['o13'] = "0".$isi['o13'];*/


	 $kode_account_at=$isi['ka'].'.'.$isi['kb'].'.'.$isi['kc'].'.'.$isi['kd'].'.'.$isi['ke'];
	 $kode_account_bm=$isi['m1'].'.'.$isi['m2'].'.'.$isi['m3'].'.'.$isi['m4'].'.'.$isi['m5'];
	 $kode_account_ap=$isi['l1'].'.'.$isi['l2'].'.'.$isi['l3'].'.'.$isi['l4'].'.'.$isi['l5'];
	 $kode_account_pemeliharaan=$isi['o1'].'.'.$isi['o2'].'.'.$isi['o3'].'.'.$isi['o4'].'.'.$isi['o5'];
	 $kode_account_beban_penyusutan=$isi['n1'].'.'.$isi['n2'].'.'.$isi['n3'].'.'.$isi['n4'].'.'.$isi['n5'];
	 $kodeRekeningSewa = $isi['k13'].'.'.$isi['l13'].'.'.$isi['m13'].'.'.$isi['n13'].'.'.$isi['o13'];
	 $namaRekeningSewa = mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$isi['k13']."' and l='".$isi['l13']."' and m='".$isi['m13']."' and n='".$isi['n13']."' and o='".$isi['o13']."' "));

	 $kode_barang=$isi['f1'].".".$isi['f2'].".".$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
	 $Koloms = array();
	 $Koloms[] = array('align="center" width="20"', $no.'.' );
	 if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 if($isi['j'] == '000'){
	 			$Koloms[] = array('align="left" width="100" style="font-weight : bold;" ',$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'].'.'.$isi['j1']);
	 }else{
	 	$Koloms[] = array('align="left" width="100" style="border-left-style: none;" ',$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'].'.'.$isi['j1']);
	 }

 	 $Koloms[] = array('align="left" width="200"',$isi['nm_barang']);
	 $Koloms[] = array('align="left" width="100"',$isi['satuan']);
	 $Koloms[] = array('align="left" width="200"',$kode_rek_bm.'<br>'.$na_rek_bm['nm_rekening']);
	 $Koloms[] = array('align="left" width="200"',$kode_rek_bp.'<br>'.$na_rek_bp['nm_rekening']);
	 $Koloms[] = array('align="left" width="200"',$kodeRekeningSewa.'<br>'.$namaRekeningSewa['nm_rekening']);
	 $Koloms[] = array('align="left" width="200"',$kode_account_bm.'<br>'.$na_bm['nm_account']);
	 $Koloms[] = array('align="left" width="200"',$kode_account_pemeliharaan.'<br>'.$na_akun_pemeliharaan['nm_account']);
	 $Koloms[] = array('align="left" width="200"',$kode_account_at.'<br>'.$na_at['nm_account']);
  	 $Koloms[] = array('align="left" width="200"',$kode_account_ap.'<br>'.$na_ap['nm_account']);
	 $Koloms[] = array('align="left" width="200"',$kode_account_beban_penyusutan.'<br>'.$na_akun_beban_penyusutan['nm_account']);
/* 	 $Koloms[] = array('align="left" width="200"',$isi['masa_manfaat']);
 	 $Koloms[] = array('align="left" width="200"',str_replace(".",",",$isi['residu']));
*/
	 return $Koloms;
	}

	function genDaftarOpsi(){
	 global $Ref, $Main;


	$cmbAkun = '0';
	$cmbKelompok = '0';
	$cmbJenis = $_REQUEST['cmbJenis'];
	$cmbObyek = $_REQUEST['cmbObyek'];
	$cmbRincianObyek = $_REQUEST['cmbRincianObyek'];
	$cmbSubRincianObyek = $_REQUEST['cmbSubRincianObyek'];
	$cmbSubSubRincianObyek = $_REQUEST['cmbSubSubRincianObyek'];
	$fmKODE = $_REQUEST['fmKODE'];
	$fmBARANG = $_REQUEST['fmBARANG'];


	 $arr = array(
			//array('selectAll','Semua'),
			array('selectfg','Kode Barang'),
			array('selectbarang','Nama Barang'),
			);


	//data order ------------------------------
	 $arrOrder = array(
	  	         array('1','Kode Barang'),
			     array('2','Nama Barang'),
	 );

	 $arrayJenisbarang = array(
								array('1', 'ASET'),
								 array('2', 'PERSEDIAAN'),


								);
	// $filterJenisBarang = $_REQUEST['filterJenisBarang'];
	$filterJenisBarang = '1';
	 $comboJenisBarang = cmbArray('filterJenisBarang',$filterJenisBarang,$arrayJenisbarang,'-- JENIS BARANG --',"onchange = $this->Prefix.refreshList(true);");
	 if($filterJenisBarang == '1'){
		 	$filterItem = "<tr>
			<td style='width:170px;' >JENIS</td><td>:</td>
			<td>".
			cmbQuery1("cmbJenis",$cmbJenis,"select f as valueCmbJenis, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f != '00'  and f != '08'  and g ='00' and h ='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td style='width:170px;'>OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbObyek",$cmbObyek,"select g as valueCmbObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g !='00' and h ='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td style='width:170px;'>RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbRincianObyek",$cmbRincianObyek,"select h as valueCmbRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h !='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			<tr>
			<td style='width:170px;'>SUB RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,"select i as valueCmbSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i != '00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			<tr>
			<td style='width:170px;'>SUB-SUB RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,"select j as valueCmbSubSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j != '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>";
	 }elseif($filterJenisBarang == '2'){
		 $cmbSubSubSubRincianObyek = $_REQUEST['cmbSubSubSubRincianObyek'];
		 $filterItem = "<tr>
		 <td style='width:170px;' >JENIS</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbJenis",$cmbJenis,"select f as valueCmbJenis, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '08'  and g ='00' and h ='00' and i='00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
		 </tr>
		 <tr>
		 <td style='width:170px;'>OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbObyek",$cmbObyek,"select g as valueCmbObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g !='00' and h ='00' and i='00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
		 </tr><tr>
		 <td style='width:170px;'>RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbRincianObyek",$cmbRincianObyek,"select h as valueCmbRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h !='00' and i='00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			 </tr>
		 <tr>
		 <td style='width:170px;'>SUB RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,"select i as valueCmbSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i != '00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			 </tr>
		 <tr>
		 <td style='width:170px;'>SUB-SUB RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,"select j as valueCmbSubSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j != '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			</tr>
		 <tr>
		 <td style='width:170px;'>SUB-SUB-SUB RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbSubSubSubRincianObyek",$cmbSubSubSubRincianObyek,"select j1 , nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j = '$cmbSubSubRincianObyek' and j1 != '0000' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			</tr>
			 ";
	 }else{
		 $filterItem = "<tr>
		 <td style='width:170px;' >JENIS</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbJenis",$cmbJenis,"select f as valueCmbJenis, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f != '00'  and g ='00' and h ='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
		 </tr>
		 <tr>
		 <td style='width:170px;'>OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbObyek",$cmbObyek,"select g as valueCmbObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g !='00' and h ='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
		 </tr><tr>
		 <td style='width:170px;'>RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbRincianObyek",$cmbRincianObyek,"select h as valueCmbRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h !='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			 </tr>
		 <tr>
		 <td style='width:170px;'>SUB RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,"select i as valueCmbSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i != '00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			 </tr>
		 <tr>
		 <td style='width:170px;'>SUB-SUB RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,"select j as valueCmbSubSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j != '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			 </tr>";
	 }

	$TampilOpt =
			"<div class='FilterBar'>".


			"<table style='width:100%'>
			$filterItem

			</table>".
			"</div>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Barang : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
				Nama Barang : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>".
			"<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>";
		return array('TampilOpt'=>$TampilOpt);
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;

		//kondisi -----------------------------------


		$arrKondisi = array();
		$fmPILCARI = $_REQUEST['fmPILCARI'];
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
			$cmbAkun = '0';
		$cmbKelompok = '0';
		$cmbJenis = $_REQUEST['cmbJenis'];
		$cmbObyek = $_REQUEST['cmbObyek'];
		$cmbRincianObyek = $_REQUEST['cmbRincianObyek'];
		$cmbSubRincianObyek = $_REQUEST['cmbSubRincianObyek'];
		$cmbSubSubRincianObyek = $_REQUEST['cmbSubSubRincianObyek'];
		$fmMERK = $_REQUEST['fmMERK'];
		$fmTYPE = $_REQUEST['fmTYPE'];
		$filterJenisBarang = $_REQUEST['filterJenisBarang'];

		switch($fmPILCARI){
			case 'selectfg': $arrKondisi[] = " concat(f,g) like '%$fmPILCARIvalue%'"; break;
			case 'selectbarang': $arrKondisi[] = " nama_barang like '%".$fmPILCARIvalue."%'"; break;
		}

		if(empty($cmbJenis)) {
			$cmbObyek='';
			$cmbRincianObyek='';
			$cmbSubRincianObyek = '';
			$cmbSubSubRincianObyek = '';
		}else{
			$arrKondisi[]= "f =$cmbJenis";
		}
		if(empty($cmbObyek)) {
			$cmbRincianObyek='';
			$cmbSubRincianObyek = '';
			$cmbSubSubRincianObyek = '';
		}else{
			$arrKondisi[]= "g =$cmbObyek";
		}
		if(empty($cmbRincianObyek)) {
			$cmbSubRincianObyek = '';
			$cmbSubSubRincianObyek = '';
		}else{
			$arrKondisi[]= "h =$cmbRincianObyek";
		}
		if(empty($cmbSubRincianObyek)) {
			$cmbSubSubRincianObyek = '';
		}else{
			$arrKondisi[]= "i =$cmbSubRincianObyek";
		}
		if(empty($cmbSubSubRincianObyek)) {
		}else{
			$arrKondisi[]= "j =$cmbSubSubRincianObyek";
		}
		if(!empty($filterJenisBarang)){
				if($filterJenisBarang == '1'){
						$arrKondisi[] = "f !='08'";
				}else{
					$arrKondisi[] = "f ='08'";
					$arrKondisi[] = "j1 !='0000'";
				}
				if($filterJenisBarang == '2' && !empty($_REQUEST['cmbSubSubSubRincianObyek'])){
						$arrKondisi[]= "j1 =".$_REQUEST['cmbSubSubSubRincianObyek']."";
				}
		}



		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(f1,f2,f,g,h,i,j) like '".str_replace('.','',$_POST['fmKODE'])."%'";
		if(!empty($_POST['fmBARANG'])) $arrKondisi[] = " nm_barang like '%".$_POST['fmBARANG']."%'";
		$arrKondisi[] = "j !='000' ";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
			$arrOrders[] = " concat(f1,f2,f,g,h,i,j) ASC " ;
			$Order= join(',',$arrOrders);
			$OrderDefault = '';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);

		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal;
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}

}
$RefBarang = new RefBarangObj();

?>
