
DROP VIEW IF EXISTS `v1_atribusi_rincian`;
CREATE TABLE `v1_atribusi_rincian` (`Id` int(11), `k` char(1), `l` char(1), `m` char(1), `n` char(2), `o` varchar(3), `uraian` text, `jumlah` decimal(18,2), `satuan` varchar(50), `harga_satuan` decimal(18,2), `jml_harga` decimal(18,2), `keterangan` text, `refid_atribusi` int(11), `refid_terima` int(11), `tahun` char(4), `uid` varchar(20), `tgl_create` datetime, `uid_create` varchar(20), `tgl_update` datetime, `status` char(1), `sttemp` int(2), `refid_dokumen_atribusi` int(11), `jns_dok` varchar(255), `tanggal_dok` date, `nomor_dok` varchar(255), `tar_sttemp` int(2), `tad_sttemp` int(2));


DROP VIEW IF EXISTS `v1_penerimaan_atribusi`;
CREATE TABLE `v1_penerimaan_atribusi` (`TAR_Id` int(11), `k` char(1), `l` char(1), `m` char(1), `n` char(2), `o` varchar(3), `TAR_jumlah` decimal(18,2), `TAR_refid_atribusi` int(11), `TAR_sttemp` int(2), `nm_rekening` varchar(75), `Id` int(11), `c1` char(1), `c` char(2), `d` char(2), `e` char(2), `e1` char(3), `jns_trans` char(2), `pencairan_dana` varchar(2), `sumber_dana` varchar(100), `cara_bayar` char(2), `status_barang` char(2), `dokumen_sumber` varchar(100), `tgl_sp2d` date, `no_sp2d` varchar(100), `refid_terima` int(11), `sttemp` int(2), `jns_dok` varchar(255), `nomor_dok` varchar(255), `tanggal_dok` date, `refid_dokumen_atribusi` int(11));


DROP TABLE IF EXISTS `v1_atribusi_rincian`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v1_atribusi_rincian` AS select `tar`.`Id` AS `Id`,`tar`.`k` AS `k`,`tar`.`l` AS `l`,`tar`.`m` AS `m`,`tar`.`n` AS `n`,`tar`.`o` AS `o`,`tar`.`uraian` AS `uraian`,`tar`.`jumlah` AS `jumlah`,`tar`.`satuan` AS `satuan`,`tar`.`harga_satuan` AS `harga_satuan`,`tar`.`jml_harga` AS `jml_harga`,`tar`.`keterangan` AS `keterangan`,`tar`.`refid_atribusi` AS `refid_atribusi`,`tar`.`refid_terima` AS `refid_terima`,`tar`.`tahun` AS `tahun`,`tar`.`uid` AS `uid`,`tar`.`tgl_create` AS `tgl_create`,`tar`.`uid_create` AS `uid_create`,`tar`.`tgl_update` AS `tgl_update`,`tar`.`status` AS `status`,`tar`.`sttemp` AS `sttemp`,`tar`.`refid_dokumen_atribusi` AS `refid_dokumen_atribusi`,`tad`.`jns_dok` AS `jns_dok`,`tad`.`tanggal_dok` AS `tanggal_dok`,`tad`.`nomor_dok` AS `nomor_dok`,`tar`.`sttemp` AS `tar_sttemp`,`tad`.`sttemp` AS `tad_sttemp` from (`t_atribusi_rincian` `tar` left join `t_atribusi_dokumen` `tad` on((`tar`.`refid_dokumen_atribusi` = `tad`.`Id`))) where (`tad`.`status` <> '2');

DROP TABLE IF EXISTS `v1_penerimaan_atribusi`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v1_penerimaan_atribusi` AS select `tar`.`Id` AS `TAR_Id`,`tar`.`k` AS `k`,`tar`.`l` AS `l`,`tar`.`m` AS `m`,`tar`.`n` AS `n`,`tar`.`o` AS `o`,`tar`.`jumlah` AS `TAR_jumlah`,`tar`.`refid_atribusi` AS `TAR_refid_atribusi`,`tar`.`sttemp` AS `TAR_sttemp`,`rr`.`nm_rekening` AS `nm_rekening`,`ta`.`Id` AS `Id`,`ta`.`c1` AS `c1`,`ta`.`c` AS `c`,`ta`.`d` AS `d`,`ta`.`e` AS `e`,`ta`.`e1` AS `e1`,`ta`.`jns_trans` AS `jns_trans`,`ta`.`pencairan_dana` AS `pencairan_dana`,`ta`.`sumber_dana` AS `sumber_dana`,`ta`.`cara_bayar` AS `cara_bayar`,`ta`.`status_barang` AS `status_barang`,`ta`.`dokumen_sumber` AS `dokumen_sumber`,`ta`.`tgl_sp2d` AS `tgl_sp2d`,`ta`.`no_sp2d` AS `no_sp2d`,`ta`.`refid_terima` AS `refid_terima`,`ta`.`sttemp` AS `sttemp`,`tar`.`jns_dok` AS `jns_dok`,`tar`.`nomor_dok` AS `nomor_dok`,`tar`.`tanggal_dok` AS `tanggal_dok`,`tar`.`refid_dokumen_atribusi` AS `refid_dokumen_atribusi` from ((`t_atribusi` `ta` left join `v1_atribusi_rincian` `tar` on((`tar`.`refid_atribusi` = `ta`.`Id`))) left join `ref_rekening` `rr` on(((`rr`.`k` = `tar`.`k`) and (`rr`.`l` = `tar`.`l`) and (`rr`.`m` = `tar`.`m`) and (`rr`.`n` = `tar`.`n`) and (`rr`.`o` = `tar`.`o`)))) where ((`ta`.`sttemp` = '0') and (`tar`.`tad_sttemp` = 0) and (`tar`.`tar_sttemp` = 0));
DELIMITER ;;
DROP FUNCTION IF EXISTS `sf_penerimaan_posting_pemeliharaan`;;
CREATE  FUNCTION `sf_penerimaan_posting_pemeliharaan`(`IdDistribusi` int(11), `tahun_dari_` int(4), `asal_usulnya_` char(1)) RETURNS text CHARSET latin1
BEGIN
     DECLARE hasil_,c1_,c_,d_,e_,e1_,f1_,f2_,f_,g_,h_,i_,j_, tahun_,uid_, nomor_, tgl_dok_, refid_jns_pemeliharaan_, jns_pemeliharaan_, cara_perolehan_, no_dokumen_sumber_, tgl_pemeliharaan_nya_, nomor_kontrak_nya_ text;
     DECLARE tgl_buku_, tgl_kontrak_nya_, tgl_dokumen_sumber_nya_ date;
     DECLARE hit_pemeliharaan_, refid_terima_, refid_penerimaan_det_, refid_buku_induk_, menambah_aset_, menambah_manfaat_, JML_DATA_SELESAI_PEMELIHARAAN_, JML_DATA_SELESAI_KPTLS_, tahun_ambil_  int;
     DECLARE jumlahKPTLS_ DECIMAL(18,2);

     SELECT c1,c,d,e,e1,f1,f2,f,g,h,i,j,jumlah, refid_terima, refid_penerimaan_det, uid, nomor, tgl_dok, refid_jns_pemeliharaan, jns_pemeliharaan, refid_buku_induk, CAST(tahun AS UNSIGNED) INTO c1_,c_,d_,e_,e1_,f1_,f2_,f_,g_,h_,i_,j_,jumlahKPTLS_, refid_terima_, refid_penerimaan_det_,uid_, nomor_, tgl_dok_, refid_jns_pemeliharaan_, jns_pemeliharaan_, refid_buku_induk_, tahun_ambil_ FROM t_distribusi WHERE Id=IdDistribusi;

     IF tahun_dari_ > tahun_ambil_ THEN
        SET tgl_pemeliharaan_nya_ = CONCAT(tahun_ambil_, "-12-31");
     ELSE
         SET tgl_pemeliharaan_nya_ = NOW();
     END IF;


     SELECT COUNT(*) INTO hit_pemeliharaan_ FROM pemeliharaan WHERE refid_terima=refid_terima_ AND refid_terima_det=refid_penerimaan_det_ AND id_bukuinduk=refid_buku_induk_ AND refid_distribusi=IdDistribusi;

     IF hit_pemeliharaan_ = 0 THEN
        SELECT menambah_aset, menambah_manfaat INTO menambah_aset_, menambah_manfaat_ FROM ref_jenis_pemeliharaan WHERE Id=refid_jns_pemeliharaan_;
        SELECT tgl_buku, asal_usul, no_dokumen_sumber, nomor_kontrak,tgl_kontrak,tgl_dokumen_sumber INTO tgl_buku_, cara_perolehan_, no_dokumen_sumber_,nomor_kontrak_nya_, tgl_kontrak_nya_, tgl_dokumen_sumber_nya_ FROM t_penerimaan_barang WHERE Id=refid_terima_;


        INSERT INTO pemeliharaan(id_bukuinduk, tgl_pemeliharaan,jenis_pemeliharaan,surat_no,surat_tgl,biaya_pemeliharaan, idbi_awal,uid,tambah_aset, tambah_masamanfaat, cara_perolehan, tgl_perolehan, no_bast, refid_terima, refid_terima_det, tgl_bast, refid_distribusi) values (refid_buku_induk_, tgl_buku_, jns_pemeliharaan_, nomor_kontrak_nya_, tgl_kontrak_nya_, jumlahKPTLS_, refid_buku_induk_, uid_, menambah_aset_, menambah_manfaat_, asal_usulnya_, tgl_dokumen_sumber_nya_, no_dokumen_sumber_, refid_terima_, refid_penerimaan_det_, tgl_dokumen_sumber_nya_, IdDistribusi) ;

     END IF;

     SELECT COUNT(*) INTO JML_DATA_SELESAI_PEMELIHARAAN_ FROM pemeliharaan WHERE refid_terima=refid_terima_;
     SELECT COUNT(*) INTO JML_DATA_SELESAI_KPTLS_ FROM t_distribusi WHERE refid_terima=refid_terima_ AND sttemp='0';

     IF JML_DATA_SELESAI_PEMELIHARAAN_ < JML_DATA_SELESAI_KPTLS_ THEN
        SET hasil_ = CONCAT("NEXT", " ", JML_DATA_SELESAI_PEMELIHARAAN_);
     ELSE
        SET hasil_ = CONCAT("END", " ", JML_DATA_SELESAI_PEMELIHARAAN_);
     END IF;

  RETURN hasil_;
END;;
DELIMITER ;
