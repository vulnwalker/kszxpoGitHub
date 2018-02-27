var pemasukan_retensiSKPD2 = new SkpdCls({
	prefix : 'pemasukan_retensiSKPD2', 
	formName: 'pemasukan_retensiForm',
	
	pilihUrusanfter : function(){pemasukan_retensi.refreshList(true);},
	pilihBidangAfter : function(){pemasukan_retensi.refreshList(true);},
	pilihUnitAfter : function(){pemasukan_retensi.refreshList(true);},
	pilihSubUnitAfter : function(){pemasukan_retensi.refreshList(true);},
	pilihSeksiAfter : function(){pemasukan_retensi.refreshList(true);}
});

var pemasukan_retensi = new DaftarObj2({
	prefix : 'pemasukan_retensi',
	url : 'pages.php?Pg=pemasukan_retensi', 
	formName : 'pemasukan_retensiForm',
	pesan_eror:'',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	
	},
	
	CariBarang: function(){
		cariBarang.windowShow(this.formName);
		cariBarang.Bar = '2';
	},
	
	Simpan: function(){ //Simpan Validasi
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					me.Close();
					me.AfterSimpan();
					if(resp.content == '1'){
						alert("Data Berhasil di Validasi !");
					}else{
						alert("Berhasil Membatalkan Validasi !");
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
		
	Baru: function(namaForm=''){	
		
		var me = this;
		//errmsg = this.CekCheckbox();
		errmsg = '';
		skpd = document.getElementById('ver_skpd').value ;
		c1n = document.getElementById('pemasukan_retensiSKPD2fmURUSAN');
		cn = document.getElementById('pemasukan_retensiSKPD2fmSKPD');
		dn = document.getElementById('pemasukan_retensiSKPD2fmUNIT');
		en = document.getElementById('pemasukan_retensiSKPD2fmSUBUNIT');
		e1n = document.getElementById('pemasukan_retensiSKPD2fmSEKSI');
		
		
		if(c1n != '' && skpd != 1){
			if(errmsg == '' && c1n.value == '0')errmsg = "URUSAN Belum di Pilih ! ";
		}
		if(errmsg == '' && cn.value == '00')errmsg = "BIDANG Belum di Pilih ! ";
		if(errmsg == '' && dn.value == '00')errmsg = "SKPD Belum di Pilih ! ";
		if(errmsg == '' && en.value == '00')errmsg = "UNIT Belum di Pilih ! ";
		if(errmsg == '' && e1n.value == '000')errmsg = "SUB UNIT Belum di Pilih ! ";
		
		if(errmsg ==''){ 
			//var box = this.GetCbxChecked();
			
			//alert(box.value);
					
			var aForm = document.getElementById(this.formName);		
			aForm.action= this.url+'_ins&YN=1';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
			aForm.target='_blank';
			aForm.submit();	
			aForm.target='';
		}else{
				alert(errmsg);
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
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=CekEdit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);
					document.body.style.overflow='auto';
					if(resp.err == ''){
						var box = me.GetCbxChecked();
						var aForm = document.getElementById(me.formName);		
						aForm.action= me.url+'_ins&YN=2';
						aForm.target='_blank';
						aForm.submit();	
						aForm.target='';
					}else{
						alert(resp.err);
					}			
					
					//setTimeout(function myFunction() {pemasukan.jam()},100);	
					//me.AfterFormBaru();
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
	
	GandakanPenerimaan: function(datanya){
		var me = this;
		var tanya = confirm("Gandakan Data Rincian Penerimaan ?");
		if(tanya == true){
				var cover = this.prefix+'_formcover2';
				document.body.style.overflow='hidden';			
				addCoverPage2(cover,999,true,false);			
				
				$.ajax({
					type:'POST', 
					data:$('#'+this.formName).serialize(),
				  	url: this.url+'&tipe=DataCopy&datakopi='+datanya,
				  	success: function(data) {		
						var resp = eval('(' + data + ')');
						delElem(cover);				
						if(resp.err ==  ""){							
							me.loading();	
						}else{													
							alert(resp.err);
						}
					}
				});			
		}
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
						alert(resp.err);
						me.Close();
					}			
					
					//setTimeout(function myFunction() {pemasukan.jam()},100);	
					//me.AfterFormBaru();
			  	}
			});
		}else{
			alert(errmsg);
		}
		
	},
	
	PostingForm:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=PostingForm',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);
						me.Close();
					}			
					
					//setTimeout(function myFunction() {pemasukan.jam()},100);	
					//me.AfterFormBaru();
			  	}
			});
		}else{
			alert(errmsg);
		}
		
	},
	
	SimpanPosting: function(){ //Simpan Validasi
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=Cek_SimpanPosting',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					var tanya = confirm(resp.content.pesan);
					if(tanya == true){
						var tot_jmlbarang = document.getElementById("tot_jmlbarang").value;
						if(resp.content.tanya != '3'){
							for(i=0;i<tot_jmlbarang;i++){
								var IdRetensiDet = document.getElementById("id_barangnya_"+i).value;
								me.SavePosting(IdRetensiDet);
							}							
						}else{
							me.BatalkanPosting();
						}
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	BatalkanPosting: function(){ //Simpan Validasi
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=BatalkanPosting',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					setTimeout(function myFunction() {me.GetPersen(resp.content.maxpersen,1);},10);	 
					if(resp.content.next == 1)me.BatalkanPosting();				
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SavePosting: function(IdRetensiDet){ //Simpan Validasi
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=SimpanPosting&IdRetensiDet='+IdRetensiDet,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					setTimeout(function myFunction() {me.GetPersen(resp.content.maxpersen);},10);	 				
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	UpdatePosting: function(kondisi){ //Simpan Validasi
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=UpdatePosting&kondisi='+kondisi,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					if(kondisi=='1'){
						alert("Berhasil Memposting Data !");
					}else{
						alert("Berhasil Membatalkan Posting Data !");
					}
					me.Close();
					me.refreshList(true); 				
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	GetPersen: function(maxpersen, mundur=0){
		var me=this;
		if(maxpersen >= 100){
			document.getElementById("statustxt1").style.width = 100+"%"; 
			document.getElementById("statustxt1").innerHTML = 100+"%";
			setTimeout(function myFunction() {me.AfterGetPersen(1);},50);
		}else{
			document.getElementById("statustxt1").style.width = Math.round(maxpersen)+"%"; 
			document.getElementById("statustxt1").innerHTML = Math.round(maxpersen)+"%";
			if(mundur == 1 && maxpersen==0)setTimeout(function myFunction() {me.AfterGetPersen(0);},50);
		}	
	},
	
	AfterGetPersen: function(kondisi){
		var me=this;
		
		me.UpdatePosting(kondisi);
	},
	
	Laporan: function(){
		var me=this;
		
		pemasukan_retensi_baru.formName = me.formName;
		pemasukan_retensi_baru.nm_prefix = me.prefix;
		pemasukan_retensi_baru.Laporan();
	},
	
});
