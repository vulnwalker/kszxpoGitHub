<?phpglobal $COrder;global $hasil_chart;global $cofmUNIT;include "viewerfnchart.php";$view->isi = file_get_contents('chart/chart.html');$progressbar='<div id="loader" style="width: 100%; border:0;" align="center" class="loadings-invisible">								<img src="images/administrator/images/loading1.gif" alt="Loading..." /></div>';$hasilcontent='<div id="hasil_content" class="loadings-invisible"></div>';$submenubar='';	$menuTab = '<div id="header"></div><table width="100%" cellspacing="0" cellpadding="0" border="0" class="menubar">	<tbody><tr><td width="40%" height="20" style="text-align: right;" class="menudottedline">	  &nbsp;</td></tr></tbody></table>	';$view->isi = str_replace('<!--menuTab-->',$menuTab,$view->isi);$view->isi = str_replace('<!--menu2-->','menuaktif',$view->isi);$view->isi = str_replace('<!--title-->'," $Main->Judul {$HTTP_COOKIE_VARS['coNama']} ",$view->isi);	$view->isi = str_replace('<!--APP_NAME-->'," $Main->APP_NAME",$view->isi);						$doCari =$_POST['doCari'];			$view->isitab = file_get_contents('chart/view_chart.html');	 //get template	$view->isitab = str_replace('<!--progressbar-->',$progressbar,$view->isitab);				//----- create option cari ----------------		$fmWIL = cekPOST("fmWIL");	$fmSKPD = $_POST['fmSKPD'];//cekPOST("fmSKPD");	$fmUNIT = cekPOST("fmUNIT");	$fmSUBUNIT = cekPOST("fmSUBUNIT");	$kode_barang = $_POST["kode_barang"];		$fmBIDANG = cekPOST("fmBIDANG");	$fmKELOMPOK =cekPOST("fmKELOMPOK"); 	$fmSUBKELOMPOK=cekPOST("fmSUBKELOMPOK");	$fmSUBSUBKELOMPOK=cekPOST("fmSUBSUBKELOMPOK"); 	$COrder=cekPOST("COrder");	$fmJChart=cekPOST("fmJChart");  	$fmthnawal=cekPOST("fmthnawal");	$fmthnakhir=cekPOST("fmthnakhir");		if (empty($fmthnawal)) $fmthnawal=date('Y');    if (empty($fmthnakhir)) $fmthnakhir=date('Y');		if ($fmthnawal>$fmthnakhir) $fmthnakhir=$fmthnawal;		if ($fmJChart=='') $fmJChart='01';	if ($COrder=='') $COrder='00';	if ($COrder=='06' || $COrder=='07' ){		if ($fmBIDANG=='00' || $fmBIDANG=='02' || $fmBIDANG=='05'){			$fmBIDANG=='01';		}	}		$fmmodelchart=cekPOST("fmmodelchart"); 	$fmstylechart=cekPOST("fmstylechart"); 			$addPageParam="&COrder=".$COrder;	$view->OptWil =	"<!--wil skpd-->	<table width=\"100%\" class=\"adminform\">	<tr>				<td width=\"100%\" valign=\"top\">						".WilSKPD1x()."		</td>		<td >			<!--labelbarang-->			 		</td>	</tr></table>";	$view->optcari =  ( getOptchart1( $doCari , $addPageParam) ); 		$view->isitab = str_replace('<!--optwil-->', $view->OptWil, $view->isitab);	$view->isitab = str_replace('<!--optcari-->', $view->optcari, $view->isitab);	$view->isitab = str_replace('<!--optchart-->', $view->optchart, $view->isitab);	$view->cari->btcari= 				'<input '.$disBtCari.' type="button" name="btcari" id="btcari" value="Tampilkan" class="button_std"				onclick="adminForm.target=\'_self\';adminForm.action=\'?Pg='.$Pg.$addPageParam.'\'; 				adminForm.doCari.value=1;								adminForm.submit();showprogress();"									>';		$view->isitab = str_replace('<!--btcari-->',$view->cari->btcari,$view->isitab);	$view->isitab = str_replace('<!--menu_bar-->',$menuBar,$view->isitab);	$view->isitab = str_replace('<!--submenu_bar-->',$submenubar,$view->isitab);			//------- proses pencarian -----------------		if($doCari == 1){	 if ($COrder=='00' || $COrder=='01' || $COrder=='02' || $COrder=='03' || $COrder=='08' || $COrder=='09' || $COrder=='10' || $COrder=='11') { $fmJChart=''; getdatachart1(); $tmpfnamex=makepiechart1(); 	 }  if ($COrder=='06' || $COrder=='07') { $fmJChart=''; getdatachart4(); $tmpfnamex=makepiechart1(); 	 }  if ($COrder=='04' || $COrder=='05' ) {  getdatachart3();  if ($fmJChart=='01')  $tmpfnamex=makebarchart1();   if ($fmJChart=='02')  $tmpfnamex=makelinechart1();   } $doCari=0;	$cari->hasil = 		"<!--menuhasil-->		<div id='hasil_content' align='center' style='width:100%;background-color:white'>		<table width='100%'><tr>$charttitle<td><div align='center' >		<img src='loaddata.php?file=".$tmpfnamex."&type=3'> </img>		</div></td></tr></table>		";if ($COrder=='88')	{$cari->hasil .= '<br></div>';} else{	$cari->hasil .= '<br>'.getdaftar1(0).'</div>';}		$cari->menubawah =		"<br><div id=\"print_content\" ><table width=\"100%\" class=\"menudottedline\">		<tr><td>			<table width=\"50\"><tr>						<td> ".PanelIcon1("javascript:printmypage();","print_f2.png","Cetak")."</td>		</tr></table>		</td></tr>		</table></div>".$cari->cek;								$view->isitab = str_replace('<!--hasilcari-->',$cari->hasil,$view->isitab);			$view->isitab = str_replace('<!--menubawah-->',$cari->menubawah,$view->isitab);						}	$view->isi = str_replace('<!--isitab-->',$view->isitab,$view->isi);	?>