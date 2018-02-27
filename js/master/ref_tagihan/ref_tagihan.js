var ref_tagihan = new DaftarObj2({
	prefix : 'ref_tagihan',
	url : 'pages.php?Pg=ref_tagihan', 
	formName : 'ref_tagihanForm',
	el_kode_urusan : '',
	el_nama_urusan: '',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
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
	
	filterRenderAfter: function(){
		var me =this;
		me.nyalakandatepicker();
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
	
	Close1:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKA';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	SimpanKategori: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KAform').serialize(),
			url: this.url+'&tipe=simpanKategori',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshKategori(resp.content);
					me.Close1();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	refreshKategori : function(id_KategoriBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_perda&tipe=refreshKategori&id_KategoriBaru='+id_KategoriBaru,
		  type : 'POST',
		  data:$('#ref_perda_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_kategori').innerHTML = resp.content.Kategori;
			
		  }
		});
	},
	
	BaruKategori: function(){	
		var me = this;
		var err='';
	//	var kdc1 =document.getElementById('datac1').value;
	//	if(err=='' && (kdc1=='9') ) err='Tidak bisa tambah baru urusan sudah batas maximal 9 !!';
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKA';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_perda_form').serialize(),
			  	url: this.url+'&tipe=BaruKategori',
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
	
	Baru:function(){
		
		var urusan = document.getElementById('fmUrusan').value; 
		var skpd = document.getElementById('fmBidang').value; 
		var unit = document.getElementById('fmSkpd').value;
		var me = this;
		
		/*errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();*/
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						setTimeout(function myFunction() {ref_tagihan.nyalakandatepicker()},1000);
					//	me.uploadIni();
//						me.AfterFormEdit(resp);
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});
		/*}else{
			alert(errmsg);
		}*/
		
	},
	
	EditKategori: function(){	
		var me = this;
		var err='';
		var kd =document.getElementById('fmKategori').value;
		if(err=='' && (kd=='') ) err='Kategori Belum Di Pilih !!';
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKA';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_perda_form').serialize(),
			  	url: this.url+'&tipe=EditKategori',
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
	
	
	HapusKategori1: function(){	
		var me = this;
		var err='';
		var kd =document.getElementById('fmKategori').value;
		if(err=='' && (kd=='') ) err='Kategori Belum Di Pilih !!';
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKA';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_perda_form').serialize(),
			  	url: this.url+'&tipe=HapusKategori',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;
					document.getElementById('cont_kategori').value = resp.content;
							
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},	
	
	
	HapusKategori: function(){
		var me= this;	
		var err='';
		var kd =document.getElementById('fmKategori').value;
		if(err=='' && (kd=='') ) err='Kategori Belum Di Pilih !!';
		if (err =='' ){		
			this.OnErrorClose = false	
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formcoverKA';
			addCoverPage2(cover,1,true,false);	
			
			$.ajax({
				type:'POST', 
				data:$('#ref_perda_form').serialize(),
				url: this.url+'&tipe=HapusKategori',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);
				//	me.Close();
					if(resp.err==''){
					//	document.getElementById('urut').innerHTML = "";
						document.getElementById('cont_kategori').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
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
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formEdit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						setTimeout(function myFunction() {ref_tagihan.nyalakandatepicker()},1000);
//						me.AfterFormEdit(resp);
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
	
	AfterFormBaru:function(){  
		//idp = document.getElementById('PenerimaanBarang_idplh').value;
		c = document.getElementById('PenerimaanBarangSKPDfmSKPD').value;
		d = document.getElementById('PenerimaanBarangSKPDfmUNIT').value;
		e = document.getElementById('PenerimaanBarangSKPDfmSUBUNIT').value;
		e1 = document.getElementById('PenerimaanBarangSKPDfmSEKSI').value;
		document.getElementById('c').value=c;
		document.getElementById('d').value=d;
		document.getElementById('e').value=e;
		document.getElementById('e1').value=e1;
		document.getElementById('detailbarang').innerHTML = 
			//"<div id='DaftarBarangDetail_cont_title' style='position:relative'></div>"+
			"<div id='DaftarBarangDetail_cont_opsi' style='position:relative'>"+
			"<input type='hidden' name='idp' id='idp' value='"+idp+"'>"+
			"</div>"+
			"<div align='right'>"+					
			"<input type='button' name='tambah' id='tambah' value='Tambah'  onclick=\"javascript:DaftarBarangDetail.Baru()\" >"+
			"<input type='button' name='edit' id='edit' value='Edit'  onclick=\"javascript:DaftarBarangDetail.Edit()\" >"+	
			"<input type='button' name='hapus' id='hapus' value='Hapus'  onclick=\"javascript:DaftarBarangDetail.Hapus()\" >"+
			"</div>"+
			"<div id='DaftarBarangDetail_cont_daftar' style='position:relative'></div>"+
			"<div id='DaftarBarangDetail_cont_hal' style='position:relative'></div>"
			;
		//generate data
	   DaftarBarangDetail.loading();
	},
	
	
	
	
	
	AfterFormEdit:function(){ 
		//idp = document.getElementById('PenerimaanBarang_idplh').value;
		document.getElementById('detailbarang').innerHTML = 
			"<div id='detailbarang_cont_title' style='position:relative'></div>"+
			"<div id='detailbarang_cont_opsi' style='position:relative'>"+
			//"<input type='hidden' name='idp' id='idp' value='"+idp+"'>"+
			"</div>"+
			"<div align='right'>"+					
			"<input type='button' name='tambah' id='tambah' value='Tambah'  onclick=\"javascript:detailbarang.Baru()\" >"+
			"<input type='button' name='edit' id='edit' value='Edit'  onclick=\"javascript:detailbarang.Edit()\" >"+	
			"<input type='button' name='hapus' id='hapus' value='Hapus'  onclick=\"javascript:detailbarang.Hapus()\" >"+
			"</div>"+
			"<div id='detailbarang_cont_daftar' style='position:relative'></div>"+
			"<div id='detailbarang_cont_hal' style='position:relative'></div>"
			;
		//generate data
	   detailbarang.loading();
	},
	
	Batal: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=batal',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					if(me.satuan_form==0){
						me.Close();
					}else{
						me.Close();
					}
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

		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				me.daftarRender();	
					
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					if(me.satuan_form==0){
						me.Close();		
					}else{
						me.Close();
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	pilihUrusan : function(){
	var me = this; 
		
		$.ajax({
		  url: 'pages.php?Pg=ref_tagihan&tipe=pilihUrusan',
		  type : 'POST',
		  data:$('#'+this.prefix+'_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_c').innerHTML = resp.content.c;
			document.getElementById('cont_d').innerHTML = resp.content.d;
		  }
		});
	},
	
	
	
	pilihBidang : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_tagihan&tipe=pilihBidang',
		  type : 'POST',
		  data:$('#'+this.prefix+'_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_d').innerHTML = resp.content.d;
			
		  }
		});
	},
	
	/*pilihSKPD : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_tagihan&tipe=pilihSKPD',
		  type : 'POST',
		  data:$('#'+this.prefix+'_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('e1').value = resp.content.e1;
		  }
		});
	},
*/	
	
	
	// Update Syfa--- Jangan Di Rubah ------------------------------------------------------------------------------
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	
	windowShow: function(namaform=''){
		var me = this;		
		var cover = this.prefix+'_cover';		
		
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+namaform).serialize(),
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
	
	Get_PilData: function(Id){
		var me=this;
		me.windowClose();
		if(document.getElementById("refid_nomor_tagihan"))document.getElementById("refid_nomor_tagihan").value=Id;
		me.AfterGetPilData();
	},
	
	AfterGetPilData:function(){
		var me=this;
	},
	
	//Update End ---------------------------------------------------------------------------------------------------
	
});