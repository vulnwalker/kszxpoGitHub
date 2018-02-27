var pengeluaranPersediaanSKPD2 = new SkpdCls({
	prefix : 'pengeluaranPersediaanSKPD2',
	formName: 'pengeluaranPersediaanForm',

	pilihUrusanfter : function(){pengeluaranPersediaan.refreshList(true);},
	pilihBidangAfter : function(){pengeluaranPersediaan.refreshList(true);},
	pilihUnitAfter : function(){pengeluaranPersediaan.refreshList(true);},
	pilihSubUnitAfter : function(){pengeluaranPersediaan.refreshList(true);},
	pilihSeksiAfter : function(){pengeluaranPersediaan.refreshList(true);}
});
var pengeluaranPersediaan = new DaftarObj2({
	prefix : 'pengeluaranPersediaan',
	url : 'pages.php?Pg=pengeluaranPersediaan',
	formName : 'pengeluaranPersediaanForm',
	pengeluaranPersediaan_form : '0',//default js pengeluaranPersediaan
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();


	},
	filterRenderAfter : function(){
    	this.daftarRender();
  	},
	programChanged : function(){
		var arrayP = $("#p").val().split('.');;
		var bk = arrayP[0];
		var ck = arrayP[1];
		var hiddenP = arrayP[2];

		$("#bk").val(bk);
		$("#ck").val(ck);
		$("#hiddenP").val(hiddenP);
		$("#q").val('');
		pengeluaranPersediaan.refreshList(true);
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

	},pilihBidang: function(){
		pengeluaranPersediaan.refreshList(true);

	},BidangAfter2: function(){
		pengeluaranPersediaan.refreshList(true);

	},comboSKPDChanged: function(){
		pengeluaranPersediaan.refreshList(true);

	},CariModul: function(){
		var me = this;

		popupModul.el_namaModul= 'namaModul';
		popupModul.el_idModul= 'idModul';
/*		RefBarangButuh.el_nama_barang= 'nama_barang';		*/
		popupModul.windowSaveAfter= function(){};
		popupModul.windowShow();
	},

	histori: function(id){
		var me = this;

		popupHistori.el_namaHistori= 'namaHistori';
		popupHistori.el_idHistori= 'idHistori';
		popupHistori.windowSaveAfter= function(){};
		popupHistori.windowShow(id);
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

/*				me.sumHalRender();*/
		  	}
		});
	},
	BaruTTD: function(){
		var me = this;
		var err='';
		var urusan = document.getElementById('pengeluaranPersediaanSKPD2fmURUSAN').value; 
		var bidang = document.getElementById('pengeluaranPersediaanSKPD2fmSKPD').value; 
		var skpd = document.getElementById('pengeluaranPersediaanSKPD2fmUNIT').value;
		var unit = document.getElementById('pengeluaranPersediaanSKPD2fmSUBUNIT').value;
		var subunit = document.getElementById('pengeluaranPersediaanSKPD2fmSEKSI').value;
		
		var cover = this.prefix+'_formcover';
		if(err==''){
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize()+"&urusan="+urusan+"&bidang="+bidang+"&skpd="+skpd+"&unit="+unit+"&subunit="+subunit,
			  	url: this.url+'&tipe=formBaruTTD',
			  	success: function(data) {
			  		delElem(cover);
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						me.AfterFormBaru(resp);	
					}else{
						alert(resp.err);
						
						document.body.style.overflow='auto';
					}			
					
			  	}
			});
		}else{
			alert(err);
		}
	},
	pilihPangkat : function(){
	var me = this; 
		$.ajax({
		  url: this.url+'&tipe=pilihPangkat',
		  type : 'POST',
		  data:{
				c1			  : $("#pengeluaranPersediaanSKPD2fmURUSAN").val(),
				c 			  : $("#pengeluaranPersediaanSKPD2fmSKPD").val(),
				d 			  : $("#pengeluaranPersediaanSKPD2fmUNIT").val(),
				e  			  : $("#pengeluaranPersediaanSKPD2fmSUBUNIT").val(),
				e1 			  : $("#pengeluaranPersediaanSKPD2fmSEKSI").val(),
			  	dc1 		  : $("#dc1").val(),
			  	dc  		  : $("#dc").val(),
			  	dd  		  : $("#dd").val(),
			  	kategori      : $("#kategori").val(),
			  	namapegawai   : $("#namapegawai").val(),
			  	nippegawai    : $("#nippegawai").val(),
			  	pangkatakhir  : $("#pangkatakhir").val(),
			  	golang_akhir  : $("#golang_akhir").val(),
			  	jabatan       : $("#jabatan").val(),
			  	eselon_akhir  : $("#eselon_akhir").val(),
		  },
		  success: function(data) {		
			var resp = eval('(' + data + ')');
			
			if(resp.err == ''){
				document.getElementById('golang_akhir').value = resp.content;
			}else{
				alert(resp.err);
			}				
		}	
		});
	},
	Baru: function(){
		var me = this;
		if($("#"+me.prefix+"SKPD2fmURUSAN").val()  == '0'){
		 	alert("Pilih Urusan");
		}else if($("#"+me.prefix+"SKPD2fmSKPD").val()  == '00'){
			alert("Pilih Bidang");
		}else if($("#"+me.prefix+"SKPD2fmUNIT").val()  == '00'){
			alert("Pilih SKPD");
		}else if($("#"+me.prefix+"SKPD2fmSUBUNIT").val() == '00'){
			alert("Pilih Unit");
		}else if($("#"+me.prefix+"SKPD2fmSEKSI").val() == '000'){
			alert("Pilih Sub Unit");
		}else{

				var skpd = $("#"+me.prefix+"SKPD2fmURUSAN").val()+'.'+$("#"+me.prefix+"SKPD2fmSKPD").val()+'.'+$("#"+me.prefix+"SKPD2fmUNIT").val()+'.'+$("#"+me.prefix+"SKPD2fmSUBUNIT").val()+'.'+$("#"+me.prefix+"SKPD2fmSEKSI").val();

				var aForm = document.getElementById(this.formName);
				$.ajax({
				type:'POST',
				data : {c1 : $("#"+me.prefix+"SKPD2fmURUSAN").val(),
						c  : $("#"+me.prefix+"SKPD2fmSKPD").val(),
						d  : $("#"+me.prefix+"SKPD2fmUNIT").val(),
						e  : $("#"+me.prefix+"SKPD2fmSUBUNIT").val(),
						e1 : $("#"+me.prefix+"SKPD2fmSEKSI").val(),

						},
			  	url: this.url+'&tipe=newTab',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						aForm.action= 'pages.php?Pg=pengeluaranPersediaan_ins&skpd='+skpd+"&nomor="+resp.content.nomor;
						aForm.target='_blank';
						aForm.submit();
						aForm.target='';
					}else{
						alert(resp.err);
					}

				 }
			});


		}

	},
	Info: function(){
		var aForm = document.getElementById(this.formName);
				$.ajax({
				  url: this.url+'&tipe=hubla',
				  type : 'POST',
				  data:$('#'+this.formName).serialize(),
				  success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == "") {
							var kodeRek = resp.content.kodeRek;
							aForm.action= 'pages.php?Pg=alokasiDpa';
							aForm.target='_blank';
							aForm.submit();
							aForm.target='';
						}else{
							alert(resp.err);
						}

				  }
				});
	},
	unlockFindRekening: function(){
		var me = this;
		if( $("#cmbJenisRKAForm").val() == ""){
			$("#findRekening").attr('disabled',true);
		}else{
			$("#findRekening").attr('disabled',false);
			$("#findRekening").attr('onclick',"pengeluaranPersediaan.findRekening('"+$("#cmbJenisRKAForm").val()+"');");

		}


	},
	

	Hapus : function(){
		var me =this;
		if(document.getElementById(this.prefix+'_jmlcek')){
			var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;
		}else{
			var jmlcek = '';
		}

		if(jmlcek ==0){
			alert('Data Belum Dipilih!');
		}else{
			if(confirm('Yakin Hapus '+jmlcek+' Data ?')){
				var cover = this.prefix+'_hapuscover';
				addCoverPage2(cover,1,true,false);
				$.ajax({
					type:'POST',
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=hapus',
				  	success: function(data) {
						var resp = eval('(' + data + ')');
						delElem(cover);
						if(resp.err==''){
							me.AfterHapus();
						}else{
							alert(resp.err);
						}

				  	},
					error: ajaxError
				});

			}
		}
	},
	Posting:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();

			//this.Show ('formedit',{idplh:box.value}, false, true);
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,2,true,false);
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=Posting',
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

	Remove:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if($("#cmbUrusan").val()  == ''){
		 	alert("Pilih Urusan");
		}else if($("#cmbBidang").val()  == ''){
			alert("Pilih Bidang");
		}else if($("#cmbSKPD").val()  == ''){
			alert("Pilih SKPD");
		}else if($("#cmbUnit").val()  == ''){
			alert("Pilih Unit");
		}else if($("#cmbSubUnit").val()  == ''){
			alert("Pilih Sub Unit");
		}else{
			if(errmsg ==''){
				var box = this.GetCbxChecked();
				var skpd = $("#cmbUrusan").val()+'.'+$("#cmbBidang").val()+'.'+$("#cmbSKPD").val()+'.'+$("#cmbUnit").val()+'.'+$("#cmbSubUnit").val();

				$.ajax({
				  url: this.url+'&tipe=Remove',
				  type : 'POST',
				  data:$('#'+this.formName).serialize(),
				  success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == "") {
							pengeluaranPersediaan.refreshList(true);
						}else{
							alert(resp.err);
						}

				  }
				});
			}else{
				alert(errmsg);
			}
		}
	},

	sesuai:function(id){


		$.ajax({
				type:'POST',
				data:{idAwal : id,
					  koreksiVolumebarang : document.getElementById("volumeRekSesuai"+id).value,
					  koreksiSatuanHarga : document.getElementById("hargaSatuanSesuai"+id).value
					  },
				url: this.url+'&tipe=koreksi',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						pengeluaranPersediaan.refreshList(true);
					}else{
						alert(resp.err);
						if(resp.err == 'Tahap Koreksi Talah Habis'){
							window.location.reload();
						}
					}

				 }
			  });

	},
	koreksi:function(id){
		$("#spanVolumeBarang"+id).html("<input type='text' name='volumeBarang"+id+"' id='volumeBarang"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='pengeluaranPersediaan.bantuVolumeBarang("+id+")'   style='text-align: right;'>  <span id='bantuVolumeBarang"+id+"' ></span>");
		$("#spanSatuanHarga"+id).html("<input type='text' name='satuanHarga"+id+"' id='satuanHarga"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='pengeluaranPersediaan.bantuSatuanHarga("+id+")'    style='text-align: right;'>  <span id='bantuSatuanHarga"+id+"' ></span>");
		$("#buttonSubmitKoreksi"+id).html("<img src='datepicker/save.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=pengeluaranPersediaan.submitKoreksi('"+id+"');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=pengeluaranPersediaan.refreshList(true);></img>");
		$("#alignButton"+id).attr('align','center' );
	},
	submitKoreksi:function(id) {

			if( document.getElementById("volumeBarang"+id).value == 0 ){
				alert("Isi Volume Barang");
			}else if( document.getElementById("satuanHarga"+id).value == 0 ){
				alert("Isi Satuan Harga");
			}else{
			  $.ajax({
				type:'POST',
				data:{idAwal : id,
					  koreksiVolumebarang : document.getElementById("volumeBarang"+id).value,
					  koreksiSatuanHarga : document.getElementById("satuanHarga"+id).value
					  },
				url: this.url+'&tipe=koreksi',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						pengeluaranPersediaan.refreshList(true);
					}else{
						alert(resp.err);
						if(resp.err == 'Tahap Koreksi Talah Habis'){
							window.location.reload();
						}
					}

				 }
			  });
			}

	},

	bantuVolumeBarang : function(id){
		document.getElementById('bantuVolumeBarang'+id).innerHTML = pengeluaranPersediaan.formatCurrency2($("#volumeBarang"+id).val());
		var hasilKali = Number($("#volumeBarang"+id).val()) * Number($("#satuanHarga"+id).val()) ;
		$("#spanJumlahHarga"+id).text(pengeluaranPersediaan.formatCurrency(hasilKali));
	},
	bantuSatuanHarga : function(id){
		document.getElementById('bantuSatuanHarga'+id).innerHTML =  pengeluaranPersediaan.formatCurrency($("#satuanHarga"+id).val());
		var hasilKali = Number($("#volumeBarang"+id).val()) * Number($("#satuanHarga"+id).val()) ;
		$("#spanJumlahHarga"+id).text(pengeluaranPersediaan.formatCurrency(hasilKali));
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
		return (((sign)?'':'-') + '' + num + ',' + cents);
	},
	formatCurrency2:function(num) {
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
		return (((sign)?'':'-') + '' + num );
	},

	bantu : function(){
		$("#bantu").text("Rp. "+pengeluaranPersediaan.formatCurrency($("#hargaSatuan").val())  );

	},

	findRekening : function(jenisRka){
		var me = this;
		var filterRek = "";
		if(jenisRka == "2.2.1"){
			filterRek = "RKA 2.2.1";
		}else if(jenisRka == "2.1"){
			filterRek = "RKA 2.1";
		}
		popupRekening.el_kode_rekening = 'kodeRekening';
		popupRekening.el_nama_rekening = 'namaRekening';
		popupRekening.windowSaveAfter= function(){};
		popupRekening.filterAkun=filterRek;
		popupRekening.windowShow();

	},

	findBarang : function(kodeRENJA){
		var me = this;
		popupBarangRKA.windowShow(kodeRENJA);

	},

	catatan:function(id){
		var me = this;


			 var cover = this.prefix+'_formcover';

			$.ajax({
				type:'POST',
				data:{idAwal : id },
			  	url: this.url+'&tipe=Catatan',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){

						document.body.style.overflow='hidden';
						addCoverPage2(cover,999,true,false);
						document.getElementById(cover).innerHTML = resp.content;
					}else{
					/*	delElem(cover);*/
						alert(resp.err);
					}


			  	}
			});


	},
   Validasi:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();

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
			  	url: this.url+'&tipe=Validasi',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						delElem(cover);
						alert(resp.err);
						if(resp.err == 'Tahap Validasi Telah Habis'){
							window.location.reload();
						}
					}

					//setTimeout(function myFunction() {pengeluaranPersediaan.jam()},100);
					//me.AfterFormBaru();
			  	}
			});
		}else{
			alert(errmsg);
		}

	},


	SimpanTTD: function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:{
				jenisKegiatan : $("#jenisKegiatan").val(),
				cetakjang	  : $("#cetakjang").val(),
				ttd			  : $("#ttd").val(),
				c1			  : $("#pengeluaranPersediaanSKPD2fmURUSAN").val(),
				c 			  : $("#pengeluaranPersediaanSKPD2fmSKPD").val(),
				d 			  : $("#pengeluaranPersediaanSKPD2fmUNIT").val(),
				e  			  : $("#pengeluaranPersediaanSKPD2fmSUBUNIT").val(),
				e1 			  : $("#pengeluaranPersediaanSKPD2fmSEKSI").val(),
			  	dc1 		  : $("#dc1").val(),
			  	dc  		  : $("#dc").val(),
			  	dd  		  : $("#dd").val(),
			  	kategori      : $("#kategori").val(),
			  	namapegawai   : $("#namapegawai").val(),
			  	nippegawai    : $("#nippegawai").val(),
			  	pangkatakhir  : $("#pangkatakhir").val(),
			  	golang_akhir  : $("#golang_akhir").val(),
			  	jabatan       : $("#jabatan").val(),
			  	eselon_akhir  : $("#eselon_akhir").val(),
			},
			url: this.url+'&tipe=simpanTTD',
		  	success: function(data) {
				var resp = eval('(' + data + ')');	
				delElem(cover);
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					document.getElementById('ttd').innerHTML = resp.content.combottd;
					pengeluaranPersediaan.Close();
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
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					if(me.pengeluaranPersediaan_form==0){
						me.Close();
						me.AfterSimpan();
					}else{
						me.Close();
						barang.refreshCombopengeluaranPersediaan();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,
	savePosting: function(idPosting){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize()+"&idPosting="+idPosting,
			url: this.url+'&tipe=savePosting',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
						me.Close();
						me.refreshList(true);
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,
   SaveValid: function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=SaveValid',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					if(me.pengeluaranPersediaan_form==0){
						me.Close();
						me.AfterSimpan();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,
   SaveCatatan: function(id){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:{id : id,
				  catatan : $("#catatan").val()},
			url: this.url+'&tipe=SaveCatatan',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					if(me.pengeluaranPersediaan_form==0){
						me.Close();
						me.AfterSimpan();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	Report: function(){
		var aForm = document.getElementById(this.prefix+('_form'));
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		var url2 = this.url;
		$.ajax({
			type:'POST',
			data: { jenisKegiatan : $("#jenisKegiatan").val(),
					cetakjang	  : $("#cetakjang").val(),
					ttd			  : $("#ttd").val(),
					c1			  : $("#pengeluaranPersediaanSKPD2fmURUSAN").val(),
					c 			  : $("#pengeluaranPersediaanSKPD2fmSKPD").val(),
					d 			  : $("#pengeluaranPersediaanSKPD2fmUNIT").val(),
					e  			  : $("#pengeluaranPersediaanSKPD2fmSUBUNIT").val(),
					e1 			  : $("#pengeluaranPersediaanSKPD2fmSEKSI").val(),

					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){

					aForm.action= url2+'&tipe='+resp.content.to+'&urusan='+$("#pengeluaranPersediaanSKPD2fmURUSAN").val()+'&bidang='+$("#pengeluaranPersediaanSKPD2fmSKPD").val()+'&skpd='+$("#pengeluaranPersediaanSKPD2fmUNIT").val()+'&unit='+$("#pengeluaranPersediaanSKPD2fmSUBUNIT").val()+'&subunit='+$("#pengeluaranPersediaanSKPD2fmSEKSI").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd;
					aForm.target='_blank';
					aForm.submit();
					aForm.target='';
					me.Close();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	BaruTTD: function(){
		var me = this;
		var err='';
		var urusan = document.getElementById('pengeluaranPersediaanSKPD2fmURUSAN').value; 
		var bidang = document.getElementById('pengeluaranPersediaanSKPD2fmSKPD').value; 
		var skpd = document.getElementById('pengeluaranPersediaanSKPD2fmUNIT').value;
		var unit = document.getElementById('pengeluaranPersediaanSKPD2fmSUBUNIT').value;
		var subunit = document.getElementById('pengeluaranPersediaanSKPD2fmSEKSI').value;
		
		var cover = this.prefix+'_formcover';
		if(err==''){
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize()+"&urusan="+urusan+"&bidang="+bidang+"&skpd="+skpd+"&unit="+unit+"&subunit="+subunit,
			  	url: this.url+'&tipe=formBaruTTD',
			  	success: function(data) {
			  		delElem(cover);
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						me.AfterFormBaru(resp);	
					}else{
						alert(resp.err);
						
						document.body.style.overflow='auto';
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
				var aForm = document.getElementById(this.formName);
				$.ajax({
				  url: this.url+'&tipe=editTab',
				  type : 'POST',
				  data:$('#'+this.formName).serialize(),
				  success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == "") {
							aForm.action= 'pages.php?Pg=pengeluaranPersediaan_ins&skpd='+resp.content.skpd+"&nomor="+resp.content.nomor;
							aForm.target='_blank';
							aForm.submit();
							aForm.target='';
						}else{
							alert(resp.err);
						}

				  }
				});
			}else{
				alert(errmsg);
			}

	},
	Report2: function(){
		var aForm = document.getElementById(this.prefix+('_form'));
		var me= this;
		errmsg = this.CekCheckbox();
		var jenisKegiatan = document.getElementById('jenisKegiatan').value;
		var cetakjang = document.getElementById('cetakjang').value;
		// var ttd = document.getElementById('ttd').value;
		var c1 = document.getElementById('pengeluaranPersediaanSKPD2fmURUSAN').value;
		var c = document.getElementById('pengeluaranPersediaanSKPD2fmSKPD').value;
		var d = document.getElementById('pengeluaranPersediaanSKPD2fmUNIT').value;
		var e = document.getElementById('pengeluaranPersediaanSKPD2fmSUBUNIT').value;
		var e1 = document.getElementById('pengeluaranPersediaanSKPD2fmSEKSI').value;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		var url2 = this.url;
		$.ajax({
			type:'POST',
			data: $('#'+this.formName).serialize()+"&jenisKegiatan="+jenisKegiatan+"&cetakjang="+cetakjang+"&urusan="+c1+"&bidang="+c+"&skpd="+d+"&unit="+e+"&subunit="+e1,
				// { 
				// 	jenisKegiatan : $("#jenisKegiatan").val(),
				// 	cetakjang	  : $("#cetakjang").val(),
				// 	ttd			  : $("#ttd").val(),
				// 	c1			  : $("#pengeluaranPersediaanSKPD2fmURUSAN").val(),
				// 	c 			  : $("#pengeluaranPersediaanSKPD2fmSKPD").val(),
				// 	d 			  : $("#pengeluaranPersediaanSKPD2fmUNIT").val(),
				// 	e  			  : $("#pengeluaranPersediaanSKPD2fmSUBUNIT").val(),
				// 	e1 			  : $("#pengeluaranPersediaanSKPD2fmSEKSI").val(),

				// },
			url: this.url+'&tipe=Report2',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){

					aForm.action= url2+'&tipe='+resp.content.to+'&nomor='+resp.content.nomor+'&idna='+resp.content.idna+'&urusan='+$("#pengeluaranPersediaanSKPD2fmURUSAN").val()+'&bidang='+$("#pengeluaranPersediaanSKPD2fmSKPD").val()+'&skpd='+$("#pengeluaranPersediaanSKPD2fmUNIT").val()+'&unit='+$("#pengeluaranPersediaanSKPD2fmSUBUNIT").val()+'&subunit='+$("#pengeluaranPersediaanSKPD2fmSEKSI").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd;
					aForm.target='_blank';
					aForm.submit();
					aForm.target='';
					me.Close();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	Laporan:function(){

			var url2 = this.url;
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=Report',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						window.open(url2+'&tipe=Laporan','_blank');

					}else{
						alert(resp.err);
					}

			  	}
			});
	},
	Laporan3:function(){
		var me = this;
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
			  	url: this.url+'&tipe=Laporan3',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						delElem(cover);
						alert(resp.err);
					}

			  	}
			});
	},
	Laporan4:function(){
		var me = this;
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
			  	url: this.url+'&tipe=Laporan4',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						delElem(cover);
						alert(resp.err);
					}

			  	}
			});
	},
	formAlokasi:function(){
		var me = this;
		var cover = this.prefix+'_formcover';


			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formAlokasi',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.body.style.overflow='hidden';
						addCoverPage2(cover,999,true,false);
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);
					}


			  	}
			});


	},
	formAlokasiTriwulan:function(){
		var me = this;
		var cover = this.prefix+'_formcover';

			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formAlokasiTriwulan',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.body.style.overflow='hidden';
						addCoverPage2(cover,999,true,false);
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);
					}


			  	}
			});

	},

	jenisPerhitunganChanged : function(){
		if($("#jenisPerhitungan").val() == "SEMI OTOMATIS" ){
			$("#buttonHitung").attr('disabled',false);
		}else{
			$("#buttonHitung").attr('disabled',true);
		}

	},
	jenisAlokasiChanged : function(){


		if($("#jenisAlokasi").val() == "BULANAN"){
			var me= this;
			this.OnErrorClose = false;
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);
			delElem(cover);
			me.Close();
			$.ajax({
				type:'POST',
				url: this.url+'&tipe=clearAlokasi',
				success: function(data) {
					pengeluaranPersediaan.formAlokasi();
				}
			});


		}else if($("#jenisAlokasi").val() == "TRIWULAN"){
			var me= this;
			this.OnErrorClose = false;
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);
			delElem(cover);
			me.Close();
			$.ajax({
				type:'POST',
				url: this.url+'&tipe=clearAlokasi',
				success: function(data) {
					pengeluaranPersediaan.formAlokasiTriwulan();
				}
			});

		}else{
			var me= this;
			this.OnErrorClose = false;
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);
			delElem(cover);
			me.Close();
			$.ajax({
				type:'POST',
				url: this.url+'&tipe=clearAlokasi',
				success: function(data) {
					pengeluaranPersediaan.formAlokasi();
				}
			});
		}



	},
	hitungSelisih:function(namaBantu){
		var jan = Number($("#jan").val());
		var feb = Number($("#feb").val());
		var mar = Number($("#mar").val());
		var apr = Number($("#apr").val());
		var mei = Number($("#mei").val());
		var jun = Number($("#jun").val());
		var jul = Number($("#jul").val());
		var agu = Number($("#agu").val());
		var sep = Number($("#sep").val());
		var okt = Number($("#okt").val());
		var nop = Number($("#nop").val());
		var des = Number($("#des").val());

		var idPost =  namaBantu.replace("bantu", "");
		idPost = idPost.toLowerCase();
		$("#"+namaBantu).text("Rp. "+this.formatCurrency($("#"+idPost).val())  );

		var jumlahHargaAlokasi = Number( jan + feb + mar + apr + mei + jun + jul + agu + sep + okt + nop + des );
		$("#jumlahHargaAlokasi").val(jumlahHargaAlokasi);
		var selisih = Number( Number($("#jumlahHargaForm").val()) -  Number( jan + feb + mar + apr + mei + jun + jul + agu + sep + okt + nop + des ) );
		$("#selisih").val(selisih);
		$("#bantuPenjumlahan").text("Rp. "+this.formatCurrency(jumlahHargaAlokasi)  );
		$("#bantuSelisih").text("Rp. "+this.formatCurrency(selisih)  );
	},
	hitung: function(){
		if($("#jenisAlokasi").val() == '' ){
			alert("Pilih Jenis Alokasi");
		}else if($("#jenisPerhitungan").val() == ''){
			alert("Pilih Jenis Perhitungan");
		}else{
			if($("#jenisAlokasi").val() == "BULANAN"){
				var jumlahHargaForm = $("#jumlahHargaForm").val();
				$("#jan").val(jumlahHargaForm / 12);
				$("#feb").val(jumlahHargaForm / 12);
				$("#mar").val(jumlahHargaForm / 12);
				$("#apr").val(jumlahHargaForm / 12);
				$("#mei").val(jumlahHargaForm / 12);
				$("#jun").val(jumlahHargaForm / 12);
				$("#jul").val(jumlahHargaForm / 12);
				$("#agu").val(jumlahHargaForm / 12);
				$("#sep").val(jumlahHargaForm / 12);
				$("#okt").val(jumlahHargaForm / 12);
				$("#nop").val(jumlahHargaForm / 12);
				$("#des").val(jumlahHargaForm / 12);
				this.hitungSelisih('bantuJan');
				this.hitungSelisih('bantuFeb');
				this.hitungSelisih('bantuApr');
				this.hitungSelisih('bantuMei');
				this.hitungSelisih('bantuJul');
				this.hitungSelisih('bantuAgu');
				this.hitungSelisih('bantuOkt');
				this.hitungSelisih('bantuNop');
				this.hitungSelisih('bantuMar');
				this.hitungSelisih('bantuJun');
				this.hitungSelisih('bantuSep');
				this.hitungSelisih('bantuDes');
			}else if($("#jenisAlokasi").val() == "TRIWULAN"){
				var jumlahHargaForm = $("#jumlahHargaForm").val();
				$("#jan").val('');
				$("#feb").val('');
				$("#mar").val(jumlahHargaForm / 4);
				$("#apr").val('');
				$("#mei").val('');
				$("#jun").val(jumlahHargaForm / 4);
				$("#jul").val('');
				$("#agu").val('');
				$("#sep").val(jumlahHargaForm / 4);
				$("#okt").val('');
				$("#nop").val('');
				$("#des").val(jumlahHargaForm / 4);
				this.hitungSelisih('bantuMar');
				this.hitungSelisih('bantuJun');
				this.hitungSelisih('bantuSep');
				this.hitungSelisih('bantuDes');
			}

		}


	},

	checkAlokasi : function(){

			var me = this;
			errmsg = this.CekCheckbox();
			if(errmsg ==''){
				var box = this.GetCbxChecked();
				$.ajax({
				type:'POST',
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=checkAlokasi',
			  		success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == ''){
							if(resp.content.jenis == "BULANAN"){
								pengeluaranPersediaan.formAlokasi();
							}else if(resp.content.jenis == "TRIWULAN"){
								pengeluaranPersediaan.formAlokasiTriwulan();
							}else{
								pengeluaranPersediaan.formAlokasi();
							}
						}else{
						alert(resp.err);
						if(resp.err == 'Tahap Telah Habis'){
							window.location.reload();
							}
						}

					}
				});
			}else{
				alert(errmsg);
			}



	},

	SaveAlokasi : function(id){

			var me= this;
			this.OnErrorClose = false;
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type:'POST',
				data:{  jumlahHarga : $("#jumlahHargaForm").val(),
						jenisAlokasi : $("#jenisAlokasi").val(),
						jan	: $("#jan").val(),
						feb : $("#feb").val(),
						mar : $("#mar").val(),
						apr : $("#apr").val(),
						mei : $("#mei").val(),
						jun : $("#jun").val(),
						jul : $("#jul").val(),
						agu : $("#agu").val(),
						sep : $("#sep").val(),
						okt : $("#okt").val(),
						nop : $("#nop").val(),
						des : $("#des").val(),
						jumlahHargaAlokasi : $("#jumlahHargaAlokasi").val(),
						c1 : $("#cmbUrusan").val(),
						c  : $("#cmbBidang").val(),
						d  : $("#cmbSKPD").val(),
						idRekening : id
						},
				url: this.url+'&tipe=saveAlokasi',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					delElem(cover);
					if(resp.err == ''){
						me.Close();
						pengeluaranPersediaan.refreshList(true);
					}else{
						alert(resp.err);
						if(resp.err == 'Tahap Telah Habis'){
							window.location.reload();
						}
					}

				 }
			});


	},
	Sync: function(){

		var me= this;
		$.ajax({
			type:'POST',
			url: this.url+'&tipe=sync',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					me.refreshList(true);
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
});
