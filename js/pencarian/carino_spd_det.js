var carino_spd_det = new DaftarObj2({
	prefix : 'carino_spd_det',
	url : 'pages.php?Pg=carino_spd_det', 
	formName : 'carino_spd_detForm',
	satuan_form : '0',//default js satuan
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
	
	windowBatal: function(){
		var me = this;
		
		var cover = this.prefix+'_cover1';	
		
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=windowBatal',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');									
				delElem(cover);	
				if(resp.err==''){
					me.windowClose();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	windowSimpan_After: function(){
		var me=this;
	},
	
	windowSimpan: function(){
		var me = this;
		
		var cover = this.prefix+'_cover1';	
		
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=windowSimpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');									
				delElem(cover);	
				if(resp.err==''){
					me.windowBatal();
					me.windowSimpan_After(resp.content);
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
	
	Get_PilData: function(id){
		var me = this;
		
		var cover = this.prefix+'_cover1';	
		
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=pilData&id='+id,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
									
				delElem(cover);	
				if(resp.err==''){
					me.windowClose();
					DataPengaturan.Set_cekDcID_val("refid_spd_det",resp.content);
					me.AfterGet_PilData();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	AfterGet_PilData: function(){
		var me=this;	
	},
	
	windowShow: function(dariForm=''){
		var me = this;
		
		var cover = this.prefix+'_cover';	
		if(dariForm == "")dariForm=this.formName;
		
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+dariForm).serialize(),
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
		
	Simpan: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
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
	
	Set_cb_Temp: function(Id, urut){			
		var me = this;		
		status=0;
		if(document.getElementById(me.prefix+"_cb"+urut).checked == true){
			status=1;
		}
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=Set_cb_Temp&IdNomorSPD='+Id+'&status_id='+status,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');				
				
		  	}
		});
	},
		
});
