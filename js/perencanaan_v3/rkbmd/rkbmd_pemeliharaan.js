var rkbmd_pemeliharaan_v3SKPD = new SkpdCls({
	prefix : 'rkbmd_pemeliharaan_v3SKPD', formName:'rkbmd_pemeliharaan_v3Form', kolomWidth:120,

	a : function(){
		alert('dsf');
	},
});

var rkbmd_pemeliharaan_v3 = new DaftarObj2({
	prefix : 'rkbmd_pemeliharaan_v3',
	url : 'pages.php?Pg=rkbmd_pemeliharaan_v3',
	formName : 'rkbmd_pemeliharaan_v3Form',
	satuan_form : '0',//default js satuan



	loading: function(){

		this.topBarRender();
		this.filterRender();


	},
	CekAda : function(){
			$.ajax({
				type:'POST',
				data:{urusan : $("#urusan").val(),
					  bidang : $("#bidang").val(),
					  skpd   : $("#skpd").val(),
					  unit   : $("#unit").val(),
					  subunit : $("#subunit").val(),
					  bk     : $("#bk").val(),
					  ck 	 : $("#ck").val(),
					  dk     : $("#dk").val(),
					  p      : $("#p").val(),
					  q      : $("#q").val()
					 },
				url: this.url+'&tipe=CekAda',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.content.status == 'ada'){
						//rkbmd_pemeliharaan_v3.refreshList(true);
					}

				}
			});
	},
	closeTab : function(){

		if(document.getElementById('q').disabled == true){
			$.ajax({
				type:'POST',
				url: this.url+'&tipe=clear',
				success: function(data) {
					$("#bk").val('');
					$("#ck").val('');
					$("#dk").val('');
					$("#p").val('');
					$("#q").val('');
					$("#program").val('');
				window.location.reload();
				}
			});
		}else{
			window.opener.location.reload();
			var ww = window.open(window.location, '_self');
			ww.close();
		}



	},

	tabelPemeliharaan:function(kodeBarang){
		var me = this;
			$.ajax({
					type:'POST',
					data : {kodeBarang : kodeBarang},
			  	url: this.url+'&tipe=tabelPemeliharaan',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelPemeliharaan').innerHTML = resp.content.tabelPemeliharaan;
					}else{
						alert(resp.err);
					}
			  	}
			});
	},
	cancelPemeliharaan:function(kodeBarang){
		var me = this;
			$.ajax({
					type:'POST',
					data : {kodeBarang : kodeBarang},
			  	url: this.url+'&tipe=tabelPemeliharaan',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelPemeliharaan').innerHTML = resp.content.tabelPemeliharaan;
					}else{
						alert(resp.err);
					}
			  	}
			});
	},

	addNewPemeliharaan:function(){
		var me = this;
		var err = "";
		if($("#kodeBarang").val() == ''){
			err = "Pilih Barang !";
		}
		if(err == ''){
			$.ajax({
				type:'POST',
					url: this.url+'&tipe=addNewPemeliharaan',
					data : {kodeBarang : $("#kodeBarang").val(),
									satuanBarang : $("#satuanBarang").val()
									},
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelPemeliharaan').innerHTML = resp.content.tabelPemeliharaan;
					}else{
						alert(resp.err);
					}


					}
			});
		}else{
			alert(err);
		}



	},
	editPemeliharaan:function(idEdit){
		var me = this;
		var err = "";

		if(err == ''){
			$.ajax({
				type:'POST',
					url: this.url+'&tipe=editPemeliharaan',
					data : {
										kodeBarang : $("#kodeBarang").val(),
										idEdit : idEdit,
									},
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelPemeliharaan').innerHTML = resp.content.tabelPemeliharaan;
					}else{
						alert(resp.err);
					}


					}
			});
		}else{
			alert(err);
		}



	},
	deletePemeliharaan:function(idEdit){
		var me = this;
		var err = "";

		if(err == ''){
			$.ajax({
				type:'POST',
					url: this.url+'&tipe=deletePemeliharaan',
					data : {
										kodeBarang : $("#kodeBarang").val(),
										idEdit : idEdit,
									},
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelPemeliharaan').innerHTML = resp.content.tabelPemeliharaan;
					}else{
						alert(resp.err);
					}


					}
			});
		}else{
			alert(err);
		}



	},
	saveEditPemeliharaan:function(idEdit){
		var me = this;
		var err = "";

		if(err == ''){
			$.ajax({
				type:'POST',
					url: this.url+'&tipe=saveEditPemeliharaan',
					data : {
										kodeBarang : $("#kodeBarang").val(),
										idEdit : idEdit,
										listIdBukuInduk : $("#listIdBukuInduk").val(),
										tempJumlahBarang : $("#tempJumlahBarang").val(),
										tempKuantitas : $("#tempKuantitas").val(),
										tempSatuan : $("#tempSatuan").val(),
										jenisPemeliharaan : $("#jenisPemeliharaan").val(),
										tempUraianPemeliharaan : $("#tempUraianPemeliharaan").val(),
										tempKeterangan : $("#tempKeterangan").val(),
										kodeRekeningPemeliharaan : $("#kodeRekeningPemeliharaan").val(),
									},
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelPemeliharaan').innerHTML = resp.content.tabelPemeliharaan;
					}else{
						alert(resp.err);
					}


					}
			});
		}else{
			alert(err);
		}



	},

	BidangAfterform: function(){
		var me = this;
		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		$.ajax({
		  url: this.url+'&tipe=BidangAfterForm',
		  type : 'POST',
		  data:{ fmSKPDBidang: c,
		  		 fmSKPDUrusan: c1,
		  		 fmSKPDskpd: d,
		  		 fmSKPDUnit: $("#cmbUnitForm").val(),
		  		 fmSKPDSubUnit: $("#cmbSubUnitForm").val() },
		  success: function(data) {
			var resp = eval('(' + data + ')');
				document.getElementById('cmbSubUnitForm').innerHTML=resp.content.subunit;
		  }
		});

	},



    CariProgram: function(idRenja){
		var me = this;
		popupProgramRKBMD_v3.idRenja = idRenja;
		popupProgramRKBMD_v3.kategori = "PEMELIHARAAN";
		popupProgramRKBMD_v3.windowShow();

	},
	CariBarang: function(kodeSKPD){
		var me = this;
		if($("#q").val() == ''){
			alert("Pilih Program dan Kegiatan");
		}else{
			popupBarangPemeliharaan_v3.skpd = kodeSKPD;
			popupBarangPemeliharaan_v3.windowShow();
		}


		/*alert(kodeSKPD);*/


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
		  	}
		});
	},

	EDIT:function(){
		$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=EDIT',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						alert("Data Tersimpan");

							window.opener.location.reload();
							var ww = window.open(window.location, '_self');
		 					ww.close();


					}else{
						alert(resp.err);
					}
				}
			});

	},

	Simpan: function(){
		$.ajax({
				type:'POST',
				data:{urusan : $("#urusan").val(),
					  bidang : $("#bidang").val(),
					  skpd   : $("#skpd").val(),
					  unit   : $("#unit").val(),
					  subunit : $("#subunit").val(),
					  bk     : $("#bk").val(),
					  ck 	 : $("#ck").val(),
					  dk     : $("#dk").val(),
					  p      : $("#p").val(),
					  q      : $("#q").val(),
					  kodeBarang : $("#kodeBarang").val(),
					  keterangan : $("#keterangan").val(),
					  jumlah : $("#jumlah").val(),
					  jumlahKebutuhanMaksimal : $("#jumlahKebutuhanMaksimal").val(),
					  jumlahKebutuhanOptimal : $("#jumlahKebutuhanOptimal").val(),
					  jumlahKebutuhanRiil : $("#jumlahKebutuhanRiil").val(),
					  tahunAnggaran : $("#tahunAnggaran").val()
					 },
				url: this.url+'&tipe=Simpan',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						document.getElementById("findProgram").disabled = true;
						document.getElementById("q").innerHTML= resp.content.q;
						document.getElementById("q").disabled = true;
						document.getElementById('btcancel').href = 'javascript:rkbmd_pemeliharaan_v3.subCancel();';
						//document.getElementById('findBarang').disabled = true;
						document.getElementById('satuanBarang').readOnly = true;
						rkbmd_pemeliharaan_v3.tabelPemeliharaan($("#kodeBarang").val());

					}else{
						alert(resp.err);
					}

				}
			});


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

	isNumberKey: function(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))

		return false;
		return true;
	},
	hapus : function(id){
		$.ajax({
				type:'POST',
				data:{id : id},
				url: this.url+'&tipe=subDelete',
				success: function(data) {
					rkbmd_pemeliharaan_v3.refreshList(true);
				}
			});
	},subHapus : function(id){
		$.ajax({
				type:'POST',
				data:{id : id},
				url: this.url+'&tipe=subHapus',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.content == 'refresh'){
						rkbmd_pemeliharaan_v3.refreshList(true);
					}else{
						location.reload();
					}

				}
			});
	},
	newPemeliharaan: function(){
		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var arrayE = $("#unit").val().split('.');
		var arrayE1 = $("#subunit").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		var e = arrayE[0];
		var e1 = arrayE1[0];
		$.ajax({
			type:'POST',
			data:{c1 		 : c1,
				  c 		 : c,
				  d 		 : d,
				  e  		 : e,
				  e1 		 : e1,
				  bk		 : $("#bk").val(),
				  ck		 : $("#ck").val(),
				  dk		 : $("#dk").val(),
				  p			 : $("#p").val(),
				  q			 : $("#q").val(),
				  kodeBarang : $("#kodeBarang").val(),
				  satuan     : $("#satuanBarang").val()
				  },
			url: this.url+'&tipe=newRowPemeliharaan',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
						var idnya = resp.content.id;
						rkbmd_pemeliharaan_v3.tabelPemeliharaan(idnya);

				}else{
					alert(resp.err);
				}
			}
		});
	},
	subSubSave: function(id){
		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var arrayE = $("#unit").val().split('.');
		var arrayE1 = $("#subunit").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		var e = arrayE[0];
		var e1 = arrayE1[0];
		$.ajax({
			type:'POST',
			data:{c1 		 : c1,
				  c 		 : c,
				  d 		 : d,
				  e  		 : e,
				  e1 		 : e1,
				  bk		 : $("#bk").val(),
				  ck		 : $("#ck").val(),
				  dk		 : $("#dk").val(),
				  p			 : $("#p").val(),
				  q			 : $("#q").val(),
				  kodeBarang : $("#kodeBarang").val(),
				  id 		 : id,
				  idJenisPemeliharaan : $("#jenisPemeliharaan"+id).val(),
				  uraianPemeliharaan  : $("#uraianPemeliharaan"+id).val(),
				  volumeBarang		  : $("#jumlah"+id).val(),
				  keterangan		  : $("#keterangan"+id).val(),
				  limit				  : $("#jumlah").val()

				  },
			url: this.url+'&tipe=subSubSave',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
						rkbmd_pemeliharaan_v3.tabelPemeliharaan(1);
				}else{
					alert(resp.err);
				}
			}
		});
	},

	subSimpan: function(){
		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var arrayE = $("#unit").val().split('.');
		var arrayE1 = $("#subunit").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		var e = arrayE[0];
		var e1 = arrayE1[0];
		$.ajax({
			type:'POST',
			data:{c1 		 : c1,
				  c 		 : c,
				  d 		 : d,
				  e  		 : e,
				  e1 		 : e1,
				  bk		 : $("#bk").val(),
				  ck		 : $("#ck").val(),
				  dk		 : $("#dk").val(),
				  p			 : $("#p").val(),
				  q			 : $("#q").val(),
				  kodeBarang : $("#kodeBarang").val(),
				  satuan    : $("#satuanBarang").val(),

				  },
			url: this.url+'&tipe=subSimpan',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){

						/*document.getElementById("q").innerHTML= resp.content.q;
						document.getElementById("q").disabled = true;
						document.getElementById("findProgram").disabled = true;
						$("#tbl_pemeliharaan").hide();
						$("#findBarang").attr('disabled',false);
						$("#kodeBarang").val("");
						$("#namaBarang").val("");
						$("#jumlah").val("");
						$("#satuanBarang").val("");
						$("#baik").val("");
						$("#kurangBaik").val("");
						$("#rusakBerat").val("");*/
						rkbmd_pemeliharaan_v3.refreshList(true);
				}else{
					alert(resp.err);
				}
			}
		});
	},

	moveBack: function(){
		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var arrayE = $("#unit").val().split('.');
		var arrayE1 = $("#subunit").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		var e = arrayE[0];
		var e1 = arrayE1[0];
		$.ajax({
			type:'POST',
			data:{c1 		 : c1,
				  c 		 : c,
				  d 		 : d,
				  e  		 : e,
				  e1 		 : e1,
				  bk		 : $("#bk").val(),
				  ck		 : $("#ck").val(),
				  dk		 : $("#dk").val(),
				  p			 : $("#p").val(),
				  q			 : $("#q").val(),
				  satuan 	 : $("#satuanBarang").val(),
				  kodeBarang : $("#kodeBarang").val(),

				  },
			url: this.url+'&tipe=moveBack',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
						rkbmd_pemeliharaan_v3.refreshList(true);
				}else{
					alert(resp.err);
				}
			}
		});
	},

	subSubDel: function(id){
		$.ajax({
			type:'POST',
			data:{id : id},
			url: this.url+'&tipe=subSubDelete',
			success: function(data) {
				rkbmd_pemeliharaan_v3.tabelPemeliharaan(1);
			}
		});
	},

	subSubCancel: function(id){
		$.ajax({
			type:'POST',
			data:{id : id},
			url: this.url+'&tipe=subSubCancel',
			success: function(data) {
				//rkbmd_pemeliharaan_v3.tabelPemeliharaan(1);
			}
		});
	},
	moveList: function(id){
		$.ajax({
			type:'POST',
			data:{id : id},
			url: this.url+'&tipe=moveList',
			success: function(data) {
				var resp = eval('(' + data + ')');
				document.getElementById('btcancel').href = 'javascript:rkbmd_pemeliharaan_v3.subCancel();';
				rkbmd_pemeliharaan_v3.tabelPemeliharaan(resp.content.kodeBarang);
				$("#tbl_pemeliharaan").show();
				$("#kodeBarang").val(resp.content.kodeBarang);
				$("#namaBarang").val(resp.content.namaBarang);
				$("#baik").val(resp.content.baik);
				$("#kurangBaik").val(resp.content.kurangBaik);
				$("#rusakBerat").val(resp.content.rusakBerat);
				$("#satuanBarang").val(resp.content.satuan);
				$("#jumlah").val(resp.content.jumlah);
				$("#satuanBarang").attr('readonly',true);
				document.getElementById('findBarang').disabled = true;
			}
		});
	},

	edit : function(id){
		$.ajax({
				type:'POST',
				data:{id : id},
				url: this.url+'&tipe=subShowEdit',
				success: function(data) {
					var resp = eval('(' + data + ')');
					$("#kodeBarang").val(resp.content.kodeBarang);
					$("#namaBarang").val(resp.content.namaBarang);
					$("#satuan").val(resp.content.satuan);
					$("#jumlahKebutuhanRiil").val(resp.content.jumlahKebutuhanOptimal);
					$("#jumlahKebutuhanMaksimal").val(resp.content.jumlahKebutuhanMaksimal);
					$("#jumlahKebutuhanOptimal").val(resp.content.jumlahKebutuhanOptimal);
					$("#jumlah").val(resp.content.jumlah);
					$("#satuanBarang").val(resp.content.satuan);
					$("#keterangan").val(resp.content.keterangan);
					document.getElementById('btsave').href = 'javascript:rkbmd_pemeliharaan_v3.subEdit('+id+');';
					document.getElementById('btcancel').href = 'javascript:rkbmd_pemeliharaan_v3.subCancel();';
					document.getElementById('findBarang').disabled = true;
				}
			});


	},
	subCancel : function(){
		$.ajax({
				type:'POST',
				data:{kodeBarang : $("#kodeBarang").val()},
				url: this.url+'&tipe=subCancel',
				success: function(data) {
					var resp = eval('(' + data + ')');
					$("#kodeBarang").val('');
					$("#namaBarang").val('');
					$("#satuan").val('');
					$("#baik").val('');
					$("#kurangBaik").val('');
					$("#rusakBerat").val('');
					$("#tbl_pemeliharaan").hide();
					$("#satuanBarang").val('');
					$("#keterangan").val('');
					$("#jumlah").val('');
					document.getElementById('btcancel').href = 'javascript:rkbmd_pemeliharaan_v3.closeTab();';
					document.getElementById('findBarang').disabled = false;
					document.getElementById('satuanBarang').readOnly= false;
					rkbmd_pemeliharaan_v3.tabelPemeliharaan('');
				}
			});



	},
	subEdit : function(id){
			$.ajax({
				type:'POST',
				data:{id : id,
					  jumlah : $("#jumlah").val(),
					  jumlahKebutuhanRiil : $("#jumlahKebutuhanRiil").val(),
					  keterangan : $("#keterangan").val()},
				url: this.url+'&tipe=subEdit',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						rkbmd_pemeliharaan_v3.refreshList(true);
						document.getElementById('btsave').href = 'javascript:rkbmd_pemeliharaan_v3.Simpan());';
						document.getElementById('btcancel').href = 'javascript:rkbmd_pemeliharaan_v3.closeTab();';
						document.getElementById('findBarang').disabled = false;
					}else{
						alert(resp.err);
					}

				}
			});
	},
	finish : function(){

		$.ajax({
				type:'POST',
				data:{test : 'test'},
				url: this.url+'&tipe=finish',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ""){
						window.opener.location.reload();
						var ww = window.open(window.location, '_self');
						ww.close();
					}else{
						alert(resp.err);
					}


				}
			});

	},
	findRegisterBI:function(){
		var me = this;

		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var arrayE = $("#unit").val().split('.');
		var arrayE1 = $("#subunit").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		var e = arrayE[0];
		var e1 = arrayE1[0];

			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,2,true,false);
			$.ajax({
			  url: this.url+'&tipe=findRegisterBI',
			  type : 'POST',
			  data:	{
							 c1	  : c1,
							 c 		: c,
							 d 		: d,
							 e  	: e,
							 e1 	: e1,
							 bk		 : $("#bk").val(),
							 ck		 : $("#ck").val(),
							 dk		 : $("#dk").val(),
							 p			 : $("#p").val(),
							 q			 : $("#q").val(),
							 kodeBarang : $("#kodeBarang").val(),
							 listIdBukuInduk : $("#listIdBukuInduk").val()

						},
			  success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						listRegisterBukuInduk.c1 = c1;
						listRegisterBukuInduk.c = c;
						listRegisterBukuInduk.d = d;
						listRegisterBukuInduk.e = e;
						listRegisterBukuInduk.e1 = e1;
						listRegisterBukuInduk.kodeBarang = $("#kodeBarang").val();
						listRegisterBukuInduk.loading();
					}else{
						alert(resp.err);
					}

			  }
			});


	},

	saveSelectedRegistar: function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#listRegisterBukuIndukForm').serialize(),
			url: this.url+'&tipe=saveSelectedRegistar',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					$("#tempJumlahBarang").val(resp.content.jumlahBarang);
					$("#tempJumlahBarangText").val(resp.content.jumlahBarang);
					$("#listIdBukuInduk").val(resp.content.listIdBukuInduk);
					me.Close();

				}
				else{
					alert(resp.err);
				}
		  	}
		});
	},

	findRekeningPemeliharaan : function(){
		var me = this;
		var filterRek = "RKA 2.2.1";

		popupRekening.el_kode_rekening = 'kodeRekeningPemeliharaan';
		popupRekening.el_nama_rekening = 'tempKeterangan';
		popupRekening.windowSaveAfter= function(){};
		popupRekening.filterAkun=filterRek;
		popupRekening.windowShow();

	},

	jumlahKaliKuantiti: function(){
			$("#tempVolume").val($("#tempJumlahBarang").val() * $("#tempKuantitas").val() );
	},
	satuanChanged: function(){
		$("#tempSatuan").val($("#tempSatuanSatu").val() + "/" +$("#tempSatuanDua").val());
	},

	saveNewPemeliharaan : function(){
		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var arrayE = $("#unit").val().split('.');
		var arrayE1 = $("#subunit").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		var e = arrayE[0];
		var e1 = arrayE1[0];
		$.ajax({
				type:'POST',
				data:{
							listIdBukuInduk : $("#listIdBukuInduk").val(),
							tempJumlahBarang : $("#tempJumlahBarang").val(),
							tempKuantitas : $("#tempKuantitas").val(),
							tempSatuan : $("#tempSatuan").val(),
							jenisPemeliharaan : $("#jenisPemeliharaan").val(),
							tempUraianPemeliharaan : $("#tempUraianPemeliharaan").val(),
							tempKeterangan : $("#tempKeterangan").val(),
							c1	  : c1,
							c 		: c,
							d 		: d,
							e  	: e,
							e1 	: e1,
							bk		 : $("#bk").val(),
							ck		 : $("#ck").val(),
							dk		 : $("#dk").val(),
							p			 : $("#p").val(),
							q			 : $("#q").val(),
							kodeBarang : $("#kodeBarang").val(),
							kodeRekeningPemeliharaan : $("#kodeRekeningPemeliharaan").val(),
						},
				url: this.url+'&tipe=saveNewPemeliharaan',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ""){
						rkbmd_pemeliharaan_v3.tabelPemeliharaan($("#kodeBarang").val());
					}else{
						alert(resp.err);
					}


				}
			});

	},
	saveTempPemeliharaan : function(){
		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var arrayE = $("#unit").val().split('.');
		var arrayE1 = $("#subunit").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		var e = arrayE[0];
		var e1 = arrayE1[0];
		$.ajax({
				type:'POST',
				data:{
							c1	  : c1,
							c 		: c,
							d 		: d,
							e  	: e,
							e1 	: e1,
							bk		 : $("#bk").val(),
							ck		 : $("#ck").val(),
							dk		 : $("#dk").val(),
							p			 : $("#p").val(),
							q			 : $("#q").val(),
							kodeBarang : $("#kodeBarang").val(),
						},
				url: this.url+'&tipe=saveTempPemeliharaan',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ""){
						rkbmd_pemeliharaan_v3.refreshList(true);
					}else{
						alert(resp.err);
					}


				}
			});

	},

});
