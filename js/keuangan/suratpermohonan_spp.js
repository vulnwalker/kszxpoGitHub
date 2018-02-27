var suratpermohonan_spp = new DaftarObj2({
	prefix : 'suratpermohonan_spp',
	url : 'pages.php?Pg=suratpermohonan_spp', 
	formName : 'suratpermohonan_sppForm',
	satuan_form : '0',//default js satuan
	loading: function(){
		this.topBarRender();
		this.filterRender();	
	},
	
	filterRenderAfter : function(){
		var me = this;
		var DataBaru = document.getElementById("databaru").value ;
		var jns_spp = document.getElementById("jns_spp").value ;
		
		DataPengaturan.nyalakandatepicker();
		DataPengaturan.nyalakandatepicker3();
		me.getNomorSPP_saja();
		me.getInformasi_jmlTrsd();
		
		if(DataBaru == "2"){
			me.GetNomorTagihan();
			me.GetData_Penerima();
		}
		
		switch(jns_spp){
			case "1":
				me.tabelRekening();
			break;
			case "2":
				me.tabelRekening_SPPUP();
			break;
		}		
	},
	
	TabelDokumen: function(){
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=TabelDokumen',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('tbl_dokumen').innerHTML = resp.content;
				}else{
					alert(resp.err);
				}
			}
		});	
		
		//setTimeout(function myFunction() {pemasukan_ins.CekSesuai()},1000);
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
		cariIdPenerima.windowShow("SPP");	
		cariIdPenerima.GetData_After= function(){
			me.GetData_AfterIdPenerimaan();
		};
	},
	
	GetData_AfterIdPenerimaan: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'Form').serialize(),
			url: this.url+'&tipe=GetData_AfterIdPenerimaan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err==''){
					$("#id_penerimaan").val(resp.content.id_penerimaan);
					me.tabelRekening();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	tabelRekening: function(hapus = 1){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRekening&del='+hapus,
			success: function(data) {	
				var resp = eval('(' + data + ')');	
				document.body.style.overflow='auto';
				delElem(cover);				
				if(resp.err==''){
					document.getElementById('tbl_rekening').innerHTML = resp.content.tabel;
				}else{
					alert(resp.err);
				}
			}
		});	
		
		//setTimeout(function myFunction() {pemasukan_ins.CekSesuai()},1000);
	},
	
	BaruRekening: function(){
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=InsertRekening',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					if(resp.content == 1){
						var me = this ;
						suratpermohonan_spp.tabelRekening(0);
					}
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	updKodeRek: function(){
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=updKodeRek',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('koderekeningnya_'+resp.content.idrek).innerHTML = resp.content.koderek;
					document.getElementById('jumlanya_'+resp.content.idrek).innerHTML = resp.content.jumlahnya;
					document.getElementById('option_'+resp.content.idrek).innerHTML = resp.content.option;
					
					suratpermohonan_spp.tabelRekening();
					//document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	JADIKANINPUT: function(idna){
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=jadiinput&idrekeningnya='+idna,
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						document.getElementById('koderekeningnya_'+resp.content.idrek).innerHTML = resp.content.koderek;
						document.getElementById('jumlanya_'+resp.content.idrek).innerHTML = resp.content.jumlahnya;
						document.getElementById('option_'+resp.content.idrek).innerHTML = resp.content.option;
						document.getElementById('atasbutton').innerHTML = resp.content.atasbutton;
						//document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
					}else{
						alert(resp.err);
					}
				}
			});	
	},
		
	jadiinput: function(idna){
		this.tabelRekening();
		setTimeout(function myFunction() {suratpermohonan_spp.JADIKANINPUT(idna)},100);
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
		var konfrim = confirm("Hapus Data Rekening ?");
		if(konfrim == true){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=HapusRekening&idrekei='+isi,
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						//document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
						suratpermohonan_spp.tabelRekening();
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
		idna = document.getElementById(this.prefix+'_idplh').value;
		
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=SimpanSemua',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
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
		
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=BatalSemua',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
							window.close();
							window.opener.location.reload();									
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	
	getNomorSPP: function(){
		var tgl_spp = DataPengaturan.cekDcID_val("tgl_spp");
		var me = this;
		
		if(tgl_spp != ''){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=getNomorSPP',
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
							document.getElementById("nomor_spp").value = resp.content;									
					}else{
						alert(resp.err);
					}
				}
			});	
		}
		
		
		//setTimeout(function myFunction() {me.getNomorSPP()},8000);	
	},
	
	getInformasi_jmlTrsd: function(){
		var me = this;
		var modul_penerima = DataPengaturan.cekDcID_val("modul_penerima");
		
		if(modul_penerima == 1){
			if(tgl_spp != ''){
				$.ajax({
					type:'POST', 
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=getInformasi_jmlTrsd',
					success: function(data) {	
						var resp = eval('(' + data + ')');			
						if(resp.err==''){
							DataPengaturan.Set_cekDcID_INNER("informasi_jmlTrsd",resp.content);
						}else{
							alert(resp.err);
						}
					}
				});	
			}			
			setTimeout(function myFunction() {me.getInformasi_jmlTrsd()},8000);	
		}
		
	},
		
	Get_Tgl_nomorSPD:function(){
		var me=this;
						
		var cover = this.prefix+'_formcover';
		addCoverPage2(cover,999,true,false);	
		document.body.style.overflow='hidden';
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=Get_Tgl_nomorSPD',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				document.body.style.overflow='auto';
				if (resp.err ==''){		
					DataPengaturan.Set_cekDcID_val("tgl_spd",resp.content);
					me.After_Get_Tgl_nomorSPD();
				}else{
					alert(resp.err);
				}
		  	}
		});
				
	},
	
	After_Get_Tgl_nomorSPD:function(){
		var me=this;
		
		me.tabelRekening();	
	},
	
	cariTagihan:function(){
		var me=this;
		ref_tagihan.windowShow(me.formName);
		ref_tagihan.AfterGetPilData= function(){
			if(document.getElementById("refid_nomor_tagihan"))me.GetNomorTagihan();
		};
	},
	
	GetNomorTagihan:function(){
		var me=this;
						
		var cover = this.prefix+'_formcover';
		addCoverPage2(cover,999,true,false);	
		document.body.style.overflow='hidden';
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=GetNomorTagihan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				document.body.style.overflow='auto';
				if (resp.err ==''){		
					DataPengaturan.Set_cekDcID_val("nomor_tagihan",resp.content);
				}else{
					alert(resp.err);
				}
		  	}
		});	
	},
	
	tabelRekening_Ins:function(){
		var me=this;
						
		var cover = this.prefix+'_formcover';
		addCoverPage2(cover,999,true,false);	
		document.body.style.overflow='hidden';
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRekening_Ins',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				document.body.style.overflow='auto';
				if (resp.err ==''){		
					me.tabelRekening(0);
					me.cariNoSPDdet();
				}else{
					alert(resp.err);
				}
		  	}
		});	
	},
	
	tabelRekening_Save:function(Idnya){
		var me=this;
						
		var cover = this.prefix+'_formcover';
		addCoverPage2(cover,999,true,false);	
		document.body.style.overflow='hidden';
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRekening_Save&IdPilihnya='+Idnya,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				document.body.style.overflow='auto';
				if (resp.err ==''){		
					me.tabelRekening();
				}else{
					alert(resp.err);
				}
		  	}
		});	
	},
	
	tabelRekening_Del:function(Idnya){
		var me=this;
						
		var cover = this.prefix+'_formcover';
		addCoverPage2(cover,999,true,false);	
		document.body.style.overflow='hidden';
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRekening_Del&Idnya='+Idnya,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				document.body.style.overflow='auto';
				if (resp.err ==''){		
					me.tabelRekening();
				}else{
					alert(resp.err);
				}
		  	}
		});	
	},
	
	tabelRekening_Edit:function(Idnya){
		var me=this;
						
		var cover = this.prefix+'_formcover';
		addCoverPage2(cover,999,true,false);	
		document.body.style.overflow='hidden';
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRekening_Edit&Idnya='+Idnya,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				document.body.style.overflow='auto';
				if (resp.err ==''){		
					DataPengaturan.Set_cekDcID_INNER("jumlah_txt_"+Idnya,resp.content.jumlah);
					DataPengaturan.Set_cekDcID_INNER("Btn_Opt_Pil_"+Idnya,resp.content.Btn_Pilih);
					DataPengaturan.Set_cekDcID_INNER("btn_option",resp.content.btn_option);
				}else{
					alert(resp.err);
				}
		  	}
		});	
	},
	
	caripenerima:function(dari=1){
		var me=this;
		if(dari == 1){
			caribendahara_rekening.windowShow(me.formName);
			caribendahara_rekening.AfterGet_PilData= function(){
				me.GetData_Penerima();
			};
		}else{
			caripenerima.windowShow(me.formName);
			caripenerima.AfterGet_PilData= function(){
				me.GetData_Penerima();
			};
		}			
	},
	
	GetData_Penerima:function(){
		var me=this;
						
		var cover = this.prefix+'_formcover';
		addCoverPage2(cover,999,true,false);	
		document.body.style.overflow='hidden';
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=GetData_Penerima',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				document.body.style.overflow='auto';
				if (resp.err ==''){		
					DataPengaturan.Set_cekDcID_val("nama_penerima_uang",resp.content.nama);
					DataPengaturan.Set_cekDcID_val("alamat_penerima_uang",resp.content.alamat);
					DataPengaturan.Set_cekDcID_val("bank_penerima_uang",resp.content.bank);
					DataPengaturan.Set_cekDcID_val("rek_penerima_uang",resp.content.rekening);
					DataPengaturan.Set_cekDcID_val("npwp_penerima_uang",resp.content.npwp);
				}else{
					alert(resp.err);
				}
		  	}
		});	
	},
	
	cariNoSPDdet:function(){
		var me=this;
		
		carino_spd_det.windowShow(me.formName);
		carino_spd_det.windowSimpan_After= function(kode){
			$("#refid_nomor_spd").val(kode.refid_nomor_spd);
			$("#nomor_spd").val(kode.nomor_spd);
			$("#tgl_spd").val(kode.tgl_spd);
			me.tabelRekening();
		}			
	},
	
	GetData_RekSPD:function(){
		var me=this;
		var Id_spp_det = DataPengaturan.cekDcID_val("Id_spp_det");
			
		var cover = this.prefix+'_formcover';
		addCoverPage2(cover,999,true,false);	
		document.body.style.overflow='hidden';
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=GetData_RekSPD',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				document.body.style.overflow='auto';
				if (resp.err ==''){		
					DataPengaturan.Set_cekDcID_val("kode_kegiatan",resp.content.kode_kegiatan);
					DataPengaturan.Set_cekDcID_INNER("kodeRekening_Edit_"+Id_spp_det,resp.content.kode_rekening);
					DataPengaturan.Set_cekDcID_INNER("namaKeterangan_Edit_"+Id_spp_det,resp.content.keterangan);
					DataPengaturan.Set_cekDcID_INNER("pagu_Edit_"+Id_spp_det,resp.content.pagu);
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	getNomorSPP_saja: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formNomorSPP';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'Form').serialize(),
			url: this.url+'&tipe=getNomorSPP_saja',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err==''){
					$("#nomor_spp_no").val(resp.content.NomorSPP);
					$("#nomor_spp_ket").val(resp.content.NomorSPP_Ket);
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	getSisaSPD: function(IdSPD, IdRekSPP){
		var me= this;	
		err = IdSPD == ""?"Tidak Ada Nomor SPD !":"";
		
		if(err == ""){
			this.OnErrorClose = false	
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formNomorSPP';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.prefix+'Form').serialize(),
				url: this.url+'&tipe=getSisaSPD&IdSPDnya='+IdSPD+'&IdRekSPP='+IdRekSPP,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);		
					document.body.style.overflow='auto';
					if(resp.err==''){
						$("#sisa_spd_"+IdRekSPP).html(resp.content);
						document.getElementById("col_JML_"+IdRekSPP).style.textAlign = "right";
					}else{
						alert(resp.err);
					}
			  	}
			});
		}else{
			alert(err);
		}
		
	},
	
	tabelRekening_SPPUP: function(){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRekening_SPPUP',
			success: function(data) {	
				var resp = eval('(' + data + ')');	
				document.body.style.overflow='auto';
				delElem(cover);				
				if(resp.err==''){
					document.getElementById('tbl_rekening').innerHTML = resp.content;
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
		
		
});
