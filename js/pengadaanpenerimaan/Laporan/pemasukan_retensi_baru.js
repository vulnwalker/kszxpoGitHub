var pemasukan_retensi_baruSKPD2 = new SkpdCls({
	prefix : 'pemasukan_retensi_baruSKPD2', 
	formName: 'pemasukan_retensi_baruForm',
	
	pilihUrusanfter : function(){pemasukan_retensi_baru.refreshList(true);},
	pilihBidangAfter : function(){pemasukan_retensi_baru.refreshList(true);},
	pilihUnitAfter : function(){pemasukan_retensi_baru.refreshList(true);},
	pilihSubUnitAfter : function(){pemasukan_retensi_baru.refreshList(true);},
	pilihSeksiAfter : function(){pemasukan_retensi_baru.refreshList(true);}
});

var pemasukan_retensi_baru = new DaftarObj2({
	prefix : 'pemasukan_retensi_baru',
	url : 'pages.php?Pg=pemasukan_retensi_baru', 
	formName : 'pemasukan_retensi_baruForm',
	pesan_eror:'',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	
	},
	
	CariBarang: function(){
		cariBarang.windowShow(this.formName);
		cariBarang.Bar = '2';
	},
	
	Simpan: function(){ //Simpan Validasi
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					me.Close();
					me.AfterSimpan();
					if(resp.content == '1'){
						alert("Data Berhasil di Validasi !");
					}else{
						alert("Berhasil Membatalkan Validasi !");
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},


			TandaTanda:function(){
				$.ajax({
					type:'POST', 
					data:{	
							c1 : $("#c1").val(),
							c : $("#c").val(),
							d : $("#d").val(),
							e : $("#e").val(),
							e1 : $("#e1").val(),
							id_penerima : $("#cmb_penerima").val(),
							id_mengetahui : $("#cmb_mengetahui").val()
							
					},
					url: this.url+'&tipe=TandaTanda',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');				
						if(resp.err==''){							
										
						}else{
							
						}							
						
				  	}
				});
	},
		
	Baru: function(namaForm=''){	
		
		var me = this;
		//errmsg = this.CekCheckbox();
		errmsg = '';
		skpd = document.getElementById('ver_skpd').value ;
		c1n = document.getElementById('pemasukan_retensi_baruSKPD2fmURUSAN');
		cn = document.getElementById('pemasukan_retensi_baruSKPD2fmSKPD');
		dn = document.getElementById('pemasukan_retensi_baruSKPD2fmUNIT');
		en = document.getElementById('pemasukan_retensi_baruSKPD2fmSUBUNIT');
		e1n = document.getElementById('pemasukan_retensi_baruSKPD2fmSEKSI');
		
		
		if(c1n != '' && skpd != 1){
			if(errmsg == '' && c1n.value == '0')errmsg = "URUSAN Belum di Pilih ! ";
		}
		if(errmsg == '' && cn.value == '00')errmsg = "BIDANG Belum di Pilih ! ";
		if(errmsg == '' && dn.value == '00')errmsg = "SKPD Belum di Pilih ! ";
		if(errmsg == '' && en.value == '00')errmsg = "UNIT Belum di Pilih ! ";
		if(errmsg == '' && e1n.value == '000')errmsg = "SUB UNIT Belum di Pilih ! ";
		
		if(errmsg ==''){ 
			//var box = this.GetCbxChecked();
			
			//alert(box.value);
					
			var aForm = document.getElementById(this.formName);		
			aForm.action= this.url+'_ins&YN=1';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
			aForm.target='_blank';
			aForm.submit();	
			aForm.target='';
		}else{
				alert(errmsg);
		}	
	},	
	
	TutupForm:function(cover){
		if(document.getElementById(cover)) delElem(cover);					
	},
	
	Laporan: function(){
	var me = this;
	
		skpd = document.getElementById('ver_skpd').value ;
		//errmsg = this.CekCheckbox();
		errmsg = '';
		//if(document.getElementById('ver_skpd').value == 1){
			c1n = document.getElementById(me.nm_prefix+'SKPD2fmURUSAN');
			cn = document.getElementById(me.nm_prefix+'SKPD2fmSKPD');
			dn = document.getElementById(me.nm_prefix+'SKPD2fmUNIT');
			en = document.getElementById(me.nm_prefix+'SKPD2fmSUBUNIT');
			e1n = document.getElementById(me.nm_prefix+'SKPD2fmSEKSI');
		/*}else{
			c1n = document.getElementById('pemasukan_baruSKPDfmUrusan');
			cn = document.getElementById('pemasukan_baruSKPDfmSKPD');
			dn = document.getElementById('pemasukan_baruSKPDfmUNIT');
			en = document.getElementById('pemasukan_baruSKPDfmSUBUNIT');
			e1n = document.getElementById('pemasukan_baruSKPDfmSEKSI');
		}*/
		
		

			if(errmsg == '' && c1n.value == '00')errmsg = "URUSAN Belum di Pilih ! ";
	
		if(errmsg == '' && cn.value == '00')errmsg = "BIDANG Belum di Pilih ! ";
		if(errmsg == '' && dn.value == '00')errmsg = "SKPD Belum di Pilih ! ";
		
		if(errmsg ==''){ 
			//var box = this.GetCbxChecked();
			
			//alert(box.value);
					
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=BuatLaporan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;

										        $.ajax({
						type:'POST',
							url: this.url+'&tipe=getYearRange',
							success: function(data) {
							var resp = eval('(' + data + ')');
									$( "#dari" ).datepicker({
										dateFormat: "dd-mm-yy",
										showAnim: "slideDown",
										inline: true,
										showOn: "button",
										buttonImage: "datepicker/calender1.png",
										buttonImageOnly: true,
										changeMonth: true,
										changeYear: false,
										yearRange: resp.content.yearRange,
										buttonText : "",
									});
									$( "#sampai" ).datepicker({
										dateFormat: "dd-mm-yy",
										showAnim: "slideDown",
										inline: true,
										showOn: "button",
										buttonImage: "datepicker/calender1.png",
										buttonImageOnly: true,
										changeMonth: true,
										changeYear: false,
										yearRange: resp.content.yearRange,
										buttonText : "",
									});

									DataPengaturan.nyalakandatepicker();

							}
					});
										        
					}else{
						alert(resp.err);
						me.Close();
					}			
					
					//setTimeout(function myFunction() {pemasukan_baru.jam()},100);	
					//me.AfterFormBaru();
			  	}
			});
			
			
			
		}else{
				alert(errmsg);
		}	
	},

		SetNama: function(pilihan){
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.prefix+'_form_TTD').serialize(),
				url: this.url+'&tipe=SetNama&pilihan='+pilihan,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						document.getElementById('nip_'+pilihan).value=resp.content.nip;
						document.getElementById('pangkat_'+pilihan).value=resp.content.pangkat;
						document.getElementById('eselon_'+pilihan).value=resp.content.eselon;
						document.getElementById('jabatan_'+pilihan).value=resp.content.jabatan;
					}else{
						alert(resp.err);
					}
			  	}
			});	
	},	

		LaporanTTD: function(){
		var me = this;
						
			var cover = this.prefix+'_formcover_TTD';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,2,true,false);
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.prefix+'_form').serialize(),
			  	url: this.url+'&tipe=LaporanTTD',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
						setTimeout(function myFunction() {pemasukan_retensi_baru.SetNama('penerima');},100);
						setTimeout(function myFunction() {pemasukan_retensi_baru.SetNama('mengetahui');},100);
					}else{
						alert(resp.err);
						me.Close();
					}			
					
					//setTimeout(function myFunction() {pemasukan_baru.jam()},100);	
					//me.AfterFormBaru();
			  	}
			});
			
			
	},

			Perolehan:function(){
				$.ajax({
					type:'POST', 
					data:{	
							nama_laporan : $("#nama_laporan").val(),
							perolehan :  $("#perolehan").val(),	
							sumber_Danas :  $("#sumber_Danas").val()
					},
					url: this.url+'&tipe=Perolehan',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');				
						if(resp.err==''){							
						if($("#nama_laporan").val() == '3'){
								$("#perolehan").prop('selectedIndex',1);
							 	 $("#perolehan").prop('disabled', 'disabled');
							 	 $("#sumber_Danas").val("APBD");
							 	 $("#sumber_Danas").prop('disabled', 'disabled');
							 	 
							 }
							 else if($("#nama_laporan").val() == '4'){
								$("#perolehan").prop('selectedIndex',1);
							 	 $("#perolehan").prop('disabled', 'disabled');
							 	 $("#sumber_Danas").val("APBD");
							 	 $("#sumber_Danas").prop('disabled', 'disabled');
							 	 
							 }else if($("#nama_laporan").val() == '5'){
							 	$("#perolehan").prop('selectedIndex',1);
							 	 $("#perolehan").prop('disabled', 'disabled');
							 	  $("#sumber_Danas").val("APBD");
							 	 $("#sumber_Danas").prop('disabled', 'disabled');
							 	 
							 }else{
							 		$("#perolehan").removeAttr("disabled");
							 		$("#perolehan").prop('selectedIndex','');
							 		$("#sumber_Danas").removeAttr("disabled");
							 		$("#sumber_Danas").prop('selectedIndex','');
							 }					
						}else{
							
						}							
						
				  	}
				});
	},
		PrintLaporan: function(){
		var aForm = document.getElementById(this.prefix+'_form');		
			aForm.action= this.url+'&tipe=PrintLaporan';	
			aForm.target='_blank';
			aForm.submit();	
			aForm.target='';
	},
	detail: function(){
		//alert('detail');
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();			
			//UserAktivitasDet.genDetail();			
			
		}else{
			alert(errmsg);
		}
		
	},
	daftarRender:function(){
		var me =this; //render daftar 
		addCoverPage2(
			'daftar_cover',	1, 	true, true,	{renderTo: this.prefix+'_cont_daftar',
			imgsrc: 'images/wait.gif',
			style: {position:'absolute', top:'5', left:'5'}
			}
		);
		$.ajax({
		  	url: this.url+'&tipe=daftar',
		 	type:'POST', 
			data:$('#'+this.formName).serialize(), 
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				document.getElementById(me.prefix+'_cont_daftar').innerHTML = resp.content;
				me.sumHalRender();
		  	}
		});
	},
	
	Edit:function(namaForm=''){
		var me = this;
		errmsg = this.CekCheckbox();
		
		if(errmsg ==''){ 			
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=CekEdit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);
					document.body.style.overflow='auto';
					if(resp.err == ''){
						var box = me.GetCbxChecked();
						var aForm = document.getElementById(me.formName);		
						aForm.action= me.url+'_ins&YN=2';
						aForm.target='_blank';
						aForm.submit();	
						aForm.target='';
					}else{
						alert(resp.err);
					}			
					
					//setTimeout(function myFunction() {pemasukan.jam()},100);	
					//me.AfterFormBaru();
			  	}
			});
			
		}else{
			alert(errmsg);
		}
		
	},
	Hapus:function(){
		
		var me =this;
		if(document.getElementById(this.prefix+'_jmlcek')){
			var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;	
		}else{
			var jmlcek = '';
		}
		
		if(jmlcek ==0){
			alert('Data Belum Dipilih!');
		}else{
			if(confirm('Hapus '+jmlcek+' Data ?')){
				//document.body.style.overflow='hidden'; 
				var cover = this.prefix+'_hapuscover';
				addCoverPage2(cover,1,true,false);
				$.ajax({
					type:'POST', 
					//data:$('#'+this.formName).serialize(),
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=hapus',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');		
						delElem(cover);		
						if(resp.err==''){							
							me.Close();
							me.refreshList(true)
						}else{
							alert(resp.err);
						}							
						
				  	}
				});
				
			}	
		}
	},
	
	
	
	Close1:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKA';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close2:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	GandakanPenerimaan: function(datanya){
		var me = this;
		var tanya = confirm("Gandakan Data Rincian Penerimaan ?");
		if(tanya == true){
				var cover = this.prefix+'_formcover2';
				document.body.style.overflow='hidden';			
				addCoverPage2(cover,999,true,false);			
				
				$.ajax({
					type:'POST', 
					data:$('#'+this.formName).serialize(),
				  	url: this.url+'&tipe=DataCopy&datakopi='+datanya,
				  	success: function(data) {		
						var resp = eval('(' + data + ')');
						delElem(cover);				
						if(resp.err ==  ""){							
							me.loading();	
						}else{													
							alert(resp.err);
						}
					}
				});			
		}
	},
	
	Validasi:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			if(me.satuan_form==0){//baru dari satuan
				addCoverPage2(cover,1,true,false);	
			}else{//baru dari barang
				addCoverPage2(cover,999,true,false);	
			}
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=Validasi',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);
						me.Close();
					}			
					
					//setTimeout(function myFunction() {pemasukan.jam()},100);	
					//me.AfterFormBaru();
			  	}
			});
		}else{
			alert(errmsg);
		}
		
	},
	
	PostingForm:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=PostingForm',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);
						me.Close();
					}			
					
					//setTimeout(function myFunction() {pemasukan.jam()},100);	
					//me.AfterFormBaru();
			  	}
			});
		}else{
			alert(errmsg);
		}
		
	},
	
	SimpanPosting: function(){ //Simpan Validasi
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=Cek_SimpanPosting',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					var tanya = confirm(resp.content.pesan);
					if(tanya == true){
						var tot_jmlbarang = document.getElementById("tot_jmlbarang").value;
						if(resp.content.tanya != '3'){
							for(i=0;i<tot_jmlbarang;i++){
								var IdRetensiDet = document.getElementById("id_barangnya_"+i).value;
								me.SavePosting(IdRetensiDet);
							}							
						}else{
							me.BatalkanPosting();
						}
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	BatalkanPosting: function(){ //Simpan Validasi
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=BatalkanPosting',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					setTimeout(function myFunction() {me.GetPersen(resp.content.maxpersen,1);},10);	 
					if(resp.content.next == 1)me.BatalkanPosting();				
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SavePosting: function(IdRetensiDet){ //Simpan Validasi
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=SimpanPosting&IdRetensiDet='+IdRetensiDet,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					setTimeout(function myFunction() {me.GetPersen(resp.content.maxpersen);},10);	 				
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	UpdatePosting: function(kondisi){ //Simpan Validasi
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=UpdatePosting&kondisi='+kondisi,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					if(kondisi=='1'){
						alert("Berhasil Memposting Data !");
					}else{
						alert("Berhasil Membatalkan Posting Data !");
					}
					me.Close();
					me.refreshList(true); 				
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	GetPersen: function(maxpersen, mundur=0){
		var me=this;
		if(maxpersen >= 100){
			document.getElementById("statustxt1").style.width = 100+"%"; 
			document.getElementById("statustxt1").innerHTML = 100+"%";
			setTimeout(function myFunction() {me.AfterGetPersen(1);},50);
		}else{
			document.getElementById("statustxt1").style.width = Math.round(maxpersen)+"%"; 
			document.getElementById("statustxt1").innerHTML = Math.round(maxpersen)+"%";
			if(mundur == 1 && maxpersen==0)setTimeout(function myFunction() {me.AfterGetPersen(0);},50);
		}	
	},
	
	AfterGetPersen: function(kondisi){
		var me=this;
		
		me.UpdatePosting(kondisi);
	},
	
	
	
});
