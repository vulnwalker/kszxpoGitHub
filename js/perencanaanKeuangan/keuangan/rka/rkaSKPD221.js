var rkaSKPD221 = new DaftarObj2({
	prefix : 'rkaSKPD221',
	url : 'pages.php?Pg=rkaSKPD221',
	formName : 'rkaSKPD221Form',
	rkaSKPD221_form : '0',//default js rkaSKPD221
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();

    /*setTimeout(function myFunction() {},1000);*/

	},

	filterRenderAfter : function(){
		this.daftarRender();
	},
	programChanged : function(){
		var arrayP = $("#p").val().split('.');;
		var bk = arrayP[0];
		var ck = arrayP[1];
		var dk = arrayP[2];
		var hiddenP = arrayP[3];

		$("#bk").val(bk);
		$("#ck").val(ck);
		$("#dk").val(dk);
		$("#hiddenP").val(hiddenP);
		$("#q").val('');
		rkaSKPD221.refreshList(true);
	},
	findSSH : function(id){
		var me = this;
		$.ajax({
			type:'POST',
				url: this.url+'&tipe=getDataSSH',
				data : {	id : id
							},
				success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err == ''){
					popupSSH.kodeRekening = resp.content.kodeRekening;
					popupSSH.kodeBarang = resp.content.kodeBarang;
					popupSSH.dari = id;
					popupSSH.windowShow();
				}else{
					alert(resp.err);
				}


				}
		});



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
		rkaSKPD221.refreshList(true);

	},BidangAfter2: function(){
		rkaSKPD221.refreshList(true);

	},comboSKPDChanged: function(){
		rkaSKPD221.refreshList(true);

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
		var uri = this.url+'&tipe=daftar';
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
		if($("#cmbUrusan").val()  == ''){
		 	alert("Pilih Urusan");
		}else if($("#cmbBidang").val()  == ''){
			alert("Pilih Bidang");
		}else if($("#cmbSKPD").val()  == ''){
			alert("Pilih SKPD");
		}else if($("#hiddenP").val()  == ''){
			alert("Pilih Program");
		}else if($("#q").val()  == ''){
			alert("Pilih Kegiatan");
		}else{

				var skpd = $("#cmbUrusan").val()+'.'+$("#cmbBidang").val()+'.'+$("#cmbSKPD").val()+'.'+$("#cmbUnit").val()+'.'+$("#cmbSubUnit").val()+'.'+$("#bk").val()+'.'+$("#ck").val()+'.'+$("#dk").val()+'.'+$("#hiddenP").val()+'.'+$("#q").val();

				var aForm = document.getElementById(this.formName);
				$.ajax({
					type:'POST',
					data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=clearTemp',
			  	success: function(data) {

					aForm.action= 'pages.php?Pg=rkaSKPD221_ins&skpd='+skpd;
					aForm.target='_blank';
					aForm.submit();
					aForm.target='';
				 }
			});


		}

	},
	Info: function(){
		var me = this;
	    var cover = this.prefix+'_formcover';
			$.ajax({
				type:'POST',
			  	url: this.url+'&tipe=Info',
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
	infoSKPD: function(id_anggaran){
		var me = this;
	    var cover = this.prefix+'_formcover';
			$.ajax({
				type:'POST',
			  	url: this.url+'&tipe=infoSKPD',
				data : {id_anggaran : id_anggaran },
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
	unlockFindRekening: function(){
		var me = this;
		if( $("#cmbJenisRKAForm").val() == ""){
			$("#findRekening").attr('disabled',true);
		}else{
			$("#findRekening").attr('disabled',false);
			$("#findRekening").attr('onclick',"rkaSKPD221.findRekening('"+$("#cmbJenisRKAForm").val()+"');");

		}


	},
	Edit:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if($("#cmbUrusan").val()  == ''){
		 	alert("Pilih Urusan");
		}else if($("#cmbBidang").val()  == ''){
			alert("Pilih Bidang");
		}else if($("#cmbSKPD").val()  == ''){
			alert("Pilih SKPD");
		}else if($("#hiddenP").val()  == ''){
			alert("Pilih Program");
		}else if($("#q").val()  == ''){
			alert("Pilih Kegiatan");
		}else{
			if(errmsg ==''){
				var box = this.GetCbxChecked();

					var skpd = $("#cmbUrusan").val()+'.'+$("#cmbBidang").val()+'.'+$("#cmbSKPD").val()+'.'+$("#cmbUnit").val()+'.'+$("#cmbSubUnit").val()+'.'+$("#bk").val()+'.'+$("#ck").val()+'.'+$("#dk").val()+'.'+$("#hiddenP").val()+'.'+$("#q").val();

					var aForm = document.getElementById(this.formName);
					$.ajax({
						type:'POST',
						data:$('#'+this.formName).serialize(),
				  	url: this.url+'&tipe=clearTemp',
				  	success: function(data) {

						aForm.action= 'pages.php?Pg=rkaSKPD221_ins&skpd='+skpd;
						aForm.target='_blank';
						aForm.submit();
						aForm.target='';
					 }
				});
			}else{
				alert(errmsg);
			}
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
		}else if($("#hiddenP").val()  == ''){
			alert("Pilih Program");
		}else if($("#q").val()  == ''){
			alert("Pilih Kegiatan");
		}else{
			if(errmsg ==''){
				var box = this.GetCbxChecked();

				$.ajax({
				  url: this.url+'&tipe=Remove',
				  type : 'POST',
				  data:$('#'+this.formName).serialize(),
				  success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == "") {
							rkaSKPD221.refreshList(true);
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
						rkaSKPD221.refreshList(true);
					}else{
						alert(resp.err);
						if(resp.err == 'Tahap Koreksi Telah Habis'){
							window.location.reload();
						}
					}

				 }
			  });

	},
	koreksi:function(id){
		$("#spanVolumeBarang"+id).html("<input type='text' name='volumeBarang"+id+"' id='volumeBarang"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='rkaSKPD221.bantuVolumeBarang("+id+")'   style='text-align: right;'>  <span id='bantuVolumeBarang"+id+"' ></span>");
		$("#spanSatuanHarga"+id).html("<input type='text' name='satuanHarga"+id+"' id='satuanHarga"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='rkaSKPD221.bantuSatuanHarga("+id+")'    style='text-align: right;'>  <span id='bantuSatuanHarga"+id+"' ></span>");
		$("#buttonSubmitKoreksi"+id).html("<img src='datepicker/save.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkaSKPD221.submitKoreksi('"+id+"');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkaSKPD221.refreshList(true);></img>");
		$("#alignButton"+id).attr('align','center' );
	},
	submitKoreksi:function(id) {

			if( document.getElementById("volumeBarang"+id).value == 0 ){
				alert("Isi Volume Barang");
			}else if( document.getElementById("satuanHarga"+id).value == 0 ){
				alert("Isi Satuan Harga");
			}else{

/*			  rkaSKPD221.formAlokasi(id);*/

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
						rkaSKPD221.refreshList(true);
					}else{
						alert(resp.err);
						if(resp.err == 'Tahap Koreksi Telah Habis'){
							window.location.reload();
						}
					}

				 }
			  });


			}

	},

	bantuVolumeBarang : function(id){
		document.getElementById('bantuVolumeBarang'+id).innerHTML = rkaSKPD221.formatCurrency2($("#volumeBarang"+id).val());
		var hasilKali = Number($("#volumeBarang"+id).val()) * Number($("#satuanHarga"+id).val()) ;
		$("#spanJumlahHarga"+id).text(rkaSKPD221.formatCurrency(hasilKali));
	},
	bantuSatuanHarga : function(id){
		document.getElementById('bantuSatuanHarga'+id).innerHTML =  rkaSKPD221.formatCurrency($("#satuanHarga"+id).val());
		var hasilKali = Number($("#volumeBarang"+id).val()) * Number($("#satuanHarga"+id).val()) ;
		$("#spanJumlahHarga"+id).text(rkaSKPD221.formatCurrency(hasilKali));
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
		$("#bantu").text("Rp. "+rkaSKPD221.formatCurrency($("#hargaSatuan").val())  );

	},

	findRekening : function(id){
		var me = this;
		var filterRek = "";
		// if(jenisRka == "2.2.1"){
		// 	filterRek = "RKA 2.2.1";
		// }else if(jenisRka == "2.1"){
		// 	filterRek = "RKA 2.1";
		// }
		popupRekening.el_kode_rekening = 'hiddenRekening'+id;
		popupRekening.el_nama_rekening = 'textRekening'+id;
		popupRekening.windowSaveAfter= function(){};
		popupRekening.filterAkun="RKA 2.2.1";
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
	Validasi:function(id_anggaran){
		var me = this;
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			if(me.satuan_form==0){
				addCoverPage2(cover,1,true,false);
			}else{
				addCoverPage2(cover,999,true,false);
			}
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=Validasi&id_anggaran='+id_anggaran,
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						delElem(cover);
						alert(resp.err);
						if(resp.err == 'Tahap Penyusunan Telah Habis'){
							window.location.reload();
						}
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
					if(me.rkaSKPD221_form==0){
						me.Close();
						me.AfterSimpan();
					}else{
						me.Close();
						barang.refreshComborkaSKPD221();
					}

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
					if(me.rkaSKPD221_form==0){
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
	setGrup: function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=setGrup',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					if(me.rkaSKPD221_form==0){
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
	tujuanPostingChanged: function(){
			if($("#cmbPosting").val() =='9'){
					$("#jenisForm").val("READ");
					$("#namaTahap").val("PENETAPAN DPA");
					$("#namaModul").val("DPA");
			}else{
					$("#jenisForm").val("KOREKSI");
					$("#namaTahap").val("KOREKSI RKA");
					$("#namaModul").val("RKA");
			}
	},
	postDataRka: function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data: {	idModul : $("#cmbPosting").val(),
							jenisForm : $("#jenisForm").val(),
							anggaran : "MURNI",
							tahun : $("#tahunAnggaran").val(),
							namaModul : $("#namaModul").val(),
							nama_tahap : $("#namaTahap").val(),
							status : "AKTIF",
							bypassTahap_v2_fmST : 0
						},
			url: "pages.php?Pg=bypassTahap_v2&tipe=simpan",
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					if(me.rkaSKPD221_form==0){
						window.location.reload();

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
					if(me.rkaSKPD221_form==0){
						me.Close();
						me.AfterSimpan();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	Report:function(){

			var url2 = 'pages.php?Pg=rkaSKPD221New';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
			  	url: 'pages.php?Pg=rkaSKPD221New'+'&tipe=Report',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						window.open(url2+'&tipe=Laporan'+'&urusan='+resp.content.urusan+'&bidang='+resp.content.bidang+'&skpd='+resp.content.skpd+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&e='+resp.content.e+'&e1='+resp.content.e1+'&bk='+resp.content.bk+'&ck='+resp.content.ck+'&dk='+resp.content.dk+'&p='+resp.content.p+'&q='+resp.content.q,'_blank');

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
			  	url: 'pages.php?Pg=rkaSKPD221New'+'&tipe=Laporan',
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
	formAlokasi:function(id){
		var me = this;
		var cover = this.prefix+'_formcover';
		var volumeBarang = $("#volumeBarang"+id).val();
		var satuanHarga = $("#satuanHarga"+id).val();
		jumlahHarga = Number(volumeBarang) * Number(satuanHarga);

	if($("#jumlahHarga").val() == '' || $("#jumlahHarga").val() == '0' ){
		alert("Jumlah Harga Kosong");
	}else{
			$.ajax({
				type:'POST',
				data : {
						 jumlahHarga : jumlahHarga,
						 id	    : id
				},
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
	}

	},


	formAlokasiTriwulan:function(id){
		var me = this;
		var cover = this.prefix+'_formcover';
		var volumeBarang = $("#volumeBarang"+id).val();
		var satuanHarga = $("#satuanHarga"+id).val();
		jumlahHarga = Number(volumeBarang) * Number(satuanHarga);
	if($("#jumlahHarga").val() == '' || $("#jumlahHarga").val() == '0' ){
		alert("Jumlah Harga Kosong");
	}else{
			$.ajax({
				type:'POST',
				data : {
						  jumlahHarga : jumlahHarga,
						  id	    : id
				},
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
		$("#"+namaBantu).text("Rp. "+rkaSKPD221.formatCurrency($("#"+idPost).val())  );

		var jumlahHargaAlokasi = Number( jan + feb + mar + apr + mei + jun + jul + agu + sep + okt + nop + des );
		$("#jumlahHargaAlokasi").val(jumlahHargaAlokasi);
		var selisih = Number( Number($("#jumlahHargaForm").val()) -  Number( jan + feb + mar + apr + mei + jun + jul + agu + sep + okt + nop + des ) );
		$("#selisih").val(selisih);
		$("#bantuPenjumlahan").text("Rp. "+rkaSKPD221.formatCurrency(jumlahHargaAlokasi)  );
		$("#bantuSelisih").text("Rp. "+rkaSKPD221.formatCurrency(selisih)  );
	},
	jenisPerhitunganChanged : function(){
		if($("#jenisPerhitungan").val() == "SEMI OTOMATIS" ){
			$("#buttonHitung").attr('disabled',false);
		}else{
			$("#buttonHitung").attr('disabled',true);
		}

	},
	jenisAlokasiChanged : function(id){


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
					rkaSKPD221.formAlokasi(id);
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
					rkaSKPD221.formAlokasiTriwulan(id);
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
					rkaSKPD221.formAlokasi(id);
				}
			});
		}



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
				rkaSKPD221.hitungSelisih('bantuJan');
				rkaSKPD221.hitungSelisih('bantuFeb');
				rkaSKPD221.hitungSelisih('bantuApr');
				rkaSKPD221.hitungSelisih('bantuMei');
				rkaSKPD221.hitungSelisih('bantuJul');
				rkaSKPD221.hitungSelisih('bantuAgu');
				rkaSKPD221.hitungSelisih('bantuOkt');
				rkaSKPD221.hitungSelisih('bantuNop');
				rkaSKPD221.hitungSelisih('bantuMar');
				rkaSKPD221.hitungSelisih('bantuJun');
				rkaSKPD221.hitungSelisih('bantuSep');
				rkaSKPD221.hitungSelisih('bantuDes');
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
				rkaSKPD221.hitungSelisih('bantuMar');
				rkaSKPD221.hitungSelisih('bantuJun');
				rkaSKPD221.hitungSelisih('bantuSep');
				rkaSKPD221.hitungSelisih('bantuDes');
			}

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
						idAwal : id,
					    koreksiVolumebarang : document.getElementById("volumeBarang"+id).value,
					    koreksiSatuanHarga : document.getElementById("satuanHarga"+id).value
						},
				url: this.url+'&tipe=koreksi',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					delElem(cover);
					if(resp.err == ''){
						me.Close();
						rkaSKPD221.refreshList(true);
					}else{
						alert(resp.err);
						if(resp.err == 'Tahap Koreksi Telah Habis'){
							window.location.reload();
						}
					}

				 }
			});


	},
	Gruping : function(){
		var me = this;
		errmsg = '';

		if(errmsg ==''){
			var box = this.GetCbxChecked();

			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,900,true,false);
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=Gruping',
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
	Posting : function(){
		var me = this;
		errmsg = '';

		if(errmsg ==''){
			var box = this.GetCbxChecked();

			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,900,true,false);
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
	newJob:function(){
		var me = this;


			 var cover = this.prefix+'_formcover2';

			$.ajax({
				type:'POST',
			  	url: this.url+'&tipe=newJob',
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
	editJob:function(){
		var me = this;
	    var cover = this.prefix+'_formcover2';

		if($("#pekerjaan").val() == ''){
			alert("Pilih pekerjaan");
		}else{
			$.ajax({
				type:'POST',
				data : {pekerjaan : $("#pekerjaan").val() },
			  	url: this.url+'&tipe=editJob',
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
		}

	},
	Close2 : function(){
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formcover2';

		delElem(cover);
	},
	closeNotice : function(){
		var me = this;
		me.Close();
		me.Sync();
	},
	SaveJob: function(){

		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:{namaPekerjaan : $("#namaPekerjaan").val()
				  },
			url: this.url+'&tipe=SaveJob',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					$("#pekerjaan").html(resp.content.cmbPekerjaan);
						me.Close2();


				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	SaveEditJob: function(){

		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:{namaPekerjaan : $("#namaPekerjaan").val(),
				  pekerjaan : $("#pekerjaan").val(),
				  },
			url: this.url+'&tipe=SaveEditJob',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					$("#pekerjaan").html(resp.content.cmbPekerjaan);
						me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,
	noticeSync:function(){
		var me = this;
		var cover = this.prefix+'_formcover';

			$.ajax({
				type:'POST',
				data : {
								c1 : $("#cmbUrusan").val(),
								c : $("#cmbBidang").val(),
								d : $("#cmbSKPD").val(),
							  },
			  	url: this.url+'&tipe=noticeSync',
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
	Sync: function(){

		var me= this;
		$.ajax({
			type:'POST',
			data : {
							c1 : $("#cmbUrusan").val(),
							c : $("#cmbBidang").val(),
							d : $("#cmbSKPD").val(),
						  },
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
	,
	editRincianBelanja: function(id_anggaran,id){

		var me= this;
		$.ajax({
			type:'POST',
			data: {
							id_anggaran : id_anggaran,
							id : id,
						},
			url: this.url+'&tipe=editRincianBelanja',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
						$("#spanEditRincianBelanja"+id_anggaran).html(resp.content.isiSpanRincianBelanja);
						$("#actionSpanRincianBelanja"+id_anggaran).html(resp.content.isiActionSpan);
						$("#spanEditRincianBelanja"+id_anggaran).attr("onclick","");

				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,
	editRekening: function(id_anggaran){

		var me= this;
		$.ajax({
			type:'POST',
			data: {
							id_anggaran : id_anggaran,
							c1 : $("#cmbUrusan").val(),
							c : $("#cmbBidang").val(),
							d : $("#cmbSKPD").val(),
						},
			url: this.url+'&tipe=editRekening',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
						$("#spanEditRekening"+id_anggaran).html(resp.content.isiSpanRekening);
						$("#actionSpanRincianBelanja"+id_anggaran).html(resp.content.isiActionSpan);
						$("#spanEditRekening"+id_anggaran).attr("onclick","");

				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,
	editSubRincian: function(id){

		var me= this;
		$.ajax({
			type:'POST',
			data: {
							id : id
						},
			url: this.url+'&tipe=editSubRincian',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
						$("#spanVolumeRekening"+id).html(resp.content.isiSpanVolume);
						$("#spanSatuan"+id).html(resp.content.isiSpanSatuan);
						$("#spanHargaSatuan"+id).html(resp.content.isiSpanHargaSatuan);
						$("#spanTotalJumlah"+id).html(resp.content.isiSpanTotalJumlah);
						$("#actionSpan"+id).html(resp.content.isiActionSpan);
						$("#tdVolumeRekening"+id).attr("align","left");
						$("#headerUraian").attr("width","600");
						$("#headerVolume").attr("width","150");

				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,
	saveEditSubRincian: function(id){

		var me= this;
		$.ajax({
			type:'POST',
			data: {
							id : id,
							hargaSatuan : $("#hargaSatuan"+id).val(),
							volume1 : $("#volume1Temp"+id).val(),
							volume2: $("#volume2Temp"+id).val(),
							volume3 : $("#volume3Temp"+id).val(),
							volumeRekening : $("#volumeRek"+id).val(),
							satuan1 : $("#satuan1Temp"+id).val(),
							satuan2: $("#satuan2Temp"+id).val(),
							satuan3 : $("#satuan3Temp"+id).val(),
							satuanRekening : $("#satuanRek"+id).val(),
							uraianVolume : $("#uraianVolume"+id).text(),
						},
			url: this.url+'&tipe=saveEditSubRincian',
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
	,
	saveEditRincianBelanja: function(id_anggaran,id){

		var me= this;
		$.ajax({
			type:'POST',
			data: {
							id : id,
							namaRincianBelanja : $("#textRincianBelanja"+id_anggaran).val(),


						},
			url: this.url+'&tipe=saveEditRincianBelanja',
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
	,
	saveEditRekening: function(id){

		var me= this;
		$.ajax({
			type:'POST',
			data: {
							id : id,
							kodeRekening : $("#hiddenRekening"+id).val(),
							c1 : $("#cmbUrusan").val(),
							c : $("#cmbBidang").val(),
							d : $("#cmbSKPD").val(),
						},
			url: this.url+'&tipe=saveEditRekening',
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
	,
	hitungVolume: function(id){
			var hasilKali = $("#volumeRek"+id).val()  * $("#hargaSatuan"+id).val();
			$("#spanTotalJumlah"+id).text(rkaSKPD221.formatCurrency(hasilKali));
	},
	formRincianVolume:function(id){
		var me = this;
		var cover = this.prefix+'_formcover';
				$.ajax({
					type:'POST',
					data : {
							 id : id,
							 volume1Temp : $("#volume1Temp"+id).val(),
							 volume2Temp : $("#volume2Temp"+id).val(),
							 volume3Temp : $("#volume3Temp"+id).val(),
							 satuan1Temp : $("#satuan1Temp"+id).val(),
							 satuan2Temp : $("#satuan2Temp"+id).val(),
							 satuan3Temp : $("#satuan3Temp"+id).val(),
							 uraianVolume : $("#uraianVolume"+id).text()
					},
				  	url: this.url+'&tipe=formRincianVolume',
				  	success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == ''){
							document.body.style.overflow='hidden';
							addCoverPage2(cover,2,true,false);
							document.getElementById(cover).innerHTML = resp.content;


						}else{
							alert(resp.err);
						}


				  	}
				});

	},

	setTotalRincian : function(){

		var jumlah1 = Number($("#jumlah1").val());
		var jumlah2 = Number($("#jumlah2").val());
		var jumlah3 = Number($("#jumlah3").val());
		if($("#jumlah2").val() == ""){
			var jumlahTotal = Number(jumlah1);
		}else if($("#jumlah3").val() == ""){
			var jumlahTotal = Number(jumlah1 * jumlah2 );
		}else{
			var jumlahTotal = Number(jumlah1 * jumlah2 * jumlah3);
		}

		$("#jumlah4").val(jumlahTotal);

	},


	SaveRincianVolume : function(id){
			var err = "";
			var me= this;
			this.OnErrorClose = false;
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);
			delElem(cover);
			if($("#jumlah1").val() !='' && $("#satuan1").val() =='' ){
				err = "Isi Satuan Kesatu !";
			}else if($("#jumlah2").val() !='' && $("#satuan2").val() =='' ){
				err = "Isi Satuan Kedua !";
			}else if($("#jumlah3").val() !='' && $("#satuan3").val() =='' ){
				err = "Isi Satuan Kedua !";
			}else if($("#jumlah3").val() !='' && $("#jumlah2").val() =='' ){
				err = "Isi Volume Kedua !";
			}else if($("#jumlah3").val() !='' && $("#jumlah1").val() =='' ){
				err = "Isi Volume Kesatu !";
			}
			if(err ==''){
				$("#volume1Temp"+id).val($("#jumlah1").val());
				$("#volume2Temp"+id).val($("#jumlah2").val());
				$("#volume3Temp"+id).val($("#jumlah3").val());
				$("#satuan1Temp"+id).val($("#satuan1").val());
				$("#satuan2Temp"+id).val($("#satuan2").val());
				$("#satuan3Temp"+id).val($("#satuan3").val());
				$("#volumeRek"+id).val($("#jumlah4").val());
				$("#uraianVolume"+id).text($("#rincianVolumeTemp").val());
				//$("#satuanRek"+id).val($("#rincianVolumeTemp").val());
				//me.bantu();
				rkaSKPD221.hitungVolume(id);
				var satuan = '';
				if($("#jumlah3").val() !=''){
						 satuan = $("#satuan1").val() + " / " +  $("#satuan2").val() + " / " + $("#satuan3").val();
						$("#satuanRek"+id).val(satuan);
				}else if($("#jumlah2").val() !=''){
						satuan =  $("#satuan1").val() + " / " + $("#satuan2").val();
						$("#satuanRek"+id).val(satuan);
				}else{
						satuan =  $("#satuan1").val();
						$("#satuanRek"+id).val(satuan);
				}
				me.Close();
			}else{
				alert(err);
			}
	},

	bantu : function(id){
		var me= this;
		$("#bantuSatuanHarga"+id).text("Rp. "+me.formatCurrency($("#hargaSatuan").val())  );
		$("#jumlahHarga"+id).val($("#hargaSatuan").val() * $("#volumeBarang").val());
		$("#bantuJumlahHarga"+id).text("Rp. "+me.formatCurrency($("#jumlahHarga").val()));
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

});
