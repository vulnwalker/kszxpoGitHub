var daftar_pengeluarankasSKPD = new SkpdCls({
	prefix : 'daftar_pengeluarankasSKPD', 
	formName: 'daftar_pengeluarankasForm',
	
	pilihUrusanfter : function(){daftar_pengeluarankas.refreshList(true);},
	pilihBidangAfter : function(){daftar_pengeluarankas.refreshList(true);},
	pilihUnitAfter : function(){daftar_pengeluarankas.refreshList(true);},
	pilihSubUnitAfter : function(){daftar_pengeluarankas.refreshList(true);},
	pilihSeksiAfter : function(){daftar_pengeluarankas.refreshList(true);}
});

var daftar_pengeluarankas = new DaftarObj2({
	prefix : 'daftar_pengeluarankas',
	url : 'pages.php?Pg=daftar_pengeluarankas', 
	formName : 'daftar_pengeluarankasForm',
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
	
	Baru: function(){			
		var me = this;
			
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=formBaru',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');				
				delElem(cover);
				document.body.style.overflow='auto';
				if(resp.err == ""){
					var aForm = document.getElementById(me.formName);		
					aForm.action= 'pages.php?Pg=form_pengeluarankas&YN=1';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
					aForm.target='_blank';
					aForm.submit();	
					aForm.target='';
				}else{
					alert(resp.err);
				}				
		  	}
		});		
		
	},
	
	Edit: function(){			
		var me = this;
			
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=formEdit',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');				
				delElem(cover);
				document.body.style.overflow='auto';
				if(resp.err == ""){
					var aForm = document.getElementById(me.formName);		
					aForm.action= 'pages.php?Pg=form_pengeluarankas&YN=2';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
					aForm.target='_blank';
					aForm.submit();	
					aForm.target='';
				}else{
					alert(resp.err);
				}				
		  	}
		});		
		
	},
	
});
