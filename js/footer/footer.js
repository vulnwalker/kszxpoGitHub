var footer = new DaftarObj2({
	prefix : 'footer',
	url : 'pages.php?Pg=footer', 
	formName : 'footerForm',
	el_kode_urusan : '',
	el_nama_urusan: '',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	},
	
	findImage: function(type){
		popupImages.typeImage = type;
		popupImages.windowShow();	
	},
	
	Gambar:function(){
		
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
				url: this.url+'&tipe=Gambar',
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
		}else{
			alert(errmsg);
		}
		
	},
	saveKolom: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=saveKolom',
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
	
	PengaturanKolom:function(){
		
		var me = this;
		var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formPengaturan',
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
	
	Baru:function(){
		
		var me = this;
		var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						setTimeout(function myFunction() {ManagementSystem.nyalakandatepicker()},1000);
						me.uploadIni();
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});		
	},
	
	Edit:function(){
		
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
	

	
	saveNewGrup: function(){
		var me= this;
		var err='';
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:{	
					namaGrup : $("#namaGrup").val(),
					},
			url: this.url+'&tipe=saveNewGrup',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					document.getElementById("cmbGrup").innerHTML = resp.content.cmbGrup;
					me.Close2();
					
				}else{
					alert(resp.err);
				}
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
	
	
	saveGambar: function(id){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize()+"&idEdit="+id,
			url: this.url+'&tipe=saveGambar',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);
				me.daftarRender();	

				if(resp.err==''){
						me.Close();		

				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	formURL:function(){
		
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formURL',
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
		}else{
			alert(errmsg);
		}
		
	},
	
	saveURL: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:{	

					id: id,
					url:$("#url").val()

					},
			url: this.url+'&tipe=saveURL',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.daftarRender();
					me.Close2();
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},

	imageAktifChanged: function(){
		var me= this;	
		var filesSelected = document.getElementById("imageAktifFile").files;
		if (filesSelected.length > 0)
		{
			var fileToLoad = filesSelected[0];
	
			var fileReader = new FileReader();
	
			fileReader.onload = function(fileLoadedEvent) 
			{
				var textAreaFileContents = document.getElementById
				(
					"baseImageAktif"
				);
		
				textAreaFileContents.value = fileLoadedEvent.target.result;
				$("#nameFileAktif").val(document.getElementById('imageAktifFile').value);
			};
	
			fileReader.readAsDataURL(fileToLoad);
		}
	},
	
	imagePasifChanged: function(){
		var me= this;	
		var filesSelected = document.getElementById("imagePasifFile").files;
		if (filesSelected.length > 0)
		{
			var fileToLoad = filesSelected[0];
	
			var fileReader = new FileReader();
	
			fileReader.onload = function(fileLoadedEvent) 
			{
				var textAreaFileContents = document.getElementById
				(
					"baseImagePasif"
				);
		
				textAreaFileContents.value = fileLoadedEvent.target.result;
				$("#nameFilePasif").val(document.getElementById('imagePasifFile').value);
			};
	
			fileReader.readAsDataURL(fileToLoad);
		}
	},
	
	levelChanged: function(){
		var me= this;	

		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=levelChanged',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				$("#cmbUpline").html(resp.content.cmbUpline);
				
		  	}
		});
	},
	
	uplineChanged: function(){
		var me= this;	

		$.ajax({
			type:'POST', 
			data:{
					level : $("#cmbLevel").val(),
					upline : $("#cmbUpline").val(),
					},
			url: this.url+'&tipe=uplineChanged',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				$("#nomorUrut").val(resp.content.nomorUrut);
		  	}
		});
	},
	
	
	newGrup: function(){	
		
		var me = this;
		var err='';

		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
/*				data:{
						cmbAplikasi : $("#cmbAplikasi").val(),		
					 },*/
			  	url: this.url+'&tipe=newGrup',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	
	editGrup: function(){	
		
		var me = this;
		var err='';
		if($("#cmbGrup").val() == ''){
			err = "Pilih grup";
		}
		
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						id : $("#cmbGrup").val(),		
					 },
			  	url: this.url+'&tipe=editGrup',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	saveEditGrup: function(id){
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
					namaGrup : $("#namaGrup").val(),

					},
			url: this.url+'&tipe=saveEditGrup',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					document.getElementById("cmbGrup").innerHTML = resp.content.cmbGrup;
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	Close2:function(){
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
});