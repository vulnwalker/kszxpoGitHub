var pengadaanNewSkpd = new SkpdCls({
	prefix : 'pengadaanNewSkpd',
	formName: 'pengadaanNewForm',
	pilihBidangAfter : function(){pengadaanNew.refreshList(true);},
	pilihUnitAfter : function(){pengadaanNew.refreshList(true);},
	pilihSubUnitAfter : function(){pengadaanNew.refreshList(true);},
	pilihSeksiAfter : function(){pengadaanNew.refreshList(true);}
});

var pengadaanNew = new DaftarObj2({
	prefix : 'pengadaanNew',
	url : 'pages.php?Pg=pengadaanNew',
	formName : 'pengadaanNewForm',

	loading:function(){
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		//this.sumHalRender();

	},
	filterRenderAfter : function(){
		this.daftarRender();
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
					ttd           : $("#ttd").val(),
					c1 			  : $("#rkbmdPengadaan_v3SkpdfmUrusan").val(),
					c 			  : $("#rkbmdPengadaan_v3SkpdfmSKPD").val(),
					d 			  : $("#rkbmdPengadaan_v3SkpdfmUNIT").val(),
					e 			  : $("#rkbmdPengadaan_v3SkpdfmSUBUNIT").val(),
					e1 			  : $("#rkbmdPengadaan_v3SkpdfmSEKSI").val(),


					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){

					aForm.action= 'pages.php?Pg=pengadaanNew'+'&tipe='+resp.content.to+'&xls=1'+'&urusan='+$("#rkbmdPengadaan_v3SkpdfmUrusan").val()+'&bidang='+$("#rkbmdPengadaan_v3SkpdfmSKPD").val()+'&skpd='+$("#rkbmdPengadaan_v3SkpdfmUNIT").val()+'&unit='+$("#rkbmdPengadaan_v3SkpdfmSUBUNIT").val()+'&subunit='+$("#rkbmdPengadaan_v3SkpdfmSEKSI").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd;
					// window.open('pages.php?Pg=pengadaanNew'+'&tipe='+resp.content.to+'&xls=1'+'&urusan='+$("#rkbmdPengadaan_v3SkpdfmUrusan").val()+'&bidang='+$("#rkbmdPengadaan_v3SkpdfmSKPD").val()+'&skpd='+$("#rkbmdPengadaan_v3SkpdfmUNIT").val()+'&unit='+$("#rkbmdPengadaan_v3SkpdfmSUBUNIT").val()+'&subunit='+$("#rkbmdPengadaan_v3SkpdfmSEKSI").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd);
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
	daftarRender:function(){
		var jenisKegiatan = document.getElementById('cmbJenispengadaanNew');
		/*cmbJenispengadaanNew.remove(0);*/
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
					pengadaanNew.refreshList(true);

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
					ttd           : $("#ttd").val(),
					c1 			  : $("#rkbmdPengadaan_v3SkpdfmUrusan").val(),
					c 			  : $("#rkbmdPengadaan_v3SkpdfmSKPD").val(),
					d 			  : $("#rkbmdPengadaan_v3SkpdfmUNIT").val(),
					e 			  : $("#rkbmdPengadaan_v3SkpdfmSUBUNIT").val(),
					e1 			  : $("#rkbmdPengadaan_v3SkpdfmSEKSI").val(),


					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){

					window.open('pages.php?Pg=pengadaanNew'+'&tipe='+resp.content.to+'&urusan='+$("#rkbmdPengadaan_v3SkpdfmUrusan").val()+'&bidang='+$("#rkbmdPengadaan_v3SkpdfmSKPD").val()+'&skpd='+$("#rkbmdPengadaan_v3SkpdfmUNIT").val()+'&unit='+$("#rkbmdPengadaan_v3SkpdfmSUBUNIT").val()+'&subunit='+$("#rkbmdPengadaan_v3SkpdfmSEKSI").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd);
					
					me.Close();
				}else{
					alert(resp.err);
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
						pengadaanNew.refreshList(true);
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
	},
	InputBaru: function(){
		var me = this;

		errmsg = '';

		if($("#pengadaanNewSkpdfmUrusan").val() == '0'){
			errmsg = "Pilih Urusan";
		}else if($("#pengadaanNewSkpdfmSKPD").val() == '00'){
			errmsg = "Pilih Bidang";
		}else if($("#pengadaanNewSkpdfmUNIT").val() == '00'){
			errmsg = "Pilih SKPD";
		}else if($("#pengadaanNewSkpdfmSUBUNIT").val() == '00'){
			errmsg = "Pilih UNIT";
		}else if($("#pengadaanNewSkpdfmSEKSI").val() == '000'){
			errmsg = "Pilih SUB UNIT";
		}else if($("#cmbJenispengadaanNew").val() == ''){
			errmsg = "Pilih JENIS pengadaanNew";
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
	Baru: function(){
		var me = this;
		var err='';
		var urusan = document.getElementById('rkbmdPengadaan_v3SkpdfmUrusan').value; 
		var bidang = document.getElementById('rkbmdPengadaan_v3SkpdfmSKPD').value; 
		var skpd = document.getElementById('rkbmdPengadaan_v3SkpdfmUNIT').value;
		var unit = document.getElementById('rkbmdPengadaan_v3SkpdfmSUBUNIT').value;
		var subunit = document.getElementById('rkbmdPengadaan_v3SkpdfmSEKSI').value;
		
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
	koreksi:function(id){
		/*$("#alignKoreksi").attr('align','center');*/
		$("#updatePengguna"+id).attr('align','center');
		$("#spanJumlah"+id).html("<input type='text' name='jumlah"+id+"' id='jumlah"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup=pengadaanNew.bantu('Jumlah"+id+"'); style='text-align: right;'>  ");
		$.ajax({
				type:'POST',
				data :{id : id},
				url: this.url+'&tipe=comboBoxPemenuhan',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err != ''){
						alert(resp.err);
					}else{
					 $("#spanCaraPemenuhan"+id).html(resp.content.caraPemenuhan  );
					}

				 }
			  });
		$("#save"+id).html("<img src='datepicker/save.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=pengadaanNew.submitKoreksi('"+id+"');></img> &nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=pengadaanNew.cancelKoreksi('"+id+"');></img> ");
	},
	sesuai:function(id){
		var isi = $("#volumeBarang"+id+"").val();
		$("#updatePengguna"+id).attr('align','center');
		$("#spanJumlah"+id).html("<input type='text' value='"+isi+"' name='jumlah"+id+"' id='jumlah"+id+"' style='text-align: right;' readonly> ");
		$.ajax({
				type:'POST',
				data :{id : id},
				url: this.url+'&tipe=comboBoxPemenuhan',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err != ''){
						alert(resp.err);
					}else{
					 $("#spanCaraPemenuhan"+id).html(resp.content.caraPemenuhan  );
					}

				 }
			  });
		$("#save"+id).html("<img src='datepicker/save.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=pengadaanNew.submitKoreksi('"+id+"');></img> &nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=pengadaanNew.cancelKoreksi('"+id+"');></img> ");
	},
	submitKoreksi:function(id) {
	var angkaKoreksi = $("#jumlah"+id).val();
	var caraPemenuhan = $("#pemenuhan"+id).val();
	if(angkaKoreksi <= '0'){
		alert("angka Salah");
	}else if(caraPemenuhan == ''){
		alert("isi cara pemenuhan");
	}else{
	    $.ajax({
				type:'POST',
				data:{idAwal : id,
					  angkaKoreksi : angkaKoreksi,
					  caraPemenuhan : caraPemenuhan,
					  jenispengadaanNew  : $("#cmbJenispengadaanNew").val()
					  },
				url: this.url+'&tipe=koreksi',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err != ''){
						alert(resp.err);
						if(resp.err == "Tahap Koreksi Telah Habis"){
							window.location.reload();
						}
					}else{
						pengadaanNew.refreshList(true);
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
	pilihPangkat : function(){
	var me = this; 
		$.ajax({
		  url: this.url+'&tipe=pilihPangkat',
		  type : 'POST',
		  data:{
				c1	: $("#rkbmdPengadaan_v3SkpdfmUrusan").val(),
			  	c   : $("#rkbmdPengadaan_v3SkpdfmSKPD").val(),
			  	d   : $("#rkbmdPengadaan_v3SkpdfmUNIT").val(),
			  	e   : $("#rkbmdPengadaan_v3SkpdfmSUBUNIT").val(),
			  	e1  : $("#rkbmdPengadaan_v3SkpdfmSEKSI").val(),
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
	jenisChanged: function(){
		var me = this;
		$.ajax({
		  url: this.url+'&tipe=jenisChanged',
		  type : 'POST',
		  data:{ 
		  	jenisKegiatan: $("#jenisKegiatan").val(),
		  	c1           : $("#rkbmdPengadaan_v3SkpdfmUrusan").val(),
		  	c            : $("#rkbmdPengadaan_v3SkpdfmSKPD").val(),
		  	d            : $("#rkbmdPengadaan_v3SkpdfmUNIT").val(),
		  	e            : $("#rkbmdPengadaan_v3SkpdfmSUBUNIT").val(),
		  	e1           : $("#rkbmdPengadaan_v3SkpdfmSEKSI").val(),
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
				jenisKegiatan: $("#jenisKegiatan").val(),
				c1	: $("#rkbmdPengadaan_v3SkpdfmUrusan").val(),
			  	c   : $("#rkbmdPengadaan_v3SkpdfmSKPD").val(),
			  	d   : $("#rkbmdPengadaan_v3SkpdfmUNIT").val(),
			  	e   : $("#rkbmdPengadaan_v3SkpdfmSUBUNIT").val(),
			  	e1  : $("#rkbmdPengadaan_v3SkpdfmSEKSI").val(),
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
		$("#bantu"+id).text(pengadaanNew.formatCurrency(angka));
	},
	cancelKoreksi : function(id){
		pengadaanNew.refreshList(true);
	}
});
