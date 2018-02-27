<?php

class ref_imagesObj  extends DaftarObj2{ 
  var $Prefix = 'ref_images';
  var $elCurrPage="HalDefault";
  var $SHOW_CEK = TRUE;
  var $TblName = 'images'; //bonus
  var $TblName_Hapus = 'images';
  var $MaxFlush = 10;
  var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
  var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
  var $KeyFields = array('id'); //primary key dari sebuah table
  var $FieldSum = array();//array('jml_harga');
  var $SumValue = array();
  var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
  var $FieldSum_Cp2 = array( 1, 1, 1);  
  var $checkbox_rowspan = 2;
  var $PageTitle = 'REFERENSI ARSIP';
  var $PageIcon = 'images/masterdata_ico.gif';
  var $pagePerHal ='';
  //var $cetak_xls=TRUE ;
  var $fileNameExcel='ref_images.xls';
  var $namaModulCetak='MASTER DATA';
  var $Cetak_Judul = 'ref_images'; 
  var $Cetak_Mode=2;
  var $Cetak_WIDTH = '30cm';
  var $Cetak_OtherHTMLHead;
  var $FormName = 'ref_imagesForm';
  var $noModul=9; 
  var $TampilFilterColapse = 0; //0
  var $username = "";
  
  function setTitle(){
    return 'IMAGES MANAGEMENT';
  }
  
  function setMenuEdit(){
    $getUserInfo = mysql_fetch_array(mysql_query("select * from admin where uid ='$this->username'"));
    foreach ($getUserInfo as $key => $value) { 
        $$key = $value; 
      } 
    
      return
                  "<td>".genPanelIcon("javascript:".$this->Prefix.".Upload()","upload.png","Upload", 'Upload')."</td>".
        "<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".

        "<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
        "<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>"; 

  }
  
  function setMenuView(){
    return "";
      
  }
  
    
  
  function simpanEdit(){
   global $HTTP_COOKIE_VARS;
   global $Main;
   $uid = $HTTP_COOKIE_VARS['coID'];
   $cek = ''; $err=''; $content=''; $json=TRUE;
   //get data -----------------
   $fmST = $_REQUEST[$this->Prefix.'_fmST'];
   $idplh = $_REQUEST[$this->Prefix.'_idplh'];
  
  $dk= $_REQUEST['k'];
  $dl= $_REQUEST['l'];
  $dm= $_REQUEST['m'];
  $dn= $_REQUEST['n'];
  $do= $_REQUEST['o'];
  $nama= $_REQUEST['nm_'];
  

  //$ke = substr($ke,1,1);
  
                
  if($err==''){           
    
  $aqry = "UPDATE  set k='$dk',l='$dl',m='$dm',n='$dn',o='$do',nm_='$nama' where concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
            $qry = mysql_query($aqry);
        }
                
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
      foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
        }
    if(empty($nama))$err = "Isi NAMA";
      if($fmST == 0){
        if($err == ''){

$getkategori = mysql_fetch_array(mysql_query("SELECT * FROM kategori_arsip WHERE id='$cmbKategori'"));
$nama_file = $_FILES['upload']['name'];
$file_tmp = $_FILES['upload']['tmp_name'];

move_uploaded_file($file_tmp, $getkategori['nama_kategori'].'/'.$nama_file);

          $data = array(
                  'nama' => $nama,
                  'kategori' => $cmbKategori,
                  'username' => $this->username,
                  'tanggal_upload' => $tanggal,
                );
          mysql_query(VulnWalkerInsert('images',$data));
          $cek = VulnWalkerInsert('images',$data);
        }
      }else{            
      $tanggal_update = explode('-',$tanggal_update);
          $data = array(
                  'nama' => $nama,
                  'kategori' => $cmbKategori,
                  'username' => $this->username,
                  'tanggal_upload' => $tanggal,
                );
        mysql_query(VulnWalkerUpdate('images',$data,"Id='$hubla'"));
        $cek = VulnWalkerUpdate('images',$data,"Id='$hubla'");
      } 
          $cek =$nama_file;
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

    case 'getdata':{
        $Id = $_REQUEST['id'];
        $k = substr($Id, 0,1);
        $l = substr($Id, 2,1);
        $m = substr($Id, 4,1);
        $n = substr($Id, 6,2);
        $o = substr($Id, 9,2);
        $get = mysql_fetch_array( mysql_query("select *, concat(k,'.',l,'.',m,'.',n,'.',o) as kode  from  where k='$k' AND l='$l' AND m='$m' AND n='$n' AND o='$o'"));
      
        
        $content = array('kode_' => $get['kode'], 'nm_' => $get['nm_']);
          
        
    break;
      }
    
    case 'modul':{
        foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
        }
        mysql_query("delete from temp_rincian_aplikasi_pemda where username = '$this->username'");  
        $idPenggunaAplikasi = $_cb[0];
        $getIdAplikasi = mysql_fetch_array(mysql_query("select * from $this->TblName where id = '$idPenggunaAplikasi'"));
        $idAplikasi = $getIdAplikasi['id_aplikasi'];
        $grabingAllSubModul = mysql_query("select * from ref_aplikasi where kode_aplikasi = '$idAplikasi' and kode_modul != '0' and kode_sub_modul !='0'");
        while($rows = mysql_fetch_array($grabingAllSubModul)){
            foreach ($rows as $key => $value) { 
            $$key = $value; 
          }
          
          if(mysql_num_rows(mysql_query("select * from rincian_aplikasi_pemda where id_aplikasi_pemda= '$idPenggunaAplikasi' and id_pemda = '".$getIdAplikasi['id_pemda']."' and id_aplikasi = '$kode_aplikasi' and id_modul = '$kode_modul' and id_sub_modul = '$kode_sub_modul'")) != 0){
            $status = "checked";
          }else{
            $status = "";
          }
            $data = array(  
                  'id_aplikasi_pemda' => $idPenggunaAplikasi,
                  'id_pemda' => $getIdAplikasi['id_pemda'],
                  'id_aplikasi' => $kode_aplikasi,
                  'id_modul' => $kode_modul,
                  'id_sub_modul' => $kode_sub_modul,
                  'status' => $status,
                  'username' => $this->username,
                  );
          mysql_query(VulnWalkerInsert("temp_rincian_aplikasi_pemda",$data));
          $cek ="select * from rincian_aplikasi_pemda where id_aplikasi_pemda= '$idPenggunaAplikasi' and id_pemda = '".$getIdAplikasi['id_pemda']."' and id_aplikasi = '$kode_aplikasi' and id_modul = '$kode_modul' and id_sub_modul = '$kode_sub_modul'";
        }
        
        $content = array('idAplikasi'=>$idAplikasi);
    break;
      }

    case 'formBaruSubModul':{     
        $id_kategori = $_REQUEST['id_kategori'];
        $fm = $this->setFormBaruSubModul($id_kategori);        
        $cek = $fm['cek'];
        $err = $fm['err'];
        $content = $fm['content'];                        
      break;
    }

    case 'simpanPemda':{
        foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
        }
        if(mysql_num_rows(mysql_query("select * from ref_pemda where nama_pemda = '$namaPemda'")) > 0){
          $err = "Pemda Sudah Ada";
        }else{
          $data = array('nama_pemda' => $namaPemda);
          mysql_query(VulnWalkerInsert('ref_pemda',$data));
          $idnya = mysql_fetch_array(mysql_query("select * from ref_pemda where nama_pemda = '$namaPemda'"));
          $content = array('replacer' => cmbQuery('cmbPemda',$idnya['id'],"select id,nama_pemda from ref_pemda",'style="width:500;"','-- Pilih Pemda --') );
        }
    break;
    }
    
    case 'simpanAplikasi':{
        foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
        }
        if(mysql_num_rows(mysql_query("select * from ref_aplikasi where nama_pemda = '$namaAplikasi'")) > 0){
          $err = "Aplikasi Sudah Ada";
        }else{
          $data = array('nama_aplikasi' => $namaAplikasi);
          mysql_query(VulnWalkerInsert('ref_aplikasi',$data));
          $idnya = mysql_fetch_array(mysql_query("select * from ref_aplikasi where nama_aplikasi = '$namaAplikasi'"));
          $content = array('replacer' => cmbQuery('cmbPemda',$idnya['id'],"select id,nama_aplikasi from ref_aplikasi",'style="width:500;"','-- Pilih Aplikasi --') );
        }
    break;
    }
    
    case 'editPemda':{
        foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
        }
        $data = array('nama_pemda' => $namaPemda);
        mysql_query(VulnWalkerUpdate("ref_pemda",$data,"id='$id'"));
        $idnya = mysql_fetch_array(mysql_query("select * from ref_pemda where nama_pemda = '$namaPemda'"));
        $content = array('replacer' => cmbQuery('cmbPemda',$idnya['id'],"select id,nama_pemda from ref_pemda",'style="width:500;"','-- Pilih Pemda --') );
    break;
    }
    case 'editAplikasi':{
        foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
        }
        $data = array('nama_aplikasi' => $namaAplikasi);
        mysql_query(VulnWalkerUpdate("ref_aplikasi",$data,"id='$id'"));
        $idnya = mysql_fetch_array(mysql_query("select * from ref_aplikasi where nama_aplikasi = '$namaAplikasi'"));
        $content = array('replacer' => cmbQuery('cmbAplikasi',$idnya['id'],"select id,nama_aplikasi from ref_aplikasi",'style="width:500;"','-- Pilih Aplikasi --') );
    break;
    }


      

    case 'formBaru':{       
      $fm = $this->setFormBaru();       
      $cek = $fm['cek'];
      $err = $fm['err'];
      $content = $fm['content'];                        
    break;
    }
    

    
    case 'formBaruPemda':{      
        $idPemda = $_REQUEST['idPemda'];
        $fm = $this->setFormBaruPemda($idPemda);        
        $cek = $fm['cek'];
        $err = $fm['err'];
        $content = $fm['content'];                        
      break;
    }
    case 'formBaruAplikasi':{     
        $idAplikasi = $_REQUEST['idAplikasi'];
        $fm = $this->setFormBaruAplikasi($idAplikasi);        
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
                         
    case 'formUpload':{        
      $fm = $this->setFormUpload();       
      $cek = $fm['cek'];
      $err = $fm['err'];
      $content = $fm['content'];                        
    break;
    }
    case 'newKategori':{       
      $fm = $this->setFormBaruKategori();       
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

   case 'saveEditKategori':{ 
        if ($_REQUEST['nama_kategori']=="") {
           $err = 'Error';
            
        }else{
          $id_kategori = $_REQUEST['cmbKategori']; 
          $nama_kategori = $_REQUEST['nama_kategori'];

          mysql_query("UPDATE images_kategori set nama='$nama_kategori' where id='$id_kategori'");

          $cek = "UPDATE kategori_arsip set nama_kategori='$nama_kategori' where id='$id_kategori'";
          $max = mysql_fetch_array(mysql_query("SELECT  * from kategori_arsip where id='$id_kategori'"));
          $data_max = $max['id'];
          $cmbKategori = cmbQuery('cmbKategori',$komboKategori,"select id,nama from images_kategori",'-- Select Option --');
          $content = array('cmbKategori' => $cmbKategori );     
        }                     
    break;
    }

     case 'SimpanKategori':{
        foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
        }
          if ($id_kategori != "") {
          $query = mysql_query("UPDATE images_kategori set nama = '$nama_kategori' where id = '$id_kategori' ");
          $cmbKategori = cmbQuery('cmbKategori',$id_kategori,"select id, nama from images_kategori ",'-- Pilih Kategori --');
          $content = array('replacer'=>$cmbKategori);
        }else{
          $query = mysql_query("INSERT into images_kategori values ('','$nama_kategori')");
          $ambil_id = mysql_fetch_array(mysql_query("SELECT max(id) from images_kategori"));
          $id_images = $ambil_id['max(id)'];
          $cmbKategori = cmbQuery('cmbKategori',$id_images,"select id, nama from images_kategori ",'-- Pilih Kategori --');
          $content = array('replacer'=>$cmbKategori);
        }        
        
    break;
    }

     case 'editKategori':{       
        $fm = $this->setFormeditKategori($_REQUEST['cmbKategori']);       
        $cek = $fm['cek'];
        $err = $fm['err'];
        $content = $fm['content'];                        
      break;
      }
    

      
    case 'simpanEdit':{
      $get= $this->simpanEdit();
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
    
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }
   


  
   function setFormBaruPemda($idPemda){
    
    $this->form_fmST = 0;
    
    $fm = $this->BaruPemda($idPemda);
    return  array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  }
  
   function setFormBaruAplikasi($idAplikasi){
    
    $this->form_fmST = 0;
    
    $fm = $this->BaruAplikasi($idAplikasi);
    return  array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  }

     function setFormBaruKategori(){
    
      $this->form_fmST = 0;
      
      $fm = $this->BaruKategori();
      return  array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
    }

       function setFormeditKategori($id_kategori){
    
      $this->form_fmST = 0;
      
      $fm = $this->editKategori($id_kategori);
      return  array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
    }
    

  function BaruSubModul($dt){
   global $SensusTmp, $Main;
   
   $cek = ''; $err=''; $content='';     
   $json = TRUE;  //$ErrMsg = 'tes';    
   $form_name = $this->Prefix.'_formKB';        
   $this->form_width = 500;
   $this->form_height = 80;
   
   if(!empty($dt)){
    $this->form_caption = 'Edit Kategori';
    $namaSubModul = mysql_fetch_array(mysql_query("select * from images_kategori where nama ='$dt'"));
    $namaSubModul = $namaSubModul['nama'];
   }else{
    if ($this->form_fmST==0) {
    $this->form_caption = 'Kategori Baru';


    $kemana = 'SimpanKategori()';
    
    }
   }
    
      //ambil data trefditeruskan
      $query = "" ;$cek .=$query;
      $res = mysql_query($query);
    
    
   //items ----------------------
    $this->form_fields = array(
      
      'Kelompok' => array( 
            'label'=>'Nama Kategori',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='nama_kategori' id='nama_kategori' value='$namaSubModul' style='width:255px;' >

            </div>", 
             ), 
      );
    //tombol
    $this->form_menubawah =
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".simpanMerek($dt)' title='Simpan' >"."&nbsp&nbsp".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
              
    $form = $this->genFormKB();
    $content = $form;
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

  function setFormBaruSubModul($id_kategori){
    
    $this->form_fmST = 0;
    
    $fm = $this->BaruSubModul($id_kategori);
    return  array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  }
  
  function BaruPemda($dt){  
   global $SensusTmp, $Main;
   
   $cek = ''; $err=''; $content='';     
   $json = TRUE;  //$ErrMsg = 'tes';    
   $form_name = $this->Prefix.'_formKB';        
   $this->form_width = 500;
   $this->form_height = 80;
   
   if(!empty($dt)){
    $this->form_caption = 'Edit Pemda';
    $kemana = "EditPemda($dt)";
    $namaPemda = mysql_fetch_array(mysql_query("select * from ref_pemda where id='$dt'"));
    $namaPemda = $namaPemda['nama_pemda'];
   }else{
    if ($this->form_fmST==0) {
    $this->form_caption = 'Baru Pemda';
    $nip   = '';
    $KA1 = $_REQUEST ['fmKA'];
      
    $kemana = 'SimpanPemda()';
    
    }
   }
    
      //ambil data trefditeruskan
      $query = "" ;$cek .=$query;
      $res = mysql_query($query);
    
    
   //items ----------------------
    $this->form_fields = array(
      
      'Kelompok' => array( 
            'label'=>'Nama Pemda',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='namaPemda' id='namaPemda' value='$namaPemda' style='width:255px;' >

            </div>", 
             ), 
                        
        
      );
    //tombol
    $this->form_menubawah =
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".$kemana' title='Simpan' >"."&nbsp&nbsp".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
              
    $form = $this->genFormKB();   
    $content = $form;
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

   function editKategori($dt){  
   global $SensusTmp, $Main;
   
   $cek = ''; $err=''; $content='';     
   $json = TRUE;  //$ErrMsg = 'tes';    
   $form_name = $this->Prefix.'_formKB';        
   $this->form_width = 500;
   $this->form_height = 80;
   
   if(!empty($dt)){
    $this->form_caption = 'Edit Kategori';
    $kemana = "saveEditKategori($dt)";
    $nama_kategori = mysql_fetch_array(mysql_query("select * from images_kategori where id='$dt'"));
    $nama_kategori = $nama_kategori['nama'];
   }else{
    if ($this->form_fmST==0) {
    $this->form_caption = 'Baru Kategori';
    $nip   = '';
    $KA1 = $_REQUEST ['fmKA'];
      
    
    }
   }
    
      //ambil data trefditeruskan
      $query = "" ;$cek .=$query;
      $res = mysql_query($query);
    
    
   //items ----------------------
    $this->form_fields = array(
      
      'Kelompok' => array( 
            'label'=>'Nama Kategori',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='nama_kategori' id='nama_kategori' value='$nama_kategori' style='width:255px;' >

            </div>", 
             ), 
                        
        
      );
    //tombol
    $this->form_menubawah =
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".$kemana' title='Simpan' >"."&nbsp&nbsp".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
              
    $form = $this->genFormKB();   
    $content = $form;
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }
  
  function BaruKategori(){  
   global $SensusTmp, $Main;
   
   $cek = ''; $err=''; $content='';     
   $json = TRUE;  //$ErrMsg = 'tes';    
   $form_name = $this->Prefix.'_formKB';        
   $this->form_width = 500;
   $this->form_height = 80;
   
    if ($this->form_fmST==0) {
    $this->form_caption = 'Baru Kategori';
    $nip   = '';
    $KA1 = $_REQUEST['fmKA'];
    }
      //ambil data trefditeruskan
      $query = "" ;$cek .=$query;
      $res = mysql_query($query);
    
   //items ----------------------
    $this->form_fields = array(
      
      'Kelompok' => array( 
            'label'=>'Nama Kategori',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='nama_kategori' id='nama_kategori' style='width:255px;' >

            </div>", 
             ), 
                        
        
      );
    //tombol
    $this->form_menubawah =
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanKategori()' title='Simpan' >"."&nbsp&nbsp".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
              
    $form = $this->genFormKB();   
    $content = $form;
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }


  function BaruAplikasi($dt){ 
   global $SensusTmp, $Main;
   
   $cek = ''; $err=''; $content='';     
   $json = TRUE;  //$ErrMsg = 'tes';    
   $form_name = $this->Prefix.'_formKB';        
   $this->form_width = 500;
   $this->form_height = 80;
   
   if(!empty($dt)){
    $this->form_caption = 'Edit Aplikasi';
    $kemana = "EditAplikasi($dt)";
    $namaAplikasi = mysql_fetch_array(mysql_query("select * from ref_aplikasi where id='$dt'"));
    $namaAplikasi = $namaAplikasi['nama_aplikasi'];
   }else{
    if ($this->form_fmST==0) {
    $this->form_caption = 'Baru Aplikasi';
    $nip   = '';

      
    $kemana = 'SimpanAplikasi()';
    
    }
   }
    
      //ambil data trefditeruskan
      $query = "" ;$cek .=$query;
      $res = mysql_query($query);
    
    
   //items ----------------------
    $this->form_fields = array(
      
      'Kelompok' => array( 
            'label'=>'Nama Aplikasi',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='namaAplikasi' id='namaAplikasi' value='$namaAplikasi' style='width:255px;' >

            </div>", 
             ), 
                        
        
      );
    //tombol
    $this->form_menubawah =
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".$kemana' title='Simpan' >"."&nbsp&nbsp".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
              
    $form = $this->genFormKB();   
    $content = $form;
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }
  
  function genFormKB($withForm=TRUE, $params=NULL, $center=TRUE){ 
    $form_name = $this->Prefix.'_KBform'; 
    
    if($withForm){
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
          <input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
          $this->form_menu_bawah_height,'',$params).
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
          <input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
          $this->form_menu_bawah_height,'',$params
        );
    }
    
    if($center){
      $form = centerPage( $form );  
    }
    return $form;
  }

  function setPage_HeaderOther(){
      
  return 
  "<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
  <tr>
  <td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
  <A href=\"pages.php?Pg=ref_aplikasi\" title='RKBMD PENGADAAN MURNI' > APLIKASI </a> |
  <A href=\"pages.php?Pg=ref_pemda\" title='RKBMD PENGADAAN MURNI' > PEMDA </a> |
  <A href=\"pages.php?Pg=\" title='RKBMD PEMELIHARAAN MURNI'  style='color : blue;' > PEGAWAI </a> |
  &nbsp&nbsp&nbsp 
  </td>
  </tr>
  </table>"
  ;
  }
  
  
  function setPage_OtherScript(){
    $getUserInfo = mysql_fetch_array(mysql_query("select * from admin where uid ='$this->username'"));
    foreach ($getUserInfo as $key => $value) { 
        $$key = $value; 
      } 
    if($level != '1'){
    
      $scriptload = 
          "<script>
            alert('Akses Ditolak');
            history.go(-1);
          </script>";
      
    }else{
      $scriptload = 
          "<script>
            $(document).ready(function(){ 
              ".$this->Prefix.".loading();
            });
          </script>";
    }
    return 
       "<script src='js/skpd.js' type='text/javascript'></script>
       <script type='text/javascript' src='js/ref_images/ref_images.js' language='JavaScript' ></script>
       <script type='text/javascript' src='js/ref_aplikasi_pemda/popupOption.js' language='JavaScript' ></script>
       
       ".'<link rel="stylesheet" href="datepicker/jquery-ui.css">
        <script src="datepicker/jquery-1.12.4.js"></script>
        <script src="datepicker/jquery-ui.js"></script>'.
      
      $scriptload;
  }
  
  function setFormBaru(){
    $cek =$cbid[0];       
    $this->form_idplh = $cbid[0];
    $kode = explode(' ',$this->form_idplh);
    $this->form_fmST = 0;
    $dt['readonly']='';
    $fmBIDANG = $_REQUEST['fmBIDANG'];
    $fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
    $fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
    $fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
    if(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
    {
      $dt['kode_jurnal']=$fmBIDANG.'.';
    }
    elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
    {
      $dt['kode_jurnal']=$fmBIDANG.'.'.$fmKELOMPOK.'.';
    }
    elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
    {
      $dt['kode_jurnal']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.';
    }
    elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
    {
      $dt['kode_jurnal']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.$fmSUBSUBKELOMPOK.'.';
    }
    $fm = $this->setForm($dt);    
    return  array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  } 
   
    function setFormEdit(){
    $cek ='';
    
    foreach ($_REQUEST as $key => $value) { 
        $$key = $value; 
      }
    $this->form_fmST = 1;
    
    $fm = $this->setForm($ref_images_cb[0]);
    
    return  array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  } 

    function setFormUpload(){
    $cek ='';
    
    foreach ($_REQUEST as $key => $value) { 
        $$key = $value; 
      }
    $this->form_fmST = 1;
    
    $fm = $this->setUpload($ref_images_cb[0]);
    
    return  array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
  } 
  
  function setFormEditdata($dt){  
   global $SensusTmp ,$Main;
   
   $cek = ''; $err=''; $content=''; 
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';        
   $this->form_width = 490;
   $this->form_height = 150;
    if ($this->form_fmST==1) {
    $this->form_caption = 'FORM EDIT KODE ';
    }
   
    $cbid = $_REQUEST[$this->Prefix.'_cb'];
    $this->form_idplh = $cbid[0];
    $kode = explode(' ',$this->form_idplh);
    $this->form_fmST = 1; 
    $k=$kode[0];
    $l=$kode[1];
    $m=$kode[2];
    $n=$kode[3];
    $o=$kode[4];
    
    
    
    $queryKAedit=mysql_fetch_array(mysql_query("SELECT k, nm_ FROM  WHERE k='$k' and l = '0' and m='0' and n='00' and o='00'")) ;
    $cek.=$queryKAedit;
    $queryKBedit=mysql_fetch_array(mysql_query("SELECT l, nm_ FROM  WHERE k='$k' and l='$l' and m= '0' and n='00' and o='00'")) ;
    $queryKCedit=mysql_fetch_array(mysql_query("SELECT m, nm_ FROM  WHERE k='$k' and l='$l' and m='$m' and n='00' and o='00'")) ;
    $queryKDedit=mysql_fetch_array(mysql_query("SELECT n, nm_ FROM  WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='00'")) ;
    $queryKEedit=mysql_fetch_array(mysql_query("SELECT o, nm_ FROM  WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o'")) ;
  //  $cek.="SELECT ke, nm_account FROM ref_jurnal WHERE ka='$data_ka' and kb='$data_kb' and kc='$data_kc' and kd='$data_kd' and ke='$data_ke' and kf='0'";
          
  
    $datka=$queryKAedit['k'].".  ".$queryKAedit['nm_'];
    $datkb=$queryKBedit['l'].". ".$queryKBedit['nm_'];
    $datkc=$queryKCedit['m']." .  ".$queryKCedit['nm_'];
    $datkd=$queryKDedit['n'].". ".$queryKDedit['nm_'];
    $datke=$queryKEedit['o'];
  //  $datke=sprintf("%02s",$queryKEedit['ke'])." .  ".$queryKEedit['nm_account'];
    
       //items ----------------------
      $this->form_fields = array(
      
      'kode_Akun' => array( 
            'label'=>'kode ',
            'labelWidth'=>120, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='ek' id='ek' value='".$datka."' style='width:270px;' readonly>
            <input type ='hidden' name='k' id='k' value='".$queryKAedit['k']."'>
            </div>", 
             ),
      'kode_kelompok' => array( 
            'label'=>'Kode Kelompok',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='el' id='el' value='".$datkb."' style='width:270px;' readonly>
            <input type ='hidden' name='l' id='l' value='".$queryKBedit['l']."'>
            </div>", 
             ),
      'kode_Jenis' => array( 
            'label'=>'kode Jenis',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='em' id='em' value='".$datkc."' style='width:270px;' readonly>
            <input type ='hidden' name='m' id='m' value='".$queryKCedit['m']."'>
            </div>", 
             ),
      'kode_Objek' => array( 
            'label'=>'kode Objek',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='en' id='en' value='".$datkd."' style='width:270px;' readonly>
            <input type ='hidden' name='n' id='n' value='".$queryKDedit['n']."'>
            </div>", 
             ),
      'Kode_Rincian_Objek' => array( 
            'label'=>'Kode Rincian Objek',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='eo' id='eo' value='".$datke."' style='width:20px;' readonly>
            <input type ='hidden' name='o' id='o' value='".$queryKEedit['o']."'>
            <input type='text' name='nm_' id='nm_' value='".$dt['nm_']."' size='36px'>
            </div>", 
             ),                  
                   
     
      
      /*'Nama' => array( 
            'label'=>'Nama',
            //'id'=>'cont_object',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'><input type='text' name='nm_account' id='nm_account' value='".$dt['nm_account']."' size='40px'>
            </div>", 
             ),   */         
      );
    //tombol
    $this->form_menubawah = 
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanEdit()' title='Simpan' >"."&nbsp&nbsp".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
      "<input type='hidden' name='ka' id='ka' value='".$dt['ka']."'>".
      "<input type='hidden' name='kb' id='kb' value='".$dt['kb']."'>".
      "<input type='hidden' name='kc' id='kc' value='".$dt['kc']."'>".
      "<input type='hidden' name='kd' id='kd' value='".$dt['kd']."'>".
      "<input type='hidden' name='ke' id='ke' value='".$dt['ke']."'>".
              
    $form = $this->genForm();   
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

  function setUpload($dt){  
   global $SensusTmp ,$Main;
   $cek = ''; $err=''; $content='';     
   $json = TRUE;  //$ErrMsg = 'tes';    
   $form_name = $this->Prefix.'_form';
        
  $this->form_width = 500;
   $this->form_height = 200;
    if ($this->form_fmST==0) {
    $this->form_caption = 'Baru';
    
  //  $nip   = '';
    }else{
    $this->form_caption = 'Edit';     
    $readonly='readonly';
    $get = mysql_fetch_array(mysql_query("select * from images where id ='$dt'"));
    foreach ($get as $key => $value) { 
        $$key = $value; 
      } 
    $tanggal_update = explode("-",$tanggal_update);
    $tanggal_update = $tanggal_update[2]."-".$tanggal_update[1]."-".$tanggal_update[0];     
    }
   //items ----------------------
    $getdatakategori = mysql_fetch_array(mysql_query("SELECT * FROM images where id='$id_kategori'"));
    $this->form_fields = array(
      
            
                 'Upload' => array( 
                'label'=>'Upload',
                'labelWidth'=>100, 
                'value'=>
                "<form></form>".
                "<form action='pages.php?Pg=processuploadfilearsip' method='post' enctype='multipart/form-data' id='UploadForm'>".
                "<input type='hidden' id='id' name='id' value='".$id."' >".
                 "<input type='hidden' id='folder' name='folder' value='".$getdatakategori['nama_kategori']."' >".
                "<input id='ImageFile' name='ImageFile' type='file'  onchange=\"".$this->Prefix.".btfile_onchange();\" />"
                          ."</form>", 
                ),
      );
    
              
    $form = $this->genForm();   
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }
    
  function setForm($dt){  
   global $SensusTmp ,$Main;
   $cek = ''; $err=''; $content='';     
   $json = TRUE;  //$ErrMsg = 'tes';    
   $form_name = $this->Prefix.'_form';
        
  $this->form_width = 500;
   $this->form_height = 200;
    if ($this->form_fmST==0) {
    $this->form_caption = 'Baru';
    
  //  $nip   = '';
    }else{
    $this->form_caption = 'Edit';     
    $readonly='readonly';
    $get = mysql_fetch_array(mysql_query("select * from arsip where id ='$dt'"));
    foreach ($get as $key => $value) { 
        $$key = $value; 
      } 
    $tanggal_update = explode("-",$tanggal_update);
    $tanggal_update = $tanggal_update[2]."-".$tanggal_update[1]."-".$tanggal_update[0];     
    }
    
               $cmbKategori = cmbQuery('cmbKategori',$nama_kategori,"SELECT id,nama from images_kategori ",'-- Select Option --');
               $id_terakhir = mysql_fetch_array(mysql_query("SELECT max(id) FROM arsip"));
   //items ----------------------
    $this->form_fields = array(
      
        
      'nama' => array( 
            'label'=>'NAMA',
            'labelWidth'=>100, 
            'value'=>"<div style='float:left;'>
            <input type='text' name='nama' id='nama' value='".$nama."' placeholder='NAMA' style='width:250px;'>
            </div>", 
             ),

      'kategori' => array( 
          'label'=>'KATEGORI',
          'labelWidth'=>100, 
          'value'=>"<div style='float:left;'>
            $cmbKategori
          <input type='button' name='warnaBaru' id='warnaBaru' value='Baru' onclick ='".$this->Prefix.".newKategori()'>
          <input type='button' name='edit' id='edit' value='Edit' onclick ='".$this->Prefix.".editKategori()'>
          </div>", 
          ),

      'username' => array(
            'label' => 'USERNAME',
            'labelWidth' => 100,
            'value' => "<div style='float:left;'>
            <input type='text' readonly name='username' id='username' value='".$_COOKIE['coID']."'
              placeholder='username' style='width:250px;'>
            </div>",
          ),

      'tanggal' => array(
            'label' => 'TANGGAL',
            'labelWidth' => 100,
            'value' => "<div style='float:left;'>
            <input type='date' name='tanggal' id='tanggal' value='".date('Y-m-d')."'
              placeholder='tanggal' style='width:250px;'>
            </div>",
          ),
      'image' => array(
            'label' => 'IMAGE',
            'labelWidth' => 100,
            'value' => "
            <form action='upload.php' method='post' enctype='multipart/form-data'>
              <div style='float:left;'>
                <input type='file' name='fileToUpload' id='fileToUpload' value='".$fileToUpload."' placeholder='image'>
              </div>
            </form>",
          ),                     

      );
    //tombol
    $this->form_menubawah =
      
      "<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan($dt)' title='Simpan' > &nbsp".
      "<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
              
    $form = $this->genForm();   
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }
  
  /*function setPage_HeaderOther(){
  return 
      "<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
  <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
  <A href=\"pages.php?Pg=ref_skpd\" title='Skpd'  >Skpd</a> | 
  <A href=\"pages.php?Pg=\" title='' style='color:blue'  ></a> |
  <A href=\"pages.php?Pg=ref_satuan\" title='Satuan'  >Satuan</a> |
  <A href=\"pages.php?Pg=ref_kepala_skpd\" title='Kepala Skpd'  >Kepala Skpd</a> |
  <A href=\"pages.php?Pg=ref_pengesahan\" title='Pengesahan'   >Pengesahan</a> |
  <A href=\"pages.php?Pg=ref_tapd\" title='Tapd'   >Tapd</a> |
  <A href=\"pages.php?Pg=ref_program\" title='Program & Kegiatan'   >Program & Kegiatan</a> |
  <A href=\"pages.php?Pg=ref_sumber_dana\" title='Sumber Dana'   >Sumber Dana</a> |
  
  </td></tr></table>";
  "<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>";
  
  }*/
    
  //daftar =================================
  function setKolomHeader($Mode=1, $Checkbox=''){
    $NomorColSpan = $Mode==1? 2: 1;
    $headerTable =
      "<thead>
        <tr>
        
        <th class='th01' width='40'>No.</th>
        $Checkbox   
        <th class='th01' >ID </th>
        <th class='th01' >NAMA </th>
        <th class='th01' >KATEGORI </th>
        <th class='th01' >USERNAME </th>
        <th class='th01' >TANGGAL UPLOAD </th>
        <th class='th01' >DIRECTORY </th>
        </tr>
        
      </thead>";
    return $headerTable;
  }
  
  function setKolomData($no, $isi, $Mode, $TampilCheckBox){
  $query = mysql_fetch_array(mysql_query("SELECT * from kategori_arsip where id='".$isi['id_kategori']."'"));
    
   if($isi['file'] != ''){
    $file2 = "<a download='".$isi['file']."' href='Media/". $query['nama_kategori']."/".$isi['file']."' title='Klik Untuk Download'>DOWNLOAD ARSIP</a>";
    
   }else{
    $file2="";
   }

    global $Ref;
    $Koloms = array();
    $Koloms[] = array('align=right', $no.'.' );
    if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
    $nama_kategori = $query['nama_kategori'];
    $Koloms[] = array('', $isi['id']);
    $Koloms[] = array('', $isi['nama']);
    $sql_images_k = mysql_fetch_array(mysql_query("SELECT * from images"));
    $get_images_k = $sql_images_k['kategori'];
    $sql_images_n = mysql_fetch_array(mysql_query("SELECT * from images_kategori where id = '".$get_images_k."' "));
    $Koloms[] = array('', $sql_images_n['nama']);
    $Koloms[] = array('', $isi['username']);
    $Koloms[] = array('', $isi['tanggal_upload']);
    $Koloms[] = array('', $isi['directory']);
    
    $Koloms[] = array('', $file2);    
    return $Koloms;
  }
  
  function genDaftarOpsi(){
   global $Ref, $Main;
   foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
        }
  $fmPILCARI = $_REQUEST['fmPILCARI'];  
  $fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];    
  //tgl bulan dan tahun
  $fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
  $fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
  $fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
  $fmORDER1 = cekPOST('fmORDER1');
  $fmDESC1 = cekPOST('fmDESC1');
   $arrOrder =  array(
                array('1','ID'),
                array('2','Kategori'),
                array('3','Nama'),
          );
  $arr = array(
      //array('selectAll','Semua'), 
      array('selectId','ID'), 
      array('selectId_kategori','Kategori'),
      array('selectuidNama','Nama'),    
      );
  $TampilOpt =
      
      $vOrder=      
      genFilterBar(
        array(              
          cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Cari Data --',''). //generate checkbox         
          "&nbsp&nbsp<input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue' uid='fmPILCARIvalue'>&nbsp&nbsp"
          //<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>"
          
          .cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--Urutkan--','').
          "<input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'>&nbspmenurun."
          ),      
        $this->Prefix.".refreshList(true)");
      "<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";
      
    return array('TampilOpt'=>$TampilOpt);
  } 
  
  function getDaftarOpsi($Mode=1){
    global $Main, $HTTP_COOKIE_VARS;
    $UID = $_COOKIE['coID']; 
    //kondisi -----------------------------------
    $arrKondisi = array();  
    $fmPILCARI = $_REQUEST['fmPILCARI'];  
    $fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
    /*$ref_skpdSkpdfmSEKSI = $_REQUEST['ref_skpdSkpdfmSEKSI'];//ref_skpdSkpdfmSKPD
    $ref_skpdSkpdfmSKPD = $_REQUEST['ref_skpdSkpdfmSKPD'];
    $ref_skpdSkpdfmUNIT = $_REQUEST['ref_skpdSkpdfmUNIT'];
    $ref_skpdSkpdfmSUBUNIT = $_REQUEST['ref_skpdSkpdfmSUBUNIT'];*/
    //Cari 
    $isivalue=explode('.',$fmPILCARIvalue);
    switch($fmPILCARI){     
      //case 'selectKode': $arrKondisi[] = " c='".$isivalue[0]."' and d='".$isivalue[1]."' and e='".$isivalue[2]."' and e1='".$isivalue[3]."'"; break;
      case 'selectId': $arrKondisi[] = " Id like '$fmPILCARIvalue%'"; break;
      case 'selectId_kategori': $arrKondisi[] = " id_kategori like '%$fmPILCARIvalue%'"; break;
      case 'selectuidNama' : $arrKondisi[] = " id_kategori like '%$fmPILCARIvalue%'"; break;
                  
    } 
    /*if($ref_skpdSkpdfmSKPD!='00' and $ref_skpdSkpdfmSKPD !='')$arrKondisi[]= "c='$ref_skpdSkpdfmSKPD'";
    if($ref_skpdSkpdfmUNIT!='00' and $ref_skpdSkpdfmUNIT !='')$arrKondisi[]= "d='$ref_skpdSkpdfmUNIT'";
    if($ref_skpdSkpdfmSUBUNIT!='00' and $ref_skpdSkpdfmSUBUNIT !='')$arrKondisi[]= "e='$ref_skpdSkpdfmSUBUNIT'";
    if($ref_skpdSkpdfmSEKSI!='00' and $ref_skpdSkpdfmSEKSI !='')$arrKondisi[]= "e1='$ref_skpdSkpdfmSEKSI'";*/
    /*$arrKondisi = array();
    
    $fmPILCARI = $_REQUEST['fmPILCARI'];  
    $fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
    //cari tgl,bln,thn
    $fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];      
    $fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
    $fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
    //Cari 
    switch($fmPILCARI){     
      case 'selectNama': $arrKondisi[] = " nama_pasien like '%$fmPILCARIvalue%'"; break;
      case 'selectAlamat': $arrKondisi[] = " alamat like '%$fmPILCARIvalue%'"; break;             
    }
    if(!empty($fmFiltTglBtw_tgl1)) $arrKondisi[]= " tgl_daftar>='$fmFiltTglBtw_tgl1'";
    if(!empty($fmFiltTglBtw_tgl2)) $arrKondisi[]= " tgl_daftar<='$fmFiltTglBtw_tgl2'";  */
    // $arrKondisi[]="nama = 'Egi Suregy'";
    $Kondisi = join(' and ',$arrKondisi);   
    $Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
    
    //Order -------------------------------------
    $fmORDER1 = cekPOST('fmORDER1');
    $fmDESC1 = cekPOST('fmDESC1');      
    $Asc1 = $fmDESC1 ==''? '': 'desc';    
    $arrOrders = array();
    switch($fmORDER1){
      case '1': $arrOrders[] = " id $Asc1 " ;break;
      case '2': $arrOrders[] = " id_kategori $Asc1 " ;break;
      case '3': $arrOrders[] = " nama $Asc1 " ;break;
      
    }
    $Order= join(',',$arrOrders); 
    $OrderDefault = '';// Order By no_terima desc ';
    $Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
    //$Order ="";
    //limit --------------------------------------
    /**$HalDefault=cekPOST($this->Prefix.'_hal',1); //Cat:Settingan Lama        
    $Limit = " limit ".(($HalDefault  *1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
    $Limit = $Mode == 3 ? '': $Limit;
    //noawal ------------------------------------
    $NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);             
    $NoAwal = $Mode == 3 ? 0: $NoAwal;    
    **/
    $pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
    $HalDefault=cekPOST($this->Prefix.'_hal',1);          
    //$Limit = " limit ".(($HalDefault  *1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
    $Limit = " limit ".(($HalDefault  *1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
    $Limit = $Mode == 3 ? '': $Limit;
    //noawal ------------------------------------
    $NoAwal= $pagePerHal * (($HalDefault*1) - 1);             
    $NoAwal = $Mode == 3 ? 0: $NoAwal;  
    
    return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
    
  }
}
$ref_images = new ref_imagesObj();
$ref_images->username = $_COOKIE['coID'];
?>