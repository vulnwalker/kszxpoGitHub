var spdList_insSKPD = new SkpdCls({
	prefix : 'spdList_insSKPD', formName:'spdList_insForm', kolomWidth:120,

	a : function(){
		alert('dsf');
	},
});

var spdList_ins = new DaftarObj2({
	prefix : 'spdList_ins',
	url : 'pages.php?Pg=spdList_ins',
	formName : 'spdList_insForm',
	satuan_form : '0',//default js satuan



	loading: function(){

		this.topBarRender();
		this.daftarRender();
		this.filterRender();

	},
	filterRenderAfter : function(){
				$('#tanggalSPD').datepicker({
								dateFormat: 'dd-mm-yy',
							showAnim: 'slideDown',
								inline: true,
							showOn: "button",
								buttonImage: "images/calendar.gif",
									buttonImageOnly: true,
							changeMonth: true,
									changeYear: true,
							buttonText : '',
							defaultDate: +0
		});
		},
	closeTab : function(){


			window.opener.location.reload();
			var ww = window.open(window.location, '_self');
			ww.close();




	},
	findRekening : function(jenisRka){
		var me = this;
		var filterRek = "";

			filterRek = "RKA 2.1";
		popupRekening.el_kode_rekening = 'kodeRekening';
		popupRekening.el_nama_rekening = 'namaRekening';
		popupRekening.spanRekening = 'spanNamaRekening';
		popupRekening.windowSaveAfter= function(){};
		popupRekening.filterAkun=filterRek;
		popupRekening.windowShow();

	},

	findRekeningRka : function(jenisRka){
		var me = this;
		var filterRek = "";
			filterRek = "RKA 2.1";

		popupRekeningRka.el_kode_rekening = 'kodeRekening';
		popupRekeningRka.el_nama_rekening = 'namaRekening';
		popupRekeningRka.spanRekening = 'spanNamaRekening';
		popupRekeningRka.windowSaveAfter= function(){};
		popupRekeningRka.filterAkun=filterRek;
		popupRekeningRka.windowShow();

	},

	addRekening:function(){
		var me = this;




			$.ajax({
				type:'POST',
			  	url: this.url+'&tipe=addRekening',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){

					//	document.getElementById('tabelRekening').innerHTML = resp.content.tabelRekening;
						document.getElementById('tabelRincianBelanja').innerHTML = resp.content.tabelRincianBelanja;
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content.tabelSubRincianBelanja;
						$("#currentRincianRekening").val('');
						$("#currentRincianBelanja").val('');

						me.findRekeningRka();
					}else{
						alert(resp.err);
					}


			  	}
			});
	},
	newJob:function(){
		var me = this;


			 var cover = this.prefix+'_formcover';

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
	    var cover = this.prefix+'_formcover';

		if($("#o1").val() == ''){
			alert("Pilih pekerjaan");
		}else{
			$.ajax({
				type:'POST',
				data : {o1 : $("#o1").val() },
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

	newSatuan:function(){
		var me = this;


			 var cover = this.prefix+'_formcover';

			$.ajax({
				type:'POST',
			  	url: this.url+'&tipe=newSatuan',
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
		$("#"+namaBantu).text("Rp. "+spdList_ins.formatCurrency($("#"+idPost).val())  );

		var jumlahHargaAlokasi = Number( jan + feb + mar + apr + mei + jun + jul + agu + sep + okt + nop + des );
		$("#jumlahHargaAlokasi").val(jumlahHargaAlokasi);
		var selisih = Number( Number($("#jumlahHargaForm").val()) -  Number( jan + feb + mar + apr + mei + jun + jul + agu + sep + okt + nop + des ) );
		$("#selisih").val(selisih);
		$("#bantuPenjumlahan").text("Rp. "+spdList_ins.formatCurrency(jumlahHargaAlokasi)  );
		$("#bantuSelisih").text("Rp. "+spdList_ins.formatCurrency(selisih)  );
	},
	formAlokasi:function(){
		var me = this;
		var cover = this.prefix+'_formcover';

	if($("#jumlahHarga").val() == '' || $("#jumlahHarga").val() == '0' ){
		alert("Jumlah Harga Kosong");
	}else{
			$.ajax({
				type:'POST',
				data : {
						 jumlahHarga : $("#jumlahHarga").val()
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


	formAlokasiTriwulan:function(){
		var me = this;
		var cover = this.prefix+'_formcover';

	if($("#jumlahHarga").val() == '' || $("#jumlahHarga").val() == '0' ){
		alert("Jumlah Harga Kosong");
	}else{
			$.ajax({
				type:'POST',
				data : {
						 jumlahHarga : $("#jumlahHarga").val()
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




	formRincianVolume:function(){
		var me = this;
		var cover = this.prefix+'_formcover';
				$.ajax({
					type:'POST',
					data : {
							 volumeRek : $("#volumeBarang").val()
					},
				  	url: this.url+'&tipe=formRincianVolume',
				  	success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == ''){
							document.body.style.overflow='hidden';
							addCoverPage2(cover,2,true,false);
							document.getElementById(cover).innerHTML = resp.content;
							$("#jumlah1").val($("#volume1Temp").val());
							$("#jumlah2").val($("#volume2Temp").val());
							$("#jumlah3").val($("#volume3Temp").val());
							$("#jumlah4").val($("#volumeBarang").val());
							$("#satuan1").val($("#satuan1Temp").val());
							$("#satuan2").val($("#satuan2Temp").val());
							$("#satuan3").val($("#satuan3Temp").val());
							$("#detailVolumeRincian").text($("#detailVolumeTemp").text());
							$("#rincianVolumeTemp").val($("#rincianVolume").val());

							if($("#satuan3Temp").val() !=''){
									$("#satuanVolume").val($("#satuan1Temp").val()+" / "+$("#satuan2Temp").val()+" / "+$("#satuan3Temp").val());
							}else if($("#satuan2Temp").val() !=''){
									$("#satuanVolume").val($("#satuan1Temp").val()+" / "+$("#satuan2Temp").val());
							}else{
								  $("#satuanVolume").val($("#satuan1Temp").val());
							}

						}else{
							alert(resp.err);
						}


				  	}
				});

	},

	newSatuanSatuan:function(){
		var me = this;
		var cover = this.prefix+'_formcover2';

				$.ajax({
					type:'POST',
				  	url: this.url+'&tipe=newSatuanSatuan',
				  	success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == ''){
							document.body.style.overflow='hidden';
							addCoverPage2(cover,3,true,false);
							document.getElementById(cover).innerHTML = resp.content;
						}else{
							alert(resp.err);
						}


				  	}
				});
	},

	newSatuanVolume:function(){
		var me = this;
		var cover = this.prefix+'_formcover2';

				$.ajax({
					type:'POST',
				  	url: this.url+'&tipe=newSatuanVolume',
				  	success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == ''){
							document.body.style.overflow='hidden';
							addCoverPage2(cover,3,true,false);
							document.getElementById(cover).innerHTML = resp.content;
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

	Close2 : function(){
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formcover2';

		delElem(cover);
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

	saveEdit : function(idEdit){
		$.ajax({
				type:'POST',
				data:{
							concatSKPD : $("#concatSKPD").val(),
							nomorSPD : $("#nomorSPD").val(),
							tanggalSPD : $("#tanggalSPD").val(),
							jenisTriwulan : $("#jenisTriwulan").val(),
							keterangan : $("#keterangan").val(),
							idEdit : idEdit,
						},
				url: this.url+'&tipe=saveEdit',
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

	Simpan : function(){
		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		$.ajax({
				type:'POST',
				data:{ c1 : c1,
					   c : c,
					   d : d,
					   kodeRekening : $("#kodeRekening").val(),
					   namaRekening : $("#namaRekening").val(),
					   noPekerjaan : $("#o1").val(),
					   kodeBarang : $("#kodeBarang").val(),
					   rincianPerhitungan : $("#rincianPerhitungan").val(),
					   volumeRek : $("#volumeBarang").val(),
					   satuanRek : $("#satuan").val(),
					   hargaSatuan : $("#hargaSatuan").val(),
					   teralokasi : $("#teralokasi").val(),
					   rincianVolume : $("#rincianVolume").val(),
					   noUrutPekerjaan : $("#nomorUrut").val(),
					   o1Html : escape($("#o1").html()),
					  },
				url: this.url+'&tipe=Simpan2',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						$("#nomorUrut").val('');
						$("#satuan").val('');
						$("#hargaSatuan").val('');
						$("#jumlahHarga").val('');
						spdList_ins.refreshList(true);
						setTimeout(function myFunction() {
						$("#kodeRekening").val(resp.content.kodeRekening);
						$("#namaRekening").val(resp.content.namaRekening);
						$("#o1").html(unescape(resp.content.o1Html));
							spdList_ins.setNoUrut();
							},1000);
					}else{
						if(resp.err == "Lengkapi Alokasi"){
							spdList_ins.formAlokasi();

						}else if(resp.err == "Lengkapi Rincian Volume"){
							spdList_ins.formRincianVolume();
						}else{
							alert(resp.err);
						}
					}


				}
			});
	},
	SaveAlokasi : function(){

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
						jumlahHargaAlokasi : $("#jumlahHargaAlokasi").val()	},
				url: this.url+'&tipe=SaveAlokasi',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					delElem(cover);
					if(resp.err==''){
						me.Close();
						$("#teralokasi").val('true');
					}else{
						alert(resp.err);
					}
			  	}
			});


	},

	SaveRincianVolume : function(){
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
				$("#volume1Temp").val($("#jumlah1").val());
				$("#volume2Temp").val($("#jumlah2").val());
				$("#volume3Temp").val($("#jumlah3").val());
				$("#satuan1Temp").val($("#satuan1").val());
				$("#satuan2Temp").val($("#satuan2").val());
				$("#satuan3Temp").val($("#satuan3").val());
				$("#volumeBarang").val($("#jumlah4").val());
				$("#rincianVolume").val($("#rincianVolumeTemp").val());
				$("#spanRincianVolume").text($("#rincianVolumeTemp").val());
				spdList_ins.bantu();
				var satuan = '';
				if($("#jumlah3").val() !=''){
						 satuan = $("#satuan1").val() + " / " +  $("#satuan2").val() + " / " + $("#satuan3").val();
						$("#detailVolumeTemp").text(satuan);
				}else if($("#jumlah2").val() !=''){
						satuan =  $("#satuan1").val() + " / " + $("#satuan2").val();
						$("#detailVolumeTemp").text(satuan);
				}else{
						satuan =  $("#satuan1").val();
						$("#detailVolumeTemp").text(satuan);
				}





				me.Close();
			}else{
				alert(err);
			}




	},
		resetRincian : function(){
		$("#rincianVolume").val('');
		$("#teralokasi").val('');
		spdList_ins.bantu();

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
	finish : function(){

		$.ajax({
				type:'POST',
				data:{
							concatSKPD : $("#concatSKPD").val(),
							nomorSPD : $("#nomorSPD").val(),
							tanggalSPD : $("#tanggalSPD").val(),
							jenisTriwulan : $("#jenisTriwulan").val(),
							keterangan : $("#keterangan").val(),
						},
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

	saveNewRekening:function(){
		var me = this;
			$.ajax({
				type:'POST',
				data : {
						kodeRekening : $("#kodeRekening").val(),
						sumberDana : $("#cmbSumberDana").val(),
				},
			  	url: this.url+'&tipe=saveNewRekening',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){

						document.getElementById('tabelRekening').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},

	editRekening:function(id){
		var me = this;
			$.ajax({
				type:'POST',
				data : {id:id},
			  	url: this.url+'&tipe=editRekening',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){

						document.getElementById('tabelRekening').innerHTML = resp.content.tabelRekening;
						document.getElementById('tabelRincianBelanja').innerHTML = resp.content.tabelRincianBelanja;
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content.tabelSubRincianBelanja;
						$("#currentRincianRekening").val('');
						$("#currentRincianBelanja").val('');
					}else{
						alert(resp.err);
					}


			  	}
			});
	},

	saveEditRekening:function(id){
		var me = this;
			$.ajax({
				type:'POST',
				data : {
						kodeRekening : $("#kodeRekening").val(),
						sumberDana : $("#cmbSumberDana").val(),
						id : id
				},
			  	url: this.url+'&tipe=saveEditRekening',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelRekening').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},

	cancelRekening:function(){
		var me = this;
			$.ajax({
				type:'POST',
					url: this.url+'&tipe=cancelRekening',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelRekening').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
					}
			});
	},

	deleteRekening:function(id){
		var me = this;
		if(confirm("Yakin hapus rekening ?")){
			$.ajax({
				type:'POST',
				data : {
						id : id
				},
					url: this.url+'&tipe=deleteRekening',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelRekening').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}


					}
			});
		}

	},

	rincianBelanja:function(id){
		var me = this;
			$.ajax({
					type:'POST',
					data : {id : id},
			  	url: this.url+'&tipe=rincianBelanja',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelRincianBelanja').innerHTML = resp.content.tabelRincianBelanja;
						document.getElementById('tabelRekening').innerHTML = resp.content.tabelRekening;
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content.tabelSubRincianBelanja;
						$("#currentRincianRekening").val(id);
						$("#currentRincianBelanja").val('');
						$("#kalimatRincianBelanja").html(resp.content.kalimatRincianBelanja);
						$("#kalimatSubRincianBelanja").html(resp.content.kalimatSubRincianBelanja);

					}else{
						alert(resp.err);
					}
			  	}
			});
	},

	addRincianBelanja:function(){
		var me = this;
		var err = "";
		if($("#currentRincianRekening").val() == ''){
			err = "Pilih Rekening !";
		}
		if(err == ''){
			$.ajax({
				type:'POST',
					url: this.url+'&tipe=addRincianBelanja',
					data : {id : $("#currentRincianRekening").val()},
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){

						document.getElementById('tabelRincianBelanja').innerHTML = resp.content.tabelRincianBelanja;
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content.tabelSubRincianBelanja;
						$("#currentRincianBelanja").val('');
					}else{
						alert(resp.err);
					}


					}
			});
		}else{
			alert(err);
		}
	},

	editRincianBelanja:function(id){
		var me = this;
			$.ajax({
				type:'POST',
				data : {idEdit : id,
								idRekeningBelanja : $("#currentRincianRekening").val()
							 },
			  	url: this.url+'&tipe=editRincianBelanja',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelRincianBelanja').innerHTML = resp.content.tabelRincianBelanja;
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content.tabelSubRincianBelanja;
						$("#currentRincianBelanja").val('');
					}else{
						alert(resp.err);
					}
			  	}
			});
	},

	saveNewRincianBelanja:function(){
		var me = this;
			$.ajax({
				type:'POST',
				data : {
						uraianBelanja : $("#uraianBelanja").val(),
						idRekeningBelanja : $("#currentRincianRekening").val(),
				},
			  	url: this.url+'&tipe=saveNewRincianBelanja',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelRincianBelanja').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},

	saveEditRincianBelanja:function(id){
		var me = this;
			$.ajax({
				type:'POST',
				data : {idEdit : id,
								idRekeningBelanja : $("#currentRincianRekening").val(),
								uraianBelanja : $("#uraianBelanja").val()
							 },
					url: this.url+'&tipe=saveEditRincianBelanja',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelRincianBelanja').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
					}
			});
	},

	cancelRincianBelanja:function(id){
		var me = this;
			$.ajax({
				type:'POST',
				data : {id : id},
					url: this.url+'&tipe=cancelRincianBelanja',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelRincianBelanja').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
					}
			});
	},
	deleteRincianBelanja:function(id){
		var me = this;
		if(confirm("Yakin hapus rincian rekening ?")){
			$.ajax({
				type:'POST',
				data : {id : id,
								idRekeningBelanja : $("#currentRincianRekening").val()
								},
					url: this.url+'&tipe=deleteRincianBelanja',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelRincianBelanja').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
					}
			});
		}

	},

	subRincianBelanja:function(id){
		var me = this;

			$.ajax({
					type:'POST',
					data : {
										id : id,
										idRekeningBelanja : $("#currentRincianRekening").val()

									},
			  	url: this.url+'&tipe=subRincianBelanja',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelRincianBelanja').innerHTML = resp.content.tabelRincianBelanja;
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content.tabelSubRincianBelanja;
						$("#currentRincianBelanja").val(id);
						$("#kalimatSubRincianBelanja").html(resp.content.kalimatSubRincianBelanja);
					}else{
						alert(resp.err);
					}
			  	}
			});
	},

	addSubRincianBelanja:function(){
		var me = this;
		var err = "";
		if($("#currentRincianBelanja").val() == ''){
			err = "Pilih Rincian Belanja !";
		}
		if(err == ''){
			$.ajax({
				type:'POST',
					url: this.url+'&tipe=addSubRincianBelanja',
					data : {id : $("#currentRincianBelanja").val(),
									idRekeningBelanja : $("#currentRincianRekening").val()},
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content.tabelSubRincianBelanja;
					}else{
						alert(resp.err);
					}


					}
			});
		}else{
			alert(err);
		}

	},

	editSubRincianBelanja:function(id){
		var me = this;
			$.ajax({
				type:'POST',
				data : { idEdit : id,
								idRekeningBelanja : $("#currentRincianRekening").val(),
								idRincianBelanja : $("#currentRincianBelanja").val()
							 },
			  	url: this.url+'&tipe=editSubRincianBelanja',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content.tabelSubRincianBelanja;
					}else{
						alert(resp.err);
					}
			  	}
			});
	},

	saveNewSubRincianBelanja:function(){
		var me = this;
			$.ajax({
				type:'POST',
				data : {
						uraianBelanja : $("#uraianBelanja").val(),
						idRekeningBelanja : $("#currentRincianRekening").val(),
						idRincianBelanja : $("#currentRincianBelanja").val(),
						rincianVolume : $("#rincianVolume").val(),
						hargaSatuan : $("#hargaSatuan").val(),
						volumeBarang : $("#volumeBarang").val(),
						kodeBarang : $("#kodeBarang").val(),
						volume1 : $("#volume1Temp").val(),
						volume2 : $("#volume2Temp").val(),
						volume3 : $("#volume3Temp").val(),
						satuan1 : $("#satuan1Temp").val(),
						satuan2 : $("#satuan2Temp").val(),
						satuan3 : $("#satuan3Temp").val(),
				},
			  	url: this.url+'&tipe=saveNewSubRincianBelanja',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},
	saveEditSubRincianBelanja:function(id){
		var me = this;
			$.ajax({
				type:'POST',
				data : {
						uraianBelanja : $("#uraianBelanja").val(),
						idRekeningBelanja : $("#currentRincianRekening").val(),
						idRincianBelanja : $("#currentRincianBelanja").val(),
						rincianVolume : $("#rincianVolume").val(),
						hargaSatuan : $("#hargaSatuan").val(),
						volumeBarang : $("#volumeBarang").val(),
						kodeBarang : $("#kodeBarang").val(),
						volume1 : $("#volume1Temp").val(),
						volume2 : $("#volume2Temp").val(),
						volume3 : $("#volume3Temp").val(),
						satuan1 : $("#satuan1Temp").val(),
						satuan2 : $("#satuan2Temp").val(),
						satuan3 : $("#satuan3Temp").val(),
						idEdit : id
				},
			  	url: this.url+'&tipe=saveEditSubRincianBelanja',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},


	cancelSubRincianBelanja:function(id){
		var me = this;
			$.ajax({
				type:'POST',
				data : {id : id},
			  	url: this.url+'&tipe=cancelSubRincianBelanja',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
			  	}
			});
	},

	deleteSubRincianBelanja:function(id){
		var me = this;
		if(confirm("Yakin hapus sub rincian rekening ?")){
			$.ajax({
				type:'POST',
				data : {id : id,
								idRincianBelanja : $("#currentRincianBelanja").val()
								},
					url: this.url+'&tipe=deleteSubRincianBelanja',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelSubRincianBelanja').innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
					}
			});

		}
	},

	thisChecked:function(idSource,idCheckBox){

		var status ="";
		if(document.getElementById(idCheckBox).checked ){
			status = "checked";
		}else{
			status = "";
		}
		$.ajax({
			type:'POST',
			data:{
					id : idSource,
					jenis : status
				 },
		  	url: this.url+'&tipe=checkboxChanged',
		  	success: function(data) {
				var resp = eval('(' + data + ')');

		  	}
		});
	},
	checkSemua : function(  n, fldName ,elHeaderChecked, elJmlCek) {
			var n = $(".iniCheckbox").length ;
		 if (!fldName) {
			 fldName = 'cb';
		 }
		 if (!elHeaderChecked) {
			 elHeaderChecked = 'toggle';
		 }
		 var c = document.getElementById(elHeaderChecked).checked;
		 var n2 = 0;
		 for (i=0; i < n ; i++) {
			cb = document.getElementById(fldName+i);
			if (cb) {
				cb.checked = c;
				 this.thisChecked($("#"+fldName+i).val(),fldName+i);
				n2++;
			}
		 }
		 if (c) {
			document.getElementById(elJmlCek).value = n2;
		 } else {
			document.getElementById(elJmlCek).value = 0;
		 }
	},








});
