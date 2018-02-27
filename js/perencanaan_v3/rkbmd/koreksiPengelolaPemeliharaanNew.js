var koreksiPengelolaPemeliharaanNewSkpd = new SkpdCls({
	prefix : 'koreksiPengelolaPemeliharaanNewSkpd',
	formName: 'koreksiPengelolaPemeliharaanNewForm',
	pilihBidangAfter : function(){koreksiPengelolaPemeliharaanNew.refreshList(true);},
	pilihUnitAfter : function(){koreksiPengelolaPemeliharaanNew.refreshList(true);},
	pilihSubUnitAfter : function(){koreksiPengelolaPemeliharaanNew.refreshList(true);},
	pilihSeksiAfter : function(){koreksiPengelolaPemeliharaanNew.refreshList(true);}
});

var koreksiPengelolaPemeliharaanNew = new DaftarObj2({
	prefix : 'koreksiPengelolaPemeliharaanNew',
	url : 'pages.php?Pg=koreksiPengelolaPemeliharaanNew',
	formName : 'koreksiPengelolaPemeliharaanNewForm',

	loading:function(){
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		//this.sumHalRender();

	},

	daftarRender:function(){
		var jenisKegiatan = document.getElementById('cmbJeniskoreksiPengelolaPemeliharaanNew');
		/*cmbJeniskoreksiPengelolaPemeliharaanNew.remove(0);*/
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
	Cari: function(){
		popupBarang.kodeBarang = 'kodeBarang';
		popupBarang.namaBarang = 'namaBarang';
		popupBarang.satuanBarang = 'satuan';
		popupBarang.windowShow();

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
						var IDrenja = Number(resp.content.idrenja);
						aForm.action= 'pages.php?Pg=rkbmd_'+resp.content.kemana+'&YN=1&id='+IDrenja;
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
	remove:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();

			$.ajax({
			  url: this.url+'&tipe=remove',
			  type : 'POST',
			  data:$('#'+this.formName).serialize(),
			  success: function(data) {
					var resp = eval('(' + data + ')');
					koreksiPengelolaPemeliharaanNew.refreshList(true);

			  }
			});
		}else{
			alert(errmsg);
		}

	},Validasi:function(id_anggaran){
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
				if(resp.err==''){
					me.Close();
						/*me.AfterSimpan();	*/
						koreksiPengelolaPemeliharaanNew.refreshList(true);
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,
	AfterSimpan : function(){
		if(document.getElementById('Kunjungan_cont_daftar')){
		this.refreshList(true);}
	},jenisChanged: function(){
		var me = this;
		$.ajax({
		  url: this.url+'&tipe=jenisChanged',
		  type : 'POST',
		  data:{ 
		  	jenisKegiatan: $("#jenisKegiatan").val(),
		  		c1			: $("#koreksiPengelolaPemeliharaanSkpdfmUrusan").val(),
				c 			: $("#koreksiPengelolaPemeliharaanSkpdfmSKPD").val(),
				d 			: $("#koreksiPengelolaPemeliharaanSkpdfmUNIT").val(),
				e 			: $("#koreksiPengelolaPemeliharaanSkpdfmSUBUNIT").val(),
				e1 			: $("#koreksiPengelolaPemeliharaanSkpdfmSEKSI").val(),
			},
		  success: function(data) {
			var resp = eval('(' + data + ')');
				document.getElementById('ttd').innerHTML=resp.content.ttd;
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
				c1			: $("#koreksiPengelolaPemeliharaanSkpdfmUrusan").val(),
				c 			: $("#koreksiPengelolaPemeliharaanSkpdfmSKPD").val(),
				d 			: $("#koreksiPengelolaPemeliharaanSkpdfmUNIT").val(),
				e 			: $("#koreksiPengelolaPemeliharaanSkpdfmSUBUNIT").val(),
				e1 			: $("#koreksiPengelolaPemeliharaanSkpdfmSEKSI").val(),
			  	dc1 : $("#dc1").val(),
			  	dc  : $("#dc").val(),
			  	dd  : $("#dd").val(),
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
					me.Close();
				}else{
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
				c1			: $("#koreksiPengelolaPemeliharaanSkpdfmUrusan").val(),
				c 			: $("#koreksiPengelolaPemeliharaanSkpdfmSKPD").val(),
				d 			: $("#koreksiPengelolaPemeliharaanSkpdfmUNIT").val(),
				e 			: $("#koreksiPengelolaPemeliharaanSkpdfmSUBUNIT").val(),
				e1 			: $("#koreksiPengelolaPemeliharaanSkpdfmSEKSI").val(),
			  	dc1 : $("#dc1").val(),
			  	dc  : $("#dc").val(),
			  	dd  : $("#dd").val(),
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
		var err='';
		var urusan = document.getElementById('koreksiPengelolaPemeliharaanSkpdfmUrusan').value; 
		var bidang = document.getElementById('koreksiPengelolaPemeliharaanSkpdfmSKPD').value; 
		var skpd = document.getElementById('koreksiPengelolaPemeliharaanSkpdfmUNIT').value;
		var unit = document.getElementById('koreksiPengelolaPemeliharaanSkpdfmSUBUNIT').value;
		var subunit = document.getElementById('koreksiPengelolaPemeliharaanSkpdfmSEKSI').value;
		
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
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;			
						me.AfterFormBaru(resp);	
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}			
					
			  	}
			});
		}else{
			alert(err);
		}
	},
	InputBaru: function(){
		var me = this;

		errmsg = '';

		if($("#koreksiPengelolaPemeliharaanNewSkpdfmUrusan").val() == '00'){
			errmsg = "Pilih Urusan";
		}else if($("#koreksiPengelolaPemeliharaanNewSkpdfmSKPD").val() == '00'){
			errmsg = "Pilih Bidang";
		}else if($("#koreksiPengelolaPemeliharaanNewSkpdfmUNIT").val() == '00'){
			errmsg = "Pilih SKPD";
		}else if($("#koreksiPengelolaPemeliharaanNewSkpdfmSUBUNIT").val() == '00'){
			errmsg = "Pilih UNIT";
		}else if($("#koreksiPengelolaPemeliharaanNewSkpdfmSEKSI").val() == '000'){
			errmsg = "Pilih SUB UNIT";
		}else if($("#cmbJeniskoreksiPengelolaPemeliharaanNew").val() == ''){
			errmsg = "Pilih JENIS koreksiPengelolaPemeliharaanNew";
		}


		if(errmsg ==''){

			var me = this;
			var aForm = document.getElementById(this.formName);
			$.ajax({
			  url: this.url+'&tipe=newTab',
			  type : 'POST',
			  data:$('#'+this.formName).serialize(),
			  success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == "") {
						var IDrenja = Number(resp.content.idrenja);
						aForm.action= 'pages.php?Pg=rkbmd_'+resp.content.kemana+'&YN=1&id='+IDrenja;
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
	findRekeningPemeliharaan : function(id){
		var me = this;
		var filterRek = "RKA 2.2.1";

		popupRekening.el_kode_rekening = 'kodeRekeningKoreksi'+id;
		popupRekening.el_nama_rekening = 'namaRekeningKoreksi'+id;
		popupRekening.windowSaveAfter= function(){};
		popupRekening.filterAkun=filterRek;
		popupRekening.windowShow();

	},
	hitungVolume : function(id){
		$("#volume"+id).val($("#jumlah"+id).val() * $("#kuantiti"+id).val());
	},
	koreksi:function(id){

		// x <input type='text' name='kuantiti"+id+"' id='kuantiti"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup=koreksiPengelolaPemeliharaanNew.bantu('Kuantiti"+id+"'); style='text-align: right; width:40%;'>
		$("#updatePengguna"+id).attr('align','center');

		$("#spanNamaRekeningKoreksi"+id).html("<input type='hidden' id='kodeRekeningKoreksi"+id+"' name='kodeRekeningKoreksi"+id+"' value='"+$("#hiddenKodeRekeningKoreksi"+id).val()+"'  ><input type='text' value='"+$("#hiddenNamaRekeningKoreksi"+id).val()+"' readonly name='namaRekeningKoreksi"+id+"' id='namaRekeningKoreksi"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' ; style='text-align: left; width:80%;'><img src='datepicker/search.png' onclick=koreksiPengelolaPemeliharaanNew.findRekeningPemeliharaan("+id+"); style='width:20px;height:20px;margin-bottom:-5px ; cursor:pointer;'>  ");
		$("#spanJumlah"+id).html("<input type='text' name='jumlah"+id+"' id='jumlah"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup=koreksiPengelolaPemeliharaanNew.hitungVolume("+id+"); style='text-align: right; width:100%;'>  ");
		$("#spanKuantiti"+id).html("<input type='text' name='kuantiti"+id+"' id='kuantiti"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup=koreksiPengelolaPemeliharaanNew.hitungVolume("+id+"); style='text-align: right; width:100%;'>  ");
		$("#spanVolume"+id).html("<input type='text' name='volume"+id+"' id='volume"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup=koreksiPengelolaPemeliharaanNew.bantu('Jumlah"+id+"'); readonly style='text-align: right; width:100%;'>  ");
		$("#save"+id).html("<img src='datepicker/save.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=koreksiPengelolaPemeliharaanNew.submitKoreksi('"+id+"');></img> &nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=koreksiPengelolaPemeliharaanNew.cancelKoreksi('"+id+"');></img> ");
	},
	sesuai:function(id){
		var angkaKoreksi = $("#hiddenJumlah"+id+"").val();
		var angkaKuantiti = $("#hiddenKuantiti"+id+"").val();
		var kodeRekeningKoreksi = $("#hiddenKodeRekeningKoreksi"+id+"").val();
		var namaRekeningKoreksi = $("#hiddenNamaRekeningKoreksi"+id+"").val();
		$("#updatePengguna"+id).attr('align','center');


				$.ajax({
					type:'POST',
					data:{
							idAwal : id,
							angkaKoreksi : angkaKoreksi,
							angkaKuantiti : angkaKuantiti,
							kodeRekeningKoreksi : kodeRekeningKoreksi,
							namaRekeningKoreksi : namaRekeningKoreksi,
							},
					url: this.url+'&tipe=koreksi',
						success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err != ''){
							alert(resp.err);
							if(resp.err == 'Tahap Koreksi Telah Habis'){
								window.location.reload();
							}
						}else{
							koreksiPengelolaPemeliharaanNew.refreshList(true);
						}

					 }
					});
	},
	submitKoreksi:function(id) {
	var angkaKoreksi = $("#jumlah"+id).val();
	var angkaKuantiti = $("#kuantiti"+id).val();
	if(angkaKoreksi == '' || angkaKuantiti=='' ){
		alert("angka Salah");
	}else{
			$.ajax({
				type:'POST',
				data:{idAwal : id,
						angkaKoreksi : angkaKoreksi,
						angkaKuantiti : angkaKuantiti,
						kodeRekeningKoreksi : $("#kodeRekeningKoreksi"+id).val(),
						namaRekeningKoreksi : $("#namaRekeningKoreksi"+id).val(),
						},
				url: this.url+'&tipe=koreksi',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err != ''){
						alert(resp.err);
						if(resp.err == 'Tahap Koreksi Telah Habis'){
								window.location.reload();
							}
					}else{
						koreksiPengelolaPemeliharaanNew.refreshList(true);
					}

				 }
				});
		}

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
						alert(resp.err);
					}


			  	}
			});


	},

	formPemenuhan:function(id){
		var me = this;


			 var cover = this.prefix+'_formcover';

			$.ajax({
				type:'POST',
				data : {id : id},
			  	url: this.url+'&tipe=formPemenuhan',
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
						me.Close();
						me.AfterSimpan();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},

	SaveCaraPemenuhan: function(id){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:{caraPemenuhan : $("#caraPemenuhan").val()},
			url: this.url+'&tipe=SaveCaraPemenuhan',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
						var myOptions = {
						    val1 : $("#caraPemenuhan").val()
						};
						$.each(myOptions, function(val, text) {
						    $('#pemenuhan'+id).append( new Option(text,val) );
						});
						me.Close();
						me.AfterSimpan();

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
		return (((sign)?'':'-') + '' + num );
	},
	bantu : function(id){
		var idAngka = id.replace('J','j');
		var angka = $("#"+idAngka).val();
		$("#bantu"+id).text(koreksiPengelolaPemeliharaanNew.formatCurrency(angka));
	},Laporan:function(){
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


	},Report: function(){
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
					c1			  : $("#koreksiPengelolaPemeliharaanSkpdfmUrusan").val(),
					c 			  : $("#koreksiPengelolaPemeliharaanSkpdfmSKPD").val(),
					d 			  : $("#koreksiPengelolaPemeliharaanSkpdfmUNIT").val(),
					e 			  : $("#koreksiPengelolaPemeliharaanSkpdfmSUBUNIT").val(),
					e1 			  : $("#koreksiPengelolaPemeliharaanSkpdfmSEKSI").val(),


					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){

					aForm.action= url2+'&tipe='+resp.content.to+'&urusan='+$("#koreksiPengelolaPemeliharaanSkpdfmUrusan").val()+'&bidang='+$("#koreksiPengelolaPemeliharaanSkpdfmSKPD").val()+'&skpd='+$("#koreksiPengelolaPemeliharaanSkpdfmUNIT").val()+'&unit='+$("#koreksiPengelolaPemeliharaanSkpdfmSUBUNIT").val()+'&subunit='+$("#koreksiPengelolaPemeliharaanSkpdfmSEKSI").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd;
					aForm.target='_blank';
					aForm.submit();
					aForm.target='';
					me.Close();
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,
	cancelKoreksi : function(id){
		koreksiPengelolaPemeliharaanNew.refreshList(true);
	},
	excel:function(){
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
			  	url: this.url+'&tipe=excel',
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
	DownloadExcel: function(){
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
					c1			  : $("#koreksiPengelolaPemeliharaanSkpdfmUrusan").val(),
					c 			  : $("#koreksiPengelolaPemeliharaanSkpdfmSKPD").val(),
					d 			  : $("#koreksiPengelolaPemeliharaanSkpdfmUNIT").val(),
					e 			  : $("#koreksiPengelolaPemeliharaanSkpdfmSUBUNIT").val(),
					e1 			  : $("#koreksiPengelolaPemeliharaanSkpdfmSEKSI").val(),


					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){

					aForm.action= url2+'&tipe='+resp.content.to+"&xls=1";
					aForm.action= url2+'&tipe='+resp.content.to+'&xls=1'+'&urusan='+$("#koreksiPengelolaPemeliharaanSkpdfmUrusan").val()+'&bidang='+$("#koreksiPengelolaPemeliharaanSkpdfmSKPD").val()+'&skpd='+$("#koreksiPengelolaPemeliharaanSkpdfmUNIT").val()+'&unit='+$("#koreksiPengelolaPemeliharaanSkpdfmSUBUNIT").val()+'&subunit='+$("#koreksiPengelolaPemeliharaanSkpdfmSEKSI").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd;
					aForm.target='_blank';
					aForm.submit();
					aForm.target='';
					me.Close();
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
});