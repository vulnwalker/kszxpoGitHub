var suratpermohonan_spm = new DaftarObj2({
	prefix : 'suratpermohonan_spm',
	url : 'pages.php?Pg=suratpermohonan_spm', 
	formName : 'suratpermohonan_spmForm',
	IdSPPTemp:0,
	satuan_form : '0',//default js satuan
	JnsSPP : '0',
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();/*
		this.daftarRender();
		this.sumHalRender();*/
	
	},
	
	filterRenderAfter : function(){
		var me = this;
		var DataBaru = document.getElementById("databaru").value ;
		me.JnsSPP = document.getElementById("haljns_sppnya").value ;
		setTimeout(function myFunction() {
			DataPengaturan.nyalakandatepicker2();			
			me.getNomorSPM();
			me.Get_RincianSPM();
			if(me.JnsSPP == "1")me.tabelPotonganPajak();
			me.Get_PenandatanganSPM();	
		},1000);
		/*setTimeout(function myFunction() {me.TabelDokumen()},1000);
		
		setTimeout(function myFunction() {me.tabelPotonganPajak()},1000);
		setTimeout(function myFunction() {me.JumlahBiaya(1)},1000);
		setTimeout(function myFunction() {me.nyalakandatepicker()},200);
		setTimeout(function myFunction() {me.getNomorSPM()},1000);*/
			
	},
	
	TabelDokumen: function(){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=TabelDokumen',
			success: function(data) {	
				var resp = eval('(' + data + ')');	
				delElem(cover);
				document.body.style.overflow='auto';		
				if(resp.err==''){
					document.getElementById('tbl_dokumen').innerHTML = resp.content;
				}else{
					alert(resp.err);
				}
			}
		});	
		
		//setTimeout(function myFunction() {pemasukan_ins.CekSesuai()},1000);
	},
	
	nyalakandatepicker: function(){
		
		$( ".datepicker" ).datepicker({ 
			dateFormat: "dd-mm-yy", 
			showAnim: "slideDown",
			inline: true,
			showOn: "button",
			buttonImage: "datepicker/calender1.png",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+0",
			buttonText : "",
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
				//me.sumHalRender();
		  	}
		});
	},
	Baru: function(){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		
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
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
					me.AfterFormBaru();
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	BaruNamaPejabat: function(JNS=''){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=BaruNamaPejabat&jns='+JNS,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
					me.AfterFormBaru();
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	SimpanNamaPejabat: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		/*this.sendReq(
			this.url,
			{ idprs: 0, daftarProses: new Array('simpan')},
			this.formDialog);*/
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=SimpanNamaPejabat',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					document.getElementById("jns_"+resp.content.jns).innerHTML = resp.content.value;
					me.Close();	
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	Edit:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,999,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formEdit',
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
		
	Simpan: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		/*this.sendReq(
			this.url,
			{ idprs: 0, daftarProses: new Array('simpan')},
			this.formDialog);*/
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					if(me.satuan_form==0){
						me.Close();
						me.AfterSimpan();						
					}else{
						me.Close();
						barang.refreshComboSatuan();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	CariProgram: function(){
		var me = this;
		cariprogram.windowShow();	
	},
	
	CariIdPenerimaan: function(){
		var me = this;
		cariIdPenerima.windowShow();	
	},
	
	tabelRekening: function(hapus = 1){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRekening',
			success: function(data) {	
				var resp = eval('(' + data + ')');		
				delElem(cover);		
				document.body.style.overflow='auto';		
				if(resp.err==''){
					document.getElementById('tbl_rekening').innerHTML = resp.content.tabel;
				}else{
					alert(resp.err);
				}
			}
		});	
		
		//setTimeout(function myFunction() {pemasukan_ins.CekSesuai()},1000);
	},
	
	CancelRekeningPajak: function(jns){
		var me=this;
		if(jns == 1){
			me.tabelPotonganPajak();
		}else{
			me.tabelRetensiDenda();
		}
	},
	
	BaruPotonganPajak: function(jns){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=BaruPotonganPajak',
			success: function(data) {	
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';		
				if(resp.err==''){
					me.tabelPotonganPajak(0);	
					me.CariPotongan();				
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	updKodeRek: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=updKodeRek',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				delElem(cover);		
				document.body.style.overflow='auto';			
				if(resp.err==''){
					me.tabelPotonganPajak();
				}else{
					alert(resp.err);
				}
			}
		});	
	},
		
	UpdateRekeningPajak: function(idna){
		var me = this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=UpdateRekeningPajak&idna='+idna,
			success: function(data) {	
				var resp = eval('(' + data + ')');
				delElem(cover);		
				document.body.style.overflow='auto';			
				if(resp.err==''){
					//me.tabelPotonganPajak(0);
					DataPengaturan.Set_cekDcID_INNER("kd_RekPotongan_"+idna,resp.content.inputan);
					DataPengaturan.Set_cekDcID_INNER("atasbutton",resp.content.atasbutton);
					DataPengaturan.Set_cekDcID_INNER("option_"+idna,resp.content.option);
				}else{
					alert(resp.err);
				}
			}
		});	
		
	},
	
	namarekening: function(){
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=namarekening',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	HapusRekening: function(isi){
		var me=this;
		var konfrim = confirm("Hapus Data Rekening Potongan SPM ?");
		if(konfrim == true){
			this.OnErrorClose = false	
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=HapusRekening&idrekei='+isi,
				success: function(data) {	
					var resp = eval('(' + data + ')');
					delElem(cover);		
					document.body.style.overflow='auto';			
					if(resp.err==''){
						me.tabelPotonganPajak();
					}else{
						alert(resp.err);
					}
				}
			});	
		}
		
	},
	
	konfBarang: function(){
		var stat_barang = document.getElementById('stat_barang').value;
		
		if(stat_barang != '1'){
			document.getElementById('progcar').disabled = true;
			document.getElementById('cariIdPenerimaan').disabled = true;
			document.getElementById('prog').value = '';
			document.getElementById('id_penerimaan').value = '';
			document.getElementById('program').value = '';
			if(document.getElementById('kegiatan1'))document.getElementById('kegiatan1').value = '';
			if(document.getElementById('kegiatan'))document.getElementById('kegiatan').value = '';
			document.getElementById('pekerjaan').value = '';
			if(document.getElementById('kegiatan1'))document.getElementById('kegiatan1').disabled = true;
			document.getElementById('pekerjaan').disabled = true;
		}else{
			document.getElementById('progcar').disabled = false;
			document.getElementById('cariIdPenerimaan').disabled = false;
			//document.getElementById('kegiatan').disabled = false;
			document.getElementById('pekerjaan').disabled = false;
			document.getElementById('pekerjaan').readOnly = false;
			document.getElementById('refid_terima').value = '';
		}
	},
	
	SimpanSemua: function(){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=SimpanSemua',
				success: function(data) {	
					var resp = eval('(' + data + ')');	
					delElem(cover);		
					document.body.style.overflow='auto';			
					if(resp.err==''){
						alert("Data Berhasil Disimpan !");
							setTimeout(function myFunction() {
								window.close();
								window.opener.location.reload();
							},1000);				
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	BatalSemua: function(){
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=BatalSemua',
			success: function(data) {	
				var resp = eval('(' + data + ')');		
				document.body.style.overflow='auto';	
				delElem(cover);			
				if(resp.err==''){
						window.close();
						window.opener.location.reload();									
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	CariIdSPP: function(){
		var me = this;
		var Namaform = me.formName;
		me.IdSPPTemp=DataPengaturan.cekDcID_val("IdSPP");
		cariIdSPP.windowShow(Namaform);	
		cariIdSPP.afterpilPen= function(){
			me.Get_DataSPP();
		};
	},
	
	Get_DataSPP: function(){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_cover';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=Get_DataSPP',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				document.body.style.overflow='auto';	
				delElem(cover);					
				if(resp.err==''){
					me.Get_DataSPP_After(resp.content);									
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	Get_DataSPP_After: function(konten){
		var me=this;
		if(me.IdSPPTemp != 0)angka = 15000;
		DataPengaturan.Set_cekDcID_val("nomor_spp",konten.nomor_spp);	
		DataPengaturan.Set_cekDcID_val("jenis_tagihan",konten.jenis_tagihan);	
		DataPengaturan.Set_cekDcID_val("uraian",konten.uraian);		
		DataPengaturan.Set_cekDcID_val("nama_penerima_uang",konten.nama_penerima_uang);		
		DataPengaturan.Set_cekDcID_val("bank_penerima_uang",konten.bank_penerima_uang);		
		DataPengaturan.Set_cekDcID_val("rek_penerima_uang",konten.rek_penerima_uang);		
		DataPengaturan.Set_cekDcID_val("npwp_penerima_uang",konten.npwp_penerima_uang);	
		DataPengaturan.Set_cekDcID_val("refid_ttd_spm",konten.refid_ttd_spm);	
		me.Get_PenandatanganSPM();	
		me.Get_RincianSPM();	
		if(me.JnsSPP == "1")me.tabelPotonganPajak();
		me.getNomorSPM();
	},
	
	getNomorSPM: function(){
		var tgl_spm = DataPengaturan.cekDcID_val("tgl_spm");
		var me = this;
		
		if(tgl_spm != ''){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=getNomorSPM',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						DataPengaturan.Set_cekDcID_val("nomor_spm_no",resp.content.nomor);								
						DataPengaturan.Set_cekDcID_val("nomor_spm_ket",resp.content.keterangan);					
					}else{
						alert(resp.err);
					}
				}
			});	
		}
		
	},
	
	getInformasi_jmlTrsd: function(){
		var me = this;
		
		//if(tgl_spp != ''){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=getInformasi_jmlTrsd',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
							document.getElementById("informasi_jmlTrsd").innerHTML = resp.content;									
					}else{
						alert(resp.err);
					}
				}
			});	
		//}
		
		
		setTimeout(function myFunction() {me.getInformasi_jmlTrsd()},8000);	
	},
	
	tabelPotonganPajak: function(status=1){
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelPotonganPajak&status='+status,
			success: function(data) {	
				var resp = eval('(' + data + ')');
				document.body.style.overflow='auto';	
				delElem(cover);					
				if(resp.err==''){
					document.getElementById('tbl_potongan_pajak').innerHTML = resp.content.tabel;
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	tabelRetensiDenda: function(status=1){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRetensiDenda&status='+status,
			success: function(data) {	
				var resp = eval('(' + data + ')');
				document.body.style.overflow='auto';	
				delElem(cover);					
				if(resp.err==''){
					document.getElementById('tbl_retensiDenda').innerHTML = resp.content.tabel;
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	PilihPotonganPajak: function(nonya){
		var me = this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=PilihPotonganPajak&nonya'+nonya,
			success: function(data) {	
				var resp = eval('(' + data + ')');
				document.body.style.overflow='auto';	
				delElem(cover);					
				if(resp.err==''){
					
				}else{
					alert(resp.err);
				}
			}
		});	
		
		me.tabelPotonganPajak();
	},
	
	CariPotongan: function(){
		var me=this;
		var IdSPPnya = document.getElementById("IdSPP").value;
		cariRekeningPajak.windowShow(IdSPPnya);
		cariRekeningPajak.GetData_After= function(){
			me.Get_DataPotonganSPM();
		};
	},
	
	Get_DataPotonganSPM: function(){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_cover';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=Get_DataPotonganSPM',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				document.body.style.overflow='auto';	
				delElem(cover);					
				if(resp.err==''){
					DataPengaturan.Set_cekDcID_val("koderek",resp.content.koderek);								
					DataPengaturan.Set_cekDcID_INNER("uraian_rekening_"+resp.content.Id,resp.content.uraian_rekening);		
					DataPengaturan.Set_cekDcID_INNER("uraian_ket_"+resp.content.Id,resp.content.uraian_ket);	
					DataPengaturan.Set_cekDcID_INNER("jumlahnya_"+resp.content.Id,resp.content.jumlahnya);	
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	JumlahBiaya: function(Ulang=0){
		var me = this;
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=JumlahBiaya',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					DataPengaturan.Set_cekDcID_val("jml_yg_dibayar",resp.content);
					if(Ulang == 1)setTimeout(function myFunction() {me.JumlahBiaya(1)},5000);
				}else{
					alert(resp.err);
				}
			}
		});	
		
	},
	
	Get_RincianSPM: function(){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_cover';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=Get_RincianSPM',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				document.body.style.overflow='auto';	
				delElem(cover);					
				if(resp.err==''){
					DataPengaturan.Set_cekDcID_INNER("rincian_spm",resp.content);								
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	Get_PenandatanganSPM: function(formnya=''){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_cover';
		addCoverPage2(cover,1,true,false);	
		
		if(formnya == "")formnya=this.formName;
		
		$.ajax({
			type:'POST', 
			data:$('#'+formnya).serialize(),
			url: this.url+'&tipe=Get_PenandatanganSPM',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				document.body.style.overflow='auto';	
				delElem(cover);					
				if(resp.err==''){
					DataPengaturan.Set_cekDcID_val("penandatanganan_nip",resp.content.penandatanganan_nip);				
					DataPengaturan.Set_cekDcID_val("penandatanganan_jabatan",resp.content.penandatanganan_jabatan);		
				}else{
					alert(resp.err);
				}
			}
		});	
	},
		
		
});
