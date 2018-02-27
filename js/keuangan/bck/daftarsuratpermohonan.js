var daftarsuratpermohonanSKPD = new SkpdCls({
	prefix : 'daftarsuratpermohonanSKPD', formName:'daftarsuratpermohonanForm', kolomWidth:120,
	
	pilihBidangAfter : function(){daftarsuratpermohonan.refreshList(true);},
	pilihUnitAfter : function(){daftarsuratpermohonan.refreshList(true);},
	pilihSubUnitAfter : function(){daftarsuratpermohonan.refreshList(true);},
	pilihSeksiAfter : function(){daftarsuratpermohonan.refreshList(true);}
});

var daftarsuratpermohonanSKPD2 = new SkpdCls({
	prefix : 'daftarsuratpermohonanSKPD2', 
	formName: 'daftarsuratpermohonanForm',
	
	pilihUrusanfter : function(){daftarsuratpermohonan.refreshList(true);},
	pilihBidangAfter : function(){daftarsuratpermohonan.refreshList(true);},
	pilihUnitAfter : function(){daftarsuratpermohonan.refreshList(true);},
	pilihSubUnitAfter : function(){daftarsuratpermohonan.refreshList(true);},
	pilihSeksiAfter : function(){daftarsuratpermohonan.refreshList(true);}
});

var daftarsuratpermohonan = new DaftarObj2({
	prefix : 'daftarsuratpermohonan',
	url : 'pages.php?Pg=daftarsuratpermohonan', 
	formName : 'daftarsuratpermohonanForm',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	
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
	BaruSPP: function(){	
		var me = this;
		if(me.CekKeFORM("spp") == 1){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=PengecekanUbahSPP',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						var aForm = document.getElementById(me.formName);		
						aForm.action= 'pages.php?Pg=suratpermohonan_spp&YN=2';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
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
	
	BaruSPM: function(){
		var me = this;
		if(me.CekKeFORM("spm") == 1){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=PengecekanUbahSPM',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						var aForm = document.getElementById(me.formName);		
						aForm.action= 'pages.php?Pg=suratpermohonan_spm&YN=2';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
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
	
	CekKeFORM: function(SPnya="spp"){
		var me = this;
		var kembali = 0;
		errmsg = this.CekCheckbox();
		if(errmsg =='Data belum dipilih!'){ 
			errmsg = '';
			skpd = document.getElementById('ver_skpd').value ;
				c1n = document.getElementById(me.prefix+'SKPD2fmURUSAN');
				cn = document.getElementById(me.prefix+'SKPD2fmSKPD');
				dn = document.getElementById(me.prefix+'SKPD2fmUNIT');
				en = document.getElementById(me.prefix+'SKPD2fmSUBUNIT');
				e1n = document.getElementById(me.prefix+'SKPD2fmSEKSI');
			
			if(c1n != '' && skpd != 1){
				if(errmsg == '' && c1n.value == '0')errmsg = "URUSAN Belum di Pilih ! ";
			}
			if(errmsg == '' && cn.value == '00')errmsg = "BIDANG Belum di Pilih ! ";
			if(errmsg == '' && dn.value == '00')errmsg = "SKPD Belum di Pilih ! ";
			if(errmsg == '' && en.value == '00')errmsg = "UNIT Belum di Pilih ! ";
			if(errmsg == '' && e1n.value == '000')errmsg = "SUB UNIT Belum di Pilih ! ";
			
			if(errmsg ==''){ 					
				var aForm = document.getElementById(me.formName);		
				aForm.action= 'pages.php?Pg=suratpermohonan_'+SPnya+'&YN=1';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
				aForm.target='_blank';
				aForm.submit();	
				aForm.target='';
			}else{
					alert(errmsg);
			}	
		}else if(errmsg == "Pilih Hanya Satu Data!"){
			alert(errmsg);
		}else{
			kembali = 1;
		}
		
		return kembali;
	},
	
	BaruSP2D: function(){
		alert("Belum Tersedia !");	
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
					if(me.daftarsuratpermohonan_form==0){
						me.Close();
						me.AfterSimpan();						
					}else{
						me.Close();
						barang.refreshCombodaftarsuratpermohonan();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	Coba: function(JNS='',Nama_Form=''){
		alert("dsgd");
	},
	
	BaruNamaPejabat: function(JNS='',Nama_Form=''){	
		
		var me = this;
		var err='';
		
		if(Nama_Form == "")Nama_Form=me.formName;
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+Nama_Form).serialize(),
			  	url: this.url+'&tipe=BaruNamaPejabat&jns='+JNS,
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
	
	SimpanNamaPejabat: function(){
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
			url: this.url+'&tipe=SimpanNamaPejabat',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					document.getElementById("jns_"+resp.content.jns).innerHTML = resp.content.value;
					me.Close();	
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
		
});
