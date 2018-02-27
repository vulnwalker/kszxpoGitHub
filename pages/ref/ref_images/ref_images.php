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
  var $PageTitle = 'IMAGES MANAGEMENT';
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
  function setPage_HeaderOther(){
   		
		return 
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
		<tr>
		<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=generalSetting\"   > SETTING </a> |
		<A href=\"pages.php?Pg=onepage\"   > SYSTEM </a> |
		<A href=\"pages.php?Pg=menuBar\"   > MENU BAR </a> |
		<A href=\"pages.php?Pg=shortcut\"   > SHORTCUT </a> |
		
		<A href=\"pages.php?Pg=footer\"   > FOOTER </a> |
    <A href=\"pages.php?Pg=ref_images\" style='color : blue;'  > IMAGES </a> |
		&nbsp&nbsp&nbsp	
		</td>
		</tr>
		</table>"
		;
	}	
  function setMenuEdit(){
    $getUserInfo = mysql_fetch_array(mysql_query("select * from admin where uid ='$this->username'"));
    foreach ($getUserInfo as $key => $value) { 
        $$key = $value; 
      } 
    
      return
            /*      "<td>".genPanelIcon("javascript:".$this->Prefix.".Upload()","upload.png","Upload", 'Upload')."</td>".*/
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
  

  function baseToImage($base64_string, $output_file) {

	    $ifp = fopen( $output_file, 'wb' ); 
	    $data = explode( ',', $base64_string );

	    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

	    fclose( $ifp ); 
	
	    return $output_file; 
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
    if(empty($nama)){
		$err = "Isi Nama";
	}elseif(empty($cmbKategori)){
		$err = "Pilih Kategori";
	}
      if($fmST == 0){
	  	if(empty($nameOfFile))$err="Pilih File";
        if($err == ''){
			$getKategoriName = mysql_fetch_array(mysql_query("select * from images_kategori where id ='$cmbKategori'"));
			$namaKategori = $getKategoriName['nama'];			
			$arrayFile = explode('.',$nameOfFile);
			$panjangArray = sizeof($arrayFile) - 1;
			$extensiFile =  $arrayFile[$panjangArray];
			$fileName = md5($nama).".".$extensiFile;
			$imageLocation = "Media/images/".$namaKategori."/".md5($nama).".".$extensiFile;	
			$this->baseToImage($baseOfFile,$imageLocation);
		  
          $data = array(
                  'nama' => $nama,
                  'kategori' => $cmbKategori,
                  'username' => $this->username,
				  'directory' => $fileName,
                  'tanggal_upload' => $tanggal,
                );
          mysql_query(VulnWalkerInsert('images',$data));
          $cek = VulnWalkerInsert('images',$data);
        }
      }else{            
    		 $tanggal_update = explode('-',$tanggal_update);
			if(!empty($nameOfFile)){
				$getDataSemula = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$hubla'"));
				$getNamaKategoriSemula = mysql_fetch_array(mysql_query("select * from images_kategori where id ='".$getDataSemula['kategori']."'"));	
				$oldFileName = "Media/images/".$getNamaKategoriSemula['nama']."/".$getDataSemula['directory'];
				unlink($oldFileName);
			
				$getKategoriName = mysql_fetch_array(mysql_query("select * from images_kategori where id ='$cmbKategori'"));
				$namaKategori = $getKategoriName['nama'];			
				$arrayFile = explode('.',$nameOfFile);
				$panjangArray = sizeof($arrayFile) - 1;
				$extensiFile =  $arrayFile[$panjangArray];
				$fileName = md5($nama).".".$extensiFile;
				$imageLocation = "Media/images/".$namaKategori."/".md5($nama).".".$extensiFile;	
				$this->baseToImage($baseOfFile,$imageLocation);
			}	  
			  
           $data = array(
                  'nama' => $nama,
                  'kategori' => $cmbKategori,
                  'username' => $this->username,
                  'tanggal_upload' => $tanggal,
				  'directory' => $fileName,
                );
        mysql_query(VulnWalkerUpdate('images',$data,"id='$hubla'"));
        $cek = VulnWalkerUpdate('images',$data,"id='$hubla'");
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
	
		case 'showImage':{				
			$fm = $this->showImage($_REQUEST['id']);				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
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
		  
		  $getDirectoryAwal = mysql_fetch_array(mysql_query("select * from images_kategori where id='$id_kategori'"));
		  $checkDuplicateDir = mysql_num_rows(mysql_query("select * from images_kategori where nama='$nama_kategori' and id!='$id_kategori'"));
		  if($checkDuplicateDir !=0){
		  	$err = "Directory sudah ada";
		  }else{
		  		$oldname = "Media/images/".$getDirectoryAwal['nama'];
			  	$newname = "Media/images/".$nama_kategori;
			  	rename($oldname, $newname);
		  		mysql_query("UPDATE images_kategori set nama='$nama_kategori' where id='$id_kategori'");

	          $cek = "UPDATE kategori_arsip set nama_kategori='$nama_kategori' where id='$id_kategori'";
	          $max = mysql_fetch_array(mysql_query("SELECT  * from kategori_arsip where id='$id_kategori'"));
	          $data_max = $max['id'];
	          $cmbKategori = cmbQuery('cmbKategori',$komboKategori,"select id,nama from images_kategori",'-- Select Option --');
	          $content = array('cmbKategori' => $cmbKategori );     
		  }

          
        }                     
    break;
    }

     case 'SimpanKategori':{
        foreach ($_REQUEST as $key => $value) { 
          $$key = $value; 
        }
        if($id_kategori != "") {
		  $getDirectoryAwal = mysql_fetch_array(mysql_query("select * from images_kategori where id='$id_kategori'"));
		  $checkDuplicateDir = mysql_num_rows(mysql_query("select * from images_kategori where nama='$nama_kategori' and id!='$id_kategori'"));
		  if($checkDuplicateDir !=0){
		  	$err = "Directory sudah ada";
		  }else{
		  	$oldname = "Media/images/".$getDirectoryAwal['nama'];
		  	$newname = "Media/images/".$nama_kategori;
		  	rename($oldname, $newname);
		  	$query = mysql_query("UPDATE images_kategori set nama = '$nama_kategori' where id = '$id_kategori' ");
	        $cmbKategori = cmbQuery('cmbKategori',$id_kategori,"select id, nama from images_kategori ",'-- Pilih Kategori --');
	        $content = array('replacer'=>$cmbKategori);
		  }

          
        }else{
		  if (!file_exists('Media/images/'.$nama_kategori)) {
			    mkdir('Media/images/'.$nama_kategori, 0777, true);
				 $query = mysql_query("INSERT into images_kategori values ('','$nama_kategori')");
		          $ambil_id = mysql_fetch_array(mysql_query("SELECT max(id) from images_kategori"));
		          $id_images = $ambil_id['max(id)'];
		          $cmbKategori = cmbQuery('cmbKategori',$id_images,"select id, nama from images_kategori ",'-- Pilih Kategori --');
		  }else{
		  	 	$err = "Kategori Sudah ada";
		  }
          
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
  
  function showImage($id){	
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];	
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 150;
	 $this->form_height = 150;
	  
		$this->form_caption = 'GAMBAR';
		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
		
		

			$idImagePasif = $getData['id'];
			$getImagePasif = mysql_fetch_array(mysql_query("select * from images where id ='$idImagePasif'"));
			$namaImagePasif = $getImagePasif['nama'];
			$getDirPasif = mysql_fetch_array(mysql_query("select * from images_kategori where id='".$getImagePasif['kategori']."'"));
			$imagePasifLocation = "Media/images/".$getDirPasif['nama']."/".$getImagePasif['directory'];
			$imageViewPasif = "<img style='width:120px;height:120px; ' src='$imagePasifLocation'/>";
	
	   
	
       //items ----------------------
		  $this->form_fields = array(
		  

						 
			 

			'asd' => array( 
						'label'=>'IMAGE',
						'labelWidth'=>100, 
						'value'=>"<span id='spanImagePasif'>$imageViewPasif </span> ",
						'type' => 'merge'
						 ),	
			
			);
		//tombol
		$this->form_menubawah =	
			
			"<input type='button' value='Close' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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
    	$kategori = $_REQUEST['filterKategori'];
  //  $nip   = '';
    }else{
    $this->form_caption = 'Edit';     
    $readonly='readonly';
    $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$dt'"));
    foreach ($get as $key => $value) { 
        $$key = $value; 
      } 
    $tanggal_update = explode("-",$tanggal_update);
    $tanggal_update = $tanggal_update[2]."-".$tanggal_update[1]."-".$tanggal_update[0];     
    }
    
               $cmbKategori = cmbQuery('cmbKategori',$kategori,"SELECT id,nama from images_kategori ",'-- Select Option --');
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

      'image' => array(
            'label' => 'IMAGE',
            'labelWidth' => 100,
            'value' => "
             <input type='hidden' name='tanggal' id='tanggal' value='".date('Y-m-d')."'
              placeholder='tanggal' style='width:250px;'>
			  <input type='hidden' name='nameOfFile' id='nameOfFile' >
			  <input type='hidden' name='baseOfFile' id='baseOfFile' >
                <input type='file' name='imageFile' id='imageFile' accept='image/x-png,image/gif,image/jpeg' onchange=$this->Prefix.fileChooserChanged() placeholder='image'>
            ",
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
  

    
  //daftar =================================
  function setKolomHeader($Mode=1, $Checkbox=''){
    $NomorColSpan = $Mode==1? 2: 1;
    $headerTable =
      "<thead>
        <tr>
        
        <th class='th01' width='40'>No.</th>
        $Checkbox  
		 <th class='th01' width='400' >KATEGORI </th> 
        <th class='th01' width='500' >NAMA </th>
       
        <th class='th01' width='50' >USERNAME </th>
        <th class='th01' width='150' >TANGGAL UPLOAD </th>
        <th class='th01' width='50' >IMAGE FILE </th>
        </tr>
        
      </thead>";
    return $headerTable;
  }
  
  function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	
    global $Ref;
	foreach ($isi as $key => $value) { 
				  $$key = $value; 
				}
    $Koloms = array();
    $Koloms[] = array('align=right', $no.'.' );
    if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	$getNamaKategori = mysql_fetch_array(mysql_query("select * from images_kategori where id ='$kategori'"));
	$namaKategori = $getNamaKategori['nama'];
    $Koloms[] = array('align ="left"', $namaKategori );
    $Koloms[] = array('align ="left"', $nama);
    
    $Koloms[] = array('align ="left"', $isi['username']);
    $Koloms[] = array('align ="center"', $isi['tanggal_upload']);
    $Koloms[] = array('align ="center"',"<span style='color:red;cursor:pointer;' onclick=$this->Prefix.showImage($id)>SHOW</span>");  
    return $Koloms;
  }
  
 function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
	  
	  $queryCmbKategori = "select id, nama from images_kategori ";
	  $comboKategori = cmbQuery('filterKategori',$filterKategori,$queryCmbKategori,"' onchange =$this->Prefix.refreshList(true); ",'-- Semua Kategori --');

	 if(empty($jumlahPerHal))$jumlahPerHal = "25";
	$TampilOpt = 
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td>KATEGORI </td>
			<td>: </td>
			<td style='width:90%;'>$comboKategori </td>
			</tr>
			
			<tr>
			<td>NAMA </td>
			<td>: </td>
			<td style='width:90%;'><input type='text' name='filterNama' id='filterNama' value='$filterNama'> <input type='button' value='tampilkan' onclick= $this->Prefix.refreshList(true);> </td>
			</tr>
		

			
			
			
			
			
			</table>".
			"</div>".
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<td>JUMLAH/HAL </td>
			<td>: </td>
			<td style='width:90%;'><input type= 'text' id='jumlahPerHal' name='jumlahPerHal' value='$jumlahPerHal' style='width:40px;'> <input type='button' value='Tampilkan' onclick=$this->Prefix.refreshList(true) </td>
			</tr>
		
			
			
			
			
			
			</table>".
			"</div>"
			
			;
		return array('TampilOpt'=>$TampilOpt);
	}			
  
  function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
		$this->pagePerHal = $jumlahPerHal;
		$arrKondisi = array();		
		if(!empty($filterKategori))$arrKondisi[]="kategori ='$filterKategori'";
		if(!empty($filterNama))$arrKondisi[]="nama like '%$filterNama%'";

		
		

		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		//$arrOrders[] = "concat(right((100 +id_system),2),'.',right((100 +id_modul),2),'.',right((1000 +id_sub_modul),3))";
		$Order= join(',',$arrOrders);	
		$OrderDefault = " ";// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
}
$ref_images = new ref_imagesObj();
$ref_images->username = $_COOKIE['coID'];
?>