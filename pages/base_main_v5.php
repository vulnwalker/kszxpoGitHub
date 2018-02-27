<?php

//include ('/pages/menubar_kanatas.php');//menu bar kanan atas

switch($Pg) //gambar header
{
  case "01":$Main->ImageLeft="tempate_01.gif";break;
  case "02":$Main->ImageLeft="pengadaan_01.gif";break;
  case "03":$Main->ImageLeft="penerimaan_01.gif";break;
  case "04":$Main->ImageLeft="penggunaan_01.gif";break;
  case "05":$Main->ImageLeft="penatausahaan_01.gif";break;
  case "06":$Main->ImageLeft="pemanfaatan_01.gif";break;
  case "07":$Main->ImageLeft="pengamanan_01.gif";break;
  case "08":$Main->ImageLeft="penilaian_01.gif";break;
  case "09":$Main->ImageLeft="penghapusan_01.gif";break;
  case "10":$Main->ImageLeft="pemindahtanganan_01.gif";break;
  case "11":$Main->ImageLeft="pembiayaan_01.gif";break;
  case "12":$Main->ImageLeft="tuntunan_01.gif";break;
  case "13":$Main->ImageLeft="pengawasan_01.gif";break;
  case "ref":$Main->ImageLeft="masterData_01.gif";break;
  case "Admin":$Main->ImageLeft="administrasi_01.gif";break;
  case "15":$Main->ImageLeft="penggunaan_01.gif";break;

}
$chatPage='?Pg=Menu&SPg=01';//'?Pg=Admin&SPg=04';
//$chatPage = '';
$chat_menu=
  "<div style='margin:0 4 0 4;width:24;height:24;float:right;position:relative'>
            <a id='chat_alert' style='background: no-repeat url(images/administrator/images/message_24_off.png);
                  width:24;height:24;display: inline-block;position:absolute'
                 target='_blank' href='$chatPage' title='Chat' >
            </a>
  </div>";
//$chat_menu="";

$sql_system = mysql_query("SELECT * from menu_bar where status = 1 and level = 1 order by concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))");
  while ($data_system = mysql_fetch_array($sql_system)) {
$nama_level1 = $data_system['title'];

$sql_system_modul = mysql_query("SELECT * from menu_bar where status = 1 and level = 2 and upline = '".$data_system['id']."' order by concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))");


  while ($data_system_modul = mysql_fetch_array($sql_system_modul)) {

      $sql_lvl3 = mysql_query("SELECT * from menu_bar where status = 1 and level = 3 and upline = '".$data_system_modul['id']."'  order by concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2)) ");

      while ($data_lvl3 = mysql_fetch_array($sql_lvl3)) {

        $sql_lvl4 = mysql_query("SELECT * from menu_bar where status = 1 and level = 4 and upline = '".$data_lvl3[id]."' order by concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2)) ");

          while ($data_lvl4 = mysql_fetch_array($sql_lvl4)) {

            $sql_lvl5 = mysql_query("SELECT * from menu_bar where status = 1 and level = 5 and upline = '".$data_lvl4[id]."' order by concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))");

              while ($data_lvl5 = mysql_fetch_array($sql_lvl5)) {

                $sql_lvl6 = mysql_query("SELECT * from menu_bar where status = 1 and level = 6 and upline= '".$data_lvl5[id]."' order by concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))");

                  while ($data_lvl6 = mysql_fetch_array($sql_lvl6)) {
                    $sub6.="
                      <li id='lim'>
                        <a href='$data_lvl6[url]' id='afont' style='font-family: $fontMenubar[option_value]'>$data_lvl6[title]</a>
                      </li>
                    ";
                  }
                  if (mysql_num_rows(mysql_query("SELECT * from menu_bar where status = 1 and upline = '".$data_lvl5['id']."' "))!=0) {
                    $sub5.="
                  <li class='dropdown-submenu'>
                    <a href='$data_lvl5[url]' id='afont' style='font-size: $dropdownFontSize[option_value]px; font-family: $fontMenubar[option_value]'>$data_lvl5[title]</a>
                    <ul class='dropdown-menu' style='padding-top:0; padding-bottom:0; margin-top:0;'>
                      ".$sub6."
                    </ul>
                  </li>
                ";
                  }else{
                    $sub5.="
                  <li id='lim'>
                    <a href='$data_lvl5[url]' id='afont' style='font-size: $dropdownFontSize[option_value]px; font-family: $fontMenubar[option_value]'>$data_lvl5[title]</a>
                    <ul>
                      ".$sub6."
                    </ul>
                  </li>
                ";
                  }
                  $sub6="";
              }
              if (mysql_num_rows(mysql_query("SELECT * from menu_bar where status = 1 and upline = '".$data_lvl4['id']."' "))!=0) {
                  $sub4.="
                    <li class='dropdown-submenu'>
                      <a href='$data_lvl4[url]' id='afont' style='font-size: $dropdownFontSize[option_value]px; font-family: $fontMenubar[option_value]'>$data_lvl4[title]</a>
                      <ul class='dropdown-menu' style='padding-top:0; padding-bottom:0; margin-top:0;'>
                        ".$sub5."
                      </ul>
                    </li>
                  ";
                }else{
                  $sub4.="
                    <li id='lim'>
                      <a href='$data_lvl4[url]' id='afont' style='font-size: $dropdownFontSize[option_value]px; font-family: $fontMenubar[option_value]'>$data_lvl4[title]</a>
                      <ul>
                        ".$sub5."
                      </ul>
                    </li>
                  ";
                }
                $sub5="";
          }
        if (mysql_num_rows(mysql_query("SELECT * from menu_bar where status = 1 and upline = '".$data_lvl3['id']."' ")) != 0) {
          $sub.="
            <li class='dropdown-submenu'>
              <a href='$data_lvl3[url]' class=dropdown-toggle' id='afont' style='font-size: $dropdownFontSize[option_value]px; font-family: $fontMenubar[option_value]'>$data_lvl3[title]</a>
                <ul class='dropdown-menu' style='padding-top:0; padding-bottom:0; margin-top:0;'>
                  ".$sub4."
                </ul>
            </li>
          ";
        }else{
          $sub.="
            <li id='lim'>
              <a href='$data_lvl3[url]' id='afont' style='font-size: $dropdownFontSize[option_value]px; font-family: $fontMenubar[option_value]' class=dropdown-toggle'>$data_lvl3[title]</a>
              ".$sub4."
            </li>
          ";
        }
$sub4 = "";
      }

      // $urllvl2 = $data_system_modul['url'];
      $dropdownFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'dropdown_font_size' "));
      if (mysql_num_rows(mysql_query("SELECT * from menu_bar where status = 1 and upline = '".$data_system_modul['id']."' ")) != 0) {
        $systemModul.="
      <li class='dropdown dropdown-submenu'>
        <a href='$data_system_modul[url]' id='afont' style='font-family: $fontMenubar[option_value]; font-size: $dropdownFontSize[option_value]px;'>$data_system_modul[title]</a>
        <ul class='dropdown-menu' style='padding-top:0; padding-bottom:0; margin-top:0;'>
          ".$sub."
        </ul>
      </li>";
      }else{

      $systemModul.="
      <li id='lim'>
        <a href='$data_system_modul[url]' id='afont' style='font-family: $fontMenubar[option_value]; font-size: $dropdownFontSize[option_value]px;'>$data_system_modul[title]</a>
      </li>";

      }

$sub = "";
  }


  $sql_grup = mysql_fetch_array(mysql_query("SELECT * from shortcut"));
  $sql_shortt = mysql_fetch_array(mysql_query("SELECT * from grup where id = '".$sql_grup[grup]."' "));
  $menubarFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'menubar_font_size' "));

  if (mysql_num_rows(mysql_query("SELECT * from menu_bar where status = 1 and upline = '".$data_system['id']."' ")) != 0) {
    $system.="
  <li class='dropdown' style='margin-right:1%;'>
  <a href='$data_system[url]' class='dropdown-toggle' id='afont' style=' font-size: $menubarFontSize[option_value]px ; color: $colorTextMenubar[option_value]; font-weight: 100; text-decoration: none; padding:0; font-family: $fontMenubar[option_value]'>$nama_level1<b class='caret'></b></a>
  <ul class='dropdown-menu' style='padding-top:0; padding-bottom:0; margin-top:0%;'>
    $systemModul
  </ul>
  </li>";
  }else{
    $system.="
  <li class='dropdown' style='margin-right:1%;'>
  <a href='$data_system[url]' class='dropdown-toggle' id='afont' style=' font-size: $menubarFontSize[option_value]px ; color: $colorTextMenubar[option_value]; font-weight: 100; text-decoration: none; padding:0; font-family: $fontMenubar[option_value]'>$nama_level1</a>
  <ul class='dropdown-menu' style='padding-top:0; padding-bottom:0; margin-top:0%;'>
    $systemModul
  </ul>
  </li>";
  }



  $systemModul = "";

}
$contentBackground = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'background_content' "));
if (!isset($_GET['grup'])) {
  // $container = "
  //   <div class='panel' style='margin-bottom:8%; background-color: $contentBackground[option_value]'>
  //     TEST
  //   </div>";
}else{

  $header_name = mysql_fetch_array(mysql_query("SELECT * from grup where id = '".$_GET['grup']."' "));
  $asd = $header_name[title];
  $idgrup = $header_name[id];
  // $getMax = mysql_fetch_array(mysql_query("SELECT * from setting_kolom"));
  $maxRow = $header_name[max_row];
  $maxKolom = $header_name[max_kolom];

  for ($rowNumber=1; $rowNumber <= $maxRow; $rowNumber++) {
    // $getKolom = mysql_query("SELECT * from shortcut where row = '$rowNumber' and grup = '$idgrup' ");
    // while ($kolomNumber = mysql_fetch_array($getKolom)) {
      for ($kolomNumber=1; $kolomNumber <= $maxKolom ; $kolomNumber++) {
        $getKolom = mysql_fetch_array(mysql_query("SELECT * from shortcut where row = '$rowNumber' and kolom = '$kolomNumber' and status = '1' and grup = '$idgrup' "));
      $shortimg = mysql_fetch_array(mysql_query("SELECT * from shortcut"));
      $aktif = mysql_fetch_array(mysql_query("SELECT * from images where id = '$getKolom[image_aktif]' "));
      $aktif_k = mysql_fetch_array(mysql_query("SELECT * from images_kategori where id = '$aktif[kategori]' "));

      $pasif = mysql_fetch_array(mysql_query("SELECT * from images where id = '$getKolom[image_pasif]' "));
      $pasif_k = mysql_fetch_array(mysql_query("SELECT * from images_kategori where id = '$pasif[kategori]' "));
      $rrr = mysql_fetch_array(mysql_query("SELECT * from shortcut where id = '$getKolom[id]' "));

      $shortcutContentFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutContentFontSize' "));
      $shortcutContentFontColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutContentFontColor' "));
      $shortcutContentFontType = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutContentFontType' "));
      $tableBorderColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'tableBorderColor' "));
      $tableBorderSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'tableBorderSize' "));

      if (empty($rrr['image_pasif']) && mysql_num_rows(mysql_query("SELECT * from shortcut where row = '$rowNumber' and kolom = '$kolomNumber' and status = '1' and grup = '$idgrup'"))!=0) {
        $fileLocationPasif = "Media/default.png";
        $imagePasif = "  <img src='$fileLocationPasif' class='top' style='width: $header_name[height]px; height: $header_name[height]px;'>
        
          ";
      }elseif(mysql_num_rows(mysql_query("SELECT * from shortcut where row = '$rowNumber' and kolom = '$kolomNumber' and status = '1' and grup = '$idgrup'"))==0){
          $imagePasif = "";
      }else{
        $fileLocationPasif = "Media/images/$pasif_k[nama]/$pasif[directory]";
        $imagePasif = "  <img src='$fileLocationPasif' class='top' style='width: $header_name[height]px; height: $header_name[height]px;'>
        
          ";
      }

      if (empty($rrr['image_aktif']) && mysql_num_rows(mysql_query("SELECT * from shortcut where row = '$rowNumber' and kolom = '$kolomNumber' and status = '1' and grup = '$idgrup'"))!=0 ) {
        $fileLocationAktif = "Media/default.png";
        $imageAktif = "<img src='$fileLocationAktif' class='bottom' style='width: $header_name[height]px; height: $header_name[height]px;'>
            ";
      }elseif(mysql_num_rows(mysql_query("SELECT * from shortcut where row = '$rowNumber' and kolom = '$kolomNumber' and status = '1' and grup = '$idgrup'"))==0){
          $imageAktif = "";
      }else{
        $fileLocationAktif = "Media/images/$aktif_k[nama]/$aktif[directory]";
        $imageAktif = "<img src='$fileLocationAktif' class='bottom' style='width: $header_name[height]px; height: $header_name[height]px;'>
            ";
      }
    if (empty($imageAktif) && empty($imagePasif)) {
      
    }else{
      $kolomIsi.="
      <td style='border: $tableBorderSize[option_value]px solid $tableBorderColor[option_value];'>
        <a href='$getKolom[url]' style='font-family: $fontMenubar[option_value]; text-decoration: none;'>
          <div id='cf'>
            $imageAktif
            $imagePasif
            <p id='contentShortcut' style='margin-left: 55px; padding-top: 7px; font-family: $shortcutContentFontType[option_value]; color: $shortcutContentFontColor[option_value]; font-size: $shortcutContentFontSize[option_value]px;'>
              $getKolom[title]
            </p>
          </div>
        </a>
      </td>
   ";
    }
    
      }

    // }
      $rowIsi.="
        <tr>
          $kolomIsi
        </tr>
      ";
      $kolomIsi="";
  }
  $fontMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'font_menu_bar' "));
  $navFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'navFontSize' "));
  $shortcutFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'fontSizeShortcut' "));
  $shortcutFontColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutFontColor' "));
  $shortcutFontType = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutFontType' "));
  $tableBackgroundColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'tableBackgroundColor' "));
  $container = "
    <p style='font-weight: bold; font-size: $shortcutFontSize[option_value]px; color: $shortcutFontColor[option_value]; font-family: $shortcutFontType[option_value]; margin-top: 1%;'>$asd</p>

    <table class='table table-bordered' style='background-color: $tableBackgroundColor[option_value]; margin-top: unset; border: unset;'>
    <tbody>
      $rowIsi
    </tbody>
  </table>
  ";

}

$footer = mysql_query("SELECT * from footer");
while ($data_footer = mysql_fetch_array($footer)) {
  $idFooter = $data_footer['id'];
      $footerPasif = mysql_fetch_array(mysql_query("SELECT * from images where id = '$data_footer[image_pasif]' "));

      $footerPasifk = mysql_fetch_array(mysql_query("SELECT * from images_kategori where id = '$footerPasif[kategori]' "));

      $footerAktif = mysql_fetch_array(mysql_query("SELECT * from images where id = '$data_footer[image_aktif]' "));

      $footerAktifk = mysql_fetch_array(mysql_query("SELECT * from images_kategori where id = '$footerAktif[kategori]' "));
      $rrrr = mysql_fetch_array(mysql_query("SELECT * from footer where id = '$data_footer[id]' "));
      if ($rrrr['image_pasif'] != "") {
        $footerLocationPasif = "Media/images/$footerPasifk[nama]/$footerPasif[directory]";
      }else{
        $footerLocationPasif = "Media/default.png";
      }

      if ($rrrr['image_aktif'] != "") {
        $footerLocationAktif = "Media/images/$footerAktifk[nama]/$footerAktif[directory]";
      }else{
        $footerLocationAktif = "Media/default.png";
      }
$footerFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'footer_font_size' "));
  $footer2.="
      <a href='$data_footer[url]' target='_blank' style='font-size: $navFontSize[option_value]px; color:white; font-family: $fontMenubarr[option_value]; text-decoration: none;' id='afontFooter'>
      <img src='$footerLocationPasif' id='imgBrand$idFooter' style='width:32px; height:32px; margin-right:10px;'>
      $data_footer[title]</a>

  <script type='text/javascript'>
    $('#imgBrand$idFooter') .mouseover(function () {
    this.src= '$footerLocationAktif'
    }).mouseout(function () {
    this.src= '$footerLocationPasif'
    });
  </script>
  ";
}
$image = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_logo' ")); //die("SELECT * from images where id = $image[option_value]");
$image2 = mysql_fetch_array(mysql_query("SELECT * from images where id = $image[option_value] ")); //die("SELECT * from images_kategori where id = $image2[kategori] ");
$image3 = mysql_fetch_array(mysql_query("SELECT * from images_kategori where id = $image2[kategori] "));
$site_title = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'site_title' "));
$header_title = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_title' "));
$header_color = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_color' "));
$menu_bar_color = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'menu_bar_color' "));
$site_url = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'site_url' "));
$footer_color = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'footer_color' "));
$footer_text = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'footer_text' "));
$copyright_color = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'copyright_color' "));
$copyright_title = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'copyright_title' "));
$fontFamily = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'font_style' "));
$headerHeight = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_height' "));
$headerTextColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_text_color' "));
$heightLogo = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'height_logo' "));
$widthLogo = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'width_logo' "));
$footerColorHover = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'footerColorHover' "));

$colorTextMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'font_color_menubar' "));
$warnaGarisBawah = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'color_border_menubar' "));
$heightMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'height_menubar' "));
$hoverMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'hoverMenubar' "));
$shortcutContentFontColorHover = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutContentFontColorHover' "));


$colorHoverMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'color_hover_menubar' "));

$getDisplayDateTime = mysql_fetch_array(mysql_query("select * from general_setting where option_name = 'date_visible'"));
if($getDisplayDateTime['option_value'] == 'false'){
  $displayDateTime = "none";
}

$getDisplayMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'show_menu_bar' "));
if ($getDisplayMenubar['option_value'] == 'false') {
  $displayMenubar = "none";
}

$getDisplayFooter = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'copyright_visible' "));
if ($getDisplayFooter['option_value'] == 'false') {
  $displayFooter = "none";
}

$getDisplayFooter2 = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'footer_visible' "));
if ($getDisplayFooter2['option_value'] == 'false') {
  $displayFooter2 = "none";
}

$favicon = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'site_image' "));
$faviconi = mysql_fetch_array(mysql_query("SELECT * from images where id = '".$favicon[option_value]."' "));
$faviconk = mysql_fetch_array(mysql_query("SELECT * from images_kategori where id = '".$faviconi[kategori]."' "));

$contentImage = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'content_image' "));
$contentImagei = mysql_fetch_array(mysql_query("SELECT * from images where id = '".$contentImage[option_value]."' "));
$contentImagek = mysql_fetch_array(mysql_query("SELECT * from images_kategori where id = '".$contentImagei[kategori]."' "));

$ContentFontStyle = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'content_font_style' "));

$dropdownBackground = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'dropdown_background_color' "));
$headerFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_font_size' "));

$headerImage = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_image'"));
$headerImagei = mysql_fetch_array(mysql_query("SELECT * from images where id = '".$headerImage[option_value]."' "));
$headerImagek = mysql_fetch_array(mysql_query("SELECT * from images_kategori where id = '".$headerImagei[kategori]."' "));

$footerImage = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'footer_image' "));
$footerImagei = mysql_fetch_array(mysql_query("SELECT * from images where id = '".$footerImage[option_value]."' "));
$footerImagek = mysql_fetch_array(mysql_query("SELECT * from images_kategori where id = '".$footerImagei[kategori]."' "));
$Menuv5->style = "
  <link rel='shortcut icon' href='Media/images/$faviconk[nama]/$faviconi[directory]' type='image/x-icon' />
  <link href='http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css' rel='stylesheet'>
  <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  <link rel='stylesheet' type='text/css' href='js/popUp.css'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$shortcutFontType[option_value]'>
  <style type='text/css'>

  @media (min-width: 979px) {
              ul.nav li.dropdown:hover > ul.dropdown-menu {
                    display: block;
                    margin-top:0px;
              }
            }

.navbar-inverse .nav li.dropdown>.dropdown-toggle .caret {
     border-top-color: unset;
     border-bottom-color: unset;
}
.navbar .nav li.dropdown>.dropdown-toggle .caret {
     border-top-color: unset;
     border-bottom-color: unset;
}
.navbar .nav .dropdown-toggle .caret {
     margin-top: unset;
}
.nav .dropdown-toggle .caret {
     border-top-color: unset;
     border-bottom-color: unset;
     margin-top: unset;
}
.dropdown .caret {
    margin-top: unset;
    margin-left: 5px;
}
.dropdown-submenu>a:after{
  border-left-color: #fff;
}
.dropdown-submenu {
  position:relative;
  background-color: $dropdownBackground[option_value]
}
.dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus, .dropdown-submenu:hover>a, .dropdown-submenu:focus>a{
    background-image: linear-gradient(to bottom, $hoverMenubar[option_value], $hoverMenubar[option_value]);
    background-repeat: repeat-x;
    color: $colorHoverMenubar[option_value]!important;
}
#contentShortcut:hover{
  color: $shortcutContentFontColorHover[option_value]!important;
}




.thumbnail.right-caption > img {
    float: left;
    margin-right: 9px;
    border: 1px solid silver;
    padding: 1%;
}

.thumbnail.right-caption {
    border: none;
}

.thumbnail.right-caption > .caption {
    padding: 4px;
}

.glyphicon{
  margin-right: 10px;
}

.container{
  font-family: ".str_replace("+", ' ', $ContentFontStyle[option_value]).";
}

#afontNav{
  font-family: ".str_replace('+', ' ', $fontFamily[option_value]).";
  font-size: 15px;
  text-decoration: none;
  color: black;
}

#afontNav:hover{
  text-decoration: none;
}

#afont{
  font-family: ".str_replace('+', ' ', $fontMenubar[option_value]).";
  color: $colorTextMenubar[option_value];
}

#afont:hover{
  color: $colorHoverMenubar[option_value];
}

#lim{
  background-color: $dropdownBackground[option_value];
}



.thumbnail .caption {
    padding: 9px;
    color: #333;
    margin-left: 35%;
}

#cf {
  position:relative;
  margin:0 auto;
}

#cf img {
  position:absolute;
  left:0;
  -webkit-transition: opacity 1s ease-in-out;
  -moz-transition: opacity 1s ease-in-out;
  -o-transition: opacity 1s ease-in-out;
  transition: opacity 1s ease-in-out;
}

#cf img.top:hover {
  opacity:0;
}
// body{
//   background-image: url('Media/images/$contentImagek[nama]/$contentImagei[directory]');
//   background-size: cover;
//   background-repeat: no-repeat;
// }

#isikonten{
  background-image: url('Media/images/$contentImagek[nama]/$contentImagei[directory]');
  background-size: 100% 100%;
  background-repeat: no-repeat;
  height: 700px;
  min-height: 0px;
  max-height: 1000px;
  margin-top: -1.5%;
}
#header{
  background-image: url('Media/images/$headerImagek[nama]/$headerImagei[directory]');
  background-size: 100% $headerHeight[option_value]px;
  background-repeat: no-repeat;
  background-color: $header_color[option_value];
}
#footer{
  background-color: $footer_color[option_value];
  background-image: url('Media/images/$footerImagek[nama]/$headerImagei[directory]');
  background-size: 100% 40px;
  background-repeat: no-repeat;
}
#remix:before{
  content: '';
  display: inline-block;
  border-left: 7px solid transparent;
  border-right: 7px solid transparent;
  border-bottom: 7px solid #ccc;
  border-bottom-color: rgba(0, 0, 0, 0.2);
  position: absolute;
  top: -7px;
  left: 139px;
}
#remix:after{
  content: '';
  display: inline-block;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-bottom: 6px solid #ffffff;
  position: absolute;
  top: -6px;
  left: 140px;
}
#afontFooter:hover{
  color: $footerColorHover[option_value]!important;
}

}

  </style>
  ";

$Menuv5->script = "
<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>
";

$Menuv5->script2 = "
<script type='text/javascript'>


function getdate(){

      var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      var hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
      var poe = new Date().getDay();
var date = new Date();
var day = date.getDate();
var month = date.getMonth();
var yy = date.getYear();
var year = (yy < 1000) ? yy + 1900 : yy;

            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
             if(s<10){
                 s = '0'+s;
             }


            $('.clock').text(hari[poe - 1] +', '+ day + ' ' + months[month] + ' ' + year +'  '+h+' : '+m+' : '+s);
              setTimeout(function(){getdate()}, 500);
            }


getdate();

</script>

<script>
  function logout(){
    window.location.href='?Pg=LogOut';
  }
</script>
<script type='text/javascript' src='js/posting.js' language='JavaScript' ></script>

";

$Menuv5->Nav1 = "
<nav class='navbar navbar-inverse' id='header' style='border: none; border-radius: 0; margin-bottom: 0; min-height: 8px; height: $headerHeight[option_value]px;'> <!-- navbar-default -->

    <div class='container-fluid'>

      <table style='width:100%;'>
          <tr>
            <th style='height: $headerHeight[option_value]px; width:50px;'>
              <img src='Media/images/$image3[nama]/$image2[directory]' style='width:$widthLogo[option_value]px; height:$heightLogo[option_value]px;'>
            </th>
            <th style='height: $headerHeight[option_value]px;'>
              <a href='$site_url[option_value]' id='afontNav' style='color: $headerTextColor[option_value]; font-weight: bold; font-size:$headerFontSize[option_value]px;'>$header_title[option_value]</a>
            </th>
            <th style='height: $headerHeight[option_value]px;'>
              <a class='clock' style='display:$displayDateTime;   color:$headerTextColor[option_value]; float:right;'></a>
            </th>
            <th style='height: $headerHeight[option_value]px; width: 200px;'>
            <ul class='nav navbar-nav' style='float:right;'>
              <li class='dropdown'>
              <span class='pull-right'>
                <img src='assets/images/username.png'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' id='afontNav' style='color: $headerTextColor[option_value]; font-weight: bold; text-decoration: none;'>".$_COOKIE['coID']."<b class='caret'></b></a>
              </span>
              <ul class='dropdown-menu dropdown-menu-right' id='remix'>
                <li><a href='#' id='afontNav'>Ganti Password</a></li>
                <li><a href='#' id='afontNav'>Tambah Photo</a></li>
                <li><a href='pages.php?Pg=generalSetting' target='_blank' id='afontNav'>Development</li>
                <li><a href='#' onclick='logout()' id='afontNav'>Keluar</a></li>
              </ul>
              </li>
            </ul>

            </th>
          </tr>
      </table>

    </div>
  </nav>
";

$Menuv5->Nav2 = "
<nav class='navbar navbar-inverse' style='background-color: $menu_bar_color[option_value]; border: none; border-radius: 0; min-height: 8px; height: $heightMenubar[option_value]px; border-bottom: 3px solid $warnaGarisBawah[option_value]; display: $displayMenubar'> <!-- navbar-default -->

    <div class='container-fluid'>

      <table style='width:100%;'>
          <tr>
            <th style='height: $heightMenubar[option_value]px;'>
              <ul class='nav navbar-nav' style='width:100%;'>
                ".$system."
              </ul>
            </th>
          </tr>
      </table>

    </div>
  </nav>
";

$Menuv5->footer1 = "
<footer class='navbar-default navbar-fixed-bottom' style='background-color: $copyright_color[option_value]; margin-bottom: 2.5%; display: $displayFooter'>
    <div class='container-fluid'>
      <span class='text-muted'>
        <h5 style='color: white; font-size: $footerFontSize[option_value]px;'>
          <marquee>$copyright_title[option_value]</marquee>
        </h5>
      </span>
    </div>
  </footer>
";



$Menuv5->footer2 = "
<footer class='navbar-default navbar-fixed-bottom' id='footer' style='display:$displayFooter2;'>
    <div class='container-fluid'>
      <table style='width:100%;'>
        <tr>
          <th style='width:50%;'>
            <h5 style='color: white; font-size: $footerFontSize[option_value]px;'>
              $footer_text[option_value]
            </h5>
          </th>

          <th style='width:50; text-align:right;'>
            ".$footer2."
          </th>
        </tr>
      </table>
    </div>
  </footer>
";


$Main->Base = "

<!DOCTYPE html>
<html lang='id'>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>$site_title[option_value]</title>
  ".$Menuv5->style."
  ".$Menuv5->script."

</head>
<body>



  ".$Menuv5->Nav1."

  ".$Menuv5->Nav2."

  <div class='container-fluid' id='isikonten' style='background-color: $contentBackground[option_value]; font-family: $ContentFontStyle[option_value];'>
    ".$container."
  </div>

  ".$Menuv5->footer1."

  ".$Menuv5->footer2."

".$Menuv5->script2."


<a href='#x' class='overlay' id='postingAnggaranKas'></a>


<div class='popup' style='padding: 0%;'>
<form action='proses.php?act=login' method='POST'>
    <div class='form' style='
background: black;
color: #fff;
text-align: left;
PADDING: 2%;
'>POSTING ANGGARAN KAS</div>
<br>
<div style='text-align:left;border: 1px solid black;margin: 2%;padding: 2%;margin-top: -18px;'>

       <div>
         <span style='margin: 16px; color:black;'>POSTING KE : </span> <select onchange='rkaSKPD221.tujuanPostingChanged();' name='cmbPostingAnggaranKas' id='cmbPostingAnggaranKas'><option value='10'>SPD</option></select>
       </div>
   </form>

</div>
<div style='
text-align: right;
margin-right: 2%;
color: black;'>
<input type='button' value='POST' onclick=postAnggaranKas(); > &nbsp <input type='button' value='BATAL' onclick=closePopup(); >
</div>
            </form>
        </div>

<a href='#x' class='overlay' id='postingRKA'></a>
        <div class='popup' style='padding: 0%;'>
        <form action='proses.php?act=login' method='POST'>
            <div class='form' style='
    background: black;
    color: #fff;
    text-align: left;
    PADDING: 2%;
'>POSTING RKA</div><br>

     <div style='text-align:left;border: 1px solid black;margin: 2%;padding: 2%;margin-top: -18px;'>

            <div>
              <span style='margin: 16px; color:black;'>POSTING KE : </span> <select onchange='rkaSKPD221.tujuanPostingChanged();' name='cmbPosting' id='cmbPosting'><option value=''>-- POSTING --</option><option value='9'>DPA</option></select>
            </div>
        </form>

</div>
<div style='
    text-align: right;
    margin-right: 2%;
    color: black;'>
  <input type='button' value='POST' onclick=postRKA(); > &nbsp <input type='button' value='BATAL' onclick=closePopup(); >
</div>
</body>
</html>

";

?>
