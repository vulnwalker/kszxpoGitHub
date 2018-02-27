var suratpermohonan_spp = new DaftarObj2({
	prefix : 'suratpermohonan_spp',
	url : 'pages.php?Pg=suratpermohonan_spp', 
	formName : 'suratpermohonan_sppForm',
	satuan_form : '0',//default js satuan
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
		
		setTimeout(function myFunction() {me.nyalakandatepicker()},1000);
		setTimeout(function myFunction() {me.TabelDokumen()},1000);
		setTimeout(function myFunction() {me.tabelRekening()},1000);
		setTimeout(function myFunction() {me.getNomorSPP()},1000);
		
		if(DataBaru == "1"){
			setTimeout(function myFunction() {me.getInformasi_jmlTrsd()},1000);
		}else if(DataBaru == "2"){
			var id_penerimaan = document.getElementById("id_penerimaan").value ;
			var refid_terima = document.getElementById("refid_terima").value ;
			setTimeout(function myFunction() {cariIdPenerima.pilPen(id_penerimaan, refid_terima, "&dari_hal=SPP");},100);
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
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRekening',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
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
	
	CariIdPenerimaan: function(){
		var me = this;
		cariIdPenerima.windowShow("SPP");	
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
		
		
		setTimeout(function myFunction() {me.getNomorSPP()},8000);	
	},
	
	getInformasi_jmlTrsd: function(){
		var me = this;
		
		if(tgl_spp != ''){
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
		}
		
		
		setTimeout(function myFunction() {me.getInformasi_jmlTrsd()},8000);	
	},
	
	
		
		
});
