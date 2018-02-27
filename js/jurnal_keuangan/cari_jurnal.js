var cari_jurnal = new DaftarObj2({
	prefix : 'cari_jurnal',
	url : 'pages.php?Pg=cari_jurnal', 
	formName : 'cari_jurnalForm',
	el_kode_account : '',
	el_nama_account: '',
	el_tahun_account:'',
	filterAkun : '',
	
	loading:function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
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
	
	
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	windowSaveAfter: function(){
		
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
	
	pilihKA : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=refakun&tipe=pilihKA',
		  type : 'POST',
		  data:$('#RefAkun_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kb').innerHTML = resp.content.unit;
		  }
		});
	},
	
	pilihKB : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=refakun&tipe=pilihKB',
		  type : 'POST',
		  data:$('#RefAkun_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kc').innerHTML = resp.content.unit;
		  }
		});
	},
	
	pilihKC : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=refakun&tipe=pilihKC',
		  type : 'POST',
		  data:$('#RefAkun_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kd').innerHTML = resp.content.unit;
		  }
		});
	},
	
	pilihKD : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=refakun&tipe=pilihKD',
		  type : 'POST',
		  data:$('#RefAkun_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('ke').value = resp.content.ke;
			//document.getElementById('cont_ke').innerHTML = resp.content.unit;
			//document.getElementById('j').value = resp.content.j;
		  }
		});
	},
	
	pilihKE : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=refakun&tipe=pilihKE',
		  type : 'POST',
		  data:$('#RefAkun_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kf').innerHTML = resp.content.unit;
		  }
		});
	},
	
	BaruKB: function(){	
		var me = this;
		var err='';
		var kda =document.getElementById('fmKA').value;
		
		if (kda==''){
			alert('kode Akun belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#RefAkun_form').serialize(),
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
				data:$('#RefAkun_form').serialize(),
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
				data:$('#RefAkun_form').serialize(),
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
	
	BaruKE: function(){	
		var me = this;
		var err='';
		var kda =document.getElementById('fmKA').value;
		var kdb =document.getElementById('fmKB').value;
		var kdc =document.getElementById('fmKC').value;
		var kdd =document.getElementById('fmKD').value;
		
		if (kda==''|| kdb==''|| kdc==''){
			alert('kode Akun / Kode Kelompok / Kode Jenis / Kode Objek belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKE';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#RefAkun_form').serialize(),
			  	url: this.url+'&tipe=formBaruKE',
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
	
	windowShow: function(Id){
		var me = this;
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=windowshow&Id='+Id,
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
		
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	
	
	windowSave: function(idnya){
		var me= this;
		/*var errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			this.idpilih = box.value;		*/	
			
			var cover = 'ref_bank2_getdata';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				url: 'pages.php?Pg=cari_jurnal&tipe=getdata&id='+idnya,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					delElem(cover);
					if(resp.err==''){
						drId=document.getElementById('drId').value;
						if(document.getElementById('Id_jurnal'))document.getElementById('Id_jurnal').value=resp.content.Id_jurnal;
						document.getElementById('namajurnal_'+drId).innerHTML=resp.content.namajurnal_;
						
						me.windowClose();
						me.windowSaveAfter();
					}else{
						alert(resp.err)	
					}
			  	}
			});
	},	
	windowSaveAfter: function(){
		//alert('tes');
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
					//data:$('#RefAkun_form').serialize(),
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
	
		
	AfterSimpan : function(){
		if(document.getElementById('Kunjungan_cont_daftar')){
		this.refreshList(true);}
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
			data:$('#'+this.prefix+'_form').serialize(),
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
	
	SimpanKE: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKE';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KEform').serialize(),
			url: this.url+'&tipe=simpanKE',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshKE(resp.content);
					me.Close5();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	refreshKB : function(id_KBBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=refakun&tipe=refreshKB&id_KBBaru='+id_KBBaru,
		  type : 'POST',
		  data:$('#RefAkun_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kb').innerHTML = resp.content.unit;
		//	me.getKodeB();
		  }
		});
	},
	
	refreshKC : function(id_KCBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=refakun&tipe=refreshKC&id_KCBaru='+id_KCBaru,
		  type : 'POST',
		  data:$('#RefAkun_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kc').innerHTML = resp.content.unit;
		//	me.getKodeC();
		  }
		});
	},
	
	refreshKD : function(id_KDBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=refakun&tipe=refreshKD&id_KDBaru='+id_KDBaru,
		  type : 'POST',
		  data:$('#RefAkun_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kd').innerHTML = resp.content.unit;
			me.getKodeE();
		  }
		});
	},
	
	refreshKE : function(id_KEBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=refakun&tipe=refreshKE&id_KEBaru='+id_KEBaru,
		  type : 'POST',
		  data:$('#RefAkun_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_ke').innerHTML = resp.content.unit;
		//	me.getKodeC();
		  }
		});
	},
	
	
	getKodeE : function(){
	var me = this; //alert('tes');	//alert(this.prefix);
		
		$.ajax({
		  url: 'pages.php?Pg=refakun&tipe=getKodeE',
		  type : 'POST',
		  //data:$('#adminForm').serialize(),
		  data:$('#RefAkun_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('ke').value = resp.content.ke;
		  }
		});
	
	},
});
