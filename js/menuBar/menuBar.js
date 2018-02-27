var menuBar = new DaftarObj2({
	prefix : 'menuBar',
	url : 'pages.php?Pg=menuBar',
	formName : 'menuBarForm',
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

	Urut:function(){

		var me = this;
		var err = "";
		if(err ==''){


			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=Urut',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
						if (resp.err ==''){
							popupUrutan.windowShow(resp.content.upline);
						}else{
							alert(resp.err);
						}
			  	}
			});
		}else{
			alert(elCurrPage);
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

				if(resp.err=='' || $("#title").val() == ''){
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

	menuBarChanged: function(){
		var me= this;

		$.ajax({
			type:'POST',
			data:{
					menuBar : $("#cmbMenuBar").val(),
					},
			url: this.url+'&tipe=menuBarChanged',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				document.getElementById('cmbMenu').innerHTML = resp.content.cmbMenu;
				document.getElementById('cmbSubMenu').innerHTML = resp.content.cmbSubMenu;
				document.getElementById('cmbSubSubMenu').innerHTML = resp.content.cmbSubSubMenu;
				document.getElementById('cmbLevel5').innerHTML = resp.content.cmbLevel5;
		  	}
		});
	},

	menuChanged: function(){
		var me= this;

		$.ajax({
			type:'POST',
			data:{
					menu : $("#cmbMenu").val(),
					},
			url: this.url+'&tipe=menuChanged',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				document.getElementById('cmbSubMenu').innerHTML = resp.content.cmbSubMenu;
				document.getElementById('cmbSubSubMenu').innerHTML = resp.content.cmbSubSubMenu;
				document.getElementById('cmbLevel5').innerHTML = resp.content.cmbLevel5;
		  	}
		});
	},

	subMenuChanged: function(){
		var me= this;

		$.ajax({
			type:'POST',
			data:{
					subMenu : $("#cmbSubMenu").val(),
					},
			url: this.url+'&tipe=subMenuChanged',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				document.getElementById('cmbSubSubMenu').innerHTML = resp.content.cmbSubSubMenu;
				document.getElementById('cmbLevel5').innerHTML = resp.content.cmbLevel5;
		  	}
		});
	},

	subSubMenuChanged: function(){
		var me= this;

		$.ajax({
			type:'POST',
			data:{
					subSubMenu : $("#cmbSubSubMenu").val(),
					},
			url: this.url+'&tipe=subSubMenuChanged',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				document.getElementById('cmbLevel5').innerHTML = resp.content.cmbLevel5;
		  	}
		});
	},
	newMenuBar: function(){

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
			  	url: this.url+'&tipe=newMenuBar',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	newMenu: function(){

		var me = this;
		var err='';

		if($("#cmbMenuBar").val() == ''){
			err = "Pilih Menu Bar";
		}

		if (err =='' ){
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type:'POST',
				data:{
						menuBar : $("#cmbMenuBar").val(),
					 },
			  	url: this.url+'&tipe=newMenu',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	newSubMenu: function(){

		var me = this;
		var err='';

		if($("#cmbMenuBar").val() == ''){
			err = "Pilih  Menu Bar";
		}else if($("#cmbMenu").val() == ''){
			err = "Pilih  Menu ";
		}

		if (err =='' ){
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type:'POST',
				data:{
						menuBar : $("#cmbMenuBar").val(),
						menu : $("#cmbMenu").val(),
					 },
			  	url: this.url+'&tipe=newSubMenu',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},


	newSubSubMenu: function(){

		var me = this;
		var err='';

		if($("#cmbMenuBar").val() == ''){
			err = "Pilih  Menu Bar";
		}else if($("#cmbMenu").val() == ''){
			err = "Pilih  Menu ";
		}else if($("#cmbSubMenu").val() == ''){
			err = "Pilih Sub Menu ";
		}

		if (err =='' ){
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type:'POST',
				data:{
						menuBar : $("#cmbMenuBar").val(),
						menu : $("#cmbMenu").val(),
						subMenu : $("#cmbSubMenu").val(),
					 },
			  	url: this.url+'&tipe=newSubSubMenu',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	newLevel5: function(){

		var me = this;
		var err='';

		if($("#cmbMenuBar").val() == ''){
			err = "Pilih  Menu Bar";
		}else if($("#cmbMenu").val() == ''){
			err = "Pilih  Menu ";
		}else if($("#cmbSubMenu").val() == ''){
			err = "Pilih Sub Menu ";
		}else if($("#cmbSubSubMenu").val() == ''){
			err = "Pilih Sub Sub Menu ";
		}

		if (err =='' ){
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type:'POST',
				data:{
						menuBar : $("#cmbMenuBar").val(),
						menu : $("#cmbMenu").val(),
						subMenu : $("#cmbSubMenu").val(),
						subSubMenu : $("#cmbSubSubMenu").val(),
					 },
			  	url: this.url+'&tipe=newLevel5',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},




	editMenuBar: function(){

		var me = this;
		var err='';

		if($("#cmbMenuBar").val() == ''){
			err = "Pilih Menu Bar";
		}

		if (err =='' ){
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type:'POST',
				data:{
						menuBar : $("#cmbMenuBar").val(),
					 },
			  	url: this.url+'&tipe=editMenuBar',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	editMenu: function(){

		var me = this;
		var err='';

		if($("#cmbMenuBar").val() == ''){
			err = "Pilih Menu Bar";
		}else if($("#cmbMenu").val() == ''){
			err = "Pilih Menu";
		}

		if (err =='' ){
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type:'POST',
				data:{
						menuBar : $("#cmbMenuBar").val(),
						menu : $("#cmbMenu").val(),
					 },
			  	url: this.url+'&tipe=editMenu',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},


	editSubMenu: function(){

		var me = this;
		var err='';

		if($("#cmbMenuBar").val() == ''){
			err = "Pilih Menu Bar";
		}else if($("#cmbMenu").val() == ''){
			err = "Pilih Menu";
		}else if($("#cmbSubMenu").val() == ''){
			err = "Pilih Sub Menu";
		}

		if (err =='' ){
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type:'POST',
				data:{
						menuBar : $("#cmbMenuBar").val(),
						menu : $("#cmbMenu").val(),
						subMenu : $("#cmbSubMenu").val(),
					 },
			  	url: this.url+'&tipe=editSubMenu',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},


	editSubSubMenu: function(){

		var me = this;
		var err='';

		if($("#cmbMenuBar").val() == ''){
			err = "Pilih Menu Bar";
		}else if($("#cmbMenu").val() == ''){
			err = "Pilih Menu";
		}else if($("#cmbSubMenu").val() == ''){
			err = "Pilih Sub Menu";
		}else if($("#cmbSubSubMenu").val() == ''){
			err = "Pilih Sub Sub Menu";
		}

		if (err =='' ){
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type:'POST',
				data:{
						menuBar : $("#cmbMenuBar").val(),
						menu : $("#cmbMenu").val(),
						subMenu : $("#cmbSubMenu").val(),
						subSubMenu : $("#cmbSubSubMenu").val(),
					 },
			  	url: this.url+'&tipe=editSubSubMenu',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},


	editLevel5: function(){

		var me = this;
		var err='';

		if($("#cmbMenuBar").val() == ''){
			err = "Pilih Menu Bar";
		}else if($("#cmbMenu").val() == ''){
			err = "Pilih Menu";
		}else if($("#cmbSubMenu").val() == ''){
			err = "Pilih Sub Menu";
		}else if($("#cmbSubSubMenu").val() == ''){
			err = "Pilih Sub Sub Menu";
		}else if($("#cmbLevel5").val() == ''){
			err = "Pilih Level 5";
		}

		if (err =='' ){
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type:'POST',
				data:{
						menuBar : $("#cmbMenuBar").val(),
						menu : $("#cmbMenu").val(),
						subMenu : $("#cmbSubMenu").val(),
						subSubMenu : $("#cmbSubSubMenu").val(),
						id : $("#cmbLevel5").val(),
					 },
			  	url: this.url+'&tipe=editLevel5',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	formEditSubMenu: function(id){

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
			  	url: this.url+'&tipe=formEditSubMenu',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	formEditSubSubMenu: function(id){

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
			  	url: this.url+'&tipe=formEditSubSubMenu',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	formEditLevel5: function(id){

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
			  	url: this.url+'&tipe=formEditLevel5',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	formEditLevel6: function(id){

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
			  	url: this.url+'&tipe=formEditLevel6',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	formEditSubMenu: function(id){

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
			  	url: this.url+'&tipe=formEditSubMenu',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	formEditMenu: function(id){

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
			  	url: this.url+'&tipe=formEditMenu',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	formEditMenuBar: function(id){

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
			  	url: this.url+'&tipe=formEditMenuBar',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});
		}else{
		 	alert(err);
		}

	},

	Close2:function(){
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);
		document.body.style.overflow='auto';
	},

	saveNewMenuBar: function(){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleMenuBar : $("#titleMenuBar").val(),

					},
			url: this.url+'&tipe=saveNewMenuBar',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById('cmbMenuBar').innerHTML = resp.content.cmbMenuBar;
					document.getElementById('cmbMenu').innerHTML = resp.content.cmbMenu;
					document.getElementById('cmbSubMenu').innerHTML = resp.content.cmbSubMenu;
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

	},

	saveNewMenu: function(){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleMenu : $("#titleMenu").val(),
					menuBar :$("#cmbMenuBar").val()

					},
			url: this.url+'&tipe=saveNewMenu',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById('cmbMenu').innerHTML = resp.content.cmbMenu;
					document.getElementById('cmbSubMenu').innerHTML = resp.content.cmbSubMenu;
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

	},

	saveNewSubMenu: function(){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleSubMenu : $("#titleSubMenu").val(),
					menuBar :$("#cmbMenuBar").val(),
					menu :$("#cmbMenu").val(),

					},
			url: this.url+'&tipe=saveNewSubMenu',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById('cmbSubMenu').innerHTML = resp.content.cmbSubMenu;
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

	},


	saveNewSubSubMenu: function(){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleSubSubMenu : $("#titleSubSubMenu").val(),
					menuBar :$("#cmbMenuBar").val(),
					menu :$("#cmbMenu").val(),
					subMenu :$("#cmbSubMenu").val(),

					},
			url: this.url+'&tipe=saveNewSubSubMenu',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById('cmbSubSubMenu').innerHTML = resp.content.cmbSubSubMenu;
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

	},


	saveNewLevel5: function(){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleLevel5 : $("#titleLevel5").val(),
					menuBar :$("#cmbMenuBar").val(),
					menu :$("#cmbMenu").val(),
					subMenu :$("#cmbSubMenu").val(),
					subSubMenu :$("#cmbSubSubMenu").val(),

					},
			url: this.url+'&tipe=saveNewLevel5',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById('cmbLevel5').innerHTML = resp.content.cmbLevel5;
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

	},


	saveEditMenuBar: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleMenuBar : $("#titleMenuBar").val(),
					id: id

					},
			url: this.url+'&tipe=saveEditMenuBar',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById('cmbMenuBar').innerHTML = resp.content.cmbMenuBar;
					document.getElementById('cmbMenu').innerHTML = resp.content.cmbMenu;
					document.getElementById('cmbSubMenu').innerHTML = resp.content.cmbSubMenu;
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

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

	saveNomorUrut: function(id){
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
					nomorUrut : $("#nomorUrut").val()

					},
			url: this.url+'&tipe=saveNomorUrut',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				document.body.style.overflow='auto';
				if(resp.err==''){
					me.daftarRender();
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

	},


	saveEditMenu: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleMenu : $("#titleMenu").val(),
					menuBar : $("#cmbMenuBar").val(),
					id: $("#cmbMenu").val(),

					},
			url: this.url+'&tipe=saveEditMenu',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById('cmbMenu').innerHTML = resp.content.cmbMenu;
					document.getElementById('cmbSubMenu').innerHTML = resp.content.cmbSubMenu;
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

	},

	saveEditSubMenu: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleSubMenu : $("#titleSubMenu").val(),
					menuBar : $("#cmbMenuBar").val(),
					menu : $("#cmbMenu").val(),
					id: $("#cmbSubMenu").val(),

					},
			url: this.url+'&tipe=saveEditSubMenu',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById('cmbSubMenu').innerHTML = resp.content.cmbSubMenu;
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

	},

	saveEditSubSubMenu: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleSubSubMenu : $("#titleSubSubMenu").val(),
					menuBar : $("#cmbMenuBar").val(),
					menu : $("#cmbMenu").val(),
					subMenu : $("#cmbSubMenu").val(),
					id: $("#cmbSubSubMenu").val(),

					},
			url: this.url+'&tipe=saveEditSubSubMenu',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById('cmbSubSubMenu').innerHTML = resp.content.cmbSubSubMenu;
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

	},


	saveEditLevel5: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleLevel5 : $("#titleLevel5").val(),
					menuBar : $("#cmbMenuBar").val(),
					menu : $("#cmbMenu").val(),
					subMenu : $("#cmbSubMenu").val(),
					subSubMenu: $("#cmbSubSubMenu").val(),
					id: $("#cmbLevel5").val(),

					},
			url: this.url+'&tipe=saveEditLevel5',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById('cmbLevel5').innerHTML = resp.content.cmbLevel5;
					me.Close2();

				}else{
					alert(resp.err);
				}
		  	}
		});

	},




	saveEditFormSubMenu: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleSubMenu : $("#titleSubMenu").val(),
					id: id,

					},
			url: this.url+'&tipe=saveEditFormSubMenu',
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

	saveEditFormSubSubMenu: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleSubSubMenu : $("#titleSubSubMenu").val(),
					id: id,

					},
			url: this.url+'&tipe=saveEditFormSubSubMenu',
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

	saveEditFormLevel5: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleLevel5 : $("#titleLevel5").val(),
					id: id,

					},
			url: this.url+'&tipe=saveEditFormLevel5',
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

	saveEditFormLevel6: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleLevel6 : $("#titleLevel6").val(),
					id: id,

					},
			url: this.url+'&tipe=saveEditFormLevel6',
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


	saveEditFormMenu: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleMenu : $("#titleMenu").val(),
					id: id,

					},
			url: this.url+'&tipe=saveEditFormMenu',
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


	saveEditFormMenuBar: function(id){
		var me= this;
		var err='';
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:{
					titleMenuBar : $("#titleMenuBar").val(),
					id: id,

					},
			url: this.url+'&tipe=saveEditFormMenuBar',
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
					if(resp.content.kategori == "6"){
						me.formEditLevel6(resp.content.id);
					}else if(resp.content.kategori == "5"){
						me.formEditLevel5(resp.content.id);
					}else if(resp.content.kategori == "4"){
						me.formEditSubSubMenu(resp.content.id);
					}else if(resp.content.kategori == "3"){
						me.formEditSubMenu(resp.content.id);
					}else if(resp.content.kategori == "2"){
						me.formEditMenu(resp.content.id);
					}else if(resp.content.kategori == "1"){
						me.formEditMenuBar(resp.content.id);
					}
			  	}
			});
		}else{
			alert(errmsg);
		}

	},

});
