var pemasukan_insSKPD = new SkpdCls({
	prefix : 'pemasukan_insSKPD', formName:'pemasukan_insForm', kolomWidth:120,
	
	a : function(){
		alert('dsf');
	},
});

var pemasukan_ins = new DaftarObj2({
	prefix : 'pemasukan_ins',
	url : 'pages.php?Pg=pemasukan_ins', 
	formName : 'pemasukan_insForm',
	satuan_form : '0',//default js satuan
	
	
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		//setTimeout(function myFunction() {var me=this;me.tabelRekening()},100);
		//setTimeout(function myFunction() {var me=this;me.tabelRekening()},100);
		//setTimeout(function myFunction() {document.getElementById('pekerjaan').focus()},1000);
		//this.daftarRender();
		//this.sumHalRender();
	
	},	
	
	filterRenderAfter : function(){
		var me = this;
		
		setTimeout(function myFunction() {me.caraperolehan()},1000);
		setTimeout(function myFunction() {me.inputpenerimaan()},1000);
		setTimeout(function myFunction() {me.rincianpenerimaan()},1000);
		setTimeout(function myFunction() {me.SetPenerima()},1000);
		setTimeout(function myFunction() {me.Get_TanggalDok_Sumber()},1000);
		setTimeout(function myFunction() {me.nyalakandatepicker()},1000);
		setTimeout(function myFunction() {me.nyalakandatepicker2()},1000);
						
		setTimeout(function myFunction() {parent.window.onunload=me.TutupHalaman()},1000);
	},
	
	nyalakandatepicker: function(){
		
		$( ".datepicker" ).datepicker({ 
			dateFormat: "dd-mm-yy", 
			showAnim: "slideDown",
			inline: true,
			showOn: "button",
			buttonImage: "datepicker/calender1.png",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+0",
			buttonText : "",
		});	
	},
	
	nyalakandatepicker2: function(){
		
		$( ".datepicker2" ).datepicker({ 
			dateFormat: "dd-mm", 
			showAnim: "slideDown",
			inline: true,
			showOn: "button",
			buttonImage: "datepicker/calender1.png",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+0",
			buttonText : "",
		});	
	},

	inputpenerimaan: function(){
		/*document.getElementById('inputpenerimaanbarang').style.color = "blue";
		document.getElementById('inputpenerimaanbarang').style.fontWeight = "bold";
		document.getElementById('rincianpenerimaanbarang').style.color = "red";
		document.getElementById('rincianpenerimaanbarang').style.fontWeight = "";*/
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=inputpenerimaanDET',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('databarangnya').innerHTML = resp.content;
				}else{
					alert(resp.err);
				}
			}
		});	
		
	},
	
	rincianpenerimaan: function(){
		var me=this;
		/*document.getElementById('rincianpenerimaanbarang').style.color = "blue";
		document.getElementById('rincianpenerimaanbarang').style.fontWeight = "bold";
		document.getElementById('inputpenerimaanbarang').style.color = "red";
		document.getElementById('inputpenerimaanbarang').style.fontWeight = "";*/
		
		/*$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=rincianpenerimaanDET',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('rinciandatabarangnya').innerHTML = resp.content;
					setTimeout(function myFunction() {pemasukan_ins.CekSesuai()},100);
					
				}else{
					alert(resp.err);
				}
			}
		});	*/
		me.AmbilPemasukanDet();
	},
		
	tabelRekening: function(hapus = 1){
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRekening&HapusData='+hapus,
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('tbl_rekening').innerHTML = resp.content.tabel;
					document.getElementById('totalbelanja23').innerHTML = resp.content.jumlah;
					if(document.getElementById('koderek')){
						document.getElementById('koderek').focus();
						document.getElementById('atasbutton').innerHTML = resp.content.atasbutton;
						setTimeout(function myFunction() {pemasukan_ins.CekSesuai()},1000);
					}
					setTimeout(function myFunction() {pemasukan_ins.reload_carabayar()},1000);					
				}else{
					alert(resp.err);
				}
			}
		});	
		
		setTimeout(function myFunction() {pemasukan_ins.CekSesuai()},1000);
	},
	
	caraperolehan: function(BIRMS = 0){
		var asalusul = document.getElementById('asalusul').value;
		var me =this;
		
		if(asalusul == '1'){
			$.ajax({
					type:'POST', 
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=caraperolehan',
					success: function(data) {	
						var resp = eval('(' + data + ')');			
						if(resp.err==''){
							document.getElementById('pilCaraPerolehan').innerHTML = resp.content;
							setTimeout(function myFunction() {pemasukan_ins.tabelRekening()},100);						
							if(BIRMS == 1){
								me.AfterPilBIRM();
							}else{
								var KEBIRMS = true;
								if(document.getElementById("kode_account_ap").value == "")KEBIRMS = false;
								if(document.getElementById("kode_account_ap").value == "0")KEBIRMS = false;
								if(KEBIRMS == true){
									me.AfterPilBIRM(0);
								}else{
									setTimeout(function myFunction() {me.TglNomorDokumen()},500);
									setTimeout(function myFunction() {me.Get_TanggalDok_Sumber()},500);				
								}
								//me.Pil_NomorDokumen();
							}	
							
						}else{
							alert(resp.err);
						}
					}
				});
		}else{
			document.getElementById('pilCaraPerolehan').innerHTML = '';
			document.getElementById('tbl_rekening').innerHTML = '';
			document.getElementById('totalbelanja23').innerHTML = '';
		}	
		
		setTimeout(function myFunction() {me.KodePenerimaan()},500);
		//setTimeout(function myFunction() {me.GetSumberDana()},100);
	},
	
	GetSumberDana: function(){
		var me =this;
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=GetSumberDana',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById("tukCaraPerolehan").innerHTML = resp.content;
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	BaruRekening: function(){
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=InsertRekening',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					if(resp.content == 1){
						var me = this ;
						pemasukan_ins.tabelRekening(0);
					}
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	namarekening: function(){
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=namarekening',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	HapusRekening: function(isi){
		var konfrim = confirm("Hapus Data Rekening ?");
		var me=this;
		if(konfrim == true){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=HapusRekening&idrekei='+isi,
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						//document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
						me.tabelRekening();
					}else{
						alert(resp.err);
					}
				}
			});	
		}
		
	},
	
	updKodeRek: function(){
		var me=this;
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=updKodeRek',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('koderekeningnya_'+resp.content.idrek).innerHTML = resp.content.koderek;
					document.getElementById('jumlanya_'+resp.content.idrek).innerHTML = resp.content.jumlahnya;
					document.getElementById('option_'+resp.content.idrek).innerHTML = resp.content.option;
					
					me.tabelRekening();
					//document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	JADIKANINPUT: function(idna){
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=jadiinput&idrekeningnya='+idna,
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						document.getElementById('koderekeningnya_'+resp.content.idrek).innerHTML = resp.content.koderek;
						document.getElementById('jumlanya_'+resp.content.idrek).innerHTML = resp.content.jumlahnya;
						document.getElementById('option_'+resp.content.idrek).innerHTML = resp.content.option;
						document.getElementById('atasbutton').innerHTML = resp.content.atasbutton;
						//document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	jadiinput: function(idna){
		var me=this;
		me.tabelRekening();
		setTimeout(function myFunction() {pemasukan_ins.JADIKANINPUT(idna)},100);
	},
	
	
	
	
	CariProgram: function(){
		var me = this;
		cariprogram.windowShow();	
	},
	
	TglNomorDokumen: function(){
		var me = this;
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=Tglnomordokumen',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('tgl_dokcopy').value = resp.content.tgl;
					document.getElementById('tgl_dok').value = resp.content.tgl_dok;
					if(document.getElementById('TombolPilih'))document.getElementById('TombolPilih').innerHTML = resp.content.Tombol;
					me.TglNomorDokumenAfter();
				}else{
					alert(resp.err);
				}
			}
		});	
		
	},
	
	TglNomorDokumenAfter:function(){
		var me = this;
	},
	
	
	cekCaraPerolehan: function(){
		var asalusul = document.getElementById('asalusul').value;
		
		if(asalusul != '1'){
			/*document.getElementById('metodepengadaan').disabled =true;
			document.getElementById('pencairan_dana').disabled =true;
			document.getElementById('program').value ='';
			document.getElementById('progcar').disabled =true;
			document.getElementById('kegiatan').value ="";
			document.getElementById('kegiatan').disabled =true;
			document.getElementById('pekerjaan').disabled =true;
			document.getElementById('pekerjaan').value ="";
			document.getElementById('tgl_dokcopy').value ="";
			document.getElementById('nomdok').value ="";
			document.getElementById('BaruNoDok').disabled =true;
			
			document.getElementById('prog').value ='';*/
		}else{
			/*document.getElementById('progcar').disabled =false;
			document.getElementById('pekerjaan').disabled =false;*/
			//document.getElementById('metodepengadaan').disabled =false;
		}
	},
	
	ambilNomorDokumen: function(pil = '', lang='t'){
		var me = this;
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=nomordokumen&nom='+pil,
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('nomber').innerHTML = resp.content.isi;
					if(lang == 'y'){
						setTimeout(function myFunction() {me.TglNomorDokumen()},100);
					}else{
						document.getElementById('tgl_dokcopy').value = '';
						document.getElementById('tgl_dok').value = '';
					}
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	BaruNomDok: function(){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		
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
			  	url: this.url+'&tipe=formBaruNomDok',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					
					if(resp.err ==""){
						document.getElementById(cover).innerHTML = resp.content;
						pemasukan_ins.nyalakandatepicker();	
					}else{
						alert(resp.err);
						delElem(cover);
					}			
					
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
		
	UbahNomDok: function(){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formUbahNomDok',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					
					if(resp.err ==""){
						document.getElementById(cover).innerHTML = resp.content;
						pemasukan_ins.nyalakandatepicker();	
					}else{
						alert(resp.err);
						delElem(cover);
					}			
					
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	SimpanNomorDokumen: function(){
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
			url: this.url+'&tipe=simpanNomorDokumen',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					me.Close();
					me.ambilNomorDokumen(resp.content.nomdok, 'y');
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	HapusNomDok: function(){
		var me= this;			
		var tanya = confirm("Hapus Dokumen Kontrak ?");
		if(tanya == true){
			this.OnErrorClose = false	
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);	
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=HapusNomorDokumen',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);
					me.Close();
					if(resp.err==''){
						document.getElementById('TombolPilih').innerHTML = "";
						me.ambilNomorDokumen();
					}else{
						alert(resp.err);
					}
			  	}
			});
		}
		
	},
	
	BaruPenyedia: function(){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		
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
			  	url: this.url+'&tipe=formBaruPenyedia',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					
					if(resp.err ==""){
						document.getElementById(cover).innerHTML = resp.content;
						//$( "#datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });	
					}else{
						alert(resp.err);
						delElem(cover);
					}			
					
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	SimpanPenyedia: function(){
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
			url: this.url+'&tipe=simpanPenyedia',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					me.Close();
					document.getElementById('dafpenyedia').innerHTML = resp.content.penyedian;
					//me.ambilNomorDokumen(resp.content.nomdok, 'y');
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanPenerima: function(){
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
			url: this.url+'&tipe=simpanPenerima',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					me.Close();
					if(document.getElementById('dafpenerima')){
						document.getElementById('dafpenerima').innerHTML = resp.content.penerima;
					}else{
						
						setTimeout(function myFunctionPersen() {pemasukan.TutupForm('pemasukan_formcover_TTD');},100);
						setTimeout(function myFunctionPersen() {pemasukan.LaporanTTD();},101);
					}
					//me.ambilNomorDokumen(resp.content.nomdok, 'y');
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	pilihPangkat : function(){
	var me = this; 
		$.ajax({
		  url: this.url+'&tipe=pilihPangkat',
		  type : 'POST',
		  data:$('#'+this.prefix+'_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');
			
			if(resp.err == ''){
				document.getElementById('golang_akhir').value = resp.content;
			}else{
				alert(resp.err);
			}				
		}	
		});
	},
	
	BaruPenerima: function(FORM_DPLH = '#'+this.formName){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
				addCoverPage2(cover,999,true,false);
			$.ajax({
				type:'POST', 
				data:$(FORM_DPLH).serialize(),
			  	url: this.url+'&tipe=formBaruPenerima',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					
					if(resp.err ==""){
						document.getElementById(cover).innerHTML = resp.content;
						//$( "#datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });	
					}else{
						alert(resp.err);
						delElem(cover);
					}			
					
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	UbahPenerima: function(FORM_DPLH = '#'+this.formName){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
				addCoverPage2(cover,999,true,false);
			$.ajax({
				type:'POST', 
				data:$(FORM_DPLH).serialize(),
			  	url: this.url+'&tipe=formUbahPenerima',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					
					if(resp.err ==""){
						document.getElementById(cover).innerHTML = resp.content;
						//$( "#datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });	
					}else{
						alert(resp.err);
						delElem(cover);
					}			
					
			  	}
			});
		
		}else{
		 	alert(err);
		}
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
	Baru: function(){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		
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
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
					me.AfterFormBaru();
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	Edit:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,999,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formEdit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						me.AfterFormEdit(resp);
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
	
	SimpanDet: function(){
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=SimpanDet',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						//	rincianpenerimaan.inputpenerimaan
						//document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
						pemasukan_ins.rincianpenerimaan();
						pemasukan_ins.inputpenerimaan();
					}else{
						alert(resp.err);
					}
				}
			});	
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
					if(me.satuan_form==0){
						me.Close();
						me.AfterSimpan();						
					}else{
						me.Close();
						barang.refreshComboSatuan();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	formatCurrency:function(num) {
		num = num.toString().replace(/\$|\,/g,'');
		if(isNaN(num))
		num = "0";
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num*100+0.50000000001);
		cents = num%100;
		num = Math.floor(num/100).toString();
		if(cents<10)
		cents = "0" + cents;
		for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+'.'+
		num.substring(num.length-(4*i+3));
		return (((sign)?'':'-') + '' + num + ',' + cents);
	},
	
	isNumberKey: function(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
		
		return false;
		return true;
	},
	
	hitungjumlahHarga: function(FROMNYA=''){
		var jumlah_barang = document.getElementById('jumlah_barang'+FROMNYA).value;
		var harga_satuan = document.getElementById('harga_satuan'+FROMNYA).value;
		
		var jns_trans = document.getElementById('jns_transaksi').value;
		if(jns_trans == '2'){
			var kuantitas = document.getElementById('kuantitas'+FROMNYA).value;
			var volume = jumlah_barang * kuantitas;
			var total = volume * harga_satuan;
			
			document.getElementById('volume'+FROMNYA).value = volume;
			
		}else{
			var total = jumlah_barang * harga_satuan;
		}
		
		//Jika Ada Pajak
		var ppn_ok = document.getElementById("ppn_ok"+FROMNYA);
		var jml_ppn =document.getElementById("jml_ppn"+FROMNYA);
		if(ppn_ok.checked == true){
			var harga_pajak = total * (jml_ppn.value /100);
			total = total + harga_pajak;
		}
		
		document.getElementById('jumlah_harga'+FROMNYA).value = this.formatCurrency(total);
	},
	
	HapusRincianPenerimaan: function(isi){
		var konfrim = confirm("Hapus Rincian Penerimaan ?");
		if(konfrim == true){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=HapusRincianPenerimaan&IdRincian='+isi,
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						//document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
						pemasukan_ins.rincianpenerimaan();
						pemasukan_ins.inputpenerimaan();
					}else{
						alert(resp.err);
					}
				}
			});	
		}
		
		//alert(isi);
		
	},
	
	UbahRincianPenerimaan: function(isi){
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=UbahRincianPenerimaan&IdRincian='+isi,
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						//	rincianpenerimaan.inputpenerimaan
						//document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
						/*pemasukan_ins.rincianpenerimaan();*/
						document.getElementById('databarangnya').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	CekSesuai: function(){
		var me=this;
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=CekSesuai',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						//	rincianpenerimaan.inputpenerimaan
							if(document.getElementById('jumlahsudahsesuai'))document.getElementById('jumlahsudahsesuai').innerHTML = resp.content.ceklis;	
							//document.getElementById('idpenerimaan').value = resp.content.idpenerimaaan;	
							me.KodePenerimaan();					
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	KodePenerimaan: function(){
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=KodePenerimaan',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){	
							document.getElementById('idpenerimaan').value = resp.content;								
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	SimpanSemua: function(){
		idna = document.getElementById('pemasukan_ins_idplh').value;
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=SimpanSemua',
				success: function(data) {	
					var resp = eval('(' + data + ')');	
					delElem(cover);			
					if(resp.err==''){
						alert("Data Berhasil Disimpan !");
						
						var konfrim = confirm("CETAK SURAT PERMOHONAN VALIDASI INPUT DATA ?");
						if(konfrim == true){
							pemasukan.CetakPermohonan(idna);
						}else{
							window.close();
							window.opener.location.reload();
						}
						
						//	rincianpenerimaan.inputpenerimaan
							//document.getElementById('jumlahsudahsesuai').innerHTML = resp.content.ceklis;	
												
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	SetPenerima: function(){
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=SetPenerima',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						//	rincianpenerimaan.inputpenerimaan
						document.getElementById('OptPenerima').innerHTML = resp.content;
						
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	CariBarang: function(){
		cariBarang.windowShow(this.formName);
	},
	
	BatalSemua: function(){
		idna = document.getElementById('pemasukan_ins_idplh').value;
		
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=BatalSemua',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
							window.close();
							window.opener.location.reload();									
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	TutupHalaman: function(){
		window.opener.location.reload();	
	},
	
	CariBIRM: function(){
		var me = this;	
		
		BIRM.el_ID = 'kode_account_ap';
		BIRM.el_fmURUSAN = 'c1nya';
		BIRM.el_fmSKPD = 'cnya';
		BIRM.el_fmUNIT = 'dnya';
		BIRM.el_fmSUBUNIT = 'enya';
		BIRM.el_fmSEKSI = 'e1nya';
		//BIRM.el_nama_account = 'nama_account_ap';
		BIRM.windowShow("");	
		BIRM.windowSaveAfter= function(){
			if(document.getElementById("pemasukan_ins_idplh"))pemasukan_ins.caraperolehan(1);
		};
		//RefJurnal.filterAkun='1.3.7';//kode akun akum penyusutan
	},
	
	AfterPilBIRM: function(SimpanT = 1){
		var me =this;		
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=AfterPilBIRM&SimpanT='+SimpanT,
				success: function(data) {	
					var resp = eval('(' + data + ')');	
					delElem(cover);			
					if(resp.err==''){
						//Pekerjaan -----------------------------						
						document.getElementById("pekerjaan").value = resp.content.pekerjaan;	
						if(resp.content.hide_pekerjaan == "Y")document.getElementById("pekerjaan").readOnly	= true;	
						
						//Program Kegiatan ------------------------------------
						document.getElementById("program").value = resp.content.nama_program;
						document.getElementById("prog").value = resp.content.prog;
						document.getElementById("dafkeg").innerHTML = resp.content.kegiatan;
						if(resp.content.cara_bayar != 0)document.getElementById("cara_bayar").value = resp.content.cara_bayar;
						
						//Tanggal & No Dokumen Kontrak ------------------------------------------------------------
						if(resp.content.DataKontrak.hide_kontrak == "1"){
							//Tanggal
							document.getElementById("tgl_dokcopy").value = resp.content.DataKontrak.tgl_kontrak_idn;	
							document.getElementById("tgl_dok").value = resp.content.DataKontrak.tgl_kontrak;	
							//Nomor 
							document.getElementById("nomber").innerHTML = resp.content.DataKontrak.no_kontrak;	
							document.getElementById("TombolBaruNomDok").innerHTML = "";	
						}
						
						//Tanggal & No BAST ------------------------------------------------------------------------
						if(resp.content.DataNoBAST.hide_bast == "1"){
							var nomor_dokumen_bast = document.getElementById("nomor_dokumen_bast");
							var UntukTanggalBAST = document.getElementById("UntukTanggalBAST");
							var dokumen_sumber = document.getElementById("dokumen_sumber");
							
							nomor_dokumen_bast.value = resp.content.DataNoBAST.no_bast;	
							nomor_dokumen_bast.readOnly	= true;			
							nomor_dokumen_bast.style.width = "272px";
							
							UntukTanggalBAST.innerHTML = resp.content.DataNoBAST.tgl_bast_idn;	
							
							dokumen_sumber.value = "BAST";	
							dokumen_sumber.disabled = true;	
							document.getElementById("UntukDokumenSumber").innerHTML = resp.content.DataNoBAST.dokumen_sumber;
						}else{
							me.Gen_DefaultTglBAST();
						}
						
						//Penyediaan ------------------------------------------------------------------------------
						//det_dafpenyedia det_dafpenerima
						if(resp.content.penyedian != '')document.getElementById("det_dafpenyedia").innerHTML = resp.content.penyedian ;
						//Penerima ---------------------------------------------------------------------------------
						if(resp.content.penerima != '')document.getElementById("det_dafpenerima").innerHTML = resp.content.penerima ;
						
						
						me.tabelRekening();
						me.rincianpenerimaan();
							
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	Gen_DefaultTglBAST: function(){
		var nomor_dokumen_bast = document.getElementById("nomor_dokumen_bast");
		var UntukTanggalBAST = document.getElementById("UntukTanggalBAST");
		var dokumen_sumber = document.getElementById("dokumen_sumber");
		var me = this;
		
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=Gen_DefaultTglBAST',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						nomor_dokumen_bast.value = "";	
						nomor_dokumen_bast.readOnly	= false;			
						nomor_dokumen_bast.style.width = "258px";
						
						UntukTanggalBAST.innerHTML = resp.content;	
						dokumen_sumber.value = "BAST";	
						dokumen_sumber.disabled = false;	
						document.getElementById("UntukDokumenSumber").innerHTML = "";	
						me.nyalakandatepicker();								
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	JumlahOnFocus: function(){
		document.getElementById("MSG_Jumlah").innerHTML = '<span style="color:red"> &nbsp  &nbsp *Untuk Bilangan Desimal berkoma "," Gunakan Titik "."</span>'	;
	},
	
	JumlahOFFFocus: function(){
		document.getElementById("MSG_Jumlah").innerHTML = ''	;
	},
	
	Cek_PPN: function(FROMNYA=''){
		var me = this;
		var ppn_ok = document.getElementById("ppn_ok"+FROMNYA);
		var jml_ppn =document.getElementById("jml_ppn"+FROMNYA);
		if(ppn_ok.checked == true){
			jml_ppn.readOnly = false;
			jml_ppn.value = "10";
		}else{
			jml_ppn.readOnly = true;
			jml_ppn.value = "";
		}
		
		me.hitungjumlahHarga(FROMNYA);
	},
	
	Pil_MetodePengadaan: function(){
		if(document.getElementById("metodepengadaan")){
			var metodepengadaan=document.getElementById("metodepengadaan").value;
			var penyedian=document.getElementById("penyedian");
			var BaruPenyedia=document.getElementById("BaruPenyedia");
			
			if(metodepengadaan == "2"){
				penyedian.disabled = true;
				BaruPenyedia.disabled = true;
			}else{
				penyedian.disabled = false;
				BaruPenyedia.disabled = false;
			}
		}		
	},
	
	OptionPenyedia: function(){
		var me = this;
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=OptionPenyediaBarang',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('OptPenyedia').innerHTML = resp.content;
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	UbahPenyedia: function(){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formUbahPenyedia',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');					
					if(resp.err ==""){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);
						delElem(cover);
					}			
					
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	HapusPenyedia: function(){
		var me= this;	
		var tanya = confirm("Hapus Penyedia Barang ?");		
		if(tanya == true){
			this.OnErrorClose = false	
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);	
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=HapusPenyedia',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);
					me.Close();
					if(resp.err==''){
						document.getElementById('OptPenyedia').innerHTML = "";
						document.getElementById('dafpenyedia').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
			  	}
			});
		}
		
	},
	
	HapusPenerima: function(){
		var me= this;	
		var tanya = confirm("Hapus Penerima Barang ?");		
		if(tanya == true){
			this.OnErrorClose = false	
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);	
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=HapusPenerima',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);
					me.Close();
					if(resp.err==''){
						document.getElementById('OptPenerima').innerHTML = "";
						document.getElementById('dafpenerima').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
			  	}
			});
		}
		
	},
	
	CariTemplateBarang: function(){
		var me = this;
		ref_templatebarang.windowShow(this.formName);
		ref_templatebarang.windowSaveAfter= function(){
			if(document.getElementById("KodeTemplateBarang"))pemasukan_ins.FormLoadingImport();
		};
	},
	
	GetPersen: function(maxpersen){
		var me=this;
		if(maxpersen >= 100){
			document.getElementById("statustxt").style.width = 100+"%"; 
			document.getElementById("statustxt").innerHTML = 100+"%";
			setTimeout(function myFunction() {me.Close()},50);
		}else{
			document.getElementById("statustxt").style.width = Math.round(maxpersen)+"%"; 
			document.getElementById("statustxt").innerHTML = Math.round(maxpersen)+"%";
		}	
	},
	
	AfterPilihTemplateBrg: function(mulainya=0){
		var me=this;
		
		if(mulainya == 0){
			this.OnErrorClose = false	
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_form2';
			addCoverPage2(cover,1,true,false);	
		}
		
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=ImportTemplateBarang&mulainya='+mulainya,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if(resp.err==''){	
					if(resp.content.mulai < resp.content.jmlbarang){
						pemasukan_ins.AfterPilihTemplateBrg(resp.content.mulai);	
					}else{				
						$("#"+me.prefix+'_form2').remove();
						setTimeout(function myFunction() {me.rincianpenerimaan()},1000);	
					}
					setTimeout(function myFunction() {me.GetPersen(resp.content.maxpersen)},50);
				}else{
					alert(resp.err);	
					delElem(cover);
				}
		  	}
		});
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
						document.body.style.overflow='auto';		
						if(resp.err ==  ""){							
							me.rincianpenerimaan();	
						}else{													
							alert(resp.err);
						}
					}
				});			
		}
	},
	
	FormLoadingImport: function(){			
		var me = this;
		var err='';
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=FormLoadingImport',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ""){						
						document.getElementById(cover).innerHTML = resp.content;
						setTimeout(function myFunction() {me.AfterPilihTemplateBrg()},50);
					}else{
						alert(resp.err);	
						delElem(cover);	
					}
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	AmbilPemasukanDet:function(){
		document.getElementById('rinciandatabarangnya').innerHTML = 
			"<div id='pemasukan_ins_det_cont_title' style='position:relative'></div>"+
			"<div id='pemasukan_ins_det_cont_opsi' style='position:relative'>"+
			"</div>"+
			"<div id='pemasukan_ins_det_cont_daftar' style='position:relative'></div>"+
			"<div id='pemasukan_ins_det_cont_hal' style='position:relative'></div>"
			;
		pemasukan_ins_det.formName=this.formName;
		pemasukan_ins_det.loading();
	},
	
	Get_TanggalDok_Sumber:function(){
		var me = this;
		var err='';
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover2';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=Get_TanggalDok_Sumber',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);	
					document.body.style.overflow='auto';
					if(resp.err == ""){						
						document.getElementById("UntukTanggalBAST").innerHTML = resp.content;
						setTimeout(function myFunction() {me.nyalakandatepicker2()},1000);
						setTimeout(function myFunction() {me.nyalakandatepicker()},1000);
					}else{
						alert(resp.err);
					}
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	reload_carabayar: function(){
		var cara_bayar = document.getElementById("cara_bayar").value;
		var jns_transaksi = document.getElementById("jns_transaksi").value;
		
		if(jns_transaksi == "1"){
			if(cara_bayar == '1' || cara_bayar == '2'){
				document.getElementById("reload_carabayar").innerHTML = " <img src='images/administrator/images/reload_f2.png' style='width:20px;margin-bottom:-5px;' onclick='pemasukan_ins.Load_DataCaraBayar()' onmouseover='this.style.width=`23px`;' onmouseout='this.style.width=`20px`;' />";
			}else{
				document.getElementById("reload_carabayar").innerHTML = "";
			}
		}		
	},
	
	Load_DataCaraBayar:function(){
		var me = this;
		var err='';
		
		var cover = this.prefix+'_formcover2';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=Load_DataCaraBayar',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);	
				document.body.style.overflow='auto';
				if(resp.err == ""){									
					setTimeout(function myFunction() {me.rincianpenerimaan()},1000);
					setTimeout(function myFunction() {me.tabelRekening()},1000);
					if(resp.content.aktif == 1){
						document.getElementById('sumberdana').value = resp.content.sumberdana;
						document.getElementById('metodepengadaan').value = resp.content.metodepengadaan;
						document.getElementById('pencairan_dana').value = resp.content.pencairan_dana;
						document.getElementById('prog').value = resp.content.prog;
						document.getElementById('program').value = resp.content.program;
						document.getElementById('dafkeg').innerHTML = resp.content.dafkeg;
						document.getElementById('pekerjaan').value = resp.content.pekerjaan;
						document.getElementById('penyedian').value = resp.content.penyedian;
						document.getElementById('penerima').value = resp.content.penerima;
						document.getElementById('keterangan_penerimaan').value = resp.content.keterangan_penerimaan;
						
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
});
