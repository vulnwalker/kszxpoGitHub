var RuangPilihSkpd = new SkpdCls({
	prefix : 'RuangPilihSkpd', formName:'RuangPilih_Form'
});
var RuangPilih = new DaftarObj2({
	prefix : 'RuangPilih',
	url : 'pages.php?Pg=RuangPilih', 
	formName : 'RuangPilih_Form',
	idpilih:'',
	fmURUSAN:'',
	fmSKPD:'',
	fmUNIT:'',
	fmSUBUNIT:'',
	fmSEKSI:'',
	

	el_idpegawai: 'ref_idpemegang',
	el_nip: 'nip1',
	el_nama: 'nama1',
	el_jabat: 'jbt1',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	
	},
	
	cariPegawai: function(){
		var me = this;
		fnCariPegawai.windowShow();	
	},
	
	pilihGedungPil : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihGedungPil',
		  type : 'POST',
		  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('q').value = resp.content.q;
		  }
		});
	},
	
	pilihUrusanPil : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihUrusanPil',
		  type : 'POST',
		//  data:$('#'+this.formName).serialize(),
		  data:$('#RuangPilih_form').serialize(),
		//  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_c').innerHTML = resp.content.unit;
			document.getElementById('cont_d').innerHTML = resp.content.bid;
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
		  }
		});
	},
	
	pilihBidangPil : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihBidangPil',
		  type : 'POST',
		  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_d').innerHTML = resp.content.bid;
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
		  }
		});
	},
	
	pilihSKPDPil : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihSKPDPil',
		  type : 'POST',
		  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
		  }
		});
	},
	
	
	pilihUnitPil : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihUnitPil',
		  type : 'POST',
		  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
			
		  }
		});
	},
	
	pilihSubUnitPil : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihSubUnitPil',
		  type : 'POST',
		  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_gd').innerHTML = resp.content.unit;
			
		  }
		});
	},
	
	getGedungPil : function(){
	var me = this; //alert('tes');	//alert(this.prefix);
		
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=getGedungPil',
		  type : 'POST',
		  //data:$('#adminForm').serialize(),
		  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('q').value = resp.content.q;
		  }
		});
	
	},
	
	refreshGedungPil : function(id_GedungBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=refreshGedungPil&id_GedungBaru='+id_GedungBaru,
		  type : 'POST',
		  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_gd').innerHTML = resp.content.unit;
			me.getGedungPil();
		  }
		});
	},
	
	SimpanGedungPil: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize(),
			url: this.url+'&tipe=simpanGedungPil',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshGedungPil(resp.content);
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},	
	
	BaruGedungPil: function(){	
		var me = this;
		var err='';
		var c1 =document.getElementById('fmc1').value;
		var c =document.getElementById('fmc').value;
		var d =document.getElementById('fmd').value;
		var e =document.getElementById('fme').value;
		var e1 =document.getElementById('fme1').value;
		
		if (c1=='' | c=='' | d=='' | e=='' | e1==''){
			alert('KODE URUSAN || KODE BIDANG || KODE SKPD || UNIT || SUN UNIT belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#RuangPilih_form').serialize(),
			  	url: this.url+'&tipe=formBaruGedungPil',
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
	
	
	Close2:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	getGedung_4 : function(){
	var me = this; //alert('tes');	//alert(this.prefix);
		
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=getGedung_4',
		  type : 'POST',
		  //data:$('#adminForm').serialize(),
		  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('q').value = resp.content.q;
		  }
		});
	
	},
	
	refreshGedung_4 : function(id_GedungBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=refreshGedung_4&id_GedungBaru='+id_GedungBaru,
		  type : 'POST',
		  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_gd').innerHTML = resp.content.unit;
			me.getGedung_4();
		  }
		});
	},	
	
	SimpanGedung_4: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
		//	 data:$('#Ruang_form').serialize(),
			data:$('#'+this.prefix+'_KBform').serialize(),
			url: this.url+'&tipe=simpanGedung_4',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshGedung_4(resp.content);
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	BaruGedung_4: function(){	
		var me = this;
		var err='';
		var c =document.getElementById('fmc').value;
		var d =document.getElementById('fmd').value;
		var e =document.getElementById('fme').value;
		var e1 =document.getElementById('fme1').value;
		
		if (c=='' | d=='' | e=='' | e1==''){
			alert('KODE BIDANG || KODE SKPD || UNIT || SUN UNIT belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#RuangPilih_form').serialize(),
			  	url: this.url+'&tipe=formBaruGedung_4',
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
		
	pilihGedung_4 : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihGedung_4',
		  type : 'POST',
		  data:$('#RuangPilih_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('q').value = resp.content.q;
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
			url: this.url+'&tipe=windowshow&fmURUSAN='+me.fmURUSAN+'&fmSKPD='+me.fmSKPD+'&fmUNIT='+me.fmUNIT+'&fmSUBUNIT='+me.fmSUBUNIT+'&fmSEKSI='+me.fmSEKSI,
		//	url: this.url+'&tipe=windowshow&fmSKPD='+me.fmSKPD+'&fmUNIT='+me.fmUNIT+'&fmSUBUNIT='+me.fmSUBUNIT+'&fmSEKSI='+me.fmSEKSI,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');							
				document.getElementById(cover).innerHTML = resp.content;	
				me.loading();						
		  	}
		});
	},	
	
	SimpanEditGedung: function(){
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
			data:$('#RuangPilih_form').serialize(),
			url: this.url+'&tipe=simpanEditGedung',
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
	
	SimpanEditRuang: function(){
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
			data:$('#RuangPilih_form').serialize(),
			url: this.url+'&tipe=simpanEditRuang',
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
	
	SimpanEditGedung_4: function(){
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
			data:$('#RuangPilih_form').serialize(),
			url: this.url+'&tipe=simpanEditGedung_4',
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
	
	Simpan_4: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#RuangPilih_form').serialize(),
		//	data:$('#Ruang_form').serialize(),
			url: this.url+'&tipe=simpan_4',
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
	
	SimpanEditRuang_4: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#RuangPilih_form').serialize(),
			url: this.url+'&tipe=simpanEditRuang_4',
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
	
	BaruPil : function(){	
		
		var me = this;
		var err='';
		var dat_urusan = document.getElementById('dat_urusan').value;
		if (dat_urusan=='0'){
		
			var skpd = document.getElementById('fmBIDANG').value; 
			var unit = document.getElementById('fmSKPD').value;
			var subunit = document.getElementById('fmUNIT').value;
			var seksi = document.getElementById('fmSUBUNIT').value;
	
			if(err=='' && (skpd=='' || skpd=='00') ) err='BIDANG belum dipilih!';
			if(err=='' && (unit=='' || unit=='00') ) err='SKPD belum dipilih!';
			if(err=='' && (subunit=='' || subunit=='00') ) err='UNIT belum dipilih!';
			if(err=='' && (seksi=='' || seksi=='000' || seksi=='000') ) err='SUB UNIT belum dipilih!';
		}else{
						
			var urusan = document.getElementById('c1').value; 
			var skpd = document.getElementById('c').value; 
			var unit = document.getElementById('d').value;
			var subunit = document.getElementById('e').value;
			var seksi = document.getElementById('e1').value;
			
		
			if(err=='' && (urusan=='' || urusan=='0') ) err='Kode URUSAN di belum dipilih!';
			if(err=='' && (skpd=='' || skpd=='00') ) err='BIDANG di belum dipilih!';
			if(err=='' && (unit=='' || unit=='00') ) err='SKPD di belum dipilih!';
			if(err=='' && (subunit=='' || subunit=='00') ) err='UNIT di belum dipilih!';
			if(err=='' && (seksi=='' || seksi=='000' || seksi=='000') ) err='SUB UNIT di belum dipilih!';
		}
		
		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formBaruPil',
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
	
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	
	windowSave: function(){
		//alert('save');
		var me = this;
		var kib = this.fmIDBARANG.substr(0,2);
		var errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();	//alert(box.value);
			this.idpilih = box.value;
			//cek yg dipilih ruang -------------------			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: 'pages.php?Pg=ruang&tipe=getdata&id='+this.idpilih,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					//alert(resp.content.nm_ruang);							
					if(resp.content.q == '0000' && kib!='03') {
						alert('Pilih hanya Ruangan!')
					}else{						
						if(document.getElementById(me.el_idruang)) document.getElementById(me.el_idruang).value= me.idpilih;
						if(document.getElementById(me.el_nmgedung)) document.getElementById(me.el_nmgedung).value= resp.content.nm_gedung;
						if(document.getElementById(me.el_nmruang)) document.getElementById(me.el_nmruang).value= resp.content.nm_ruang;
						me.windowClose();
						me.windowSaveAfter();
					}
			  	}
			});
			
		}else{
			alert(errmsg);
		}
	},
	windowSaveAfter: function(){
		//alert('tes');
	}
	
});


var Ruang = new DaftarObj2({
	prefix : 'Ruang',
	url : 'pages.php?Pg=ruang', 
	formName : 'adminForm',// 'ruang_form',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	
	},
	
	cariPegawai: function(){
		var me = this;
		fnCariPegawai.windowShow();	
	},
	
	pilihUrusan : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihUrusan',
		  type : 'POST',
		  data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_c').innerHTML = resp.content.unit;
			document.getElementById('cont_d').innerHTML = resp.content.bid;
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
		  }
		});
	},
	
	pilihBidang : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihBidang',
		  type : 'POST',
		  data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_d').innerHTML = resp.content.bid;
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
		  }
		});
	},
	
	pilihSKPD : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihSKPD',
		  type : 'POST',
			data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
		  }
		});
	},
	
	
	pilihUnit : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihUnit',
		  type : 'POST',
			data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
			
		  }
		});
	},
	
	pilihSubUnit : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihSubUnit',
		  type : 'POST',
			data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_gd').innerHTML = resp.content.unit;
			
		  }
		});
	},
	
	pilihGedung : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihGedung',
		  type : 'POST',
		  data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('q').value = resp.content.q;
		  }
		});
	},
	
	BaruGedung: function(){	
		var me = this;
		var err='';
		var c1 =document.getElementById('fmc1').value;
		var c =document.getElementById('fmc').value;
		var d =document.getElementById('fmd').value;
		var e =document.getElementById('fme').value;
		var e1 =document.getElementById('fme1').value;
		
		if (c1=='' | c=='' | d=='' | e=='' | e1==''){
			alert('KODE URUSAN || KODE BIDANG || KODE SKPD || UNIT || SUN UNIT belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#Ruang_form').serialize(),
			  	url: this.url+'&tipe=formBaruGedung',
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
	
	SimpanEditGedung: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
		//	data:$('#RuangPilih_form').serialize(),
			data:$('#Ruang_form').serialize(),
			url: this.url+'&tipe=simpanEditGedung',
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
	
	SimpanEditRuang: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
		//	data:$('#RuangPilih_form').serialize(),
			data:$('#Ruang_form').serialize(),
			url: this.url+'&tipe=simpanEditRuang',
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
	
	SimpanEditGedung_4: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#Ruang_form').serialize(),
			url: this.url+'&tipe=simpanEditGedung_4',
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
	
	SimpanGedung: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize(),
			url: this.url+'&tipe=simpanGedung',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshGedung(resp.content);
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},	
	
	refreshGedung : function(id_GedungBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=refreshGedung&id_GedungBaru='+id_GedungBaru,
		  type : 'POST',
		  data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_gd').innerHTML = resp.content.unit;
			me.getGedung();
		  }
		});
	},
	
	getGedung : function(){
	var me = this; //alert('tes');	//alert(this.prefix);
		
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=getGedung',
		  type : 'POST',
		  //data:$('#adminForm').serialize(),
		  data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('q').value = resp.content.q;
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
	
	pilihBidang_4 : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihBidang_4',
		  type : 'POST',
		  data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_d').innerHTML = resp.content.bid;
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
		  }
		});
	},
	
	pilihSKPD_4 : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihSKPD_4',
		  type : 'POST',
			data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
		  }
		});
	},
	
	
	pilihUnit_4 : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihUnit_4',
		  type : 'POST',
			data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e1').innerHTML = resp.content.sub1;
		  }
		});
	},
	
	pilihSubUnit_4 : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihSubUnit_4',
		  type : 'POST',
			data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_gd').innerHTML = resp.content.unit;
		  }
		});
	},
	
	pilihGedung_4 : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=pilihGedung_4',
		  type : 'POST',
		  data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('q').value = resp.content.q;
		  }
		});
	},
	
	BaruGedung_4: function(){	
		var me = this;
		var err='';
		var c =document.getElementById('fmc').value;
		var d =document.getElementById('fmd').value;
		var e =document.getElementById('fme').value;
		var e1 =document.getElementById('fme1').value;
		
		if (c=='' | d=='' | e=='' | e1==''){
			alert('KODE BIDANG || KODE SKPD || UNIT || SUN UNIT belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#Ruang_form').serialize(),
			  	url: this.url+'&tipe=formBaruGedung_4',
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
	
	SimpanGedung_4: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
		//	 data:$('#Ruang_form').serialize(),
			data:$('#'+this.prefix+'_KBform').serialize(),
			url: this.url+'&tipe=simpanGedung_4',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshGedung_4(resp.content);
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	SimpanEditRuang_4: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#Ruang_form').serialize(),
			url: this.url+'&tipe=simpanEditRuang_4',
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
	
	refreshGedung_4 : function(id_GedungBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=refreshGedung_4&id_GedungBaru='+id_GedungBaru,
		  type : 'POST',
		  data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_gd').innerHTML = resp.content.unit;
			me.getGedung_4();
		  }
		});
	},	
	
	getGedung_4 : function(){
	var me = this; //alert('tes');	//alert(this.prefix);
		
		$.ajax({
		  url: 'pages.php?Pg=ruang&tipe=getGedung_4',
		  type : 'POST',
		  //data:$('#adminForm').serialize(),
		  data:$('#Ruang_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('q').value = resp.content.q;
		  }
		});
	
	},
	
	Simpan_4: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#Ruang_form').serialize(),
			url: this.url+'&tipe=simpan_4',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
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
		
		$.ajax({
			type:'POST', 
			data:$('#Ruang_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					me.Close();
					me.refreshList(true)
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	
	
});