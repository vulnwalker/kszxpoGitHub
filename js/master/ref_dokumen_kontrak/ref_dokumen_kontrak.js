var ref_dokumen_kontrakSKPD2 = new SkpdCls({
	prefix : 'ref_dokumen_kontrakSKPD2', 
	formName: 'ref_dokumen_kontrakForm',
});

var ref_dokumen_kontrak = new DaftarObj2({
	prefix : 'ref_dokumen_kontrak',
	url : 'pages.php?Pg=ref_dokumen_kontrak', 
	formName : 'ref_dokumen_kontrakForm',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
		
	},
	
	filterRenderAfter: function(){
		var me =this;
		DataPengaturan.nyalakandatepicker2();
	},
	
	AfterFormBaru: function(resp){
		var me =this;
		DataPengaturan.nyalakandatepicker2();		
	},
	
	AfterFormEdit: function(resp){
		var me =this;
		DataPengaturan.nyalakandatepicker2();		
	},
	
	Edit:function(dicek=1){
		var me = this;
		var proses = true;
		var errmsg = "";
		if(dicek == 1){
			errmsg = this.CekCheckbox();
			if(errmsg ==''){ 
				var box = this.GetCbxChecked();
			}else{
				alert(errmsg);
			}
		}
		
		if(errmsg == ""){
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
			data:$('#ref_dokumen_kontrak_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					me.Close();
					me.AfterSimpan(resp.content);
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
	
	AfterHapus:function(){
		var me =this;
		me.refreshList(true);
	},
	
	Hapus:function(dicek=1){
		
		var me =this;
		var proses = true;
		if(dicek == 1){
			if(document.getElementById(this.prefix+'_jmlcek')){
				var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;	
			}else{
				var jmlcek = '';
			}
			
			if(jmlcek ==0){
				alert('Data Belum Dipilih!');
			}else{
				var hasil = confirm('Hapus '+jmlcek+' Data ?');
			}
		}else{
			var hasil = confirm('Hapus Data ?');	
		}		
		
		if(hasil == true){
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
						me.AfterHapus();
					}else{
						alert(resp.err);
					}							
					
			  	}
			});
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
	
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	
	windowShow: function(urlnya='', dari_jenis='', vers=''){//1=Retensi
		var me = this;
		
		var cover = this.prefix+'_cover';
		
		if(urlnya == '')urlnya=this.formName;
		
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+urlnya).serialize(),
			url: this.url+'&tipe=windowshow&dari_jenis='+dari_jenis+'&vers='+vers,
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
	
	PilDokumenKontrak:function(Idnya){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=PilDokumenKontrak&Idnya='+Idnya,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				document.body.style.overflow='auto';	
				delElem(cover);		
				if(resp.err==''){
					if(document.getElementById("tgl_dokcopy"))document.getElementById("tgl_dokcopy").value=resp.content.tgl_dokcopy;
					if(document.getElementById("tgl_dok"))document.getElementById("tgl_dok").value=resp.content.tgl_dok;
					if(document.getElementById("nomdok"))document.getElementById("nomdok").value=resp.content.nomor_dok;
					if(document.getElementById("nomdok_copy"))document.getElementById("nomdok_copy").value=resp.content.nomor_dok;
					me.AfterwindowSave(resp.content);
					me.windowClose();	 				
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	AfterwindowSave:function(konten){
		var me=this;	
	},
	
});
