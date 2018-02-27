<?php

class saldoAwalObj  extends DaftarObj2{
	var $Prefix = 'saldoAwal';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = "saldo_awal "; //daftar
	var $TblName_Hapus = 'ref_std_kebutuhan_barang_jasa';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Persediaan';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'SALDO AWAL';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'saldoAwalForm';
	var $kode_skpd = '';
	var $username = '';
	var $WHERE_O = "";
	var $norCrotttt = 0;

	function setTitle(){
		return 'SALDO AWAL';
	}
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","TAMBAH",'TAMBAH')."</td>".
			"</td>";
	}
	function setMenuView(){
		return "";
	}
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;

		//$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD'); //echo 'fmskpd='.$fmSKPD;
		//$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		//$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";
			/*"<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT)."</td>
				</tr>
			</table><br>";*/
	}

	//function setPage_IconPage(){		return 'images/masterData_ico.gif';	}
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $c1 = $_REQUEST[$this->Prefix."SKPD2fmURUSAN"];
	 $c = $_REQUEST[$this->Prefix."SKPD2fmSKPD"];
	 $d = $_REQUEST[$this->Prefix."SKPD2fmUNIT"];
	 $e = $_REQUEST[$this->Prefix."SKPD2fmSUBUNIT"];
	 $e1 = $_REQUEST[$this->Prefix."SKPD2fmSEKSI"];
	 foreach ($_REQUEST as $key => $value) {
		  $$key = $value;
	 }




				if($err==''){
						$explodingKodeRekening = explode('.', $kodeRekening);
						$k = $explodingKodeRekening[0];
						$l = $explodingKodeRekening[1];
						$m = $explodingKodeRekening[2];
						$n = $explodingKodeRekening[3];
						$o = $explodingKodeRekening[4];
						$getData = mysql_query("SELECT * from tmp_saldoawal where user = '$this->username' and  jumlah!=''  AND harga_satuan!='' and jumlah != '0' and harga_satuan!='0'");


					              $getTanggal = mysql_fetch_array(mysql_query("SELECT * FROM pengaturan_persediaan Limit 1 "));

						while($rows = mysql_fetch_array($getData)){
							foreach ($rows as $key => $value) {
								 $$key = $value;
							}
								foreach ($_REQUEST as $key => $value) {
									  $$key = $value;
								 }


								$data = array(
												'c1' => $c1,
												'c' => $c,
												'd' => $d,
												'e' => $e,
												'e1' => $e1,
												'bk' => '0',
												'ck' => '0',
												'dk' => '0',
												'p' => '0',
												'q' => '0',
												'f1' => '0',
												'f2' => '0',
												'f' => $f,
												'g' => $g,
												'h' => $h,
												'i' => $i,
												'j' => $j,
												'j1' => $j1,
												'satuan' => $satuan,
												'total' => $jumlah *  $harga_satuan,
												'harga_satuan' => $harga_satuan,
												'tanggal' =>  $getTanggal['tanggal'],
												'jumlah' => $jumlah,

											);



							$cekQ = mysql_num_rows(mysql_query("SELECT * from saldo_awal where  f ='$f'  AND g='$g' and h= '$h' and i='$i' and j='$j' and j1='$j1' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));

							$cek = "SELECT * from saldo_awal where  f ='$f'  AND g='$g' and h= '$h' and i='$i' and j='$j' and j1='$j1'";
						              if ($cekQ==1) {
						                     $query = VulnWalkerUpdate("saldo_awal",$data,"f='$f'  AND g='$g' and h= '$h' and i='$i' and j='$j' and j1='$j1' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'");

						              }else{
						              	$query = VulnWalkerInsert("saldo_awal",$data);
						              }

						              $cek = $query2;
							mysql_query($query);

				                                       $datasId = mysql_fetch_array(mysql_query("SELECT * from saldo_awal where f='$f'  AND g='$g' and h= '$h' and i='$i' and j='$j' and j1='$j1' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));

									$data2 = array(
												'c1' => $c1,
												'c' => $c,
												'd' => $d,
												'e' => $e,
												'e1' => $e1,
												'bk' => '0',
												'ck' => '0',
												'dk' => '0',
												'p' => '0',
												'q' => '0',
												'f1' => '0',
												'f2' => '0',
												'f' => $f,
												'g' => $g,
												'h' => $h,
												'i' => $i,
												'j' => $j,
												'j1' => $j1,
												'satuan' => $satuan,
												'total' => $jumlah *  $harga_satuan,
												'harga_satuan' => $harga_satuan,
												'tanggal_buku' => $getTanggal['tanggal'],
												'jumlah' => $jumlah,
												'jns' => '1',
												'jenis_persediaan' => '1',
												'cara_perolehan' => '1',
												'refid' => $datasId['id'],
											);

							$cekQ2 = mysql_num_rows(mysql_query("SELECT * from t_kartu_persediaan where  f ='$f'  AND g='$g' and h= '$h' and i='$i' and j='$j' and j1='$j1' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and jns='1' and jenis_persediaan = '1' and cara_perolehan = '1' and refid = '".$datasId['id']."' "));


						              if ($cekQ2==1) {

						                     $query2 = VulnWalkerUpdate("t_kartu_persediaan",$data2,"f ='$f'  AND g='$g' and h= '$h' and i='$i' and j='$j' and j1='$j1' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and jns='1' and jenis_persediaan = '1' and cara_perolehan = '1' and refid = '".$datasId['id']."' '");

						              }else{
						              	$query2 = VulnWalkerInsert("t_kartu_persediaan",$data2);
						              }

							mysql_query($query2);
							$cek = $query2;
							mysql_query("DELETE from tmp_saldoawal where user = '$this->username'");

						}


				}

			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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

		case 'formBaru':{
			foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
			}
			mysql_query("DELETE from tmp_saldoawal where user = '$this->username'");
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$c1 = $_REQUEST[$this->Prefix."SKPD2fmURUSAN"];
			$c = $_REQUEST[$this->Prefix."SKPD2fmSKPD"];
			$d = $_REQUEST[$this->Prefix."SKPD2fmUNIT"];
			$e = $_REQUEST[$this->Prefix."SKPD2fmSUBUNIT"];
			$e1 = $_REQUEST[$this->Prefix."SKPD2fmSEKSI"];

			if(empty($c1)  || $c1 =='00'){
				$err = "Pilih Urusan";
			}elseif(empty($c)  || $c =='00'){
				$err = "Pilih Bidang";
			}elseif(empty($d)  || $d =='00'){
				$err = "Pilih SKPD";
			}elseif(empty($e)   || $e =='00'){
				$err = "Pilih Unit";
			}elseif(empty($e1)   || $e1 =='000'){
				$err = "Pilih Sub Unit";
			}

			$content = $fm['content'];
		break;
		}

		case 'saveData':{
			foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
			}
			$data = array('jumlah' => $jumlahBarang);
			$query = VulnWalkerUpdate($this->TblName,$data,"concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$kode'");
			mysql_query($query);

		break;
		}

		case 'Hapus':{
			foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
			}
			$getData = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan Where refid='$id' and jns = '1' "));
			foreach ($getData as $key => $value) {
				 $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where  c1 ='$c1' and c ='$c' and d ='$d' and e ='$e' and e1 ='$e1' and f ='$f' and g ='$g' and h ='$h' and i ='$i' and j ='$j' and j1 ='$j1' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '1' ")) == 0)
			{
				mysql_query("DELETE from saldo_awal Where id='$id'");
				mysql_query("DELETE from t_kartu_persediaan Where refid='$id' and jns = '1' ");
			}else{
				$err = "Data sudah di kunci !";
			}

		break;
		}

		case 'SimpanUbah':{
                                   foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
	                        }
	           			$explodeKodeBarang = explode('.', $id);
			 	$f = $explodeKodeBarang[0];
			 	$g = $explodeKodeBarang[1];
			 	$h = $explodeKodeBarang[2];
			 	$i = $explodeKodeBarang[3];
			 	$j = $explodeKodeBarang[4];
			 	$j1 = $explodeKodeBarang[5];
		$cek = mysql_num_rows(mysql_query("SELECT * from tmp_saldoawal where user ='$this->username' and f ='$f' and g ='$g' and h = '$h' and i='$i' and j='$j' and j1='$j1'"));
	  	if($cek == 1){
		   mysql_query("UPDATE  tmp_saldoawal set jumlah='$jumlah',satuan='$satuan',harga_satuan='$harga' where user ='$this->username' and f ='$f' and g ='$g' and h = '$h' and i='$i' and j='$j' and j1='$j1'");
		}else{

		  mysql_query("INSERT Into tmp_saldoawal values('','$f','$g','$h','$i','$j','$j1','$jumlah','$satuan','$harga','$this->username')");

		}


		break;
		}


		case 'SimpanData':{
			foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
			}
      $dataSaldo = mysql_fetch_array(mysql_query("SELECT * from saldo_awal where id='$id'"));
      $cek = mysql_num_rows(mysql_query("SELECT * from tmp_saldoawal where user ='$this->username' and f ='$dataSaldo[f]' and g ='$dataSaldo[g]' and h = '$dataSaldo[h]' and i='$dataSaldo[i]' and j='$dataSaldo[j]' and j1='$dataSaldo[j1]'"));
	  	if($cek == 1){
		   mysql_query("UPDATE  tmp_saldoawal set jumlah='$jumlah',harga_satuan='$harga' where user ='$this->username' and f ='$dataSaldo[f]' and g ='$dataSaldo[g]' and h = '$dataSaldo[h]' and i='$dataSaldo[i]' and j='$dataSaldo[j]' and j1='$dataSaldo[j1]'");
			}else{
		   	mysql_query("INSERT Into tmp_saldoawal values('','$dataSaldo[f]','$dataSaldo[g]','$dataSaldo[h]','$dataSaldo[i]','$dataSaldo[j]','$dataSaldo[j1]','$jumlah','','$harga','$this->username')");
			}


		break;
		}

		case 'SimpanDatas':{
			foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
			}
						$getData = mysql_query("SELECT * from tmp_saldoawal where user = '$this->username' and  jumlah!=''  AND harga_satuan!='' and jumlah != '0' and harga_satuan!='0'");
						$c1 = $_REQUEST[$this->Prefix."SKPD2fmURUSAN"];
						$c = $_REQUEST[$this->Prefix."SKPD2fmSKPD"];
						$d = $_REQUEST[$this->Prefix."SKPD2fmUNIT"];
						$e = $_REQUEST[$this->Prefix."SKPD2fmSUBUNIT"];
						$e1 = $_REQUEST[$this->Prefix."SKPD2fmSEKSI"];
						$rows = mysql_fetch_array($getData);
							foreach ($rows as $key => $value) {
								 $$key = $value;
							}

							if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where  c1 ='$c1' and c ='$c' and d ='$d' and e ='$e' and e1 ='$e1' and f ='$f' and g ='$g' and h ='$h' and i ='$i' and j ='$j' and j1 ='$j1' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '1' ")) == 0)
							{
									$data = array(
													'total' => $jumlah *  $harga_satuan,
													'harga_satuan' => $harga_satuan,
													'jumlah' => $jumlah,
												);
				        $query = VulnWalkerUpdate("saldo_awal",$data,"c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f'  AND g='$g' and h= '$h' and i='$i' and j='$j' and j1='$j1'");
							  $dataSaldoAwal = mysql_query("update t_kartu_persediaan set jumlah = '$jumlah' where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f'  AND g='$g' and h= '$h' and i='$i' and j='$j' and j1='$j1' and jns='1'");
								mysql_query($query);
								mysql_query("DELETE from tmp_saldoawal where user = '$this->username'");

							}else{
								 $err = "Data sudah di kunci !";
							}



		break;
		}

		case 'ubahData':{
			foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
			}

			mysql_query("DELETE from tmp_saldoawal where user = '$this->username'");
			 $dataSaldo = mysql_fetch_array(mysql_query("SELECT * from saldo_awal where id='$id'"));


			$btnOpsi = "<a id='simpan$id' onclick=$this->Prefix.simpanData('$id') style='cursor: 		pointer;text-decoration: none; color: rgb(18, 100, 228);'> SIMPAN </a>  |
 			<a onclick=$this->Prefix.refreshList(true) style='cursor: pointer;text-decoration: none; color: rgb(18, 100, 228);'> BATAL </a>";

			$inputJumlah ="<input  id='jumlah$id' onkeyup=$this->Prefix.sum('$id') onChange=$this->Prefix.sum('$id') type='number'  value='$dataSaldo[jumlah]'>
				<br><span id='bantuanJ$id'></span>";
			$hargaSatuan ="<input  type='text' id='harga$id' onkeyup=$this->Prefix.sum('$id') value='".$this->buangNol($dataSaldo[harga_satuan])."'>
			<br><span id='bantuanH$id'></span>";
			$content =
			array(
				'inputJumlah' => $inputJumlah,
				'hargaSatuan' => $hargaSatuan,
				'btnOpsi' => $btnOpsi,

			);

		break;
		}

		case 'editData':{
			foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
				}
			$kodeRekening = explode(" ",  $saldoAwal_cb[0]);
			$k = $kodeRekening[0];
			$l = $kodeRekening[1];
			$m = $kodeRekening[2];
			$n = $kodeRekening[3];
			$o = $kodeRekening[4];

			mysql_query("delete from temp_rincian_belanja_barang_jasa where username ='$this->username'");
			$getData = mysql_query("select * from ref_barang where k12='".$k."' and l12='".$l."' and m12='".$m."' and n12='".$n."' and o12='".$o."' ");
			$kodeRekening	= $k.".".$l.".".$m.".".$n.".".$o;
			while ($rows = mysql_fetch_array($getData)) {
				foreach ($rows as $key => $value) {
				 $$key = $value;
				}
				$data = array(
								'f1' => $f1,
								'f2' => $f2,
								'f' => $f,
								'g' => $g,
								'h' => $h,
								'i' => $i,
								'j' => $j,
								'j1' => $j1,
								'username' => $_COOKIE['coID'],
								'status' => 'checked',
							);
				$query = VulnWalkerInsert("temp_rincian_belanja_barang_jasa",$data);
				mysql_query($query);
			}


			$fm = $this->setFormEdit($kodeRekening);
			$cek = "select * from ref_barang where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j) ='$kodeBarang'";
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'formEdit':{
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
	 function setPage_HeaderOther(){

return
"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>

<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>

<A href=\"pages.php?Pg=saldoAwal\" title='SALDO AWAL' style='color : blue;' > SALDO AWAL </a> |
<A href=\"pages.php?Pg=pengaturanPersediaan\" title='PENGATURAN' > PENGATURAN </a>

&nbsp&nbsp&nbsp
</td></tr>
</table>";
}
	function setPage_OtherScript(){
		$scriptload =

					"<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();
						});

					</script>";

		return
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/persediaan/saldoAwal/saldoAwal.js' language='JavaScript' ></script>
			 <script type='text/javascript' src='js/persediaan/saldoAwal/listBarangSaldoAwal.js' language='JavaScript' ></script>
			 ".
			$scriptload;
	}

	function buangNol($angka){
                   $angka = explode('.', $angka);
                   return $angka[0];
	}

	//form ==================================
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$dt=array();


		//if(mysql_num_rows(mysql_query("select * from temp_standar_kebutuhan where username = '$this->username'")) == 0){
			//	$this->copyDataBarang();


		$cek =$cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$fm = $this->setForm($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

		function setFormUbah($id){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$dt=array();


		$cek =$cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$fm = $this->setFormUbahs($id);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

  	function setFormEdit($kodeRekening){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek =$cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;

		$aqry = "select * from ref_std_kebutuhan_barang_jasa where concat(c1,' ',c,' ',d,' ',e,' ',e1,' ',f,' ',g,' ',h,' ',i,' ',j) ='".$this->form_idplh."' "; $cek.=$aqry;


		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($kodeRekening);


		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}




	function setForm($kodeRekening){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';

	 $json = TRUE;	//$ErrMsg = 'tes';

	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 900;
	 $this->form_height = 200;
		$this->form_caption = 'BARU';


		foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}


       //items ----------------------
		  $this->form_fields = array(

		   	'infoSKPD' => array(
						'label'=>'',
						'value'=>
								""
							,

						'type'=>'merge'
					 ),
			'asdas' => array(
						'label'=>'',
						'value'=>"

						<div id='listBarang' style='height:5px'>
							"."<div id='listBarangSaldoAwal_cont_title' style='position:relative'></div>".
			"<div id='listBarangSaldoAwal_cont_opsi' style='position:relative'>".
			"</div>".
			"<div id='listBarangSaldoAwal_cont_daftar' style='position:relative'></div>".
			"<div id='listBarangSaldoAwal_cont_hal' style='position:relative'></div>"."
						</div>",

						'type'=>'merge'
					 ),
			);
		//tombol
		$c1 = $_REQUEST[$this->Prefix."SKPD2fmURUSAN"];
		$c = $_REQUEST[$this->Prefix."SKPD2fmSKPD"];
		$d = $_REQUEST[$this->Prefix."SKPD2fmUNIT"];
		$e = $_REQUEST[$this->Prefix."SKPD2fmSUBUNIT"];
		$e1 = $_REQUEST[$this->Prefix."SKPD2fmSEKSI"];
		$this->form_menubawah =

			"
			<input type='hidden' id ='c1' name ='c1' value='$c1'>
			<input type='hidden' id ='c' name ='c' value='$c'>
			<input type='hidden' id ='d' name ='d' value='$d'>
			<input type='hidden' id ='e' name ='e' value='$e'>
			<input type='hidden' id ='e1' name ='e1' value='$e1'>

			<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Batal kunjungan' >&nbsp &nbsp ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function pageShow(){
		global $app, $Main;

		$navatas_ = $this->setNavAtas();
		$navatas = $navatas_==''? // '0': '20';
			'':
			"<tr><td height='20'>".
					$navatas_.
			"</td></tr>";
		$form1 = $this->withform? "<form name='$this->FormName' id='$this->FormName' method='post' action=''>" : '';
		$form2 = $this->withform? "</form >": '';


			$tergantung = "100";

		return

		"<html>".
			$this->genHTMLHead().
			"<body >".

			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0'  height='100%' >".
				"<tr height='34'><td>".
					$this->setPage_Header().
					"<div id='header' ></div>".
				"</td></tr>".
				$navatas.
				"<tr height='*' valign='top'> <td >".

					$this->setPage_HeaderOther().
					"<div align='center' class='centermain' >".
					"<div class='main' >".
					$form1.
						$this->setPage_Content().

					$form2.
					"</div></div>".
				"</td></tr>".
				"<tr><td height='29' >".
					$Main->CopyRight.
				"</td></tr>".
				$OtherFooterPage.
			"</table>".
			"</body>
		</html>
		<style>
			#kerangkaHal {
						width:$tergantung%;
			}

		</style>
		";
	}
	function genForm2($withForm=TRUE){
		$form_name = 'listBarangSaldoAwalForm';

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

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	 "<thead>
	 <tr>
  	   <th class='th01' width='20' >No.</th>

	   <th class='th01' align='center' width='800'>NAMA BARANG</th>
	   <th class='th01' align='center' width='50'>JUMLAH</th>
	   <th class='th01' align='center' width='50' style='width: 10%;'>HARGA SATUAN ( Rp. )</th>
	   <th class='th01' align='center' width='50'>TOTAL ( Rp. )</th>
	  <th class='th01' align='center' width='50' style='width: 8%;text-align: center;'>OPSI</th>
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

	  $kodeRekening = $isi['k'].".".$isi['l'].".".$isi['m'].".".$isi['n'].".".$isi['o'];




 	$this->nomor = $namaSKPD;
             $getBarang = mysql_fetch_array(mysql_query("SELECT * from ref_barang Where f='$isi[f]' and g='$isi[g]' and h='$isi[h]' and i='$isi[i]' and j='$isi[j]' and j1='$isi[j1]'"));

	 $getSubUnit = mysql_fetch_array(mysql_query("SELECT * from ref_skpd where c1='$isi[c1]' and c='$isi[c]' and d='$isi[d]' and e='$isi[e]' and e1='$isi[e1]'"));
	$idSaldo = $isi[id];
	 $kodeBarang =$isi[f].".".$isi[g].".".$isi[h].".".$isi[i].".".$isi[j].".".$isi[j1];
	  $kodeSKPD =$isi[c1].".".$isi[c].".".$isi[d].".".$isi[e].".".$isi[e1];

	 $this->lastKodeRekening = $kodeRekening;

	 $hargaSatuan = "<span  id='hargaSatuan$idSaldo'>".number_format($isi['harga_satuan'],2,",",".")."</span>";

	 $inputTotal = "<span  id='inputTotal$idSaldo'>".number_format($isi['harga_satuan'] * $isi['jumlah'],2,",",".")."</span>";

	 $inputJumlah = "<span  id='inputJumlah$idSaldo'>".number_format($isi['jumlah'],0,",",".")."</span>";
	$namaSKPD = $getSubUnit['nm_skpd'];

	$Koloms[] = array('align="center" width="20"', $no );



	 $Koloms[] = array('align="left"',$getBarang['nm_barang']);


	 $Koloms[] = array('align="right"',$inputJumlah);




	 $Koloms[] = array('align="right"',$hargaSatuan);





	 $Koloms[] = array('align="right"', $inputTotal);

	 $Koloms[] = array('align="left"',"
	 	<span id='btnOpsi$idSaldo'>
	 	<a id='ubah$idSaldo' onclick=$this->Prefix.ubah('$idSaldo') style='cursor: pointer;text-decoration: none; color: rgb(18, 100, 228);'> UBAH </a>
	 	|
	 	 <a onclick=$this->Prefix.hapus('$idSaldo') style='cursor: pointer;text-decoration: none; color: rgb(18, 100, 228);'> HAPUS </a>
	 	 </span>
	 	 ");
	 return $Koloms;
	}
	function generateDate($tanggal){
			$tanggal = explode('-',$tanggal);
			$tanggal = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
			return $tanggal;
	}
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
	 }
	$getDataPengaturan = mysql_fetch_array(mysql_query("select * from pengaturan_persediaan"));
	$tanggalSaldoAwal =$this->generateDate( $getDataPengaturan['tanggal']);
	$cmbAkun = "0";
	$cmbKelompok = "0";
	$cmbJenis = "08";
$jumlahData = $_REQUEST['jumlahData'];
if(empty($jumlahData))$jumlahData = 50;
$TampilOpt =
		"<table width=\"100%\" class=\"adminform\">	<tr>
		<td width=\"50%\" valign=\"top\">
			" . WilSKPD_ajx3($this->Prefix.'SKPD2','100%','145px') .
		"</td>
		<td width=\"50%\" valign=\"top\">
			<table>

				<tr><td width='200'>OBYEK</td><td width='10'>:</td><td>".
				cmbQuery1("cmbObyek",$cmbObyek,"select g as valueCmbObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g !='00' and h ='00' and i='00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','')

					."</td></tr>".
				"<tr><td width='100'>RINCIAN OBYEK</td><td width='10'>:</td><td>".
					 cmbQuery1("cmbRincianObyek",$cmbRincianObyek,"select h as valueCmbRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h !='00' and i='00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td></tr>".
				"<tr><td width='100'>SUB RINCIAN OBYEK</td><td width='10'>:</td><td>".
					cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,"select i as valueCmbSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i != '00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td></tr>".
				"<tr><td width='100'>SUB SUB RINCIAN OBYEK</td><td width='10'>:</td><td>".
					cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,"select j as valueCmbSubSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j != '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td></tr>".
				"<tr><td width='100'>SUB SUB SUB RINCIAN OBYEK</td><td width='10'>:</td><td>".
					cmbQuery1("cmbSubSubSubRincianObyek",$cmbSubSubSubRincianObyek,"select j1 , nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j = '$cmbSubSubRincianObyek' and j1 != '0000' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td></tr>".
			"</table>".
		"</td>
		</tr></table>".
					genFilterBar(
						array(
							"TANGGAL SALDO AWAL &nbsp &nbsp <input type='text' value='$tanggalSaldoAwal' style='width:80px;' readonly>&nbsp &nbsp &nbsp &nbsp JUMLAH DATA &nbsp &nbsp <input type='text' name ='jumlahData' id='jumlahData' value ='$jumlahData' style='width:40px;'>  &nbsp <input type='button' onclick =$this->Prefix.refreshList(true); value='Tampilkan'>"
					),'','','')

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
		$c1 = $_REQUEST[$this->Prefix."SKPD2fmURUSAN"];
		$c = $_REQUEST[$this->Prefix."SKPD2fmSKPD"];
		$d = $_REQUEST[$this->Prefix."SKPD2fmUNIT"];
		$e = $_REQUEST[$this->Prefix."SKPD2fmSUBUNIT"];
		$e1 = $_REQUEST[$this->Prefix."SKPD2fmSEKSI"];

		 if(!empty($c1) && !empty($c) && !empty($d) && !empty($e) && !empty($e1)){
		 	$arrKondisi[] = "c1 = '$c1' AND c = '$c' AND d = '$d' AND e = '$e' AND e1 = '$e1'";
		 }else{
		 	$arrKondisi[] = "c1 = 'sdaas'";
		 }

		 if(!empty($cmbObyek)){
				 $arrKondisi[] = "g = '$cmbObyek'";
		 }
		 if(!empty($cmbRincianObyek)){
				 $arrKondisi[] = "h = '$cmbRincianObyek'";
		 }
		 if(!empty($cmbSubRincianObyek)){
				 $arrKondisi[] = "i = '$cmbSubRincianObyek'";
		 }
		 if(!empty($cmbSubSubRincianObyek)){
				 $arrKondisi[] = "j = '$cmbSubSubRincianObyek'";
		 }
		 if(!empty($cmbSubSubSubRincianObyek)){
				 $arrKondisi[] = "j1 = '$cmbSubSubSubRincianObyek'";
		 }



		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " b1,c,d,e,e1 $Asc1 " ;break;
			case '2': $arrOrders[] = " nm_skpd $Asc1 " ;break;
		}
		$Order= join(',',$arrOrders);
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		$this->pagePerHal =$jumlah;
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal;
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}

	function copyDataBarang(){
		$getAllBarang = mysql_query("select * from ref_barang where j!='000'");
		while($rows = mysql_fetch_array($getAllBarang)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			 }
			 $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j;
			 if(mysql_num_rows(mysql_query("select * from temp_standar_kebutuhan where username = '$this->username' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'")) == 0){
			 		$data = array(
			 						"f" => $f,
			 						"g" => $g,
			 						"h" => $h,
			 						"i" => $i,
			 						"j" => $j,
			 						'jumlah' => '0',
			 						'username' => $this->username
			 					  );
			 		$query = VulnWalkerInsert('temp_standar_kebutuhan',$data);
			 		mysql_query($query);
			 }

		}
	}

	function editData($id){

	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 900;
	 $this->form_height = 200;

		$this->form_caption = 'Edit';
		$kode = explode(' ', $id);
		$c1 = $kode[0];
		$c = $kode[1];
		$d = $kode[2];
		$e = $kode[3];
		$e1 = $kode[4];

		$f = $kode[5];
		$g = $kode[6];
		$h = $kode[7];
		$i = $kode[8];
		$j = $kode[9];

		$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;

		$getNamaBarang =  mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' "));
		$namaBarang = $getNamaBarang['nm_barang'];
		$satuanBarang = $getNamaBarang['satuan'];

		$getNamaUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='00' and d='00' and e='00' and e1='000'"));
		$getNamaBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='00' and e='00' and e1='000'"));
		$getNamaSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
		$getNamaUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
		$getNamaSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));

		$urusan = $getNamaUrusan['nm_skpd'];
		$bidang = $getNamaBidang['nm_skpd'];
		$skpd = $getNamaSKPD['nm_skpd'];
		$unit = $getNamaUnit['nm_skpd'];
		$subUnit = $getNamaSubUnit['nm_skpd'];

		$primaryKey = $c1.".".$c.".".$d.".".$e.".".$e1.".".$f.".".$g.".".$h.".".$i.".".$j;

		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) ='$primaryKey'"));
		$jumlahBarang = $getData['jumlah'];

       //items ----------------------
		 $this->form_fields = array(
			'urusan' => array(
								'label'=>'URUSAN',
								'labelWidth'=>200,
								'value'=>"$urusan"
									 ),

			'bidang' => array(
								'label'=>'BIDANG',
								'labelWidth'=>200,
								'value'=>"$bidang"
									 ),
			'skpd' => array(
								'label'=>'SKPD',
								'labelWidth'=>200,
								'value'=>"$skpd"
									 ),
			'skpd' => array(
								'label'=>'SKPD',
								'labelWidth'=>200,
								'value'=>"$skpd"
									 ),
			'unit' => array(
								'label'=>'UNIT',
								'labelWidth'=>200,
								'value'=>"$unit"
									 ),
			'subUnit' => array(
								'label'=>'SUB UNIT',
								'labelWidth'=>200,
								'value'=>"$subUnit"
									 ),
			'kodeBarang' => array(
								'label'=>'KODE BARANG',
								'labelWidth'=>200,
								'value'=>"$kodeBarang"
									 ),
			'namaBarang' => array(
								'label'=>'NAMA BARANG',
								'labelWidth'=>200,
								'value'=>"$namaBarang"
									 ),
			'satuanBarang' => array(
								'label'=>'SATUAN',
								'labelWidth'=>200,
								'value'=>"$satuanBarang"
									 ),
			'jumlahBarang' => array(
								'label'=>'JUMLAH BARANG',
								'labelWidth'=>200,
								'value'=>"<input type='text' name='jumlahBarang' id='jumlahBarang' value='$jumlahBarang' onkeypress='return event.charCode >= 48 && event.charCode <= 57'>"
									 ),

			);
		//tombol
		$this->form_menubawah =
			"
			<input type='hidden' id ='c1' name ='c1' value='$c1'>
			<input type='hidden' id ='c' name ='c' value='$c'>
			<input type='hidden' id ='d' name ='d' value='$d'>
			<input type='hidden' id ='e' name ='e' value='$e'>
			<input type='hidden' id ='e1' name ='e1' value='$e1'>

			".
			"<input type='button' value='Simpan' onclick =$this->Prefix.saveData('$primaryKey') title='Simpan' > &nbsp &nbsp ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

}
$saldoAwal = new saldoAwalObj();
$saldoAwal->username = $_COOKIE['coID'];
if($Main->REK_DIGIT_O == 0){
	$saldoAwal->WHERE_O = "00";
}else{
	$saldoAwal->WHERE_O = "000";
}
?>
