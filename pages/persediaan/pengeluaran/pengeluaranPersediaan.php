<?php

class pengeluaranPersediaanObj  extends DaftarObj2{
  var $Prefix = 'pengeluaranPersediaan';
  var $elCurrPage="HalDefault";
  var $SHOW_CEK = TRUE;
  var $TblName = 'pengeluaran'; //bonus
  var $TblName_Hapus = 'pengeluaran';
  var $MaxFlush = 10;
  var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
  var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
  var $KeyFields = array('id');
  var $FieldSum = array();//array('jml_harga');
  var $SumValue = array();
  var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
  var $FieldSum_Cp2 = array( 1, 1, 1);
  var $checkbox_rowspan = 2;
  var $PageTitle = 'PENGELUARAN';
  var $PageIcon = 'images/masterData_01.gif';
  var $pagePerHal ='';
  //var $cetak_xls=TRUE ;
  var $fileNameExcel='pengeluaranPersediaan.xls';
  var $namaModulCetak='PENGELUARAN';
  var $Cetak_Judul = 'PENGELUARAN';
  var $Cetak_Mode=2;
  var $Cetak_WIDTH = '30cm';
  var $Cetak_OtherHTMLHead;
  var $FormName = 'pengeluaranPersediaanForm';
  var $modul = "PENGELUARAN";
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

  function setFormBaruTTD(){
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
      $dt['c1'] = $_REQUEST[$this->Prefix.'pengeluaranPersediaanSKPD2fmURUSAN'];
      $dt['c'] = $_REQUEST[$this->Prefix.'pengeluaranPersediaanSKPD2fmSKPD'];
      $dt['d'] = $_REQUEST[$this->Prefix.'pengeluaranPersediaanSKPD2fmUNIT'];
      $dt['e'] = $_REQUEST[$this->Prefix.'pengeluaranPersediaanSKPD2fmSUBUNIT'];
      $dt['e1'] = $_REQUEST[$this->Prefix.'pengeluaranPersediaanSKPD2fmSEKSI'];
      $fm = $this->setFormTTD($dt);
    }
      return  array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  }

function setFormTTD($dt,$c1,$c,$d,$e,$e1){  
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
            <input type='text' name='de' id='de' value='".$date."' style='width:500px;' readonly>
            <input type ='hidden' name='e' id='e' value='".$querye['e']."'>
            </div>", 
             ),
      'subunit' => array( 
            'label'=>'SUBUNIT',
            'labelWidth'=>150, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='de1' id='de1' value='".$date1."' style='width:500px;' readonly>
            <input type ='hidden' name='e1' id='e1' value='".$querye1['e1']."'>
            </div>", 
             ),
      'kategori' => array( 
            'label'=>'KATEGORI',
            'labelWidth'=>150,
            'value'=>"<input type='text' style='width: 250px;' readonly='readonly' id='kategori' name='kategori' value='".$queryKategori1[kategori_tandatangan]."'  >",
          
            
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
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanTTD()' title='Simpan' >".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
              
    $form = $this->genForm();   
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

function simpanTTD(){
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
    return 'PENGELUARAN';
  }
  function setMenuView(){
    return
      // "<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";
      "";
  }
  function setMenuEdit(){

    $listMenu =
          "<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru ", 'Baru ')."</td>".
          "<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
          "<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>".
          "<td>".genPanelIcon("javascript:".$this->Prefix.".Posting()","publishdata.png","Posting ", 'Posting ')."</td>".
          "<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan3()","print_f2.png","Laporan ", 'Laporan ')."</td>".
          "<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan4()","print_f2.png","Form ", 'Form ')."</td>"
          ;


    return $listMenu ;
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

    case 'pilihPangkat':{
      global $Main;
      $cek = ''; $err=''; $content=''; $json=TRUE;
      
      $idpangkat = $_REQUEST['pangkatakhir'];
      
      $query = "select concat(gol,'/',ruang)as nama FROM ref_pangkat WHERE nama='$idpangkat'" ;
      $get=mysql_fetch_array(mysql_query($query));$cek.=$query;
      $content=$get['nama'];                      
      break;
    }

    case 'Pengeluaran':{
      $json = FALSE;
      $this->Pengeluaran();
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
    case 'Report2':{
      $id = $_REQUEST['pengeluaranPersediaan_cb'];
      foreach ($_REQUEST as $key => $value) {
         $$key = $value;
      }

      
      $getDataPengeluaran = mysql_fetch_array(mysql_query("select * from pengeluaran where id = '".$id[0]."'"));
      // if($getDataPengeluaran['status_posting'] == 1){
      //     $err = "Data sudah di posting tidak dapat di ubah !";
      // }
      $kodeSKPD = $getDataPengeluaran['c1'].".".$getDataPengeluaran['c'].".".$getDataPengeluaran['d'].".".$getDataPengeluaran['e'].".".$getDataPengeluaran['e1'];
      $nomor = $getDataPengeluaran['yang_menyerahkan'];
      $idna = $getDataPengeluaran['id'];

      if(empty($err)){
        $getAllDetailPengeluaran = mysql_query("select * from detail_pengeluaran where id_pengeluaran ='".$id[0]."'");
        while ($detailPengeluaran = mysql_fetch_array($getAllDetailPengeluaran)) {
          foreach ($detailPengeluaran as $key => $value) {
              $$key = $value;
          }
          $dataDetail = array(
                      'f1' => $f1,
                      'f2' => $f2,
                      'f' => $f,
                      'g' => $g,
                      'h' => $h,
                      'i' => $i,
                      'j' => $j,
                      'j1' => $j1,
                      'jumlah' => $jumlah,
                      'merk' => $merk,
                      'keterangan' => $keterangan,
                      'id_pengeluaran' => $detailPengeluaran['id'],
                      'username' => $this->username
          );
          $query = VulnWalkerInsert('temp_pengeluaran',$dataDetail);
          mysql_query($query);
          $cek = $query;

        }
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
        $content = array('to' => $jenisKegiatan, 'ttd' => $ttd, 'cetakjang' => $cetakjang, 'nomor' => $nomor, 'idna' => $idna );
      // }
    break;
    }
    case 'kartuPersediaan':{
      $json = FALSE;
      $this->kartuPersediaan();
    break;
    }
    case 'kartuPersediaanBarang':{
      $json = FALSE;
      $this->kartuPersediaanBarang();
    break;
    }
    case 'Laporan':{
      $json = FALSE;
      $this->Laporan();
    break;
    }
    case 'kartuBarang':{
      $json = FALSE;
      $this->kartuBarang();
    break;
    }
    case 'Laporan5':{
      $json = FALSE;
      $this->Laporan5();
    break;
    }
    case 'Laporan3':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
        $fm = $this->Laporan3($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
      break;

    }
    case 'Laporan4':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
        $fm = $this->Laporan4($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
      break;

    }
    case 'formBaruTTD':{
      $fm = $this->setFormBaruTTD();
      $cek = $fm['cek'];
      $err = $fm['err'];
      $content = $fm['content'];
    break;
    }
    case 'simpanTTD':{
      $get= $this->simpanTTD();
      $cek = $get['cek'];
      $err = $get['err'];
      $content = $get['content'];
    break;
     }
    case 'savePosting':{
      foreach ($_REQUEST as $key => $value) {
         $$key = $value;
      }
      $getData = mysql_fetch_array(mysql_query("select * from pengeluaran where id = '$idPosting'"));
      $explodeTanggalBuku = explode($getData['tanggal_buku']);
      $bulanBuku = $explodeTanggalBuku[1];
      if($bulanBuku <= 6){
        $semesterPosting = "1";
      }elseif($bulanBuku >= 7){
        $semesterPosting = "2";
      }
      $getDetailPengeluaran = mysql_query("select * from detail_pengeluaran where id_pengeluaran = '$idPosting'");
      while ($detailPengeluaran = mysql_fetch_array($getDetailPengeluaran) ) {
        if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where  c1 ='".$getData['c1']."' and c ='".$getData['c']."' and d ='".$getData['d']."' and e ='".$getData['e']."' and e1 ='".$getData['e1']."' and f1 ='".$detailPengeluaran['f1']."' and f2 ='".$detailPengeluaran['f2']."' and f ='".$detailPengeluaran['f']."' and g ='".$detailPengeluaran['g']."' and h ='".$detailPengeluaran['h']."' and i ='".$detailPengeluaran['i']."' and j ='".$detailPengeluaran['j']."' and j1 ='".$detailPengeluaran['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '$semesterPosting' ")) == 0)
        {
            if($statusPosting == 'on' && $getData['status_posting'] == 0){
              $dataPosting = array(
                                      'c1' => $getData['c1'],
                                      'c' => $getData['c'],
                                      'd' => $getData['d'],
                                      'e' => $getData['e'],
                                      'e1' => $getData['e1'],
                                      'bk' => $getData['bk'],
                                      'ck' => $getData['ck'],
                                      'dk' => $getData['dk'],
                                      'p' => $getData['p'],
                                      'q' => $getData['q'],
                                      'f1' => $detailPengeluaran['f1'],
                                      'f2' => $detailPengeluaran['f2'],
                                      'f' => $detailPengeluaran['f'],
                                      'g' => $detailPengeluaran['g'],
                                      'h' => $detailPengeluaran['h'],
                                      'i' => $detailPengeluaran['i'],
                                      'j' => $detailPengeluaran['j'],
                                      'j1' => $detailPengeluaran['j1'],
                                      'merk' => $detailPengeluaran['merk'],
                                      'jumlah' => $detailPengeluaran['jumlah'],
                                      'keterangan' => $detailPengeluaran['keterangan'],
                                      'jns' => 6,
                                      'jenis_persediaan' => 2,
                                      'nomor' => $getData['nomor'],
                                      'refid' => $idPosting,
                                      'tanggal_buku' => $getData['tanggal'],
                                      'merk' => $detailPengeluaran['merk']
                                  );
              $query = VulnWalkerInsert("t_kartu_persediaan",$dataPosting);
              mysql_query($query);
            }
          }else{
              $err = "Data sudah di kunci !";
          }
      }
      if($err == ''){
        if($statusPosting == 'on'){
          mysql_query("update pengeluaran set status_posting = '1' where id = '$idPosting'");
          //$err = "update pengeluaran set status_posting = '1' where id = '$idPosting'";
        }else{
          mysql_query("update pengeluaran set status_posting = '0' where id = '$idPosting'");
          //$err = "beda";
        }
        if($statusPosting != 'on'){
          mysql_query("delete from t_kartu_persediaan where refid = '$idPosting' and jns='6' and jenis_persediaan ='2'");
        }
      }else{
          mysql_query("delete from t_kartu_persediaan where refid = '$idPosting' and jns='6' and jenis_persediaan ='2'");
      }

      //$cek = "update pengeluaran set status_posting = '1' where id = '$idPosting'";
    break;
    }
    case 'formBaru':{
      foreach ($_REQUEST as $key => $value) {
         $$key = $value;
      }

      if(empty($cmbUrusan)){
        $err = "Pilih Urusan";
      }elseif(empty($cmbBidang)){
        $err = "Pilih Bidang";
      }elseif(empty($cmbSKPD)){
        $err = "Pilih SKPD";
      }elseif(empty($cmbUnit)){
        $err = "Pilih Unit";
      }elseif(empty($cmbBidang)){
        $err = "Pilih Bidang";
      }elseif(empty($q)){
        $err = "Pilih Kegiatan";
      }elseif(empty($cmbJenisPENGELUARAN)){
        $err = "Pilih Jenis PENGELUARAN";
      }else{
        $fm = $this->setFormBaru();
        $cek = $fm['cek'];
        $err = $fm['err'];
        $content = $fm['content'];
      }


    break;
    }
    case 'Info':{
        $fm = $this->Info();
        $cek .= $fm['cek'];
        $err = $fm['err'];
        $content = $fm['content'];
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
    case 'newTab':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
      }
      mysql_query("delete from temp_pengeluaran where username = '$this->username'");
      mysql_query("delete from delete_temp_pengeluaran where username = '$this->username'");
      $getDataMax = mysql_fetch_array(mysql_query("select max(nomor) from pengeluaran where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  "));
      $explodeNomor = explode('/',$getDataMax['max(nomor)']);
      $nomorTerakhir = $explodeNomor[0] + 1;
      $nomorPengeluaran = $this->kasihNol($nomorTerakhir );
      $nomor = $nomorPengeluaran."/"."P/".$c1.".".$c.".".$d.".".$e.".".$e1."/".$_COOKIE['coThnAnggaran'];

      $dataInsert = array(
                'c1' => $c1,
                'c' => $c,
                'd' => $d,
                'e' => $e,
                'e1' => $e1,
                'nomor' => $nomor,
                'status_temp' => "1",
                'tanggal' => $_COOKIE['coThnAnggaran']."-".date("m-d"),
      );
      $query = VulnWalkerInsert($this->TblName,$dataInsert);
      mysql_query($query);
      $cek = $query;
      $content = array("nomor" => $nomor);

    break;
    }




    case 'editTab':{
      mysql_query("delete from temp_pengeluaran where username = '$this->username'");
      mysql_query("delete from delete_temp_pengeluaran where username = '$this->username'");
      $id = $_REQUEST['pengeluaranPersediaan_cb'];
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
      }
      $getDataPengeluaran = mysql_fetch_array(mysql_query("select * from pengeluaran where id = '".$id[0]."'"));
      if($getDataPengeluaran['status_posting'] == 1){
          $err = "Data sudah di posting tidak dapat di ubah !";
      }
      $kodeSKPD = $getDataPengeluaran['c1'].".".$getDataPengeluaran['c'].".".$getDataPengeluaran['d'].".".$getDataPengeluaran['e'].".".$getDataPengeluaran['e1'];
      $nomor = $getDataPengeluaran['nomor'];

      if(empty($err)){
        $getAllDetailPengeluaran = mysql_query("select * from detail_pengeluaran where id_pengeluaran ='".$id[0]."'");
        while ($detailPengeluaran = mysql_fetch_array($getAllDetailPengeluaran)) {
          foreach ($detailPengeluaran as $key => $value) {
              $$key = $value;
          }
          $dataDetail = array(
                      'f1' => $f1,
                      'f2' => $f2,
                      'f' => $f,
                      'g' => $g,
                      'h' => $h,
                      'i' => $i,
                      'j' => $j,
                      'j1' => $j1,
                      'jumlah' => $jumlah,
                      'merk' => $merk,
                      'keterangan' => $keterangan,
                      'id_pengeluaran' => $detailPengeluaran['id'],
                      'username' => $this->username
          );
          $query = VulnWalkerInsert('temp_pengeluaran',$dataDetail);
          mysql_query($query);
          $cek = $query;

        }
      }

        $content = array('skpd' => $kodeSKPD,'nomor'=> $nomor);
      break;
    }

    case 'Remove':{
      $id = $_REQUEST['pengeluaranPersediaan_cb'];
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
      }

      $username = $_COOKIE['coID'];

      $get = mysql_fetch_array(mysql_query("select * from tabel_PENGELUARAN where id ='$id[0]'"));
      $kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

      $getAll = mysql_query("select * from tabel_PENGELUARAN where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and status_validasi !='1' order by o1, rincian_perhitungan");
      mysql_query("delete from temp_rka_21 where user='$username'");
      mysql_query("delete from temp_rincian_volume_21 where user='$username'");
        mysql_query("delete from temp_alokasi_rka_21_v2 where user='$username'");
      while($rows = mysql_fetch_array($getAll)){
        foreach ($rows as $key => $value) {
          $$key = $value;
        }
        mysql_query("delete from tabel_PENGELUARAN where id = '$id'");
        //mysql_query("delete from tabel_PENGELUARAN where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and o1 ='$o1' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and jenis_rka='2.1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");

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


          $qry = "SELECT * FROM tabel_PENGELUARAN WHERE id = '$idplh' ";$cek=$qry;
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

      $getData = mysql_fetch_array(mysql_query("SELECT * FROM tabel_PENGELUARAN WHERE id = '$idAwal'"));
      foreach ($getData as $key => $value) {
          $$key = $value;
      }
      $getMaxID = mysql_fetch_array(mysql_query("select max(id) as maxID from tabel_PENGELUARAN where tahun = '$tahun'  and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q' and jenis_anggaran = '$jenis_anggaran'  "));
      $maxID = $getMaxID['maxID'];
      $aqry = "select * from tabel_PENGELUARAN where id ='$maxID' ";
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

    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
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
      <script type='text/javascript' src='js/persediaan/pengeluaran/pengeluaranPersediaan.js' language='JavaScript' ></script>
        <link rel='stylesheet' href='datepicker/jquery-ui.css'>
        <script src='datepicker/jquery-1.12.4.js'></script>
        <script src='datepicker/jquery-ui.js'></script>

      ".
      $scriptload;
  }

  function setFormBaru(){
    $dt=array();
    //$this->form_idplh ='';
    $this->form_fmST = 0;
    $dt['tgl'] = date("Y-m-d");
    $fm = $this->setForm($dt);
    return  array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  }

    function setFormEdit(){
    $cek ='';
    $cbid = $_REQUEST[$this->Prefix.'_cb'];
    $this->form_idplh = $cbid[0];
    $kode = explode(' ',$this->form_idplh);
    $this->form_fmST = 1;
    if($err == ''){
      $aqry = "SELECT * FROM  tabel_PENGELUARAN WHERE id='".$this->form_idplh."' "; $cek.=$aqry;
      $dt = mysql_fetch_array(mysql_query($aqry));
      $fm = $this->setForm($dt);
    }

    return  array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
  }
  function Info(){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 500;
   $this->form_height = 100;
   $this->form_caption = 'INFO PENGELUARAN';


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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

  function setForm($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 700;
   $this->form_height = 400;
    if ($this->form_fmST==0) {


    }else{
    $this->form_caption = 'Edit';
    foreach ($dt as $key => $value) {
         $$key = $value;
     }
     $getNamaUrusan = mysql_fetch_array(mysql_query("select concat(c1,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='00' and d='00' and e='00' and e1 = '000'"));
     $namaUrusan = $getNamaUrusan['nama'];
     $urusan = "<input type ='hidden' name='c1' id='c1' value = '$c1' > <input type ='text'  value = '$namaUrusan' style='width:400px;' readonly>";

     $getNamaBidang = mysql_fetch_array(mysql_query("select concat(c,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='00' and e='00' and e1 = '000'"));
     $namaBidang = $getNamaBidang['nama'];
     $bidang = "<input type ='hidden' name='c' id='c' value = '$c' > <input type ='text'  value = '$namaBidang' style='width:400px;' readonly>";

     $getNamaSKPD = mysql_fetch_array(mysql_query("select concat(d,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$d' and e='00' and e1 = '000'"));
     $namaSKPD = $getNamaSKPD['nama'];
     $skpd = "<input type ='hidden' name='d' id='d' value = '$d' > <input type ='text'  value = '$namaSKPD' style='width:400px;' readonly>";

     $getNamaUnit = mysql_fetch_array(mysql_query("select concat(e,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$e' and e='$e' and e1 = '000'"));
     $namaUnit = $getNamaUnit['nama'];
     $unit = "<input type ='hidden' name='e' id='e' value = '$e' > <input type ='text'  value = '$namaUnit' style='width:400px;' readonly>";

     $getNamaSubUnit = mysql_fetch_array(mysql_query("select concat(e1,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$d' and e='$e' and e1 = '$e1'"));
     $namaSubUnit = $getNamaSubUnit['nama'];
     $subunit = "<input type ='hidden' name='e1' id='e1' value = '$e1' > <input type ='text'  value = '$namaSubUnit' style='width:400px;' readonly>";

     $getProgram = mysql_fetch_array(mysql_query("select concat(p,'. ',nama) as nama from ref_program where bk='$bk' and ck='$ck' and dk = '0' and p = '$p' and q= '0'"));
     $namaProgram = $getProgram['nama'];
     $program = "<input type ='hidden' name='bk' id='bk' value = '$bk' > <input type ='hidden' name='ck' id='ck' value = '$ck' > <input type ='hidden' name='p' id='p' value = '$p' > <input type ='text'  value = '$namaProgram' style='width:400px;' readonly>";

     $getKegiatan = mysql_fetch_array(mysql_query("select concat(q,'. ',nama) as nama from ref_program where bk='$bk' and ck='$ck' and dk = '0' and p = '$p' and q= '$q'"));
     $namaKegiatan = $getKegiatan['nama'];
     $kegiatan = "<input type ='hidden' name='q' id='q' value = '$q' > <input type ='text'  value = '$namaKegiatan' style='width:400px;' readonly>";

     $kodeRENJA = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$p.".".$q;
     $hargaSatuan = $satuan_rek;
     $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j ;
     $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
     $namaBarang = $getNamaBarang['nm_barang'];
     $kodeRekening = $k.".".$l.".".$m.".".$n.".".$o ;
     $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
     $namaRekening = $getNamaRekening['nm_rekening'];
     $arrayJenisPENGELUARAN = array(
            array("2.1","PENGELUARAN 2.1"),
            array("2.1","PENGELUARAN 2.1")

            );
     $jenis_rka = $jenis_rka;
     $cmbJenisPENGELUARAN = cmbArray('cmbJenisPENGELUARANForm',$jenis_rka,$arrayJenisPENGELUARAN,'-- JENIS PENGELUARAN --','onchange=pengeluaranPersediaan.unlockFindRekening();');
     if(empty($jenis_rka)){
      $tergantungJenis = "disabled";
     }

     $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
     $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
     $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and id_tahap = '$idTahapRenja' "));
     $angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');

     $formPaguIndikatif  = " <input type='hidden' id='paguIndifkatif' name='paguIndikatif' value='".$getPaguIndikatif['jumlah']."' ><input type='text' value='$angkaPaguIndikatif' readonly >";
    }



   //items ----------------------
    $this->form_fields = array(
          'kode0' => array(
              'label'=>'URUSAN',
            'labelWidth'=>150,
            'value'=> $urusan
             ),
        'kode1' => array(
              'label'=>'BIDANG',
            'labelWidth'=>150,
            'value'=> $bidang
             ),
      'kode2' => array(
            'label'=>'SKPD',
            'labelWidth'=>150,
            'value'=> $skpd
             ),
      'kode3' => array(
            'label'=>'UNIT',
            'labelWidth'=>150,
            'value'=> $unit
             ),
      'kode4' => array(
            'label'=>'SUB UNIT',
            'labelWidth'=>150,
            'value'=> $subunit
             ),
      'kode5' => array(
            'label'=>'PROGRAM',
            'labelWidth'=>150,
            'value'=> "<input type='hidden' name = 'bk' id = 'bk' value='$bk'> <input type='hidden' name = 'ck' id = 'ck' value='$ck'>".$program
             ),
      'kode6' => array(
            'label'=>'KEGIATAN',
            'labelWidth'=>150,
            'value'=> $kegiatan
             ),
      'kode12' => array(
            'label'=>'PAGU INDIKATIF',
            'labelWidth'=>150,
            'value'=> $formPaguIndikatif
             ),
      'kode11' => array(
            'label'=>'JENIS PENGELUARAN',
            'labelWidth'=>150,
            'value'=> $cmbJenisPENGELUARAN,
             ),
      'kode9' => array(
            'label'=>'BARANG',
            'labelWidth'=>150,
            'value'=> "<input type='text' id='kodeBarang' name='kodeBarang' style='width:120px;' readonly value = '$kodeBarang'> &nbsp&nbsp
             <input type='text' id='namaBarang' name='namaBarang' style='width:300px;' readonly value = '$namaBarang'> "
             ),
      'kode7' => array(
            'label'=>'REKENING',
            'labelWidth'=>150,
            'value'=> "<input type='text' id='kodeRekening' name='kodeRekening' style='width:120px;' readonly value = '$kodeRekening'> &nbsp&nbsp
             <input type='text' id='namaRekening' name='namaRekening' style='width:300px;' readonly value = '$namaRekening'>
             <button type='button' id='findRekening' onclick=pengeluaranPersediaan.findRekening('$jenis_rka'); $tergantungJenis> CARI </button> "
             ),
      'kode8' => array(
            'label'=>'HARGA SATUAN',
            'labelWidth'=>150,
            'value'=> "<input type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='pengeluaranPersediaan.bantu();' > <span id='bantu' style='color:red;'> </span>"
             ),


      );
    //tombol
    $this->form_menubawah =
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >  &nbsp  ".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }
  function Posting($idPosting){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 350;
   $this->form_height = 80;

    $this->form_caption = 'Posting';
    $getData = mysql_fetch_array(mysql_query("select * from pengeluaran where id = '$idPosting'"));
    if($getData['status_posting'] == 1){
      $statusPosting = "checked";
    }
    $nomorPengeluaran = $getData['nomor'];

   //items ----------------------
    $this->form_fields = array(
      'kode0' => array(
          'label'=>'NOMOR PENGELUARAN',
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }



  //daftar =================================
  function setKolomHeader($Mode=1, $Checkbox=''){



    $headerTable =
      "<thead>
       <tr>
       <th class='th01' width='20'>NO</th>
       $Checkbox
       <th class='th01' width='70'>TANGGAL</th>
       <th class='th01' width='40'>NOMOR</th>
       <th class='th01' width='1000'>NAMA BARANG</th>
       <th class='th01' width='100'>MERK/ TYPE/ SPESIFIKASI</th>
       <th class='th01' width='50'>JUMLAH</th>
       <th class='th01' width='100'>KETERANGAN</th>
       <th class='th01' width='50'>POSTING</th>



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



    // $Koloms = array();
    // $Koloms[] = array(' align="center"',$no);
    // $Koloms[] = array(' align="center"',$TampilCheckBox);
    // $Koloms[] = array(' align="center"',$this->generateDate($tanggal));
    // $explodeNomor = explode('/',$nomor);
    // $Koloms[] = array(' align="left"',$explodeNomor[0]."/".$explodeNomor[1]."...");
    // $getAllBarang = mysql_query("select * from detail_pengeluaran where id_pengeluaran = '$id'");
    // while ($dataBarang = mysql_fetch_array($getAllBarang)) {
    //    $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='".$dataBarang['f1']."' and f2='".$dataBarang['f2']."' and f='".$dataBarang['f']."' and g='".$dataBarang['g']."'  and h='".$dataBarang['h']."'  and i='".$dataBarang['i']."' and j='".$dataBarang['j']."' and j1='".$dataBarang['j1']."'"));
    //    $listBarang .= $getNamaBarang['nm_barang']."<br>";
    //    $listJumlahBarang .= number_format($dataBarang['jumlah'],0,',','.')."<br>";
    //    $listKeterangan .= $dataBarang['keterangan']."<br>";
    // }
    // $Koloms[] = array(' align="left"',$listBarang);
    // $Koloms[] = array(' align="right"',$listJumlahBarang);
    // $Koloms[] = array(' align="left"',$listKeterangan);
    // if($status_posting == '1'){
    //  $statusPosting = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px'> </img>";
    // }else{
    //  $statusPosting = "<img src='images/administrator/images/invalid.png' width='20px' heigh='20px'> </img>";
    // }
    // $Koloms[] = array(' valign="middle" align="center"',$statusPosting);
    $explodeNomor = explode('/',$nomor);
    if($status_posting == '1'){
      $statusPosting = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px'> </img>";
    }else{
      $statusPosting = "<img src='images/administrator/images/invalid.png' width='20px' heigh='20px'> </img>";
    }
    $getBarangPertama = mysql_fetch_array(mysql_query("select min(id) from detail_pengeluaran where id_pengeluaran = '$id'"));
    $getDataBarangPertama = mysql_fetch_array(mysql_query("select * from detail_pengeluaran where id = '".$getBarangPertama['min(id)']."'"));
    $getnamaBarangPertama = mysql_fetch_array(mysql_query("select * from ref_barang where f1='".$getDataBarangPertama['f1']."' and f2='".$getDataBarangPertama['f2']."' and f='".$getDataBarangPertama['f']."' and g='".$getDataBarangPertama['g']."'  and h='".$getDataBarangPertama['h']."'  and i='".$getDataBarangPertama['i']."' and j='".$getDataBarangPertama['j']."' and j1='".$getDataBarangPertama['j1']."'"));

    $kolomPengeluaran = "
      <tr class='row0' valign='top'>
        <td align='center' class='GarisDaftar' >$no</td>
        <td align='center' class='GarisDaftar'  >$TampilCheckBox</td>
        <td align='center' class='GarisDaftar'  >".$this->generateDate($tanggal)."</td>
        <td align='left' class='GarisDaftar'  >".$explodeNomor[0]."/".$explodeNomor[1]."..."."</td>
        <td align='left' class='GarisDaftar'  >".$getnamaBarangPertama['nm_barang']."</td>
        <td align='left' class='GarisDaftar'  >".$getDataBarangPertama['merk']."</td>
        <td align='right' class='GarisDaftar'  >".number_format($getDataBarangPertama['jumlah'],0,',','.')."</td>
        <td align='left' class='GarisDaftar'  >".$getDataBarangPertama['keterangan']."</td>
        <td align='center' valign='middle' class='GarisDaftar'  >$statusPosting</td>
      </tr>
    ";
    $getAllBarang = mysql_query("select * from detail_pengeluaran where id_pengeluaran = '$id' and id!='".$getBarangPertama['min(id)']."'");
    while ($dataBarang = mysql_fetch_array($getAllBarang)) {
      $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='".$dataBarang['f1']."' and f2='".$dataBarang['f2']."' and f='".$dataBarang['f']."' and g='".$dataBarang['g']."'  and h='".$dataBarang['h']."'  and i='".$dataBarang['i']."' and j='".$dataBarang['j']."' and j1='".$dataBarang['j1']."'"));
      $kolomDetailPengeluaran .= "
        <tr class='row0' valign='top'>
          <td align='center' class='GarisDaftar' ></td>
          <td align='center' class='GarisDaftar'  ></td>
          <td align='center' class='GarisDaftar'  ></td>
          <td align='left' class='GarisDaftar'  ></td>
          <td align='left' class='GarisDaftar'  >". $getNamaBarang['nm_barang']."</td>
          <td align='left' class='GarisDaftar'  >".$dataBarang['merk']."</td>
          <td align='right' class='GarisDaftar'  >".number_format($dataBarang['jumlah'],0,',','.')."</td>
          <td align='left' class='GarisDaftar'  >".$dataBarang['keterangan']."</td>
          <td align='center' valign='middle' class='GarisDaftar'  ></td>
        </tr>
      ";
        // $listBarang .= $getNamaBarang['nm_barang']."<br>";
        // $listJumlahBarang .= number_format($dataBarang['jumlah'],0,',','.')."<br>";
        // $listKeterangan .= $dataBarang['keterangan']."<br>";
    }
    $Koloms = array(
      array("VulnWalker", $kolomPengeluaran.$kolomDetailPengeluaran)
     );




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
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 400;
   $this->form_height = 120;
   $this->form_caption = 'VALIDASI PENGELUARAN 2.1';
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

  function Catatan($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }


  function genDaftarOpsi(){
   global $Ref, $Main;

$jumlahData = $_REQUEST['jumlahData'];
if(empty($jumlahData))$jumlahData = 50;
      $TampilOpt =
          "<tr><td>".
          genFilterBar(array(WilSKPD_ajx3($this->Prefix.'SKPD2','100%','145px')),'','','').
          genFilterBar(
            array(
              "TAHUN &nbsp &nbsp <input type='text' value='".$_COOKIE['coThnAnggaran']."' style='width:40px;' readonly>&nbsp &nbsp &nbsp &nbsp JUMLAH DATA &nbsp &nbsp <input type='text' name ='jumlahData' id='jumlahData' value ='$jumlahData' style='width:40px;'>  &nbsp <input type='button' onclick =$this->Prefix.refreshList(true); value='Tampilkan'>"
          ),'','','')

            ;

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
    if($pengeluaranPersediaanSKPD2fmURUSAN !='00'){
        $arrKondisi[] = "c1 = '$pengeluaranPersediaanSKPD2fmURUSAN'";
    }
    if($pengeluaranPersediaanSKPD2fmSKPD !='00'){
        $arrKondisi[] = "c = '$pengeluaranPersediaanSKPD2fmSKPD'";
    }
    if($pengeluaranPersediaanSKPD2fmUNIT !='00'){
        $arrKondisi[] = "d = '$pengeluaranPersediaanSKPD2fmUNIT'";
    }
    if($pengeluaranPersediaanSKPD2fmSUBUNIT !='00'){
        $arrKondisi[] = "e = '$pengeluaranPersediaanSKPD2fmSUBUNIT'";
    }
    if($pengeluaranPersediaanSKPD2fmSEKSI !='00'){
        $arrKondisi[] = "e1 = '$pengeluaranPersediaanSKPD2fmSEKSI'";
    }
    $arrKondisi[] = "status_temp  != '1'";
    $arrKondisi[] = "left(tanggal,4) = '".$_COOKIE['coThnAnggaran']."'";
    $Kondisi= join(' and ',$arrKondisi);
    $Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;
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
    //$Limit = " limit ".(($HalDefault  *1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
    $Limit = " limit ".(($HalDefault  *1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
    $Limit = $Mode == 3 ? '': $Limit;
    //noawal ------------------------------------
    $NoAwal= $pagePerHal * (($HalDefault*1) - 1);
    $NoAwal = $Mode == 3 ? 0: $NoAwal;

    return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal );

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
function kartuPersediaan($xls =FALSE){
    global $Main;
    $getJenisReport1 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL1' "));
    $getJenisUkuran = $getJenisReport1['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTangan1 = explode(';', $getJenisReport1['tanda_tangan']);

    $this->fileNameExcel = "USULAN RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG";
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



    $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
    $getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
    $getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul !='KOREKSI PENGGUNA' and jenis_form_modul !='KOREKSI PENGELOLA' "));
    $lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
    $getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
    $lastNomorUrut = $getLastTahap['no_urut'];
    $getMinJenisForm = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran'"));
    if($getMinJenisForm['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE){
        $kondisiValid = " and status_validasi = '1'";
    }

    $arrKondisi = array();

    $grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and p !='0' and q='0'");
    while($rows = mysql_fetch_array($grabProgram)){
      foreach ($rows as $key => $value) {
          $$key = $value;
      }
      if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' $kondisiValid $this->kondisiBarang")) == 0){
        $concat = $bk.".".$ck.".".$dk.".".$p;
        $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
      }else{
        if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $kondisiValid $this->kondisiBarang")) == 0){
          if($q != '0'){
            $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
          }
        }else{
            $concat = $f.".".$g.".".$h.".".$i.".".$j;
          if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' $kondisiValid $this->kondisiBarang")) == 0){
            if($j != '000'){
              $arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
            }
          }
        }
      }
    }


    $Kondisi= join(' and ',$arrKondisi);
    if(sizeof($arrKondisi) == 0){
      $Kondisi= '';
    }else{
      $Kondisi = " and ".$Kondisi;
    }

    $qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $this->kondisiBarang $Kondisi  order by urut";
    $aqry = mysql_query($qry);

    $grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
    $urusan = $grabUrusan['nm_skpd'];
    $grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
    $bidang = $grabBidang['nm_skpd'];
    $grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
    $skpd = $grabSkpd['nm_skpd'];
    $grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
    $unit = $grabUnit['nm_skpd'];
    $grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $subunit = $grabSubUnit['nm_skpd'];
    
    $getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
    //MULAI Halaman Laporan ------------------------------------------------------------------------------------------
    $css = $xls ? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
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
                  <td style='width: 10%;'>
                    <img src='".getImageReport()."' style='
                      width: 102.08px;
                      height: 84.59;
                      max-height: 84.59;
                      max-width: 102.08px;
                    '>
                  </td>
                </tr>
              </table>


        <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif;'>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>URUSAN</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$urusan."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>BIDANG</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$bidang."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>SKPD</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$skpd."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>UNIT</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$unit."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>SUB UNIT</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$subunit."</td>
          </tr>
        </table>

        <table style='width: 100%; border: none; margin-top: 1%;'>
          <tr>
            <td style='text-align: center; font-size: 14px;'><b>KARTU PERSEDIAAN</b></td>
          </tr>
        </table>

        <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif;'>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>Kode Barang</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$urusan."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>Nama Barang</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$urusan."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>Satuan</td>
            $pisah
            <td valign='top' style='font-size: 14px; width: 55%;'>".$bidang."</td>
          </tr>
        </table>
                ";
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='margin:2 0 0 0;width:100%;'>
                <thead>
                  <tr>
                    <th class='th01' style='width:20px;' >NO</th>
                    <th class='th01'>Tanggal</th>
                    <th class='th01'>Masuk</th>
                    <th class='th01'>Keluar</th>
                    <th class='th01'>Harga Satuan</th>
                    <th class='th01'>Stok</th>
                    <th class='th01'>Jumlah Harga</th>
                    <th class='th01'>Keterangan Transaksi</th>
                  </tr>
                  </thead>
    ";

    $no = 1;
    while($daqry = mysql_fetch_array($aqry)){
      foreach ($daqry as $key => $value) {
          $$key = $value;
      }
      $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
      if($q == '0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j !='000'){
        $programKegiatan = "";
        $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
        $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
        $namaBarang = $getNamaBarang['nm_barang'];
        $volBar = number_format($volume_barang,0,'.',',');
        $getKebutuhanMaksimum = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
        $kebutuhanMaksimum = $getKebutuhanMaksimum['jumlah'];
        $getJumlahOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and status_barang = '1' and (kondisi = '1' or kondisi ='2')"));
        $jumlahOptimal = $getJumlahOptimal['sum(jml_barang)'];
        $kebutuhanRiil = $getKebutuhanMaksimum['jumlah'] - $getJumlahOptimal['sum(jml_barang)'];
        $kebutuhanMaksimum = number_format($kebutuhanMaksimum,0,'.',',');
        $jumlahOptimal = number_format($jumlahOptimal,0,'.',',');
        $kebutuhanRill = number_format($kebutuhanRiil,0,'.',',');
      }

      if ($q != "0") {
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='14'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }else{
        $namaProgram = "<td align='left' class='GarisCetak' colspan='14'>".$programKegiatan."</td>";
      }


      if ($q == '0') {
        $naonkitu =
      "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaProgram."
                </tr>
      ";
      $no++;
      }elseif ($q != '0' && $f == '00') {
      $naonkitu =
      "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  ".$namaKegiatan."
                </tr>
      ";
      }else{
        $naonkitu =
      "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  <td align='left' class='GarisCetak' ></td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."<br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$volBar</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$kebutuhanMaksimum</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."<br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$jumlahOptimal</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$kebutuhanRill</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' >".$catatan."</td>
                </tr>
      ";
      }
      echo $naonkitu;

      
      $volBar = "";
      $jumlahBarangSebelumnya = "";
      $kebutuhanMaksimum = "";
      $jumlahOptimal = "";
      $kebutuhanRill = "";

      $satuan_barang = "";
      $catatan = "";
      $kodeBarang = "";
      $namaBarang = "";
      $programKegiatan = "";





    }
    echo        "</table>";

    $getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));
    if($xls){
      echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP  ".$getDataKuasaPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        </body>
      </html>";
    }else{
        if (sizeof($arrayTandaTangan1)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport1['posisi'];
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));
            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '1' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[titimangsa_surat].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $hmm[jabatan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$hmm['nama']."</u><br>
            NIP ".$hmm['nip']."


            </div>

            <div class='ukurantulisan' style ='float:left; text-align:center;'>
            Mengetahui<br>
            Kepala Administrasi System
            <br>
            <br>
            <br>
            <br>
            <br>
            <span>(.................................................)</span><br>
            <span style='float: left;'>NIP</span>


            </div>";

          }elseif (sizeof($arrayTandaTangan1)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport1['posisi']);
            $panjangArrayPosisi = sizeof($arrayPosisi);
            $kategoriKanan = $arrayPosisi[$panjangArrayPosisi-1];
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-3];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKanan' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $queryNama2 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKiri' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKanan' "));
            $queryKategori2 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKiri' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
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

          }elseif (sizeof($arrayTandaTangan1)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport1['posisi']);
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
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
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

            <!-- <h5 class='pag pag1' style='bottom: -10px; font-size: 9px;'>
              <span style='bottom: 0; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
            </h5>
            <div class='insert'></div> -->
      </body>
    </html>";
    }

  }
function kartuBarang($xls =FALSE){
    global $Main;
    $getJenisReport1 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL1' "));
    $getJenisUkuran = $getJenisReport1['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTangan1 = explode(';', $getJenisReport1['tanda_tangan']);

    $this->fileNameExcel = "USULAN RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG";
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



    $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
    $getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
    $getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul !='KOREKSI PENGGUNA' and jenis_form_modul !='KOREKSI PENGELOLA' "));
    $lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
    $getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
    $lastNomorUrut = $getLastTahap['no_urut'];
    $getMinJenisForm = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran'"));
    if($getMinJenisForm['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE){
        $kondisiValid = " and status_validasi = '1'";
    }

    $arrKondisi = array();

    $grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and p !='0' and q='0'");
    while($rows = mysql_fetch_array($grabProgram)){
      foreach ($rows as $key => $value) {
          $$key = $value;
      }
      if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' $kondisiValid $this->kondisiBarang")) == 0){
        $concat = $bk.".".$ck.".".$dk.".".$p;
        $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
      }else{
        if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $kondisiValid $this->kondisiBarang")) == 0){
          if($q != '0'){
            $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
          }
        }else{
            $concat = $f.".".$g.".".$h.".".$i.".".$j;
          if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' $kondisiValid $this->kondisiBarang")) == 0){
            if($j != '000'){
              $arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
            }
          }
        }
      }
    }


    $Kondisi= join(' and ',$arrKondisi);
    if(sizeof($arrKondisi) == 0){
      $Kondisi= '';
    }else{
      $Kondisi = " and ".$Kondisi;
    }

    $qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $this->kondisiBarang $Kondisi  order by urut";
    $aqry = mysql_query($qry);

    $grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
    $urusan = $grabUrusan['nm_skpd'];
    $grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
    $bidang = $grabBidang['nm_skpd'];
    $grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
    $skpd = $grabSkpd['nm_skpd'];
    $grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
    $unit = $grabUnit['nm_skpd'];
    $grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $subunit = $grabSubUnit['nm_skpd'];
    
    $getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
    //MULAI Halaman Laporan ------------------------------------------------------------------------------------------
    $css = $xls ? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
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
                  <td style='width: 10%;'>
                    <img src='".getImageReport()."' style='height: 10%;'>
                  </td>
                </tr>
              </table>


        <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif;'>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>URUSAN</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$urusan."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>BIDANG</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$bidang."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>SKPD</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$skpd."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>UNIT</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$unit."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>SUB UNIT</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$subunit."</td>
          </tr>
        </table>

        <table style='width: 100%; border: none; margin-top: 1%;'>
          <tr>
            <td style='text-align: center; font-size: 14px;'><b>KARTU BARANG</b></td>
          </tr>
        </table>

        <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif;'>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>Nama Barang</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$urusan."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>Satuan</td>
            $pisah
            <td valign='top' style='font-size: 14px; width: 55%;'>".$bidang."</td>

            <td width='10%' valign='top' style='font-size: 14px;'>Spesifikasi</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$bidang."</td>
          </tr>
        </table>
                ";
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='margin:2 0 0 0;width:100%;'>
                <thead>
                  <tr>
                    <th class='th01' style='width:20px;' >NO</th>
                    <th class='th01'>Tanggal</th>
                    <th class='th01'>Masuk</th>
                    <th class='th01'>Keluar</th>
                    <th class='th01'>Sisa</th>
                    <th class='th01'>Keterangan Transaksi</th>
                  </tr>
                  </thead>
    ";

    $no = 1;
    while($daqry = mysql_fetch_array($aqry)){
      foreach ($daqry as $key => $value) {
          $$key = $value;
      }
      $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
      if($q == '0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j !='000'){
        $programKegiatan = "";
        $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
        $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
        $namaBarang = $getNamaBarang['nm_barang'];
        $volBar = number_format($volume_barang,0,'.',',');
        $getKebutuhanMaksimum = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
        $kebutuhanMaksimum = $getKebutuhanMaksimum['jumlah'];
        $getJumlahOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and status_barang = '1' and (kondisi = '1' or kondisi ='2')"));
        $jumlahOptimal = $getJumlahOptimal['sum(jml_barang)'];
        $kebutuhanRiil = $getKebutuhanMaksimum['jumlah'] - $getJumlahOptimal['sum(jml_barang)'];
        $kebutuhanMaksimum = number_format($kebutuhanMaksimum,0,'.',',');
        $jumlahOptimal = number_format($jumlahOptimal,0,'.',',');
        $kebutuhanRill = number_format($kebutuhanRiil,0,'.',',');
      }

      if ($q != "0") {
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='14'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }else{
        $namaProgram = "<td align='left' class='GarisCetak' colspan='14'>".$programKegiatan."</td>";
      }


      if ($q == '0') {
        $naonkitu =
      "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaProgram."
                </tr>
      ";
      $no++;
      }elseif ($q != '0' && $f == '00') {
      $naonkitu =
      "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  ".$namaKegiatan."
                </tr>
      ";
      }else{
        $naonkitu =
      "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  <td align='left' class='GarisCetak' ></td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."<br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$volBar</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$kebutuhanMaksimum</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."<br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$jumlahOptimal</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$kebutuhanRill</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' >".$catatan."</td>
                </tr>
      ";
      }
      echo $naonkitu;

      
      $volBar = "";
      $jumlahBarangSebelumnya = "";
      $kebutuhanMaksimum = "";
      $jumlahOptimal = "";
      $kebutuhanRill = "";

      $satuan_barang = "";
      $catatan = "";
      $kodeBarang = "";
      $namaBarang = "";
      $programKegiatan = "";





    }
    echo        "</table>";

    $getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));
    if($xls){
      echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP  ".$getDataKuasaPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        </body>
      </html>";
    }else{
        if (sizeof($arrayTandaTangan1)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport1['posisi'];
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));
            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '1' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[titimangsa_surat].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $hmm[jabatan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$hmm['nama']."</u><br>
            NIP ".$hmm['nip']."


            </div>

            <div class='ukurantulisan' style ='float:left; text-align:center;'>
            <br>
            ATASAN LANGSUNG
            <br>
            <br>
            <br>
            <br>
            <br>
            <span>(.................................................)</span><br>
            <span style='float: left;'>NIP</span>


            </div>";

          }elseif (sizeof($arrayTandaTangan1)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport1['posisi']);
            $panjangArrayPosisi = sizeof($arrayPosisi);
            $kategoriKanan = $arrayPosisi[$panjangArrayPosisi-1];
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-3];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKanan' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $queryNama2 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKiri' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKanan' "));
            $queryKategori2 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKiri' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
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

          }elseif (sizeof($arrayTandaTangan1)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport1['posisi']);
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
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
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

            <!-- <h5 class='pag pag1' style='bottom: -10px; font-size: 9px;'>
              <span style='bottom: 0; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
            </h5>
            <div class='insert'></div> -->
      </body>
    </html>";
    }

  }
function kartuPersediaanBarang($xls =FALSE){
    global $Main;
    $getJenisReport1 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL1' "));
    $getJenisUkuran = $getJenisReport1['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTangan1 = explode(';', $getJenisReport1['tanda_tangan']);

    $this->fileNameExcel = "USULAN RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG";
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



    $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
    $getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
    $getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul !='KOREKSI PENGGUNA' and jenis_form_modul !='KOREKSI PENGELOLA' "));
    $lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
    $getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
    $lastNomorUrut = $getLastTahap['no_urut'];
    $getMinJenisForm = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran'"));
    if($getMinJenisForm['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE){
        $kondisiValid = " and status_validasi = '1'";
    }

    $arrKondisi = array();

    $grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and p !='0' and q='0'");
    while($rows = mysql_fetch_array($grabProgram)){
      foreach ($rows as $key => $value) {
          $$key = $value;
      }
      if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' $kondisiValid $this->kondisiBarang")) == 0){
        $concat = $bk.".".$ck.".".$dk.".".$p;
        $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
      }else{
        if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $kondisiValid $this->kondisiBarang")) == 0){
          if($q != '0'){
            $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
          }
        }else{
            $concat = $f.".".$g.".".$h.".".$i.".".$j;
          if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' $kondisiValid $this->kondisiBarang")) == 0){
            if($j != '000'){
              $arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
            }
          }
        }
      }
    }


    $Kondisi= join(' and ',$arrKondisi);
    if(sizeof($arrKondisi) == 0){
      $Kondisi= '';
    }else{
      $Kondisi = " and ".$Kondisi;
    }

    $qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $this->kondisiBarang $Kondisi  order by urut";
    $aqry = mysql_query($qry);

    $grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
    $urusan = $grabUrusan['nm_skpd'];
    $grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
    $bidang = $grabBidang['nm_skpd'];
    $grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
    $skpd = $grabSkpd['nm_skpd'];
    $grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
    $unit = $grabUnit['nm_skpd'];
    $grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $subunit = $grabSubUnit['nm_skpd'];
    
    $getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
    //MULAI Halaman Laporan ------------------------------------------------------------------------------------------
    $css = $xls ? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
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
                  <td style='width: 10%;'>
                    <img src='".getImageReport()."' style='height: 10%;'>
                  </td>
                </tr>
              </table>


        <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif;'>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>URUSAN</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$urusan."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>BIDANG</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$bidang."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>SKPD</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$skpd."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>UNIT</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$unit."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>SUB UNIT</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$subunit."</td>
          </tr>
        </table>

        <table style='width: 100%; border: none; margin-top: 1%;'>
          <tr>
            <td style='text-align: center; font-size: 14px;'><b>KARTU PERSEDIAAN BARANG</b></td>
          </tr>
        </table>

        <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif;'>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>Gudang</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$urusan."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>Nama Barang</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$urusan."</td>

            <td width='10%' valign='top' style='font-size: 14px;'>Kartu No.</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$urusan."</td>
          </tr>
          <tr>
            <td width='10%' valign='top' style='font-size: 14px;'>Satuan</td>
            $pisah
            <td valign='top' style='font-size: 14px; width: 55%;'>".$bidang."</td>

            <td width='10%' valign='top' style='font-size: 14px;'>Spesifikasi</td>
            $pisah
            <td valign='top' style='font-size: 14px;'>".$bidang."</td>
          </tr>
        </table>
                ";
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='margin:2 0 0 0;width:100%;'>
                <thead>
                  <tr>
                    <th class='th02' rowspan='2' style='width:20px;' >NO</th>
                    <th class='th02' rowspan='2'>Tanggal</th>
                    <th class='th02' rowspan='2'>No./Tgl Surat Dasar<br>Penerimaan/Pengeluaran</th>
                    <th class='th02' rowspan='2'>Uraian</th>
                    <th class='th02' colspan='3'>Barang-barang</th>
                    <th class='th02' rowspan='2'>Harga Satuan (Rp)</th>
                    <th class='th02' colspan='3'>Jumlah Harga Barang yg Diterima/yang Dikeluarkan/Sisa</th>
                    <th class='th02' rowspan='2'>Keterangan</th>
                  </tr>
                  <tr>
                    <th class='th02'>Masuk</th>
                    <th class='th02'>Keluar</th>
                    <th class='th02'>Sisa</th>
                    <th class='th02'>Bertambah (Rp)</th>
                    <th class='th02'>Berkurang (Rp)</th>
                    <th class='th02'>Sisa (Rp)</th>
                  </tr>
                  <tr>
                    <th class='th01' align='center'>1</th>
                    <th class='th01' align='center'>2</th>
                    <th class='th01' align='center'>3</th>
                    <th class='th01' align='center'>4</th>
                    <th class='th01' align='center'>5</th>
                    <th class='th01' align='center'>6</th>
                    <th class='th01' align='center'>7</th>
                    <th class='th01' align='center'>8</th>
                    <th class='th01' align='center'>9</th>
                    <th class='th01' align='center'>10</th>
                    <th class='th01' align='center'>11</th>
                    <th class='th01' align='center'>12</th>
                  </tr>
                  </thead>
    ";

    $no = 1;
    while($daqry = mysql_fetch_array($aqry)){
      foreach ($daqry as $key => $value) {
          $$key = $value;
      }
      $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
      if($q == '0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j !='000'){
        $programKegiatan = "";
        $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
        $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
        $namaBarang = $getNamaBarang['nm_barang'];
        $volBar = number_format($volume_barang,0,'.',',');
        $getKebutuhanMaksimum = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
        $kebutuhanMaksimum = $getKebutuhanMaksimum['jumlah'];
        $getJumlahOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and status_barang = '1' and (kondisi = '1' or kondisi ='2')"));
        $jumlahOptimal = $getJumlahOptimal['sum(jml_barang)'];
        $kebutuhanRiil = $getKebutuhanMaksimum['jumlah'] - $getJumlahOptimal['sum(jml_barang)'];
        $kebutuhanMaksimum = number_format($kebutuhanMaksimum,0,'.',',');
        $jumlahOptimal = number_format($jumlahOptimal,0,'.',',');
        $kebutuhanRill = number_format($kebutuhanRiil,0,'.',',');
      }

      if ($q != "0") {
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='14'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }else{
        $namaProgram = "<td align='left' class='GarisCetak' colspan='14'>".$programKegiatan."</td>";
      }


      if ($q == '0') {
        $naonkitu =
      "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaProgram."
                </tr>
      ";
      $no++;
      }elseif ($q != '0' && $f == '00') {
      $naonkitu =
      "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  ".$namaKegiatan."
                </tr>
      ";
      }else{
        $naonkitu =
      "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  <td align='left' class='GarisCetak' ></td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."<br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$volBar</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$kebutuhanMaksimum</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."<br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$jumlahOptimal</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$kebutuhanRill</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' >".$catatan."</td>
                </tr>
      ";
      }
      echo $naonkitu;

      
      $volBar = "";
      $jumlahBarangSebelumnya = "";
      $kebutuhanMaksimum = "";
      $jumlahOptimal = "";
      $kebutuhanRill = "";

      $satuan_barang = "";
      $catatan = "";
      $kodeBarang = "";
      $namaBarang = "";
      $programKegiatan = "";





    }
    echo        "</table>";

    $getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));
    if($xls){
      echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP  ".$getDataKuasaPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        </body>
      </html>";
    }else{
        if (sizeof($arrayTandaTangan1)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport1['posisi'];
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));
            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '1' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[titimangsa_surat].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $hmm[jabatan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$hmm['nama']."</u><br>
            NIP ".$hmm['nip']."


            </div>

            <div class='ukurantulisan' style ='float:left; text-align:center;'>
            <br>
            ATASAN LANGSUNG
            <br>
            <br>
            <br>
            <br>
            <br>
            <span>(.................................................)</span><br>
            <span style='float: left;'>NIP</span>


            </div>";

          }elseif (sizeof($arrayTandaTangan1)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport1['posisi']);
            $panjangArrayPosisi = sizeof($arrayPosisi);
            $kategoriKanan = $arrayPosisi[$panjangArrayPosisi-1];
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-3];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKanan' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $queryNama2 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKiri' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKanan' "));
            $queryKategori2 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKiri' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
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

          }elseif (sizeof($arrayTandaTangan1)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport1['posisi']);
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
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
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

            <!-- <h5 class='pag pag1' style='bottom: -10px; font-size: 9px;'>
              <span style='bottom: 0; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
            </h5>
            <div class='insert'></div> -->
      </body>
    </html>";
    }

  }
function Laporan($xls =FALSE){
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



    $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
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
    $css = $xls ? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
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
                    <img src='".getImageReport()."' style='height: 10%;'>
                  </td>
                  <td style='text-align: center;'>
                    <span style='font-size:18px;font-weight:bold;text-transform: uppercase; '>
                      DAFTAR PENGELUARAN PERSEDIAAN BARANG<br>
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
                    <th class='th01' style='width: 6%;'>TGL</th>
                    <th class='th01'>NOMOR</th>
                    <th class='th01' style='width: 5%;'>UNTUK KEPERLUAN</th>
                    <th class='th01'>NAMA BARANG</th>
                    <th class='th01' style='width: 8%;'>MERK/TYPE/SPEK</th>
                    <th class='th01' style='width: 7%;'>JUMLAH</th>
                  </tr>
                </thead>
    ";
    $arrayPenggunaBarang = array();
    $arrayExcept = array();
    $no = 1;

    $queryPengeluaran = mysql_query("SELECT * from pengeluaran where c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' and status_posting = 1 ");

    while ($dataPengeluaran = mysql_fetch_array($queryPengeluaran)) {

      $queryDetailPengeluaran = mysql_fetch_array(mysql_query("SELECT * from detail_pengeluaran where id_pengeluaran = ".$dataPengeluaran[id]." "));

      $firstId = $queryDetailPengeluaran[id];

      if ($queryDetailPengeluaran[jumlah] == "") {
        $jumlah = '0';
      }else{
        $jumlah = $queryDetailPengeluaran[jumlah];
      }

      $queryRefBarang = mysql_fetch_array(mysql_query("SELECT * from ref_barang where f = ".$queryDetailPengeluaran[f]." and g = ".$queryDetailPengeluaran[g]." and h = ".$queryDetailPengeluaran[h]." and i = ".$queryDetailPengeluaran[i]." and j = ".$queryDetailPengeluaran[j]." and j1 = ".$queryDetailPengeluaran[j1]." "));

      echo "
        <tr>
          <td align='center' class='GarisCetak'>".$no."</td>
          <td class='GarisCetak'>".$dataPengeluaran[tanggal]."</td>
          <td class='GarisCetak'>".$dataPengeluaran[nomor]."</td>
          <td class='GarisCetak'>".$dataPengeluaran[keperluan]."</td>
          <td class='GarisCetak'>".$queryRefBarang[nm_barang]."</td>
          <td class='GarisCetak'>".$queryDetailPengeluaran[merk]."</td>
          <td align='right' class='GarisCetak'>".number_format($jumlah,2,',','.')."</td>
        </tr>
      ";

      $queryDetailPengeluaran2 = mysql_query("SELECT * from detail_pengeluaran where id_pengeluaran = ".$dataPengeluaran[id]." and id != ".$firstId." ");
      while ($dataPengeluaran2 = mysql_fetch_array($queryDetailPengeluaran2)) {

        $queryRefBarang2 = mysql_fetch_array(mysql_query("SELECT * from ref_barang where f = ".$dataPengeluaran2[f]." and g = ".$dataPengeluaran2[g]." and h = ".$dataPengeluaran2[h]." and i = ".$dataPengeluaran2[i]." and j = ".$dataPengeluaran2[j]." and j1 = ".$dataPengeluaran2[j1]." "));

        if ($dataPengeluaran2[jumlah] == "") {
          $jumlah2 = '0';
        }else{
          $jumlah2 = $dataPengeluaran2[jumlah];
        }

        echo "
        <tr>
          <td align='center' class='GarisCetak' colspan='4'></td>
          <td class='GarisCetak'>".$queryRefBarang2[nm_barang]."</td>
          <td class='GarisCetak'>".$dataPengeluaran2[merk]."</td>
          <td align='right' class='GarisCetak'>".number_format($jumlah2,2,',','.')."</td>
        </tr>
      ";
      }
      $no++;
    }

    echo        "</table>";

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
            NIP $this->nipPengelola
            </td>
            </tr>





            </table>
            </div>
        </body>
      </html>";
    }else{
      if (sizeof($arrayTandaTangan7)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit]; $nomor = $_GET[nomor];
            $arrayPosisi = $getJenisReport7['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '3' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '23' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '3' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));
            $queryRefPenyerahPengeluaran = mysql_fetch_array(mysql_query("SELECT * from ref_penyerah_pengeluaran where id = '$nomor' "));

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
// function tanggal_indo($tanggal, $cetak_hari = false){
//   $hari = array ( 1 =>    'Senin',
//         'Selasa',
//         'Rabu',
//         'Kamis',
//         'Jumat',
//         'Sabtu',
//         'Minggu'
//       );
      
//   $bulan = array (1 =>   'Januari',
//         'Februari',
//         'Maret',
//         'April',
//         'Mei',
//         'Juni',
//         'Juli',
//         'Agustus',
//         'September',
//         'Oktober',
//         'November',
//         'Desember'
//       );
//   $split    = explode('-', $tanggal);
//   $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
//   $tgl_indos = date('Y-m-d');
  
//   if ($cetak_hari) {
//     $num = date('N', strtotime($tanggal));
//     return $hari[$num] . ', ' . $tgl_indo;
//   }
//   return $tgl_indos;
// }
function Laporan5($xls =FALSE){
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



    $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit]; $idna = $_GET[idna];
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
    $css = $xls ? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
    $queryNomorna = mysql_fetch_array(mysql_query("SELECT * from pengeluaran where id = '$idna' "));
    $tglHari = date('d');
    $tglTahun = date('Y');
    $dataTanggalExplode = tanggal_indo(date('d-m-Y'));
    $getBulan = explode(" ", $dataTanggalExplode);
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
          <table class=\"rangkacetak\" style='width: 21.5cm; height: 33cm; font-family: sans-serif;'>
            <tr>
              <td valign=\"top\"> <div style='text-align:center;'>
              <table style='width: 100%; border: none;'>
                <tr>
                  <td style='width: 10%; text-align: center;'>
                    <img src='".getImageReport()."' style='height: 10%;'>
                  </td>
                  <td style='text-align: center;'>
                    <span style='font-size:18px;font-weight:bold;text-transform: uppercase; '>
                      Berita Acara<br>
                      Pengeluaran Barang Persediaan<br>
                      Nomor : ".$queryNomorna[nomor]."<br>
                    </span>
                  </td>
                </tr>
              </table>

              <table style='width: 100%; border: none; margin-top: 5%;'>
                <tr>
                  <td style='font-size: 16px;'>Pada hari ini ".terbilang($tglHari, $style=3)." ".$getBulan[1]." ".terbilang($tglTahun, $style=3)." telah dikeluarkan barang persediaan sebagai berikut :</td>
                </tr>
              </table>";
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='width:100%;'>
                <thead>
                  <tr>
                    <th class='th01' style='width:20px;' >NO</th>
                    <th class='th01'>NAMA BARANG</th>
                    <th class='th01' style='width: 8%;'>MERK/TYPE/SPEK</th>
                    <th class='th01' style='width: 6%;'>SATUAN</th>
                    <th class='th01' style='width: 12%;'>JUMLAH</th>
                  </tr>
                </thead>
    ";
    $arrayPenggunaBarang = array();
    $arrayExcept = array();
    $no = 1;
    

    $queryPengeluaran = mysql_query("SELECT * from pengeluaran where id = '$idna' ");

    while ($dataPengeluaran = mysql_fetch_array($queryPengeluaran)) {

      $queryDetailPengeluaran = mysql_fetch_array(mysql_query("SELECT * from detail_pengeluaran where id_pengeluaran = ".$dataPengeluaran[id]." "));

      $total = mysql_fetch_array(mysql_query("SELECT SUM(jumlah) as total from detail_pengeluaran where id_pengeluaran = ".$dataPengeluaran[id]." "));

      $firstId = $queryDetailPengeluaran[id];

      if ($queryDetailPengeluaran[jumlah] == "") {
        $jumlah = '0';
      }else{
        $jumlah = $queryDetailPengeluaran[jumlah];
      }

      $queryRefBarang = mysql_fetch_array(mysql_query("SELECT * from ref_barang where f = ".$queryDetailPengeluaran[f]." and g = ".$queryDetailPengeluaran[g]." and h = ".$queryDetailPengeluaran[h]." and i = ".$queryDetailPengeluaran[i]." and j = ".$queryDetailPengeluaran[j]." and j1 = ".$queryDetailPengeluaran[j1]." "));

      echo "
        <tr>
          <td align='center' class='GarisCetak'>".$no."</td>
          <td class='GarisCetak'>".$queryRefBarang[nm_barang]."</td>
          <td class='GarisCetak'>".$queryDetailPengeluaran[merk]."</td>
          <td align='right' class='GarisCetak'>".$queryRefBarang[satuan]."</td>
          <td align='right' class='GarisCetak'>".number_format($jumlah,2,',','.')."</td>
        </tr>
      ";

      $queryDetailPengeluaran2 = mysql_query("SELECT * from detail_pengeluaran where id_pengeluaran = ".$dataPengeluaran[id]." and id != ".$firstId." ");
      while ($dataPengeluaran2 = mysql_fetch_array($queryDetailPengeluaran2)) {

        $queryRefBarang2 = mysql_fetch_array(mysql_query("SELECT * from ref_barang where f = ".$dataPengeluaran2[f]." and g = ".$dataPengeluaran2[g]." and h = ".$dataPengeluaran2[h]." and i = ".$dataPengeluaran2[i]." and j = ".$dataPengeluaran2[j]." and j1 = ".$dataPengeluaran2[j1]." "));

        if ($dataPengeluaran2[jumlah] == "") {
          $jumlah2 = '0';
        }else{
          $jumlah2 = $dataPengeluaran2[jumlah];
        }

        echo "
        <tr>
          <td align='center' class='GarisCetak' colspan='1'></td>
          <td class='GarisCetak'>".$queryRefBarang2[nm_barang]."</td>
          <td class='GarisCetak'>".$dataPengeluaran2[merk]."</td>
          <td align='right' class='GarisCetak'>".$queryRefBarang2[satuan]."</td>
          <td align='right' class='GarisCetak'>".number_format($jumlah2,2,',','.')."</td>
        </tr>
      ";
      }
      echo "
        <tr>
          <td class='GarisCetak' colspan='4' align='right'><b>TOTAL</b></td>
          <td class='GarisCetak' align='right'><b>".number_format($total[total],2,',','.')."</b></td>
        </tr>
      ";
      $no++;
    }

    echo        "</table>";

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
            NIP $this->nipPengelola
            </td>
            </tr>





            </table>
            </div>
        </body>
      </html>";
    }else{
      if (sizeof($arrayTandaTangan7)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit]; $nomor = $_GET[nomor];
            $arrayPosisi = $getJenisReport7['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '3' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '23' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '3' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));
            $queryRefPenyerahPengeluaran = mysql_fetch_array(mysql_query("SELECT * from ref_penyerah_pengeluaran where id = '$nomor' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[titimangsa_surat].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            Yang Menyerahkan<br>
            $queryRefPenyerahPengeluaran[jabatan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryRefPenyerahPengeluaran['nama']."</u><br>
            NIP ".$queryRefPenyerahPengeluaran['nip']."


            </div>

            <div class='ukurantulisan' style ='float:left; text-align:center;'>
            <br>
            Yang Menerima
            <br>
            <br>
            <br>
            <br>
            <br>
            <span>(.................................................)</span><br>
            <span style='float: left;'>NIP</span>


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
function Laporan2($xls =FALSE){
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
      $getAllParent = mysql_query("select * from tabel_PENGELUARAN where id_tahap ='$this->idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
      while($rows = mysql_fetch_array($getAllParent)){
        foreach ($rows as $key => $value) {
         $$key = $value;
        }
        $cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where o1 = '$o1' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
        if($cekPekerjaan == 0){
          $arrKondisi[] = "o1 !='$o1'";
        }else{
          $arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id' ";
          $getAllRekening = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$this->idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
          while($row2s = mysql_fetch_array($getAllRekening)){
            foreach ($row2s as $key => $value) {
             $$key = $value;
            }
            $cekRekening = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
            if($cekRekening == 0){
              $concat = $k.".".$l.".".$m.".".$n.".".$o;
              $arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
            }else{
              $arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id'  ";


            }
          }
        }
      }


        $grabNonMapingRekening= mysql_query("select * from tabel_PENGELUARAN where id_tahap ='$this->idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
        while($got = mysql_fetch_array($grabNonMapingRekening)){
          if(mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
            $arrKondisi[] = "id_tahap = '$this->idTahap' or id ='".$got['id']."'";
          }

        }
        $grabNonHostedRekening= mysql_query("select * from tabel_PENGELUARAN where id_tahap ='$this->idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
        while($got = mysql_fetch_array($grabNonHostedRekening)){
          if(mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
            $arrKondisi[] = "id_tahap = '$this->idTahap' or id ='".$got['id']."'";
          }

        }


      $arrKondisi[] = "id_tahap = '$this->idTahap' ";

    }elseif($this->jenisForm == 'KOREKSI'){
      $nomorUrutSebelumnya = $this->nomorUrut;
      $getRApbd = mysql_fetch_array(mysql_query("select * from tabel_PENGELUARAN where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
      if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
        $nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;
      }
      $getLastTahap = mysql_fetch_array(mysql_query("select * from tabel_PENGELUARAN where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
      $blackList = "";
      if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
        $getAllChild = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");
        while($black = mysql_fetch_array($getAllChild)){
          $blackList .= " and id !='".$black['id']."'";
        }
      }

      $getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
      $idTahap = $getIDTahap['id_tahap'];
      $getAllParent = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
      while($rows = mysql_fetch_array($getAllParent)){
        foreach ($rows as $key => $value) {
         $$key = $value;
        }
        $cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
        if($cekPekerjaan == 0){
          $arrKondisi[] = "o1 !='$o1'";
        }else{
          $arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id' ";
          $getAllRekening = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
          while($row2s = mysql_fetch_array($getAllRekening)){
            foreach ($row2s as $key => $value) {
             $$key = $value;
            }
            $cekRekening = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
            if($cekRekening == 0){
              $concat = $k.".".$l.".".$m.".".$n.".".$o;
              $arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
            }else{
              $arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'  ";
              $getAllProgram = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
              while($row3s = mysql_fetch_array($getAllProgram)){
                foreach ($row3s as $key => $value) {
                 $$key = $value;
                }
                $cekProgram = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
                if($cekProgram == 0){
                  $concat = $bk.".".$ck.".".$p;
                  $arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
                }else{
                  $arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'   ";
                  $getAllKegiatan = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
                  while($row4s = mysql_fetch_array($getAllKegiatan)){
                    foreach ($row4s as $key => $value) {
                     $$key = $value;
                    }
                    $cekKegiatan = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
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


        $grabNonMapingRekening= mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
        while($got = mysql_fetch_array($grabNonMapingRekening)){
          if(mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
            $arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
          }

        }

        $grabNonHostedRekening= mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
        while($got = mysql_fetch_array($grabNonHostedRekening)){
          if(mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
            $arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
          }

        }





      $arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";


    }else{
      if($this->jenisFormTerakhir == "KOREKSI"){
        $nomorUrutSebelumnya = $this->urutTerakhir;
        $getRApbd = mysql_fetch_array(mysql_query("select * from tabel_PENGELUARAN where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
        if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
          $nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;
        }
        $getLastTahap = mysql_fetch_array(mysql_query("select * from tabel_PENGELUARAN where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
        $blackList = "";
        if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
          $getAllChild = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");
          while($black = mysql_fetch_array($getAllChild)){
            $blackList .= " and id !='".$black['id']."'";
          }
        }

        $getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
        $idTahap = $getIDTahap['id_tahap'];
        $getAllParent = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
        while($rows = mysql_fetch_array($getAllParent)){
          foreach ($rows as $key => $value) {
           $$key = $value;
          }
          $cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
          if($cekPekerjaan == 0){
            $arrKondisi[] = "o1 !='$o1'";
          }else{
            $arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id' ";
            $getAllRekening = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
            while($row2s = mysql_fetch_array($getAllRekening)){
              foreach ($row2s as $key => $value) {
               $$key = $value;
              }
              $cekRekening = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
              if($cekRekening == 0){
                $concat = $k.".".$l.".".$m.".".$n.".".$o;
                $arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
              }else{
                $arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'  ";
                $getAllProgram = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
                while($row3s = mysql_fetch_array($getAllProgram)){
                  foreach ($row3s as $key => $value) {
                   $$key = $value;
                  }
                  $cekProgram = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
                  if($cekProgram == 0){
                    $concat = $bk.".".$ck.".".$p;
                    $arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
                  }else{
                    $arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'   ";
                    $getAllKegiatan = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
                    while($row4s = mysql_fetch_array($getAllKegiatan)){
                      foreach ($row4s as $key => $value) {
                       $$key = $value;
                      }
                      $cekKegiatan = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
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


          $grabNonMapingRekening= mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
          while($got = mysql_fetch_array($grabNonMapingRekening)){
            if(mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
              $arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
            }

          }

          $grabNonHostedRekening= mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
          while($got = mysql_fetch_array($grabNonHostedRekening)){
            if(mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
              $arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
            }

          }





        $arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
      }elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
        $getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));
        $idTahap = $getIDTahap['id_tahap'];
        $getAllParent = mysql_query("select * from tabel_PENGELUARAN where id_tahap ='$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
        while($rows = mysql_fetch_array($getAllParent)){
          foreach ($rows as $key => $value) {
           $$key = $value;
          }
          $cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where o1 = '$o1' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
          if($cekPekerjaan == 0){
            $arrKondisi[] = "o1 !='$o1'";
          }else{
            $arrKondisi[] = " id_tahap='$idTahap'  or id = '$id' ";
            $getAllRekening = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
            while($row2s = mysql_fetch_array($getAllRekening)){
              foreach ($row2s as $key => $value) {
               $$key = $value;
              }
              $cekRekening = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
              if($cekRekening == 0){
                $concat = $k.".".$l.".".$m.".".$n.".".$o;
                $arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
              }else{
                $arrKondisi[] = " id_tahap='$idTahap'  or id = '$id'  ";
                $getAllProgram = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
                while($row3s = mysql_fetch_array($getAllProgram)){
                  foreach ($row3s as $key => $value) {
                   $$key = $value;
                  }
                  $cekProgram = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where bk ='$bk' and ck='$ck' and p='$p' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
                  if($cekProgram == 0){
                    $concat = $bk.".".$ck.".".$p;
                    $arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
                  }else{
                    $arrKondisi[] = " id_tahap='$idTahap'  or id = '$id'   ";
                    $getAllKegiatan = mysql_query("select * from tabel_PENGELUARAN where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
                    while($row4s = mysql_fetch_array($getAllKegiatan)){
                      foreach ($row4s as $key => $value) {
                       $$key = $value;
                      }
                      $cekKegiatan = mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
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


        $grabNonMapingRekening= mysql_query("select * from tabel_PENGELUARAN where id_tahap ='$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
        while($got = mysql_fetch_array($grabNonMapingRekening)){
          if(mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
            $arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
          }

        }

        $grabNonHostedRekening= mysql_query("select * from tabel_PENGELUARAN where id_tahap ='$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
        while($got = mysql_fetch_array($grabNonHostedRekening)){
          if(mysql_num_rows(mysql_query("select * from tabel_PENGELUARAN where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
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
    $qry ="select * from tabel_PENGELUARAN where $Kondisi ";
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
    $css = $xls ? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
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
    $getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_PENGELUARAN where $Kondisi  "));
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
        $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_PENGELUARAN where  o1 ='$o1' $kondisiSKPD $kondisiFilter  "));
        $jumlah_harga = "<span style='font-weight:bold;'>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.') . "</span>";


      }elseif($c1 == '0'){
        $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
        $jarak = "0px";
        if($o1 !='0' && $o1 !='')$jarak = "10px";
        $uraian = "<span style='font-weight:bold;margin-left:$jarak;'>".$getNamaRekening['nm_rekening']."</b>";
        $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_PENGELUARAN where  k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'  $kondisiSKPD $kondisiFilter"));
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
    echo        "<tr valign='top'>
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
            NIP ".$getDataPenggunaBarang['nip']."


            </div>
      </body>
    </html>";
  }
  function Laporan3($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 500;
   $this->form_height = 100;
   $this->form_caption = 'LAPORAN RKBMD PENGADAAN';

   $c1 = $dt['pengeluaranPersediaanSKPD2fmURUSAN'];
   $c = $dt['pengeluaranPersediaanSKPD2fmSKPD'];
   $d = $dt['pengeluaranPersediaanSKPD2fmUNIT'];
   $e = $dt['pengeluaranPersediaanSKPD2fmSUBUNIT'];
   $e1 = $dt['pengeluaranPersediaanSKPD2fmSEKSI'];

    $arrayJenisLaporan = array(
                 array('Laporan', 'DAFTAR PENGELUARAN PERSEDIAAN BARANG'),
                 // array('kartuBarang', 'KARTU BARANG'),
                 // array('kartuPersediaanBarang', 'KARTU PERSEDIAAN BARANG'),
                 // array('kartuPersediaan', 'KARTU PERSEDIAAN'),

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
                  'value'=>cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = 23 and c1 = '$c1' and c = '$c' and d = '$d' ",'onchange=rka.refreshList(true);','-- TTD --'),

                ),

      );
    //tombol
    $this->form_menubawah =
      "
      <input type='button' value='TTD' onclick ='".$this->Prefix.".BaruTTD()' title='TTD' >
      <input type='button' value='View' onclick ='".$this->Prefix.".Report()' title='Simpan' >   ".
      "<input type='button' value='Batal' onclick ='pengeluaranPersediaan.Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

  function Laporan4($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 500;
   $this->form_height = 100;
   $this->form_caption = 'LAPORAN RKBMD PENGADAAN';

   $c1 = $dt['pengeluaranPersediaanSKPD2fmURUSAN'];
   $c = $dt['pengeluaranPersediaanSKPD2fmSKPD'];
   $d = $dt['pengeluaranPersediaanSKPD2fmUNIT'];
   $e = $dt['pengeluaranPersediaanSKPD2fmSUBUNIT'];
   $e1 = $dt['pengeluaranPersediaanSKPD2fmSEKSI'];

    $arrayJenisLaporan = array(
                 array('Laporan5', 'PENGELUARAN BARANG PERSEDIAAN'),

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

      );
    //tombol
    $this->form_menubawah =
      "
      <input type='button' value='View' onclick ='".$this->Prefix.".Report2()' title='Simpan' >   ".
      "<input type='button' value='Batal' onclick ='pengeluaranPersediaan.Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

function formAlokasi($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

  function formAlokasiTriwulan($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }


    function newJob($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }
  function editJob($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

  function Gruping($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 500;
   $this->form_height = 180;
   $this->form_caption = 'DETAIL VOLUME';
   $jumlahHargaForm = $dt;
   $username =$_COOKIE['coID'];
  //  $getRincianVolume = mysql_fetch_array(mysql_query("select * from tabel_PENGELUARAN where id ='$dt'"));
  //  foreach ($getRincianVolume as $key => $value) {
  //        $$key = $value;
  //  }

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
      array(    'label' => '',
            'labelWidth' => 1,
            'pemisah' => ' ',
            'value'=>" JUMLAH 1 &nbsp<input type='text' id='jumlah1' value='$volume1Temp' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder='JUMLAH'> &nbsp SATUAN 1   &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' name ='satuan1' id ='satuan1' value='$satuan1Temp'>",
             ),
      array(    'label' => '',
            'labelWidth' => 1,
            'pemisah' => ' ',
            'value'=>"",
             ),
      array(    'label' => '',
            'labelWidth' => 1,
            'pemisah' => ' ',
            'value'=>" JUMLAH 2 &nbsp<input type='text' id='jumlah2' placeholder='JUMLAH' value='".$this->nullChecker($volume2Temp)."' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 2  &nbsp&nbsp&nbsp&nbsp&nbsp    <input type='text' value='$satuan2Temp' name ='satuan2' id ='satuan2'>",
             ),
      array(    'label' => '',
            'labelWidth' => 1,
            'pemisah' => ' ',
            'value'=>"",
             ),
      array(    'label' => '',
            'labelWidth' => 1,
            'pemisah' => ' ',
            'value'=>" JUMLAH 3 &nbsp<input type='text' id='jumlah3' placeholder='JUMLAH' value='".$this->nullChecker($volume3Temp)."' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 3  &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' value='$satuan3Temp'name ='satuan3' id ='satuan3'>",
             ),
      array(    'label' => '',
            'labelWidth' => 1,
            'pemisah' => ' ',
            'value'=>"",
             ),
      array(    'label' => '',
            'labelWidth' => 1,
            'pemisah' => ' ',
            'value'=>" VOLUME &nbsp &nbsp<input type='text' value='$totalResult' placeholder='JUMLAH' id='jumlah4' readonly >&nbsp SATUAN VOL &nbsp <input type='text' name ='satuanVolume' id ='satuanVolume' style='width:150px;'  value='$satuanVolume' readonly> &nbsp &nbsp <span id='detailVolumeRincian'>",
             ),
       array(     'label' => '',
            'labelWidth' => 1,
            'pemisah' => ' ',
            'value'=>"",
             ),
        array(  'label' => '',
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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

  function Hapus($ids){ //validasi hapus ref_kota
     $err=''; $cek='';
    for($i = 0; $i<count($ids); $i++) {
        $getData = mysql_fetch_array(mysql_query("select * from pengeluaran where id='".$ids[$i]."'"));
        if($getData['status_posting'] == 1){

        }else{
          mysql_query("delete from pengeluaran where id = '".$ids[$i]."'");
          mysql_query("delete from detail_pengeluaran where id_pengeluaran = '".$ids[$i]."'");

        }




    }
    return array('err'=>$err,'cek'=>$cek);
  }

}
$pengeluaranPersediaan = new pengeluaranPersediaanObj();
$pengeluaranPersediaan->username = $_COOKIE['coID'];



?>
