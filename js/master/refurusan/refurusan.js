var refurusan = new DaftarObj2({
	prefix : 'refurusan',
	url : 'pages.php?Pg=refurusan', 
	formName : 'refurusanForm',
	el_kode_urusan : '',
	el_nama_urusan: '',
	
	loading:function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
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
	
	BaruUrusan: function(){	
		var me = this;
		var err='';
	//	var kda =document.getElementById('fmc1').value;
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKA';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#refurusan_form').serialize(),
			  	url: this.url+'&tipe=BaruUrusan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},		
	
	BaruBidang: function(){	
		var me = this;
		var err='';
		var bk =document.getElementById('fmbk').value;
		
		
		if (bk==''){
			alert('Kode Urusan belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#refurusan_form').serialize(),
			  	url: this.url+'&tipe=BaruBidang',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
			  	}
			});
		}else{
		 	alert(err);
		}
		}	
	},
	
	SimpanUrusan: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KAform').serialize(),
			url: this.url+'&tipe=simpanUrusan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshUrusan(resp.content);
					me.Close1();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	refreshUrusan : function(id_UrusanBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=refurusan&tipe=refreshUrusan&id_UrusanBaru='+id_UrusanBaru,
		  type : 'POST',
		  data:$('#refurusan_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_bk').innerHTML = resp.content.bk;
			document.getElementById('cont_kc').innerHTML = resp.content.ck;

		  }
		});
	},
	
	SimpanBidang: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#refurusan_KBform').serialize(),
			url: this.url+'&tipe=simpanBidang',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshBidang(resp.content);
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	refreshBidang : function(id_BidangBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=refurusan&tipe=refreshBidang&id_BidangBaru='+id_BidangBaru,
		  type : 'POST',
		  data:$('#refurusan_KBform').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_ck').innerHTML = resp.content.ck;
			me.getKode_dk();
		  }
		});
	},
	
	getKode_dk : function(){
	var me = this; //alert('tes');	//alert(this.prefix);
		
		$.ajax({
		  url: 'pages.php?Pg=refurusan&tipe=getKode_dk',
		  type : 'POST',
		  //data:$('#adminForm').serialize(),
		  data:$('#refurusan_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('dk').value = resp.content.dk;
		  }
		});
	
	},		
	
	
	pilihUrusan : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=refurusan&tipe=pilihUrusan',
		  type : 'POST',
		  data:$('#refurusan_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
	
			document.getElementById('cont_ck').innerHTML = resp.content.ck;
			
		  }
		});
	},
	
	pilihBidang : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=refurusan&tipe=pilihBidang',
		  type : 'POST',
		  data:$('#refurusan_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('dk').value = resp.content.dk;
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
	
	Baru:function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,999,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=formBaru',
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
			
			
			var cover = 'ref_urusan_getdata';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				url: 'pages.php?Pg=ref_urusan&tipe=getdata&id='+this.idpilih,
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
	
	SimpanEdit: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanEdit',
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
