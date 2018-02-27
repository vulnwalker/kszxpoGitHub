var InventarisRekapSkpd = new SkpdCls({
	prefix : 'InventarisRekapSkpd', formName:'InventarisRekapForm',
	
	pilihBidangAfter : function(){InventarisRekap.refreshList(true);},
	pilihUnitAfter : function(){InventarisRekap.refreshList(true);},
	pilihSubUnitAfter : function(){InventarisRekap.refreshList(true);},
	pilihSeksiAfter : function(){InventarisRekap.refreshList(true);}
});


var InventarisRekap = new DaftarObj2({
	prefix : 'InventarisRekap',
	url : 'pages.php?Pg=InventarisRekap', 
	formName : 'InventarisRekapForm',
	
	loading:function(){
		//alert('loading');
		this.topBarRender();
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
				$('#tgl_cek').datepicker({
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
				$("#tgl_cek").datepicker({ dateFormat: "dd-mm-yy" });			
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
		
	ProsesInventaris : function(id){
		var me= this;
		var idaktif=document.getElementById("idplh");
		if(idaktif == null){
			var idplh = 0;	
		}else{
			var idplh = idaktif.value;			
		}	
		//alert(id);
		//me.daftarRender();
		$.ajax({
			type:'POST', 
			data:$('#InventarisRekapForm').serialize()+"&id="+id+"&idplh="+idplh,
			url: this.url+'&tipe=prosesInventaris',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				
				//$("#cmbBidang").html(resp.content.cmbBidang);
				//alert("test - "+mode+" - "+idbi);
					//document.getElementById("kondisi_"+idbi).innerHTML=resp.content.kondisi;
					//document.getElementById("ada_"+idbi).innerHTML=resp.content.ada;
					document.getElementById("tidak_"+id).innerHTML=resp.content.tidak;
					document.getElementById("status_"+id).innerHTML=resp.content.status;				
					if(idplh != 0){				
						//alert(idbiaktif.value);
					document.getElementById("tidak_"+idplh).innerHTML=resp.content.tidakawl;
					document.getElementById("status_"+idplh).innerHTML=resp.content.statusawl;						}
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
		
	ProsesCaribarang: function(idplh){
		var me = this;	
		//var idplh = document.getElementById('idplh_'+idplh).value;
		InventarisShow.el_ID = 'idplh_'+idplh;
		InventarisShow.el_Ada = 'ada_'+idplh;
		InventarisShow.el_Tidak = 'tidak_'+idplh;
		InventarisShow.el_Status = 'status_'+idplh;
		InventarisShow.el_Baik = 'baik_'+idplh;
		InventarisShow.el_Kurang = 'kurang_'+idplh;
		InventarisShow.el_Rusak = 'rusak_'+idplh;				
		InventarisShow.el_StatusBI = 'statusbi_'+idplh;	
		InventarisShow.windowSaveAfter= function(){};
		InventarisShow.windowShow();	
	},	
});
