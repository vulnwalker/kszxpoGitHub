var suratpermohonan_sp2d = new DaftarObj2({
	prefix : 'suratpermohonan_sp2d',
	url : 'pages.php?Pg=suratpermohonan_sp2d', 
	formName : 'suratpermohonan_sp2dForm',
	satuan_form : '0',//default js satuan
	loading: function(){
		//alert('loading');
		this.filterRender();
		this.topBarRender();
		/*this.daftarRender();
		this.sumHalRender();*/
	},
	
	filterRenderAfter : function(){
		var me = this;
		var DataBaru = document.getElementById("databaru").value ;
		var JnsSPP = document.getElementById("haljns_sppnya").value ;
		
		DataPengaturan.nyalakandatepicker2();	
		me.Get_DataSPP();	
		me.getNomorSP2D();
		if(JnsSPP == "2")me.GetNomorBKU();	
			
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
	
	CariIdSPP: function(){
		var me = this;
		var Namaform = me.formName;
		me.IdSPPTemp=DataPengaturan.cekDcID_val("IdSPP");
		cariIdSPP.windowShow(Namaform, 'sp2d');	
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
		if(konten.Id != null){
			DataPengaturan.Set_cekDcID_val("nomor_spm",konten.nomor_spm);	
			DataPengaturan.Set_cekDcID_val("nilai_spm",konten.nilai_spm);	
			DataPengaturan.Set_cekDcID_val("potongan_spm",konten.potongan_spm);	
			DataPengaturan.Set_cekDcID_val("ygdibayar_spm",konten.ygdibayar_spm);	
			DataPengaturan.Set_cekDcID_val("uraian",konten.uraian);		
			if(konten.refid_ttd_sp2d != null)DataPengaturan.Set_cekDcID_val("refid_bank",konten.refid_bank);		
			if(konten.refid_ttd_sp2d != null)DataPengaturan.Set_cekDcID_val("refid_ttd_sp2d",konten.refid_ttd_sp2d);	
		}		
		suratpermohonan_spm.Get_PenandatanganSPM(me.formName);	
		me.getNomorSP2D();
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
	
	getNomorSP2D: function(){
		var me = this;
				
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=getNomorSP2D',
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
					DataPengaturan.Set_cekDcID_val("nomor_sp2d_no",resp.content.no);									
					DataPengaturan.Set_cekDcID_val("nomor_sp2d_ket",resp.content.ket);									
				}else{
					alert(resp.err);
				}
			}
		});	
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
	
	GetNomorBKU: function(){
		var me=this;
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=GetNomorBKU',
			success: function(data) {	
				var resp = eval('(' + data + ')');				
				if(resp.err==''){
					$("#nomor_bku").val(resp.content);				
				}else{
					alert(resp.err);
				}
			}
		});	
		setTimeout(function myFunction() {me.GetNomorBKU();},10000);
		
	},
		
});
