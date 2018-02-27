var pemasukan_kapitalisasi = new DaftarObj2({
	prefix : 'pemasukan_kapitalisasi',
	url : 'pages.php?Pg=pemasukan_kapitalisasi', 
	formName : 'pemasukan_kapitalisasiForm',
	satuan_form : '0',//default js satuan
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();/*
		this.daftarRender();
		this.sumHalRender();*/
	
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
	
	filterRenderAfter : function(){
		var me = this;
		
		setTimeout(function myFunction() {me.nyalakandatepicker()},1000);
		setTimeout(function myFunction() {me.TabelPenerimaDistribusi()},1000);
	},
	
	formatCurrency:function(num) {
		num = num.toString().replace(/\$|\,/g,'');
		if(isNaN(num))
		num = "0";
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num*100+0.50000000001);
		cents = num%100;
		num = Math.floor(num/100).toString();
		if(cents<10)
		cents = "0" + cents;
		for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+'.'+
		num.substring(num.length-(4*i+3));
		if(num == 0){
			return '';
		}else{
			return (((sign)?'':'-') + '' + num + ',' + cents);
		}
		
	},
	
	isNumberKey: function(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
		
		return false;
		return true;
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
				//me.sumHalRender();
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
					if(me.satuan_form==0){
						me.Close();
						me.AfterSimpan();						
					}else{
						me.Close();
						barang.refreshComboSatuan();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	CariProgram: function(){
		var me = this;
		cariprogram.windowShow();	
	},
	
	CariIdPenerimaan: function(){
		var me = this;
		cariIdPenerima.windowShow();	
	},
	
	cariTemplate: function(){
		var me = this;
		
		c1nya = document.getElementById('c1nya').value;
		cnya = document.getElementById('cnya').value;
		dnya = document.getElementById('dnya').value;
		idTerima = document.getElementById('idTerima').value;
		idTerima_det = document.getElementById('idTerima_det').value;
		
		cariTemplate.windowShow(c1nya,cnya,dnya,idTerima,idTerima_det);	
	},
	
	TabelSKPD: function(){
	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=TabelSKPD',
			success: function(data) {		
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					document.getElementById('tbl_atribusi').innerHTML = resp.content.tabel;
				}else{
					alert(resp.err);
				}
				
			  }
		});
		
	},
	
	cekTabelSKPD: function(isinya='', ambil=1, cek2=1){
	
		var CaraTampilKPTLS = document.getElementById('CaraTampilKPTLS').value;
		
		if(CaraTampilKPTLS == '1'){	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=cekTabelSKPD&CekKe='+cek2,
				success: function(data) {		
					var resp = eval('(' + data + ')');
					
					if(resp.err==''){
						if(cek2 == 2){
							if(resp.content.a=='1')pemasukan_kapitalisasi.SimpanKeDistribusi(ambil);
						}
						if(ambil == 2 && cek2 == 1){
							pemasukan_kapitalisasi.SimpanSemua();
						}
						pemasukan_kapitalisasi.TabelSKPD();
					}else{
						if(cek2 == 2 && resp.err == ''){
							if(resp.content.a=='1')pemasukan_kapitalisasi.SimpanKeDistribusi(ambil);
						}else{
							var konfrim = confirm(resp.err);
							if(konfrim == true){
								if(cek2 == 2){
									if(resp.content.a=='0')document.getElementById('unitkerja').value = resp.content.unit;
								}else{
									pemasukan_kapitalisasi.cekTabelSKPD(isinya,ambil,2);
									document.getElementById('unitkerja').value = resp.content.unit;
									
								}
							}else{
								pemasukan_kapitalisasi.TabelSKPD();
							}
							
						}
						
						
						
					}
					
				  }
			});
		}else{
			if(ambil == 2 && cek2 == 1)pemasukan_kapitalisasi.SimpanSemua();
		}
		
		pemasukan_kapitalisasi.TabelPenerimaDistribusi();
		
	},
	
	
	SimpanKeDistribusi: function(ambilTabel = 0){
	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=SimpanKeDistribusi',
			success: function(data) {		
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					if(ambilTabel == 1)pemasukan_kapitalisasi.TabelSKPD();
					if(ambilTabel == 2)pemasukan_kapitalisasi.SimpanSemua();
					pemasukan_kapitalisasi.TabelPenerimaDistribusi();
					//document.getElementById('tbl_penerima_atribusi').innerHTML = resp.content.tabel;
				}else{
					alert(resp.err);
				}
				
			  }
		});
		
	},	
	
	TabelPenerimaDistribusi: function(){
	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=TabelPenerimaDistribusi',
			success: function(data) {		
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					document.getElementById('tbl_penerima_distribusi').innerHTML = resp.content.tabel;
				}else{
					alert(resp.err);
				}
				
			  }
		});
		
	},
	
	SimpanSemua: function(){
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=SimpanSemua',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					alert("Data Berhasil Disimpan !");
						window.close();
						window.opener.location.reload();
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	BatalSemua: function(){
		
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=BatalSemua',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
							window.close();
							window.opener.location.reload();									
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	cariBarangBI: function(){
		var namaform = this.formName;
		//alert(namaform);
		var unitkerja = document.getElementById('unitkerja').value;
		
		if(unitkerja != '-'){
			cariIDBI.windowShow(namaform);	
		}else{
			alert("Unit Kerja Belum Di Pilih !");
		}
	},
	
	HapusRincian: function(IdKPTLS){
		var me = this;
		var tanya=confirm("Data Akan di Hapus ?");
		
		if(tanya == true){
			$.ajax({
					type:'POST', 
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=HapusRincian&IdKPTLS='+IdKPTLS,
					success: function(data) {	
						var resp = eval('(' + data + ')');			
						if(resp.err==''){
							me.TabelPenerimaDistribusi();						
						}else{
							alert(resp.err);
						}
					}
				});	
		}
	},
	
	
		
});
