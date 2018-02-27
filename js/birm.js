var BIRMSkpd = new SkpdCls({
	prefix : 'BIRMSkpd', formName:'BIRMForm'
	
	//pilihBidangAfter : function(){BIRM.refreshList(true);},
	//pilihUnitAfter : function(){BIRM.refreshList(true);},
	//pilihSubUnitAfter : function(){BIRM.refreshList(true);},
	//pilihSeksiAfter : function(){BIRM.refreshList(true);}
});

var BIRM = new DaftarObj2({
	prefix : 'BIRM',
	url : 'pages.php?Pg=BIRM', 
	formName : 'BIRMForm',
	el_ID : '',
	el_fmURUSAN : '',
	el_fmSKPD : '',
	el_fmUNIT : '',
	el_fmSUBUNIT : '',
	el_fmSEKSI : '',
	
	loading:function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
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

	formSinkron: function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#BIRMForm').serialize(),
		  	url: this.url+'&tipe=formSinkron',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				
					 
				if (resp.err ==''){						
					document.getElementById(cover).innerHTML = resp.content;
				}else{
					delElem(cover);
					document.body.style.overflow='auto';
					alert(resp.err);
					
				}			
				
		  	}
		});
	},

	Sinkron: function(pidprev,piderror){
		//alert('tes');
		var me = this;
		var err= '';
		var cover = this.prefix+'_formcoversinkron';
		if(pidprev==null) pidprev=[];
		if(piderror==null) piderror=[];
		
		//alert(piderror.length);
		
		//document.body.style.overflow='hidden';
		if(err==''){
			
			if(document.getElementById('progressbar').style.width=="100%"){
				document.getElementById('progressbox').style.display='none';
				document.getElementById('progbirm').value = 0;
				document.getElementById('progressbar').style.width = '0%';			
				//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
				document.getElementById('progressmsg').innerHTML = "";
				document.getElementById('tmplpiderror').value="";									
			}
			document.getElementById('btproses').disabled=true;
			document.getElementById('btbatal').disabled=true;
			document.getElementById('progressbox').style.display='block';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+'BIRM_form').serialize()+'&pidprev='+pidprev,
			  	url: this.url+'&tipe=Sinkron',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					delElem(cover);

					//	document.body.style.overflow='auto';
					if (resp.err ==''){
						var  jmldata = parseInt(document.getElementById('jmldata').value);
						var  prog = parseInt(document.getElementById('progbirm').value) || 0;
						prog = prog + parseInt(resp.content.jml);
						if(prog>jmldata) prog = jmldata;
						document.getElementById('progbirm').value = prog;
						var persen = ((prog/jmldata)*100);
						document.getElementById('progressbar').style.width = persen +'%';			
						//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
						document.getElementById('progressmsg').innerHTML = formatNumber(prog,0,',','.')+'/'+formatNumber(jmldata,0,',','.');			
						//if(resp.content.piderror!="") {piderror = piderror+resp.content.piderror;}
						//var testerror = piderror.push(resp.content.piderror);
						var testerror = resp.content.piderror;
						for(var ino=0; ino>testerror.length; ino++){
							testerror.push(testerror[ino]);
						}
						
						
    					//var res = testerror.split(",");
						//alert(testerror+res);
						pidprev.push(resp.content.pidprev);
						piderror.push.apply(piderror,testerror);
						var jml_error = piderror.length;
						//alert(document.getElementById('progressbar').style.width);
						//var testerror = pidprev.length;
						//var testerror = piderror.split(",");
						//alert(piderror+piderror[0);
						//alert("prog="+prog+"jml="+parseInt(resp.content.jml)+"jmldata="+jmldata+"persen="+persen);
						if(persen<100) {
							if(jml_error>0){
								//var tmpl_error = piderror.replace(",","");
								document.getElementById('tmplpiderror').value = "Ditemukan "+jml_error+" Kesalahan\r\n"+piderror;								
							}
							setTimeout(function(){ me.Sinkron(pidprev,piderror); }, 1000);						
						}else{
							if(jml_error>0){
								//alert(piderror);
								//var tmpl_error = piderror.replace(",","");
								document.getElementById('tmplpiderror').value = "Ditemukan "+jml_error+" Kesalahan\r\n"+piderror;
								document.getElementById('btproses').disabled=false;
								document.getElementById('btbatal').disabled=false;								
								
							}else{
								alert('Sinkronisasi Selesai');
								document.getElementById('progressbox').style.display='none';
								me.Close();
								//document.getElementById('btproses').disabled=false;
								//document.getElementById('btbatal').disabled=false;							
								BIRM.refreshList(true);	
							}
						}
					}else{
						alert(resp.err);
						
					}			
					
			  	},
				error: function(request, type, errorThrown){
					if(type != 'abort'){
						//me.jmlgagal ++;	
						//me.iterator+=me.jmlkol;
						//document.getElementById(idel_).innerHTML = '';
						me.Sinkron();
					}
					
				}
			});
		}else{
			alert(err);
		}

	},	

	/*Sinkron:function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		//document.body.style.overflow='hidden';
		//addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=Sinkron',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				//loadingShow('dlgProgress','images/administrator/images/loading.gif');	
				if (resp.err ==''){
					//document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru(resp);
					//if (resetPageNo && document.getElementById(this.prefix+'_hal') ) document.getElementById(this.prefix+'_hal').value=1;		
					//document.getElementById('BIRM_formcover_imgload').parentNode.removeChild(document.getElementById('BIRM_formcover_imgload'));
					me.refreshList(true);
					//me.filterRender();
					//me.daftarRender();
					//me.filterRender();
					//me.loading();	
					//delElem(cover);		
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}			
				
		  	}
		});
	},
	
	*/
	Baru:function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=formBaru',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					document.getElementById(cover).innerHTML = resp.content;			
					me.AfterFormBaru(resp);	
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}			
				
		  	}
		});
	},
	
	CariBIRM: function(){
		var me = this;	
		
		BIRM.el_ID = 'kode_account_ap';
		BIRM.windowSaveAfter= function(){};
		BIRM.windowShow();	
	},	
	
	windowShow: function(){
		var me = this;
		fmURUSAN = document.getElementById(me.el_fmURUSAN).value;
		fmSKPD = document.getElementById(me.el_fmSKPD).value;
		fmUNIT = document.getElementById(me.el_fmUNIT).value;
		fmSUBUNIT = document.getElementById(me.el_fmSUBUNIT).value;
		fmSEKSI = document.getElementById(me.el_fmSEKSI).value;
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize()+'&fmURUSAN='+fmURUSAN+'&fmSKPD='+fmSKPD+'&fmUNIT='+fmUNIT+'&fmSUBUNIT='+fmSUBUNIT+'&fmSEKSI='+fmSEKSI,
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
		//alert('save');
		var errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			//alert(box.value);
			this.idpilih = box.value;
			
			
			var cover = 'birm_getdata';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				url: 'pages.php?Pg=BIRM&tipe=getdata&id='+this.idpilih,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					delElem(cover);
					if(resp.err==''){
						if(document.getElementById(me.el_ID)) document.getElementById(me.el_ID).value= resp.content.ID;
						if(document.getElementById("pemasukan_ins_idplh"))pemasukan_ins.caraperolehan(1);
						me.windowClose();
						me.windowSaveAfter();
					}else{
						alert(resp.err)	
					}
			  	}
			});		
		}else{
			alert(errmsg);
		}
	},
	windowSaveAfter: function(){
		//alert('tes');
	},		
	AfterSimpan : function(){
		if(document.getElementById('Kunjungan_cont_daftar')){
		this.refreshList(true);}
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
	}
});