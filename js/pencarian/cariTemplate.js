var cariTemplateSKPD = new SkpdCls({
	prefix : 'cariTemplateSKPD', formName:'cariTemplateForm', kolomWidth:120,
	
	pilihBidangAfter : function(){cariTemplate.refreshList(true);},
	pilihUnitAfter : function(){cariTemplate.refreshList(true);},
	pilihSubUnitAfter : function(){cariTemplate.refreshList(true);},
	pilihSeksiAfter : function(){cariTemplate.refreshList(true);}
});

var cariTemplate = new DaftarObj2({
	prefix : 'cariTemplate',
	url : 'pages.php?Pg=cariTemplate', 
	formName : 'cariTemplateForm',
	satuan_form : '0',//default js satuan
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
		this.BersihData();
	
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
	
	BaruTemplate: function(){
		template.AfterSimpan=function(){
			cariTemplate.refreshList(false);
		};
		template.Baru();
		
		
	},
	
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	
	pilihan: function(idnya){
		var me = this;
		
		var cover = this.prefix+'_cover';
		
		
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=pilihan&idnya='+idnya,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				if(resp.err==''){
					delElem(cover);
					me.windowClose();
					pemasukan_distribusi.TabelPenerimaDistribusi();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	windowShow: function(c1nya,cnya,dnya,idTerima,idTerima_det){
		var me = this;
		
		var cover = this.prefix+'_cover';
		
		
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=windowshow&c1nya='+c1nya+'&cnya='+cnya+'&dnya='+dnya+'&idTerima='+idTerima+'&idTerima_det='+idTerima_det,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				if(resp.err==''){
					document.getElementById(cover).innerHTML = resp.content;				
					me.loading();
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}
		  	}
		});
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
	
	AfterFormBaru: function(){
		var me= this;
		setTimeout(function myFunctionPersen() {me.GetDataTemplate();},111);
		setTimeout(function myFunctionPersen() {me.nyalakandatepicker();},111);
	},
	
	AfterFormEdit: function(){
		var me= this;
		setTimeout(function myFunctionPersen() {me.GetDataTemplate();},111);
		setTimeout(function myFunctionPersen() {me.nyalakandatepicker();},111);
	},
	
	GetDataTemplate: function(){
		var me= this;
		var err='';
		
		if (err =='' ){	
			var cover = this.prefix+'_formcover2';
			document.body.style.overflow='hidden';			
			addCoverPage2(cover,999,true,false);
				
			$.ajax({
				type:'POST', 
				data:$('#'+this.prefix+'_form').serialize(),
			  	url: this.url+'&tipe=GetDataTemplate',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);		
					document.body.style.overflow='auto';		
					document.getElementById("DataPenerimaTemplate").innerHTML = resp.content;
					me.CekDet_DataTemplate(5);
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	Simpan_DetDataTemplate: function(dari){
		var me= this;
		var err='';		
		if (err =='' ){		
			var cover = this.prefix+'_formcover2';
			document.body.style.overflow='hidden';			
			addCoverPage2(cover,999,true,false);
			$.ajax({
				type:'POST', 
				data:$('#'+this.prefix+'_form').serialize(),
			  	url: this.url+'&tipe=Simpan_DetDataTemplate',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);		
					document.body.style.overflow='auto';
							
					if(resp.err == ''){
						me.Get_JumlahBarang();
						alert("Rincian Template Berhasil Di Simpan !");
						if(dari == 1)me.Simpan();
					}else{
						alert(resp.err);
					}
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	Get_JumlahBarang: function(){
		
			var cover = this.prefix+'_formcover2';
			document.body.style.overflow='hidden';			
			addCoverPage2(cover,999,true,false);
				
			$.ajax({
				type:'POST', 
				data:$('#'+this.prefix+'_form').serialize(),
			  	url: this.url+'&tipe=Get_JumlahBarang',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					delElem(cover);			
					if(resp.err ==  ""){					
						document.getElementById("JUMLAH_BRG").value = resp.content;						
					}else{
						alert(resp.err);
					}
					//document.getElementById("DataPenerimaTemplate").innerHTML = resp.content;	
			  	}
			});
	},
	
	CekDet_DataTemplate: function(dari=0){
		var me= this;
		var err='';
		
		if (err =='' ){	
			var cover = this.prefix+'_formcover2';
			document.body.style.overflow='hidden';			
			addCoverPage2(cover,999,true,false);
				
			$.ajax({
				type:'POST', 
				data:$('#'+this.prefix+'_form').serialize(),
			  	url: this.url+'&tipe=CekDet_DataTemplate',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					delElem(cover);		
					document.body.style.overflow='auto';		
					if(resp.err ==  ""){
						cm =false;						
						document.getElementById("JUMLAH_BRG").value = resp.content.jml_brg;
						if(dari != 5){							
							if(resp.content.confrim != "")var cm = confirm(resp.content.confrim);
							if(cm == true){
							me.Simpan_DetDataTemplate(dari);
							}																		
							if(dari==0){
								me.GetDataTemplate();
							}else{
								if(cm==false)me.Simpan();
							}
						}
						
						
					}else{
						alert(resp.err);
					}
					//document.getElementById("DataPenerimaTemplate").innerHTML = resp.content;	
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
			
	Simpan: function(){
		var me= this;	
		var cm = confirm("Templeat Akan Di Simpan ?");
		if(cm == true){
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
						alert("Data Berhasil Di Simpan !")
						me.Close();
						me.loading();
					}else{
						alert(resp.err);
					}
			  	}
			});
		}
		
	},
	
	BersihData: function(Id=0){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=BersihData&IdBersih='+Id,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				me.Close();		
				//document.getElementById(cover).innerHTML = resp.content;
				
		  	}
		});
	},
	
	CleanCariSubUnit: function(){
		if(document.getElementById("CariSubUnit"))document.getElementById("CariSubUnit").value='';	
	},
	
	DataCopy: function(datanya){
		var me = this;
		var tanya = confirm("Gandakan Data ?");
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
						document.body.style.overflow='auto';		
						if(resp.err ==  ""){
							alert("Data Template Distribusi Berhasil di Gandakan !");							
							me.loading();						
						}else{
							alert(resp.err);
						}
					  }
				});
		}
		
	},
		
});
