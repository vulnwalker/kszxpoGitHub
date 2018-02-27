<?php

class rkaSKPD21NewObj  extends DaftarObj2{
	var $Prefix = 'rkaSKPD21New';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_rka_2_1'; //bonus
	var $TblName_Hapus = 'tabel_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_anggaran');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'RKA-SKPD';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='rkaSKPD21New.xls';
	var $namaModulCetak='RKA';
	var $Cetak_Judul = 'RKA';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'rkaSKPD21NewForm';
	var $modul = "RKA-SKPD";
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
      $dt['c1'] = $_REQUEST[$this->Prefix.'cmbUrusan'];
      $dt['c'] = $_REQUEST[$this->Prefix.'cmbBidang'];
      $dt['d'] = $_REQUEST[$this->Prefix.'cmbSKPD'];
      $fm = $this->setForm($dt);
    }
      return  array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  }

function setForm($dt,$c1,$c,$d,$e,$e1){  
   global $SensusTmp;
   $cek = ''; $err=''; $content='';     
   $json = TRUE;  //$ErrMsg = 'tes';    
   $form_name = $this->Prefix.'_form';        
   $this->form_width = 500;
   $this->form_height = 220;
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
    
    
    $queryKategori = "SELECT id,kategori_tandatangan FROM ref_kategori_tandatangan where id = 1";
  
    
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
    $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '1' "));
     $this->form_fields = array(
      'URUSAN' => array( 
            'label'=>'URUSAN',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='dc1' id='dc1' value='".$datc1."' style='width:300px;' readonly>
            <input type ='hidden' name='c1' id='c1' value='".$queryc1['c1']."'>
            </div>", 
             ),
      
      'bidang' => array( 
            'label'=>'BIDANG',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='dc' id='dc' value='".$datc."' style='width:300px;' readonly>
            <input type ='hidden' name='c' id='c' value='".$queryc['c']."'>
            </div>", 
             ),
      
      'skpd' => array( 
            'label'=>'SKPD',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='dd' id='dd' value='".$datd."' style='width:300px;' readonly>
            <input type ='hidden' name='d' id='d' value='".$queryd['d']."'>
            </div>", 
             ),     
                
      // 'unit' => array( 
      //       'label'=>'UNIT',
      //       'labelWidth'=>150, 
      //       'value'=>"<div style='float:left;'>
      //       <input type='text' name='de' id='de' value='".$date."' style='width:500px;' readonly>
      //       <input type ='hidden' name='e' id='e' value='".$querye['e']."'>
      //       </div>", 
      //        ),         
      
      // 'subunit' => array( 
      //       'label'=>'SUB UNIT',
      //       'labelWidth'=>150, 
      //       'value'=>"<div style='float:left;'>
      //       <input type='text' name='de1' id='de1' value='".$date1."' style='width:500px;' readonly>
      //       <input type ='hidden' name='e1' id='e1' value='".$querye1['e1']."'>
      //       </div>", 
      //        ),
      // 'kategori' => array( 
      //       'label'=>'KATEGORI',
      //       'labelWidth'=>150,
      //       'value'=>"<input type='text' id='kategori' name='kategori' value='".$queryKategori1[kategori_tandatangan]."' readonly='readonly' style='width: 250px;'>",
      //                 ),
    //  cmbQuery('fmJabatan',$dt['jabatan'],$queryJabatan,'','-------- Pilih --------')
      'namapegawai' => array( 
            'label'=>'NAMA',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='namapegawai' id='namapegawai' value='".$dt['nama']."' style='width:300px;'>
            
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
   // if( $err=='' && $kategori =='' ) $err= 'Kategori Belum Di Pilih !!';
  
      if($fmST == 0){
      if($err=='' && $oldy['cnt']>0) $err="NIP '$nippegawai' Sudah Ada";
        if($err==''){
      
          $aqry = "INSERT into ref_tandatangan (c1,c,d,e,e1,nama,nip,jabatan,pangkat,gol,ruang,eselon,kategori_tandatangan) values('$kode1','$kode2','$kode3','$kode4','$kode5','$namapegawai','$nippegawai','$jabatan','$p1','$golongan[0]','$golongan[1]','$eselon','0')";  $cek .= $aqry;  
          $qry = mysql_query($aqry);
          $jenisKegiatan = $_REQUEST['jenisKegiatan'];
            if($jenisKegiatan == "Pengadaan1" || $jenisKegiatan == "Pengadaan3"){
              $kategorinaey = 1;
            }else{
              $kategorinaey = 2;
            }
          $content = array('combottd' => cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = '0' and c1 = '".$_REQUEST[c1]."' and c = '".$_REQUEST[c]."' and d = '".$_REQUEST[d]."' and e = '".$_REQUEST[e]."' and e1 = '".$_REQUEST[e1]."' ",'onchange=rka.refreshList(true);','-- TTD --'));
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
		return 'RKA-SKPD 2.1 '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
	}
	function setMenuView(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";

	}
	function setMenuEdit(){
	 	 $arrayResult = VulnWalkerTahap_v2('RKA');
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $query = $arrayResult['query'];
	 if ($jenisForm == "PENYUSUNAN"){
	 	$listMenu =

					"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru ", 'Baru ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			//		"<td>".genPanelIcon("javascript:".$this->Prefix.".Remove()","delete_f2.png","Hapus", 'Hapus')."</td>".
				//	"<td>".genPanelIcon("javascript:".$this->Prefix.".Gruping()","publishdata.png","Gruping ", 'Gruping ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>"
					;
	 }elseif ($jenisForm == "VALIDASI"){
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Validasi()","validasi-menu.png","Validasi", 'Validasi')."</td>
					<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }elseif ($jenisForm == "KOREKSI"){
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }else{
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }

		return $listMenu ;
	}
	function genRowSum($ColStyle, $Mode, $Total){
		foreach ($_REQUEST as $key => $value) {
		  	$$key = $value;
		 }
		 if($cmbSubUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
		}elseif($cmbUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
		}elseif($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}

		if ($this->jenisForm == "PENYUSUNAN" || $this->jenisForm == "KOREKSI" ){
			$idTahap = $this->idTahap;
		}else{
			$getIdTahapRKATerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from tabel_anggaran where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and jenis_rka !='' and o1 !='0' and (rincian_perhitungan !='' or f !='00' ) and nama_modul = 'RKA-SKPD' "));
		 	$idTahap = $getIdTahapRKATerakhir['max'];
		}


		if($this->wajibValidasi == TRUE)$tergantung = "<td class='GarisDaftar' align='center' ></td>";
		$ContentTotal =
		"<tr>
			<td class='$ColStyle' colspan='6' align='center'><b>Total </td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->total,2,',','.')."</div></td>

			$tergantung
		</tr>" ;


			if($Mode == 2){
				$ContentTotal = '';
			}else if($Mode == 3){
				$ContentTotalHal='';
			}

		return $ContentTotalHal.$ContentTotal;
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

		case 'setGrup':{
				foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 	}


				if(mysql_num_rows(mysql_query("select * from tabel_anggaran where o1 = '$pekerjaan' and id_tahap = '$this->idTahap' and jenis_rka = '2.1' and nama_modul ='RKA-SKPD'")) == 0){
					$data = array(
												 'c1' => '0',
												 'c' => '00',
												 'd' => '00',
												 'e' => '00',
												 'e1' => '000',
												 'f1' => '0',
										  		 'f2' => '0',
										  		 'f' => '00',
										 		 'g' => '00',
										  		 'h' => '00',
												 'i' => '00',
												 'j' => '000',
												 'k' => '0',
												 'l' => '0',
												 'm' => '0',
												 'n' => '0',
												 'o' => '0',
												 'o1' => $pekerjaan,
												 'jenis_rka' => '2.1',
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'id_tahap' => $this->idTahap,
												 'nama_modul' => 'RKA-SKPD'
													);
					mysql_query(VulnWalkerInsert('tabel_anggaran',$data));
				}
				if(strpos($anggota, ',') !== false) {
				    $arrayRekening = explode(',',$anggota);
					$huge = sizeof($arrayRekening);

					for($i = 0 ; $i < $huge; $i++){

						$id_rekening =  $arrayRekening[$i];
						$getRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_rekening'"));
						/*foreach ($getRekening as $key => $value) {
						  $$key = $value;
					 	}*/

						$data = array('o1' => $pekerjaan);
						$query = VulnWalkerUpdate('tabel_anggaran',$data," k='".$getRekening['k']."' and l='".$getRekening['l']."' and m='".$getRekening['m']."' and n='".$getRekening['n']."' and o='".$getRekening['o']."' and id_tahap = '$this->idTahap'");
						mysql_query($query);

					}
				}else{
						$id_rekening =  $anggota;
						$getRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_rekening'"));
						foreach ($getRekening as $key => $value) {
						  $$key = $value;
					 	}

						$data = array('o1' => $pekerjaan);
						$query = VulnWalkerUpdate('tabel_anggaran',$data," k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$this->idTahap'");
						$content = "2";
						mysql_query($query);
				}




		break;
		}
		case 'SaveEditJob':{
			$username = $_COOKIE['coID'];
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $getMaxLeftUrut = mysql_fetch_array(mysql_query("select left_urut  from ref_pekerjaan where  id ='$o1'"));
			 $left_urut = $getMaxLeftUrut['left_urut'];

			 $data = array( 'nama_pekerjaan' => $namaPekerjaan

			 				);
			 $query = VulnWalkerUpdate("ref_pekerjaan",$data,"id = '$pekerjaan'");

			 if(empty($namaPekerjaan)){
			 	$err = "input gagal";
			 }else{
				$execute = mysql_query($query);
			 }
			$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan  ";
			$getCurrentInsert = mysql_fetch_array(mysql_query("select max(id) from ref_pekerjaan "));
			$cmbPekerjaan = cmbQuery('pekerjaan', $getCurrentInsert['max(id)'], $codeAndNamePekerjaan,"  ",'-- PEKERJAAN --');

			$getUrut = mysql_fetch_array(mysql_query("select * from temp_rka_221 where o1='$o1'"));
			$urut = $getUrut['urut'];

			$content = array('cmbPekerjaan' => $cmbPekerjaan, 'left_urut' => $left_urut, 'urut' => $urut, 'query' => "select left_urut , urut as urut from ref_pekerjaan where  id ='$o1'" );
		break;
	    }
		case 'editJob':{
				$dt = $_REQUEST['pekerjaan'];
				$fm = $this->editJob($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
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

		case 'Gruping':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if(!isset($rkaSKPD21New_cb)){
				$err = "Pilih Data";
			}
			$dt = implode(',',$rkaSKPD21New_cb);
			if($this->jenisForm !='PENYUSUNAN')$err = "Tahap Penyusunan Telah Habis";
				 if($err == ''){
						$fm = $this->Gruping($dt);
						$cek = $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
				 }

		break;
		}

		case 'newJob':{
				$fm = $this->newJob($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'SaveJob':{
			$username = $_COOKIE['coID'];
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }


			 $data = array( 'nama_pekerjaan' => $namaPekerjaan
			 				);
			 $query = VulnWalkerInsert("ref_pekerjaan",$data);

			 if(empty($namaPekerjaan)){
			 	$err = "input gagal";
			 }else{
				$execute = mysql_query($query);
			 }
			$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan ";
			$getCurrentInsert = mysql_fetch_array(mysql_query("select max(id) from ref_pekerjaan"));
			$cmbPekerjaan = cmbQuery('pekerjaan', $getCurrentInsert['max(id)'], $codeAndNamePekerjaan,"  ",'-- PEKERJAAN --');
			$getMaxUrut = mysql_fetch_array(mysql_query("select max(urut) from temp_rka_221 where user ='$username'"));
			$urut = $getMaxUrut['max(urut)'] + 1;
			$content = array('cmbPekerjaan' => $cmbPekerjaan, 'left_urut' => $left_urut, 'urut' => $urut );
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

	   case 'Report':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
      }
    $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "))
    ;
      if($jenisKegiatan==''){
          $err = "Pilih Format Laporan";
      }else{
          $data = array(
              'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD,

              );
      if(mysql_num_rows(mysql_query("select * from skpd_report_rka_21 where username= '$this->username'")) == 0){
        $query = VulnWalkerInsert('skpd_report_rka_21',$data);
      }else{
        $query = VulnWalkerUpdate('skpd_report_rka_21',$data,"username = '$this->username'");
      }
      mysql_query($query);
        }
      $content = array('to' => $jenisKegiatan,'urusan' => $cmbUrusan, 'bidang' => $cmbBidang, 'skpd' => $cmbSKPD, 'namaPemda' => $namaPemda[option_value], 'cetakjang' => $cetakjang, 'ttd' => $ttd );
    break;
    }

		case 'Laporan':{
			$fm = $this->Laporan($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
		break;
		}
		case 'RKASKPD21':{
      $json = FALSE;
      $this->RKASKPD21();
    break;
    }
		case 'formBaru':{       
      $fm = $this->setFormBaru();       
      $cek = $fm['cek'];
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
		case 'clearTemp':{
				$username =$_COOKIE['coID'];
				mysql_query("delete from temp_rekening_rka_belanja_tidak_langsung where username ='$username'");
				mysql_query("delete from temp_rincian_belanja_tidak_langsung where username ='$username'");
				mysql_query("delete from temp_sub_rincian_belanja_tidak_langsung where username ='$username'");
				mysql_query("delete from temp_remove_rka_21 where username ='$username'");
				foreach ($_REQUEST as $key => $value) {
			 	 $$key = $value;
				}
				$getALlData = mysql_query("select * from view_rka_2_1 where id_tahap = '$this->idTahap' and c1 ='$cmbUrusan' and c ='$cmbBidang' and d='$cmbSKPD' and bk ='0' and ck='0' and dk='0' and p='0' and q='0' and rincian_perhitungan !='' and id_rincian_belanja !=''");
				while ($rows = mysql_fetch_array($getALlData)) {
						foreach ($rows as $key => $value) {
								$$key = $value;
						}
						$getMyIdRekening = mysql_fetch_array(mysql_query("select * from view_rka_2_1 where id_tahap = '$this->idTahap' and bk ='0' and ck='0' and dk='0' and p='0' and q='0' and k='$k'  and l ='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja ='' and rincian_perhitungan = '' "));
						$getDataRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '".$getMyIdRekening['id_anggaran']."'"));
						if(mysql_num_rows(mysql_query("select * from temp_rekening_rka_belanja_tidak_langsung where username = '$this->username' and k='$k'  and l ='$l' and m='$m' and n='$n' and o='$o'")) == 0){
								$dataRekening = array(
																				'k'=> $k,
																				'l'=> $l,
																				'm'=> $m,
																				'n'=> $n,
																				'o'=> $o,
																				'username' => $this->username,
																				'sumber_dana' => $getDataRekening['sumber_dana'],
																				'id_anggaran' => $getDataRekening['id_anggaran']
								);
								$queryRekening = VulnWalkerInsert('temp_rekening_rka_belanja_tidak_langsung',$dataRekening);
								mysql_query($queryRekening);
						}

						$getMyIdRincianBelanja = mysql_fetch_array(mysql_query("select * from view_rka_2_1 where id_tahap = '$this->idTahap' and c1='$c1' and c='$c' and d='$d' and bk ='0' and ck='0' and dk='0' and p='0' and q='0' and k='$k'  and l ='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja ='$id_rincian_belanja' and rincian_perhitungan = '' "));
						$getDataRincianBelanja =  mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '".$getMyIdRincianBelanja['id_anggaran']."'"));
						$getUraianRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '".$getDataRincianBelanja['id_rincian_belanja']."'"));
						$getIdRekeningBelanja = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_belanja_tidak_langsung where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and username = '$this->username'"));
						if(mysql_num_rows(mysql_query("select * from temp_rincian_belanja_tidak_langsung where username = '$this->username' and id_rekening_belanja = '".$getIdRekeningBelanja['id']."' and uraian = '".$getUraianRincianBelanja['nama_rincian_belanja']."'")) == 0){
								$dataRincianBelanja = array(

																				'id_rekening_belanja'=> $getIdRekeningBelanja['id'],
																				'uraian'=> $getUraianRincianBelanja['nama_rincian_belanja'],
																				'username' => $this->username,
																				'id_anggaran' => $getDataRincianBelanja['id_anggaran']
								);
								$queryRincianBelanja = VulnWalkerInsert('temp_rincian_belanja_tidak_langsung',$dataRincianBelanja);
								mysql_query($queryRincianBelanja);
						}
						$getUplineRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id_rincian_belanja'"));
						$getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from temp_rincian_belanja_tidak_langsung where username = '$this->username' and uraian = '".$getUplineRincianBelanja['nama_rincian_belanja']."'"));

						$getDataCurrentID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_anggaran'"));


						$dataSubRincian = array(
																			'id_rincian_belanja' => $getIdRincianBelanja['id'],
																			'uraian' => $rincian_perhitungan,
																			'f1' => $f1,
																			'f2' => $f2,
																			'f' => $f,
																			'g' => $g,
																			'h' => $h,
																			'i' => $i,
																			'j' => $j,
																			'harga_satuan' => $jumlah,
																			'volume1' => $this->checkKosong($getDataCurrentID['jumlah1']),
																			'volume2' => $this->checkKosong($getDataCurrentID['jumlah2']),
																			'volume3' => $this->checkKosong($getDataCurrentID['jumlah3']),
																			'rincian_volume' => $rincian_volume,
																			'satuan1' => $getDataCurrentID['satuan1'],
																			'satuan2' => $getDataCurrentID['satuan2'],
																			'satuan3' => $getDataCurrentID['satuan3'],
																			'username' => $this->username,
																			'id_anggaran' => $id_anggaran,
																		);
						$querySubRincian = VulnWalkerInsert("temp_sub_rincian_belanja_tidak_langsung",$dataSubRincian);
						mysql_query($querySubRincian);

				}



		break;
		}
		case 'BidangAfterForm':{
			 $kondisiBidang = "";
			 $cmbUrusan = $_REQUEST['fmSKPDUrusan'];
			 $cmbBidang = $_REQUEST['fmSKPDBidang'];

			 $codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) as vnama from ref_skpd where d='00' and c ='00' order by c1";

		     $codeAndNameBidang = "SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where d = '00' and e = '00' and c!='00'and c1 = '$cmbUrusan'  and e1='000'";

		     $codeAndNameskpd = "SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd  where c='$cmbBidang' and c1='$cmbUrusan' and d != '00' and  e = '00' and e1='000' ";


				$bidang =  cmbQuery('cmbBidangForm', $cmbBidang, $codeAndNameBidang,' '.$cmbRo.' onChange=\''.$this->Prefix.'.BidangAfterform()\'','-- Pilih Semua --');
				$skpd = cmbQuery('cmbSKPDForm', $cmbSKPD, $codeAndNameskpd,''.$cmbRo.'','-- Pilih Semua --');
				$content = array('bidang' => $bidang, 'skpd' =>$skpd ,'queryGetBidang' => $kondisiBidang);
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

		case 'sesuai':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getrkaSKPD21Newnya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getrkaSKPD21Newnya as $key => $value) {
				  $$key = $value;
			}
			$cmbUrusanForm = $c1;
			$cmbBidangForm = $c;

			$cekUrusan =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'"));
					if($cekUrusan > 0 ){

					}else{
						$data = array(
									    'c1' => $cmbUrusanForm,
										'c' => '00',
										'd' => '00',
										'e' => '00',
										'e1' => '000',
										'bk' => '0',
										'ck' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										"nama_modul" => $this->modul
										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= "mampir";
						mysql_query($query)	;
					}

					$cekBidang =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '00' and e='00' and e1='000'  and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekBidang > 0 ){

					}else{
						$data = array(
									    'c1' => $cmbUrusanForm,
										'c'  => $cmbBidangForm,
										'd'  => '00',
										'e'  => '00',
										'e1' => '000',
										'bk' => '0',
										'ck' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										"nama_modul" => $this->modul

										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= $query;
						mysql_query($query)	;
					}


			$dataSesuai = array("tahun" => $tahun,
								"c1" => $c1,
								"c" => $c,
								"d" => $d,
								"e" => $e,
								"e1" => $e1,
								"p" => '0',
								"q" => '0',
								"bk" => '0',
								"ck" => '0',
								'jumlah' => $jumlah,
								'id_tahap' => $this->idTahap,
								'jenis_anggaran' => $this->jenisAnggaran,
								'tahun' => $this->tahun,
								"nama_modul" => $this->modul

 								);
			$cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='00' and e1='000'  and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekSKPD > 0 ){
						$getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='00' and e1='000'  and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					    $idnya = $getID['id_anggaran'];
						mysql_query("update tabel_anggaran set jumlah = '$jumlah' where id_anggaran='$idnya'");
					}else{
						mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
						$content .=VulnWalkerInsert("tabel_anggaran", $dataSesuai);
					}


			/*$content = array("query" => $query, "sesuai" => number_format($jumlah,2,',','.'), "QUERY ROWS" => $queryData);*/

		break;
	    }

		case 'koreksi':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getrkaSKPD21Newnya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getrkaSKPD21Newnya as $key => $value) {
				  $$key = $value;
			}

			 $hasilKali = $koreksiSatuanHarga * $koreksiVolumebarang ;
			 if($this->jenisForm !='KOREKSI'){
			 	$err = "Tahap Koreksi Talah Habis";
			 }else{
			 /*	if(isset($jenisAlokasi) && !empty($jenisAlokasi)){
							$alokasi_jan = $_REQUEST['jan'];
							$alokasi_feb = $_REQUEST['feb'];
							$alokasi_mar = $_REQUEST['mar'];
							$alokasi_apr = $_REQUEST['apr'];
							$alokasi_mei = $_REQUEST['mei'];
							$alokasi_jun = $_REQUEST['jun'];
							$alokasi_jul = $_REQUEST['jul'];
							$alokasi_agu = $_REQUEST['agu'];
							$alokasi_sep = $_REQUEST['sep'];
							$alokasi_okt = $_REQUEST['okt'];
							$alokasi_nop = $_REQUEST['nop'];
							$alokasi_des = $_REQUEST['des'];
							$jenis_alokasi_kas = $_REQUEST['jenisAlokasi'];
							if(empty($jenisAlokasi)){
									$err = "Pilih jenis alokasi";
								}elseif($jenisAlokasi == 'BULANAN'){
									if( $jan == '' || $feb == '' || $mar == '' || $apr == '' || $mei == '' || $jun == '' || $jul == '' || $agu == '' || $sep == '' || $okt == '' || $nop == '' || $des == ''   ){
										$err = "Lengkapi alokasi";
									}

								}elseif($jenisAlokasi == 'TRIWULAN'   ){
									if( $mar == '' ||  $jun == '' ||  $sep == '' ||  $des == ''   ){
										$err = "Lengkapi alokasi";
									}
								}elseif($jumlahHargaAlokasi != $jumlahHarga){
									$err = "Jumlah Alokasi Salah ";
								}else{
									//mysql_query($query);
								}
						}*/
			 	if($err == ""){
				 	if(mysql_num_rows(mysql_query("select * from view_rka_2_1 where  o1='$o1' and rincian_perhitungan='' and rincian_perhitungan ='' and id_tahap='$this->idTahap' ")) > 0){

						 }else{
							$arrayPekerjaan = array(
												'c1' => '0',
												 'c' => '00',
												 'd' => '00',
												 'e' => '00',
												 'e1' => '000',
												 'f1' => '0',
										  		 'f2' => '0',
										  		 'f' => '00',
										 		 'g' => '00',
										  		 'h' => '00',
												 'i' => '00',
												 'j' => '000',
												 'k' => '0',
												 'l' => '0',
												 'm' => '0',
												 'n' => '0',
												 'o' => '0',
												 'o1' => $o1,
												 'jenis_rka' => '2.1',
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'id_tahap' => $this->idTahap,
												 'nama_modul' => 'RKA-SKPD'
												);
							$queryPekerjaan = VulnWalkerInsert('tabel_anggaran',$arrayPekerjaan);
							mysql_query($queryPekerjaan);
					}

				 	if(mysql_num_rows(mysql_query("select * from view_rka_2_1 where  rincian_perhitungan ='' and c1='0' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap='$this->idTahap'  ")) > 0){

					 }else{
						$data = array(
										"tahun" => $tahun,
										"c1" => '0',
										"c" => '00',
										"d" => '00',
										"e" => '00',
										"e1" => '000',
										"bk" => '0',
										"ck" => '0',
										"dk" => '0',
										"p" => '0',
										"q" => '0',
										"f1" => '0',
										"f2" => '0',
										"f" => '00',
										"g" => '00',
										"h" => '00',
										"i" => '00',
										"j" => '000',
										"k" => $k,
										"l" => $l,
										"m" => $m,
										"n" => $n,
										"o" => $o,
										'o1' => $o1,
										"jenis_rka" => '2.1',
										"jenis_anggaran" => $this->jenisAnggaran,
										"id_tahap" => $this->idTahap,
										"nama_modul" => $this->modul,
										"user_update" => $_COOKIE['coID'],
										"tanggal_update" => date("Y-m-d")

									);
							$query = VulnWalkerInsert('tabel_anggaran',$data);
							mysql_query($query);
					 }

					 $dataSesuai = array("tahun" => $tahun,
										 "c1" => $c1,
										 "c" => $c,
										 "d" => $d,
										 "e" => $e,
										 "e1" => $e1,
										 "f" => $f,
										 "g" => $g,
										 "h" => $h,
										 "i" => $i,
										 "j" => $j,
										 "id_jenis_pemeliharaan" => $id_jenis_pemeliharaan,
										 "uraian_pemeliharaan" => $uraian_pemeliharaan,
										 "k" => $k,
										 "l" => $l,
										 "m" => $m,
										 "n" => $n,
										 "o" => $o,
										 "o1" => $o1,
										 "rincian_perhitungan" => $rincian_perhitungan,
										 "jumlah" => $koreksiSatuanHarga,
										 "volume_rek" => $koreksiVolumebarang,
										 "satuan_rek" => $satuan_rek,
										 "jumlah_harga" => $hasilKali,
										 "jenis_anggaran" => $this->jenisAnggaran,
										 "jenis_rka" => '2.1',
										 "id_tahap" => $this->idTahap,
										 "nama_modul" => $this->modul,
										 "user_update" => $_COOKIE['coID'],
										 "tanggal_update" => date("Y-m-d"),

		 								);

					$cekRKA =  mysql_num_rows(mysql_query("select * from view_rka_2_1 where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' and o1='$o1' and rincian_perhitungan = '$rincian_perhitungan'"));
							if($cekRKA > 0 ){
								$getID = mysql_fetch_array(mysql_query("select * from view_rka_2_1 where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1 !='0' and rincian_perhitungan !='' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
							    $idnya = $getID['id_anggaran'];
								mysql_query(VulnWalkerUpdate("tabel_anggaran", $dataSesuai, "id_anggaran = '$idnya'"));
							}else{
								mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
								$content.=VulnWalkerInsert("tabel_anggaran", $dataSesuai);
							}
			 }
			 }



		break;
	    }

	    case 'SaveValid':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 if ($validasi == 'on') {
			 	 $status_validasi = "1";
			 }else{
			 	$status_validasi = "0";
			 }



			 $data = array( "status_validasi" => $status_validasi,
			 				'user_validasi' => $_COOKIE['coID'],
			 				'tanggal_validasi' => date("Y-m-d"),
							'id_tahap' => $this->idTahap
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$rkaSKPD21New_idplh'");
			 mysql_query($query);

			$content .= $query;
		break;
	    }

		 case 'SaveCatatan':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $data = array( "catatan" => $catatan
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$id'");
			 mysql_query($query);

			$content .= $query;
		break;
	    }


		case 'editTab':{
			$id = $_REQUEST['rkaSKPD21New_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$id[0]'"));
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

			$getAll = mysql_query("select * from view_rka_2_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and status_validasi !='1'  order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rka_21 where user='$username'");
			mysql_query("delete from temp_rincian_volume_21 where user='$username'");
		    mysql_query("delete from temp_alokasi_rka_21_v2 where user='$username'");
			$noUrutPekerjaan = 0;
			$angkaO2 = 0;
			$lastO1 = 0;
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				}
				$getMaxID = mysql_fetch_array(mysql_query("select  max(id) as gblk from temp_rka_21 where user ='$username'"));
				$maxID = $getMaxID['gblk'];
				$lastO1 = $o1;

				$getLastO1 = mysql_fetch_array(mysql_query("select o1 from temp_rka_21 where id='$maxID' "));
				if($getLastO1['o1'] != $lastO1){
					$noUrutPekerjaan = $noUrutPekerjaan + 1;
					if($o1 == '0'){
						$noUrutPekerjaan = 0;
					}
					$angkaO2 = 1;
				}


				$data = array(
								'c1' => $c1,
								'c' => $c,
								'd' => $d,
								'e' => $e,
								'e1' => $e1,
								'f' => $f,
								'g' => $g,
								'h' => $h,
								'i' => $i,
								'j' => $j,
								'k' => $k,
								'l' => $l,
								'm' => $m,
								'n' => $n,
								'o' => $o,
								'o1' => $o1,
								'volume_rek' => $volume_rek,
								'satuan' => $satuan_rek,
								'user' => $username,
								'rincian_perhitungan' => $rincian_perhitungan,
								'harga_satuan' => $jumlah,
								'jumlah_harga' => $jumlah_harga,

								'id_awal' => $id_anggaran
								);
				$query = VulnWalkerInsert('temp_rka_21',$data);
				mysql_query($query);
				$angkaO2 = $angkaO2 + 1;

			}

				$content = array('kodeRek' => $kodeRek);
			break;
		}

		case 'Remove':{
			$id = $_REQUEST['rkaSKPD21New_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$id[0]'"));
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

			$getAll = mysql_query("select * from view_rka_2_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and status_validasi !='1' order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rka_21 where user='$username'");
			mysql_query("delete from temp_rincian_volume_21 where user='$username'");
		    mysql_query("delete from temp_alokasi_rka_21_v2 where user='$username'");
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				}
				mysql_query("delete from tabel_anggaran where id_anggaran = '$id_anggaran'");
				//mysql_query("delete from tabel_anggaran where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and o1 ='$o1' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and jenis_rka='2.1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");

			}

			break;
		}

	    case 'Validasi':{
				$dt = array();
				$err='';
				$content='';
				$uid = $HTTP_COOKIE_VARS['coID'];

				$cbid = $_REQUEST[$this->Prefix.'_cb'];
				$idplh = $_REQUEST['id_anggaran'];
				$this->form_idplh = $_REQUEST['id_anggaran'];


					$qry = "SELECT * FROM tabel_anggaran WHERE id_anggaran = '$idplh' ";$cek=$qry;
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

			$getData = mysql_fetch_array(mysql_query("SELECT * FROM tabel_anggaran WHERE id_anggaran = '$idAwal'"));
			foreach ($getData as $key => $value) {
				  $$key = $value;
			}
			$getMaxID = mysql_fetch_array(mysql_query("select max(id_anggaran) as maxID from tabel_anggaran where tahun = '$tahun'  and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q' and jenis_anggaran = '$jenis_anggaran'  "));
			$maxID = $getMaxID['maxID'];
			$aqry = "select * from tabel_anggaran where id_anggaran ='$maxID' ";
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
	"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=rkaSKPD221\" title='BELANJA' style='color:blue;' > BELANJA </a> |
	<A href=\"pages.php?Pg=rkaSKPD1PAD\" title='PENDAPATAN' > PENDAPATAN </a> |
	<A href=\"pages.php?Pg=rkaSKPD31\" title='RKA-SKPKD MURNI' > PEMBIAYAAN </a> |
	<A href=\"pages.php?Pg=rkaSKPD\" title='RKA-SKPKD MURNI' > RKA-SKPD  </a> |

	&nbsp&nbsp&nbsp
	</td></tr>

	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=rkaSKPD221\" title='BELANJA'  > LANGSUNG </a> |
	<A href=\"pages.php?Pg=rkaSKPD21New\" title='TIDAK LANGSUNG' style='color:blue;' > TIDAK LANGSUNG </a> |

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
			"
			<script src='js/skpd.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/perencanaan_v2/rka/popupBarang.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaan_v2/rka/popupRekening.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/rkaSKPD21New.js' language='JavaScript' ></script>
			  <link rel='stylesheet' href='datepicker/jquery-ui.css'>
			  <script src='datepicker/jquery-1.12.4.js'></script>
			  <script src='datepicker/jquery-ui.js'></script>

			".
			$scriptload;
	}

  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		if($err == ''){
			$aqry = "SELECT * FROM  tabel_anggaran WHERE id_anggaran='".$this->form_idplh."' "; $cek.=$aqry;
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
	 $this->form_caption = 'INFO RKA';


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


	 if($this->jenisForm == "PENYUSUNAN"){
	 	if($this->wajibValidasi == TRUE)$tergantung = "<th class='th01' rowspan='2' width='100' >VALIDASI</th>";
		$headerTable =
		  "<thead>
		   <tr>
	  	<th class='th01' width='20'  rowspan='2' ></th>

		   <th class='th01' width='100'  rowspan='2' >KODE REKENING </th>
		   <th class='th01' width='700'  rowspan='2' >URAIAN</th>
		   <th class='th02' colspan='3'  rowspan='1' width='800' >RINCIAN PENGHITUNGAN</th>
		   <th class='th01' width='120'  rowspan='2' >JUMLAH HARGA</th>

		   $tergantung

		   </tr>
		   <tr>
		   <th class='th01' >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >HARGA SATUAN</th>


		   </tr>

		   </thead>";
	 }elseif ($this->jenisForm == "KOREKSI"){
	 	$Checkbox = "";
	 	$tergantungJenisForm = "
		<th class='th02' rowspan='1' colspan='3' width='600'>KOREKSI</th>
		<th class='th02' rowspan='1' colspan='3' width='600'>BERTAMBAH/(BERKURANG)</th>
		<th class='th01' rowspan='2' width='200'>AKSI</th>
		";
		$headerTable =
		  "<thead>
		   <tr>
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='900'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='600' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' width='200'  rowspan='2' >JUMLAH HARGA</th>
		   $tergantungJenisForm

		   </tr>
		   <tr>
		   <th class='th01'  >VOLUME</th>
		   <th class='th01'  >SATUAN</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   </tr>
		   </thead>";
	 }else{
	    $Checkbox = "";
		if($this->jenisFormTerakhir == "PENYUSUNAN"){
		if($this->wajibValidasi == TRUE)$tergantung = "<th class='th01' rowspan='2' width='100' >VALIDASI</th>";
		$headerTable =
		  "<thead>
		   <tr>
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='500'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='4'  rowspan='1' width='1000' >RINCIAN PENGHITUNGAN</th>
		   $tergantung

		   </tr>
		   <tr>

		   <th class='th01' >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >HARGA SATUAN</th>
		   <th class='th01' >JUMLAH</th>

		   </tr>
		   </thead>";
		}elseif($this->jenisFormTerakhir == "KOREKSI"){
			$Checkbox = "";
	 	$tergantungJenisForm = "
		<th class='th02' rowspan='1' colspan='3' width='600'>KOREKSI</th>
		<th class='th02' rowspan='1' colspan='3' width='600'>BERTAMBAH/(BERKURANG)</th>
		";
		$headerTable =
		  "<thead>
		   <tr>
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='900'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='600' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' width='200'  rowspan='2' >JUMLAH HARGA</th>
		   $tergantungJenisForm

		   </tr>
		   <tr>
		   <th class='th01'  >VOLUME</th>
		   <th class='th01'  >SATUAN</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   </tr>
		   </thead>";
		}

	 }
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
	 	if($cmbSubUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
		}elseif($cmbUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
		}elseif($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}

		$Koloms = array();
		if( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && empty($id_rincian_belanja) ){
				 //Rekening
				 $boldStatus = "bold";
				 $marginStatus = "0px;";
				 $kode = $k.".".$l.".".$m.".".$n.".".$o;
				 $marginKode = "10px;";
				 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
				 $uraianList = $getNamaRekening['nm_rekening'];
				 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiRekening"));
				 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
				 $TampilCheckBox = "";
		}elseif( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && empty($rincian_perhitungan)){
				 //RincianBelanja
				 $boldStatus = "";
				 $marginStatus = "10px;";
				 $kode = "";
				 $getNamaRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id_rincian_belanja'"));
				 $uraianList = $getNamaRincianBelanja['nama_rincian_belanja'];
				 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja='$id_rincian_belanja' $kondisiSKPD $kondisiRekening"));
				 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
				 $TampilCheckBox = "";
		}elseif( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && !empty($rincian_perhitungan) ){
				 //SubRincianBelanja
				 $boldStatus = "";
				 $marginStatus = "20px;";
				 $kode = "";
				 if($j !='000'){
					 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
					 $uraianList = " - ".$getNamaBarang['nm_barang'];
				 }else{
					 $uraianList = " - ".$rincian_perhitungan;
				 }
				 $volumeRekening = number_format($volume_rek ,0,',','.');
				 $getSatuan = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_anggaran'"));
				 $satuanRekening = $getSatuan['satuan_total'];
				 $hargaSatuan = number_format($jumlah ,2,',','.');
				 $jumlahHarga = number_format($jumlah_harga ,2,',','.');
				 $this->total += $jumlah_harga;
				 $TampilCheckBox = "";
		}
		$Koloms[] = array(' align="left"', $TampilCheckBox );
		$Koloms[] = array(' align="left"', "<span style='color:$warnaMapping;margin-left:$marginKode;'>$kode</span>" );
		$Koloms[] = array(' align="left"', "<span style='font-weight:$boldStatus;margin-left:$marginStatus'>$uraianList</span> <div style='float:right'>".$isi['rincian_volume']."</div>" );
		$Koloms[] = array(' align="right"', $volumeRekening );
		$Koloms[] = array(' align="left"', $satuanRekening );
		$Koloms[] = array(' align="right"', $hargaSatuan );
		$Koloms[] = array(' align="right"',  "<span style='font-weight:$boldStatus;'>$jumlahHarga </span>" );

	 return $Koloms;
	}


	function Validasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI RKA-SKPD 2.1';
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
	 $idnya = $dt['id_anggaran'];

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


	 $arrOrder = array(
				     	array('nama_tahap','NAMA TAHAP'),
						array('waktu_aktif','WAKTU AKTIF'),
						array('waktu_pasif','WAKTU PASIF'),
						array('modul','MODUL'),
						array('status','STATUS')
					);

	$fmPILCARI = $_REQUEST['fmPILCARI'];
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
$fmORDER1 = $_REQUEST['fmORDER1'];


	$fmDESC1 = cekPOST('fmDESC1');
	$baris = $_REQUEST['baris'];
	if($baris == ''){
		$baris = "25";
	}

	$selectedC1 = $_REQUEST['cmbUrusan'];
	$selectedC  = $_REQUEST['cmbBidang'];
	$selectedD = $_REQUEST['cmbSKPD'];
	$selectedE = $_REQUEST['cmbUnit'];
	$selectedE1 = $_REQUEST['cmbSubUnit'];


	if(!isset($selectedC1) ){
	   		$arrayData = mysql_fetch_array(mysql_query("select * from current_filter where username ='".$_COOKIE['coID']."'"));
			foreach ($arrayData as $key => $value) {
			  $$key = $value;
			 }
			if($CurrentSKPD !='00' ){
				$selectedD = $CurrentSKPD;
				$selectedC = $CurrentBidang;
				$selectedC1 = $CurrentUrusan;

			}elseif($CurrentBidang !='00'){
				$selectedC = $CurrentBidang;
				$selectedC1 = $CurrentUrusan;

			}elseif($CurrentUrusan !='0'){
				$selectedC1 = $CurrentUrusan;
			}
	   }




	foreach ($_COOKIE as $key => $value) {
				  $$key = $value;
			}


		if($VulnWalkerSKPD != '00'){
			$selectedD = $VulnWalkerSKPD;
			$selectedC = $VulnWalkerBidang;
			$selectedC1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerBidang != '00'){
			$selectedC = $VulnWalkerBidang;
			$selectedC1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerUrusan != '0'){
			$selectedC1 = $VulnWalkerUrusan;
		}
		$codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) from ref_skpd where c='00' and d='00' and e='00' and e1='000' ";
		$urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=rkaSKPD21New.refreshList(true);','-- URUSAN --');

		$codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
		$bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=rkaSKPD21New.refreshList(true);','-- BIDANG --');

		$codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
		$skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=rkaSKPD21New.refreshList(true);','-- SKPD --');

		$codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e!='00' and e1='000' ";
		$unit = cmbQuery('cmbUnit',$selectedE,$codeAndNameUnit,'onchange=rkaSKPD21New.refreshList(true);','-- UNIT --');


		$codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1!='000' ";
		$subunit = cmbQuery('cmbSubUnit',$selectedE1,$codeAndNameSubUnit,'onchange=rkaSKPD21New.refreshList(true);','-- SUB UNIT --');



	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran) as max from view_rkbmd "));
	$maxID = $get1['max'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran = '$maxID' "));
	$nomorUrutSebelumnya =  $get2['no_urut'];









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





			</table>".
			"</div>"

			;

		return array('TampilOpt'=>$TampilOpt);


	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------
		$nomorUrutSebelumnya = $this->nomorUrut - 1;
		$arrKondisi = array();
		$arrKondisi[] = ' 1 = 1';
		$fmPILCARI = $_REQUEST['fmPILCARI'];
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn


		$cmbJenisRKA = $_REQUEST['cmbJenisRKA'];

		foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

		if(isset($cmbSKPD)){
			$data = array("CurrentUrusan" => $cmbUrusan,
					  "CurrentBidang" => $cmbBidang,
					  "CurrentSKPD" => $cmbSKPD,

					  );
		}elseif(isset($cmbBidang)){
			$data = array("CurrentUrusan" => $cmbUrusan,
					  "CurrentBidang" => $cmbBidang,

					  );
		}elseif(isset($cmbUrusan)){
			$data = array("CurrentUrusan" => $cmbUrusan

			 );
		}

		mysql_query(VulnWalkerUpdate("current_filter",$data,"username='$this->username'"));

		if(!isset($cmbUrusan) ){
	   		$arrayData = mysql_fetch_array(mysql_query("select * from current_filter where username ='".$_COOKIE['coID']."'"));
			foreach ($arrayData as $key => $value) {
			  $$key = $value;
			 }
			 if($CurrentSKPD !='00' ){
				$cmbSKPD = $CurrentSKPD;
				$cmbBidang = $CurrentBidang;
				$cmbUrusan = $CurrentUrusan;

			}elseif($CurrentBidang !='00'){
				$cmbBidang = $CurrentBidang;
				$cmbUrusan = $CurrentUrusan;

			}elseif($CurrentUrusan !='0'){
				$cmbUrusan = $CurrentUrusan;
			}
	   }
	  if(isset($cmbUrusan) && $cmbUrusan== ''){
	   		$cmbBidang = "";
			$cmbSKPD = "";
	   }elseif(isset($cmbBidang) && $cmbBidang== ''){
			$cmbSKPD = "";

	   }elseif(isset($cmbSKPD) && $cmbSKPD== ''){
	   }

			if($cmbSKPD != ''){
				// $arrKondisi[] = "c1 = '$cmbUrusan'";
				// $arrKondisi[] = "c = '$cmbBidang'";
				// $arrKondisi[] = "d = '$cmbSKPD'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
			}elseif($cmbBidang != ''){
				// $arrKondisi[] = "c1 = '$cmbUrusan'";
				// $arrKondisi[] = "c = '$cmbBidang'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
			}elseif($cmbUrusan != ''){
				//$arrKondisi[] = "c1 = '$cmbUrusan'";
				$kondisiSKPD = "and c1='$cmbUrusan'";
			}
			$blackListSubRincian = array();
			$getAllSubRincian = mysql_query("select * from view_rka_2_1 where id_tahap = '$this->idTahap' and (j!='000' or rincian_perhitungan !='' )");
			while($subRincian = mysql_fetch_array($getAllSubRincian)){
						if(mysql_num_rows(mysql_query("select * from view_rka_2_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening")) == 0){
								$blackListSubRincian[] = "id_anggaran != '".$subRincian['id_anggaran']."'";
								$arrKondisi[] = "id_anggaran !='".$subRincian['id_anggaran']."'";
								// $this->injectQuery = "select * from view_rka_2_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening";
						}
			}
			$kondisiBlackListSubRincian= join(' and ',$blackListSubRincian);
			if(sizeof($blackListSubRincian) == 0){
				$kondisiBlackListSubRincian = "";
			}elseif(sizeof($blackListSubRincian) > 0){
				$kondisiBlackListSubRincian = " and ".$kondisiBlackListSubRincian;
			}

			$blackListRincian = array();
			$getAllRincian =  mysql_query("select * from view_rka_2_1 where id_tahap ='$this->idTahap'  and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja != '' and id_rincian_belanja !='0' and j='000' and rincian_perhitungan = '' ");
			while($rincianBelanja = mysql_fetch_array($getAllRincian)){
					if(mysql_num_rows(mysql_query("select  * from view_rka_2_1 where id_tahap = '$this->idTahap' and bk = '".$rincianBelanja['bk']."' and ck = '".$rincianBelanja['ck']."' and dk = '".$rincianBelanja['dk']."' and p = '".$rincianBelanja['p']."' and q = '".$rincianBelanja['q']."' and k = '".$rincianBelanja['k']."' and l = '".$rincianBelanja['l']."'  and m = '".$rincianBelanja['m']."'  and n = '".$rincianBelanja['n']."' and o = '".$rincianBelanja['o']."' and id_rincian_belanja = '".$rincianBelanja['id_rincian_belanja']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
							$blackListRincian[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
							$arrKondisi[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
					}

			}

			$blackListRekening = array();
			$getAllRekening =  mysql_query("select * from view_rka_2_1 where id_tahap ='$this->idTahap'  and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
			while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
					if(mysql_num_rows(mysql_query("select  * from view_rka_2_1 where id_tahap = '$this->idTahap' and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
							$blackListRekening[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
							$arrKondisi[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
					}
			}




		$arrKondisi[] = "id_tahap = '$this->idTahap' ";
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		$arrOrders[] = "urut, rincian_perhitungan  asc";
		$Order= join(',',$arrOrders);
		$OrderDefault = '';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal );

	}

	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{


			$qy = "DELETE FROM $this->TblName_Hapus WHERE id_anggaran='".$ids[$i]."' ";$cek.=$qy;
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

function Laporan($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 300;
   $this->form_height = 100;
   $this->form_caption = 'LAPORAN RKA-SKPD 2.1 MURNI';

   $c1 = $dt['cmbUrusan'];
   $c = $dt['cmbBidang'];
   $d = $dt['cmbSKPD'];

     $arrayJenisLaporan = array(
                 array('RKASKPD21', 'RKA-SKPD 2.1 MURNI'),
                 // array('Pengadaan2', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGGUNA BARANG'),
                 // array('Pengadaan3', 'RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG'),
                 );

    $queryNama12 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '14' and c1 = '$c1' and c = '$c' and d = '$d' "));
    
    $cmbJenisLaporan = cmbArray('jenisKegiatan','',$arrayJenisLaporan,'-- JENIS LAPORAN --',"onchange = $this->Prefix.jenisChanged();");

    // $kat = $_REQUEST['jenisKegiatan'];
    // if ($kat == 'Pengadaan1' || $kat == 'Pengadaan3') {
    //   $kat2 = 1;
    // }else{
    //   $kat2 = 2;
    // }
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
                  'value'=>cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = 0 and c1 = '$c1' and c = '$c' and d = '$d' ",'onchange=rka.refreshList(true);','-- TTD --'),

                ),
      );
    //tombol
    $this->form_menubawah =
      "
      <input type='button' value='TTD' onclick ='".$this->Prefix.".Baru()' title='TTD' >
      <input type='button' value='View' onclick ='".$this->Prefix.".Report()' title='Simpan' >   ".
      "<input type='button' value='Batal' onclick ='".'rkaSKPD21'.".Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

function RKASKPD21($xls =FALSE){
		global $Main;
		$getJenisReport = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL' "));
		$getJenisUkuran = $getJenisReport['jenis'];
		if ($getJenisUkuran == 'L') {
			$trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
			$cetak = "<link rel='stylesheet' type='text/css' href='css/pageNumber4.css'>";
			$width = "33cm";
			$height = "21.5cm";
		}else{
			$trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
			$cetak = "<link rel='stylesheet' type='text/css' href='css/pageNumber2.css'>";
			$width = "21.5cm";
			$height = "30.3cm";
		}
		$arrayTandaTangan = explode(';', $getJenisReport['tanda_tangan']);
	
		$pisah = "<td width='1%' valign='top'> : </td>";
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		
		
		$arrKondisi = array();
		// $grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rka_21 where username='$this->username'"));
		$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd];
		foreach ($grabSKPD as $key => $value) { 
				  $$key = $value; 
			}
		$cmbUrusan = $c1;
		$cmbBidang = $c;
		$cmbSKPD = $d;
		$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' ";

		$blackListSubRincian = array();
			$getAllSubRincian = mysql_query("select * from view_rka_2_1 where id_tahap = '$this->idTahap' and (j!='000' or rincian_perhitungan !='' )");
			while($subRincian = mysql_fetch_array($getAllSubRincian)){
						if(mysql_num_rows(mysql_query("select * from view_rka_2_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening")) == 0){
								$blackListSubRincian[] = "id_anggaran != '".$subRincian['id_anggaran']."'";
								$arrKondisi[] = "id_anggaran !='".$subRincian['id_anggaran']."'";
								// $this->injectQuery = "select * from view_rka_2_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening";
						}
			}
			$kondisiBlackListSubRincian= join(' and ',$blackListSubRincian);
			if(sizeof($blackListSubRincian) == 0){
				$kondisiBlackListSubRincian = "";
			}elseif(sizeof($blackListSubRincian) > 0){
				$kondisiBlackListSubRincian = " and ".$kondisiBlackListSubRincian;
			}

			$blackListRincian = array();
			$getAllRincian =  mysql_query("select * from view_rka_2_1 where id_tahap ='$this->idTahap'  and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja != '' and id_rincian_belanja !='0' and j='000' and rincian_perhitungan = '' ");
			while($rincianBelanja = mysql_fetch_array($getAllRincian)){
					if(mysql_num_rows(mysql_query("select  * from view_rka_2_1 where id_tahap = '$this->idTahap' and bk = '".$rincianBelanja['bk']."' and ck = '".$rincianBelanja['ck']."' and dk = '".$rincianBelanja['dk']."' and p = '".$rincianBelanja['p']."' and q = '".$rincianBelanja['q']."' and k = '".$rincianBelanja['k']."' and l = '".$rincianBelanja['l']."'  and m = '".$rincianBelanja['m']."'  and n = '".$rincianBelanja['n']."' and o = '".$rincianBelanja['o']."' and id_rincian_belanja = '".$rincianBelanja['id_rincian_belanja']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
							$blackListRincian[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
							$arrKondisi[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
					}

			}

			$blackListRekening = array();
			$getAllRekening =  mysql_query("select * from view_rka_2_1 where id_tahap ='$this->idTahap'  and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
			while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
					if(mysql_num_rows(mysql_query("select  * from view_rka_2_1 where id_tahap = '$this->idTahap' and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
							$blackListRekening[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
							$arrKondisi[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
					}
			}




		$arrKondisi[] = "id_tahap = '$this->idTahap' ";
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
		
		$Kondisi= join(' and ',$arrKondisi);
		/*if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}*/
		$qry ="select * from view_rka_2_1 where $Kondisi order by urut";
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
    $kota = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan"));
		echo 
			"<html>
			<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  		<link rel='stylesheet' type='text/css' href='css/pageNumber4.css'>
  		<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
  		".$trChild."
  		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:15px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead { display: table-header-group; }
						.GarisCetak5{
							padding: 4px;
              border-top: unset;
              border-bottom: unset;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width: 33cm; font-family: sans-serif; height: 21.5cm; margin-left: 1cm; border: 1px solid #000; border-bottom-color: transparent; display: block;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>

							<table style='width: 33cm; border: 1px solid; margin-bottom: 1%; margin-left: -1px;'>
								<tr>
									<th class='th02' rowspan='2' style='width: 10%; border: 1px solid; text-align: center;'>
										<img src='".getImageReport()."' style='
                      width: 102.08px;
                      height: 84.59;
                      max-height: 84.59;
                      max-width: 102.08px;
                     padding: 5%;'>
									</th>
									<th class='th02' rowspan='1' style='text-align: center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>
											RENCANA KERJA DAN ANGGARAN<br>
											SATUAN KERJA PERANGKAT DAERAH
										</span>
									</th>
									<th class='th02' rowspan='2' style='text-align: center; width: 9%; border: 1px solid;'>
										<span style='font-size: 14px; font-weight: bold;'>
											Formulir<br> RKA SKPD<br> 2.1
										</span>
									</th>
								</tr>
								<tr>
									<th class='th02'  style='text-align: center; border: 1px solid;'>
										<span style='font-weight: bold; font-size: 14px; text-transform: uppercase;'>
											PEMERINTAH KABUPATEN ".$kota[kota]."<br>
										</span>
										<span class='ukurantulisanIdPenerimaan' style='font-size: 14px; font-weight: 100;'>TAHUN ANGGARAN : $this->tahun </span>
									</th>
								</tr>
							</table>

				<table class='subjudulcetak' style='width: 100.1%; font-family: sans-serif; margin-bottom: -0.5%; margin-top: -1%; border: 1px solid; margin-left: -1px;'>
					
					<tr>
						<td width='11%' valign='top'><span style='margin-left: 5%;'>Urusan Pemerintahan</span></td>
						$pisah
						<td width='1%' valign='top'>".$cmbUrusan."</td>
						<td valign='top'>$urusan</td>
					</tr>
					<tr>
						<td width='11%' valign='top' ><span style='margin-left: 5%;'>Organisasi</span></td>
						$pisah
						<td width='5%' valign='top'>".$cmbUrusan." . ".$cmbBidang."</td>
						<td valign='top'>$bidang</td>
					</tr>
					<tr>
						<td width='11%' valign='top'><span style='margin-left: 5%;'>Sub Unit Organisasi</span></td>
						$pisah
						<td valign='top' width='6%'>".$cmbUrusan." . ".$cmbBidang." . ".$cmbSKPD."</td>
						<td valign='top'>$skpd</td>
					</tr>
					
				</table>
				
				";
		echo "<br>
								<table table width='100%' class='cetak' border='1' style='width:100.1%; margin-top: -0.7%; margin-left: -1px;'>
								<thead>
									<tr>
										<th colspan='10' style='text-align: center; border: 1px solid; padding: 1.5px;'>
											<span style='font-size:14px;font-weight:bold;text-decoration: '>
												RINCIAN ANGGARAN BELANJA TIDAK LANGSUNG SATUAN KERJA PERANGKAT DAERAH
											</span>	
										</th>
									</tr>
									<tr>
										<th class='th02' rowspan='2' >KODE<br>REKENING</th>
										<th class='th02' rowspan='2' colspan='1' >URAIAN</th>
										<th class='th02' rowspan='1' colspan='3' >Tahun n</th>
										<th class='th02' rowspan='2' >JUMLAH<br> (RP)</th>
										<th class='th02' rowspan='2' >Tahun<br> n + 1</th>
									</tr>
									<tr>
										<th class='th02' >Volume</th>
										<th class='th02' >Satuan</th>
										<th class='th02' >Tarif / Harga</th>
									</tr>
									<tr>
										<th class='th02' >1</th>
										<th class='th02' >2</th>
										<th class='th02' style='width: 4%;'>3</th>
										<th class='th02' style='width: 4%;'>4</th>
										<th class='th02' >5</th>
										<th class='th02' >6 = (3 x 5)</th>
										<th class='th02' >7</th>
									</tr>
									</thead>
								
									
		";
		$getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_1 where $Kondisi  "));
		$total = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) { 
				  $$key = $value; 
			} 
			// $kondisiFilter = "and no_urut = '$this->urutTerakhir' and tahun  ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'";
			// if($k == '0' && $n =='0' ){
			// 	$k = "";
			// 	$l = "";
			//     $m = "";
			// 	$n = "";
			// 	$o = "";
			// 	$this->publicVar += 1;
			// 	$getPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1' "));
			// 	$uraian = "<span style='font-weight:bold;'>$this->publicVar.". $getPekerjaan['nama_pekerjaan'] . "</span>";
			// 	$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_1 where  o1 ='$o1' $kondisiSKPD $kondisiFilter  "));
			// 	$jumlah_harga = "<span style='font-weight:bold;'>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.') . "</span>";
				
				
			// }elseif($c1 == '0'){
			// 	$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
			// 	$jarak = "0px";
			// 	if($o1 !='0' && $o1 !='')$jarak = "10px";
			// 	$uraian = "<span style='font-weight:bold;margin-left:$jarak;'>".$getNamaRekening['nm_rekening']."</b>";
			// 	$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_1 where  k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'  $kondisiSKPD $kondisiFilter"));
			// 	$jumlah_harga = "<b>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.');
			// }else{
			// 	$k = "";
			// 	$l = "";
			//     $m = "";
			// 	$n = "";
			// 	$o = "";
			// 	if($j != '000'){
			// 		$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			// 		$uraian = "<span style='margin-left:20px;'> ". $getNamaBarang['nm_barang'] . "</span>";
			// 	}else{
			// 		$uraian = "<span style='margin-left:20px;'> ". $rincian_perhitungan . "</span>";
			// 	}
			// 	$jumlah = number_format($jumlah,2,',','.');
			// 	$jumlah_harga = number_format($jumlah_harga,2,',','.');
			// 	$volume_rek = number_format($volume_rek,0,',','.');
				
			// }
			if ( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && empty($id_rincian_belanja) ){
				//Rekening
						$boldStatus = "bold";
						$marginStatus = "20px;";

						$marginKode = "10px;";
						$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l = '0' and m='0' and n='00' and o='000'"));
						$getNamaRekening2 = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l = '$l' and m='0' and n='00' and o='000'"));
						$getNamaRekening3 = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l = '$l' and m='$m' and n='00' and o='000'"));
						$getNamaRekening4 = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l = '$l' and m='$m' and n='$n' and o='000'"));
						$getNamaRekening5 = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l = '$l' and m='$m' and n='$n' and o='$o'"));
						if(mysql_num_rows(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'")) == 0){
							$uraianList = "<span style='color:red;cursor:pointer' class='uraianList' id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>Belanja xxx</span>";
							$kode = "<span style='color:red;'>x.x.x.xx.xxx</span>";
						}else{
							$kode = $k.".".$l.".".$m.".".$n.".".$o;
							// $uraianList = $getNamaRekening['nm_rekening'];
							$uraianList = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening['nm_rekening']."</span>";
							$uraianList2 = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening2['nm_rekening']."</span>";
							$uraianList3 = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening3['nm_rekening']."</span>";
							$uraianList4 = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening4['nm_rekening']."</span>";
							$uraianList5 = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening5['nm_rekening']."</span>";
						}

						$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiRekening"));
						$jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
						$TampilCheckBox = "";

				$rekeningLevel1 .= "
								<tr valign='top'>
									<td align='left' class='GarisCetak5' >".$k."</td>
									<td align='left' class='GarisCetak5' style='font-weight: bold; padding-left: 10px;'>".$uraianList."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='left' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000; font-weight: bold;'>".$total."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;' ></td>
								</tr>
				";

				$rekeningLevel2 .= "
								<tr valign='top'>
									<td align='left' class='GarisCetak5' >".$k.".".$l."</td>
									<td align='left' class='GarisCetak5' style='font-weight: bold; padding-left: 15px;'>".$uraianList2."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='left' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000; font-weight: bold;'>".$jumlahHarga."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;' ></td>
								</tr>
				";

				$rekeningLevel3 .= "
								<tr valign='top'>
									<td align='left' class='GarisCetak5' >".$k.".".$l.".".$m."</td>
									<td align='left' class='GarisCetak5' style='font-weight: bold; padding-left: 20px;'>".$uraianList3."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='left' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000; font-weight: bold;'>".$jumlahHarga."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;' ></td>
								</tr>
				";

				$rekeningLevel4 .= "
								<tr valign='top'>
									<td align='left' class='GarisCetak5' >".$k.".".$l.".".$m.".".$n."</td>
									<td align='left' class='GarisCetak5' style='font-weight: bold; padding-left: 25px;'>".$uraianList4."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='left' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000; font-weight: bold;'>".$jumlahHarga."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;' ></td>
								</tr>
				";

              if (in_array($k, $arrayRekening1)) {
                $rekeningLevel1 = "";
              }
              $concatRekeningLevel2 = $k.".".$l;
              if (in_array($concatRekeningLevel2, $arrayRekening2)) {
                $rekeningLevel2 = "";
              }
              $concatRekeningLevel3 = $k.".".$l.".".$m;
              if (in_array($concatRekeningLevel3, $arrayRekening3)) {
                $rekeningLevel3 = "";
              }
              $concatRekeningLevel4 = $k.".".$l.".".$m.".".$n;
              if (in_array($concatRekeningLevel4, $arrayRekening4)) {
                $rekeningLevel4 = "";
              }

				$naonkitu .= "
								<tr valign='top'>
									<td align='left' class='GarisCetak5' >".$kode."</td>
									<td align='left' class='GarisCetak5' style='font-weight: bold; padding-left: 30px;'>".$uraianList5."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='left' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000; font-weight: bold;'>".$jumlahHarga."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;' ></td>
								</tr>
				";
			}elseif( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && empty($rincian_perhitungan)){
				 //RincianBelanja
				 $boldStatus = "";
				 $marginStatus = "10px;";
				 $kode = "";
				 $getNamaRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id_rincian_belanja'"));
				 $uraianList = $getNamaRincianBelanja['nama_rincian_belanja'];
				 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja='$id_rincian_belanja' $kondisiSKPD $kondisiRekening"));
				 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
				 $TampilCheckBox = "";

				 $naonkitu .= "
								<tr valign='top'>
									<td align='left' class='GarisCetak5' ></td>
									<td align='left' class='GarisCetak5' style='padding-left: 35px;'>".$uraianList."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='left' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'></td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;'>".$jumlahHarga."</td>
									<td align='right' class='GarisCetak5' style='border-top: 1px solid #000;' ></td>
								</tr>
				";
		}elseif( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && !empty($rincian_perhitungan) ){
				 //SubRincianBelanja
				 $boldStatus = "";
				 $marginStatus = "20px;";
				 $kode = "";
				 if($j !='000'){
					 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
					 $uraianList = " - ".$getNamaBarang['nm_barang'];
				 }else{
					 $uraianList = " - ".$rincian_perhitungan;
				 }
				 $volumeRekening = number_format($volume_rek ,0,',','.');
				 $getSatuan = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_anggaran'"));
				 $satuanRekening = $getSatuan['satuan_total'];
				 $hargaSatuan = number_format($jumlah ,2,',','.');
				 $jumlahHarga = number_format($jumlah_harga ,2,',','.');
				 $this->total += $jumlah_harga;
				 $TampilCheckBox = "";

				 $naonkitu .= "
								<tr valign='top'>
									<td align='center' class='GarisCetak5' ></td>
									<td align='left' class='GarisCetak5' style='padding-left: 40px;'>".$uraianList."</td>
									<td align='right' class='GarisCetak5' style='border: 1px dashed #000; border-right: 1px solid;'>".$volumeRekening."</td>
									<td align='left' class='GarisCetak5' style='border: 1px dashed #000; border-right: 1px solid;'>$satuanRekening</td>
									<td align='right' class='GarisCetak5' style='border: 1px dashed #000; border-right: 1px solid;'>".$hargaSatuan."</td>
									<td align='right' class='GarisCetak5' style='border: 1px dashed #000; border-right: 1px solid;'>".$jumlahHarga."</td>
									<td align='right' class='GarisCetak5' style='border: 1px dashed #000; border-right: 1px solid;' ></td>
								</tr>
				";
		}
			
			echo $rekeningLevel1.$rekeningLevel2.$rekeningLevel3.$rekeningLevel4.$naonkitu;
      $rekeningLevel1 = "";
      $rekeningLevel2 = "";
      $rekeningLevel3 = "";
      $rekeningLevel4 = "";
      $naonkitu = "";

      $arrayRekening1[] = $k;
      $arrayRekening2[] = $k.".".$l;
      $arrayRekening3[] = $k.".".$l.".".$m;
      $arrayRekening4[] = $k.".".$l.".".$m.".".$n;

			$no++;
		}
		echo 				"
							 </table>";		
		$getDataPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGGUNA' "));
			if (sizeof($arrayTandaTangan)==1) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '0' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '0' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));
            $titimangsa = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan"));
            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '0' "));

            $tandaTanganna .= "<br>
            <div class='ukurantulisan' style =' text-align:center; padding-bottom: 15px;'>
            ".$titimangsa[titimangsa_surat].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            <b>$hmm[jabatan]</b>
            <br>
            <br>
            <br>
            <br>
            <br>
            <span>".$hmm['nama']."</span>
            <hr style='border-top: 1px solid #000; margin-bottom: 5px; margin-top: 5px; width: 70%;'>
            <span style='margin-bottom: 5px;'>NIP ".$hmm['nip']."</span>
          
            
            </div>";

					}
			$sqlTimAnggaran = mysql_query("SELECT * from ref_tim_anggaran ORDER BY no_urut asc");
			while ($dataTimAnggaran = mysql_fetch_array($sqlTimAnggaran)) {
					$isiTimAnggaran .="
					<tr>
						<td style='text-align: center;' class='GarisCetak4'>$dataTimAnggaran[no_urut]</td>
						<td class='GarisCetak4'>$dataTimAnggaran[nama]</td>
						<td class='GarisCetak4'>$dataTimAnggaran[nip]</td>
						<td class='GarisCetak4'>$dataTimAnggaran[jabatan]</td>
						<td class='GarisCetak4'></td>
					</tr>
					";
				}
		echo 			
						"
						<table style='width:100.1%; border: 1px solid; margin-left: -1px;'>
							<tr>
								<td style='width: 50%; position: absolute;'><br>
									<div class='ukurantulisan'>
										<p style='padding-left: 2%;'>Ketarangan :</p>
											<p style='padding-left: 5%;'>- Tanggal Pembahasan</p>
											<p style='padding-left: 5%;'>- Catatan hasil pembahasan</p>
									</div>
								</td>
								<td style='width: 50%; border-left: 1px solid;'>
									".$tandaTanganna."
								</td>
							</tr>
						</table>
						
						<table class='cetak' border='1' style='width:100.1%; margin-left: -1px; margin-top: -0.1%;'>
								<thead>
									<tr>
										<th colspan='6' style='text-align: center; border: 1px solid; padding: 1.5px;'>
											<span style='font-size:16px;font-weight:bold;'>
												TIM ANGGARAN PEMERINTAH DAERAH
											</span>	
										</th>
									</tr>
									<tr>
										<th class='th02' >No.</th>
										<th class='th02' >NAMA</th>
										<th class='th02' >NIP</th>
										<th class='th02' >JABATAN</th>
										<th class='th02' >TANDA TANGAN</th>
									</tr>
									</thead>
									<tbody>
											".$isiTimAnggaran."
									</tbody>
						</table>

						<h5 class='pag pag1'>
							<span style='bottom: 2px; position: absolute; left:0;'>
							<hr style='width: 33cm; border-top: 1px solid #000; margin-bottom: 19px;'>
							</span>
							<span style='bottom: 2px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
						</h5>
  					<div class='insert'></div>
			</body>	
		</html>";
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



}
$rkaSKPD21New = new rkaSKPD21NewObj();

$arrayResult = VulnWalkerTahap_v2('RKA');
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$rkaSKPD21New->jenisForm = $jenisForm;
$rkaSKPD21New->nomorUrut = $nomorUrut;
$rkaSKPD21New->urutTerakhir = $nomorUrut;
$rkaSKPD21New->tahun = $tahun;
$rkaSKPD21New->jenisAnggaran = $jenisAnggaran;
$rkaSKPD21New->idTahap = $idTahap;
$rkaSKPD21New->username = $_COOKIE['coID'];

$rkaSKPD21New->wajibValidasi = $Main->wajibValidasi;
if($Main->wajibValidasi == TRUE){
	$rkaSKPD21New->sqlValidasi = " and status_validasi ='1' ";
}else{
	$rkaSKPD21New->sqlValidasi = " ";
}

if(empty($rkaSKPD21New->tahun)){

	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_2_1 "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rka_2_1 where id_anggaran = '$maxAnggaran'"));
	$rkaSKPD21New->tahun  = $get2['tahun'];
	$rkaSKPD21New->jenisAnggaran = $get2['jenis_anggaran'];
	$rkaSKPD21New->urutTerakhir = $get2['no_urut'];
	$rkaSKPD21New->jenisFormTerakhir = $get2['jenis_form_modul'];
	$rkaSKPD21New->urutSebelumnya = $rkaSKPD21New->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$rkaSKPD21New->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD21New->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$rkaSKPD21New->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaSKPD21New->idTahap'"));
	$rkaSKPD21New->currentTahap = $getCurrenttahap['nama_tahap'];

	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaSKPD21New->idTahap'"));
	$rkaSKPD21New->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$rkaSKPD21New->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD21New->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}


$setting = settinganPerencanaan_v2();
$rkaSKPD21New->provinsi = $setting['provinsi'];
$rkaSKPD21New->kota = $setting['kota'];
$rkaSKPD21New->pengelolaBarang = $setting['pengelolaBarang'];
$rkaSKPD21New->pejabatPengelolaBarang = $setting['pejabat'];
$rkaSKPD21New->pengurusPengelolaBarang = $setting['pengurus'];
$rkaSKPD21New->nipPengelola = $setting['nipPengelola'];
$rkaSKPD21New->nipPengurus = $setting['nipPengurus'];
$rkaSKPD21New->nipPejabat = $setting['nipPejabat'];


if($rkaSKPD21New->jenisForm != "PENYUSUNAN"){
$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_2_1 where jenis_form_modul = 'PENYUSUNAN' "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rka_2_1 where id_anggaran = '$maxAnggaran'"));
	$rkaSKPD21New->tahun  = $get2['tahun'];
	$rkaSKPD21New->jenisAnggaran = $get2['jenis_anggaran'];
	$rkaSKPD21New->urutTerakhir = $get2['no_urut'];
	$rkaSKPD21New->jenisFormTerakhir = $get2['jenis_form_modul'];
	$rkaSKPD21New->urutSebelumnya = $rkaSKPD21New->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$rkaSKPD21New->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD21New->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$rkaSKPD21New->currentTahap = $arrayHasil['currentTahap'];
			$rkaSKPD21New->jenisForm = "";
			$rkaSKPD21New->jenisFormTerakhir = "PENYUSUNAN";
			$rkaSKPD21New->idTahap = $get2['id_tahap'];
			$rkaSKPD21New->tahun = $get2['tahun'];
			$rkaSKPD21New->nomorUrut = $get2['no_urut'];
			$rkaSKPD21New->urutTerakhir = $get2['no_urut'];
}


?>
