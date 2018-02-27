<?php 
class koreksiPengadaanNewObj  extends DaftarObj2{
  var $Prefix = 'koreksiPengadaanNew';
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
  var $PageTitle = 'RKBMD PENGADAAN PENGGUNA BARANG';
  var $PageIcon = 'images/perencanaan_ico.png';
  var $pagePerHal ='';
  var $cetak_xls=TRUE ;
  var $fileNameExcel='usulansk.xls';
  var $Cetak_Judul = 'Daftar Standar Kebutuhan Barang Maksimal';
  var $Cetak_Mode=2;
  var $Cetak_WIDTH = '30cm';
  var $Cetak_OtherHTMLHead;
  var $FormName = 'koreksiPengadaanNewForm';
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
  var $kondisiBarang = "and f != '06' and f!='07' and f!='08'";
  var $reportURL2 = "pages.php?Pg=pengadaanNew&tipe=Pengadaan2";
  var $reportURL3 = "pages.php?Pg=pengadaanNew&tipe=Pengadaan3";
  var $reportURL4 = "pages.php?Pg=koreksiPengadaanNew&tipe=Pengadaan4";
  var $reportURL5 = "pages.php?Pg=koreksiPengadaanNew&tipe=Pengadaan5";
  var $reportURL6 = "pages.php?Pg=koreksiPengadaanNew&tipe=Pengadaan6";

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
      $dt['c1'] = $_REQUEST[$this->Prefix.'koreksiPenggunaPengadaanSkpdfmUrusan'];
      $dt['c'] = $_REQUEST[$this->Prefix.'koreksiPenggunaPengadaanSkpdfmSKPD'];
      $dt['d'] = $_REQUEST[$this->Prefix.'koreksiPenggunaPengadaanSkpdfmUNIT'];
      $dt['e'] = $_REQUEST[$this->Prefix.'koreksiPenggunaPengadaanSkpdfmSUBUNIT'];
      $dt['e1'] = $_REQUEST[$this->Prefix.'koreksiPenggunaPengadaanSkpdfmSEKSI'];
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
            'value'=>cmbQuery('kategori',$dt['kategori_tandatangan'],$queryKategori,'style=width:350px;','--PILIH--')
          
            
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
            if($jenisKegiatan == "Pengadaan1" || $jenisKegiatan == "Pengadaan3"){
              $kategorinaey = 1;
            }else{
              $kategorinaey = 2;
            }
          $content = array('combottd' => cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = '$kategorinaey' and c1 = '".$_REQUEST[c1]."' and c = '".$_REQUEST[c]."' and d = '".$_REQUEST[d]."' and e = '".$_REQUEST[e]."' and e1 = '".$_REQUEST[e1]."' ",'onchange=rka.refreshList(true);','-- TTD --'));



         
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
function Laporan($dt,$c1,$c,$d,$e,$e1){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;
   $form_name = $this->Prefix.'_form';
   $this->form_height = 100;
   $this->form_caption = 'LAPORAN RKBMD PENGADAAN';

   $c1 = $dt['koreksiPenggunaPengadaanSkpdfmUrusan'];
   $c = $dt['koreksiPenggunaPengadaanSkpdfmSKPD'];
   $d = $dt['koreksiPenggunaPengadaanSkpdfmUNIT'];
   $e = $dt['koreksiPenggunaPengadaanSkpdfmSUBUNIT'];
   $e1 = $dt['koreksiPenggunaPengadaanSkpdfmSEKSI'];
     $arrayJenisLaporan = array(
                 // array('Pengadaan4', 'USULAN RKBMD PENGADAAN PADA PENGGUNA BARANG'),
                 // array('Pengadaan5', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGELOLA BARANG'),
                 // array('Pengadaan6', 'RKBMD PENGADAAN PADA PENGGUNA BARANG'),
                 array('Pengadaan2', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGGUNA BARANG'),
                 array('Pengadaan3', 'RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG'),


                 );
     $queryNama12 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '14' and c1 = '$c1' and c = '$c' and d = '$d' "));
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
                  'value'=>cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = 999 and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' ",'onchange=rka.refreshList(true);','-- TTD --'),

                ),

      );
    //tombol
    $this->form_menubawah =
      "
      
      <input type='button' value='TTD' onclick ='".$this->Prefix.".Baru()' title='TTD' >
      <input type='button' value='View' onclick ='".$this->Prefix.".Report()' title='Simpan' >   ".
      "<input type='button' value='Batal' onclick ='".'koreksiPenggunaPengadaan'.".Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

  function set_selector_other($tipe){
   global $Main;
   $cek = ''; $err=''; $content=''; $json=TRUE;

    switch($tipe){
    case 'excel':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
       if($koreksiPengadaanNewSkpdfmUrusan =='0'){
        $err = "Pilih Urusan";
       }elseif($koreksiPengadaanNewSkpdfmSKPD =='00'){
        $err = "Pilih Bidang";
       }elseif($koreksiPengadaanNewSkpdfmUNIT =='00'){
        $err = "Pilih SKPD";
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
        if($jenisKegiatan == "Pengadaan1" || $jenisKegiatan == "Pengadaan3"){
          $kategorinaey = 1;
        }else{
          $kategorinaey = 2;
        }
      $content = array('ttd' => cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = $kategorinaey and c1 = '".$_REQUEST[c1]."' and c = '".$_REQUEST[c]."' and d = '".$_REQUEST[d]."' and e = '".$_REQUEST[e]."' and e1 = '".$_REQUEST[e1]."' ",'-- TTD --') ) ;
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
  case 'formBaru':{       
      $fm = $this->setFormBaru();       
      $cek = $fm['cek'];
      $err = $fm['err'];
      $content = $fm['content'];                        
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
      $content= array('to' => $jenisKegiatan,'cetakjang'=>$cetakjang,'namaPemda'=>$namaPemda[option_value],'ttd'=>$ttd);
    break;
    }
    case 'Pengadaan1':{
      $json = FALSE;
      $this->Pengadaan1();
    break;
    }
    case 'Pengadaan2':{
      $json = FALSE;
      $this->Pengadaan2();
    break;
    }
    case 'Pengadaan3':{
      $json = FALSE;
      $this->Pengadaan3();
    break;
    }
    case 'Pengadaan4':{
      $json = FALSE;
      $this->Pengadaan4();
    break;
    }
    case 'Pengadaan5':{
      $json = FALSE;
      $this->Pengadaan5();
    break;
    }
    case 'Pengadaan6':{
      $json = FALSE;
      $this->Pengadaan6();
    break;
    }
    case 'Pengadaan7':{
      $json = FALSE;
      $this->Pengadaan7();
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
       $cmbCaraPemenuhan = cmbQuery('pemenuhan'.$id, "PEMBELIAN", $caraPemenuhan,' ','-- CARA PEMENUHAN --');
       $content = array('caraPemenuhan' => $cmbCaraPemenuhan ,'tambahCaraPemenuhan' => "<img style='margin-top: 3px;cursor:pointer;' src='datepicker/add-button-md.png' width='20px' heigh='20px'  onclick='$this->Prefix.formPemenuhan($id);'></img>" );



    break;
    }
    case 'newTab':{
       foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
       $nomorUrutSebelumnya = $this->nomorUrut - 1;
       $cekKeberadaanMangkluk =  mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$koreksiPengadaanNewSkpdfmUrusan' and c = '$koreksiPengadaanNewSkpdfmSKPD' and d='$koreksiPengadaanNewSkpdfmUNIT' and e = '$koreksiPengadaanNewSkpdfmSUBUNIT' and e1='$koreksiPengadaanNewSkpdfmSEKSI'  and q!='0' and no_urut ='$nomorUrutSebelumnya' "));
       $getDatarenja = mysql_fetch_array(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$koreksiPengadaanNewSkpdfmUrusan' and c = '$koreksiPengadaanNewSkpdfmSKPD' and d='$koreksiPengadaanNewSkpdfmUNIT' and e = '$koreksiPengadaanNewSkpdfmSUBUNIT' and e1='$koreksiPengadaanNewSkpdfmSEKSI' and q!='0' and no_urut = '$nomorUrutSebelumnya'"));
       $lastID = $getDatarenja['id_anggaran'];
        if($cekKeberadaanMangkluk != 0){
          if($getDatarenja['jenis_form_modul']  == 'PENYUSUNAN' ){
            $getJumlahRenjaValidasi = mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$koreksiPengadaanNewSkpdfmUrusan' and c = '$koreksiPengadaanNewSkpdfmSKPD' and d='$koreksiPengadaanNewSkpdfmUNIT' and e = '$koreksiPengadaanNewSkpdfmSUBUNIT' and e1='$koreksiPengadaanNewSkpdfmSEKSI' and q!='0' $this->sqlValidasi and no_urut = '$nomorUrutSebelumnya'"));
            if($getJumlahRenjaValidasi == 0){
              $err = "Renja Belum Di Validasi";
            }
          }

          $getParentkoreksiPengadaanNew = mysql_fetch_array(mysql_query("select * from view_renja where id_anggaran = '$lastID'"));
          $parentC1 = $getParentkoreksiPengadaanNew['c1'];
          $parentC = $getParentkoreksiPengadaanNew['c'];
          $parentD = $getParentkoreksiPengadaanNew['d'];
          $parentE = $getParentkoreksiPengadaanNew['e'];
          $parentE1= $getParentkoreksiPengadaanNew['e1'];
          $getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentE' and e1 = '$parentE1' and p = '0' and q = '0' and no_urut = '$nomorUrutSebelumnya' "));
          $idrenja = $getIdRenja['id_anggaran'];
          if($cmbJeniskoreksiPengadaanNew == 'PENGADAAN'){
            $kemana = 'ins_v3';
          }else{
            $kemana = 'pemeliharaan_v3';
          }
          $username = $_COOKIE['coID'];
          mysql_query("delete from temp_rkbmd_pengadaan where user = '$username'");
          mysql_query("delete from temp_rkbmd_pemeliharaan where user = '$username'");
          mysql_query("delete from rkbmd_pemeliharaan where user = '$username'");
        }else{
          $err  = "Renja Belum ada atau belum di Koreksi";

        }


        $content = array('idrenja' => $idrenja, "kemana" =>$kemana);
      break;
    }
    case 'editTab':{
       $id = $_REQUEST['koreksiPengadaanNew_cb'];
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
          $nomorUrutSebelumnya = $this->nomorUrut - 1;
          $getParentkoreksiPengadaanNew = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran = '$id[0]'"));
          foreach ($getParentkoreksiPengadaanNew as $key => $value) {
             $$key = $value;
           }
          $parentC1 = $getParentkoreksiPengadaanNew['c1'];
          $parentC = $getParentkoreksiPengadaanNew['c'];
          $parentD = $getParentkoreksiPengadaanNew['d'];
          $parentE = $getParentkoreksiPengadaanNew['e'];
          $parentE1= $getParentkoreksiPengadaanNew['e1'];
          $getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentE' and e1 = '$parentE1' and p = '0' and q = '0' and no_urut = '$nomorUrutSebelumnya' "));
          $idrenja = $getIdRenja['id_anggaran'];
          if($cmbJeniskoreksiPengadaanNew == 'PENGADAAN'){
            $kemana = 'ins_v3';
          }else{
            $kemana = 'pemeliharaan_v3';
          }
          $username = $_COOKIE['coID'];
          mysql_query("delete from temp_rkbmd_pengadaan where user = '$username'");
          mysql_query("delete from temp_rkbmd_pemeliharaan where user = '$username'");
          mysql_query("delete from rkbmd_pemeliharaan where user = '$username'");

          $execute = mysql_query("select * from view_rkbmd where  c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and id_tahap ='$this->idTahap' and f !='00' ");
              while($rows = mysql_fetch_array($execute)){
              foreach ($rows as $key => $value) {
                 $$key = $value;
              }
              $data  = array(
                 "c1" => $c1,
                 "c" => $c,
                 "d" => $d,
                 "e" => $e,
                 "e1" => $e1,
                 "bk" => $bk,
                 "ck" => $ck,
                 "dk" => $dk,
                 "p" => $p,
                 "q" => $q,
                 "f" => $f,
                 "g" => $g,
                 "h" => $h,
                 "i" => $i,
                 "j" => $j,
                 "satuan" => $satuan_barang,
                 "jumlah" => $volume_barang,
                 "catatan" => $catatan,
                 "user" => $_COOKIE['coID']
              );
              if($status_validasi == '1'){
                //$err = "Data Telah Di Validasi !";
              }else{
                mysql_query(VulnWalkerInsert('temp_rkbmd_pengadaan',$data));
              }

            }




        $content = array('idrenja' => $idrenja, "kemana" =>$kemana, "qc" => "select * from view_rkbmd where id_anggaran = '$id[0]'");
      break;
    }
    case 'Laporan':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
       if($koreksiPengadaanNewSkpdfmUrusan =='0'){
        $err = "Pilih Urusan";
       }elseif($koreksiPengadaanNewSkpdfmSKPD =='00'){
        $err = "Pilih Bidang";
       }elseif($koreksiPengadaanNewSkpdfmUNIT =='00'){
        $err = "Pilih SKPD";
       }else{
        $fm = $this->Laporan($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
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
    case 'SaveValid':{
        foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
       if ($validasi == 'on') {
         $status_validasi = "1";
       }else{
        $status_validasi = "0";
       }
       $getSKPD = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$koreksiPengadaanNew_idplh'"));
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
              'tanggal_validasi' => date("Y-m-d")
              );
       $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$koreksiPengadaanNew_idplh'");
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
      $id = $_REQUEST['koreksiPengadaanNew_cb'];
      for($i = 0 ; $i < sizeof($id) ; $i++ ){
        $getData = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran='$id[$i]'"));
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

        $get = mysql_query("select * from tabel_anggaran where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and id_tahap ='$this->idTahap' and ((id_jenis_pemeliharaan = '0' and f !='00') or uraian_pemeliharaan = 'RKBMD PENGADAAN') and id_anggaran!='$id[$i]' ");
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
      $getkoreksiPengadaanNewnya = mysql_fetch_array(mysql_query($queryRows));
      foreach ($getkoreksiPengadaanNewnya as $key => $value) {
          $$key = $value;
      }


      $nextNomorUrut = $this->nomorUrut + 1;
      if($this->jenisForm !='KOREKSI PENGGUNA' && $this->jenisForm !='KOREKSI PENGELOLA'){
        $err = "Tahap Koreksi Telah Habis";
      }elseif(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$nextNomorUrut' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'")) != 0){
        $err = "Data Yang Telah Disetujui Pengelola Barang Tidak Dapat Diubah";
      }else{
        $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '0' and ck = '0' and dk = '0' and p = '0' and q= '0' and id_tahap='$this->idTahap'"));
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
        $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q= '0' and id_tahap='$this->idTahap'"));
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

        $cekKegiatanPengadaan = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q= '$q' and  f='00' and id_tahap='$this->idTahap' and uraian_pemeliharaan = 'RKBMD PENGADAAN'"));
        if($cekKegiatanPengadaan < 1){
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
                  'uraian_pemeliharaan' => 'RKBMD PENGADAAN'
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
                      'f1' => $f1,
                      'f2' => $f2,
                      'f' => $f,
                      'g' => $g,
                      'h' => $h,
                      'i' => $i,
                      'j' => $j,
                      'cara_pemenuhan' => $caraPemenuhan,
                      'volume_barang' => $angkaKoreksi,
                      'id_tahap' => $this->idTahap,
                      'nama_modul' => $this->modul,
                      'satuan_barang' => $satuan_barang,
                      'uraian_pemeliharaan' => $uraian_pemeliharaan,
                      'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
                      'user_update' => $_COOKIE['coID'],
                      'tanggal_update' => date('Y-m-d'),
                      'catatan' => $catatan


                );

        $kodeBarang =$f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$j ;
        $kodeSKPD = $c1.".".$c.".".$d.".".$e.".".$e1;
        $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
        $concat = $kodeSKPD.".".$kodeBarang;

          $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
          $kebutuhanMax = $getKebutuhanMax['jumlah'];
          $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
          $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
          $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;
          $melebihi = "Kebutuhan Riil";




        $cekKoreksi =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
        if($cekKoreksi > 0 ){
           $getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
              $idnya = $getID['id_anggaran'];
            if($getID['status_validasi'] == '1'){
              $err = "Data sudah di koreksi pengelola";
            }elseif($angkaKoreksi <= $kebutuhanRiil || (empty($jumlahOptimal) && empty($kebutuhanMax) && $getkoreksiPengadaanNewnya['volume_barang'] >= $angkaKoreksi )  ){
              mysql_query("update tabel_anggaran set volume_barang = '$angkaKoreksi' , cara_pemenuhan = '$caraPemenuhan' where id_anggaran='$idnya'");
            }elseif($getkoreksiPengadaanNewnya['volume_barang'] < $angkaKoreksi){
              $err = "Jumlah Koreksi Tidak Melebihi Pengajuan";
            }else{
              $err = "Tidak dapat melebihi $melebihi";
            }

      }else{
            if($angkaKoreksi <= $kebutuhanRiil || (empty($jumlahOptimal) && empty($kebutuhanMax) ) && $getkoreksiPengadaanNewnya['volume_barang'] >= $angkaKoreksi ){
              mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
              /*$dugDung = array('status_validasi' => '1');
              mysql_query(VulnWalkerUpdate("tabel_anggaran",$dugDung, " id_anggaran = '$idAwal'" ));*/
            }elseif($getkoreksiPengadaanNewnya['volume_barang'] < $angkaKoreksi){
              $err = "Jumlah Koreksi Tidak Melebihi Pengajuan";
            }else{
              $err = "Tidak dapat melebihi $melebihi";

            }

      }

      }


      //$cek = "select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p = '$p' and q='$q'  and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'";




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
      $getMaxID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
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
    case 'SaveCaraPemenuhan':{
        foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }

       $data = array( "cara_pemenuhan" => $caraPemenuhan
              );
       $query = VulnWalkerInsert("ref_cara_pemenuhan",$data);
       $execute = mysql_query($query);
       if($execute){

       }else{
        $err = "input gagal";
       }

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
    $noUrutKoreksi = $this->nomorUrut - 1;
    $angka = mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap'"));
     if($this->jenisForm == "KOREKSI"){
       $noUrutKoreksi  = $this->nomorUrut - 1;
       $angka = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$noUrutKoreksi'"));
     }
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
        for (i=0; i < ".$angka."; i++) {
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


          </script>";

    return
      "

      <script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
       "<script type='text/javascript' src='js/perencanaan_v3/rkbmd/koreksiPengadaanNew.js' language='JavaScript' ></script>".
      $scriptload;
  }
function Pengadaan2($xls =FALSE){
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

    $this->fileNameExcel = "HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGGUNA BARANG";
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
    $getPenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
    $penggunaBarang = $getPenggunaBarang['nm_skpd'];
    $getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul ='KOREKSI PENGGUNA'"));
    $lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
    $getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
    $lastNomorUrut = $getLastTahap['no_urut'];
    $arrKondisi = array();
    $grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and p !='0' and q='0'");
    while($rows = mysql_fetch_array($grabProgram)){
      foreach ($rows as $key => $value) {
          $$key = $value;
      }
      if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk = '$dk' and p ='$p' and j!='000' $this->kondisiBarang ")) == 0){
        $concat = $bk.".".$ck.".".$dk.".".$p;
        $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
      }else{
        if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and ck='$dk' and p ='$p' and q='$q' and j!='000' $this->kondisiBarang")) == 0){
          if($q != '0'){
            $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
          }
        }else{
            $concat = $f.".".$g.".".$h.".".$i.".".$j;
          if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' $this->kondisiBarang")) == 0){
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

    $qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $this->kondisiBarang $Kondisi order by urut";
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
            .GarisCetak1{
              padding: 17px;
              border: 1px solid #000;
            }
          </style>
        </head>".
      "<body >
        <div style='width:$this->Cetak_WIDTH_Landscape;'>
          <table class=\"rangkacetak\" style='width: $width; font-family: sans-serif; height: $height;'>
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
                      HASIL PENELAAHAN RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
                      (RENCANA PENGADAAN)<br>
                      KUASA PENGUNA BARANG ".strtoupper($subunit)."<br>
                      <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN ANGGARAN $this->tahun </span>
                    </span>
                  </td>
                </tr>
              </table>

          <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif; margin-bottom: -0.5%;'>

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
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='width:100%;'>
                <thead>
                  <tr>
                    <th class='th01' rowspan='3' style='width:20px;' >NO</th>
                    <th class='th02' rowspan='1' colspan='5' >USULAN RKBMD</th>
                    <th class='th02' rowspan='1' colspan='2' >KEBUTUHAN MAKSIMUM</th>
                    <th class='th02' rowspan='1' colspan='4' >DATA DAFTAR BARANG YANG DAPAT DIOPTIMALKAN</th>
                    <th class='th02' rowspan='1' colspan='2' >KEBUTUHAN RILL BARANG MILIK DAERAH</th>
                    <th class='th02' rowspan='2' colspan='2' >RENCANA KEBUTUHAN PENGADAAN BMD YANG DISETUJUI</th>
                    <th class='th01' rowspan='3'  style='width: 6%;'>CARA PEMENUHAN</th>
                    <th class='th01' rowspan='3'  >KETERANGAN</th>
                  </tr>
                  <tr>
                    <th class='th01' rowspan='2'>PROGRAM/<br>KEGIATAN/<br>OUTPUT</th>
                    <th class='th01' rowspan='2' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' rowspan='2' style='width:4%;'>JUMLAH</th>
                    <th class='th01' rowspan='2' style='width:4%;'>SATUAN</th>
                    <th class='th01' rowspan='2' style='width:4%;'>JUMLAH</th>
                    <th class='th01' rowspan='2' style='width:4%;'>SATUAN</th>
                    <th class='th01' rowspan='2' colspan='2'>KODE / BARANG</th>
                    <th class='th01' rowspan='2' style='width:4%;'>JUMLAH</th>
                    <th class='th01' rowspan='2' style='width:4%;'>SATUAN</th>
                    <th class='th01' rowspan='2' style='width:4%;'>JUMLAH</th>
                    <th class='th01' rowspan='2' style='width:4%;'>SATUAN</th>
                  </tr>
                  <tr>
                    <th class='th01' style='width:4%;'>JUMLAH</th>
                    <th class='th01' style='width:4%;'>SATUAN</th>
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
        $nomorUrutSebelumnya = $lastNomorUrut - 1;
        $getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q= '$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and dk ='$dk' and p='$p' and q='$q'"));
        $jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];

      }
      if ($q != "0") {
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='17'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }else{
        $namaProgram = "<td align='left' class='GarisCetak' colspan='17'>".$programKegiatan."</td>";
      }

      if ($q == '0' && $p != '0') {
        $naonkitu = "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaProgram."
                </tr>
      ";
      $no++;
      }elseif ($q != '0' && $f == '00') {
        $naonkitu = "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  ".$namaKegiatan."
                </tr>
      ";
      }else{
        $naonkitu = "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  <td align='left' class='GarisCetak' colspan='1'></td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."</br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$jumlahBarangSebelumnya</td>
                  <td align='left' class='GarisCetak' >$satuan_barang</td>
                  <td align='right' class='GarisCetak'>$kebutuhanMaksimum</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."</br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$jumlahOptimal</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$kebutuhanRill</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$volBar</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' >".$cara_pemenuhan."</td>
                  <td align='left' class='GarisCetak' >".$catatan."</td>
                </tr>
      ";
      }
      echo $naonkitu;
      $naonkitu= "";
      
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
    $getDataPejabatPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PEJABAT'"));
    $getDataPengurusPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGURUS'"));

    if($xls){
        echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP  ".$getDataKuasaPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        ";
        echo " <br> <div >
          <div  >Telah Diperiksa : </div>
          <table table width='100%' class='cetak' border='1' style='margin-left:90px;width:50%;'>
            <tr>
              <th class='th01'>No</th>
              <th class='th01'>Nama</th>
              <th class='th01'>Jabatan</th>
              <th class='th01'>TTD / Paraf</th>
              <th class='th01' >Tanggal</th>
            </tr>
            <tr>
              <td align='center' class='GarisCetak' >1.</td>
              <td align='left' class='GarisCetak' >".$getDataPejabatPenggunaBarang['nama']."</td>
              <td align='left' class='GarisCetak' >Pejabat Penatausahaan Pengguna Barang</td>
              <td align='left' class='GarisCetak' >&nbsp</td>
              <td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
              <td align='center' class='GarisCetak' >2.</td>
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
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));
            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '2' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '2' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));
            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '2' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[titimangsa_surat].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            Disetujui<br>
            $hmm[jabatan]
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
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-2];

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
            <h5 class='pag pag1' style='bottom: -10px; font-size: 9px;'>
              <span style='bottom: 0; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
            </h5>
            <div class='insert'></div>
      ";
      $queryNamaDiperiksa1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '14' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
      $queryNamaDiperiksa2 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '23' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
      $queryKategoriDiperiksa1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '14' "));
      $queryKategoriDiperiksa2 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '23' "));
      echo "<div >
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

function Pengadaan3($xls =FALSE){
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

    $this->fileNameExcel = "RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG";
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
    $getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul ='KOREKSI PENGGUNA'"));
    $lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
    $getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
    $lastNomorUrut = $getLastTahap['no_urut'];
    $arrKondisi = array();
    $grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and p !='0' and q='0'");
    while($rows = mysql_fetch_array($grabProgram)){
      foreach ($rows as $key => $value) {
          $$key = $value;
      }
      if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' $this->kondisiBarang")) == 0){
        $concat = $bk.".".$ck.".".$dk.".".$p;
        $arrKondisi[] = " concat(bk,'.',ck,'.',p) !='$concat'";
      }else{
        if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $this->kondisiBarang")) == 0){
          if($q != '0'){
            $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
          }
        }else{
            $concat = $f.".".$g.".".$h.".".$i.".".$j;
          if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' $this->kondisiBarang")) == 0){
            if($j != '000'){
              $arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
            }
          }
        }
      }
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


    $Kondisi= join(' and ',$arrKondisi);
    if(sizeof($arrKondisi) == 0){
      $Kondisi= '';
    }else{
      $Kondisi = " and ".$Kondisi;
    }
    $qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $this->kondisiBarang $Kondisi order by urut";
    $aqry = mysql_query($qry);
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
          <table class=\"rangkacetak\" style='width: $width; font-family: sans-serif; height: $height;'>
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
                      RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
                      (RENCANA PENGADAAN)<br>
                      KUASA PENGUNA BARANG ".strtoupper($subunit)."<br>
                      <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN ANGGARAN $this->tahun </span>
                    </span>
                  </td>
                </tr>
              </table>

          <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif; margin-bottom: -0.5%;'>

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
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='margin:1 0 0 0;width:100%;'>
                <thead>
                  <tr>
                    <th class='th01' rowspan='2' style='width:20px;' >NO</th>
                    <th class='th01' rowspan='2' >PROGRAM/<br>KEGIATAN/<br>OUTPUT</th>
                    <th class='th02' rowspan='1' colspan='4' >RENCANA KEBUTUHAN BARANG MILIK DAERAH (YANG DISETUJUI)</th>
                    <th class='th01' rowspan='2' style='width: 6%;'>CARA<br>PEMENUHAN</th>
                    <th class='th01' rowspan='2' style='width: 12%;'>KETERANGAN</th>
                  </tr>
                  <tr>
                    <th class='th01' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' style='width: 5%;'>JUMLAH</th>
                    <th class='th01' style='width: 5%;'>SATUAN</th>
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
        $nomorUrutSebelumnya = $lastNomorUrut - 1;
        $getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q= '$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and p='$p' and q='$q'"));
        $jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];

      }
      if ($q != "0") {
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='7'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }else{
        $namaProgram = "<td align='left' class='GarisCetak' colspan='7'>".$programKegiatan."</td>";
      }

      if ($q == '0') {
        $naonkitu = "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaProgram."
                </tr>
      ";
      $no++;
      }elseif ($q != '0' && $f == '00') {
        $naonkitu = "
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
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."&nbsp &nbsp".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$volBar</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' >".$cara_pemenuhan."</td>
                  <td align='left' class='GarisCetak' >".$catatan."</td>
                </tr>
      ";
      }
      echo $naonkitu;
      $naonkitu = "";

      
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
      $cara_pemenuhan = "";



    }
    echo        "</table>";
    $getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));

    if($xls){
      echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP  ".$getDataKuasaPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        </body>
      </html>";
    }else{
      if (sizeof($arrayTandaTangan3)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport3['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));
            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '1' "));

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
            $arrayPosisi = explode(';', $getJenisReport['posisi']);
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
            $arrayPosisi = explode(';', $getJenisReport['posisi']);
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
            <h5 class='pag pag1' style='font-size: 9px; bottom: -10px;'>
              <span style='bottom: 0; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
            </h5>
            <div class='insert'></div>
      </body>
    </html>";
    }
  }

function Pengadaan4($xls =FALSE){
  global $Main;
  $getJenisReport4 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL4' "));
  $getJenisUkuran = $getJenisReport4['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
  $arrayTandaTangan4 = explode(';', $getJenisReport4['tanda_tangan']);

    $this->fileNameExcel = "USULAN RKBMD PENGADAAN PADA PENGGUNA BARANG";
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
    $getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul !='KOREKSI PENGGUNA' and jenis_form_modul !='KOREKSI PENGELOLA' "));
    $lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
    $getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
    $lastNomorUrut = $getLastTahap['no_urut'];
    $getMinJenisForm = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran'"));
    if($getMinJenisForm['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE){
        $kondisiValid = " and status_validasi = '1'";
    }

    $arrKondisi = array();


    $getAllParent = mysql_query("select * from view_rkbmd where  tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and f='00' and q !='0' and id_jenis_pemeliharaan = '0' and c1='$c1' and c='$c'  and d='$d'");
        while($rows = mysql_fetch_array($getAllParent)){
          foreach ($rows as $key => $value) {
           $$key = $value;
          }
          $cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang "));
          if($cekKegiatan == 0){
            $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
            $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk'  and p='$p' and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang"));
            if($cekProgram == 0){
              $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
              $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
              $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang"));
              if($cekSKPD == 0){
                $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
                $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
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
    $qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and uraian_pemeliharaan !='RKBMD PERSEDIAAN'  $this->kondisiBarang $Kondisi order by urut";
    $aqry = mysql_query($qry);
    $getPenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
    $penggunaBarang = $getPenggunaBarang['nm_skpd'];
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
          <table class=\"rangkacetak\" style='width: $width; font-family :sans-serif; height: $height;'>
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
                    <span style='font-size:18px;font-weight:bold; text-transform: uppercase; '>
                      USULAN RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
                      (RENCANA PENGADAAN)<br>
                      PENGUNA BARANG ".$skpd."<br>
                      <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN ANGGARAN $this->tahun </span>
                    </span>
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


        </table>";
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='width:100%;'>
                <thead>
                  <tr>
                    <th class='th01' rowspan='2' style='width:20px;' >NO</th>
                    <th class='th01' rowspan='2' >PROGRAM/<br>KEGIATAN/<br>OUTPUT</th>
                    <th class='th02' rowspan='1' colspan='4' >USULAN BMD</th>
                    <th class='th02' rowspan='1' colspan='2' >KEBUTUHAN MAKSIMUM</th>
                    <th class='th02' rowspan='1' colspan='4' >DATA DAFTAR BARANG YANG DAPAT DI OPTIOMALISASIKAN</th>
                    <th class='th02' rowspan='1' colspan='2' >KEBUTUHAN RIIL BMD</th>
                    <th class='th01' rowspan='2' >KETERANGAN</th>
                  </tr>
                  <tr>
                    <th class='th01' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' >JUMLAH</th>
                    <th class='th01' >SATUAN</th>
                    <th class='th01' >JUMLAH</th>
                    <th class='th01' >SATUAN</th>
                    <th class='th01' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' >JUMLAH</th>
                    <th class='th01' >SATUAN</th>
                    <th class='th01' >JUMLAH</th>
                    <th class='th01' >SATUAN</th>
                  </tr>
                  </thead>
    ";

    $no = 1;
    while($daqry = mysql_fetch_array($aqry)){
      foreach ($daqry as $key => $value) {
          $$key = $value;
      }
      $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
      if($p == '0'){
        $getNamaSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
        $programKegiatan = "<span style='font-weight:bold; '>".$getNamaSkpd['nm_skpd']."</span>";

      }elseif($p !='0' && $q == '0' && $j =='000'){
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

        $nomorUrutSebelumnya = $lastNomorUrut + 1;
        $getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q= '$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and p='$p' and q='$q'"));
        $jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];
      }

      if ($p == '0') {
        $namaProgram = "<td align='left' class='GarisCetak' colspan='14'>".$programKegiatan."</td>";

      }elseif($p !='0' && $q == '0' && $j =='000'){
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='14'>".$programKegiatan." </td>";

      }elseif($q !='0' && $j =='000'){
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan2 = "<td align='left' style='padding-left: 15px;' class='GarisCetak' colspan='14'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }

      if ($p =='0' && $q == '0' && $j =='000') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaProgram."
                </tr>
      ";
      }elseif ($p !='0' && $q == '0' && $j =='000') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaKegiatan."
                </tr>
      ";
      }elseif($q !='0' && $j =='000'){
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaKegiatan2."
                </tr>
      ";
      }else{
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  <td align='left' class='GarisCetak' colspan='1'></td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."</br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$jumlahBarangSebelumnya</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$kebutuhanMaksimum</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."</br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$jumlahOptimal</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$kebutuhanRill</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' >".$catatan."</td>
                </tr>
      ";
      }

      echo $naonkitu;
      $naonkitu = "";
      $no++;
      $volBar = "";
      $jumlahBarangSebelumnya = "";
      $kebutuhanMaksimum = "";
      $jumlahOptimal = "";
      $kebutuhanRill = "";
      $namaBarang = "";
      $kodeBarang = "";



    }
    echo        "</table>";
    $getDataPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGGUNA' "));

    if($xls){
      echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'><u>".$getDataPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>NIP ".$getDataPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        </body>
      </html>";
    }else{
      if (sizeof($arrayTandaTangan4)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport4['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));
            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '1' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $queryKategori1[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$hmm['nama']."</u><br>
            NIP ".$hmm['nip']."


            </div>";

          }elseif (sizeof($arrayTandaTangan4)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport4['posisi']);
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

          }elseif (sizeof($arrayTandaTangan4)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport4['posisi']);
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
function Pengadaan5($xls =FALSE){
    global $Main;
    $getJenisReport5 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL5' "));
    $getJenisUkuran = $getJenisReport5['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTangan5 = explode(';', $getJenisReport5['tanda_tangan']);

    $this->fileNameExcel = "HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGELOLA BARANG";
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
    $getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul ='KOREKSI PENGGUNA'"));
    $lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
    $getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
    $lastNomorUrut = $getLastTahap['no_urut'];
    $arrKondisi = array();

    $getAllParent = mysql_query("select * from view_rkbmd where  tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and f='00' and q !='0' and id_jenis_pemeliharaan = '0' and c1='$c1' and c='$c'  and d='$d' ");
        while($rows = mysql_fetch_array($getAllParent)){
          foreach ($rows as $key => $value) {
           $$key = $value;
          }
          $cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang "));
          if($cekKegiatan == 0){
            $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
            $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang"));
            if($cekProgram == 0){
              $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
              $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
              $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang"));
              if($cekSKPD == 0){
                $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
                $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
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
    $qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and uraian_pemeliharaan !='RKBMD PERSEDIAAN'   $this->kondisiBarang $Kondisi order by urut";
    $aqry = mysql_query($qry);
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
            .GarisCetak1{
              padding: 17px;
              border: 1px solid #000;
            }
          </style>
        </head>".
      "<body >
        <div style='width:$this->Cetak_WIDTH_Landscape;'>
          <table class=\"rangkacetak\" style='width: $width; font-family: sans-serif; height: $height;'>
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
                      HASIL PENELAAHAN RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
                      (RENCANA PENGADAAN)<br>
                      PENGUNA BARANG ".$skpd."<br>
                      <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN ANGGARAN $this->tahun </span>
                    </span>
                  </td>
                </tr>
              </table>


        <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif; margin-bottom: -0.5%;'>

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



        </table>"
                ;
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='width:100%; margin: 1 0 0 0;'>
                <thead>
                  <tr>
                    <th class='th01' rowspan='3' style='width:20px;' >NO</th>
                    <th class='th02' rowspan='1' colspan='5' >USULAN RKBMD</th>
                    <th class='th02' rowspan='1' colspan='2' >KEBUTUHAN MAKSIMUM</th>
                    <th class='th02' rowspan='1' colspan='4' >DATA DAFTAR BARANG YANG DAPAT DIOPTIMALKAN</th>
                    <th class='th02' rowspan='1' colspan='2' >KEBUTUHAN RILL BARANG MILIK DAERAH</th>
                    <th class='th02' rowspan='2' colspan='2' >RENCANA KEBUTUHAN PENGADAAN BMD YANG DISETUJUI</th>
                    <th class='th01' rowspan='3'  >CARA PEMENUHAN</th>
                    <th class='th01' rowspan='3'  >KETERANGAN</th>
                  </tr>
                  <tr>
                    <th class='th01' rowspan='2'>PROGRAM/<br>KEGIATAN/<br>OUTPUT</th>
                    <th class='th01' rowspan='2' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' rowspan='2'>JUMLAH</th>
                    <th class='th01' rowspan='2'>SATUAN</th>
                    <th class='th01' rowspan='2'>JUMLAH</th>
                    <th class='th01' rowspan='2'>SATUAN</th>
                    <th class='th01' rowspan='2' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' rowspan='2'>JUMLAH</th>
                    <th class='th01' rowspan='2'>SATUAN</th>
                    <th class='th01' rowspan='2'>JUMLAH</th>
                    <th class='th01' rowspan='2'>SATUAN</th>
                  </tr>
                  <tr>
                    <th class='th01' >JUMLAH</th>
                    <th class='th01' >SATUAN</th>
                  </tr>
                  </thead>

    ";

    $no = 1;
    while($daqry = mysql_fetch_array($aqry)){
      foreach ($daqry as $key => $value) {
          $$key = $value;
      }
      $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
      if($p == '0'){
        $getNamaSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
        $programKegiatan = "<span style='font-weight:bold; '>".$getNamaSkpd['nm_skpd']."</span>";

      }elseif($p !='0' && $q == '0' && $j =='000'){
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

        $nomorUrutSebelumnya = $lastNomorUrut + 1;
        $getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q= '$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and p='$p' and q='$q'"));
        $jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];

      }
      if ($p == '0') {
        $namaProgram = "<td align='left' class='GarisCetak' colspan='17'>".$programKegiatan."</td>";

      }elseif($p !='0' && $q == '0' && $j =='000'){
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='17'>".$programKegiatan." </td>";

      }elseif($q !='0' && $j =='000'){
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan2 = "<td align='left' style='padding-left: 15px;' class='GarisCetak' colspan='17'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }

      if ($p =='0' && $q == '0' && $j =='000') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaProgram."
                </tr>
      ";
      }elseif ($p !='0' && $q == '0' && $j =='000') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaKegiatan."
                </tr>
      ";
      }elseif ($q !='0' && $j =='000') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaKegiatan2."
                </tr>
      ";
      }else{
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  <td align='left' class='GarisCetak' colspan='1'></td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."</br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$volBar</td>
                  <td align='left' class='GarisCetak' >$satuan_barang</td>
                  <td align='right' class='GarisCetak'>$kebutuhanMaksimum</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."</br>".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$jumlahOptimal</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$kebutuhanRill</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='right' class='GarisCetak'>$jumlahBarangSebelumnya</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' >".$cara_pemenuhan."</td>
                  <td align='left' class='GarisCetak' >".$catatan."</td>
                </tr>
      ";
      }

      echo $naonkitu;
      $naonkitu = "";

      $no++;
      $volBar = "";
      $jumlahBarangSebelumnya = "";
      $kebutuhanMaksimum = "";
      $jumlahOptimal = "";
      $kebutuhanRill = "";
      $kodeBarang = "";
      $namaBarang = "";





    }
    echo        "</table>";
    if($xls){
      echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'><u>".$getDataPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>NIP ".$getDataPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        ";

    echo "
          <div >Telah Diperiksa : </div>
          <table table width='100%' class='cetak' border='1' style='margin-left:90px;width:50%;'>
            <tr>
              <th class='th01'>No</th>
              <th class='th01'>Nama</th>
              <th class='th01'>Jabatan</th>
              <th class='th01'>TTD / Paraf</th>
              <th class='th01'>Tanggal</th>
            </tr>
            <tr>
              <td align='right' class='GarisCetak' >1.</td>
              <td align='left' class='GarisCetak' >$this->pejabatPengelolaBarang</td>
              <td align='left' class='GarisCetak' >Pejabat Penatausahaan Barang</td>
              <td align='left' class='GarisCetak' >&nbsp</td>
              <td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
              <td align='right' class='GarisCetak' >2.</td>
              <td align='left' class='GarisCetak' >$this->pengurusPengelolaBarang</td>
              <td align='left' class='GarisCetak' >Pengurus Barang Pengelola</td>
              <td align='left' class='GarisCetak' >&nbsp</td>
              <td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
          </tabel>
      </body>
    </html>";

    }else{
      if (sizeof($arrayTandaTangan5)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport5['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '2' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '2' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));
            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '2' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));

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

          }elseif (sizeof($arrayTandaTangan5)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport5['posisi']);
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

          }elseif (sizeof($arrayTandaTangan5)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport5['posisi']);
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
    echo "
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
function Pengadaan6($xls =FALSE){
    global $Main;
    $getJenisReport6 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL6' "));
    $getJenisUkuran = $getJenisReport6['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTangan6 = explode(';', $getJenisReport6['tanda_tangan']);

    $this->fileNameExcel = "RKBMD PENGADAAN PADA PENGGUNA BARANG";
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
    $getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d'  and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul ='KOREKSI PENGELOLA'"));
    $lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
    $getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
    $lastNomorUrut = $getLastTahap['no_urut'];
    $arrKondisi = array();
    $getAllParent = mysql_query("select * from view_rkbmd where  tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and f='00' and q !='0'  and id_jenis_pemeliharaan = '0' and c1='$c1' and c='$c'  and d='$d'");
        while($rows = mysql_fetch_array($getAllParent)){
          foreach ($rows as $key => $value) {
           $$key = $value;
          }
          $cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang  "));
          if($cekKegiatan == 0){
            $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',p,'.',q) != '$concat'";
            $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang"));
            if($cekProgram == 0){
              $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
              $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
              $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->nomorUrut' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang"));
              if($cekSKPD == 0){
                $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
                $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
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
    $qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and uraian_pemeliharaan !='RKBMD PERSEDIAAN' $this->kondisiBarang  $Kondisi order by urut";
    $aqry = mysql_query($qry);
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
          <table class=\"rangkacetak\" style='width: $width; height: $height; font-family: sans-serif;'>
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
                      RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
                      (RENCANA PENGADAAN)<br>
                      PENGUNA BARANG ".$skpd."<br>
                      <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN : $this->tahun </span>
                    </span>
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



        </table>";
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='width:100%; margin: 1 0 0 0;'>
                <thead>
                  <tr>
                    <th class='th01' rowspan='2' style='width:20px;' >NO</th>
                    <th class='th01' rowspan='2' style='width: 14%;'>KUASA PENGGUNA BARANG/<br>PROGRAM/<br>KEGIATAN/<br>OUTPUT</th>
                    <th class='th02' rowspan='1' colspan='4' >RENCANA KEBUTUHAN BARANG MILIK DAERAH</th>
                    <th class='th01' rowspan='2' style='width: 7%;'>CARA<br>PEMENUHAN</th>
                    <th class='th01' rowspan='2' >KETERANGAN</th>

                  </tr>
                  <tr>
                    <th class='th01' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' style='width: 4%;'>JUMLAH</th>
                    <th class='th01' style='width: 4%;'>SATUAN</th>
                  </tr>
                </thead>


    ";

    $no = 1;
    while($daqry = mysql_fetch_array($aqry)){
      foreach ($daqry as $key => $value) {
          $$key = $value;
      }
      $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
      if($p == '0'){
        $getNamaSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
        $programKegiatan = "<span style='font-weight:bold; '>".$getNamaSkpd['nm_skpd']."</span>";

      }elseif($p !='0' && $q == '0' && $j =='000'){
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
        $nomorUrutSebelumnya = $lastNomorUrut - 1;
        $getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q= '$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and p='$p' and q='$q'"));
        $jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];

      }
      // if ($p == '0') {
   //      $namaProgram = "<td align='left' class='GarisCetak' >".$programKegiatan."</td>";
   //    }elseif ($p !='0' && $q == '0' && $j =='000') {
   //      $namaProgram = "<td align='left' class='GarisCetak' style='padding-left: 10px;'>".$programKegiatan."</td>";
   //    }else{
   //      $namaProgram = "<td align='left' class='GarisCetak' style='padding-left: 15px;'>".$programKegiatan."</td>";
   //    }
      if ($p == '0') {
        $namaProgram = "<td align='left' class='GarisCetak' colspan='7'>".$programKegiatan."</td>";

      }elseif($p !='0' && $q == '0' && $j =='000'){
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='7'>".$programKegiatan." </td>";

      }elseif($q !='0' && $j =='000'){
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan2 = "<td align='left' style='padding-left: 15px;' class='GarisCetak' colspan='7'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
      }

      if ($p =='0' && $q == '0' && $j =='000') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaProgram."
                </tr>
      ";
      }elseif ($p !='0' && $q == '0' && $j =='000') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaKegiatan."
                </tr>
      ";
      }elseif ($q !='0' && $j =='000') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  ".$namaKegiatan2."
                </tr>
      ";
      }else{
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'>$no</td>
                  <td align='left' class='GarisCetak' colspan='1'></td>
                  <td align='left' class='GarisCetak' colspan='2'>".$namaBarang." ".$kodeBarang."</td>
                  <td align='right' class='GarisCetak'>$volBar</td>
                  <td align='left' class='GarisCetak' >".$satuan_barang."</td>
                  <td align='left' class='GarisCetak' >".$cara_pemenuhan."</td>
                  <td align='left' class='GarisCetak' >".$catatan."</td>
                </tr>
      ";
      }
      echo $naonkitu;
      $naonkitu = "";
      $volBar = "";
      $jumlahBarangSebelumnya = "";
      $no++;
      $kodeBarang = "";
      $namaBarang = "";




    }
    echo        "</table>";
    $getDataPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGGUNA' "));

    if($xls){
      echo
            "<br><div class='ukurantulisan' align='right'>
            <table align='right'>
            <tr>
            <td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
            </tr>
            <tr>
            <td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>Kuasa Pengguna Barang</td>
            </tr>
            <tr>
            <td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
            </tr>
            <tr>
            <td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'><u>".$getDataPenggunaBarang['nama']."</u></td>
            </tr>
            <tr>
            <td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>NIP  ".$getDataPenggunaBarang['nip']."</td>
            </tr>
            </table>
            </div>
        ";
    }else{
      if (sizeof($arrayTandaTangan6)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport6['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '1' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));
            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '1' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$namaPemda[option_value].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $queryKategori1[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$hmm['nama']."</u><br>
            NIP ".$hmm['nip']."


            </div>";

          }elseif (sizeof($arrayTandaTangan6)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport6['posisi']);
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

          }elseif (sizeof($arrayTandaTangan6)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport6['posisi']);
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
}
$koreksiPengadaanNew = new koreksiPengadaanNewObj();
$arrayResult = tahapKoreksi("KOREKSI PENGGUNA","MURNI");
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = "MURNI";
$idTahap = $arrayResult['idTahap'];

$koreksiPengadaanNew->jenisForm = $jenisForm;
$koreksiPengadaanNew->nomorUrut = $nomorUrut;
$koreksiPengadaanNew->urutTerakhir = $nomorUrut;
$koreksiPengadaanNew->tahun = $tahun;
$koreksiPengadaanNew->jenisAnggaran = $jenisAnggaran;
$koreksiPengadaanNew->idTahap = $idTahap;
$koreksiPengadaanNew->username = $_COOKIE['coID'];
$koreksiPengadaanNew->wajibValidasi = $arrayResult['wajib_validasi'];
if($koreksiPengadaanNew->wajibValidasi == TRUE){
  $koreksiPengadaanNew->sqlValidasi = " and status_validasi ='1' ";
}else{
  $koreksiPengadaanNew->sqlValidasi = " ";
}

$koreksiPengadaanNew->provinsi = $arrayResult['provinsi'];
$koreksiPengadaanNew->kota = $arrayResult['kota'];
$koreksiPengadaanNew->pengelolaBarang = $arrayResult['pengelolaBarang'];
$koreksiPengadaanNew->pejabatPengelolaBarang = $arrayResult['pejabat'];
$koreksiPengadaanNew->pengurusPengelolaBarang = $arrayResult['pengurus'];
$koreksiPengadaanNew->nipPengelola = $arrayResult['nipPengelola'];
$koreksiPengadaanNew->nipPengurus = $arrayResult['nipPengurus'];
$koreksiPengadaanNew->nipPejabat = $arrayResult['nipPejabat'];
?>