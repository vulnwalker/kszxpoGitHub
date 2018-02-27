<?php

class rkaSKPD22NewObj  extends DaftarObj2{
  var $Prefix = 'rkaSKPD22New';
  var $elCurrPage="HalDefault";
  var $SHOW_CEK = TRUE;
  var $TblName = 'view_rka_2_2_1'; //bonus
  var $TblName_Hapus = 'tabel_anggaran';
  var $MaxFlush = 10;
  var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
  var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
  var $KeyFields = array('id_anggaran');
  var $FieldSum = array();//array('jml_harga');
  var $SumValue = array();
  var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
  var $FieldSum_Cp2 = array( 1, 1, 1);
  var $checkbox_rowspan = 2;
  var $PageTitle = 'RKA-SKPD';
  var $PageIcon = 'images/masterData_01.gif';
  var $pagePerHal ='';
  //var $cetak_xls=TRUE ;
  var $fileNameExcel='rkaSKPD22New.xls';
  var $namaModulCetak='RKA';
  var $Cetak_Judul = 'RKA';
  var $Cetak_Mode=2;
  var $Cetak_WIDTH = '30cm';
  var $Cetak_OtherHTMLHead;
  var $FormName = 'rkaSKPD22NewForm';
  var $modul = "RKA-SKPD";
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
          $jenisKegiatan = $_REQUEST['jenisKegiatan'];
            if($jenisKegiatan == "Pengadaan1" || $jenisKegiatan == "Pengadaan3"){
              $kategorinaey = 1;
            }else{
              $kategorinaey = 2;
            }
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
    return 'RKA-SKPD 2.2 '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
  }
  function setMenuView(){
    return
      "<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";

  }

  function setMenuEdit(){
     $arrayResult = VulnWalkerTahap_v2('RKA');
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
     /*if($cmbSubUnit != ''){
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

    if(!empty($this->jenisForm)){
      $idTahap = $this->idTahap;
    }else{
      $getIdTahapRKATerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_rka_2_2_1 where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and jenis_rka !=''  and (rincian_perhitungan !='' or f !='00' ) "));
      $idTahap = $getIdTahapRKATerakhir['max'];
    }

    $getAllKegiatan = mysql_query("select * from tabel_anggaran where id_tahap='$idTahap' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' $kondisiSKPD ");
    while($got = mysql_fetch_array($getAllKegiatan)){
      $gotC1= $got['c1'];
      $gotC= $got['c'];
      $gotD= $got['d'];
      $gotE = $got['e'];
      $gotE1 = $got['e1'];
      $gotQ= $got['q'];
      $getIdAwalRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) as idAwalRenja from view_renja where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and bk='$bk' and ck='$ck' and p='$p' and q='$gotQ' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  "));
      if(mysql_num_rows(mysql_query("select * from view_renja where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and bk='$bk' and ck='$ck' and p='$p' and q='$gotQ' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  ")) == 0){
        $getIdAwalRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) as idAwalRenja from view_renja where c1='$gotC1' and c='$gotC' and d='$gotD'  and bk='$bk' and ck='$ck' and p='$p' and q='$gotQ' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  "));
      }
      $idAwalRenja = $getIdAwalRenja['idAwalRenja'];
      $getDetailRenja = mysql_fetch_array(mysql_query("select * from detail_renja where id_anggaran ='$idAwalRenja'"));
      $sumTahunPlus = $sumTahunPlus + $getDetailRenja['plus'];
    }
    $tahunPlus = number_format($sumTahunPlus ,2,',','.');
    $getData = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f !='00' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' $kondisiSKPD $kondisiRekening"));
    $Total = $getData['sum(jumlah_harga)'];
    $getTotalPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f !='00' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' and k = '5' and l ='2' and m='1' $kondisiSKPD $kondisiRekening"));
    $TotalBelanjaPegawai = $getTotalPegawai['sum(jumlah_harga)'];
    $getTotalBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f !='00' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' and k = '5' and l ='2' and m='2' $kondisiSKPD $kondisiRekening"));
    $TotalBelanjaBarangJasa = $getTotalBarangJasa['sum(jumlah_harga)'];
    $getTotalModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f !='00' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' and k = '5' and l ='2' and m='3' $kondisiSKPD $kondisiRekening"));
    $TotalBelanjaModal = $getTotalModal['sum(jumlah_harga)'];
    $ContentTotalHal=''; $ContentTotal='';
      $TampilTotalHalRp = number_format($this->SumValue[0],2, ',', '.');*/
      $TotalColSpan1 = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
      $TotalColSpan2 = $this->FieldSum_Cp2[$Mode-1];//$Mode ==1 ? 5 : 4;
      $Kiri2 = $TotalColSpan1 > 0 ? "<td class='$ColStyle' colspan='6' align='center'><b>Total</td>": '';
        $ContentTotal =
        "<tr>
          $Kiri2
          <td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->sumJumlahBelanjaPegawai,2,',','.')."</div></td>
          <td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->sumJumlahBelanjaBarangJasa,2,',','.')."</div></td>
          <td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->sumJumlahBelanjaModal,2,',','.')."</div></td>
          <td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->sumJumlah,2,',','.')."</div></td>
          <td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->sumTahunPlusFromList,2,',','.')."</div></td>
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

   return array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
  }

  function set_selector_other($tipe){
   global $Main;
   $cek = ''; $err=''; $content=''; $json=TRUE;

    switch($tipe){
    // case 'Report':{
    //  foreach ($_REQUEST as $key => $value) {
    //     $$key = $value;
    //  }
    //  if(empty($cmbUrusan)){
    //    $err = "Pilih Urusan";
    //  }elseif(empty($cmbBidang)){
    //    $err = "Pilih Bidang";
    //  }elseif(empty($cmbSKPD)){
    //    $err = "Pilih SKPD";
    //  }else{
    //    if(mysql_num_rows(mysql_query("select * from skpd_report_rka_22 where username= '$this->username'")) == 0){
    //      $data = array(
    //              'username' => $this->username,
    //              'c1' => $cmbUrusan,
    //              'c' => $cmbBidang,
    //              'd' => $cmbSKPD,

    //              );
    //      $query = VulnWalkerInsert('skpd_report_rka_22',$data);
    //      mysql_query($query);
    //    }else{
    //      $data = array(
    //              'username' => $this->username,
    //              'c1' => $cmbUrusan,
    //              'c' => $cmbBidang,
    //              'd' => $cmbSKPD,

    //              );
    //      $query = VulnWalkerUpdate('skpd_report_rka_22',$data,"username = '$this->username'");
    //      mysql_query($query);
    //    }

    //  }
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
      if(mysql_num_rows(mysql_query("select * from skpd_report_rka_22 where username= '$this->username'")) == 0){
        $query = VulnWalkerInsert('skpd_report_rka_22',$data);
      }else{
        $query = VulnWalkerUpdate('skpd_report_rka_22',$data,"username = '$this->username'");
      }
      mysql_query($query);
        }
      $content = array('to' => $jenisKegiatan,'urusan' => $cmbUrusan, 'bidang' => $cmbBidang, 'skpd' => $cmbSKPD, 'namaPemda' => $namaPemda[option_value], 'cetakjang' => $cetakjang, 'e' => $cmbUnit, 'e1' => $cmbSubUnit, 'bk' => $bk, 'ck' => $ck, 'dk' => $dk, 'p' => $hiddenP, 'q' => $q, 'ttd' => $ttd );
    break;
    }
    case 'simpan':{
      $get= $this->simpan();
      $cek = $get['cek'];
      $err = $get['err'];
      $content = $get['content'];
    break;
      }
      case 'RKASKPD22':{
      $json = FALSE;
      $this->RKASKPD22();
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
    case 'Laporan':{
      $fm = $this->Laporan($_REQUEST);
            $cek .= $fm['cek'];
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
  "<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
  <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
  <A href=\"pages.php?Pg=rkaSKPD22New1\" title='BELANJA' style='color:blue;' > BELANJA </a> |
  <A href=\"pages.php?Pg=rkaSKPD1PAD\" title='PENDAPATAN' > PENDAPATAN </a> |
  <A href=\"pages.php?Pg=rkaSKPD31\" title='RKA-SKPKD MURNI' > PEMBIAYAAN </a> |
  <A href=\"pages.php?Pg=rkaSKPD\" title='RKA-SKPKD MURNI' > RKA-SKPD  </a>

  &nbsp&nbsp&nbsp
  </td></tr>

  <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
  <A href=\"pages.php?Pg=rkaSKPD22New1\" title='BELANJA LANGSUNG' style='color:blue;' > LANGSUNG </a> |
  <A href=\"pages.php?Pg=rkaSKPD21\" title='BELANJA TIDAK LANGSUNG' > TIDAK LANGSUNG </a>

  &nbsp&nbsp&nbsp
  </td></tr>
  <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
  <A href=\"pages.php?Pg=rkaSKPD22New1\" title='INPUT'  > INPUT </a> |
  <A href=\"pages.php?Pg=rkaSKPD22New\" title='REKAP' style='color:blue;' > REKAP </a>

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
      <script type='text/javascript' src='js/perencanaan_v2/rka/popupBarang.js' language='JavaScript' ></script>
      <script type='text/javascript' src='js/perencanaan_v2/rka/popupRekening.js' language='JavaScript' ></script>
      <script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/rkaSKPD22New.js' language='JavaScript' ></script>
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

    return  array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
  }
  function Info(){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
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
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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
         <th class='th01' width='5' rowspan='3'  >No.</th>
       <th class='th02' width='100'  rowspan='2' colspan='2' >KODE</th>
       <th class='th01' width='500'  rowspan='3' >URAIAN</th>
       <th class='th01' width='100'  rowspan='3' >LOKASI KEGIATAN</th>
       <th class='th01' width='100'  rowspan='3' >TARGET KINERJA</th>
       <th class='th02' colspan='4'  rowspan='1' width='500' >JUMLAH</th>
       <th class='th01' width='80'  rowspan='3' >TAHUN N + 1</th>
       $tergantungJenisForm

       </tr>
       <tr>


       <th class='th02' colspan='4'  rowspan='1' width='1000' >TAHUN N</th>
       </tr>
       <tr>
       <th class='th01' rowspan='1'>PROGRAM</th>
       <th class='th01' rowspan='1'>KEGIATAN</th>
       <th class='th01' rowspan='1'>BELANJA PEGAWAI</th>
       <th class='th01' rowspan='1'>BELANJA BARANG & JASA</th>
       <th class='th01' rowspan='1'>BELANJA MODAL</th>
       <th class='th01' rowspan='1'>JUMLAH</th>
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
    if($cmbSKPD != ''){
      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
    }elseif($cmbBidang != ''){
      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
    }elseif($cmbUrusan != ''){
      $kondisiSKPD = "and c1='$cmbUrusan'";
    }



   $Koloms = array();
   $Koloms[] = array('align="center"', $no.'.' );
   if($q == '0'){
    $Koloms[] = array('align="center"', genNumber($bk).'.'.genNumber($ck).'.'.genNumber($dk).'.'.genNumber($p) );
   }else{
    $Koloms[] = array('align="center"',"");
   }

   $Koloms[] = array('align="center"', genNumber($q)  );

   if($q == '0'){
    $getNamaProgram = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='0'"));
    $namaProgram =  $getNamaProgram['nama'];
    $Koloms[] = array('align="left"', "<span style='font-weight:bold;'>".$namaProgram."</span>" );
    $Koloms[] = array('align="left"', "" );
    $Koloms[] = array('align="left"', "" );

    $sumTahunPlus = 0;

    $getAllKegiatan = mysql_query("select * from view_rka_2_2 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q!='0' $kondisiSKPD ");
    while($got = mysql_fetch_array($getAllKegiatan)){
      $gotC1= $got['c1'];
      $gotC= $got['c'];
      $gotD= $got['d'];
      $gotE = $got['e'];
      $gotE1 = $got['e1'];
      $gotQ= $got['q'];
      $getIdAwalRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) as idAwalRenja from view_renja where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$gotQ' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  "));
      $idAwalRenja = $getIdAwalRenja['idAwalRenja'];
      $getDetailRenja = mysql_fetch_array(mysql_query("select * from detail_renja where id_anggaran ='$idAwalRenja'"));
      $sumTahunPlus = $sumTahunPlus + $getDetailRenja['plus'];
    }
    $tahunPlus = number_format($sumTahunPlus ,2,',','.');

   }else{
    $getNamaKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'"));
    $namaKegiatan =  $getNamaKegiatan['nama'];
    $Koloms[] = array('align="left"', "<span style='margin-left:10px;'>".$namaKegiatan."</span>" );
    $getIdAwalRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) as idAwalRenja from view_renja where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  "));
    $idAwalRenja = $getIdAwalRenja['idAwalRenja'];
    if($idAwalRenja == NULL){
      $getIdAwalRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) as idAwalRenja from view_renja where c1='$c1' and c='$c' and d='$d'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  "));
      $idAwalRenja = $getIdAwalRenja['idAwalRenja'];
    }
    $getDetailRenja = mysql_fetch_array(mysql_query("select * from detail_renja where id_anggaran ='$idAwalRenja'"));

    $Koloms[] = array('align="left"', $getDetailRenja['lokasi_kegiatan'] );
    $Koloms[] = array('align="left"', $getDetailRenja['capaian_program_tk'] );
    $tahunPlus = number_format($getDetailRenja['plus'] ,2,',','.');
    $this->sumTahunPlusFromList += $getDetailRenja['plus'];
   }
   if($q != '0'){
     $getBelanjaPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaPegawai from tabel_anggaran where nama_modul = 'RKA-SKPD' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='5' and l='2' and m='1' "));
       $getBelanjaBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaBarangJasa from tabel_anggaran where nama_modul = 'RKA-SKPD' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='5' and l='2' and m='2' "));
     $getBelanjaModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaModal from tabel_anggaran where nama_modul = 'RKA-SKPD' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='5' and l='2' and m='3' "));


     $Koloms[] = array('align="right"', number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.') );
     $Koloms[] = array('align="right"', number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.') );
     $Koloms[] = array('align="right"', number_format($getBelanjaModal['belanjaModal'] ,2,',','.') );
     $jumlahRekening = $getBelanjaPegawai['belanjaPegawai'] + $getBelanjaBarangJasa['belanjaBarangJasa'] + $getBelanjaModal['belanjaModal'];
     $Koloms[] = array('align="right"', number_format($jumlahRekening ,2,',','.') );
     $this->sumJumlahBelanjaPegawai += $getBelanjaPegawai['belanjaPegawai'];
     $this->sumJumlahBelanjaBarangJasa += $getBelanjaBarangJasa['belanjaBarangJasa'];
     $this->sumJumlahBelanjaModal += $getBelanjaModal['belanjaModal'];
     $this->sumJumlah += $jumlahRekening;
     $Koloms[] = array('align="right"', $tahunPlus );
   }else{
     $getBelanjaPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaPegawai from view_rka_2_2_1 where id_tahap='$this->idTahap' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p'  and k='5' and l='2' and m='1' "));
     $getBelanjaBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaBarangJasa from view_rka_2_2_1 where  id_tahap='$this->idTahap' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p'  and k='5' and l='2' and m='2' "));
     $getBelanjaModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaModal from view_rka_2_2_1 where  id_tahap='$this->idTahap' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p'  and k='5' and l='2' and m='3' "));
     $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>" .number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.') ."</span> " );
     $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>" .number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</span>" );
     $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>" . number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</span>" );
     $jumlahRekening = $getBelanjaPegawai['belanjaPegawai'] + $getBelanjaBarangJasa['belanjaBarangJasa'] + $getBelanjaModal['belanjaModal'];
     $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>" . number_format($jumlahRekening ,2,',','.')."</span>" );
     $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>" . $tahunPlus ."</span>" );
   }

   return $Koloms;
  }


  function Validasi($dt){
   global $SensusTmp;
   $cek = ''; $err=''; $content='';
   $json = TRUE;  //$ErrMsg = 'tes';
   $form_name = $this->Prefix.'_form';
   $this->form_width = 400;
   $this->form_height = 120;
   $this->form_caption = 'VALIDASI RKA-SKPD 2.2';
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
            'label'=>'KODE rkaSKPD22New',
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
    $codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) from ref_skpd where  c='00' and d='00' and e='00' and e1='000' ";
    $urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=rkaSKPD22New.refreshList(true);','-- URUSAN --');

    $codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
    $bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=rkaSKPD22New.refreshList(true);','-- BIDANG --');

    $codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
    $skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=rkaSKPD22New.refreshList(true);','-- SKPD --');

    $codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e!='00' and e1='000' ";
    $unit = cmbQuery('cmbUnit',$selectedE,$codeAndNameUnit,'onchange=rkaSKPD22New.refreshList(true);','-- UNIT --');


    $codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1!='000' ";
    $subunit = cmbQuery('cmbSubUnit',$selectedE1,$codeAndNameSubUnit,'onchange=rkaSKPD22New.refreshList(true);','-- SUB UNIT --');






  if($this->jenisForm == "KOREKSI" || $this->jenisForm == "PENYUSUNAN" || $this->jenisForm == "VALIDASI"){
    $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
    $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
    $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
    $angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');

    $getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$this->idTahap'  "));
    $sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
    $sisaPagu =  number_format($sisaPagu ,2,',','.');
    $paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";

  }else{
    $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
    $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
    $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
    $angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');

    $getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  "));
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

      <input type='hidden' name='tahun' id='tahun' value='$this->tahun' style='width:40px;' > <input type='hidden' name ='cmbJenisRKA' id='cmbJenisRKA' value='2.2'>



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
    $blackListSubRincian = array();
    $getAllSubRincian = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and (j!='000' or rincian_perhitungan !='' )");
    while($subRincian = mysql_fetch_array($getAllSubRincian)){
          if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening")) == 0){
              $blackListSubRincian[] = "id_anggaran != '".$subRincian['id_anggaran']."'";
              $arrKondisi[] = "id_anggaran !='".$subRincian['id_anggaran']."'";
              // $this->injectQuery = "select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening";
          }
    }
    $kondisiBlackListSubRincian= join(' and ',$blackListSubRincian);
    if(sizeof($blackListSubRincian) == 0){
      $kondisiBlackListSubRincian = "";
    }elseif(sizeof($blackListSubRincian) > 0){
      $kondisiBlackListSubRincian = " and ".$kondisiBlackListSubRincian;
    }
    $blackListRincian = array();
    $getAllRincian =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja != '' and id_rincian_belanja !='0' and j='000' and rincian_perhitungan = '' ");
    while($rincianBelanja = mysql_fetch_array($getAllRincian)){
        if(mysql_num_rows(mysql_query("select  * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk = '".$rincianBelanja['bk']."' and ck = '".$rincianBelanja['ck']."' and dk = '".$rincianBelanja['dk']."' and p = '".$rincianBelanja['p']."' and q = '".$rincianBelanja['q']."' and k = '".$rincianBelanja['k']."' and l = '".$rincianBelanja['l']."'  and m = '".$rincianBelanja['m']."'  and n = '".$rincianBelanja['n']."' and o = '".$rincianBelanja['o']."' and id_rincian_belanja = '".$rincianBelanja['id_rincian_belanja']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $blackListRincian[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
            $arrKondisi[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
        }

    }

    $blackListRekening = array();
    $getAllRekening =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
    while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
        if(mysql_num_rows(mysql_query("select  * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $blackListRekening[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
            $arrKondisi[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
        }
    }
    $blackListKegiatan = array();
    $getAllKegiatan =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k ='0' and l ='0'  and m ='0'   and n ='0'  and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
    while($kegiatanBelanja = mysql_fetch_array($getAllKegiatan)){
        if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and bk = '".$kegiatanBelanja['bk']."' and ck = '".$kegiatanBelanja['ck']."' and dk = '".$kegiatanBelanja['dk']."' and p = '".$kegiatanBelanja['p']."' and q = '".$kegiatanBelanja['q']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $blackListKegiatan[] = "id_anggaran !='".$kegiatanBelanja['id_anggaran']."'";
            $arrKondisi[] = "id_anggaran !='".$kegiatanBelanja['id_anggaran']."'";
        }
    }
    $blackListKegiatan = array();
    $getAllProgram =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q ='0'  ");
    while($programBelanja = mysql_fetch_array($getAllProgram)){
        if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and bk = '".$programBelanja['bk']."' and ck = '".$programBelanja['ck']."' and dk = '".$programBelanja['dk']."' and p = '".$programBelanja['p']."'  and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $arrKondisi[] = "id_anggaran !='".$programBelanja['id_anggaran']."'";
            $arrKondisi[] = "id_anggaran !='".$programBelanja['id_anggaran']."'";
        }
    }
    $arrKondisi[] = "c1 ='0' and (k='' or k='0')";
    $arrKondisi[] = "id_rincian_belanja ='' and rincian_perhitungan = ''";
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
    for($i = 0; $i<count($ids); $i++) {


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
   $this->form_caption = 'LAPORAN RKA-SKPD 2.2 MURNI';

   $c1 = $dt['cmbUrusan'];
   $c = $dt['cmbBidang'];
   $d = $dt['cmbSKPD'];

     $arrayJenisLaporan = array(
                 array('RKASKPD22', 'RKA-SKPD 2.2 MURNI'),
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
      "<input type='button' value='Batal' onclick ='".'rkaSKPD22'.".Close()' >";

    $form = $this->genForm();
    $content = $form;//$content = 'content';
    return  array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
  }

function RKASKPD22($xls =FALSE){
    global $Main;
    $getJenisReport = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL' "));
    $getJenisUkuran = $getJenisReport['jenis'];
    if ($getJenisUkuran == 'L') {
      $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
      $cetak = "<link rel='stylesheet' type='text/css' href='css/pageNumber4.css'>";
      $width = "33cm";
      $height = "21.5cm";
    }else{
      $trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
      $cetak = "<link rel='stylesheet' type='text/css' href='css/pageNumber2.css'>";
      $width = "21.5cm";
      $height = "33cm";
    }
    $arrayTandaTangan = explode(';', $getJenisReport['tanda_tangan']);
  
    $pisah = "<td width='1%' valign='top'> : </td>";
    if($xls){
      header("Content-type: application/msexcel");
      header("Content-Disposition: attachment; filename=$this->fileNameExcel");
      header("Pragma: no-cache");
      header("Expires: 0");
    }
    
    
    
    
    // $grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rka_22 where username='$this->username'"));
    $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
    foreach ($grabSKPD as $key => $value) { 
          $$key = $value; 
      }
    $cmbUrusan = $c1;
    $cmbBidang = $c;
    $cmbSKPD = $d;
    $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'";
    $blackListSubRincian = array();
    $getAllSubRincian = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and (j!='000' or rincian_perhitungan !='' )");
    while($subRincian = mysql_fetch_array($getAllSubRincian)){
          if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening")) == 0){
              $blackListSubRincian[] = "id_anggaran != '".$subRincian['id_anggaran']."'";
              $arrKondisi[] = "id_anggaran !='".$subRincian['id_anggaran']."'";
              // $this->injectQuery = "select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening";
          }
    }
    $kondisiBlackListSubRincian= join(' and ',$blackListSubRincian);
    if(sizeof($blackListSubRincian) == 0){
      $kondisiBlackListSubRincian = "";
    }elseif(sizeof($blackListSubRincian) > 0){
      $kondisiBlackListSubRincian = " and ".$kondisiBlackListSubRincian;
    }
    $blackListRincian = array();
    $getAllRincian =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja != '' and id_rincian_belanja !='0' and j='000' and rincian_perhitungan = '' ");
    while($rincianBelanja = mysql_fetch_array($getAllRincian)){
        if(mysql_num_rows(mysql_query("select  * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk = '".$rincianBelanja['bk']."' and ck = '".$rincianBelanja['ck']."' and dk = '".$rincianBelanja['dk']."' and p = '".$rincianBelanja['p']."' and q = '".$rincianBelanja['q']."' and k = '".$rincianBelanja['k']."' and l = '".$rincianBelanja['l']."'  and m = '".$rincianBelanja['m']."'  and n = '".$rincianBelanja['n']."' and o = '".$rincianBelanja['o']."' and id_rincian_belanja = '".$rincianBelanja['id_rincian_belanja']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $blackListRincian[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
            $arrKondisi[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
        }

    }

    $blackListRekening = array();
    $getAllRekening =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
    while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
        if(mysql_num_rows(mysql_query("select  * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $blackListRekening[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
            $arrKondisi[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
        }
    }
    $blackListKegiatan = array();
    $getAllKegiatan =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k ='0' and l ='0'  and m ='0'   and n ='0'  and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
    while($kegiatanBelanja = mysql_fetch_array($getAllKegiatan)){
        if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and bk = '".$kegiatanBelanja['bk']."' and ck = '".$kegiatanBelanja['ck']."' and dk = '".$kegiatanBelanja['dk']."' and p = '".$kegiatanBelanja['p']."' and q = '".$kegiatanBelanja['q']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $blackListKegiatan[] = "id_anggaran !='".$kegiatanBelanja['id_anggaran']."'";
            $arrKondisi[] = "id_anggaran !='".$kegiatanBelanja['id_anggaran']."'";
        }
    }
    $blackListKegiatan = array();
    $getAllProgram =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q ='0'  ");
    while($programBelanja = mysql_fetch_array($getAllProgram)){
        if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and bk = '".$programBelanja['bk']."' and ck = '".$programBelanja['ck']."' and dk = '".$programBelanja['dk']."' and p = '".$programBelanja['p']."'  and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
            $arrKondisi[] = "id_anggaran !='".$programBelanja['id_anggaran']."'";
            $arrKondisi[] = "id_anggaran !='".$programBelanja['id_anggaran']."'";
        }
    }
    $arrKondisi[] = "c1 ='0' and (k='' or k='0')";
    $arrKondisi[] = "id_rincian_belanja ='' and rincian_perhitungan = ''";
    $arrKondisi[] = "id_tahap = '$this->idTahap' ";
    $arrKondisi[] = "tahun = '$this->tahun'";
    $arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
    
    $Kondisi= join(' and ',$arrKondisi);
    /*if(sizeof($arrKondisi) == 0){
      $Kondisi= '';
    }else{
      $Kondisi = " and ".$Kondisi;
    }*/
    $qry ="select * from tabel_anggaran where $Kondisi order by bk,ck,dk,p,q";
    $aqry = mysql_query($qry);
    $getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
    $kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];    
    
    
    //Get Id Awal Renja
    
    $getIdRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) from view_renja where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$hublaBK' and ck='$hublaCK' and p='$hiddenP' and q='$hublaQ' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
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
    $css = $xls ? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
    $kota = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan"));
    echo 
      "<html>
      <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
      <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
      <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
      <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
      <link rel='stylesheet' type='text/css' href='css/pageNumber4.css'>
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
          <table class=\"rangkacetak\" style='width: 33cm; font-family: sans-serif; margin-left :1cm; height: 21.5cm; border: 1px solid #000; border-bottom-color: transparent; display: block;'>
            <tr>
              <td valign=\"top\"> <div style='text-align:center;'>

              <table style='width: 100.2%; border: 1px solid; margin-bottom: 1%; margin-left: -1px;'>
                <tr>
                  <th class='th02' rowspan='2' style='width: 10%; border: 1px solid; text-align: center;'>
                    <img src='".getImageReport()."' style='
                      width: 102.08px;
                      height: 84.59;
                      max-height: 84.59;
                      max-width: 102.08px;
                     padding: 5%;'>
                  </th>
                  <th class='th02' rowspan='1' style='text-align: center;'>
                    <span style='font-size:18px;font-weight:bold;text-decoration: '>
                      RENCANA KERJA DAN ANGGARAN<br>
                      SATUAN KERJA PERANGKAT DAERAH
                    </span>
                  </th>
                  <th class='th02' rowspan='2' style='text-align: center; width: 9%; border: 1px solid;'>
                    <span style='font-size: 14px; font-weight: bold;'>
                      Formulir<br> RKA SKPD<br> 2.2
                    </span>
                  </th>
                </tr>
                <tr>
                  <th class='th02'  style='text-align: center; border: 1px solid;'>
                    <span style='font-weight: bold; font-size: 14px; text-transform: uppercase;'>
                      PEMERINTAH KABUPATEN ".$kota[kota]."<br>
                    </span>
                    <span class='ukurantulisanIdPenerimaan' style='font-size: 14px; font-weight: 100;'>TAHUN ANGGARAN : $this->tahun </span>
                  </th>
                </tr>
              </table>

        <table class='subjudulcetak' style='width: 100.2%; font-family: sans-serif; margin-bottom: -0.5%; margin-top: -1%; border: 1px solid; margin-left: -1px;'>
          
          <tr>
            <td width='11%' valign='top'><span style='margin-left: 5%;'>Urusan Pemerintahan</span></td>
            $pisah
            <td width='1%' valign='top'>".$cmbUrusan."</td>
            <td valign='top'>$urusan</td>
          </tr>
          <tr>
            <td width='11%' valign='top' ><span style='margin-left: 5%;'>Organisasi</span></td>
            $pisah
            <td width='5%' valign='top'>".$cmbUrusan." . ".$cmbBidang."</td>
            <td valign='top'>$bidang</td>
          </tr>
          <tr>
            <td width='11%' valign='top'><span style='margin-left: 5%;'>Sub Unit Organisasi</span></td>
            $pisah
            <td valign='top' width='6%'>".$cmbUrusan." . ".$cmbBidang." . ".$cmbSKPD."</td>
            <td valign='top'>$skpd</td>
          </tr>
          
        </table>
        
        <br>
        
        
        ";
    echo "
                <table table width='100%' class='cetak' border='1' style='width:100.2%; margin-top: -0.7%; margin-left: -1px;'>
                <thead>
                <tr>
                    <th colspan='10' style='text-align: center; border: 1px solid; padding: 1.5px;'>
                      <span style='font-size:14px;font-weight:bold;text-decoration: '>
                        REKAPITULASI RINCIAN ANGGARAN BELANJA LANGSUNG MENURUT PROGRAM DAN KEGIATAN SATUAN KERJA PERANGKAT DAERAH
                      </span> 
                    </th>
                  </tr>
                  <tr>
                     <th class='th02' width='100'  rowspan='2' colspan='2' >KODE</th>
                     <th class='th01' width='500'  rowspan='3' >URAIAN</th>
                     <th class='th01' width='100'  rowspan='3' >LOKASI KEGIATAN</th>
                     <th class='th01' width='100'  rowspan='3' >TARGET KINERJA</th>
                     <th class='th02' colspan='4'  rowspan='1' width='500' >JUMLAH</th>
                     <th class='th01' width='80'  rowspan='3' >TAHUN N + 1</th>
                     
                   
                     </tr>
                     <tr>
                     
                     
                     <th class='th02' colspan='4'  rowspan='1' width='1000' >TAHUN N</th>
                     </tr>
                     <tr>
                     <th class='th01' rowspan='1'>PROGRAM</th>
                     <th class='th01' rowspan='1'>KEGIATAN</th>
                     <th class='th01' rowspan='1'>BELANJA PEGAWAI</th>
                     <th class='th01' rowspan='1'>BELANJA BARANG & JASA</th>
                     <th class='th01' rowspan='1'>BELANJA MODAL</th>
                     <th class='th01' rowspan='1'>JUMLAH</th>
                     </tr>
                </thead>
                  
    ";
    $getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2 where $Kondisi  "));
    $total = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
    $no = 1;
    while($daqry = mysql_fetch_array($aqry)){
      foreach ($daqry as $key => $value) {
          $$key = $value; 
      }
        
    if($q == '0'){
    $getNamaProgram = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='0'"));
    $namaProgram =  $getNamaProgram['nama'];

    $sumTahunPlus = 0;

    $getAllKegiatan = mysql_query("select * from view_rka_2_2 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q!='0' $kondisiSKPD ");
    while($got = mysql_fetch_array($getAllKegiatan)){
      $gotC1= $got['c1'];
      $gotC= $got['c'];
      $gotD= $got['d'];
      $gotE = $got['e'];
      $gotE1 = $got['e1'];
      $gotQ= $got['q'];
      $getIdAwalRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) as idAwalRenja from view_renja where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$gotQ' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  "));
      $idAwalRenja = $getIdAwalRenja['idAwalRenja'];
      $getDetailRenja = mysql_fetch_array(mysql_query("select * from detail_renja where id_anggaran ='$idAwalRenja'"));
      $sumTahunPlus = $sumTahunPlus + $getDetailRenja['plus'];
    }
    $tahunPlus = number_format($sumTahunPlus ,2,',','.');
    $getBelanjaPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaPegawai from tabel_anggaran where nama_modul = 'RKA-SKPD' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='5' and l='2' and m='1' "));
       $getBelanjaBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaBarangJasa from tabel_anggaran where nama_modul = 'RKA-SKPD' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='5' and l='2' and m='2' "));
     $getBelanjaModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaModal from tabel_anggaran where nama_modul = 'RKA-SKPD' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='5' and l='2' and m='3' "));
     $jumlahRekening = $getBelanjaPegawai['belanjaPegawai'] + $getBelanjaBarangJasa['belanjaBarangJasa'] + $getBelanjaModal['belanjaModal'];
     $this->sumJumlahBelanjaPegawai += $getBelanjaPegawai['belanjaPegawai'];
     $this->sumJumlahBelanjaBarangJasa += $getBelanjaBarangJasa['belanjaBarangJasa'];
     $this->sumJumlahBelanjaModal += $getBelanjaModal['belanjaModal'];
     $this->sumJumlah += $jumlahRekening;

    $naonkitu = "
        <tr valign='top'>
          <td align='left' class='GarisCetak5' >".genNumber($bk).".".genNumber($ck).".".genNumber($dk).".".genNumber($p)."</td>
          <td align='left' class='GarisCetak5' >".genNumber($q)."</td>
          <td align='left' class='GarisCetak5' style=' font-weight: bold;'>".$namaProgram."</td>
          <td align='left' class='GarisCetak5' >".$getDetailRenja['lokasi_kegiatan']."</td>
          <td align='right' class='GarisCetak5' >".$getDetailRenja['capaian_program_tk']."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($jumlahRekening ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".$tahunPlus."</td>
        </tr>
              ";

   }else{
    $getNamaKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'"));
    $namaKegiatan =  $getNamaKegiatan['nama'];
    // $Koloms[] = array('align="left"', "<span style='margin-left:10px;'>".$namaKegiatan."</span>" );
    $getIdAwalRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) as idAwalRenja from view_renja where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  "));
    $idAwalRenja = $getIdAwalRenja['idAwalRenja'];
    if($idAwalRenja == NULL){
      $getIdAwalRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) as idAwalRenja from view_renja where c1='$c1' and c='$c' and d='$d'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  "));
      $idAwalRenja = $getIdAwalRenja['idAwalRenja'];
    }
    $getDetailRenja = mysql_fetch_array(mysql_query("select * from detail_renja where id_anggaran ='$idAwalRenja'"));

    // $Koloms[] = array('align="left"', $getDetailRenja['lokasi_kegiatan'] );
    // $Koloms[] = array('align="left"', $getDetailRenja['capaian_program_tk'] );
    $tahunPlus = number_format($getDetailRenja['plus'] ,2,',','.');
    $this->sumTahunPlusFromList += $getDetailRenja['plus'];

    $naonkitu = "
        <tr valign='top'>
          <td align='left' class='GarisCetak5' >".genNumber($bk).".".genNumber($ck).".".genNumber($dk).".".genNumber($p)."</td>
          <td align='left' class='GarisCetak5' >".genNumber($q)."</td>
          <td align='left' class='GarisCetak5' style=' font-weight: bold;'>".$namaProgram."</td>
          <td align='left' class='GarisCetak5' >".$getDetailRenja['lokasi_kegiatan']."</td>
          <td align='right' class='GarisCetak5' >".$getDetailRenja['capaian_program_tk']."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($jumlahRekening ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".$tahunPlus."</td>
        </tr>
              ";
   }
   if($q != '0'){
     $getBelanjaPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaPegawai from tabel_anggaran where nama_modul = 'RKA-SKPD' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='5' and l='2' and m='1' "));
       $getBelanjaBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaBarangJasa from tabel_anggaran where nama_modul = 'RKA-SKPD' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='5' and l='2' and m='2' "));
     $getBelanjaModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaModal from tabel_anggaran where nama_modul = 'RKA-SKPD' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='5' and l='2' and m='3' "));


     // $Koloms[] = array('align="right"', number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.') );
     // $Koloms[] = array('align="right"', number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.') );
     // $Koloms[] = array('align="right"', number_format($getBelanjaModal['belanjaModal'] ,2,',','.') );
     $jumlahRekening = $getBelanjaPegawai['belanjaPegawai'] + $getBelanjaBarangJasa['belanjaBarangJasa'] + $getBelanjaModal['belanjaModal'];
     // $Koloms[] = array('align="right"', number_format($jumlahRekening ,2,',','.') );
     $this->sumJumlahBelanjaPegawai += $getBelanjaPegawai['belanjaPegawai'];
     $this->sumJumlahBelanjaBarangJasa += $getBelanjaBarangJasa['belanjaBarangJasa'];
     $this->sumJumlahBelanjaModal += $getBelanjaModal['belanjaModal'];
     $this->sumJumlah += $jumlahRekening;
     // $Koloms[] = array('align="right"', $tahunPlus );

     $naonkitu = "
        <tr valign='top'>
          <td align='left' class='GarisCetak5' ></td>
          <td align='left' class='GarisCetak5' >".genNumber($q)."</td>
          <td align='left' class='GarisCetak5' style='padding-left: 10px;'>".$namaKegiatan."</td>
          <td align='left' class='GarisCetak5' >".$getDetailRenja['lokasi_kegiatan']."</td>
          <td align='right' class='GarisCetak5' >".$getDetailRenja['capaian_program_tk']."</td>
          <td align='right' class='GarisCetak5' style='border: 1px dashed;'>".number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='border: 1px dashed; border-right: 1px solid;'>".number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='border: 1px dashed; border-right: 1px solid;'>".number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='border: 1px dashed; border-right: 1px solid;'>".number_format($jumlahRekening ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='border: 1px dashed; border-right: 1px solid;'>".$tahunPlus."</td>
        </tr>
              ";
   }else{
     $getBelanjaPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaPegawai from view_rka_2_2_1 where id_tahap='$this->idTahap' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p'  and k='5' and l='2' and m='1' "));
     $getBelanjaBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaBarangJasa from view_rka_2_2_1 where  id_tahap='$this->idTahap' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p'  and k='5' and l='2' and m='2' "));
     $getBelanjaModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaModal from view_rka_2_2_1 where  id_tahap='$this->idTahap' $kondisiSKPD $kondisiFilter and bk='$bk' and ck='$ck' and dk='$dk' and p='$p'  and k='5' and l='2' and m='3' "));
     // $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>" .number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.') ."</span> " );
     // $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>" .number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</span>" );
     // $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>" . number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</span>" );
     $jumlahRekening = $getBelanjaPegawai['belanjaPegawai'] + $getBelanjaBarangJasa['belanjaBarangJasa'] + $getBelanjaModal['belanjaModal'];
     // $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>" . number_format($jumlahRekening ,2,',','.')."</span>" );
     // $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>" . $tahunPlus ."</span>" );
     $naonkitu = "
        <tr valign='top'>
          <td align='left' class='GarisCetak5' >".genNumber($bk).".".genNumber($ck).".".genNumber($dk).".".genNumber($p)."</td>
          <td align='left' class='GarisCetak5' >".genNumber($q)."</td>
          <td align='left' class='GarisCetak5' style=' font-weight: bold;'>".$namaProgram."</td>
          <td align='left' class='GarisCetak5' >".$getDetailRenja['lokasi_kegiatan']."</td>
          <td align='right' class='GarisCetak5' >".$getDetailRenja['capaian_program_tk']."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".number_format($jumlahRekening ,2,',','.')."</td>
          <td align='right' class='GarisCetak5' style='font-weight: bold;'>".$tahunPlus."</td>
        </tr>
              ";
   }
echo $naonkitu;
    $naonkitu = "";
}



    // "$ContentTotal
    "
               </table>";   
               
    $getDataPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGGUNA' "));
    if (sizeof($arrayTandaTangan)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '0' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $hmm = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '0' and c1 = '$c1' and c = '$c' and d = '$d' and Id = '".$_GET[ttd]."' "));
            $titimangsa = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan"));
            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '0' "));

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
            <hr style='border-top: 1px solid #000; margin-bottom: 5px; margin-top: 5px; width: 70%;'>
            <span style='margin-bottom: 5px;'>NIP ".$hmm['nip']."</span>
          
            
            </div>";

          }
      $sqlTimAnggaran = mysql_query("SELECT * from ref_tim_anggaran ORDER BY no_urut asc");
      while ($dataTimAnggaran = mysql_fetch_array($sqlTimAnggaran)) {
          $isiTimAnggaran .="
          <tr>
            <td style='text-align: center;' class='GarisCetak4'>$dataTimAnggaran[no_urut]</td>
            <td class='GarisCetak4'>$dataTimAnggaran[nama]</td>
            <td class='GarisCetak4'>$dataTimAnggaran[nip]</td>
            <td class='GarisCetak4'>$dataTimAnggaran[jabatan]</td>
            <td class='GarisCetak4'></td>
          </tr>
          ";
        }
    echo      
            "
            <table style='width:100.2%; border: 1px solid; margin-left: -1px;'>
              <tr>
                <td style='width: 50%; position: absolute;'><br>
                  <div class='ukurantulisan'>
                    <p style='padding-left: 2%;'>Ketarangan :</p>
                      <p style='padding-left: 5%;'>- Tanggal Pembahasan</p>
                      <p style='padding-left: 5%;'>- Catatan hasil pembahasan</p>
                  </div>
                </td>
                <td style='width: 50%; border-left: 1px solid;'>
                  ".$tandaTanganna."
                </td>
              </tr>
            </table>
            
            <table class='cetak' border='1' style='width:100.2%; margin-left: -1px; margin-top: -0.1%;'>
                <thead>
                  <tr>
                    <th colspan='6' style='text-align: center; border: 1px solid;'>
                      <span style='font-size:16px;font-weight:bold;'>
                        TIM ANGGARAN PEMERINTAH DAERAH
                      </span> 
                    </th>
                  </tr>
                  <tr>
                    <th class='th02' >No.</th>
                    <th class='th02' >NAMA</th>
                    <th class='th02' >NIP</th>
                    <th class='th02' >JABATAN</th>
                    <th class='th02' >TANDA TANGAN</th>
                  </tr>
                  </thead>
                  <tbody>
                      ".$isiTimAnggaran."
                  </tbody>
            </table>

            <h5 class='pag pag1'>
              <span style='bottom: 2px; position: absolute; left:0;'>
              <hr style='width: 33cm; border-top: 1px solid #000; margin-bottom: 19px;'>
              </span>
              <span style='bottom: 2px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
            </h5>
            <div class='insert'></div>
      </body> 
    </html>";
  }

}
$rkaSKPD22New = new rkaSKPD22NewObj();

$arrayResult = VulnWalkerTahap_v2('RKA');
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$rkaSKPD22New->jenisForm = $jenisForm;
$rkaSKPD22New->nomorUrut = $nomorUrut;
$rkaSKPD22New->tahun = $tahun;
$rkaSKPD22New->jenisAnggaran = $jenisAnggaran;
$rkaSKPD22New->idTahap = $idTahap;
$rkaSKPD22New->username = $_COOKIE['coID'];

$rkaSKPD22New->wajibValidasi = $Main->wajibValidasi;
if($Main->wajibValidasi == TRUE){
  $rkaSKPD22New->sqlValidasi = " and status_validasi ='1' ";
}else{
  $rkaSKPD22New->sqlValidasi = " ";
}


if(empty($rkaSKPD22New->tahun)){

  $get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_2_2_1 "));
  $maxAnggaran = $get1['max(id_anggaran)'];
  $get2 = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_anggaran = '$maxAnggaran'"));
  /*$rkaSKPD22New->tahun = "select max(id_anggaran) as max from view_rka_2_2_1 where nama_modul = 'rkaSKPD22New'";*/
  $rkaSKPD22New->tahun  = $get2['tahun'];
  $rkaSKPD22New->jenisAnggaran = $get2['jenis_anggaran'];
  $rkaSKPD22New->urutTerakhir = $get2['no_urut'];
  $rkaSKPD22New->jenisFormTerakhir = $get2['jenis_form_modul'];
  $rkaSKPD22New->idTahap = $get2['id_tahap'];
  $rkaSKPD22New->urutSebelumnya = $rkaSKPD22New->urutTerakhir - 1;


  $idtahapTerakhir = $get2['id_tahap'];
  $namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
  $rkaSKPD22New->namaTahapTerakhir = $namaTahap['nama_tahap'];
  $arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
  $lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
  $arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
  $lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
  $rkaSKPD22New->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

  $arrayHasil =  VulnWalkerLASTTahap_v2();
  $rkaSKPD22New->currentTahap = $arrayHasil['currentTahap'];
}else{
  $getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaSKPD22New->idTahap'"));
  $rkaSKPD22New->currentTahap = $getCurrenttahap['nama_tahap'];

  $namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaSKPD22New->idTahap'"));
  $rkaSKPD22New->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
  $rkaSKPD22New->namaTahapTerakhir = $namaTahap['nama_tahap'];
  $arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
  $lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
  $arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
  $lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
  $rkaSKPD22New->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}

$setting = settinganPerencanaan_v2();
$rkaSKPD22New->provinsi = $setting['provinsi'];
$rkaSKPD22New->kota = $setting['kota'];
$rkaSKPD22New->pengelolaBarang = $setting['pengelolaBarang'];
$rkaSKPD22New->pejabatPengelolaBarang = $setting['pejabat'];
$rkaSKPD22New->pengurusPengelolaBarang = $setting['pengurus'];
$rkaSKPD22New->nipPengelola = $setting['nipPengelola'];
$rkaSKPD22New->nipPengurus = $setting['nipPengurus'];
$rkaSKPD22New->nipPejabat = $setting['nipPejabat'];

if($rkaSKPD22New->jenisForm != "PENYUSUNAN"){
$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_2_2_1 where jenis_form_modul = 'PENYUSUNAN' "));
  $maxAnggaran = $get1['max(id_anggaran)'];
  $get2 = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_anggaran = '$maxAnggaran'"));
  $rkaSKPD22New->tahun  = $get2['tahun'];
  $rkaSKPD22New->jenisAnggaran = $get2['jenis_anggaran'];
  $rkaSKPD22New->urutTerakhir = $get2['no_urut'];
  $rkaSKPD22New->jenisFormTerakhir = $get2['jenis_form_modul'];
  $rkaSKPD22New->urutSebelumnya = $rkaSKPD22New->urutTerakhir - 1;


  $idtahapTerakhir = $get2['id_tahap'];
  $namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
  $rkaSKPD22New->namaTahapTerakhir = $namaTahap['nama_tahap'];
  $arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
  $lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
  $arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
  $lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
  $rkaSKPD22New->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

  $arrayHasil =  VulnWalkerLASTTahap_v2();
  $rkaSKPD22New->currentTahap = $arrayHasil['currentTahap'];
      $rkaSKPD22New->jenisForm = "";
      $rkaSKPD22New->jenisFormTerakhir = "PENYUSUNAN";
      $rkaSKPD22New->idTahap = $get2['id_tahap'];
      $rkaSKPD22New->nomorUrut = $get2['no_urut'];
      $rkaSKPD22New->urutTerakhir = $get2['no_urut'];
}


?>
