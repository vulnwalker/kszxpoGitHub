var InventarisShowSkpd = new SkpdCls({
	prefix : 'InventarisSkpd', formName:'InventarisForm',
	
	pilihBidangAfter : function(){Inventaris.refreshList(true);},
	pilihUnitAfter : function(){Inventaris.refreshList(true);},
	pilihSubUnitAfter : function(){Inventaris.refreshList(true);},
	pilihSeksiAfter : function(){Inventaris.refreshList(true);}
});


var InventarisShow = new DaftarObj2({
	prefix : 'InventarisShow',
	url : 'pages.php?Pg=InventarisShow', 
	formName : 'InventarisShowForm',
	el_ID : '',
	el_Ada : '',
	el_Tidak : '',
	el_Status : '',		
	el_Baik : '',		
	el_Kurang : '',		
	el_Rusak : '',
	el_StatusBI : '',		
					
	loading:function(){
		//alert('loading');
		//this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	},
	
	daftarRender: function(){
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
			//contentType: "application/x-www-form-urlencoded;charset=ISO-8859-1",	
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				document.getElementById(me.prefix+'_cont_daftar').innerHTML = resp.content;
				if(me.withPilih) me.cbTampil();	
				me.daftarRenderAfter(resp);	
				me.sumHalRender();
				/*$('#tgl_cek').datepicker({
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
				$("#tgl_cek").datepicker({ dateFormat: "dd-mm-yy" });*/			
		  	},
			error: ajaxError
		});
	},	
	
	pilihGedungOnchange: function(){
		var me = this;
		$.ajax({
		  url: this.url+'&tipe=pilihRuang',
		  type : 'POST',
		  data:$('#'+this.formName).serialize(),
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagi
				//document.getElementById('fmSKPDSubUnit2').innerHTML=resp.content;
				if(resp.err==''){							
					document.getElementById('cbxRuang').innerHTML = resp.content;
					//me.refreshList(true);		
				}else{
					alert(resp.err);
				}	
		  }
		});
	},	
		
	ProsesInventaris : function(mode,idbi){
		var me= this;
		var idbiaktif=document.getElementById("idbiplh");
		if(idbiaktif == null){
			var idbiplh = 0;	
		}else{
			var idbiplh = idbiaktif.value;			
		}	
		//alert(idbiplh);
		//me.daftarRender();
		$.ajax({
			type:'POST', 
			data:$('#InventarisForm').serialize()+"&mode="+mode+"&idbi="+idbi+"&idbiplh="+idbiplh,
			url: this.url+'&tipe=prosesInventaris',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				
				//$("#cmbBidang").html(resp.content.cmbBidang);
				//alert("test - "+mode+" - "+idbi);
					document.getElementById("kondisi_"+idbi).innerHTML=resp.content.kondisi;
					document.getElementById("ada_"+idbi).innerHTML=resp.content.ada;
					document.getElementById("status_"+idbi).innerHTML=resp.content.status;
					document.getElementById("tombol_"+idbi).innerHTML=resp.content.tombol;				
					if(idbiplh != 0){				
						//alert(idbiaktif.value);
						document.getElementById("kondisi_"+idbiplh).innerHTML=resp.content.kondisiawl;
						document.getElementById("ada_"+idbiplh).innerHTML=resp.content.adaawl;
						document.getElementById("status_"+idbiplh).innerHTML=resp.content.statusawl;
						document.getElementById("tombol_"+idbiplh).innerHTML=resp.content.tombolawl;			
					}
		  	}
		});
	},
	
	Updinventaris: function(mode,idbi){
		var me = this;
		var idbiaktif=document.getElementById("idbiplh");		
		
		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=updInventaris',
		  type : 'POST',
		  data:$('#'+this.formName).serialize()+"&mode="+mode+"&idbi="+idbi,
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagi
				//document.getElementById('fmSKPDSubUnit2').innerHTML=resp.content;
				if(resp.err==''){							
					document.getElementById("kondisi_"+idbi).innerHTML=resp.content.kondisi;
					document.getElementById("ada_"+idbi).innerHTML=resp.content.ada;
					document.getElementById("status_"+idbi).innerHTML=resp.content.status;
					document.getElementById("tombol_"+idbi).innerHTML=resp.content.tombol;
					me.refreshList(true);			
				}else{
					alert(resp.err);
				}	
		  }
		});
	},
	
   	formPengaturan : function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,999,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=formPengaturani',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					document.getElementById(cover).innerHTML = resp.content;			
					me.AfterFormBaru(resp);	
					/*$('#tgl_buku_inventaris').datepicker({
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
					$("#tgl_buku_inventaris").datepicker({ dateFormat: "dd-mm-yy" });*/
				}else{
					alert(resp.err);
					delElem(cover);
				}			
				
		  	}
		});
	},
	
	savePengaturan : function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=savePengaturan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					alert("Data sudah disimpan !");
					me.Close();
					window.location.href = 'pages.php?Pg=Inventaris';					
				}else{
					alert(resp.err);
				}
		  	}
		});
	},			
		
	windowShow: function(){
		var me = this;
		//fmURUSAN = document.getElementById(me.el_fmURUSAN).value;
		//fmSKPD = document.getElementById(me.el_fmSKPD).value;
		//fmUNIT = document.getElementById(me.el_fmUNIT).value;
		//fmSUBUNIT = document.getElementById(me.el_fmSUBUNIT).value;
		var fmId = document.getElementById(me.el_ID).value;
		//alert(fmId);
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize()+'&fmId='+fmId,
			url: this.url+'&tipe=windowshow',
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
		
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	
	windowSave: function(){
		var me= this;
		var idpilih= document.getElementById(this.prefix+'_idplh').value;
		var tgl_cek= document.getElementById(this.prefix+'_idplh').value;

		//alert('save');
		//var errmsg = this.CekCheckbox();
		//if(errmsg ==''){ 
		//	var box = this.GetCbxChecked();
			//alert(box.value);
		//	this.idpilih = box.value;
			
			
			var cover = 'inventaris_getdata';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				url: 'pages.php?Pg=InventarisShow&tipe=getdata&id='+idpilih,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					delElem(cover);
					if(resp.err==''){
						if(document.getElementById(me.el_Ada)) document.getElementById(me.el_Ada).innerHTML= resp.content.ada;
						if(document.getElementById(me.el_Tidak)) document.getElementById(me.el_Tidak).innerHTML= resp.content.tidak;
						if(document.getElementById(me.el_Status)) document.getElementById(me.el_Status).innerHTML= resp.content.status;
						if(document.getElementById(me.el_Baik)) document.getElementById(me.el_Baik).innerHTML= resp.content.baik;	
						if(document.getElementById(me.el_Kurang)) document.getElementById(me.el_Kurang).innerHTML= resp.content.kurang;	
						if(document.getElementById(me.el_Rusak)) document.getElementById(me.el_Rusak).innerHTML= resp.content.rusak;																			
						if(document.getElementById(me.el_StatusBI)) document.getElementById(me.el_StatusBI).innerHTML= resp.content.statusBI;
						me.windowClose();
						me.windowSaveAfter();
					}else{
						alert(resp.err)	
					}
			  	}
			});		
	//	}else{
	//		alert(errmsg);
	//	}
	},
	windowSaveAfter: function(){
		//alert('tes');
	},	
});
