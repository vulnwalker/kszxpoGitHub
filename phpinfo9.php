<?php
echo php_ini_loaded_file();
//phpinfo();
//error_reporting(0);

//echo date('Y-m-t', strtotime('2017-2-01'))

/***
include("config.php");

$isi = mysql_fetch_array( mysql_query( "select count(*) as cnt from buku_induk"));
echo 'jumlah 1: '.$isi['cnt']."<br>";


//$link = mssql_connect('mssql', 'datapilar', 'Atisisbada2018');
$link = mssql_connect('103.73.74.241', 'datapilar', 'Atisisbada2018');

if (!$link) {
    die('Something went wrong while connecting to MSSQL');
}

$conn=mssql_select_db("krw2017_atisis",$link );

$stmt =  mssql_query(  "select count(*) as cnt  from Ta_kegiatan " );
$isi = mssql_fetch_array($stmt);
echo 'jumlah : '.$isi['cnt']."<br>";
mssql_close($conn);

$isi = mysql_fetch_array( mysql_query( "select count(*) as cnt from buku_induk where tahun='2015'"));
echo 'jumlah 13: '.$isi['cnt']."<br>";

$stmt =  mssql_query(  "select count(*) as cnt  from Ta_kegiatan " );
$isi = mssql_fetch_array($stmt);
echo 'jumlah : '.$isi['cnt']."<br>";

**/
?>
