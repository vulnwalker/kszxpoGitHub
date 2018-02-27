var ref_pegawaiSkpd = new SkpdCls({
	prefix : 'ref_pegawaiSkpd', formName:'ref_pegawaiForm',
	
	pilihUrusanAfter : function(){ref_pegawai.refreshList(true);},
	pilihBidangAfter : function(){ref_pegawai.refreshList(true);},
	pilihUnitAfter : function(){ref_pegawai.refreshList(true);},
	pilihSubUnitAfter : function(){ref_pegawai.refreshList(true);},
	pilihSeksiAfter : function(){ref_pegawai.refreshList(true);}
});

var ref_pegawai = new DaftarObj2({
	prefix : 'ref_pegawai',
	url : 'pages.php?Pg=ref_pegawai', 
	formName : 'ref_pegawaiForm',
	
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
	
	windowSave: function(id){
		var me= this;
		/*var errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			this.idpilih = box.value;		*/	
			
			var cover = 'ref_pegawai_getdata';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				url: 'pages.php?Pg=ref_pegawai&tipe=getdata&id='+id,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					delElem(cover);
					if(resp.err==''){
					
						if(document.getElementById('nm_pegawai'))document.getElementById('nm_pegawai').value=resp.content.nm_pegawai;
						if(document.getElementById('nip_pegawai'))document.getElementById('nip_pegawai').value=resp.content.nip_pegawai;
						
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
	
	cariRekening: function(){
		var me = this;	
		ref_rekening3.windowShow();	
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
	}
	
});
