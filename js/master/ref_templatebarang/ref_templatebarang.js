var ref_templatebarangSKPD2 = new SkpdCls({
	prefix : 'ref_templatebarangSKPD2', 
	formName: 'ref_templatebarangForm',
	
	pilihUrusanfter : function(){ref_templatebarang.refreshList(true);},
	pilihBidangAfter : function(){ref_templatebarang.refreshList(true);},
	pilihUnitAfter : function(){ref_templatebarang.refreshList(true);},
	pilihSubUnitAfter : function(){ref_templatebarang.refreshList(true);},
	pilihSeksiAfter : function(){ref_templatebarang.refreshList(true);}
});

var ref_templatebarang = new DaftarObj2({
	prefix : 'ref_templatebarang',
	url : 'pages.php?Pg=ref_templatebarang', 
	formName : 'ref_templatebarangForm',
	el_ID : 'KodeTemplateBarang',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	
	},
	
	
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	
	windowSave: function(){
		var me= this;
		//alert('save');
		var errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			//alert(box.value);
			this.idpilih = box.value;			
			var cover = 'birm_getdata';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				url: this.url+'&tipe=getdata&id='+this.idpilih,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					delElem(cover);
					if(resp.err==''){
						if(document.getElementById(me.el_ID)) document.getElementById(me.el_ID).value= resp.content;
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
	windowSaveAfter: function(){
		//alert('tes');
	},		
	
	windowShow: function(urlnya=''){
		var me = this;
		
		var cover = this.prefix+'_cover';
		
		if(urlnya == '')urlnya=this.formName;
		
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+urlnya).serialize(),
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
			data:$('#'+this.prefix+"_detForm").serialize(),
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
	
	Batal: function(){
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
			data:$('#'+this.prefix+"_detForm").serialize(),
			url: this.url+'&tipe=Batal',
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
	
	AfterFormBaru:function(){ 
		var me=this;
		me.AmbilRefTemplateDet();		
		setTimeout(function myFunction() {me.nyalakandatepicker()},1000);		
	},
	
	AfterFormEdit:function(){ 
		var me=this;
		me.AmbilRefTemplateDet();		
		setTimeout(function myFunction() {me.nyalakandatepicker()},1000);		
	},
	
	AmbilRefTemplateDet:function(){
		document.getElementById('det_barang').innerHTML = 
			"<div id='ref_templatebarang_det_cont_title' style='position:relative'></div>"+
			"<div id='ref_templatebarang_det_cont_opsi' style='position:relative'>"+
			"</div>"+
			"<div align='right'>"+					
			"<input type='button' name='tambah' id='tambah' value='Tambah'  onclick=\"javascript:ref_templatebarang_det.Baru(`"+this.prefix+"_detForm`)\" > "+
			" <input type='button' name='edit' id='edit' value='Ubah'  onclick=\"javascript:ref_templatebarang_det.Edit()\" > "+	
			" <input type='button' name='hapus' id='hapus' value='Hapus'  onclick=\"javascript:ref_templatebarang_det.Hapus()\" >"+
			"</div>"+
			"<div id='ref_templatebarang_det_cont_daftar' style='position:relative'></div>"+
			"<div id='ref_templatebarang_det_cont_hal' style='position:relative'></div>"
			;
		ref_templatebarang_det.loading();
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
	
	
	
	
});
