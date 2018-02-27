<?php

class cekFisikObj  extends DaftarObj2{
	var $Prefix = 'cekFisik';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_kartu_persediaan'; //bonus
	var $TblName_Hapus = 't_kartu_persediaan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'CEK FISIK';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='cekFisik.xls';
	var $namaModulCetak='CEK FISIK';
	var $Cetak_Judul = 'CEK FISIK';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'cekFisikForm';
	var $modul = "CEK FISIK";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";
	var $currentTahap = "";
	var $namaTahapTerakhir = "";
	var $masaTerakhir = "";
	//buatview
	var $urutTerakhir = "";
	var $urutSebelumnya = "";
	var $jenisFormTerakhir = "";

	var $username = "";
	var $wajibValidasi = "";

	var $sqlValidasi = "";
	//buatview
	var $TampilFilterColapse = 0; //0

	var $provinsi = "";
	var $kota = "";
	var $pengelolaBarang = "";
	var $pejabatPengelolaBarang = "";
	var $pengurusPengelolaBarang = "";
	var $nipPengelola = "";
	var $nipPejabat = "";
	var $nipPengurus ="";

	var $publicVar = "";
	var $tanggalCek = "";

	var $arrEselon = array( 
    array('1','ESELON I'),
    array('2','ESELON II'),
    array('3','ESELON III'),
    array('4','ESELON IV'),
    array('5','ESELON V')
    );

  function setFormBaru(){
    global $Main;
    $cbid = $_REQUEST[$this->Prefix.'_cb'];
    $cek =$cbid[0];       
    $this->form_idplh = $cbid[0];
    $kode = explode(' ',$this->form_idplh);
    $this->form_fmST = 0;
    
    $dt=array();
    //$this->form_idplh ='';
    $this->form_fmST = 0;
  //  $dat_urusan= $_REQUEST['dat_urusan'];
    $urusan = $Main->URUSAN;
    if ($urusan=='0'){
      $dt['c1'] = $_REQUEST[$this->Prefix.'fmSKPDUrusan'];
      $dt['c'] = $_REQUEST[$this->Prefix.'fmSKPDBidang'];
      $dt['d'] = $_REQUEST[$this->Prefix.'fmSKPDskpd'];
      $fm = $this->setForm4($dt);
    }else{
      $dt['c1'] = $_REQUEST[$this->Prefix.'cekFisikSKPD2fmURUSAN'];
      $dt['c'] = $_REQUEST[$this->Prefix.'cekFisikSKPD2fmSKPD'];
      $dt['d'] = $_REQUEST[$this->Prefix.'cekFisikSKPD2fmUNIT'];
      $dt['e'] = $_REQUEST[$this->Prefix.'cekFisikSKPD2fmSUBUNIT'];
      $dt['e1'] = $_REQUEST[$this->Prefix.'cekFisikSKPD2fmSEKSI'];
      $fm = $this->setForm($dt);
    }
      return  array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  }

function setForm($dt,$c1,$c,$d,$e,$e1){  
   global $SensusTmp;
   $cek = ''; $err=''; $content='';     
   $json = TRUE;  //$ErrMsg = 'tes';    
   $form_name = $this->Prefix.'_form';        
   $this->form_width = 700;
   $this->form_height = 280;
    if ($this->form_fmST==0) {
    $this->form_caption = 'BARU TANDA TANGAN';
    $nip   = '';
    }else{
    $this->form_caption = 'EDIT TANDA TANGAN';      
    $readonly='readonly';
          
    }
     $arrOrder = array(
                 array('1','Kepala Dinas'),
             array('2','Pengurus Barang'),
          );
  $arr = array(
      //array('selectAll','Semua'), 
      array('selectKepala Dinas','Kepala Dinas'), 
      array('selectPengurus Barang','Pengurus Barang'),   
      );
      //ambil data trefditeruskan
    $query = "" ;$cek .=$query;
    $res = mysql_query($query);
    $kode1=genNumber($dt['c'],2);
    $kode2=genNumber($dt['d'],2);
    $kode3=genNumber($dt['e'],2);
    $kode4=genNumber($dt['e1'],3);
    $nama=$dt['nama'];
    $nip=$dt['nip'];
    $jabatan=$dt['jabatan'];
    
    $Arrjbt = array(
        array('1.',"Kepala Dinas"),
        array('2.','Pengurus Barang'),
        );
            
    $c1 = $_REQUEST['urusan'];
    $c = $_REQUEST['bidang'];
    $d = $_REQUEST['skpd'];
    $e = $_REQUEST['unit'];
    $e1 = $_REQUEST['subunit'];
    $ket = $dt['kategori_tandatangan'];

    $qry4 = "SELECT * FROM ref_skpd WHERE c1='$c1' and c='00' AND d='00' AND e='00' AND e1='000'";//$cek.=$qry;
    $aqry4 = mysql_query($qry4);
    $queryc1 = mysql_fetch_array($aqry4);
    
    $qry = "SELECT * FROM ref_skpd WHERE c1='$c1' and c='$c' AND d='00' AND e='00' AND e1='000'";//$cek.=$qry;
    $aqry = mysql_query($qry);
    $queryc = mysql_fetch_array($aqry);
  //  $cek.=$data;
    
    $qry1 = "SELECT * FROM ref_skpd WHERE c1='$c1' and c='$c' AND d='$d' AND e='00' AND e1='000'";//$cek.=$qry1;
    $aqry1 = mysql_query($qry1);
    $queryd = mysql_fetch_array($aqry1);
    
    $qry2 = "SELECT * FROM ref_skpd WHERE c1='$c1' and c='$c' AND d='$d' AND e='$e' AND e1='000'";//$cek.=$qry2;
    $aqry2 = mysql_query($qry2);
    $querye = mysql_fetch_array($aqry2);
    
    $qry3 = "SELECT * FROM ref_skpd WHERE c1='$c1' and c='$c' AND d='$d' AND e='$e' AND e1='$e1'";$cek.=$qry3;
    $aqry3 = mysql_query($qry3);
    $querye1 = mysql_fetch_array($aqry3);
    
    
    $queryKategori = "SELECT id,kategori_tandatangan FROM ref_kategori_tandatangan where id = 23";
  
    
    $queryPangkat="select nama,concat(nama,' (',gol,'/',ruang,')')as nama from ref_pangkat order by gol,ruang";
    $queryPangkat2="select pangkat,concat(pangkat,' (',gol,'/',ruang,')')as nama from ref_tandatangan where pangkat='".$_REQUEST['pangkat']."' and gol='".$_REQUEST['gol']."' and ruang='".$_REQUEST['ruang']."'";
    $queryPangkat2=mysql_fetch_array(mysql_query("select gol,ruang from ref_tandatangan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and Id='".$this->form_idplh."'"));
    $cek.="select gol,ruang from ref_tandatangan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and Id='".$this->form_idplh."'";
       //items ----------------------
    $datketegori="select kategori_tandatangan from ref_kategori_tandatangan where kategori_tandatangan='".$dt['kategori_tandatangan']."'";
    $cek.="select kategori_tandatangan from ref_kategori_tandatangan where kategori_tandatangan='".$dt['kategori_tandatangan']."'";
    //$qry_jabatan = "SELECT Id, nama FROM ref_jabatan WHERE c1='$c1' AND c='$c' AND d='$d' ";
    $querygedung="";
    $datapangkat=$queryPangkat2['gol']."/".$queryPangkat2['ruang'];
    $datc1=$queryc1['c1'].".".$queryc1['nm_skpd'];
    $datc=$queryc['c'].".".$queryc['nm_skpd'];
    $datd=$queryd['d'].".".$queryd['nm_skpd'];
    $date=$querye['e'].".".$querye['nm_skpd'];
    $date1=$querye1['e1'].".".$querye1['nm_skpd'];
    $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '23' "));
     $this->form_fields = array(
      'URUSAN' => array( 
            'label'=>'URUSAN',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='dc1' id='dc1' value='".$datc1."' style='width:500px;' readonly>
            <input type ='hidden' name='c1' id='c1' value='".$queryc1['c1']."'>
            </div>", 
             ),
      
      'bidang' => array( 
            'label'=>'BIDANG',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='dc' id='dc' value='".$datc."' style='width:500px;' readonly>
            <input type ='hidden' name='c' id='c' value='".$queryc['c']."'>
            </div>", 
             ),
      
      'skpd' => array( 
            'label'=>'SKPD',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='dd' id='dd' value='".$datd."' style='width:500px;' readonly>
            <input type ='hidden' name='d' id='d' value='".$queryd['d']."'>
            </div>", 
             ),
      'unit' => array(
      			'label'=>'UNIT',
      			'labelWidth'=>150,
      			'value'=>"<div style='float:left;'>
      			<input type='text' name='de' id='de' value='".$date."' style='width: 500px;' readonly>
      			<input type='hidden' name='e' id='e' value='".$querye['e']."'>
      			</div> ",
      			 ),
      'subunit' => array( 
            'label'=>'SUB UNIT',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='de1' id='de1' value='".$date1."' style='width:500px;' readonly>
            <input type ='hidden' name='e1' id='e1' value='".$querye1['e1']."'>
            </div>", 
             ),
      'kategori' => array( 
            'label'=>'KATEGORI',
            'labelWidth'=>150,
            'value'=>"<input type='text' readonly='readonly' id='kategori' name='kategori' style='width: 250px;' value='".$queryKategori1[kategori_tandatangan]."'  >",
          
            
             ),
    //  cmbQuery('fmJabatan',$dt['jabatan'],$queryJabatan,'','-------- Pilih --------')
      'namapegawai' => array( 
            'label'=>'NAMA',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='namapegawai' id='namapegawai' value='".$dt['nama']."' style='width:500px;'>
            
            </div>", 
             ), 
      'nippegawai' => array( 
            'label'=>'NIP',
            'labelWidth'=>170, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='nippegawai' id='nippegawai' value='".$dt['nip']."' style='width:250px;'>
            
            </div>", 
             ), 
             
      
    
      'pangkat' => array( 
            'label'=>'PANGKAT/ GOL/ RUANG.',
            'labelWidth'=>150, 
            'value'=>
            "<div id='cont_gd'>".cmbQuery('pangkatakhir',$_REQUEST['pangkat'],$queryPangkat,'style="width:250px;"onchange="'.$this->Prefix.'.pilihPangkat()"','--PILIH--')."&nbsp&nbsp"."<input type='text' name='golang_akhir' style='width:40px;' id='golang_akhir' size=1 value='".$datapangkat."' readonly>
          
            </div>",
             ), 
      
      'jabatan' => array( 
            'label'=>'JABATAN',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='jabatan' id='jabatan' value='".$dt['jabatan']."' style='width:300px;'>
            
            </div>", 
             ),       
            
            
      'eselon' => array( 
            'label'=>'ESELON',
            'labelWidth'=>150, 
            'value'=>cmbArray('eselon_akhir',$_REQUEST['eselon'],$this->arrEselon,'--PILIH--','style=width:100px;'),
          //  'value'=>cmbArray('status',$dt['status'],$this->stStatus,'--PILIH Status--',''), 
            ),
                             
      );
    //tombol
    $this->form_menubawah = 
      "<input type='hidden' name='Id_skpd' id='Id_skpd'  value='".$Id."'>".
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
              
    $form = $this->genForm();   
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
    
  }

function simpan(){
   global $HTTP_COOKIE_VARS;
   global $Main;
   
   $uid = $HTTP_COOKIE_VARS['coID'];
   $cek = ''; $err=''; $content=''; $json=TRUE;
  //get data -----------------
   $fmST = $_REQUEST[$this->Prefix.'_fmST'];
   $idplh = $_REQUEST[$this->Prefix.'_idplh'];
   $kode1= $_REQUEST['c1'];
   $kode2= $_REQUEST['c'];
   $kode3= $_REQUEST['d'];
   $kode4= $_REQUEST['e'];
   $kode5= $_REQUEST['e1'];
   $namapegawai= $_REQUEST['namapegawai'];
   $nippegawai= $_REQUEST['nippegawai'];
  
   $p1= $_REQUEST['pangkatakhir'];
  
   $golang_akhir= $_REQUEST['golang_akhir'];
   $golongan = explode("/", $golang_akhir);
   $jabatan= $_REQUEST['jabatan'];
   $eselon= $_REQUEST['eselon_akhir'];
   $kategori= $_REQUEST['kategori'];
  
  
  $oldy=mysql_fetch_array(
    mysql_query(
      "select count(*) as cnt from ref_tandatangan where nip='$nippegawai'"
    ));
   if( $err=='' && $namapegawai =='' ) $err= 'NAMA PEGAWAI Belum Di Isi !!';
   if( $err=='' && $nippegawai =='' ) $err= 'NIP Belum Di Isi !!';
   if( $err=='' && $p1 =='' ) $err= 'PANGKAT/ GOL/ RUANG Belum Di Pilih !!';
   if( $err=='' && $jabatan =='' ) $err= 'JABATAN Belum Di Isi !!';
   if( $err=='' && $kategori =='' ) $err= 'Kategori Belum Di Pilih !!';
  
      if($fmST == 0){
      if($err=='' && $oldy['cnt']>0) $err="NIP '$nippegawai' Sudah Ada";
        if($err==''){
      
          $aqry = "INSERT into ref_tandatangan (c1,c,d,e,e1,nama,nip,jabatan,pangkat,gol,ruang,eselon,kategori_tandatangan) values('$kode1','$kode2','$kode3','$kode4','$kode5','$namapegawai','$nippegawai','$jabatan','$p1','$golongan[0]','$golongan[1]','$eselon','23')";  $cek .= $aqry;  
          $qry = mysql_query($aqry);

          $content = array('combottd' => cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = 23 and c1 = '".$_REQUEST[c1]."' and c = '".$_REQUEST[c]."' and d = '".$_REQUEST[d]."' and e = '".$_REQUEST[e]."' and e1 = '".$_REQUEST[e1]."' ",'onchange=rka.refreshList(true);','-- TTD --'));
        }
      }else{            
        if($err==''){
        $aqry = "UPDATE ref_tandatangan SET nama='$namapegawai', nip='$nippegawai', jabatan='$jabatan' ,pangkat='$p1', gol='$golongan[0]' ,ruang='$golongan[1]',eselon='$eselon' ,kategori_tandatangan='$kategori' WHERE Id='".$idplh."'";  $cek .= $aqry;
            $qry = mysql_query($aqry) or die(mysql_error());
          }
      } //end else
          
      return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);  
    }

	function setTitle(){
		return 'CEK FISIK';
	}
	// function setMenuView(){
	// 	return
	// 		// "<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";
	// 		"";
	// }
	function setMenuEdit(){

	 	$listMenu =
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png","Laporan ", 'Laporan ')."</td>"
					;

		return $listMenu ;
	}

	function setMenuView(){
		return "";

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

	  	case 'simpan':{
				$get= $this->simpan();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		   }

	  	case 'pilihPangkat':{
	      global $Main;
	      $cek = ''; $err=''; $content=''; $json=TRUE;
	      
	      $idpangkat = $_REQUEST['pangkatakhir'];
	      
	      $query = "select concat(gol,'/',ruang)as nama FROM ref_pangkat WHERE nama='$idpangkat'" ;
	      $get=mysql_fetch_array(mysql_query($query));$cek.=$query;
	      $content=$get['nama'];                      
	      break;
	    }

			case 'getYearRange':{
				$yearRange = $_COOKIE['coThnAnggaran'] - date("Y");
				$content = array(
													'yearRange' => $yearRange.":".$yearRange
				);
			break;
			}
			case 'cekFisik':{
				foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
				}

				$fm = $this->cekFisik($idPersediaan);
				$cek .= $fm['cek'];
				$err .= $fm['err'];
				$content = $fm['content'];

				// $content = array(
				// 									'spanBerkurang' => "<input type='text' name='berkurang$idPersediaan' id='berkurang$idPersediaan' value='".$getDataCekFisik['berkurang']."' style='width:40px;text-align:right;' onkeyup=$this->Prefix.bantu('berkurang$idPersediaan','spanBerkurangBantu$idPersediaan',$idPersediaan)> <span id='spanBerkurangBantu$idPersediaan'></span>",
				// 									'spanBertambah' => "<input type='text' name='bertambah$idPersediaan' id='bertambah$idPersediaan' value='".$getDataCekFisik['bertambah']."' style='width:40px;text-align:right;'  onkeyup=$this->Prefix.bantu('bertambah$idPersediaan','spanBertambahBantu$idPersediaan',$idPersediaan)> <span id='spanBertambahBantu$idPersediaan'></span>",
				// 									'spanKeterangan' => "<input type='text' name='keterangan$idPersediaan' id='keterangan$idPersediaan' value='".$getDataCekFisik['keterangan']."' style='width:100%;'>",
				// 									'spanJumlah' => "<span id='spanJumlah$idPersediaan' style='text-align:right;'> <span>",
				// 									'spanAction' => "<span id='spanAction$idPersediaan' style='text-align:center;'><img src='datepicker/save.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.saveCekFisik($idPersediaan); >
				// 								 &nbsp <img src='datepicker/remove2.png' style='width:20px;height:20px;cursor:pointer;' onclick= 	$this->Prefix.refreshList(true); ><span>",
				// 							);
			break;
			}

			case 'Report':{
      foreach ($_REQUEST as $key => $value) {
         $$key = $value;
      }
      // if(empty($cmbUrusan)){
      //  $err = "Pilih Urusan";
      // }elseif(empty($cmbBidang)){
      //  $err = "Pilih Bidang";
      // }elseif(empty($cmbSKPD)){
      //  $err = "Pilih SKPD";
      // }else{
        if(mysql_num_rows(mysql_query("select * from skpd_report_rka_21 where username= '$this->username'")) == 0){
          $data = array(
              'c1' => $c1,
              'c' => $c,
              'd' => $d,
              'e' => $e,
              'e1' => $e1,
              'username' => $this->username
              );
          $query = VulnWalkerInsert('skpd_report_rka_21',$data);
          mysql_query($query);
        }else{
          $data = array(
              'c1' => $c1,
              'c' => $c,
              'd' => $d,
              'e' => $e,
              'e1' => $e1,
              'username' => $this->username
              );
          $query = VulnWalkerUpdate('skpd_report_rka_21',$data,"username = '$this->username'");
          mysql_query($query);
        }
        $content = array('to' => $jenisKegiatan, 'ttd' => $ttd, 'cetakjang' => $cetakjang );
      // }
    break;
    }

		// case 'Report':{
		// 	foreach ($_REQUEST as $key => $value) {
		// 	 	 $$key = $value;
		// 	}
		// 	if(empty($cmbUrusan)){
		// 		$err = "Pilih Urusan";
		// 	}elseif(empty($cmbBidang)){
		// 		$err = "Pilih Bidang";
		// 	}elseif(empty($cmbSKPD)){
		// 		$err = "Pilih SKPD";
		// 	}else{
		// 		if(mysql_num_rows(mysql_query("select * from skpd_report_rka_21 where username= '$this->username'")) == 0){
		// 			$data = array(
		// 						  'username' => $this->username,
		// 						  'c1' => $cmbUrusan,
		// 						  'c' => $cmbBidang,
		// 						  'd' => $cmbSKPD

		// 						  );
		// 			$query = VulnWalkerInsert('skpd_report_rka_21',$data);
		// 			mysql_query($query);
		// 		}else{
		// 			$data = array(
		// 						  'username' => $this->username,
		// 						  'c1' => $cmbUrusan,
		// 						  'c' => $cmbBidang,
		// 						  'd' => $cmbSKPD


		// 						  );
		// 			$query = VulnWalkerUpdate('skpd_report_rka_21',$data,"username = '$this->username'");
		// 			mysql_query($query);
		// 		}

		// 	}
		// break;
		// }
		case 'Laporan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 	$fm = $this->Laporan($_REQUEST);
						$cek .= $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
			break;
		}
		case 'Laporan2':{
			$json = FALSE;
			$this->Laporan2();
		break;
		}
		case 'Laporann':{
			$json = FALSE;
			$this->Laporann();
		break;
		}
		case 'saveCekFisik':{
			foreach ($_REQUEST as $key => $value) {
					$$key = $value;
			}
			// if(substr($tanggalCek, -4) !=$_COOKIE['coThnAnggaran']){
			// 		$err = "Tahun harus sama dengan tahun login";
			// }
			if($periode == '1'){
					$tanggalCheck = $_COOKIE['coThnAnggaran']."-06-30";
					$kondisiTanggalBuku = " and tanggal_buku = '".$tanggalCheck."'";
					$semesterPosting = "1";
			}elseif($periode == '2'){
					$tanggalCheck = $_COOKIE['coThnAnggaran']."-12-31";
					$kondisiTanggalBuku = " and tanggal_buku = '".$tanggalCheck."'";
					$semesterPosting = "2";
			}elseif($periode == '3'){
					$tanggalCheck = $_COOKIE['coThnAnggaran']."-12-31";
					$kondisiTanggalBuku = " and tanggal_buku = '".$tanggalCheck."'";
			}
			if(empty($jenisPersediaan)){
					$err = "Pilih hasil check fisik";
			}
			if($jenisPersediaan == '4'){
					$jnsCekFisik = "4";
					$jenisPersediaan = '1';
					$bertambah = $jumlahCheck;
			}elseif($jenisPersediaan == '5'){
					$jnsCekFisik = "5";
					$jenisPersediaan = '2';
					$berkurang = $jumlahCheck;
					$hargaSatuan = "0";
			}
			$getData = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '$idFisik'"));
			if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where  c1 ='".$getData['c1']."' and c ='".$getData['c']."' and d ='".$getData['d']."' and e ='".$getData['e']."' and e1 ='".$getData['e1']."' and f ='".$getData['f']."' and g ='".$getData['g']."' and h ='".$getData['h']."' and i ='".$getData['i']."' and j ='".$getData['j']."' and j1 ='".$getData['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '$semesterPosting' ")) != 0)
			{
				$err = "Data sudah di kunci !";
			}
			if(empty($err)){

				if(mysql_num_rows(mysql_query("select * from cek_fisik where id_persediaan = '$idFisik' and semester = '$periode'")) == 0){
					$dataCekFisik = array(
									'c1' => $getData['c1'],
									'c' => $getData['c'],
									'd' => $getData['d'],
									'e' => $getData['e'],
									'e1' => $getData['e1'],
									'f1' => $getData['f1'],
									'f2' => $getData['f2'],
									'f' => $getData['f'],
									'g' => $getData['g'],
									'h' => $getData['h'],
									'i' => $getData['i'],
									'j' => $getData['j'],
									'j1' => $getData['j1'],
									'berkurang' => $berkurang,
									'bertambah' => $bertambah,
									'keterangan' => $keterangan,
									'id_persediaan' => $idFisik,
									'tanggal_cek' => $tanggalCheck,
									'tahun' => $_COOKIE['coThnAnggaran'],
									'semester' => $periode,
									'harga_satuan' => $hargaSatuan
					);
					$query = VulnWalkerInsert("cek_fisik",$dataCekFisik);
					mysql_query($query);
					$dataKartuPersediaan = array(
									'c1' => $getData['c1'],
									'c' => $getData['c'],
									'd' => $getData['d'],
									'e' => $getData['e'],
									'e1' => $getData['e1'],
									'f1' => $getData['f1'],
									'f2' => $getData['f2'],
									'f' => $getData['f'],
									'g' => $getData['g'],
									'h' => $getData['h'],
									'i' => $getData['i'],
									'j' => $getData['j'],
									'j1' => $getData['j1'],
									'jumlah' => $jumlahCheck,
									'jns' => $jnsCekFisik,
									'jenis_persediaan' => $jenisPersediaan,
									'keterangan' => $keterangan,
									'tanggal_buku' => $tanggalCheck,
									'harga_satuan' => $hargaSatuan
					);
					$queryKartuPersediaan = VulnWalkerInsert("t_kartu_persediaan",$dataKartuPersediaan);
					mysql_query($queryKartuPersediaan);
					$cek = $queryKartuPersediaan;

				}else{
					$dataCekFisik = array(
									'berkurang' => $berkurang,
									'bertambah' => $bertambah,
									'keterangan' => $keterangan,
									'id_persediaan' => $idFisik,
									'harga_satuan' => $hargaSatuan
					);
					$query = VulnWalkerUpdate("cek_fisik",$dataCekFisik,"id_persediaan ='$idFisik' and semester = '$periode'");
					mysql_query($query);

					$dataKartuPersediaan = array(
									'jumlah' => $jumlahCheck,
									'jns' => $jnsCekFisik,
									'jenis_persediaan' => $jenisPersediaan,
									'jumlah' => $jumlahCheck,
									'keterangan' => $keterangan,
									'harga_satuan' => $hargaSatuan
					);
					$queryKartuPersediaan = VulnWalkerUpdate("t_kartu_persediaan",$dataKartuPersediaan,"c1 = '".$getData['c1']."' and c = '".$getData['c']."' and d = '".$getData['d']."' and e = '".$getData['e']."' and e1 = '".$getData['e1']."'  and f1 = '".$getData['f1']."' and f2 = '".$getData['f2']."' and f = '".$getData['f']."' and g = '".$getData['g']."' and h = '".$getData['h']."' and i = '".$getData['i']."' and j = '".$getData['j']."' and j1 = '".$getData['j1']."' and (jns = '4' or jns ='5') and (jenis_persediaan = '1' or jenis_persediaan = '2') $kondisiTanggalBuku");
					mysql_query($queryKartuPersediaan);
					$cek = $queryKartuPersediaan;
				}
			}

		break;
		}
		case 'Posting':{
				$idPosting = $_REQUEST[$this->Prefix.'_cb'];
				$fm = $this->Posting($idPosting[0]);
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}

		case 'Info':{
				$fm = $this->Info();
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'newTab':{
			foreach ($_REQUEST as $key => $value) {
					$$key = $value;
			}
			mysql_query("delete from temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from temp_detail_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_detail_rincian_distribusi where username = '$this->username'");
			$getDataMax = mysql_fetch_array(mysql_query("select max(nomor) from distribusi where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  "));
			$explodeNomor = explode('/',$getDataMax['max(nomor)']);
			$nomorTerakhir = $explodeNomor[0] + 1;
			$nomorPengeluaran = $this->kasihNol($nomorTerakhir );
			$nomor = $nomorPengeluaran."/"."D/".$c1.".".$c.".".$d.".".$e.".".$e1."/".$_COOKIE['coThnAnggaran'];

			$dataInsert = array(
								'c1' => $c1,
								'c' => $c,
								'd' => $d,
								'e' => $e,
								'e1' => $e1,
								'nomor' => $nomor,
								'status_temp' => "1",
								'tanggal' => date("Y-m-d"),
								'tanggal_buku' => date("Y-m-d"),
			);
			$query = VulnWalkerInsert($this->TblName,$dataInsert);
			mysql_query($query);
			$cek = $query;



			$content = array("nomor" => $nomor);

		break;
		}




		case 'editTab':{
			mysql_query("delete from temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from temp_detail_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_detail_rincian_distribusi where username = '$this->username'");
			$id = $_REQUEST['cekFisik_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$getDataDistribusi = mysql_fetch_array(mysql_query("select * from distribusi where id = '".$id[0]."'"));
			$kodeSKPD = $getDataDistribusi['c1'].".".$getDataDistribusi['c'].".".$getDataDistribusi['d'].".".$getDataDistribusi['e'].".".$getDataDistribusi['e1'];
			$nomor = $getDataDistribusi['nomor'];

			$getAllRincianDistribusi = mysql_query("select * from rincian_distribusi where id_distribusi ='".$id[0]."'");
			while ($rincianDistribusi = mysql_fetch_array($getAllRincianDistribusi)) {
				foreach ($rincianDistribusi as $key => $value) {
						$$key = $value;
				}
				$dataRincian = array(
										'f1' => $f1,
										'f2' => $f2,
										'f' => $f,
										'g' => $g,
										'h' => $h,
										'i' => $i,
										'j' => $j,
										'j1' => $j1,
										'jumlah' => $jumlah,
										'id_rincian_distribusi' => $rincianDistribusi['id'],
										'username' => $this->username
				);
				$query = VulnWalkerInsert('temp_rincian_distribusi',$dataRincian);
				mysql_query($query);
				$getIdTempRincianDistribusi = mysql_fetch_array(mysql_query("select max(id) from temp_rincian_distribusi where username = '$this->username'"));
				$getAllDetailRincianDistribusi = mysql_query("select * from detail_rincian_distribusi where id_rincian_distribusi = '".$rincianDistribusi['id']."'");
				while ($detailRincianDistribusi = mysql_fetch_array($getAllDetailRincianDistribusi)) {
						$dataDetailRincian = array(
								'c1' => $detailRincianDistribusi['c1'],
								'c' => $detailRincianDistribusi['c'],
								'd' => $detailRincianDistribusi['d'],
								'e' => $detailRincianDistribusi['e'],
								'e1' => $detailRincianDistribusi['e1'],
								'jumlah' => $detailRincianDistribusi['jumlah'],
								'id_rincian_distribusi' => $getIdTempRincianDistribusi['max(id)'],
								'id_detail_rincian_distribusi' => $detailRincianDistribusi['id'],
								'username' => $this->username
						);
						mysql_query(VulnWalkerInsert("temp_detail_rincian_distribusi",$dataDetailRincian));
				}

			}

				$content = array('skpd' => $kodeSKPD,'nomor'=> $nomor);
			break;
		}

		case 'Remove':{
			$id = $_REQUEST['cekFisik_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_CEK FISIK where id ='$id[0]'"));
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

			$getAll = mysql_query("select * from tabel_CEK FISIK where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and status_validasi !='1' order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rka_21 where user='$username'");
			mysql_query("delete from temp_rincian_volume_21 where user='$username'");
		    mysql_query("delete from temp_alokasi_rka_21_v2 where user='$username'");
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				}
				mysql_query("delete from tabel_CEK FISIK where id = '$id'");
				//mysql_query("delete from tabel_CEK FISIK where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and o1 ='$o1' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and jenis_rka='2.1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");

			}

			break;
		}

	    case 'Validasi':{
				$dt = array();
				$err='';
				$content='';
				$uid = $HTTP_COOKIE_VARS['coID'];

				$cbid = $_REQUEST[$this->Prefix.'_cb'];
				$idplh = $_REQUEST['id'];
				$this->form_idplh = $_REQUEST['id'];


					$qry = "SELECT * FROM tabel_CEK FISIK WHERE id = '$idplh' ";$cek=$qry;
					$aqry = mysql_query($qry);
					$dt = mysql_fetch_array($aqry);
					$username = $_COOKIE['coID'];
					$user_validasi = $dt['user_validasi'];
					$user_update = $dt['user_update'];

					if ($username != $user_validasi && $dt['status_validasi'] == '1') {
						$getNamaOrang = mysql_fetch_array(mysql_query("select * from admin where uid = '$user_validasi'"));
						$err = "Data Sudah di Validasi, Perubahan Hanya Bisa Dilakukan oleh ".$getNamaOrang['nama']." !";
					}else{
						if($username == $user_update){
							$err = "User yang membuat tidak dapat melakukan VALIDASI";
						}
					}
					if($this->jenisForm !='PENYUSUNAN')$err = "Tahap Penyusunan Telah Habis";
					if($err == ''){
						$fm = $this->Validasi($dt);
						$cek .= $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
					}



			break;
		}


		 case 'Catatan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			$getData = mysql_fetch_array(mysql_query("SELECT * FROM tabel_CEK FISIK WHERE id = '$idAwal'"));
			foreach ($getData as $key => $value) {
				  $$key = $value;
			}
			$getMaxID = mysql_fetch_array(mysql_query("select max(id) as maxID from tabel_CEK FISIK where tahun = '$tahun'  and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q' and jenis_anggaran = '$jenis_anggaran'  "));
			$maxID = $getMaxID['maxID'];
			$aqry = "select * from tabel_CEK FISIK where id ='$maxID' ";
			$dt = mysql_fetch_array(mysql_query($aqry));
			if($dt['id_tahap'] != $this->idTahap){
				$err = "Data Belum Di Koreksi ";
			}
			if($err == ''){
				$fm = $this->Catatan($dt);
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			}

		break;
		}

		case 'formAlokasi':{
				$dt[] = $_REQUEST['jumlahHarga'];
				$dt[] = $_REQUEST['id'];
				$fm = $this->formAlokasi($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}
		case 'formAlokasiTriwulan':{
				$jumlahHargaForm = $_REQUEST['jumlahHarga'];
				$id = $_REQUEST['id'];
				$fm = $this->formAlokasiTriwulan($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


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
			"";
}
   function setPage_OtherScript(){
		$scriptload =
					"<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();
						});
					</script>";
		return
			"
			<script src='js/skpd.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/persediaan/cekFisik/cekFisik.js' language='JavaScript' ></script>
			  <link rel='stylesheet' href='datepicker/jquery-ui.css'>
			  <script src='datepicker/jquery-1.12.4.js'></script>
			  <script src='datepicker/jquery-ui.js'></script>

			".
			$scriptload;
	}

	// function setFormBaru(){
	// 	$dt=array();
	// 	//$this->form_idplh ='';
	// 	$this->form_fmST = 0;
	// 	$dt['tgl'] = date("Y-m-d");
	// 	$fm = $this->setForm($dt);
	// 	return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	// }

  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		if($err == ''){
			$aqry = "SELECT * FROM  tabel_CEK FISIK WHERE id='".$this->form_idplh."' "; $cek.=$aqry;
			$dt = mysql_fetch_array(mysql_query($aqry));
			$fm = $this->setForm($dt);
		}

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
	function Info(){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 100;
	 $this->form_caption = 'INFO CEK FISIK';


	 if($this->jenisFormTerakhir == "VALIDASI"){
	 	$getJumlahSKPDYangMengisiPlafon = mysql_num_rows(mysql_query("select * from view_plafon where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$this->noUrutTerakhirPlafon' and d!='00' and status_validasi = '1' "));
	 }else{
	 	$getJumlahSKPDYangMengisiPlafon = mysql_num_rows(mysql_query("select * from view_plafon where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$this->noUrutTerakhirPlafon' and d!='00' "));
	 }



	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'ANGGARAN',
						'labelWidth'=>150,
						'value'=>$this->jenisAnggaran. " TAHUN  ". $this->tahun,
						 ),
			'2' => array(
						'label'=>'NAMA TAHAP TERAKHIR',
						'labelWidth'=>150,
						'value'=>$this->namaTahapTerakhir,
						 ),
			'3' => array(
						'label'=>'WAKTU',
						'labelWidth'=>150,
						'value'=>$this->masaTerakhir,
						 ),
			'4' => array(
						'label'=>'TAHAP SEKARANG',
						'labelWidth'=>150,
						'value'=>$this->currentTahap,
						 )


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){

		foreach ($_REQUEST as $key => $value) {
 		  			$$key = $value;
 	 }

		$headerTable =
		  "<thead>
		   <tr>
			 <th class='th01' width='20' rowspan='2'>NO</th>

		   <th class='th01' width='700'>NAMA BARANG</th>
		   <th class='th01' width='40'>SATUAN</th>
		   <th class='th01' width='50'>JUMLAH</th>
		   <th class='th01' width='50'>BERKURANG</th>
		   <th class='th01' width='50'>BERTAMBAH</th>
		   <th class='th01' width='50'>JUMLAH</th>
		   <th class='th01' width='200'>KETERANGAN</th>
		   <th class='th01' width='100'>AKSI</th>
		   </tr>


		   </thead>";


	 $NomorColSpan = $Mode==1? 2: 1;


		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
		  			$$key = $value;
	 }
	 foreach ($_REQUEST as $key => $value) {
					 $$key = $value;
	}


				$Koloms = array();
				$Koloms[] = array(' align="center"',$no);
				$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h ='$h' and i='$i' and j='$j' and j1='$j1'"));
				$Koloms[] = array(' align="left"',$getNamaBarang['nm_barang']);
				$Koloms[] = array(' align="left"',$getNamaBarang['satuan']);

				$saldoAwal = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '1' and jenis_persediaan = '1'"));
				$beli = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '2'"));
				$hibah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '3'"));
				$distribusiTambah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '3' and jenis_persediaan = '1'"));

				$keluar = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '6' and jenis_persediaan = '2'"));
				$distribusiKurang = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '7' and jenis_persediaan = '2'"));

				$jumlahAsal = ($saldoAwal['jumlah'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $distribusiTambah['sum(jumlah)']) - ($keluar['sum(jumlah)'] + $distribusiKurang['sum(jumlah)']);

				$Koloms[] = array(' align="right"',number_format($jumlahAsal,0,',','.')."<input type='hidden' id='asalJumlah$id' value='".$jumlahAsal."' >");

				if($filterPeriode == '1'){
						$maxFilter = $_COOKIE['coThnAnggaran']."06";
						$kondisiFilterPeriode = " and replace(left(tanggal_cek,6),'-','') <= '$maxFilter'";
				}elseif($filterPeriode == '2'){
						$minFilter = $_COOKIE['coThnAnggaran']."07";
						$maxFilter = $_COOKIE['coThnAnggaran']."12";
						$kondisiFilterPeriode = " and replace(left(tanggal_cek,6),'-','') >= '$minFilter' and replace(left(tanggal_cek,6),'-','') <= '$maxFilter'";
				}elseif($filterPeriode == '3'){
						$maxFilter = $_COOKIE['coThnAnggaran']."12";
						$kondisiFilterPeriode = " and replace(left(tanggal_cek,6),'-','') <= '$maxFilter'";
				}
				$getDataCekFisik = mysql_fetch_array(mysql_query("select * from cek_fisik where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' $kondisiFilterPeriode"));
				$Koloms[] = array(' align="right"',"<span id='spanBerkurang$id'>".number_format($getDataCekFisik['berkurang'],0,',','.')."</span> ");
				$Koloms[] = array(' align="right"',"<span id='spanBertambah$id'>".number_format($getDataCekFisik['bertambah'],0,',','.')."</span> ");
				$Koloms[] = array(' align="right"',"<span id='spanJumlah$id'>".number_format($jumlahAsal - $getDataCekFisik['berkurang'] + $getDataCekFisik['bertambah'],0,',','.')."</span> ");
				$Koloms[] = array(' align="left"',"<span id='spanKeterangan$id'>".$getDataCekFisik['keterangan']."</span> ");
				$Koloms[] = array(' align="center"',"<span id='spanAction$id'><img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.cekFisik($id); ></span> ");




	 return $Koloms;
	}
	function generateDate($tanggal){
			$tanggal = explode('-',$tanggal);
			$tanggal = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
			return $tanggal;
	}

	function Validasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI CEK FISIK 2.1';
	 $kode = $dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'].".".$dt['bk'].".".$dt['ck'].".".$dt['p'].".".$dt['q'].".".$dt['o1'];
	  if ($dt['status_validasi'] == '1') {
	  	//2017-03-30 17:12:16
		// $tglvalidnya = $dt['tgl_validasi'];
		// $thn1 = substr($tglvalidnya,0,4);
		// $bln1 = substr($tglvalidnya,5,2);
		// $tgl1 = substr($tglvalidnya,8,2);
		// $jam1 = substr($tglvalidnya,11,8);
		$arrayTanggalValidasi = explode("-", $dt['tanggal_validasi']);

		$tglvalid = $arrayTanggalValidasi[2]."-".$arrayTanggalValidasi[1]."-".$arrayTanggalValidasi[0];
		$username = $dt['user_validasi'];
		$checked = "checked='checked'";
	  }else{
		$tglvalid = date("d-m-Y");
		$checked = "";
		$username = $_COOKIE['coID'];
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);

	 //items ----------------------
	  $this->form_fields = array(
			'kode' => array(
						'label'=>'KODE',
						'labelWidth'=>100,
						'value'=>$kode,
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),
			'tgl_validasi' => array(
						'label'=>'TANGGAL',
						'labelWidth'=>100,
						'value'=>$tglvalid,
						'type'=>'text',
						'param'=>"style='width:125px;' readonly"
						 ),

			'username' => array(
						'label'=>'USERNAME',
						'labelWidth'=>100,
						'value'=>$username ,
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),
			'validasi' => array(
						'label'=>'VALIDASI DATA',
						'labelWidth'=>100,
						'value'=>"<input type='checkbox' name='validasi' $checked style='margin-left:-1px;' />",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveValid()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function Catatan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'CATATAN';
	 $catatan = $dt['catatan'];
	 $idnya = $dt['id'];

	 //items ----------------------
	  $this->form_fields = array(
			'catatan' => array(
						'label'=>'CATATAN',
						'labelWidth'=>100,
						'value'=>"<textarea id='catatan' name='catatan' style='width:100%; height : 100px;'>".$catatan."</textarea>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveCatatan($idnya)' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
	 }
	 $arrayPerhitungan = array(
		 				array('FISIK','FISIK'),
		 				array('HARGA','HARGA'),
	 );
	 $comboPerhitungan = cmbArray('filterPerhitungan',"FISIK",$arrayPerhitungan,'-- BULAN --',"onchange=$this->Prefix.refreshList(true); disabled");
	 $arrayPeriode = array(
		 				array('1','SEMESTER 1'),
		 				array('2','SEMESTER 2'),
		 				array('3','TAHUNAN'),
	 );
	 if(empty($filterPeriode))$filterPeriode ='1';
$comboPeriode = cmbArray('filterPeriode',$filterPeriode,$arrayPeriode,'-- PERHITUNGAN --',"onchange=$this->Prefix.refreshList(true);");
$jumlahData = $_REQUEST['jumlahData'];
if(empty($jumlahData))$jumlahData = 50;
if(empty($tanggalCek))$tanggalCek = "31-12-".$_COOKIE['coThnAnggaran'];
$cmbAkun = "0";
$cmbKelompok = "0";
$cmbJenis = "08";
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
						"
						 NAMA BARANG &nbsp &nbsp <input type='text' name='namaBarang' id='namaBarang' value='$namaBarang'> &nbsp &nbsp TAHUN &nbsp &nbsp <input type='text' value='".$_COOKIE['coThnAnggaran']."' style='width:40px;' readonly> &nbsp PERIODE : &nbsp $comboPeriode
						 "
				),'','','').
				genFilterBar(
					array(
						"JUMLAH DATA &nbsp &nbsp <input type='text' name ='jumlahData' id='jumlahData' value ='$jumlahData' style='width:40px;'>  &nbsp <input type='button' onclick =$this->Prefix.refreshList(true); value='Tampilkan'>"
				),'','','');



		return array('TampilOpt'=>$TampilOpt);


	}




	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------
		$arrKondisi = array();
		foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
		}
		$cmbAkun = "0";
		$cmbKelompok = "0";
		$cmbJenis = "08";
		if($cekFisikSKPD2fmURUSAN !='00'){
				$arrKondisi[] = "c1 = '$cekFisikSKPD2fmURUSAN'";
		}
		if($cekFisikSKPD2fmSKPD !='00'){
				$arrKondisi[] = "c = '$cekFisikSKPD2fmSKPD'";
		}
		if($cekFisikSKPD2fmUNIT !='00'){
				$arrKondisi[] = "d = '$cekFisikSKPD2fmUNIT'";
		}
		if($cekFisikSKPD2fmSUBUNIT !='00'){
				$arrKondisi[] = "e = '$cekFisikSKPD2fmSUBUNIT'";
		}
		if($cekFisikSKPD2fmSEKSI !='00'){
				$arrKondisi[] = "e1 = '$cekFisikSKPD2fmSEKSI'";
		}

		if(!empty($kodeBarang)){
				$arrKondisi[] = "concat(f,'.',g,'.',h,'.',i,'.',j,'.',j1) like '$kodeBarang%'";
		}
		if($filterPeriode == '1'){
				$maxFilter = $_COOKIE['coThnAnggaran']."06";
				$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
		}elseif($filterPeriode == '2'){
				$minFilter = $_COOKIE['coThnAnggaran']."07";
				$maxFilter = $_COOKIE['coThnAnggaran']."12";
				$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') >= '$minFilter' and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
		}elseif($filterPeriode == '3'){
				$maxFilter = $_COOKIE['coThnAnggaran']."12";
				$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
		}
		if(!empty($namaBarang)){
				$getBarangMatch = mysql_query("select * from ref_barang where nm_barang like'%$namaBarang%' and f ='08' and j1 !='0000'");
				while ($barangMatch = mysql_fetch_array($getBarangMatch)) {
							$concatExcept = $barangMatch['f'].".".$barangMatch['g'].".".$barangMatch['h'].".".$barangMatch['i'].".".$barangMatch['j'].".".$barangMatch['j1'];
							$arrayExcept[] = " concat(f,'.',g,'.',h,'.',i,'.',j,'.',j1) !='$concatExcept'";
				}
				$kondisiExcept = join(' and ',$arrayExcept);
				if(sizeof($arrayExcept) !=0){
					$kondisiExcept = " and ".$kondisiExcept;
				}

				$getBlockBarang = mysql_query("select * from ref_barang where f ='08' and j1!='0000' $kondisiExcept");
				while ($barangBlock = mysql_fetch_array($getBlockBarang)) {
							$concatBlock = $barangBlock['f'].".".$barangBlock['g'].".".$barangBlock['h'].".".$barangBlock['i'].".".$barangBlock['j'].".".$barangBlock['j1'];
							$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j,'.',j1) !='$concatBlock'";
				}
			//	$arrKondisi[] = "VulnWalker select * from ref_barang where nm_barang like='%$namaBarang%' and f ='08' and j1 !='0000' VulnWalker";
		}
		$arrKondisi[] = "left(tanggal_buku,4) = '".$_COOKIE['coThnAnggaran']."'";

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
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;
		$Kondisi = $Kondisi ." group by (concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1))" ;
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		$Order= join(',',$arrOrders);
		$OrderDefault = '';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

		if(empty($jumlahData))$jumlahData =50;
		$this->pagePerHal = $jumlahData;
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal );

	}

	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{


			$qy = "DELETE FROM $this->TblName_Hapus WHERE id='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);

		}
		return array('err'=>$err,'cek'=>$cek);
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

		if($this->jenisForm =="PENYUSUNAN" || $this->jenisForm =="VALIDASI" || $this->jenisFormTerakhir == "PENYUSUNAN" || $this->jenisFormTerakhir == "VALIDASI" ){
			$tergantung = "100";
		}else{
			$tergantung = "100";
		}
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

function Laporan2($xls =FALSE){
		global $Main;
		$getJenisReport7 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL7' "));
		$getJenisUkuran = $getJenisReport7['jenis'];
		if ($getJenisUkuran == 'L') {
			$trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
			$width = "33cm";
			$height = "21.5cm";
		}else{
			$trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
			$width = "21.5cm";
			$height = "33cm";
		}
		$arrayTandaTangan7 = explode(';', $getJenisReport7['tanda_tangan']);

		$this->fileNameExcel = "RKBMD PENGADAAN PROVINSI/KABUPATEN/KOTA";
		$align = "center";
		$xls = $_GET['xls'];
		$pisah = "<td width='1%' valign='top'> : </td>";
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$align = 'center';
			$pisah = "";
		}



		$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit]; $filterPeriode = $_GET[filterPeriode];
		$arrKondisi = array();

    if(!empty($c1) && $c1!="0" ){
      $this->kondisiSKPD = " and c1='$c1' ";
    }
    if(!empty($c) && $c!="00"){
      $this->kondisiSKPD = " and c1='$c1' and c='$c' ";
    }
    if(!empty($d) && $d!="00"){
      $this->kondisiSKPD = " and c1='$c1' and c='$c' and d='$d' ";
    }


    $arrKondisi[] = "id_jenis_pemeliharaan = '0'  and uraian_pemeliharaan != 'RKBMD PEMELIHARAAN' and uraian_pemeliharaan != 'RKBMD PERSEDIAAN' ";


    $getAllBarangFromRKBMD = mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap'  and j!='000' " );
    while($dataBarang = mysql_fetch_array($getAllBarangFromRKBMD)){
          if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' $this->kondisiBarang $this->kondisiSKPD and c1='".$dataBarang['c1']."' and c='".$dataBarang['c']."' and d='".$dataBarang['d']."' and ck='".$dataBarang['ck']."' and dk='".$dataBarang['dk']."'  and dk='".$dataBarang['dk']."' and p='".$dataBarang['p']."' and q='".$dataBarang['q']."' and f='".$dataBarang['f']."' and g='".$dataBarang['g']."' and h='".$dataBarang['h']."' and i='".$dataBarang['i']."' and j='".$dataBarang['j']."' and volume_barang !='0' and id_jenis_pemeliharaan = '0'")) == 0){
              $blackListBarang[] = "id_anggaran !='".$dataBarang['id_anggaran']."'";
              $arrKondisi[] = "id_anggaran !='".$dataBarang['id_anggaran']."'";

          }
    }
    $kondisiBlackListBarang= join(' and ',$blackListBarang);
    if(sizeof($blackListBarang) == 0){
      $kondisiBlackListBarang = "";
    }elseif(sizeof($blackListBarang) > 0){
      $kondisiBlackListBarang = " and ".$kondisiBlackListBarang;
    }

    $getAllKegiatan = mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' and j='000' and q!='0' ");
    while($dataKegiatan = mysql_fetch_array($getAllKegiatan)){
        if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap' $this->kondisiSKPD and c1='".$dataKegiatan['c1']."' and c='".$dataKegiatan['c']."' and d='".$dataKegiatan['d']."' and ck='".$dataKegiatan['ck']."' and bk='".$dataKegiatan['bk']."' and ck='".$dataKegiatan['ck']."' and dk='".$dataKegiatan['dk']."' and p='".$dataKegiatan['p']."' and q='".$dataKegiatan['q']."' and j!='000' $kondisiBlackListBarang ")) == 0){
            $blackListKegiatan[] = "id_anggaran !='".$dataKegiatan['id_anggaran']."'";
            $arrKondisi[] = "id_anggaran !='".$dataKegiatan['id_anggaran']."'";
        }
    }

    $kondisiBlackListKegiatan= join(' and ',$blackListKegiatan);
    if(sizeof($blackListKegiatan) == 0){
      $kondisiBlackListKegiatan = "";
    }elseif(sizeof($blackListKegiatan) > 0){
      $kondisiBlackListKegiatan = " and ".$kondisiBlackListKegiatan;
    }

    $getAllProgram = mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' and j='000' and p!='0' and q='0' ");
    while($dataProgram = mysql_fetch_array($getAllProgram)){
        if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap' $this->kondisiSKPD and c1='".$dataProgram['c1']."' and c='".$dataProgram['c']."' and d='".$dataProgram['d']."' and ck='".$dataProgram['ck']."' and bk='".$dataProgram['bk']."' and ck='".$dataProgram['ck']."' and dk='".$dataProgram['dk']."' and p='".$dataProgram['p']."'  and j!='000' $kondisiBlackListBarang ")) == 0){
            $blackListProgram[] = "id_anggaran !='".$dataProgram['id_anggaran']."'";
            $arrKondisi[] = "id_anggaran !='".$dataProgram['id_anggaran']."'";
        }
    }

    $kondisiBlackListProgram= join(' and ',$blackListProgram);
    if(sizeof($blackListProgram) == 0){
      $kondisiBlackListProgram = "";
    }elseif(sizeof($blackListProgram) > 0){
      $kondisiBlackListProgram = " and ".$kondisiBlackListProgram;
    }
    $getAllSKPD = mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' and j='000' and p='0' and q='0' ");
    while($dataSKPD = mysql_fetch_array($getAllSKPD)){

        if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap' $this->kondisiSKPD and c1='".$dataSKPD['c1']."' and c='".$dataSKPD['c']."' and d='".$dataSKPD['d']."'   and j!='000' $kondisiBlackListBarang ")) == 0){
            $arrKondisi[] = "id_anggaran !='".$dataSKPD['id_anggaran']."' ";
        }
    }

    $kondisiBlackListSKPD= join(' and ',$blackListSKPD);
    if(sizeof($blackListSKPD) == 0){
      $kondisiBlackListSKPD = "";
    }elseif(sizeof($blackListSKPD) > 0){
      $kondisiBlackListSKPD = " and ".$kondisiBlackListSKPD;
    }


    $arrKondisi[] = "id_tahap = '$this->idTahap'";
    $arrKondisi[] = "tahun = '$this->tahun'";
    $arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
    $arrKondisi[] = "f != '06' and f!='07' and f!='08'";


		$Kondisi= join(' and ',$arrKondisi);
		if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}
		$qry ="SELECT * from view_rkbmd where 1=1 $Kondisi group by c1,c,d,bk,ck,dk,p,q,f,g,h,i,j Order by concat(convert(c1 using utf8),'.',convert(c using utf8),'.',convert(d using utf8),'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',convert(f1 using utf8),'.',convert(f2 using utf8),'.',convert(f using utf8),'.',convert(g using utf8),'.',convert(h using utf8),'.',convert(i using utf8),'.',convert(j using utf8),'.',convert(right((100 + id_jenis_pemeliharaan),2) using utf8)) ASC";

		$aqry = mysql_query($qry);

		$namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));

		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo
			"<html>
			<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  		<link rel='stylesheet' type='text/css' href='css/pageNumber.css'>
  		<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
  		<script type='text/javascript' src='js/pageNumber.js'></script>
  		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
				"<head>
					<title>$Main->Judul</title>
					$css
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:15px;
							margin-bottom: 3%;

						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead { display: table-header-group; }
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width: 33cm; height: 21.5cm; font-family: sans-serif;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none;'>
								<tr>
									<td style='width: 10%; text-align: center;'>
										<img src='".getImageReport()."' style='
                      width: 102.08px;
                      height: 84.59;
                      max-height: 84.59;
                      max-width: 102.08px;
                    '>
									</td>
									<td style='text-align: center;'>
										<span style='font-size:18px;font-weight:bold;text-transform: uppercase; '>
											DAFTAR PERSEDIAAN BARANG<br>
											KOTA ".$namaPemda[option_value]."<br>
											<span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN ANGGARAN ".date(Y)." </span>
										</span>
									</td>
								</tr>
							</table>";
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='width:100%;'>
								<thead>
									<tr>
										<th class='th01' style='width:20px;' >NO</th>
										<th class='th01' >NAMA BARANG</th>
										<th class='th01' style='width: 4%;'>SATUAN</th>
										<th class='th01' style='width: 4%;'>JUMLAH</th>
										<th class='th01' style='width: 4%;'>BERKURANG</th>
										<th class='th01' style='width: 4%;'>BERTAMBAH</th>
										<th class='th01' style='width: 4%;'>JUMLAH</th>
										<th class='th01' style='width: 6%;'>KETERANGAN</th>
								</thead>

		";
		$arrayPenggunaBarang = array();
		$arrayExcept = array();
		$no = 1;

				if($filterPeriode == '1'){
						$maxFilter = $_COOKIE['coThnAnggaran']."06";
						$filterPeriode = " and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				}elseif($filterPeriode == '2'){
						$minFilter = $_COOKIE['coThnAnggaran']."07";
						$maxFilter = $_COOKIE['coThnAnggaran']."12";
						$filterPeriode = " and replace(left(tanggal_buku,6),'-','') >= '$minFilter' and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				}elseif($filterPeriode == '3'){
						$maxFilter = $_COOKIE['coThnAnggaran']."12";
						$filterPeriode = " and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				}

		$queryKartuPersediaan = mysql_query("SELECT * from t_kartu_persediaan where c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' $filterPeriode group by (concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1))");
		while($dataKartuPersediaan = mysql_fetch_array($queryKartuPersediaan)){

			$queryRefBarang = mysql_fetch_array(mysql_query("SELECT * from ref_barang where f1 = ".$dataKartuPersediaan[f1]." and f2 = ".$dataKartuPersediaan[f2]." and f = ".$dataKartuPersediaan[f]." and g = ".$dataKartuPersediaan[g]." and h = ".$dataKartuPersediaan[h]." and i = ".$dataKartuPersediaan[i]." and j = ".$dataKartuPersediaan[j]." and j1 = ".$dataKartuPersediaan[j1]." "));

			$saldoAwal = mysql_fetch_array(mysql_query("SELECT * from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1 = ".$dataKartuPersediaan[f1]." and f2 = ".$dataKartuPersediaan[f2]." and f = ".$dataKartuPersediaan[f]." and g = ".$dataKartuPersediaan[g]." and h = ".$dataKartuPersediaan[h]." and i = ".$dataKartuPersediaan[i]." and j = ".$dataKartuPersediaan[j]." and j1 = ".$dataKartuPersediaan[j1]." and jns = '1' and jenis_persediaan = '1'"));

			$beli = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' and f = ".$dataKartuPersediaan[f]." and g = ".$dataKartuPersediaan[g]." and h = ".$dataKartuPersediaan[h]." and i = ".$dataKartuPersediaan[i]." and j = ".$dataKartuPersediaan[j]." and j1 = ".$dataKartuPersediaan[j1]." and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '2'"));

			$hibah = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1=".$dataKartuPersediaan[f1]." and f2=".$dataKartuPersediaan[f2]." and f=".$dataKartuPersediaan[f]." and g=".$dataKartuPersediaan[g]." and h=".$dataKartuPersediaan[h]." and i=".$dataKartuPersediaan[i]." and j=".$dataKartuPersediaan[j]." and j1=".$dataKartuPersediaan[j1]." and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '3'"));

			$distribusiTambah = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1 = ".$dataKartuPersediaan[f1]." and f2 = ".$dataKartuPersediaan[f2]." and f = ".$dataKartuPersediaan[f]." and g = ".$dataKartuPersediaan[g]." and h = ".$dataKartuPersediaan[h]." and i = ".$dataKartuPersediaan[i]." and j = ".$dataKartuPersediaan[j]." and j1 = ".$dataKartuPersediaan[j1]." and jns = '3' and jenis_persediaan = '1'"));

			$keluar = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1=".$dataKartuPersediaan[f1]." and f2=".$dataKartuPersediaan[f2]." and f=".$dataKartuPersediaan[f]." and g=".$dataKartuPersediaan[g]." and h=".$dataKartuPersediaan[h]." and i=".$dataKartuPersediaan[i]." and j=".$dataKartuPersediaan[j]." and j1=".$dataKartuPersediaan[j1]." and jns = '6' and jenis_persediaan = '2'"));

			$distribusiKurang = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1 = ".$dataKartuPersediaan[f1]." and f2 = ".$dataKartuPersediaan[f2]." and f = ".$dataKartuPersediaan[f]." and g = ".$dataKartuPersediaan[g]." and h = ".$dataKartuPersediaan[h]." and i = ".$dataKartuPersediaan[i]." and j = ".$dataKartuPersediaan[j]." and j1 = ".$dataKartuPersediaan[j1]." and jns = '7' and jenis_persediaan = '2'"));

			$jumlahAsal = ($saldoAwal['jumlah'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $distribusiTambah['sum(jumlah)']) - ($keluar['sum(jumlah)'] + $distribusiKurang['sum(jumlah)']);

			if($filterPeriode == '1'){
						$maxFilter = $_COOKIE['coThnAnggaran']."06";
						$kondisiFilterPeriode = " and replace(left(tanggal_cek,6),'-','') <= '$maxFilter'";
				}elseif($filterPeriode == '2'){
						$minFilter = $_COOKIE['coThnAnggaran']."07";
						$maxFilter = $_COOKIE['coThnAnggaran']."12";
						$kondisiFilterPeriode = " and replace(left(tanggal_cek,6),'-','') >= '$minFilter' and replace(left(tanggal_cek,6),'-','') <= '$maxFilter'";
				}elseif($filterPeriode == '3'){
						$maxFilter = $_COOKIE['coThnAnggaran']."12";
						$kondisiFilterPeriode = " and replace(left(tanggal_cek,6),'-','') <= '$maxFilter'";
				}

			$getDataCekFisik = mysql_fetch_array(mysql_query("SELECT * from cek_fisik where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1 = ".$dataKartuPersediaan[f1]." and f2 = ".$dataKartuPersediaan[f2]." and f = ".$dataKartuPersediaan[f]." and g = ".$dataKartuPersediaan[g]." and h = ".$dataKartuPersediaan[h]." and i = ".$dataKartuPersediaan[i]." and j = ".$dataKartuPersediaan[j]." and j1 = ".$dataKartuPersediaan[j1]." $kondisiFilterPeriode"));

			$cekFisikTambah = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1=".$dataKartuPersediaan[f1]." and f2=".$dataKartuPersediaan[f2]." and f=".$dataKartuPersediaan[f]." and g=".$dataKartuPersediaan[g]." and h=".$dataKartuPersediaan[h]." and i=".$dataKartuPersediaan[i]." and j=".$dataKartuPersediaan[j]." and j1=".$dataKartuPersediaan[j1]." and jns = '4' and jenis_persediaan = '1'"));

			$distribusi = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1=".$dataKartuPersediaan[f1]." and f2=".$dataKartuPersediaan[f2]." and f=".$dataKartuPersediaan[f]." and g=".$dataKartuPersediaan[g]." and h=".$dataKartuPersediaan[h]." and i=".$dataKartuPersediaan[i]." and j=".$dataKartuPersediaan[j]." and j1=".$dataKartuPersediaan[j1]." and jns = '7' and jenis_persediaan = '2'"));

			$cekfisiKurang = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1=".$dataKartuPersediaan[f1]." and f2=".$dataKartuPersediaan[f2]." and f=".$dataKartuPersediaan[f]." and g=".$dataKartuPersediaan[g]." and h=".$dataKartuPersediaan[h]." and i=".$dataKartuPersediaan[i]." and j=".$dataKartuPersediaan[j]." and j1=".$dataKartuPersediaan[j1]." and jns = '5' and jenis_persediaan = '2'"));

			echo "
				<tr>
					<td class='GarisCetak' align='center'>".$no."</td>
					<td class='GarisCetak'>".$queryRefBarang[nm_barang]."</td>
					<td class='GarisCetak'>".$queryRefBarang[satuan]."</td>
					<td class='GarisCetak' align='right'>".number_format($jumlahAsal,0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format($getDataCekFisik['berkurang'],0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format($getDataCekFisik['bertambah'],0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format($jumlahAsal - $getDataCekFisik['berkurang'] + $getDataCekFisik['bertambah'],0,',','.')."</td>
					<td class='GarisCetak' align='right'>".$getDataCekFisik[keterangan]."</td>
				</tr>
			";


			$no++;
		}
		
		echo 				"</table>";

		if($xls){
			echo
						"<br><div class='ukurantulisan' align='right'>
						<table align='right'>
						<tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."
						</td>
						</tr>
						<tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						Pengelola Barang
						</td>
						</tr>
						<tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						&nbsp
						</td>
						</tr><tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						&nbsp
						</td>
						</tr><tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						&nbsp
						</td>
						</tr>
						<tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						<u>$this->pengelolaBarang</u>
						</td>
						</tr><tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						NIP	$this->nipPengelola
						</td>
						</tr>





						</table>
						</div>
				</body>
			</html>";
		}else{
			if (sizeof($arrayTandaTangan7)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport7['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '3' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '23' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '3' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $hmm[jabatan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$hmm['nama']."</u><br>
            NIP ".$hmm['nip']."


            </div>";

          }elseif (sizeof($arrayTandaTangan7)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport7['posisi']);
            $panjangArrayPosisi = sizeof($arrayPosisi);
            $kategoriKanan = $arrayPosisi[$panjangArrayPosisi-1];
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-3];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKanan' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $queryNama2 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKiri' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKanan' "));
            $queryKategori2 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKiri' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$_GET['kota'].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $queryKategori1[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama1['nama']."</u><br>
            NIP ".$queryNama1['nip']."


            </div>

            <div class='ukurantulisan' style ='float:left; text-align:center;'>
            $queryKategori2[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama2['nama']."</u><br>
            NIP ".$queryNama2['nip']."


            </div>";

          }elseif (sizeof($arrayTandaTangan7)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport7['posisi']);
            $panjangArrayPosisi = sizeof($arrayPosisi);
            $kategoriKanan = $arrayPosisi[$panjangArrayPosisi-1];
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-3];
            $kategoriTengah = $arrayPosisi[$panjangArrayPosisi-2];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKanan' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $queryNama2 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKiri' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $queryNama3 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandangan = '$kategoriTengah' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKanan' "));
            $queryKategori2 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKiri' "));
            $queryKategori3 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriTengah' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$_GET['kota'].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $queryKategori1[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama1['nama']."</u><br>
            NIP ".$queryNama1['nip']."


            </div>

            <div class='ukurantulisan' style ='float:left; text-align:center;'>
            $queryKategori2[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama2['nama']."</u><br>
            NIP ".$queryNama2['nip']."


            </div>

            <div class='ukurantulisan' style ='float:right; text-align:center; position: relative; left: -25%;'>
            $queryKategori3[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama3['nama']."</u><br>
            NIP ".$queryNama3['nip']."


            </div>";

          }
			echo
						"
						".$tandaTanganna."
						<!-- <h5 class='pag pag1'>
							<span style='bottom: -10px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
						</h5>
  					<div class='insert'></div> -->
				</body>
			</html>";
		}
}

function Laporan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 350;
	 $this->form_height = 100;
	 $this->form_caption = 'LAPORAN RKBMD PENGADAAN';

	 $c1 = $dt['cekFisikSKPD2fmURUSAN'];
	 $c = $dt['cekFisikSKPD2fmSKPD'];
	 $d = $dt['cekFisikSKPD2fmUNIT'];
	 $e = $dt['cekFisikSKPD2fmSUBUNIT'];
	 $e1 = $dt['cekFisikSKPD2fmSEKSI'];

	 	$arrayJenisLaporan = array(
							   array('Laporan2', 'DAFTAR CEK FISIK BARANG'),

							   );

	  $cmbJenisLaporan = cmbArray('jenisKegiatan','',$arrayJenisLaporan,'-- JENIS LAPORAN --',"onchange = $this->Prefix.jenisChanged();");
	  $this->form_fields = array(
			'jenisLaporan' => array(
						'label'=>'JENIS LAPORAN',
						'labelWidth'=>100,
						'value'=> $cmbJenisLaporan
						 ),
			'Cetakjang' => array(
									'label'=>'TANGGAL CETAK',
									'labelWiidth'=>100,
									'value'=>"<input type='date' name='cetakjang' id='cetakjang' value='".date('Y-m-d')."'>
									",
								),
			'ttd' => array(
                  'label'=>'TTD',
                  'labelWiidth'=>100,
                  'value'=>cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = 23 and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' ",'onchange=rka.refreshList(true);','-- TTD --'),

                ),

			);
		//tombol
		$this->form_menubawah =
			"
      <input type='button' value='TTD' onclick ='".$this->Prefix.".Baru()' title='TTD' >
			<input type='button' value='View' onclick ='".$this->Prefix.".Report()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='cekFisik.Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
function Laporann($xls =FALSE){
		global $Main;



		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}



		$arrKondisi = array();
		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rka_21 where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) {
				  $$key = $value;
			}
		$cmbUrusan = $c1;
		$cmbBidang = $c;
		$cmbSKPD = $d;
		$cmbUnit = $e;
		$cmbSubUnit = $e1;

		if($cmbSubUnit != ''){
			$arrKondisi[] = "c1 = '$cmbUrusan'";
			$arrKondisi[] = "c = '$cmbBidang'";
			$arrKondisi[] = "d = '$cmbSKPD'";
			$arrKondisi[] = "e = '$cmbUnit'";
			$arrKondisi[] = "e1 = '$cmbSubUnit'";
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";


			}elseif($cmbUnit != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$arrKondisi[] = "e = '$cmbUnit'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
			}elseif($cmbSKPD != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
			}elseif($cmbBidang != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
			}elseif($cmbUrusan != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$kondisiSKPD = "and c1='$cmbUrusan'";
			}
		$arrKondisi[] = "c1 != '0'";
		if($this->jenisForm == 'PENYUSUNAN'){
			$getAllParent = mysql_query("select * from tabel_CEK FISIK where id_tahap ='$this->idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) {
			 	 $$key = $value;
				}
				$cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where o1 = '$o1' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id' ";
					$getAllRekening = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$this->idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
					while($row2s = mysql_fetch_array($getAllRekening)){
						foreach ($row2s as $key => $value) {
					 	 $$key = $value;
						}
						$cekRekening = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id'  ";


						}
					}
				}
			}


				$grabNonMapingRekening= mysql_query("select * from tabel_CEK FISIK where id_tahap ='$this->idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id ='".$got['id']."'";
					}

				}
				$grabNonHostedRekening= mysql_query("select * from tabel_CEK FISIK where id_tahap ='$this->idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id ='".$got['id']."'";
					}

				}


			$arrKondisi[] = "id_tahap = '$this->idTahap' ";

		}elseif($this->jenisForm == 'KOREKSI'){
			$nomorUrutSebelumnya = $this->nomorUrut;
			$getRApbd = mysql_fetch_array(mysql_query("select * from tabel_CEK FISIK where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
				$nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;
			}
			$getLastTahap = mysql_fetch_array(mysql_query("select * from tabel_CEK FISIK where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			$blackList = "";
			if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
				$getAllChild = mysql_query("select * from tabel_CEK FISIK where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");
				while($black = mysql_fetch_array($getAllChild)){
					$blackList .= " and id !='".$black['id']."'";
				}
			}

			$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
			$idTahap = $getIDTahap['id_tahap'];
			$getAllParent = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) {
			 	 $$key = $value;
				}
				$cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id' ";
					$getAllRekening = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
					while($row2s = mysql_fetch_array($getAllRekening)){
						foreach ($row2s as $key => $value) {
					 	 $$key = $value;
						}
						$cekRekening = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'  ";
							$getAllProgram = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
							while($row3s = mysql_fetch_array($getAllProgram)){
								foreach ($row3s as $key => $value) {
							 	 $$key = $value;
								}
								$cekProgram = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
								if($cekProgram == 0){
									$concat = $bk.".".$ck.".".$p;
									$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
								}else{
									$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'   ";
									$getAllKegiatan = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
									while($row4s = mysql_fetch_array($getAllKegiatan)){
										foreach ($row4s as $key => $value) {
									 	 $$key = $value;
										}
										$cekKegiatan = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
										if($cekKegiatan == 0){
											$concat = $bk.".".$ck.".".$p;
											$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
										}else{
											$arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id'   ";


										}
									}

								}
							}

						}
					}
				}
			}


				$grabNonMapingRekening= mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
					}

				}

				$grabNonHostedRekening= mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
					}

				}





			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";


		}else{
			if($this->jenisFormTerakhir == "KOREKSI"){
				$nomorUrutSebelumnya = $this->urutTerakhir;
				$getRApbd = mysql_fetch_array(mysql_query("select * from tabel_CEK FISIK where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
				if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
					$nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;
				}
				$getLastTahap = mysql_fetch_array(mysql_query("select * from tabel_CEK FISIK where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				$blackList = "";
				if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
					$getAllChild = mysql_query("select * from tabel_CEK FISIK where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");
					while($black = mysql_fetch_array($getAllChild)){
						$blackList .= " and id !='".$black['id']."'";
					}
				}

				$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id' ";
						$getAllRekening = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
						while($row2s = mysql_fetch_array($getAllRekening)){
							foreach ($row2s as $key => $value) {
						 	 $$key = $value;
							}
							$cekRekening = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'  ";
								$getAllProgram = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
								while($row3s = mysql_fetch_array($getAllProgram)){
									foreach ($row3s as $key => $value) {
								 	 $$key = $value;
									}
									$cekProgram = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'   ";
										$getAllKegiatan = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
										while($row4s = mysql_fetch_array($getAllKegiatan)){
											foreach ($row4s as $key => $value) {
										 	 $$key = $value;
											}
											$cekKegiatan = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
											if($cekKegiatan == 0){
												$concat = $bk.".".$ck.".".$p;
												$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
											}else{
												$arrKondisi[] = " id_tahap='$idTahap'  or id = '$id'   ";


											}
										}

									}
								}

							}
						}
					}
				}


					$grabNonMapingRekening= mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
					while($got = mysql_fetch_array($grabNonMapingRekening)){
						if(mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
						}

					}

					$grabNonHostedRekening= mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
					while($got = mysql_fetch_array($grabNonHostedRekening)){
						if(mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
						}

					}





				$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
				$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = mysql_query("select * from tabel_CEK FISIK where id_tahap ='$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where o1 = '$o1' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap='$idTahap'  or id = '$id' ";
						$getAllRekening = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
						while($row2s = mysql_fetch_array($getAllRekening)){
							foreach ($row2s as $key => $value) {
						 	 $$key = $value;
							}
							$cekRekening = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap='$idTahap'  or id = '$id'  ";
								$getAllProgram = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
								while($row3s = mysql_fetch_array($getAllProgram)){
									foreach ($row3s as $key => $value) {
								 	 $$key = $value;
									}
									$cekProgram = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where bk ='$bk' and ck='$ck' and p='$p' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap='$idTahap'  or id = '$id'   ";
										$getAllKegiatan = mysql_query("select * from tabel_CEK FISIK where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
										while($row4s = mysql_fetch_array($getAllKegiatan)){
											foreach ($row4s as $key => $value) {
										 	 $$key = $value;
											}
											$cekKegiatan = mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
											if($cekKegiatan == 0){
												$concat = $bk.".".$ck.".".$p;
												$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
											}else{
												$arrKondisi[] = " id_tahap='$idTahap'  or id = '$id'   ";


											}
										}

									}
								}

							}
						}
					}
				}


				$grabNonMapingRekening= mysql_query("select * from tabel_CEK FISIK where id_tahap ='$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
					}

				}

				$grabNonHostedRekening= mysql_query("select * from tabel_CEK FISIK where id_tahap ='$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_CEK FISIK where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
					}

				}



				$arrKondisi[] = "id_tahap = '$idTahap' ";
			}
		}






		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";

		$Kondisi= join(' and ',$arrKondisi);
		/*if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}*/
		$qry ="select * from tabel_CEK FISIK where $Kondisi ";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];

		$getUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='00'"));
		$urusan = $getUrusan['nm_skpd'];
		$getBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='00'"));
		$bidang = $getBidang['nm_skpd'];
		$getSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='00'"));
		$skpd = $getSKPD['nm_skpd'];
		$getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' "));
		$subUnit = $getSubUnit['nm_skpd'];
		$getProgram = mysql_fetch_array(mysql_query("select * from ref_program where bk='$hublaBK' and ck='$hublaCK' and dk='0' and p='$hublaP' and q='0'"));
		$program = $getProgram['nama'];
		$getKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$hublaBK' and ck='$hublaCK' and dk='0' and p='$hublaP' and q='$hublaQ'"));
		$kegiatan = $getKegiatan['nama'];


		//

		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:17px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: '>
					RENCANA KERJA DAN ANGGARAN<br>
					SATUAN KERJA PERANGKAT DAERAH
				</span><br>
				<span style='font-size:14px;font-weight:text-decoration: '>
					PROVINSI/Kabupaten/Kota $this->kota<br>
					Tahun Anggaran $this->tahun
					<br>
				</span><br>
				<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='15%' valign='top'>URUSAN PEMERINTAHAN</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.". </td>
						<td valign='top'>$urusan</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>BIDANG</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.". </td>
						<td valign='top'>$bidang</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.".".$cmbSKPD.". </td>
						<td valign='top'>$skpd</td>
					</tr>




				</table>

				<br>


				";
		echo "
				<span style='font-size:16px;font-weight:bold;text-decoration: '>
					Rincian Anggaran Pendapatan Tidak Langsung Satuan Kerja Perangkat Daerah
				</span><br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='2' colspan='5' >KODE REKENING</th>
										<th class='th01' rowspan='2' >URAIAN</th>
										<th class='th02' rowspan='1' colspan='3' >Rincian Perhitungan</th>
										<th class='th01' rowspan='2' >JUMLAH (Rp)</th>

									</tr>
									<tr>
										<th class='th01' >VOLUME</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >HARGA SATUAN</th>
									</tr>


		";
		$getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_CEK FISIK where $Kondisi  "));
		$total = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}
			$kondisiFilter = "and no_urut = '$this->urutTerakhir' and tahun  ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'";
			if($k == '0' && $n =='0' ){
				$k = "";
				$l = "";
			    $m = "";
				$n = "";
				$o = "";
				$this->publicVar += 1;
				$getPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1' "));
				$uraian = "<span style='font-weight:bold;'>$this->publicVar.". $getPekerjaan['nama_pekerjaan'] . "</span>";
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_CEK FISIK where  o1 ='$o1' $kondisiSKPD $kondisiFilter  "));
				$jumlah_harga = "<span style='font-weight:bold;'>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.') . "</span>";


			}elseif($c1 == '0'){
				$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
				$jarak = "0px";
				if($o1 !='0' && $o1 !='')$jarak = "10px";
				$uraian = "<span style='font-weight:bold;margin-left:$jarak;'>".$getNamaRekening['nm_rekening']."</b>";
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_CEK FISIK where  k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'  $kondisiSKPD $kondisiFilter"));
				$jumlah_harga = "<b>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.');
			}else{
				$k = "";
				$l = "";
			    $m = "";
				$n = "";
				$o = "";
				if($j != '000'){
					$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
					$uraian = "<span style='margin-left:20px;'> ". $getNamaBarang['nm_barang'] . "</span>";
				}else{
					$uraian = "<span style='margin-left:20px;'> ". $rincian_perhitungan . "</span>";
				}
				$jumlah = number_format($jumlah,2,',','.');
				$jumlah_harga = number_format($jumlah_harga,2,',','.');
				$volume_rek = number_format($volume_rek,0,',','.');

			}

			echo "
								<tr valign='top'>
									<td align='center' class='GarisCetak' >".$k."</td>
									<td align='center' class='GarisCetak' >".$l."</td>
									<td align='center' class='GarisCetak' >".$m."</td>
									<td align='center' class='GarisCetak' >".$n."</td>
									<td align='center' class='GarisCetak' >".$o."</td>
									<td align='left' class='GarisCetak' >".$uraian."</td>
									<td align='right' class='GarisCetak' >".$volume_rek."</td>
									<td align='left' class='GarisCetak'>$satuan_rek</td>
									<td align='right' class='GarisCetak' >".$jumlah."</td>
									<td align='right' class='GarisCetak' >".$jumlah_harga."</td>
								</tr>
			";
			$no++;




		}
		echo 				"<tr valign='top'>
									<td align='right' colspan='9' class='GarisCetak'>Jumlah</td>
									<td align='right' class='GarisCetak' ><b>".$total."</b></td>

								</tr>
							 </table>";
		$getDataPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGGUNA' "));

		echo
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						Kepala SKPD
						<br>
						<br>
						<br>
						<br>
						<br>

						<u>".$getDataPenggunaBarang['nama']."</u><br>
						NIP	".$getDataPenggunaBarang['nip']."


						</div>
			</body>
		</html>";
	}

	function Posting($idPosting){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 350;
	 $this->form_height = 80;

		$this->form_caption = 'Posting';
		$getData = mysql_fetch_array(mysql_query("select * from distribusi where id = '$idPosting'"));
		if($getData['status_posting'] == 1){
			$statusPosting = "checked";
		}
		$nomorPengeluaran = $getData['nomor'];

	 //items ----------------------
	  $this->form_fields = array(
	  	'kode0' => array(
					'label'=>'NOMOR CEK FISIK',
				'labelWidth'=>150,
				'value'=> $nomorPengeluaran
				 ),

			'kode12' => array(
						'label'=>'STATUS POSTING',
						'labelWidth'=>150,
						'value'=> "<input type='checkbox' name='statusPosting' id='statusPosting' $statusPosting>"
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".savePosting($idPosting)' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

function formAlokasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $jumlahHargaForm = $_REQUEST['jumlahHarga'];
	 $id = $_REQUEST['id'];
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );


	 $jenisAlokasi = $jenis_alokasi_kas;
	 $resultPenjumlahan = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nop + $des;
	 if(empty($jenisPerhitungan))$jenisPerhitungan = "MANUAL";
	 if(empty($jan))$jan="0";
	 if(empty($feb))$feb="0";
	 if(empty($mar))$mar="0";
	 if(empty($apr))$apr="0";
	 if(empty($mei))$mei="0";
	 if(empty($jun))$jun="0";
	 if(empty($jul))$jul="0";
	 if(empty($agu))$agu="0";
	 if(empty($sep))$sep="0";
	 if(empty($okt))$okt="0";
	 if(empty($nop))$nop="0";
	 if(empty($des))$des="0";
	 $selisih = $jumlahHargaForm - $resultPenjumlahan;
	 if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','BULANAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged($id);") ;
	 $cmbJenisPerhitungan = cmbArray('jenisPerhitungan',$jenisPerhitungan,$arrayJenisPerhitungan,'-- JENIS PERHITUNGAN --',"onchange=$this->Prefix.jenisPerhitunganChanged();") ;
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'JUMLAH HARGA ',
						'labelWidth'=>150,
						'value'=>"<input type='hidden' name='jumlahHargaForm' id ='jumlahHargaForm'  value='$jumlahHargaForm'>
						<input type='text' value='Rp. ".number_format($jumlahHargaForm,2,',','.')."' readonly style='width:210px;'> ",
						 ),
			'2' => array(
						'label'=>'JENIS ALOKASI',
						'labelWidth'=>150,
						'value'=>$cmbJenisAlokasi,
						 ),
			'3' => array(
						'label'=>'SISTEM PERHITUNGAN',
						'labelWidth'=>150,
						'value'=>$cmbJenisPerhitungan." &nbsp <button type='button' id='buttonHitung' onclick='$this->Prefix.hitung();' disabled >HITUNG</button> ",
						 ),
			'4' => array(
						'label'=>'JANUARI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jan' id='jan' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$jan' onkeyup=$this->Prefix.hitungSelisih('bantuJan'); > &nbsp <span id='bantuJan' style='color:red;'>".number_format($jan ,2,',','.')."</span> ",

						 ),
			'5' => array(
						'label'=>'FEBRUARI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='feb' id='feb' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$feb' onkeyup=$this->Prefix.hitungSelisih('bantuFeb'); > &nbsp <span id='bantuFeb' style='color:red;'>".number_format($feb ,2,',','.')."</span> ",

						 ),
			'6' => array(
						'label'=>'MARET',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='mar' id='mar' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mar' onkeyup=$this->Prefix.hitungSelisih('bantuMar');> &nbsp <span id='bantuMar' style='color:red;'>".number_format($mar ,2,',','.')."</span> ",

						 ),
			'7' => array(
						'label'=>'APRIL',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='apr' id='apr' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$apr' onkeyup=$this->Prefix.hitungSelisih('bantuApr');> &nbsp <span id='bantuApr' style='color:red;'>".number_format($apr ,2,',','.')."</span> ",

						 ),
			'22' => array(
						'label'=>'MEI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='mei' id='mei' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mei' onkeyup=$this->Prefix.hitungSelisih('bantuMei');> &nbsp <span id='bantuMei' style='color:red;'>".number_format($mei ,2,',','.')."</span> ",

						 ),
			'8' => array(
						'label'=>'JUNI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jun' id='jun' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jun' onkeyup=$this->Prefix.hitungSelisih('bantuJun');> &nbsp <span id='bantuJun' style='color:red;'>".number_format($jun ,2,',','.')."</span> ",

						 ),
			'9' => array(
						'label'=>'JULI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jul' id='jul' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jul' onkeyup=$this->Prefix.hitungSelisih('bantuJul');> &nbsp <span id='bantuJul' style='color:red;'>".number_format($jul,2,',','.')."</span> ",

						 ),
			'10' => array(
						'label'=>'AGUSTUS',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='agu' id='agu' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$agu' onkeyup=$this->Prefix.hitungSelisih('bantuAgu');> &nbsp <span id='bantuAgu' style='color:red;'>".number_format($agu ,2,',','.')."</span> ",

						 ),

			'11' => array(
						'label'=>'SEPTEMBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='sep' id='sep'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$sep' onkeyup=$this->Prefix.hitungSelisih('bantuSep');> &nbsp <span id='bantuSep' style='color:red;'>".number_format($sep ,2,',','.')."</span> ",

						 ),
			'12' => array(
						'label'=>'OKTOBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='okt' id='okt' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$okt' onkeyup=$this->Prefix.hitungSelisih('bantuOkt');> &nbsp <span id='bantuOkt' style='color:red;'>".number_format($okt ,2,',','.')."</span> ",

						 ),
			'13' => array(
						'label'=>'NOPEMBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='nop' id='nop' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$nop' onkeyup=$this->Prefix.hitungSelisih('bantuNop');> &nbsp <span id='bantuNop' style='color:red;'>".number_format($nop ,2,',','.')."</span> ",

						 ),
			'14' => array(
						'label'=>'DESEMBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='des' id='des' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$des' onkeyup=$this->Prefix.hitungSelisih('bantuDes');> &nbsp <span id='bantuDes' style='color:red;'>".number_format($des ,2,',','.')."</span> ",

						 ),
			'15' => array(
						'label'=>'JUMLAH HARGA ALOKASI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jumlahHargaAlokasi' id='jumlahHargaAlokasi' value='$resultPenjumlahan' readonly > &nbsp <span id='bantuPenjumlahan' style='color:red;'>".number_format($resultPenjumlahan ,2,',','.')."</span>",

						 ),
			'16' => array(
						'label'=>'SELISIH (+/-)',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='selisih' id='selisih' value='$selisih' readonly > &nbsp <span id='bantuSelisih' style='color:red;'>".number_format($selisih ,2,',','.')."</span>",

						 ),

			);
		//tombol

		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($id);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function formAlokasiTriwulan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $jumlahHargaForm = $_REQUEST['jumlahHarga'];
	 $id = $_REQUEST['id'];
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );

	 $username = $_COOKIE['coID'];
	 $getAlokasi = mysql_fetch_array(mysql_query("select * from temp_alokasi_rka_v2 where user='$username'"));
	 foreach ($getAlokasi as $key => $value) {
				  $$key = $value;
			}
	 $jenisAlokasi = $jenis_alokasi_kas;
	 $resultPenjumlahan = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nop + $des;
	 if(empty($jenisPerhitungan))$jenisPerhitungan = "MANUAL";
	 if(empty($jan))$jan="0";
	 if(empty($feb))$feb="0";
	 if(empty($mar))$mar="0";
	 if(empty($apr))$apr="0";
	 if(empty($mei))$mei="0";
	 if(empty($jun))$jun="0";
	 if(empty($jul))$jul="0";
	 if(empty($agu))$agu="0";
	 if(empty($sep))$sep="0";
	 if(empty($okt))$okt="0";
	 if(empty($nop))$nop="0";
	 if(empty($des))$des="0";
	 $selisih = $jumlahHargaForm - $resultPenjumlahan;
	 if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','TRIWULAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged($id);") ;
	 $cmbJenisPerhitungan = cmbArray('jenisPerhitungan',$jenisPerhitungan,$arrayJenisPerhitungan,'-- JENIS PERHITUNGAN --',"onchange=$this->Prefix.jenisPerhitunganChanged();") ;
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'JUMLAH HARGA',
						'labelWidth'=>150,
						'value'=>"<input type='hidden' name='jumlahHargaForm' id ='jumlahHargaForm'  value='$jumlahHargaForm'> <input type='text' value='Rp. ".number_format($jumlahHargaForm,2,',','.')."' readonly style='width:210px;'>",
						 ),
			'2' => array(
						'label'=>'JENIS ALOKASI',
						'labelWidth'=>150,
						'value'=>$cmbJenisAlokasi,
						 ),
			'3' => array(
						'label'=>'SISTEM PERHITUNGAN',
						'labelWidth'=>150,
						'value'=>$cmbJenisPerhitungan." &nbsp <button type='button' id='buttonHitung' onclick='$this->Prefix.hitung();' disabled >HITUNG</button>  <input type='hidden' name='jan' id='jan'><input type='hidden' name='feb' id='feb'> <input type='hidden' name='apr' id='apr'> <input type='hidden' name='mei' id='mei'> <input type='hidden' name='jul' id='jul'> <input type='hidden' name='agu' id='agu'> <input type='hidden' name='okt' id='okt'> <input type='hidden' name='nop' id='nop'> ",
						 ),
			'6' => array(
						'label'=>'TRIWULAN 1',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='mar' id='mar' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mar' onkeyup=$this->Prefix.hitungSelisih('bantuMar');> &nbsp <span id='bantuMar' style='color:red;'>".number_format($mar ,2,',','.')."</span> ",

						 ),
			'8' => array(
						'label'=>'TRIWULAN 2',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jun' id='jun' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jun' onkeyup=$this->Prefix.hitungSelisih('bantuJun');> &nbsp <span id='bantuJun' style='color:red;'>".number_format($jun ,2,',','.')."</span> ",

						 ),
			'11' => array(
						'label'=>'TRIWULAN 3',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='sep' id='sep'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$sep' onkeyup=$this->Prefix.hitungSelisih('bantuSep');> &nbsp <span id='bantuSep' style='color:red;'>".number_format($sep ,2,',','.')."</span> ",

						 ),
			'14' => array(
						'label'=>'TRIWULAN 4',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='des' id='des' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$des' onkeyup=$this->Prefix.hitungSelisih('bantuDes');> &nbsp <span id='bantuDes' style='color:red;'>".number_format($des ,2,',','.')."</span> ",

						 ),
			'15' => array(
						'label'=>'JUMLAH HARGA ALOKASI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jumlahHargaAlokasi' id='jumlahHargaAlokasi' value='$resultPenjumlahan' readonly > &nbsp <span id='bantuPenjumlahan' style='color:red;'>".number_format($resultPenjumlahan ,2,',','.')."</span>",

						 ),
			'16' => array(
						'label'=>'SELISIH (+/-)',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='selisih' id='selisih' value='$selisih' readonly > &nbsp <span id='bantuSelisih' style='color:red;'>".number_format($selisih ,2,',','.')."</span>",

						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($id);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


    function newJob($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'PEKERJAAN BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'namaPekerjaan' => array(
						'label'=>'NAMA PEKERJAAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaPekerjaan' id='namaPekerjaan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveJob();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function editJob($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'EDIT PEKERJAAN';

	 $getNamaPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$dt'"));
	 $namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];

	 //items ----------------------
	  $this->form_fields = array(
			'namaPekerjaan' => array(
						'label'=>'NAMA PEKERJAAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaPekerjaan' id='namaPekerjaan' value='$namaPekerjaan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveEditJob();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function Gruping($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
	 $this->form_width = 600;
	 $this->form_height = 80;
	 $this->form_caption = 'Gruping Pekerjaan';
	 $codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan  ";
	 $cmbPekerjaan = cmbQuery('pekerjaan', $pekerjaan, $codeAndNamePekerjaan,"  ",'-- PEKERJAAN --');

	 //items ----------------------
	  $this->form_fields = array(
			'pekerjaan' => array(
						'label'=>'PEKERJAAN',
						'labelWidth'=>100,
						'value'=>$cmbPekerjaan." &nbsp <button type='button' onclick=$this->Prefix.newJob(); >Tambah</button>  &nbsp <button type='button' onclick=$this->Prefix.editJob(); >Edit</button>
								<input type='hidden' name='anggota' id='anggota' value='$dt'>
								",
						 ),


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".setGrup()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function checkKosong($jumlah){
			if($jumlah == 0 || $jumlah == ''){
					$jumlah = "";
			}
			return $jumlah;
	}

	function nullChecker($angka){
		if(empty($angka)){
				$angka = "";
		}
		return $angka;

	}

	function removeKoma($angka){
			return str_replace(".00","",$angka);
	}

	function formRincianVolume($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 180;
	 $this->form_caption = 'DETAIL VOLUME';
	 $jumlahHargaForm = $dt;
	 $username =$_COOKIE['coID'];
	//  $getRincianVolume = mysql_fetch_array(mysql_query("select * from tabel_CEK FISIK where id ='$dt'"));
	//  foreach ($getRincianVolume as $key => $value) {
	// 			  $$key = $value;
	// 	}

	foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
	 }
	 if(empty($volume3Temp) && !empty($volume2Temp)){
	  $totalResult = $volume1Temp * $volume2Temp ;
	  $volume3Temp = "";
		 $satuanVolume = $satuan1Temp." / ".$satuan2Temp;

	}elseif(empty($volume2Temp)){
	 $totalResult = $volume1Temp  ;
	 $volume3Temp = "";
	 $volume2Temp = "";
	$satuanVolume = $satuan1Temp;
	}else{
	  $totalResult = $jumlah1 * $jumlah2 * $jumlah3 ;
		$satuanVolume = $satuan1Temp." / ".$satuan2Temp." / ".$satuan3Temp;
	 }
// <input type='hidden' id='volumeRek' value='$volume_rek'>
	 //items ----------------------
	  $this->form_fields = array(
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 1 &nbsp<input type='text' id='jumlah1' value='$volume1Temp' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder='JUMLAH'> &nbsp SATUAN 1   &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' name ='satuan1' id ='satuan1' value='$satuan1Temp'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 2 &nbsp<input type='text' id='jumlah2' placeholder='JUMLAH' value='".$this->nullChecker($volume2Temp)."' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 2  &nbsp&nbsp&nbsp&nbsp&nbsp    <input type='text' value='$satuan2Temp' name ='satuan2' id ='satuan2'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 3 &nbsp<input type='text' id='jumlah3' placeholder='JUMLAH' value='".$this->nullChecker($volume3Temp)."' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 3  &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' value='$satuan3Temp'name ='satuan3' id ='satuan3'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" VOLUME &nbsp &nbsp<input type='text' value='$totalResult' placeholder='JUMLAH' id='jumlah4' readonly >&nbsp SATUAN VOL &nbsp <input type='text' name ='satuanVolume' id ='satuanVolume' style='width:150px;'  value='$satuanVolume' readonly> &nbsp &nbsp <span id='detailVolumeRincian'>",
						 ),
			 array( 		'label' => '',
 						'labelWidth' => 1,
 						'pemisah' => ' ',
 						'value'=>"",
 						 ),
	 			array( 	'label' => '',
	 						'labelWidth' => 1,
	 						'pemisah' => ' ',
	 						'value'=>" URAIAN VOLUME &nbsp <input type='text' value='$uraianVolume' placeholder=''  id='rincianVolumeTemp' style='width:330px;' >",
	 						 ),


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveRincianVolume($dt);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function kasihNol($angka){
			if($angka < 10){
					$hubla = "000".$angka;
			}elseif($angka < 100){
					$hubla = "00".$angka;
			}elseif($angka < 1000){
					$hubla = "0".$angka;
			}elseif($angka < 10000){
					$hubla = $angka;
			}
			return $hubla;
	}


	function cekFisik($idPersediaan){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 150;
	 foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
	 }
		$this->form_caption = 'CEK FISIK';
		$getDataPersediaan = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '$idPersediaan'"));
		$getDataCekFisik = mysql_fetch_array(mysql_query("select * from cek_fisik where c1='".$getDataPersediaan['c1']."' and c='".$getDataPersediaan['c']."' and d='".$getDataPersediaan['d']."' and e='".$getDataPersediaan['e']."' and e1='".$getDataPersediaan['e1']."' and f1='".$getDataPersediaan['f1']."' and f2='".$getDataPersediaan['f2']."' and f='".$getDataPersediaan['f']."' and g='".$getDataPersediaan['g']."' and h='".$getDataPersediaan['h']."' and i='".$getDataPersediaan['i']."' and j='".$getDataPersediaan['j']."'  and j1='".$getDataPersediaan['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '$periode'"));

		if(empty($getDataCekFisik['berkurang'])){
				$jumlahCheck = $getDataCekFisik['bertambah'];
				$jenisCekFisik = "4";
				$hargaSatuan = $getDataCekFisik['harga_satuan'];
				$explodeHargaSatuan = explode(".",$hargaSatuan);
				$hargaSatuan = $explodeHargaSatuan[0];
				$statusHargaSatuan = "";
		}else{
				$jumlahCheck = $getDataCekFisik['berkurang'];
				$jenisCekFisik = "5";
				$statusHargaSatuan = "readonly";
		}
	 //items ----------------------
	 	$arrayJenisCekFisik = array(
															array('4','BERTAMBAH'),
															array('5','BERKURANG'),
														);
	  $this->form_fields = array(

	  	'sdsds' => array(
					'label'=>'HASIl CEK',
					'labelWidth'=>100,
					'value'=>	cmbArray('jenisCekFisik',$jenisCekFisik,$arrayJenisCekFisik,'-- PERHITUNGAN --',"onchange=$this->Prefix.cekFisikChanged();"),
				),
	  	'asd' => array(
					'label'=>'JUMLAH CEK',
					'labelWidth'=>100,
					'value'=>	"<input type='text' name='jumlahCheck' id = 'jumlahCheck' style='width:60px;' value='$jumlahCheck' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantuJumlahCheck();'> <span id='bantuJumlahCheck'></span>",
				),
	  	'dddd' => array(
					'label'=>'HARGA SATUAN',
					'labelWidth'=>100,
					'value'=>	"<input type='text' name='hargaSatuan' id = 'hargaSatuan' value='".$hargaSatuan."' $statusHargaSatuan onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantuHargaSatuan();'> <span id='bantuHargaSatuan'></span>",
				),
	  	'labelKeterangan' => array(
					'label'=>'KETERANGAN',
					'labelWidth'=>100,
					'value'=>	"",
				),
	  	'keterangan' => array(
					'label'=>'',
					'labelWidth'=>100,
					'value'=>	"<textarea id='keterangan' name='keterangan' style = 'width:100%;' row ='3'>".$getDataCekFisik['keterangan']."</textarea>",
					'type'=>	"merge",
				),




			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveCekFisik($idPersediaan)' > &nbsp".
			"<input type='button' value='Tutup' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

}
$cekFisik = new cekFisikObj();
$cekFisik->username = $_COOKIE['coID'];
$getTanggalCek = mysql_fetch_array(mysql_query("select * from pengaturan_persediaan where tahun = '".$_COOKIE['coThnAnggaran']."'"));
$cekFisik->tanggalCek = $getTanggalCek['tanggal_cek'];


?>
