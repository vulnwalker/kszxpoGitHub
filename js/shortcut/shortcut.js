var shortcut = new DaftarObj2({
	prefix : 'shortcut',
	url : 'pages.php?Pg=shortcut',
	formName : 'shortcutForm',
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



	showImage:function(id){

		var me = this;
		var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize()+"&id="+id,
				url: this.url+'&tipe=showImage',
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


	grupChanged:function(){
			$.ajax({
				type:'POST',
				data:{
						'idKategori' : $("#cmbGrup").val(),
						},
				url: this.url+'&tipe=grupChanged',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById('row').innerHTML = resp.content.comboRow;
					document.getElementById('kolom').innerHTML = resp.content.comboKolom;

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
					cmbMenuBar : $("#cmbMenuBar").val(),
					title : $("#titleKategori").val(),
					url : $("#urlKategori").val(),
					contentHeight : $("#contentHeight").val(),
					contentBackground : $("#contentBackground").val(),
					maxRow : $("#maxRow").val(),
					maxKolom : $("#maxKolom").val(),
					},
			url: this.url+'&tipe=saveNewGrup',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById("cmbGrup").innerHTML = resp.content.cmbGrup;
					me.grupChanged();
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
					$("#contentBackground").spectrum({
							color: resp.cek,
							showInput: true,
							className: "full-spectrum",
							showInitial: true,
							showPalette: true,
							showSelectionPalette: true,
							maxSelectionSize: 10,
							preferredFormat: "hex",
							localStorageKey: "spectrum.demo",
							move: function (color) {

							},
							show: function () {

							},
							beforeShow: function () {

							},
							hide: function () {

							},
							change: function() {

							},
							palette: [
									["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
									"rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
									["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
									"rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
									["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
									"rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
									"rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
									"rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
									"rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
									"rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
									"rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
									"rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
									"rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
									"rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
							]
					});
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
			err = "Pilih Kategori";
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
					$("#contentBackground").spectrum({
							color: resp.cek,
							showInput: true,
							className: "full-spectrum",
							showInitial: true,
							showPalette: true,
							showSelectionPalette: true,
							maxSelectionSize: 10,
							preferredFormat: "hex",
							localStorageKey: "spectrum.demo",
							move: function (color) {

							},
							show: function () {

							},
							beforeShow: function () {

							},
							hide: function () {

							},
							change: function() {

							},
							palette: [
									["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
									"rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
									["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
									"rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
									["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
									"rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
									"rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
									"rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
									"rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
									"rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
									"rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
									"rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
									"rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
									"rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
							]
					});
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
					cmbMenuBar : $("#cmbMenuBar").val(),
					title : $("#titleKategori").val(),
					url : $("#urlKategori").val(),
					maxRow : $("#maxRow").val(),
					maxKolom : $("#maxKolom").val(),
					contentHeight : $("#contentHeight").val(),
					contentBackground : $("#contentBackground").val(),

					},
			url: this.url+'&tipe=saveEditGrup',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);

				if(resp.err==''){
					document.getElementById("cmbGrup").innerHTML = resp.content.cmbGrup;
					me.grupChanged();
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
		document.body.style.overflow='auto';
	},

});
