var ManagementPengguna = new DaftarObj2({
	prefix : 'ManagementPengguna',
	url : 'pages.php?Pg=ManagementPengguna', 
	formName : 'ManagementPenggunaForm',
	el_kode_urusan : '',
	el_nama_urusan: '',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	},
	
	detail: function(){
		//alert('detail');
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();				
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
	
	Baru: function(){	
		
		var me = this;
		err='';
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;
				//	me.AfterFormBaru();
			  	}
			});			
		
		}else{
		 	alert(err);
		}
	},
	
	Edit:function(){
		
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
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formEdit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						setTimeout(function myFunction() {ManagementSystem.nyalakandatepicker()},1000);
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
	
	Upload:function(){
		
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
		var box = this.GetCbxChecked();
					
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formUpload',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						me.uploadIni();
						me.uploadIni2();
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
	
	btfile_onchange: function(){
		$( '#UploadForm' ).submit();	
	},
	
	uploadIni : function(idpilih){
		var me = this;
		
		//elements
		var progressbox 	= $('#progressbox');
		var progressbar 	= $('#progressbar');
		var statustxt 		= $('#statustxt');
		var submitbutton 	= $('#SubmitButton');
		var myform 			= $('#UploadForm');
		var output 			= $('#output');
		var completed 		= '0%';
		var ImageFile 		= $('#ImageFile');
		var content_newfile = $('#content_newfile');
		
		$(myform).ajaxForm({
			beforeSend: function() { //brfore sending form
				document.getElementById('output').innerHTML='';
				ImageFile.attr('disabled', ''); 
				statustxt.empty();
				progressbox.show(); //show progressbar
				progressbar.width(completed); //initial value 0% of progressbar
				statustxt.html(completed); //set status text
				statustxt.css('color','#000'); //initial color of status text
			},
			uploadProgress: function(event, position, total, percentComplete) { //on progress
				progressbar.width(percentComplete + '%') //update progressbar percent complete
				statustxt.html(percentComplete + '%'); //update status text
			},
			complete: function(response) { // on complete
				ImageFile.removeAttr('disabled'); //enable submit button
				progressbox.hide(); // hide progressbar
				
				var resp = eval('(' + response.responseText + ')');
				document.getElementById('content_newfile').innerHTML = resp.content.nmfile_asli;
			}
		});
	},
			
	btfile2_onchange: function(){
		$( '#UploadForm2' ).submit();	
	},
	
	uploadIni2 : function(idpilih){
		var me = this;
		
		//elements
		var progressbox 	= $('#progressbox');
		var progressbar 	= $('#progressbar');
		var statustxt 		= $('#statustxt');
		var submitbutton 	= $('#SubmitButton');
		var myform 			= $('#UploadForm2');
		var output 			= $('#output');
		var completed 		= '0%';
		var ImageFile 		= $('#ImageFile2');
		var content_newfile = $('#content_newfile');
		
		
		$(myform).ajaxForm({
			beforeSend: function() { //brfore sending form
				document.getElementById('output').innerHTML='';
				ImageFile.attr('disabled', ''); 
				statustxt.empty();
				progressbox.show(); //show progressbar
				progressbar.width(completed); //initial value 0% of progressbar
				statustxt.html(completed); //set status text
				statustxt.css('color','#000'); //initial color of status text
			},
			uploadProgress: function(event, position, total, percentComplete) { //on progress
				progressbar.width(percentComplete + '%') //update progressbar percent complete
				statustxt.html(percentComplete + '%'); //update status text
			},
			complete: function(response) { // on complete
				ImageFile.removeAttr('disabled'); //enable submit button
				progressbox.hide(); // hide progressbar
				var resp = eval('(' + response.responseText + ')');
				document.getElementById('content_newfile2').innerHTML = resp.content.nmfile_asli;
			}
		});
	},
	
	Batal: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=batal',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					if(me.satuan_form==0){
						me.Close();
					}else{
						me.Close();
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	Simpan: function(){
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
				me.daftarRender();	
					
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					if(me.satuan_form==0){
						me.Close();		
					}else{
						me.Close();
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanUpload: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanUpload',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				me.daftarRender();	
				if(resp.err==''){
					if(me.satuan_form==0){
						me.Close();		
					}else{
						me.Close();
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
});