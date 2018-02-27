<?php

class reportObj  extends DaftarObj2{	
	var $Prefix = 'report';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'report'; //bonus
	var $TblName_Hapus = 'report';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'LAPORAN';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='report.xls';
	var $namaModulCetak='MASTER DATA';
	var $Cetak_Judul = 'pengguna_aplikasi';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'reportForm';
	var $noModul=9; 
	var $TampilFilterColapse = 0; //0
	var $username = "";
	
	function setTitle(){
		return ' LAPORAN ';
	}
	function setPage_HeaderOther(){
   		
	return 
	"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr>
	<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=report\" title='RKBMD PENGADAAN MURNI' style='color:blue'> LAPORAN </a>
	&nbsp&nbsp&nbsp	
	</td>
	</tr>
	</table>"
	;
	}
	function setMenuEdit(){
		$getUserInfo = mysql_fetch_array(mysql_query("select * from admin where uid ='$this->username'"));
		foreach ($getUserInfo as $key => $value) { 
			  $$key = $value; 
			}	
		if( $level =='5' || $level =='1'){
		return
			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";	
		}else{

		return " ";

		}	
		/*"<td>".genPanelIcon("javascript:".$this->Prefix.".Check()","sections.png","Check", 'Check')."</td>".*/
	}
	
	function setMenuView(){
		return "";
			
	}
	
	function Closes()
		{

		mysql_query("TRUNCATE table temp_jabatan");
		
		}	

	
	function simpanEdit(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	
	$dk= $_REQUEST['k'];
	$dl= $_REQUEST['l'];
	$dm= $_REQUEST['m'];
	$dn= $_REQUEST['n'];
	$do= $_REQUEST['o'];
	$nama= $_REQUEST['nm_pengguna_aplikasi'];
	

	//$ke = substr($ke,1,1);
	
								
	if($err==''){						
		
	$aqry = "UPDATE report set k='$dk',l='$dl',m='$dm',n='$dn',o='$do',nm_pengguna_aplikasi='$nama' where concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
						$qry = mysql_query($aqry);
				}
								
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	

	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
		
                           /*elseif(mysql_num_rows(mysql_query("select * from temp_cek_item where username ='$this->username' and status_delete !='delete'"))== 0){
			$err = "Isi Item Check";
		}*/

		$queryGetPosisi = mysql_query("select * from temp_jabatan where username = '$this->username' order by posisi asc");
		while ($gotData =mysql_fetch_array($queryGetPosisi)) {
			$arrPosisi[] = $gotData['id_jabatan'];
			if ($gotData['posisi'] == '1') {
				$kiri =  $gotData['id_jabatan'];
			}
			if ($gotData['posisi'] == '2') {
				$tengah =  $gotData['id_jabatan'];
			}
			if ($gotData['posisi'] == '3') {
				$kanan =  $gotData['id_jabatan'];
			}
		}
		if($fmST == 0){

							$data = array( 'nama_laporan' => $nama_laporan,
								            'jenis' => $cmbStatus,
							                         'tanda_tangan' => $arrayList,
								            'keterangan' => $keterangan,
								            'url' => $url,
								            'posisi' => implode(";", $arrPosisi),
								            'kiri' => $kiri,
								            'tengah' => $tengah,
								            'kanan' => $kanan,

										  
										  );
							mysql_query("delete  temp_jabatan where username ='$this->username'");
							mysql_query(VulnWalkerInsert("report",$data));
							$cek = VulnWalkerInsert("report",$data);
			}else{

									$data = array( 'nama_laporan' => $nama_laporan,
								            'jenis' => $cmbStatus,
							                         'tanda_tangan' => $arrayList,
								            'keterangan' => $keterangan,
								            'url' => $url,
								            'posisi' => implode(";", $arrPosisi),
								            'kiri' => $kiri,
								            'tengah' => $tengah,
								            'kanan' => $kanan,

										  
										  );
							mysql_query("delete  temp_jabatan where username ='$this->username'");
							mysql_query(VulnWalkerUpdate('report',$data,"id = '$hubla'"));
							$cek = VulnWalkerUpdate('report',$data,"id = '$hubla'");

			}	

					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
		
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	function tabelItem(){
			/*$datanya = "
				<tr class='row0'>
					<td align='center'>1.</td>
					<td><textarea name='CPTK' id='CPTK' style='width:100%; '>$CPTK</textarea></td>
					<td><textarea name='CPTU' id='CPTU' style='width:100%; '>$CPTU</textarea></td>
					<td><textarea name='CPTK' id='CPTK' style='width:100%; '>$CPTK</textarea></td>
			   </tr>
			   
			  
			";*/
			
		$aksi = '<a href="javascript:report.newrincian_pekerjaan()" id="pengguna_aplikasiAtasButton"><img id="gambarAtasButton" src="datepicker/add-256.png" style="width:20px;height:20px;"></a>';
	
		$content2 = 
					"

					<table class='koptable' style='width:100%;' border='1' id='tabelRincianPekerjaan'>
						<tr>
								<th class='th01'>NO</th>

								<th class='th01'>ITEM CHECK</th>
								<th class='th01'>KETERANGAN</th>
								<th class='th01'>$aksi</th>	
							
						</tr>
						$datanya
					</table>
					"
				
				;
		return $content2;
	}
	
	
	function tabelHistori($id){
		
		        $query = mysql_query("select * from histori_report where id_cek = '$id' order by id");
				$no = 1 ;
				while($rows = mysql_fetch_array($query)){
					foreach ($rows as $key => $value) { 
					  $$key = $value; 
					}
					if($no % 2 != 0){
						$tergantung = "row1";
					}else{
						$tergantung = "row0";
					}
					/*$getNamaModul = mysql_fetch_array(mysql_query("select * from ref_aplikasi where kode_aplikasi = '$id_aplikasi' and kode_modul = '$id_modul' and kode_sub_modul = '0'"));
					$namaModul = $getNamaModul['nama_aplikasi'];
					if($id_modul == '0'){
						$namaModul = "NON MODUL";
					}
					if($lastIDModul == $id_modul){
						$namaModul = "";
					}
					$action  = "<img src='images/administrator/images/edit_f2.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.editRincian('$id');></img> &nbsp &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.hapusRincian('$id');></img>";
					
					if($keterangan == ''){
						$action = "";
					}*/
					
					$isi =  "	
							<tr class='$tergantung'>
								<td align='center'>$no.</td>
								<td>".VulnWalkerTitiMangsa($tanggal_cek)."</td>
								<td>$username</td>
								<td>$keterangan</td>
								<td align='center'>$status_cek</td>
			   				</tr>
				
					";
					$lastIDModul = $id_modul;					
					$data .= $isi;
					$no += 1;
				}
				
		 	
		$content2 = 
					"

					<table class='koptable' style='width:100%;' border='1' >
						<tr>
								<th class='th01' width='20'>NO</th>
								<th class='th01' width='150'>TANGGAL CEK</th>
								<th class='th01' width='100'>USERNAME</th>
								<th class='th01'>KETERANGAN</th>
								<th class='th01' width='50'>STATUS</th>	
							
						</tr>
						$data
					</table>
					"
				
				;
		return $content2;
	}
	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	  
	  switch($tipe){
	  			case 'newrincian_pekerjaan':{			
				$fm = $this->newrincian_pekerjaan();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		
		case 'cekOK':{
				foreach ($_REQUEST as $key => $value) { 
					  $$key = $value; 
				}
				

					$data = array(
								 'status_cek' => "OK",
								 'tanggal_cek' => date("Y-m-d"),
								 'username' => $this->username
						);	
					mysql_query(VulnWalkerUpdate('report',$data,"id = '$id'"));
					$dataHistory = array(
								 'status_cek' => "OK",
								 'tanggal_cek' => date("Y-m-d"),
								 'id_cek' => $id,
								 'username' => $this->username
						);	
					mysql_query(VulnWalkerInsert("hireport",$dataHistory));

		break;
	    }

	    case 'chooserShow':{			
		foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
	              		}		    									
		break;
	    }

		case 'cekNo':{
				foreach ($_REQUEST as $key => $value) { 
					  $$key = $value; 
				}
				

					$data = array(
								 'status_cek' => "TIDAK",
								 'tanggal_cek' => date("Y-m-d"),
								 'username' => $this->username
						);	

		break;
	    }
		
		case 'Editrincian_pekerjaan':{
				foreach ($_REQUEST as $key => $value) { 
					  $$key = $value; 
				}
				
				if(empty($itemCheck)){
					$err = "Isi Item Cek";
				}else{
				
					
					
					$data = array(
								'item_cek' => $itemCheck,
								 'keterangan' => $ket,
						);	
					mysql_query(VulnWalkerUpdate('temp_cek_item',$data,"id = '$id'"));
				}
				
				
				
		break;
	    }
		case 'editrincian_pekerjaan':{	
						
				$fm = $this->editrincian_pekerjaan($_REQUEST['idTemp']);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}

	             case 'Closes':{	
						
                                            mysql_query("TRUNCATE table temp_jabatan"); 												
			break;
		}

		case 'hapusRincian':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				$getIDawal = mysql_fetch_array(mysql_query("select * from temp_cek_item where id = '$id'"));
				$idAwal = $getIDawal['id_awal'];
				
					$getIdParent = mysql_fetch_array(mysql_query("select * from temp_cek_item where id ='$id'"));
					$id_awal = $getIdParent['id_awal'];
					$data = array('status_delete' => 'delete',
								  'username' => $this->username
								  );
					mysql_query(VulnWalkerUpdate('temp_cek_item',$data,"id = '$id'"));
				
				
				
		break;
		}
		case 'Saverincian_pekerjaan':{			
				foreach ($_REQUEST as $key => $value) { 
					  $$key = $value; 
					}
				if(empty($itemCheck))$err = "Isi Item Cek";										
				if(empty($err)){
					$data = array('item_cek' => $itemCheck,
								  'keterangan' => $ket,
								  'username' => $this->username
								);
					mysql_query(VulnWalkerInsert("temp_cek_item",$data));			
				}								
			break;
		}
			case 'getTabel':{
			foreach ($_REQUEST as $key => $value) { 
					  $$key = $value; 
					}
			$aksi = '<a href="javascript:report.newrincian_pekerjaan()" id="pengguna_aplikasiAtasButton"><img id="gambarAtasButton" src="datepicker/add-256.png" style="width:20px;height:20px;"></a>';
			$header = "<tr>
								<th class='th01' width='20'>NO</th>

								<th class='th01' width='800'>ITEM CHECK</th>
								<th class='th01' width='400'>KETERANGAN</th>
								<th class='th01' width='50'>$aksi</th>	
							
						</tr>";
						
						

				//getDaftar
				$query = mysql_query("select * from temp_cek_item where username ='$this->username' and status_delete != 'delete'");
				$no = 1 ;
				while($rows = mysql_fetch_array($query)){
					foreach ($rows as $key => $value) { 
					  $$key = $value; 
					}
					if($no % 2 != 0){
						$tergantung = "row1";
					}else{
						$tergantung = "row0";
					}
					$getNamaModul = mysql_fetch_array(mysql_query("select * from ref_aplikasi where kode_aplikasi = '$id_aplikasi' and kode_modul = '$id_modul' and kode_sub_modul = '0'"));
					$namaModul = $getNamaModul['nama_aplikasi'];
					if($id_modul == '0'){
						$namaModul = "NON MODUL";
					}
					if($lastIDModul == $id_modul){
						$namaModul = "";
					}
					$action  = "<img src='images/administrator/images/edit_f2.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.editRincian('$id');></img> &nbsp &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.hapusRincian('$id');></img>";
					
					if($keterangan == ''){
						$action = "";
					}
					
					$isi =  "	
							<tr class='$tergantung'>
								<td align='center'>$no.</td>
								<td>$item_cek</td>
								<td>$keterangan</td>
								<td align='center'><span id='spanAction$id'>$action</span></td>
			   				</tr>
				
					";
					$lastIDModul = $id_modul;					
					$data .= $isi;
					$no += 1;
				}
			
			$content = array('tabel' => $header.$data);
			
		break;
	    }
		
		case 'getdata':{
				$Id = $_REQUEST['id'];
				$k = substr($Id, 0,1);
				$l = substr($Id, 2,1);
				$m = substr($Id, 4,1);
				$n = substr($Id, 6,2);
				$o = substr($Id, 9,2);
				$get = mysql_fetch_array( mysql_query("select *, concat(k,'.',l,'.',m,'.',n,'.',o) as kodepengguna_aplikasi  from report where k='$k' AND l='$l' AND m='$m' AND n='$n' AND o='$o'"));
			
				
				$content = array('kode_pengguna_aplikasi' => $get['kodepengguna_aplikasi'], 'nm_pengguna_aplikasi' => $get['nm_pengguna_aplikasi']);
					
				
		break;
	    }
		
		
		case 'saveProgres':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				
				if(empty($progres)){
					$err = "Isi Progres";
				}elseif(empty($url)){
					$err = "Isi URL";
				}elseif(empty($cmbPegawai)){
					$err = "Pilih Pegawai";
				}/*elseif(empty($cmbInstall)){
					$err = "Pilih Status Install";
				}*/
				else{
					$data = array('progres' => $progres,
								  'url' => $url,
								  'programer' => $cmbPegawai,/*
								  'install' => $cmbInstall,*/
								  'username' => $this->username,
								  'tanggal_update' => date('Y-m-d'),
								  'tgl_progress' => date('Y-m-d H:i:s'),
								  'uid_progress' => $this->username,
								 
								 );
					mysql_query(VulnWalkerUpdate("report",$data, "id = '$hubla'"));
					
				}
				
					
				
		break;
	    }
		
		
		case 'saveCheck':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				
				if(empty($cmbCheck)){
					$err = "Pilih Status Check";
				}
				else{
					$data = array(
								 'status_cek' => $cmbCheck,
								 'tanggal_cek' => date("Y-m-d"),
								 'username' => $this->username
						);	
					mysql_query(VulnWalkerUpdate('tabel_report',$data,"id = '$hubla'"));
					$dataHistory = array(
								 'status_cek' => $cmbCheck,
								 'tanggal_cek' => date("Y-m-d"),
								 'keterangan' => $keterangan,
								 'id_cek' => $hubla,
								 'username' => $this->username
						);	
					mysql_query(VulnWalkerInsert("histori_report",$dataHistory));
				}
				
					
				
		break;
	    }
		
		case 'pemdaChanged':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				$querycmbAplikasi = "select pengguna_aplikasi.id_aplikasi,ref_aplikasi.nama_aplikasi from pengguna_aplikasi 
inner join ref_aplikasi on pengguna_aplikasi.id_aplikasi = ref_aplikasi.kode_aplikasi where pengguna_aplikasi.id_pemda = '$idPemda' and ref_aplikasi.kode_modul = '0'";
					$cmbAplikasi = cmbQuery('cmbAplikasi','',$querycmbAplikasi,"' onclick =$this->Prefix.reportChanged(); ",'-- Pilih report --');
					
				
				$content = array(
								  'cmbAplikasi' => $cmbAplikasi,
								  'cmbModul' => cmbQuery('cmbModul',$id_modul,$queryCmbModul,"' onchange=$this->Prefix.modulChanged();",'-- Pilih Modul --'), 
								  'cmbSubModul' => cmbQuery('cmbSubModul',$id_modul,$queryCmbSubModul,"' ",'-- Pilih Sub Modul --'), 
								 );
	
		break;
		}
		case 'reportChanged':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				
				$queryCmbModul = "select kode_modul, nama_aplikasi from ref_aplikasi where kode_aplikasi = '$cmbAplikasi' and kode_modul != '0' and kode_sub_modul = '0'";
				$content = array('cmbModul' => cmbQuery('cmbModul',$id_modul,$queryCmbModul,"' onchange=$this->Prefix.modulChanged();",'-- Pilih Modul --'),
								 'cmbSubModul' => cmbQuery('cmbSubModul',$id_modul,$queryCmbSubModul,"' ",'-- Pilih Sub Modul --')
								
								 );
	
		break;
		}
		
		case 'modulChanged':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				
				$comboKategori = cmbQuery('cmbKategori',$id_kategori,"select id, nama from tabel_kategori where  id_aplikasi = '$id_aplikasi' and id_modul = '$id_modul'"," style = 'width:380;'",'-- Pilih Kategori --');
	  			$content = array('cmbKategori' =>$comboKategori
								
								 );
	
		break;
		}
		

		case 'simpanModul':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				if(mysql_num_rows(mysql_query("select * from ref_modul where nama_modul = '$namaModul' and parent ='0' and id_aplikasi = '$cmbAplikasi'")) > 0){
					$err = "Modul Sudah Ada";
				}else{
					$data = array('nama_modul' => $namaModul,
								  'parent' => '0',
								  'id_aplikasi' => $cmbAplikasi
								  );
					mysql_query(VulnWalkerInsert('ref_modul',$data));
					$idnya = mysql_fetch_array(mysql_query("select * from ref_modul where nama_modul = '$namaModul' and parent = '0' and id_aplikasi = '$cmbAplikasi'"));
					$content = array('replacer' => cmbQuery('cmbModul',$idnya['id'],"select id,nama_modul from ref_modul where parent ='0' and id_aplikasi = '$cmbAplikasi'",'style="width:500;" onchange=$this->Prefix.modulChanged();','-- Pilih Modul --'),
									 'cmbSubModul' => cmbQuery('cmbModul',$idnya['id'],"select id,nama_modul from ref_modul where parent ='".$idnya['id']."' and id_aplikasi = '$cmbAplikasi'",'style="width:500;" ','-- Pilih Sub Modul --')
					 );
				}
		break;
		}
		
		
		case 'simpanSubModul':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				if(mysql_num_rows(mysql_query("select * from tabel_kategori where nama = '$namaKategori' and id_aplikasi = '$id_aplikasi' and id_modul = '$id_modul' ")) > 0){
					$err = "Kategori Sudah Ada";
				}else{
					$data = array('nama' => $namaKategori,
								  'id_aplikasi' => $id_aplikasi,
								  'id_modul' => $id_modul
								  );
					mysql_query(VulnWalkerInsert('tabel_kategori',$data));
					$idnya = mysql_fetch_array(mysql_query("select * from tabel_kategori where nama = '$namaKategori' and id_aplikasi = '$id_aplikasi' and id_modul = '$id_modul' "));
					$content = array('replacer' => cmbQuery('cmbKategori',$idnya['id'],"select id,nama from tabel_kategori where id_aplikasi = '$id_aplikasi' and id_modul = '$id_modul'",'style="width:500;" ','-- Pilih Kategori --') );
				}
		break;
		}
		
		case 'simpanreport':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				if(mysql_num_rows(mysql_query("select * from ref_aplikasi where nama_pemda = '$namareport'")) > 0){
					$err = "report Sudah Ada";
				}else{
					$data = array('nama_aplikasi' => $namareport);
					mysql_query(VulnWalkerInsert('ref_aplikasi',$data));
					$idnya = mysql_fetch_array(mysql_query("select * from ref_aplikasi where nama_aplikasi = '$namareport'"));
					$content = array('replacer' => cmbQuery('cmbPemda',$idnya['id'],"select id,nama_aplikasi from ref_aplikasi",'style="width:500;"','-- Pilih report --') );
				}
		break;
		}
		
		case 'editModul':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				$data = array('nama_modul' => $namaModul);
				mysql_query(VulnWalkerUpdate("ref_modul",$data,"id='$id'"));
				$idnya = mysql_fetch_array(mysql_query("select * from ref_modul where nama_modul = '$namaModul' and parent = '0' and id_aplikasi = '$cmbAplikasi' "));
				$content = array('replacer' => cmbQuery('cmbModul',$idnya['id'],"select id,nama_modul from ref_modul where parent ='0' and id_aplikasi = '$cmbAplikasi'","' onchange=$this->Prefix.modulChanged();",'-- Pilih Modul --') );
		break;
		}
		
		case 'editSubModul':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				$data = array('nama' => $namaKategori);
				mysql_query(VulnWalkerUpdate("tabel_kategori",$data,"id='$id'"));
				$idnya = mysql_fetch_array(mysql_query("select * from tabel_kategori where nama = '$namaKategori'  "));
				$content = array('replacer' => cmbQuery('cmbKategori',$idnya['id'],"select id,nama from tabel_kategori where id_aplikasi = '$id_aplikasi' and id_modul = '$id_modul'",'','-- Pilih Kategori --') );
		break;
		}
		
		
		case 'editreport':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				$data = array('nama_aplikasi' => $namareport);
				mysql_query(VulnWalkerUpdate("ref_aplikasi",$data,"id='$id'"));
				$idnya = mysql_fetch_array(mysql_query("select * from ref_aplikasi where nama_aplikasi = '$namareport'"));
				$content = array('replacer' => cmbQuery('cmbAplikasi',$idnya['id'],"select id,nama_aplikasi from ref_aplikasi",'style="width:500;"','-- Pilih report --') );
		break;
		}


			

		case 'formBaru':{		
			mysql_query("delete  from temp_jabatan where username ='$this->username'");	
			$fm = $this->setFormBaru();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}

		case 'formLihat':{		
			$fm = $this->setFormLihat($url);				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'showHistori':{		
				
			$fm = $this->showHistori($_REQUEST['id']);				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'formProgres':{	
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
			$dt = $report_cb[0];		
			$fm = $this->Progres($dt);				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		
		case 'formCheck':{	
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
			
			$fm = $this->Check($idCheck);				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		

		
		case 'formBaruModul':{			
				$idModul = $_REQUEST['idModul'];
				$fm = $this->setFormBaruModul($idModul);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		
		case 'formBaruSubModul':{			
				$idSubModul = $_REQUEST['cmbKategori'];
				$fm = $this->setFormBaruSubModul($idSubModul);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		
		case 'formBarureport':{			
				$idreport = $_REQUEST['idreport'];
				$fm = $this->setFormBarureport($idreport);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}		
		

		case 'formEdit':{			
			mysql_query("delete from temp_cek_item where username ='$this->username'");		
						
			$fm = $this->setFormEdit();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
			
		case 'simpan':{

			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		

			
		case 'simpanEdit':{
			$get= $this->simpanEdit();
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
   


	
	 function setFormBaruModul($idModul){
		
		$this->form_fmST = 0;
		
		$fm = $this->BaruModul($idModul);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
             
             function setFormLihat($url){
		
		$this->form_fmST = 0;
		
		$fm = $this->Lihat($url);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	 function setFormBaruSubModul($idSubModul){
		
		$this->form_fmST = 0;
		
		$fm = $this->BaruSubModul($idSubModul);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	 function setFormBarureport($idreport){
		
		$this->form_fmST = 0;
		
		$fm = $this->Barureport($idreport);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}


	 function Lihat($url){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 500;
	 $this->form_height = 80;
	 $this->form_caption = 'LIHAT LAPORAN';

	  
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);

              $url = $_REQUEST['url'];
              $urusan = $_REQUEST['cmbUrusan'];
              $bidang = $_REQUEST['cmbBidang'];
              $skpd = $_REQUEST['cmbSKPD'];
              $unit = $_REQUEST['cmbUnit'];
              $subunit = $_REQUEST['cmbSubUnit'];

        if ($urusan != "" && $bidang =="" && $skpd =="" && $unit =="" && $subunit =="") {
                          
                          $opsi = "&urusan=$urusan";
                   
                   } 
             
             else if ($urusan != "" && $bidang != "" && $skpd =="" && $unit =="" && $subunit =="") {
                          
                          $opsi = "&urusan=$urusan&bidang=$bidang";
                   
                   } 
             
             else if ($urusan != "" && $bidang != "" && $skpd !="" && $unit =="" && $subunit =="") {
                          
                          $opsi = "&urusan=$urusan&bidang=$bidang&skpd=$skpd";
                   
                   } 
            else if ($urusan != "" && $bidang != "" && $skpd !="" && $unit !="" && $subunit =="") {
                          
                          $opsi = "&urusan=$urusan&bidang=$bidang&skpd=$skpd&unit=$unit";
                   
                   } 

            else if ($urusan != "" && $bidang != "" && $skpd !="" && $unit !="" && $subunit !="") {
                          
                             $opsi = "&urusan=$urusan&bidang=$bidang&skpd=$skpd&unit=$unit&subunit=$subunit";
                   
                  } 
	 //items ----------------------
	  $this->form_fields = array(
			
			'Tanggal' => array( 
						'label'=>'Tanggal',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
					             <input type='text' name='cariTanggal' onchange='".$this->Prefix.".injectUrl()' id='cariTanggal' value='".date('d-m-Y')."' style='text-align:left;'>
						</div>", 
						 ),
			
			'Kota' => array( 
						'label'=>'Kota',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='kota'  onchange='".$this->Prefix.".injectUrl()' id='kota' value='' style='width:255px;' >

						</div>", 
						 ),	

									 			
				
			);
		//tombol
		$this->form_menubawah =
			"
			<input type='hidden' id='urlAwal' value='$url$opsi'>
			<a target='_blank' id='postUrl' href='$url$opsi' style='text-decoration:none;'><input type='button' value='LIHAT'/></a>"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	

	
	
	function BaruModul($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 500;
	 $this->form_height = 80;
	 
	 if(!empty($dt)){
	 	$this->form_caption = 'Edit Modul';
		$kemana = "EditModul($dt)";
		$namaModul = mysql_fetch_array(mysql_query("select * from ref_modul where id='$dt'"));
		$namaModul = $namaModul['nama_modul'];
	 }else{
	 	if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Modul';


		$kemana = 'SimpanModul()';
		
	  }
	 }
	  
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'Kelompok' => array( 
						'label'=>'Nama Modul',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='namaModul' id='namaModul' value='$namaModul' style='width:255px;' >

						</div>", 
						 ),	
									 			
				
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".$kemana' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function BaruSubModul($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 500;
	 $this->form_height = 80;
	 
	 if(!empty($dt)){
	 	$this->form_caption = 'Edit Kategori';
		$kemana = "EditSubModul($dt)";
		$namaSubModul = mysql_fetch_array(mysql_query("select * from tabel_kategori where id='$dt'"));
		$namaSubModul = $namaSubModul['nama'];
	 }else{
	 	if ($this->form_fmST==0) {
		$this->form_caption = 'Kategori Baru';


		$kemana = 'SimpanSubModul()';
		
	  }
	 }
	  
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'Kelompok' => array( 
						'label'=>'Nama Kategori',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='namaKategori' id='namaKategori' value='$namaSubModul' style='width:255px;' >

						</div>", 
						 ),	
									 			
				
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".$kemana' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Barureport($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 500;
	 $this->form_height = 80;
	 
	 if(!empty($dt)){
	 	$this->form_caption = 'Edit report';
		$kemana = "Editreport($dt)";
		$namareport = mysql_fetch_array(mysql_query("select * from ref_aplikasi where id='$dt'"));
		$namareport = $namareport['nama_aplikasi'];
	 }else{
	 	if ($this->form_fmST==0) {
		$this->form_caption = 'Baru report';
		$nip	 = '';

			
		$kemana = 'Simpanreport()';
		
	  }
	 }
	  
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'Kelompok' => array( 
						'label'=>'Nama report',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='namareport' id='namareport' value='$namareport' style='width:255px;' >

						</div>", 
						 ),	
									 			
				
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".$kemana' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
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
	

	function setPage_OtherScript(){
		$getUserInfo = mysql_fetch_array(mysql_query("select * from admin where uid ='$this->username'"));
		foreach ($getUserInfo as $key => $value) { 
			  $$key = $value; 
			}	
                                
			if(!isset($_REQUEST['jumlahPerHal'])){
				$angka = "25";
			}else{
				$angka = $_REQUEST['jumlahPerHal'];
			}
			$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
	
		return 
			 "<script src='js/skpd.js' type='text/javascript'></script>
			 <script type='text/javascript' src='js/report/report.js' language='JavaScript' ></script>
			 <script type='text/javascript' src='js/report/popupSource.js' language='JavaScript' ></script>
			 ".'<link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>'.
			
			$scriptload;
	}
	
	//form ==================================
	/*function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}*/
	
	function setFormBaru(){
		//$cbid = $_REQUEST[$this->Prefix.'_cb'];
		//$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		//$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		//$e = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
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
			$dt['kode_jurnal']=$fmBIDANG.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_jurnal']=$fmBIDANG.'.'.$fmKELOMPOK.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_jurnal']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_jurnal']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.$fmSUBSUBKELOMPOK.'.';
		}
		$fm = $this->setForm($dt);		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
   
  	function setFormEdit(){
		$cek ='';
		
		foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			}
		$this->form_fmST = 1;
		
		$fm = $this->setForm($report_cb[0]);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function setFormEditdata($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 490;
	 $this->form_height = 150;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'FORM EDIT KODE pengguna_aplikasi';
	  }
	 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;	
		$k=$kode[0];
		$l=$kode[1];
		$m=$kode[2];
		$n=$kode[3];
		$o=$kode[4];
		
		
		
		$queryKAedit=mysql_fetch_array(mysql_query("SELECT k, nm_pengguna_aplikasi FROM report WHERE k='$k' and l = '0' and m='0' and n='00' and o='00'")) ;
		$cek.=$queryKAedit;
		$queryKBedit=mysql_fetch_array(mysql_query("SELECT l, nm_pengguna_aplikasi FROM report WHERE k='$k' and l='$l' and m= '0' and n='00' and o='00'")) ;
		$queryKCedit=mysql_fetch_array(mysql_query("SELECT m, nm_pengguna_aplikasi FROM report WHERE k='$k' and l='$l' and m='$m' and n='00' and o='00'")) ;
		$queryKDedit=mysql_fetch_array(mysql_query("SELECT n, nm_pengguna_aplikasi FROM report WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='00'")) ;
		$queryKEedit=mysql_fetch_array(mysql_query("SELECT o, nm_pengguna_aplikasi FROM report WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o'")) ;
	//	$cek.="SELECT ke, nm_account FROM ref_jurnal WHERE ka='$data_ka' and kb='$data_kb' and kc='$data_kc' and kd='$data_kd' and ke='$data_ke' and kf='0'";
					
	
		$datka=$queryKAedit['k'].".  ".$queryKAedit['nm_pengguna_aplikasi'];
		$datkb=$queryKBedit['l'].". ".$queryKBedit['nm_pengguna_aplikasi'];
		$datkc=$queryKCedit['m']." .  ".$queryKCedit['nm_pengguna_aplikasi'];
		$datkd=$queryKDedit['n'].". ".$queryKDedit['nm_pengguna_aplikasi'];
		$datke=$queryKEedit['o'];
	//	$datke=sprintf("%02s",$queryKEedit['ke'])." .  ".$queryKEedit['nm_account'];
		
       //items ----------------------
		  $this->form_fields = array(
		  
		  'kode_Akun' => array( 
						'label'=>'kode pengguna_aplikasi',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='ek' id='ek' value='".$datka."' style='width:270px;' readonly>
						<input type ='hidden' name='k' id='k' value='".$queryKAedit['k']."'>
						</div>", 
						 ),
			'kode_kelompok' => array( 
						'label'=>'Kode Kelompok',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='el' id='el' value='".$datkb."' style='width:270px;' readonly>
						<input type ='hidden' name='l' id='l' value='".$queryKBedit['l']."'>
						</div>", 
						 ),
			'kode_Jenis' => array( 
						'label'=>'kode Jenis',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='em' id='em' value='".$datkc."' style='width:270px;' readonly>
						<input type ='hidden' name='m' id='m' value='".$queryKCedit['m']."'>
						</div>", 
						 ),
			'kode_Objek' => array( 
						'label'=>'kode Objek',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='en' id='en' value='".$datkd."' style='width:270px;' readonly>
						<input type ='hidden' name='n' id='n' value='".$queryKDedit['n']."'>
						</div>", 
						 ),
			'Kode_Rincian_Objek' => array( 
						'label'=>'Kode Rincian Objek',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='eo' id='eo' value='".$datke."' style='width:20px;' readonly>
						<input type ='hidden' name='o' id='o' value='".$queryKEedit['o']."'>
						<input type='text' name='nm_pengguna_aplikasi' id='nm_pengguna_aplikasi' value='".$dt['nm_pengguna_aplikasi']."' size='36px'>
						</div>", 
						 ),			 			 			 
						 			 
		 
			
			/*'Nama' => array( 
						'label'=>'Nama',
						//'id'=>'cont_object',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'><input type='text' name='nm_account' id='nm_account' value='".$dt['nm_account']."' size='40px'>
						</div>", 
						 ),		*/				 
			);
		//tombol
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanEdit()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
			"<input type='hidden' name='ka' id='ka' value='".$dt['ka']."'>".
			"<input type='hidden' name='kb' id='kb' value='".$dt['kb']."'>".
			"<input type='hidden' name='kc' id='kc' value='".$dt['kc']."'>".
			"<input type='hidden' name='kd' id='kd' value='".$dt['kd']."'>".
			"<input type='hidden' name='ke' id='ke' value='".$dt['ke']."'>".
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


		
	function setForm($dt){	
	 global $SensusTmp ,$Main;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';
	 			
	 $this->form_width = 600;
	 $this->form_height = 190;
	 foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			}	
	  $id_aplikasi = $cmbAplikasi;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$id_aplikasi = $_REQUEST['cmbAplikasi'];

	  }else{
		$this->form_caption = 'Edit';			
		$readonly='readonly';
		$get = mysql_fetch_array(mysql_query("select * from report where id ='$dt'"));
		foreach ($get as $key => $value) { 
			  $$key = $value; 
			}	
		mysql_query("DELETE from temp_jabatan where username ='$this->username'");

		            $listArray = explode(';', $tanda_tangan);
		            $listPosisi = explode(';', $posisi);

		            for ($i=0; $i < sizeof($listArray); $i++) { 

                                      if ($listArray[$i] == $kiri) {
                                      	  $posisiNumber = 1;
                                      }
                                       else if ($listArray[$i] == $tengah) {
                                      	  $posisiNumber = 2;
                                      }
                                       else if ($listArray[$i] == $kanan) {
                                      	  $posisiNumber = 3;
                                      }

			// $posisiNumber = array_search($listArray[$i], $listPosisi);
			// $posisiNumber += 1;                                    
                                         mysql_query("INSERT into temp_jabatan values('$this->username','$listArray[$i]','checked','$posisiNumber')");

                                         }
 if($jenis == 'L'){
	 
	 $cmbStatus = 'L';
               
               }

               elseif($jenis == 'P'){
	 
	 $cmbStatus = 'P';
	 
	  }
		
		
	  }



	    //ambil data trefditeruskan
		$arrayJenis = array(
				                 array('L' , 'Lanscape'),
				                 array('P' , 'Portrait'),
						
				       );
	  $cmbPemda = cmbQuery('cmbPemda',$id_pemda,"select id,nama_pemda from ref_pemda where kota!='0'","' onchange=$this->Prefix.pemdaChangeddisabeld();",'-- Pilih Pemda --');
	  $queryCmbModul = "select kode_modul, nama_aplikasi from ref_aplikasi where kode_aplikasi = '".$id_aplikasi."' and kode_modul != '0' and kode_sub_modul = '0'";
	  $cmbModul = cmbQuery('cmbModulForm',$id_modul,$queryCmbModul,"' onchange=$this->Prefix.modulChanged();  style = 'width:475;'",'-- Pilih Modul --');
	  $comboKategori = cmbQuery('cmbKategori',$id_kategori,"select id, nama from tabel_kategori where id_aplikasi = '$id_aplikasi' and id_modul = '$id_modul'"," style = 'width:380;'",'-- Pilih Kategori --');

	 
	$cmbStatus = cmbArray('cmbStatus',$get['jenis'],$arrayJenis,"-- Jenis Laporan --",'');			
               
               	$arrayKategoriFunction = array();
				
	                

			 $arrayList = array();

                                         
                                         $listArray = explode(';',  $tanda_tangan);

                                         for ($i=0; $i < sizeof($listArray); $i++) { 
                                         	$getListItem = mysql_fetch_array(mysql_query("select * from ref_kategori_tandatangan where id ='$listArray[$i]'"));

                                         	 $namaSource = $getListItem['kategori_tandatangan'];
                                                     $arrayKategoriFunction[] = "&nbsp - ".$namaSource;

				 $arrayList[] = $listArray[$i];
			
		
			

                                         }

			$listUpdate = "<br><b>JABATAN</b> : "."<br>".implode("<br>",$arrayKategoriFunction);	
	
			$content = array('listUpdate' => $listUpdate,"arrayList" => implode(';',$arrayList));

	 //items ----------------------
	  $this->form_fields = array(
			
			
						 	

                                      	'nama_laporan' => array( 
						'label'=>'NAMA LAPORAN',
						'labelWidth'=>100, 
						'value'=>"<input type='text' value='$nama_laporan' id='nama_laporan' name='nama_laporan'  style='width: 93%;'> ", 
						 ),

		             'jenis_laporan' => array( 
						'label'=>'JENIS KERTAS',
						'labelWidth'=>100, 
						'value'=>$cmbStatus, 
						 ),

		             'keterangan' => array( 
						'label'=>' KETERANGAN ',
						'labelWidth'=>100, 
						'value'=>"<textarea name='keterangan' id='keterangan' style='width: 93%;'>$keterangan</textarea>", 
						 ),
		             

		             'url' => array( 
						'label'=>'LOKASI URL',
						'labelWidth'=>100, 
						'value'=>"<input type='text' value='$url' id='url' name='url'  style='width: 93%;'> ", 
						 ),


			'fileupdate' => array( 
						'label'=>'TANDA TANGAN',
						'labelWidth'=>100, 
						'value'=>"<input type='button' value='PILIH' id='pemicu' onclick=$this->Prefix.chooserShow($dt); style='width: 60%;'> ", 
						 ),
                                    	'new' => array( 
						'label'=>'LIST UPDATED',
						'labelWidth'=>100, 
						'value'=>"<div style='width:470px;height:150px;' readonly id='listUpdate' name='listUpdate'>$listUpdate</div>
						<input type='hidden' name='arrayList' id='listItem' value='".$arrayList."'>
						<input type='hidden' name='arrayPosisi' id='listPosisi' value='".$arrayPosisi."'> ", 
						'type' => 'merge'
						 ),
			
				
			
			);
		//tombol
		$this->form_menubawah =
			
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan($dt)' title='Simpan' > &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Closes()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function showHistori($dt){	
	 global $SensusTmp ,$Main;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';
	 			
	 $this->form_width = 500;
	 $this->form_height = 210;
	 foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			}	
	
		$this->form_caption = 'HISTORI';			
		
		
	

	 //items ----------------------
	  $this->form_fields = array(
			
			
						 	




			'item_cek2' => array( 
						'label'=>'ITEM CEK',
						'labelWidth'=>100, 
						'value'=> $this->tabelHistori($dt),
						'type' => "merge"
						
						 ),

			
				
			
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Tutup' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm2();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
function Progres($dt){	
	 global $SensusTmp ,$Main;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';
	 			
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'Progres';	
	 $got = mysql_fetch_array(mysql_query("select * from report where id='$dt'"));
	 foreach ($got as $key => $value) { 
			  $$key = $value; 
			}
	 $arrayInstall = array(
						array('YA' , 'YA'),
						array('TIDAK' , 'TIDAK'),
						
						);	
	 $cmbInstall = cmbArray('cmbInstall',$install,$arrayInstall,'-- STATUS INSTALL --','style="width:200;"');	
	 $cmbPegawai = cmbQuery('cmbPegawai',$programer,"select Id,nama from ref_pegawai","style='width:200;'",'-- Pilih Pegawai --');
	 //items ----------------------
	  $this->form_fields = array(
			'progres' => array( 
						'label'=>'PROGRES',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='progres' id='progress' value='".$progres."' placeholder='PROGRES' style='width:70; text-align:right;'> %
						</div>", 
						 ),
			
			'url' => array( 
						'label'=>'URL',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='url' id='url' value='".$url."' placeholder='URL' style='width:250; text-align:left;'> 
						</div>", 
						 ),
			/*'status_install' => array( 
						'label'=>'STATUS INSTALL',
						'labelWidth'=>120, 
						'value'=> $cmbInstall 
						 ),	*/
			'pr' => array( 
						'label'=>'PROGRAMER',
						'labelWidth'=>120, 
						'value'=> $cmbPegawai 
						 ),	
						 	
				
			
			);
		//tombol
		$this->form_menubawah =
			
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveProgres($dt)' title='Simpan' > &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		

function Check($dt){	
	 global $SensusTmp ,$Main;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';
	 			
	 $this->form_width = 400;
	 $this->form_height = 100;
	 $this->form_caption = 'Check';	
	 $got = mysql_fetch_array(mysql_query("select * from tabel_report where id='$dt'"));
	 foreach ($got as $key => $value) { 
			  $$key = $value; 
			}
	 $arrayInstall = array(
						array('OK' , 'OK'),
						array('TIDAK' , 'TIDAK'),
						
						);	
	if(empty($status_cek))$status_cek='TIDAK';
	 $cmbCheck = cmbArray('cmbCheck',$status_cek,$arrayInstall,'-- STATUS CHECK --','');	

	  $this->form_fields = array(

			
			'status_check' => array( 
						'label'=>'STATUS CHECK',
						'labelWidth'=>120, 
						'value'=> $cmbCheck 
						 ),	
			'keterangan' => array( 
						'label'=>'KETERANGAN',
						'labelWidth'=>120, 
						'value'=> "<textarea  name='keterangan' id = 'keterangan' style='width:220;height:50;'> </textarea>" 
						 ),		 	
				
			
			);
		//tombol
		$this->form_menubawah =
			
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveCheck($dt)' title='Simpan' > &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 global $Main;
	 $NomorColSpan = $Mode==1? 2: 1;
	 if(isset($_REQUEST['jumlahPerHal'])){
	 	$Main->PagePerHal =  $_REQUEST['jumlahPerHal'];
	 }else{
	 	$Main->PagePerHal =  25;
	 }
	
		$rowspan_cbx = $this->checkbox_rowspan >1 ? "rowspan='$this->checkbox_rowspan'":'';
		$Checkbox = $Mode==1? 
			"<th class='th01' width='10' $rowspan_cbx>
					<input type='checkbox' name='".$this->Prefix."_toggle' id='".$this->Prefix."_toggle' value='' ".
						//" onClick=\"checkAll4($Main->PagePerHal,'".$this->Prefix."_cb','".$this->Prefix."_toggle','".$this->Prefix."_jmlcek');\" /> ".
						" onClick=\"checkAll4($Main->PagePerHal,'".$this->Prefix."_cb','".$this->Prefix."_toggle','".$this->Prefix."_jmlcek');".
							"$this->Prefix.checkAll($Main->PagePerHal,'".$this->Prefix."_cb','".$this->Prefix."_toggle','".$this->Prefix."_jmlcek')\" /> ".
						
			" </th>" : '';	

	 $getUserInfo = mysql_fetch_array(mysql_query("select * from admin where uid ='$this->username'"));
              
              foreach ($getUserInfo as $key => $value) { 
                  $$key = $value; 
	 }

		
	  $cekCheckbox = $Checkbox;



	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $cekCheckbox		
		   <th class='th01' width='300' >NAMA LAPORAN</th>
		   <th class='th01' width='50'  align='center'>Jenis</th>
		   
		   <th class='th01' width='250'  align='center'>KETERANGAN</th>
		   <th class='th01' width='150'  align='center'>AKSI</th>
		   
	   </tr>

	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) { 
			  $$key = $value; 
			}
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  
	
		
	 $Koloms[] = array(" align='center' ", $TampilCheckBox);

	 $Koloms[] = array('align="left"',$nama_laporan);
              $Koloms[] = array('align="center"',$jenis); 

              $urusan = $_REQUEST['cmbUrusan'];
              $bidang = $_REQUEST['cmbBidang'];
              $skpd = $_REQUEST['cmbSKPD'];
              $unit = $_REQUEST['cmbUnit'];
              $subunit = $_REQUEST['cmbSubUnit'];
              


              if ($urusan != "" && $bidang =="" && $skpd =="" && $unit =="" && $subunit =="") {
                          
                          $opsi = "&urusan=$urusan";
                   
                   } 
             
             else if ($urusan != "" && $bidang != "" && $skpd =="" && $unit =="" && $subunit =="") {
                          
                          $opsi = "&urusan=$urusan&bidang=$bidang";
                   
                   } 
             
             else if ($urusan != "" && $bidang != "" && $skpd !="" && $unit =="" && $subunit =="") {
                          
                          $opsi = "&urusan=$urusan&bidang=$bidang&skpd=$skpd";
                   
                   } 
            else if ($urusan != "" && $bidang != "" && $skpd !="" && $unit !="" && $subunit =="") {
                          
                          $opsi = "&urusan=$urusan&bidang=$bidang&skpd=$skpd&unit=$unit";
                   
                   } 

            else if ($urusan != "" && $bidang != "" && $skpd !="" && $unit !="" && $subunit !="") {
                          
                             $opsi = "&urusan=$urusan&bidang=$bidang&skpd=$skpd&unit=$unit&subunit=$subunit";
                   
                  } 


              $Koloms[] = array('align="left"',$keterangan);
              $Koloms[] = array('align="center"',"<a target='_blank' href='$url?cetak=1' style='cursor:pointer;'>CETAK</a> | 
              	<a  onClick=$this->Prefix.Lihat('$url') style='cursor:pointer;'>LIHAT</a>");
       
	 
	

	 
	 
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
	  
		$codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) from ref_skpd where c='00' and d='00' and e='00' and e1='000' ";
		$urusan = cmbQuery('cmbUrusan',$cmbUrusan,$codeAndNameUrusan,"onchange='".$this->Prefix.".refreshList(true)'",'-- URUSAN --');
		
		$codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$cmbUrusan' and c !='00' and d='00' and e='00' and e1='000' ";
		$bidang = cmbQuery('cmbBidang',$cmbBidang,$codeAndNameBidang,"onchange='".$this->Prefix.".refreshList(true)'",'-- BIDANG --');
		
		$codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d!='00' and e='00' and e1='000' ";
		$skpd= cmbQuery('cmbSKPD',$cmbSKPD,$codeAndNameSKPD,"onchange='".$this->Prefix.".refreshList(true)'",'-- SKPD --');
		
		$codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e!='00' and e1='000' ";
		$unit = cmbQuery('cmbUnit',$cmbUnit,$codeAndNameUnit,"onchange='".$this->Prefix.".refreshList(true)'",'-- UNIT --');
		
		
		$codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1!='000' ";
		$subunit = cmbQuery('cmbSubUnit',$cmbSubUnit,$codeAndNameSubUnit,"onchange='".$this->Prefix.".refreshList(true)'",'-- SUB UNIT --');

		$TampilOpt = 
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td>URUSAN </td>
			<td>:</td>
			<td style='width:86%;'> 
			".$urusan."
			</td>
			</tr>
			<tr>
			<td>BIDANG</td>
			<td>:</td>
			<td style='width:86%;'>
			".$bidang."
			</td>
			</tr>
			<tr>
			<td>SKPD</td>
			<td>:</td>
			<td style='width:86%;'>
			".$skpd."
			</td>
			</tr>
			<tr>
			<td>UNIT</td>
			<td>:</td>
			<td style='width:86%;'>
			".$unit."
			</td>
			</tr>
			<tr>
			<td>SUB UNIT</td>
			<td>:</td>
			<td style='width:86%;'>
			".$subunit."<input type='hidden' name='tahun' id='tahun' value='$this->tahun' style='width:40px;' > <input type='hidden' name ='cmbJenisRKA' id='cmbJenisRKA' value='2.2'>
			</td>
			</tr>
			
			
			
			
			</table>"
			
			;
			
		return array('TampilOpt'=>$TampilOpt);
		
		
	}
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			}	
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$this->pagePerHal = $jumlahPerHal;
		if(empty($cmbAplikasi)){
		  	$cmbModul = "";
			$kategoriFilter = "";
		  }	
		  if(empty($cmbModul)){
			$kategoriFilter = "";
		  }	
		if(!empty($cmbAplikasi))$arrKondisi[] = "id_aplikasi = '$cmbAplikasi'";
		if(!empty($cmbModul))$arrKondisi[] = "id_modul = '$cmbModul'";
		if(!empty($kategoriFilter))$arrKondisi[] = "id_kategori = '$kategoriFilter'";
		if(!empty($statusFilter)){
			if($statusFilter == "OK"){
				$arrKondisi[] = "status_cek = 'OK'";
			}else{
				$arrKondisi[] = "status_cek != 'OK'";
			}
			
		}
		
		
		

		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		/*$arrOrders[] = "id_pemda,id_aplikasi,id_modul,id_sub_modul";right((100 +id_aplikasi),2),right((100 +id_modul),2),right((100 +id_kategori),2) */
		$arrOrders[] = "concat(right((100 +id),2))";

		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	function genForm2($withForm=TRUE){	
		$form_name = $this->Prefix.'_form';	
				
		if($withForm){
			$params->tipe=1;
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
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height,
					'',$params
					).
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
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				);
			
			
		}
		return $form;
	}	

function newrincian_pekerjaan($id){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 500;
	 $this->form_height = 200;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
	 	$this->form_caption = 'BARU';
		if(!empty($id)){
			$kemana = "Editrincian_pekerjaan($id)";
			$read = "disabled";
		}else{
			$kemana = "Saverincian_pekerjaan()";
		}
		


	 //items ----------------------
	  $this->form_fields = array(


			'spek' => array( 
						'label'=>'ITEM CEK',
						'labelWidth'=>150, 
						'value'=>"", 
						 ),
			'sasdpek' => array( 
						'label'=>'RINCIAN PEKERJAAN',
						'labelWidth'=>150, 
						'value'=>"<div style='float:left;'>
						<textarea name = 'itemCheck' id = 'itemCheck' style='width:475px;height:50px;' >$item_cek</textarea>
						</div>", 
						'type' => 'merge'
						 ),	
			'ket' => array( 
						'label'=>'KETERANGAN',
						'labelWidth'=>100, 
						'value'=>"", 
						 ),	
			'keasdast' => array( 
						'label'=>'KETERANGAN',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<textarea name = 'ket' id = 'ket' style='width:475px; height:50px;'>$keterangan</textarea>

						</div>", 
						'type' => 'merge'
						 ),							 			
				
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".$kemana' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function editrincian_pekerjaan($id){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 500;
	 $this->form_height = 200;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
	 	$this->form_caption = 'EDIT';
		
		
		$getData = mysql_fetch_array(mysql_query("select * from temp_cek_item where id = '$idTemp'"));
		foreach ($getData as $key => $value) { 
				  $$key = $value; 
				}

		

		
	 //items ----------------------
	  $this->form_fields = array(
			'spek' => array( 
						'label'=>'ITEM CEK',
						'labelWidth'=>150, 
						'value'=>"", 
						 ),
			'sasdpek' => array( 
						'label'=>'RINCIAN PEKERJAAN',
						'labelWidth'=>150, 
						'value'=>"<div style='float:left;'>
						<textarea name = 'itemCheck' id = 'itemCheck' style='width:475px;height:50px;' >$item_cek</textarea>
						</div>", 
						'type' => 'merge'
						 ),	
			'ket' => array( 
						'label'=>'KETERANGAN',
						'labelWidth'=>100, 
						'value'=>"", 
						 ),	
			'keasdast' => array( 
						'label'=>'KETERANGAN',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<textarea name = 'ket' id = 'ket' style='width:475px; height:50px;'>$keterangan</textarea>

						</div>", 
						'type' => 'merge'
						 ),					 			
				
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Editrincian_pekerjaan($idTemp)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	

}
$report = new reportObj();
$report->username = $_COOKIE['coID'];
?>