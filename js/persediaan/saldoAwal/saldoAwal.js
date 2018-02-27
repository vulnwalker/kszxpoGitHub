
var saldoAwalSKPD2 = new SkpdCls({
	prefix : 'saldoAwalSKPD2',
	formName: 'saldoAwalForm',

	pilihUrusanfter : function(){saldoAwal.refreshList(true);},
	pilihBidangAfter : function(){saldoAwal.refreshList(true);},
	pilihUnitAfter : function(){saldoAwal.refreshList(true);},
	pilihSubUnitAfter : function(){saldoAwal.refreshList(true);},
	pilihSeksiAfter : function(){saldoAwal.refreshList(true);}
});
var saldoAwal = new DaftarObj2({
	prefix : 'saldoAwal',
	url : 'pages.php?Pg=saldoAwal',
	formName : 'saldoAwalForm',

	loading:function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	},
	filterRenderAfter : function(){
		// $.ajax({
		// 	type:'POST',
		// 		url: this.url+'&tipe=getYearRange',
		// 		success: function(data) {
		// 		var resp = eval('(' + data + ')');
		// 			$('#tanggalCek').datepicker({
		// 					dateFormat: "dd-mm-yy",
		// 					showAnim: "slideDown",
		// 					inline: true,
		// 					showOn: "button",
		// 					buttonImage: "datepicker/calender1.png",
		// 					buttonImageOnly: true,
		// 					changeMonth: true,
		// 					changeYear: false,
		// 					yearRange: resp.content.yearRange,
		// 					buttonText : "",
		// 			});
		// 		}
		// });

			this.daftarRender();
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

	findRekening : function(){
		var me = this;
		var filterRek = "BELANJA BARANG JASA";

		popupRekening.el_kode_rekening = 'kodeRekening';
		popupRekening.el_nama_rekening = 'namaRekening';
		popupRekening.windowSaveAfter= function(){};
		popupRekening.filterAkun=filterRek;
		popupRekening.windowShow();

	},

	Baru:function(){
		var me = this;
		var err ='';



		if (err =='' ){
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,2,true,false);
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						//me.AfterFormBaru(resp);
						listBarangSaldoAwal.loading();

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

	editData:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,2,true,false);
			$.ajax({
			  url: this.url+'&tipe=editData',
			  type : 'POST',
			  data:$('#'+this.formName).serialize(),
			  success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						listBarangSaldoAwal.loading();
					}else{
						alert(resp.err);
					}

			  }
			});
		}else{
			alert(errmsg);
		}

	},
	BidangAfterform: function(){
		var me = this;

		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=BidangAfterForm',
		  type : 'POST',
		  data:{fmSKPDBidang: $("#cmbBidangForm").val(),
		  		fmSKPDUrusan: $("#cmbUrusanForm").val(),
				fmSKPDskpd: $("#cmbSKPDForm").val(),
				fmSKPDUnit: $("#cmbUnitForm").val(),
				fmSKPDSubUnit: $("#cmbSubUnitForm").val(),
				},
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagian');
				document.getElementById('cmbBidangForm').innerHTML=resp.content.bidang;
				document.getElementById('cmbSKPDForm').innerHTML=resp.content.skpd;
				document.getElementById('cmbUnitForm').innerHTML=resp.content.unit;
				document.getElementById('cmbSubUnitForm').innerHTML=resp.content.subUnit;




		  }
		});

	},
	Cari: function(){
		popupBarang_v2.kodeBarang = 'kodeBarang';
		popupBarang_v2.namaBarang = 'namaBarang';
		popupBarang_v2.satuanBarang = 'satuan';
		popupBarang_v2.windowShow();

	},

	AfterSimpan : function(){
		if(document.getElementById('Kunjungan_cont_daftar')){
		this.refreshList(true);}
	},

	Simpan: function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'Form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					alert('Data berhasil disimpan');
					me.Close();
					me.refreshList(true);
				}
				else{
					alert(resp.err);
				}
		  	}
		});
	},


		simpanData: function(){
		var me= this;

		$.ajax({
			type:'POST',
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=SimpanDatas',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					alert('Data berhasil disimpan');
					me.refreshList(true);
				}
				else{
					alert(resp.err);
				}
		  	}
		});
	},


	hapus: function(id){
		var me= this;
            if (confirm('Anda yakin ingin menghapus Data?')) {
					$.ajax({
						type:'POST',
						data:
							{
								id :id
							},
						url: this.url+'&tipe=Hapus',
					  	success: function(data) {
							var resp = eval('(' + data + ')');
							if(resp.err==''){
								//alert('Data berhasil diHapus');
								me.refreshList(true);
							}
							else{
								alert(resp.err);
							}
					  	}
					});
            }



	},

	saveData: function(kode){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:{
					kode : kode,
					jumlahBarang : $("#jumlahBarang").val()
				 },
			url: this.url+'&tipe=saveData',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					alert('Data berhasil disimpan');
					me.Close();
					me.refreshList(true);
				}
				else{
					alert(resp.err);
				}
		  	}
		});
	},
 sum : function(id) {
 	  var id = id;
      var inputJumlah = document.getElementById('jumlah'+id).value;
      var hargaSatuan = document.getElementById('harga'+id).value;
      var result = parseInt(inputJumlah) * parseInt(hargaSatuan);

      if (hargaSatuan == ""){
      	document.getElementById('inputTotal'+id).textContent ="";
      	 document.getElementById('bantuanH'+id).textContent = "";
      }else{
      	 document.getElementById('bantuanH'+id).textContent = this.formatCurrency(hargaSatuan);
      }

      if (inputJumlah < 0){
      	   	document.getElementById('jumlah'+id).value ="";
      	 document.getElementById('bantuanJ'+id).textContent = "";
      }else{
      	 document.getElementById('bantuanJ'+id).textContent = this.formatCurrency(inputJumlah);
      }


	  if (!isNaN(result)) {

	        document.getElementById('inputTotal'+id).textContent = this.formatCurrency(result);

	  }


    		$.ajax({
			type:'POST',
			data:{
					id : id,
					harga : hargaSatuan,
					jumlah : inputJumlah
				 },
		  	url: this.url+'&tipe=SimpanData',
		  	success: function(data) {
				var resp = eval('(' + data + ')');

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


	ubah: function(id){

		$.ajax({
			type:'POST',
			data:{
					id : id


				 },
			url: this.url+'&tipe=ubahData',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					// document.getElementById("inputJumlah41").innerHTML=resp.content.inputJumlah;
					$("#inputJumlah"+id).html(resp.content.inputJumlah);
					$("#hargaSatuan"+id).html(resp.content.hargaSatuan);
					$("#btnOpsi"+id).html(resp.content.btnOpsi);

					// document.getElementById("#hargaSatuan"+id).innerHTML=resp.content.hargaSatuan;

				}
				else{
					alert(resp.err);
				}
		  	}
		});
	},

});
