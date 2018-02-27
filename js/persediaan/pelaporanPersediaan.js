var pelaporanPersediaanSKPD2 = new SkpdCls({
	prefix : 'pelaporanPersediaanSKPD2',
	formName: 'pelaporanPersediaanForm',

	pilihUrusanfter : function(){pelaporanPersediaan.refreshList(true);},
	pilihBidangAfter : function(){pelaporanPersediaan.refreshList(true);},
	pilihUnitAfter : function(){pelaporanPersediaan.refreshList(true);},

});
var pelaporanPersediaan = new DaftarObj2({
	prefix : 'pelaporanPersediaan',
	url : 'pages.php?Pg=pelaporanPersediaan',
	formName : 'pelaporanPersediaanForm',
	pelaporanPersediaan_form : '0',//default js pelaporanPersediaan
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
  	pilihPangkat : function(){
	var me = this; 
		$.ajax({
		  url: this.url+'&tipe=pilihPangkat',
		  type : 'POST',
		  data:{
				c1			  : $("#pelaporanPersediaanSKPD2fmURUSAN").val(),
				c 			  : $("#pelaporanPersediaanSKPD2fmSKPD").val(),
				d 			  : $("#pelaporanPersediaanSKPD2fmUNIT").val(),
				e 			  : $("#pelaporanPersediaanSKPD2fmSUBUNIT").val(),
				e1 			  : $("#pelaporanPersediaanSKPD2fmSEKSI").val(),
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
				c1			  : $("#pelaporanPersediaanSKPD2fmURUSAN").val(),
				c 			  : $("#pelaporanPersediaanSKPD2fmSKPD").val(),
				d 			  : $("#pelaporanPersediaanSKPD2fmUNIT").val(),
				e 			  : $("#pelaporanPersediaanSKPD2fmSUBUNIT").val(),
				e1 			  : $("#pelaporanPersediaanSKPD2fmSEKSI").val(),
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
					pelaporanPersediaan.Close();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	Baru: function(){
		var me = this;
		var err='';
		var urusan = document.getElementById('pelaporanPersediaanSKPD2fmURUSAN').value; 
		var bidang = document.getElementById('pelaporanPersediaanSKPD2fmSKPD').value; 
		var skpd = document.getElementById('pelaporanPersediaanSKPD2fmUNIT').value;
		var unit = document.getElementById('pelaporanPersediaanSKPD2fmSUBUNIT').value;
		var subunit = document.getElementById('pelaporanPersediaanSKPD2fmSEKSI').value;
		
		var cover = this.prefix+'_formcover';
		if(err==''){
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize()+"&urusan="+urusan+"&bidang="+bidang+"&skpd="+skpd+"&unit="+unit+"&subunit="+subunit,
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					delElem(cover);
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
			data: { jenisKegiatan  : $("#jenisKegiatan").val(),
					cetakjang	   : $("#cetakjang").val(),
					ttd			   : $("#ttd").val(),
					c1			   : $("#pelaporanPersediaanSKPD2fmURUSAN").val(),
					c 			   : $("#pelaporanPersediaanSKPD2fmSKPD").val(),
					d 			   : $("#pelaporanPersediaanSKPD2fmUNIT").val(),
					e 			   : $("#pelaporanPersediaanSKPD2fmSUBUNIT").val(),
					e1 			   : $("#pelaporanPersediaanSKPD2fmSEKSI").val(),
					filterPeriode  : $("#filterPeriode").val(),

					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){

					aForm.action= url2+'&tipe='+resp.content.to+'&filterPeriode='+$("#filterPeriode").val()+'&urusan='+$("#pelaporanPersediaanSKPD2fmURUSAN").val()+'&bidang='+$("#pelaporanPersediaanSKPD2fmSKPD").val()+'&skpd='+$("#pelaporanPersediaanSKPD2fmUNIT").val()+'&unit='+$("#pelaporanPersediaanSKPD2fmSUBUNIT").val()+'&subunit='+$("#pelaporanPersediaanSKPD2fmSEKSI").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd;
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
		pelaporanPersediaan.refreshList(true);
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
		pelaporanPersediaan.refreshList(true);

	},BidangAfter2: function(){
		pelaporanPersediaan.refreshList(true);

	},comboSKPDChanged: function(){
		pelaporanPersediaan.refreshList(true);

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
	// 					aForm.action= 'pages.php?Pg=pelaporanPersediaan_ins&skpd='+skpd+"&nomor="+resp.content.nomor;
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
			$("#findRekening").attr('onclick',"pelaporanPersediaan.findRekening('"+$("#cmbJenisRKAForm").val()+"');");

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
							aForm.action= 'pages.php?Pg=pelaporanPersediaan_ins&skpd='+resp.content.skpd+"&nomor="+resp.content.nomor;
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




	bantuVolumeBarang : function(id){
		document.getElementById('bantuVolumeBarang'+id).innerHTML = pelaporanPersediaan.formatCurrency2($("#volumeBarang"+id).val());
		var hasilKali = Number($("#volumeBarang"+id).val()) * Number($("#satuanHarga"+id).val()) ;
		$("#spanJumlahHarga"+id).text(pelaporanPersediaan.formatCurrency(hasilKali));
	},
	bantuSatuanHarga : function(id){
		document.getElementById('bantuSatuanHarga'+id).innerHTML =  pelaporanPersediaan.formatCurrency($("#satuanHarga"+id).val());
		var hasilKali = Number($("#volumeBarang"+id).val()) * Number($("#satuanHarga"+id).val()) ;
		$("#spanJumlahHarga"+id).text(pelaporanPersediaan.formatCurrency(hasilKali));
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
		$("#bantu").text("Rp. "+pelaporanPersediaan.formatCurrency($("#hargaSatuan").val())  );

	},

	Hitung:function(){
		var me = this;

			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=Hitung',
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


	executeHitung: function(){
		var me= this;
		// var tot_jmlbarang = document.getElementById('tot_jmlbarang').value;
		$.ajax({
				type:'POST',
				data:$('#'+this.prefix+"_form").serialize(),
				url: this.url+'&tipe=executeHitung',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						var cover = 'pelaporanPersediaan_formcover_load';
						addCoverPage2(cover,1,true,false);
						document.body.style.overflow='hidden';
						me.prosesHitung(1, "belom",resp.content.jumlahData,resp.content.dataHitung);
					}else{
						alert(resp.err);
					}
					}
			});


	},


	prosesHitung: function(urutan,statusSelesai,jumlahData,dataHitung){
		var me= this;
		var cover = this.prefix+'_formcover';
		var obj = JSON.parse(dataHitung);
		if(statusSelesai != 'OK'){
		$.ajax({
			 type:'POST',
			 data:{
				 			nomorPost : urutan,
							idHitung : obj[urutan],
							jumlahData : jumlahData
			 },
			 url: this.url+'&tipe=prosesHitung',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					urutan = urutan + 1;
					document.getElementById("statustxt").style.width = resp.content.persen+"%";
					document.getElementById("statustxt").innerHTML = resp.content.persen+"%";
					setTimeout(function myFunctionPersen() {me.prosesHitung(urutan, resp.content.statusSelesai,jumlahData,dataHitung);},101);
				}else{
					alert(resp.err);
					setTimeout(function myFunctionPersen() {delElem('pelaporanPersediaanformcover_load');},500);
				}
		  	}
		});
		}else{
			setTimeout(function myFunctionPersen() {me.UpdatePostingBerhasil();},110);
		}
	},


	UpdatePostingBerhasil: function(){
		var me = this;
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+"_form").serialize(),
			url: this.url+'&tipe=BerhasilPosting',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					alert("Berhasil Memposting Data !");

					setTimeout(function myFunctionPersen() {me.Close();me.refreshList();},111);
					setTimeout(function myFunctionPersen() {delElem('pelaporanPersediaan_formcover_load');},500);
				}else{
					alert(resp.err);
				}
			}
		});
	},

	urusanChanged: function(){
		var me = this;
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+"_form").serialize(),
			url: this.url+'&tipe=urusanChanged',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
						$("#cmbBidang").html(resp.content.cmbBidang);
						$("#cmbSKPD").html(resp.content.cmbSKPD);
				}else{
					alert(resp.err);
				}
			}
		});
	},
	bidangChanged: function(){
		var me = this;
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+"_form").serialize(),
			url: this.url+'&tipe=bidangChanged',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					$("#cmbSKPD").html(resp.content.cmbSKPD);
				}else{
					alert(resp.err);
				}
			}
		});
	},
	gChanged: function(){
		var me = this;
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+"_form").serialize(),
			url: this.url+'&tipe=gChanged',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					$("#cmbH").html(resp.content.cmbH);
					$("#cmbI").html(resp.content.cmbI);
					$("#cmbJ").html(resp.content.cmbJ);
					$("#cmbJ1").html(resp.content.cmbJ1);
				}else{
					alert(resp.err);
				}
			}
		});
	},
	hChanged: function(){
		var me = this;
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+"_form").serialize(),
			url: this.url+'&tipe=hChanged',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					$("#cmbI").html(resp.content.cmbI);
					$("#cmbJ").html(resp.content.cmbJ);
					$("#cmbJ1").html(resp.content.cmbJ1);
				}else{
					alert(resp.err);
				}
			}
		});
	},
	iChanged: function(){
		var me = this;
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+"_form").serialize(),
			url: this.url+'&tipe=iChanged',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					$("#cmbJ").html(resp.content.cmbJ);
					$("#cmbJ1").html(resp.content.cmbJ1);
				}else{
					alert(resp.err);
				}
			}
		});
	},
	jChanged: function(){
		var me = this;
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+"_form").serialize(),
			url: this.url+'&tipe=jChanged',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					$("#cmbJ1").html(resp.content.cmbJ1);
				}else{
					alert(resp.err);
				}
			}
		});
	},




});
