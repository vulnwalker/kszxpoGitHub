<?php

class dpaSKPDNewObj  extends DaftarObj2{	
	var $Prefix = 'dpaSKPDNew';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_dpa'; //bonus
	var $TblName_Hapus = 'tabel_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_anggaran');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 4, 4, 4);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'DPA-SKPD';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='dpaSKPDNew.xls';
	var $namaModulCetak='RKA';
	var $Cetak_Judul = 'RKA';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'dpaSKPDNewForm';
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
		return 'DPA-SKPD  '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
	}
	function setMenuView(){
		return 			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";				
			
	}
	function setMenuEdit(){
	 	 $arrayResult = VulnWalkerTahap_v2("DPA-SKPD");
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $query = $arrayResult['query'];
	
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";

	 
		return $listMenu ;
	}
	function genRowSum($ColStyle, $Mode, $Total){
		foreach ($_REQUEST as $key => $value) { 
		  	$$key = $value; 
		 } 
		 if($cmbSubUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
		if(!empty($hiddenP)){
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and p='$hiddenP'";
					if(!empty($q)){
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and p='$hiddenP' and q='$q'";
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
	 	/*if(!empty($cmbBelanja)){
				if($cmbBelanja == "BELANJA PEGAWAI"){
					$kondisiRekening = "and k='5' and l ='2' and m ='1'";
				}elseif($cmbBelanja == "BELANJA BELANJA BARANG & JASA"){
					$kondisiRekening = "and k='5' and l ='2' and m ='2'";
				}elseif($cmbBelanja == "BELANJA MODAL"){
					$kondisiRekening = "and k='5' and l ='2' and m ='3'";
				}
				
		}*/
		
		/*if(!empty($this->jenisForm)){
			$idTahap = $this->idTahap;
		}else{*/
			$getIdTahapRKATerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from tabel_anggaran where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and jenis_rka !=''  and (rincian_perhitungan !='' or f !='00' ) and nama_modul = 'DPA-SKPD' "));
		 	$idTahap = $getIdTahapRKATerakhir['max'];
		/*}*/

		$getData = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f !='00' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and nama_modul='DPA-SKPD' and jenis_anggaran = '$this->jenisAnggaran' $kondisiSKPD $kondisiRekening"));
		$Total = $getData['sum(jumlah_harga)'];
		$ContentTotalHal=''; $ContentTotal='';
			$TampilTotalHalRp = number_format($this->SumValue[0],2, ',', '.');
			$TotalColSpan1 = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
			$TotalColSpan2 = $this->FieldSum_Cp2[$Mode-1];//$Mode ==1 ? 5 : 4;	
			$Kiri2 = $TotalColSpan1 > 0 ? "<td class='$ColStyle' colspan='3' align='center'><b>Total</td>": '';
				$ContentTotal = 
				"<tr>
					$Kiri2
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalJumlah,2,',','.')."</div>
					</td>
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
		// 		if(mysql_num_rows(mysql_query("select * from skpd_report_dpa where username= '$this->username'")) == 0){
		// 			$data = array(
		// 						  'username' => $this->username,
		// 						  'c1' => $cmbUrusan,
		// 						  'c' => $cmbBidang,
		// 						  'd' => $cmbSKPD
								  
		// 						  );
		// 			$query = VulnWalkerInsert('skpd_report_dpa',$data);
		// 			mysql_query($query);
		// 		}else{
		// 			$data = array(
		// 						  'username' => $this->username,
		// 						  'c1' => $cmbUrusan,
		// 						  'c' => $cmbBidang,
		// 						  'd' => $cmbSKPD
								  
								  
		// 						  );
		// 			$query = VulnWalkerUpdate('skpd_report_dpa',$data,"username = '$this->username'");
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
      if(mysql_num_rows(mysql_query("select * from skpd_report_dpa where username= '$this->username'")) == 0){
        $query = VulnWalkerInsert('skpd_report_dpa',$data);
      }else{
        $query = VulnWalkerUpdate('skpd_report_dpa',$data,"username = '$this->username'");
      }
      mysql_query($query);
        }
      $content = array('to' => $jenisKegiatan,'urusan' => $cmbUrusan, 'bidang' => $cmbBidang, 'skpd' => $cmbSKPD, 'namaPemda' => $namaPemda[option_value], 'cetakjang' => $cetakjang, 'e' => $cmbUnit, 'e1' => $cmbSubUnit, 'bk' => $bk, 'ck' => $ck, 'dk' => $dk, 'p' => $hiddenP, 'q' => $q, 'ttd' => $ttd );
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
		case 'Laporan':{
			$fm = $this->Laporan($_REQUEST);
            $cek .= $fm['cek'];
            $err = $fm['err'];
            $content = $fm['content'];
		break;
		}

		case 'dpaSKPD':{
      $json = FALSE;
      $this->dpaSKPD();
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
				mysql_query("delete from temp_dpa_221 where user ='$username'");							
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
	<A href=\"pages.php?Pg=dpaSKPDNew221\" title='DPA MURNI'  > DPA-SKPD 2.2.1 </a> |
	<A href=\"pages.php?Pg=dpaSKPDNew22\" title='DPA-SKPKD MURNI'  > DPA-SKPD 2.2 </a> |
	<A href=\"pages.php?Pg=dpaSKPDNew21\" title='DPA-SKPKD MURNI'  > DPA-SKPD 2.1 </a> |
	<A href=\"pages.php?Pg=dpaSKPDNew1\" title='DPA-SKPKD MURNI'    > DPA-SKPD 1 </a> |
	<A href=\"pages.php?Pg=dpaSKPDNew\" title='DPA-SKPKD MURNI' style='color:blue;'> DPA-SKPD </a> |
	
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
			<script type='text/javascript' src='js/perencanaan_v2/dpa/popupBarang.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaan_v2/dpa/popupRekening.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/dpa/dpaSKPDNew.js' language='JavaScript' ></script> 
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
	
		
		 $arrayResult = VulnWalkerTahap_v2($this->modul);
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $id_tahap = $arrayResult['id_tahap'];
	 
		$headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5' rowspan='1'  >No.</th>	
		   <th class='th01' width='60'  rowspan='1' >KODE</th>
		   <th class='th01' width='1000'  rowspan='1' >URAIAN</th>
		   <th class='th01'  rowspan='1' width='150' >JUMLAH</th>
		   $tergantungJenisForm 
		 
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
	$getIdTahapTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) from tabel_anggaran where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
	    $idTahapTerakhir = $getIdTahapTerakhir['max(id_tahap)'];
		$kondisiFilter = " and id_tahap = '$idTahapTerakhir' ";
		if($this->jenisFormTerakhir == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
				$kondisiFilter = $kondisiFilter." and status_validasi ='1' ";
		}
	$getTotalPerrekening = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
	$total = $getTotalPerrekening['sum(jumlah_harga)'];

	 $Koloms = array();
	 
		 $Koloms[] = array('align="center"', $no.'.' );
		 $kodeRekekening = $k.".".$l.".".$m.".".$n.".".$o;
		 $Koloms[] = array('align="center"', $kodeRekekening );
		 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening  where k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
		 $Koloms[] = array('align="left"', $getNamaRekening['nm_rekening'] );
		 
		 
		 $Koloms[] = array('align="right"', number_format($total,2,',','.') );	
		 $this->totalJumlah += $total;
	 
	 
	

	 return $Koloms;
	}


	function Validasi($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI DPA-SKPD ';
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
						'label'=>'KODE dpaSKPDNew',
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
		$urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=dpaSKPDNew.refreshList(true);','-- URUSAN --');
		
		$codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
		$bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=dpaSKPDNew.refreshList(true);','-- BIDANG --');
		
		$codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
		$skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=dpaSKPDNew.refreshList(true);','-- SKPD --');
		
		$codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e!='00' and e1='000' ";
		$unit = cmbQuery('cmbUnit',$selectedE,$codeAndNameUnit,'onchange=dpaSKPDNew.refreshList(true);','-- UNIT --');
		
		
		$codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1!='000' ";
		$subunit = cmbQuery('cmbSubUnit',$selectedE1,$codeAndNameSubUnit,'onchange=dpaSKPDNew.refreshList(true);','-- SUB UNIT --');
	
	
	

	
	
	if($this->jenisForm == "KOREKSI" || $this->jenisForm == "PENYUSUNAN" || $this->jenisForm == "VALIDASI"){
		$getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
		$angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');
		
		$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_dpa where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$this->idTahap'  "));
		$sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
		$sisaPagu =  number_format($sisaPagu ,2,',','.');
		$paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";
		
	}else{
		$getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
		$angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');
		
		$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_dpa where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  "));
		$sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
		$sisaPagu =  number_format($sisaPagu ,2,',','.');
		$paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";
		
	}
	
	
	
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

			<input type='hidden' name='tahun' id='tahun' value='$this->tahun' style='width:40px;' > <input type='hidden' name ='cmbJenisRKA' id='cmbJenisRKA' value=''>
			
			
			
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
				//$arrKondisi[] = "c1 = '$cmbUrusan'";
				//$arrKondisi[] = "c = '$cmbBidang'";
				//$arrKondisi[] = "d = '$cmbSKPD'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
			}elseif($cmbBidang != ''){
				//$arrKondisi[] = "c1 = '$cmbUrusan'";
				//$arrKondisi[] = "c = '$cmbBidang'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
			}elseif($cmbUrusan != ''){
				//$arrKondisi[] = "c1 = '$cmbUrusan'";
				$kondisiSKPD = "and c1='$cmbUrusan'";
			}
		
		$getIdTahapTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) from tabel_anggaran where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
	    $idTahapTerakhir = $getIdTahapTerakhir['max(id_tahap)'];
		$kondisiFilter = " and id_tahap = '$idTahapTerakhir' ";
		if($this->jenisFormTerakhir == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
				$kondisiFilter = $kondisiFilter." and status_validasi ='1' ";
		}
		if($this->jenisForm = "READ"){
			$getAllRekeningFromRka = mysql_query("select * from tabel_anggaran where jenis_rka !='' and jenis_rka !='DPA-SKPD'  and c1 ='0' and f ='00' and k !='0' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul ='DPA-SKPD' ");	
			while($rows = mysql_fetch_array($getAllRekeningFromRka)){
				foreach ($rows as $key => $value) { 
				  $$key = $value; 
				}
				if(strlen($k) > 1){
					
				}else{
					$data = array(
									'c1' => '0',
									'c'  => '00',
									'd'  => '00',
									'e' => '00',
									'e1' => '000',
									'f1' => '0',
									'f2' => '0',
									'f' => '00',
									'g' => '00',
									'h' => '00',
									'i' => '00',
									'j' => '000',
									'k' => $k,
									'l' => $l,
									'm' => $m,
									'n' => $n,
									'o' => $o,
									'jenis_rka' => 'DPA-SKPD',
									'nama_modul' => 'DPA-SKPD',
									'tahun' => $this->tahun,
									'jenis_anggaran' => $this->jenisAnggaran,
								  );
					  if(mysql_num_rows(mysql_query("select * from view_dpa where k='$k' and l='$l' and m='$m' and n='$n' and o ='$o'")) == 0){
					  	mysql_query(VulnWalkerInsert("tabel_anggaran",$data));
					  }
					  
								  
				}
			}		
		}
		
		
		
  		
		
		$grabAll = mysql_query("select * from view_dpa where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");
		while($rows = mysql_fetch_array($grabAll)){
			foreach ($rows as $key => $value) { 
		  		$$key = $value; 
		 	}
			$getTotalPerrekening = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiFilter and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
		 	$total = $getTotalPerrekening['sum(jumlah_harga)'];
		 	if($total == 0){
				$arrKondisi[] = "id_anggaran !='$id_anggaran'";
			}	
		}
		
		
		
	 
			
		
				
		
		
		
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
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
	
	function Laporan($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 300;
   $this->form_height = 100;
   $this->form_caption = 'LAPORAN DPA-SKPD MURNI';

   $c1 = $dt['cmbUrusan'];
   $c = $dt['cmbBidang'];
   $d = $dt['cmbSKPD'];

     $arrayJenisLaporan = array(
                 array('dpaSKPD', 'DPA-SKPD MURNI'),
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
      "<input type='button' value='Batal' onclick ='".'dpaSKPD'.".Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }	
	
	function dpaSKPD($xls =FALSE){
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
	
		
		$pisah = "<td width='1%' valign='top' style='font-weight: bold;'> : </td>";
	
		
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		
		
		$arrKondisi = array();
    $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
    // $grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_dpa where username='$this->username'"));
    foreach ($grabSKPD as $key => $value) { 
          $$key = $value; 
      }
    $cmbUrusan = $c1;
    $cmbBidang = $c;
    $cmbSKPD = $d;
    $cmbUnit = $e;
    $cmbSubUnit = $e1;
    
    if($cmbSubUnit != ''){
      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'";       
    }elseif($cmbUnit != ''){
      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
    }elseif($cmbSKPD != ''){
      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
    }elseif($cmbBidang != ''){
      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
    }elseif($cmbUrusan != ''){
      $kondisiSKPD = "and c1='$cmbUrusan'";
    }
    
    
    
    $blackListSubRincian = array();
    $getAllSubRincian = mysql_query("select * from tabel_dpa where id_tahap = '$this->idTahap' and (j!='000' or rincian_perhitungan !='' )");
    while($subRincian = mysql_fetch_array($getAllSubRincian)){
          if(mysql_num_rows(mysql_query("select * from tabel_dpa where id_tahap = '$this->idTahap' and id='".$subRincian['id']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening")) == 0){
              $blackListSubRincian[] = "id != '".$subRincian['id']."'";
              $arrKondisi[] = "id !='".$subRincian['id']."'";
              // $this->injectQuery = "select * from tabel_dpa where id_tahap = '$this->idTahap' and id='".$subRincian['id']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening";
          }
    }
    $kondisiBlackListSubRincian= join(' and ',$blackListSubRincian);
    if(sizeof($blackListSubRincian) == 0){
      $kondisiBlackListSubRincian = "";
    }elseif(sizeof($blackListSubRincian) > 0){
      $kondisiBlackListSubRincian = " and ".$kondisiBlackListSubRincian;
    }
    $blackListRincian = array();
    $getAllRincian =  mysql_query("select * from tabel_dpa where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja != '' and id_rincian_belanja !='0' and j='000' and rincian_perhitungan = '' ");
    while($rincianBelanja = mysql_fetch_array($getAllRincian)){
        if(mysql_num_rows(mysql_query("select  * from tabel_dpa where id_tahap = '$this->idTahap' and bk = '".$rincianBelanja['bk']."' and ck = '".$rincianBelanja['ck']."' and dk = '".$rincianBelanja['dk']."' and p = '".$rincianBelanja['p']."' and q = '".$rincianBelanja['q']."' and k = '".$rincianBelanja['k']."' and l = '".$rincianBelanja['l']."'  and m = '".$rincianBelanja['m']."'  and n = '".$rincianBelanja['n']."' and o = '".$rincianBelanja['o']."' and id_rincian_belanja = '".$rincianBelanja['id_rincian_belanja']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $blackListRincian[] = "id !='".$rincianBelanja['id']."'";
            $arrKondisi[] = "id !='".$rincianBelanja['id']."'";
        }

    }

    $blackListRekening = array();
    $getAllRekening =  mysql_query("select * from tabel_dpa where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
    while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
        if(mysql_num_rows(mysql_query("select  * from tabel_dpa where id_tahap = '$this->idTahap' and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $blackListRekening[] = "id !='".$rekeningBelanja['id']."'";
            $arrKondisi[] = "id !='".$rekeningBelanja['id']."'";
        }
    }
    $blackListKegiatan = array();
    $getAllKegiatan =  mysql_query("select * from tabel_dpa where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k ='0' and l ='0'  and m ='0'   and n ='0'  and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
    while($kegiatanBelanja = mysql_fetch_array($getAllKegiatan)){
        if(mysql_num_rows(mysql_query("select * from tabel_dpa where id_tahap ='$this->idTahap' and bk = '".$kegiatanBelanja['bk']."' and ck = '".$kegiatanBelanja['ck']."' and dk = '".$kegiatanBelanja['dk']."' and p = '".$kegiatanBelanja['p']."' and q = '".$kegiatanBelanja['q']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $blackListKegiatan[] = "id !='".$kegiatanBelanja['id']."'";
            $arrKondisi[] = "id !='".$kegiatanBelanja['id']."'";
        }
    }
    $blackListKegiatan = array();
    $getAllProgram =  mysql_query("select * from tabel_dpa where id_tahap ='$this->idTahap' and p != '0' and q ='0'  ");
    while($programBelanja = mysql_fetch_array($getAllProgram)){
        if(mysql_num_rows(mysql_query("select * from tabel_dpa where id_tahap ='$this->idTahap' and bk = '".$programBelanja['bk']."' and ck = '".$programBelanja['ck']."' and dk = '".$programBelanja['dk']."' and p = '".$programBelanja['p']."'  and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $arrKondisi[] = "id !='".$programBelanja['id']."'";
            $arrKondisi[] = "id !='".$programBelanja['id']."'";
        }
    }

    $arrKondisi[] = "id_rincian_belanja ='' and rincian_perhitungan = ''";
    $arrKondisi[] = "k !='0' and k!=''";
    $arrKondisi[] = "id_tahap = '$this->idTahap' ";
    $arrKondisi[] = "tahun = '$this->tahun'";
    $arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
    
    $Kondisi= join(' and ',$arrKondisi);
    $qry ="select * from tabel_dpa where $Kondisi  ";
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
		$kota = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan"));
    $css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
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
						.GarisCetak{
							border-left-color: transparent;
              padding-right: 1%;
						}
            .GarisCetak5{
              border: unset;
              border-right: 1px solid;
            }
            .GarisCetak4{
              border: 1px dashed;
            }
						table.cetak th.th01{
							border-left-color: transparent;
						}
						table.cetak th.th02{
							border-left-color: transparent;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width: $width; font-family: sans-serif; margin-left :1cm; height: $height; border: 1px solid #000; border-bottom-color: transparent;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>

							<table style='width: 100%; margin-bottom: 1%;'>
								<tr>
									<!-- <th class='th02' rowspan='2' style='width: 12%; border: 1px solid;'>
										<img src='".getImageReport()."' style='width: 90%; height: 10%; margin: 5%;'>
									</th> -->
									<th class='th02' rowspan='1' style='text-align: center;'>
										<span style='font-size:18px;font-weight:bold;'>
											RINGKASAN DOKUMEN PELAKSANA ANGGARAN<br>
											SATUAN KERJA PERANGKAT DAERAH<br>
										</span>
									</th>
									<th class='th02' rowspan='2' style='text-align: center; width: 20%; border-left: 1px solid; border-bottom: 1px solid;'>
										<span style='font-size: 14px; font-weight: bold;'>
											Formulir<br> DPA - SKPD
										</span>
									</th>
								</tr>
								<tr style='border-bottom: 1px solid;'>
									<th class='th02'  style='text-align: center; border-top: 1px solid; padding-bottom: 6px; padding-top: 6px;'>
										<span style='font-weight: bold; font-size: 14px; text-transform: uppercase;'>
											PEMERINTAH KABUPATEN ".$kota[kota]."<br>
										</span>
										<span class='ukurantulisanIdPenerimaan' style='font-size: 14px; font-weight: 100;'>TAHUN ANGGARAN : $this->tahun </span>
									</th>
								</tr>
							</table>

				<table width=\"100%\" class='subjudulcetak' style='font-family: sans-serif; margin-top: -0.8%;'>
					
					<tr>
						<td width='17%' valign='top'><span style='margin-left: 5%;'>Urusan Pemerintahan</span></td>
						$pisah
						<td width='1%' valign='top'>".$cmbUrusan."</td>
						<td valign='top'>$urusan</td>
					</tr>
					<tr>
						<td width='17%' valign='top' ><span style='margin-left: 5%;'>Organisasi</span></td>
						$pisah
						<td width='5%' valign='top'>".$cmbUrusan." . ".$cmbBidang."</td>
						<td valign='top'>$bidang</td>
					</tr>
					<tr>
						<td width='17%' valign='top'><span style='margin-left: 5%;'>Sub Unit Organisasi</span></td>
						$pisah
						<td valign='top' width='10%'>".$cmbUrusan." . ".$cmbBidang." . ".$cmbSKPD."</td>
						<td valign='top'>$skpd</td>
					</tr>
					
				</table>
				
				<br>
				
				
				";
		echo "
								<table class='cetak' style='width:100.2%; margin-top: -0.8%; border-bottom: 1px solid; margin-left: 0px;'>
								<thead>
									<tr>
										<th class='th02' rowspan='1' >KODE<br>REKENING</th>
										<th class='th02' rowspan='1' >URAIAN</th>
										<th class='th02' rowspan='1' >JUMLAH</th>
									</tr>
									<tr>
										<th class='th01' >1</th>
										<th class='th01' >2</th>
										<th class='th01' >3</th>
									</tr>
								</thead>
								
									
		";
		$getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_dpa where k='$k'  $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
    $total2 = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) { 
				  $$key = $value; 
			} 
        $getNamaRekening1 = mysql_fetch_array(mysql_query("SELECT * from ref_rekening where k='$k' and l='0' and m='0' and n='00' and o='000'"));
        $getNamaRekening2 = mysql_fetch_array(mysql_query("SELECT * from ref_rekening where k='$k' and l='$l' and m='0' and n='00' and o='000'"));
        $getNamaRekening3 = mysql_fetch_array(mysql_query("SELECT * from ref_rekening where k='$k' and l='$l' and m='$m' and n='00' and o='000'"));
        $getNamaRekening4 = mysql_fetch_array(mysql_query("SELECT * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='000'"));
        $getNamaRekening5 = mysql_fetch_array(mysql_query("SELECT * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));

        $uraian1 = $getNamaRekening1['nm_rekening']."</b>";
        $uraian2 = $getNamaRekening2['nm_rekening']."</b>";
        $uraian3 = $getNamaRekening3['nm_rekening']."</b>";
        $uraian4 = $getNamaRekening4['nm_rekening']."</b>";
        $uraian5 = $getNamaRekening5['nm_rekening']."</b>";
        
        // $getTotalLevel1 = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_dpa where k='$k'  $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
        // $totalLevel1 = $getTotalLevel1['sum(jumlah_harga)'];
        
        // $getSumJumlahHarga1 = mysql_fetch_array(mysql_query(" SELECT sum(jumlah_harga) from tabel_dpa where k='$k' and l='0' and m='0' and n='00' and o='000' $kondisiSKPD $kondisiFilter and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD' "));
        // $getSumJumlahHarga2 = mysql_fetch_array(mysql_query(" SELECT sum(jumlah_harga) from tabel_dpa where k='$k' and l='$l' and m='0' and n='00' and o='000' $kondisiSKPD $kondisiFilter and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD' "));
        // $getSumJumlahHarga3 = mysql_fetch_array(mysql_query(" SELECT sum(jumlah_harga) from tabel_dpa where k='$k' and l='$l' and m='$m' and n='00' and o='000' $kondisiSKPD $kondisiFilter and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD' "));
        // $getSumJumlahHarga4_1 = mysql_fetch_array(mysql_query(" SELECT sum(jumlah_harga) from tabel_dpa where k='$k' and l='$l' and m='$m' and n='$n' and o='001' $kondisiSKPD $kondisiFilter and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD' "));
        // $getSumJumlahHarga4_2 = mysql_fetch_array(mysql_query(" SELECT sum(jumlah_harga) from tabel_dpa where k='$k' and l='$l' and m='$m' and n='$n' and o='004' $kondisiSKPD $kondisiFilter and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD' "));
        // $total4 = $getSumJumlahHarga4_1['sum(jumlah_harga)']+$getSumJumlahHarga4_2['sum(jumlah_harga)'];
        // $getSumJumlahHarga5 = mysql_fetch_array(mysql_query(" SELECT sum(jumlah_harga) from tabel_dpa where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiFilter and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD' "));

        // $getTotalPerrekening = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_dpa where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
        // $total = $getTotalPerrekening['sum(jumlah_harga)'];
        // $this->totalJumlah += $total;

        // $jumlah_harga1 = number_format($getSumJumlahHarga1['sum(jumlah_harga)'],2,',','.');
        // $jumlah_harga2 = number_format($getSumJumlahHarga2['sum(jumlah_harga)'],2,',','.');
        // $jumlah_harga3 = number_format($getSumJumlahHarga3['sum(jumlah_harga)'],2,',','.');
        // $jumlah_harga4 = number_format($total4,2,',','.');
        // $jumlah_harga5 = number_format($getSumJumlahHarga5['sum(jumlah_harga)'],2,',','.');
        $getTotalPerrekening = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_dpa where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
        $total = $getTotalPerrekening['sum(jumlah_harga)'];

        $getTotalLevel4 = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_dpa where k='$k' and l='$l' and m='$m' and n='$n'  $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
        $totalLevel4 = $getTotalLevel4['sum(jumlah_harga)'];

        $getTotalLevel3 = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_dpa where k='$k' and l='$l' and m='$m'  $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
        $totalLevel3 = $getTotalLevel3['sum(jumlah_harga)'];

        $getTotalLevel2 = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_dpa where k='$k' and l='$l'  $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
        $totalLevel2 = $getTotalLevel2['sum(jumlah_harga)'];


        $getTotalLevel1 = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_dpa where k='$k'  $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'DPA-SKPD'"));
        $totalLevel1 = $getTotalLevel1['sum(jumlah_harga)'];

        $kode = $k.".".$l.".".$m.".".$n.".".$o;

        $rekeningLevel1 = "
                <tr valign='top'>
                  <td align='left' class='GarisCetak5' >".$k."</td>
                  <td align='left' class='GarisCetak5' style='padding-left: 10px; font-weight: bold;'>".$uraian1."</td>
                  <td align='right' class='GarisCetak' style='font-weight: bold;'><b>".number_format($totalLevel1,2,',','.')."</b></td>
                </tr>";
        $rekeningLevel2 = "
                <tr valign='top'>
                  <td align='left' class='GarisCetak5' >".$k.".".$l."</td>
                  <td align='left' class='GarisCetak5' style='padding-left: 15px; font-weight: bold;'>".$uraian2."</td>
                  <td align='right' class='GarisCetak4' style='font-weight: bold;'><b>".number_format($totalLevel2,2,',','.')."</b></td>
                </tr>";
        $rekeningLevel3 = "
                <tr valign='top'>
                  <td align='left' class='GarisCetak5' >".$k.".".$l.".".$m."</td>
                  <td align='left' class='GarisCetak5' style='padding-left: 20px; font-weight: bold;'>".$uraian3."</td>
                  <td align='right' class='GarisCetak4' style='font-weight: bold;'><b>".number_format($totalLevel3,2,',','.')."</b></td>
                </tr>";
        $rekeningLevel4 = "
                <tr valign='top'>
                  <td align='left' class='GarisCetak5' >".$k.".".$l.".".$m.".".$n."</td>
                  <td align='left' class='GarisCetak5' style='padding-left: 25px; font-weight: bold;'>".$uraian4."</td>
                  <td align='right' class='GarisCetak4' style='font-weight: bold;'><b>".number_format($totalLevel4,2,',','.')."</b></td>
                </tr>";

        if (in_array($k, $this->arrayRekening1)) {
               $rekeningLevel1 = "";
             }
             $concatRekeningLevel2 = $k.".".$l;
             if (in_array($concatRekeningLevel2, $this->arrayRekening2)) {
               $rekeningLevel2 = "";
             }
             $concatRekeningLevel3 = $k.".".$l.".".$m;
             if (in_array($concatRekeningLevel3, $this->arrayRekening3)) {
               $rekeningLevel3 = "";
             }
             $concatRekeningLevel4 = $k.".".$l.".".$m.".".$n;
             if (in_array($concatRekeningLevel4, $this->arrayRekening4)) {
               $rekeningLevel4 = "";
             }

        $rekeningLevel5 = "
                <tr valign='top'>
                  <td align='left' class='GarisCetak5' >".$kode."</td>
                  <td align='left' class='GarisCetak5' style='padding-left: 30px;'>".$uraian5."</td>
                  <td align='right' class='GarisCetak4' >".number_format($total,2,',','.')."</td>
                </tr>";
        $this->totalSum += $total;
      
      echo $rekeningLevel1.$rekeningLevel2.$rekeningLevel3.$rekeningLevel4.$rekeningLevel5;
      $rekeningLevel1 = "";
      $rekeningLevel2 = "";
      $rekeningLevel3 = "";
      $rekeningLevel4 = "";
      $rekeningLevel5 = "";

      $this->arrayRekening1[] = $k;
      $this->arrayRekening2[] = $k.".".$l;
      $this->arrayRekening3[] = $k.".".$l.".".$m;
      $this->arrayRekening4[] = $k.".".$l.".".$m.".".$n;

      

      // "
      //           <tr valign='top'>
      //             <td align='center' class='GarisCetak' >".$k.".".$l.".".$m.".".$n.".".$o."</td>
      //             <td align='left' class='GarisCetak' >".$uraian5."</td>
      //             <td align='right' class='GarisCetak' >".$jumlah_harga."</td>
      //           </tr>
      // ";
			
			
		}
    echo "
        <tr>
          <td class='GarisCetak' align='right' colspan='2'><b>SURPLUS / (DEFISIT)</b></td>
          <td class='GarisCetak' align='right'><b>".number_format($this->totalSum,2,',','.')."</b></td>
        </tr>
      ";
				$no++;		
		// "<tr valign='top'>
		// 							<td align='right' colspan='4' class='GarisCetak' style='font-weight: bold;'>Surpls/(Defisit)</td>
		// 							<td align='right' class='GarisCetak' ><b>".$total."</b></td>
		// 						</tr>
		// 						<tr valign='top'>
		// 							<td align='center' class='GarisCetak' >".$k."</td>
		// 							<td align='center' class='GarisCetak' >".$l."</td>
		// 							<td align='center' class='GarisCetak' >".$m."</td>
		// 							<!-- <td align='center' class='GarisCetak' >".$n."</td>
		// 							<td align='center' class='GarisCetak' >".$o."</td> -->
		// 							<td align='left' class='GarisCetak' >".$uraian."</td>
		// 							<td align='right' class='GarisCetak' >".$jumlah_harga."</td>
		// 						</tr>
		// 						<tr>
		// 							<td align='right' colspan='4' class='GarisCetak' style='font-weight: bold;'>Pembiayaan netto</td>
		// 							<td align='right' class='GarisCetak' ><b></b></td>
		// 						</tr>
		// 					 </table>
		
		// ";
		
		$getSumPendapatan = mysql_fetch_array(mysql_query("select  sum(alokasi_jan), sum(alokasi_feb) , sum(alokasi_mar) , sum(alokasi_apr) , sum(alokasi_mei) , sum(alokasi_jun) , sum(alokasi_jul) , sum(alokasi_agu) , sum(alokasi_sep) , sum(alokasi_okt) , sum(alokasi_nop), sum(alokasi_des) from tabel_spd where  anggaran ='$this->jenisAnggaran' and tahun = '$this->tahun' $kondisiSKPD and jenis_rka = '1' and jenis_dpa = 'DPA-SKPD'"));		
		$PendapatantriwulanI =  $getSumPendapatan['sum(alokasi_jan)'] + $getSumPendapatan['sum(alokasi_feb)'] + $getSumPendapatan['sum(alokasi_mar)'];
		$Pendapatanjumlah_harga += $PendapatantriwulanI;
		$PendapatantriwulanI = number_format($PendapatantriwulanI,2,',','.');
		
		$PendapatantriwulanII = $getSumPendapatan['sum(alokasi_apr)'] + $getSumPendapatan['sum(alokasi_mei)'] + $getSumPendapatan['sum(alokasi_jun)'];
		$Pendapatanjumlah_harga += $PendapatantriwulanII;
		$PendapatantriwulanII = number_format($PendapatantriwulanII,2,',','.');
		
		$PendapatantriwulanIII = $getSumPendapatan['sum(alokasi_jul)'] + $getSumPendapatan['sum(alokasi_agu)'] + $getSumPendapatan['sum(alokasi_sep)'];
		$Pendapatanjumlah_harga += $PendapatantriwulanIII;
		$PendapatantriwulanIII = number_format($PendapatantriwulanIII,2,',','.');
		
		$PendapatantriwulanIV = $getSumPendapatan['sum(alokasi_okt)'] + $getSumPendapatan['sum(alokasi_nop)'] + $getSumPendapatan['sum(alokasi_des)'];
		$Pendapatanjumlah_harga += $PendapatantriwulanIV;
		$PendapatantriwulanIV = number_format($PendapatantriwulanIV,2,',','.');
		$Pendapatanjumlah_harga = number_format($Pendapatanjumlah_harga,2,',','.');
		
		
		$getSumTidakLangsung = mysql_fetch_array(mysql_query("select  sum(alokasi_jan), sum(alokasi_feb) , sum(alokasi_mar) , sum(alokasi_apr) , sum(alokasi_mei) , sum(alokasi_jun) , sum(alokasi_jul) , sum(alokasi_agu) , sum(alokasi_sep) , sum(alokasi_okt) , sum(alokasi_nop), sum(alokasi_des) from tabel_spd where anggaran ='$this->jenisAnggaran' and tahun = '$this->tahun' $kondisiSKPD and jenis_rka = '2.1' and jenis_dpa = 'DPA-SKPD'"));		
		$TidakLangsungtriwulanI =  $getSumTidakLangsung['sum(alokasi_jan)'] + $getSumTidakLangsung['sum(alokasi_feb)'] + $getSumTidakLangsung['sum(alokasi_mar)'];
		$TidakLangsungjumlah_harga += $TidakLangsungtriwulanI;
		$TidakLangsungtriwulanI = number_format($TidakLangsungtriwulanI,2,',','.');
		
		$TidakLangsungtriwulanII = $getSumTidakLangsung['sum(alokasi_apr)'] + $getSumTidakLangsung['sum(alokasi_mei)'] + $getSumTidakLangsung['sum(alokasi_jun)'];
		$TidakLangsungjumlah_harga += $TidakLangsungtriwulanII;
		$TidakLangsungtriwulanII = number_format($TidakLangsungtriwulanII,2,',','.');
		
		$TidakLangsungtriwulanIII = $getSumTidakLangsung['sum(alokasi_jul)'] + $getSumTidakLangsung['sum(alokasi_agu)'] + $getSumTidakLangsung['sum(alokasi_sep)'];
		$TidakLangsungjumlah_harga += $TidakLangsungtriwulanIII;
		$TidakLangsungtriwulanIII = number_format($TidakLangsungtriwulanIII,2,',','.');
		
		$TidakLangsungtriwulanIV = $getSumTidakLangsung['sum(alokasi_okt)'] + $getSumTidakLangsung['sum(alokasi_nop)'] + $getSumTidakLangsung['sum(alokasi_des)'];
		$TidakLangsungjumlah_harga += $TidakLangsungtriwulanIV;
		$TidakLangsungtriwulanIV = number_format($TidakLangsungtriwulanIV,2,',','.');
		$TidakLangsungjumlah_harga = number_format($TidakLangsungjumlah_harga,2,',','.');
		
		
		$getSumLangsung = mysql_fetch_array(mysql_query("select  sum(alokasi_jan), sum(alokasi_feb) , sum(alokasi_mar) , sum(alokasi_apr) , sum(alokasi_mei) , sum(alokasi_jun) , sum(alokasi_jul) , sum(alokasi_agu) , sum(alokasi_sep) , sum(alokasi_okt) , sum(alokasi_nop), sum(alokasi_des) from tabel_spd where anggaran ='$this->jenisAnggaran' and tahun = '$this->tahun' $kondisiSKPD and jenis_rka = '2.2.1' and jenis_dpa = 'DPA-SKPD'"));		
		$LangsungtriwulanI =  $getSumLangsung['sum(alokasi_jan)'] + $getSumLangsung['sum(alokasi_feb)'] + $getSumLangsung['sum(alokasi_mar)'];
		$Langsungjumlah_harga += $LangsungtriwulanI;
		$LangsungtriwulanI = number_format($LangsungtriwulanI,2,',','.');
		
		$LangsungtriwulanII = $getSumLangsung['sum(alokasi_apr)'] + $getSumLangsung['sum(alokasi_mei)'] + $getSumLangsung['sum(alokasi_jun)'];
		$Langsungjumlah_harga += $LangsungtriwulanII;
		$LangsungtriwulanII = number_format($LangsungtriwulanII,2,',','.');
		
		$LangsungtriwulanIII = $getSumLangsung['sum(alokasi_jul)'] + $getSumLangsung['sum(alokasi_agu)'] + $getSumLangsung['sum(alokasi_sep)'];
		$Langsungjumlah_harga += $LangsungtriwulanIII;
		$LangsungtriwulanIII = number_format($LangsungtriwulanIII,2,',','.');
		
		$LangsungtriwulanIV = $getSumLangsung['sum(alokasi_okt)'] + $getSumLangsung['sum(alokasi_nop)'] + $getSumLangsung['sum(alokasi_des)'];
		$Langsungjumlah_harga += $LangsungtriwulanIV;
		$LangsungtriwulanIV = number_format($LangsungtriwulanIV,2,',','.');
		$Langsungjumlah_harga = number_format($Langsungjumlah_harga,2,',','.');
		
	echo "	
		<table class='cetak' style='width:100%; border-bottom: 1px solid; margin-left: 0px;'>
		<thead>
		<tr>
			<th style='text-align: center;' colspan='8'>
				<span style='font-size:14px;font-weight:bold;text-decoration: '>
          RENCANA PELAKSANAAN ANGGARAN<br> SATUAN KERJA PERANGKAT DAERAH PER TRIWULAN
				</span>	
			</th>
		</tr>
		<tr>
	   <th class='th02' rowspan='2' align='center'>No.</th>
	   <th class='th02' rowspan='2' align='center'>URAIAN</th>
	   <th class='th02' rowspan='1' colspan='5' align='center'>TRIWULAN</th>
	  </tr>
	  <tr>
	  <th class='th02' width='100' rowspan='1' align='center'>I</th> 
	  <th class='th02' width='100' rowspan='1' align='center'>II</th> 
	  <th class='th02' width='100' rowspan='1' align='center'>III</th>
	  <th class='th02' width='100' rowspan='1' align='center'>IV</th> 
	  <th class='th02' width='100' rowspan='1' align='center'>Jumlah</th>
	  </tr>
	  <tr>
	  	<th class='th01'>1</th>
	  	<th class='th01'>2</th>
	  	<th class='th01'>3</th>
	  	<th class='th01'>4</th>
	  	<th class='th01'>5</th>
	  	<th class='th01'>6</th>
	  	<th class='th01'>7 = 3 + 4 + 5 + 6</th>
	  </tr>
	  </thead>
	  <tr valign='top'>
									<td align='left' class='GarisCetak'>1</td>
									<td align='left' class='GarisCetak' >Pendapatan </td>
									<td align='right' class='GarisCetak' >".$PendapatantriwulanI."</td>
									<td align='right' class='GarisCetak' >".$PendapatantriwulanII."</td>
									<td align='right' class='GarisCetak' >".$PendapatantriwulanIII."</td>
									<td align='right' class='GarisCetak' >".$PendapatantriwulanIV."</td>
									<td align='right' class='GarisCetak' >".$Pendapatanjumlah_harga."</td>
	 </tr>
	 <tr valign='top'>
									<td align='left' class='GarisCetak'>2.1</td>
									<td align='left' class='GarisCetak' >Belanja Tidak Langsung</td>
									<td align='right' class='GarisCetak' >".$TidakLangsungtriwulanI."</td>
									<td align='right' class='GarisCetak' >".$TidakLangsungtriwulanII."</td>
									<td align='right' class='GarisCetak' >".$TidakLangsungtriwulanIII."</td>
									<td align='right' class='GarisCetak' >".$TidakLangsungtriwulanIV."</td>
									<td align='right' class='GarisCetak' >".$TidakLangsungjumlah_harga."</td>
	 </tr>
	 <tr valign='top'>
									<td align='left' class='GarisCetak'>2.2</td>
									<td align='left' class='GarisCetak' >Belanja Langsung</td>
									<td align='right' class='GarisCetak' >".$LangsungtriwulanI."</td>
									<td align='right' class='GarisCetak' >".$LangsungtriwulanII."</td>
									<td align='right' class='GarisCetak' >".$LangsungtriwulanIII."</td>
									<td align='right' class='GarisCetak' >".$LangsungtriwulanIV."</td>
									<td align='right' class='GarisCetak' >".$Langsungjumlah_harga."</td>
	 </tr>
	</table>
	  ";
	  
	  	
		if (sizeof($arrayTandaTangan)==1) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$arrayPosisi' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '0' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));
            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$arrayPosisi' "));
            $titimangsa = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan"));

            $tandaTanganna .= "<br><br>
            <div class='ukurantulisan' style ='float: right; text-align:center; margin-right: 5%;'>
            ".$titimangsa[titimangsa_surat].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            <b>$hmm[jabatan]</b>
            <br>
            <br>
            <br>
            <br>
            <br>
            <span>".$hmm['nama']."</span>
            <hr style='border-top: 1px solid #000; margin-bottom: 5px; margin-top: 5px;'>
            <span style='margin-bottom: 5px;'>NIP ".$hmm['nip']."</span>
          
            
            </div>";

					}
		echo 			
						"
						<table style='width:100.2%; margin-left: -1px;'>
							<tr>
								<td>
									".$tandaTanganna."
								</td>
							</tr>
						</table>
						<h5 class='pag pag1'>
							<span style='bottom: 2px; position: absolute; left:0;'>
							<hr style='width: 33cm; border-top: 1px solid #000;'>
							</span>
							<span style='bottom: 2px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
						</h5>
  					<div class='insert'></div>
			</body>	
		</html>";
	}
	
}
$dpaSKPDNew = new dpaSKPDNewObj();

$arrayResult = VulnWalkerTahap_v2($dpaSKPDNew->modul);
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$dpaSKPDNew->jenisForm = $jenisForm;
$dpaSKPDNew->nomorUrut = $nomorUrut;
$dpaSKPDNew->urutTerakhir = $nomorUrut;
$dpaSKPDNew->tahun = $tahun;
$dpaSKPDNew->jenisAnggaran = $jenisAnggaran;
$dpaSKPDNew->idTahap = $idTahap;

$dpaSKPDNew->username = $_COOKIE['coID'];


$dpaSKPDNew->wajibValidasi = $Main->wajibValidasi;
if($Main->wajibValidasi == TRUE){
	$dpaSKPDNew->sqlValidasi = " and status_validasi ='1' ";
}else{
	$dpaSKPDNew->sqlValidasi = " ";
}


if(empty($dpaSKPDNew->tahun)){
    
	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_dpa "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_dpa where id_anggaran = '$maxAnggaran'"));
	/*$dpaSKPDNew->tahun = "select max(id_anggaran) as max from view_dpa where nama_modul = 'dpaSKPDNew'";*/
	$dpaSKPDNew->tahun  = $get2['tahun'];
	$dpaSKPDNew->jenisAnggaran = $get2['jenis_anggaran'];
	$dpaSKPDNew->urutTerakhir = $get2['no_urut'];
	$dpaSKPDNew->jenisFormTerakhir = $get2['jenis_form_modul'];
	$dpaSKPDNew->urutSebelumnya = $dpaSKPDNew->urutTerakhir - 1;
	
	
	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$dpaSKPDNew->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$dpaSKPDNew->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
	
	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$dpaSKPDNew->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$dpaSKPDNew->idTahap'"));
	$dpaSKPDNew->currentTahap = $getCurrenttahap['nama_tahap'];
	
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$dpaSKPDNew->idTahap'"));
	$dpaSKPDNew->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$dpaSKPDNew->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$dpaSKPDNew->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}

$setting = settinganPerencanaan_v2();
$dpaSKPDNew->provinsi = $setting['provinsi'];
$dpaSKPDNew->kota = $setting['kota'];
$dpaSKPDNew->pengelolaBarang = $setting['pengelolaBarang'];
$dpaSKPDNew->pejabatPengelolaBarang = $setting['pejabat'];
$dpaSKPDNew->pengurusPengelolaBarang = $setting['pengurus'];
$dpaSKPDNew->nipPengelola = $setting['nipPengelola'];
$dpaSKPDNew->nipPengurus = $setting['nipPengurus'];
$dpaSKPDNew->nipPejabat = $setting['nipPejabat'];

?>