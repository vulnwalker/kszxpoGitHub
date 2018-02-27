<?php

class dpaSKPD221NewObj  extends DaftarObj2{
	var $Prefix = 'dpaSKPD221New';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_dpa_2_2_1'; //bonus
	var $TblName_Hapus = 'tabel_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 7, 7, 7);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'DPA-SKPD';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='dpaSKPD221New.xls';
	var $namaModulCetak='DPA';
	var $Cetak_Judul = 'DPA';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'dpaSKPD221NewForm';
	var $modul = "DPA";
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
	var $provinsi = "";
	var $kota = "";
	var $pengelolaBarang = "";
	var $pejabatPengelolaBarang = "";
	var $pengurusPengelolaBarang = "";
	var $nipPengelola = "";
	var $nipPejabat = "";
	var $nipPengurus ="";

	var $publicVar = "";
	var $publicKondisi = "";
	var $publicExcept = array();
	var $publicGrupId = array();
	var $reportURL = "pages.php?Pg=dpaSKPD221&tipe=Laporan";

	var $publicSum = '';

	//buatview
	var $TampilFilterColapse = 0; //0

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
      $dt['e'] = $_REQUEST[$this->Prefix.'cmbUnit'];
      $dt['e1'] = $_REQUEST[$this->Prefix.'cmbSubUnit'];
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
		return 'DPA-SKPD 2.2.1 '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
	}
	function genRowSum($ColStyle, $Mode, $Total){
		foreach ($_REQUEST as $key => $value) {
		  	$$key = $value;
		 }
		 if($cmbSubUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
		if(!empty($hiddenP)){
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP'";
					if(!empty($q)){
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q'";
		}
		}
		}elseif($cmbUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
		}elseif($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}
	 	if(!empty($cmbBelanja)){
				if($cmbBelanja == "BELANJA PEGAWAI"){
					$kondisiRekening = "and k='5' and l ='2' and m ='1'";
				}elseif($cmbBelanja == "BELANJA BELANJA BARANG & JASA"){
					$kondisiRekening = "and k='5' and l ='2' and m ='2'";
				}elseif($cmbBelanja == "BELANJA MODAL"){
					$kondisiRekening = "and k='5' and l ='2' and m ='3'";
				}

		}
		if($this->wajibValidasi == TRUE)$tergantung = "<td class='GarisDaftar' align='center' ></td>";
		$ContentTotal =
		"<tr>
			<td class='$ColStyle' colspan='5' align='center'><b>Total </td>
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
	function setMenuEdit(){
	 if ($this->jenisForm == "READ"){
	 	$listMenu =
		//"<td>".genPanelIcon("javascript:".$this->Prefix.".Sync()","sync.png","Sync", 'Sync ')."</td>".
				//	"<td>".genPanelIcon("javascript:".$this->Prefix.".checkAlokasi()","alokasi.jpg","Alokasi", 'Alokasi')."</td>".

				//  "<td>".genPanelIcon("javascript:".$this->Prefix.".Posting()","publishdata.png","Posting ", 'Posting ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>"

					;
	 }else{
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }

		return $listMenu ;
	}
	function setMenuView(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";

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

    case 'pilihPangkat':{
      global $Main;
      $cek = ''; $err=''; $content=''; $json=TRUE;
      
      $idpangkat = $_REQUEST['pangkatakhir'];
      
      $query = "select concat(gol,'/',ruang)as nama FROM ref_pangkat WHERE nama='$idpangkat'" ;
      $get=mysql_fetch_array(mysql_query($query));$cek.=$query;
      $content=$get['nama'];                      
      break;
    }

		case 'Posting':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			if($this->jenisForm !='READ')$err = "Tahap Penyusunan Telah Habis";
				 if($err == ''){
						$fm = $this->Posting();
						$cek = $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
				 }

		break;
		}
		case 'formRincianVolume':{
				$dt = $_REQUEST['id'];
				$fm = $this->formRincianVolume($dt);
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
		case 'sync':{
		    if($this->jenisForm == 'READ'){
		        $nomorUrutRka = $this->nomorUrut - 1;
		        $getIdTahapRka = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '".$nomorUrutRka."' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));
		        $this->idTahapRka = $getIdTahapRka['id_tahap'];
		        $cek = "select * from view_rka_2_2_1 where id_tahap = '$this->idTahapRka' and rincian_perhitungan !=''";
		        $getAllSubRincian = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahapRka' and rincian_perhitungan !=''");
		        while($subRincian = mysql_fetch_array($getAllSubRincian)){
		              $queryCekProgram = "select * from view_dpa_2_2_1 where c1='0' and j = '000' and rincian_perhitungan = '' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='0' and id_tahap='$this->idTahap' ";
		              if(mysql_num_rows(mysql_query($queryCekProgram)) == 0){
		                $arrayProgram = array(
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
		                             'bk'=> $subRincian['bk'],
		                             'ck'=> $subRincian['ck'],
		                             'dk'=> $subRincian['dk'],
		                             'p' => $subRincian['p'],
		                             'q' => '0',
		                             'jenis_rka' => '2.2.1',
		                             'tahun' => $this->tahun,
		                             'jenis_anggaran' => $this->jenisAnggaran,
		                             'id_tahap' => $this->idTahap,
		                             'nama_modul' => 'DPA-SKPD',
		                             'id_rincian_belanja' => ""
		                              );
		                $queryInsertProgram = VulnWalkerInsert('tabel_dpa',$arrayProgram);
		                mysql_query($queryInsertProgram);
		              }

		              $queryCekKegiatan= "select * from view_dpa_2_2_1 where c1='0' and j = '000' and rincian_perhitungan = '' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='".$subRincian['q']."' and id_tahap='$this->idTahap' ";
		              if(mysql_num_rows(mysql_query($queryCekKegiatan)) == 0){
		                $arrayKegiatan = array(
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
		                             'bk'=> $subRincian['bk'],
		                             'ck'=> $subRincian['ck'],
		                             'dk'=> $subRincian['dk'],
		                             'p' => $subRincian['p'],
		                             'q' => $subRincian['q'],
		                             'k' => '0',
		                             'l' => '0',
		                             'm' => '0',
		                             'n' => '0',
		                             'o' => '0',
		                             'jenis_rka' => '2.2.1',
		                             'tahun' => $this->tahun,
		                             'jenis_anggaran' => $this->jenisAnggaran,
		                             'id_tahap' => $this->idTahap,
		                             'nama_modul' => 'DPA-SKPD',
		                             'id_rincian_belanja' => ""
		                              );
		                $queryInsertKegiatan = VulnWalkerInsert('tabel_dpa',$arrayKegiatan);
		                mysql_query($queryInsertKegiatan);
		              }

		              $queryCekRekening = "select * from view_dpa_2_2_1 where c1='0' and j = '000' and rincian_perhitungan = '' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='".$subRincian['q']."' and k ='".$subRincian['k']."' and l ='".$subRincian['l']."' and m ='".$subRincian['m']."' and n ='".$subRincian['n']."' and o ='".$subRincian['o']."' and id_rincian_belanja='' and id_tahap='$this->idTahap' ";
		              if(mysql_num_rows(mysql_query($queryCekRekening)) == 0){
		                $getRekening = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahapRka' and c1='0' and j = '000' and rincian_perhitungan = '' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='".$subRincian['q']."' and k ='".$subRincian['k']."' and l ='".$subRincian['l']."' and m ='".$subRincian['m']."' and n ='".$subRincian['n']."' and o ='".$subRincian['o']."' and id_rincian_belanja='' "));
		                $arrayRekening = array(
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
		                             'bk'=> $subRincian['bk'],
		                             'ck'=> $subRincian['ck'],
		                             'dk'=> $subRincian['dk'],
		                             'p' => $subRincian['p'],
		                             'q' => $subRincian['q'],
		                             'k' => $subRincian['k'],
		                             'l' => $subRincian['l'],
		                             'm' => $subRincian['m'],
		                             'n' => $subRincian['n'],
		                             'o' => $subRincian['o'],
		                             'sumber_dana' => $getRekening['sumber_dana'],
		                             'jenis_rka' => '2.2.1',
		                             'tahun' => $this->tahun,
		                             'jenis_anggaran' => $this->jenisAnggaran,
		                             'id_tahap' => $this->idTahap,
		                             'nama_modul' => 'DPA-SKPD',
		                             'id_rincian_belanja' => ""
		                              );
		                $queryInsertRekening = VulnWalkerInsert('tabel_dpa',$arrayRekening);
		                mysql_query($queryInsertRekening);
		              }

		              $queryCekRincianBelaja = "select * from view_dpa_2_2_1 where c1='".$subRincian['c1']."' and c = '".$subRincian['c']."' and d='".$subRincian['d']."' and  rincian_perhitungan = '' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='".$subRincian['q']."' and k ='".$subRincian['k']."' and l ='".$subRincian['l']."' and m ='".$subRincian['m']."' and n ='".$subRincian['n']."' and o ='".$subRincian['o']."' and id_rincian_belanja = '".$subRincian['id_rincian_belanja']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'";
		             if(mysql_num_rows(mysql_query($queryCekRincianBelaja)) == 0){
		               $arrayRincianBelanja = array(
		                            'c1' => $subRincian['c1'],
		                            'c' => $subRincian['c'],
		                            'd' => $subRincian['d'],
		                            'e' => '00',
		                            'e1' => '000',
		                            'f1' => '0',
		                            'f2' => '0',
		                            'f' => '00',
		                            'g' => '00',
		                            'h' => '00',
		                            'i' => '00',
		                            'j' => '000',
		                            'bk'=> $subRincian['bk'],
		                            'ck'=> $subRincian['ck'],
		                            'dk'=> $subRincian['dk'],
		                            'p' => $subRincian['p'],
		                            'q' => $subRincian['q'],
		                            'k' => $subRincian['k'],
		                            'l' => $subRincian['l'],
		                            'm' => $subRincian['m'],
		                            'n' => $subRincian['n'],
		                            'o' => $subRincian['o'],
		                            'jenis_rka' => '2.2.1',
		                            'tahun' => $this->tahun,
		                            'jenis_anggaran' => $this->jenisAnggaran,
		                            'id_tahap' => $this->idTahap,
		                            'nama_modul' => 'DPA-SKPD',
		                            'id_rincian_belanja' => $subRincian['id_rincian_belanja'],
		                            'rincian_perhitungan' => '',
		                             );
		               $queryRincianBelanja = VulnWalkerInsert('tabel_dpa',$arrayRincianBelanja);
		               mysql_query($queryRincianBelanja);
		             }


		             $queryCekSubRincian = "select * from view_dpa_2_2_1 where c1='".$subRincian['c1']."' and c = '".$subRincian['c']."' and d='".$subRincian['d']."' and  rincian_perhitungan = '".$subRincian['rincian_perhitungan']."' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='".$subRincian['q']."' and k ='".$subRincian['k']."' and l ='".$subRincian['l']."' and m ='".$subRincian['m']."' and n ='".$subRincian['n']."' and o ='".$subRincian['o']."' and id_rincian_belanja = '".$subRincian['id_rincian_belanja']."'  and f1 ='".$subRincian['f1']."' and f2='".$subRincian['f2']."' and f='".$subRincian['f']."' and g='".$subRincian['g']."' and h ='".$subRincian['h']."' and i ='".$subRincian['i']."' and j ='".$subRincian['j']."' and j1 ='".$subRincian['j1']."'  and id_tahap='$this->idTahap'";
		             if(mysql_num_rows(mysql_query($queryCekSubRincian)) == 0){
									 	if($subRincian['f']=='08'){
											 $jenisTransaksi = "PERSEDIAAN";
										}elseif($subRincian['id_jenis_pemeliharaan'] =='1'){
											$jenisTransaksi = "PEMELIHARAAN";
										}elseif($subRincian['id_jenis_pemeliharaan'] =='0' && !empty($subRincian['f']) && $subRincian['f'] !='08') {
											$jenisTransaksi = "PENGADAAN";
										}elseif (empty($subRincian['f']) == 'ya') {
											$jenisTransaksi = "ATRIBUSI";
										}
		                 $arraySubRincian = array(
		                              'c1' => $subRincian['c1'],
		                              'c' => $subRincian['c'],
		                              'd' => $subRincian['d'],
		                              'e' => '00',
		                              'e1' => '000',
		                              'f1' => $subRincian['f1'],
		                              'f2' => $subRincian['f2'],
		                              'f' => $subRincian['f'],
		                              'g' => $subRincian['g'],
		                              'h' => $subRincian['h'],
		                              'i' => $subRincian['i'],
		                              'j' => $subRincian['j'],
		                              'j1' => $subRincian['j1'],
		                              'bk'=> $subRincian['bk'],
		                              'ck'=> $subRincian['ck'],
		                              'dk'=> $subRincian['dk'],
		                              'p' => $subRincian['p'],
		                              'q' => $subRincian['q'],
		                              'k' => $subRincian['k'],
		                              'l' => $subRincian['l'],
		                              'm' => $subRincian['m'],
		                              'n' => $subRincian['n'],
		                              'o' => $subRincian['o'],
		                              'jenis_rka' => '2.2.1',
		                              'tahun' => $this->tahun,
		                              'jenis_anggaran' => $this->jenisAnggaran,
		                              'id_tahap' => $this->idTahap,
		                              'nama_modul' => 'DPA-SKPD',
		                              'id_rincian_belanja' => $subRincian['id_rincian_belanja'],
		                              'rincian_volume' => $subRincian['rincian_volume'],
		                              'volume_rek' => $subRincian['volume_rek'],
		                              'jumlah' => $subRincian['jumlah'],
		                              'jumlah_harga' => $subRincian['jumlah_harga'],
		                              'rincian_perhitungan' => $subRincian['rincian_perhitungan'],
		                              'jumlah1' => $subRincian['jumlah1'],
		                              'jumlah2' => $subRincian['jumlah2'],
		                              'jumlah3' => $subRincian['jumlah3'],
		                              'satuan1' => $subRincian['satuan1'],
		                              'satuan2' => $subRincian['satuan2'],
		                              'satuan3' => $subRincian['satuan3'],
		                              'satuan_total' => $subRincian['satuan_total'],
		                              'jenis_transaksi' => $jenisTransaksi,
																	'jenis_atribusi' => $subRincian['jenis_atribusi']
		                               );
		                 $queryInsertSubRincian = VulnWalkerInsert('tabel_dpa',$arraySubRincian);
		                 mysql_query($queryInsertSubRincian);
		             }






		    }

		}

		break;
		}
		case 'newSatuanSatuan':{
				$fm = $this->newSatuanSatuan($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'SaveSatuanSatuan':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $data = array( "satuan_rekening" => $namaSatuan,
			 				"type" => 'satuan'
			 				);
			 $query = VulnWalkerInsert("ref_satuan_rekening",$data);
			 $execute = mysql_query($query);
			 if($execute){

			 }else{
			 	$err = "input gagal";
			 }

			$content .= $query;
		break;
	    }
		case 'newSatuanVolume':{
				$fm = $this->newSatuanVolume($dt);
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
		case 'SaveSatuanVolume':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $data = array( "satuan_rekening" => $namaSatuan,
			 				"type" => 'volume'
			 				);
			 $query = VulnWalkerInsert("ref_satuan_rekening",$data);
			 $execute = mysql_query($query);
			 if($execute){

			 }else{
			 	$err = "input gagal";
			 }

			$content .= $query;
		break;
	    }
		case  'SaveRincianVolume':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$grabVolume = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id'"));

			$volumeRek = $grabVolume['volume_rek'];
			$data = array( 'jumlah1' => $jumlah1,
						   'satuan1' => $satuan1,
						   'jumlah2' => $jumlah2,
						   'satuan2' => $satuan2,
						   'jumlah3' => $jumlah3,
						   'satuan3' => $satuan3,
						   'jumlah4' => $jumlahTotal,
						   'satuan_total' => $satuanTotal,
						  );

			$query = VulnWalkerUpdate('tabel_anggaran',$data,"id_anggaran = '$id' ");
			if($volumeRek != $jumlahTotal ){
				$err = "Total Rincian Tidak Sama";
			}elseif( (!empty($jumlah1) && empty($satuan1) ) || (!empty($jumlah2) && empty($satuan2) || (!empty($jumlah3) && empty($satuan3)  || (!empty($jumlahTotal) && empty($satuanTotal) ) ) )  ){
				$err = "Pilih satuan";
			}else{
				mysql_query($query);
			}

			$content = array('query' => $query,"volumeRek" => $volumeRek);



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
		// 	}elseif(empty($hiddenP)){
		// 		$err = "Pilih Program";
		// 	}elseif(empty($q)){
		// 		$err = "Pilih Kegiatan";
		// 	}else{
		// 		if(mysql_num_rows(mysql_query("select * from skpd_report_dpa_2_2_1 where username= '$this->username'")) == 0){
		// 			$data = array(
		// 						  'username' => $this->username,
		// 						  'c1' => $cmbUrusan,
		// 						  'c' => $cmbBidang,
		// 						  'd' => $cmbSKPD,
		// 						  'bk' => $bk,
		// 						  'ck' => $ck,
		// 						  'p' => $hiddenP,
		// 						  'q' => $q,

		// 						  );
		// 			$query = VulnWalkerInsert('skpd_report_dpa_2_2_1',$data);
		// 			mysql_query($query);
		// 		}else{
		// 			$data = array(
		// 						  'username' => $this->username,
		// 						  'c1' => $cmbUrusan,
		// 						  'c' => $cmbBidang,
		// 						  'd' => $cmbSKPD,
		// 						  'bk' => $bk,
		// 						  'ck' => $ck,
		// 						  'p' => $hiddenP,
		// 						  'q' => $q,

		// 						  );
		// 			$query = VulnWalkerUpdate('skpd_report_dpa_2_2_1',$data,"username = '$this->username'");
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
								  'e' => $cmbUnit,
								  'e1' => $cmbSubUnit,
								  'bk' => $bk,
								  'ck' => $ck,
								  'dk' => $dk,
								  'p' => $hiddenP,
								  'q' => $q,

              );
      if(mysql_num_rows(mysql_query("select * from skpd_report_dpa_2_2_1 where username= '$this->username'")) == 0){
        $query = VulnWalkerInsert('skpd_report_dpa_2_2_1',$data);
      }else{
        $query = VulnWalkerUpdate('skpd_report_dpa_2_2_1',$data,"username = '$this->username'");
      }
      mysql_query($query);
        }
      $content = array('to' => $jenisKegiatan,'urusan' => $cmbUrusan, 'bidang' => $cmbBidang, 'skpd' => $cmbSKPD, 'namaPemda' => $namaPemda[option_value], 'cetakjang' => $cetakjang, 'e' => $cmbUnit, 'e1' => $cmbSubUnit, 'bk' => $bk, 'ck' => $ck, 'dk' => $dk, 'p' => $hiddenP, 'q' => $q, 'ttd' => $ttd );
    break;
    }

		case 'Laporan':{
			$fm = $this->Laporan($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
		break;
		}
		case 'dpaSKPD221':{
      $json = FALSE;
      $this->dpaSKPD221();
    break;
    }
		case 'clearTemp':{
				$username =$_COOKIE['coID'];
				mysql_query("delete from temp_rka_221 where user ='$username'");
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

		case 'Remove':{
			$id = $_REQUEST['dpaSKPD221New_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$id[0]'"));
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

			$getAll = mysql_query("select * from view_dpa_2_2_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and (rincian_perhitungan !='' or f!='00' )   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and p='$hiddenP' and q='$q' order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rincian_volume where user='$username'");
		    mysql_query("delete from temp_alokasi_rka where user='$username'");
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				}
				mysql_query("delete from tabel_anggaran where id_anggaran = '$id_anggaran'");
				mysql_query("delete from tabel_anggaran where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and o1 ='$o1' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and jenis_rka='2.2.1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");
			}

			break;
		}




		case 'formAlokasi':{

				$fm = $this->formAlokasi();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}
		case 'formAlokasiTriwulan':{
				$fm = $this->formAlokasiTriwulan();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}

		case 'checkAlokasi':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$c1 = $cmbUrusan;
			$c = $cmbBidang;
			$d = $cmbSKPD;
			$p = $hiddenP;
			$terpilih = $dpaSKPD221New_cb[0];



			if($this->jenisForm != "READ"){
				$err = "Tahap Telah Habis";
			}else{
				$getKodeRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$terpilih'"));
				$k = $getKodeRekening['k'];
				$l = $getKodeRekening['l'];
				$m = $getKodeRekening['m'];
				$n = $getKodeRekening['n'];
				$o = $getKodeRekening['o'];
				$jenisAlokasi = "";
				if(mysql_num_rows(mysql_query("select * from tabel_spd where tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c='$c' and d ='$d' and bk ='$bk' and ck ='$ck' and p='$p' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka = '2.2.1' and jenis_dpa = 'DPA-SKPD'")) != 0){
					$getAlokasi = mysql_fetch_array(mysql_query("select * from tabel_spd where tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c='$c' and d ='$d' and bk ='$bk' and ck ='$ck' and p='$p' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka = '2.2.1' and jenis_dpa = 'DPA-SKPD'"));
					foreach ($getAlokasi as $key => $value) {
						  $$key = $value;
					}
					$jenisAlokasi = $jenis_alokasi_kas;
				}
			}

			$content = array("jenis" => $jenisAlokasi)	;

		break;
		}
		case 'saveAlokasi' : {
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if($this->jenisForm != "READ"){
				$err = "Tahap Telah Habis";
			}else{

				if(empty($jenisAlokasi)){
					$err = "Pilih jenis alokasi";
				}
				if($jenisAlokasi == 'BULANAN'){
					if( $jan == '' || $feb == '' || $mar == '' || $apr == '' || $mei == '' || $jun == '' || $jul == '' || $agu == '' || $sep == '' || $okt == '' || $nop == '' || $des == ''   ){
						$err = "Lengkapi alokasi";
					}
				}
				if($jenisAlokasi == 'TRIWULAN'   ){
					if( $mar == '' ||  $jun == '' ||  $sep == '' ||  $des == ''   ){
						$err = "Lengkapi alokasi";
					}
				}
				if($jumlahHargaAlokasi != $jumlahHarga){
					$err = "Jumlah Alokasi Salah ";
				}

				if($err == ""){
					$getKodeRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$idRekening'"));
					$k = $getKodeRekening['k'];
					$l = $getKodeRekening['l'];
					$m = $getKodeRekening['m'];
					$n = $getKodeRekening['n'];
					$o = $getKodeRekening['o'];
					if(mysql_num_rows(mysql_query("select * from tabel_spd where tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c='$c' and d ='$d' and bk ='$bk' and ck ='$ck' and p='$p' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o'  and jenis_rka ='2.2.1'  and jenis_dpa = 'DPA-SKPD'")) == 0){
						$data = array(
									'c1' => $c1,
									'c' => $c,
									'd' => $d,
									'bk' => $bk,
									'ck' => $ck,
									'p' => $p,
									'q' => $q,
									'q' => $q,
									'k' => $k,
									'l' => $l,
									'm' => $m,
									'n' => $n,
									'o' => $o,
									'total' => $jumlahHarga,
									'jenis_alokasi_kas' => $jenisAlokasi,
									"alokasi_jan" => $jan,
									"alokasi_feb" => $feb,
									"alokasi_mar" => $mar,
									"alokasi_apr" => $apr,
									"alokasi_mei" => $mei,
									"alokasi_jun" => $jun,
									"alokasi_jul" => $jul,
									"alokasi_agu" => $agu,
									"alokasi_sep" => $sep,
								    "alokasi_okt" => $okt,
									"alokasi_nop" => $nop,
									"alokasi_des" => $des,
									"jenis_rka" => '2.2.1',
									"jenis_dpa" => 'DPA-SKPD',
									"tahun" => $this->tahun,
									"anggaran" => $this->jenisAnggaran
									);
						$cek = VulnWalkerInsert('tabel_spd',$data);
						mysql_query(VulnWalkerInsert('tabel_spd',$data));
					}else{
						$grepId = mysql_fetch_array(mysql_query("select * from tabel_spd where tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c='$c' and d ='$d' and bk ='$bk' and ck ='$ck' and p='$p' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o'  and jenis_dpa = 'DPA-SKPD' and jenis_rka = '2.2.1'"));
						$id = $grepId['id'];
						$data = array(
										'jenis_alokasi_kas' => $jenisAlokasi,
										"alokasi_jan" => $jan,
										"alokasi_feb" => $feb,
										"alokasi_mar" => $mar,
										"alokasi_apr" => $apr,
										"alokasi_mei" => $mei,
										"alokasi_jun" => $jun,
										"alokasi_jul" => $jul,
										"alokasi_agu" => $agu,
										"alokasi_sep" => $sep,
									    "alokasi_okt" => $okt,
										"alokasi_nop" => $nop,
										"alokasi_des" => $des,

										);
						$cek = VulnWalkerUpdate('tabel_spd',$data, "id = '$id' ");
						mysql_query(VulnWalkerUpdate('tabel_spd',$data, "id = '$id' "));
					}






				}
			}
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
		 <A href=\"pages.php?Pg=dpaSKPD221New\" title='BELANJA' style='color:blue;' > BELANJA </a> |
		 <A href=\"pages.php?Pg=dpaSKPD1PAD\" title='PENDAPATAN' > PENDAPATAN </a> |
		 <A href=\"pages.php?Pg=dpaSKPD31\" title='dpa-SKPKD MURNI' > PEMBIAYAAN </a> |
		 <A href=\"pages.php?Pg=dpaSKPD\" title='dpa-SKPKD MURNI' > dpa-SKPD  </a>

		 &nbsp&nbsp&nbsp
		 </td></tr>

		 <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		 <A href=\"pages.php?Pg=dpaSKPD221New\" title='BELANJA LANGSUNG' style='color:blue;' > LANGSUNG </a> |
		 <A href=\"pages.php?Pg=dpaSKPD21\" title='BELANJA TIDAK LANGSUNG' > TIDAK LANGSUNG </a>

		 &nbsp&nbsp&nbsp
		 </td></tr>
		 <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		 <A href=\"pages.php?Pg=dpaSKPD221New\" title='INPUT' style='color:blue;' > INPUT </a> |
		 <A href=\"pages.php?Pg=dpaSKPD22\" title='REKAP' > REKAP </a>

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
			<script type='text/javascript' src='js/perencanaan/rka/popupBarang.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/popup_rekening/popupRekening.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/dpa/dpaSKPD221N.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaan_v2/dpa/alokasi/alokasidpaSKPD221New.js' language='JavaScript'></script>
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
	 $this->form_caption = 'INFO ALOKASI DPA-SKPD 2.2.1';






	 //items ----------------------
	   $this->form_fields = array(
			'listDetailVolume' => array(
						'label'=>'',
						'value'=>"

						<div id='listAlokasidpaSKPD221New'  width=10px></div>",

						'type'=>'merge'
					 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Tutup' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){


/*		 $arrayResult = VulnWalkerTahap_v2('RKA');
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $id_tahap = $arrayResult['id_tahap'];*/

	 	if($this->wajibValidasi == TRUE)$tergantung = "<th class='th01' rowspan='2' width='100' >VALIDASI</th>";
		$headerTable =
		  "<thead>
		   <tr>

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


	 $NomorColSpan = $Mode==1? 2: 1;


		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
		  			$$key = $value;
	 }
	//  foreach ($_REQUEST as $key => $value) {
	// 	  			$$key = $value;
	//  }

	if(isset($_REQUEST['cmbUrusan']) && $_REQUEST['cmbUrusan']== ''){
		$_REQUEST['cmbBidang'] = "";
		$_REQUEST['cmbSKPD'] = "";
		$_REQUEST['hiddenP'] = "";
		$_REQUEST['cmbUnit'] = "";
		$_REQUEST['cmbSubUnit'] = "";
	 }elseif(isset($_REQUEST['cmbBidang']) && $_REQUEST['cmbBidang']== ''){
		$_REQUEST['cmbSKPD'] = "";
		$_REQUEST['hiddenP'] = "";
		$_REQUEST['cmbUnit'] = "";
		$_REQUEST['cmbSubUnit'] = "";
	 }elseif(isset($_REQUEST['cmbSKPD']) && $_REQUEST['cmbSKPD']== ''){
		$_REQUEST['hiddenP'] = "";
		$_REQUEST['cmbUnit'] = "";
		$_REQUEST['cmbSubUnit'] = "";
	 }elseif(isset($_REQUEST['cmbUnit']) && $_REQUEST['cmbUnit']== ''){
		$_REQUEST['cmbSubUnit'] = "";
	 }

	 if(isset($_REQUEST['hiddenP']) && $_REQUEST['hiddenP'] == ''){
			$_REQUEST['q'] = "";
	 }

	if($_REQUEST['cmbSubUnit'] != ''){
		$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."' and d='".$_REQUEST['cmbSKPD']."' and e='".$_REQUEST['cmbUnit']."' and e1='".$_REQUEST['cmbSubUnit']."'";
	if(!empty($_REQUEST['hiddenP'])){
			$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."' and d='".$_REQUEST['cmbSKPD']."' and e='".$_REQUEST['cmbUnit']."' and e1='".$_REQUEST['cmbSubUnit']."' and bk='".$_REQUEST['bk']."' and ck='".$_REQUEST['ck']."' and dk='".$_REQUEST['dk']."' and p='".$_REQUEST['hiddenP']."'";
				if(!empty($_REQUEST['q'])){
			$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."' and d='".$_REQUEST['cmbSKPD']."' and e='".$_REQUEST['cmbUnit']."' and e1='".$_REQUEST['cmbSubUnit']."' and bk='".$_REQUEST['bk']."' and ck='".$_REQUEST['ck']."' and dk='".$_REQUEST['dk']."' and p='".$_REQUEST['hiddenP']."' and q='".$_REQUEST['q']."'";
	}
	}
	}elseif($_REQUEST['cmbUnit'] != ''){
		$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."' and d='".$_REQUEST['cmbSKPD']."' and e='".$_REQUEST['cmbUnit']."' ";
	}elseif($_REQUEST['cmbSKPD'] != ''){
		$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."' and d='".$_REQUEST['cmbSKPD']."'  ";
	}elseif($_REQUEST['cmbBidang'] != ''){
		$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."'  ";
	}elseif($_REQUEST['cmbUrusan'] != ''){
		$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."'";
	}
	if(!empty($_REQUEST['cmbBelanja'])){
			if($_REQUEST['cmbBelanja'] == "BELANJA PEGAWAI"){
				$kondisiBelanja = "and k='5' and l ='2' and m ='1'";
			}elseif($_REQUEST['cmbBelanja'] == "BELANJA BELANJA BARANG & JASA"){
				$kondisiBelanja = "and k='5' and l ='2' and m ='2'";
			}elseif($_REQUEST['cmbBelanja'] == "BELANJA MODAL"){
				$kondisiBelanja = "and k='5' and l ='2' and m ='3'";
			}

		}



	// if($this->jenisForm == 'PENYUSUNAN'){



	$Koloms = array();
	if(!empty($p) && $q== '0'){
			 //Program
			 $boldStatus = "bold";
			 $kode = $bk.".".$ck.".".$dk.".".$p;
			 $getNamaKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='0'"));
			 $uraianList = $getNamaKegiatan['nama'];
			 $kodeRekening = "";
			 $TampilCheckBox = "";
			 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' $kondisiSKPD $kondisiRekening"));
			 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
	}elseif(!empty($p) && !empty($q) && empty($k) && empty($l) && empty($m)  && empty($n)  && empty($o)  && empty($id_rincian_belanja) ){
			 //Kegiatan
			 $boldStatus = "bold";
			 $marginStatus = "10px;";
			 $kode = $bk.".".$ck.".".$dk.".".$p.".".$q;
			 $getNamaKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'"));
			 $uraianList = $getNamaKegiatan['nama'];
			 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' $kondisiSKPD $kondisiRekening"));
			 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
		 //	$kodeRekening = $this->injectQuery;
	}elseif(!empty($p) && !empty($q) && !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && empty($id_rincian_belanja) ){
			 //Rekening
			 $boldStatus = "bold";
			 $marginStatus = "20px;";
			 $kode = $k.".".$l.".".$m.".".$n.".".$o;
			 $marginKode = "10px;";
			 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $uraianList = $getNamaRekening['nm_rekening'];
			 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiRekening"));
			 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
			 $TampilCheckBox = "";
	}elseif(!empty($p) && !empty($q) && !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && empty($rincian_perhitungan)){
			 //RincianBelanja
			 $boldStatus = "";
			 $marginStatus = "30px;";
			 $kode = "";
			 $getNamaRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id_rincian_belanja'"));
			 $uraianList = $getNamaRincianBelanja['nama_rincian_belanja'];
			 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja='$id_rincian_belanja' $kondisiSKPD $kondisiRekening"));
			 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
			 $TampilCheckBox = "";
	}elseif(!empty($p) && !empty($q) && !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && !empty($rincian_perhitungan) ){
			 //SubRincianBelanja
			 $boldStatus = "";
			 $marginStatus = "40px;";
			 $kode = "";
			 if($j !='000'){
 				if($f == '08'){
 					$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1'"));
 					$uraianList = "<span style='color:$colorList;cursor:pointer;' onclick=$this->Prefix.editSubRincian($id_anggaran);> - ".$getNamaBarang['nm_barang']." </span>";
 				}else{
 					$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' "));
 					$uraianList = "<span style='color:$colorList;cursor:pointer;' onclick=$this->Prefix.editSubRincian($id_anggaran);> - ".$getNamaBarang['nm_barang']." </span>";
 				}
 			}else{
 				$uraianList = "<span style='color:$colorList;cursor:pointer;' onclick=$this->Prefix.editSubRincian($id_anggaran);> - ".$rincian_perhitungan."</span>";
 			}
			 $volumeRekening = number_format($volume_rek ,0,',','.');
			 $satuanRekening = $satuan_total;
			 $hargaSatuan = number_format($jumlah ,2,',','.');
			 $jumlahHarga = number_format($jumlah_harga ,2,',','.');
			 $this->total += $jumlah_harga;
			 $TampilCheckBox = "";
	}
	$Koloms[] = array(' align="left"', "<span style='color:$warnaMapping;margin-left:$marginKode;'>$kode</span>" );
	$Koloms[] = array(' align="left"', "<span style='font-weight:$boldStatus;margin-left:$marginStatus'>$uraianList</span> <div style='float:right'>".$isi['rincian_volume']."</div>" );
	$Koloms[] = array(' align="right"', $volumeRekening );
	$Koloms[] = array(' align="left"', $satuanRekening );
	$Koloms[] = array(' align="right"', $hargaSatuan );
	$Koloms[] = array(' align="right"',  "<span style='font-weight:$boldStatus;'>$jumlahHarga </span>" );
			 //$Koloms[] = array(' align="right"', $catatan );


			// if(!empty($cmbSKPD) && empty($cmbUnit)){
			// 	if(in_array($id_anggaran, $this->publicExcept)) {
			//
			// 	}elseif($j != '000' && mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and id_tahap = '$this->idTahap' ")) > 1 ){
			// 		$Koloms = array();
			// 	}
			// }







	// }

	 return $Koloms;
	}



	function Validasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI DPA-SKPD 2.2.1';
	 $kode = $dt['c1'].".".$dt['c'].".".$dt['d'];
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
						'label'=>'KODE dpaSKPD221New',
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
	     if($CurrentQ !='' ){
	      $_REQUEST['p'] = $CurrentBK.".".$CurrentCK.".".$CurrentDK.".".$CurrentP;
	      $_REQUEST['q'] =  $CurrentQ;
	      $selectedE1 = $CurrentSubUnit;
	      $selectedE = $CurrentUnit;
	      $selectedD = $CurrentSKPD;
	      $selectedC = $CurrentBidang;
	      $selectedC1 = $CurrentUrusan;

	    }elseif($CurrentP !='' ){
	      $_REQUEST['p'] = $CurrentBK.".".$CurrentCK.".".$CurrentDK.".".$CurrentP;
	      $selectedE1 = $CurrentSubUnit;
	      $selectedE = $CurrentUnit;
	      $selectedD = $CurrentSKPD;
	      $selectedC = $CurrentBidang;
	      $selectedC1 = $CurrentUrusan;

	    }elseif($CurrentSubUnit !='000' ){
	      $selectedE1 = $CurrentSubUnit;
	      $selectedE = $CurrentUnit;
	      $selectedD = $CurrentSKPD;
	      $selectedC = $CurrentBidang;
	      $selectedC1 = $CurrentUrusan;

	    }elseif($CurrentUnit !='00' ){
	      $selectedE = $CurrentUnit;
	      $selectedD = $CurrentSKPD;
	      $selectedC = $CurrentBidang;
	      $selectedC1 = $CurrentUrusan;

	    }elseif($CurrentSKPD !='00' ){
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

	$arrayProgram = explode(".",$_REQUEST['p']);
	$selectedBK = $arrayProgram[0];
	$selectedCK = $arrayProgram[1];
	$selectedDK = $arrayProgram[2];
	$selectedP = $arrayProgram[3];
	$selectedQ = $_REQUEST['q'];

	foreach ($_COOKIE as $key => $value) {
	        $$key = $value;
	    }


	  if($VulnWalkerSubUnit != '000'){
	    $selectedE1 = $VulnWalkerSubUnit;
	    $selectedE = $VulnWalkerUnit;
	    $selectedD = $VulnWalkerSKPD;
	    $selectedC = $VulnWalkerBidang;
	    $selectedC1 = $VulnWalkerUrusan;
	  }elseif($VulnWalkerUnit != '00'){
	    $selectedE = $VulnWalkerUnit;
	    $selectedD = $VulnWalkerSKPD;
	    $selectedC = $VulnWalkerBidang;
	    $selectedC1 = $VulnWalkerUrusan;
	  }elseif($VulnWalkerSKPD != '00'){
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
	  $urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=dpaSKPD221New.refreshList(true);','-- URUSAN --');

	  $codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
	  $bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=dpaSKPD221New.refreshList(true);','-- BIDANG --');

	  $codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
	  $skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=dpaSKPD221New.refreshList(true);','-- SKPD --');

	  $codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e!='00' and e1='000' ";
	  $unit = cmbQuery('cmbUnit',$selectedE,$codeAndNameUnit,'onchange=dpaSKPD221New.refreshList(true);','-- UNIT --');


	  $codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1!='000' ";
	  $subunit = cmbQuery('cmbSubUnit',$selectedE1,$codeAndNameSubUnit,'onchange=dpaSKPD221New.refreshList(true);','-- SUB UNIT --');



	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran) as max from view_renja where tahun='$this->tahun' and jenis_anggaran = 'MURNI' "));
	$maxID = $get1['max'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_renja where id_anggaran = '$maxID' "));
	$nomorUrutSebelumnya =  $get2['no_urut'];




	  $codeAndNameProgram = mysql_query("select tabel_anggaran.bk, tabel_anggaran.ck, tabel_anggaran.dk, tabel_anggaran.p as pFromProgram, tabel_anggaran.q  , ref_program.nama from tabel_anggaran  inner join ref_program on tabel_anggaran.bk = ref_program.bk and tabel_anggaran.ck = ref_program.ck and tabel_anggaran.dk = ref_program.dk and tabel_anggaran.p = ref_program.p and tabel_anggaran.q = ref_program.q  inner join ref_tahap_anggaran on tabel_anggaran.id_tahap = ref_tahap_anggaran.id_tahap where ref_tahap_anggaran.no_urut = '$nomorUrutSebelumnya' and tabel_anggaran.tahun ='$this->tahun' and tabel_anggaran.jenis_anggaran = '$this->jenisAnggaran' and tabel_anggaran.c1 = '$selectedC1' and tabel_anggaran.c = '$selectedC' and tabel_anggaran.d = '$selectedD'  and tabel_anggaran.q='0' and concat(tabel_anggaran.bk,'.',tabel_anggaran.ck,'.',tabel_anggaran.dk,'.',tabel_anggaran.p) !='0.0.0.0'  ");

	$pSama = "";
	$arrayP = array() ;
	while($rows = mysql_fetch_array($codeAndNameProgram)){
	  foreach ($rows as $key => $value) {
	        $$key = $value;
	  }

	    $concat = $bk.".".$ck.".".$dk.".".$pFromProgram ;
	    if($concat != ".."){
	      if($concat == $pSama){
	      }else{
	        if(mysql_num_rows(mysql_query("select * from view_renja where q !='0' and concat(bk,'.',ck,'.',dk,'.',p) ='$concat' and tahun ='$this->tahun' and jenis_anggaran ='MURNI'")) != 0){
	          array_push($arrayP,
	            array($concat,$nama  )
	          );
	        }

	      }
	    }






	  $pSama = $concat;
	}

	$program = "<input type='hidden' id='bk' name='bk' value='$selectedBK'> <input type='hidden' id='ck' name='ck' value='$selectedCK'> <input type='hidden' id='dk' name='dk' value='$selectedDK'> <input type='hidden' id='hiddenP' name='hiddenP' value='$selectedP'>".cmbArray('p',$_REQUEST['p'],$arrayP,'-- PROGRAM --','onchange=dpaSKPD221New.programChanged();');


	  $codeAndNameKegiatan = mysql_query("select tabel_anggaran.bk, tabel_anggaran.ck, tabel_anggaran.dk, tabel_anggaran.p, tabel_anggaran.q, ref_program.nama from tabel_anggaran  inner join ref_program on tabel_anggaran.bk = ref_program.bk and tabel_anggaran.ck = ref_program.ck and tabel_anggaran.dk = ref_program.dk and tabel_anggaran.p = ref_program.p and tabel_anggaran.q = ref_program.q  inner join ref_tahap_anggaran on tabel_anggaran.id_tahap = ref_tahap_anggaran.id_tahap where  ref_tahap_anggaran.no_urut = '$nomorUrutSebelumnya' and tabel_anggaran.tahun ='$this->tahun' and tabel_anggaran.jenis_anggaran = '$this->jenisAnggaran' and tabel_anggaran.c1 = '$selectedC1' and tabel_anggaran.c = '$selectedC' and tabel_anggaran.d = '$selectedD' and tabel_anggaran.q !='0' and tabel_anggaran.bk='$selectedBK' and tabel_anggaran.ck='$selectedCK' and tabel_anggaran.dk='$selectedDK' and tabel_anggaran.p='$selectedP'  ");

	$qSama = "";
	$arrayQ = array() ;
	while($rows = mysql_fetch_array($codeAndNameKegiatan)){
	  foreach ($rows as $key => $value) {
	        $$key = $value;
	  }
	  if($q != 0) {
	    if($q == $qSama){
	    }else{
	      array_push($arrayQ,
	         array($q,$nama)
	      );
	    }
	  }




	  $qSama = $q;
	}

	$kegiatan = cmbArray('q',$_REQUEST['q'],$arrayQ,'-- KEGIATAN --','onchange=dpaSKPD221New.refreshList(true);');


	if($this->jenisForm == "KOREKSI" || $this->jenisForm == "PENYUSUNAN" || $this->jenisForm == "VALIDASI"){
	  $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
	  $idTahapRenja = $getIdTahapRenjaTerakhir['max'];

	  $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
	  $getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$this->idTahap'  "));
	  $cekDulu=mysql_num_rows(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja'"));
	  if($cekDulu == 0){
	    $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
	    $getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$this->idTahap'  "));

	  }
	  $angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');

	  $sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
	  $sisaPagu =  number_format($sisaPagu ,2,',','.');
	  $paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";

	}else{
	  $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
	  $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
	  $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
	  $cekDulu = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
	  $getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  "));

	  if($cekDulu ==0){
	    $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
	    $getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  "));

	  }
	  $angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');

	  $sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
	  $sisaPagu =  number_format($sisaPagu ,2,',','.');
	  $paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";

	}
	$arrayBelanja = array(
	             array('BELANJA PEGAWAI','BELANJA PEGAWAI'),
	             array('BELANJA BELANJA BARANG & JASA','BELANJA BARANG & JASA'),
	             array('BELANJA MODAL','BELANJA MODAL'),
	        );
	$cmbBelanja = cmbArray('cmbBelanja',$_REQUEST['cmbBelanja'],$arrayBelanja,'-- JENIS BELANJA--','onchange=dpaSKPD221New.refreshList(true);');


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
	    "</div>"."<div class='FilterBar' style='margin-top:5px;'>".
	    "<table style='width:100%'>
	    <tr>
	    <td>PROGRAM</td>
	    <td>:</td>
	    <td style='width:86%;'>$this->injectQuery
	    <input type='hidden' name='tahun' id='tahun' value='$this->tahun' style='width:40px;' > <input type='hidden' name ='cmbJenisRKA' id='cmbJenisRKA' value='2.2.1'>
	    ".$program."
	    </td>
	    </tr>
	    <tr>
	    <td>KEGIATAN</td>
	    <td>:</td>
	    <td style='width:86%;'>
	    ".$kegiatan."
	    </td>
	    </tr>
	    </table>".
	    "</div>"."<div class='FilterBar' style='margin-top:5px;'>"."
	    <table style='width:100%'>
	    <tr>
	    <td>PAGU INDIKATIF</td>
	    <td>:</td>
	    <td style='width:86%;'>
	    ".$paguIndikatif."&nbsp &nbsp JENIS BELANJA &nbsp : $cmbBelanja "."
	    </td>
	    </tr>
	    <tr>
	    <td>UNIT</td>
	    <td>:</td>
	    <td style='width:86%;'>
	    ".$unit."&nbsp&nbsp SUB UNIT &nbsp".$subunit."
	    </td>
	    </tr>

	    </table>"

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
	  if(isset($q)){
	    $data = array("CurrentUrusan" => $cmbUrusan,
	          "CurrentBidang" => $cmbBidang,
	          "CurrentSKPD" => $cmbSKPD,
	           "CurrentUnit" => $cmbUnit,
	            "CurrentSubUnit" => $cmbSubUnit,
	          "CurrentBK" => $bk,
	          "CurrentCK" => $ck,
	          "CurrentDK" => $dk,
	          "CurrentP" => $hiddenP,
	          "CurrentQ" => $q,

	          );
	  }elseif(isset($hiddenP)){
	    $data = array("CurrentUrusan" => $cmbUrusan,
	          "CurrentBidang" => $cmbBidang,
	          "CurrentSKPD" => $cmbSKPD,
	           "CurrentUnit" => $cmbUnit,
	            "CurrentSubUnit" => $cmbSubUnit,
	          "CurrentBK" => $bk,
	          "CurrentCK" => $ck,
	          "CurrentDK" => $dk,
	          "CurrentP" => $hiddenP,

	          );
	  }elseif(isset($cmbSubUnit)){
	    $data = array("CurrentUrusan" => $cmbUrusan,
	          "CurrentBidang" => $cmbBidang,
	          "CurrentSKPD" => $cmbSKPD,
	           "CurrentUnit" => $cmbUnit,
	            "CurrentSubUnit" => $cmbSubUnit,

	          );
	  }elseif(isset($cmbUnit)){
	    $data = array("CurrentUrusan" => $cmbUrusan,
	          "CurrentBidang" => $cmbBidang,
	          "CurrentSKPD" => $cmbSKPD,
	           "CurrentUnit" => $cmbUnit,

	          );
	  }elseif(isset($cmbSKPD)){
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
	     if($CurrentQ !='' ){
	      $_REQUEST['q'] = $CurrentQ;
	      $_REQUEST['hiddenP'] = $CurrentP;
	      $_REQUEST['bk'] = $CurrentBK;
	      $_REQUEST['ck'] = $CurrentCK;
	      $_REQUEST['dk'] = $CurrentDK;
	      $selectedQ =  $CurrentQ;
	      $cmbSubUnit = $CurrentSubUnit;
	      $cmbUnit = $CurrentUnit;
	      $cmbSKPD = $CurrentSKPD;
	      $cmbBidang = $CurrentBidang;
	      $cmbUrusan = $CurrentUrusan;

	    }elseif($CurrentP !='' ){
	      $_REQUEST['hiddenP'] = $CurrentP;
	      $_REQUEST['bk'] = $CurrentBK;
	      $_REQUEST['ck'] = $CurrentCK;
	      $_REQUEST['dk'] = $CurrentDK;
	      $cmbSubUnit = $CurrentSubUnit;
	      $cmbUnit = $CurrentUnit;
	      $cmbSKPD = $CurrentSKPD;
	      $cmbBidang = $CurrentBidang;
	      $cmbUrusan = $CurrentUrusan;

	    }elseif($CurrentSubUnit !='000' ){
	      $cmbSubUnit = $CurrentSubUnit;
	      $cmbUnit = $CurrentUnit;
	      $cmbSKPD = $CurrentSKPD;
	      $cmbBidang = $CurrentBidang;
	      $cmbUrusan = $CurrentUrusan;

	    }elseif($CurrentUnit !='00' ){
	      $cmbUnit = $CurrentUnit;
	      $cmbSKPD = $CurrentSKPD;
	      $cmbBidang = $CurrentBidang;
	      $cmbUrusan = $CurrentUrusan;

	    }elseif($CurrentSKPD !='00' ){
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
	    $hiddenP = "";
	    $cmbUnit = "";
	    $cmbSubUnit = "";
	   }elseif(isset($cmbBidang) && $cmbBidang== ''){
	    $cmbSKPD = "";
	    $hiddenP = "";
	    $cmbUnit = "";
	    $cmbSubUnit = "";
	   }elseif(isset($cmbSKPD) && $cmbSKPD== ''){
	    $hiddenP = "";
	    $cmbUnit = "";
	    $cmbSubUnit = "";
	    if(isset($hiddenP) && $hiddenP == ''){
	          $q = "";
	     }
	   }elseif(isset($cmbUnit) && $cmbUnit== ''){
	    $cmbSubUnit = "";
	   }




	   if($cmbSubUnit != ''){
	    // $arrKondisi[] = "c1 = '$cmbUrusan'";
	    // $arrKondisi[] = "c = '$cmbBidang'";
	    // $arrKondisi[] = "d = '$cmbSKPD'";
	    // $arrKondisi[] = "e = '$cmbUnit'";
	    // $arrKondisi[] = "e1 = '$cmbSubUnit'";
	    $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
	    if(!empty($hiddenP)){
	        $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' $kondisiRekening";

	        // $arrKondisi[] = "ck = '$ck' ";
	        // $arrKondisi[] = "bk = '$bk' ";
	        // $arrKondisi[] = "dk = '$dk' ";
	        // $arrKondisi[] = " p = '$hiddenP'  ";
	        if(!empty($q)){
	          $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q= '$q' $kondisiRekening";
	          //$arrKondisi[] = "q = '$q' ";
	        }
	    }
	    }elseif($cmbUnit != ''){
	      // $arrKondisi[] = "c1 = '$cmbUrusan'";
	      // $arrKondisi[] = "c = '$cmbBidang'";
	      // $arrKondisi[] = "d = '$cmbSKPD'";
	      // $arrKondisi[] = "e = '$cmbUnit'";
	      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
	      if(!empty($hiddenP)){
	        $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' $kondisiRekening";

	        // $arrKondisi[] = "ck = '$ck' ";
	        // $arrKondisi[] = "bk = '$bk' ";
	        // $arrKondisi[] = "dk = '$dk' ";
	        // $arrKondisi[] = " p = '$hiddenP'  ";
	        if(!empty($q)){
	          $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q= '$q' $kondisiRekening";
	          //$arrKondisi[] = "q = '$q' ";
	        }
	    }
	    }elseif($cmbSKPD != ''){
	      // $arrKondisi[] = "c1 = '$cmbUrusan'";
	      // $arrKondisi[] = "c = '$cmbBidang'";
	      // $arrKondisi[] = "d = '$cmbSKPD'";
	      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
	      if(!empty($hiddenP)){
	        $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' $kondisiRekening";
	        if(!empty($cmbUnit)){
	          $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' $kondisiRekening";
	          if(!empty($cmbSubUnit)){
	            $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' $kondisiRekening";


	          }
	        }
	        // $arrKondisi[] = "ck = '$ck' ";
	        // $arrKondisi[] = "bk = '$bk' ";
	        // $arrKondisi[] = "dk = '$dk' ";
	        // $arrKondisi[] = " p = '$hiddenP'  ";
	  if(!empty($q)){
	        $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q' $kondisiRekening";
	        if(!empty($cmbUnit)){
	          $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q' $kondisiRekening";
	          if(!empty($cmbSubUnit)){
	            $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q' $kondisiRekening";
	          }
	        }
	        //$arrKondisi[] = "q = '$q' ";
	      }
	  }
	    }elseif($cmbBidang != ''){
	      // $arrKondisi[] = "c1 = '$cmbUrusan'";
	      // $arrKondisi[] = "c = '$cmbBidang'";
	      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
	    }elseif($cmbUrusan != ''){
	      // $arrKondisi[] = "c1 = '$cmbUrusan'";
	      $kondisiSKPD = "and c1='$cmbUrusan'";
	    }
	    if(!empty($cmbBelanja)){
	      if($cmbBelanja == "BELANJA PEGAWAI"){
	        // $arrKondisi[] = "k = '5'";
	        // $arrKondisi[] = "l = '2'";
	        // $arrKondisi[] = "m = '1'";
	        $kondisiRekening = " and k='5' and l ='2' and m ='1'";
	      }elseif($cmbBelanja == "BELANJA BELANJA BARANG & JASA"){
	        // $arrKondisi[] = "k = '5'";
	        // $arrKondisi[] = "l = '2'";
	        // $arrKondisi[] = "m = '2'";
	        $kondisiRekening = " and k='5' and l ='2' and m ='2'";
	      }elseif($cmbBelanja == "BELANJA MODAL"){
	        // $arrKondisi[] = "k = '5'";
	        // $arrKondisi[] = "l = '2'";
	        // $arrKondisi[] = "m = '3'";
	        $kondisiRekening = " and k='5' and l ='2' and m ='3'";
	      }

	    }

	  $bk = $_REQUEST['bk'];
	  $ck= $_REQUEST['ck'];
	  $dk= $_REQUEST['dk'];
	  $hiddenP = $_REQUEST['hiddenP'];
	  $q = $_REQUEST['q'];
	  $hublaBK = $_REQUEST['bk'];
	  $hublaCK = $_REQUEST['ck'];
	  $hublaDK = $_REQUEST['dk'];
	  $hublaP = $_REQUEST['hiddenP'];
	  $hublaQ = $_REQUEST['q'];


	  //$arrKondisi[] = "c1 != '0'";


	    // $nomorUrutSebelumnya = $this->nomorUrut;
	    // $getAllParent = mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap'  and o1 !='0' and k='0' and n='0' and j='000'  ");
	    // while($rows = mysql_fetch_array($getAllParent)){
	    // 	foreach ($rows as $key => $value) {
	    //  	 $$key = $value;
	    // 	}
	    // 	$cekPekerjaan = mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where o1 = '$o1' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
	    // 	if($cekPekerjaan == 0){
	    // 		$arrKondisi[] = "o1 !='$o1'";
	    // 	}else{
	    // 		$arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id' ";
	    // 		$getAllRekening = mysql_query("select * from view_dpa_2_2_1 where id_tahap = '$this->idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
	    // 		while($row2s = mysql_fetch_array($getAllRekening)){
	    // 			foreach ($row2s as $key => $value) {
	    // 		 	 $$key = $value;
	    // 			}
	    // 			$cekRekening = mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
	    // 			if($cekRekening == 0){
	    // 				$concat = $k.".".$l.".".$m.".".$n.".".$o;
	    // 				$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
	    // 			}else{
	    // 				$arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id'  ";
	    // 				$getAllProgram = mysql_query("select * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
	    // 				while($row3s = mysql_fetch_array($getAllProgram)){
	    // 					foreach ($row3s as $key => $value) {
	    // 				 	 $$key = $value;
	    // 					}
	    // 					$cekProgram = mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
	    // 					if($cekProgram == 0){
	    // 						$concat = $bk.".".$ck.".".$dk.".".$p;
	    // 						$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)  !='$concat'";
	    // 					}else{
	    // 						$arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id'   ";
	    // 						$getAllKegiatan = mysql_query("select * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
	    // 						while($row4s = mysql_fetch_array($getAllKegiatan)){
	    // 							foreach ($row4s as $key => $value) {
	    // 						 	 $$key = $value;
	    // 							}
	    // 							$cekKegiatan = mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
	    // 							if($cekKegiatan == 0){
	    // 								$concat = $bk.".".$ck.".".$dk.".".$p;
	    // 								$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)  !='$concat'";
	    // 							}else{
	    // 								$arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id'   ";
	    //
	    //
	    // 							}
	    // 						}
	    //
	    // 					}
	    // 				}
	    //
	    // 			}
	    // 		}
	    // 	}
	    // }


	      // $grabNonMapingRekening= mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and (LENGTH(k) > 1) and j='000'");
	      // while($got = mysql_fetch_array($grabNonMapingRekening)){
	      // 	if(mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' ) $kondisiRekening $kondisiSKPD ")) != 0){
	      // 		$arrKondisi[] = "id_tahap = '$this->idTahap' or id ='".$got['id']."'";
	      // 	}
	      //
	      // }
	      //
	      // $grabNonHostedRekening= mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and (LENGTH(k) = 1 and k !='0') and j='000'");
	      // while($got = mysql_fetch_array($grabNonHostedRekening)){
	      // 	if(mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' ) $kondisiRekening $kondisiSKPD ")) != 0){
	      // 		$arrKondisi[] = "id_tahap = '$this->idTahap' or id ='".$got['id']."'";
	      // 	}
	      //
	      // }

	  $blackListSubRincian = array();
	  $getAllSubRincian = mysql_query("select * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and (j!='000' or rincian_perhitungan !='' )");
	  while($subRincian = mysql_fetch_array($getAllSubRincian)){
	        if(mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and id='".$subRincian['id']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening")) == 0){
	            $blackListSubRincian[] = "id != '".$subRincian['id']."'";
	            $arrKondisi[] = "id !='".$subRincian['id']."'";
	            // $this->injectQuery = "select * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and id='".$subRincian['id']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening";
	        }
	  }
	  $kondisiBlackListSubRincian= join(' and ',$blackListSubRincian);
	  if(sizeof($blackListSubRincian) == 0){
	    $kondisiBlackListSubRincian = "";
	  }elseif(sizeof($blackListSubRincian) > 0){
	    $kondisiBlackListSubRincian = " and ".$kondisiBlackListSubRincian;
	  }

	  $blackListRincian = array();
	  $getAllRincian =  mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja != '' and id_rincian_belanja !='0' and j='000' and rincian_perhitungan = '' ");
	  while($rincianBelanja = mysql_fetch_array($getAllRincian)){
	      if(mysql_num_rows(mysql_query("select  * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk = '".$rincianBelanja['bk']."' and ck = '".$rincianBelanja['ck']."' and dk = '".$rincianBelanja['dk']."' and p = '".$rincianBelanja['p']."' and q = '".$rincianBelanja['q']."' and k = '".$rincianBelanja['k']."' and l = '".$rincianBelanja['l']."'  and m = '".$rincianBelanja['m']."'  and n = '".$rincianBelanja['n']."' and o = '".$rincianBelanja['o']."' and id_rincian_belanja = '".$rincianBelanja['id_rincian_belanja']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	          $blackListRincian[] = "id !='".$rincianBelanja['id']."'";
	          $arrKondisi[] = "id !='".$rincianBelanja['id']."'";
	      }

	  }

	  $blackListRekening = array();
	  $getAllRekening =  mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
	  while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
	      if(mysql_num_rows(mysql_query("select  * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	          $blackListRekening[] = "id !='".$rekeningBelanja['id']."'";
	          $arrKondisi[] = "id !='".$rekeningBelanja['id']."'";
	      }
	  }


	  $blackListKegiatan = array();
	  $getAllKegiatan =  mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k ='0' and l ='0'  and m ='0'   and n ='0'  and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
	  while($kegiatanBelanja = mysql_fetch_array($getAllKegiatan)){
	      if(mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and bk = '".$kegiatanBelanja['bk']."' and ck = '".$kegiatanBelanja['ck']."' and dk = '".$kegiatanBelanja['dk']."' and p = '".$kegiatanBelanja['p']."' and q = '".$kegiatanBelanja['q']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	          $blackListKegiatan[] = "id !='".$kegiatanBelanja['id']."'";
	          $arrKondisi[] = "id !='".$kegiatanBelanja['id']."'";
	      }
	  }

	  $blackListKegiatan = array();
	  $getAllProgram =  mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q ='0'  ");
	  while($programBelanja = mysql_fetch_array($getAllProgram)){
	      if(mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and bk = '".$programBelanja['bk']."' and ck = '".$programBelanja['ck']."' and dk = '".$programBelanja['dk']."' and p = '".$programBelanja['p']."'  and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	          $arrKondisi[] = "id !='".$programBelanja['id']."'";
	          $arrKondisi[] = "id !='".$programBelanja['id']."'";
	      }
	  }









	  $arrKondisi[] = "id_tahap = '$this->idTahap' ";
	  $arrKondisi[] = "tahun = '$this->tahun'";
	  $arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
	  $Kondisi= join(' and ',$arrKondisi);
	  $Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;
	  $this->publicKondisi = $Kondisi;

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
   $this->form_caption = 'LAPORAN DPA-SKPD 2.2.1 MURNI';

   $c1 = $dt['cmbUrusan'];
   $c = $dt['cmbBidang'];
   $d = $dt['cmbSKPD'];
   $e = $dt['cmbUnit'];
   $e1 = $dt['cmbSubUnit'];
   $bk = $dt['bk'];
   $ck = $dt['ck'];
   $dk = $dt['dk'];
   $p = $dt['hiddenP'];
   $q = $dt['q'];

     $arrayJenisLaporan = array(
                 array('dpaSKPD221', 'DPA-SKPD 2.2.1 MURNI'),
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
      "<input type='button' value='Batal' onclick ='".'dpaSKPD221'.".Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

function dpaSKPD221($xls =FALSE){
		global $Main;
		$getJenisReport = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL' "));
    $getJenisUkuran = $getJenisReport['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTangan = explode(';', $getJenisReport['tanda_tangan']);


		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}




		// $grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_dpa_2_2_1 where username='$this->username'"));
		$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit]; $bk =  $_GET[bk]; $ck = $_GET[ck]; $dk = $_GET[dk]; $hiddenP = $_GET[p]; $q = $_GET[q];
		foreach ($grabSKPD as $key => $value) { 
				  $$key = $value; 
			}
		$cmbUrusan = $c1;
		$cmbBidang = $c;
		$cmbSKPD = $d;
		$cmbUnit = $e;
		$cmbSubUnit = $e1;
		$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and dk ='$dk' and p='$hiddenP' and q='$q'";

		$blackListSubRincian = array();
	  $getAllSubRincian = mysql_query("select * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and (j!='000' or rincian_perhitungan !='' )");
	  while($subRincian = mysql_fetch_array($getAllSubRincian)){
	        if(mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and id='".$subRincian['id']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening")) == 0){
	            $blackListSubRincian[] = "id != '".$subRincian['id']."'";
	            $arrKondisi[] = "id !='".$subRincian['id']."'";
	            // $this->injectQuery = "select * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and id='".$subRincian['id']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening";
	        }
	  }
	  $kondisiBlackListSubRincian= join(' and ',$blackListSubRincian);
	  if(sizeof($blackListSubRincian) == 0){
	    $kondisiBlackListSubRincian = "";
	  }elseif(sizeof($blackListSubRincian) > 0){
	    $kondisiBlackListSubRincian = " and ".$kondisiBlackListSubRincian;
	  }

	  $blackListRincian = array();
	  $getAllRincian =  mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja != '' and id_rincian_belanja !='0' and j='000' and rincian_perhitungan = '' ");
	  while($rincianBelanja = mysql_fetch_array($getAllRincian)){
	      if(mysql_num_rows(mysql_query("select  * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk = '".$rincianBelanja['bk']."' and ck = '".$rincianBelanja['ck']."' and dk = '".$rincianBelanja['dk']."' and p = '".$rincianBelanja['p']."' and q = '".$rincianBelanja['q']."' and k = '".$rincianBelanja['k']."' and l = '".$rincianBelanja['l']."'  and m = '".$rincianBelanja['m']."'  and n = '".$rincianBelanja['n']."' and o = '".$rincianBelanja['o']."' and id_rincian_belanja = '".$rincianBelanja['id_rincian_belanja']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	          $blackListRincian[] = "id !='".$rincianBelanja['id']."'";
	          $arrKondisi[] = "id !='".$rincianBelanja['id']."'";
	      }

	  }

	  $blackListRekening = array();
	  $getAllRekening =  mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
	  while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
	      if(mysql_num_rows(mysql_query("select  * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	          $blackListRekening[] = "id !='".$rekeningBelanja['id']."'";
	          $arrKondisi[] = "id !='".$rekeningBelanja['id']."'";
	      }
	  }


	  $blackListKegiatan = array();
	  $getAllKegiatan =  mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k ='0' and l ='0'  and m ='0'   and n ='0'  and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
	  while($kegiatanBelanja = mysql_fetch_array($getAllKegiatan)){
	      if(mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and bk = '".$kegiatanBelanja['bk']."' and ck = '".$kegiatanBelanja['ck']."' and dk = '".$kegiatanBelanja['dk']."' and p = '".$kegiatanBelanja['p']."' and q = '".$kegiatanBelanja['q']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	          $blackListKegiatan[] = "id !='".$kegiatanBelanja['id']."'";
	          $arrKondisi[] = "id !='".$kegiatanBelanja['id']."'";
	      }
	  }

	  $blackListKegiatan = array();
	  $getAllProgram =  mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q ='0'  ");
	  while($programBelanja = mysql_fetch_array($getAllProgram)){
	      if(mysql_num_rows(mysql_query("select * from view_dpa_2_2_1 where id_tahap ='$this->idTahap' and bk = '".$programBelanja['bk']."' and ck = '".$programBelanja['ck']."' and dk = '".$programBelanja['dk']."' and p = '".$programBelanja['p']."'  and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	          $arrKondisi[] = "id !='".$programBelanja['id']."'";
	          $arrKondisi[] = "id !='".$programBelanja['id']."'";
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
		$qry ="select * from view_dpa_2_2_1 where $Kondisi order by urut";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];


		//Get Id Awal Renja

		$getIdRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) from view_renja where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and bk='$hublaBK' and ck='$hublaCK' and p='$hiddenP' and q='$hublaQ' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$idRenja = $getIdRenja['min(id_anggaran)'];
		$getDetailRenja = mysql_fetch_array(mysql_query("select * from detail_renja where id_anggaran = '$idRenja'"));
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
							padding: 3px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead { display: table-header-group; }
						.GarisCetak{
							border-left-color: transparent;
						}
						table.cetak th.th01{
							border-left-color: transparent;
						}
						table.cetak th.th02{
							border-left-color: transparent;
						}
						td{
							font-size: 13px;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width: $width; font-family: sans-serif; margin-left :1cm; height: $height; border: 1px solid #000; border-bottom-color: transparent;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>

							<table style='width: 100%; margin-bottom: 0.4%;'>
								<tr>
									<!-- <th class='th02' rowspan='2' style='width: 12%; border: 1px solid;'>
										<img src='".getImageReport()."' style='width: 90%; height: 10%; margin: 5%;'>
									</th> -->
									<th class='th02' rowspan='2' style='text-align: center;'>
										<span style='font-size:18px;font-weight:bold;'>
											DOKUMEN PERLAKSANAAN ANGGARAN<br> SATUAN KERJA PERANGKAT DAERAH
										</span>
									</th>
									<th class='th02' rowspan='1' colspan='6' style='text-align: center; border-left: 1px solid;'>
										NOMOR DPA SKPD
									</th>
									<th class='th02' rowspan='2' style='text-align: center; width: 20%; border-left: 1px solid; border-bottom: 1px solid;'>
										<span style='font-size: 14px; font-weight: bold;'>
											Formulir<br> DPA - SKPD<br> 2.2.1
										</span>
									</th>
								</tr>
								<tr>
									<th class='th02' style='border-bottom: 1px solid; border-top: 1px solid; border-right: 1px solid; text-align: center;'>
										x.xx
									</th>
									<th class='th02' style='border-bottom: 1px solid; border-top: 1px solid; border-right: 1px solid; text-align: center;'>
										xx
									</th>
									<th class='th02' style='border-bottom: 1px solid; border-top: 1px solid; border-right: 1px solid; text-align: center;'>
										00
									</th>
									<th class='th02' style='border-bottom: 1px solid; border-top: 1px solid; border-right: 1px solid; text-align: center;'>
										00
									</th>
									<th class='th02' style='border-bottom: 1px solid; border-top: 1px solid; border-right: 1px solid; text-align: center;'>
										5
									</th>
									<th class='th02' style='border-bottom: 1px solid; border-top: 1px solid; border-right: 1px solid; text-align: center;'>
										2
									</th>
								</tr>
								<tr style='border-bottom: 1px solid;'>
									<th class='th02' colspan='9' style='text-align: center; border-top: 1px solid; border-right: 1px solid; padding: 4px;'>
										<span style='font-weight: bold; font-size: 14px; text-transform: uppercase;'>
											PEMERINTAH KABUPATEN ".$kota[kota]."<br>
										</span>
										<span class='ukurantulisanIdPenerimaan' style='font-size: 14px; font-weight: 100;'>TAHUN ANGGARAN : $this->tahun </span>
									</th>
								</tr>
							</table>";

							$queryViewRenja = mysql_query("SELECT * from view_renja where jenis_anggaran = 'MURNI' and no_urut = '2' and c1='$cmbUrusan' and c = '$cmbBidang' and d = '$cmbSKPD' and e = '00' and e1 = '000' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$hiddenP' and q = '$q' ");
									while ($isiQueryViewRenja = mysql_fetch_array($queryViewRenja)) {
										$queryDetailRenja = mysql_query("SELECT * from detail_renja where id_anggaran = ".$isiQueryViewRenja[id_anggaran]." ");
										while ($isiQueryDetailRenja = mysql_fetch_array($queryDetailRenja)) {
											$lokasiKegiatan = $isiQueryDetailRenja[lokasi_kegiatan];
							echo "


				<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='15%' valign='top' style='padding-left: 0.5%;'>URUSAN PEMERINTAHAN</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.". </td>
						<td valign='top'>$urusan</td>
					</tr>
					<tr >
						<td width='10%' valign='top' style='padding-left: 0.5%;'>ORGANISASI</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.". </td>
						<td valign='top'>$bidang</td>
					</tr>
					<tr >
						<td width='10%' valign='top' style='padding-left: 0.5%;'>PROGRAM</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.".".$cmbSKPD.genNumber($hublaBK).genNumber($hublaCK).genNumber($hublaP).".  </td>
						<td valign='top'>$program</td>
					</tr>
					<tr >
						<td width='10%' valign='top' style='padding-left: 0.5%;'>KEGIATAN</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.".".$cmbSKPD.genNumber($hublaBK).genNumber($hublaCK).genNumber($hublaP).".".genNumber($hublaQ)." </td>
						<td valign='top'>$kegiatan</td>
					</tr>
					<tr >
						<td width='10%' valign='top' style='padding-left: 0.5%;'>WAKTU PELAKSANAAN</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top' colspan='2'>".$isiQueryDetailRenja['tanggal_mulai']."</td>
					</tr>
					<tr >
						<td width='10%' valign='top' style='padding-left: 0.5%;'>LOKASI KEGIATAN</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top' colspan='2'>".$lokasiKegiatan."</td>
					</tr>
					<tr >
						<td width='10%' valign='top' style='padding-left: 0.5%;'>SUMBER DANA</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top' colspan='2'>".$isiQueryViewRenja['sumber_dana']."</td>
					</tr>


				</table>
				";
}}
				$queryViewRenja = mysql_query("SELECT * from view_renja where jenis_anggaran = 'MURNI' and no_urut = '2' and c1='$cmbUrusan' and c = '$cmbBidang' and d = '$cmbSKPD' and e = '00' and e1 = '000' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$hiddenP' and q = '$q' ");
									while ($isiQueryViewRenja = mysql_fetch_array($queryViewRenja)) {
										$queryDetailRenja = mysql_query("SELECT * from detail_renja where id_anggaran = ".$isiQueryViewRenja[id_anggaran]." ");
										while ($isiQueryDetailRenja = mysql_fetch_array($queryDetailRenja)) {
											$lokasiKegiatan = $isiQueryDetailRenja[lokasi_kegiatan];

				echo "
				<br>
				<table class='cetak' style='width:100%; border-bottom: 1px solid; margin-left: 0px; margin-top: -0.8%; margin-bottom: -1.2%;'>
				<thead>
					<tr>
						<th style='text-align: center; border-top: 1px solid; padding: 5px;' colspan='3'>
							INDIKATOR & TOLAK UKUR KINERJA BELANJA LANGSUNG
						</th>
					</tr>
					<tr>
						<th class='th01' width = '200' style='font-size: 12px;'>INDIKATOR</th>
						<th class='th01' style='font-size: 12px;'>TOLAK UKUR KINERJA</th>
						<th class='th01' style='font-size: 12px;'>TERGET KINERJA</th>
					</tr>
				</thead>
					<tr>
						<td  valign='top' class = 'GarisCetak' style='font-weight: bold;'>CAPAIAN PROGRAM</td>
						<td  valign='top' class = 'GarisCetak'>".$isiQueryDetailRenja['capaian_program_tuk']."</td>
						<td  valign='top' class = 'GarisCetak'>".$isiQueryDetailRenja['capaian_program_tk']."</td>
					</tr>
					<tr>
						<td  valign='top' class = 'GarisCetak' style='font-weight: bold;'>MASUKAN</td>
						<td  valign='top' class = 'GarisCetak'>".$isiQueryDetailRenja['masuk_tuk']."</td>
						<td  valign='top' class = 'GarisCetak'>".$isiQueryDetailRenja['masuk_tk']."</td>
					</tr>
					<tr>
						<td  valign='top' class = 'GarisCetak' style='font-weight: bold;'>KELUARAN</td>
						<td  valign='top' class = 'GarisCetak'>".$isiQueryDetailRenja['keluaran_tuk']."</td>
						<td  valign='top' class = 'GarisCetak'>".$isiQueryDetailRenja['keluaran_tk']."</td>
					</tr>
					<tr>
						<td valign='top' class = 'GarisCetak' style='font-weight: bold;'>HASIL</td>
						<td  valign='top' class = 'GarisCetak'>".$isiQueryDetailRenja['hasil_tuk']."</td>
						<td  valign='top' class = 'GarisCetak'>".$isiQueryDetailRenja['hasil_tk']."</td>
					</tr>
					<tr>
						<td valign='top' class = 'GarisCetak' colspan='3' style='font-weight: bold;'>KELOMPOK SASARAN KEGIATAN : ".$isiQueryDetailRenja['kelompok_sasaran_kegiatan']."</td>
					</tr>

				</table>
				<br>
				";

			}}
		echo "
								<table class='cetak' style='width:100.1%; border-bottom: 1px solid; margin-left: -1px;'>
								<thead>
									<tr>
										<th style='text-align: center; border-top: 1px solid;' colspan='10'>
											RINCIAN DOKUMEN PELAKSANAAN ANGGARAN BELANJA LANGSUNG<br> PROGRAM DAN PER KEGIATAN SATUAN KERJA PERANGKAT DAERAH
										</th>
									</tr>
									<tr>
										<th class='th01' rowspan='2' >KODE<br> REKENING</th>
										<th class='th01' rowspan='2' >URAIAN</th>
										<th class='th02' rowspan='1' colspan='3' >Rincian Perhitungan</th>
										<th class='th01' rowspan='2' >JUMLAH (Rp)</th>

									</tr>
									<tr>
										<th class='th01' >VOLUME</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >HARGA SATUAN</th>
									</tr>
								</thead>

		";
		$getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_2_2_1 where $Kondisi  "));
		$total = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}

			if (!empty($p) && !empty($q) && !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && empty($id_rincian_belanja) ){
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

						$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiRekening"));
						$jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
						$TampilCheckBox = "";

						$getDataViewDPA221 = mysql_fetch_array(mysql_query("select * from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiRekening"));

            // $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' $kondisiSKPD $kondisiRekening"));
            // $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');


						
							$rekeningLevel1 = "
								<tr valign='top'>
												<td align='left' class='GarisCetak5' >".$k."</td>
												<td align='left' class='GarisCetak5' style='font-weight: bold; padding-left: 10px;'>".$uraianList."</td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='left' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid; border-left: 1px solid; border-right: 1px solid;'>".$total."</td>
											</tr>
							";

							$rekeningLevel2 = "
											<tr valign='top'>
												<td align='left' class='GarisCetak5' >".$k.".".$l."</td>
												<td align='left' class='GarisCetak5' style='font-weight: bold; padding-left: 15px;'>".$uraianList2."</td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='left' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid; border-left: 1px solid; border-right: 1px solid;' >".$jumlahHarga."</td>
											</tr>
							";

							$rekeningLevel3 = "
											<tr valign='top'>
												<td align='left' class='GarisCetak5' >".$k.".".$l.".".$m."</td>
												<td align='left' class='GarisCetak5' style='font-weight: bold; padding-left: 20px;'>".$uraianList3."</td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='left' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-left: 1px solid; border-right: 1px solid;'>".$jumlahHarga."</td>
											</tr>
							";

							$rekeningLevel4 = "
											<tr valign='top'>
												<td align='left' class='GarisCetak5' >".$k.".".$l.".".$m.".".$n."</td>
												<td align='left' class='GarisCetak5' style='font-weight: bold; padding-left: 25px;'>".$uraianList4."</td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='left' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-left: 1px solid; border-right: 1px solid;'>".$jumlahHarga."</td>
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

							$naonkitu = "
											<tr valign='top'>
												<td align='left' class='GarisCetak5' >".$kode."</td>
												<td align='left' class='GarisCetak5' style='font-weight: bold; padding-left: 30px;'>".$uraianList5."</td>
												<td align='right' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='left' class='GarisCetak5' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='right' class='GarisCetak55' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'></td>
												<td align='right' class='GarisCetak55' style='font-weight: bold; border: 1px solid #000; border-right: 1px solid; border-left: 1px solid;'>".$jumlahHarga."</td>
											</tr>
							";
				
					}elseif(!empty($p) && !empty($q) && !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && empty($rincian_perhitungan)){
					 //RincianBelanja
					 $boldStatus = "";
					 $marginStatus = "30px;";
					 $kode = "";
					 $getNamaRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id_rincian_belanja'"));
					 $uraianList = $getNamaRincianBelanja['nama_rincian_belanja'];
					 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja='$id_rincian_belanja' $kondisiSKPD $kondisiRekening"));
					 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
					 $TampilCheckBox = "";

					 $naonkitu = "
													<tr valign='top'>
														<td align='left' class='GarisCetak5' ></td>
														<td align='left' class='GarisCetak5' style='padding-left: 35px;'>".$uraianList."</td>
														<td align='right' class='GarisCetak5' style='border: 1px dashed #504d4d; border-right: 1px solid #000; border-left: 1px solid #000;'></td>
														<td align='left' class='GarisCetak5' style='border: 1px dashed #504d4d; border-right: 1px solid #000; border-left: 1px solid #000;'></td>
														<td align='right' class='GarisCetak5' style='border: 1px dashed #504d4d; border-right: 1px solid #000; border-left: 1px solid #000;'></td>
														<td align='right' class='GarisCetak5' style='border: 1px dashed #504d4d; border-right: 1px solid #000; border-left: 1px solid #000;'>".$jumlahHarga."</td>
													</tr>
									";
			}elseif(!empty($p) && !empty($q) && !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && !empty($rincian_perhitungan) ){
			 //SubRincianBelanja
			 $boldStatus = "";
			 $marginStatus = "40px;";
			 $kode = "";
			 if($j !='000'){
 				if($f == '08'){
 					$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1'"));
 					$uraianList = "<span style='color:$colorList;cursor:pointer;' onclick=$this->Prefix.editSubRincian($id_anggaran);> - ".$getNamaBarang['nm_barang']." </span>";
 				}else{
 					$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' "));
 					$uraianList = "<span style='color:$colorList;cursor:pointer;' onclick=$this->Prefix.editSubRincian($id_anggaran);> - ".$getNamaBarang['nm_barang']." </span>";
 				}
 			}else{
 				$uraianList = "<span style='color:$colorList;cursor:pointer;' onclick=$this->Prefix.editSubRincian($id_anggaran);> - ".$rincian_perhitungan."</span>";
 			}
			 $volumeRekening = number_format($volume_rek ,0,',','.');
			 $satuanRekening = $satuan_total;
			 $hargaSatuan = number_format($jumlah ,2,',','.');
			 $jumlahHarga = number_format($jumlah_harga ,2,',','.');
			 $this->total += $jumlah_harga;
			 $TampilCheckBox = "";

			 $naonkitu = "
													<tr valign='top'>
														<td align='left' class='GarisCetak5' ></td>
														<td align='left' class='GarisCetak5' style='padding-left: 35px;'>".$uraianList."</td>
														<td align='right' class='GarisCetak5' style='border: 1px dashed #504d4d; border-right: 1px solid #000; border-left: 1px solid #000;'>".$volumeRekening."</td>
														<td align='left' class='GarisCetak5' style='border: 1px dashed #504d4d; border-right: 1px solid #000; border-left: 1px solid #000;'>".$satuanRekening."</td>
														<td align='right' class='GarisCetak5' style='border: 1px dashed #504d4d; border-right: 1px solid #000; border-left: 1px solid #000;'>".$hargaSatuan."</td>
														<td align='right' class='GarisCetak5' style='border: 1px dashed #504d4d; border-right: 1px solid #000; border-left: 1px solid #000;'>".$jumlahHarga."</td>
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

    
		}
		echo "<tr valign='top'>
									<td align='right' colspan='5' class='GarisCetak'><b>JUMLAH</b></td>
									<td align='right' class='GarisCetak' style='border: 1px solid; border-left: 1px solid; border-right: 1px solid; border-bottom: 1px solid;'><b>".$total."</b></td>

								</tr>";
		// "
			// <tr valign='top'>
			// 	<td align='center' class='GarisCetak' >".$k."</td>
			// 	<td align='center' class='GarisCetak' >".$l."</td>
			// 	<td align='center' class='GarisCetak' >".$m."</td>
			// 	<td align='center' class='GarisCetak' >".$n."</td>
			// 	<td align='center' class='GarisCetak' >".$o."</td>
			// 	<td align='left' class='GarisCetak' >".$uraian."</td>
			// 	<td align='right' class='GarisCetak' >".$volume_rek."</td>
			// 	<td align='left' class='GarisCetak'>$satuan_rek</td>
			// 	<td align='right' class='GarisCetak' >".$jumlah."</td>
			// 	<td align='right' class='GarisCetak' >".$jumlah_harga."</td>
			// </tr>
		// ";

		"						
							 </table>";

		$getSumAlokasi = mysql_fetch_array(mysql_query("select  sum(alokasi_jan), sum(alokasi_feb) , sum(alokasi_mar) , sum(alokasi_apr) , sum(alokasi_mei) , sum(alokasi_jun) , sum(alokasi_jul) , sum(alokasi_agu) , sum(alokasi_sep) , sum(alokasi_okt) , sum(alokasi_nop), sum(alokasi_des) from tabel_spd where anggaran='$this->jenisAnggaran' and tahun ='$this->tahun'  and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck'  and p='$p' and q='$q'"));

		$triwulanI = $getSumAlokasi['sum(alokasi_jan)'] + $getSumAlokasi['sum(alokasi_feb)'] + $getSumAlokasi['sum(alokasi_mar)'];
		$totalAlokasi += $triwulanI;

		$triwulanI = number_format($triwulanI,2,',','.');

		$triwulanII = $getSumAlokasi['sum(alokasi_apr)'] + $getSumAlokasi['sum(alokasi_mei)'] + $getSumAlokasi['sum(alokasi_jun)'];
		$totalAlokasi += $triwulanII;
		$triwulanII = number_format($triwulanII,2,',','.');

		$triwulanIII = $getSumAlokasi['sum(alokasi_jul)'] + $getSumAlokasi['sum(alokasi_agu)'] + $getSumAlokasi['sum(alokasi_sep)'];
		$totalAlokasi += $triwulanIII;
		$triwulanIII = number_format($triwulanIII,2,',','.');

		$triwulanIV = $getSumAlokasi['sum(alokasi_okt)'] + $getSumAlokasi['sum(alokasi_nop)'] + $getSumAlokasi['sum(alokasi_des)'];
		$totalAlokasi += $triwulanIV;
		$triwulanIV = number_format($triwulanIV,2,',','.');

		$totalAlokasi = number_format($totalAlokasi,2,',','.');
		if (sizeof($arrayTandaTangan)==1) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$arrayPosisi' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '0' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));
            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$arrayPosisi' "));
            $titimangsa = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan"));

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
            <hr style='border-top: 1px solid #000; margin-bottom: 5px; margin-top: 5px; width: 50%;'>
            <span style='margin-bottom: 5px;'>NIP ".$hmm['nip']."</span>
          
            
            </div>";

					}
		echo
						"<table style='width:100.2%; border: 1px solid; margin-left: -1px;'>
							<tr>
								<td style='width: 50%; position: absolute;'><br>
									<div class='ukurantulisan' style ='float:left;'>

									<table class='ukurantulisan' >
									 <tr>
									 	<td class='ukurantulisan'>Triwulan I</td>
										<td class='ukurantulisan'>&nbsp &nbsp Rp</td>
										<td class='ukurantulisan' align='right'>$triwulanI</td>
									 </tr>
									 <tr>
									 	<td class='ukurantulisan'>Triwulan II</td>
										<td class='ukurantulisan'>&nbsp &nbsp Rp</td>
										<td class='ukurantulisan' align='right'>$triwulanII</td>
									 </tr>
									 <tr>
									 	<td class='ukurantulisan'>Triwulan III</td>
										<td class='ukurantulisan'>&nbsp &nbsp Rp</td>
										<td class='ukurantulisan' align='right'>$triwulanIII</td>
									 </tr>
									 <tr>
									 	<td class='ukurantulisan'>Triwulan IV</td>
										<td class='ukurantulisan'>&nbsp &nbsp Rp</td>
										<td class='ukurantulisan' align='right'>$triwulanIV</td>
									 </tr>
									 <tr>
									 	<td class='ukurantulisan'>Jumlah</td>
										<td class='ukurantulisan'>&nbsp &nbsp Rp</td>
										<td class='ukurantulisan' align='right'>$totalAlokasi</td>
									 </tr>
									</table>
									
									</div>
								</td>
								<td style='width: 50%; border-left: 1px solid;'>
									".$tandaTanganna."
								</td>
							</tr>
						</table>
						<h5 class='pag pag1' >
							<span style='bottom: 2px; position: absolute; left:0;'>
							<hr style='width: 33cm; border-top: 1px solid #000;'>
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

	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

	 if(empty($cmbUrusan)){
	 	$err = "Pilih Urusan";
	 }elseif(empty($cmbBidang)){
	 	$err = "Pilih Bidang";
	 }elseif(empty($cmbSKPD)){
	 	$err = "Pilih SKPD";
	 }elseif(empty($p)){
	 	$err = "Pilih Program";
	 }elseif(empty($q)){
	 	$err = "Pilih Kegiatan";
	 }

	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';

	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );

	 $terpilih = $dpaSKPD221New_cb[0];
	 $getKodeRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$terpilih'"));
				$k = $getKodeRekening['k'];
				$l = $getKodeRekening['l'];
				$m = $getKodeRekening['m'];
				$n = $getKodeRekening['n'];
				$o = $getKodeRekening['o'];

	 $this->publicSum = "select sum(jumlah_harga) from tabel_anggaran where (rincian_perhitungan !='' or f !='00' ) and id_tahap='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka ='2.2.1' and c1= '$cmbUrusan' and c ='$cmbBidang' and d='$cmbSKPD' and bk = '$bk' and ck ='$ck' and p = '$hiddenP' and q='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' ";
	 $getSumJumlah = mysql_fetch_array(mysql_query($this->publicSum));
	 $jumlahHargaForm =$getSumJumlah['sum(jumlah_harga)'];
	 if(mysql_num_rows(mysql_query("select * from tabel_spd where tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran' and c1 ='$cmbUrusan' and c='$cmbBidang' and d ='$cmbSKPD' and bk ='$bk' and ck ='$ck' and p='$hiddenP' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka ='2.2.1' and jenis_dpa = 'DPA-SKPD'")) != 0 ){
	 	$grabSPD = mysql_fetch_array(mysql_query("select * from tabel_spd where tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran' and c1 ='$cmbUrusan' and c='$cmbBidang' and d ='$cmbSKPD' and bk ='$bk' and ck ='$ck' and p='$hiddenP' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka ='2.2.1' and jenis_dpa = 'DPA-SKPD'"));
		foreach ($grabSPD as $key => $value) {
				  $$key = $value;
		}
		$jan = $alokasi_jan;
		$feb = $alokasi_feb;
		$mar = $alokasi_mar;
		$apr = $alokasi_apr;
		$mei = $alokasi_mei;
		$jun = $alokasi_jun;
		$jul = $alokasi_jul;
		$agu = $alokasi_agu;
		$sep = $alokasi_sep;
		$okt = $alokasi_okt;
		$nop = $alokasi_nop;
		$des = $alokasi_des;
		$jenisAlokasi = $jenis_alokasi_kas;
	 }

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
	 /*if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }*/
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($terpilih);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

function formAlokasiTriwulan(){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
	 $terpilih = $dpaSKPD221New_cb[0];
	 $getKodeRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$terpilih'"));
				$k = $getKodeRekening['k'];
				$l = $getKodeRekening['l'];
				$m = $getKodeRekening['m'];
				$n = $getKodeRekening['n'];
				$o = $getKodeRekening['o'];
	 $this->publicSum = "select sum(jumlah_harga) from tabel_anggaran where (rincian_perhitungan !='' or f !='00' ) and id_tahap='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka ='2.2.1' and c1= '$cmbUrusan' and c ='$cmbBidang' and d='$cmbSKPD' and bk = '$bk' and ck ='$ck' and p = '$hiddenP' and q='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' ";
	 $getSumJumlah = mysql_fetch_array(mysql_query($this->publicSum));
	 $jumlahHargaForm =$getSumJumlah['sum(jumlah_harga)'];

	 if(mysql_num_rows(mysql_query("select * from tabel_spd where tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran' and c1 ='$cmbUrusan' and c='$cmbBidang' and d ='$cmbSKPD' and bk ='$bk' and ck ='$ck' and p='$hiddenP' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka ='2.2.1' and jenis_dpa = 'DPA-SKPD'")) != 0 ){
	 	$grabSPD = mysql_fetch_array(mysql_query("select * from tabel_spd where tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran' and c1 ='$cmbUrusan' and c='$cmbBidang' and d ='$cmbSKPD' and bk ='$bk' and ck ='$ck' and p='$hiddenP' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka ='2.2.1' and jenis_dpa = 'DPA-SKPD'"));
		foreach ($grabSPD as $key => $value) {
				  $$key = $value;
		}
		$jan = $alokasi_jan;
		$feb = $alokasi_feb;
		$mar = $alokasi_mar;
		$apr = $alokasi_apr;
		$mei = $alokasi_mei;
		$jun = $alokasi_jun;
		$jul = $alokasi_jul;
		$agu = $alokasi_agu;
		$sep = $alokasi_sep;
		$okt = $alokasi_okt;
		$nop = $alokasi_nop;
		$des = $alokasi_des;

	 }
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
						'label'=>'JUMLAH HARGA ',
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($terpilih);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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

function formRincianVolume($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 230;
	 $this->form_caption = 'RINCIAN VOLUME';
	 $jumlahHargaForm = $dt;
	 $username =$_COOKIE['coID'];
	 $getRincianVolume = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$dt'"));
	 foreach ($getRincianVolume as $key => $value) {
				  $$key = $value;
		}
	 $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	 $cmbSatuanSatuan1 = cmbQuery('satuanSatuan1',$satuan1,$codeAndSatuanSatuan,'','-- SATUAN --');

	 $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	 $cmbSatuanSatuan2 = cmbQuery('satuanSatuan2',$satuan2,$codeAndSatuanSatuan,'','-- SATUAN --');

	 $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	 $cmbSatuanSatuan3 = cmbQuery('satuanSatuan3',$satuan3,$codeAndSatuanSatuan,'','-- SATUAN --');

	 $codeAndSatuanVolume = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='volume'";
	 $cmbSatuanVolume = cmbQuery('satuanVolume',$satuan_total,$codeAndSatuanVolume,'','-- SATUAN --');

	 if($jumlah3 == 0 && $satuan3 == ""){
	 	$totalResult = $jumlah1 * $jumlah2 ;
		$jumlah3 = "";
	 }else{
	 	$totalResult = $jumlah1 * $jumlah2 * $jumlah3 ;
	 }


	 //items ----------------------
	  $this->form_fields = array(
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='hidden' id='volumeRek' value='$dt'>  <input type='text' id='jumlah1' value='$jumlah1' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder='JUMLAH'> &nbsp &nbsp ".$cmbSatuanSatuan1. " &nbsp &nbsp <button type='button' onclick='$this->Prefix.newSatuanSatuan();'>Baru</button>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"KALI (X)",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='text' id='jumlah2' placeholder='JUMLAH' value='$jumlah2' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp &nbsp ".$cmbSatuanSatuan2. " ",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"KALI (X)",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='text' id='jumlah3' placeholder='JUMLAH' value='$jumlah3' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp &nbsp ".$cmbSatuanSatuan3. " ",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"KALI (X)",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='text' value='$totalResult' placeholder='JUMLAH' id='jumlah4' readonly > &nbsp &nbsp ".$cmbSatuanVolume. " &nbsp &nbsp <button type='button' onclick='$this->Prefix.newSatuanVolume();'>Baru</button>",
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

function newSatuanSatuan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form2';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'SATUAN BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'' => array(
						'label'=>'NAMA SATUAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaSatuan' id='namaSatuan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveSatuanSatuan();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function newSatuanVolume($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form2';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'SATUAN BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'' => array(
						'label'=>'NAMA SATUAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaSatuan' id='namaSatuan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveSatuanVolume();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function Posting(){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
	 $this->form_width = 300;
	 $this->form_height = 50;
	 $this->form_caption = 'POSTING';
	 $arrayPosting = array(
		 										array('10','SPD'),
	 										);
	 $cmbPosting =  cmbArray('cmbPosting',"SPD",$arrayPosting,'-- POSTING --',"onchange=$this->Prefix.tujuanPostingChanged();");

	 //items ----------------------
	  $this->form_fields = array(
			's' => array(
						'label'=>'POSTING KE',
						'labelWidth'=>100,
						'value'=>$cmbPosting."<input type='hidden' name='jenisForm' id='jenisForm' >
						 <input type='hidden' name='namaTahap' id='namaTahap'>
						 <input type='hidden' name='namaModul' id='namaModul'>
						<input type='hidden' name='tahunAnggaran' id='tahunAnggaran' value='$this->tahun'>
						",
						 ),


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='POST' onclick ='".$this->Prefix.".postDataDpa()' title='POST' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

}
$dpaSKPD221New = new dpaSKPD221NewObj();


$arrayResult = VulnWalkerTahap_v2($dpaSKPD221New->modul);
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$dpaSKPD221New->jenisForm = $jenisForm;
$dpaSKPD221New->nomorUrut = $nomorUrut;
$dpaSKPD221New->urutTerakhir = $nomorUrut;
$dpaSKPD221New->tahun = $tahun;
$dpaSKPD221New->jenisAnggaran = $jenisAnggaran;
$dpaSKPD221New->idTahap = $idTahap;

$dpaSKPD221New->username = $_COOKIE['coID'];


if(empty($dpaSKPD221New->tahun)){

	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_dpa_2_2_1 "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_dpa_2_2_1 where id_anggaran = '$maxAnggaran'"));
	/*$dpaSKPD221New->tahun = "select max(id_anggaran) as max from view_dpa_2_2_1 where nama_modul = 'dpaSKPD221New'";*/
	$dpaSKPD221New->tahun  = $get2['tahun'];
	$dpaSKPD221New->jenisAnggaran = $get2['jenis_anggaran'];
	$dpaSKPD221New->urutTerakhir = $get2['no_urut'];
	$dpaSKPD221New->jenisFormTerakhir = $get2['jenis_form_modul'];
	$dpaSKPD221New->urutSebelumnya = $dpaSKPD221New->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$dpaSKPD221New->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$dpaSKPD221New->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$dpaSKPD221New->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$dpaSKPD221New->idTahap'"));
	$dpaSKPD221New->currentTahap = $getCurrenttahap['nama_tahap'];

	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$dpaSKPD221New->idTahap'"));
	$dpaSKPD221New->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$dpaSKPD221New->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$dpaSKPD221New->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}

$setting = settinganPerencanaan_v2();
$dpaSKPD221New->provinsi = $setting['provinsi'];
$dpaSKPD221New->kota = $setting['kota'];
$dpaSKPD221New->pengelolaBarang = $setting['pengelolaBarang'];
$dpaSKPD221New->pejabatPengelolaBarang = $setting['pejabat'];
$dpaSKPD221New->pengurusPengelolaBarang = $setting['pengurus'];
$dpaSKPD221New->nipPengelola = $setting['nipPengelola'];
$dpaSKPD221New->nipPengurus = $setting['nipPengurus'];
$dpaSKPD221New->nipPejabat = $setting['nipPejabat'];


?>
