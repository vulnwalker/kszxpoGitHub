var popupImages = new DaftarObj2({
	prefix : 'popupImages',
	url : 'pages.php?Pg=popupImages',
	formName : 'popupImagesForm',
	typeImage : '',

	filterAkun : '',

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

	windowShow: function(){
		var me = this;
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=windowshow&filterAkun='+this.filterAkun,
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

	windowSave: function(id){
		var me= this;


			var cover = 'popupImages_getdata';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type : 'POST',
				url: 'pages.php?Pg=popupImages&tipe=getdata&id='+id,
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					delElem(cover);
					if(resp.err==''){
						if(me.typeImage =='pasif'){
							$("#namaImagePasif").val(resp.content.nama);
							$("#imagePasif").val(id);
							document.getElementById('spanImagePasif').innerHTML = resp.content.imageView;
						}else if(me.typeImage =='aktif'){
							$("#namaImageAktif").val(resp.content.nama);
							$("#imageAktif").val(id);
							document.getElementById('spanImageAktif').innerHTML = resp.content.imageView;
						}else if(me.typeImage =='headerLogo'){
							$("#headerLogo").val(id);
							$("#imageView").attr('src',resp.content.imageLocation);
						}else if(me.typeImage =='siteImage'){
							$("#siteImage").val(id);
							$("#imageView").attr('src',resp.content.imageLocation);
						}else if(me.typeImage =='contentImage'){
							$("#contentImage").val(id);
							$("#imageView").attr('src',resp.content.imageLocation);
						}else if(me.typeImage =='headerImage'){
							$("#headerImage").val(id);
							$("#imageView").attr('src',resp.content.imageLocation);
						}else if(me.typeImage =='footerImage'){
							$("#footerImage").val(id);
							$("#imageView").attr('src',resp.content.imageLocation);
						}

						me.windowClose();
						me.windowSaveAfter();
					}else{
						alert(resp.err)
					}
			  	}
			});





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
});
