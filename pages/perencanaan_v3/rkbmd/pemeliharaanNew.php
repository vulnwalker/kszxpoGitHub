<?php
class pemeliharaanNewObj  extends DaftarObj2{
  var $Prefix = 'pemeliharaanNew';
  var $elCurrPage="HalDefault";
  var $SHOW_CEK = TRUE;
  var $TblName = "view_rkbmd"; //daftar
  var $TblName_Hapus = 'tabel_anggaran';
  var $MaxFlush = 10;
  var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
  var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
  var $KeyFields = array('id_anggaran');
  var $FieldSum = array();
  var $SumValue = array();
  var $FieldSum_Cp1 = array( 14, 13, 13);
  var $FieldSum_Cp2 = array( 1, 1, 1);
  var $checkbox_rowspan = 3;
  var $PageTitle = 'RKBMD PEMELIHARAAN KUASA PENGGUNA BARANG';
  var $PageIcon = 'images/perencanaan_ico.png';
  var $pagePerHal ='';
  var $cetak_xls=TRUE ;
  var $fileNameExcel='usulansk.xls';
  var $Cetak_Judul = 'Daftar Standar Kebutuhan Barang Maksimal';
  var $Cetak_Mode=2;
  var $Cetak_WIDTH = '33cm';
  var $Cetak_OtherHTMLHead;
  var $FormName = 'pemeliharaanNewForm';
  var $kode_skpd = '';
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

  var $settingAnggaran = "";
  var $kondisiBarang = "and f != '06' and f!='07'";
  var $reportURL1 = "pages.php?Pg=pemeliharaanNew&tipe=Pemeliharaan1";
  var $reportURL2 = "pages.php?Pg=pemeliharaanNew&tipe=Pemeliharaan2";
  var $reportURL3 = "pages.php?Pg=pemeliharaanNew&tipe=Pemeliharaan3";

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
      $dt['c1'] = $_REQUEST[$this->Prefix.'rkbmdPemeliharaan_v3SkpdfmUrusan'];
      $dt['c'] = $_REQUEST[$this->Prefix.'rkbmdPemeliharaan_v3SkpdfmSKPD'];
      $dt['d'] = $_REQUEST[$this->Prefix.'rkbmdPemeliharaan_v3SkpdfmUNIT'];
      $dt['e'] = $_REQUEST[$this->Prefix.'rkbmdPemeliharaan_v3SkpdfmSUBUNIT'];
      $dt['e1'] = $_REQUEST[$this->Prefix.'rkbmdPemeliharaan_v3SkpdfmSEKSI'];
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
    
    
    $queryKategori = "SELECT id,kategori_tandatangan FROM ref_kategori_tandatangan where id = 1 or id = 2";
  
    
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
            'value'=>"<input type='text' id='kategori' name='kategori' value='".$queryKategori1[kategori_tandatangan]."' style='width: 250px;' readonly='readonly'>",
          
            
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
      
          $aqry = "INSERT into ref_tandatangan (c1,c,d,e,e1,nama,nip,jabatan,pangkat,gol,ruang,eselon,kategori_tandatangan) values('$kode1','$kode2','$kode3','$kode4','$kode5','$namapegawai','$nippegawai','$jabatan','$p1','$golongan[0]','$golongan[1]','$eselon','$kategori')";  $cek .= $aqry;  
          $qry = mysql_query($aqry);
          $jenisKegiatan = $_REQUEST['jenisKegiatan'];
            if($jenisKegiatan == "Pemeliharaan1" || $jenisKegiatan == "Pemeliharaan3"){
              $kategorinaey = 1;
            }else{
              $kategorinaey = 2;
            }
          $content = array('combottd' => cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = $kategorinaey and c1 = '".$_REQUEST[c1]."' and c = '".$_REQUEST[c]."' and d = '".$_REQUEST[d]."' and e = '".$_REQUEST[e]."' and e1 = '".$_REQUEST[e1]."' ",'onchange=ttd.refreshList(true);','-- TTD --'));
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
    case 'excel':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
       if($rkbmdPengadaan_v2SkpdfmUrusan =='0'){
        $err = "Pilih Urusan";
       }elseif($rkbmdPengadaan_v2SkpdfmSKPD =='00'){
        $err = "Pilih Bidang";
       }elseif($rkbmdPengadaan_v2SkpdfmUNIT =='00'){
        $err = "Pilih SKPD";
       }elseif($rkbmdPengadaan_v2SkpdfmSUBUNIT =='00'){
        $err = "Pilih Unit";
       }elseif($rkbmdPengadaan_v2SkpdfmSEKSI =='000'){
        $err = "Pilih Sub Unit";
       }else{
        $fm = $this->excel($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
      }

      break;

    }
    case 'jenisChanged':{
        $jenisKegiatan = $_REQUEST['jenisKegiatan'];
        if($jenisKegiatan == "Pemeliharaan1" || $jenisKegiatan == "Pemeliharaan3"){
          $kategorinaey = 1;
        }else{
          $kategorinaey = 2;
        }
      $content = array('ttd' => cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = $kategorinaey and c1 = '".$_REQUEST[c1]."' and c = '".$_REQUEST[c]."' and d = '".$_REQUEST[d]."' and e = '".$_REQUEST[e]."' and e1 = '".$_REQUEST[e1]."' ",'-- TTD --') ) ;
      break;
        }

    case 'Laporan':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
       if($pemeliharaanNewSkpdfmUrusan =='0'){
        $err = "Pilih Urusan";
       }elseif($pemeliharaanNewSkpdfmSKPD =='00'){
        $err = "Pilih Bidang";
       }elseif($pemeliharaanNewSkpdfmUNIT =='00'){
        $err = "Pilih SKPD";
       }elseif($pemeliharaanNewSkpdfmSUBUNIT =='00'){
        $err = "Pilih Unit";
       }elseif($pemeliharaanNewSkpdfmSEKSI =='000'){
        $err = "Pilih Sub Unit";
       }else{
        $fm = $this->Laporan($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
       }

      break;

    }


    case 'Report':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
      }
    $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'nama_pemda' "));
      if($jenisKegiatan==''){
          $err = "Pilih Format Laporan";
      }else{
          $data = array(
              'c1' => $c1,
              'c' => $c,
              'd' => $d,
              'e' => $e,
              'e1' => $e1,
              'username' => $this->username
              );
      if(mysql_num_rows(mysql_query("select * from skpd_report_rkbmd where username= '$this->username'")) == 0){
        $query = VulnWalkerInsert('skpd_report_rkbmd', $data);
      }else{
        $query = VulnWalkerUpdate('skpd_report_rkbmd', $data, "username = '$this->username'");
      }
      mysql_query($query);
        }
      $content= array('to' => $jenisKegiatan,'cetakjang'=>$cetakjang,'namaPemda'=>$namaPemda[option_value], 'ttd' => $ttd);
    break;
    }
    case 'Pemeliharaan1':{
      $json = FALSE;
      $this->Pemeliharaan1();
    break;
    }
    case 'Pemeliharaan2':{
      $json = FALSE;
      $this->Pemeliharaan2();
    break;
    }
    case 'Pemeliharaan3':{
      $json = FALSE;
      $this->Pemeliharaan3();
    break;
    }
    case 'Pemeliharaan4':{
      $json = FALSE;
      $this->Pemeliharaan4();
    break;
    }
    case 'Pemeliharaan5':{
      $json = FALSE;
      $this->Pemeliharaan5();
    break;
    }
    case 'Pemeliharaan6':{
      $json = FALSE;
      $this->Pemeliharaan6();
    break;
    }
    case 'Pemeliharaan7':{
      $json = FALSE;
      $this->Pemeliharaan7();
    break;
    }
    case 'Info':{
        $fm = $this->Info();
        $cek .= $fm['cek'];
        $err = $fm['err'];
        $content = $fm['content'];
    break;
    }
    case 'comboBoxPemenuhan':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }

       $caraPemenuhan =  "select cara_pemenuhan ,cara_pemenuhan from ref_cara_pemenuhan" ;
       $cmbCaraPemenuhan = cmbQuery('pemenuhan'.$id, $pemenuhan, $caraPemenuhan,' ','-- CARA PEMENUHAN --');
       $content = array('caraPemenuhan' => $cmbCaraPemenuhan ,'tambahCaraPemenuhan' => "<img style='margin-top: 3px;cursor:pointer;' src='datepicker/add-button-md.png' width='20px' heigh='20px'  onclick='$this->Prefix.formPemenuhan($id);'></img>" );



    break;
    }
    case 'newTab':{
       foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
       $nomorUrutSebelumnya = $this->nomorUrut - 1;
       $cekKeberadaanMangkluk =  mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$pemeliharaanNewSkpdfmUrusan' and c = '$pemeliharaanNewSkpdfmSKPD' and d='$pemeliharaanNewSkpdfmUNIT' and e = '$pemeliharaanNewSkpdfmSUBUNIT' and e1='$pemeliharaanNewSkpdfmSEKSI'  and q!='0' and no_urut ='$nomorUrutSebelumnya' "));
       $getDatarenja = mysql_fetch_array(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$pemeliharaanNewSkpdfmUrusan' and c = '$pemeliharaanNewSkpdfmSKPD' and d='$pemeliharaanNewSkpdfmUNIT' and e = '$pemeliharaanNewSkpdfmSUBUNIT' and e1='$pemeliharaanNewSkpdfmSEKSI' and q!='0' and no_urut = '$nomorUrutSebelumnya'"));
       $lastID = $getDatarenja['id_anggaran'];
       $parentC1 = $pemeliharaanNewSkpdfmUrusan;
         $parentC = $pemeliharaanNewSkpdfmSKPD;
       $parentD = $pemeliharaanNewSkpdfmUNIT;
       $parentE = $pemeliharaanNewSkpdfmSUBUNIT;
       $parentE1= $pemeliharaanNewSkpdfmSEKSI;
       if($cekKeberadaanMangkluk == 0){
         $cekKeberadaanMangkluk =  mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$pemeliharaanNewSkpdfmUrusan' and c = '$pemeliharaanNewSkpdfmSKPD' and d='$pemeliharaanNewSkpdfmUNIT' and e = '00' and e1='000'  and q!='0' and no_urut ='$nomorUrutSebelumnya' "));
         $getDatarenja = mysql_fetch_array(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$pemeliharaanNewSkpdfmUrusan' and c = '$pemeliharaanNewSkpdfmSKPD' and d='$pemeliharaanNewSkpdfmUNIT' and e = '00' and e1='000' and q!='0' and no_urut = '$nomorUrutSebelumnya'"));
         $lastID = $getDatarenja['id_anggaran'];
         $parentE = '00';
         $parentE1= '000';
       }

        if($cekKeberadaanMangkluk != 0){
          if($getDatarenja['jenis_form_modul']  == 'PENYUSUNAN' && $this->wajibValidasi == TRUE ){
            $getJumlahRenjaValidasi = mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$pemeliharaanNewSkpdfmUrusan' and c = '$pemeliharaanNewSkpdfmSKPD' and d='$pemeliharaanNewSkpdfmUNIT' and e = '$parentE' and e1='$parentE1' and q!='0' $this->sqlValidasi and no_urut = '$nomorUrutSebelumnya'"));
            if($getJumlahRenjaValidasi == 0){
              $err = "Renja Belum Di Validasi";
            }
          }

          $getParentpemeliharaanNew = mysql_fetch_array(mysql_query("select * from view_renja where id_anggaran = '$lastID'"));

          $getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentE' and e1 = '$parentE1' and p != '0' and q != '0' and no_urut = '$nomorUrutSebelumnya' "));
          $idrenja = $getIdRenja['id_anggaran'];

          $kemana = 'pemeliharaan_v3';
          $username = $_COOKIE['coID'];
          mysql_query("delete from temp_rkbmd_pemeliharaan where user = '$username'");
          mysql_query("delete from temp_rkbmd_pemeliharaan where user = '$username'");
          mysql_query("delete from rkbmd_pemeliharaan where user = '$username'");
        }else{
          $err  = "Renja Belum ada atau belum di Koreksi";

        }


        $content = array('idrenja' => $idrenja, "kemana" =>$kemana);
      break;
    }
    case 'editTab':{
       $id = $_REQUEST['pemeliharaanNew_cb'];
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
          $nomorUrutSebelumnya = $this->nomorUrut - 1;
          $getParentpemeliharaanNew = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran = '$id[0]'"));
          foreach ($getParentpemeliharaanNew as $key => $value) {
             $$key = $value;
           }
          $parentC1 = $getParentpemeliharaanNew['c1'];
          $parentC = $getParentpemeliharaanNew['c'];
          $parentD = $getParentpemeliharaanNew['d'];
          $parentE = $getParentpemeliharaanNew['e'];
          $parentE1= $getParentpemeliharaanNew['e1'];
          $getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentD' and e1 = '$parentE1' and p = '0' and q = '0' and no_urut = '$nomorUrutSebelumnya' "));
          $idrenja = $getIdRenja['id_anggaran'];
          if($idrenja == 0){
            $parentE = '00';
            $parentE1= '000';
            $getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentE' and e1 = '$parentE1' and p = '0' and q = '0' and no_urut = '$nomorUrutSebelumnya' "));
            $idrenja = $getIdRenja['id_anggaran'];
          }
          $kemana = 'pemeliharaan_v3';

          $username = $_COOKIE['coID'];
          mysql_query("delete from temp_rkbmd_pengadaan where user = '$username'");
          mysql_query("delete from temp_rkbmd_pemeliharaan where user = '$username'");
          mysql_query("delete from rkbmd_pemeliharaan where user = '$username'");

          $nextUrut = $this->nomorUrut + 1;
          $arrayExcept = array();
          $grabExceptID = mysql_query("select * from view_rkbmd where no_urut = '$nextUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and j!='000' and id_jenis_pemeliharaan !='0' ");
          while($getKoreksi = mysql_fetch_array($grabExceptID)){
            foreach ($getKoreksi as $key => $value) {
                 $$key = $value;
             }
             $getIDawal = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck ='$ck' and dk='$dk' and p='$p' and $q='$q' and f='$f' and g='$g' and h = '$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'"));
             $arrayExcept[] = "id_anggaran !='".$getIDawal['id_anggaran']."'";
          }
          $exceptID= join(' and ',$arrayExcept);
            $exceptID = $exceptID =='' ? '':' and '.$exceptID;
          foreach ($_REQUEST as $key => $value) {
              $$key = $value;
           }
          $execute = mysql_query("select * from view_rkbmd where  c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and id_tahap ='$this->idTahap' and f !='00' and id_jenis_pemeliharaan !='0'  $exceptID  ");
              while($rows = mysql_fetch_array($execute)){
              foreach ($rows as $key => $value) {
                 $$key = $value;
              }
              $data = array(
                  'c1' => $c1,
                  'c' => $c,
                  'd' => $d,
                  'e' => $e,
                  'e1' => $e1,
                  'bk' => $bk,
                  'ck' => $ck,
                  'dk' => $dk,
                  'p' => $p,
                  'q' => $q,
                  'f' => $f,
                  'g' => $g,
                  'h' => $h,
                  'i' => $i,
                  'j' => $j,
                  'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
                  'keterangan' => $catatan,
                  'satuan' => $satuan_barang,
                  'uraian_pemeliharaan' => $uraian_pemeliharaan,
                  'volume_barang' => $volume_barang,
                  'user' => $username
                  );
              if($id_jenis_pemeliharaan != '0'){
              if($status_validasi == '1'){

              }else{
                mysql_query(VulnWalkerInsert('rkbmd_pemeliharaan',$data));
              }

              }
            }

        if(mysql_num_rows($execute) == 0){
          $err = "Data sudah di koreksi pengguna !";
        }




        $content = array('idrenja' => $idrenja, "kemana" =>$kemana, "qc" => "select * from view_rkbmd where id_anggaran = '$id[0]'");
      break;
    }
    case 'Validasi':{
        $dt = array();
        $err='';
        $content='';
        $uid = $HTTP_COOKIE_VARS['coID'];

        $cbid = $_REQUEST[$this->Prefix.'_cb'];
        $idplh = $_REQUEST['id_anggaran'];
        $this->form_idplh =$_REQUEST['id_anggaran'];


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
       $getSKPD = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$pemeliharaanNew_idplh'"));
       $cmbUrusanForm = $getSKPD['c1'];
       $cmbBidangForm = $getSKPD['c'];
       $cmbSKPDForm = $getSKPD['d'];
       $cmbUnitForm = $getSKPD['e'];
       $cmbSubUnitForm = $getSKPD['e1'];
       $bk= $getSKPD['bk'];
       $ck = $getSKPD['ck'];
       $dk = $getSKPD['dk'];
       $p = $getSKPD['p'];
       $q = $getSKPD['q'];


       $data = array( "status_validasi" => $status_validasi,
              'user_validasi' => $_COOKIE['coID'],
              'tanggal_validasi' => date("Y-m-d"),
              'id_tahap' => $this->idTahap
              );
       $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$pemeliharaanNew_idplh'");
       mysql_query($query);

      $content .= $query;
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
     case 'remove':{
      $id = $_REQUEST['pemeliharaanNew_cb'];
      for($i = 0 ; $i < sizeof($id) ; $i++ ){
        $getData = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran='$id[$i]'"));
        $c1 = $getData['c1'];
        $c = $getData['c'];
        $d = $getData['d'];
        $e = $getData['e'];
        $e1 = $getData['e1'];
        $bk = $getData['bk'];
        $dk = $getData['dk'];
        $ck = $getData['ck'];
        $p = $getData['p'];
        $q = $getData['q'];

        $nextUrut = $this->nomorUrut + 1;
        $arrayExcept = array();
        $grabExceptID = mysql_query("select * from view_rkbmd where no_urut = '$nextUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and j!='000' and id_jenis_pemeliharaan !='0' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' ");
          while($getKoreksi = mysql_fetch_array($grabExceptID)){
            foreach ($getKoreksi as $key => $value) {
                 $$key = $value;
             }
             $getIDawal = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck ='$ck' and dk='$dk' and p='$p' and $q='$q' and f='$f' and g='$g' and h = '$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'"));
             $arrayExcept[] = "id_anggaran !='".$getIDawal['id_anggaran']."'";
          }
        $exceptID= join(' and ',$arrayExcept);
        $exceptID = $exceptID =='' ? '':' and '.$exceptID;
        $c1 = $getData['c1'];
        $c = $getData['c'];
        $d = $getData['d'];
        $e = $getData['e'];
        $e1 = $getData['e1'];
        $bk = $getData['bk'];
        $ck = $getData['ck'];
        $dk = $getData['dk'];
        $p = $getData['p'];
        $q = $getData['q'];
        $get = mysql_query("select * from tabel_anggaran where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and id_tahap ='$this->idTahap' and ((id_jenis_pemeliharaan != '0' and f !='00') or uraian_pemeliharaan = 'RKBMD PEMELIHARAAN') and id_anggaran!='$id[$i]' and status_validasi !='1' $exceptID ");
        while($rows= mysql_fetch_array($get)){
          foreach ($rows as $key => $value) {
            $$key = $value;
          }
          if($status_validasi == '1'){
          }else{

            if($j !='000'){
              mysql_query("delete from tabel_anggaran where id_anggaran ='$id_anggaran' ");
            }
          }
        }





      }

    break;
    }
    case 'koreksi':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
      }
      $queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
      $getpemeliharaanNewnya = mysql_fetch_array(mysql_query($queryRows));
      foreach ($getpemeliharaanNewnya as $key => $value) {
          $$key = $value;
      }



      if($this->jenisForm !='KOREKSI PENGGUNA' && $this->jenisForm !='KOREKSI PENGELOLA'){
        $err = "Tahap Koreksi Telah Habis";
      }else{
        $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '0' and ck = '0' and dk='0' and p = '0' and q= '0' and id_tahap='$this->idTahap'"));
        if($cekSKPD < 1){
          $data = array('jenis_anggaran' => $this->jenisAnggaran,
                  'tahun' => $this->tahun,
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
                        'f' => '00',
                        'g' => '00',
                          'h' => '00',
                        'i' => '00',
                        'j' => '000',
                  'id_tahap' => $this->idTahap,
                  'nama_modul' => "RKBMD",
                  'tanggal_update' => date('Y-m-d'),
                  'user_update' => $_COOKIE['coID']
                  );
            mysql_query(VulnWalkerInsert('tabel_anggaran',$data));
        }
        $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck = '$ck' and dk='$dk' and p = '$p' and q= '0' and id_tahap='$this->idTahap'"));
        if($cekProgram < 1){
          $data = array('jenis_anggaran' => $this->jenisAnggaran,
                  'tahun' => $this->tahun,
                  'c1' => $c1,
                  'c' => $c,
                  'd' => $d,
                  'e' => $e,
                  'e1' => $e1,
                  'bk' => $bk,
                  'ck' => $ck,
                  'dk' => $dk,
                  'p' => $p,
                  'q' => '0',
                  'f1' => '0',
                        'f2' => '0',
                        'f' => '00',
                        'g' => '00',
                          'h' => '00',
                        'i' => '00',
                        'j' => '000',
                  'id_tahap' => $this->idTahap,
                  'nama_modul' => "RKBMD",
                  'tanggal_update' => date('Y-m-d'),
                  'user_update' => $_COOKIE['coID']
                  );
            mysql_query(VulnWalkerInsert('tabel_anggaran',$data));
        }

        $cekKegiatanPemeliharaan = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck = '$ck' and dk='$dk' and p = '$p' and q= '$q' and  f='00' and id_tahap='$this->idTahap' and uraian_pemeliharaan = 'RKBMD PEMELIHARAAN'"));
        if($cekKegiatanPemeliharaan < 1){
          $data = array('jenis_anggaran' => $this->jenisAnggaran,
                  'tahun' => $this->tahun,
                  'c1' => $c1,
                  'c' => $c,
                  'd' => $d,
                  'e' => $e,
                  'e1' => $e1,
                  'bk' => $bk,
                  'ck' => $ck,
                  'dk' => $dk,
                  'p' => $p,
                  'q' => $q,
                  'f1' => '0',
                        'f2' => '0',
                        'f' => '00',
                        'g' => '00',
                          'h' => '00',
                        'i' => '00',
                        'j' => '000',
                  'id_tahap' => $this->idTahap,
                  'nama_modul' => "RKBMD",
                  'tanggal_update' => date('Y-m-d'),
                  'user_update' => $_COOKIE['coID'],
                  'uraian_pemeliharaan' => 'RKBMD PEMELIHARAAN'
                  );
            mysql_query(VulnWalkerInsert('tabel_anggaran',$data));
        }





       $dataSesuai = array(           'jenis_anggaran' => $this->jenisAnggaran,
                      'tahun' => $this->tahun,
                      'c1' => $c1,
                      'c' => $c,
                      'd' => $d,
                      'e' => $e,
                      'e1' => $e1,
                      'bk' => $bk,
                      'ck' => $ck,
                      'dk' => $dk,
                      'p' => $p,
                      'q' => $q,
                      'f' => $f,
                      'g' => $g,
                      'h' => $h,
                      'i' => $i,
                      'j' => $j,
                      'cara_pemenuhan' => $caraPemenuhan,
                      'volume_barang' => $angkaKoreksi,
                      'satuan_barang' => $satuan_barang,
                      'id_tahap' => $this->idTahap,
                      'nama_modul' => $this->modul,
                      'uraian_pemeliharaan' => $uraian_pemeliharaan,
                      'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
                      'user_update' => $_COOKIE['coID'],
                      'tanggal_update' => date('Y-m-d'),
                      'catatan' => $catatan


                );

        $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j ;
        $kodeSKPD = $c1.".".$c.".".$d.".".$e.".".$e1;
        $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
        $concat = $kodeSKPD.".".$kodeBarang;

          $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
          $kebutuhanMax = $getKebutuhanMax['jumlah'];
          $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
          $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
          $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;
          $melebihi = "Kebutuhan Riil";




        $cekKoreksi =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
        if($cekKoreksi > 0 ){
           $getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
              $idnya = $getID['id_anggaran'];

            if( $getpemeliharaanNewnya['volume_barang'] >= $angkaKoreksi ) {
              mysql_query("update tabel_anggaran set volume_barang = '$angkaKoreksi' , cara_pemenuhan = '$caraPemenuhan' where id_anggaran='$idnya'");
            }elseif($getpemeliharaanNewnya['volume_barang'] < $angkaKoreksi){
              $err = "Jumlah Koreksi Tidak Melebihi Pengajuan";
            }

      }else{
            if( $getpemeliharaanNewnya['volume_barang'] >= $angkaKoreksi )  {
              mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
            }elseif($getpemeliharaanNewnya['volume_barang'] < $angkaKoreksi){
              $err = "Jumlah Koreksi Tidak Melebihi Pengajuan";
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
      $getMaxID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
      $maxID = $getMaxID['id_anggaran'];
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
    case 'formPemenuhan':{
        $dt = $_REQUEST['id'];
        $fm = $this->formPemenuhan($dt);
        $cek = $fm['cek'];
        $err = $fm['err'];
        $content = $fm['content'];


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
    $scriptload =

          "<script>
            $(document).ready(function(){

              ".$this->Prefix.".loading();

            });



          </script>";

    return
      "

      <script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
       "<script type='text/javascript' src='js/perencanaan_v3/rkbmd/pemeliharaanNew.js' language='JavaScript' ></script>".
      $scriptload;
  }
function Pemeliharaan1($xls =FALSE){
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


    $this->fileNameExcel = "USULAN RKBMD PEMELIHARAAN PADA KUASA PENGGUNA BARANG";
    $align = "right";
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
    
    $arrKondisi[] = "c1 = '$c1'";
    $arrKondisi[] = "c = '$c'";
    $arrKondisi[] = "d = '$d'";
    $arrKondisi[] = "e = '$e'";
    $arrKondisi[] = "e1 = '$e1'";
    $arrKondisi[] = "id_tahap = '$this->idTahap'";

    
    $grabBarangsql = mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j != '000' ");
    while ($isibarangsql = mysql_fetch_array($grabBarangsql)) {
      if (mysql_num_rows(mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isibarangsql[bk]."' and ck = '".$isibarangsql[ck]."' and dk = '".$isibarangsql[dk]."' and p = '".$isibarangsql[p]."' and q = '".$isibarangsql[q]."' and f = '".$isibarangsql[f]."' and g = '".$isibarangsql[g]."' and h = '".$isibarangsql[h]."' and i = '".$isibarangsql[i]."' and j = '".$isibarangsql[j]."' and id_jenis_pemeliharaan != 0 ")) == 0) {

        $arrKondisi[] = "id_anggaran != '".$isibarangsql[id_anggaran]."' ";
        $arrblacklistbarang[] = "id_anggaran != '".$isibarangsql[id_anggaran]."' ";

      }
    }
    $kondisiblacklistbarang= join(' and ',$arrblacklistbarang);
    if(sizeof($arrblacklistbarang) == 0){
      $kondisiblacklistbarang= '';
    }else{
      $kondisiblacklistbarang = " and ".$kondisiblacklistbarang;
    }
    $grabKegiatansql = mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and q != '0' and j = '000' ");

    while ($isikegiatan = mysql_fetch_array($grabKegiatansql)) {
      if (mysql_num_rows(mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isikegiatan[bk]."' and ck = '".$isikegiatan[ck]."' and dk = '".$isikegiatan[dk]."' and p = '".$isikegiatan[p]."' and q = '".$isikegiatan[q]."' and j != '000' and id_jenis_pemeliharaan != '0' $kondisiblacklistbarang ")) == 0) {

        $arrKondisi[] = "id_anggaran != '".$isikegiatan[id_anggaran]."' ";
        $arrayblacklistkegiatan[] = "id_anggaran != '".$isikegiatan[id_anggaran]."' ";

      }
    }

    $grabprogramsql = mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p != '0' and q = '0' and j = '000' ");
    while ($isiprogram = mysql_fetch_array($grabprogramsql)) {
      if (mysql_num_rows(mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isiprogram[bk]."' and ck = '".$isiprogram[ck]."' and dk = '".$isiprogram[dk]."' and p = '".$isiprogram[p]."' and j != '000' and id_jenis_pemeliharaan != '0' $kondisiblacklistbarang ")) == 0) {

        $arrKondisi[] = "id_anggaran != '".$isiprogram[id_anggaran]."' ";
        $arrayblacklistprogram[] = $isiprogram[id_anggaran];

      }
    }
    $blacklistprogram = json_encode($arrayblacklistprogram);

    $Kondisi= join(' and ',$arrKondisi);
    if(sizeof($arrKondisi) == 0){
      $Kondisi= '';
    }else{
      $Kondisi = " and ".$Kondisi;
    }

    $qry = "SELECT * from view_rkbmd where 1=1 $Kondisi order by urut asc";

    $aqry = mysql_query($qry);

    $getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
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
          <table class=\"rangkacetak\" style='width: $width; font-family: sans-serif; height: $height'>
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
                    <span style='font-size:18px;font-weight:bold;text-transform: uppercase; '>
                      USULAN RENCANA KEBUTUHAN PEMELIHARAAN BARANG MILIK DAERAH<br>
                      (RENCANA PEMELIHARAAN)<br>
                      KUASA PENGUNA BARANG ".$subunit."<br>
                      <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN ANGGARAN $this->tahun </span>
                    </span>
                  </td>
                </tr>
              </table>

        ".
                $this->LaporanTmplSKPD($get['c1'],$get['c'],$get['d'],$get['e'],$get['e1'],$pisah);
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='width:100%;'>
                <thead>
                  <tr>
                    <th class='th01' rowspan='3' style='width:20px;' >NO</th>
                    <th class='th01' rowspan='3' >PROGRAM/<br>KEGIATAN/<br>OUTPUT</th>
                    <th class='th02' rowspan='1' colspan='8' >BARANG YANG DIPELIHARA</th>
                    <th class='th02' rowspan='1' colspan='3' >USULAN KEBUTUHAN PEMELIHARAAN</th>
                    <th class='th01' rowspan='3' style='width: 6%;'>KETERANGAN</th>
                  </tr>
                  <tr>
                    <th class='th01' rowspan='2' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' rowspan='2' style='width:4%;'>JUMLAH</th>
                    <th class='th01' rowspan='2' style='width:4%;'>SATUAN</th>
                    <th class='th01' rowspan='2' style='width:4%;'>STATUS BARANG</th>
                    <th class='th02' rowspan='1' colspan='3' >KONDISI BARANG</th>
                    <th class='th01' rowspan='2' >NAMA PEMELIHARAAN</th>
                    <th class='th01' rowspan='2' style='width:4%;'>JUMLAH</th>
                    <th class='th01' rowspan='2' style='width:4%;'>SATUAN</th>


                  </tr>
                  <tr>
                    <th class='th01' rowspan='1' style='width: 3%;'>B</th>
                    <th class='th01' rowspan='1' style='width: 3%;'>KB</th>
                    <th class='th01' rowspan='1' style='width: 3%;'>RB</th>
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
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk='$dk' and p='$p' and q='$q'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk='$dk' and p='$p' and q='$q'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j !='000'){
        $programKegiatan = "";
        $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
        $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
        $namaBarang = $getNamaBarang['nm_barang'];
        $volBar = number_format($volume_barang,0,'.',',');
        $getNamaPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
        $namaPemeliharaan = $getNamaPemeliharaan['jenis'];
        $getJumlahB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='1'"));
        $b =  number_format($getJumlahB['jml_barang'],0,'.',',');
        $getJumlahKB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='2'"));
        $kb =  number_format($getJumlahKB['jml_barang'],0,'.',',');
        $getJumlahRB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='3'"));
        $rb =  number_format($getJumlahRB['jml_barang'],0,'.',',');
        $jumlahBarangDiBukuInduk = $getJumlahB['jml_barang'] + $getJumlahKB['jml_barang'] + $getJumlahRB['jml_barang'];
        $status_barang = "MILIK";
      }

      if ($q != "0") {
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk='$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='13'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }else{
        $namaProgram = "<td align='left' class='GarisCetak' style='padding-left: 5px;' colspan='13'>".$programKegiatan."</td>";
      }

      if ($q == '0' && $p == '0') {
        $namasub = mysql_fetch_array(mysql_query("SELECT * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' "));
        $namasubunit = $namasub[nm_skpd];
        $naonkitu =
        "
                <tr valign='top' hidden='hidden'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  <td align='left' class='GarisCetak' colspan='13' style='font-weight: bold;'>$namasubunit</td>
                </tr>
      ";
      }

      elseif ($q == '0' && $p != '0') {
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
                  <td align='left' class='GarisCetak' colspan='1'></td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."</br>".$namaBarang."</td>
                  <td align='left' class='GarisCetak' >".$jumlahBarangDiBukuInduk."</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='center' class='GarisCetak' >$status_barang</td>
                  <td align='right' class='GarisCetak'>$b</td>
                  <td align='right' class='GarisCetak'>$kb</td>
                  <td align='right' class='GarisCetak'>$rb</td>
                  <td align='left' class='GarisCetak'>$uraian_pemeliharaan <span style='float: right;'>($jumlah1 x $jumlah2)</span></td>
                  <td align='right' class='GarisCetak'>$volBar</td>
                  <td align='left' class='GarisCetak'>$satuan_barang</td>
                  <td align='left' class='GarisCetak'>$catatan</td>
                </tr>
      ";
      }
      echo $naonkitu;
      $naonkitu = "";


      
      $volBar = "";
      $jumlahBarangSebelumnya = "";
      $rb = "";
      $b = "";
      $kb = "";
      $satuan_barang = "";
      $jumlahBarangDiBukuInduk = "";
      $catatan = "";
      $volBar= "";
      $status_barang= "";
      $namaPemeliharaan = "";
    }
    echo        "</table>";
    $getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));

    if($xls){
      echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP  ".$getDataKuasaPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        </body>
      </html>";
    }else{
      if (sizeof($arrayTandaTangan1)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport1['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$arrayPosisi' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$arrayPosisi' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

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
            <h5 class='pag pag1' style='bottom: -10px; font-size: 9px;'>
              <span style='bottom: 0; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
            </h5>
            <div class='insert'></div>
      </body>
    </html>";
    }
  }

function Pemeliharaan2($xls =FALSE){
    global $Main;
    $getJenisReport2 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL2' "));
    $getJenisUkuran = $getJenisReport2['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTangan2 = explode(';', $getJenisReport2['tanda_tangan']);

    $this->fileNameExcel = "HASIL PENELAAHAN RKBMD PEMELIHARAAN OLEH PENGGUNA BARANG";
    $align = "right";
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
    
    $arrKondisi[] = "c1 = '$c1'";
    $arrKondisi[] = "c = '$c'";
    $arrKondisi[] = "d = '$d'";
    $arrKondisi[] = "e = '$e'";
    $arrKondisi[] = "e1 = '$e1'";
    $arrKondisi[] = "id_tahap = '$this->idTahap'";

    
    $grabBarangsql = mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j != '000' ");
    while ($isibarangsql = mysql_fetch_array($grabBarangsql)) {
      if (mysql_num_rows(mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isibarangsql[bk]."' and ck = '".$isibarangsql[ck]."' and dk = '".$isibarangsql[dk]."' and p = '".$isibarangsql[p]."' and q = '".$isibarangsql[q]."' and f = '".$isibarangsql[f]."' and g = '".$isibarangsql[g]."' and h = '".$isibarangsql[h]."' and i = '".$isibarangsql[i]."' and j = '".$isibarangsql[j]."' and id_jenis_pemeliharaan != 0 ")) == 0) {

        $arrKondisi[] = "id_anggaran != '".$isibarangsql[id_anggaran]."' ";
        $arrblacklistbarang[] = "id_anggaran != '".$isibarangsql[id_anggaran]."' ";

      }
    }
    $kondisiblacklistbarang= join(' and ',$arrblacklistbarang);
    if(sizeof($arrblacklistbarang) == 0){
      $kondisiblacklistbarang= '';
    }else{
      $kondisiblacklistbarang = " and ".$kondisiblacklistbarang;
    }
    $grabKegiatansql = mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and q != '0' and j = '000' ");

    while ($isikegiatan = mysql_fetch_array($grabKegiatansql)) {
      if (mysql_num_rows(mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isikegiatan[bk]."' and ck = '".$isikegiatan[ck]."' and dk = '".$isikegiatan[dk]."' and p = '".$isikegiatan[p]."' and q = '".$isikegiatan[q]."' and j != '000' and id_jenis_pemeliharaan != '0' $kondisiblacklistbarang ")) == 0) {

        $arrKondisi[] = "id_anggaran != '".$isikegiatan[id_anggaran]."' ";
        $arrayblacklistkegiatan[] = "id_anggaran != '".$isikegiatan[id_anggaran]."' ";

      }
    }

    $grabprogramsql = mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p != '0' and q = '0' and j = '000' ");
    while ($isiprogram = mysql_fetch_array($grabprogramsql)) {
      if (mysql_num_rows(mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isiprogram[bk]."' and ck = '".$isiprogram[ck]."' and dk = '".$isiprogram[dk]."' and p = '".$isiprogram[p]."' and j != '000' and id_jenis_pemeliharaan != '0' $kondisiblacklistbarang ")) == 0) {

        $arrKondisi[] = "id_anggaran != '".$isiprogram[id_anggaran]."' ";
        // $arrKondisi[] = "akjl SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isiprogram[bk]."' and ck = '".$isiprogram[ck]."' and dk = '".$isiprogram[dk]."' and p = '".$isiprogram[p]."' and q = '".$isiprogram[q]."' and j != '000' and id_jenis_pemeliharaan != '0' $kondisiblacklistbarang akjl";
        $arrayblacklistprogram[] = $isiprogram[id_anggaran];

      }
    }
    $blacklistprogram = json_encode($arrayblacklistprogram);


    $Kondisi= join(' and ',$arrKondisi);
    if(sizeof($arrKondisi) == 0){
      $Kondisi= '';
    }else{
      $Kondisi = " and ".$Kondisi;
    }
    $qry = "SELECT * from view_rkbmd where 1=1 $Kondisi order by urut asc";

    $aqry = mysql_query($qry);
    $getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
    $grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
    $urusan = $grabUrusan['nm_skpd'];
    $grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
    $bidang = $grabBidang['nm_skpd'];
    $grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
    $skpd = $grabSkpd['nm_skpd'];
    $grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
    $unit = $grabUnit['nm_skpd'];
    $grabSubUnit = mysql_fetch_array(mysql_query("SELECT * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='".$_GET[unit]."' and e1='".$_GET[subunit]."' "));
    $subunit = $grabSubUnit['nm_skpd'];
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
            .GarisCetak1{
              padding: 17px;
              border: 1px solid #000;
            }
          </style>
        </head>".
      "<body >
        <div style='width:$this->Cetak_WIDTH_Landscape;'>
          <table class=\"rangkacetak\" style='width: $width; font-family: sans-serif;'>
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
                    <span style='font-size:18px;font-weight:bold;text-transform: uppercase;'>
                      HASIL PENELAAHAN RENCANA KEBUTUHAN PEMELIHARAAN BARANG MILIK DAERAH<br>
                      (RENCANA PEMELIHARAAN)<br>
                      KUASA PENGUNA BARANG ".$subunit."<br>
                      <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN : $this->tahun </span>
                    </span>
                  </td>
                </tr>
              </table>

        ".
                $this->LaporanTmplSKPD($get['c1'],$get['c'],$get['d'],$get['e'],$get['e1'],$pisah);
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='width:100%; margin: 1 0 0 0;'>
                <thead>
                  <tr>
                    <th class='th01' rowspan='3' style='width:20px;' >NO</th>
                    <th class='th01' rowspan='3' >PROGRAM/<br>KEGIATAN/<br>OUTPUT</th>
                    <th class='th02' rowspan='1' colspan='8' >BARANG YANG DIPELIHARA</th>
                    <th class='th02' rowspan='1' colspan='3' >USULAN KEBUTUHAN PEMELIHARAAN</th>
                    <th class='th02' rowspan='1' colspan='2' >RENCANA KEBUTUHAN PEMELIHARAAN BMD YANG DISETUJUI</th>
                    <th class='th01' rowspan='3' >KETERANGAN</th>
                  </tr>
                  <tr>
                    <th class='th01' rowspan='2' colspa='2'>KODE / NAMA BARANG</th>
                    <th class='th01' rowspan='2' >JUMLAH</th>
                    <th class='th01' rowspan='2' colspan='2'>SATUAN</th>
                    <th class='th01' rowspan='2' >STATUS BARANG</th>
                    <th class='th02' rowspan='1' colspan='3' >KONDISI BARANG</th>
                    <th class='th01' rowspan='2' >NAMA PEMELIHARAAN</th>
                    <th class='th01' rowspan='2' >JUMLAH</th>
                    <th class='th01' rowspan='2' >SATUAN</th>
                    <th class='th01' rowspan='2' >JUMLAH</th>
                    <th class='th01' rowspan='2' >SATUAN</th>


                  </tr>
                  <tr>
                    <th class='th01' rowspan='1' style='width: 3%;'>B</th>
                    <th class='th01' rowspan='1' style='width: 3%;'>KB</th>
                    <th class='th01' rowspan='1' style='width: 3%;'>RB</th>
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
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk='$dk' and p='$p' and q='0'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk='$dk' and p='$p' and q='$q'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j !='000'){
        $programKegiatan = "";
        $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
        $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
        $namaBarang = $getNamaBarang['nm_barang'];
        $volBar = number_format($volume_barang,0,'.',',');
        $getNamaPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
        $namaPemeliharaan = $getNamaPemeliharaan['jenis'];
        $getJumlahB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='1'"));
        $b =  number_format($getJumlahB['jml_barang'],0,'.',',');
        $getJumlahKB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='2'"));
        $kb =  number_format($getJumlahKB['jml_barang'],0,'.',',');
        $getJumlahRB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='3'"));
        $rb =  number_format($getJumlahRB['jml_barang'],0,'.',',');
        $jumlahBarangDiBukuInduk = $getJumlahB['jml_barang'] + $getJumlahKB['jml_barang'] + $getJumlahRB['jml_barang'];
        $status_barang = "MILIK";
        $nomorurutSetelahnya = $this->nomorUrut +1 ;
        $getJumlahBarangSetelahnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q= '$q' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and uraian_pemeliharaan = '$uraian_pemeliharaan' and no_urut='$nomorurutSetelahnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
        $volumeBarangSetelahnya = number_format($getJumlahBarangSetelahnya['volume_barang'],0,'.',',');
      }
      if ($q != "0") {
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk='$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='15'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }else{
        $namaProgram = "<td align='left' class='GarisCetak' colspan='15' style='padding-left: 5px;'>".$programKegiatan."</td>";
      }

      if ($q == '0' && $p == '0') {
        $namasub = mysql_fetch_array(mysql_query("SELECT * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' "));
        $namasubunit = $namasub[nm_skpd];
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  <td align='left' class='GarisCetak' colspan='15' style='font-weight: bold;'>$namasubunit</td>
                </tr>
      ";
      }

      elseif ($q == '0' && $p != '0') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaProgram."
                </tr>
      ";
      }elseif ($q != '0' && $f == '00') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaKegiatan."
                </tr>
      ";
      }else{
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  <td align='left' class='GarisCetak' colspan='1'></td>
                  <td align='left' class='GarisCetak' colspan='1'>".$kodeBarang."</br>".$namaBarang."</td>
                  <td align='left' class='GarisCetak' colspan='2'>".$jumlahBarangDiBukuInduk."</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='center' class='GarisCetak' >$status_barang</td>
                  <td align='right' class='GarisCetak'>$b</td>
                  <td align='right' class='GarisCetak'>$kb</td>
                  <td align='right' class='GarisCetak'>$rb</td>
                  <td align='left' class='GarisCetak'>$uraian_pemeliharaan</td>
                  <td align='right' class='GarisCetak'>$volBar</td>
                  <td align='left' class='GarisCetak'>$satuan_barang</td>
                  <td align='right' class='GarisCetak'>$volumeBarangSetelahnya</td>
                  <td align='left' class='GarisCetak'>$satuan_barang</td>
                  <td align='left' class='GarisCetak'>$catatan</td>
                </tr>
      ";
      }

      echo $naonkitu;
      $naonkitu = "";

      $no++;

      $volBar = "";
      $jumlahBarangSebelumnya = "";
      $rb = "";
      $b = "";
      $kb = "";
      $satuan_barang = "";
      $jumlahBarangDiBukuInduk = "";
      $catatan = "";
      $volBar= "";
      $status_barang= "";
      $namaPemeliharaan = "";



    }
    echo        "</table>";
    $getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));
    $getDataPejabatPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PEJABAT'"));
    $getDataPengurusPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGURUS'"));

    if($xls){
      echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>NIP  ".$getDataKuasaPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        ";
    echo "  <div >
          <div>Telah Diperiksa : </div>
          <table table width='100%' class='cetak' border='1' style='margin-left:90px;width:50%;'>
            <tr>
              <th class='th01'>No</th>
              <th class='th01'>Nama</th>
              <th class='th01'>Jabatan</th>
              <th class='th01'>TTD / Paraf</th>
              <th class='th01' >Tanggal</th>
            </tr>
            <tr>
              <td align='$align' class='GarisCetak' >1.</td>
              <td align='left' class='GarisCetak' >".$getDataPejabatPenggunaBarang['nama']."</td>
              <td align='left' class='GarisCetak' >Pejabat Penatausahaan Pengguna Barang</td>
              <td align='left' class='GarisCetak' >&nbsp</td>
              <td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
              <td align='$align' class='GarisCetak' >2.</td>
              <td align='left' class='GarisCetak' >".$getDataPengurusPenggunaBarang['nama']."</td>
              <td align='left' class='GarisCetak' >Pengurus Barang Pengguna</td>
              <td align='left' class='GarisCetak' >&nbsp</td>
              <td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
          </tabel>
        </div>
      </body>
    </html>";

    }else{
      if (sizeof($arrayTandaTangan2)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport2['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '2' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '2' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '2' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            Disetujui<br>
            $queryKategori1[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$hmm['nama']."</u><br>
            NIP ".$hmm['nip']."


            </div>";

          }elseif (sizeof($arrayTandaTangan2)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport2['posisi']);
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

          }elseif (sizeof($arrayTandaTangan2)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport2['posisi']);
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
            <h5 class='pag pag1' style='bottom: -10px; font-size: 9px;'>
              <span style='bottom: 0; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
            </h5>
            <div class='insert'></div>
      ";
      $queryNamaDiperiksa1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '14' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
      $queryNamaDiperiksa2 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '23' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
      $queryKategoriDiperiksa1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '14' "));
      $queryKategoriDiperiksa2 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '23' "));
    echo " <div >
          <div style='margin-left:90px;width:50%;' >Telah Diperiksa : </div>
          <table table width='100%' class='cetak' border='1' style='width: 70%;'>
            <tr>
              <th class='th01' style='width: 42px;''>No</th>
              <th class='th01' style='width: 195px;'>Nama</th>
              <th class='th01' style='width: 29%;'>Jabatan</th>
              <th class='th01' style='width: 176px;'>TTD / Paraf</th>
              <th class='th01' >Tanggal</th>
            </tr>
            <tr>
              <td align='center' class='GarisCetak1' >1</td>
              <td align='left' class='GarisCetak1' >".$queryNamaDiperiksa1[nama]."</td>
              <td align='left' class='GarisCetak1' >PEJABAT PENATAUSAHAAN BARANG</td>
              <td align='left' class='GarisCetak1' >&nbsp</td>
              <td align='left' class='GarisCetak1' ></td>
            </tr>
            <tr>
              <td align='center' class='GarisCetak1' >2</td>
              <td align='left' class='GarisCetak1' >".$queryNamaDiperiksa2[nama]."</td>
              <td align='left' class='GarisCetak1' >".$queryKategoriDiperiksa2['kategori_tandatangan']."</td>
              <td align='left' class='GarisCetak1' >&nbsp</td>
              <td align='left' class='GarisCetak1' ></td>
            </tr>
          </tabel>
        </div>
      </body>
    </html>";
    }
  }

function Pemeliharaan3($xls =FALSE){
    global $Main;
    $getJenisReport3 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL3' "));
    $getJenisUkuran = $getJenisReport3['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTangan3 = explode(';', $getJenisReport3['tanda_tangan']);


    $this->fileNameExcel = "RKBMD PEMELIHARAAN PADA KUASA PENGGUNA BARANG";
    $align = "right";
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
    
    $arrKondisi[] = "c1 = '$c1'";
    $arrKondisi[] = "c = '$c'";
    $arrKondisi[] = "d = '$d'";
    $arrKondisi[] = "e = '$e'";
    $arrKondisi[] = "e1 = '$e1'";
    $arrKondisi[] = "id_tahap = '$this->idTahap'";

    
    $grabBarangsql = mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j != '000' ");
    while ($isibarangsql = mysql_fetch_array($grabBarangsql)) {
      if (mysql_num_rows(mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isibarangsql[bk]."' and ck = '".$isibarangsql[ck]."' and dk = '".$isibarangsql[dk]."' and p = '".$isibarangsql[p]."' and q = '".$isibarangsql[q]."' and f = '".$isibarangsql[f]."' and g = '".$isibarangsql[g]."' and h = '".$isibarangsql[h]."' and i = '".$isibarangsql[i]."' and j = '".$isibarangsql[j]."' and id_jenis_pemeliharaan != 0 ")) == 0) {

        $arrKondisi[] = "id_anggaran != '".$isibarangsql[id_anggaran]."' ";
        $arrblacklistbarang[] = "id_anggaran != '".$isibarangsql[id_anggaran]."' ";

      }
    }
    $kondisiblacklistbarang= join(' and ',$arrblacklistbarang);
    if(sizeof($arrblacklistbarang) == 0){
      $kondisiblacklistbarang= '';
    }else{
      $kondisiblacklistbarang = " and ".$kondisiblacklistbarang;
    }
    $grabKegiatansql = mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and q != '0' and j = '000' ");

    while ($isikegiatan = mysql_fetch_array($grabKegiatansql)) {
      if (mysql_num_rows(mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isikegiatan[bk]."' and ck = '".$isikegiatan[ck]."' and dk = '".$isikegiatan[dk]."' and p = '".$isikegiatan[p]."' and q = '".$isikegiatan[q]."' and j != '000' and id_jenis_pemeliharaan != '0' $kondisiblacklistbarang ")) == 0) {

        $arrKondisi[] = "id_anggaran != '".$isikegiatan[id_anggaran]."' ";
        $arrayblacklistkegiatan[] = "id_anggaran != '".$isikegiatan[id_anggaran]."' ";

      }
    }

    $grabprogramsql = mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p != '0' and q = '0' and j = '000' ");
    while ($isiprogram = mysql_fetch_array($grabprogramsql)) {
      if (mysql_num_rows(mysql_query("SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isiprogram[bk]."' and ck = '".$isiprogram[ck]."' and dk = '".$isiprogram[dk]."' and p = '".$isiprogram[p]."' and j != '000' and id_jenis_pemeliharaan != '0' $kondisiblacklistbarang ")) == 0) {

        $arrKondisi[] = "id_anggaran != '".$isiprogram[id_anggaran]."' ";
        // $arrKondisi[] = "akjl SELECT * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '".$isiprogram[bk]."' and ck = '".$isiprogram[ck]."' and dk = '".$isiprogram[dk]."' and p = '".$isiprogram[p]."' and q = '".$isiprogram[q]."' and j != '000' and id_jenis_pemeliharaan != '0' $kondisiblacklistbarang akjl";
        $arrayblacklistprogram[] = $isiprogram[id_anggaran];

      }
    }
    $blacklistprogram = json_encode($arrayblacklistprogram);

    $Kondisi= join(' and ',$arrKondisi);
    if(sizeof($arrKondisi) == 0){
      $Kondisi= '';
    }else{
      $Kondisi = " and ".$Kondisi;
    }

    $qry = "SELECT * from view_rkbmd where 1=1 $Kondisi order by urut asc";

    $aqry = mysql_query($qry);
    $getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
    $grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
    $urusan = $grabUrusan['nm_skpd'];
    $grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
    $bidang = $grabBidang['nm_skpd'];
    $grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
    $skpd = $grabSkpd['nm_skpd'];
    $grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
    $unit = $grabUnit['nm_skpd'];
    $grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='".$_GET[unit]."' and e1='".$_GET[subunit]."'"));
    $subunit = $grabSubUnit['nm_skpd'];
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
          <table class=\"rangkacetak\" style='width: $width; font-family: sans-serif;'>
            <tr>
              <td valign=\"top\"> <div style='text-align:center;'>
              <table style='width: 100%; border: none; margin-bottom: 0.5%;'>
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
                    <span style='font-size:18px;font-weight:bold;text-transform: uppercase;'>
                      RENCANA KEBUTUHAN PEMELIHARAAN BARANG MILIK DAERAH<br>
                      (RENCANA PEMELIHARAAN)<br>
                      KUASA PENGUNA BARANG ".$subunit."<br>
                      <span class='ukurantulisanIdPenerimaan'>TAHUN ANGGARAN $this->tahun </span>
                    </span>
                  </td>
                </tr>
              </table>

        ".
                $this->LaporanTmplSKPD($get['c1'],$get['c'],$get['d'],$get['e'],$get['e1'],$pisah);
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='width:100%;'>
                <thead>
                  <tr>
                    <th class='th01' rowspan='3' style='width:20px;' >NO</th>
                    <th class='th01' rowspan='3' >PROGRAM/<br>KEGIATAN/<br>OUTPUT</th>
                    <th class='th02' rowspan='1' colspan='8' >BARANG YANG DIPELIHARA</th>
                    <th class='th02' rowspan='1' colspan='3' >RENCANA KEBUTUHAN PEMELIHARAAN BMD YANG DISETUJUI</th>
                    <th class='th01' rowspan='3' >KETERANGAN</th>
                  </tr>
                  <tr>
                    <th class='th01' rowspan='2' >KODE BARANG</th>
                    <th class='th01' rowspan='2' >NAMA BARANG</th>
                    <th class='th01' rowspan='2' >JUMLAH</th>
                    <th class='th01' rowspan='2' >SATUAN</th>
                    <th class='th01' rowspan='2' >STATUS BARANG</th>
                    <th class='th02' rowspan='1' colspan='3' >KONDISI BARANG</th>
                    <th class='th01' rowspan='2' >NAMA PEMELIHARAAN</th>
                    <th class='th01' rowspan='2' >JUMLAH</th>
                    <th class='th01' rowspan='2' >SATUAN</th>


                  </tr>
                  <tr>
                    <th class='th01' rowspan='1' >B</th>
                    <th class='th01' rowspan='1' >KB</th>
                    <th class='th01' rowspan='1' >RB</th>
                  </tr>
                <thead>
    ";

    $no = 1;
    while($daqry = mysql_fetch_array($aqry)){
      foreach ($daqry as $key => $value) {
          $$key = $value;
      }
      $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
      if($q == '0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk='$dk' and p='$p' and q='0'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk='$dk' and p='$p' and q='$q'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j !='000'){
        $programKegiatan = "";
        $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
        $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
        $namaBarang = $getNamaBarang['nm_barang'];
        $volBar = number_format($volume_barang,0,'.',',');
        $getNamaPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
        $namaPemeliharaan = $getNamaPemeliharaan['jenis'];
        $getJumlahB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='1'"));
        $b =  number_format($getJumlahB['jml_barang'],0,'.',',');
        $getJumlahKB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='2'"));
        $kb =  number_format($getJumlahKB['jml_barang'],0,'.',',');
        $getJumlahRB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='3'"));
        $rb =  number_format($getJumlahRB['jml_barang'],0,'.',',');
        $jumlahBarangDiBukuInduk = $getJumlahB['jml_barang'] + $getJumlahKB['jml_barang'] + $getJumlahRB['jml_barang'];
        $status_barang = "MILIK";
        $nomorurutSetelahnya = $this->nomorUrut +1 ;
        $getJumlahBarangSetelahnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q= '$q' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and uraian_pemeliharaan = '$uraian_pemeliharaan' and no_urut='$nomorurutSetelahnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
        $volumeBarangSetelahnya = number_format($getJumlahBarangSetelahnya['volume_barang'],0,'.',',');
        //$jumlahBarangSebelumnya = "select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and uraian_pemeliharaan = '$uraian_pemeliharaan' and no_urut='$nomorurutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'";
      }

      if ($q != "0") {
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk='$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='13'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }else{
        $namaProgram = "<td align='left' class='GarisCetak' colspan='13' style='padding-left: 5px;'>".$programKegiatan."</td>";
      }

      if ($q == '0' && $p == '0') {
        $namasub = mysql_fetch_array(mysql_query("SELECT * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' "));
        $namasubunit = $namasub[nm_skpd];
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  <td align='left' class='GarisCetak' colspan='13'>$namasubunit</td>
                </tr>
      ";
      }

      elseif ($q == '0' && $p != '0') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaProgram."
                </tr>
      ";
      }elseif ($q != '0' && $f == '00') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaKegiatan."
                </tr>
      ";
      }else{
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  <td align='left' class='GarisCetak' colspan='1'></td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."</br>".$namaBarang."</td>
                  <td align='left' class='GarisCetak' >".$jumlahBarangDiBukuInduk."</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='center' class='GarisCetak' >$status_barang</td>
                  <td align='right' class='GarisCetak'>$b</td>
                  <td align='right' class='GarisCetak'>$kb</td>
                  <td align='right' class='GarisCetak'>$rb</td>
                  <td align='left' class='GarisCetak'>$uraian_pemeliharaan</td>
                  <td align='right' class='GarisCetak'>$volumeBarangSetelahnya</td>
                  <td align='left' class='GarisCetak'>$satuan_barang</td>
                  <td align='left' class='GarisCetak'>$catatan</td>
                </tr>
      ";
      }

      echo $naonkitu;
      $naonkitu = "";

      $no++;

      $volBar = "";
      $jumlahBarangSebelumnya = "";
      $rb = "";
      $b = "";
      $kb = "";
      $satuan_barang = "";
      $jumlahBarangDiBukuInduk = "";
      $catatan = "";
      $volBar= "";
      $status_barang= "";
      $namaPemeliharaan = "";


    }
    echo        "</table>";
    $getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));

    if($xls){
      echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP  ".$getDataKuasaPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        </body>
      </html>";
    }else{
      if (sizeof($arrayTandaTangan3)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport3['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$arrayPosisi' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$arrayPosisi' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));


            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $queryKategori1[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <u>".$hmm['nama']."</u><br>
            NIP ".$hmm['nip']."


            </div>";

          }elseif (sizeof($arrayTandaTangan3)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport3['posisi']);
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

          }elseif (sizeof($arrayTandaTangan3)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport3['posisi']);
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
            <h5 class='pag pag1' style='bottom: -10px; font-size: 9px;'>
              <span style='bottom: 0; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
            </h5>
            <div class='insert'></div>
      </body>
    </html>";
    }
  }
function Laporan($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   // $this->form_width = 800;
   $this->form_height = 100;
   $this->form_caption = 'LAPORAN RKBMD PEMELIHARAAN';
   $c1 = $dt['rkbmdPemeliharaan_v3SkpdfmUrusan'];
   $c = $dt['rkbmdPemeliharaan_v3SkpdfmSKPD'];
   $d = $dt['rkbmdPemeliharaan_v3SkpdfmUNIT'];
   $e = $dt['rkbmdPemeliharaan_v3SkpdfmSUBUNIT'];
   $e1 = $dt['rkbmdPemeliharaan_v3SkpdfmSEKSI'];

   if($e1 != '000'){
     $arrayJenisLaporan = array(
                 array('Pemeliharaan1', 'USULAN RKBMD PEMELIHARAAN PADA KUASA PENGGUNA BARANG'),
                 // array('Pemeliharaan2', 'HASIL PENELAAHAN RKBMD PEMELIHARAAN OLEH PENGGUNA BARANG'),
                 // array('Pemeliharaan3', 'RKBMD PEMELIHARAAN PADA KUASA PENGGUNA BARANG'),
                 );
   }

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
                  'value'=>cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = 999 and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' ",'onchange=ttd.refreshList(true);','-- TTD --'),

                ),

      );
    //tombol
    $this->form_menubawah =
      "
      
      <input type='button' value='TTD' onclick ='".$this->Prefix.".Baru()' title='TTD' >
      <input type='button' value='View' onclick ='".$this->Prefix.".Report()' title='Simpan' >   ".
      "<input type='button' value='Batal' onclick ='rkbmdPemeliharaan_v3.Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }
function LaporanTmplSKPD($c1, $c, $d, $e, $e1,$pisah){
    global $Main, $DataPengaturan, $DataOption;

    $get = mysql_fetch_array(mysql_query("select * from skpd_report_rkbmd where username = '$this->username'"));
    foreach ($get as $key => $value) {
      $$key = $value;
    }
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



    $data = "
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

        </table>";

    return $data;
  }

}
$pemeliharaanNew = new pemeliharaanNewObj();
$arrayResult = tahapPerencanaanV3($pemeliharaanNew->modul,"MURNI");
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = "MURNI";
$idTahap = $arrayResult['idTahap'];

$pemeliharaanNew->jenisForm = $jenisForm;
$pemeliharaanNew->nomorUrut = $nomorUrut;
$pemeliharaanNew->urutTerakhir = $nomorUrut;
$pemeliharaanNew->tahun = $tahun;
$pemeliharaanNew->jenisAnggaran = $jenisAnggaran;
$pemeliharaanNew->idTahap = $idTahap;
$pemeliharaanNew->username = $_COOKIE['coID'];
$pemeliharaanNew->wajibValidasi =  $arrayResult['wajib_validasi'];
if($pemeliharaanNew->wajibValidasi == TRUE){
  $pemeliharaanNew->sqlValidasi = " and status_validasi ='1' ";
}else{
  $pemeliharaanNew->sqlValidasi = " ";
}

$pemeliharaanNew->provinsi = $arrayResult['provinsi'];
$pemeliharaanNew->kota = $arrayResult['kota'];
$pemeliharaanNew->pengelolaBarang = $arrayResult['pengelolaBarang'];
$pemeliharaanNew->pejabatPengelolaBarang = $arrayResult['pejabat'];
$pemeliharaanNew->pengurusPengelolaBarang = $arrayResult['pengurus'];
$pemeliharaanNew->nipPengelola = $arrayResult['nipPengelola'];
$pemeliharaanNew->nipPengurus = $arrayResult['nipPengurus'];
$pemeliharaanNew->nipPejabat = $arrayResult['nipPejabat'];
$pemeliharaanNew->settingAnggaran = $arrayResult['settingAnggaran'];
?>