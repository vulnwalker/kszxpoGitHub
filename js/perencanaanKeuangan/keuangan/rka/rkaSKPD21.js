var rkaSKPD21 = new DaftarObj2({
	prefix : 'rkaSKPD21',
	url : 'pages.php?Pg=rkaSKPD21',
	formName : 'rkaSKPD21Form',
	rkaSKPD21_form : '0',//default js rkaSKPD21
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();



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
			  	url: 'pages.php?Pg=rkaSKPD21New'+'&tipe=Laporan',
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
		rkaSKPD21.refreshList(true);
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
		rkaSKPD21.refreshList(true);

	},BidangAfter2: function(){
		rkaSKPD21.refreshList(true);

	},comboSKPDChanged: function(){
		rkaSKPD21.refreshList(true);

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
		}else{

				var skpd = $("#cmbUrusan").val()+'.'+$("#cmbBidang").val()+'.'+$("#cmbSKPD").val();

				var aForm = document.getElementById(this.formName);
				$.ajax({
				type:'POST',
				data : {cmbUrusan : $("#cmbUrusan").val(),
						cmbBidang : $("#cmbBidang").val(),
						cmbSKPD  : $("#cmbSKPD").val(),
						},
			  	url: this.url+'&tipe=clearTemp',
			  	success: function(data) {

						aForm.action= 'pages.php?Pg=rkaSKPD21_ins&skpd='+skpd;
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
			$("#spanTotalJumlah"+id).text(rkaSKPD21.formatCurrency(hasilKali));
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
				rkaSKPD21.hitungVolume(id);
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
		popupRekening.filterAkun="RKA 2.1";
		popupRekening.windowShow();

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
