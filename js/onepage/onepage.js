var onepage = new DaftarObj2({
	prefix : 'onepage',
	url : 'pages.php?Pg=onepage', 
	formName : 'onepageForm',
	el_kode_urusan : '',
	el_nama_urusan: '',
	
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
	},
	
	Cari: function(){
		var me = this;
		ManagementModulSystem2.windowShow();	
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
	formStatus:function(id){
		

			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formStatus'+"&idStatus="+id,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						$("#status option[value='']").remove();

					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});

		
	},

	Hapus:function(){
		
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();

			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=hapus',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
						if(resp.err == ''){
							me.refreshList(true);
						}else{
							var quest = confirm(resp.err);
							if(quest == true){
								me.deleteDownline();
								  setTimeout(function myFunction() {me.refreshList(true);},1000);

							}
						}
						
					
			  	}
			});
		}else{
			alert(errmsg);
		}
		
	},


	deleteDownline:function(){
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=deleteDownline',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					
					
			  	}
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
	
	
	selectEdit:function(){
		
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();

			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=checkEdit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if(resp.content.kategori == "SUB SUB SUB MODUL"){
						me.Edit();
					}else if(resp.content.kategori == "SUB SUB MODUL"){
						me.editSubSubModul(resp.content.id);
					}else if(resp.content.kategori == "SUB MODUL"){
						me.editSubModul(resp.content.id);
					}else if(resp.content.kategori == "MODUL"){
						me.editModul(resp.content.id);
					}else{
						me.editSystem(resp.content.id);
					}
			  	}
			});
		}else{
			alert(errmsg);
		}
		
	},

	saveStatus: function(id){
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
					status:$("#status").val()

					},
			url: this.url+'&tipe=saveStatus',
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
	
	newSystem: function(){	
		
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
			  	url: this.url+'&tipe=newSystem',
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
	
	newModul: function(){	
		
		var me = this;
		var err='';

		if($("#id_system").val() == ''){
			err = "Pilih System";
		}
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						id_system : $("#id_system").val(),		
					 },
			  	url: this.url+'&tipe=newModul',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	newSubModul: function(){	
		
		var me = this;
		var err='';

		if($("#id_system").val() == ''){
			err = "Pilih System";
		}else if($("#id_modul").val() == ''){
			err = "Pilih Modul";
		}
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						id_system : $("#id_system").val(),		
						id_modul : $("#id_modul").val(),		
					 },
			  	url: this.url+'&tipe=newSubModul',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	
	newSubSubModul: function(){	
		
		var me = this;
		var err='';

		if($("#id_system").val() == ''){
			err = "Pilih System";
		}else if($("#id_modul").val() == ''){
			err = "Pilih Modul";
		}else if($("#id_sub_modul").val() == ''){
			err = "Pilih Sub Modul";
		}
		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						id_system : $("#id_system").val(),		
						id_modul : $("#id_modul").val(),		
						id_sub_modul : $("#id_sub_modul").val(),		
					 },
			  	url: this.url+'&tipe=newSubSubModul',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	
	editSubSubModul: function(id){	
		
		var me = this;
		var err='';


		
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						id : id		
					 },
			  	url: this.url+'&tipe=editSubSubModul',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	
	editSubModul: function(id){	
		
		var me = this;
		var err='';


		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						id : id			
					 },
			  	url: this.url+'&tipe=editSubModul',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	editModul: function(id){	
		
		var me = this;
		var err='';


		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						id : id			
					 },
			  	url: this.url+'&tipe=editModul',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},
	editSystem: function(id){	
		
		var me = this;
		var err='';


		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:{
						id : id			
					 },
			  	url: this.url+'&tipe=editSystem',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;	
			  	}
			});
		}else{
		 	alert(err);
		}	
		
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
	Close2:function(){
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);			
	
			document.body.style.overflow='auto';						
		
	},
	
	saveNewSystem: function(){
		var me= this;
		var err='';
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:{	
					namaSystem : $("#namaSystem").val(),
					titleSystem : $("#titleSystem").val(),
					urlSystem : $("#urlSystem").val(),
					hintSystem : $("#hintSystem").val(),

					},
			url: this.url+'&tipe=saveNewSystem',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					document.getElementById("id_system").innerHTML = resp.content.cmbSystem;
					me.Close2();
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	saveNewModul: function(){
		var me= this;
		var err='';
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:{	
					id_system : $("#id_system").val(),
					namaModul : $("#namaModul").val(),
					titleModul : $("#titleModul").val(),
					urlModul : $("#urlModul").val(),
					hintModul : $("#hintModul").val(),

					},
			url: this.url+'&tipe=saveNewModul',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					document.getElementById("id_modul").innerHTML = resp.content.cmbModul;
					me.Close2();
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	saveNewSubModul: function(){
		var me= this;
		var err='';
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:{	
					id_system : $("#id_system").val(),
					id_modul : $("#id_modul").val(),
					namaSubModul : $("#namaSubModul").val(),
					titleSubModul : $("#titleSubModul").val(),
					urlSubModul : $("#urlSubModul").val(),
					hintSubModul : $("#hintSubModul").val(),

					},
			url: this.url+'&tipe=saveNewSubModul',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					document.getElementById("id_sub_modul").innerHTML = resp.content.cmbSubModul;
					me.Close2();
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	saveNewSubSubModul: function(){
		var me= this;
		var err='';
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:{	
					id_system : $("#id_system").val(),
					id_modul : $("#id_modul").val(),
					id_sub_modul : $("#id_sub_modul").val(),
					namaSubSubModul : $("#namaSubSubModul").val(),
					titleSubSubModul : $("#titleSubSubModul").val(),
					urlSubSubModul : $("#urlSubSubModul").val(),
					hintSubSubModul : $("#hintSubSubModul").val(),

					},
			url: this.url+'&tipe=saveNewSubSubModul',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					document.getElementById("id_sub_sub_modul").innerHTML = resp.content.cmbSubSubModul;
					me.Close2();
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	
	
	saveeditSubSubModul: function(id){
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
					status : $("#status").val(),
					namaSubSubModul : $("#namaSubSubModul").val(),
					titleSubSubModul : $("#titleSubSubModul").val(),
					urlSubSubModul : $("#urlSubSubModul").val(),
					hintSubSubModul : $("#hintSubSubModul").val(),

					},
			url: this.url+'&tipe=saveeditSubSubModul',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshList(true);
					me.Close2();
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	saveeditSubModul: function(id){
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
					status : $("#status").val(),
					namaSubModul : $("#namaSubModul").val(),
					titleSubModul : $("#titleSubModul").val(),
					urlSubModul : $("#urlSubModul").val(),
					hintSubModul : $("#hintSubModul").val(),

					},
			url: this.url+'&tipe=saveeditSubModul',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshList(true);
					me.Close2();
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	
	saveeditModul: function(id){
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
					status : $("#status").val(),
					namaModul : $("#namaModul").val(),
					titleModul : $("#titleModul").val(),
					urlModul : $("#urlModul").val(),
					hintModul : $("#hintModul").val(),

					},
			url: this.url+'&tipe=saveeditModul',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshList(true);
					me.Close2();
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	saveeditSystem: function(id){
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
					status : $("#status").val(),
					namaSystem : $("#namaSystem").val(),
					titleSystem : $("#titleSystem").val(),
					urlSystem : $("#urlSystem").val(),
					hintSystem : $("#hintSystem").val(),

					},
			url: this.url+'&tipe=saveeditSystem',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshList(true);
					me.Close2();

					
					
					
				}else{
					alert(resp.err);
				}
		  	}
		});
		
	},
	systemChanged: function(){
		var me= this;	

		$.ajax({
			type:'POST', 
			data:{id_system : $("#id_system").val()},
			url: this.url+'&tipe=systemChanged',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				document.getElementById('id_modul').innerHTML = resp.content.cmbModul;
				document.getElementById('id_sub_modul').innerHTML = resp.content.cmbSubModul;
				document.getElementById('id_sub_sub_modul').innerHTML = resp.content.cmbSubSubModul;
		  	}
		});
	},
	
	modulChanged: function(){
		var me= this;	

		$.ajax({
			type:'POST', 
			data:{
					id_system : $("#id_system").val(),
					id_modul : $("#id_modul").val(),
						
					},
			url: this.url+'&tipe=modulChanged',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				document.getElementById('id_sub_modul').innerHTML = resp.content.cmbSubModul;
				document.getElementById('id_sub_sub_modul').innerHTML = resp.content.cmbSubSubModul;
		  	}
		});
	},
	
	subModulChanged: function(){
		var me= this;	

		$.ajax({
			type:'POST', 
			data:{
					id_system : $("#id_system").val(),
					id_modul : $("#id_modul").val(),
					id_sub_modul: $("#id_sub_modul").val(),
						
					},
			url: this.url+'&tipe=subModulChanged',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				document.getElementById('id_sub_sub_modul').innerHTML = resp.content.cmbSubSubModul;
		  	}
		});
	},
	
});