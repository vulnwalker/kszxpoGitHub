var PenggunaanSkpd = new SkpdCls({
	prefix : 'PenggunaanSkpd', 
	formName:'PenggunaanForm',
	pilihBidangAfter:function(){
		Penggunaan.refreshList(true);
	},
	pilihUnitAfter:function(){
		Penggunaan.refreshList(true);
	},
	pilihSubUnitAfter:function(){
		Penggunaan.refreshList(true);
	} 
});


var Penggunaan = new DaftarObj2({
	prefix : 'Penggunaan',
	url : 'pages.php?Pg=Penggunaan', 
	formName : 'PenggunaanForm',// 'ruang_form',
	fmSKPD:'',
	fmUNIT:'',
	fmSUBUNIT:'',
	tahun_anggaran:'',
	el_id_penggunaan : '',
	el_ipk : '',
	
	Baru : function(){	
		
		var me = this;
		var err='';
		
		//cek skpd
		var skpd = document.getElementById(this.prefix+'SkpdfmSKPD').value; 
		var unit = document.getElementById(this.prefix+'SkpdfmUNIT').value;
		var subunit = document.getElementById(this.prefix+'SkpdfmSUBUNIT').value;
		
		if(err=='' && (skpd=='' || skpd=='00') ) err='BIDANG belum dipilih!';
		if(err=='' && (unit=='' || unit=='00') ) err='ASISTEN/OPD belum dipilih!';
		if(err=='' && (subunit=='' || subunit=='00') ) err='BIRO/ UPTD/B belum dipilih!';
		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
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
	
	AfterFormBaru:function(){ 
		
	id_penggunaan = document.getElementById('Penggunaan_idplh').value;
	document.getElementById('daftarpenggunaandetail').innerHTML = 
			//"<div id='Penggunaan_cont_title' style='position:relative'></div>"+
			"<div id='Penggunaan_Det_cont_opsi' style='position:relative'>"+
			"<input type='hidden' name='id_penggunaan' id='id_penggunaan' value='"+id_penggunaan+"'>"+
			"</div>"+
			"<div id='Penggunaan_Det_cont_daftar' style='position:relative'></div>"+
			"<div id='Penggunaan_Det_cont_hal' style='position:relative'></div>"
			//"<div><input type='button' name='cariobat' id='cariobat' value='Tambah'  onclick=\"javascript:FarmasiJualDetail.Cari()\" >"+
			//"<input type='button' name='editobat' id='editobat' value='Edit'  onclick=\"javascript:FarmasiJualDetail.Edit("+menu+")\" >"+			
			//"<input type='button' name='hapusobat' id='hapusobat' value='Hapus'  onclick=\"javascript:FarmasiJualDetail.Hapus()\" ></div>"
			;
		//generate data
	   Penggunaan_Det.loading();
	},
	
	AfterFormEdit:function(){ 
		
	id_penggunaan = document.getElementById('Penggunaan_idplh').value;
	document.getElementById('daftarpenggunaandetail').innerHTML = 
			//"<div id='Penggunaan_cont_title' style='position:relative'></div>"+
			"<div id='Penggunaan_Det_cont_opsi' style='position:relative'>"+
			"<input type='hidden' name='id_penggunaan' id='id_penggunaan' value='"+id_penggunaan+"'>"+
			"</div>"+
			"<div id='Penggunaan_Det_cont_daftar' style='position:relative'></div>"+
			"<div id='Penggunaan_Det_cont_hal' style='position:relative'></div>"
			//"<div><input type='button' name='cariobat' id='cariobat' value='Tambah'  onclick=\"javascript:FarmasiJualDetail.Cari()\" >"+
			//"<input type='button' name='editobat' id='editobat' value='Edit'  onclick=\"javascript:FarmasiJualDetail.Edit("+menu+")\" >"+			
			//"<input type='button' name='hapusobat' id='hapusobat' value='Hapus'  onclick=\"javascript:FarmasiJualDetail.Hapus()\" ></div>"
			;
		//generate data
	   Penggunaan_Det.loading();
	},
	
	getDaftarOpsi:function(){
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: 'pages.php?Pg=05&idpilih=getDaftarOpsi',
		  	success: function(data) {
				var resp = eval('(' + data + ')');	
				if (resp.ErrMsg =='')	{	
					document.getElementById('penatausaha_cont_opt').innerHTML = resp.content;
				}else{
					alert(resp.ErrMsg);					
					
				}
			}
		});
	},		
	
	TambahBarang:function(){		
		var sw = getBrowserWidth();
		var sh = getBrowserHeight();						
		var idref = document.getElementById(this.prefix+'_idplh').value;
		var tahun = document.getElementById('tahun').value;
		//var sesiCari = document.getElementById('sesi').value;
		var c = document.getElementById('c').value;
		var d = document.getElementById('d').value;
		var e = document.getElementById('e').value;	
		var cover = this.prefix+'_formcovercari';
		addCoverPage2(cover,999,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=formCari&sw='+sw+'&sh='+sh+'&id_penggunaan='+id_penggunaan,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				if (resp.err ==''){		
					document.getElementById(cover).innerHTML = resp.content;
					//var c = ''; var d=''; var e='';
					document.getElementById('div_detailcaribarang').innerHTML = 
					'<input type=\"hidden\" id=\"formcaribi\" name=\"formcaribi\" value=\"8\">'+
					'<input type=\"hidden\" id=\"multiSelectNo\" name=\"multiSelectNo\" value=\"1\">'+
					'<input type=\"hidden\" id=\"fmSKPD\" name=\"fmSKPD\" value=\"'+c+'\">'+
					'<input type=\"hidden\" id=\"fmUNIT\" name=\"fmUNIT\" value=\"'+d+'\">'+
					'<input type=\"hidden\" id=\"fmSUBUNIT\" name=\"fmSUBUNIT\" value=\"'+e+'\">'+
					'<input type=\"hidden\" id=\"idref\" name=\"idref\" value=\"'+idref+'\">'+
					'<input type=\"hidden\" id=\"tahun_anggaran\" name=\"tahun_anggaran\" value=\"'+tahun+'\">'+
					//'<input type=\"hidden\" id=\"sesicari\" name=\"sesicari\" value=\"'+sesiCari+'\">'+					 
					'<input type=\"hidden\" id=\"boxchecked\" name=\"boxchecked\" value=\"2\">'+
					//'<input type=\"hidden\" id=\"GetSPg\" name=\"GetSPg\" value=\"03\">'+
					//'<input type=\"hidden\" id=\"SPg\" name=\"SPg\" value=\"03\">'+					
					'<div id=\"penatausaha_cont_opt\"></div>'+
					'<div id=\"penatausaha_cont_list\"></div>'+
					'<div id=\"penatausaha_cont_hal\"><input type=\"hidden\" value=\"1\" id=HalDefault></div>'+
					'';
					//generate data
					Penatausaha.getDaftarOpsi();
					Penatausaha.resetPilih();
					Penatausaha.refreshList(true);
					document.body.style.overflow='hidden';
					//barcodeCariBarang.loading();
				}else{
					alert(resp.err);
					//delElem(cover);
					document.body.style.overflow='auto';
				}
		  	}
		});						
	} ,	
	
	CloseCariBarang:function(){//alert(this.elCover);
		Penatausaha.resetPilih();		
		var cover = this.prefix+'_formcovercari';
		if(document.getElementById(cover)) delElem(cover);								
	},
	
	PilihBarang:function(){ //pilih cari
		var me = this;
		errmsg = '';		
		if((errmsg=='') && (Penatausaha.daftarPilih.length == 0 )){
			errmsg= 'Data belum dipilih!';
		}
		if((errmsg=='') && (Penatausaha.daftarPilih.length > 1 )){
			errmsg= 'Pilih 1 data!';
		}
		if(errmsg ==''){	
			//alert('simpan');
			$.ajax({
				type:'POST', 
				data:$('#adminForm').serialize(),
				url: this.url +'&tipe=simpanPilihBarang',
			  	success: function(data) {
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){
						me.CloseCariBarang();
						Penggunaan_Det.refreshList(true);
						document.getElementById('idbi').value = resp.content.idbi;
						document.getElementById('c').value = resp.content.c;
						document.getElementById('d').value = resp.content.d;
						document.getElementById('e').value = resp.content.e;					
						
					}else{
						alert(resp.err);
					}
				}
			});
			
		}else{
			alert(errmsg);
		}
		
	},
	
	windowShow: function(){
		var me = this;
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=windowshow&ipk='+me.el_ipk,//&fmSKPD='+me.fmSKPD+'&fmUNIT='+me.fmUNIT+'&fmSUBUNIT='+me.fmSUBUNIT,
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
	
	windowSaveAfter: function(){
		//alert('tes');
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
			ipk = document.getElementById('ipk').value;			
			
			var cover = 'Penggunaan_Cari_cover';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				url: 'pages.php?Pg=Penggunaan&tipe=windowsave&id='+this.idpilih+'&ipk='+ipk,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					delElem(cover);
					if(resp.err==''){
						me.windowClose();
						me.windowSaveAfter();
						Penggunaan_Cari.refreshList(true);
					}else{
						alert(resp.err)	
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
	},	
	
	Usulan : function(){	
		
		var me = this;
		var err='';
		
		//cek skpd
		var skpd = document.getElementById(this.prefix+'SkpdfmSKPD').value; 
		var unit = document.getElementById(this.prefix+'SkpdfmUNIT').value;
		var subunit = document.getElementById(this.prefix+'SkpdfmSUBUNIT').value;
		
		if(err=='' && (skpd=='' || skpd=='00') ) err='BIDANG belum dipilih!';
		if(err=='' && (unit=='' || unit=='00') ) err='ASISTEN/OPD belum dipilih!';
		if(err=='' && (subunit=='' || subunit=='00') ) err='BIRO/ UPTD/B belum dipilih!';
		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formUsulan',
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
	
	Batal : function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);
			if(confirm('Batalkan Data ini?')){			
				var cover = this.prefix+'_batalcover';
				addCoverPage2(cover,999,true,false);	
				document.body.style.overflow='hidden';
				$.ajax({
					type:'POST', 
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=batal',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');	
						if (resp.err ==''){		
							document.getElementById(cover).innerHTML = resp.content;
							//me.AfterFormEdit(resp);
							alert('Data berhasil dibatalkan');
							delElem(cover);
							me.refreshList(true);
						}else{
							alert(resp.err);
							delElem(cover);
							me.refreshList(true);
							//document.body.style.overflow='auto';
						}
				  	}
				});
			}
		}else{
			alert(errmsg);
		}
		
	},				
	
	cetakSK: function (){	
		var aForm = document.getElementById(this.formName);		
		aForm.action= this.url+'&tipe=cetakSK';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
		aForm.target='_blank';
		aForm.submit();	
		aForm.target='';
		
		
	},		
	
	
});
