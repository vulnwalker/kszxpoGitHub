<?php 
class renjaAsetNewObj  extends DaftarObj2{ 
  var $Prefix = 'renjaAsetNew';
  var $elCurrPage="HalDefault";
  var $SHOW_CEK = TRUE;
  var $TblName = 'view_renja'; //bonus
  var $TblName_Hapus = 'renjaAsetNew';
  var $MaxFlush = 10;
  var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
  var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
  var $KeyFields = array('id_anggaran');
  var $FieldSum = array();//array('jml_harga');
  var $SumValue = array();
  var $FieldSum_Cp1 = array( 14, 14, 14);//berdasar mode
  var $FieldSum_Cp2 = array( 0, 0, 0);  
  var $checkbox_rowspan = 1;
  var $PageTitle = 'RENCANA KERJA';
  var $PageIcon = 'images/perencanaan_ico.png';
  var $pagePerHal ='';
  var $fileNameExcel='renjaAsetNew.xls';
  var $namaModulCetak='DAFTAR renjaAsetNew';
  var $Cetak_Judul = 'DAFTAR renjaAsetNew';  
  var $Cetak_Mode=2;
  var $Cetak_WIDTH = '30cm';
  var $Cetak_OtherHTMLHead;
  var $FormName = 'renjaAsetNewForm';
  var $TampilFilterColapse = 0; //0
  var $modul = "RENJA";
  var $jenisForm = "";
  var $tahun = "";
  var $nomorUrut = "";
  var $jenisAnggaran = "";
  var $idTahap = "";
  var $namaTahapTerakhir = "";
  var $masaTerakhir = "";
    //untuk view
  var $urutTerakhir = "";
  var $urutSebelumnya = "";
  var $jenisFormTerakhir = "";
  var $tahapTerakhir = "";
  
  var $username = "";
  
  var $wajibValidasi = "";
  var $sqlValidasi = "";
  //untuk view
  var $currentTahap = "";
  var $settingAnggaran = "";
  var $reportURLAset = "pages.php?Pg=renjaAsetNew&tipe=Laporan";

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
      $dt['c1'] = $_REQUEST[$this->Prefix.'fmSKPDUrusan'];
      $dt['c'] = $_REQUEST[$this->Prefix.'fmSKPDBidang'];
      $dt['d'] = $_REQUEST[$this->Prefix.'fmSKPDskpd'];
      $fm = $this->setForm($dt);
    }
      return  array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  }

function setForm($dt,$c1,$c,$d){  
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
    
    
    $queryKategori = "SELECT id,kategori_tandatangan FROM ref_kategori_tandatangan";
  
    
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
    $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '14' "));
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
      'kategori' => array( 
            'label'=>'KATEGORI',
            'labelWidth'=>150, 
            'value'=>"
              <input type='text' readonly='readonly' style='width: 350px;' name='kategori' id='kategori' value='".$queryKategori1[kategori_tandatangan]."'>
            ",
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
      
          $aqry = "INSERT into ref_tandatangan (c1,c,d,nama,nip,jabatan,pangkat,gol,ruang,eselon,kategori_tandatangan) values('$kode1','$kode2','$kode3','$namapegawai','$nippegawai','$jabatan','$p1','$golongan[0]','$golongan[1]','$eselon',14)";  $cek .= $aqry;  
          $qry = mysql_query($aqry);
          $content = array('combottd' => cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = '14' and c1 = '".$_REQUEST[c1]."' and c = '".$_REQUEST[c]."' and d = '".$_REQUEST[d]."'",'onchange=rka.refreshList(true);','-- TTD --'));
        }
      }else{            
        if($err==''){
        $aqry = "UPDATE ref_tandatangan SET nama='$namapegawai', nip='$nippegawai', jabatan='$jabatan' ,pangkat='$p1', gol='$golongan[0]' ,ruang='$golongan[1]',eselon='$eselon' ,kategori_tandatangan='$kategori' WHERE Id='".$idplh."'";  $cek .= $aqry;
            $qry = mysql_query($aqry) or die(mysql_error());
          }
      } //end else
          
      return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);  
    }

function set_selector_other2($tipe){
   global $Main;
   $cek = ''; $err=''; $content=''; $json=TRUE;
    
   return array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
  }
  
  function set_selector_other($tipe){
   global $Main;
   $cek = ''; $err=''; $content=''; $json=TRUE;
    
    switch($tipe){  
      
    case 'postReport':{       
       foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
       }
       $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));
       if($fmSKPDUrusan == '00'){
        $err = "Pilih Urusan";
       }elseif($fmSKPDBidang== '00') {
        $err = "Pilih Bidang";
       }elseif($fmSKPDskpd == '00'){
        $err = "Pilih SKPD";
       }
       $data = array(
              'c1' => $fmSKPDUrusan,
              'c' => $fmSKPDBidang,
              'd' => $fmSKPDskpd,
              'username' => $this->username
              );  
      if(mysql_num_rows(mysql_query("select * from skpd_report_renja where username= '$this->username'")) == 0){
        $query = VulnWalkerInsert('skpd_report_renja', $data);
      }else{
        $query = VulnWalkerUpdate('skpd_report_renja', $data, "username = '$this->username'");
      } 
      mysql_query($query);
      $content= array('urusan'=>$fmSKPDUrusan,'bidang'=>$fmSKPDBidang,'skpd'=>$fmSKPDskpd,'namaPemda'=>$namaPemda[option_value],'cetakjang'=>$cetakjang, 'ttd' => $ttd);
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

    case 'TanggalCetak':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
       if($fmSKPDUrusan =='0'){
        $err = "Pilih Urusan";
       }elseif($fmSKPDBidang =='00'){
        $err = "Pilih Bidang";
       }elseif($fmSKPDskpd =='00'){
        $err = "Pilih SKPD";
       }else{
        $fm = $this->TanggalCetak($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
       }


      break;

    }
    
    case 'Laporan':{
    $json = FALSE;
    
    
    if($xls){
      header("Content-type: application/msexcel");
      header("Content-Disposition: attachment; filename=$this->fileNameExcel");
      header("Pragma: no-cache");
      header("Expires: 0");
    }

    $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
    $ref_skpdSkpdfmUrusan= $c1;
    $ref_skpdSkpdfmSKPD = $c;
    $ref_skpdSkpdfmUNIT = $d;
    
    
    if($ref_skpdSkpdfmUrusan!='0' and $ref_skpdSkpdfmUrusan !='' and $ref_skpdSkpdfmUrusan!='00' ){
      $arrKondisi[]= "c1='$ref_skpdSkpdfmUrusan'";
      if($ref_skpdSkpdfmSKPD!='00' and $ref_skpdSkpdfmSKPD !=''  )$arrKondisi[]= "c='$ref_skpdSkpdfmSKPD'";
  
      if($ref_skpdSkpdfmSKPD!='00'){
  
      if($ref_skpdSkpdfmUNIT!='00' and $ref_skpdSkpdfmUNIT !='' )$arrKondisi[]= "d='$ref_skpdSkpdfmUNIT'";
      }
    }

    $arrKondisi = array();    
    
    $fmPILCARI = $_REQUEST['fmPILCARI'];  
    $fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];

    $fmSKPDUrusan = $c1;
    $fmSKPDBidang =  $c;
    $fmSKPDskpd = $d;
    
      
    
    
    $noUrutSebelumnya = $this->nomorUrut - 1;
    /*$fmLimit = $_REQUEST['baris'];
    $this->pagePerHal=$fmLimit;*/
    
    if($fmSKPDskpd != "00"){
      $arrKondisi[] = "d = '$fmSKPDskpd'";
      $arrKondisi[] = "c = '$fmSKPDBidang'";
      $arrKondisi[] = "c1 = '$fmSKPDUrusan'";
    }elseif($fmSKPDBidang != "00"){
      $arrKondisi[] = "c = '$fmSKPDBidang'";
      $arrKondisi[] = "c1 = '$fmSKPDUrusan'";
    }elseif($fmSKPDUrusan != "0"){
      $arrKondisi[] = "c1 = '$fmSKPDUrusan'";
    }

  
      $arrKondisi[] = " tahun = '$this->tahun'";
      $arrKondisi[] = " jenis_anggaran = '$this->jenisAnggaran'";
      $arrKondisi[] =  " no_urut = '$this->nomorUrut'";
    
    $arraySync = array();
    $getExcept = mysql_query("select * from view_renja where jumlah !='0' and jumlah !='' and q!='0' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
    while($rowExcept = mysql_fetch_array($getExcept)){
          if(mysql_num_rows(mysql_query("select * from sync_renja where id_anggaran = '".$rowExcept['id_anggaran']."'")) == 0){
            $arraySync[] = "id_anggaran != '".$rowExcept['id_anggaran']."'";
          }

    }
    if(sizeof($arraySync) > 0){
      $kondisiSync = " and ".join(' and ',$arraySync);
    }

    $this->jsonArrayExcept = json_encode($arraySync);


    $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
    while($Urusan= mysql_fetch_array($getUrusan)){
      foreach ($Urusan as $key => $value) { 
            $$key = $value; 
      }
      if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'   $kondisiSync")) == 0 ){
        $concatUrusan = $c1;
        $arrKondisi[] = "c1 !='$concatUrusan' ";
      }else{
        $getBidang = mysql_query("select * from view_renja where c1 = '$c1' and  c != '00' and d='00' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
        while($Bidang= mysql_fetch_array($getBidang)){
          foreach ($Bidang as $key => $value) { 
                $$key = $value; 
          }
          if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and c='$c' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'  $kondisiSync")) == 0 ){
            $concatBidang = $c1.".".$c;
            $arrKondisi[] = "concat(c1,'.',c) !='$concatBidang'";
          }else{
            $getSkpd = mysql_query("select * from view_renja where c1 = '$c1' and  c = '$c' and d !='00' and p='0' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
            while($Skpd= mysql_fetch_array($getSkpd)){
              foreach ($Skpd as $key => $value) { 
                    $$key = $value; 
              }
              if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and c='$c' and d='$d' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'  $kondisiSync")) == 0 ){
                $concatSKPD = $c1.".".$c.".".$d;
                $arrKondisi[] = "concat(c1,'.',c,'.',d) !='$concatSKPD'";
              }else{
                $getProgram = mysql_query("select * from view_renja where c1 = '$c1' and  c = '$c' and d ='$d' and p!='0' and q='0' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut' $kondisiSync");
                while($Program= mysql_fetch_array($getProgram)){
                  foreach ($Program as $key => $value) { 
                        $$key = $value; 
                  }


                  if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and c='$c' and d='$d' and bk = '$bk' and ck = '$ck' and p ='$p' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'  $kondisiSync")) == 0 ){
                    $concatProgram = $c1.".".$c.".".$d.".".$bk.".".$ck.".".$p;
                    $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',p) !='$concatProgram' ";
                  }

                }
              }
            }
          }
        }
      }
    }
  
    
    $Kondisi= join(' and ',$arrKondisi);
    $Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
    
    $getMaxIDTahap = mysql_fetch_array(mysql_query("select max(id_tahap) from view_renja"));
    $idTahap = $getMaxIDTahap['max(id_tahap)'];
    $qry ="select * from view_renja $Kondisi order by urut";
    $aqry = mysql_query($qry);
    
        
    //MULAI Halaman Laporan ------------------------------------------------------------------------------------------ 
    $css = $xls ? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
    $getJenisReportAset = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURLAset' "));
    $getJenisUkuran = $getJenisReportAset['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTanganAset = explode(';', $getJenisReportAset['tanda_tangan']);

    $grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'")); 
    $urusan = $c1.". ".$grabUrusan['nm_skpd'];
    $grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
    $bidang = $c.". ".$grabBidang['nm_skpd'];
    $grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
    $skpd = $grabSkpd['nm_skpd'];
    echo 
      "<html>
      <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
      <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
      <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
      <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
      <link rel='stylesheet' type='text/css' href='css/pageNumber.css'>
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
          </style>
        </head>".
      "<body >
        <div style='width:$this->Cetak_WIDTH_Landscape;'>
          <table class=\"rangkacetak\" style='width: 33cm; font-family: sans-serif; height: 21.5cm;'>
            <tr>
              <td valign=\"top\"> <div style='text-align:center;'>
              <table style='width: 100%; border: none; margin-bottom: 1%;'>
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
                    <span style='font-size:18px;font-weight:bold;text-decoration: '>
                      RENCANA KERJA SKPD<br>
                      <span style='text-transform: uppercase;'>".$skpd."<br></span>
                      <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN ANGGARAN $this->tahun </span>
                    </span>
                  </td>
                </tr>

              </table>
              ".
                $this->LaporanTmplSKPD($get['c1'],$get['c'],$get['d']);
                
    //echo $qry;
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='width:100%;'>
                <thead>
                  <tr>
                    <th class='th01' style='width:20px;' >NO</th>
                    <th class='th01' style='width:175px;' >KODE</th>
                    <th class='th01' >NAMA URUSAN PEMERINTAHAN, ORGANISASI, PROGRAM DAN KEGIATAN</th>
                    <th class='th01' style='width:360px;' >OUTPUT</th>
                  </tr>
                </thead>
                  
    ";
    
    $pid = '';
    $no_cek = 0;
    $no = 1;
    while($daqry = mysql_fetch_array($aqry)){
      foreach ($daqry as $key => $value) { 
          $$key = $value; 
      } 
      $arrayKode = explode(".",$urut);
     if($d !='00'  && $bk == '0' && $ck =='0' && $p =='0' && $q=='0'){
        $get  = mysql_fetch_array(mysql_query("select nm_skpd from ref_skpd where c1='$c1' and c='$c' and d = '$d' and e='00' and e1='000'" ));
      $nama_skpd = "<span style='font-weight:bold;'>". $get['nm_skpd'] ."</span>";
      $getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and id_tahap = '$idTahap'"));
      $jumlah = $getJumlah['jumlah'];
      $kode = $c1.".".$c.".".$d;
     }elseif($c != '00' && $d !='00'  &&  $p !='0' && $q =='0'  ){
       $get  = mysql_fetch_array(mysql_query("select nama from ref_program where bk ='$bk' and ck='$ck' and dk = '0' and p='$p' and q = '0'" ));
       $nama_skpd = "<span style='font-weight:bold;'>". $get['nama'] ."</span>";
       $getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c ='$c' and d='$d'and  e ='$e' and e1='$e1' and bk ='$bk' and ck='$ck' and p ='$p' and id_tahap = '$idTahap'"));
       $jumlah = $getJumlah['jumlah'];
       $kode = $c1.".".$c.".".$d.".".$e.".".$e1.".".genNumber($bk).genNumber($ck).genNumber($p);
     }elseif($c != '00' && $d !='00' &&  $p !='0' && $q!='0'  ){
       $get  = mysql_fetch_array(mysql_query("select nama from ref_program where bk ='$bk' and ck='$ck' and dk = '0' and p='$p' and q = '$q'" ));
       $nama_skpd = "<span>". $get['nama'] ."</span>";
       $kode = $c1.".".$c.".".$d.".".$e.".".$e1.".".genNumber($bk).genNumber($ck).genNumber($p).".".genNumber($q);
     }
     $getDetailRenja = mysql_fetch_array(mysql_query("select * from detail_renja where id_anggaran ='$id_anggaran'"));
     foreach ($getDetailRenja as $key => $value) { 
      $$key = $value; 
      }
      if ($c != '00' && $d !='00'  &&  $p !='0' && $q =='0') {
        $naonkitu .="
        <tr valign='top'>
                  <td align='center' class='GarisCetak'>$no</td>
                  <td align='left' class='GarisCetak' >".$kode."</td>
                  <td align='left' class='GarisCetak' style='padding-left: 10px;'>".$nama_skpd."</td>
                  <td align='left' class='GarisCetak' ></td>
                </tr>";
                $no++;
      }elseif ($c != '00' && $d !='00' &&  $p !='0' && $q!='0') {
        $naonkitu .="
          <tr valign='top'>
                  <td align='center' class='GarisCetak'></td>
                  <td align='left' class='GarisCetak' >".$kode."</td>
                  <td align='left' class='GarisCetak' style='padding-left: 20px;'>".$nama_skpd."</td>
                  <td align='left' class='GarisCetak' >".$output."</td>
                </tr>
        ";
      }
      echo $naonkitu;
      $naonkitu = "";
      // "
      //           <tr valign='top'>
      //             <td align='center' class='GarisCetak'>$no</td>
      //             <td align='left' class='GarisCetak' >".$kode."</td>
      //             <td align='left' class='GarisCetak' >".$nama_skpd."</td>
      //             <td align='left' class='GarisCetak' >".$output."</td>
      //           </tr>
      // ";
      
      
      $no_cek++;
      
      
    }
    echo        "</table>";   
    echo      $this->TandaTanganFooter($c1,$c,$d,$e,$e1).
            "</div> </td></tr>
          </table>
        </div>  
      </body> 
    </html>";
      
      break;
    }
      
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
    
    
    case 'lihatrenjaAsetNew':{       
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
    case 'Info':{
        $fm = $this->Info();        
        $cek .= $fm['cek'];
        $err = $fm['err'];
        $content = $fm['content'];                    
    break;
    }
    case 'SKPDAfter':{
        $fmSKPDUnit = cekPOST('fmSKPDUnit');
        $fmSKPDBidang = cekPOST('fmSKPDBidang');
        $fmSKPDskpd = cekPOST('fmSKPDskpd');
    break;
    
    }
    

    case 'sync':{
      $getRenjaKeuangan = mysql_query("select * from view_renja where jumlah !='' and jumlah !='0' and q!='0' and jenis_anggaran = 'MURNI'");
      while ($rowKeuangan = mysql_fetch_array($getRenjaKeuangan)) {
          if(mysql_num_rows(mysql_query("select * from sync_renja where id_anggaran ='".$rowKeuangan['id_anggaran']."'")) == 0 ){
            $data = array(
                    'id_anggaran' => $rowKeuangan['id_anggaran'],
                    'tanggal' => date("Y-m-d"),
                    'username' => $this->username,
                    );
            $query = VulnWalkerInsert("sync_renja",$data);
            mysql_query($query);
          }
      }

       
       
  
      break;
     }  
    case 'newTab':{
    
       
      
       foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
       } 
       
  
        
        if(mysql_num_rows(mysql_query("select * from skpd_renja_v3 where c1 = '$fmSKPDUrusan' and c = '$fmSKPDBidang' and d='$fmSKPDskpd'")) == 0){
          $data = array("c1" => $fmSKPDUrusan,
                  "c" => $fmSKPDBidang,
                  "d" => $fmSKPDskpd,
                 );
          mysql_query(VulnWalkerInsert('skpd_renja_v3',$data));
        }
        
        $grabID = mysql_fetch_array(mysql_query("select * from skpd_renja_v3 where c1 = '$fmSKPDUrusan' and c = '$fmSKPDBidang' and d='$fmSKPDskpd'"));
        $ID_PLAFON = $grabID['id'];
        $content = array('idrenjaAsetNew' => $ID_PLAFON, "status" => $statunya );
      break;
        }
      
      
      case 'editTab':{
      
       foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
       }
       $urutArray = explode(" ",$renjaAsetNew_cb[0]);
       $urut = $renjaAsetNew_cb[0];
       $query = "select * from view_renja where id_anggaran = '$renjaAsetNew_cb[0]' ";
       $getViewrenjaAsetNew = mysql_fetch_array(mysql_query($query)); 
       foreach ($getViewrenjaAsetNew as $key => $value) { 
          $$key = $value; 
       }
       $IDEDIT = $id_anggaran;
       $nomor = $this->nomorUrut - 1;
      
       $grabID = mysql_fetch_array(mysql_query("select * from skpd_renja_v3 where c1 = '$c1' and c = '$c' and d='$d'"));
       $ID_PLAFON = $grabID['id'];
       if($status_validasi == '1'){
        $err = "Data sudah di validasi !";
       }
       
       $content = array('ID_PLAFON' => $ID_PLAFON,  'ID_EDIT' => $renjaAsetNew_cb[0] , 'query ' =>"select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$c1' and c = '$c' and d='$d' and e='00' and e1='000' and bk='0' and ck = '0'  and p ='0' and q = '0' and no_urut = '$nomor' ");
      
      break;
        }
      
      case 'jenisChanged':{
        $jenisKegiatan = $_REQUEST['jenisKegiatan'];
        if($jenisKegiatan == 'baru'){
          $plus = "<input type='text' name ='plus' id ='plus'  readonly> ";
          $minus = "<input type='text' name ='minus' id ='minus' readonly> ";
        }else{
          $plus = "<input type='text' name ='plus' id ='plus' style='width:200px; text-align:right;'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='document.getElementById(`keyPP`).textContent = `Rp. ` + popupProgramrenjaAsetNew.formatCurrency(this.value);' > ";
          $minus = "<input type='text' name ='minus' id ='minus' style='width:200px; text-align:right;'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='document.getElementById(`keyMM`).textContent = `Rp. ` + popupProgramrenjaAsetNew.formatCurrency(this.value);'> ";
        }
        $content = array('plus' => $plus, 'minus' => $minus);
      break;
        }
      
      case 'comboPlafon':{
        foreach ($_REQUEST as $key => $value) { 
           $$key = $value; 
        } 
        $codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) from ref_skpd where c='00' and d='00' and e='00' and e1='000' ";
        $urusan = cmbQuery('cmbUrusan',$c1,$codeAndNameUrusan,'onchange=rka.refreshList(true);','-- URUSAN --');
  
        $codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$c1' and c !='00' and d='00' and e='00' and e1='000' ";
        $bidang = cmbQuery('cmbBidang',$c,$codeAndNameBidang,'onchange=rka.refreshList(true);','-- BIDANG --');
  
        $codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$c1' and c='$c' and d!='00' and e='00' and e1='000' ";
        $skpd= cmbQuery('cmbSKPD',$d,$codeAndNameSKPD,'onchange=rka.refreshList(true);','-- SKPD --');
        
        $getidTahapPlafon = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_plafon where tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' "));
        $idTahapPlafon= $getidTahapPlafon['max'];
        $getAngkaPlafon = mysql_fetch_array(mysql_query("select plafon from view_plafon where c1='$c1' and c='$c' and d='$d' and id_tahap='$idTahapPlafon'"));
        $angkaPlafon = number_format($getAngkaPlafon['plafon'],2,',','.');
        
        
        $content = array('urusan' => $urusan, 'bidang' => $bidang, 'skpd' => $skpd , 'angkaPlafon' => "Rp. ".$angkaPlafon );
      break;
        }
      
      
      case 'Validasi':{
        $dt = array();
        $err='';
        $content='';
        $uid = $HTTP_COOKIE_VARS['coID'];
        
        $cbid = $_REQUEST[$this->Prefix.'_cb'];
        $idplh = $cbid[0];
        $this->form_idplh = $cbid[0];
        
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
    case 'SaveValid':{
        foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
       } 
       if ($validasi == 'on') {
         $status_validasi = "1";
       }else{
        $status_validasi = "0";
       }
       $getSKPD = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$renjaAsetNew_idplh'"));
       $cmbUrusanForm = $getSKPD['c1'];
       $cmbBidangForm = $getSKPD['c'];
       $cmbSKPDForm = $getSKPD['d'];
       $cmbUnitForm = $getSKPD['e'];
       $cmbSubUnitForm = $getSKPD['e1'];
       $bk = $getSKPD['bk'];
       $ck = $getSKPD['ck'];
       $p = $getSKPD['p'];
       $q = $getSKPD['q'];
       
       


       $data = array( "status_validasi" => $status_validasi,
              'user_validasi' => $_COOKIE['coID'],
              'tanggal_validasi' => date("Y-m-d")
              );
       $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$renjaAsetNew_idplh'");
       mysql_query($query);

      $content .= $query;
    break;
      }
    case 'sesuai':{
      foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
      } 
      $queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
      $getPlafonnya = mysql_fetch_array(mysql_query($queryRows));
      foreach ($getPlafonnya as $key => $value) { 
          $$key = $value; 
      } 
      $cmbUrusanForm = $c1;
      $cmbBidangForm = $c;
      $cmbSKPDForm = $d;
      $cmbUnitForm = $e;
      $cmbSubUnitForm = $e1;
      $bk = $bk;
      $p = $p;
      $ck = $ck;
      $q = $q;

      if($this->jenisForm  !='KOREKSI'){
        $err = "Tahap Koreksi Telah Habis";
      }else{
        $cekUrusan =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'"));
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
                    'nama_modul' => $this->modul
                    );
            $query = VulnWalkerInsert("tabel_anggaran", $data);
            $content .= $query;
            $cek .= "select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'";
            mysql_query($query) ;       
          }
          
          $cekBidang =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
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
                    'nama_modul' => $this->modul
                    
                    );
            $query = VulnWalkerInsert("tabel_anggaran", $data);
            $content .= $query;
            mysql_query($query) ;       
          }

          
          $cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$cmbSKPDForm' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0' and p = '00' and q='00'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
          if($cekSKPD > 0 ){
          }else{
            $data = array(
                      'c1' => $cmbUrusanForm,
                    'c'  => $cmbBidangForm,
                    'd'  => $cmbSKPDForm,
                    'e'  => '00',
                    'e1' => '000',
                    'bk' => '0',
                    'ck' => '0',
                    'p'  => '0',
                    'q'  => '0',
                    'jenis_anggaran' => $this->jenisAnggaran,
                    'id_tahap' => $this->idTahap,
                    'tahun' => $this->tahun,
                    'nama_modul' => $this->modul
                    
                    );
            $query = VulnWalkerInsert("tabel_anggaran", $data);
            $content .= $query;
            mysql_query($query);          
          }
            
            
            
            $cekUnit = "select * from tabel_anggaran where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '000' and bk='0' and ck ='0' and p = '0' and q='0' and id_tahap = '$this->idTahap'  ";
            if(mysql_num_rows(mysql_query($cekUnit))  == 0) {
              $data = array(
                      'jenis_anggaran' => $this->jenisAnggaran,
                      'tahun' => $this->tahun,
                      'c1' => $cmbUrusanForm,
                      'c' => $cmbBidangForm,
                      'd' => $cmbSKPDForm,
                      'e' => $cmbUnitForm,
                      'e1' => '000',
                      'bk' => '0',
                      'ck' => '0',
                      'p' => '0',
                      'q' => '0',
                      'id_tahap' => $this->idTahap,
                      'nama_modul' => $this->modul
                      );
               $query = VulnWalkerInsert("tabel_anggaran",$data);
               mysql_query($query);
            }
            $cekSubUnit = "select * from tabel_anggaran  where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '$cmbSubUnitForm' and bk='0' and ck ='0' and p = '0' and q='0' and id_tahap = '$this->idTahap' ";
            if(mysql_num_rows(mysql_query($cekSubUnit))  == 0) {
              $data = array(
                      'jenis_anggaran' => $this->jenisAnggaran,
                      'tahun' => $this->tahun,
                      'c1' => $cmbUrusanForm,
                      'c' => $cmbBidangForm,
                      'd' => $cmbSKPDForm,
                      'e' => $cmbUnitForm,
                      'e1' => $cmbSubUnitForm,
                      'bk' => '0',
                      'ck' => '0',
                      'p' => '0',
                      'q' => '0',
                      'id_tahap' => $this->idTahap,
                      'nama_modul' => $this->modul
                      );
               $query = VulnWalkerInsert("tabel_anggaran",$data);
               mysql_query($query);
            }
            $cekProgram = "select * from tabel_anggaran  where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '$cmbSubUnitForm' and bk ='$bk' and ck ='$ck' and p = '$p' and q='0' and id_tahap = '$this->idTahap'"; 
            if(mysql_num_rows(mysql_query($cekProgram)) == 0){
              $data = array(
                      'jenis_anggaran' => $this->jenisAnggaran,
                      'tahun' => $this->tahun,
                      'c1' => $cmbUrusanForm,
                      'c' => $cmbBidangForm,
                      'd' => $cmbSKPDForm,
                      'e' => $cmbUnitForm,
                      'e1' => $cmbSubUnitForm,
                      'bk' => $bk,
                      'ck' => $ck,
                      'p' => $p,
                      'q' => '0',
                      'id_tahap' => $this->idTahap,
                      'nama_modul' => $this->modul
                      );
               $query = VulnWalkerInsert("tabel_anggaran",$data);
               mysql_query($query);
            }
      
      $dataSesuai = array(
                      'jenis_anggaran' => $this->jenisAnggaran,
                      'tahun' => $this->tahun,
                      'c1' => $cmbUrusanForm,
                      'c' => $cmbBidangForm,
                      'd' => $cmbSKPDForm,
                      'e' => $cmbUnitForm,
                      'e1' => $cmbSubUnitForm,
                      'bk' => $bk,
                      'ck' => $ck,
                      'p' => $p,
                      'q' => $q,
                      'jumlah' => $jumlah,
                      'id_tahap' => $this->idTahap,
                      'nama_modul' => $this->modul,
                      'tanggal_update' => date('Y-m-d')
                    
                );      
      $cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p = '$p' and q='$q'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
          if($cekSKPD > 0 ){
            $getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p = '$p' and q='$q'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
              $idnya = $getID['id_anggaran'];
            mysql_query("update tabel_anggaran set jumlah = '$jumlah' where id_anggaran='$idnya'");
          }else{
            mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai)); 
            $content .=VulnWalkerInsert("tabel_anggaran", $dataSesuai); 
          }
      }
      
    
       
    break;
      }
    
    
    case 'koreksi':{
      foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
      } 
      $queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
      $getPlafonnya = mysql_fetch_array(mysql_query($queryRows));
      foreach ($getPlafonnya as $key => $value) { 
          $$key = $value; 
      } 
      $cmbUrusanForm = $c1;
      $cmbBidangForm = $c;
      $cmbSKPDForm = $d;
      $cmbUnitForm = $e;
      $cmbSubUnitForm = $e1;
      $bk = $bk;
      $p = $p;
      $ck = $ck;
      $q = $q;

      
      if($this->jenisForm !='KOREKSI'){
        $err = "Tahap Koreksi Telah Habis";
      }else{
        $cekUrusan =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'"));
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
                    'nama_modul' => $this->modul
                    );
            $query = VulnWalkerInsert("tabel_anggaran", $data);
            $content .= $query;
            $cek .= "select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'";
            mysql_query($query) ;       
          }
          
          $cekBidang =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
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
                    'nama_modul' => $this->modul
                    
                    );
            $query = VulnWalkerInsert("tabel_anggaran", $data);
            $content .= $query;
            mysql_query($query) ;       
          }

          
          $cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$cmbSKPDForm' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0' and p = '00' and q='00'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
          if($cekSKPD > 0 ){
          }else{
            $data = array(
                      'c1' => $cmbUrusanForm,
                    'c'  => $cmbBidangForm,
                    'd'  => $cmbSKPDForm,
                    'e'  => '00',
                    'e1' => '000',
                    'bk' => '0',
                    'ck' => '0',
                    'p'  => '0',
                    'q'  => '0',
                    'jenis_anggaran' => $this->jenisAnggaran,
                    'id_tahap' => $this->idTahap,
                    'tahun' => $this->tahun,
                    'nama_modul' => $this->modul
                    
                    );
            $query = VulnWalkerInsert("tabel_anggaran", $data);
            $content .= $query;
            mysql_query($query);          
          }
            
            
            
            $cekUnit = "select * from tabel_anggaran where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '000' and bk='0' and ck ='0' and p = '0' and q='0' and id_tahap = '$this->idTahap'  ";
            if(mysql_num_rows(mysql_query($cekUnit))  == 0) {
              $data = array(
                      'jenis_anggaran' => $this->jenisAnggaran,
                      'tahun' => $this->tahun,
                      'c1' => $cmbUrusanForm,
                      'c' => $cmbBidangForm,
                      'd' => $cmbSKPDForm,
                      'e' => $cmbUnitForm,
                      'e1' => '000',
                      'bk' => '0',
                      'ck' => '0',
                      'p' => '0',
                      'q' => '0',
                      'id_tahap' => $this->idTahap,
                      'nama_modul' => $this->modul
                      );
               $query = VulnWalkerInsert("tabel_anggaran",$data);
               mysql_query($query);
            }
            $cekSubUnit = "select * from tabel_anggaran  where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '$cmbSubUnitForm' and bk='0' and ck ='0' and p = '0' and q='0' and id_tahap = '$this->idTahap' ";
            if(mysql_num_rows(mysql_query($cekSubUnit))  == 0) {
              $data = array(
                      'jenis_anggaran' => $this->jenisAnggaran,
                      'tahun' => $this->tahun,
                      'c1' => $cmbUrusanForm,
                      'c' => $cmbBidangForm,
                      'd' => $cmbSKPDForm,
                      'e' => $cmbUnitForm,
                      'e1' => $cmbSubUnitForm,
                      'bk' => '0',
                      'ck' => '0',
                      'p' => '0',
                      'q' => '0',
                      'id_tahap' => $this->idTahap,
                      'nama_modul' => $this->modul
                      );
               $query = VulnWalkerInsert("tabel_anggaran",$data);
               mysql_query($query);
            }
            $cekProgram = "select * from tabel_anggaran  where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '$cmbSubUnitForm' and bk ='$bk' and ck ='$ck' and p = '$p' and q='0' and id_tahap = '$this->idTahap'"; 
            if(mysql_num_rows(mysql_query($cekProgram)) == 0){
              $data = array(
                      'jenis_anggaran' => $this->jenisAnggaran,
                      'tahun' => $this->tahun,
                      'c1' => $cmbUrusanForm,
                      'c' => $cmbBidangForm,
                      'd' => $cmbSKPDForm,
                      'e' => $cmbUnitForm,
                      'e1' => $cmbSubUnitForm,
                      'bk' => $bk,
                      'ck' => $ck,
                      'p' => $p,
                      'q' => '0',
                      'id_tahap' => $this->idTahap,
                      'nama_modul' => $this->modul
                      );
               $query = VulnWalkerInsert("tabel_anggaran",$data);
               mysql_query($query);
            }
       
       
       $dataSesuai = array('jenis_anggaran' => $this->jenisAnggaran,
                      'tahun' => $this->tahun,
                      'c1' => $cmbUrusanForm,
                      'c' => $cmbBidangForm,
                      'd' => $cmbSKPDForm,
                      'e' => $cmbUnitForm,
                      'e1' => $cmbSubUnitForm,
                      'bk' => $bk,
                      'ck' => $ck,
                      'p' => $p,
                      'q' => $q,
                      'jumlah' => $angkaKoreksi,
                      'id_tahap' => $this->idTahap,
                      'nama_modul' => $this->modul
                );
                
       $getIDPlafon = mysql_fetch_array(mysql_query("select max(id_anggaran) as idPlafon from view_plafon where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$cmbUrusanForm' and c = '$cmbBidangForm' and d = '$cmbSKPDForm'"));
       $idPlafon = $getIDPlafon['idPlafon'];
       $getJumlahPlafon = mysql_fetch_array(mysql_query("select plafon from view_plafon where id_anggaran = '$idPlafon'"));
       $jumlahPlafon = $getJumlahPlafon['plafon'];
       $concatKegiatan = $bk.".".$ck.".".$p.".".$q;
       $getTotalPagu = mysql_fetch_array(mysql_query("select sum(jumlah) as pagu from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut' and c1 = '$cmbUrusanForm' and c = '$cmbBidangForm' and d = '$cmbSKPDForm' "));
       $totalPagu = $getTotalPagu['pagu'];                
       
       $cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p = '$p' and q='$q'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
       if($cekSKPD > 0 ){
              
            $getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p = '$p' and q='$q'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
              $idnya = $getID['id_anggaran'];
            $pagu = $getID['jumlah'];
            $sisaPlafon = $jumlahPlafon - $totalPagu -  ($angkaKoreksi - $pagu);
            if($sisaPlafon >= 0){
              mysql_query("update tabel_anggaran set jumlah = '$angkaKoreksi' where id_anggaran='$idnya'");
            }else{
              $sesa = $jumlahPlafon -  $totalPagu - ($angkaKoreksi - $pagu) ;
              $err = "Tidak dapat melebihi plafon, sisa plafon = ".str_replace("-","",$sesa);
            }
            
      }else{
            $sisaPlafon = $jumlahPlafon -  $totalPagu - $angkaKoreksi;
            if($sisaPlafon >= 0){
              mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai)); 
            }else{
                $sesa = $jumlahPlafon -  $totalPagu - ($angkaKoreksi - $pagu);
              $err = "Tidak dapat melebihi plafon, sisa plafon = ".str_replace("-","",$sesa);
            }
            
      }
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
      $getMaxID = mysql_fetch_array(mysql_query("select max(id_anggaran) as maxID from tabel_anggaran where tahun = '$tahun'  and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q' and jenis_anggaran = '$jenis_anggaran' ")); 
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
     default:{
        $other = $this->set_selector_other2($tipe);
        $cek = $other['cek'];
        $err = $other['err'];
        $content=$other['content'];
        $json=$other['json'];
     break;
     }
     
   }//end switch
    
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }

   function setPage_OtherScript(){
      $angka = mysql_num_rows(mysql_query("select * from view_renja where id_tahap='$this->idTahap'"));
    
    /* if($this->jenisForm == "KOREKSI"){
    
       $noUrutKoreksi  = $this->nomorUrut - 1;
       $angka = mysql_num_rows(mysql_query("select * from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$noUrutKoreksi'"));
    
   
    
     }*/
    $scriptload = 
          "<script>
            $(document).ready(function(){ 
              ".$this->Prefix.".loading();
              
            });
            
           function checkAll4( n, fldName ,elHeaderChecked, elJmlCek) {
    
        if (!fldName) {
           fldName = 'cb';
        }
         if (!elHeaderChecked) {
           elHeaderChecked = 'toggle';
        }
        var c = document.getElementById(elHeaderChecked).checked;
        var n2 = 0;
        for (i=0; i < $angka ; i++) { 
          cb = document.getElementById(fldName+i);
          if (cb) {
            cb.checked = c;
            n2++;
          }
        }
        if (c) {    
          document.getElementById(elJmlCek).value = n2;
        } else {    
          document.getElementById(elJmlCek).value = 0;
        }
    } 
            
    
          </script>
    ";
    return  
      "<script src='js/skpd.js' type='text/javascript'></script>
      <script type='text/javascript' src='js/perencanaan_v3/renja/renjaAsetNew.js' language='JavaScript' ></script>
      <script type='text/javascript' src='js/perencanaan_v3/renja/renjaAsetNew_ins.js' language='JavaScript' ></script>
      <script type='text/javascript' src='js/perencanaan/renja/popupProgram.js' language='JavaScript' ></script>
      <script type='text/javascript' src='js/perencanaan/popupUrusanBidangProgram.js' language='JavaScript' ></script>
      <script type='text/javascript' src='js/master/ref_template/VulnWalkerFrameWork.js' language='JavaScript' ></script>
      <script type='text/javascript' src='js/master/ref_template/jquery.js' language='JavaScript' ></script>
      <script type='text/javascript' src='js/master/ref_template/jquery-ui.min.js' language='JavaScript'></script>
      <link rel='stylesheet' type='text/css' href='js/master/ref_template/jquery-ui.css'>
      <script type='text/javascript' src='js/master/refstandarharga/refbarang.js' language='JavaScript' ></script>
       <script type='text/javascript' src='js/master/ref_tandatangan/ref_tandatangan.js' language='JavaScript' ></script>
".
      $scriptload;
  }
function JudulLaporan($dari='', $sampai='',$judul=''){
    return "<div style='text-align:center;'>
        <span style='font-size:18px;font-weight:bold;text-decoration: underline;'>
          RENCANA KERJA SKPD $this->jenisAnggaran
        </span><br>
        <span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>";
  }
  function TandaTanganFooter($c1,$c,$d,$e,$e1){
    global $Main, $DataPengaturan,$HTTP_COOKIE_VARS;
    $getJenisReportAset = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURLAset' "));
    $getJenisUkuran = $getJenisReportAset['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTanganAset = explode(';', $getJenisReportAset['tanda_tangan']);
    $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));
    if (sizeof($arrayTandaTanganAset)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd];
            $arrayPosisi = $getJenisReportAset['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '14' and c1 = '$c1' and c = '$c' and d = '$d' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '14' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '14' "));

            $tandaTanganna .= "<br><br><br>

            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[titimangsa_surat].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            ".$hmm[jabatan]."
            <br>
            <br>
            <br>
            <br>
            <br>
            ".$hmm[nama]."<br>
            <hr style='border-color: black; margin: 0;'>
            NIP ".$hmm['nip']."
          
            
            </div>";

          }elseif (sizeof($arrayTandaTanganAset)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReportAset['posisi']);
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

          }elseif (sizeof($arrayTandaTanganAset)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReportAset['posisi']);
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
    return "
            ".$tandaTanganna."

            ";
  }
  function TanggalCetak($dt,$c1,$c,$d){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 400;
   $this->form_height = 100;
   $this->form_caption = 'RENCANA KERJA SKPD';

   $c1 = $dt['fmSKPDUrusan'];
   $c = $dt['fmSKPDBidang'];
   $d = $dt['fmSKPDskpd'];


    $cmbJenisLaporan = cmbArray('jenisKegiatan','',$arrayJenisLaporan,'-- JENIS LAPORAN --',"onchange = $this->Prefix.jenisChanged();");

    $queryNama12 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '14' and c1 = '$c1' and c = '$c' and d = '$d' "));

    $this->form_fields = array(
      
      'Cetakjang' => array(
                  'label'=>'TANGGAL CETAK',
                  'labelWiidth'=>100,
                  'value'=>"<input type='date' name='cetakjang' id='cetakjang' value='".date('Y-m-d')."'>
                  ",
                ),
      'username' => array(
                  'label'=>'USERNAME',
                  'labelWiidth'=>100,
                  'value'=>"<input type='text' name='username' id='username' readonly='readonly' value='".$this->username."'>
                  ",
                ),
      'ttd' => array(
                  'label'=>'TTD',
                  'labelWiidth'=>100,
                  'value'=>cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = '14' and c1 = '$c1' and c = '$c' and d = '$d'",'onchange=rka.refreshList(true);','-- TTD --'),

                ),
      );
    //tombol
    $this->form_menubawah =
      "
      <input type='button' value='TTD' onclick ='".$this->Prefix.".Baru()' title='TTD' >
      <input type='button' value='View' onclick ='".$this->Prefix.".Laporan()' title='Simpan' >   ".
      "<input type='button' value='Batal' onclick='renjaAset.Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }
  function LaporanTmplSKPD($c1, $c, $d, $e, $e1){
    global $Main, $DataPengaturan, $DataOption;
    
    $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
    $grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'")); 
    $urusan = $c1.". ".$grabUrusan['nm_skpd'];
    $grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
    $bidang = $c.". ".$grabBidang['nm_skpd'];
    $grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
    $skpd = $d.". ".$grabSkpd['nm_skpd'];
    
    
    
    $data = "
        <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif;'>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>URUSAN</td>
            <td width='1%' valign='top'> : </td>
            <td valign='top' style='font-size: 14px;'>".$urusan."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>BIDANG</td>
            <td width='1%' valign='top'> : </td>
            <td valign='top' style='font-size: 14px;'>".$bidang."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>SKPD</td>
            <td width='1%' valign='top'> : </td>
            <td valign='top' style='font-size: 14px;'>".$skpd."</td>
          </tr>
          
        </table>";
    
    return $data;
  }

}
$renjaAsetNew = new renjaAsetNewObj();

$arrayResult = tahapPerencanaanV3($renjaAsetNew->modul,"MURNI");


$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = "MURNI";
$idTahap = $arrayResult['idTahap'];

$renjaAsetNew->jenisForm = $jenisForm;
$renjaAsetNew->nomorUrut = $nomorUrut;
$renjaAsetNew->tahun = $tahun;
$renjaAsetNew->jenisAnggaran = $jenisAnggaran;
$renjaAsetNew->idTahap = $idTahap;
$renjaAsetNew->username = $_COOKIE['coID'];
$renjaAsetNew->wajibValidasi = $arrayResult['wajib_validasi'];
$renjaAsetNew->settingAnggaran = $arrayResult['settingAnggaran'];
?>