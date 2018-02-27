var cari_rekeningSkpd = new SkpdCls({
	prefix : 'cari_rekeningSkpd', formName:'cari_rekeningForm',
	
	pilihBidangAfter : function(){cari_rekening.refreshList(true);},
	pilihKelompokAfter : function(){cari_rekening.refreshList(true);},
	pilihSubKelompokAfter : function(){cari_rekening.refreshList(true);},
	pilihSekSubKelompokAfter : function(){cari_rekening.refreshList(true);}
});

var cari_rekening = new DaftarObj2({
	prefix :'cari_rekening',
	url : 'pages.php?Pg=cari_rekening', 
	formName : 'cari_rekeningForm',
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
		//	url: this.url+'&tipe=windowshow&filterRekening='+this.filterRekening,
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
	
	
	
	windowSave: function(id){
		var me= this;
			
			var cover = 'ref_rekening_getdata';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				url: 'pages.php?Pg=cari_rekening&tipe=getdata&id='+id,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					delElem(cover);
					if(resp.err==''){
					
						if(document.getElementById(me.el_kode_rekening)) document.getElementById(me.el_kode_rekening).value= resp.content.kode_rekening;
						if(document.getElementById(me.el_nama_rekening)) document.getElementById(me.el_nama_rekening).value= resp.content.nm_rekening;
						
						me.windowClose();
						me.windowSaveAfter();
					}else{
						alert(resp.err)	
					}
			  	}
			});		
		
	},
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	windowSaveAfter: function(){
		
	},
	
	
		
	detail: function(){
		//alert('detail');
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
	}
	
	
	
	
	
	
	
		
});
