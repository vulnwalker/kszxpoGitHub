var PenyusutanSkpd = new SkpdCls({
	prefix : 'PenyusutanSkpd', formName:'adminForm'
});


var Penyusutan = new DaftarObj2({
	prefix : 'Penyusutan',
	url : 'pages.php?Pg=Penyusutan', 
	formName : 'Penyusutan_form',// 'ruang_form',
	
	formSusut: function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#adminForm').serialize(),
		  	url: this.url+'&tipe=formSusut',
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
	
	formInformasi: function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#adminForm').serialize(),
		  	url: this.url+'&tipe=formInformasi',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				
					 
				if (resp.err ==''){						
					document.getElementById(cover).innerHTML = resp.content;
					me.TmplInfo();
				}else{
					delElem(cover);
					document.body.style.overflow='auto';
					alert(resp.err);
					
				}			
				
		  	}
		});
	},	
	
	formSusutSatu: function(){ //1 barang
		var me = this;
		errmsg = this.CekCheckboxBi();
		if(errmsg ==''){ 
			//var box = this.GetCbxChecked();
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#adminForm').serialize(),
			  	url: this.url+'&tipe=formSusutSatu',
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
		}else{
			alert(errmsg);
		}
	},
	
	formSusutKoreksi: function(){ //1 barang
		var me = this;
		errmsg = this.CekCheckboxBi();
		if(errmsg ==''){ 
			//var box = this.GetCbxChecked();
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#adminForm').serialize(),
			  	url: this.url+'&tipe=formKoreksi',
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
		}
	},
	
	formBatal: function(){ //1 barang
		var me = this;
		var err = '';
		var errmsg = '';
		//cek skpd
		var skpd = document.getElementById('fmSKPD').value; 
		var unit = document.getElementById('fmUNIT').value;
		var subunit = document.getElementById('fmSUBUNIT').value;
		var seksi = document.getElementById('fmSEKSI').value;
		
		//if(err=='' && (skpd=='' || skpd=='00') ) err='BIDANG belum dipilih!';
		//if(err=='' && (unit=='' || unit=='00') ) err='SKPD belum dipilih!';
		//if(err=='' && (subunit=='' || subunit=='00') ) err='UNIT belum dipilih!';
		//if(err=='' && (seksi=='' || seksi=='00' || seksi=='000') ) err='SUB UNIT belum dipilih!';
		//errmsg = this.CekCheckboxBi();
		if(err ==''){
			if(errmsg ==''){ 
				//var box = this.GetCbxChecked();
				var cover = this.prefix+'_formcover';
				document.body.style.overflow='hidden';
				addCoverPage2(cover,1,true,false);	
				$.ajax({
					type:'POST', 
					data:$('#adminForm').serialize(),
				  	url: this.url+'&tipe=formBatal',
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
			}else{
				alert(errmsg);
			}
		}else{
			alert(err);
		}
	},	
	
	batalNext: function(){ //1 barang
		var me = this;
		//cek skpd
		//var box = this.GetCbxChecked();
		//var cover = this.prefix+'_formcover';
		//document.body.style.overflow='hidden';
		//addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#Penyusutan_form').serialize(),
		  	url: this.url+'&tipe=batalNext',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');												
					document.getElementById('InputIdBarang').innerHTML = resp.content.InputIdBarang;										document.getElementById('InputKdBarang').innerHTML = resp.content.InputKdBarang;						
					//document.getElementById('nextInput').innerHTML = resp.content.nextInput;	
					//document.getElementById('idbi').value =	resp.content.idbi;	
					document.getElementById('vjmldata').innerHTML = resp.content.jmlData;
					document.getElementById('jmldata').value =	resp.content.jmlData;						
					//document.getElementById('batalMetodehidden').value = resp.content.batalMetodehidden;						

					//alert(resp.content.jmlData);		
		  	}
		});
	},
	
	susutNext: function(){ //1 barang
		var me = this;
			if(document.getElementById('susutKdBarang').checked){
			document.getElementById('InputKdBarang').innerHTML = "<input type='text' id='KdBarang' name='KdBarang' onchange='Penyusutan.changeTahun()'><span style='color:red'> (mis : 00.00.00.00.000)</span>";			
		}else{
			document.getElementById('KdBarang').value="";
			me.changeTahun();	
			document.getElementById('InputKdBarang').innerHTML = "";
					
		}
	},					

	daftaropsierror_click : function(heightmax){	//alert('tess');
		//var heightmax = 200;//$opsi_height;
		var heightmin = 0;
		var icon_up='images/tumbs/up_2.png';
		var icon_down = 'images/tumbs/down_2.png';
		var div_id = 'daftaropsisusuterror_div';
		var div_slide = 'daftaropsierror_slide_img';
		
		var div= document.getElementById(div_id);
		var img = document.getElementById(div_slide);
		var img_src=img.getAttribute('src');
		//if( img_src =='images/tumbs/down.png' ){
		if( img_src == icon_down ){                                                            
			img.setAttribute('src', icon_up);
			div.style.height=heightmax;
			document.getElementById('div_border').style.width = '715px';
			document.getElementById('div_border').style.height = '625px';
			document.getElementById('Penyusutan_form_div').style.width = '700px';
			document.getElementById('Penyusutan_form_div').style.height = '550px';
		}else{ 
			img.setAttribute('src', icon_down);
			div.style.height=heightmin;
			document.getElementById('div_border').style.width = '518px';
			document.getElementById('div_border').style.height = '328px';
			document.getElementById('Penyusutan_form_div').style.width = '500px';
			document.getElementById('Penyusutan_form_div').style.height = '250px';			
		}
	},
	
	daftaropsierrorbatal_click : function(heightmax){	//alert('tess');
		//var heightmax = 200;//$opsi_height;
		var heightmin = 0;
		var icon_up='images/tumbs/up_2.png';
		var icon_down = 'images/tumbs/down_2.png';
		var div_id = 'daftaropsisusuterror_div';
		var div_slide = 'daftaropsierror_slide_img';
		
		var div= document.getElementById(div_id);
		var img = document.getElementById(div_slide);
		var img_src=img.getAttribute('src');
		//if( img_src =='images/tumbs/down.png' ){
		if( img_src == icon_down ){                                                            
			img.setAttribute('src', icon_up);
			div.style.height=heightmax;
			document.getElementById('div_border').style.width = '715px';
			document.getElementById('div_border').style.height = '625px';
			document.getElementById('Penyusutan_form_div').style.width = '700px';
			document.getElementById('Penyusutan_form_div').style.height = '550px';
		}else{ 
			img.setAttribute('src', icon_down);
			div.style.height=heightmin;
			document.getElementById('div_border').style.width = '518px';
			document.getElementById('div_border').style.height = '378px';
			document.getElementById('Penyusutan_form_div').style.width = '500px';
			document.getElementById('Penyusutan_form_div').style.height = '300px';			
		}
	},	
	
	batalSusut : function(){
		var me = this;
		var errmsg = '';
		
		//errmsg = this.CekCheckboxBi();
		if((errmsg=='') && ( (document.getElementById('boxchecked').value == 0)||(document.getElementById('boxchecked').value == '')  )){
			errmsg= 'Data belum dipilih!';
		}

		if(errmsg =='' && confirm('Batalkan semua penyusutan untuk '+adminForm.boxchecked.value+' barang?') ){ 			
			var me = this;
			var cover = this.prefix+'_formcover';
			//document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#adminForm').serialize(),
			  	url: this.url+'&tipe=batalSusut',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');									
					delElem(cover);
					if (resp.err ==''){						
						//document.getElementById(cover).innerHTML = resp.content;
						//me.filterRender();
						//me.daftarRender();
						alert(resp.content.alert);
						Penatausaha.refreshList(true);							
					}else{
						
						//document.body.style.overflow='auto';
						alert(resp.err);					
					}
			  	}
			});
		
		}else {
			alert( errmsg);
		}
	},

	batalSusutMetode1 : function(){
		var me = this;
		var errmsg = '';
		
		//errmsg = this.CekCheckboxBi();
		//if((errmsg=='') && ( (document.getElementById('boxchecked').value == 0)||(document.getElementById('boxchecked').value == '')  )){
		//	errmsg= 'Data belum dipilih!';
		//}

		if(confirm('Batalkan semua penyusutan untuk '+document.getElementById('jmldata').value+' barang?') ){ 	
			var me = this;
			var cover = this.prefix+'_formcoverBatal';
			//document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#Penyusutan_form').serialize(),
			  	url: this.url+'&tipe=batalSusutMetode',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');									
					delElem(cover);
					if (resp.err ==''){						
						//document.getElementById(cover).innerHTML = resp.content;
						//me.filterRender();
						//me.daftarRender();
						//alert(resp.content.alert);
						Penatausaha.refreshList(true);							
					}else{
						
						//document.body.style.overflow='auto';
						alert(resp.err);					
					}
			  	}
			});
		
		}else {
			alert( errmsg);
		}
	},
	
	batalSusutMetode: function(urutan){
		//alert('tes');
		var me = this;
		var err= '';
		var cover = this.prefix+'_formcoverBatl';
		var img = document.getElementById('daftaropsierror_slide_img');	
		var batalMetode = document.getElementById('batalMetodehidden').value;				
		//var thnsusut = document.getElementById('thnsusut').value;
		if(err=='' && (batalMetode=='' || batalMetode == null ) ) err= ' Metode Batal Penyusutan belum dipilih! ';
		//document.body.style.overflow='hidden';
		//if(confirm('Batalkan semua penyusutan untuk '+document.getElementById('jmldata').value+' barang?') ){ 		
			//kondisi jika terdapat error dan melakukan proses batal kembali
			if(document.getElementById('progressbar').style.width=="100%"){
				document.getElementById('progressbox').style.display='none';
				document.getElementById('prog').value = 0;
				document.getElementById('progressbar').style.width = '0%';			
				//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
				document.getElementById('progressmsg').innerHTML = "";
				img.setAttribute('src', '');
				var fmSesi = document.getElementById('fmSesi').value.split(".");
				aler(fmSesi[1]);
													
			}
			
			document.getElementById('btproses').disabled=true;
			document.getElementById('btbatal').disabled=true;
			document.getElementById('progressbox').style.display='block';
			
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+'Penyusutan_form').serialize(),
			  	url: this.url+'&tipe=batalSusutMetode',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					delElem(cover);
					document.getElementById('btproses').disabled=false;
					document.getElementById('btbatal').disabled=false;
					document.body.style.overflow='auto';
					if (resp.err ==''){
						var  jmldata = parseInt(document.getElementById('jmldata').value);
						var  prog = parseInt(document.getElementById('prog').value);
						prog = prog + resp.content.jml;
						if(prog>jmldata) prog = jmldata;
						document.getElementById('prog').value = prog;
						var persen = ((prog/jmldata)*100);
						document.getElementById('progressbar').style.width = persen +'%';			
						//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
						document.getElementById('progressmsg').innerHTML = formatNumber(prog,0,',','.')+'/'+formatNumber(jmldata,0,',','.');		//alert(resp.content.jml);	
						if(persen<100) {
							setTimeout(function(){ me.batalSusutMetode(urutan); }, 1000);
						 	if(resp.content.msg_jml_error!=''){
								document.getElementById('progreserrormsg').innerHTML = resp.content.msg_jml_error;
								me.susutError(resp.content.NoSesi);
								urutan = urutan+1;		
							}
							if(urutan==1){
								img.setAttribute('src', 'images/tumbs/down_2.png');								
							}
						}else{
							if(resp.content.msg_jml_error==''){
								alert('Batal Penyusutan Selesai');
								document.getElementById('progressbox').style.display='none';
								me.Close();
								Penatausaha.refreshList(true);
							}else{
								alert(resp.content.msg_jml_error+' !');
							 	img.setAttribute('src', 'images/tumbs/down_2.png');						
							 	document.getElementById('progreserrormsg').innerHTML = resp.content.msg_jml_error;	
							 	me.susutError(resp.content.NoSesi);							
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
						me.batalSusutMetode()
					}
					
				}
			});
		//}
	},	
	
	susut: function(urutan){
		//alert('tes');
		var me = this;
		var err= '';
		var cover = this.prefix+'_formcoversust';
		var img = document.getElementById('daftaropsierror_slide_img');		
		var thnsusut = document.getElementById('thnsusut').value;
		if(err=='' && (thnsusut=='' || thnsusut == null ) ) err= ' Tahun laporan belum dipilih! ';
		
		//document.body.style.overflow='hidden';
		if(err==''){
			
			document.getElementById('btproses').disabled=true;
			document.getElementById('btbatal').disabled=true;
			document.getElementById('progressbox').style.display='block';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+'Penyusutan_form').serialize(),
			  	url: this.url+'&tipe=susut',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					delElem(cover);
					document.getElementById('btproses').disabled=false;
					document.getElementById('btbatal').disabled=false;
					//	document.body.style.overflow='auto';
					if (resp.err ==''){
						var  jmldata = parseInt(document.getElementById('jmldata').value);
						var  prog = parseInt(document.getElementById('prog').value);
						prog = prog + resp.content.jml;
						if(prog>jmldata) prog = jmldata;
						document.getElementById('prog').value = prog;
						var persen = ((prog/jmldata)*100);
						document.getElementById('progressbar').style.width = persen +'%';			
						//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
						document.getElementById('progressmsg').innerHTML = formatNumber(prog,0,',','.')+'/'+formatNumber(jmldata,0,',','.');			
						if(persen<100) {
							setTimeout(function(){ me.susut(urutan); }, 1000);
						 	if(resp.content.msg_jml_error!=''){
								urutan = urutan+1;
								document.getElementById('progreserrormsg').innerHTML = resp.content.msg_jml_error;
								me.susutError(resp.content.NoSesi);

							}
							if(urutan==1){
								img.setAttribute('src', 'images/tumbs/down_2.png');								
							}
						}else{
							if(resp.content.msg_jml_error==''){
								alert('Penyusutan Selesai');
								document.getElementById('progressbox').style.display='none';
								me.Close();
								Penatausaha.refreshList(true);
							}else{
								alert(resp.content.msg_jml_error+' !');
							 	img.setAttribute('src', 'images/tumbs/down_2.png');		
								document.getElementById('progreserrormsg').innerHTML = resp.content.msg_jml_error;	
							 	me.susutError(resp.content.NoSesi);		
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
						me.susut(urutan);
					}
					
				}
			});
		}else{
			alert(err);
		}

	},
	
	susutError:function(Sesi){
		document.getElementById('progreserror').innerHTML = 
			"<div id='PenyusutanLog_cont_opsi' style='position:relative'>"+
			//"<input type='hidden' name='fmSesi' id='fmSesi' value='"+Sesi+"'>"+
			"</div>"+
			"<div id='PenyusutanLog_cont_daftar' style='position:relative'></div>"+
			"<div id='PenyusutanLog_cont_hal' style='position:relative'></div>"
			;
		//generate data
	   PenyusutanLog.loading();
	},
	
	susutSatu: function(){
		//alert('tes');
		var me = this;
		var err='';// 'Sementara tidak dapat melakukan penyusutan';
		
		var cover = this.prefix+'_formcoversust';
		
		var thnsusut = document.getElementById('thnsusut').value;
		if(err=='' && (thnsusut=='' || thnsusut == null ) ) err= ' Tahun laporan belum dipilih! ';
		//document.body.style.overflow='hidden';
		if(err==''){
			
			document.getElementById('btproses').disabled=true;
			document.getElementById('btbatal').disabled=true;
			document.getElementById('progressbox').style.display='block';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+'Penyusutan_form').serialize(),
			  	url: this.url+'&tipe=susutSatu',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					delElem(cover);
					document.getElementById('btproses').disabled=false;
					document.getElementById('btbatal').disabled=false;	//	document.body.style.overflow='auto';
					if (resp.err ==''){
						var  jmldata = parseInt(document.getElementById('jmldata').value);
						var  prog = parseInt(document.getElementById('prog').value);
						prog = prog + resp.content.jml;
						if(prog>jmldata) prog = jmldata;
						document.getElementById('prog').value = prog;
						var persen = ((prog/jmldata)*100);
						document.getElementById('progressbar').style.width = persen +'%';//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
						document.getElementById('progressmsg').innerHTML = formatNumber(prog,0,',','.')+'/'+formatNumber(jmldata,0,',','.');			
						/*if(persen<100) {
							 me.susutSatu();
						}else{*/
							alert('Penyusutan Selesai');
							document.getElementById('progressbox').style.display='none';
							me.Close();
							Penatausaha.refreshList(true);
						//}
					}else{
						alert(resp.err+'\n'+resp.content.err_message);
						me.Close();
						//me.formErrorPenyusutan();
					}			
					
			  	}
			});
		}else{
			alert(err);
		}

	},

	susutKoreksi: function(){
		//alert('tes');
		var me = this;
		var err='';// 'Sementara tidak dapat melakukan penyusutan';
		
		var cover = this.prefix+'_formcoversust';
		
		var tgl_koreksi = document.getElementById('tgl_koreksi').value;
		if(err=='' && (tgl_koreksi=='' || tgl_koreksi == null ) ) err= ' Tanggal Koreksi Belum diisi! ';
		//document.body.style.overflow='hidden';
		if(err==''){
			
			document.getElementById('btproses').disabled=true;
			document.getElementById('btbatal').disabled=true;
			document.getElementById('progressbox').style.display='block';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+'Penyusutan_form').serialize(),
			  	url: this.url+'&tipe=susutKoreksi',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					delElem(cover);
					document.getElementById('btproses').disabled=false;
					document.getElementById('btbatal').disabled=false;	//	document.body.style.overflow='auto';
					if (resp.err ==''){
						var  jmldata = parseInt(document.getElementById('jmldata').value);
						var  prog = parseInt(document.getElementById('prog').value);
						prog = prog + resp.content.jml;
						if(prog>jmldata) prog = jmldata;
						document.getElementById('prog').value = prog;
						var persen = ((prog/jmldata)*100);
						document.getElementById('progressbar').style.width = persen +'%';//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
						document.getElementById('progressmsg').innerHTML = formatNumber(prog,0,',','.')+'/'+formatNumber(jmldata,0,',','.');			
						/*if(persen<100) {
							 me.susutSatu();
						}else{*/
							alert('Penyusutan Koreksi Selesai');
							document.getElementById('progressbox').style.display='none';
							me.Close();
							Penatausaha.refreshList(true);
						//}
					}else{
						alert(resp.err);
						
					}			
					
			  	}
			});
		}else{
			alert(err);
		}

	},
	
	formRincian: function(){
		var me= this;
		errmsg = this.CekCheckboxBi();
		if(errmsg ==''){ 			
			var me = this;
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#adminForm').serialize(),
			  	url: this.url+'&tipe=formRincian',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');									
					if (resp.err ==''){						
						document.getElementById(cover).innerHTML = resp.content;
						me.filterRender();
						me.daftarRender();							
					}else{
						delElem(cover);
						document.body.style.overflow='auto';
						alert(resp.err);					
					}
			  	}
			});
		
		}else {
			alert( errmsg);
		}
	},
	
	formErrorPenyusutan: function(){
		var me= this;
		//errmsg = this.CekCheckboxBi();
		//if(errmsg ==''){ 			
			var me = this;
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#adminForm').serialize(),
			  	url: this.url+'&tipe=formErrorPenyusutan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');									
					if (resp.err ==''){						
						document.getElementById(cover).innerHTML = resp.content;
						//me.filterRender();
						//me.daftarRender();							
					}else{
						delElem(cover);
						document.body.style.overflow='auto';
						alert(resp.err);					
					}
			  	}
			});
		
		//}else {
		//	alert( errmsg);
		//}
	},	
	
	changeTahun: function(){
		//alert('tes');
		document.getElementById('btproses').disabled=true;
		document.getElementById('btbatal').disabled=true;
		$.ajax({
			type:'POST', 
			data:$('#'+'Penyusutan_form').serialize(),
		  	url: this.url+'&tipe=changeTahun',
		  	success: function(data) {	
				document.getElementById('btproses').disabled=false;
				document.getElementById('btbatal').disabled=false;
				var resp = eval('(' + data + ')');									
				if (resp.err ==''){	
					document.getElementById('vjmldata').innerHTML = resp.content.vjml;
					document.getElementById('jmldata').value =	resp.content.jml;			
					//document.getElementById(cover).innerHTML = resp.content; //me.filterRender(); //me.daftarRender();							
				}else{
					//delElem(cover); //document.body.style.overflow='auto';
					alert(resp.err);					
				}
		  	}
		});
	},
	
	TmplInfo: function(){
		//alert('tes');
		var versi_name = document.getElementById('versi_name').value; 
		
		$.ajax({
			type:'POST', 
			data:"versi_name="+versi_name,
		  	url: this.url+'&tipe=TmplInfo',
		  	success: function(data) {	
				var resp = eval('(' + data + ')');									
				if (resp.err ==''){	
					document.getElementById('tmpl_info').innerHTML = resp.content;							
				}else{
					//delElem(cover); //document.body.style.overflow='auto';
					alert(resp.err);					
				}
		  	}
		});
	}	
});
