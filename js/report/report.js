

var report = new DaftarObj2({
	prefix : 'report',
	url : 'pages.php?Pg=report', 
	//formName : 'report_form',
	formName : 'reportForm',
	//report_form
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		//this.sumHalRender();
	
	},
	
	find: function(){
		var me = this;
		me.refreshList(true);	
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

	chooserShow: function(id){
		var me = this;
		
		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=chooserShow',
		  type : 'POST',
		  data:{ id : id
		  		},
		  success: function(data) {
			popupSource.windowShow();
		  }
		});

	},

	Baru: function(){	
		
		var me = this;
		var err='';
		/*else if($("#cmbModul").val() == ''){
			err = "Pilih Modul";
		}*/
		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						cmbAplikasi : $("#cmbAplikasi").val(),
					    id_modul : $("#cmbModul").val(),
					    id_kategori : $("#kategoriFilter").val(),
					  },
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;
					me.AfterFormBaru();
					$('#tanggal_update').datepicker({
						    dateFormat: 'dd-mm-yy',
							showAnim: 'slideDown',
						    inline: true,
							showOn: "button",
     						buttonImage: "images/calendar.gif",
      						buttonImageOnly: true,
							changeMonth: true,
      						changeYear: true,
							buttonText : '',
							defaultDate: +0
					});	
					$("#tanggal_update").datepicker({ dateFormat: "dd-mm-yy" });
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	

		Lihat: function(url){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		

			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						cmbUrusan : $("#cmbUrusan").val(),
					    cmbBidang : $("#cmbBidang").val(),
					    cmbSKPD : $("#cmbSKPD").val(),
					    cmbUnit : $("#cmbUnit").val(),
					    cmbSubUnit : $("#cmbSubUnit").val(),
					    url : url,
					  },
			  	url: this.url+'&tipe=formLihat',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;
					me.AfterFormBaru();
					$('#cariTanggal').datepicker({
						    dateFormat: 'dd-mm-yy',
							showAnim: 'slideDown',
						    inline: true,
							showOn: "button",
     						buttonImage: "images/calendar.gif",
      						buttonImageOnly: true,
							changeMonth: true,
      						changeYear: true,
							buttonText : '',
							defaultDate: +0
					});	
					$("#cariTanggal").datepicker({ dateFormat: "dd-mm-yy" });
					me.injectUrl();
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	

	injectUrl:function(){	
		var urlAwal = $("#urlAwal").val();
        
        var str = $("#cariTanggal").val();
        
        var res = str.split("-");

        var tanggal = res[2] +"-" + res[1] +"-"+ res[0];
		
		var kota = $("#kota").val();

		var urlPost = urlAwal + "&tanggalCetak="+tanggal +"&kota="+kota;
		$("#postUrl").attr('href',urlPost);
         


		
	},
	
	
	ModulBaru: function(){	
		
		var me = this;
		var err='';
		if($("#cmbPemda").val() == ''){
			err = "Pilih Pemda";
		}else if($("#cmbreport").val() == ''){
			err = "Pilih report";
		}
		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#report_form').serialize(),
			  	url: this.url+'&tipe=formBaruModul',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	
	SubModulBaru: function(){	
		
		var me = this;
		var err='';
		/*if($("#cmbPemda").val() == ''){
			err = "Pilih Pemda";
		}else if($("#cmbreport").val() == ''){
			err = "Pilih report";
		}else if($("#cmbModul").val() == ''){
			err = "Pilih Modul";
		}*/
		if($("#cmbModulForm").val() == ''){
			err = "Pilih Modul";
		}
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
			  	url: this.url+'&tipe=formBaruSubModul',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	
	reportBaru: function(){	
		
		var me = this;
		var err='';

		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#report_form').serialize(),
			  	url: this.url+'&tipe=formBarureport',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},

ModulEdit: function(){	
		
		var me = this;
		var err='';
		if($("#cmbModul").val() == ''){
			err = "Pilih Modul";
		}
		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#report_form').serialize()+"&idModul="+$("#cmbModul").val(),
			  	url: this.url+'&tipe=formBaruModul',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},

SubModulEdit: function(){	
		
		var me = this;
		var err='';
		if($("#cmbSubModul").val() == ''){
			err = "Pilih Sub Modul";
		}
		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#report_form').serialize(),
			  	url: this.url+'&tipe=formBaruSubModul',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},

    
	
reportEdit: function(){	
		
		var me = this;
		var err='';
		if($("#cmbreport").val() == ''){
			err = "Pilih report";
		}
		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#report_form').serialize()+"&idreport="+$("#cmbreport").val(),
			  	url: this.url+'&tipe=formBarureport',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
    	
	
	Edit:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if($("#cmbAplikasi").val() == ""){
			errmsg = "Pilih Aplikasi";
		} 
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#reportForm').serialize(),
				url: this.url+'&tipe=formEdit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						me.AfterFormEdit(resp);
						me.reloadTabel();
						
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
	
	
	Progres:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#reportForm').serialize(),
				url: this.url+'&tipe=formProgres',
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
	
	
	Check:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#reportForm').serialize(),
				url: this.url+'&tipe=formCheck',
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
	
	
	
	pemdaChanged:function(){
		

				$.ajax({
					type:'POST', 
					data:{
							idPemda : $("#cmbPemda").val()	
					},
					url: this.url+'&tipe=pemdaChanged',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');				
						if(resp.err==''){							
							 document.getElementById('cmbreport').innerHTML = resp.content.cmbreport;			
							 document.getElementById('cmbModul').innerHTML = resp.content.cmbModul;	
							 document.getElementById('cmbSubModul').innerHTML = resp.content.cmbSubModul;			
						}else{
							alert(resp.err);
						}							
						
				  	}
				});
				
		
	},
	
	
	reportChanged:function(){
		

				$.ajax({
					type:'POST', 
					data:{
							idreport : $("#cmbreport").val(),
							cmbreport : $("#cmbreport").val()	
					},
					url: this.url+'&tipe=reportChanged',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');				
						if(resp.err==''){							
							 document.getElementById('cmbModul').innerHTML = resp.content.cmbModul;			
							 document.getElementById('cmbSubModul').innerHTML = resp.content.cmbSubModul;			
						}else{
							alert(resp.err);
						}							
						
				  	}
				});
				
		
	},
	
	modulChanged:function(){
		

				$.ajax({
					type:'POST', 
					data:{
							id_aplikasi : $("#cmbAplikasi").val(),
							id_modul : $("#cmbModulForm").val(),
					},
					url: this.url+'&tipe=modulChanged',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');				
						if(resp.err==''){								
							 document.getElementById('cmbKategori').innerHTML = resp.content.cmbKategori;			
						}else{
							alert(resp.err);
						}							
						
				  	}
				});
				
		
	},
	
	
	Close2:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},


	Closes: function(){	
			var me= this;
			$.ajax({
				type:'POST', 
				
			  	url: this.url+'&tipe=Closes',
			  	success: function() {		
					
						me.reloadTabel();	
						me.Close();
					
			  	}
			});

		
	},	
	
	Close3:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKC';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close4:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKD';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close5:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKE';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	
	
	SimpanModul: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize()+"&cmbreport="+$("#cmbreport").val(),
			url: this.url+'&tipe=simpanModul',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					document.getElementById('cmbModul').innerHTML = resp.content.replacer;
					document.getElementById('cmbSubModul').innerHTML = resp.content.cmbSubModul;
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	
	SimpanSubModul: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize()+"&id_aplikasi="+$("#cmbAplikasi").val()+"&id_modul="+$("#cmbModulForm").val(),
			url: this.url+'&tipe=simpanSubModul',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					document.getElementById('cmbKategori').innerHTML = resp.content.replacer;
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	
	
	Simpanreport: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize(),
			url: this.url+'&tipe=simpanreport',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					document.getElementById('cmbreport').innerHTML = resp.content.replacer;
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	EditModul: function(id){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize()+'&id='+id+"&cmbreport="+$("#cmbreport").val(),
			url: this.url+'&tipe=editModul',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					document.getElementById('cmbModul').innerHTML = resp.content.replacer;
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	
	EditSubModul: function(id){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize()+"&id_aplikasi="+$("#cmbAplikasi").val()+"&id_modul="+$("#cmbModulForm").val()+'&id='+id,
			url: this.url+'&tipe=editSubModul',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					document.getElementById('cmbKategori').innerHTML = resp.content.replacer;
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	Editreport: function(id){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize()+'&id='+id,
			url: this.url+'&tipe=editreport',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					document.getElementById('cmbreport').innerHTML = resp.content.replacer;
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	
	SimpanEdit: function(){
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
			data:$('#report_form').serialize(),
			url: this.url+'&tipe=simpanEdit',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					alert('Data berhasil disimpan');
					me.Close();
					me.refreshList(true);
					me.AfterSimpan();	
				}
				else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	Simpan: function(id){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize()+'&hubla='+id+"&id_aplikasi="+$("#cmbAplikasi").val(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					me.Close();
					me.AfterSimpan();
					me.refreshList(true);
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SaveProgres: function(id){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize()+'&hubla='+id,
			url: this.url+'&tipe=saveProgres',
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
	}
	
	,
	
	SaveCheck: function(id){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize()+'&hubla='+id,
			url: this.url+'&tipe=saveCheck',
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
	newrincian_pekerjaan: function(){	
		
		var me = this;
		var err='';

		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.prefix+'_form').serialize()+'&cmbAplikasi='+$("#cmbAplikasi").val(),
			  	url: this.url+'&tipe=newrincian_pekerjaan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	
	Saverincian_pekerjaan: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:{
					itemCheck : $("#itemCheck").val(),
				  	ket : $("#ket").val()
				  },
			url: this.url+'&tipe=Saverincian_pekerjaan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					
					me.reloadTabel();
					me.Close2();
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	reloadTabel: function(){
		var me= this;
		var err='';
		
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize()+'&cmbAplikasi='+$("#cmbAplikasi").val(),
			url: this.url+'&tipe=getTabel',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				if(resp.err==''){
					document.getElementById("tabelRincianPekerjaan").innerHTML = resp.content.tabel;
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	hapusRincian: function(id){	
			var me= this;
			$.ajax({
				type:'POST', 
				data:{
						id : id	
					  },
			  	url: this.url+'&tipe=hapusRincian',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if(resp.err == ''){
						me.reloadTabel();	
					}else{
						alert(resp.err);
					}		
					
			  	}
			});

		
	},	
	editRincian: function(id){	
		
		var me = this;
		var err='';

		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						idTemp : id	
					 },
			  	url: this.url+'&tipe=editrincian_pekerjaan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	Editrincian_pekerjaan: function(id){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:{
					id : id,
					itemCheck : $("#itemCheck").val(),
				  	ket : $("#ket").val()
					
					},
			url: this.url+'&tipe=Editrincian_pekerjaan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){

					me.reloadTabel();
					me.Close2();
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},	
	
	CekOK: function(id){	
			var me= this;
			$.ajax({
				type:'POST', 
				data:{
						id : id	
					  },
			  	url: this.url+'&tipe=cekOK',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if(resp.err == ''){
						me.refreshList(true);	
					}else{
						alert(resp.err);
					}		
					
			  	}
			});

		
	},
	
	CekNo: function(id){	
			var me= this;
			$.ajax({
				type:'POST', 
				data:{
						id : id	
					  },
			  	url: this.url+'&tipe=cekNo',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if(resp.err == ''){
						me.refreshList(true);	
					}else{
						alert(resp.err);
					}		
					
			  	}
			});

		
	},
	
	showHistori: function(id){	
		
		var me = this;

		var err = "";
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{	id : id
					  },
			  	url: this.url+'&tipe=showHistori',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;

					
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	
	formCheck:function(id){
		var me = this;
	
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#reportForm').serialize()+"&idCheck="+id,
				url: this.url+'&tipe=formCheck',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});

		
	},
		
});
