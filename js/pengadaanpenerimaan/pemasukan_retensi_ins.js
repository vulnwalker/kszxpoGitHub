var pemasukan_retensi_ins = new DaftarObj2({
	prefix : 'pemasukan_retensi_ins',
	url : 'pages.php?Pg=pemasukan_retensi_ins', 
	formName : 'pemasukan_retensi_insForm',
	
	loading: function(){
		this.topBarRender();
		this.filterRender();
	
	},
	
	filterRenderAfter : function(){
		var me = this;
		me.tabelRekening();		
		setTimeout(function myFunction() {me.DetailRetensi_Form()},100);
		setTimeout(function myFunction() {me.Tabel_DetailRetensi_Form()},100);
		setTimeout(function myFunction() {pemasukan_ins.nyalakandatepicker()},100);
		setTimeout(function myFunction() {pemasukan_ins.nyalakandatepicker2()},100);
		setTimeout(function myFunction() {me.Get_IdRetensi()},100);
		pemasukan_ins.formName=me.formName;
		pemasukan_ins.TglNomorDokumenAfter= function(){
			document.getElementById('TombolPilih').innerHTML = '';
		};
	},
	
	CariBarang: function(){
		cariBarang.windowShow(this.formName);
		cariBarang.Bar = '2';
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
			data:$('#pemasukan_retensi_ins_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					me.Close();
					me.AfterSimpan();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
		
	Baru: function(namaForm=''){	
		
		var me = this;
		var err='';
		
		if(namaForm=="")namaForm=me.formName;
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+namaForm).serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ""){						
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);	
						delElem(cover);	
					}
			  	}
			});
		
		}else{
		 	alert(err);
		}
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
				me.sumHalRender();
		  	}
		});
	},
	
	Edit:function(namaForm=''){
		var me = this;
		errmsg = this.CekCheckbox();
		
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			if(namaForm=="")namaForm=me.formName;
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+namaForm).serialize(),
			//	data:$('#ref_ruang_form').serialize(),
				url: this.url+'&tipe=formEdit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						//document.getElementById('kode1').focus();	
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
	Hapus:function(){
		
		var me =this;
		if(document.getElementById(this.prefix+'_jmlcek')){
			var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;	
		}else{
			var jmlcek = '';
		}
		
		if(jmlcek ==0){
			alert('Data Belum Dipilih!');
		}else{
			if(confirm('Hapus '+jmlcek+' Data ?')){
				//document.body.style.overflow='hidden'; 
				var cover = this.prefix+'_hapuscover';
				addCoverPage2(cover,1,true,false);
				$.ajax({
					type:'POST', 
					//data:$('#'+this.formName).serialize(),
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=hapus',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');		
						delElem(cover);		
						if(resp.err==''){							
							me.Close();
							me.refreshList(true)
						}else{
							alert(resp.err);
						}							
						
				  	}
				});
				
			}	
		}
	},
	
	
	
	Close1:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKA';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close2:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	tabelRekening: function(hapus = 1){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=tabelRekening&HapusData='+hapus,
			success: function(data) {	
				var resp = eval('(' + data + ')');
				
				delElem(cover);
				document.body.style.overflow='auto';		
				if(resp.err==''){
					document.getElementById('tbl_rekening').innerHTML = resp.content.tabel;
					//document.getElementById('totalbelanja23').innerHTML = resp.content.jumlah;
					if(document.getElementById('koderek')){
						document.getElementById('koderek').focus();
						document.getElementById('atasbutton').innerHTML = resp.content.atasbutton;
					}
					me.TotalBelanja();
				}else{
					alert(resp.err);
				}
			}
		});	
		
	},
	
	BaruRekening: function(){
		var me = this;
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=InsertRekening',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					if(resp.content == 1){
						me.tabelRekening(0);
					}
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
		var konfrim = confirm("Hapus Data Rekening ?");
		var me=this;
		if(konfrim == true){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=HapusRekening&idrekei='+isi,
				success: function(data) {	
					var resp = eval('(' + data + ')');			
					if(resp.err==''){
						//document.getElementById('namaakun_'+resp.content.idrek).innerHTML = resp.content.namarekening;
						me.tabelRekening();
					}else{
						alert(resp.err);
					}
				}
			});	
		}
		
	},
	
	updKodeRek: function(){
		var me=this;
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
					
					me.tabelRekening();
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
		var me=this;
		me.tabelRekening();
		setTimeout(function myFunction() {me.JADIKANINPUT(idna)},100);
	},
	
	TotalBelanja: function(){
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=TotalBelanja',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				
				delElem(cover);
				document.body.style.overflow='auto';		
				if(resp.err==''){
					document.getElementById('totalbelanja23').innerHTML = resp.content.jumlah;					
				}else{
					alert(resp.err);
				}
			}
		});	
		
	},
		
	DetailRetensi_Form: function(){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=DetailRetensi_Form',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				
				delElem(cover);
				document.body.style.overflow='auto';		
				if(resp.err==''){
					document.getElementById('databarangnya').innerHTML = resp.content;					
				}else{
					alert(resp.err);
				}
			}
		});	
		
	},
	
	UbahRincianRetensi:function(Id){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=Edit_DetailRetensi_Form&IdRetensi='+Id,
			success: function(data) {	
				var resp = eval('(' + data + ')');
				
				delElem(cover);
				document.body.style.overflow='auto';		
				if(resp.err==''){
					document.getElementById('databarangnya').innerHTML = resp.content;					
				}else{
					alert(resp.err);
				}
			}
		});
	},
	
	cariBarangBI: function(){
		var namaform = this.formName;
		var me=this;
		//alert(namaform);
		var unitkerja = document.getElementById('unitkerja').value;
		
		if(unitkerja != '-'){
			cariIDBI.windowShow(namaform,2);		
			cariIDBI.AfterPilBI2= function(){
				if(document.getElementById("id_bukuinduk"))me.getDataBI();
			};
		}else{
			alert("Unit Kerja Belum Di Pilih !");
		}
	},
	
	getDataBI: function(){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=getDataBI',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				
				delElem(cover);
				document.body.style.overflow='auto';		
				if(resp.err==''){
					document.getElementById('SUBUNIT').value = resp.content.subunit;					
					document.getElementById('kodebarang').value = resp.content.kode_barang;					
					document.getElementById('namabarang').value = resp.content.nm_barang;					
					document.getElementById('noreg').value = resp.content.noreg;					
					document.getElementById('tahun').value = resp.content.thn_perolehan;					
					document.getElementById('keteranganbarang').value = resp.content.keteragan;					
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	SimpanDet: function(){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=SimpanDet',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				
				delElem(cover);
				document.body.style.overflow='auto';		
				if(resp.err==''){
					alert("Rincian Retensi Berhasil Di Simpan !");	
					me.DetailRetensi_Form();	
					me.Tabel_DetailRetensi_Form();	
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	Tabel_DetailRetensi_Form: function(){
		var me=this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=Tabel_DetailRetensi_Form',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				
				delElem(cover);
				document.body.style.overflow='auto';		
				if(resp.err==''){
					document.getElementById('rinciandatabarangnya').innerHTML = resp.content;					
				}else{
					alert(resp.err);
				}
			}
		});	
		
	},
	
	HapusRincianRetensi: function(IdDet){
		var me=this;
		
		var tanya = confirm("Hapus Rincian Retensi Barang ?");
		if(tanya == true){
			this.OnErrorClose = false	
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);	
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=HapusRincianRetensi&IdDet='+IdDet,
				success: function(data) {	
					var resp = eval('(' + data + ')');
					
					delElem(cover);
					document.body.style.overflow='auto';		
					if(resp.err==''){
						alert("Rincian Retensi Berhasil Di Hapus !");	
						me.DetailRetensi_Form();	
						me.Tabel_DetailRetensi_Form();	
					}else{
						alert(resp.err);
					}
				}
			});	
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
					alert("Data Retensi Berhasil Di Simpan !");						
					window.close();
					window.opener.location.reload();
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	
	BatalSemua: function(){
		var me=this;
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
				delElem(cover);
				document.body.style.overflow='auto';			
				if(resp.err==''){
						window.close();
						window.opener.location.reload();									
				}else{
					alert(resp.err);
				}
			}
		});	
	},
	
	Get_IdRetensi: function(){
		var me=this;
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=Get_IdRetensi',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					document.getElementById('idretensi').value = resp.content;
					setTimeout(function myFunction() {me.Get_IdRetensi()},10000);				
				}else{
					alert(resp.err);
				}
			}
		});		
	},
	
	CariDokumenKontrak: function(){
		ref_dokumen_kontrak.windowShow(this.formName, 1);
	},
});
