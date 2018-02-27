# MySQL-Front 5.1  (Build 1.32)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: 127.0.0.1:3308    Database: db_atsb_demo_v2
# ------------------------------------------------------
# Server version 5.5.44-0+deb7u1

#
# Source for function sf_penerimaan_posting_v2
#

CREATE DEFINER=`root`@`localhost` FUNCTION `sf_penerimaan_posting_v2`(`Id_PenDet_` int, `thn_bast_` char(4), `staset_` char(4),`a_` char(2), `a1_` char(2),`b_` char(2), `asal_usul_` char(2), `tgl_buku_` date,`JMLBRGNY_` int, `barang_sudah_proses_` int, `thn_anggaran_` char(4),`uid_` text, noreg_max_ int, sumber_dana_ text) RETURNS text CHARSET latin1
BEGIN

	DECLARE c1_, c_, d_, e_, e1_ text; 
    DECLARE f1_, f2_, f_, g_, h_, i_, j_ text; 
    DECLARE hasilstat_,hasilstat2_ text;
    DECLARE satuan_, noreg_baru_text_, bk_ur_, ck_ur_, dk_ur_, ket_barang_, keterangan_, nm_barangnya_, ambil_noreg_, Hasil_Distribusi_ text;
	DECLARE refid_terima_, jumlah_data_input_,jml_barang_dplh_, noreg_, refid_atribusi_, noreg_baru_, hit_bi int;
    DECLARE jml_barang_selesai_proses_, cek_harga_diBI_, ID_BI_barunya_, cntskpd_urusan_, barangdistribusi_, Id_Distribusi_, jumlah_total_input_BI_, jumlah_Barang_pendet_ int;
	DECLARE harga_beli_barang_,harga_atribusi_barang_, harga_satuan_, harga_atribusi_, harga_barang_satuan_dplh_, harga_totat_diBI_ DECIMAL(18,2);
    
    DECLARE harga_satuan_perolehan_, harga_satuan_perolehan_akhir_  DECIMAL(18,2);  
    DECLARE harga_beli_barang1_ , harga_atribusi_barang1_   DECIMAL(18,2);    
    DECLARE harga_beli_barang2_ , harga_atribusi_barang2_   DECIMAL(18,2);  
    DECLARE tgl_dok_sum_, tgl_kontraknya_,tgl_bukunya_  date;    
    DECLARE no_dokumen_sumber_, bk_, ck_, dk_, p_, q_, nomor_kontraknya_  text;    
    DECLARE hitungSelesai_ int;
	
	
	SELECT c1,c,d,e,e1,f1,f2,f,g,h,i,j, refid_terima, jml, satuan,ket_barang, keterangan, barangdistribusi, dat_hargabeli1, dat_hargabeli2, dat_atribusi1, dat_atribusi2 INTO c1_, c_, d_, e_, e1_, f1_, f2_, f_, g_, h_, i_, j_, refid_terima_, jml_barang_dplh_, satuan_, ket_barang_, keterangan_, barangdistribusi_, harga_beli_barang1_, harga_beli_barang2_, harga_atribusi_barang1_, harga_atribusi_barang2_ FROM t_penerimaan_barang_det WHERE Id=Id_PenDet_;
	
    SET harga_satuan_perolehan_ = harga_beli_barang1_ + harga_atribusi_barang1_;    
    SET harga_satuan_perolehan_akhir_ = harga_beli_barang2_ + harga_atribusi_barang2_;    

    SELECT tgl_dokumen_sumber, no_dokumen_sumber, bk, ck, dk, p, q, nomor_kontrak, tgl_kontrak, tgl_buku INTO tgl_dok_sum_, no_dokumen_sumber_, bk_, ck_, dk_, p_, q_, nomor_kontraknya_, tgl_kontraknya_, tgl_bukunya_ FROM t_penerimaan_barang WHERE Id=refid_terima_;
      
    SET hasilstat_ = "NEXT";        
    SET harga_barang_satuan_dplh_ = 0;    
    SET hitungSelesai_ = 0;   

    WHILE barang_sudah_proses_ < JMLBRGNY_ DO	
    	
    	SELECT COUNT(*) as jml INTO jumlah_data_input_ FROM buku_induk WHERE refid_terima_det=Id_PenDet_ AND refid_terima=refid_terima_;    		
    	
    	IF jumlah_data_input_ + 1 > jml_barang_dplh_ THEN
    		SET hasilstat_ = "NEXT";    
            SET barang_sudah_proses_ = barang_sudah_proses_ + JMLBRGNY_;
    	ELSEIF barang_sudah_proses_ >= JMLBRGNY_ THEN
    		SET hasilstat_ = "LANJUT";
    	ELSE    
                
        IF barangdistribusi_ = 1 THEN        
           SET barangdistribusi_ = 1;           
           SELECT sf_penerimaan_posting_distribusi(Id_PenDet_, c1_, c_, d_, e_, e1_) INTO Hasil_Distribusi_; 
           
           SET e_ = SUBSTRING(Hasil_Distribusi_, 1,2);
           SET e1_ = SUBSTRING(Hasil_Distribusi_, 4,3);
           SET Id_Distribusi_ = SUBSTRING_INDEX(Hasil_Distribusi_, ' ', -1);           
        END IF;
    		
			SELECT nm_barang INTO nm_barangnya_ FROM ref_barang WHERE f1=f1_ AND f2=f2_ AND f=f_ AND g=g_ AND h=h_ AND i=i_ AND j=j_;
			     
            
            SELECT sf_penerimaan_posting_noreg(c1_, c_, d_, e_, e1_, f1_, f2_, f_, g_, h_, i_, j_, thn_bast_,nm_barangnya_, noreg_max_) INTO ambil_noreg_ ;  
			SET j_=SUBSTRING(ambil_noreg_, 1,3);
			SET noreg_baru_text_ = SUBSTRING(ambil_noreg_,5);
				
    		
    		IF jumlah_data_input_ + 1 = jml_barang_dplh_ THEN
    			SET hasilstat_ = "LANJUT";
    			  
                SELECT COUNT(*) INTO cek_harga_diBI_ FROM buku_induk WHERE refid_terima_det = Id_PenDet_ AND harga = harga_satuan_perolehan_akhir_ ;                
                IF cek_harga_diBI_ = 0 THEN                
                   SET harga_barang_satuan_dplh_ = harga_satuan_perolehan_akhir_; 
                   SET harga_beli_barang_ = harga_beli_barang2_;
                   SET harga_atribusi_barang_ = harga_atribusi_barang2_;                                  
                ELSE    
                   SET harga_beli_barang_ = harga_beli_barang1_;
                   SET harga_atribusi_barang_ = harga_atribusi_barang1_;                  
                END IF;
                
    		ELSE
    			SET harga_barang_satuan_dplh_ = harga_satuan_perolehan_;    
                SET harga_beli_barang_ = harga_beli_barang1_;
                SET harga_atribusi_barang_ = harga_atribusi_barang1_;    
    			SET hasilstat_ = "OK";
    		END IF;
    		
    		
    		SELECT Id INTO refid_atribusi_ FROM t_atribusi WHERE refid_terima=refid_terima_ LIMIT 0,1;    

            
            SELECT bk, ck, dk, COUNT(*) INTO bk_ur_, ck_ur_, dk_ur_, cntskpd_urusan_ FROM ref_skpd_urusan WHERE c=c_ AND d=d_;            

            IF cntskpd_urusan_ <= 0 THEN             
               SET bk_ur_ = 0;               
               SET ck_ur_ = 0;               
               SET dk_ur_ = 0;
            
            END IF;
    				
    		
    		INSERT INTO buku_induk (a1, a, b, c1, c, d, e, e1, f1, f2, f, g, h, i, j, noreg, thn_perolehan, jml_barang, satuan, harga, jml_harga, asal_usul, kondisi, status_barang, staset, tgl_buku, tahun, uid, harga_beli, harga_atribusi, ref_idatribusi, no_ba, tgl_ba, bk_p, ck_p, dk_p, p, q, refid_terima, refid_terima_det, bk,ck,dk, jns_hibah, no_spk, tgl_spk) values (a1_, a_, b_, c1_, c_, d_, e_, e1_, f1_, f2_, f_, g_, h_, i_, j_, noreg_baru_text_, thn_bast_, '1', satuan_, harga_barang_satuan_dplh_, harga_barang_satuan_dplh_, asal_usul_, '1', '1', staset_, tgl_bukunya_, thn_anggaran_, uid_, harga_beli_barang_, harga_atribusi_barang_, refid_atribusi_, no_dokumen_sumber_, tgl_dok_sum_, bk_, ck_, dk_, p_, q_, refid_terima_, Id_PenDet_, bk_ur_, ck_ur_, dk_ur_, sumber_dana_, nomor_kontraknya_, tgl_kontraknya_);
    		    
            
            SELECT id INTO ID_BI_barunya_ FROM buku_induk WHERE a1=a1_ AND a=a_ AND b=b_ AND c1=c1_ AND c=c_ AND d=d_ AND e=e_ AND e1=e1_ AND f1=f1_ AND f2=f2_ AND f=f_ AND g=g_ AND h=h_ AND i=i_ AND j=j_ AND noreg=noreg_baru_text_ AND thn_perolehan=thn_bast_ AND staset=staset_ AND refid_terima=refid_terima_ AND refid_terima_det=Id_PenDet_ AND uid=uid_ AND asal_usul=asal_usul_ ORDER BY id DESC;
            
            IF f_='01' THEN
               INSERT INTO kib_a (a1, a, b, c1, c, d, e, e1, f1, f2, f, g, h, i, j, noreg, alamat, ket, tahun, idbi) VALUES(a1_, a_, b_, c1_, c_, d_, e_, e1_, f1_, f2_, f_, g_, h_, i_, j_, noreg_baru_text_,ket_barang_, keterangan_, thn_anggaran_, ID_BI_barunya_);            
            ELSEIF f_='02' THEN            
               INSERT INTO kib_b (a1, a, b, c1, c, d, e, e1, f1, f2, f, g, h, i, j, noreg, merk, ket, tahun, idbi) VALUES(a1_, a_, b_, c1_, c_, d_, e_, e1_, f1_, f2_, f_, g_, h_, i_, j_, noreg_baru_text_,ket_barang_, keterangan_, thn_anggaran_, ID_BI_barunya_);
            ELSEIF f_='03' THEN            
               INSERT INTO kib_c (a1, a, b, c1, c, d, e, e1, f1, f2, f, g, h, i, j, noreg, alamat, ket, tahun, idbi) VALUES(a1_, a_, b_, c1_, c_, d_, e_, e1_, f1_, f2_, f_, g_, h_, i_, j_, noreg_baru_text_,ket_barang_, keterangan_, thn_anggaran_, ID_BI_barunya_);
            ELSEIF f_='04' THEN            
               INSERT INTO kib_d (a1, a, b, c1, c, d, e, e1, f1, f2, f, g, h, i, j, noreg, alamat, ket, tahun, idbi) VALUES(a1_, a_, b_, c1_, c_, d_, e_, e1_, f1_, f2_, f_, g_, h_, i_, j_, noreg_baru_text_,ket_barang_, keterangan_, thn_anggaran_, ID_BI_barunya_);
            ELSEIF f_='05' THEN            
               INSERT INTO kib_e (a1, a, b, c1, c, d, e, e1, f1, f2, f, g, h, i, j, noreg, buku_judul, ket, tahun, idbi) VALUES(a1_, a_, b_, c1_, c_, d_, e_, e1_, f1_, f2_, f_, g_, h_, i_, j_, noreg_baru_text_,ket_barang_, keterangan_, thn_anggaran_, ID_BI_barunya_);
            ELSEIF f_='06' THEN            
               INSERT INTO kib_f (a1, a, b, c1, c, d, e, e1, f1, f2, f, g, h, i, j, noreg, alamat, ket, tahun, idbi) VALUES(a1_, a_, b_, c1_, c_, d_, e_, e1_, f1_, f2_, f_, g_, h_, i_, j_, noreg_baru_text_,ket_barang_, keterangan_, thn_anggaran_, ID_BI_barunya_);
            ELSEIF f_='07' THEN            
               INSERT INTO kib_g (a1, a, b, c1, c, d, e, e1, f1, f2, f, g, h, i, j, noreg, uraian, ket, tahun, idbi) VALUES(a1_, a_, b_, c1_, c_, d_, e_, e1_, f1_, f2_, f_, g_, h_, i_, j_, noreg_baru_text_,ket_barang_, keterangan_, thn_anggaran_, ID_BI_barunya_);
            END IF;
                        
            UPDATE buku_induk SET idawal=ID_BI_barunya_ WHERE id=ID_BI_barunya_; 
            
            SET hitungSelesai_ = hitungSelesai_+1;            

    		SET barang_sudah_proses_ = barang_sudah_proses_ + 1;    
    
    	END IF;	
    END WHILE;
        
    SELECT COUNT(*) INTO jml_barang_selesai_proses_ FROM buku_induk WHERE refid_terima=refid_terima_;
    
    SET hasilstat_ = CONCAT(hasilstat_," ",jml_barang_selesai_proses_, " ", harga_barang_satuan_dplh_, " ",hitungSelesai_);     

 RETURN hasilstat_; 

END;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
