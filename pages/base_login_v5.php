<?php
$thn_ = getdate();
$thn = $thn_['year'];


if($Main->DOWNLOAD_MOBILE ){
	$smartMobileLink = 
		"<tr><td align='center' style = 'height:24px'>
			<a target='' href='download.php?file=ATISISBADA_KabSrg.apk&dr=downloads&nm=ATISISBADA.apk' 	
				style='padding:8 8 8 8; color: white; 											
				font-family: tahoma, verdana, arial, sans-serif;
				font-size: 11px;' title='Download ATISISBADA Smart Mobile'><b>Download ATISISBADA Smart Mobile</a>			
		</td></tr>";
	$smartMobileLink2 = 
		
			"<a target='' href='download.php?file=".$Main->APK_FILE."&dr=downloads&nm=ATISISBADA.apk' 	
				style='padding:8 8 8 8; color: white; 											
				font-family: tahoma, verdana, arial, sans-serif;
				font-size: 11px;' title='Download ATISISBADA Smart Mobile'>
					<b>DOWNLOAD MANTAP SMART MOBILE
			</a>			
		";
}

if($Main->MENU_VERSI == 2){
$Main->Base = "	
	<html>
<head>
<title>:: MANTAP</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<style type=\"text/css\">
body {
	background-color: #496887;
	background-image: url(images2/index_01.jpg);
	background-repeat: no-repeat;
	background-position:center;
	background-position:top;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
	color: #FFFFFF;
}
text {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
	color: #666
}
</style>
<script type=\"text/javascript\">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf(\"#\")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf(\"?\"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
</head>
<body bgcolor=\"#FFFFFF\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" onLoad=\"MM_preloadImages('images2/index_17.png','images2/bt_login2.png')\">
<!-- Save for Web Slices (menu mantap_slice latar.psd) -->
<table width=\"1300\" height=\"739\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" id=\"Table_01\">
	<tr>
		<td align=\"center\" valign=\"top\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
		  <tr>
		    <td align=\"center\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		      <tr>
		        <td width=\"158\">&nbsp;</td>
		        <td width=\"313\"><img src=\"images2/index_02.png\" width=\"313\" height=\"171\"></td>
		        <td width=\"363\">&nbsp;</td>
		        <td width=\"339\" align=\"right\"><img src=\"images2/index_04.png\" width=\"399\" height=\"171\"></td>
		        <td width=\"67\">&nbsp;</td>
	          </tr>
	        </table></td>
	      </tr>
		  <tr>
		    <td align=\"center\">
			
			
			
			<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		      <tr>
		        <td width=\"158\">&nbsp;</td>
		        <td width=\"313\">&nbsp;</td>
		        <td width=\"363\">&nbsp;</td>
		        <td width=\"339\" align=\"right\">
				
				<form name=\"login_form\" id=\"login_form\" method=\"post\" action=\"index.php?Pg=LogIn\" >
				<table width=\"361\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		          <tr>
		            <td><img src=\"images2/login_03.png\" width=\"361\" height=\"54\"></td>
		            </tr>
		          <tr>
		            <td height=\"177\" background=\"images2/login_05.png\">
					
					
					
					<table width=\"80%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"6\">
		              <tr>
		                <td width=\"15%\" valign=\"middle\"><p><img src=\"images2/administrator.png\" width=\"22\" height=\"22\"></p></td>
		                <td width=\"85%\" valign=\"middle\"><p>
		                  <input name=\"user\" type=\"text\" id=\"user\" value=\"\" size=\"35\"  border=\"\" placeholder='Username'>
		                </p></td>
		                </tr>
		              <tr>
		                <td valign=\"middle\">&nbsp;</td>
		                <td valign=\"middle\">&nbsp;</td>
		                </tr>
		              <tr>
		                <td valign=\"middle\"><img src=\"images2/lock.png\" width=\"22\" height=\"22\"></td>
		                <td valign=\"middle\"><input name=\"password\" type=\"password\" id=\"password\" 
							value=\"\" size=\"35\"  border=\"\" placeholder='password'></td>
		                </tr>
		              <tr>
		                <td valign=\"middle\">&nbsp;</td>
		                <td valign=\"middle\">&nbsp;</td>
		                </tr>
		              <tr>
		                <td valign=\"middle\"><img src=\"images2/tear_off_calendar.png\" width=\"22\" height=\"22\"> |</td>
		                <td valign=\"middle\"><input name=\"thn\" type=\"text\" id=\"thn\" value=\"$thn\" 
							size=\"35\"  border=\"\"></td>
		                </tr>
		              </table>
					  
					  
					  </td>
		            </tr>
		          <!--
				  <tr>
		            <td width=\"361\">
					
						<a href=\"index.html\" onMouseOut=\"MM_swapImgRestore()\" 
							onMouseOver=\"MM_swapImage('bt_login','','images2/bt_login2.png',1)\">
								<img src=\"images2/bt_login1.png\" width=\"361\" height=\"47\" id=\"bt_login\">
						</a>
					</td>
										
		            </tr>
					-->
					
					
					<tr>
					<td>
						<input type=\"image\" src=\"images2/bt_login1.png\" 
						name=\"bt_ok\" width=\"361\" height=\"47\"  border=\"0\" id=\"bt_ok\" 
						onmouseover=\"MM_swapImage('bt_ok','','images2/bt_login2.png',1)\" onmouseout=\"MM_swapImgRestore()\">
					
					</td>
					</tr>
	            </table>
				</form>
				
				
				</td>
		        <td width=\"67\">&nbsp;</td>
	          </tr>
	        </table>		      <p>&nbsp;</p></td>
	      </tr>
		  <tr>
		    <td align=\"center\">&nbsp;</td>
	      </tr>
	    </table></td>
	</tr>
	<tr>
		<td height=\"35\" align=\"center\" valign=\"middle\" bgcolor=\"#201736\">
		
		<!--DOWNLOAD BUKU PETUNJUK MANTAP | DOWNLOAD MANTAP SMART MOBILE -->
		
		<a target='' href='download.php?file=".$Main->ManualBook."&dr=downloads&nm=".$Main->ManualBook."' 	
						style='padding:8 8 8 8; color: white; 											
						font-family: tahoma, verdana, arial, sans-serif;
						font-size: 11px;' title='Download Buku Petunjuk'><b>DOWNLOAD BUKU PETUNJUK MANTAP 
			</a>
		| 
		$smartMobileLink2 
		</td>
	</tr>
	<tr>
		<td height=\"24\" bgcolor=\"#302948\">
		<!--
		<marquee scrollamount=3>MANTAP (Mobile Asset Management Aplication) Kota Bandung | 
		Dinas Pengelolaan Keuangan dan Aset Daerah Kota Bandung
		</marquee>
		-->
		
		<marquee scrollamount=\"3\" >".
		  $Main->CopyRight_isi.
		"</marquee>
		
		</td>
	</tr>
</table>
<!-- End Save for Web Slices -->
</body>
</html>
 ";
	
}
else{
	


$Main->Base = "
	<html>
	<head>
	<title><!--JUDUL--></title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
	<meta name='format-detection' content='telephone=no' />
	<META NAME='ROBOTS' CONTENT='NOINDEX, NOFOLLOW' />
	$Main->HeadStyleico
	<script type=\"text/javascript\" language=\"JavaScript\" src=\"js/ajax.js\"></script>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
   <link href='css/full-slider.css' rel='stylesheet'>
      <link rel='stylesheet' href='css/style.css'>
  <link href='vendor/bootstrap/css/bootstrap.min.css' rel='stylesheet'>
	<script type='text/javascript'>
	<!--

	function MM_preloadImages() { //v3.0
	  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
		var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
		if (a[i].indexOf(\"#\")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
	}

	function MM_swapImgRestore() { //v3.0
	  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
	}

	function MM_findObj(n, d) { //v4.01
	  var p,i,x;  if(!d) d=document; if((p=n.indexOf(\"?\"))>0&&parent.frames.length) {
		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	  if(!x && d.getElementById) x=d.getElementById(n); return x;
	}

	function MM_swapImage() { //v3.0
	  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
	   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
	}

	function cekEnableJs() {
					if(window.opener) window.opener.close();
					document.getElementById('login').style.display = '';
				}
	//-->
	</script>
	</head>
	<body>

	 <div id='carouselExampleIndicators' class='carousel slide' data-ride='carousel'>

        <ol class='carousel-indicators'>
          <li data-target='#carouselExampleIndicators' data-slide-to='0' class='active'></li>
          <li data-target='#carouselExampleIndicators' data-slide-to='1'></li>
          <li data-target='#carouselExampleIndicators' data-slide-to='2'></li>
        </ol>

        <div class='carousel-inner' role='listbox'>
        <div style='margin-bottom: -659px;width: 100%;'> 
        <div class='container'>
  <div class='info'>
    <h1> </h1>
  </div>
</div>
<div class='form'>
<img src='images/logos.png' style='width:100%'/>
  <form class='login-form' name=\"login_form\" id=\"login_form\" method=\"post\" action=\"index.php?Pg=LogIn\" >
  <input type=\"text\" name=\"user\" id=\"user\" value=\"\" placeholder='Username'>
  <input type=\"password\" name=\"password\" id=\"password\" value=\"\" AUTOCOMPLETE='off' placeholder='Password'>
   <div class='row'>
    <div class='col-md-6 col-xs-12'>
      <input name=\"bt_ok\" id=\"bt_ok\" class='btn btn-info' type='submit' value='Login' style='
    background: #00a1ff;
'>
    </div>
    <div class='col-md-6 col-xs-12'>
      <input name=\"bt_cancel\" id=\"bt_cancel\" class='btn btn-danger' type='submit'  value='Cancel' style='
    background: #f3384a;
'>
    </div>
     </div>
    <p class='message'> <a href='#'></a></p>
  </form>
</div>
</div>
          <!-- Slide One - Set the background image for this slide in the line below -->
          <div class='carousel-item active' style='background-image: url(images/banner2.jpg)'>
            <div class='carousel-caption d-none d-md-block'>
            </div>
          </div>
          <!-- Slide Two - Set the background image for this slide in the line below -->
          <div class='carousel-item' style='background-image: url(images/banner1.jpeg)'>
            <div class='carousel-caption d-none d-md-block'>
            </div>
          </div>
          <!-- Slide Three - Set the background image for this slide in the line below -->
          <div class='carousel-item' style='background-image: url(images/banner3.png)'>
            <div class='carousel-caption d-none d-md-block'>
            </div>
          </div>
        </div>
      </div>



	</body>
	 <script src='vendor/jquery/jquery.min.js'></script>
    <script src='vendor/popper/popper.min.js'></script>
    <script src='vendor/bootstrap/js/bootstrap.min.js'></script>
    <script  src='js/index.js'></script>
	</html>
";
}

?>