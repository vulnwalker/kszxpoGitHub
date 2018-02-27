// var refclosingdataPenyusutanSKPD = new SkpdCls({
// 	prefix : 'refclosingdataPenyusutanSKPD', formName:'refclosingdataPenyusutanForm', kolomWidth:120,
	
// 	pilihBidangAfter : function(){refclosingdataPenyusutan.refreshList(true);},
// 	pilihUnitAfter : function(){refclosingdataPenyusutan.refreshList(true);},
// 	pilihSubUnitAfter : function(){refclosingdataPenyusutan.refreshList(true);},
// 	pilihSeksiAfter : function(){refclosingdataPenyusutan.refreshList(true);}
// });

var refclosingdataPenyusutanSKPD2 = new SkpdCls({
	prefix : 'refclosingdataPenyusutanSKPD2', 
	formName: 'refclosingdataPenyusutanForm',
	
	pilihUrusanfter : function(){refclosingdataPenyusutan.refreshList(true);},
	pilihBidangAfter : function(){refclosingdataPenyusutan.refreshList(true);},
	pilihUnitAfter : function(){refclosingdataPenyusutan.refreshList(true);},
	pilihSubUnitAfter : function(){refclosingdataPenyusutan.refreshList(true);},
	pilihSeksiAfter : function(){refclosingdataPenyusutan.refreshList(true);}
});


var refclosingdataPenyusutan = new DaftarObj2({
	prefix : 'refclosingdataPenyusutan',
	url : 'pages.php?Pg=refclosingdataPenyusutan', 
	formName : 'refclosingdataPenyusutanForm',
	el_kode_urusan : '',
	el_nama_urusan: '',
	
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




	
	Closing:function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,999,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=formClosing',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					document.getElementById(cover).innerHTML = resp.content;			
					me.AfterFormBaru(resp);	
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}			
				
		  	}
		});
	},




		ClosingPenyusutan:function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,999,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=formClosing1',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					document.getElementById(cover).innerHTML = resp.content;			
					me.AfterFormBaru(resp);	
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}			
				
		  	}
		});
	},

	
	windowShow: function(){
		var me = this;
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,999,true,false);	
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

		Hapus:function(){
		var me = this;

		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=hapus',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					me.refreshList(true);
				}else{
					alert(resp.err);
					
				}			
				
		  	}
		});
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
			
			
			var cover = 'refclosingdataPenyusutan_getdata';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				url: 'pages.php?Pg=refclosingdataPenyusutan&tipe=getdata&id='+this.idpilih,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					delElem(cover);
					if(resp.err==''){
						if(document.getElementById(me.el_kode_urusan)) document.getElementById(me.el_kode_urusan).value= resp.content.kode_urusan;
						if(document.getElementById(me.el_nama_urusan)) document.getElementById(me.el_nama_urusan).value= resp.content.nama_urusan;
						
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
	
		
	AfterSimpan : function(){
		if(document.getElementById('Kunjungan_cont_daftar')){
		this.refreshList(true);}
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
	}
});
