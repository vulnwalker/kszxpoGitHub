var penetapanRKBMDPemeliharaanNewSkpd = new SkpdCls({
	prefix : 'penetapanRKBMDPemeliharaanNewSkpd',
	formName: 'penetapanRKBMDPemeliharaanNewForm',
	pilihBidangAfter : function(){penetapanRKBMDPemeliharaanNew.refreshList(true);},
	pilihUnitAfter : function(){penetapanRKBMDPemeliharaanNew.refreshList(true);},
	pilihSubUnitAfter : function(){penetapanRKBMDPemeliharaanNew.refreshList(true);},
	pilihSeksiAfter : function(){penetapanRKBMDPemeliharaanNew.refreshList(true);}
});

var penetapanRKBMDPemeliharaanNew = new DaftarObj2({
	prefix : 'penetapanRKBMDPemeliharaanNew',
	url : 'pages.php?Pg=penetapanRKBMDPemeliharaanNew',
	formName : 'penetapanRKBMDPemeliharaanNewForm',

	loading:function(){
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		//this.sumHalRender();

	},

	daftarRender:function(){
		var jenisKegiatan = document.getElementById('cmbJenispenetapanRKBMDPemeliharaanNew');
		/*cmbJenispenetapanRKBMDPemeliharaanNew.remove(0);*/
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
					penetapanRKBMDPemeliharaanNew.refreshList(true);

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
				c1			: $("#penetapanRKBMDPemeliharaanSkpdfmUrusan").val(),
				c 			: $("#penetapanRKBMDPemeliharaanSkpdfmSKPD").val(),
				d 			: $("#penetapanRKBMDPemeliharaanSkpdfmUNIT").val(),
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
				c1			: $("#penetapanRKBMDPemeliharaanSkpdfmUrusan").val(),
				c 			: $("#penetapanRKBMDPemeliharaanSkpdfmSKPD").val(),
				d 			: $("#penetapanRKBMDPemeliharaanSkpdfmUNIT").val(),
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
		var urusan = document.getElementById('penetapanRKBMDPemeliharaanSkpdfmUrusan').value; 
		var bidang = document.getElementById('penetapanRKBMDPemeliharaanSkpdfmSKPD').value; 
		var skpd = document.getElementById('penetapanRKBMDPemeliharaanSkpdfmUNIT').value;
		
		var cover = this.prefix+'_formcover';
		if(err==''){
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize()+"&urusan="+urusan+"&bidang="+bidang+"&skpd="+skpd,
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
					ttd			: $("#ttd").val(),
					c1			: $("#penetapanRKBMDPemeliharaanSkpdfmUrusan").val(),
					c 			: $("#penetapanRKBMDPemeliharaanSkpdfmSKPD").val(),
					d 			: $("#penetapanRKBMDPemeliharaanSkpdfmUNIT").val(),


					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){

					aForm.action= url2+'&tipe='+resp.content.to+'&urusan='+$("#penetapanRKBMDPemeliharaanSkpdfmUrusan").val()+'&bidang='+$("#penetapanRKBMDPemeliharaanSkpdfmSKPD").val()+'&skpd='+$("#penetapanRKBMDPemeliharaanSkpdfmUNIT").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd;
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

	tetapkanRKBMD:function() {

				var me = this;
					 var cover = this.prefix+'_formcover';
					$.ajax({
						type:'POST',
							url: this.url+'&tipe=tetapkanRKBMD',
							data:$('#'+this.formName).serialize(),
							success: function(data) {
							var resp = eval('(' + data + ')');
							if(resp.err == ''){

								document.body.style.overflow='hidden';
								addCoverPage2(cover,5,true,false);
								document.getElementById(cover).innerHTML = resp.content;
								$('#tanggalPenetapan').datepicker({
												    dateFormat: 'dd-mm-yy',
													showAnim: 'slideDown',
												    inline: true,
													showOn: "button",
						     						buttonImage: "images/calendar.gif",
						      						buttonImageOnly: true,
													changeMonth: true,
						      						changeYear: true,
								});
							}else{
								alert(resp.err);
							}


							}
					});


	},

	newNomorPenetapan:function() {

				var me = this;
				var cover = this.prefix+'_formcoverKB';
					$.ajax({
						type:'POST',
							url: this.url+'&tipe=newNomorPenetapan',
							success: function(data) {
							var resp = eval('(' + data + ')');
							if(resp.err == ''){

								document.body.style.overflow='hidden';
								addCoverPage2(cover,5,true,false);
								document.getElementById(cover).innerHTML = resp.content;
								$('#newTanggalPenetapan').datepicker({
												    dateFormat: 'dd-mm-yy',
													showAnim: 'slideDown',
												    inline: true,
													showOn: "button",
						     						buttonImage: "images/calendar.gif",
						      						buttonImageOnly: true,
													changeMonth: true,
						      						changeYear: true,
								});
							}else{
								alert(resp.err);
							}
							}
					});
	},
	Close2: function(){
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);
		if(tipe==null){
				document.body.style.overflow = 'auto';
		}
	},

	saveTetapkanRKBMD:function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);

		$.ajax({
		 type:'POST',
		 url: this.url+'&tipe=saveTetapkanRKBMD',
		 	 data : {
				 nomor : $("#nomorPenetapan").val(),
				 c1 : $("#c1").val(),
				 c : $("#c").val(),
				 d : $("#d").val(),
				 nomorPenetapan : $("#nomorPenetapan").val(),
				 tanggalPenetapan : $("#tanggalPenetapan").val(),
				 namaPejabat : $("#namaPejabat").val(),
				 nip : $("#nip").val(),
				 jabatan : $("#jabatan").val(),
				 statusPengadaan : $("#checkBoxPengadaan").is( ":checked" ),
				 statusPemeliharaan : $("#checkboxPemeliharaan").is( ":checked" ),
				 statusPersediaan : $("#checkboxPersediaan").is( ":checked" ),

			 },
			 success: function(data) {
			 var resp = eval('(' + data + ')');
			 delElem(cover);
			 if(resp.err != ''){
				 alert(resp.err);
			 }else{
					 alert("Penetapan Berhasil");
					 me.Close();
			 }

			}
		 });

	},
	saveNomorPenetapan:function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formcoverKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
		 type:'POST',
		 url: this.url+'&tipe=saveNomorPenetapan',
		 	 data : {
				 nomor : $("#newNomorPenetapan").val(),
				 tanggalPenetapan : $("#newTanggalPenetapan").val(),
				 namaPejabat : $("#newNamaPejabat").val(),
				 nip : $("#newNIP").val(),
				 jabatan : $("#newJabatan").val(),

			 },
			 success: function(data) {
			 var resp = eval('(' + data + ')');
			 delElem(cover);
			 if(resp.err != ''){
				  alert(resp.err);
			 }else{
					 alert("Data Tersimpan");
					 $("#nomorPenetapan").html(resp.content.comboNomorPenetapan);
					 me.Close2();
			 }

			}
		 });

	},
	cancelPenetapanPengadaan:function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);

		$.ajax({
		 type:'POST',
		 data : {
			 				c1 : $("#c1").val(),
			 				c : $("#c").val(),
			 				d : $("#d").val(),
		 },
		 url: this.url+'&tipe=cancelPenetapanPengadaan',

			 success: function(data) {
			 var resp = eval('(' + data + ')');
			 delElem(cover);
			 if(resp.err != ''){
				 alert(resp.err);
			 }else{
					 alert("Penetapan di batalkan ");
					 me.Close();
			 }

			}
		 });

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
	nomorPenetapanChanged:function(){
		var me = this;



			$.ajax({
				type:'POST',
				data : {id : $("#nomorPenetapan").val()},
			  	url: this.url+'&tipe=nomorPenetapanChanged',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
							$("#tanggalPenetapan").val(resp.content.tanggalPenetapan);
							$("#namaPejabat").val(resp.content.namaPejabat);
							$("#nip").val(resp.content.nip);
							$("#jabatan").val(resp.content.jabatan);
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
		$("#bantu"+id).text(penetapanRKBMDPemeliharaanNew.formatCurrency(angka));
	},
	cancelKoreksi : function(id){
		penetapanRKBMDPemeliharaanNew.refreshList(true);
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
					ttd			: $("#ttd").val(),
					c1			: $("#penetapanRKBMDPemeliharaanSkpdfmUrusan").val(),
					c 			: $("#penetapanRKBMDPemeliharaanSkpdfmSKPD").val(),
					d 			: $("#penetapanRKBMDPemeliharaanSkpdfmUNIT").val(),


					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){

					// aForm.action= url2+'&tipe='+resp.content.to+"&xls=1";
					aForm.action= url2+'&tipe='+resp.content.to+'&xls=1'+'&urusan='+$("#penetapanRKBMDPemeliharaanSkpdfmUrusan").val()+'&bidang='+$("#penetapanRKBMDPemeliharaanSkpdfmSKPD").val()+'&skpd='+$("#penetapanRKBMDPemeliharaanSkpdfmUNIT").val()+'&kota='+resp.content.namaPemda+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd;
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
});
