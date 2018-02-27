var daftarPersediaanBarangSKPD2 = new SkpdCls({
	prefix : 'daftarPersediaanBarangSKPD2',
	formName: 'daftarPersediaanBarangForm',

	pilihUrusanfter : function(){daftarPersediaanBarang.refreshList(true);},
	pilihBidangAfter : function(){daftarPersediaanBarang.refreshList(true);},
	pilihUnitAfter : function(){daftarPersediaanBarang.refreshList(true);},
	pilihSubUnitAfter : function(){daftarPersediaanBarang.refreshList(true);},
	pilihSeksiAfter : function(){daftarPersediaanBarang.refreshList(true);}
});
var daftarPersediaanBarang = new DaftarObj2({
	prefix : 'daftarPersediaanBarang',
	url : 'pages.php?Pg=daftarPersediaanBarang',
	formName : 'daftarPersediaanBarangForm',
	daftarPersediaanBarang_form : '0',//default js daftarPersediaanBarang
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
  	Close2: function(){
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);
		if(tipe==null){
				document.body.style.overflow = 'auto';
		}
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
					c1			  : $("#daftarPersediaanBarangSKPD2fmURUSAN").val(),
					c 			  : $("#daftarPersediaanBarangSKPD2fmSKPD").val(),
					d 			  : $("#daftarPersediaanBarangSKPD2fmUNIT").val(),
					e 			  : $("#daftarPersediaanBarangSKPD2fmSUBUNIT").val(),
					e1 			  : $("#daftarPersediaanBarangSKPD2fmSEKSI").val(),
					filterPeriode  : $("#filterPeriode").val(),

					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){

					aForm.action= url2+'&tipe='+resp.content.to+'&filterPeriode='+$("#filterPeriode").val()+'&urusan='+$("#daftarPersediaanBarangSKPD2fmURUSAN").val()+'&bidang='+$("#daftarPersediaanBarangSKPD2fmSKPD").val()+'&skpd='+$("#daftarPersediaanBarangSKPD2fmUNIT").val()+'&unit='+$("#daftarPersediaanBarangSKPD2fmSUBUNIT").val()+'&subunit='+$("#daftarPersediaanBarangSKPD2fmSEKSI").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd;
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
	programChanged : function(){
		var arrayP = $("#p").val().split('.');;
		var bk = arrayP[0];
		var ck = arrayP[1];
		var hiddenP = arrayP[2];

		$("#bk").val(bk);
		$("#ck").val(ck);
		$("#hiddenP").val(hiddenP);
		$("#q").val('');
		daftarPersediaanBarang.refreshList(true);
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
		daftarPersediaanBarang.refreshList(true);

	},BidangAfter2: function(){
		daftarPersediaanBarang.refreshList(true);

	},comboSKPDChanged: function(){
		daftarPersediaanBarang.refreshList(true);

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
	pilihPangkat : function(){
	var me = this; 
		$.ajax({
		  url: this.url+'&tipe=pilihPangkat',
		  type : 'POST',
		  data:{
				c1			  : $("#daftarPersediaanBarangSKPD2fmURUSAN").val(),
				c 			  : $("#daftarPersediaanBarangSKPD2fmSKPD").val(),
				d 			  : $("#daftarPersediaanBarangSKPD2fmUNIT").val(),
				e 			  : $("#daftarPersediaanBarangSKPD2fmSUBUNIT").val(),
				e1 			  : $("#daftarPersediaanBarangSKPD2fmSEKSI").val(),
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
	Simpan: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = 'renjaAset'+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:{
				jenisKegiatan : $("#jenisKegiatan").val(),
				c1			  : $("#daftarPersediaanBarangSKPD2fmURUSAN").val(),
				c 			  : $("#daftarPersediaanBarangSKPD2fmSKPD").val(),
				d 			  : $("#daftarPersediaanBarangSKPD2fmUNIT").val(),
				e 			  : $("#daftarPersediaanBarangSKPD2fmSUBUNIT").val(),
				e1 			  : $("#daftarPersediaanBarangSKPD2fmSEKSI").val(),
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
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					document.getElementById('ttd').innerHTML = resp.content.combottd;
					daftarPersediaanBarang.Close();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	Baru: function(){
		var me = this;
		var err='';
		var urusan = document.getElementById('daftarPersediaanBarangSKPD2fmURUSAN').value; 
		var bidang = document.getElementById('daftarPersediaanBarangSKPD2fmSKPD').value; 
		var skpd = document.getElementById('daftarPersediaanBarangSKPD2fmUNIT').value;
		var unit = document.getElementById('daftarPersediaanBarangSKPD2fmSUBUNIT').value;
		var subunit = document.getElementById('daftarPersediaanBarangSKPD2fmSEKSI').value;
		
		var cover = this.prefix+'_formcover';
		if(err==''){
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize()+"&urusan="+urusan+"&bidang="+bidang+"&skpd="+skpd+"&unit="+unit+"&subunit="+subunit,
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {
			  		delElem(cover);
					var resp = eval('(' + data + ')');
					
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
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
	// Baru: function(){
	// 	var me = this;
	// 	if($("#"+me.prefix+"SKPD2fmURUSAN").val()  == '0'){
	// 	 	alert("Pilih Urusan");
	// 	}else if($("#"+me.prefix+"SKPD2fmSKPD").val()  == '00'){
	// 		alert("Pilih Bidang");
	// 	}else if($("#"+me.prefix+"SKPD2fmUNIT").val()  == '00'){
	// 		alert("Pilih SKPD");
	// 	}else if($("#"+me.prefix+"SKPD2fmSUBUNIT").val() == '00'){
	// 		alert("Pilih Unit");
	// 	}else if($("#"+me.prefix+"SKPD2fmSEKSI").val() == '000'){
	// 		alert("Pilih Sub Unit");
	// 	}else{

	// 			var skpd = $("#"+me.prefix+"SKPD2fmURUSAN").val()+'.'+$("#"+me.prefix+"SKPD2fmSKPD").val()+'.'+$("#"+me.prefix+"SKPD2fmUNIT").val()+'.'+$("#"+me.prefix+"SKPD2fmSUBUNIT").val()+'.'+$("#"+me.prefix+"SKPD2fmSEKSI").val();

	// 			var aForm = document.getElementById(this.formName);
	// 			$.ajax({
	// 			type:'POST',
	// 			data : {c1 : $("#"+me.prefix+"SKPD2fmURUSAN").val(),
	// 					c  : $("#"+me.prefix+"SKPD2fmSKPD").val(),
	// 					d  : $("#"+me.prefix+"SKPD2fmUNIT").val(),
	// 					e  : $("#"+me.prefix+"SKPD2fmSUBUNIT").val(),
	// 					e1 : $("#"+me.prefix+"SKPD2fmSEKSI").val(),

	// 					},
	// 		  	url: this.url+'&tipe=newTab',
	// 		  	success: function(data) {
	// 				var resp = eval('(' + data + ')');
	// 				if(resp.err == ''){
	// 					aForm.action= 'pages.php?Pg=daftarPersediaanBarang_ins&skpd='+skpd+"&nomor="+resp.content.nomor;
	// 					aForm.target='_blank';
	// 					aForm.submit();
	// 					aForm.target='';
	// 				}else{
	// 					alert(resp.err);
	// 				}

	// 			 }
	// 		});


	// 	}

	// },
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
			$("#findRekening").attr('onclick',"daftarPersediaanBarang.findRekening('"+$("#cmbJenisRKAForm").val()+"');");

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
							aForm.action= 'pages.php?Pg=daftarPersediaanBarang_ins&skpd='+resp.content.skpd+"&nomor="+resp.content.nomor;
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
	lockBarang:function(){
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
				url: this.url+'&tipe=lockBarang',
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
	kartuPersediaan:function(){
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
				url: this.url+'&tipe=kartuPersediaan',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						listKartuKunci.loading(resp.cek);
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
	showKartu:function(idLock){
		var me = this;
		if($("#filterPeriode").val() != ''){
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,2,true,false);
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=showKartu',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						listKartuKunci.loading(idLock);
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
					}
			});
		}else{
				alert("Pilih Periode");
		}

	},
	checkError:function(idPersediaan){
		var me = this;
		if($("#filterPeriode").val() != ''){
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,2,true,false);
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize()+"&idPersediaan="+idPersediaan,
				url: this.url+'&tipe=checkError',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						kartuError.loading(idPersediaan);
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
					}
			});
		}else{
				alert("Pilih Periode");
		}

	},
	detailPengeluaran:function(idPengeluaran){
		var me = this;

		var cover = this.prefix+'_formcoverDetailPengeluaran';
		addCoverPage2(cover,4,true,false);
		document.body.style.overflow='hidden';
		$.ajax({
			type:'POST',
			data:{idPengeluaran : idPengeluaran},
			url: this.url+'&tipe=detailPengeluaran',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					document.getElementById(cover).innerHTML = resp.content;
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}
		  	}
		});
	},
	detailPengeluaranTemp:function(idPengeluaran){
		var me = this;

		var cover = this.prefix+'_formcoverDetailPengeluaran';
		addCoverPage2(cover,4,true,false);
		document.body.style.overflow='hidden';
		$.ajax({
			type:'POST',
			data:{idPengeluaran : idPengeluaran},
			url: this.url+'&tipe=detailPengeluaranTemp',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					document.getElementById(cover).innerHTML = resp.content;
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}
		  	}
		});
	},

	CloseDetailPengeluaran:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverDetailPengeluaran';
		if(document.getElementById(cover)) delElem(cover);

	},


	saveLockBarang: function(idPosting){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize()+"&idPosting="+idPosting,
			url: this.url+'&tipe=saveLockBarang',
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
	unLockBarang: function(idLock){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize()+"&idLock="+idLock,
			url: this.url+'&tipe=unLockBarang',
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

	bantuVolumeBarang : function(id){
		document.getElementById('bantuVolumeBarang'+id).innerHTML = daftarPersediaanBarang.formatCurrency2($("#volumeBarang"+id).val());
		var hasilKali = Number($("#volumeBarang"+id).val()) * Number($("#satuanHarga"+id).val()) ;
		$("#spanJumlahHarga"+id).text(daftarPersediaanBarang.formatCurrency(hasilKali));
	},
	bantuSatuanHarga : function(id){
		document.getElementById('bantuSatuanHarga'+id).innerHTML =  daftarPersediaanBarang.formatCurrency($("#satuanHarga"+id).val());
		var hasilKali = Number($("#volumeBarang"+id).val()) * Number($("#satuanHarga"+id).val()) ;
		$("#spanJumlahHarga"+id).text(daftarPersediaanBarang.formatCurrency(hasilKali));
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
		$("#bantu").text("Rp. "+daftarPersediaanBarang.formatCurrency($("#hargaSatuan").val())  );

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

					//setTimeout(function myFunction() {daftarPersediaanBarang.jam()},100);
					//me.AfterFormBaru();
			  	}
			});
		}else{
			alert(errmsg);
		}

	},



	// Simpan: function(){
	// 	var me= this;
	// 	this.OnErrorClose = false
	// 	document.body.style.overflow='hidden';
	// 	var cover = this.prefix+'_formsimpan';
	// 	addCoverPage2(cover,1,true,false);
	// 	$.ajax({
	// 		type:'POST',
	// 		data:$('#'+this.prefix+'_form').serialize(),
	// 		url: this.url+'&tipe=simpan',
	// 	  	success: function(data) {
	// 			var resp = eval('(' + data + ')');
	// 			delElem(cover);
	// 			//document.getElementById(cover).innerHTML = resp.content;
	// 			if(resp.err==''){
	// 				if(me.daftarPersediaanBarang_form==0){
	// 					me.Close();
	// 					me.AfterSimpan();
	// 				}else{
	// 					me.Close();
	// 					barang.refreshCombodaftarPersediaanBarang();
	// 				}

	// 			}else{
	// 				alert(resp.err);
	// 			}
	// 	  	}
	// 	});
	// }
	// ,
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
					if(me.daftarPersediaanBarang_form==0){
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
					if(me.daftarPersediaanBarang_form==0){
						me.Close();
						me.AfterSimpan();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	Laporan:function(){
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
			  	url: this.url+'&tipe=Laporan',
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
	// Laporan:function(){

	// 		var url2 = this.url;
	// 		$.ajax({
	// 			type:'POST',
	// 			data:$('#'+this.formName).serialize(),
	// 		  	url: this.url+'&tipe=Report',
	// 		  	success: function(data) {
	// 				var resp = eval('(' + data + ')');
	// 				if(resp.err == ''){
	// 					window.open(url2+'&tipe=Laporan','_blank');

	// 				}else{
	// 					alert(resp.err);
	// 				}

	// 		  	}
	// 		});


	// },
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
					daftarPersediaanBarang.formAlokasi();
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
					daftarPersediaanBarang.formAlokasiTriwulan();
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
					daftarPersediaanBarang.formAlokasi();
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
								daftarPersediaanBarang.formAlokasi();
							}else if(resp.content.jenis == "TRIWULAN"){
								daftarPersediaanBarang.formAlokasiTriwulan();
							}else{
								daftarPersediaanBarang.formAlokasi();
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
						daftarPersediaanBarang.refreshList(true);
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
