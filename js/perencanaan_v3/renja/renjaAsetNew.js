var renjaAsetNew = new DaftarObj2({
	prefix : 'renjaAsetNew',
	url : 'pages.php?Pg=renjaAsetNew', 
	formName : 'renjaAsetNewForm',
	renjaAsetNew_form : '0',
	loading: function(){
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		//this.sumHalRender();
	
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
	InputBaru: function(){
	var me = this;
			
		errmsg = '';
		
		if($("#fmSKPDUrusan").val() == '00'){
			errmsg = "Pilih Urusan";
		}else if($("#fmSKPDBidang").val() == '00'){
			errmsg = "Pilih Bidang";
		}else if($("#fmSKPDskpd").val() == '00'){
			errmsg = "Pilih SKPD";
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
						var IDrenjaAsetNew = Number(resp.content.idrenjaAsetNew);
						aForm.action= 'pages.php?Pg=renjaAsetNew_ins&YN=1&id='+IDrenjaAsetNew;
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
	},
	BidangAfter2: function(){
		renjaAsetNew.refreshList(true);
	},
	BidangAfterform: function(){
		var me = this;
		$.ajax({
		  url: this.url+'&tipe=BidangAfterForm',
		  type : 'POST',
		  data:{ fmSKPDBidang: $("#cmbBidangForm").val(),
		  		 fmSKPDUrusan: $("#cmbUrusanForm").val(),
		  		 fmSKPDskpd: $("#cmbSKPDForm").val(),
		  		 fmSKPDUnit: $("#cmbUnitForm").val(),
		  		 fmSKPDSubUnit: $("#cmbSubUnitForm").val() },
		  success: function(data) {
			var resp = eval('(' + data + ')');	
				document.getElementById('cmbBidangForm').innerHTML=resp.content.bidang;
				document.getElementById('cmbSKPDForm').innerHTML=resp.content.skpd;
				document.getElementById('cmbUnitForm').innerHTML=resp.content.unit;
				document.getElementById('cmbSubUnitForm').innerHTML=resp.content.subunit;
		  }
		});

	},
	jenisChanged: function(){
		var me = this;
		$.ajax({
		  url: this.url+'&tipe=jenisChanged',
		  type : 'POST',
		  data:{ jenisKegiatan: $("#jenisKegiatan").val()},
		  success: function(data) {
			var resp = eval('(' + data + ')');	
				document.getElementById('tempatPlus').innerHTML=resp.content.plus;
				document.getElementById('tempatMinus').innerHTML=resp.content.minus;
				document.getElementById('keyPP').textContent ="";
				document.getElementById('keyMM').textContent ="";
		  }
		});

	},
	pilihBidang: function(){
				renjaAsetNew.refreshList(true);

	},
	comboSKPDChanged: function(){
				renjaAsetNew.refreshList(true);
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
				//me.sumHalRender();
		  	}
		});
	},
	pilihPangkat : function(){
	var me = this; 
		$.ajax({
		  url: this.url+'&tipe=pilihPangkat',
		  type : 'POST',
		  data:{
		  	c1	: $("#fmSKPDUrusan").val(),
		  	c   : $("#fmSKPDBidang").val(),
		  	d   : $("#fmSKPDskpd").val(),
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
		var urusan = document.getElementById('fmSKPDUrusan').value; 
		var bidang = document.getElementById('fmSKPDBidang').value; 
		var skpd = document.getElementById('fmSKPDskpd').value;
		
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
	sesuai:function(id){
		$.ajax({
				type:'POST', 
				data:{idAwal : id,
					  angkaKoreksi : $("#valueJumlah"+id).val()},
				url: this.url+'&tipe=koreksi',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if(resp.err != ''){
						alert(resp.err);
						if(resp.err == 'Tahap Koreksi Telah Habis'){
							window.location.reload();
						}
					}else{
						renjaAsetNew.refreshList(true);
					}
					
				 }
			  });
		/*$("#span"+id).html("<input type='text' name='"+id+"' id='"+id+"' onkeyup='return renjaAsetNew.submitKoreksi(event,id)'  value='"+$("#valueJumlah"+id).val()+"'  style='text-align: right;'>  <span id='bantu"+id+"' >"+popupBarang.formatCurrency($("#valueJumlah"+id).val())+"</span>");*/

	},
	koreksi:function(id){
		$("#span"+id).html("<input type='text' name='"+id+"' id='"+id+"' onkeyup='return renjaAsetNew.submitKoreksi(event,id)' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  style='text-align: right;'>  <span id='bantu"+id+"' ></span>");
	},
	submitKoreksi:function(e,id) {
	var angkaKoreksi = $("#"+id).val();
	    if (e.keyCode == 13) {
			
			if(angkaKoreksi <= '0'){
				alert("angka Salah");
			}else{
			  $.ajax({
				type:'POST', 
				data:{idAwal : id,
					  angkaKoreksi : angkaKoreksi},
				url: this.url+'&tipe=koreksi',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if(resp.err != ''){
						alert(resp.err);
						if(resp.err == 'Tahap Koreksi Telah Habis'){
							window.location.reload();
						}
					}else{
						renjaAsetNew.refreshList(true);
					}
					
				 }
			  });
			}
	        return false;
	    }else if (e.keyCode == 27) {
			renjaAsetNew.refreshList(true);
	        return false;
	    }else{
			document.getElementById('bantu'+id).innerHTML = popupBarang.formatCurrency(angkaKoreksi);
		}
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
	Info: function(){	
		var me = this;
	    var cover = this.prefix+'_formcover';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize() ,
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
					if(me.renjaAsetNew_form==0){
						me.Close();
						me.AfterSimpan();						
					}

				}else{
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
						if(resp.err == 'Tahap Penyusunan Telah Habis'){
							alert(resp.err);
							window.location.reload();
						}else{
							alert(resp.err);
						}
					}			
			
			  	}
			});
		}else{
			alert(errmsg);
		}
		
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
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					if(me.renjaAsetNew_form == 0){
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
	detailrenjaAsetNew: function(kode){	
		
		var me = this;
			var box = this.GetCbxChecked();
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,2,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data: $('#'+this.formName).serialize()+"&renjaAsetNew_cb%5B%5D=1.08.01.01.01" ,
				url: this.url+'&tipe=lihatrenjaAsetNew',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						me.AfterFormEdit(resp);
						$("#findProgram").attr("disabled",true);
						$("#plafon").attr("readonly",true);
						$("#keyPlafon").text("Rp. " + popupProgram.formatCurrency($("#plafon").val()));
						
						
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});
	},
	pesanPasif : function(){
	  alert("STATUS PASIF");	
	},
	
	comboChanged : function(){
			$.ajax({
			type:'POST', 
			data:{ c1 : $("#cmbUrusan").val(),
				   c  : $("#cmbBidang").val(),
				   d  : $("#cmbSKPD").val()
					 },
			url: this.url+'&tipe=comboPlafon',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				document.getElementById("cmbUrusan").innerHTML = resp.content.urusan;
				document.getElementById("cmbBidang").innerHTML = resp.content.bidang;
				document.getElementById("cmbSKPD").innerHTML = resp.content.skpd;
				document.getElementById("angkaPlafon").innerHTML = resp.content.angkaPlafon;

				
		  	}
		});
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
					if(resp.err ==''){
						var ID_PLAFON = Number(resp.content.ID_PLAFON);
						var ID_EDIT = Number(resp.content.ID_EDIT);
						aForm.action= 'pages.php?Pg=renjaAsetNew_ins&id='+ID_PLAFON+"&ID_RENJA="+ID_EDIT;
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
	
	CariProgramKegiatan : function(){
		popupProgram.windowSaveAfter= function(){};
		 if(document.getElementById('bk').value == ''){
		 	alert("PILIH URUSAN PROGRAM");
		 }else if(document.getElementById('bk').value != '0' && document.getElementById('ck').value == '' ){
		 	alert("PILIH BIDANG PROGRAM"); 
		 }else{
		 	 popupProgram.filterAkun=document.getElementById('bk').value + "." + document.getElementById('ck').value;
		 	 popupProgram.windowShow();	
		 }
	},
	
	CariUrusanProgram : function(){
		 
		 popupUrusan.filterAkun='0';
		 popupUrusan.windowShow();	
	},
	
	CariBidangProgram : function(){
		 popupUrusan.windowSaveAfter= function(){};
		 popupUrusan.filterAkun= document.getElementById('bk').value;
		 if(document.getElementById('bk').value == ''){
		 	alert("PILIH URUSAN PROGRAM");
		 }else if(document.getElementById('bk').value == '0'){
		 	alert("NON URUSAN TIDAK MEMILIKI BIDANG"); 
		 }else{
		 	 popupUrusan.windowShow();	
		 }
		
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
				c1	: $("#fmSKPDUrusan").val(),
			  	c   : $("#fmSKPDBidang").val(),
			  	d   : $("#fmSKPDskpd").val(),
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
	},Laporan: function(){
			$.ajax({
			  url: 'pages.php?Pg=renjaAsetNew&tipe=postReport',
			  type : 'POST',
			  data:{
			  		cetakjang : $("#cetakjang").val(),
			  		ttd       : $("#ttd").val(),
					urusan    : $("#fmSKPDUrusan").val(),
					bidang    : $("#fmSKPDBidang").val(),
					skpd      : $("#fmSKPDskpd").val(),
					namaPemda : $("#namaPemda").val(),
					},
			  success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err !=''){
						alert(resp.err);
						me.Close();

					}else{
						window.open('pages.php?Pg=renjaAsetNew&tipe=Laporan'+'&urusan='+$("#fmSKPDUrusan").val()+'&bidang='+$("#fmSKPDBidang").val()+'&skpd='+$("#fmSKPDskpd").val()+'&tanggalCetak='+resp.content.cetakjang+'&ttd='+resp.content.ttd, '_blank');
						me.Close();
					}
			  }
			});

	},
	TanggalCetak:function(){
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
			  	url: this.url+'&tipe=TanggalCetak',
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