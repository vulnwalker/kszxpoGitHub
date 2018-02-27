<?php

class rpebmdObj  extends DaftarObj2{
	var $Prefix = 'rpebmd';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_rencana_pemindahtanganan'; //daftar
	var $TblName_Hapus = 't_rencana_pemindahtanganan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array('harga');//array('jml_harga');
	var $SumValue = array();
	var $fieldSum_lokasi = array(9);
	var $totalCol = 13; //total kolom daftar
	var $FieldSum_Cp1 = array( 8, 7,7);//berdasar mode
	var $FieldSum_Cp2 = array( 8, 5, 4);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'Perencanaan Kebutuhan dan Penganggaran';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='Rencana Pemindahtanganan.xls';
	var $Cetak_Judul = 'RENCANA PEMINDAHTANGANAN';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;

	var $FormName = 'rpebmdForm';
	var $modul = "RKBMD";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";
	var $namaTahapTerakhir = "";
	var $masaTerakhir = "";
	var $currentTahap = "";
    //untuk view
	var $urutTerakhir = "";
	var $urutSebelumnya = "";
	var $jenisFormTerakhir = "";
	var $tahapTerakhir = "";
	var $username = "";

	var $wajibValidasi = "";

	var $sqlValidasi = "";

	var $provinsi = "";
	var $kota = "";
	var $pengelolaBarang = "";
	var $pejabatPengelolaBarang = "";
	var $pengurusPengelolaBarang = "";
	var $nipPengelola = "";
	var $nipPejabat = "";
	var $nipPengurus ="";
	function setTitle(){
		return 'Rencana Pemindahtanganan Barang Milik Daerah (RPTBMD)';
	}
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit1()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>";
	}

	function setMenuView(){
		return
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png","SPPT",'Cetak SPPT')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".CetakSemua(\"$Op\")","print_f2.png",'Laporan',"Laporan")."</td>";
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","edit_f2.png","Default",'Setting Default')."</td>";
	}

	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 //Inisiasi DATA
	 //==================================
	 $id_bukuinduk=$_REQUEST['fmid_buku_induk'];
	 $fmIDBARANG=$_REQUEST['fmIDBARANG'];
	 $expfmIDBARANG=explode('.',$fmIDBARANG);
	 $a1 = $Main->DEF_KEPEMILIKAN;
	 $a = $Main->DEF_PROPINSI;
	 $b = $Main->DEF_WILAYAH;
	 $c1 = $_REQUEST['c1'];
	 $c = $_REQUEST['c'];
	 $d = $_REQUEST['d'];
	 $e = $_REQUEST['e'];
	 $e1 = $_REQUEST['e1'];
	 $f=$expfmIDBARANG['0'];
	 $g=$expfmIDBARANG['1'];
	 $h=$expfmIDBARANG['2'];
	 $i=$expfmIDBARANG['3'];
	 $j=$expfmIDBARANG['4'];
	 $nm_barang=$_REQUEST['fmNMBARANG'];
	 $asal_usul=$_REQUEST['fmasalusul'];
	 $kondisi=$_REQUEST['fmkondisi'];
	 $harga=$_REQUEST['fmharga_perolehan'];
	 $fmIDREKENING=$_REQUEST['kode_account'];
	 $expfmIDREKENING=explode('.',$fmIDREKENING);
	 $ka=$expfmIDREKENING['0'];
	 $kb=$expfmIDREKENING['1'];
	 $kc=$expfmIDREKENING['2'];
	 $kd=$expfmIDREKENING['3'];
	 $ke=$expfmIDREKENING['4'];
	 $kf=$expfmIDREKENING['5'];
	 $thn_akun=$_REQUEST['tahun_account'];
	 $nm_akun=$_REQUEST['nama_account'];
	 $noreg=$_REQUEST['fmnoreg'];
	 $thn_perolehan=$_REQUEST['fmthn_perolehan'];
	 $bentuk_pemindahtanganan=$_REQUEST['fmbentuk_pemindahtanganan'];
	 $ket=$_REQUEST['fmket'];
	 $thn_anggaran=$_REQUEST['fmthn_anggaran'];

	 $idbi_awal=$_REQUEST['fmidbi_awal'];
	 	if($fmIDREKENING=="" && $err=="")$err="Pilih Kode Akun!";
		if($fmIDBARANG=="" && $err=="")$err="Kode Barang Tidak Boleh Kosong!";
		if($bentuk_pemindahtanganan=="" && $err=="")$err="Bentuk Pemindahtanganan Harus Dipilih!";
		//Cek pemindahtanganan
		$kondisi1=" id_bukuinduk='$id_bukuinduk' and thn_anggaran='$thn_anggaran'";$cek.=$kondisi1;

		if($err==''){
			if($fmST == 0){
			//Simpan DATA
			//==================================
				$ck_pemindahtanganan = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM t_rencana_pemindahtanganan WHERE $kondisi1 "));
				if($ck_pemindahtanganan['cnt']>0 && $err=="") $err="Barang Sudah Masuk Ke Rencana Pemindahtanganan!";

				if($err==''){
					$aqry= "insert into t_rencana_pemindahtanganan (".
					" id_bukuinduk,idbi_awal,".
					" a1,a,b,".
					" c1,c,d,e,e1,f,g,h,i,j,".
					" nm_barang,asal_usul,kondisi,harga,".
					//" ka,kb,kc,kd,ke,kf,nm_account,thn_akun,".
					" ka,kb,kc,kd,ke,kf,thn_akun,".
					" noreg,thn_perolehan,thn_anggaran,".
					" bentuk_pemindahtanganan,ket,".
					" uid,tgl_update".
					" )values(".
					" '$id_bukuinduk','$idbi_awal',".
					" '$a1','$a','$b',".
					" '$c1','$c','$d','$e','$e1','$f','$g','$h','$i','$j',".
					" '$nm_barang','$asal_usul','$kondisi','$harga',".
					//" '$ka','$kb','$kc','$kd','$ke','$kf','$nm_akun','$thn_akun',".
					" '$ka','$kb','$kc','$kd','$ke','$kf','$thn_akun',".
					" '$noreg','$thn_perolehan','$thn_anggaran',".
					" '$bentuk_pemindahtanganan','$ket',".
					" '$uid',now()".
					")";$cek.=$aqry;
					$qry = mysql_query($aqry);
					if($qry==FALSE) $err="Gagal Simpan Data ".mysql_error();

				}
			}elseif($fmST == 1){
			//EDIT DATA
			//==================================
				if($err==''){
					$aqry= "update t_rencana_pemindahtanganan set ".
					"  id_bukuinduk='$id_bukuinduk',idbi_awal='$idbi_awal',".
					" f='$f',g='$g',h='$h',i='$i',j='$j',".
					" nm_barang='$nm_barang',asal_usul='$asal_usul',kondisi='$kondisi',harga='$harga',".
				//" ka='$ka',kb='$kb',kc='$kc',kd='$kd',ke='$ke',kf='$kf',nm_account='$nm_akun', thn_akun='$thn_akun',".
					" ka='$ka',kb='$kb',kc='$kc',kd='$kd',ke='$ke',kf='$kf', thn_akun='$thn_akun',".
					" noreg='$noreg', thn_perolehan='$thn_perolehan', thn_anggaran='$thn_anggaran',".
					" bentuk_pemindahtanganan='$bentuk_pemindahtanganan', ket='$ket',".
					" uid='$uid',tgl_update=now()".
					" where Id='$idplh'";$cek.=$aqry;
					$qry = mysql_query($aqry);
					if($qry==FALSE) $err="Gagal Edit Data ".mysql_error();
				}
			}else{
			if($err==''){
				$err="Tidak Dapat Menerima ID Pilih";
			}
			} //end else
		}//end if error
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
    }

	function SetPilihCariBI(){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;

		$ids = $_REQUEST['cidBI'];

		if($err=='' && $ids[0] == '') $err = 'Barang belum dipilih!';

		if($err==''){
			$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='".$ids[0]."'")) ;
			$brg = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,g,h,i,j)='".$bi['f'].$bi['g'].$bi['h'].$bi['i'].$bi['j']."'")) ;

			$fmThnAnggaran=  $this->tahun;
			$kueri1="select max(thn_akun) as thn_akun from ref_jurnal where thn_akun <= '$fmThnAnggaran'";
			$tmax = mysql_fetch_array(mysql_query($kueri1));
			$kueri="select * from ref_jurnal
					where thn_akun = '".$tmax['thn_akun']."'
					and ka='".$brg['ka']."' and kb='".$brg['kb']."'
					and kc='".$brg['kc']."' and kd='".$brg['kd']."'
					and ke='".$brg['ke']."' and kf='".$brg['kf']."'"; //echo "$kueri";
			$row=mysql_fetch_array(mysql_query($kueri));

			$content->plhkode_account =$row['ka'].".".$row['kb'].".".$row['kc'].".".$row['kd'].".".$row['ke'].".".$row['kf'];
			$content->plhnama_account = $row['nm_account'];
			$content->plhtahun_account = $row['thn_akun'];
			$content->plhid_buku_induk = $bi['id'];
			$content->plhidbi_awal = $bi['idawal'];
			$content->plhIDBARANG = $bi['f'].'.'.$bi['g'].'.'.$bi['h'].'.'.$bi['i'].'.'.$bi['j'] ;// '1';
			$content->plhNMBARANG = $brg['nm_barang'];
			$content->plhnoreg = $bi['noreg'];
			$content->plhthn_perolehan = $bi['thn_perolehan'];
			$content->plhharga_perolehan = $bi['harga'];
			$content->plhvalharga_perolehan = number_format($bi['harga'],0,',','.');
			$content->plhasalusul = $bi['asal_usul'];
			$content->plhkondisi = $bi['kondisi'];
			$content->plhvalasalusul = $Main->AsalUsul[$bi['asal_usul']-1][1];
			$content->plhvalkondisi = $Main->KondisiBarang[$bi['kondisi']-1][1];
			if ($bi['f']=="01"){
				$aqry = "select * from kib_a where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$content->plhluas = $arrdet['luas'];
				$content->plhalamat=$arrdet['alamat'];
				$content->plhkel=$arrdet['alamat_kel'];
				$content->plhkec=$arrdet['alamat_kec'];
				//mengambil nama kota
					$aqry1 = "select nm_wilayah from ref_wilayah where
					a='".$arrdet['alamat_a']."' and b='".$arrdet['alamat_b']."' ";
					$qry1=mysql_query($aqry1);
					$kota=mysql_fetch_array($qry1);
				$content->plhkota=$kota['nm_wilayah'];
			}
			if ($bi['f']=="02"){
				$aqry = "select * from kib_b where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$content->plhmerk = $arrdet['merk'];
				$content->plhukuran=$arrdet['ukuran'];
				$content->plhbahan=$arrdet['bahan'];

			}
			if ($bi['f']=="03"){
				$aqry = "select * from kib_c where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$content->plhkonstruksi = $Main->Bangunan[$arrdet['kondisi_bangunan']-1][1];
				$content->plhtingkat = $Main->Tingkat[$arrdet['konstruksi_tingkat']-1][1];
				$content->plhbeton = $Main->Beton[$arrdet['konstruksi_beton']-1][1];

				$content->plhluas = $arrdet['luas_lantai'];
				$content->plhalamat=$arrdet['alamat'];
				$content->plhkel=$arrdet['alamat_kel'];
				$content->plhkec=$arrdet['alamat_kec'];
				//mengambil nama kota
					$aqry1 = "select nm_wilayah from ref_wilayah where
					a='".$arrdet['alamat_a']."' and b='".$arrdet['alamat_b']."' ";
					$qry1=mysql_query($aqry1);
					$kota=mysql_fetch_array($qry1);
				$content->plhkota=$kota['nm_wilayah'];
			}
			if ($bi['f']=="04"){
				$aqry = "select * from kib_d where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$content->plhkonstruksi = $Main->Bangunan[$arrdet['konstruksi']-1][1];
				$content->plhpanjang = $Main->Tingkat[$arrdet['panjang']-1][1];
				$content->plhlebar = $Main->Beton[$arrdet['lebar']-1][1];

				$content->plhluas = $arrdet['luas_lantai'];
				$content->plhalamat=$arrdet['alamat'];
				$content->plhkel=$arrdet['alamat_kel'];
				$content->plhkec=$arrdet['alamat_kec'];
				//mengambil nama kota
					$aqry1 = "select nm_wilayah from ref_wilayah where
					a='".$arrdet['alamat_a']."' and b='".$arrdet['alamat_b']."' ";
					$qry1=mysql_query($aqry1);
					$kota=mysql_fetch_array($qry1);
				$content->plhkota=$kota['nm_wilayah'];
			}
			if ($bi['f']=="05"){
				$aqry = "select * from kib_e where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$content->plhjudul = $arrdet['buku_judul'];
				$content->plhspesifikasi=$arrdet['buku_spesifikasi'];
				$content->plhasal=$arrdet['seni_asal_daerah'];
				$content->plhpencipta=$arrdet['seni_pencipta'];
				$content->plhjenis=$arrdet['hewan_jenis'];
				$content->plhukuran=$arrdet['hewan_ukuran'];
				$content->plhbahan=$arrdet['seni_bahan'];
			}
			if ($bi['f']=="06"){
				$aqry = "select * from kib_f where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$content->plhkonstruksi = $Main->Bangunan[$arrdet['bangunan']-1][1];
				$content->plhtingkat = $Main->Tingkat[$arrdet['konstruksi_tingkat']-1][1];
				$content->plhbeton = $Main->Beton[$arrdet['konstruksi_beton']-1][1];

				$content->plhluas = $arrdet['luas'];
				$content->plhalamat=$arrdet['alamat'];
				$content->plhkel=$arrdet['alamat_kel'];
				$content->plhkec=$arrdet['alamat_kec'];
				//mengambil nama kota
					$aqry1 = "select nm_wilayah from ref_wilayah where
					a='".$arrdet['alamat_a']."' and b='".$arrdet['alamat_b']."' ";
					$qry1=mysql_query($aqry1);
					$kota=mysql_fetch_array($qry1);
				$content->plhkota=$kota['nm_wilayah'];
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
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
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

		case 'formCari':{
				$fm = $this->SetFormCari();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
				break;
			}
		case 'pilihcaribi':{
				$get= $this->SetPilihCariBI();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
				break;
			}
		case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	   }

	   case 'subtitle':{
					$content = $this->setTopBar();
					$json=TRUE;
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

	function setPage_OtherScript(){
		$scriptload =
					"<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();
						});

					</script>";

		return
		 "<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
		 "<script type='text/javascript' src='js/penatausaha.js' language='JavaScript' ></script>".
		 "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>
		  <script type='text/javascript' src='js/perencanaan_v3/rkbmd/pemindahtangananNew.js' language='JavaScript' ></script>".
		 "<script type='text/javascript' src='js/perencanaan_v3/rkbmd/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".



			$scriptload;
	}

	//form ==================================
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];

		$cek =$cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt['c1'] = $_REQUEST[$this->Prefix.'SkpdfmURUSAN'];
		$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$dt['e1'] = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		$dt['thn_anggaran'] = $this->tahun;

		$fm = $this->setForm($dt);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

  	function setFormEdit(){
	global $Main;
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek =$cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;

		$aqry = "select * from t_rencana_pemindahtanganan where Id='".$this->form_idplh."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
			$akn = mysql_fetch_array(mysql_query("select * from ref_jurnal where concat(ka,kb,kc,kd,ke,kf)='".$dt['ka'].$dt['kb'].$dt['kc'].$dt['kd'].$dt['ke'].$dt['kf']."' and thn_akun='".$dt['thn_akun']."'")) ;

			$akn = array_map('utf8_encode', $akn);
			$dt['nm_account']=$akn['nm_account'];

		if($err==''){
			$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='".$dt['id_bukuinduk']."'")) ;
			$dt['harga_perolehan'] = $bi['harga'];
			$dt['valharga_perolehan'] = number_format($bi['harga'],0,',','.');
			$dt['asal_usul'] = $bi['asal_usul'];
			$dt['kondisi'] = $bi['kondisi'];
			$dt['valasal_usul'] = $Main->AsalUsul[$bi['asal_usul']-1][1];
			$dt['valkondisi'] = $Main->KondisiBarang[$bi['kondisi']-1][1];


			if ($bi['f']=="01"){
				$aqry = "select * from kib_a where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$dt['luas'] = $arrdet['luas'];
				$dt['alamat']=$arrdet['alamat'];
				$dt['kel']=$arrdet['alamat_kel'];
				$dt['kec']=$arrdet['alamat_kec'];
				//mengambil nama kota
					$aqry1 = "select nm_wilayah from ref_wilayah where
					a='".$arrdet['alamat_a']."' and b='".$arrdet['alamat_b']."' ";
					$qry1=mysql_query($aqry1);
					$kota=mysql_fetch_array($qry1);
				$dt['kota']=$kota['nm_wilayah'];
			}
			if ($bi['f']=="02"){
				$aqry = "select * from kib_b where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$dt['merk'] = $arrdet['merk'];
				$dt['ukuran']=$arrdet['ukuran'];
				$dt['bahan']=$arrdet['bahan'];

			}
			if ($bi['f']=="03"){
				$aqry = "select * from kib_c where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$dt['konstruksi'] = $Main->Bangunan[$arrdet['kondisi_bangunan']-1][1];
				$dt['tingkat'] = $Main->Tingkat[$arrdet['konstruksi_tingkat']-1][1];
				$dt['beton'] = $Main->Beton[$arrdet['konstruksi_beton']-1][1];

				$dt['luas'] = $arrdet['luas'];
				$dt['alamat']=$arrdet['alamat'];
				$dt['kel']=$arrdet['alamat_kel'];
				$dt['kec']=$arrdet['alamat_kec'];
				//mengambil nama kota
					$aqry1 = "select nm_wilayah from ref_wilayah where
					a='".$arrdet['alamat_a']."' and b='".$arrdet['alamat_b']."' ";
					$qry1=mysql_query($aqry1);
					$kota=mysql_fetch_array($qry1);
				$dt['kota']=$kota['nm_wilayah'];
			}
			if ($bi['f']=="04"){
				$aqry = "select * from kib_d where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$dt['konstruksi'] = $Main->Bangunan[$arrdet['konstruksi']-1][1];
				$dt['panjang'] = $Main->Tingkat[$arrdet['panjang']-1][1];
				$dt['lebar'] = $Main->Beton[$arrdet['lebar']-1][1];

				$dt['luas'] = $arrdet['luas_lantai'];
				$dt['alamat']=$arrdet['alamat'];
				$dt['kel']=$arrdet['alamat_kel'];
				$dt['kec']=$arrdet['alamat_kec'];
				//mengambil nama kota
					$aqry1 = "select nm_wilayah from ref_wilayah where
					a='".$arrdet['alamat_a']."' and b='".$arrdet['alamat_b']."' ";
					$qry1=mysql_query($aqry1);
					$kota=mysql_fetch_array($qry1);
				$dt['kota']=$kota['nm_wilayah'];
			}
			if ($bi['f']=="05"){
				$aqry = "select * from kib_e where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$dt['judul'] = $arrdet['buku_judul'];
				$dt['spesifikasi']=$arrdet['buku_spesifikasi'];
				$dt['asal']=$arrdet['seni_asal_daerah'];
				$dt['pencipta']=$arrdet['seni_pencipta'];
				$dt['jenis']=$arrdet['hewan_jenis'];
				$dt['ukuran']=$arrdet['hewan_ukuran'];
				$dt['bahan']=$arrdet['seni_bahan'];
			}
			if ($bi['f']=="06"){
				$aqry = "select * from kib_f where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);

				$dt['konstruksi'] = $Main->Bangunan[$arrdet['bangunan']-1][1];
				$dt['tingkat'] = $Main->Tingkat[$arrdet['konstruksi_tingkat']-1][1];
				$dt['beton'] = $Main->Beton[$arrdet['konstruksi_beton']-1][1];

				$dt['luas'] = $arrdet['luas'];
				$dt['alamat']=$arrdet['alamat'];
				$dt['kel']=$arrdet['alamat_kel'];
				$dt['kec']=$arrdet['alamat_kec'];
				//mengambil nama kota
					$aqry1 = "select nm_wilayah from ref_wilayah where
					a='".$arrdet['alamat_a']."' and b='".$arrdet['alamat_b']."' ";
					$qry1=mysql_query($aqry1);
					$kota=mysql_fetch_array($qry1);
				$dt['kota']=$kota['nm_wilayah'];


			}
		}
		$fm = $this->setForm($dt);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

	function genForm2($withForm=TRUE){
		$form_name = $this->Prefix.'_form';

		if($withForm){
			$params->tipe=1;
			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
				$this->createDialog(
					$form_name.'_div',
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					// $this->form_menubawah.
					""
					,//$this->setForm_menubawah_content(),
					"",
					'',$params
					).
				"</form>";

		}else{
			$form=
				$this->createDialog(
					$form_name.'_div',
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					// $this->form_menubawah.
					""
					,//$this->setForm_menubawah_content(),
					""
				);


		}
		return $form;
	}

	function createDialog($fmID='divdialog1',
		$Content='',
		$ContentWidth=623,
		$ContentHeight=358,
		$caption='Dialog', $dlgCaptionContent='',
		$menuContent='', $menuHeight=22, $FormName='', $params = NULL ){


		$paddingMenuRight = 8;
			$paddingMenuLeft = 8;
			$paddingMenuBottom = 9;
		$marginTop= 9;
			$marginBottom= 8;
			$marginLeft = 8;
			$marginRight = 8;
		$menudlg = "
				<div style='padding: 0 $paddingMenuRight $paddingMenuBottom $paddingMenuLeft;height:$menuHeight; '>
				<div style='float:right;'>
					$menuContent
				</div>
				</div>
				";
		$captionHeight = 30;
			$dlgHeight = $captionHeight+$marginTop+$ContentHeight+$marginBottom+$menuHeight+$paddingMenuBottom;
			//$dlgWidth = 642;
			$dlgWidth = $ContentWidth+$marginLeft+$marginRight+2;

		if($params == NULL){

			//add menu

			$dlg =
				dialog_createCaption($caption, $dlgCaptionContent).
				"<div id='$fmID' style='margin:$marginTop $marginLeft $marginBottom $marginRight;
					overflow:auto;width:$ContentWidth;height:$ContentHeight; border:1px solid #E5E5E5;'
				>".
				$Content.
				'</div>'.
				$menudlg;
			//add border style and dimensi
			$dlg = "<div id='div_border' style='width:$dlgWidth;height:$dlgHeight;
					background-color:white;
					border-color: rgba(0, 0, 0, 0.3);   border-style: solid;  border-width:1;
					box-shadow: 6px 6px 5px rgba(0, 0, 0, 0.3);'>
						$dlg
					</div>";
			//add form
			if($FormName !=''){
				//$dlg = form_it($FormName,$dlg);
			}

		}else{

			$dlg =

				"<table style='width:100%;height:100%' >".
				"<tr height='10'><td>".dialog_createCaption($caption, $dlgCaptionContent)."</td></tr>".
				"<tr  height='*' valign='top'><td>
				<div style='overflow:auto;height:100%'>$Content</div></td></tr>".
				"<tr height='30'><td >$menudlg</td></tr>".
				"</table>";




			$dlg = "<div id='div_border' style='width:100%;height:100%;
					background-color:white;
					border-color: rgba(0, 0, 0, 0.3);   border-style: solid;  border-width:1;
					box-shadow: 6px 6px 5px rgba(0, 0, 0, 0.3);'>
						$dlg
					</div>";

			//if($FormName !=''){
			//	$dlg = form_it($FormName,$dlg);
		//	}
		}


		return $dlg;
	}
	function setForm($dt){
	 global $fmIDBARANG,$fmIDREKENING,$Main;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;
	 $form_name = $this->Prefix.'_form';
	 $sw=$_REQUEST['sw'];
	 $sh=$_REQUEST['sh'];
	 $this->form_width = $sw-50;
		$this->form_height = $sh-100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU';
	  }else{
		$this->form_caption = 'EDIT';
	  }

		//items ----------------------
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='00' "));
		$urusan = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='00' "));
		$bidang = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$unit = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='000'"));
		$subunit = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' "));
		$seksi = $get['nm_skpd'];


	   	$brg = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,g,h,i,j)='".$dt['f'].$dt['g'].$dt['h'].$dt['i'].$dt['j']."'")) ;
	   	$kode_skpd = $dt['f']==''? '' : $dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j'] ;
		$kode_account = $dt['ka']==''? '' : $dt['ka'].'.'.$dt['kb'].'.'.$dt['kc'].'.'.$dt['kd'].'.'.$dt['ke'].'.'.$dt['kf'];
		$title="KIB";

		//-- set visible entry u kib -----------------------------
		$fmkibavisible = "style='display:none'"; //untuk alamat
		$fmkibbvisible = "style='display:none'";
		$fmkibcvisible = "style='display:none'";
		$fmkibdvisible = "style='display:none'"; //untuk sertifikat
		$fmkibevisible = "style='display:none'";
		$fmkibfvisible = "style='display:none'";
		switch ( $dt['f']){
			case '01': $fmkibavisible = "style='display:block'"; break;
			case '02': $fmkibbvisible = "style='display:block'"; break;
			case '03': $fmkibcvisible= "style='display:block'";break;
			case '04': $fmkibdvisible= "style='display:block'";break;
			case '05': $fmkibevisible = "style='display:block'"; break;
			case '06': $fmkibfvisible= "style='display:block'";break;
		}

		//FORM DETAIL PEMINDAHTANGANAN
		//========================
		$this->form_fields = array(
			'btk_pemindahtanganan' => array(
				'label'=> 'Bentuk Pemindahtanganan',
				'labelWidth'=>150,
				'value'=> cmb2D('fmbentuk_pemindahtanganan',$dt['bentuk_pemindahtanganan'],$Main->BentukPemindahtanganan,''),
				'type'=>''
				),
			'ket' => array(
				'label'=>'Keterangan',
				'labelWidth'=>100,
				'value'=>"<textarea name='fmket' id='fmket' cols='83'>{$dt['ket']}</textarea>"
				 ),

		);
		$rpebmd_formdet = "<table style='width:100%' >".$this->setForm_content_fields()."</table>";

		//FORM KIB A
		//========================
		$this->form_fields = array(
			'KIBA' => array(
					'label'=>'',
					'labelWidth'=>150,
					'value'=>'<div style="font-size: 18px;font-weight: bold;color: #C64934;margin:0 0 10 0">KIB A</div>',
					'type'=>'merge'
					),
			'luasA' => array(
				'label'=>'Luas (m2)',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmluasa" id="fmluasa" value="'.$dt['luas'].'" size="4"
					onkeypress="return isNumberKey(event)" readonly="">',
				'type'=>''
				),
			'alamatA' => array(
				'label'=>'Letak/Alamat',
				'labelWidth'=>150,
				'value'=> "<textarea style='width:438;' id='fmalamata' name='fmalamata' readonly=''>".$dt['alamat']."</textarea> ",
				'row_params'=>"valign='top'",
				'labelWidth'=>116, 'type'=>''
				),
			'alamat_kelA' => array(
				'label'=>'Kelurahan/kec/kota',
				'labelWidth'=>150,
				'name'=>'alamat_kel',
				'value'=>'<INPUT type=text name="fmalamat_kela" id="fmalamat_kela" value="'.$dt['kel'].'" readonly="">&nbsp
						  <INPUT type=text name="fmalamat_keca" id="fmalamat_keca" value="'.$dt['kec'].'" readonly="">&nbsp
						  <INPUT type=text name="fmalamat_kotaa" id="fmalamat_kotaa" value="'.$dt['kota'].'" readonly="">' ,
				'type'=>''
				),


		);
		$formKIBA = "<table style='width:100%' >".$this->setForm_content_fields()."</table>";

		//FORM KIB B
		//========================
		$this->form_fields = array(
			'KIBB' => array(
					'label'=>'',
					'labelWidth'=>150,
					'value'=>'<div style="font-size: 18px;font-weight: bold;color: #C64934;margin:0 0 10 0">KIB B</div>',
					'type'=>'merge'
					),
			'merkB' => array(
				'label'=>'Merk/Type/Spesifikasi',
				 'labelWidth'=>150,
				'value'=> "<textarea style='width:438;' id='fmmerk' name='fmmerk' readonly=''>".$dt['merk']."</textarea> ",
				'row_params'=>"valign='top'",
				'labelWidth'=>116, 'type'=>''
				),
			'ukuranB' => array(
				'label'=>'Ukuran',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmukuranb" id="fmukuranb" value="'.$dt['ukuran'].'" readonly="">',
				'type'=>''
				),
			'bahanB' => array(
				'label'=>'Bahan',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmbahanb" id="fmbahanb" value="'.$dt['bahan'].'" readonly="">',
				'type'=>''
				),


		);
		$formKIBB = "<table style='width:100%' >".$this->setForm_content_fields()."</table>";

		//FORM KIB C
		//========================
		$this->form_fields = array(
			'KIBC' => array(
					'label'=>'',
					'labelWidth'=>150,
					'value'=>'<div style="font-size: 18px;font-weight: bold;color: #C64934;margin:0 0 10 0">KIB C</div>',
					'type'=>'merge'
					),
			'konstruksiC' => array(
				'label'=>'Konstruksi Bangunan',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmkonstruksic" id="fmkonstruksic" value="'.$dt['konstruksi'].'" readonly="">',
				'type'=>''
				),
			'tingkatC' => array(
				'label'=>'Bertingkat/Tidak',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmtingkatc" id="fmtingkatc" value="'.$dt['tingkat'].'" readonly="">',
				'type'=>''
				),
			'betonC' => array(
				'label'=>'Beton/Tidak',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmbetonc" id="fmbetonc" value="'.$dt['beton'].'" readonly="">',
				'type'=>''
				),
			'luasC' => array(
				'label'=>'Luas Total Lantai (m2)',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmluasc" id="fmluasc" value="'.$dt['luas'].'" size="4"
					onkeypress="return isNumberKey(event)" readonly="">',
				'type'=>''
				),
			'alamatC' => array(
				'label'=>'Letak/Alamat',
				'labelWidth'=>150,
				'value'=> "<textarea style='width:438;' id='fmalamatc' name='fmalamatc' readonly=''>".$dt['alamat']."</textarea> ",
				'row_params'=>"valign='top'",
				'labelWidth'=>116, 'type'=>''
				),
			'alamat_kelC' => array(
				'label'=>'Kelurahan/Desa',
				'labelWidth'=>150,
				'name'=>'alamat_kel',
				'value'=>'<INPUT type=text name="fmalamat_kelc" id="fmalamat_kelc" value="'.$dt['kel'].'" readonly="">' ,
				'type'=>''
				),
			'alamat_kecC' => array(
				'label'=>'Kecamatan',
				'labelWidth'=>150,
				'name'=>'alamat_kel',
				'value'=>'<INPUT type=text name="fmalamat_kecc" id="fmalamat_kecc" value="'.$dt['kec'].'" readonly="">' ,
				'type'=>''
				),
			'alamat_kotaC' => array(
				'label'=>'Kelurahan/Desa',
				'labelWidth'=>150,
				'name'=>'alamat_kel',
				'value'=>'<INPUT type=text name="fmalamat_kotac" id="fmalamat_kotac" value="'.$dt['kota'].'" readonly="">' ,
				'type'=>''
				),
		);
		$formKIBC = "<table style='width:100%' >".$this->setForm_content_fields()."</table>";

		//FORM KIB D
		//========================
		$this->form_fields = array(
			'KIBD' => array(
					'label'=>'',
					'labelWidth'=>150,
					'value'=>'<div style="font-size: 18px;font-weight: bold;color: #C64934;margin:0 0 10 0">KIB D</div>',
					'type'=>'merge'
					),
			'konstruksiD' => array(
				'label'=>'Konstruksi',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmkonstruksid" id="fmkonstruksid" value="'.$dt['konstruksi'].'" readonly="">',
				'type'=>''
				),
			'panjangD' => array(
				'label'=>'Panjang (Km)',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmpanjang" id="fmpanjang" value="'.$dt['panjang'].'" size="4"
					onkeypress="return isNumberKey(event)" readonly="">',
				'type'=>''
				),
			'lebarD' => array(
				'label'=>'Lebar (m2)',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmlebar" id="fmlebar" value="'.$dt['lebar'].'" size="4"
					onkeypress="return isNumberKey(event)" readonly="">',
				'type'=>''
				),
			'luasD' => array(
				'label'=>'Luas (m2)',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmluasd" id="fmluasd" value="'.$dt['luas'].'" size="4"
					onkeypress="return isNumberKey(event)" readonly="">',
				'type'=>''
				),
			'alamatD' => array(
				'label'=>'Letak/Alamat',
				'labelWidth'=>150,
				'value'=> "<textarea style='width:438;' id='fmalamatd' name='fmalamatd' readonly=''>".$dt['alamat']."</textarea> ",
				'row_params'=>"valign='top'",
				'labelWidth'=>116, 'type'=>''
				),
			'alamat_kelD' => array(
				'label'=>'Kelurahan/Desa',
				'labelWidth'=>150,
				'name'=>'alamat_kel',
				'value'=>'<INPUT type=text name="fmalamat_keld" id="fmalamat_keld" value="'.$dt['kel'].'" readonly="">' ,
				'type'=>''
				),
			'alamat_kecd' => array(
				'label'=>'Kecamatan',
				'labelWidth'=>150,
				'name'=>'alamat_kel',
				'value'=>'<INPUT type=text name="fmalamat_kecd" id="fmalamat_kecd" value="'.$dt['kec'].'" readonly="">' ,
				'type'=>''
				),
			'alamat_kotad' => array(
				'label'=>'Kelurahan/Desa',
				'labelWidth'=>150,
				'name'=>'alamat_kel',
				'value'=>'<INPUT type=text name="fmalamat_kotad" id="fmalamat_kotad" value="'.$dt['kota'].'" readonly="">' ,
				'type'=>''
				),
		);
		$formKIBD = "<table style='width:100%' >".$this->setForm_content_fields()."</table>";

		//FORM KIB E
		//========================
		$this->form_fields = array(
			'KIBE' => array(
					'label'=>'',
					'labelWidth'=>150,
					'value'=>'<div style="font-size: 18px;font-weight: bold;color: #C64934;margin:0 0 10 0">KIB E</div>',
					'type'=>'merge'
					),
			'detE1' => array(
					'label'=>'',
					'labelWidth'=>150,
					'value'=>'Buku Perpustakaan',
					'type'=>'merge'
					),
			'judulE' => array(
				'label'=>'Judul/Pencipta',
				'labelWidth'=>150,
				'name'=>'judulE',
				'value'=>'<INPUT type=text name="fmjudul" id="fmjudul" value="'.$dt['judul'].'" readonly="">' ,
				'type'=>''
				),
			'spesifikasiE' => array(
				'label'=>'Spesifikasi',
				'labelWidth'=>150,
				'name'=>'spesifikasiE',
				'value'=>'<INPUT type=text name="fmspesifikasi" id="fmspesifikasi" value="'.$dt['spesifikasi'].'" readonly="">' ,
				'type'=>''
				),
			'detE2' => array(
					'label'=>'',
					'labelWidth'=>150,
					'value'=>'Barang Bercorak Kesenian/Kebudayaan',
					'type'=>'merge'
					),
			'asalE' => array(
				'label'=>'Asal Daerah',
				'labelWidth'=>150,
				'name'=>'asalE',
				'value'=>'<INPUT type=text name="fmasal" id="fmasal" value="'.$dt['asal'].'" readonly="">' ,
				'type'=>''
				),
			'penciptaE' => array(
				'label'=>'Pencipta',
				'labelWidth'=>150,
				'name'=>'penciptaE',
				'value'=>'<INPUT type=text name="fmpencipta" id="fmpencipta" value="'.$dt['pencipta'].'" readonly="">' ,
				'type'=>''
				),
			'bahanE' => array(
				'label'=>'Bahan',
				'labelWidth'=>150,
				'name'=>'bahanE',
				'value'=>'<INPUT type=text name="fmbahane" id="fmbahane" value="'.$dt['bahan'].'" readonly="">' ,
				'type'=>''
				),
			'detE3' => array(
					'label'=>'',
					'labelWidth'=>150,
					'value'=>'Hewan Ternak',
					'type'=>'merge'
					),
			'jenisE' => array(
				'label'=>'Jenis',
				'labelWidth'=>150,
				'name'=>'jenisE',
				'value'=>'<INPUT type=text name="fmjenis" id="fmjenis" value="'.$dt['jenis'].'" readonly="">' ,
				'type'=>''
				),
			'ukuranE' => array(
				'label'=>'Ukuran',
				'labelWidth'=>150,
				'name'=>'ukuranE',
				'value'=>'<INPUT type=text name="fmukurane" id="fmukurane" value="'.$dt['ukuran'].'" readonly="">' ,
				'type'=>''
				),

		);
		$formKIBE = "<table style='width:100%' >".$this->setForm_content_fields()."</table>";

		//FORM KIB F
		//========================
		$this->form_fields = array(
			'KIBF' => array(
					'label'=>'',
					'labelWidth'=>150,
					'value'=>'<div style="font-size: 18px;font-weight: bold;color: #C64934;margin:0 0 10 0">KIB F</div>',
					'type'=>'merge'
					),
			'konstruksiF' => array(
				'label'=>'Bangunan',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmkonstruksif" id="fmkonstruksif" value="'.$dt['konstruksi'].'" readonly="">',
				'type'=>''
				),
			'detF1' => array(
					'label'=>'',
					'labelWidth'=>150,
					'value'=>'Konstruksi Bangunan',
					'type'=>'merge'
					),
			'tingkatF' => array(
				'label'=>'&nbps&nbps&nbpsBertingkat/Tidak',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmtingkatf" id="fmtingkatf" value="'.$dt['tingkat'].'" readonly="">',
				'type'=>''
				),
			'betonF' => array(
				'label'=>'&nbps&nbps&nbpsBeton/Tidak',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmbetonf" id="fmbetonf" value="'.$dt['beton'].'" readonly="">',
				'type'=>''
				),
			'luasF' => array(
				'label'=>'Luas (m2)',
				'labelWidth'=>150,
				'value'=>'<INPUT type=text name="fmluasf" id="fmluasf" value="'.$dt['luas'].'" size="4"
					onkeypress="return isNumberKey(event)" readonly="">',
				'type'=>''
				),
			'alamatF' => array(
				'label'=>'Letak/Alamat',
				'labelWidth'=>150,
				'value'=> "<textarea style='width:438;' id='fmalamatf' name='fmalamatf' readonly=''>".$dt['alamat']."</textarea> ",
				'row_params'=>"valign='top'",
				'labelWidth'=>116, 'type'=>''
				),
			'alamat_kelF' => array(
				'label'=>'Kelurahan/Desa',
				'labelWidth'=>150,
				'name'=>'alamat_kelF',
				'value'=>'<INPUT type=text name="fmalamat_kelf" id="fmalamat_kelf" value="'.$dt['kel'].'" readonly="">' ,
				'type'=>''
				),
			'alamat_kecF' => array(
				'label'=>'Kecamatan',
				'labelWidth'=>150,
				'name'=>'alamat_kecF',
				'value'=>'<INPUT type=text name="fmalamat_kecf" id="fmalamat_kecf" value="'.$dt['kec'].'" readonly="">' ,
				'type'=>''
				),
			'alamat_kotaF' => array(
				'label'=>'Kelurahan/Desa',
				'labelWidth'=>150,
				'name'=>'alamat_kotaF',
				'value'=>'<INPUT type=text name="fmalamat_kotaf" id="fmalamat_kotaf" value="'.$dt['kota'].'" readonly="">' ,
				'type'=>''
				),

		);
		$formKIBF = "<table style='width:100%' >".$this->setForm_content_fields()."</table>";

		/*****************************************************************
		 *				FORM UTAMA                                       *
		 *                                                               *
		 *****************************************************************/
		  $this->form_fields = array(
		    'urusan' => array( 'label'=>'URUSAN',
								'labelWidth'=>150,
								'value'=>$urusan,
								'type'=>'', 'row_params'=>"height='21'"
							),
			'bidang' => array( 'label'=>'BIDANG',
								'labelWidth'=>150,
								'value'=>$bidang,
								'type'=>'', 'row_params'=>"height='21'"
							),
			'unit' => array( 'label'=>'SKPD',
								'value'=>$unit,
								'type'=>'', 'row_params'=>"height='21'"
							),
			'subunit' => array( 'label'=>'UNIT',
								'value'=>$subunit,
								'type'=>'', 'row_params'=>"height='21'"
							),
			'seksi' => array( 'label'=>'SUB UNIT',
								'value'=>$seksi,
								'type'=>'', 'row_params'=>"height='21'"
							),

            'thn_anggaran' => array(
								'label'=>'Tahun Anggaran',
								'labelWidth'=>150,
								'value'=>"<input type='text' name='fmthn_anggaran' id='fmthn_anggaran' size='4' value='".$dt['thn_anggaran']."' readonly=''>"
									 ),
			'nm_barang' => array(
								'label'=>'Nama Barang',
								'labelWidth'=>150,
								'value'=>"<input type='text' name='fmIDBARANG' id='fmIDBARANG' size='15' value='$kode_skpd' readonly=''>".
										 "&nbsp;<input type='text' name='fmNMBARANG' id='fmNMBARANG' size='60' value='".$brg['nm_barang']."' readonly=''>".
										 "&nbsp;<input type='button' value='Cari' onclick=\"".$this->Prefix.".caribarang1()\" >
										 <input type='hidden' name='kode_account' value='$kode_account' size='15px' id='kode_account' readonly>
										  <input type='hidden' name='nama_account' value='".$dt['nm_account']."' size='60px' id='nama_account' readonly>
										  <input type='hidden'' id='tahun_account' name='tahun_account' value='".$dt['thn_akun']."'>
										 "
									 ),

			/*'kode_account' => array(
								'label'=>'Nama Akun',
								'labelWidth'=>100,
								'value'=>"<input type='text' name='kode_account' value='$kode_account' size='15px' id='kode_account' readonly>
										  <input type='text' name='nama_account' value='".$dt['nm_account']."' size='60px' id='nama_account' readonly>
										  <input type=hidden id='tahun_account' name='tahun_account' value='".$dt['thn_akun']."'>
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".CariJurnal()' title='Cari Jurnal' >"
									 ),		*/
			'noreg' => array(
								'label'=>'No Register',
								'labelWidth'=>150,
								'value'=>"<input type='text' name='fmnoreg' id='fmnoreg' value='".$dt['noreg']."' readonly=''>"
									 ),
            'thn_perolehan' => array(
								'label'=>'Tahun Perolehan',
								'labelWidth'=>150,
								'value'=>"<input type='text' name='fmthn_perolehan' id='fmthn_perolehan' value='".$dt['thn_perolehan']."' readonly=''>"
									 ),
			'harga_perolehan' => array(
								'label'=>'Harga Perolehan',
								'labelWidth'=>150,
								'value'=>"<input type='text' name='valharga_perolehan' id='valharga_perolehan' value='".$dt['valharga_perolehan']."' readonly=''>
										<input type=hidden id='fmharga_perolehan' name='fmharga_perolehan' value='".$dt['harga_perolehan']."'>"
									 ),
			'asal_usul' => array(
								'label'=>'Asal/Cara Perolehan',
								'labelWidth'=>150,
								'value'=>"<input type='text' name='valasalusul' id='valasalusul' value='".$dt['valasal_usul']."' readonly=''>
										<input type=hidden id='fmasalusul' name='fmasalusul' value='".$dt['asal_usul']."'>"
									 ),
			'kondisi' => array(
								'label'=>'Kondisi Barang',
								'labelWidth'=>150,
								'value'=>"<input type='text' name='valkondisi' id='valkondisi' value='".$dt['valkondisi']."' readonly=''>
										<input type=hidden id='fmkondisi' name='fmkondisi' value='".$dt['kondisi']."'>"
									 ),

			'fmkiba' => array(
				'label'=> '',
				'value'=> "<div id='rpebmd_formkiba' name='rpebmd_formkiba' $fmkibavisible>".$formKIBA."</div>",
				'type'=>'merge'
				),
			'fmkibb' => array(
				'label'=> '',
				'value'=> "<div id='rpebmd_formkibb' name='rpebmd_formkibb' $fmkibbvisible>".$formKIBB."</div>",
				'type'=>'merge'
				),
			'fmkibc' => array(
				'label'=> '',
				'value'=> "<div id='rpebmd_formkibc' name='rpebmd_formkibc' $fmkibcvisible>".$formKIBC."</div>",
				'type'=>'merge'
				),
			'fmkibd' => array(
				'label'=> '',
				'value'=> "<div id='rpebmd_formkibd' name='rpebmd_formkibd' $fmkibdvisible>".$formKIBD."</div>",
				'type'=>'merge'
				),
			'fmkibe' => array(
				'label'=> '',
				'value'=> "<div id='rpebmd_formkibe' name='rpebmd_formkibe' $fmkibevisible>".$formKIBE."</div>",
				'type'=>'merge'
				),
			'fmkibf' => array(
				'label'=> '',
				'value'=> "<div id='rpebmd_formkibf' name='rpebmd_formkibf' $fmkibfvisible>".$formKIBF."</div>",
				'type'=>'merge'
				),
			'det_rpebmd' => array(
				'label'=> '',
				'labelWidth'=>150,
				'value'=> "<div id='det_rpebmd' name='det_rpebmd' >".$rpebmd_formdet."</div>",
				'type'=>'merge'
			),
			'tempatBUrrong' => array(
			'label'=> '',
			'labelWidth'=>150,
			'value'=>
					"<input type=hidden id='c1' name='c1' value='".$dt['c1']."'> ".
			 "<input type=hidden id='c' name='c' value='".$dt['c']."'> ".
			 "<input type=hidden id='d' name='d' value='".$dt['d']."'> ".
			 "<input type=hidden id='e' name='e' value='".$dt['e']."'> ".
			 "<input type=hidden id='e1' name='e1' value='".$dt['e1']."'> ".
			 "<input type='hidden' id='fmid_buku_induk' name='fmid_buku_induk' value='".$dt['id_bukuinduk']."' >".
	 	 		"<input type='hidden' id='fmidbi_awal' name='fmidbi_awal' value='".$dt['idbi_awal']."' >".
				 "<input type='hidden' id='fmid_buku_induk' name='fmid_buku_induk' value='".$dt['id_bukuinduk']."' >".
				 "<input type='hidden' id='fmidbi_awal' name='fmidbi_awal' value='".$dt['idbi_awal']."' >".
				 "<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
				 <input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
			"

				 <table>
					<tr>
						<td>".$this->buttonnya($this->Prefix.'.'.'Simpan()','save_f2.png','simpan','simpan','SIMPAN')."</td>
						<td>".$this->buttonnya($this->Prefix.'.Close()','cancel_f2.png','batal','batal','BATAL')."</td>

					</tr></table>",
			'type'=>'merge'
		),
			);
		//tombol
		$this->form_menubawah = ""
		   ;

		$form = $this->genForm2();

		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function buttonnya($js,$img,$name,$alt,$judul){
		return "<table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'>
					<td class='border:none'>
						<a class='toolbar' id='btsave'
							href='javascript:$js'>
						<img src='images/administrator/images/$img' alt='$alt' name='$name' width='32' height='32' border='0' align='middle' title='$judul'> $judul</a>
					</td>
					</tr>
					</tbody></table> ";
	}
	function SetFormCari(){
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$cek = 'tes';

		$dt=array();
		$this->form_fmST = 0;
		//$dt['tgl_usul'] = date("Y-m-d"); //set waktu sekarang
		//$dt['sesi'] = gen_table_session('penghapusan_usul','uid'); //generate no sesi
		//$fm = $this->setFormCr($dt);

		$sw=$_REQUEST['sw'];
		$sh=$_REQUEST['sh'];

		$form_name = 'adminForm';	//nama Form
		$this->form_width = $sw-50;
		$this->form_height = $sh-100;
		$this->form_caption = 'Cari Barang'; //judul form

		$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$dt['e1'] = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='00' "));
		$bidang = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$unit = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='000'"));
		$subunit = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' "));
		$seksi = $get['nm_skpd'];

		$this->form_fields = array(

			'detailcari' => array(
				'label'=>'',
				'value'=>"<div id='div_detailcaribi' style='height:5px'></div>",
				'type'=>'merge'
			)
		);

		//tombol
		$this->form_menubawah =
			"<input type='button' value='Pilih' onclick ='".$this->Prefix.".Pilih()' >".
			"<input type='button' value='Close' onclick ='".$this->Prefix.".Closecari()' >";

		//$form = //$this->genForm();
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
					,
					$this->form_menu_bawah_height,
					'',1
					).
				"</form>";

		$content = $form;


		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5' rowspan='2'>No.</th>
	  	   $Checkbox
		   <th class='th01' rowspan='2'>Kode Barang</th>
		   <th class='th01' rowspan='2'>Noreg</th>
		   <th class='th01' rowspan='2'>Nama Barang</th>
		   <th class='th02' colspan='2'>Spesifikasi Barang</th>
		   <th class='th01' rowspan='2'>Tahun/Cara Perolehan</th>
		   <th class='th01' rowspan='2'>Harga Perolehan</th>
		   <th class='th01' rowspan='2'>Ukuran/Konstruksi</th>
		   <th class='th01' rowspan='2'>Kondisi Barang</th>
		   <th class='th01' rowspan='2'>Bentuk Pemindahtanganan</th>
		   <th class='th01' rowspan='2'>Keterangan</th>
	   </tr>
	   <tr>
	  	   <th class='th01' >Merk/Type/Alamat</th>
		   <th class='th01' >No. Sertifikat / No. Pabrik / No. Chasis / No. Mesin</th>

	   </tr>
	   </thead>";

	return $headerTable;
	}

	function setPage_HeaderOther(){
   		return
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
<!--		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=renjaAset\" title='MURNI' style='color : blue;' > MURNI </a> |
		<A href=\"pages.php?Pg=renjaAsetPerubahan\" title='PERUBAHAN' > PERUBAHAN </a>

		&nbsp&nbsp&nbsp
		</td></tr>
-->
		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=renjaAset\" title='RENJA'  > RENJA </a> |
		<A href=\"pages.php?Pg=rkbmdPengadaan_v3\" title='RKBMD'  style='color : blue;' > RKBMD </a> |
		<A href=\"pages.php?Pg=koreksiPengelolaPengadaan\" title='RKBMD PENGELOLA' > RKBMD PENGELOLA </a> |
		<A href=\"pages.php?Pg=penetapatanRKBMDPengadaan\" title='RKBMD PENGELOLA' > PENETAPAN RKBMD </a>

		&nbsp&nbsp&nbsp
		</td></tr>

		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=rkbmdPengadaan_v3\" title='RKBMD'   > PENGADAAN </a> |
		<A href=\"pages.php?Pg=rkbmdPemeliharaan_v3\" title='RKBMD PENGELOLA' > PEMELIHARAAN </a> |
		<A href=\"pages.php?Pg=rkbmdPersediaan_v3\" title='RKBMD PERSEDIAAN'  > PERSEDIAAN </a> |
		<A href=\"pages.php?Pg=rencana_pemanfaatan\" title='RKBMD PEMANFAATAN' > PEMANFAATAN </a> |
		<A href=\"pages.php?Pg=rpebmd\" title='RKBMD PEMINDAHTANGANAN'  style='color : blue;'> PEMINDAHTANGANAN </a> |
		<A href=\"pages.php?Pg=rphbmd\" title='RKBMD PENGHAPUSAN' > PENGHAPUSAN </a>

		&nbsp&nbsp&nbsp
		</td></tr>


		</table>";
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;
		$kd_barang=$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'];
	 	$brg = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,g,h,i,j)='".$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j']."'")) ;
		$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='".$isi['id_bukuinduk']."'")) ;
		if($bi['f']=='01'){
			$aqry = "select * from kib_a where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['alamat'];
			$no_det=$arrdet['sertifikat_no'];
			$ukuran=$arrdet['luas']." m2";
		}
		if($bi['f']=='02'){
			$aqry = "select * from kib_b where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['merk'];
			$no_det=$arrdet['no_pabrik']."/".$arrdet['no_rangka']."/".$arrdet['no_mesin'];
			$ukuran=$arrdet['ukuran']." cc";
		}
		if($bi['f']=='03'){
			$aqry = "select * from kib_c where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['alamat'];
			$no_det=$arrdet['dokumen_no'];
			$ukuran=$Main->Bangunan[$arrdet['kondisi_bangunan']-1][1];
		}
		if($bi['f']=='04'){
			$aqry = "select * from kib_d where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['alamat'];
			$no_det=$arrdet['dokumen_no'];
			$ukuran=$Main->Bangunan[$arrdet['konstruksi']-1][1];
		}
		if($bi['f']=='05'){
			$aqry = "select * from kib_e where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['buku_judul']."/".$arrdet['buku_spesifikasi'];
			$no_det="";
			$ukuran=$arrdet['hewan_ukuran'];
		}
		if($bi['f']=='06'){
			$aqry = "select * from kib_f where
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['alamat'];
			$no_det=$arrdet['dokumen_no'];
			$ukuran=$Main->Bangunan[$arrdet['bangunan']-1][1];
		}

	    $cara=$isi['thn_perolehan']." / ".$Main->AsalUsul[$bi['asal_usul']-1][1];
		$harga=number_format($isi['harga'],2,',','.');

		$Koloms = array();
		$Koloms[] = array('align=center', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('align=center', $kd_barang);
		$Koloms[] = array('align=center', $isi['noreg']);
		$Koloms[] = array('', $brg['nm_barang']);
		$Koloms[] = array('', $merk) ;
		$Koloms[] = array('', $no_det);
		$Koloms[] = array('', $cara);
		$Koloms[] = array('align=right', $harga);
		$Koloms[] = array('', $ukuran);
		$Koloms[] = array('', $Main->KondisiBarang[$bi['kondisi']-1][1]);
		$Koloms[] = array('', $Main->BentukPemindahtanganan[$isi['bentuk_pemindahtanganan']-1][1]);
		$Koloms[] = array('', $isi['ket']);
		return $Koloms;
	}
	function genDaftarInitial(){
		$vOpsi = $this->genDaftarOpsi();
		$fmThnAnggaran=  $this->tahun;
		$divHal = "<div id='{$this->Prefix}_cont_hal' style='position:relative'>".
							"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
						"</div>";
		switch($this->daftarMode){
			case '1' :{ //detail horisontal
				$vdaftar =
					"<table width='100%'><tr valign=top>
					<td style='width:$this->containWidth;'>".
						"<div id='{$this->Prefix}_cont_daftar' style='position:relative;width:$this->containWidth;overflow:auto' >"."</div>".
						$divHal.
					"</td>".
					"<td>".
						"<div id='{$this->Prefix}_cont_daftar_det' style=''>".$this->genTableDetail()."</div>".
					"</td>".
					"</tr></table>";
				break;
			}
			default :{
				$vdaftar =
					"<div id='{$this->Prefix}_cont_daftar' style='position:relative;' >"."</div>".
					$divHal;
				break;
			}
		}

		return
			//$NavAtas.
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".
				"<input type='hidden' value='$fmThnAnggaran' id='fmThnAnggaran' name='fmThnAnggaran' >".
			"</div>".
			//"<div style='position:relative'>".
			$vdaftar.
			//"</div>".
			'';
	}
	function genDaftarOpsi(){
	 global $Ref, $Main;

	$fmThnAnggaran=  $this->tahun;

	$fmPILCARI = cekPOST('fmPILCARI');
	$fmPILCARIVALUE = cekPOST('fmPILCARIVALUE');
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');


	$arrCari = array(
			array('1','Kode Barang'),
			array('2','Nama Barang'),
			);

	//data order ------------------------------
	 $arrOrder = array(
	  	         array('1','Kode Barang'),
			     array('2','Nama Barang'),
	 );

	$TampilOpt =
			"<table width=\"100%\" class=\"adminform\">	<tr>
			<td width=\"100%\" valign=\"top\">" .
				WilSKPD_ajx3($this->Prefix.'Skpd','100%',100) .
			"</td>
			<td >" .
			"</td></tr>
			<!--<tr><td>
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>			-->
			</table>".
			genFilterBar(
				array(
					cmbArray('fmPILCARI',$fmPILCARI,$arrCari,'Cari Data','').
					"&nbsp;<input type='text' value='$fmPILCARIVALUE' id='fmPILCARIVALUE' name='fmPILCARIVALUE'>"
				)
				, $this->Prefix.".refreshList(true)",TRUE, 'Cari').
			genFilterBar(
				array(
					boxFilter( 'Tahun Anggaran : '.	"<input type='text' value='$fmThnAnggaran' id='fmThnAnggaran' name='fmThnAnggaran' readonly>"	 )
				),$this->Prefix.".refreshList(true)",FALSE
			).
			genFilterBar(
				array(
					'Urutkan : '.
					cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--','').
					"<input type='checkbox' $fmDESC1 id='fmDESC1' name='fmDESC1' value='checked'>Desc."
				),
				$this->Prefix.".refreshList(true)");
		return array('TampilOpt'=>$TampilOpt);
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;

		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------

		$arrKondisi = array();
		$fmThnAnggaran=$_REQUEST['fmThnAnggaran'];
		$fmPILCARI = cekPOST('fmPILCARI');
		$fmPILCARIVALUE = cekPOST('fmPILCARIVALUE');
		$fmURUSAN = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST($this->Prefix.'SkpdfmURUSAN');
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');
		if(!($fmURUSAN=='' || $fmURUSAN=='0') ) $arrKondisi[] = "c1='$fmURUSAN'";
		if(!($fmSKPD=='' || $fmSKPD=='00') ) $arrKondisi[] = "c='$fmSKPD'";
		if(!($fmUNIT=='' || $fmUNIT=='00') ) $arrKondisi[] = "d='$fmUNIT'";
		if(!($fmSUBUNIT=='' || $fmSUBUNIT=='00') ) $arrKondisi[] = "e='$fmSUBUNIT'";
		if(!($fmSEKSI=='' || $fmSEKSI=='00') ) $arrKondisi[] = "e1='$fmSEKSI'";
		if(!($fmThnAnggaran=='') ) $arrKondisi[] = "thn_anggaran='$fmThnAnggaran'";
		switch($fmPILCARI){
			case '1': $arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) like '%$fmPILCARIVALUE%'"; break;
			case '2': $arrKondisi[] = " nm_barang like '%$fmPILCARIVALUE%'"; break;
		}

		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " concat(f,g,h,i,j) $Asc1 " ;break;
			case '2': $arrOrders[] = " nm_barang $Asc1 " ;break;
		}

			$Order= join(',',$arrOrders);
			$OrderDefault = ' Order By concat(f,g,h,i,j) ';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//}
		//$Order ="";
		//limit --------------------------------------
		/**$HalDefault=cekPOST($this->Prefix.'_hal',1);	//Cat:Settingan Lama
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;
		**/
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}

function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		$fmURUSAN = cekPOST($this->Prefix.'SkpdfmURUSAN');
		$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD'); //echo 'fmskpd='.$fmSKPD;
		$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = cekPOST($this->Prefix.'SkpdfmSEKSI');

		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>
			<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".PrintSKPD3($this->provinsi,$this->kota,$fmURUSAN,$fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI)."</td>
				</tr>
			</table><br>";
	}
function setCetak_footer(){
		return "<br>".
				PrintTTD2($this->kota,$this->Cetak_WIDTH);
	}
}
$rpebmd = new rpebmdObj();

$arrayResult = tahapPerencanaanV3($rpebmd->modul);
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$rpebmd->jenisForm = $jenisForm;
$rpebmd->nomorUrut = $nomorUrut;
$rpebmd->urutTerakhir = $nomorUrut;
$rpebmd->tahun = $tahun;
$rpebmd->jenisAnggaran = $jenisAnggaran;
$rpebmd->idTahap = $idTahap;
$rpebmd->username = $_COOKIE['coID'];
$rpebmd->wajibValidasi = $arrayResult['wajib_validasi'];
if($rpebmd->wajibValidasi == TRUE){
	$rpebmd->sqlValidasi = " and status_validasi ='1' ";
}else{
	$rpebmd->sqlValidasi = " ";
}
$rpebmd->provinsi = $arrayResult['provinsi'];
$rpebmd->kota = $arrayResult['kota'];

$rpebmd->pengelolaBarang = $arrayResult['pengelolaBarang'];
$rpebmd->pejabatPengelolaBarang = $arrayResult['pejabat'];
$rpebmd->pengurusPengelolaBarang = $arrayResult['pengurus'];
$rpebmd->nipPengelola = $arrayResult['nipPengelola'];
$rpebmd->nipPengurus = $arrayResult['nipPengurus'];
$rpebmd->nipPejabat = $arrayResult['nipPejabat'];

?>
