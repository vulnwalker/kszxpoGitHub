var pemasukanSKPD = new SkpdCls({
	prefix : 'pemasukanSKPD', formName:'pemasukanForm', kolomWidth:120,
	
	pilihBidangAfter : function(){pemasukan.refreshList(true);},
	pilihUnitAfter : function(){pemasukan.refreshList(true);},
	pilihSubUnitAfter : function(){pemasukan.refreshList(true);},
	pilihSeksiAfter : function(){pemasukan.refreshList(true);}
});

var pemasukanSKPD2 = new SkpdCls({
	prefix : 'pemasukanSKPD2', 
	formName: 'pemasukanForm',
	
	pilihUrusanfter : function(){pemasukan.refreshList(true);},
	pilihBidangAfter : function(){pemasukan.refreshList(true);},
	pilihUnitAfter : function(){pemasukan.refreshList(true);},
	pilihSubUnitAfter : function(){pemasukan.refreshList(true);},
	pilihSeksiAfter : function(){pemasukan.refreshList(true);}
});

var pemasukan = new DaftarObj2({
	prefix : 'pemasukan',
	url : 'pages.php?Pg=pemasukan', 
	formName : 'pemasukanForm',
	satuan_form : '0',//default js satuan
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	
	},
	
	filterRenderAfter : function(){
		var me = this;
		DataPengaturan.nyalakandatepicker2();		
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
	
	InputBaru: function(){
	var me = this;
		//errmsg = this.CekCheckbox();
		errmsg = '';
		skpd = document.getElementById('ver_skpd').value ;
		//if(document.getElementById('ver_skpd').value == 1){
			c1n = document.getElementById('pemasukanSKPD2fmURUSAN');
			cn = document.getElementById('pemasukanSKPD2fmSKPD');
			dn = document.getElementById('pemasukanSKPD2fmUNIT');
			en = document.getElementById('pemasukanSKPD2fmSUBUNIT');
			e1n = document.getElementById('pemasukanSKPD2fmSEKSI');
		/*}else{
			c1n = document.getElementById('pemasukanSKPDfmUrusan');
			cn = document.getElementById('pemasukanSKPDfmSKPD');
			dn = document.getElementById('pemasukanSKPDfmUNIT');
			en = document.getElementById('pemasukanSKPDfmSUBUNIT');
			e1n = document.getElementById('pemasukanSKPDfmSEKSI');
		}*/
		
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
		
	
		errmsg = '';
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
	
	// Laporan: function(){
	// 	var me=this;
		
	// 	pemasukan_baru.formName = me.formName;
	// 	pemasukan_baru.nm_prefix = me.prefix;
	// 	pemasukan_baru.Laporan();
	// },
	
	/*Laporan: function(){
	var me = this;
	
		skpd = document.getElementById('ver_skpd').value ;
		//errmsg = this.CekCheckbox();
		errmsg = '';
		//if(document.getElementById('ver_skpd').value == 1){
			c1n = document.getElementById('pemasukanSKPD2fmURUSAN');
			cn = document.getElementById('pemasukanSKPD2fmSKPD');
			dn = document.getElementById('pemasukanSKPD2fmUNIT');
			en = document.getElementById('pemasukanSKPD2fmSUBUNIT');
			e1n = document.getElementById('pemasukanSKPD2fmSEKSI');
		/*}else{
			c1n = document.getElementById('pemasukanSKPDfmUrusan');
			cn = document.getElementById('pemasukanSKPDfmSKPD');
			dn = document.getElementById('pemasukanSKPDfmUNIT');
			en = document.getElementById('pemasukanSKPDfmSUBUNIT');
			e1n = document.getElementById('pemasukanSKPDfmSEKSI');
		}*/
	/*	
		if(c1n != '' && skpd != 1){
			if(errmsg == '' && c1n.value == '0')errmsg = "URUSAN Belum di Pilih ! ";
		}
		if(errmsg == '' && cn.value == '00')errmsg = "BIDANG Belum di Pilih ! ";
		if(errmsg == '' && dn.value == '00')errmsg = "SKPD Belum di Pilih ! ";
		if(errmsg == '' && en.value == '00')errmsg = "UNIT Belum di Pilih ! ";
		if(errmsg == '' && e1n.value == '000')errmsg = "SUB UNIT Belum di Pilih ! ";
		
		errmsg = '';
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
						pemasukan_ins.nyalakandatepicker();
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
	},*/
	
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
						setTimeout(function myFunction() {pemasukan.SetNama('penerima');},100);
						setTimeout(function myFunction() {pemasukan.SetNama('mengetahui');},100);
					}else{
						alert(resp.err);
						me.Close();
					}			
					
					//setTimeout(function myFunction() {pemasukan.jam()},100);	
					//me.AfterFormBaru();
			  	}
			});
			
			
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
	
	jam: function () {
	  var e = document.getElementById('tgl_validasi'),
	  d = new Date(), h, m, s;
	  h = d.getHours();
	  m = pemasukan.setJam(d.getMinutes());
	  s = pemasukan.setJam(d.getSeconds());
	  
	  
	  hari = d.getDate();
	  bulan = d.getMonth();
	  yy = d.getYear();
	  var Tahun = (yy < 1000) ? yy + 1900 : yy;
	  bulan = bulan + 1;
	  bln = bulan.toString()
	  if(bln.length == 1)bln = "0"+bln;
	
	  e.value = hari + '-'+ bln + '-'+ Tahun +" "+ h +':'+ m +':'+ s;
	
	  
	  setTimeout(function myFunction() {pemasukan.jam()},1000);
	 },
	
	 setJam: function (e) {
	  	e = e < 10 ? '0'+ e : e;
	  	return e;
	 },
	
	Edit:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=PengecekanUbah&CekUbah=1',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					//document.getElementById(cover).innerHTML = resp.content;
					if(resp.err==''){
						var aForm = document.getElementById(pemasukan.formName);		
						aForm.action= pemasukan.url+'_ins&YN=2';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
						aForm.target='_blank';
						aForm.submit();	
						aForm.target='';
					}else{
						alert(resp.err);
					}
			  	}
			});
			
			
		}else{
			alert(errmsg);
		}
		
	},
		
	Simpan: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		/*this.sendReq(
			this.url,
			{ idprs: 0, daftarProses: new Array('simpan')},
			this.formDialog);*/
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					alert(resp.content.alert);
					me.Close();
					pemasukan.refreshList();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	CetakPermohonan: function(idnya, Formnya='pemasukan_insForm'){
	
				
			var aForm = document.getElementById(Formnya);		
			aForm.action= this.url+'&tipe=CetakPermohonan&idnya='+idnya;//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
			aForm.target='_blank';
			aForm.submit();	
			aForm.target='';
	},
	
	headerTabel: function(){
		var target = $('#header-fix');
		var div_position = target.offset().top;
		
		$(window).scroll(function() { 
		    var y_position = $(window).scrollTop();
		    if(y_position > div_position) {
		        target.addClass('tetapdiatas');
		    }
		    else {
		        target.removeClass('tetapdiatas');
		    }
		});
			
	},
	
	Distribusikan: function(IdTerima, IdTerima_det){
		var aForm = document.getElementById('pemasukanForm');		
			aForm.action= this.url+'_distribusi&idTerima_nya='+IdTerima+'&idTerima_det_nya='+IdTerima_det;
			aForm.target='_blank';
			aForm.submit();	
			aForm.target='';
	},
	
	Kapitalisasikan: function(IdTerima, IdTerima_det){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=PengecekanKapitalisasi&IdTerimanya='+IdTerima,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						pemasukan.MulaiKapitalisasi(IdTerima, IdTerima_det);						
					}else{
						alert(resp.err);
					}
			  	}
			});
			
	},
	
	MulaiKapitalisasi: function(IdTerima, IdTerima_det){
		var aForm = document.getElementById('pemasukanForm');		
		aForm.action= this.url+'_kapitalisasi&idTerima_nya='+IdTerima+'&idTerima_det_nya='+IdTerima_det;
		aForm.target='_blank';
		aForm.submit();	
		aForm.target='';
	},
	
	AtribusiBaru: function(){
	var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg =='Data belum dipilih!'){ 
			var box = this.GetCbxChecked();
	
			//errmsg = this.CekCheckbox();
			VersiSKPD = document.getElementById('ver_skpd').value;
			
			errmsg = '';
			if(VersiSKPD == '1'){
				cn = document.getElementById('pemasukanSKPD2fmSKPD');
				dn = document.getElementById('pemasukanSKPD2fmUNIT');
				en = document.getElementById('pemasukanSKPD2fmSUBUNIT');
				e1n = document.getElementById('pemasukanSKPD2fmSEKSI');
			}else{
				c1n = document.getElementById('pemasukanSKPD2fmURUSAN');
				cn = document.getElementById('pemasukanSKPD2fmSKPD');
				dn = document.getElementById('pemasukanSKPD2fmUNIT');
				en = document.getElementById('pemasukanSKPD2fmSUBUNIT');
				e1n = document.getElementById('pemasukanSKPD2fmSEKSI');
				
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
				aForm.action= this.url+'_atribusi&YN=1';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
				aForm.target='_blank';
				aForm.submit();	
				aForm.target='';
			}else{
					alert(errmsg);
			}
		}else if(errmsg == "Pilih Hanya Satu Data!"){
			alert(errmsg);
		}else{
		
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=PengecekanUbah&atrib=Y',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						var aForm = document.getElementById(pemasukan.formName);		
						aForm.action= pemasukan.url+'_atribusi&YN=2';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
						aForm.target='_blank';
						aForm.submit();	
						aForm.target='';
					}else{
						alert(resp.err);
					}
			  	}
			});
			
		}	
	},
	
	Posting:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formPosting',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});
		}else{
			alert(errmsg);
		}
		
	},
	
	function_persenan: function(persen){
		document.getElementById("statustxt").style.width = persen+"%"; 
		document.getElementById("statustxt").innerHTML = persen+"%";
	},
	
	ProsesPostingPersediaan_After: function(konten){
		var me=this;
		me.function_persenan(konten.persenan);
		if(konten.lanjut == 1){
			me.ProsesPostingPersediaan(konten.mulai);
		}else{
			me.ProsesPostingPersediaan_Selesai();
		}
	},
	
	ProsesPostingPersediaan_Selesai: function(){
		var me= this;	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formpsting';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=ProsesPostingPersediaan_Selesai',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);	
				document.body.style.overflow='auto';	
				if(resp.err==''){
					alert("Data Berhasil Di Posting !");
					me.Close();
					me.refreshList(true);
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	ProsesPostingPersediaan: function(mulai){
		var me= this;	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formpsting';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=ProsesPostingPersediaan&mulai='+mulai,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					me.ProsesPostingPersediaan_After(resp.content);
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	HapusPostingPersediaan_Selesai: function(){
		var me= this;	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formdel';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=HapusPostingPersediaan_Selesai',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				delElem("pemasukan_formcover_load");		
				document.body.style.overflow='auto';
				if(resp.err==''){
					alert("Berhasil Membatalkan Posting !");
					me.Close();
					me.refreshList(true);
				}else{
					alert(resp.err);
				}
		  	}
		});	
	},
	
	HapusPostingPersediaan_After: function(konten){
		var me=this;
		me.function_persenan(konten.persenan);
		if(konten.lanjut == 1){
			me.HapusPostingPersediaan(100);
		}else{
			me.HapusPostingPersediaan_Selesai();
		}		
	},
	
	HapusPostingPersediaan: function(Limit){
		var me= this;	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formposting';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=HapusPostingPersediaan&Limit='+Limit,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					me.HapusPostingPersediaan_After(resp.content);
				}else{
					alert(resp.err);
				}
		  	}
		});	
	},
	
	SimpanPosting: function(){
		var me= this;	
		
		tot_jmlbarang = document.getElementById('tot_jmlbarang').value;
				
		$.ajax({
				type:'POST', 
				data:$('#'+this.prefix+"_form").serialize(),
				url: this.url+'&tipe=PengecekanPosting',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						if(resp.content.konfirmasi){
							if(resp.content.NoPosting){
								alert(resp.content.konfirmasi);
							}else{
								konf = confirm(resp.content.konfirmasi);
								if(konf == true){
									if(!resp.content.err){
										var cover = 'pemasukan_formcover_load';
										addCoverPage2(cover,1,true,false);	
										document.body.style.overflow='hidden';
										switch(resp.content.jns_trans){
											case "1":
												if(resp.content.konfirmasi == "Batalkan Posting Data ?"){
													me.HapusPosting(100);
												}else{
													if(document.getElementById('idbarangnya_0'))me.ProsesPosting(0, 0, 0);
												}
											break;
											case "2":
												if(resp.content.konfirmasi == "Batalkan Posting Data ?"){
													me.HapusPosting(100);
												}else{
													if(document.getElementById('idKPTLS_0'))me.ProsesPostingPemeliharaan(0, 0, 0);
												}
											break;
											case "3":
												if(resp.content.konfirmasi == "Batalkan Posting Data ?"){
													me.HapusPostingPersediaan(100);
												}else{
													delElem(cover);
													document.body.style.overflow='auto';
													if(document.getElementById('id_Detail_0'))me.ProsesPostingPersediaan(0);
												}
											break;
										}
									}else{
										alert(resp.content.err);
									}
								}
							}
								
						}
								
					}else{
						alert(resp.err);
					}
			  	}
			});		
		
		
	},
	
	kemajuanpersen: function(persenan,maxpersen,persenSebelum=0) {
		 var elem = document.getElementById("progressbox");
		 var me = this;
		 var tot_jmlbarang = document.getElementById('tot_jmlbarang').value;
		 tmbhn = 1/tot_jmlbarang * 100;
		 		 
		 if(Math.round(persenan+tmbhn) < maxpersen && Math.round(persenan)<=100){
			persenan = Math.round(persenan);
						
			if(persenSebelum != persenan){
				//alert(persenSebelum+" == "+persenan+" = "+maxpersen);
				document.getElementById("statustxt").style.width = persenan+"%"; 
				document.getElementById("statustxt").innerHTML = persenan+"%";
				
				persenSebelum = persenan;
				persenan = persenan + Math.round(tmbhn);
							
				//alert(persenSebelum+" = "+persenan);	
				setTimeout(function myFunctionPersen() {me.kemajuanpersen(persenan,maxpersen,persenSebelum)},1);
			}
		 }else{
			if(maxpersen >= 100){
				document.getElementById("statustxt").style.width = 100+"%"; 
				document.getElementById("statustxt").innerHTML = 100+"%";
			}else{
				document.getElementById("statustxt").style.width = Math.round(maxpersen)+"%"; 
				document.getElementById("statustxt").innerHTML = Math.round(maxpersen)+"%";
			}	
		 }	
		
	},
	
	kemunduranpersen: function(persenan,maxpersen,persenSebelum=0) {
		 var elem = document.getElementById("progressbox");
		 var me = this;
		 tot_jmlbarang = document.getElementById('tot_jmlbarang').value;
		 tmbhn = 1/tot_jmlbarang * 100;
		 		 
		 if(Math.round(persenan-tmbhn) < maxpersen && Math.round(persenan)<=100){
			persenan = Math.round(persenan);
						
			if(persenSebelum != persenan){
				//alert(persenSebelum+" == "+persenan+" = "+maxpersen);
				document.getElementById("statustxt").style.width = persenan+"%"; 
				document.getElementById("statustxt").innerHTML = persenan+"%";
				
				persenSebelum = persenan;
				persenan = persenan - Math.round(tmbhn);
							
				//alert(persenSebelum+" = "+persenan);	
				setTimeout(function myFunctionPersen() {me.kemunduranpersen(persenan,maxpersen,persenSebelum)},1);
			}
		 }else{
			if(maxpersen <= 0){
				document.getElementById("statustxt").style.width = 0+"%"; 
				document.getElementById("statustxt").innerHTML = 0+"%";
			}else{
				document.getElementById("statustxt").style.width = Math.round(maxpersen)+"%"; 
				document.getElementById("statustxt").innerHTML = Math.round(maxpersen)+"%";
			}	
		 }	
		
	},
	
	HapusPosting: function(persenan){
		tot_jmlbarang = document.getElementById('tot_jmlbarang').value;
		
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.prefix+"_form").serialize(),
				url: this.url+'&tipe=HapusPosting',
					success: function(data) {		
					var resp = eval('(' + data + ')');
					var me = pemasukan;
					var cover = 'pemasukan_formcover_load';
						if(resp.err==''){
							if(resp.content.Proses == "NEXT"){
								JumlahBarang = resp.content.JumlahBarang;
								tot_persen = JumlahBarang/tot_jmlbarang * 100;
								setTimeout(function myFunctionPersen() {me.kemunduranpersen(tot_persen,tot_persen,persenan)},100);
								setTimeout(function myFunctionPersen() {me.HapusPosting(tot_persen);},101);		
							}else{
								
								setTimeout(function myFunctionPersen() {me.kemunduranpersen(persenan,0,persenan)},100);
								setTimeout(function myFunctionPersen() {alert("Berhasil Membatalkan Posting !");},120);
								setTimeout(function myFunctionPersen() {me.Close();pemasukan.refreshList();},122);
								setTimeout(function myFunctionPersen() {delElem(cover);},500);
							}
							
						}else{
							delElem(cover);
							alert(resp.err);
						}
					}
			});	
	},
	
	
	ProsesPosting: function(urutan, BRGMULAI, BRGSUDAHPROSES){
		var me= this;	
		var cover = this.prefix+'_formcover';
		
		
		tot_jmlbarang = document.getElementById('tot_jmlbarang').value;
		
		if(document.getElementById('idbarangnya_'+urutan)){
			idbarangnya = document.getElementById('idbarangnya_'+urutan).value;
			jmlbarangnya = parseInt(document.getElementById('jmlbarangnya_'+idbarangnya).value);
			
			if(BRGSUDAHPROSES == 0){
				perawal=1;
			}else{
				perawal=BRGSUDAHPROSES;
			}
			
			persenan = perawal/tot_jmlbarang * 100;
			
			//alert(BRGSUDAHPROSES+" = "+tot_jmlbarang);
			if(parseInt(BRGSUDAHPROSES) < parseInt(tot_jmlbarang)){
				
				if(BRGMULAI >= jmlbarangnya){
					urutan = urutan+1;
					BRGSUDAHPROSES = BRGSUDAHPROSES + jmlbarangnya;
					
					maxpersenan =(BRGSUDAHPROSES)/tot_jmlbarang * 100;
					
					setTimeout(function myFunctionPersen() {me.kemajuanpersen(persenan,maxpersenan)},100);
					setTimeout(function myFunctionPersen() {me.ProsesPosting(urutan, 0, BRGSUDAHPROSES);},101);		
					
				}else{
					if(jmlbarangnya > 100){
						if((BRGMULAI + 100) > jmlbarangnya){
							JMLBARANGKIRIM = jmlbarangnya - BRGMULAI;
							BRGSUDAHPROSES = BRGSUDAHPROSES + JMLBARANGKIRIM;
							BRGMULAI = 0;
							urutan = urutan+1;	
						}else{
							JMLBARANGKIRIM = 100;
							BRGSUDAHPROSES = BRGSUDAHPROSES + 100;
							BRGMULAI = BRGMULAI+100;
							
														
						}
						
						maxpersenan =(BRGSUDAHPROSES+100)/tot_jmlbarang * 100;
						
					}else{
						BRGSUDAHPROSES = BRGSUDAHPROSES + jmlbarangnya;
						BRGMULAI = 0;
						//urutan = urutan+1;
						maxpersenan =(BRGSUDAHPROSES)/tot_jmlbarang * 100;
						JMLBARANGKIRIM = jmlbarangnya;
					}
					
					//alert("urutan Ke-2"+urutan+" Persen Ke-"+persenan+" maxpersenan"+maxpersenan);
					//alert(BRGMULAI+" BRG "+BRGSUDAHPROSES);
										
					$.ajax({
						type:'POST', 
						data:$('#'+this.prefix+"_form").serialize(),
						url: this.url+'&tipe=ProsesPosting&IdPenDet='+idbarangnya+'&JMLBRGNY='+JMLBARANGKIRIM+'&BRGMULAI='+BRGMULAI,
					  	success: function(data) {		
							var resp = eval('(' + data + ')');
							if(resp.err==''){
								if(BRGMULAI >=jmlbarangnya){
									BRGMULAI = 0;
									urutan = urutan + 1;
								}else if(resp.content.Langsung){
									BRGMULAI = 0;
									urutan = urutan + 1;
								}else if(jmlbarangnya < 100){
									BRGMULAI = 0;
									urutan = urutan + 1;
								}
									
								setTimeout(function myFunctionPersen() {me.kemajuanpersen(persenan,maxpersenan)},100);
								setTimeout(function myFunctionPersen() {me.ProsesPosting(urutan, BRGMULAI, resp.content.BarangSudahProses);},101);		
							}else{
								alert(resp.err);
								setTimeout(function myFunctionPersen() {delElem('pemasukan_formcover_load');},500);
							}
					  	}
					});	
					
					
					
				}
				
			}else{
				persenan = (BRGSUDAHPROSES/tot_jmlbarang) * 100;
				//alert("urutan Ke-2"+urutan+" Persen Ke-"+persenan);
				setTimeout(function myFunctionPersen() {me.kemajuanpersen(persenan,100)},100);
				setTimeout(function myFunctionPersen() {me.UpdatePostingBerhasil();},110);
			}
						
		}else{
			persenan = (BRGSUDAHPROSES/tot_jmlbarang) * 100;
			//alert("urutan Ke-2"+urutan+" Persen Ke-"+persenan);
			setTimeout(function myFunctionPersen() {me.kemajuanpersen(persenan,100)},100);
			setTimeout(function myFunctionPersen() {me.UpdatePostingBerhasil();},110);
					
		}
		
	},
	
	UpdatePostingBerhasil: function(){
		var me = this;
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+"_form").serialize(),
			url: this.url+'&tipe=BerhasilPosting',
			success: function(data) {		
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					alert("Berhasil Memposting Data !");
					
					setTimeout(function myFunctionPersen() {me.Close();pemasukan.refreshList();},111);
					setTimeout(function myFunctionPersen() {delElem('pemasukan_formcover_load');},500);
				}else{
					alert(resp.err);
				}
			}
		});
	},
		
	SimpanTTD: function(){
		var me= this;
		
		var cover = this.prefix+'_formcover_TTD_load';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,2,true,false);	
		
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form_TTD').serialize(),
			url: this.url+'&tipe=SimpanTTD',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					alert(resp.content);
					me.TutupForm("pemasukan_formcover_TTD");
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	PrintLaporan: function(){
		var aForm = document.getElementById(this.prefix+('_form'));		
			aForm.action= this.url+'&tipe=PrintLaporan';	
			aForm.target='_blank';
			aForm.submit();	
			aForm.target='';
	},
	
	ProsesPostingPemeliharaan: function(urutan, BRGMULAI, BRGSUDAHPROSES){
		var me= this;	
		var cover = this.prefix+'_formcover';
		
		
		tot_jmlbarang = document.getElementById('tot_jmlbarang').value;
		
		if(document.getElementById('idKPTLS_'+urutan)){
			idKPTLS = document.getElementById('idKPTLS_'+urutan).value;
			
			if(BRGSUDAHPROSES == 0){
				perawal=1;
			}else{
				perawal=BRGSUDAHPROSES;
			}
			
			persenan = perawal/tot_jmlbarang * 100;								
				$.ajax({
						type:'POST', 
						data:$('#'+this.prefix+"_form").serialize(),
						url: this.url+'&tipe=ProsesPostingPemeliharaan&IdDistribusi='+idKPTLS+'&BRGMULAI='+BRGMULAI,
					  	success: function(data) {		
							var resp = eval('(' + data + ')');
							if(resp.err==''){
								
								BRGMULAI = BRGMULAI + 1;
								urutan = urutan + 1;
								
								maxpersenan = resp.content.brg_input/tot_jmlbarang * 100 ;
								
								if(resp.content.lanjut == "NEXT"){
									setTimeout(function myFunctionPersen() {me.kemajuanpersen(persenan,maxpersenan)},100);
									setTimeout(function myFunctionPersen() {me.ProsesPostingPemeliharaan(urutan, BRGMULAI, resp.content.BarangSudahProses);},101);	
								}else{
									setTimeout(function myFunctionPersen() {me.kemajuanpersen(persenan,maxpersenan)},100);
									setTimeout(function myFunctionPersen() {me.UpdatePostingBerhasil();},110);
									
								}
																	
							}else{
								alert(resp.err);
								delElem("pemasukan_formcover_load");
							}
					  	}
					});	
					
					
					
		}
		
	},
	
	LihatData:function(Idnya){
		var me = this;
			var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formLihatData&Idnya='+Idnya,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});
		
	},
	
	SingkronAtribusi: function(){
		var me= this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=SingkronAtribusi',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err==''){
					alert("Selesai");
				}else{
					alert(resp.err);
				}
		  	}
		});
			
		
	},
	
	FormTemplate:function(){
		var me = this;
			//var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=FormTemplate',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});
		
	},
	
	PilihTemplate:function(){
		var errmsg = '';
		var pil_template = document.getElementById('pil_template').value;
		if(pil_template == '')errmsg = "Template Belum Di Pilih !";
		
		if(errmsg ==''){ 
			var tukUrl = 'cariTemplate';
			if(pil_template == '1')tukUrl='ref_templatebarang';
								
			var aForm = document.getElementById(this.prefix+"_form");		
			aForm.action= "pages.php?Pg="+tukUrl;		
			aForm.target='_blank';
			aForm.submit();	
			aForm.target='';
		}else{
				alert(errmsg);
		}	
	},
			
});
