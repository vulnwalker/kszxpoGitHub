<?php

class koreksiPengelolaPengadaanNewObj  extends DaftarObj2{
  var $Prefix = 'koreksiPengelolaPengadaanNew';
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
  var $PageTitle = 'RKBMD PENGADAAN PENGELOLA BARANG';
  var $PageIcon = 'images/perencanaan_ico.png';
  var $pagePerHal ='';
  var $cetak_xls=TRUE ;
  var $fileNameExcel='usulansk.xls';
  var $Cetak_Judul = 'Daftar Standar Kebutuhan Barang Maksimal';
  var $Cetak_Mode=2;
  var $Cetak_WIDTH = '30cm';
  var $Cetak_OtherHTMLHead;
  var $FormName = 'koreksiPengelolaPengadaanNewForm';
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
  var $reportURL4 = "pages.php?Pg=koreksiPengadaanNew&tipe=Pengadaan4";
  var $reportURL5 = "pages.php?Pg=koreksiPengadaanNew&tipe=Pengadaan5";
  var $reportURL6 = "pages.php?Pg=koreksiPengadaanNew&tipe=Pengadaan6";
  var $reportURL7 = "pages.php?Pg=koreksiPengelolaPengadaanNew&tipe=Pengadaan7";
  var $statusPenetapan ="";

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
      $dt['c1'] = $_REQUEST[$this->Prefix.'koreksiPengelolaPengadaanSkpdfmUrusan'];
      $dt['c'] = $_REQUEST[$this->Prefix.'koreksiPengelolaPengadaanSkpdfmSKPD'];
      $dt['d'] = $_REQUEST[$this->Prefix.'koreksiPengelolaPengadaanSkpdfmUNIT'];
      $dt['e'] = $_REQUEST[$this->Prefix.'koreksiPengelolaPengadaanSkpdfmSUBUNIT'];
      $dt['e1'] = $_REQUEST[$this->Prefix.'koreksiPengelolaPengadaanSkpdfmSEKSI'];
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
    $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '3' "));
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
          $jenisKegiatan = $_REQUEST['jenisKegiatan'];
            if($jenisKegiatan == "Pengadaan4" || $jenisKegiatan == "Pengadaan6"){
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

  //untuk view
  function setTitle(){
    return 'RKBMD PENGADAAN PENGELOLA BARANG';
  }
  function setPage_Header($IconPage='', $TitlePage=''){

    return createHeaderPage($this->PageIcon, "RKBMD PENGADAAN $this->jenisAnggaran TAHUN $this->tahun");
  }
  function setMenuEdit(){
      if ($this->jenisForm == "PENYUSUNAN"){
        $listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".InputBaru()","sections.png","Baru ", 'Baru ')."</td>".
              "<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
              "<td>".genPanelIcon("javascript:".$this->Prefix.".remove()","delete_f2.png","Hapus", 'Hapus')."</td>".

        "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
       }elseif ($this->jenisForm == "KOREKSI PENGGUNA"){
        $listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
         }elseif ($this->jenisForm == "KOREKSI PENGELOLA"){
        $listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
         }else{
        $listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
       }
        $listMenu .=  "<td>".genPanelIcon("javascript:".$this->Prefix.".excel()","export_xls.png","Excell", 'Excell')."</td>";

     return $listMenu;
  }
  function setPage_HeaderOther(){
      return
    "<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
    <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
    <A href=\"pages.php?Pg=renjaAset\" title='MURNI' style='color : blue;' > MURNI </a> |
    <A href=\"pages.php?Pg=renjaAsetPerubahan\" title='PERUBAHAN' > PERUBAHAN </a>

    &nbsp&nbsp&nbsp
    </td></tr>
    <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
    <A href=\"pages.php?Pg=renjaAset\" title='RENJA'  > RENJA </a> |
    <A href=\"pages.php?Pg=rkbmdPengadaan_v3\" title='RKBMD'   > RKBMD </a> |
    <A href=\"pages.php?Pg=koreksiPengelolaPengadaanNew\" title='RKBMD PENGELOLA'  style='color : blue;'> RKBMD PENGELOLA </a> |
    <A href=\"pages.php?Pg=penetapanRKBMDPengadaan\" title='RKBMD PENGELOLA' > PENETAPAN RKBMD </a>

    &nbsp&nbsp&nbsp
    </td></tr>

    <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
    <A href=\"pages.php?Pg=koreksiPengelolaPengadaanNew\" title='RKBMD'  style='color : blue;' > PENGADAAN </a> |
    <A href=\"pages.php?Pg=koreksiPengelolaPemeliharaan\" title='RKBMD PENGELOLA' > PEMELIHARAAN </a> |
    <A href=\"pages.php?Pg=koreksiPengelolaPersediaan\" title='RKBMD PERSEDIAAN' > PERSEDIAAN </a>

    &nbsp&nbsp&nbsp
    </td></tr>


    </table>";
  }


    function setMenuView(){
    return
      "<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";

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

  //function setPage_IconPage(){    return 'images/masterData_ico.gif'; }

  function set_selector_other2($tipe){
   global $Main;
   $cek = ''; $err=''; $content=''; $json=TRUE;

   return array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
  }

  function set_selector_other($tipe){
   global $Main;
   $cek = ''; $err=''; $content=''; $json=TRUE;

    switch($tipe){
    case 'excel':{
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
       /*if($koreksiPengelolaPengadaanNewSkpdfmUrusan =='0'){
        $err = "Pilih Urusan";
       }elseif($koreksiPengelolaPengadaanNewSkpdfmSKPD =='00'){
        $err = "Pilih Bidang";
       }elseif($koreksiPengelolaPengadaanNewSkpdfmUNIT =='00'){
        $err = "Pilih SKPD";
       }elseif($koreksiPengelolaPengadaanNewSkpdfmSUBUNIT =='00'){
        $err = "Pilih Unit";
       }elseif($koreksiPengelolaPengadaanNewSkpdfmSEKSI =='000'){
        $err = "Pilih Sub Unit";
       }else{*/
        $fm = $this->excel($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
       /*}*/

      break;

    }
    case 'jenisChanged':{
        $jenisKegiatan = $_REQUEST['jenisKegiatan'];
        if($jenisKegiatan == "Pengadaan4" || $jenisKegiatan == "Pengadaan6"){
          $kategorinaey = 1;
        }else{
          $kategorinaey = 2;
        }
      $content = array('ttd' => cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = $kategorinaey and c1 = '".$_REQUEST[c1]."' and c = '".$_REQUEST[c]."' and d = '".$_REQUEST[d]."' and e = '".$_REQUEST[e]."' and e1 = '".$_REQUEST[e1]."' ",'-- TTD --') ) ;
      break;
        }
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
       $cekKeberadaanMangkluk =  mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$koreksiPengelolaPengadaanNewSkpdfmUrusan' and c = '$koreksiPengelolaPengadaanNewSkpdfmSKPD' and d='$koreksiPengelolaPengadaanNewSkpdfmUNIT' and e = '$koreksiPengelolaPengadaanNewSkpdfmSUBUNIT' and e1='$koreksiPengelolaPengadaanNewSkpdfmSEKSI'  and q!='0' and no_urut ='$nomorUrutSebelumnya' "));
       $getDatarenja = mysql_fetch_array(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$koreksiPengelolaPengadaanNewSkpdfmUrusan' and c = '$koreksiPengelolaPengadaanNewSkpdfmSKPD' and d='$koreksiPengelolaPengadaanNewSkpdfmUNIT' and e = '$koreksiPengelolaPengadaanNewSkpdfmSUBUNIT' and e1='$koreksiPengelolaPengadaanNewSkpdfmSEKSI' and q!='0' and no_urut = '$nomorUrutSebelumnya'"));
       $lastID = $getDatarenja['id_anggaran'];
        if($cekKeberadaanMangkluk != 0){
          if($getDatarenja['jenis_form_modul']  == 'PENYUSUNAN' ){
            $getJumlahRenjaValidasi = mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$koreksiPengelolaPengadaanNewSkpdfmUrusan' and c = '$koreksiPengelolaPengadaanNewSkpdfmSKPD' and d='$koreksiPengelolaPengadaanNewSkpdfmUNIT' and e = '$koreksiPengelolaPengadaanNewSkpdfmSUBUNIT' and e1='$koreksiPengelolaPengadaanNewSkpdfmSEKSI' and q!='0' $this->sqlValidasi and no_urut = '$nomorUrutSebelumnya'"));
            if($getJumlahRenjaValidasi == 0){
              $err = "Renja Belum Di Validasi";
            }
          }

          $getParentkoreksiPengelolaPengadaanNew = mysql_fetch_array(mysql_query("select * from view_renja where id_anggaran = '$lastID'"));
          $parentC1 = $getParentkoreksiPengelolaPengadaanNew['c1'];
          $parentC = $getParentkoreksiPengelolaPengadaanNew['c'];
          $parentD = $getParentkoreksiPengelolaPengadaanNew['d'];
          $parentE = $getParentkoreksiPengelolaPengadaanNew['e'];
          $parentE1= $getParentkoreksiPengelolaPengadaanNew['e1'];
          $getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentE' and e1 = '$parentE1' and p = '0' and q = '0' and no_urut = '$nomorUrutSebelumnya' "));
          $idrenja = $getIdRenja['id_anggaran'];
          if($cmbJeniskoreksiPengelolaPengadaanNew == 'PENGADAAN'){
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
       $id = $_REQUEST['koreksiPengelolaPengadaanNew_cb'];
      foreach ($_REQUEST as $key => $value) {
          $$key = $value;
       }
          $nomorUrutSebelumnya = $this->nomorUrut - 1;
          $getParentkoreksiPengelolaPengadaanNew = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran = '$id[0]'"));
          foreach ($getParentkoreksiPengelolaPengadaanNew as $key => $value) {
             $$key = $value;
           }
          $parentC1 = $getParentkoreksiPengelolaPengadaanNew['c1'];
          $parentC = $getParentkoreksiPengelolaPengadaanNew['c'];
          $parentD = $getParentkoreksiPengelolaPengadaanNew['d'];
          $parentE = $getParentkoreksiPengelolaPengadaanNew['e'];
          $parentE1= $getParentkoreksiPengelolaPengadaanNew['e1'];
          $getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentE' and e1 = '$parentE1' and p = '0' and q = '0' and no_urut = '$nomorUrutSebelumnya' "));
          $idrenja = $getIdRenja['id_anggaran'];
          if($cmbJeniskoreksiPengelolaPengadaanNew == 'PENGADAAN'){
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
       /*if($koreksiPengelolaPengadaanNewSkpdfmUrusan =='0'){
        $err = "Pilih Urusan";
       }elseif($koreksiPengelolaPengadaanNewSkpdfmSKPD =='00'){
        $err = "Pilih Bidang";
       }elseif($koreksiPengelolaPengadaanNewSkpdfmUNIT =='00'){
        $err = "Pilih SKPD";
       }elseif($koreksiPengelolaPengadaanNewSkpdfmSUBUNIT =='00'){
        $err = "Pilih Unit";
       }elseif($koreksiPengelolaPengadaanNewSkpdfmSEKSI =='000'){
        $err = "Pilih Sub Unit";
       }else{*/
        $fm = $this->Laporan($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
       /*}*/

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
       $getSKPD = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$koreksiPengelolaPengadaanNew_idplh'"));
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
       $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$koreksiPengelolaPengadaanNew_idplh'");
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
      $id = $_REQUEST['koreksiPengelolaPengadaanNew_cb'];
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
      $getkoreksiPengelolaPengadaanNewnya = mysql_fetch_array(mysql_query($queryRows));
      foreach ($getkoreksiPengelolaPengadaanNewnya as $key => $value) {
          $$key = $value;
      }

      $nextNomorUrut = $this->nomorUrut + 2;
      if($this->jenisForm !='KOREKSI PENGGUNA' && $this->jenisForm !='KOREKSI PENGELOLA'){
        $err = "Tahap Koreksi Telah Habis";
      }elseif($this->statusPenetapan != 0){
        $err = "RKBMD TELAH DI TETAPKAN";
      }elseif(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '3' and tahun ='$this->tahun' and jenis_anggaran ='PERUBAHAN' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'")) != 0){
        $err = "Data Yang Telah Masuk RKBMD PERUBAHAN";
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
            if($angkaKoreksi <= $kebutuhanRiil || (empty($jumlahOptimal) && empty($kebutuhanMax) && $getkoreksiPengelolaPengadaanNewnya['volume_barang'] >= $angkaKoreksi )  ){
              mysql_query("update tabel_anggaran set volume_barang = '$angkaKoreksi' , cara_pemenuhan = '$caraPemenuhan' where id_anggaran='$idnya'");
            }elseif($getkoreksiPengelolaPengadaanNewnya['volume_barang'] < $angkaKoreksi){
              $err = "Jumlah Koreksi Tidak Melebihi Pengajuan";
            }else{
              $err = "Tidak dapat melebihi $melebihi";
            }

      }else{
            if($angkaKoreksi <= $kebutuhanRiil || (empty($jumlahOptimal) && empty($kebutuhanMax) ) && $getkoreksiPengelolaPengadaanNewnya['volume_barang'] >= $angkaKoreksi ){
              mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
              /*$dugDung = array('status_validasi' => '1');
              mysql_query(VulnWalkerUpdate("tabel_anggaran",$dugDung, " id_anggaran = '$idAwal'" ));*/
            }elseif($getkoreksiPengelolaPengadaanNewnya['volume_barang'] < $angkaKoreksi){
              $err = "Jumlah Koreksi Tidak Melebihi Pengajuan";
            }else{
              $err = "Tidak dapat melebihi $melebihi";

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
       "<script type='text/javascript' src='js/perencanaan_v3/rkbmd/koreksiPengelolaPengadaanNew.js' language='JavaScript' ></script>".
      $scriptload;
  }

  //daftar =================================
  function setKolomHeader($Mode=1, $Checkbox=''){
   $NomorColSpan = $Mode==1? 2: 1;
/*    $nomorUrutSebelumnya = $this-> -1;*/
    if($this->jenisForm == "PENYUSUNAN"){

          if($this->wajibValidasi == TRUE){
            $tergantung = "<th class='th01' align='center' rowspan='2' colspan='1' width='200'>VALIDASI</th>";
          }

          $headerTable =
           "<thead>
           <tr>
               <th class='th01'  rowspan='2' colspan='1' width='20' >No.</th>
               $Checkbox
             <th class='th01' align='center' rowspan='2' colspan='1' width='500'>SKPD/PROGRAM/KEGIATAN/OUTPUT</th>
               <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN BMD</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>JML RIIL</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>JML MAX</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>JML OPTIMAL</th>
              <th class='th01' align='center' rowspan='2' colspan='1' width='200'>KETERANGAN</th>
             $tergantung
             </tr>
             <tr>
                <th class='th01' align='center'  width='600'>NAMA BARANG</th>
              <th class='th01' align='center'  width='200'>JUMLAH</th>
                <th class='th01' align='center'  width='200'>SATUAN</th>

             </tr>
             </thead>";

    }elseif($this->jenisForm == "KOREKSI PENGGUNA"){
      $nomorUrutSebelumnya = $this->nomorUrut - 1;
      $getJenisFormSebelumnya = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran = '$this->jenisAnggaran'"));
      $jenisFormSebelumnya = $getJenisFormSebelumnya['jenis_form_modul'];
          $headerTable =
           "<thead>
           <tr>
               <th class='th01'  rowspan='2' colspan='1' width='20' >No.</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>SKPD/PROGRAM/KEGIATAN/OUTPUT</th>
               <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN BMD</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='50'>JML RIIL</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='50'>JML MAX</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='50'>JML OPTIMAL</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>KETERANGAN</th>
             <th class='th02' align='center' rowspan='1' colspan='2' width='200'>DISETUJUI PENGGUNA</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='300'>AKSI</th>
             </tr>
             <tr>
                <th class='th01' align='center'  width='400'>NAMA BARANG</th>
              <th class='th01' align='center'  width='50'>JUMLAH</th>
                <th class='th01' align='center'  width='50'>SATUAN</th>
              <th class='th01' align='center'  width='50'>JUMLAH</th>
              <th class='th01' align='center'  width='200'>CARA PEMENUHAN</th>
             </tr>
             </thead>";





    }

    elseif($this->jenisForm == "KOREKSI PENGELOLA"){
      $nomorUrutSebelumnya = $this->nomorUrut - 1;
      $getJenisFormSebelumnya = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran = '$this->jenisAnggaran'"));
      $jenisFormSebelumnya = $getJenisFormSebelumnya['jenis_form_modul'];

          $headerTable =
           "<thead>
           <tr>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>SKPD/PROGRAM/KEGIATAN/OUTPUT</th>
               <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN BMD</th>

             <th class='th01' align='center' rowspan='2' colspan='1' width='50'>JML MAX</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='50'>JML OPTIMAL</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='50'>JML RIIL</th>
             <th class='th02' align='center' rowspan='1' colspan='2' width='100'>DISETUJUI PENGGUNA</th>
             <th class='th02' align='center' rowspan='1' colspan='2' width='100'>DISETUJUI PENGELOLA</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='100'>KOREKSI PENGELOLA</th>
             </tr>
             <tr>
                <th class='th01' align='center'  width='1000'>NAMA BARANG</th>
              <th class='th01' align='center'  width='80'>JML</th>
                <th class='th01' align='center'  width='100'>SATUAN</th>
              <th class='th01' align='center'  width='80'>JUMLAH</th>
              <th class='th01' align='center'  width='100'>CARA PEMENUHAN</th>
              <th class='th01' align='center'  width='80'>JML</th>
              <th class='th01' align='center'  width='100'>CARA PEMENUHAN</th>
             </tr>
             </thead>";




    }
    //KOREKSI PENGGUNA
    //view
    else{
      if($this->jenisFormTerakhir == "PENYUSUNAN"){
          if($this->wajibValidasi == TRUE){
            $tergantung = "<th class='th01' align='center' rowspan='2' colspan='1' width='200'>VALIDASI</th>";
          }
          $headerTable =
           "<thead>
           <tr>
               <th class='th01'  rowspan='2' colspan='1' width='20' >No.</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='500'>SKPD/PROGRAM/KEGIATAN/OUTPUT</th>
               <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN BMD</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>JML RIIL</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>JML MAX</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>JML OPTIMAL</th>
              <th class='th01' align='center' rowspan='2' colspan='1' width='200'>KETERANGAN</th>
             $tergantung
             </tr>
             <tr>
                <th class='th01' align='center'  width='600'>NAMA BARANG</th>
              <th class='th01' align='center'  width='200'>JUMLAH</th>
                <th class='th01' align='center'  width='200'>SATUAN</th>

             </tr>
             </thead>";

      }elseif($this->jenisFormTerakhir == "KOREKSI PENGGUNA"){
          $headerTable =
           "<thead>
           <tr>
               <th class='th01'  rowspan='2' colspan='1' width='20' >No.</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='400'>SKPD/PROGRAM/KEGIATAN/OUTPUT</th>
               <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN BMD</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JML RIIL</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JML MAX</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JML OPTIMAL</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>KETERANGAN</th>
             <th class='th02' align='center' rowspan='1' colspan='2' width='200'>DISETUJUI PENGGUNA</th>
             </tr>
             <tr>
                <th class='th01' align='center'  width='400'>NAMA BARANG</th>
              <th class='th01' align='center'  width='100'>JUMLAH</th>
                <th class='th01' align='center'  width='100'>SATUAN</th>
              <th class='th01' align='center'  width='100'>JUMLAH</th>
              <th class='th01' align='center'  width='200'>CARA PEMENUHAN</th>
             </tr>
             </thead>";

      }
      elseif($this->jenisFormTerakhir =="KOREKSI PENGELOLA"){
          $headerTable =
           "<thead>
           <tr>
               <th class='th01'  rowspan='2' colspan='1' width='20' >No.</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='500'>SKPD/PROGRAM/KEGIATAN/OUTPUT</th>
               <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN BMD</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>JML RIIL</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>JML MAX</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>JML OPTIMAL</th>
             <th class='th01' align='center' rowspan='2' colspan='1' width='200'>KETERANGAN</th>
             <th class='th02' align='center' rowspan='1' colspan='2' width='200'>DISETUJUI PENGGUNA</th>
             <th class='th02' align='center' rowspan='1' colspan='2' width='200'>DISETUJUI PENGELOLA</th>
             </tr>
             <tr>
                <th class='th01' align='center'  width='600'>NAMA BARANG</th>
              <th class='th01' align='center'  width='200'>JUMLAH</th>
                <th class='th01' align='center'  width='200'>SATUAN</th>
              <th class='th01' align='center'  width='200'>JUMLAH</th>
              <th class='th01' align='center'  width='200'>CARA PEMENUHAN</th>
              <th class='th01' align='center'  width='200'>JUMLAH</th>
              <th class='th01' align='center'  width='200'>CARA PEMENUHAN</th>
             </tr>
             </thead>";


      }

    }





    return $headerTable;
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

  function formPemenuhan($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 400;
   $this->form_height = 80;
   $this->form_caption = 'CARA PEMENUHAN BARU';


   //items ----------------------
    $this->form_fields = array(
      'catatan' => array(
            'label'=>'CARA PEMENUHAN',
            'labelWidth'=>130,
            'value'=>"<input type='text' name='caraPemenuhan' id='caraPemenuhan' style='width:210px;'>",
             ),

      );
    //tombol
    $this->form_menubawah =
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveCaraPemenuhan($dt);' title='Simpan' >   ".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }
  function setKolomData($no, $isi, $Mode, $TampilCheckBox){
   global $Ref;
   foreach ($isi as $key => $value) {
      $$key = $value;
   }
    $status_validasi = $isi['status_validasi'];

     if($this->jenisForm=="PENYUSUNAN"){

        if($f == '00' && $q =='0')$TampilCheckBox = "";
            if($p =='0'){
          $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
          $getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
          $header = $e1.". ".$getSubUnit['nm_skpd'];
          $style = "style='font-weight:bold;'";
          $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
          $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
          $Koloms.= "<td class='$cssclass' align='center'></td>";
          $Koloms.= $tampilHeader;
          $Koloms.= "<td class='$cssclass' align='left'></td>";
          $Koloms.= "<td class='$cssclass' align='right'></td>";
          $Koloms.= "<td class='$cssclass' align='left'></td>";
          $Koloms.= "<td class='$cssclass' align='left'></td>";

          if($this->wajibValidasi==TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
         }elseif($p!= '0' && $q=='0'){
          $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
          $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
          $header = genNumber($p).". ".$getNamaPrgoram['nama'];
          $style = "style='margin-left:5px;'";
          $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
          $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
          $Koloms.= "<td class='$cssclass' align='center'></td>";
          $Koloms.= $tampilHeader;
          $Koloms.= "<td class='$cssclass' align='left'></td>";
          $Koloms.= "<td class='$cssclass' align='right'></td>";
          $Koloms.= "<td class='$cssclass' align='left'></td>";
          $Koloms.= "<td class='$cssclass' align='left'></td>";
          if($this->wajibValidasi==TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
         }elseif($f == '00' && $q!='0'){
          $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
          $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
          $header = genNumber($q).". ".$getNamaPrgoram['nama'];
          $style = "style='margin-left:10px;'";
          $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
          $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
          $Koloms.= "<td class='$cssclass' align='center'>$TampilCheckBox</td>";
          $Koloms.= $tampilHeader;
          $Koloms.= "<td class='$cssclass' align='left'></td>";
          $Koloms.= "<td class='$cssclass' align='right'></td>";
          $Koloms.= "<td class='$cssclass' align='left'></td>";
          $Koloms.= "<td class='$cssclass' align='left'></td>";
          if($this->wajibValidasi==TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
         }else{

           $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
           $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
           $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
           $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
           $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
           $getBarang = mysql_fetch_array(mysql_query($syntax));
           $namaBarang = $getBarang['nm_barang'];

           $concat = $kodeSKPD.".".$kodeBarang;
           $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
           $kebutuhanMax = $getKebutuhanMax['jumlah'];
           $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
           $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
           $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;
           $satuan = $getBarang['satuan'];
           $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
           $Koloms.= "<td class='$cssclass' align='center'></td>";
           $Koloms.= $tampilHeader;
           $Koloms.= "<td class='$cssclass' align='left'>$namaBarang</td>";
           $Koloms.= "<td class='$cssclass' align='right'>".number_format($volume_barang,0,',','.')."</td>";
           $Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
           $Koloms.= "<td class='$cssclass' align='right'>".number_format($kebutuhanRiil,0,',','.')."</td>";
           $Koloms.= "<td class='$cssclass' align='right'>".number_format($kebutuhanMax,0,',','.')."</td>";
           $Koloms.= "<td class='$cssclass' align='right'>".number_format($jumlahOptimal,0,',','.')."</td>";
           $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
           /*$getStatusValidasi = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$id_anggaran'"));
           $status_validasi = $getStatusValidasi['status_validasi'];*/
           if($status_validasi == '1'){
              $validnya = "valid.png";
           }else{
              $validnya = "invalid.png";
           }
           if($this->wajibValidasi==TRUE){
            $Koloms.= "<td class='$cssclass' align='center'>"."<img src='images/administrator/images/$validnya' width='20px' heigh='20px' style='cursor:pointer;'  onclick=$this->Prefix.Validasi('$id_anggaran');> "."</td>";

           }


         }

          $Koloms = array(
            array("Y", $Koloms),
           );
     }
     elseif($this->jenisForm=="KOREKSI PENGGUNA"){

          if($f == '00' && $q =='0')$TampilCheckBox = "";
              if($p =='0'){
            $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
            $getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
            $header = $e1.". ".$getSubUnit['nm_skpd'];
            $style = "style='font-weight:bold;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
           }elseif($p!= '0' && $q=='0'){
            $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
            $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
            $header = genNumber($p).". ".$getNamaPrgoram['nama'];
            $style = "style='margin-left:5px;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
           }elseif($f == '00' && $q!='0'){
            $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
            $header = genNumber($q).". ".$getNamaPrgoram['nama'];
            $style = "style='margin-left:10px;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
           }else{

             $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
             $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
             $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
             $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
             $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
             $getBarang = mysql_fetch_array(mysql_query($syntax));
             $namaBarang = $getBarang['nm_barang'];

             $concat = $kodeSKPD.".".$kodeBarang;
             $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
             $kebutuhanMax = $getKebutuhanMax['jumlah'];
             $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
             $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
             $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;

             $getDataKoreksi = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "));
             $kondisiWarna = "red";

             if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "))  > 0){
              $jumlahKoreksi = number_format($getDataKoreksi['volume_barang'],0,',','.');
              $align = "right";
              $tanggalKoreksi = explode("-",$getDataKoreksi['tanggal_update']);
              $tanggalKoreksi = $tanggalKoreksi[2]."-".$tanggalKoreksi[1]."-".$tanggalKoreksi[0];
              $caraPemenuhan = $getDataKoreksi['cara_pemenuhan'];
              $keteranganKoreksi =  $getDataKoreksi['user_update']."/".$tanggalKoreksi;
              $kondisiWarna = "black";
             }

             $satuan = $getBarang['satuan'];
             $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
             $Koloms.= $tampilHeader;
             $Koloms.= "<td class='$cssclass' align='left' ><span style='color:$kondisiWarna;'>$namaBarang</span></td>";
             $Koloms.= "<td class='$cssclass' align='right'><input type='hidden' id='volumeBarang$id_anggaran' value='$volume_barang'>".number_format($volume_barang,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($kebutuhanRiil,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($kebutuhanMax,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($jumlahOptimal,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
             $Koloms.= "<td class='$cssclass' id='alignKoreksi' align='$align'><span id='spanJumlah$id_anggaran'>$jumlahKoreksi</span> <span style='color:red;' id='bantuJumlah$id_anggaran'><span> </td>";
             $Koloms.= "<td class='$cssclass' align='left'><span id='spanCaraPemenuhan$id_anggaran'>$caraPemenuhan</span> </td>";
             $aksi  = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=koreksiPengelolaPengadaanNew.sesuai('$id_anggaran');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=koreksiPengelolaPengadaanNew.koreksi('$id_anggaran');></img>";
             $Koloms.= "<td class='$cssclass'  id='updatePengguna$id_anggaran' align='center'><span id='save$id_anggaran'>$aksi</span></td>";

           }



        $Koloms = array(
              array("Y", $Koloms),
             );
      }

     elseif($this->jenisForm=="KOREKSI PENGELOLA"){

          if($f == '00' && $q =='0')$TampilCheckBox = "";
              if($p =='0'){
            $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
            $getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
            $header = $e1.". ".$getSubUnit['nm_skpd'];
            $style = "style='font-weight:bold;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            //$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            //$Koloms.= "<td class='$cssclass' align='left'></td>";

           }elseif($p!= '0' && $q=='0'){
            $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
            $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
            $header = genNumber($p).". ".$getNamaPrgoram['nama'];
            $style = "style='margin-left:5px;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            //$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            //$Koloms.= "<td class='$cssclass' align='left'></td>";

           }elseif($f == '00' && $q!='0'){
            $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
            $header = genNumber($q).". ".$getNamaPrgoram['nama'];
            $style = "style='margin-left:10px;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            //$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
          //  $Koloms.= "<td class='$cssclass' align='left'></td>";

           }else{

             $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
             $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
             $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
             $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
             $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
             $getBarang = mysql_fetch_array(mysql_query($syntax));
             $namaBarang = $getBarang['nm_barang'];

             $concat = $kodeSKPD.".".$kodeBarang;
             $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
             $kebutuhanMax = $getKebutuhanMax['jumlah'];
             $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
             $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
             $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;

             $getDataKoreksi = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "));
             $kondisiWarna = "red";

             if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "))  > 0){
              $jumlahKoreksi = number_format($getDataKoreksi['volume_barang'],0,',','.');
              $align = "right";
              $tanggalKoreksi = explode("-",$getDataKoreksi['tanggal_update']);
              $tanggalKoreksi = $tanggalKoreksi[2]."-".$tanggalKoreksi[1]."-".$tanggalKoreksi[0];
              $caraPemenuhan = $getDataKoreksi['cara_pemenuhan'];
              $keteranganKoreksi =  $getDataKoreksi['user_update']."/".$tanggalKoreksi;
              $kondisiWarna = "black";
             }

             $satuan = $getBarang['satuan'];
             //$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
             $Koloms.= $tampilHeader;
             $Koloms.= "<td class='$cssclass' align='left' valign='middle' ><span style='color:$kondisiWarna;'>$namaBarang</span></td>";

             $nomorUrutDuaTahapSebelumnya = $this->nomorUrut - 2;
             $getIsiBarangTahapSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutDuaTahapSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'"));
             $isiBarangTahapSebelumnya = $getIsiBarangTahapSebelumnya['volume_barang'];
             $catatan = $getIsiBarangTahapSebelumnya['catatan'];
             $Koloms.= "<td class='$cssclass' align='right' valign='middle'>".number_format($isiBarangTahapSebelumnya,0,',','.')."</td>";

             $Koloms.= "<td class='$cssclass' align='left' valign='middle'>$satuan_barang</td>";
             $Koloms.= "<td class='$cssclass' align='right' valign='middle'>".number_format($kebutuhanMax,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='right' valign='middle'>".number_format($jumlahOptimal,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='right' valign='middle'>".number_format($kebutuhanRiil,0,',','.')."</td>";
            // $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
             $Koloms.= "<td class='$cssclass' align='right' valign='middle'><input type='hidden' id='volumeBarang$id_anggaran' value='$volume_barang'>".number_format($volume_barang,0,',','.')." </td>";
             $Koloms.= "<td class='$cssclass' align='left' valign='middle'>$cara_pemenuhan</td>";
             $tanggal_update = explode("-",$tanggal_update);
             $tanggal_update = $tanggal_update[2]."-".$tanggal_update[1]."-".$tanggal_update[0];
             $Koloms.= "<td class='$cssclass' id='alignKoreksi' align='right' valign='middle'><span id='spanJumlah$id_anggaran'>$jumlahKoreksi</span> <span style='color:red;' id='bantuJumlah$id_anggaran'><span> </td>";
             $Koloms.= "<td class='$cssclass' align='left' valign='middle'><span id='spanCaraPemenuhan$id_anggaran'>$caraPemenuhan</span> </td>";
             $aksi  = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=koreksiPengelolaPengadaanNew.sesuai('$id_anggaran');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=koreksiPengelolaPengadaanNew.koreksi('$id_anggaran');></img> ";
             $Koloms.= "<td class='$cssclass' id='updatePengguna$id_anggaran' align='center' valign='middle'><span id='save$id_anggaran'>$aksi</span></td>";

           }



        $Koloms = array(
              array("Y", $Koloms),
             );
      }
     else{
        if($this->jenisFormTerakhir == "PENYUSUNAN"){

          if($f == '00' && $q =='0')$TampilCheckBox = "";
              if($p =='0'){
            $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
            $getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
            $header = $e1.". ".$getSubUnit['nm_skpd'];
            $style = "style='font-weight:bold;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            if($this->wajibValidasi==TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
           }elseif($p!= '0' && $q=='0'){
            $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
            $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
            $header = genNumber($p).". ".$getNamaPrgoram['nama'];
            $style = "style='margin-left:5px;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            if($this->wajibValidasi==TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
           }elseif($f == '00' && $q!='0'){
            $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
            $header = genNumber($q).". ".$getNamaPrgoram['nama'];
            $style = "style='margin-left:10px;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            if($this->wajibValidasi==TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
           }else{

             $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
             $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
             $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
             $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
             $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
             $getBarang = mysql_fetch_array(mysql_query($syntax));
             $namaBarang = $getBarang['nm_barang'];

             $concat = $kodeSKPD.".".$kodeBarang;
             $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
             $kebutuhanMax = $getKebutuhanMax['jumlah'];
             $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
             $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
             $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;
             $satuan = $getBarang['satuan'];
             $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
             $Koloms.= $tampilHeader;
             $Koloms.= "<td class='$cssclass' align='left'>$namaBarang</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($volume_barang,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($kebutuhanRiil,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($kebutuhanMax,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($jumlahOptimal,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
              if($status_validasi == '1'){
              $validnya = "valid.png";
           }else{
              $validnya = "invalid.png";
           }
           if($this->wajibValidasi==TRUE)$Koloms.= "<td class='$cssclass' align='center'>"."<img src='images/administrator/images/$validnya' width='20px' heigh='20px' style='cursor:pointer;'  > "."</td>";
           }


            $Koloms = array(
              array("Y", $Koloms),
             );

      }
      elseif($this->jenisFormTerakhir == "KOREKSI PENGGUNA"){

          if($f == '00' && $q =='0')$TampilCheckBox = "";
              if($p =='0'){
            $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
            $getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
            $header = $e1.". ".$getSubUnit['nm_skpd'];
            $style = "style='font-weight:bold;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
           }elseif($p!= '0' && $q=='0'){
            $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
            $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
            $header = genNumber($p).". ".$getNamaPrgoram['nama'];
            $style = "style='margin-left:5px;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
           }elseif($f == '00' && $q!='0'){
            $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
            $header = genNumber($q).". ".$getNamaPrgoram['nama'];
            $style = "style='margin-left:10px;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
           }else{

             $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
             $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
             $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
             $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
             $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
             $getBarang = mysql_fetch_array(mysql_query($syntax));
             $namaBarang = $getBarang['nm_barang'];

             $concat = $kodeSKPD.".".$kodeBarang;
             $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
             $kebutuhanMax = $getKebutuhanMax['jumlah'];
             $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
             $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
             $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;

             $getDataKoreksi = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "));
             $kondisiWarna = "red";

             if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "))  > 0){
              $jumlahKoreksi = number_format($getDataKoreksi['volume_barang'],0,',','.');
              $align = "right";
              $tanggalKoreksi = explode("-",$getDataKoreksi['tanggal_update']);
              $tanggalKoreksi = $tanggalKoreksi[2]."-".$tanggalKoreksi[1]."-".$tanggalKoreksi[0];
              $caraPemenuhan = $getDataKoreksi['cara_pemenuhan'];
              $keteranganKoreksi =  $getDataKoreksi['user_update']."/".$tanggalKoreksi;
             }

             $satuan = $getBarang['satuan'];
             $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
             $Koloms.= $tampilHeader;
             $Koloms.= "<td class='$cssclass' align='left' ><span style='color:black;'>$namaBarang</span></td>";
             $nomorUrutDuaTahapSebelumnya = $this->urutTerakhir - 1;
             $get2TahapSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutDuaTahapSebelumnya' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "));
             $volume_barang = $get2TahapSebelumnya['volume_barang'];
             $catatan = $get2TahapSebelumnya['catatan'];
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($volume_barang,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($kebutuhanRiil,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($kebutuhanMax,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($jumlahOptimal,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
             $Koloms.= "<td class='$cssclass' id='alignKoreksi' align='$align'>$jumlahKoreksi </td>";
             $Koloms.= "<td class='$cssclass' align='left'>$caraPemenuhan </td>";

           }

        $Koloms = array(
              array("Y", $Koloms),
             );

      }
      elseif($this->jenisFormTerakhir == "KOREKSI PENGELOLA"){
          if($f == '00' && $q =='0')$TampilCheckBox = "";
              if($p =='0'){
            $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
            $getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
            $header = $e1.". ".$getSubUnit['nm_skpd'];
            $style = "style='font-weight:bold;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
           }elseif($p!= '0' && $q=='0'){
            $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
            $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
            $header = genNumber($p).". ".$getNamaPrgoram['nama'];
            $style = "style='margin-left:5px;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
           }elseif($f == '00' && $q!='0'){
            $kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
            $header = genNumber($q).". ".$getNamaPrgoram['nama'];
            $style = "style='margin-left:10px;'";
            $tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
            $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
            $Koloms.= $tampilHeader;
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='right'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
            $Koloms.= "<td class='$cssclass' align='left'></td>";
           }else{

             $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
             $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
             $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
             $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
             $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
             $getBarang = mysql_fetch_array(mysql_query($syntax));
             $namaBarang = $getBarang['nm_barang'];

             $concat = $kodeSKPD.".".$kodeBarang;
             $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
             $kebutuhanMax = $getKebutuhanMax['jumlah'];
             $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
             $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
             $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;

             $getDataKoreksi = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut='$this->urutTerakhir' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "));
             $kondisiWarna = "red";

             if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut='$this->urutTerakhir' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "))  > 0){
              $jumlahKoreksi = number_format($getDataKoreksi['volume_barang'],0,',','.');
              $align = "right";
              $tanggalKoreksi = explode("-",$getDataKoreksi['tanggal_update']);
              $tanggalKoreksi = $tanggalKoreksi[2]."-".$tanggalKoreksi[1]."-".$tanggalKoreksi[0];
              $caraPemenuhan = $getDataKoreksi['cara_pemenuhan'];
              $keteranganKoreksi =  $getDataKoreksi['user_update']."/".$tanggalKoreksi;
              $kondisiWarna = "black";
             }

             $satuan = $getBarang['satuan'];
             $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
             $Koloms.= $tampilHeader;
             $Koloms.= "<td class='$cssclass' align='left' ><span style='color:black;'>$namaBarang</span></td>";

             $nomorUrut2TahapSebelumnya = $this->urutTerakhir -2;
             $getDataDuaTahapSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrut2TahapSebelumnya' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'  "));

             $catatan = $getDataDuaTahapSebelumnya['catatan'];
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($getDataDuaTahapSebelumnya['volume_barang'],0,',','.')."</td>";

             $Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($kebutuhanRiil,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($kebutuhanMax,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($jumlahOptimal,0,',','.')."</td>";
             $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
             $Koloms.= "<td class='$cssclass' align='right'>".number_format($volume_barang,0,',','.')." </td>";
             $Koloms.= "<td class='$cssclass' align='left'>$cara_pemenuhan</td>";
             $tanggal_update = explode("-",$tanggal_update);
             $tanggal_update = $tanggal_update[2]."-".$tanggal_update[1]."-".$tanggal_update[0];
             $Koloms.= "<td class='$cssclass' align='right'>$jumlahKoreksi </td>";
             $Koloms.= "<td class='$cssclass' align='left'>$caraPemenuhan </td>";


           }



        $Koloms = array(
              array("Y", $Koloms),
             );

      }
     }
   return $Koloms;

  }
   function Validasi($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 500;
   $this->form_height = 120;
   $this->form_caption = 'VALIDASI RKBMD PENGADAAN';
   $kode = $dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'].".".genNumber($dt['bk']).".".genNumber($dt['ck']).".".genNumber($dt['dk']).".".genNumber($dt['p']).".".$dt['q'].".".$dt['f1'].".".$dt['f2'].".".$dt['f'].".".$dt['g'].".".$dt['h'].".".$dt['i'].".".$dt['j'].".".$dt['id_jenis_pemeliharaan'];
    if ($dt['status_validasi'] == '1') {
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
            'label'=>'KODE RKBMD',
            'labelWidth'=>100,
            'value'=>$kode,
            'type'=>'text',
            'param'=>"style='width:300px;' readonly"
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
            'param'=>"style='width:300px;' readonly"
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
  function Laporan($dt,$c1,$c,$d,$e,$e1){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   // $this->form_width = 800;
   $this->form_height = 100;
   $this->form_caption = 'LAPORAN RKBMD PENGADAAN';

   $c1 = $dt['koreksiPengelolaPengadaanSkpdfmUrusan'];
   $c = $dt['koreksiPengelolaPengadaanSkpdfmSKPD'];
   $d = $dt['koreksiPengelolaPengadaanSkpdfmUNIT'];
   $e = $dt['koreksiPengelolaPengadaanSkpdfmSUBUNIT'];
   $e1 = $dt['koreksiPengelolaPengadaanSkpdfmSEKSI'];

    $arrayJenisLaporan = array(
                 // array('Pengadaan7', 'RKBMD PENGADAAN PROVINSI/KABUPATEN/KOTA'),
                 array('Pengadaan4', 'USULAN RKBMD PENGADAAN PADA PENGGUNA BARANG'),
                 array('Pengadaan5', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGELOLA BARANG'),
                 array('Pengadaan6', 'RKBMD PENGADAAN PADA PENGGUNA BARANG'),

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
                  'value'=>cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = 999 and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' ",'onchange=rka.refreshList(true);','-- TTD --'),

                ),

      );
    //tombol
    $this->form_menubawah =
      "
      <input type='button' value='TTD' onclick ='".$this->Prefix.".Baru()' title='TTD' >
      <input type='button' value='View' onclick ='".$this->Prefix.".Report()' title='Simpan' >   ".
      "<input type='button' value='Batal' onclick ='koreksiPengelolaPengadaan.Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }


  function genDaftarOpsi(){
   global $Ref, $Main,  $HTTP_COOKIE_VARS;


  $fmKODE = $_REQUEST['fmKODE'];
  $fmBARANG = $_REQUEST['fmBARANG'];
  $arr = array(
      //array('selectAll','Semua'),
      array('selectfg','Kode Barang'),
      array('selectbarang','Nama Barang'),
      );


  //data order ------------------------------
   $arrOrder = array(
               array('1','Kode Barang'),
           array('2','Nama Barang'),
   );



  $TampilOpt =
      //"<tr><td>".
      "<table width=\"100%\" class=\"adminform\"> <tr>
      <td width=\"100%\" valign=\"top\">" .
        WilSKPD_ajxVW("koreksiPengelolaPengadaanNewSkpd") .
      "</td>
      <td >" .
      "</td></tr>
      <tr><td>
      <input type='hidden' name='cmbJeniskoreksiPengelolaPengadaanNew' id='cmbJeniskoreksiPengelolaPengadaanNew' value='PENGADAAN'>
      </td></tr>
      </table>";
    return array('TampilOpt'=>$TampilOpt);
  }
  function Info(){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 500;
   $this->form_height = 100;
   $this->form_caption = 'INFO RKBMD';


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

    //"<html xmlns='http://www.w3.org/1999/xhtml'>".
    "<html>".
      $this->genHTMLHead().
      "<body >".
      /*"<div id='pageheader'>".$this->setPage_Header()."</div>".
      "<div id='pagecontent'>".$this->setPage_Content()."</div>".
      $Main->CopyRight.*/

      "<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0'  height='100%' >".
        //header page -------------------
        "<tr height='34'><td>".
          //$this->setPage_Header($IconPage, $TitlePage).
          $this->setPage_Header().
          "<div id='header' ></div>".
        "</td></tr>".
        $navatas.
        //$this->setPage_HeaderOther().
        //Content ------------------------
        //style='padding:0 8 0 8'
        "<tr height='*' valign='top'> <td >".

          $this->setPage_HeaderOther().
          "<div align='center' class='centermain' >".
          "<div class='main' >".
          $form1.

            //Form ------------------
            //$hidden.
            //genSubTitle($TitleDaftar,$SubTitle_menu).
            $this->setPage_Content().
            //$OtherInForm.

          $form2.//"</form>".
          "</div></div>".
        "</td></tr>".
        //$OtherContentPage.
        //Footer ------------------------
        "<tr><td height='29' >".
          //$app->genPageFoot(FALSE).
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

  function getDaftarOpsi($Mode=1){
    global $Main, $HTTP_COOKIE_VARS;
    $UID  = $_COOKIE['coID'];
    $c1   = $_REQUEST['koreksiPengelolaPengadaanNewSkpdfmUrusan'];
    $c    = $_REQUEST['koreksiPengelolaPengadaanNewSkpdfmSKPD'];
    $d    = $_REQUEST['koreksiPengelolaPengadaanNewSkpdfmUNIT'];
    $e    = $_REQUEST['koreksiPengelolaPengadaanNewSkpdfmSUBUNIT'];
    $e1   = $_REQUEST['koreksiPengelolaPengadaanNewSkpdfmSEKSI'];
    if(isset($e1)){
      $data = array("CurrentUrusan" => $c1,
            "CurrentBidang" => $c,
            "CurrentSKPD" => $d,
             "CurrentUnit" => $e,
              "CurrentSubUnit" => $e1,

            );
    }elseif(isset($e)){
      $data = array("CurrentUrusan" => $c1,
            "CurrentBidang" => $c,
            "CurrentSKPD" => $d,
             "CurrentUnit" => $e,

            );
    }elseif(isset($d)){
      $data = array("CurrentUrusan" => $c1,
            "CurrentBidang" => $c,
            "CurrentSKPD" => $d,

            );
    }elseif(isset($c)){
      $data = array("CurrentUrusan" => $c1,
            "CurrentBidang" => $c,

            );
    }elseif(isset($c1)){
      $data = array("CurrentUrusan" => $c1

       );
    }

    mysql_query(VulnWalkerUpdate("current_filter",$data,"username='$this->username'"));


      if(!isset($c1) ){
        $arrayData = mysql_fetch_array(mysql_query("select * from current_filter where username ='".$_COOKIE['coID']."'"));
      foreach ($arrayData as $key => $value) {
        $$key = $value;
       }
       if($CurrentSubUnit !='000' ){
        $e1 = $CurrentSubUnit;
        $e = $CurrentUnit;
        $d = $CurrentSKPD;
        $c = $CurrentBidang;
        $c1 = $CurrentUrusan;

      }elseif($CurrentUnit !='00' ){
        $e = $CurrentUnit;
        $d = $CurrentSKPD;
        $c = $CurrentBidang;
        $c1 = $CurrentUrusan;

      }elseif($CurrentSKPD !='00' ){
        $d = $CurrentSKPD;
        $c = $CurrentBidang;
        $c1 = $CurrentUrusan;

      }elseif($CurrentBidang !='00'){
        $c = $CurrentBidang;
        $c1 = $CurrentUrusan;

      }elseif($CurrentUrusan !='0'){
        $c1 = $CurrentUrusan;
      }
     }

    foreach ($HTTP_COOKIE_VARS as $key => $value) {
            $$key = $value;
    }

    if($VulnWalkerSubUnit != '000'){
      $e1 = $VulnWalkerSubUnit;
      $e = $VulnWalkerUnit;
      $d = $VulnWalkerSKPD;
      $c = $VulnWalkerBidang;
      $c1 = $VulnWalkerUrusan;
    }elseif($VulnWalkerUnit != '00'){
      $e = $VulnWalkerUnit;
      $d = $VulnWalkerSKPD;
      $c = $VulnWalkerBidang;
      $c1 = $VulnWalkerUrusan;
    }elseif($VulnWalkerSKPD != '00'){
      $d = $VulnWalkerSKPD;
      $c = $VulnWalkerBidang;
      $c1 = $VulnWalkerUrusan;
    }elseif($VulnWalkerBidang != '00'){
      $c = $VulnWalkerBidang;
      $c1 = $VulnWalkerUrusan;
    }elseif($VulnWalkerUrusan != '0'){
      $c1 = $VulnWalkerUrusan;
    }
    if(isset($c1) && (empty($c1) || $c1 =="0")){
      $c1 = "";
      $c = "";
      $d = "";
      $e = "";
      $e1 = "";
    }elseif(isset($c) && (empty($c) || $c =="00")){
      $c = "";
      $d = "";
      $e = "";
      $e1 = "";
    }elseif(isset($d) && (empty($d) || $d =="00")){
      $d = "";
      $e = "";
      $e1 = "";
    }elseif(isset($e) && (empty($e) || $e =="00")){
      $e = "";
      $e1 = "";
    }elseif(isset($e1) && (empty($e1) || $e1 =="000")){
      $e1 = "";
    }
    $fmKODE = $_REQUEST['fmKODE'];
    $fmBARANG = $_REQUEST['fmBARANG'];
    $cmbJeniskoreksiPengelolaPengadaanNew = $_REQUEST['cmbJeniskoreksiPengelolaPengadaanNew'];
    $arrKondisi = array();

    if(!empty($c1) && $c1!="0" ){
      $arrKondisi[] = "c1 = $c1";
    }
    if(!empty($c) && $c!="00"){
      $arrKondisi[] = "c = $c";
    }
    if(!empty($d) && $d!="00"){
      $arrKondisi[] = "d = $d";
    }
    if(!empty($e) && $e!="00"){
      $arrKondisi[] = "e = $e";
    }
    if(!empty($e1) && $e1!="000"){
      $arrKondisi[] = "e1 = $e1";
    }

    $arrKondisi[] = "id_jenis_pemeliharaan = '0'  and uraian_pemeliharaan != 'RKBMD PEMELIHARAAN' and uraian_pemeliharaan != 'RKBMD PERSEDIAAN' ";

    if($this->jenisForm == "PENYUSUNAN"){
      $getAllParent = mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and f='00' and q = '0' and e1 !='000' ");
      while($rows = mysql_fetch_array($getAllParent)){
        foreach ($rows as $key => $value) {
         $$key = $value;
        }
        $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan ='0' "));
        if($cekSKPD == 0){
          $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
          $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
        }else{
          $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
          $getAllProgram = mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and f ='00'  and concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$concat'  and p !='0' and q ='0'");
          while($rows = mysql_fetch_array($getAllProgram)){
            foreach ($rows as $key => $value) {
             $$key = $value;
            }
            $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and bk='$bk' and ck= '$ck' and dk= '$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan ='0' "));
            if($cekProgram == 0){
              $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
              $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
            }
          }

        }


      }

      $arrKondisi[] = "id_tahap = '$this->idTahap'";
    }elseif($this->jenisForm == "KOREKSI PENGGUNA"){
      $nomorUrutSebelumnya = $this->nomorUrut -1;
      $getJenisTahapSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
      $jenisTahapSebelumnya = $getJenisTahapSebelumnya['jenis_form_modul'];
      $getAll = mysql_query("select * from view_rkbmd where f !='00' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya'");
      $arrayID = array();
      while($rows = mysql_fetch_array($getAll)){
        foreach ($rows as $key => $value) {
         $$key = $value;
        }
        if( $jenisTahapSebelumnya == "PENYUSUNAN" && $status_validasi != '1' && $this->wajibValidasi == TRUE ){
            $arrKondisi[] = " id_anggaran !='$id_anggaran' ";
            $arrayID[] = " id_anggaran !='$id_anggaran' ";
            array_push($arrayID,$id_anggaran);
            $Condition= join(' and ',$arrayID);
            if(sizeof($arrayID) == 0){
              $Condition = "";
            }else{
              $Condition = $Condition." and";
            }
            $resultKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where  $Condition  j !='000' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck='$ck'  and dk='$dk' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
            if($resultKegiatan  == 0){
                $concat =  $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.'.'.$ck.'.'.$dk.'.'.$p.'.'.$q;
              $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat' ";
              $resultProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where  $Condition   j!='000' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck='$ck'  and dk='$dk' and p='$p'  and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
              if($resultProgram == 0){
                $concat =  $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.'.'.$ck.'.'.$dk.'.'.$p;
                $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat' ";
                $resultSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where $Condition  j !='000' and c1='$c1' and c='$c' and d='$d' and e='$e' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
                if($resultSKPD == 0){
                  $concat =  $c1.".".$c.".".$d.".".$e.".".$e1;
                  $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat' ";
                }
              }

            }
        }




      }

      if($jenisTahapSebelumnya == "PENYUSUNAN"){
          $getAllParent = mysql_query("select * from view_rkbmd where  tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and f='00' and q !='0'  ");
          while($rows = mysql_fetch_array($getAllParent)){
            foreach ($rows as $key => $value) {
             $$key = $value;
            }
            $cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f !='00' and id_jenis_pemeliharaan ='0' $this->sqlValidasi "));
            if($cekKegiatan == 0){
              $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
              $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
              $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan ='0' $this->sqlValidasi "));
              if($cekProgram == 0){
                $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
                $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
                $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan ='0' $this->sqlValidasi "));
                if($cekSKPD == 0){
                  $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
                  $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
                }
              }
            }


          }
      }else{
        $getAllParent = mysql_query("select * from view_rkbmd where  tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and f='00' and q !='0' ");
        while($rows = mysql_fetch_array($getAllParent)){
          foreach ($rows as $key => $value) {
           $$key = $value;
          }
          $cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f !='00' and id_jenis_pemeliharaan ='0'  "));
          if($cekKegiatan == 0){
            $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
            $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan ='0' "));
            if($cekProgram == 0){
              $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
              $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
              $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan ='0' "));
              if($cekSKPD == 0){
                $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
                $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
              }
            }
          }


        }

      }
      $arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya'";

    }elseif($this->jenisForm == "KOREKSI PENGELOLA"){
      $nomorUrutSebelumnya = $this->nomorUrut -1;
      $getJenisTahapSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
      $jenisTahapSebelumnya = $getJenisTahapSebelumnya['jenis_form_modul'];

        $getAllParent = mysql_query("select * from view_rkbmd where  tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and f='00' and q !='0' ");
        while($rows = mysql_fetch_array($getAllParent)){
          foreach ($rows as $key => $value) {
           $$key = $value;
          }
          $cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang "));
          if($cekKegiatan == 0){
            $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
            $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang"));
            if($cekProgram == 0){
              $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
              $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
              $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan ='0' $this->kondisiBarang"));
              if($cekSKPD == 0){
                $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
                $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
              }
            }
          }


        }


      $arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya'";
    }else{
      if($this->jenisFormTerakhir == "PENYUSUNAN"){
        $getAllParent = mysql_query("select * from view_rkbmd where no_urut='$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' and f='00' and q = '0' and e1 !='000' ");
        while($rows = mysql_fetch_array($getAllParent)){
          foreach ($rows as $key => $value) {
           $$key = $value;
          }
          $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut='$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan ='0' "));
          if($cekSKPD == 0){
            $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
            $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
          }else{
            $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
            $getAllProgram = mysql_query("select * from view_rkbmd where no_urut='$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' and f ='00'  and concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$concat'  and p !='0' and q ='0'");
            while($rows = mysql_fetch_array($getAllProgram)){
              foreach ($rows as $key => $value) {
               $$key = $value;
              }
              $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut='$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and bk='$bk' and ck= '$ck' and dk= '$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan ='0' "));
              if($cekProgram == 0){
                $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
                $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
              }
            }

          }


        }
        $arrKondisi[] =  "no_urut = '$this->urutTerakhir'";
      }elseif($this->jenisFormTerakhir == "KOREKSI PENGGUNA"){
        $getAllParent = mysql_query("select * from view_rkbmd where  tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and f='00' and q !='0' ");
        while($rows = mysql_fetch_array($getAllParent)){
          foreach ($rows as $key => $value) {
           $$key = $value;
          }
          $cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f !='00' and id_jenis_pemeliharaan ='0'  "));
          if($cekKegiatan == 0){
            $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
            $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan ='0' "));
            if($cekProgram == 0){
              $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
              $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
              $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan ='0' "));
              if($cekSKPD == 0){
                $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
                $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
              }
            }
          }


        }
        $arrKondisi[] =  "no_urut = '$this->urutTerakhir'";
      }elseif($this->jenisFormTerakhir == "KOREKSI PENGELOLA"){
        $getAllParent = mysql_query("select * from view_rkbmd where  tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and f='00' and q !='0' ");
        while($rows = mysql_fetch_array($getAllParent)){
          foreach ($rows as $key => $value) {
           $$key = $value;
          }
          $cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f !='00' and id_jenis_pemeliharaan ='0'  "));
          if($cekKegiatan == 0){
            $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
            $cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan ='0' "));
            if($cekProgram == 0){
              $concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
              $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
              $cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan ='0' "));
              if($cekSKPD == 0){
                $concat = $c1.".".$c.".".$d.".".$e.".".$e1;
                $arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
              }
            }
          }


        }
        $noUrut2TahapSebelumnya = $this->urutTerakhir - 1;
        $arrKondisi[] =  "no_urut = '$noUrut2TahapSebelumnya'";
      }


    }



    $arrKondisi[] = "tahun = '$this->tahun'";
    $arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
    $arrKondisi[] = "f != '06' and f!='07' and f!='08'";


    $Kondisi= join(' and ',$arrKondisi);
    $Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

    //Order -------------------------------------
    $fmORDER1 = cekPOST('fmORDER1');
    $fmDESC1 = cekPOST('fmDESC1');
    $Asc1 = $fmDESC1 ==''? '': 'desc';
    $arrOrders = array();
    $arrOrders[] = "urut ASC " ;




      $Order= join(',',$arrOrders);
      $OrderDefault = '';// Order By no_terima desc ';
      $Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;


    return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

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
                    <th class='th01' style='width: 4%;'>JUMLAH</th>
                    <th class='th01' style='width: 4%;'>SATUAN</th>
                    <th class='th01' style='width: 4%;'>JUMLAH</th>
                    <th class='th01' style='width: 4%;'>SATUAN</th>
                    <th class='th01' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' style='width: 4%;'>JUMLAH</th>
                    <th class='th01' style='width: 4%;'>SATUAN</th>
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

        $nomorUrutSebelumnya = $lastNomorUrut ;
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
                <tr valign='top' hidden='hidden'>
                  <td align='$align' class='GarisCetak'>".$no."</td>
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
      $no++;
      }elseif($q !='0' && $j =='000'){
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  ".$namaKegiatan2."
                </tr>
      ";
      }else{
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
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
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));

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
                    <th class='th01' rowspan='2' style='width: 4%;'>JUMLAH</th>
                    <th class='th01' rowspan='2' style='width: 4%;'>SATUAN</th>
                    <th class='th01' rowspan='2' style='width: 4%;'>JUMLAH</th>
                    <th class='th01' rowspan='2' style='width: 4%;'>SATUAN</th>
                    <th class='th01' rowspan='2' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' rowspan='2' style='width: 4%;'>JUMLAH</th>
                    <th class='th01' rowspan='2' style='width: 4%;'>SATUAN</th>
                    <th class='th01' rowspan='2' style='width: 4%;'>JUMLAH</th>
                    <th class='th01' rowspan='2' style='width: 4%;'>SATUAN</th>
                  </tr>
                  <tr>
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
                <tr valign='top' hidden='hidden'>
                  <td align='$align' class='GarisCetak'></td>
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
      $no++;
      }elseif ($q !='0' && $j =='000') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  ".$namaKegiatan2."
                </tr>
      ";
      }else{
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
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
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));

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
        $nomorUrutSebelumnya = $lastNomorUrut + 1;
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
                <tr valign='top' hidden='hidden'>
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
      $no++;
      }elseif ($q !='0' && $j =='000') {
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  ".$namaKegiatan2."
                </tr>
      ";
      }else{
        $naonkitu =
        "
                <tr valign='top'>
                  <td align='$align' class='GarisCetak'></td>
                  <td align='left' class='GarisCetak' colspan='1'></td>
                  <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang." &nbsp &nbsp ".$namaBarang."</td>
                  <td align='right' class='GarisCetak'>$jumlahBarangSebelumnya</td>
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
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan "));

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

  function Pengadaan7($xls =FALSE){
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
    $getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul ='KOREKSI PENGELOLA'"));
    $lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
    $getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
    $lastNomorUrut = $getLastTahap['no_urut'];
    $arrKondisi = array();
    $grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and p !='0' and q='0'");
    while($rows = mysql_fetch_array($grabProgram)){
      foreach ($rows as $key => $value) {
          $$key = $value;
      }
      if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' $this->kondisiBarang ")) == 0){
        $concat = $bk.".".$ck.".".$dk.".".$p;
        $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
      }else{
        if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $this->kondisiBarang")) == 0){
          if($q != '0'){
            $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
            $arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
          }
        }else{
            $concat = $f.".".$g.".".$h.".".$i.".".$j;
          if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' ")) == 0){
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
    $qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and uraian_pemeliharaan !='RKBMD PERSEDIAAN'  $this->kondisiBarang $Kondisi order by urut";
    $aqry = mysql_query($qry);

    //MULAI Halaman Laporan ------------------------------------------------------------------------------------------
    $css = $xls ? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
    $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));
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
                      RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
                      (RENCANA PENGADAAN)<br>
                      PROVINSI/KABUPATEN/KOTA ".$namaPemda[option_value]."<br>
                      <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN ANGGARAN $this->tahun </span>
                    </span>
                  </td>
                </tr>
              </table>


        <table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif;'>




        </table>";
    echo "
                <br>
                <table table width='100%' class='cetak' border='1' style='width:100%;'>
                <thead>
                  <tr>
                    <th class='th01' rowspan='2' style='width:20px;' >NO</th>
                    <th class='th01' rowspan='2' >PENGGUNA BARANG/<br>PROGRAM/<br>KEGIATAN/<br>OUTPUT</th>
                    <th class='th02' rowspan='1' colspan='4' >RENCANA KEBUTUHAN BARANG MILIK DAERAH</th>
                    <th class='th02' rowspan='1' colspan='2' >PEMENUHAN KEBUTUHAN BMD</th>
                    <th class='th01' rowspan='2' >CARA PEMENUHAN</th>
                    <th class='th01' rowspan='2' >KETERANGAN</th>
                  </tr>
                  <tr>
                    <th class='th01' colspan='2'>KODE / NAMA BARANG</th>
                    <th class='th01' >JUMLAH</th>
                    <th class='th01' >SATUAN</th>
                    <th class='th01' >JUMLAH</th>
                    <th class='th01' >SATUAN</th>
                  </tr>
                </thead>

    ";
    $arrayPenggunaBarang = array();
    $arrayExcept = array();
    $no = 1;
    while($daqry = mysql_fetch_array($aqry)){
      foreach ($daqry as $key => $value) {
          $$key = $value;
      }
      $concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
      $konket = $c1.".".$c.".".$d;
      if($p == '0'){
        $getNamaSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
        $programKegiatan = "<span style='font-weight:bold; '>".$getNamaSkpd['nm_skpd']."</span>";

        if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and uraian_pemeliharaan =''  and c1='$c1' and c='$c' and d='$d' and j!='000' ")) == 0){
          $arrayExcept[] = $konket;
        }else{
          if(array_search($konket,$arrayPenggunaBarang) == ''){
            $arrayPenggunaBarang[] = $konket;
          }
        }

      }elseif($p !='0' && $q == '0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
        $programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j =='000'){
        $getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
        $programKegiatan = "<span style='font-weight:bold; '>".$getProgramKegiatan['nama']."</span>";
        $kodeBarang = "";
        $namaBarang = "";
      }elseif($q !='0' && $j !='000'){
        $programKegiatan = "";
        $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
        $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
        $namaBarang = $getNamaBarang['nm_barang'];
        $volBar = number_format($volume_barang,0,'.',',');
        $nomorUrutSebelumnya = $lastNomorUrut - 1;
        $getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q= '$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and p='$p' and q='$q'"));
        $jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];

      }


      if ($p == '0') {
        $namaProgram = "<td align='left' class='GarisCetak' colspan='9'>".$programKegiatan."</td>";

      }elseif($p !='0' && $q == '0' && $j =='000'){
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='9'>".$programKegiatan." </td>";

      }elseif($q !='0' && $j =='000'){
        $getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
        $getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
        $outputan = $getDetailRenja[output];

        $namaKegiatan2 = "<td align='left' style='padding-left: 15px;' class='GarisCetak' colspan='9'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
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
                  <td align='right' class='GarisCetak'>$volBar</td>
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
      $namaBarang = "";
      $kodeBarang = "";



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
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport7['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = 3 and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = 3 "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = 3 and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

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
            <h5 class='pag pag1' style='font-size: 9px; bottom: -10px;'>
              <span style='bottom: 0; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
            </h5>
            <div class='insert'></div>
        </body>
      </html>";
    }
  }

function excel($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 800;
   $this->form_height = 80;
   $this->form_caption = 'LAPORAN RKBMD PENGADAAN';

   $c1 = $dt['koreksiPengelolaPengadaanNewSkpdfmUrusan'];
   $c = $dt['koreksiPengelolaPengadaanNewSkpdfmSKPD'];
   $d = $dt['koreksiPengelolaPengadaanNewSkpdfmUNIT'];
   $e = $dt['koreksiPengelolaPengadaanNewSkpdfmSUBUNIT'];
   $e1 = $dt['koreksiPengelolaPengadaanNewSkpdfmSEKSI'];

    $arrayJenisLaporan = array(
                 array('Pengadaan7', 'RKBMD PENGADAAN PROVINSI/KABUPATEN/KOTA'),

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
      "<input type='button' value='Download' onclick ='".$this->Prefix.".DownloadExcel()' title='Simpan' >   ".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }
}
$koreksiPengelolaPengadaanNew = new koreksiPengelolaPengadaanNewObj();
$arrayResult = tahapKoreksi("KOREKSI PENGELOLA","MURNI");
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = "MURNI";
$idTahap = $arrayResult['idTahap'];

$koreksiPengelolaPengadaanNew->jenisForm = $jenisForm;
$koreksiPengelolaPengadaanNew->nomorUrut = $nomorUrut;
$koreksiPengelolaPengadaanNew->urutTerakhir = $nomorUrut;
$koreksiPengelolaPengadaanNew->tahun = $tahun;
$koreksiPengelolaPengadaanNew->jenisAnggaran = $jenisAnggaran;
$koreksiPengelolaPengadaanNew->idTahap = $idTahap;
$koreksiPengelolaPengadaanNew->username = $_COOKIE['coID'];
$koreksiPengelolaPengadaanNew->wajibValidasi = $arrayResult['wajib_validasi'];
if($koreksiPengelolaPengadaanNew->wajibValidasi == TRUE){
  $koreksiPengelolaPengadaanNew->sqlValidasi = " and status_validasi ='1' ";
}else{
  $koreksiPengelolaPengadaanNew->sqlValidasi = " ";
}

$koreksiPengelolaPengadaanNew->provinsi = $arrayResult['provinsi'];
$koreksiPengelolaPengadaanNew->kota = $arrayResult['kota'];
$koreksiPengelolaPengadaanNew->pengelolaBarang = $arrayResult['pengelolaBarang'];
$koreksiPengelolaPengadaanNew->pejabatPengelolaBarang = $arrayResult['pejabat'];
$koreksiPengelolaPengadaanNew->pengurusPengelolaBarang = $arrayResult['pengurus'];
$koreksiPengelolaPengadaanNew->nipPengelola = $arrayResult['nipPengelola'];
$koreksiPengelolaPengadaanNew->nipPengurus = $arrayResult['nipPengurus'];
$koreksiPengelolaPengadaanNew->nipPejabat = $arrayResult['nipPejabat'];

$koreksiPengelolaPengadaanNew->statusPenetapan = checkPenetapanRKBMD($koreksiPengelolaPengadaanNew->tahun,$koreksiPengelolaPengadaanNew->jenisAnggaran,"PENGADAAN");

?>
