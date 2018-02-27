<?php

function getStatusAset($fmSTATUSASET, $fmKONDISIBARANG, $fmHARGABARANG, $f,$g,$h,$i,$j,$fmTAHUN=''){
	global $Main;
	switch($Main->VERSI_NAME){ //$fmSTATUSASET, $ArBarang[0], $fmHARGABARANG
		case 'KARAWANG' : { //extra < 250000 kecuali bku (05.17), karpet (?), gorden (?)
			//if($fmKONDISIBARANG==3 && ($fmSTATUSASET==3 || $fmSTATUSASET==8 || $fmSTATUSASET==9) ){ //RB
			//	$fmSTATUSASET=9;
			//}else{		
			if($fmSTATUSASET !=5 && $fmSTATUSASET !=6 && $fmSTATUSASET !=7  ){//pindah tangan, tgr, pemitraan, (tidak rubah aset)
						
				if($fmKONDISIBARANG==3 ){ //rb oto
					$fmSTATUSASET=9;
				}else{
					if( 
						( $fmHARGABARANG >= 500000  ) ||
						( $f.$g =='0517' && $fmHARGABARANG >= 100000) || //buku
						( $f.$g =='0518' && $fmHARGABARANG >= 1500000) || //barang bercorak kebudayaan
						( $f.$g.$h.$i =='05180103' && $fmHARGABARANG >= 500000) || //alat kesenian
						( $f.$g =='0519' && $fmHARGABARANG >= 1000000) || //hewan ternak & tumbuhan
						( $f=='01' || $f=='03' || $f=='04' || $f=='06' || $f=='07')
					){
						//$fmSTATUSASET = 3;
						$fmSTATUSASET = $f.$g =='0724' ? 8:3; 
					}else{
						if ($fmTAHUN>2015) $fmSTATUSASET = 10;		
					}	
				}
			}
			break;
		}
		case 'KOTA_BANDUNG' : {
			if($fmSTATUSASET !=5 && $fmSTATUSASET !=6 && $fmSTATUSASET !=7 && $fmSTATUSASET!=10  ){	//pindah tangan, tgr, pemitraan, (tidak rubah aset)					
				/*if($fmKONDISIBARANG==3  ){ //RB oto aset lainnya
					$fmSTATUSASET=9;
				}else{						
					if ( $fmSTATUSASET == '' ){ 
						$fmSTATUSASET = $f.$g =='0724' ? 8:3; //ATB
					}
				}*/
				//cek intra
				if( ( $f=='02' && $fmHARGABARANG <1000000 && $fmTAHUN>=2016 ) ||
					( $f=='03' && $fmHARGABARANG <10000000 && $fmTAHUN>=2016 )
					){ //ekstra
					$fmSTATUSASET=10;
				}else if($fmKONDISIBARANG==3 ){ //aset lain
					$fmSTATUSASET=9;
				}else if( $f.$g =='0724'){
					$fmSTATUSASET = 8; //ATB
				}else{
					$fmSTATUSASET = 3; 
				}
			}
			break;
		

		}
		case 'SERANG' : { //kab
			if($fmSTATUSASET !=5 && $fmSTATUSASET !=6 && $fmSTATUSASET !=7  ){//pindah tangan, tgr, pemitraan, (tidak rubah aset)
				//if($fmKONDISIBARANG==3 && ($fmSTATUSASET==3 || $fmSTATUSASET==8 || $fmSTATUSASET==9) ){ //rb otomatis
				if($fmKONDISIBARANG==3 ){ //rb oto
					$fmSTATUSASET=9;
				}else{ //extra, intra , tdk oto												 
					if( 
						$fmHARGABARANG< 1000000 
					){
						$fmSTATUSASET = 10;//extra
					//}else if( $ArBarang[0].$ArBarang[1]=='0724'  ){									
					//	$fmSTATUSASET = 8;	//tak berwujud						
					}else{
						//$fmSTATUSASET = 3;	//intra						
						$fmSTATUSASET = $f.$g =='0724' ? 8:3; 
					}		
				}
			}			
			break;
		}	
		case 'SERANG_KOTA' : {
			if($fmSTATUSASET !=5 && $fmSTATUSASET !=6 && $fmSTATUSASET !=7  ){//pindah tangan, tgr, pemitraan, (tidak rubah aset)
				//if($fmKONDISIBARANG==3 && ($fmSTATUSASET==3 || $fmSTATUSASET==8 || $fmSTATUSASET==9) ){ //rb otomatis
				if($fmKONDISIBARANG==3 ){ //rb oto
					$fmSTATUSASET=9;
				}else{ //extra, intra , tdk oto												 
					if( 
						( $f.$g=='0202' && $fmHARGABARANG< 10000000 ) ||	// Alat-alat Berat
						( $f.$g=='0203' && $fmHARGABARANG< 5000000 ) ||		// Alat-alat Angkutan
						( $f.$g=='0204' && $fmHARGABARANG< 500000 ) ||		// Alat-alat bengkel dan alat ukur
						( $f.$g=='0205' && $fmHARGABARANG< 1000000 ) ||		// Alat Pertanian
						( $f.$g.$h=='020601' && $fmHARGABARANG< 1000000 ) ||	// Alat-alat Kantor
						( $f.$g.$h=='020602' && $fmHARGABARANG< 500000 ) ||		// Alat-alat Rumah tangga
						( $f.$g=='0207' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat studio
						( $f.$g=='0208' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat kedokteran
						( $f.$g=='0209' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat Laboratorium
						( $f.$g=='0210' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat persenjataan

						( $f.$g=='0301' && $fmHARGABARANG< 50000000 ) ||	// Gedung
						( $f.$g=='0302' && $fmHARGABARANG< 20000000 ) ||	// Monumen

						( $f.$g=='0413' && $fmHARGABARANG< 40000000 ) ||	// Jalan & Jembatan
						( $f.$g=='0414' && $fmHARGABARANG< 25000000 ) ||	// Bangunan Air/ Irigasi
						( $f.$g=='0415' && $fmHARGABARANG< 10000000 ) ||	// Instalasi
						( $f.$g=='0416' && $fmHARGABARANG< 10000000 ) ||	// Jaringan

						( $f.$g=='0517' && $fmHARGABARANG< 100000 ) ||	// Buku
						( $f.$g=='0518' && $fmHARGABARANG< 1500000 ) ||	// Bercorak Kebudayaan
						( $f.$g.$h=='051901' && $fmHARGABARANG< 10000000 ) ||	// Ternak dan Hewan
						( $f.$g.$h=='051902' && $fmHARGABARANG< 5000000 ) ||	// Tanaman

						//( $ArBarang[0]=='01' )||	//( $ArBarang[0]=='04' )||
						( $f=='06' && $fmHARGABARANG< 25000000 ) // KDP
						//( $ArBarang[0].$ArBarang[1]=='0517'  )||	//( $ArBarang[0].$ArBarang[1]=='0518'  )
						
					){
						$fmSTATUSASET = 10;//extra
					//}else if( $ArBarang[0].$ArBarang[1]=='0724'  ){									
					//	$fmSTATUSASET = 8;	//tak berwujud						
					}else{
						//$fmSTATUSASET = 3;	//intra						
						$fmSTATUSASET = $f.$g =='0724' ? 8:3; 
					}		
				}
			}			
			break;
		}		
	
		case 'PANDEGLANG' : {
			if($fmSTATUSASET !=5 && $fmSTATUSASET !=6 && $fmSTATUSASET !=7  ){//pindah tangan, tgr, pemitraan, (tidak rubah aset)
				//if($fmKONDISIBARANG==3 && ($fmSTATUSASET==3 || $fmSTATUSASET==8 || $fmSTATUSASET==9) ){ //rb otomatis
															 
				if( 
					( $f.$g=='0202' && $fmHARGABARANG< 1000000 ) ||	// Alat-alat Berat
					( $f.$g=='0203' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat Angkutan
					( $f.$g=='0204' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat bengkel dan alat ukur
					( $f.$g=='0205' && $fmHARGABARANG< 1000000 ) ||		// Alat Pertanian
					( $f.$g=='0206' && $fmHARGABARANG< 1000000 ) ||	// Alat-alat Kantor & Rumah Tangga
					( $f.$g=='0207' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat studio
					( $f.$g=='0208' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat kedokteran
					( $f.$g=='0209' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat Laboratorium
					( $f.$g=='0210' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat persenjataan


					( $f.$g=='0518' && $fmHARGABARANG< 1000000 ) ||	// Bercorak Kebudayaan
					( $f.$g.$h=='051901' && $fmHARGABARANG< 1000000 ) ||	// Ternak dan Hewan
					( $f.$g.$h=='051902' && $fmHARGABARANG< 1000000 ) ||	// Tanaman

					//( $ArBarang[0]=='01' )||	//( $ArBarang[0]=='04' )||
					( $f.$g=='0724' && $fmHARGABARANG< 25000000 ) // Aset Tak berwujud
					//( $ArBarang[0].$ArBarang[1]=='0517'  )||	//( $ArBarang[0].$ArBarang[1]=='0518'  )
					
				){
					$fmSTATUSASET = 10;//extra
				//}else if( $ArBarang[0].$ArBarang[1]=='0724'  ){									
				//	$fmSTATUSASET = 8;	//tak berwujud						
				}else{
					if($fmKONDISIBARANG==3 ){ //rb oto
						$fmSTATUSASET=9;
					}else{ //extra, intra , tdk oto						
						$fmSTATUSASET = $f.$g =='0724' ? 8:3; 
					}		
				}
			}			
			break;
		}
		case 'CIREBON_KAB' : {
			
			if($fmSTATUSASET !=5 && $fmSTATUSASET !=6 && $fmSTATUSASET !=7  ){//pindah tangan, tgr, pemitraan, (tidak rubah aset)
				//if($fmKONDISIBARANG==3 && ($fmSTATUSASET==3 || $fmSTATUSASET==8 || $fmSTATUSASET==9) ){ //rb otomatis															 
				if( 
					( $f.$g=='0202' && $fmHARGABARANG< 2500000 ) ||	// Alat-alat Berat
					( $f.$g=='0203' && $fmHARGABARANG< 1000000 ) ||		// Alat-alat Angkutan
					( $f.$g=='0204' && $fmHARGABARANG< 500000 ) ||		// Alat-alat bengkel dan alat ukur
					( $f.$g=='0205' && $fmHARGABARANG< 500000 ) ||		// Alat Pertanian
					( $f.$g.$h=='020601' && $fmHARGABARANG< 500000 ) ||	// Alat-alat Kantor 
					( $f.$g.$h=='020602' && $fmHARGABARANG< 500000 ) ||	// Alat-alat Rumah Tangga
					( $f.$g=='0207' && $fmHARGABARANG< 500000 ) ||		// Alat-alat studio
					( $f.$g=='0208' && $fmHARGABARANG< 500000 ) ||		// Alat-alat kedokteran
					( $f.$g=='0209' && $fmHARGABARANG< 500000 ) ||		// Alat-alat Laboratorium
					( $f.$g=='0210' && $fmHARGABARANG< 500000 ) ||		// Alat-alat persenjataan

					( $f.$g=='0311' && $fmHARGABARANG< 10000000 ) ||		// Gedung
					( $f.$g=='0312' && $fmHARGABARANG< 10000000 ) ||		// Monumen

					( $f=='04' && $fmHARGABARANG< 10000000 ) 		// JIJ
					
				){
					$fmSTATUSASET = 10;//extra
				//}else if( $ArBarang[0].$ArBarang[1]=='0724'  ){									
				//	$fmSTATUSASET = 8;	//tak berwujud						
				}else{ 
					if($fmKONDISIBARANG==3 ){ //rb oto
						$fmSTATUSASET=9;
					}else{ //intra / atb						
						$fmSTATUSASET = $f.$g =='0724' ? 8:3; 
					}
				}		
				
			}			
			break;
		}
		case 'BDG_BARAT' : {
			if($fmSTATUSASET !=5 && $fmSTATUSASET !=6 && $fmSTATUSASET !=7  ){//pindah tangan, tgr, pemitraan, (tidak rubah aset)
				//if($fmKONDISIBARANG==3 && ($fmSTATUSASET==3 || $fmSTATUSASET==8 || $fmSTATUSASET==9) ){ //rb otomatis
				if($fmKONDISIBARANG==3 ){ //rb oto
					$fmSTATUSASET=9;
				}else{ //extra, intra , tdk oto												 
					if( 
						( $f =='03' && $fmHARGABARANG< 10000000 ) ||
						( $f.$g=='0202' && $fmHARGABARANG< 1000000 ) ||
						( $f.$g=='0203' && $fmHARGABARANG< 1000000 ) ||
						( $f.$g=='0204' && $fmHARGABARANG< 500000 ) ||
						( $f.$g=='0205' && $fmHARGABARANG< 500000 ) ||
						( $f.$g=='0206' && $fmHARGABARANG< 500000 ) ||
						( $f.$g=='0207' && $fmHARGABARANG< 500000 ) ||
						( $f.$g=='0208' && $fmHARGABARANG< 1000000 ) ||
						( $f.$g=='0209' && $fmHARGABARANG< 500000 ) ||
						( $f.$g=='0210' && $fmHARGABARANG< 500000 ) ||
						//( $ArBarang[0]=='01' )||	//( $ArBarang[0]=='04' )||
						( $f.$g=='0519' && $fmHARGABARANG< 300000 )
						//( $ArBarang[0].$ArBarang[1]=='0517'  )||	//( $ArBarang[0].$ArBarang[1]=='0518'  )
						
					){
						$fmSTATUSASET = 10;//extra
					//}else if( $ArBarang[0].$ArBarang[1]=='0724'  ){									
					//	$fmSTATUSASET = 8;	//tak berwujud						
					}else{
						//$fmSTATUSASET = 3;	//intra						
						$fmSTATUSASET = $f.$g =='0724' ? 8:3; 
					}		
				}
			}			
			break;
		}
		case 'GARUT' : { //extra < 250000 kecuali bku (05.17), karpet (?), gorden (?)
			//if($fmKONDISIBARANG==3 && ($fmSTATUSASET==3 || $fmSTATUSASET==8 || $fmSTATUSASET==9) ){ //RB
			//	$fmSTATUSASET=9;
			//}else{		
			if($fmSTATUSASET !=5 && $fmSTATUSASET !=6 && $fmSTATUSASET !=7  ){//pindah tangan, tgr, pemitraan, (tidak rubah aset)
						
				if($fmKONDISIBARANG==3 ){ //rb oto
					$fmSTATUSASET=9;
				}else{
					if( 
						( $fmHARGABARANG >= 250000  ) ||
						( $f.$g =='0517'   ) || //buku
						( $f.$g.$h.$i.$j=='02060201046' ) || //karpet
						( $f=='01' || $f=='03' || $f=='04' || $f=='06' || $f=='07')
					){
						//$fmSTATUSASET = 3;
						$fmSTATUSASET = $f.$g =='0724' ? 8:3; 
					}else{
						$fmSTATUSASET = 10;		
					}	
				}
			}
			break;
		}
		case 'BOGOR' : {
			if($fmSTATUSASET !=5 && $fmSTATUSASET !=6 && $fmSTATUSASET !=7 && $fmSTATUSASET!=10  ){	//pindah tangan, tgr, pemitraan, (tidak rubah aset)					
				/*if($fmKONDISIBARANG==3  ){ //RB oto aset lainnya
					$fmSTATUSASET=9;
				}else{						
					if ( $fmSTATUSASET == '' ){ 
						$fmSTATUSASET = $f.$g =='0724' ? 8:3; //ATB
					}
				}*/
				//cek intra
				if( ($fmHARGABARANG < 100000 && $fmTAHUN<=2014 ) || ( $fmHARGABARANG <300000 && $fmTAHUN>2014 )  ){ //ekstra
					$fmSTATUSASET=10;
				}else if($fmKONDISIBARANG==3 ){ //aset lain
					$fmSTATUSASET=9;
				}else if( $f.$g =='0724'){
					$fmSTATUSASET = 8; //ATB
				}else{
					$fmSTATUSASET = 3; 
				}
			}
			if($f == "05")$fmSTATUSASET = 3; 
			break;
		}	
		case 'JABAR' :{
				
			if( $f=='02' && $fmHARGABARANG < 1000000 && $fmSTATUSASET <>9 && $fmTAHUN>=2015  ){
				$fmSTATUSASET =10;
			}else if( $f=='02' && $fmHARGABARANG < 500000 && $fmSTATUSASET <>9  && $fmTAHUN>=2011 ){
				$fmSTATUSASET =10;
			}else{
				if ( $fmSTATUSASET == '' || $fmSTATUSASET == '3' ||  $fmSTATUSASET == '10'){						
					$fmSTATUSASET = $f.$g =='0724' ? 8:3; 						
				}
			}
			break;
		}
		default:{//manual/otomatis default			
			/*if($Main->STASET_OTOMATIS){ 
				//setingan default kalo otomatis
				if($fmHARGABARANG >= $Main->MIN_INTRA) {
					if($fmKONDISIBARANG==3  ){
						$fmSTATUSASET=9;
					}else{
						if ( $fmSTATUSASET == '' || $fmSTATUSASET == '3' ){
							$fmSTATUSASET = $f.$g =='0724' ? 8:3; 
						}	
					}
				}else{
					$fmSTATUSASET=10;
				}
			}else{*/
				if ( $fmSTATUSASET == '' || $fmSTATUSASET == '3' ){
					$fmSTATUSASET = $f.$g =='0724' ? 8:3; 
				}	
			//}
			
			
		}
	}
			
	return $fmSTATUSASET;
}
	

?>