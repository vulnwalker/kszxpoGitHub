<?php
//header("Content-Type: text/javascript; charset=utf-8");
ob_start("ob_gzhandler");
/* ganti selector di index */
// include("common/vars.php");
include("config.php");

$Pg = isset($HTTP_GET_VARS["Pg"]) ? $HTTP_GET_VARS["Pg"] : "";

//if (CekLogin ()) {
  //  setLastAktif();

    switch ($Pg) {
        case "brg" : {
			if (CekLogin ()) {  setLastAktif();
               	include("pages/brg/selector.php");
			} else {  
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
        	break;                
        }
        case "map" : {
			//if (CekLogin () && $Main->MODUL_PETA) {  setLastAktif();
            if (CekLogin ()) {  setLastAktif();
               	include("pages/map/selector.php");
			} else {  
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
        	break;                
        }
		case '05': {
			if (CekLogin ()) {  setLastAktif();           
				include("pages/05/selector.php");
			} else {  
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		} 
		case '10': {//pindah tangan
			if (CekLogin ()) {  setLastAktif();
           
				include("pages/10/selector.php");
			} else {  
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		} 
		case '12': {
			if (CekLogin ()) {  setLastAktif();
           
				include("pages/12/selector.php");
			} else {  
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		} 
		/*case 'barcode':{ include("common/barcode.php"); break;}*/
		case 'barcode':{
			if (CekLogin ()) {  setLastAktif();
           
				include("pages/barcode/selector.php");
			} else {  
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'genxmlbar':{
			if (CekLogin ()) {  setLastAktif();
				include("pages/barcode/genxml.php"); 
			} else {  
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'sensus': {
			if (CekLogin(FALSE)) {  setLastAktif();
				include("pages/sensus/selector.php"); //break;
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'sensustmp': {
			if (CekLogin(FALSE)) {  setLastAktif();
			
				include ('common/daftarobj.php');
				include('common/fnsensus.php');
				$SensusTmp->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'skpd': {
			if (CekLogin(FALSE)) {  setLastAktif();
				include('common/fnskpd.php'); 
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
			
		}
		case 'gedung':{
			if (CekLogin(FALSE)) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/fngedung.php');
				$gedung->selector();	
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}		
			break;
		}
		case 'ruang': {
			if (CekLogin(FALSE)) {  setLastAktif();		
				include('common/daftarobj.php');
				include('common/fnruang.php');
				$Ruang->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}	
			break;
		}
		case 'RuangPilih': {
			if (CekLogin(FALSE)) {  setLastAktif();		
				include('common/daftarobj.php');
				include('common/fnruang.php');
				$RuangPilih->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}	
			break;
		}
		case 'pegawai': {
			if (CekLogin(FALSE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('common/fnpegawai.php');
				$Pegawai->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		
		case 'PegawaiPilih': {
			if (CekLogin(FALSE)) {  setLastAktif();		
				include('common/daftarobj.php');
				include('common/fnpegawai.php');
				$PegawaiPilih->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		
		case 'img': {
			if (CekLogin(FALSE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('common/fngbr2.php');
				$Gbr->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
			//select * from gambar where idbi = 10254
		}
		case 'wilayah':{		
			if (CekLogin(FALSE)) {  setLastAktif();
//				include('common/daftarobj.php');
				include("common/fnwilayah.php"); //break;
	//			$wilayah->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}
		case 'refKotaKec': {
			if (CekLogin(FALSE)) {  setLastAktif();
				$Main->HeadScript.="<script src=\"js/refkotakec.js\" type=\"text/javascript\"></script>";		
				include('common/daftarobj.php');
				include('common/fnrefkotakec.php');
				$refKotaKec->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refKotaKecPilih': {
			if (CekLogin(FALSE)) {  setLastAktif();	
				$Main->HeadScript.="<script src=\"js/refkotakec.js\" type=\"text/javascript\"></script>";		

				include('common/daftarobj.php');
				include('common/fnrefkotakec.php');
				$refKotaKecPilih->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}		
		case 'rkb':{
			//echo 'tes';
			if (CekLogin(FALSE) && $Main->MODUL_PERENCANAAN ) {  setLastAktif();
				
				include('common/daftarobj.php');
				if($Main->PP27_PERENCANAAN){
					include("pages/perencanaan/fnrkb.php"); //break;
					$rkb->selector();
				}else{
					include("common/fnrkb.php"); //break;
					$rkb->selector();
				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}
		case 'rkpb':{		
			if (CekLogin() && $Main->MODUL_PERENCANAAN ) {  setLastAktif();
				include('common/daftarobj.php');
				if($Main->PP27_PERENCANAAN){
					include("pages/perencanaan/fnrkpb.php"); //break;
					$rkpb->selector();
				}else{
					include("common/fnrkpb.php"); //break;
					$rkpb->selector();
				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}
		case 'dkb':{		
			if (CekLogin() && $Main->MODUL_PERENCANAAN ) {  setLastAktif();
				
				include('common/daftarobj.php');
				
				if($Main->PP27_PERENCANAAN){
					include("pages/perencanaan/fndkb.php"); //break;
					$dkb->selector();
				}else{
					include("common/fndkb.php"); //break;
					$dkb->selector();
				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}

		case 'dkpb':{		
			if (CekLogin() && $Main->MODUL_PERENCANAAN) {  setLastAktif();
				
				include('common/daftarobj.php');
				if($Main->PP27_PERENCANAAN){
					include("pages/perencanaan/fndkpb.php"); //break;
					$dkpb->selector();
				}else{
					include("common/fndkpb.php"); //break;
					$dkpb->selector();
				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}
    	/*case 'rekaprkb':{
			//echo 'tes';
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnrekap_rkb.php"); //break;
				$rekaprkb->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}*/
		case 'rekaprkb': {
			if (CekLogin() ) {  
				setLastAktif();								
				include_once('common/daftarobj.php');
				
				if($Main->PP27_PERENCANAAN){
					include("pages/perencanaan/rekaprkb.php"); //break;	//echo $UserAktivitas->pageShow();
					$rekaprkb->selector();					
				}else{
					include("common/fnrekap_rkb.php"); //break;
					$rekaprkb->selector();

				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		/*case 'rekapdkb':{			//echo 'tes';
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnrekap_dkb.php"); //break;
				$rekapdkb->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}*/
		case 'rekapdkb':{			//echo 'tes';
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				if($Main->PP27_PERENCANAAN){
					include("pages/perencanaan/rekapdkb.php"); //break;
					$rekapdkb->selector();
				} else{
					include("common/fnrekap_dkb.php"); //break;
					$rekapdkb->selector();
				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}		
		/*case 'rekaprkpb':{			//echo 'tes';
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnrekap_rkpb.php"); //break;
				$rekaprkpb->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}*/
		case 'rekaprkpb':{			//echo 'tes';
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				if($Main->PP27_PERENCANAAN ){
					include("pages/perencanaan/rekaprkpb.php"); //break;	//echo $UserAktivitas->pageShow();
					$rekaprkpb->selector();
				} else {

					include("common/fnrekap_rkpb.php"); //break;
					$rekaprkpb->selector();
				}


			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}
		/*case 'rekapdkpb':{			//echo 'tes';
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnrekap_dkpb.php"); //break;
				$rekapdkpb->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}*/
		case 'ref_jenis_peneliharaan': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/master/ref_jenis_pemeliharaan/ref_jenis_pemeliharaan.php');
				$ref_jenis_pemeliharaan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		
		case 'rekapdkpb':{			//echo 'tes';
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				if($Main->PP27_PERENCANAAN) {
					include("pages/perencanaan/rekapdkpb.php"); //break;
					$rekapdkpb->selector();
				}else{				
					include("common/fnrekap_dkpb.php"); //break;
					$rekapdkpb->selector();
				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}
		case 'dpb':{
			if (CekLogin() && $Main->MODUL_PENGADAAN) {  setLastAktif();
				include('common/daftarobj.php');
				if($Main->PP27_PENGADAAN){
					include("pages/pengadaan/fndpb.php"); //break;
					$dpb->selector();
				}else{
					include("common/fndpb.php"); //break;
					$dpb->selector();
				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		/*case 'rekapdpb':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnrekap_dpb.php"); //break;
				$rekapdpb->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}*/
		case 'rekapdpb': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				if($Main->PP27_PENGADAAN){
					include("pages/pengadaan/rekapdpb.php"); //break;	//echo $UserAktivitas->pageShow();
					$rekapdpb->selector();
				}else{
					include("common/fnrekap_dpb.php"); //break;
					$rekapdpb->selector();
				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		case 'dppb':{
			if (CekLogin()  && $Main->MODUL_PENGADAAN) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fndppb.php"); //break;
				$dppb->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'rekapdppb':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnrekap_dppb.php"); //break;
				$rekapdppb->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'usulanhapus':{
			if (CekLogin()) {  setLastAktif();
				
				include('common/daftarobj.php');
				include("common/fnusulanhapus.php"); //break;	//echo $UserAktivitas->pageShow();
				$UsulanHapus->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'usulanhapusba':{
			if (CekLogin()) {  setLastAktif();
				
				include('common/daftarobj.php');
				include("common/fnusulanhapusba.php"); //break;	//echo $UserAktivitas->pageShow();
				$UsulanHapusba->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'usulanhapussk':{
			if (CekLogin()) {  setLastAktif();
				
				include('common/daftarobj.php');
				include("common/fnusulanhapussk.php"); //break;	//echo $UserAktivitas->pageShow();
				$UsulanHapussk->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'usulanhapusdetail':{
			if (CekLogin()) {  setLastAktif();
				
				include('common/daftarobj.php');
				include("common/fnusulanhapusdetail.php"); //break;	//echo $UserAktivitas->pageShow();
				$UsulanHapusdetail->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'usulanhapusbadetail':{
			if (CekLogin()) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("common/fnusulanhapusbadetail.php"); //break;	//echo $UserAktivitas->pageShow();
				$UsulanHapusbadetail->selector();				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;			
		}
		case 'usulanhapusskdet':{
			if (CekLogin()) {  setLastAktif();
				
				include('common/daftarobj.php');
				include("common/fnusulanhapusskdet.php"); //break;	//echo $UserAktivitas->pageShow();
				$UsulanHapusskdet->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'usulanhapusbacari':{
			if (CekLogin()) {  setLastAktif();
				
				include('common/daftarobj.php');
				include("common/fnusulanhapusbacari.php"); //break;	//echo $UserAktivitas->pageShow();
				$UsulanHapusbacari->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'panitiapemeriksa':{
			if (CekLogin()) {  setLastAktif();
				
				include('common/daftarobj.php');
				include("common/fnpanitiapemeriksa.php");
				$PanitiaPemeriksa->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'penatausahapilih':{
			if (CekLogin()) {  setLastAktif();
				
				include('common/daftarobj.php');
				//include('common/fnpenatausaha.php');
				include("common/fnpenatausahapilih.php"); //break;	//echo $UserAktivitas->pageShow();
				$PenatausahaPilih->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		
		case 'rekappenerimaan':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnrekap_penerimaan.php"); //break;
				$rekappenerimaan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'pengeluaran':{
			if (CekLogin()  && $Main->MODUL_PENERIMAAN) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnpengeluaran.php"); //break;
				//$pengeluaran->pageShow();
				$pengeluaran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}		
		case 'rekappengeluaran':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnrekap_pengeluaran.php"); //break;
				$rekappengeluaran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'gudang': {
			if (CekLogin(FALSE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('common/fngudang.php');
				$Gudang->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'GudangPilih': {
			if (CekLogin(FALSE)) {  setLastAktif();		
				include('common/daftarobj.php');
				include('common/fngudang.php');
				$GudangPilih->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'useraktivitas':{
			if (CekLogin()) {  setLastAktif();
				if ($HTTP_COOKIE_VARS['coLevel']==1 ){
					
				
				include('common/daftarobj.php');
				include("common/fnuseraktivitas.php"); //break;
				//echo $UserAktivitas->pageShow();
				$UserAktivitas->selector();
				}else{
					header("Location:index.php?");
				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'UserAktivitasDet': {
			if (CekLogin(FALSE)) {  setLastAktif();		
				include('common/daftarobj.php');
				include('common/fnuseraktivitas.php');
				//echo'tes';
				$UserAktivitasDet->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'userprofil':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnuserprofil.php"); //break;				
				$UserProfil->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'processupload':{
			include('ajax-upload/processupload.php');
			break;
		}
		case 'processuploadfile':{
			include('ajax-upload/uploadfile.php');
			break;
		}			
		case 'SensusHasil':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnsensushasil.php"); //break;	//echo $UserAktivitas->pageShow();
				$SensusHasil->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'SensusHasil2':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnsensushasil2.php"); //break;	//echo $UserAktivitas->pageShow();
				
				$SensusHasil2->selector();

				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
 			
			break;
			
		}
		case 'SensusTidakTercatat':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnsensustidaktercatat.php"); //break;	//echo $UserAktivitas->pageShow();
				$SensusTidakTercatat->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'SensusScan':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnsensusscan.php"); //break;	//echo $UserAktivitas->pageShow();
				$SensusScan->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'SensusProgres':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnsensusprogres.php"); //break;	//echo $UserAktivitas->pageShow();
				$SensusProgres->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}		
		case 'Pembukuan':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnpembukuan.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pembukuan->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}		
		case 'Rekap1':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnpembukuan_1_ajx.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pembukuan1Ajx->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'Rekap1_old':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnpembukuan_1.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pembukuan2->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'Rekap2_old':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnpembukuan_2.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pembukuan2_2->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'Rekap2':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');	
				//if($Main->VERSI_NAME == 'SERANG'){
				//	include("common/fnpembukuan_2.php"); //break;	//echo $UserAktivitas->pageShow();
				//	$Pembukuan2_2->selector();
				//}else{
					include("common/fnpembukuan_2_ajx.php"); //break;	//echo $UserAktivitas->pageShow();
					$Pembukuan2Ajx->selector();	
				//}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'Rekap3':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				//include("common/fnpembukuan_3.php"); //break;	//echo $UserAktivitas->pageShow();
				//$Pembukuan3_2->selector();
				include("common/fnpembukuan_3_ajx2.php");				
				$Pembukuan3_2Ajx2->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'Rekap3_old':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				//include("common/fnpembukuan_3.php"); //break;	//echo $UserAktivitas->pageShow();
				//$Pembukuan3_2->selector();
				include("common/fnpembukuan_3_ajx.php");				
				$Pembukuan3_2Ajx->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		/**case 'Rekap3Ajx':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnpembukuan_3_ajx.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pembukuan3_2Ajx->selector();				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;			
		}**/	
		case 'Reclass': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("common/fnreclass.php"); //break;	//echo $UserAktivitas->pageShow();
				//echo 'tes';
				$Reclass->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'backup': {
			if (CekLogin(FALSE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/admin/backup.php');
				$backup->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}	

		case 'migrasi': {
			if (CekLogin(FALSE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/admin/migrasi.php');
				$migrasi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'DaftarImport': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("common/fndaftarimport.php"); //break;	//echo $UserAktivitas->pageShow();
				$DaftarImport->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'Penyusutan': {
			if (CekLogin() && $Main->PENYUSUTAN ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("common/fnpenyusutan.php"); //break;	//echo $UserAktivitas->pageShow();
				$Penyusutan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'refbarang': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_aset/refbarang.php"); //break;	//echo $UserAktivitas->pageShow();
				$RefBarang->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'refjurnal': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_aset/refjurnal.php"); //break;	//echo $UserAktivitas->pageShow();
				$RefJurnal->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'history': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/penatausahaan/history.php"); //break;	//echo $UserAktivitas->pageShow();
				$History->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

			

		case 'AsetLainLain': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('common/fnasetlainlain.php');
				$AsetLainLain->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}	
		case 'Kapitalisasi': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('common/fnkapitalisasi.php');
				$Kapitalisasi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}	
		case 'Jurnal': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('common/fnjurnal.php');
				$Jurnal->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'reclass_asal': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("common/fnreclass_asal.php"); //break;	//echo $UserAktivitas->pageShow();
				//echo 'tes';
				$reclass_asal->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'reclass_baru': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("common/fnreclass_baru.php"); //break;	//echo $UserAktivitas->pageShow();
				//echo 'tes';
				$reclass_baru->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		
		case 'Penilaian': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/penilaian/penilaian.php"); //break;	//echo $UserAktivitas->pageShow();
				$Penilaian->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	

		case 'Kip': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/kip/kip.php"); //break;	//echo $UserAktivitas->pageShow();
				$Kip->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'RefStatusBarang': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/master/refstatusbarang/refstatusbarang.php"); //break;	//echo $UserAktivitas->pageShow();
				$RefStatusBarang->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'HrgSatPilih': {
			if (CekLogin(FALSE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/01/HrgSatPilih.php');
				$HrgSatPilih->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}

		case 'rka': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rka.php"); //break;	//echo $UserAktivitas->pageShow();
				$RKA->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'rkadetail': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rkadetail.php"); //break;	//echo $UserAktivitas->pageShow();
				$RKADetail->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'rencana_pemanfaatan': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/perencanaan/rencana_pemanfaatan.php');
				$rencana_pemanfaatan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'rpebmd': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/perencanaan/rpebmd.php');
				$rpebmd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'rphbmd': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/perencanaan/rphbmd.php');
				$rphbmd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'rekaprkb_skpd': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/perencanaan/rekaprkb_skpd.php');
				$rekaprkb_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}	
		case 'rekaprkpbmd_skpd': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/perencanaan/rekaprkpbmd_skpd.php');
				$rekaprkpbmd_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'rekaprkb_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rekaprkb_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekaprkb_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}/*		
		case 'ref_urusan2': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/master/ref_urusan2/ref_urusan2.php"); //break;	//echo $UserAktivitas->pageShow();
				$ref_urusan2->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}*/

		case 'rekaprkb_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/perencanaan/rekaprkb_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekaprkb_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'refskpd_urusan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/master/refskpd_urusan/refskpd_urusan.php"); //break;	//echo $UserAktivitas->pageShow();
				$refskpd_urusan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'refprogram': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/master/refprogram/refprogram.php');
				$refprogram->selector();
			}else{ 
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'rekapdkpb_skpd': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/perencanaan/rekapdkpbmd_skpd.php');
				$rekapdkpbmd_skpd->selector();
			}else{ 
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'rekapdkb_skpd': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/perencanaan/rekapdkb_skpd.php');
				$rekapdkb_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'rekaprphbmd_skpd': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/perencanaan/rekaprphbmd_skpd.php');
				$rekaprphbmd_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'rekaprpebmd_skpd': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/perencanaan/rekaprpebmd_skpd.php');
				$rekaprpebmd_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'rekaprpbmd_skpd': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/perencanaan/rekaprpbmd_skpd.php');
				$rekaprpbmd_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}	

		case 'barekon_audit': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/rekon/barekon_audit.php"); //break;	//echo $UserAktivitas->pageShow();
				$BaRekon_Audit->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'barekon': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/rekon/barekon.php"); //break;	//echo $UserAktivitas->pageShow();
				$BaRekon->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'bapengalihan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/rekon/bapengalihan.php"); //break;	//echo $UserAktivitas->pageShow();
				$BaPengalihan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekonlampiran1': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/rekon/rekonlampiran1.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekonlampiran1->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
			
		case 'rekonlampiran2': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/rekon/rekonlampiran2.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekonlampiran2->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekonhitung': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/rekon/rekonhitung.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekonhitung->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	

		case 'rekon': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/rekon/rekon.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekon->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		case 'rekapdkb_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rekapdkb_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekapdkb_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		case 'rekapdkpb_lampiran':{			//echo 'tes';
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("pages/perencanaan/rekapdkpb_lampiran.php"); //break;
				$Rekapdkpb_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}			
			break;
		}
		case 'rekaprkpb_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rekaprkpb_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekaprkpb_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	

		case 'rekapdkb_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/perencanaan/rekapdkb_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekapdkb_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'rekaprkpbmd_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/perencanaan/rekaprkpbmd_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekaprkpbmd_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'rekapdkpbmd_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/perencanaan/rekapdkpbmd_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekapdkpbmd_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'rekaprpbmd_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/perencanaan/rekaprpbmd_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekaprpbmd_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'rekaprpebmd_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/perencanaan/rekaprpebmd_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekaprpebmd_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'rekaprphbmd_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/perencanaan/rekaprphbmd_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekaprphbmd_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'dpb_rencana': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pengadaan/dpb_rencana.php"); //break;	//echo $UserAktivitas->pageShow();
				$Dpb_Rencana->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'rekapdpb_skpd': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pengadaan/rekapdpb_skpd.php');
				$rekapdpb_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'rekaprpbmd': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rekaprpbmd.php"); //break;	//echo $UserAktivitas->pageShow();
				$rekaprpbmd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'rekaprptbmd': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rekaprptbmd.php"); //break;	//echo $UserAktivitas->pageShow();
				$rekaprptbmd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'rekaprphbmd': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rekaprphbmd.php"); //break;	//echo $UserAktivitas->pageShow();
				$rekaprphbmd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'pemelihara_rencana': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pemeliharaan/pemelihara_rencana.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pemelihara_Rencana->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'pemanfaat_rencana': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pemanfaatan/pemanfaat_rencana.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pemanfaat_Rencana->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekaprpb_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rekaprpb_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekaprpb_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekaprpt_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rekaprpt_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekaprpt_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekaprph_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/perencanaan/rekaprph_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekaprph_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'pemeliharaan':{
			if (CekLogin() && $Main->MODUL_PENGADAAN) {  setLastAktif();
				include('common/daftarobj.php');
				include("pages/pemeliharaan/pemeliharaan.php"); //break;
				$pemeliharaan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'pemindahtangan_rencana': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pemindahtangan/pemindahtangan_rencana.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pemindahtangan_Rencana->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'pemanfaatan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pemanfaatan/pemanfaatan.php"); //break;	//echo $UserAktivitas->pageShow();
				$pemanfaatan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'MutasiBA': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/mutasi/mutasiba.php"); //break;	//echo $UserAktivitas->pageShow();
				$MutasiBA->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'MutasiKurang': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/mutasi/mutasikurang.php"); //break;	//echo $UserAktivitas->pageShow();
				$MutasiKurang->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'MutasiKurangDetail': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/mutasi/mutasikurangdetail.php"); //break;	//echo $UserAktivitas->pageShow();
				$MutasiKurangDetail->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}		
		
		case 'MutasiTambah': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/mutasi/mutasitambah.php"); //break;	//echo $UserAktivitas->pageShow();
				$MutasiTambah->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'MutasiTambahDetail': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/mutasi/mutasitambahdetail.php"); //break;	//echo $UserAktivitas->pageShow();
				$MutasiTambahDetail->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'pemindahtangan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pemindahtangan/pemindahtangan.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pemindahtangan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'Penilaian_manfaat': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/penilaian/penilaian_manfaat.php"); //break;	//echo $UserAktivitas->pageShow();
				$Penilaian_manfaat->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'Penilaian_pindahtangan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/penilaian/penilaian_pindahtangan.php"); //break;	//echo $UserAktivitas->pageShow();
				$Penilaian_pindahtangan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'Penilaian_koreksi': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/penilaian/penilaian_koreksi.php"); //break;	//echo $UserAktivitas->pageShow();
				$Penilaian_koreksi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'pemusnahan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pemusnahan/pemusnahan.php"); //break;	//echo $UserAktivitas->pageShow();
				$pemusnahan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'pemusnahanba': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pemusnahan/pemusnahanba.php"); //break;	//echo $UserAktivitas->pageShow();
				$pemusnahanba->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'pemusnahan_panitia': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pemusnahan/pemusnahan_panitia.php"); //break;	//echo $UserAktivitas->pageShow();
				$pemusnahan_panitia->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		
		case 'pemusnahan_det': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pemusnahan/pemusnahan_det.php"); //break;	//echo $UserAktivitas->pageShow();
				$pemusnahan_det->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'tgr_ketetapan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/gantirugi/tgr_ketetapan.php"); //break;	//echo $UserAktivitas->pageShow();
				$tgr_ketetapan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'tgr': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/gantirugi/tgr.php"); //break;	//echo $UserAktivitas->pageShow();
				$TGR->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekappemanfaatan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemanfaatan/rekappemanfaatan.php"); //break;	//echo $UserAktivitas->pageShow();
				$rekappemanfaatan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekappemanfaatan_skpd': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemanfaatan/rekappemanfaatan_skpd.php"); //break;	//echo $UserAktivitas->pageShow();
				$rekappemanfaatan_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'reftambahmanfaat': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/master/reftambahmanfaat/reftambahmanfaat.php"); //break;	//echo $UserAktivitas->pageShow();
				$RefTambahManfaat->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekapdpb_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pengadaan/rekapdpb_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekapdpb_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'ref_std_butuh': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/master/refstdbutuh/refstdbutuh.php"); //break;	//echo $UserAktivitas->pageShow();
				$refstdbutuh->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'refbarangbutuh': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/master/refstdbutuh/refbarangbutuh.php"); //break;	//echo $UserAktivitas->pageShow();
				$RefBarangButuh->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekappelihara': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemeliharaan/rekappemeliharaan.php"); //break;	//echo $UserAktivitas->pageShow();
				$RekapPemeliharaan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'rekappelihara_skpd':{
			if (CekLogin() && $Main->MODUL_PENGADAAN) {  setLastAktif();
				include('common/daftarobj.php');
				include("pages/pemeliharaan/rekappemeliharaan_skpd.php"); //break;
				$rekappemeliharaan_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekapdpb_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pengadaan/rekapdpb_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekapdpb_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekappemindahtangan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemindahtangan/rekappemindahtangan.php"); //break;	//echo $UserAktivitas->pageShow();
				$RekapPemindahtangan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekappemanfaatan_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemanfaatan/rekappemanfaatan_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekappemanfaatan_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'rekappemindahtangan_skpd': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pemindahtangan/rekappemindahtangan_skpd.php"); //break;	//echo $UserAktivitas->pageShow();
				$rekappemindahtangan_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekappemeliharaan_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemeliharaan/rekappemeliharaan_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekappemeliharaan_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekappemindahtangan_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemindahtangan/rekappemindahtangan_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekappemindahtangan_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	

		case 'rekappemeliharaan_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemeliharaan/rekappemeliharaan_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekappemeliharaan_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'penghapusan_sk': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/penghapusan/penghapusan_sk.php"); //break;	//echo $UserAktivitas->pageShow();
				$penghapusan_sk->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'penghapusan_rencana': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/penghapusan/penghapusan_rencana.php"); //break;	//echo $UserAktivitas->pageShow();
				$penghapusan_rencana->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'penghapusan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/penghapusan/penghapusan.php"); //break;	//echo $UserAktivitas->pageShow();
				$penghapusan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'penghapusan_det': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/penghapusan/penghapusan_det.php"); //break;	//echo $UserAktivitas->pageShow();
				$penghapusan_det->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekappemanfaatan_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemanfaatan/rekappemanfaatan_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekappemanfaatan_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		/*case 'penerimaan':{
			if (CekLogin()  && $Main->MODUL_PENERIMAAN) {  setLastAktif();
				include('common/daftarobj.php');
				include("common/fnpenerimaan.php"); //break;
				$penerimaan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}*/

		case 'penerimaan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				if($Main->PP27_PENERIMAAN){
					include("pages/penerimaan/penerimaan.php"); //break;	//echo $UserAktivitas->pageShow();
					$Penerimaan->selector();
				}else{
					include("common/fnpenerimaan.php"); //break;
					$penerimaan->selector();
				}
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		
		case 'penerimaandetail': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/penerimaan/penerimaandetail.php"); //break;	//echo $UserAktivitas->pageShow();
				$PenerimaanDetail->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		
		case 'distribusi': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/penerimaan/distribusi.php"); //break;	//echo $UserAktivitas->pageShow();
				$Distribusi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		
		case 'distribusidetail': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/penerimaan/distribusidetail.php"); //break;	//echo $UserAktivitas->pageShow();
				$DistribusiDetail->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'pengadaancari': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/penerimaan/pengadaancari.php"); //break;	//echo $UserAktivitas->pageShow();
				$PengadaanCari->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekappemindahtangan_skpd_rinci': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemindahtangan/rekappemindahtangan_skpd_rinci.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekappemindahtangan_skpd_rinci->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'rekappenghapusan_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/penghapusan/rekappenghapusan_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekappenghapusan_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		
		case 'rekappemusnahan_lampiran': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemusnahan/rekappemusnahan_lampiran.php"); //break;	//echo $UserAktivitas->pageShow();
				$Rekappemusnahan_lampiran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'dpb_spk_det': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pengadaan/dpb_spk_det.php"); //break;	//echo $UserAktivitas->pageShow();
				$dpb_spk_det->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'dpb_spk': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/pengadaan/dpb_spk.php"); //break;	//echo $UserAktivitas->pageShow();
				$dpb_spk->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'lra': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_lra/ref_lra.php"); //break;	//echo $UserAktivitas->pageShow();
				$Ref_LRA->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'RekapPenyusutan': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('common/fnrekappenyusutan.php');
				$RekapPenyusutan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'perbandingan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/RLA/perbandingan.php"); //break;	//echo $UserAktivitas->pageShow();
				$Perbandingan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		case 'JurnalPenyusutan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/penyusutan/jurnalpenyusutan.php"); //break;	//echo $UserAktivitas->pageShow();
				$JurnalPenyusutan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'JurnalPenyusutan2': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/penyusutan/jurnalpenyusutan2.php"); //break;	//echo $UserAktivitas->pageShow();
				$JurnalPenyusutan2->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}		

		case 'Pemeliharaan_Tambah_Manfaat': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/pemeliharaan/pemeliharaan_tambah_manfaat.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pemeliharaan_Tambah_Manfaat->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}/*																
		case 'refSKPD_Keuangan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/refSKPD_Keuangan/refSKPD_Keuangan.php"); //break;	//echo $UserAktivitas->pageShow();
				$refSKPD_Keuangan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}*/	
		case 'refMapping_SKPD': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/refMapping_SKPD/refMapping_SKPD.php"); //break;	//echo $UserAktivitas->pageShow();
				$refMapping_SKPD->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		case 'ref_penyusutan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_penyusutan/ref_penyusutan.php"); //break;	//echo $UserAktivitas->pageShow();
				$ref_penyusutan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		case 'ref_kapitalisasi': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_kapitalisasi/ref_kapitalisasi.php"); //break;	//echo $UserAktivitas->pageShow();
				$ref_kapitalisasi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'refstandarharga': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/refstandarharga/refstandarharga.php"); //break;	//echo $UserAktivitas->pageShow();
				$refstandarharga->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		case 'ref_tandatangan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_tandatangan/ref_tandatangan.php"); //break;	//echo $UserAktivitas->pageShow();
				$ref_tandatangan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
	case 'refclosingdata': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/admin/refclosingdata/refclosingdata.php"); //break;	//echo $UserAktivitas->pageShow();
				$refclosingdata->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}					
		case 'refdatalra': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/admin/refdatalra/refdatalra.php"); //break;	//echo $UserAktivitas->pageShow();
				$refdatalra->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}																
		case 'refmigrasi': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/admin/refmigrasi/refmigrasi.php"); //break;	//echo $UserAktivitas->pageShow();
				$refmigrasi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		case 'refperbandinganhasil': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/admin/refperbandinganhasil/refperbandinganhasil.php"); //break;	//echo $UserAktivitas->pageShow();
				$refperbandinganhasil->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}	
		case 'ref_skpd': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_skpd/ref_skpd.php"); //break;	//echo $UserAktivitas->pageShow();
				$ref_skpd->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'ref_rekening': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_rekening/ref_rekening.php"); //break;	//echo $UserAktivitas->pageShow();
				$ref_rekening->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'ref_gudang': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_gudang/ref_gudang.php"); //break;	//echo $UserAktivitas->pageShow();
				$ref_gudang->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;	
		}
		case 'ref_skpd_keuangan': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_skpd_keuangan/ref_skpd_keuangan.php"); //break;	//echo $UserAktivitas->pageShow();
				$ref_skpd_keuangan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;	
		}
		case 'Koreksi': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('common/fnkoreksi.php');
				$Koreksi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}

		case 'Kondisi': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/kondisi/kondisi.php"); //break;	//echo $UserAktivitas->pageShow();
				$Kondisi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'Rekap5':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("common/fnpembukuan_5.php"); //break;	//echo $UserAktivitas->pageShow();
				$Pembukuan5->selector();
				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
			
		}
		case 'gantirugi': {
			
			if (CekLogin(TRUE)) {  setLastAktif();	
				
				include('common/daftarobj.php');
				include('pages/gantirugi/gantirugi.php');
				
				$gantirugi->selector();
//echo "test";
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		
		case 'gantirugibayar': {
			if (CekLogin(TRUE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/gantirugi/gantirugibayar.php');
				$gantirugibayar->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}	
		case 'gantirugiprogres': {
			if (CekLogin(TRUE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/gantirugi/gantirugiprogres.php');
				$gantirugiprogres->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		
		case 'gantirugi_cari': {
			if (CekLogin(TRUE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/gantirugi/gantirugi_cari.php');
				$gantirugi_cari->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'ref_sumberdana': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_sumberdana/ref_sumberdana.php"); //break;	//echo $UserAktivitas->pageShow();
				$ref_sumberdana->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;	
		}
		case 'RekapPenyusutanOld': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('common/fnrekap_penyusutan.php');
				$RekapPenyusutanOld->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'bast': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/bast/bast.php');
				$bast->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'sotkbaru':{
			if (CekLogin() ) {  
				include('common/daftarobj.php');
				include("pages/sotkbaru/sotkbaru.php"); //break;	//echo $UserAktivitas->pageShow();
				$SOTKBaru->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 't_pegawai_ins': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pegawai/t_pegawai_ins.php');
				$t_pegawai_ins->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'pemasukan_atribusi': {
			if (CekLogin(TRUE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pengadaanpenerimaan/pemasukan_atribusi.php');
				$pemasukan_atribusi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}	
		case 'cariIdPenerima': {
			if (CekLogin(TRUE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pencarian/cariIdPenerima.php');
				$cariIdPenerima->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'pemasukan_distribusi': {
			if (CekLogin(TRUE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pengadaanpenerimaan/pemasukan_distribusi.php');
				$pemasukan_distribusi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'cariTemplate': {
			if (CekLogin(TRUE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pencarian/cariTemplate.php');
				$cariTemplate->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'ref_template': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/master/ref_template/ref_template.php"); //break;	//echo $UserAktivitas->pageShow();
				$template->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'detailTemplate': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/master/ref_template/detailTemplate.php"); //break;	//echo $UserAktivitas->pageShow();
				$detailTemplate->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'detailTemplateEdit': {
			if (CekLogin() ) {  
				setLastAktif();				
				include_once('common/daftarobj.php');
				include("pages/master/ref_template/detailTemplateEdit.php"); //break;	//echo $UserAktivitas->pageShow();
				$detailTemplateEdit->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}
		case 'pemasukan_kapitalisasi': {
			if (CekLogin(TRUE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pengadaanpenerimaan/pemasukan_kapitalisasi.php');
				$pemasukan_kapitalisasi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'DataPengaturan': {
			if (CekLogin(TRUE)) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pencarian/DataPengaturan.php');
				$DataPengaturan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}	
		case 'cariRekening': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pencarian/cariRekening.php');
				$cariRekening->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'pemasukan_ins': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pengadaanpenerimaan/pemasukan_ins.php');
				$pemasukan_ins->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'cariprogram': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pencarian/cariprogram.php');
				$cariprogram->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'pemasukan': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pengadaanpenerimaan/pemasukan.php');
				$pemasukan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'cariBarang': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pencarian/cariBarang.php');
				$cariBarang->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'Cekbi': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('common/fncekbi.php');
				$Cekbi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'PenyusutanLog':{
			if (CekLogin()) {  setLastAktif();				
				include('common/daftarobj.php');				
				include("pages/penyusutan/penyusutanlog.php"); //break;	//echo $UserAktivitas->pageShow();
				
				$PenyusutanLog->selector();

				
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
 			
			break;
			
		}	
		case 'cariIDBI': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/pencarian/cariIDBI.php');
				$cariIDBI->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		
		case 'ref_sp_potongan': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/master/ref_sp_potongan/ref_sp_potongan.php');
				$ref_sp_potongan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		
		case 'ref_rekening_daerah': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/master/ref_rekening_daerah/ref_rekening_daerah.php');
				$ref_rekening_daerah->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		
		case 'ref_rekening3': {
			if (CekLogin() ) {  
				setLastAktif();				
				include('common/daftarobj.php');
				include("pages/master/ref_rekening/ref_rekening3.php"); //break;	//echo $UserAktivitas->pageShow();
				$ref_rekening3->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}						
			break;
		}

		case 'ref_nm_pejabat_sp': {
			if (CekLogin()) {  setLastAktif();	
				include('common/daftarobj.php');
				include('pages/master/ref_nm_pejabat_sp/ref_nm_pejabat_sp.php');
				$ref_nm_pejabat_sp->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		
	 }
    
	ob_flush();
	flush();

//} else {  header("Location: http://atisisbada.net/");}
?>
