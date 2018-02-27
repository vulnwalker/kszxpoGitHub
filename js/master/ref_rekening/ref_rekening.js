var ref_rekeningSkpd = new SkpdCls({
	prefix : 'ref_rekeningSkpd', formName:'ref_rekeningForm',
	
	pilihBidangAfter : function(){ref_rekening.refreshList(true);},
	pilihKelompokAfter : function(){ref_rekening.refreshList(true);},
	pilihSubKelompokAfter : function(){ref_rekening.refreshList(true);},
	pilihSekSubKelompokAfter : function(){ref_rekening.refreshList(true);}
});

var ref_rekening = new DaftarObj2({
	prefix : 'ref_rekening',
	url : 'pages.php?Pg=ref_rekening', 
	formName : 'ref_rekeningForm',
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	
	},
	
	windowShow: function(){
		var me = this;
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=windowshow',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				if(resp.err==''){
					document.getElementById(cover).innerHTML = resp.content;	
					me.loading();					
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}
		  	}
		});
	},
	
	Simpan_k: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan_k',
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
	},
	
	Simpan_l: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan_l',
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
	},
	
	Simpan_m: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan_m',
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
	},
	
	
	Simpan_n: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan_n',
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
	},
	
	Simpan_o: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan_n',
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
	},
	
	windowSave: function(){
		var me= this;
		var errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			this.idpilih = box.value;			
			
			var cover = 'ref_rekening_getdata';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				url: 'pages.php?Pg=ref_rekening&tipe=getdata&id='+this.idpilih,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					delElem(cover);
					if(resp.err==''){
					
						if(document.getElementById('kode_rekening'))document.getElementById('kode_rekening').value=resp.content.kode_rekening;
						if(document.getElementById('nm_rekening'))document.getElementById('nm_rekening').value=resp.content.nm_rekening;
						
						me.windowClose();
						me.windowSaveAfter();
					}else{
						alert(resp.err)	
					}
			  	}
			});		
		}else{
			alert(errmsg);
		}
	},
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	windowSaveAfter: function(){
		
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
					data:$('#ref_rekening_form').serialize(),
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
	
	pilihKA : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_rekening&tipe=pilihKA',
		  type : 'POST',
		  data:$('#ref_rekening_form').serialize(), 
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kb').innerHTML = resp.content.kb;
			document.getElementById('cont_kc').innerHTML = resp.content.kc;
			document.getElementById('cont_kd').innerHTML = resp.content.kd;
		  }
		});
	},
	
	pilihKB : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_rekening&tipe=pilihKB',
		  type : 'POST',
		  data:$('#ref_rekening_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kc').innerHTML = resp.content.kc;
			document.getElementById('cont_kd').innerHTML = resp.content.kd;
		  }
		});
	},
	
	pilihKC : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_rekening&tipe=pilihKC',
		  type : 'POST',
		  data:$('#ref_rekening_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kd').innerHTML = resp.content.unit;
		  }
		});
	},
	
	pilihKD : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_rekening&tipe=pilihKD',
		  type : 'POST',
		  data:$('#ref_rekening_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('ke').value = resp.content.ke;
		  }
		});
	},
	
	detail: function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();			
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
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_rekening_form').serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;
					document.getElementById('kode1').focus();			
					me.AfterFormBaru();
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	BaruKB: function(){	
		var me = this;
		var err='';
		var kda =document.getElementById('fmKA').value;
		
		
		if (kda==''){
			alert('kode Rekening belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_rekening_form').serialize(),
			  	url: this.url+'&tipe=formBaruKB',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		}
	},		
	
	BaruKC: function(){	
		var me = this;
		var err='';
		var kda =document.getElementById('fmKA').value;
		var kdb =document.getElementById('fmKB').value;
		
		if (kda==''|| kdb==''){
			alert('kode Akun / Kode Kelompok belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKC';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_rekening_form').serialize(),
			  	url: this.url+'&tipe=formBaruKC',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		}
	},	
	
	BaruKD: function(){	
		var me = this;
		var err='';
		var kda =document.getElementById('fmKA').value;
		var kdb =document.getElementById('fmKB').value;
		var kdc =document.getElementById('fmKC').value;
		
		if (kda==''|| kdb==''|| kdc==''){
			alert('kode Akun / Kode Kelompok / Kode Jenis belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKD';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_rekening_form').serialize(),
			  	url: this.url+'&tipe=formBaruKD',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
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
				data:$('#ref_rekeningForm').serialize(),
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
	
	Mapping:function(){
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
				data:$('#ref_rekeningForm').serialize(),
				url: this.url+'&tipe=formMapping',
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
	
	cari_rekening: function(){
		var me = this;	
		cari_rekening.el_kode_rekening = 'kode_rekening';
		cari_rekening.el_nama_rekening = 'nm_rekening';
		cari_rekening.windowSaveAfter= function(){};
		cari_rekening.windowShow();	
	},
	
	cari_akun_1: function(){
		var me = this;
		cari_akun.el_kode_jurnal = 'kode_akun';
		cari_akun.el_nama_jurnal = 'nama_akun';
		cari_akun.windowSaveAfter= function(){};	
		cari_akun.windowShow();	
	},
	
	cari_akun_2: function(){
		cari_akun.el_kode_jurnal = 'kode_mapping1';
		cari_akun.el_nama_jurnal = 'nm_mapping1';
		cari_akun.windowSaveAfter= function(){};	
		cari_akun.windowShow();	
	},
	
	cari_akun_3: function(){
		cari_akun.el_kode_jurnal = 'kode_mapping2';
		cari_akun.el_nama_jurnal = 'nm_mapping2';
		cari_akun.windowSaveAfter= function(){};	
		cari_akun.windowShow();	
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
	
	refreshKB : function(id_KBBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_rekening&tipe=refreshKB&id_KBBaru='+id_KBBaru,
		  type : 'POST',
		  data:$('#ref_rekening_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kb').innerHTML = resp.content.kb;
			document.getElementById('cont_kc').innerHTML = resp.content.kc;
			document.getElementById('cont_kd').innerHTML = resp.content.kd;
		//	me.getKodeB();
		  }
		});
	},
	
	refreshKC : function(id_KCBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_rekening&tipe=refreshKC&id_KCBaru='+id_KCBaru,
		  type : 'POST',
		  data:$('#ref_rekening_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kc').innerHTML = resp.content.unit;
		//	me.getKodeB();
		  }
		});
	},
	
	refreshKD : function(id_KDBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_rekening&tipe=refreshKD&id_KDBaru='+id_KDBaru,
		  type : 'POST',
		  data:$('#ref_rekening_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kd').innerHTML = resp.content.unit;
		me.getKode_o();
		  }
		});
	},
	
	getKode_o : function(){
	var me = this; //alert('tes');	//alert(this.prefix);
		
		$.ajax({
		  url: 'pages.php?Pg=ref_rekening&tipe=getKode_o',
		  type : 'POST',
		  //data:$('#adminForm').serialize(),
		  data:$('#ref_rekening_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('ke').value = resp.content.ke;
		  }
		});
	
	},
	
	Close2:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close3:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKC';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close4:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKD';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close5:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKE';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	SimpanKB: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize(),
			url: this.url+'&tipe=simpanKB',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshKB(resp.content);
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	SimpanKC: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKC';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KCform').serialize(),
			url: this.url+'&tipe=simpanKC',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshKC(resp.content);
					me.Close3();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanKD: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKD';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KDform').serialize(),
			url: this.url+'&tipe=simpanKD',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshKD(resp.content);
					me.Close4();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanEdit: function(){
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
			data:$('#ref_rekening_form').serialize(),
			url: this.url+'&tipe=simpanEdit',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					alert('Data berhasil disimpan');
					me.Close();
					me.refreshList(true);
					me.AfterSimpan();	
				}
				else{
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
					me.Close();
					me.AfterSimpan();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanMapping: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanMapping',
		//	url: this.url+'&tipe=simpanMapping&tambah_mapping=0',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				
				
				
				if(resp.err==''){
				alert("Data Tersimpan");
			
				if (confirm('Input Lagi ?')) {
					$.ajax({
					type:'POST', 
					data:$('#ref_rekeningForm').serialize(),
					url: this.url+'&tipe=formMapping',
			  		success: function(data) {		
						var resp = eval('(' + data + ')');
						delElem(cover);	
						if (resp.err ==''){		
							document.getElementById('kode_rekening').value ='' ;
							document.getElementById('nm_rekening').value ='' ;
							document.getElementById('kode_akun').value ='' ;
							document.getElementById('nama_akun').value ='' ;
							document.getElementById('kode_mapping1').value ='' ;
							document.getElementById('nm_mapping1').value ='' ;
							document.getElementById('kode_mapping2').value ='' ;
							document.getElementById('nm_mapping2').value ='' ;
							document.getElementById(cover).innerHTML = resp.content;
							
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});
					
					
				}else{
					delElem(cover);	
					me.Close();
					me.AfterSimpan();
				}
					
					
				}/*else{
					me.Close();
					me.AfterSimpan();
				}*/
		  	}
		});
	}
	
	
		
});
