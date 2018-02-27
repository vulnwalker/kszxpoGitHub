var form_pengeluarankas = new DaftarObj2({
	prefix : 'form_pengeluarankas',
	url : 'pages.php?Pg=form_pengeluarankas', 
	formName : 'form_pengeluarankasForm',
	loading: function(){
		this.topBarRender();
		this.filterRender();	
	},
	
	filterRenderAfter : function(){
		var me = this;
		DataPengaturan.nyalakandatepicker2();	
		me.Form_Rekening(1);		
		me.Form_Potongan();		
		//me.Form_Rekening(2);		
		me.Form_PenerimaCaraBayar();		
	},
	
	CariRek: function(Id){
		cariRekening.windowShow(Id, "form_pengeluaran",Id);
	},
	
	Form_Rekening: function(GetRek=1, DelData=1){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=Form_Rekening&GetRek='+GetRek+'&DelData='+DelData,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){					
					switch(GetRek){
						case 1:$("#Form_Rekening").html(resp.content);break;
						case 2:$("#Form_Potongan").html(resp.content);break;
					}
					me.Get_JumlahDiBayar();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	Form_RekeningBaru: function(GetRek=1){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=Form_RekeningBaru&GetRek='+GetRek,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){					
					me.Form_Rekening(GetRek,0);
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	FormRekening_Simpan: function(Idnya, GetRek){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=FormRekening_Simpan&Idnya='+Idnya,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){					
					me.Form_Rekening(GetRek);
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	FormRekening_Ubah: function(Idnya, GetRek){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=FormRekening_Ubah&Idnya='+Idnya+'&GetRek='+GetRek,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){	
					document.getElementById("kd_Rek_"+Idnya).innerHTML = resp.content.rekening;
					document.getElementById("kd_Jumlah_"+Idnya).innerHTML = resp.content.jumlah;
					document.getElementById("option_"+Idnya).innerHTML = resp.content.option;
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	FormRekening_Hapus: function(Idnya, GetRek){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=FormRekening_Hapus&Idnya='+Idnya,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){					
					me.Form_Rekening(GetRek);
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	Form_PenerimaCaraBayar: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=Form_PenerimaCaraBayar',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){
					$("#Form_PenerimaCaraBayar").html(resp.content);
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	Get_JumlahDiBayar: function(){
		var me= this;	
		
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=Get_JumlahDiBayar',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if(resp.err == ""){
					document.getElementById("fm_jumlah_yang_dibayar").value=resp.content;
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	CariPotongan: function(){
		var me=this;
		var IdSPPnya = document.getElementById(me.prefix+"_idplh").value;
		cariRekeningPajak.windowShow(IdSPPnya, me.formName);
		cariRekeningPajak.GetData_After= function(){
			me.Form_PotonganBaru();
		};
	},
	
	Form_Potongan: function(DelData=1){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=Form_Potongan&DelData='+DelData,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){		
					$("#Form_Potongan").html(resp.content);		
					me.Get_JumlahDiBayar();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	Form_PotonganBaru: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=Form_PotonganBaru',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){		
					me.Form_Potongan();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	Form_PotonganHapus: function(Idnya){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=Form_PotonganHapus&Idnya='+Idnya,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){		
					me.Form_Potongan();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	Form_PotonganUbah: function(Idnya){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=Form_PotonganUbah&Idnya='+Idnya,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){		
					me.Form_Potongan();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanSemua: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=SimpanSemua',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){		
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
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formRek';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+me.formName).serialize(),
			url: this.url+'&tipe=BatalSemua',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				document.body.style.overflow='auto';
				if(resp.err == ""){		
					alert("Data Berhasil Di Batalkan !");
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
	
	
});
