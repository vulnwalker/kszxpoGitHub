<?php

class daftarPersediaanBarangObj  extends DaftarObj2{
	var $Prefix = 'daftarPersediaanBarang';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_kartu_persediaan'; //bonus
	var $TblName_Hapus = 't_kartu_persediaan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'DAFTAR PERSEDIAAN BARANG';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='daftarPersediaanBarang.xls';
	var $namaModulCetak='DAFTAR PERSEDIAAN BARANG';
	var $Cetak_Judul = 'DAFTAR PERSEDIAAN BARANG';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'daftarPersediaanBarangForm';
	var $modul = "DAFTAR PERSEDIAAN BARANG";
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
      $dt['c1'] = $_REQUEST[$this->Prefix.'daftarPersediaanBarangSKPD2fmURUSAN'];
      $dt['c'] = $_REQUEST[$this->Prefix.'daftarPersediaanBarangSKPD2fmSKPD'];
      $dt['d'] = $_REQUEST[$this->Prefix.'daftarPersediaanBarangSKPD2fmUNIT'];
      $dt['e'] = $_REQUEST[$this->Prefix.'daftarPersediaanBarangSKPD2fmSUBUNIT'];
      $dt['e1'] = $_REQUEST[$this->Prefix.'daftarPersediaanBarangSKPD2fmSEKSI'];
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
      			<input type='text' name='de' id='de' value='".$date."' style='width: 500px;' readonly>
      			<input type='hidden' name='e' id='e' value='".$querye['e']."'>
      			</div> ",
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
            'value'=>"<input type='text' readonly='readonly' id='kategori' name='kategori' style='width: 250px;' value='".$queryKategori1[kategori_tandatangan]."'  >",
          
            
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
		return 'DAFTAR PERSEDIAAN BARANG';
	}
	// function setMenuView(){
	// 	return
	// 		// "<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";
	// 		"";
	// }
	function setMenuEdit(){

	 	$listMenu =
					"<td>".genPanelIcon("javascript:".$this->Prefix.".kartuPersediaan()","icon_template.png","Kartu ", 'Kartu ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".lockBarang()","lock.svg","Kunci ", 'Kunci ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png","Laporan ", 'Laporan ')."</td>"
					;

		return $listMenu ;
	}

	function setMenuView(){
		return "";

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

			case 'saveLockBarang':{
				foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
				}
				$kondisiTahun = " and left(tanggal_buku,4) = '".$_COOKIE['coThnAnggaran']."' ";
				if(!empty($filterPeriode)){
						if($filterPeriode == '1'){
								$maxFilter = $_COOKIE['coThnAnggaran']."06";
								$kondisiPeriode  = " and replace(left(tanggal_buku,6),'-','') <= '$maxFilter' ";
						}elseif($filterPeriode == '2'){
								$minFilter = $_COOKIE['coThnAnggaran']."07";
								$maxFilter = $_COOKIE['coThnAnggaran']."12";
								$kondisiPeriode= " and replace(left(tanggal_buku,6),'-','') >= '$minFilter' and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
						}elseif($filterPeriode == '3'){
								$maxFilter = $_COOKIE['coThnAnggaran']."12";
								$kondisiPeriode = " and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
						}
				}

				$getData = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '$idPosting'"));
				if(mysql_num_rows(mysql_query("select * from temp_lock where id_daftar ='$idPosting' and username ='$this->username' and saldo < 0"))){
					$err = "Saldo minus !";
				}elseif(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where c1='".$getData['c1']."' and c='".$getData['c']."' and d='".$getData['d']."' and e='".$getData['e']."' and e1='".$getData['e1']."' and f1='".$getData['f1']."' and f2='".$getData['f2']."' and f='".$getData['f']."' and g='".$getData['g']."' and h='".$getData['h']."' and i='".$getData['i']."' and j='".$getData['j']."' and j1='".$getData['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '".$filterPeriode."' ")) == 0){
							$dataLockBarang = array(
													'c1' => $getData['c1'],
													'c' => $getData['c'],
													'd' => $getData['d'],
													'e' => $getData['e'],
													'e1' => $getData['e1'],
													'f1' => $getData['f1'],
													'f2' => $getData['f2'],
													'f' => $getData['f'],
													'g' => $getData['g'],
													'h' => $getData['h'],
													'i' => $getData['i'],
													'j' => $getData['j'],
													'j1' => $getData['j1'],
													'tahun' => $_COOKIE['coThnAnggaran'],
													'semester' => $filterPeriode,
							);
							mysql_query(VulnWalkerInsert("t_persediaan_lock_barang",$dataLockBarang));

							$idLock = mysql_fetch_array(mysql_query("select * from t_persediaan_lock_barang where c1='".$getData['c1']."' and c='".$getData['c']."' and d='".$getData['d']."' and e='".$getData['e']."' and e1='".$getData['e1']."' and f1='".$getData['f1']."' and f2='".$getData['f2']."' and f='".$getData['f']."' and g='".$getData['g']."' and h='".$getData['h']."' and i='".$getData['i']."' and j='".$getData['j']."' and j1='".$getData['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '".$filterPeriode."' "));
							$idLock = $idLock['id'];

							$getData = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '$idPosting'"));
						  $getDataTambah = mysql_query("select * from t_kartu_persediaan where c1='".$getData['c1']."' and c='".$getData['c']."' and d='".$getData['d']."' and e='".$getData['e']."' and e1='".$getData['e1']."' and f1='".$getData['f1']."' and f2='".$getData['f2']."' and f='".$getData['f']."' and g='".$getData['g']."' and h='".$getData['h']."' and i='".$getData['i']."' and j='".$getData['j']."' and j1='".$getData['j1']."' and jenis_persediaan = '1' $kondisiTahun $kondisiPeriode order by tanggal_buku asc");
						  while ($dataTambah = mysql_fetch_array($getDataTambah)) {
						      $dataLockTambah = array(
						                  'tanggal' => $dataTambah['tanggal_buku'],
						                  'id_t_kartu_persediaan' => $dataTambah['id'],
						                  'jumlah' => $dataTambah['jumlah'],
						                  'harga' => $dataTambah['harga_satuan'],
						                  'sisa' => $dataTambah['jumlah'],
						                  'id_lock' => $idLock,
						      );
						      mysql_query(VulnWalkerInsert('lock_barang_tambah',$dataLockTambah));
						  }

							$getDataKurang = mysql_query("select * from t_kartu_persediaan where c1='".$getData['c1']."' and c='".$getData['c']."' and e='".$getData['e']."' and e1='".$getData['e1']."' and d='".$getData['d']."' and f1='".$getData['f1']."' and f2='".$getData['f2']."' and f='".$getData['f']."' and g='".$getData['g']."' and h='".$getData['h']."' and i='".$getData['i']."' and j='".$getData['j']."' and j1='".$getData['j1']."' and jenis_persediaan = '2' $kondisiTahun $kondisiPeriode order by tanggal_buku asc");
						  while ($dataKurang = mysql_fetch_array($getDataKurang)) {
						      $arrayPerolehan = array();
						      $jumlahBarangKurang = $dataKurang['jumlah'];
						      $getDataPenerimaan = mysql_query("select * from lock_barang_tambah where id_lock = '".$idLock."' and sisa !='0'");
						      while ($dataPenerimaan = mysql_fetch_array($getDataPenerimaan)) {
						          if($jumlahBarangKurang != 0){
						            if($jumlahBarangKurang > $dataPenerimaan['sisa'] ){
						                mysql_query("update lock_barang_tambah set sisa = sisa - ".$dataPenerimaan['sisa']." where id = '".$dataPenerimaan['id']."'");
						                $arrayPerolehan[] = array(
						                                          'idPenerimaan' => $dataPenerimaan['id_t_kartu_persediaan'],
						                                          'jumlah' => $dataPenerimaan['sisa'],
						                                          'harga' => $dataPenerimaan['harga'],
						                                          'total' => $dataPenerimaan['sisa'] * $dataPenerimaan['harga']
						                                         );
						                $jumlahBarangKurang -= $dataPenerimaan['sisa'];
						            }else{
						                mysql_query("update lock_barang_tambah set sisa = sisa - $jumlahBarangKurang where id = '".$dataPenerimaan['id']."'");
						                $arrayPerolehan[] = array(
						                                          'idPenerimaan' => $dataPenerimaan['id_t_kartu_persediaan'],
						                                          'jumlah' => $jumlahBarangKurang,
						                                          'harga' => $dataPenerimaan['harga'],
						                                          'total' => $jumlahBarangKurang * $dataPenerimaan['harga']
						                                         );
						                $jumlahBarangKurang = 0;
						            }
						          }
						      }
						      $encoding = json_encode($arrayPerolehan);
						      $decoding = json_decode($encoding);
						      $hargaPerolehan= "";
						      for ($i=0; $i < sizeof($decoding) ; $i++) {
						          $hargaPerolehan += $decoding[$i]->total;
						      }
						      $dataLockKurang = array(
						                  'tanggal' => $dataKurang['tanggal_buku'],
						                  'id_t_kartu_persediaan' => $dataKurang['id'],
						                  'jumlah' => $dataKurang['jumlah'],
						                   'harga' => $hargaPerolehan,
						                  'id_lock' => $idLock,
						                  'perolehan' => json_encode($arrayPerolehan)

						      );
						      mysql_query(VulnWalkerInsert('lock_barang_kurang',$dataLockKurang));
						  }


							$getDataHistori = mysql_query("select * from t_kartu_persediaan where c1='".$getData['c1']."' and c='".$getData['c']."' and d='".$getData['d']."' and e='".$getData['e']."' and e1='".$getData['e1']."' and f1='".$getData['f1']."' and f2='".$getData['f2']."' and f='".$getData['f']."' and g='".$getData['g']."' and h='".$getData['h']."' and i='".$getData['i']."' and j='".$getData['j']."' and j1='".$getData['j1']."'  $kondisiTahun $kondisiPeriode order by tanggal_buku,jenis_persediaan asc");
						  while ($dataHistori = mysql_fetch_array($getDataHistori)) {
						      if($dataHistori['jenis_persediaan'] == 1){
						        if($dataHistori['jns'] == '1'){
						          $barangMasuk = $dataHistori['jumlah'];
						          $barangKeluar = 0;
						          $uraianPersediaan = "SALDO AWAL";
						        }elseif($dataHistori['jns'] == '2'){
						          $barangMasuk = $dataHistori['jumlah'];
						          $barangKeluar = 0;
						          if($dataHistori['cara_perolehan'] == '2'){
						            $uraianPersediaan = "PENERIMAAN PEMBELIAN";
						          }elseif($dataHistori['cara_perolehan'] == '3'){
						            $uraianPersediaan = "PENERIMAAN HIBAH";
						          }
						        }elseif($dataHistori['jns'] == '4'){
						          $barangMasuk = $dataHistori['jumlah'];
						          $barangKeluar = 0;
						          $uraianPersediaan = "CEK FISIK TAMBAH";
						        }elseif($dataHistori['jns'] == '3'){
						          $barangMasuk = $dataHistori['jumlah'];
						          $barangKeluar = 0;
						          $uraianPersediaan = "PENERIMAAN DISTRIBUSI";
						        }
						        $hargaSatuan = $dataHistori['harga_satuan'];
						        $totalHarga = $hargaSatuan * $dataHistori['jumlah'];
						        $saldoBarang += $dataHistori['jumlah'];
						        $totalSaldo += $totalHarga;

										$getIdDetail = mysql_fetch_array(mysql_query("select * from lock_barang_tambah where id_lock = '$idLock' and id_t_kartu_persediaan = '".$dataHistori['id']."'"));
										$idDetail = $getIdDetail['id'];
						      }else{
						          if($dataHistori['jns'] == '6'){
						            $barangKeluar = $dataHistori['jumlah'];
						            $barangMasuk = 0;
						            $uraianPersediaan = "PENGELUARAAN";
						          }elseif($dataHistori['jns'] == '5'){
						            $barangKeluar = $dataHistori['jumlah'];
						            $barangMasuk = 0;
						            $uraianPersediaan = "CEK FISIK KURANG";
						          }elseif($dataHistori['jns'] == '7'){
						            $barangKeluar = $dataHistori['jumlah'];
						            $barangMasuk = 0;
						            $uraianPersediaan = "PENGELUARAN DISTRIBUSI";
						          }
						          $hargaSatuan = "";
						        $saldoBarang -= $dataHistori['jumlah'];
						        $getTotalHarga = mysql_fetch_array(mysql_query("select * from lock_barang_kurang where id_lock = '$idLock' and id_t_kartu_persediaan = '".$dataHistori['id']."'"));
						        $totalHarga = $getTotalHarga['harga'];
						        $totalSaldo -= $totalHarga;
										$idDetail = $getTotalHarga['id'];
						      }
						      // if($saldoBarang < 0){
						      //     $err = "Tanggal saldo minus";
						      // }
						      $dataRincianLock = array(
						                  'id_lock' => $idLock,
						                  'tanggal' => $dataHistori['tanggal_buku'],
						                  'uraian' => $uraianPersediaan,
						                  'masuk' => $barangMasuk,
						                  'keluar' => $barangKeluar,
						                  'saldo_barang' => $saldoBarang,
						                  'total' => $totalHarga,
						                  'saldo' => $totalSaldo,
						                  'type' => $dataHistori['jenis_persediaan'],
						                  'id_t_kartu_persediaan' => $dataHistori['id'],
						                  'id_detail' => $idDetail,
						      );
						      mysql_query(VulnWalkerInsert('rincian_lock_barang',$dataRincianLock));
						  }

							mysql_query("update t_persediaan_lock_barang set harga = '$totalSaldo' where id = '$idLock'");




				}else{
						$err = "Data sudah di kunci";
				}




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
    case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
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
		case 'Laporan2':{
			$json = FALSE;
			$this->Laporan2();
		break;
		}
		case 'Laporan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 	$fm = $this->Laporan($_REQUEST);
						$cek .= $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
			break;
		}
		case 'Laporann':{
			$json = FALSE;
			$this->Laporann();
		break;
		}
		case 'unLockBarang':{
			$idLock = $_REQUEST['idLock'];
			mysql_query("delete from t_persediaan_lock_barang where id = '$idLock'");
			mysql_query("delete from rincian_lock_barang where id_lock = '$idLock'");
			mysql_query("delete from lock_barang_tambah where id_lock = '$idLock'");
			mysql_query("delete from lock_barang_kurang where id_lock = '$idLock'");

		break;
		}
		case 'lockBarang':{
				$idPosting = $_REQUEST[$this->Prefix.'_cb'];
				$fm = $this->lockBarang($idPosting[0]);
				$cek .= $fm['cek'];
				if(empty($_REQUEST['filterPeriode'])){
						$err = "Pilih Periode";
				}

				$content = $fm['content'];
		break;
		}
		case 'kartuPersediaan':{
				$idPosting = $_REQUEST[$this->Prefix.'_cb'];
				$getDataIdPosting = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '$idPosting[0]'"));
				if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where c1='".$getDataIdPosting['c1']."' and c='".$getDataIdPosting['c']."' and d='".$getDataIdPosting['d']."' and e='".$getDataIdPosting['e']."' and e1='".$getDataIdPosting['e1']."'  and f='".$getDataIdPosting['f']."' and g='".$getDataIdPosting['g']."'  and h='".$getDataIdPosting['h']."'  and i='".$getDataIdPosting['i']."'  and j='".$getDataIdPosting['j']."'  and j1='".$getDataIdPosting['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '".$_REQUEST['filterPeriode']."'")) == 0){
					$err = "Data belum dikunci !";
				}
				$getDataLock = mysql_fetch_array(mysql_query("select * from t_persediaan_lock_barang where c1='".$getDataIdPosting['c1']."' and c='".$getDataIdPosting['c']."' and d='".$getDataIdPosting['d']."' and e='".$getDataIdPosting['e']."' and e1='".$getDataIdPosting['e1']."'  and f='".$getDataIdPosting['f']."' and g='".$getDataIdPosting['g']."'  and h='".$getDataIdPosting['h']."'  and i='".$getDataIdPosting['i']."'  and j='".$getDataIdPosting['j']."'  and j1='".$getDataIdPosting['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '".$_REQUEST['filterPeriode']."'"));

				$fm = $this->showKartu($getDataLock['id']);
				$cek = $getDataLock['id'];
				if(empty($_REQUEST['filterPeriode'])){
						$err = "Pilih Periode";
				}

				$content = $fm['content'];
		break;
		}
		case 'showKartu':{
				$idLock = $_REQUEST['idLock'];
				$fm = $this->showKartu($idLock);
				$cek .= $fm['cek'];
				$err .= $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'checkError':{
				$idPersediaan = $_REQUEST['idPersediaan'];
				$fm = $this->checkError($idPersediaan);
				$cek .= $fm['cek'];
				$err .= $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'detailPengeluaran':{
				$idPengeluaran = $_REQUEST['idPengeluaran'];
				$fm = $this->detailPengeluaran($idPengeluaran);
				$cek .= $fm['cek'];
				$err .= $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'detailPengeluaranTemp':{
				$idPengeluaran = $_REQUEST['idPengeluaran'];
				$fm = $this->detailPengeluaranTemp($idPengeluaran);
				$cek .= $fm['cek'];
				$err .= $fm['err'];
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
		case 'newTab':{
			foreach ($_REQUEST as $key => $value) {
					$$key = $value;
			}
			mysql_query("delete from temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from temp_detail_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_detail_rincian_distribusi where username = '$this->username'");
			$getDataMax = mysql_fetch_array(mysql_query("select max(nomor) from distribusi where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  "));
			$explodeNomor = explode('/',$getDataMax['max(nomor)']);
			$nomorTerakhir = $explodeNomor[0] + 1;
			$nomorPengeluaran = $this->kasihNol($nomorTerakhir );
			$nomor = $nomorPengeluaran."/"."D/".$c1.".".$c.".".$d.".".$e.".".$e1."/".$_COOKIE['coThnAnggaran'];

			$dataInsert = array(
								'c1' => $c1,
								'c' => $c,
								'd' => $d,
								'e' => $e,
								'e1' => $e1,
								'nomor' => $nomor,
								'status_temp' => "1",
								'tanggal' => date("Y-m-d"),
								'tanggal_buku' => date("Y-m-d"),
			);
			$query = VulnWalkerInsert($this->TblName,$dataInsert);
			mysql_query($query);
			$cek = $query;



			$content = array("nomor" => $nomor);

		break;
		}




		case 'editTab':{
			mysql_query("delete from temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from temp_detail_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_detail_rincian_distribusi where username = '$this->username'");
			$id = $_REQUEST['daftarPersediaanBarang_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$getDataDistribusi = mysql_fetch_array(mysql_query("select * from distribusi where id = '".$id[0]."'"));
			$kodeSKPD = $getDataDistribusi['c1'].".".$getDataDistribusi['c'].".".$getDataDistribusi['d'].".".$getDataDistribusi['e'].".".$getDataDistribusi['e1'];
			$nomor = $getDataDistribusi['nomor'];

			$getAllRincianDistribusi = mysql_query("select * from rincian_distribusi where id_distribusi ='".$id[0]."'");
			while ($rincianDistribusi = mysql_fetch_array($getAllRincianDistribusi)) {
				foreach ($rincianDistribusi as $key => $value) {
						$$key = $value;
				}
				$dataRincian = array(
										'f1' => $f1,
										'f2' => $f2,
										'f' => $f,
										'g' => $g,
										'h' => $h,
										'i' => $i,
										'j' => $j,
										'j1' => $j1,
										'jumlah' => $jumlah,
										'id_rincian_distribusi' => $rincianDistribusi['id'],
										'username' => $this->username
				);
				$query = VulnWalkerInsert('temp_rincian_distribusi',$dataRincian);
				mysql_query($query);
				$getIdTempRincianDistribusi = mysql_fetch_array(mysql_query("select max(id) from temp_rincian_distribusi where username = '$this->username'"));
				$getAllDetailRincianDistribusi = mysql_query("select * from detail_rincian_distribusi where id_rincian_distribusi = '".$rincianDistribusi['id']."'");
				while ($detailRincianDistribusi = mysql_fetch_array($getAllDetailRincianDistribusi)) {
						$dataDetailRincian = array(
								'c1' => $detailRincianDistribusi['c1'],
								'c' => $detailRincianDistribusi['c'],
								'd' => $detailRincianDistribusi['d'],
								'e' => $detailRincianDistribusi['e'],
								'e1' => $detailRincianDistribusi['e1'],
								'jumlah' => $detailRincianDistribusi['jumlah'],
								'id_rincian_distribusi' => $getIdTempRincianDistribusi['max(id)'],
								'id_detail_rincian_distribusi' => $detailRincianDistribusi['id'],
								'username' => $this->username
						);
						mysql_query(VulnWalkerInsert("temp_detail_rincian_distribusi",$dataDetailRincian));
				}

			}

				$content = array('skpd' => $kodeSKPD,'nomor'=> $nomor);
			break;
		}

		case 'Remove':{
			$id = $_REQUEST['daftarPersediaanBarang_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id ='$id[0]'"));
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

			$getAll = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and status_validasi !='1' order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rka_21 where user='$username'");
			mysql_query("delete from temp_rincian_volume_21 where user='$username'");
		    mysql_query("delete from temp_alokasi_rka_21_v2 where user='$username'");
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				}
				mysql_query("delete from tabel_DAFTAR PERSEDIAAN BARANG where id = '$id'");
				//mysql_query("delete from tabel_DAFTAR PERSEDIAAN BARANG where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and o1 ='$o1' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and jenis_rka='2.1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");

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


					$qry = "SELECT * FROM tabel_DAFTAR PERSEDIAAN BARANG WHERE id = '$idplh' ";$cek=$qry;
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

			$getData = mysql_fetch_array(mysql_query("SELECT * FROM tabel_DAFTAR PERSEDIAAN BARANG WHERE id = '$idAwal'"));
			foreach ($getData as $key => $value) {
				  $$key = $value;
			}
			$getMaxID = mysql_fetch_array(mysql_query("select max(id) as maxID from tabel_DAFTAR PERSEDIAAN BARANG where tahun = '$tahun'  and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q' and jenis_anggaran = '$jenis_anggaran'  "));
			$maxID = $getMaxID['maxID'];
			$aqry = "select * from tabel_DAFTAR PERSEDIAAN BARANG where id ='$maxID' ";
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
			<script type='text/javascript' src='js/persediaan/daftarPersediaanBarang.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/persediaan/listKartuKunci.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/persediaan/kartuError.js' language='JavaScript' ></script>
			  <link rel='stylesheet' href='datepicker/jquery-ui.css'>
			  <script src='datepicker/jquery-1.12.4.js'></script>
			  <script src='datepicker/jquery-ui.js'></script>

			".
			$scriptload;
	}

	// function setFormBaru(){
	// 	$dt=array();
	// 	//$this->form_idplh ='';
	// 	$this->form_fmST = 0;
	// 	$dt['tgl'] = date("Y-m-d");
	// 	$fm = $this->setForm($dt);
	// 	return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	// }

  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		if($err == ''){
			$aqry = "SELECT * FROM  tabel_DAFTAR PERSEDIAAN BARANG WHERE id='".$this->form_idplh."' "; $cek.=$aqry;
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
	 $this->form_caption = 'INFO DAFTAR PERSEDIAAN BARANG';


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

		foreach ($_REQUEST as $key => $value) {
 		  			$$key = $value;
 	 }
	 if($daftarPersediaanBarangSKPD2fmSEKSI != '000' && $daftarPersediaanBarangSKPD2fmSUBUNIT == '01'){
			if($daftarPersediaanBarangSKPD2fmSEKSI == '001'){
				$headerTable =
					"<thead>
					 <tr>
					 <th class='th01' width='20' rowspan='2'>NO</th>
					 <th class='th01' width='20' rowspan='2'></th>

					 <th class='th01' width='700' rowspan='2'>NAMA BARANG</th>
					 <th class='th01' width='40' rowspan='2' >SATUAN</th>
					 <th class='th01' width='50' rowspan='2' >AWAL</th>
					 <th class='th02' width='50' rowspan='1' colspan ='4'>BERTAMBAH</th>
					 <th class='th02' width='50' rowspan='1' colspan ='4'>BERKURANG</th>
					 <th class='th01' width='50' rowspan='2'>AKHIR</th>
					 <th class='th01' width='50' rowspan='2'>STATUS</th>
					 </tr>
					 <tr>
						<th class='th01' width='50' rowspan='1'>BELI</th>
						<th class='th01' width='50' rowspan='1'>HIBAH</th>
						<th class='th01' width='50' rowspan='1'>CEK FISIK</th>
						<th class='th01' width='50' rowspan='1'>JUMLAH</th>
						<th class='th01' width='50' rowspan='1'>KELUAR</th>
						<th class='th01' width='50' rowspan='1'>DISTRIBUSI</th>
						<th class='th01' width='50' rowspan='1'>CEK FISIK</th>
						<th class='th01' width='50' rowspan='1'>JUMLAH</th>
					 </tr>

					 </thead>";
			}else{
					$headerTable =
	 			 "<thead>
	 				<tr>
	 				<th class='th01' width='20' rowspan='2'>NO2</th>
	 				<th class='th01' width='20' rowspan='2'></th>
	 				<th class='th01' width='700' rowspan='2'>NAMA BARANG</th>
	 				<th class='th01' width='40' rowspan='2'>SATUAN</th>
	 				<th class='th01' width='50' rowspan='2'>AWAL</th>
	 				<th class='th02' width='50' rowspan='1' colspan ='5'>BERTAMBAH</th>
	 				<th class='th02' width='50' rowspan='1' colspan ='3'>BERKURANG</th>
	 				<th class='th01' width='50' rowspan='2'>AKHIR</th>
	 				<th class='th01' width='50' rowspan='2'>STATUS</th>
	 				</tr>
	 				<tr>
	 				 <th class='th01' width='50' rowspan='1'>BELI</th>
	 				 <th class='th01' width='50' rowspan='1'>HIBAH</th>
	 				 <th class='th01' width='50' rowspan='1'>DISTRIBUSI</th>
	 				 <th class='th01' width='50' rowspan='1'>CEK FISIK</th>
	 				 <th class='th01' width='50' rowspan='1'>JUMLAH</th>
	 				 <th class='th01' width='50' rowspan='1'>KELUAR</th>
	 				 <th class='th01' width='50' rowspan='1'>CEK FISIK</th>
	 				 <th class='th01' width='50' rowspan='1'>JUMLAH</th>
	 				</tr>
	 				</thead>";
			}
	 }elseif($daftarPersediaanBarangSKPD2fmSEKSI != '000' && ( $daftarPersediaanBarangSKPD2fmSUBUNIT != '01' )){
			 $headerTable =
			 "<thead>
				<tr>
				<th class='th01' width='20' rowspan='2'>NO2</th>
				<th class='th01' width='20' rowspan='2'></th>
				<th class='th01' width='700' rowspan='2'>NAMA BARANG</th>
				<th class='th01' width='40' rowspan='2'>SATUAN</th>
				<th class='th01' width='50' rowspan='2'>AWAL</th>
				<th class='th02' width='50' rowspan='1' colspan ='5'>BERTAMBAH</th>
				<th class='th02' width='50' rowspan='1' colspan ='3'>BERKURANG</th>
				<th class='th01' width='50' rowspan='2'>AKHIR</th>
				<th class='th01' width='50' rowspan='2'>STATUS</th>
				</tr>
				<tr>
				 <th class='th01' width='50' rowspan='1'>BELI</th>
				 <th class='th01' width='50' rowspan='1'>HIBAH</th>
				 <th class='th01' width='50' rowspan='1'>DISTRIBUSI</th>
				 <th class='th01' width='50' rowspan='1'>CEK FISIK</th>
				 <th class='th01' width='50' rowspan='1'>JUMLAH</th>
				 <th class='th01' width='50' rowspan='1'>KELUAR</th>
				 <th class='th01' width='50' rowspan='1'>CEK FISIK</th>
				 <th class='th01' width='50' rowspan='1'>JUMLAH</th>
				</tr>
				</thead>";
		 }else{
			 $headerTable =
	 		  "<thead>
	 		   <tr>
	 			 <th class='th01' width='20' rowspan='2'>NO</th>

	 		   <th class='th01' width='700' rowspan='2'>NAMA BARANG</th>
	 		   <th class='th01' width='40' rowspan='2'>SATUAN</th>
	 		   <th class='th01' width='50' rowspan='2'>AWAL</th>
	 		   <th class='th02' width='50' rowspan='1' colspan ='5'>BERTAMBAH</th>
	 		   <th class='th02' width='50' rowspan='1' colspan ='3'>BERKURANG</th>
	 		   <th class='th01' width='50' rowspan='2'>AKHIR</th>
	 		   </tr>
	 			 <tr>
	 			 	<th class='th01' width='50' rowspan='1'>BELI</th>
	 			 	<th class='th01' width='50' rowspan='1'>HIBAH</th>
					<th class='th01' width='50' rowspan='1'>DISTRIBUSI</th>
					<th class='th01' width='50' rowspan='1'>CEK FISIK</th>
	 			 	<th class='th01' width='50' rowspan='1'>JUMLAH</th>
	 			 	<th class='th01' width='50' rowspan='1'>KELUAR</th>
					<th class='th01' width='50' rowspan='1'>CEK FISIK</th>
	 			 	<th class='th01' width='50' rowspan='1'>JUMLAH</th>
	 			 </tr>

	 		   </thead>";
		 }

	 $NomorColSpan = $Mode==1? 2: 1;


		return $headerTable;
	}

	function generateHitung($idDaftar,$periode,$tahun,$kodeSKPD,$kodeBarang){
		$err = "";
		$cek = "";
		$content = "";
		mysql_query("delete from temp_lock where id_daftar = '$idDaftar' and username = '$this->username'");
		mysql_query("delete from temp_lock_tambah where id_daftar = '$idDaftar' and username = '$this->username'");
		mysql_query("delete from temp_lock_kurang where id_daftar = '$idDaftar' and username = '$this->username'");
		$kondisiTahun = " and left(tanggal_buku,4) = '".$tahun."' ";
		if(!empty($periode)){
		    if($periode == '1'){
		        $maxFilter = $_COOKIE['coThnAnggaran']."06";
		        $kondisiPeriode  = " and replace(left(tanggal_buku,6),'-','') <= '$maxFilter' ";
		    }elseif($periode == '2'){
		        $minFilter = $_COOKIE['coThnAnggaran']."07";
		        $maxFilter = $_COOKIE['coThnAnggaran']."12";
		        $kondisiPeriode= " and replace(left(tanggal_buku,6),'-','') >= '$minFilter' and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
		    }elseif($periode == '3'){
		        $maxFilter = $_COOKIE['coThnAnggaran']."12";
		        $kondisiPeriode = " and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
		    }
		}
		$getData = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '$idDaftar'"));
		$getDataTambah = mysql_query("select * from t_kartu_persediaan where c1='".$getData['c1']."' and c='".$getData['c']."' and d='".$getData['d']."' and e='".$getData['e']."' and e1='".$getData['e1']."' and f1='".$getData['f1']."' and f2='".$getData['f2']."' and f='".$getData['f']."' and g='".$getData['g']."' and h='".$getData['h']."' and i='".$getData['i']."' and j='".$getData['j']."' and j1='".$getData['j1']."' and jenis_persediaan = '1' $kondisiTahun $kondisiPeriode order by tanggal_buku asc");
		while ($dataTambah = mysql_fetch_array($getDataTambah)) {
		    $dataLockTambah = array(
		                'tanggal' => $dataTambah['tanggal_buku'],
		                'id_t_kartu_persediaan' => $dataTambah['id'],
		                'jumlah' => $dataTambah['jumlah'],
		                'harga' => $dataTambah['harga_satuan'],
		                'sisa' => $dataTambah['jumlah'],
		                'id_daftar' => $idDaftar,
										'username' => $this->username
		    );
		    mysql_query(VulnWalkerInsert('temp_lock_tambah',$dataLockTambah));
		}

		$getDataKurang = mysql_query("select * from t_kartu_persediaan where c1='".$getData['c1']."' and c='".$getData['c']."' and e='".$getData['e']."' and e1='".$getData['e1']."' and d='".$getData['d']."' and f1='".$getData['f1']."' and f2='".$getData['f2']."' and f='".$getData['f']."' and g='".$getData['g']."' and h='".$getData['h']."' and i='".$getData['i']."' and j='".$getData['j']."' and j1='".$getData['j1']."' and jenis_persediaan = '2' $kondisiTahun $kondisiPeriode order by tanggal_buku asc");
		while ($dataKurang = mysql_fetch_array($getDataKurang)) {
		    $arrayPerolehan = array();
		    $jumlahBarangKurang = $dataKurang['jumlah'];
		    $getDataPenerimaan = mysql_query("select * from temp_lock_tambah where id_daftar = '".$idDaftar."' and sisa !='0'");
		    while ($dataPenerimaan = mysql_fetch_array($getDataPenerimaan)) {
		        if($jumlahBarangKurang != 0){
		          if($jumlahBarangKurang > $dataPenerimaan['sisa'] ){
		              mysql_query("update temp_lock_tambah set sisa = sisa - ".$dataPenerimaan['sisa']." where id = '".$dataPenerimaan['id']."'");
		              $arrayPerolehan[] = array(
		                                        'idPenerimaan' => $dataPenerimaan['id_t_kartu_persediaan'],
		                                        'jumlah' => $dataPenerimaan['sisa'],
		                                        'harga' => $dataPenerimaan['harga'],
																						'total' => $dataPenerimaan['sisa'] * $dataPenerimaan['harga']
		                                       );
		              $jumlahBarangKurang -= $dataPenerimaan['sisa'];
		          }else{
		              mysql_query("update temp_lock_tambah set sisa = sisa - $jumlahBarangKurang where id = '".$dataPenerimaan['id']."'");
		              $arrayPerolehan[] = array(
		                                        'idPenerimaan' => $dataPenerimaan['id_t_kartu_persediaan'],
		                                        'jumlah' => $jumlahBarangKurang,
		                                        'harga' => $dataPenerimaan['harga'],
																						'total' => $jumlahBarangKurang * $dataPenerimaan['harga']
		                                       );
		              $jumlahBarangKurang = 0;
		          }
		        }
		    }
				$encoding = json_encode($arrayPerolehan);
				$decoding = json_decode($encoding);
				$hargaPerolehan= "";
				for ($i=0; $i < sizeof($decoding) ; $i++) {
						$hargaPerolehan += $decoding[$i]->total;
				}
		    $dataLockKurang = array(
		                'tanggal' => $dataKurang['tanggal_buku'],
		                'id_t_kartu_persediaan' => $dataKurang['id'],
		                'jumlah' => $dataKurang['jumlah'],
										 'harga' => $hargaPerolehan,
		                'id_daftar' => $idDaftar,
										'username' => $this->username,
		                'perolehan' => json_encode($arrayPerolehan)

		    );
		    mysql_query(VulnWalkerInsert('temp_lock_kurang',$dataLockKurang));
		}



		$getDataHistori = mysql_query("select * from t_kartu_persediaan where c1='".$getData['c1']."' and c='".$getData['c']."' and d='".$getData['d']."' and e='".$getData['e']."' and e1='".$getData['e1']."' and f1='".$getData['f1']."' and f2='".$getData['f2']."' and f='".$getData['f']."' and g='".$getData['g']."' and h='".$getData['h']."' and i='".$getData['i']."' and j='".$getData['j']."' and j1='".$getData['j1']."'  $kondisiTahun $kondisiPeriode order by tanggal_buku,jenis_persediaan asc");
		$cek = "select * from t_kartu_persediaan where c1='".$getData['c1']."' and c='".$getData['c']."' and d='".$getData['d']."' and e='".$getData['e']."' and e1='".$getData['e1']."' and f1='".$getData['f1']."' and f2='".$getData['f2']."' and f='".$getData['f']."' and g='".$getData['g']."' and h='".$getData['h']."' and i='".$getData['i']."' and j='".$getData['j']."' and j1='".$getData['j1']."'  $kondisiTahun $kondisiPeriode order by tanggal_buku,jenis_persediaan asc";
		while ($dataHistori = mysql_fetch_array($getDataHistori)) {
		    if($dataHistori['jenis_persediaan'] == 1){
		      if($dataHistori['jns'] == '1'){
		        $barangMasuk = $dataHistori['jumlah'];
		        $barangKeluar = 0;
		        $uraianPersediaan = "SALDO AWAL";
		      }elseif($dataHistori['jns'] == '2'){
		        $barangMasuk = $dataHistori['jumlah'];
		        $barangKeluar = 0;
		        if($dataHistori['cara_perolehan'] == '2'){
		          $uraianPersediaan = "PENERIMAAN PEMBELIAN";
		        }elseif($dataHistori['cara_perolehan'] == '3'){
		          $uraianPersediaan = "PENERIMAAN HIBAH";
		        }
		      }elseif($dataHistori['jns'] == '4'){
		        $barangMasuk = $dataHistori['jumlah'];
		        $barangKeluar = 0;
		        $uraianPersediaan = "CEK FISIK TAMBAH";
		      }elseif($dataHistori['jns'] == '3'){
		        $barangMasuk = $dataHistori['jumlah'];
		        $barangKeluar = 0;
		        $uraianPersediaan = "PENERIMAAN DISTRIBUSI";
		      }
					$hargaSatuan = $dataHistori['harga_satuan'];
					$totalHarga = $hargaSatuan * $dataHistori['jumlah'];
		      $saldoBarang += $dataHistori['jumlah'];
					$totalSaldo += $totalHarga;
		    }else{
		        if($dataHistori['jns'] == '6'){
		          $barangKeluar = $dataHistori['jumlah'];
		          $barangMasuk = 0;
		          $uraianPersediaan = "PENGELUARAAN";
		        }elseif($dataHistori['jns'] == '5'){
		          $barangKeluar = $dataHistori['jumlah'];
		          $barangMasuk = 0;
		          $uraianPersediaan = "CEK FISIK KURANG";
		        }elseif($dataHistori['jns'] == '7'){
		          $barangKeluar = $dataHistori['jumlah'];
		          $barangMasuk = 0;
		          $uraianPersediaan = "PENGELUARAN DISTRIBUSI";
		        }
						$hargaSatuan = "";
		      $saldoBarang -= $dataHistori['jumlah'];
				  $getTotalHarga = mysql_fetch_array(mysql_query("select * from temp_lock_kurang where id_daftar = '$idDaftar' and username ='$this->username' and id_t_kartu_persediaan = '".$dataHistori['id']."'"));
					$totalHarga = $getTotalHarga['harga'];
					$totalSaldo -= $totalHarga;
		    }

		    if($saldoBarang < 0){
		        $err = "Tanggal saldo minus";
		    }
		    $dataRincianLock = array(
		                'id_daftar' => $idDaftar,
		                'username' => $this->username,
		                'tanggal' => $dataHistori['tanggal_buku'],
		                'uraian' => $uraianPersediaan,
		                'masuk' => $barangMasuk,
		                'keluar' => $barangKeluar,
		                'harga_satuan' => $hargaSatuan,
		                'saldo' => $saldoBarang,
		                'total' => $totalHarga,
		                'total_harga' => $totalSaldo,
		                'type' => $dataHistori['jenis_persediaan'],
		                'id_t_kartu_persediaan' => $dataHistori['id'],
		                'tahun' => $tahun,
		                'periode' => $periode,
		    );
		    mysql_query(VulnWalkerInsert('temp_lock',$dataRincianLock));

		}





			return json_encode(array('err' => $err,'cek' => $cek, 'content' => $content ));
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
		  			$$key = $value;
	 }
	 foreach ($_REQUEST as $key => $value) {
					 $$key = $value;
	}
	$kondisiTahun = " and left(tanggal_buku,4) = '".$_COOKIE['coThnAnggaran']."' ";
	if(!empty($filterPeriode)){
			if($filterPeriode == '1'){
					$maxFilter = $_COOKIE['coThnAnggaran']."06";
					$kondisiPeriode  = " and replace(left(tanggal_buku,6),'-','') <= '$maxFilter' ";
					$semester = " and semester = '1' ";
			}elseif($filterPeriode == '2'){
					$minFilter = $_COOKIE['coThnAnggaran']."07";
					$maxFilter = $_COOKIE['coThnAnggaran']."12";
					$kondisiPeriode= " and replace(left(tanggal_buku,6),'-','') >= '$minFilter' and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
					$semester = " and semester = '2' ";
			}elseif($filterPeriode == '3'){
					$maxFilter = $_COOKIE['coThnAnggaran']."12";
					$kondisiPeriode = " and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
					$semester = " and semester = '3' ";
			}
	}
		if($daftarPersediaanBarangSKPD2fmSUBUNIT == '01' && $daftarPersediaanBarangSKPD2fmSEKSI != '000'){
				if($daftarPersediaanBarangSKPD2fmSEKSI == '001' ){
					$dataHitung = json_decode($this->generateHitung($id,$filterPeriode,$_COOKIE['coThnAnggaran'],$c1.".".$c.".".$d.".".$e.".".$e1,$f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$i.".".$j.".".$j1));

					$Koloms = array();
					$Koloms[] = array(' align="center"',$no);
					$Koloms[] = array(' align="center"',$TampilCheckBox);
					$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h ='$h' and i='$i' and j='$j' and j1='$j1'"));
					$Koloms[] = array(' align="left" valign="middle"',$getNamaBarang['nm_barang']);
					$Koloms[] = array(' align="left" valign="middle"',$getNamaBarang['satuan']);
					$saldoAwal = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '1' and jenis_persediaan = '1' $kondisiTahun"));
					$Koloms[] = array(' align="right" valign="middle"',number_format($saldoAwal['jumlah'],0,',','.'));
					$beli = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '2' $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right" valign="middle"',number_format($beli['sum(jumlah)'],0,',','.'));
					$hibah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '3' $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right" valign="middle"',number_format($hibah['sum(jumlah)'],0,',','.'));
					$cekFisikTambah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '4' and jenis_persediaan = '1'  $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right" valign="middle"',number_format($cekFisikTambah['sum(jumlah)'],0,',','.'));
					$Koloms[] = array(' align="right" valign="middle"',number_format($beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] ,0,',','.'));
					$keluar = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '6' and jenis_persediaan = '2' $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right" valign="middle"',number_format($keluar['sum(jumlah)'],0,',','.')."");
					$distribusi = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '7' and jenis_persediaan = '2' $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right" valign="middle"',number_format($distribusi['sum(jumlah)'],0,',','.')."");
					$cekfisiKurang = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '5' and jenis_persediaan = '2'  $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right" valign="middle"',number_format($cekfisiKurang['sum(jumlah)'],0,',','.'));
					$Koloms[] = array(' align="right" valign="middle"',number_format($keluar['sum(jumlah)'] + $distribusi['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'],0,',','.')."");

					if($dataHitung->err !=''){
							$Koloms[] = array(' align="right" valign="middle"',"<span style='color:red;cursor:pointer;' onclick=$this->Prefix.checkError($id);>".number_format( ($saldoAwal['jumlah'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] ) - ($keluar['sum(jumlah)'] + $distribusi['sum(jumlah)'] + $cekfisiKurang['sum(jumlah)']) ,0,',','.')."</span>"  );
					}else{
						// ini
							$Koloms[] = array(' align="right" valign="middle"',number_format( ($saldoAwal['jumlah'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] ) - ($keluar['sum(jumlah)'] + $distribusi['sum(jumlah)'] + $cekfisiKurang['sum(jumlah)']) ,0,',','.')  );
					}

					if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and i='$i' and j='$j' and j1='$j1' and tahun ='".$_COOKIE['coThnAnggaran']."' $semester")) != 0 ){
							$getIdLock = mysql_fetch_array(mysql_query("select * from t_persediaan_lock_barang where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and i='$i' and j='$j' and j1='$j1' and tahun ='".$_COOKIE['coThnAnggaran']."' $semester"));
							$idLock = $getIdLock['id'];
							$statusKunci = "<img src='images/administrator/images/lock.svg' style='width:20px;height:20px;' >";
					}else{
							$statusKunci = "<img src='images/administrator/images/unlock.svg' style='width:20px;height:20px;' >";
					}
					$Koloms[] = array(' align="center"', $statusKunci);
				}else{
					$dataHitung = json_decode($this->generateHitung($id,$filterPeriode,$_COOKIE['coThnAnggaran'],$c1.".".$c.".".$d.".".$e.".".$e1,$f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$i.".".$j.".".$j1));
					$Koloms = array();
					$Koloms[] = array(' align="center"',$no);
					$Koloms[] = array(' align="center"',$TampilCheckBox);
					$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h ='$h' and i='$i' and j='$j' and j1='$j1'"));
					$Koloms[] = array(' align="left"',$getNamaBarang['nm_barang']);
					$Koloms[] = array(' align="left"',$getNamaBarang['satuan']);
					$saldoAwal = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '1' and jenis_persediaan = '1'  $kondisiTahun "));
					$Koloms[] = array(' align="right"',number_format($saldoAwal['jumlah'],0,',','.'));
					$beli = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '2'  $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right"',number_format($beli['sum(jumlah)'],0,',','.'));
					$hibah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '3'  $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right"',number_format($hibah['sum(jumlah)'],0,',','.'));
					$distribusiTambah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '3' and jenis_persediaan = '1' $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right"',number_format($distribusiTambah['sum(jumlah)'],0,',','.')."");
					$cekFisikTambah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '4' and jenis_persediaan = '1' $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right"',number_format($cekFisikTambah['sum(jumlah)'],0,',','.'));
					$Koloms[] = array(' align="right"',number_format( $distribusiTambah['sum(jumlah)'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] ,0,',','.'));
					$keluar = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '6' and jenis_persediaan = '2' $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right"',number_format($keluar['sum(jumlah)'],0,',','.')."");
					$cekFisifKurang = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '5' and jenis_persediaan = '2' $kondisiTahun $kondisiPeriode"));
					$Koloms[] = array(' align="right"',number_format($cekFisifKurang['sum(jumlah)'],0,',','.')."");
					$Koloms[] = array(' align="right"',number_format($keluar['sum(jumlah)'] ,0,',','.')."");
					if($dataHitung->err !=''){
							$Koloms[] = array(' align="right"',"<span style='color:red;cursor:pointer;' onclick=$this->Prefix.checkError($id);>".number_format( ( $saldoAwal['jumlah'] + $distribusiTambah['sum(jumlah)'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] )  -   ($keluar['sum(jumlah)'] + $cekFisifKurang['sum(jumlah)'] ),0,',','.')."<span>"  );
					}else{
							$Koloms[] = array(' align="right"',number_format( ( $saldoAwal['jumlah'] + $distribusiTambah['sum(jumlah)'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] )  -   ($keluar['sum(jumlah)'] + $cekFisifKurang['sum(jumlah)'] ),0,',','.')  );
					}

					if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and i='$i' and j='$j' and j1='$j1' and tahun ='".$_COOKIE['coThnAnggaran']."' $semester")) != 0 ){
							$getIdLock = mysql_fetch_array(mysql_query("select * from t_persediaan_lock_barang where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and i='$i' and j='$j' and j1='$j1' and tahun ='".$_COOKIE['coThnAnggaran']."' $semester"));
							$idLock = $getIdLock['id'];
							$statusKunci = "<img src='images/administrator/images/lock.svg' style='width:20px;height:20px;' >";
					}else{
							$statusKunci = "<img src='images/administrator/images/unlock.svg' style='width:20px;height:20px;' >";
					}
					$Koloms[] = array(' align="center"', $statusKunci);
				}
		}elseif($daftarPersediaanBarangSKPD2fmSEKSI != '000' && ( $daftarPersediaanBarangSKPD2fmSUBUNIT != '01' )){
				$dataHitung = json_decode($this->generateHitung($id,$filterPeriode,$_COOKIE['coThnAnggaran'],$c1.".".$c.".".$d.".".$e.".".$e1,$f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$i.".".$j.".".$j1));
				$Koloms = array();
				$Koloms[] = array(' align="center"',$no);
				$Koloms[] = array(' align="center"',$TampilCheckBox);
				$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h ='$h' and i='$i' and j='$j' and j1='$j1'"));
				$Koloms[] = array(' align="left"',$getNamaBarang['nm_barang']);
				$Koloms[] = array(' align="left"',$getNamaBarang['satuan']);
				$saldoAwal = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '1' and jenis_persediaan = '1'  $kondisiTahun "));
				$Koloms[] = array(' align="right"',number_format($saldoAwal['jumlah'],0,',','.'));
				$beli = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '2'  $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($beli['sum(jumlah)'],0,',','.'));
				$hibah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '3'  $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($hibah['sum(jumlah)'],0,',','.'));
				$distribusiTambah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '3' and jenis_persediaan = '1' $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($distribusiTambah['sum(jumlah)'],0,',','.')."");
				$cekFisikTambah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '4' and jenis_persediaan = '1' $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($cekFisikTambah['sum(jumlah)'],0,',','.'));
				$Koloms[] = array(' align="right"',number_format( $distribusiTambah['sum(jumlah)'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] ,0,',','.'));
				$keluar = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '6' and jenis_persediaan = '2' $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($keluar['sum(jumlah)'],0,',','.')."");
				$cekFisifKurang = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '5' and jenis_persediaan = '2' $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($cekFisifKurang['sum(jumlah)'],0,',','.')."");
				$Koloms[] = array(' align="right"',number_format($keluar['sum(jumlah)'] ,0,',','.')."");
				if($dataHitung->err !=''){
					$Koloms[] = array(' align="right"',"<span style='color:red;cursor:pointer;' onclick=$this->Prefix.checkError($id);>".number_format( ( $saldoAwal['jumlah'] + $distribusiTambah['sum(jumlah)'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] )  -   ($keluar['sum(jumlah)'] + $cekFisifKurang['sum(jumlah)'] ),0,',','.')."<span>"  );
				}else{
					$Koloms[] = array(' align="right"',number_format( ( $saldoAwal['jumlah'] + $distribusiTambah['sum(jumlah)'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] )  -   ($keluar['sum(jumlah)'] + $cekFisifKurang['sum(jumlah)'] ),0,',','.')  );
				}

				if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and i='$i' and j='$j' and j1='$j1' and tahun ='".$_COOKIE['coThnAnggaran']."' $semester")) != 0 ){
						$getIdLock = mysql_fetch_array(mysql_query("select * from t_persediaan_lock_barang where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and i='$i' and j='$j' and j1='$j1' and tahun ='".$_COOKIE['coThnAnggaran']."' $semester"));
						$idLock = $getIdLock['id'];
						$statusKunci = "<img src='images/administrator/images/lock.svg' style='width:20px;height:20px;' >";
				}else{
						$statusKunci = "<img src='images/administrator/images/unlock.svg' style='width:20px;height:20px;' >";
				}
				$Koloms[] = array(' align="center"', $statusKunci);
		}else{

				$Koloms = array();
				$Koloms[] = array(' align="center"',$no);
				$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h ='$h' and i='$i' and j='$j' and j1='$j1'"));
				$Koloms[] = array(' align="left"',$getNamaBarang['nm_barang']);
				$Koloms[] = array(' align="left"',$getNamaBarang['satuan']);
				$saldoAwal = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '1' and jenis_persediaan = '1'  $kondisiTahun "));
				$Koloms[] = array(' align="right"',number_format($saldoAwal['jumlah'],0,',','.'));
				$beli = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '2'  $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($beli['sum(jumlah)'],0,',','.'));
				$hibah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '3'  $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($hibah['sum(jumlah)'],0,',','.'));
				$distribusiTambah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '3' and jenis_persediaan = '1' $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($distribusiTambah['sum(jumlah)'],0,',','.')."");
				$cekFisikTambah = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '4' and jenis_persediaan = '1' $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($cekFisikTambah['sum(jumlah)'],0,',','.'));
				$Koloms[] = array(' align="right"',number_format( $distribusiTambah['sum(jumlah)'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] ,0,',','.'));
				$keluar = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '6' and jenis_persediaan = '2' $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($keluar['sum(jumlah)'],0,',','.')."");
				$cekFisifKurang = mysql_fetch_array(mysql_query("select sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and jns = '5' and jenis_persediaan = '2' $kondisiTahun $kondisiPeriode"));
				$Koloms[] = array(' align="right"',number_format($cekFisifKurang['sum(jumlah)'],0,',','.')."");
				$Koloms[] = array(' align="right"',number_format($keluar['sum(jumlah)'] ,0,',','.')."");
				$Koloms[] = array(' align="right"',number_format( ( $saldoAwal['jumlah'] + $distribusiTambah['sum(jumlah)'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] )  -   ($keluar['sum(jumlah)'] + $cekFisifKurang['sum(jumlah)'] ),0,',','.')  );
		}



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
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI DAFTAR PERSEDIAAN BARANG 2.1';
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
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
	 }
	 $arrayPerhitungan = array(
		 				array('FISIK','FISIK'),
		 				array('HARGA','HARGA'),
	 );
	 $comboPerhitungan = cmbArray('filterPerhitungan',"FISIK",$arrayPerhitungan,'-- PERHITUNGAN --',"onchange=$this->Prefix.refreshList(true); disabled");
	 // $arrayPeriode = array(
		//  				array('1','JANUARI'),
		//  				array('2','FEBRUARI'),
		//  				array('3','MARET'),
		//  				array('4','APRIL'),
		//  				array('5','MEI'),
		//  				array('6','JUNI'),
		//  				array('7','JULI'),
		//  				array('8','AGUSTUS'),
		//  				array('9','SEPTEMBER'),
		//  				array('10','OKTOBER'),
		//  				array('11','NOPEMBER'),
		//  				array('12','DESEMBER'),
	 // );
	 $arrayPeriode = array(
		 				array('1','SEMESTER 1'),
		 				array('2','SEMESTER 2'),
		 				array('3','TAHUNAN'),
	 );
if(empty($filterPeriode))$filterPeriode ='1';
$comboPeriode = cmbArray('filterPeriode',$filterPeriode,$arrayPeriode,'-- PERHITUNGAN --',"onchange=$this->Prefix.refreshList(true);");
$cmbAkun = "0";
$cmbKelompok = "0";
$cmbJenis = "08";
$jumlahData = $_REQUEST['jumlahData'];
if(empty($jumlahData))$jumlahData = 50;
$TampilOpt =
		"<table width=\"100%\" class=\"adminform\">	<tr>
		<td width=\"50%\" valign=\"top\">
			" . WilSKPD_ajx3($this->Prefix.'SKPD2','100%','145px') .
		"</td>
		<td width=\"50%\" valign=\"top\">
			<table>

				<tr><td width='200'>OBYEK</td><td width='10'>:</td><td>".
				cmbQuery1("cmbObyek",$cmbObyek,"select g as valueCmbObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g !='00' and h ='00' and i='00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','')

					."</td></tr>".
				"<tr><td width='100'>RINCIAN OBYEK</td><td width='10'>:</td><td>".
					 cmbQuery1("cmbRincianObyek",$cmbRincianObyek,"select h as valueCmbRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h !='00' and i='00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td></tr>".
				"<tr><td width='100'>SUB RINCIAN OBYEK</td><td width='10'>:</td><td>".
					cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,"select i as valueCmbSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i != '00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td></tr>".
				"<tr><td width='100'>SUB SUB RINCIAN OBYEK</td><td width='10'>:</td><td>".
					cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,"select j as valueCmbSubSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j != '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td></tr>".
				"<tr><td width='100'>SUB SUB SUB RINCIAN OBYEK</td><td width='10'>:</td><td>".
					cmbQuery1("cmbSubSubSubRincianObyek",$cmbSubSubSubRincianObyek,"select j1 , nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j = '$cmbSubSubRincianObyek' and j1 != '0000' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td></tr>".
			"</table>".
		"</td>
		</tr></table>".
					genFilterBar(
						array(
							"PERHITUNGAN  &nbsp &nbsp $comboPerhitungan  &nbsp &nbsp TAHUN  &nbsp &nbsp <input type='text' readonly name='filterTahun' id='filterTahun' value='".$_COOKIE['coThnAnggaran']."' style='width:40px;'> &nbsp &nbsp PERIODE &nbsp &nbsp $comboPeriode  "
					),'','','').
					genFilterBar(
						array(
							"JUMLAH DATA &nbsp &nbsp <input type='text' name ='jumlahData' id='jumlahData' value ='$jumlahData' style='width:40px;'>  &nbsp <input type='button' onclick =$this->Prefix.refreshList(true); value='Tampilkan'>"
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
		if($daftarPersediaanBarangSKPD2fmURUSAN !='00'){
				$arrKondisi[] = "c1 = '$daftarPersediaanBarangSKPD2fmURUSAN'";
		}
		if($daftarPersediaanBarangSKPD2fmSKPD !='00'){
				$arrKondisi[] = "c = '$daftarPersediaanBarangSKPD2fmSKPD'";
		}
		if($daftarPersediaanBarangSKPD2fmUNIT !='00'){
				$arrKondisi[] = "d = '$daftarPersediaanBarangSKPD2fmUNIT'";
		}
		if($daftarPersediaanBarangSKPD2fmSUBUNIT !='00'){
				$arrKondisi[] = "e = '$daftarPersediaanBarangSKPD2fmSUBUNIT'";
		}
		if($daftarPersediaanBarangSKPD2fmSEKSI !='00'){
				$arrKondisi[] = "e1 = '$daftarPersediaanBarangSKPD2fmSEKSI'";
		}
		$arrKondisi[] = "left(tanggal_buku,4) = '".$_COOKIE['coThnAnggaran']."'";
		if(empty($filterPeriode))$filterPeriode='1';
		if(!empty($filterPeriode)){
				// if($filterPeriode == '1'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."01";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '2'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."02";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '3'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."03";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '4'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."04";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '5'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."05";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '6'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."06";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '7'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."07";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '8'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."08";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '9'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."09";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '10'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."10";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '11'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."11";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }elseif($filterPeriode == '12'){
				// 		$maxFilter = $_COOKIE['coThnAnggaran']."12";
				// 		$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				// }
				if($filterPeriode == '1'){
						$maxFilter = $_COOKIE['coThnAnggaran']."06";
						$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				}elseif($filterPeriode == '2'){
						$minFilter = $_COOKIE['coThnAnggaran']."07";
						$maxFilter = $_COOKIE['coThnAnggaran']."12";
						$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') >= '$minFilter' and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				}elseif($filterPeriode == '3'){
						$maxFilter = $_COOKIE['coThnAnggaran']."12";
						$arrKondisi[] = "replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				}
		}

			if(!empty($cmbObyek)){
					$arrKondisi[] = "g = '$cmbObyek'";
			}
			if(!empty($cmbRincianObyek)){
					$arrKondisi[] = "h = '$cmbRincianObyek'";
			}
			if(!empty($cmbSubRincianObyek)){
					$arrKondisi[] = "i = '$cmbSubRincianObyek'";
			}
			if(!empty($cmbSubSubRincianObyek)){
					$arrKondisi[] = "j = '$cmbSubSubRincianObyek'";
			}
			if(!empty($cmbSubSubSubRincianObyek)){
					$arrKondisi[] = "j1 = '$cmbSubSubSubRincianObyek'";
			}

		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;
		$Kondisi = $Kondisi ." group by (concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1))" ;
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
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal );

	}

	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{


			$qy = "DELETE FROM $this->TblName_Hapus WHERE id='".$ids[$i]."' ";$cek.=$qy;
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
function Laporan2($xls =FALSE){
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



		$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit]; $filterPeriode = $_GET[filterPeriode];
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
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
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
										<img src='".getImageReport()."' style='
                      width: 102.08px;
                      height: 84.59;
                      max-height: 84.59;
                      max-width: 102.08px;
                    '>
									</td>
									<td style='text-align: center;'>
										<span style='font-size:18px;font-weight:bold;text-transform: uppercase; '>
											DAFTAR PERSEDIAAN BARANG<br>
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
										<th class='th01' rowspan='2' style='width:20px;' >NO</th>
										<th class='th01' rowspan='2' >NAMA BARANG</th>
										<th class='th01' rowspan='2' style='width: 4%;'>SATUAN</th>
										<th class='th01' rowspan='2' style='width: 4%;'>AWAL</th>
										<th class='th02' colspan='4' >BERTAMBAH</th>
										<th class='th02' colspan='4' >BERKURANG</th>
										<th class='th01' rowspan='2' style='width: 4%;'>AKHIR</th>
									</tr>
									<tr>
										<th class='th01' style='width: 4%;'>BELI</th>
										<th class='th01' style='width: 4%;'>HIBAH</th>
										<th class='th01' style='width: 4%;'>CEK<br>FISIK</th>
										<th class='th01' style='width: 4%;'>JUMLAH</th>
										<th class='th01' style='width: 4%;'>KELUAR</th>
										<th class='th01' style='width: 4%;'>DISTRIBUSI</th>
										<th class='th01' style='width: 4%;'>CEK<br>FISIK</th>
										<th class='th01' style='width: 4%;'>JUMLAH</th>
									</tr>
								</thead>

		";
		$arrayPenggunaBarang = array();
		$arrayExcept = array();
		$no = 1;

				if($filterPeriode == '1'){
						$maxFilter = $_COOKIE['coThnAnggaran']."06";
						$filterPeriode = " and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				}elseif($filterPeriode == '2'){
						$minFilter = $_COOKIE['coThnAnggaran']."07";
						$maxFilter = $_COOKIE['coThnAnggaran']."12";
						$filterPeriode = " and replace(left(tanggal_buku,6),'-','') >= '$minFilter' and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				}elseif($filterPeriode == '3'){
						$maxFilter = $_COOKIE['coThnAnggaran']."12";
						$filterPeriode = " and replace(left(tanggal_buku,6),'-','') <= '$maxFilter'";
				}

		$queryKartuPersediaan = mysql_query("SELECT * from t_kartu_persediaan where c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' $filterPeriode group by (concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1))");
		while($dataKartuPersediaan = mysql_fetch_array($queryKartuPersediaan)){

			$queryRefBarang = mysql_fetch_array(mysql_query("SELECT * from ref_barang where f = ".$dataKartuPersediaan[f]." and g = ".$dataKartuPersediaan[g]." and h = ".$dataKartuPersediaan[h]." and i = ".$dataKartuPersediaan[i]." and j = ".$dataKartuPersediaan[j]." and j1 = ".$dataKartuPersediaan[j1]." "));

			$beli = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' and f = ".$dataKartuPersediaan[f]." and g = ".$dataKartuPersediaan[g]." and h = ".$dataKartuPersediaan[h]." and i = ".$dataKartuPersediaan[i]." and j = ".$dataKartuPersediaan[j]." and j1 = ".$dataKartuPersediaan[j1]." and cara_perolehan = '2'"));

			$hibah = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1=".$dataKartuPersediaan[f1]." and f2=".$dataKartuPersediaan[f2]." and f=".$dataKartuPersediaan[f]." and g=".$dataKartuPersediaan[g]." and h=".$dataKartuPersediaan[h]." and i=".$dataKartuPersediaan[i]." and j=".$dataKartuPersediaan[j]." and j1=".$dataKartuPersediaan[j1]." and jns = '2' and jenis_persediaan = '1' and cara_perolehan = '3'"));

			$cekFisikTambah = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1=".$dataKartuPersediaan[f1]." and f2=".$dataKartuPersediaan[f2]." and f=".$dataKartuPersediaan[f]." and g=".$dataKartuPersediaan[g]." and h=".$dataKartuPersediaan[h]." and i=".$dataKartuPersediaan[i]." and j=".$dataKartuPersediaan[j]." and j1=".$dataKartuPersediaan[j1]." and jns = '4' and jenis_persediaan = '1'"));

			$keluar = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1=".$dataKartuPersediaan[f1]." and f2=".$dataKartuPersediaan[f2]." and f=".$dataKartuPersediaan[f]." and g=".$dataKartuPersediaan[g]." and h=".$dataKartuPersediaan[h]." and i=".$dataKartuPersediaan[i]." and j=".$dataKartuPersediaan[j]." and j1=".$dataKartuPersediaan[j1]." and jns = '6' and jenis_persediaan = '2'"));

			$distribusi = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1=".$dataKartuPersediaan[f1]." and f2=".$dataKartuPersediaan[f2]." and f=".$dataKartuPersediaan[f]." and g=".$dataKartuPersediaan[g]." and h=".$dataKartuPersediaan[h]." and i=".$dataKartuPersediaan[i]." and j=".$dataKartuPersediaan[j]." and j1=".$dataKartuPersediaan[j1]." and jns = '7' and jenis_persediaan = '2'"));

			$cekfisiKurang = mysql_fetch_array(mysql_query("SELECT sum(jumlah) from t_kartu_persediaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f1=".$dataKartuPersediaan[f1]." and f2=".$dataKartuPersediaan[f2]." and f=".$dataKartuPersediaan[f]." and g=".$dataKartuPersediaan[g]." and h=".$dataKartuPersediaan[h]." and i=".$dataKartuPersediaan[i]." and j=".$dataKartuPersediaan[j]." and j1=".$dataKartuPersediaan[j1]." and jns = '5' and jenis_persediaan = '2'"));

			echo "
				<tr>
					<td class='GarisCetak' align='center'>".$no."</td>
					<td class='GarisCetak'>".$queryRefBarang[nm_barang]."</td>
					<td class='GarisCetak'>".$queryRefBarang[satuan]."</td>
					<td class='GarisCetak' align='right'>".$dataKartuPersediaan[jumlah]."</td>
					<td class='GarisCetak' align='right'>".number_format($beli['sum(jumlah)'],0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format($hibah['sum(jumlah)'],0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format($cekFisikTambah['sum(jumlah)'],0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format($beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] ,0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format($keluar['sum(jumlah)'],0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format($distribusi['sum(jumlah)'],0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format($cekfisiKurang['sum(jumlah)'],0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format($keluar['sum(jumlah)'] + $distribusi['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'],0,',','.')."</td>
					<td class='GarisCetak' align='right'>".number_format( ($dataKartuPersediaan['jumlah'] + $beli['sum(jumlah)'] + $hibah['sum(jumlah)'] + $cekFisikTambah['sum(jumlah)'] ) - ($keluar['sum(jumlah)'] + $distribusi['sum(jumlah)'] + $cekfisiKurang['sum(jumlah)']) ,0,',','.')."</td>
				</tr>
			";


			$no++;
		}
		
		echo 				"</table>";

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
						NIP	$this->nipPengelola
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

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '3' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '23' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '3' "));
            $namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'alamat_pemda' "));

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
function Laporan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 350;
	 $this->form_height = 100;
	 $this->form_caption = 'LAPORAN RKBMD PENGADAAN';

	 $c1 = $dt['daftarPersediaanBarangSKPD2fmURUSAN'];
	 $c = $dt['daftarPersediaanBarangSKPD2fmSKPD'];
	 $d = $dt['daftarPersediaanBarangSKPD2fmUNIT'];
	 $e = $dt['daftarPersediaanBarangSKPD2fmSUBUNIT'];
	 $e1 = $dt['daftarPersediaanBarangSKPD2fmSEKSI'];

	 	$arrayJenisLaporan = array(
							   array('Laporan2', 'DAFTAR PERSEDIAAN BARANG'),

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
                  'value'=>cmbQuery('ttd',$d,"SELECT Id, nama from ref_tandatangan where kategori_tandatangan = 23 and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' ",'onchange=rka.refreshList(true);','-- TTD --'),

                ),

			);
		//tombol
		$this->form_menubawah =
			"
      <input type='button' value='TTD' onclick ='".$this->Prefix.".Baru()' title='TTD' >
			<input type='button' value='View' onclick ='".$this->Prefix.".Report()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='daftarPersediaanBarang.Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

function Laporann($xls =FALSE){
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
			$getAllParent = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap ='$this->idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) {
			 	 $$key = $value;
				}
				$cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where o1 = '$o1' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id' ";
					$getAllRekening = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$this->idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
					while($row2s = mysql_fetch_array($getAllRekening)){
						foreach ($row2s as $key => $value) {
					 	 $$key = $value;
						}
						$cekRekening = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap='$this->idTahap'  or id = '$id'  ";


						}
					}
				}
			}


				$grabNonMapingRekening= mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap ='$this->idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id ='".$got['id']."'";
					}

				}
				$grabNonHostedRekening= mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap ='$this->idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id ='".$got['id']."'";
					}

				}


			$arrKondisi[] = "id_tahap = '$this->idTahap' ";

		}elseif($this->jenisForm == 'KOREKSI'){
			$nomorUrutSebelumnya = $this->nomorUrut;
			$getRApbd = mysql_fetch_array(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
				$nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;
			}
			$getLastTahap = mysql_fetch_array(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			$blackList = "";
			if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
				$getAllChild = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");
				while($black = mysql_fetch_array($getAllChild)){
					$blackList .= " and id !='".$black['id']."'";
				}
			}

			$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
			$idTahap = $getIDTahap['id_tahap'];
			$getAllParent = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) {
			 	 $$key = $value;
				}
				$cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id' ";
					$getAllRekening = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
					while($row2s = mysql_fetch_array($getAllRekening)){
						foreach ($row2s as $key => $value) {
					 	 $$key = $value;
						}
						$cekRekening = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'  ";
							$getAllProgram = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
							while($row3s = mysql_fetch_array($getAllProgram)){
								foreach ($row3s as $key => $value) {
							 	 $$key = $value;
								}
								$cekProgram = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
								if($cekProgram == 0){
									$concat = $bk.".".$ck.".".$p;
									$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
								}else{
									$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'   ";
									$getAllKegiatan = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
									while($row4s = mysql_fetch_array($getAllKegiatan)){
										foreach ($row4s as $key => $value) {
									 	 $$key = $value;
										}
										$cekKegiatan = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
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


				$grabNonMapingRekening= mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
					}

				}

				$grabNonHostedRekening= mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
					}

				}





			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";


		}else{
			if($this->jenisFormTerakhir == "KOREKSI"){
				$nomorUrutSebelumnya = $this->urutTerakhir;
				$getRApbd = mysql_fetch_array(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
				if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
					$nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;
				}
				$getLastTahap = mysql_fetch_array(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				$blackList = "";
				if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
					$getAllChild = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");
					while($black = mysql_fetch_array($getAllChild)){
						$blackList .= " and id !='".$black['id']."'";
					}
				}

				$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id' ";
						$getAllRekening = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
						while($row2s = mysql_fetch_array($getAllRekening)){
							foreach ($row2s as $key => $value) {
						 	 $$key = $value;
							}
							$cekRekening = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'  ";
								$getAllProgram = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
								while($row3s = mysql_fetch_array($getAllProgram)){
									foreach ($row3s as $key => $value) {
								 	 $$key = $value;
									}
									$cekProgram = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap = '$idTahap'  or id = '$id'   ";
										$getAllKegiatan = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
										while($row4s = mysql_fetch_array($getAllKegiatan)){
											foreach ($row4s as $key => $value) {
										 	 $$key = $value;
											}
											$cekKegiatan = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
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


					$grabNonMapingRekening= mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
					while($got = mysql_fetch_array($grabNonMapingRekening)){
						if(mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
						}

					}

					$grabNonHostedRekening= mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
					while($got = mysql_fetch_array($grabNonHostedRekening)){
						if(mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
						}

					}





				$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
				$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap ='$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekPekerjaan = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where o1 = '$o1' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap='$idTahap'  or id = '$id' ";
						$getAllRekening = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
						while($row2s = mysql_fetch_array($getAllRekening)){
							foreach ($row2s as $key => $value) {
						 	 $$key = $value;
							}
							$cekRekening = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap='$idTahap'  or id = '$id'  ";
								$getAllProgram = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
								while($row3s = mysql_fetch_array($getAllProgram)){
									foreach ($row3s as $key => $value) {
								 	 $$key = $value;
									}
									$cekProgram = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where bk ='$bk' and ck='$ck' and p='$p' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap='$idTahap'  or id = '$id'   ";
										$getAllKegiatan = mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
										while($row4s = mysql_fetch_array($getAllKegiatan)){
											foreach ($row4s as $key => $value) {
										 	 $$key = $value;
											}
											$cekKegiatan = mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
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


				$grabNonMapingRekening= mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap ='$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id ='".$got['id']."'";
					}

				}

				$grabNonHostedRekening= mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap ='$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
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
		$qry ="select * from tabel_DAFTAR PERSEDIAAN BARANG where $Kondisi ";
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
		$getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_DAFTAR PERSEDIAAN BARANG where $Kondisi  "));
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
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_DAFTAR PERSEDIAAN BARANG where  o1 ='$o1' $kondisiSKPD $kondisiFilter  "));
				$jumlah_harga = "<span style='font-weight:bold;'>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.') . "</span>";


			}elseif($c1 == '0'){
				$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
				$jarak = "0px";
				if($o1 !='0' && $o1 !='')$jarak = "10px";
				$uraian = "<span style='font-weight:bold;margin-left:$jarak;'>".$getNamaRekening['nm_rekening']."</b>";
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_DAFTAR PERSEDIAAN BARANG where  k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'  $kondisiSKPD $kondisiFilter"));
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
		echo 				"<tr valign='top'>
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
						NIP	".$getDataPenggunaBarang['nip']."


						</div>
			</body>
		</html>";
	}

	function lockBarang($idPosting){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
	 }
		$this->form_caption = 'Kunci Barang';
		if($filterPeriode == '1'){
				$namaSemester = "SEMESTER 1";
		}elseif($filterPeriode == '2'){
				$namaSemester = "SEMESTER 2";
		}else{
				$namaSemester = "TAHUNAN";
		}
		$getData = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '$idPosting'"));
		if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where c1 = '".$getData['c1']."' and  c = '".$getData['c']."'  and  d = '".$getData['d']."' and  e = '".$getData['e']."'  and  e1 = '".$getData['e1']."'  and  f1 = '".$getData['f1']."' and  f2 = '".$getData['f2']."' and  f = '".$getData['f']."'  and  g = '".$getData['g']."' and  h = '".$getData['h']."' and  i = '".$getData['i']."' and  j = '".$getData['j']."'  and  j1 = '".$getData['j1']."' and tahun ='".$_COOKIE['coThnAnggaran']."' and semester = '".$_REQUEST['filterPeriode']."' ")) !=0 ){
			$getLockBarang = mysql_fetch_array(mysql_query("select * from t_persediaan_lock_barang where c1 = '".$getData['c1']."' and  c = '".$getData['c']."'  and  d = '".$getData['d']."' and  e = '".$getData['e']."'  and  e1 = '".$getData['e1']."'  and  f1 = '".$getData['f1']."' and  f2 = '".$getData['f2']."' and  f = '".$getData['f']."'  and  g = '".$getData['g']."' and  h = '".$getData['h']."' and  i = '".$getData['i']."' and  j = '".$getData['j']."'  and  j1 = '".$getData['j1']."' and tahun ='".$_COOKIE['coThnAnggaran']."' and semester = '".$_REQUEST['filterPeriode']."' "));
			$action = "unLockBarang(".$getLockBarang['id'].")";
			$pesan =  "Unlock data dapat membatalkan proses perhitungan, Yakin Unlock ? ";
			$kata = "Unlock";
		}else{
			$action = "saveLockBarang($idPosting)";
			$pesan = "Mengunci data agar proses hitung bisa di lakukan, data yang sudah di kunci tidak dapat di ubah lagi, Yakin mengunci ?";
			$kata = "Lock";
		}
	 //items ----------------------
	  $this->form_fields = array(
	  	'kode0' => array(
					'label'=>'SEMESTER',
				'labelWidth'=>100,
				'value'=> $namaSemester.
				"<input type = 'hidden' name='filterPeriode' id='filterPeriode' value='$filterPeriode'>"
				 ),
	  	'sds' => array(
					'label'=>'',
					'labelWidth'=>100,
					'value'=> "<span style='color:red';>Mengunci data agar proses hitung bisa di lakukan, data yang sudah di kunci tidak dapat di ubah lagi, Yakin mengunci ?</span>",
					'type' => 'merge'
				),



			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='$kata' onclick ='".$this->Prefix.".$action' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function showKartu($idLock){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
	 }
		$this->form_caption = 'KARTU PERSEDIAAN BARANG';

	 //items ----------------------
	  $this->form_fields = array(

	  	'sds' => array(
					'label'=>'',
					'labelWidth'=>100,
					'value'=>"
					<div id='listKartuKunci' style='height:5px'>
					<input type='hidden' id='idLock' name='idLock' value='$idLock'>
						"."<div id='listBarangSaldoAwal_cont_title' style='position:relative'></div>".
		"<div id='listKartuKunci_cont_opsi' style='position:relative'>".
		"</div>".
		"<div id='listKartuKunci_cont_daftar' style='position:relative'></div>".
		"<div id='listKartuKunci_cont_hal' style='position:relative'></div>"."
					</div>",
					'type' => 'merge'
				),



			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Tutup' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function checkError($idPersediaan){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
	 }
		$this->form_caption = 'RINCIAN PERHITUNGAN';

	 //items ----------------------
	  $this->form_fields = array(

			'sds' => array(
			    'label'=>'',
			    'labelWidth'=>100,
			    'value'=>"
			    <div id='kartuError' style='height:5px'>
			    <input type='hidden' id='idPersediaan' name='idPersediaan' value='$idPersediaan'>
			      "."<div id='listBarangSaldoAwal_cont_title' style='position:relative'></div>".
			"<div id='kartuError_cont_opsi' style='position:relative'>".
			"</div>".
			"<div id='kartuError_cont_daftar' style='position:relative'></div>".
			"<div id='kartuError_cont_hal' style='position:relative'></div>"."
			    </div>",
			    'type' => 'merge'
			  ),



			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Tutup' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function detailPengeluaran($idPengeluaran){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 800;
	 $this->form_height = 500;
	 foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
	 }
		$this->form_caption = 'DETAIL PENGELUARAN';
		$getBarangKeluar = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '$idPengeluaran'"));
	 //items ----------------------
	  $this->form_fields = array(

	  	'sdsds' => array(
					'label'=>'BARANG KELUAR',
					'labelWidth'=>120,
					'value'=>	number_format($getBarangKeluar['jumlah'],0,',','.'),
				),
	  	'sds' => array(
					'label'=>'',
					'labelWidth'=>100,
					'value'=>$this->tabelDetailPengeluaran($idPengeluaran),
					'type' => 'merge'
				),



			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Tutup' onclick ='".$this->Prefix.".CloseDetailPengeluaran()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function detailPengeluaranTemp($idPengeluaran){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 800;
	 $this->form_height = 500;
	 foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
	 }
		$this->form_caption = 'DETAIL PENGELUARAN';
		$getBarangKeluar = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '$idPengeluaran'"));
	 //items ----------------------
	  $this->form_fields = array(

	  	'sdsds' => array(
					'label'=>'BARANG KELUAR',
					'labelWidth'=>120,
					'value'=>	number_format($getBarangKeluar['jumlah'],0,',','.'),
				),
	  	'sds' => array(
					'label'=>'',
					'labelWidth'=>100,
					'value'=>$this->tabelDetailPengeluaranTemp($idPengeluaran),
					'type' => 'merge'
				),



			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Tutup' onclick ='".$this->Prefix.".CloseDetailPengeluaran()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function tabelDetailPengeluaran($idPengeluaran){
		$cek = '';
		$err = '';

		$getData = mysql_fetch_array(mysql_query("select * from lock_barang_kurang where id_t_kartu_persediaan = '$idPengeluaran'"));
		$arrayDari = json_decode($getData['perolehan']);
		$no=1;
		for ($i=0; $i < sizeof($arrayDari) ; $i++) {
				$getDataPersediaan = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '".$arrayDari[$i]->idPenerimaan."'"));
				if($getDataPersediaan['cara_perolehan'] == '1'){
						$caraPerolehan = "SALDO AWAL";
				}elseif($getDataPersediaan['cara_perolehan'] == '2'){
						$caraPerolehan = "PENERIMAAN PEMBELIAN";
				}elseif($getDataPersediaan['cara_perolehan'] == '3'){
						$caraPerolehan = "PENERIMAAN HIBAH";
				}elseif($getDataPersediaan['cara_perolehan'] == '4'){
						$caraPerolehan = "CEK FISIK";
				}
				$datanya.="
							<tr class='row0'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='center'>
									".$this->generateDate($getDataPersediaan['tanggal_buku'])."
								</td>
								<td class='GarisDaftar' align='left'>
									".$caraPerolehan."
								</td>
								<td class='GarisDaftar' align='right'>
								".number_format($arrayDari[$i]->jumlah,0,',','.')."
								</td>
								<td class='GarisDaftar' align='right'>
								".number_format($arrayDari[$i]->harga,2,',','.')."
								</td>

							</tr>
				";
				$no = $no+1;
		}

		$content =
			"
					<div  style='width:100%;'>
					<table class='koptable'  style='width:100%;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='100px;'>TANGGAL</th>
							<th class='th01' width='200px;'>CARA PEROLEHAN</th>
							<th class='th01' width='200px;'>JUMLAH</th>
							<th class='th01' width='200px;'>HARGA</th>
						</tr>
						$datanya

					</table>
					</div>
					"
		;

		return	$content;
	}
	function tabelDetailPengeluaranTemp($idPengeluaran){
		$cek = '';
		$err = '';

		$getData = mysql_fetch_array(mysql_query("select * from temp_lock_kurang where id_t_kartu_persediaan = '$idPengeluaran'"));
		$arrayDari = json_decode($getData['perolehan']);
		$no=1;
		for ($i=0; $i < sizeof($arrayDari) ; $i++) {
				$getDataPersediaan = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where id = '".$arrayDari[$i]->idPenerimaan."'"));
				if($getDataPersediaan['cara_perolehan'] == '1'){
						$caraPerolehan = "SALDO AWAL";
				}elseif($getDataPersediaan['cara_perolehan'] == '2'){
						$caraPerolehan = "PENERIMAAN PEMBELIAN";
				}elseif($getDataPersediaan['cara_perolehan'] == '3'){
						$caraPerolehan = "PENERIMAAN HIBAH";
				}elseif($getDataPersediaan['cara_perolehan'] == '4'){
						$caraPerolehan = "CEK FISIK";
				}
				$datanya.="
							<tr class='row0'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='center'>
									".$this->generateDate($getDataPersediaan['tanggal_buku'])."
								</td>
								<td class='GarisDaftar' align='left'>
									".$caraPerolehan."
								</td>
								<td class='GarisDaftar' align='right'>
								".number_format($arrayDari[$i]->jumlah,0,',','.')."
								</td>
								<td class='GarisDaftar' align='right'>
								".number_format($arrayDari[$i]->harga,2,',','.')."
								</td>

							</tr>
				";
				$no = $no+1;
		}

		$content =
			"
					<div  style='width:100%;'>
					<table class='koptable'  style='width:100%;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='100px;'>TANGGAL</th>
							<th class='th01' width='200px;'>CARA PEROLEHAN</th>
							<th class='th01' width='200px;'>JUMLAH</th>
							<th class='th01' width='200px;'>HARGA</th>
						</tr>
						$datanya

					</table>
					</div>
					"
		;

		return	$content;
	}
	function genForm2($withForm=TRUE){
		$form_name = 'listBarangSaldoAwalForm';

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
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 180;
	 $this->form_caption = 'DETAIL VOLUME';
	 $jumlahHargaForm = $dt;
	 $username =$_COOKIE['coID'];
	//  $getRincianVolume = mysql_fetch_array(mysql_query("select * from tabel_DAFTAR PERSEDIAAN BARANG where id ='$dt'"));
	//  foreach ($getRincianVolume as $key => $value) {
	// 			  $$key = $value;
	// 	}

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
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 1 &nbsp<input type='text' id='jumlah1' value='$volume1Temp' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder='JUMLAH'> &nbsp SATUAN 1   &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' name ='satuan1' id ='satuan1' value='$satuan1Temp'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 2 &nbsp<input type='text' id='jumlah2' placeholder='JUMLAH' value='".$this->nullChecker($volume2Temp)."' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 2  &nbsp&nbsp&nbsp&nbsp&nbsp    <input type='text' value='$satuan2Temp' name ='satuan2' id ='satuan2'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 3 &nbsp<input type='text' id='jumlah3' placeholder='JUMLAH' value='".$this->nullChecker($volume3Temp)."' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 3  &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' value='$satuan3Temp'name ='satuan3' id ='satuan3'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" VOLUME &nbsp &nbsp<input type='text' value='$totalResult' placeholder='JUMLAH' id='jumlah4' readonly >&nbsp SATUAN VOL &nbsp <input type='text' name ='satuanVolume' id ='satuanVolume' style='width:150px;'  value='$satuanVolume' readonly> &nbsp &nbsp <span id='detailVolumeRincian'>",
						 ),
			 array( 		'label' => '',
 						'labelWidth' => 1,
 						'pemisah' => ' ',
 						'value'=>"",
 						 ),
	 			array( 	'label' => '',
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
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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

}
$daftarPersediaanBarang = new daftarPersediaanBarangObj();
$daftarPersediaanBarang->username = $_COOKIE['coID'];



?>
