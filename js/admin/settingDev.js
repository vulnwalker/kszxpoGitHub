var settingDev = new DaftarObj2({
	prefix : 'settingDev',
	url : 'pages.php?Pg=settingDev',
	formName : 'settingDevForm',
	satuan_form : '0',//default js satuan
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		//this.daftarRender();
		//this.sumHalRender();

	},

	detail: function(){
		//alert('detail');
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();
			//UserAktivitasDet.genDetail();

		}else{

			alert(errmsg);
		}

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
					if(me.satuan_form==0){
						me.Close();
						me.AfterSimpan();
					}else{
						me.Close();
						barang.refreshComboSatuan();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	SimpanData:function(Id){
		$.ajax({
			type:'POST',
			data:{
			  		Id : Id,
			  		label       : $("#label"+Id).val(),
					nilai    : $("#nilai"+Id).val(),
					urut    : $("#urut"+Id).val(),
					uid      : $("#uid"+Id).val(),
					tgl_update : $("#tgl_update"+Id).val(),
					},
			url: this.url+'&tipe=SimpanData',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				document.getElementById("TablePenatausahaan").innerHTML = resp.content;
			}
		});
	},
	BatalData:function(Id){
		$.ajax({
			type:'POST',
			data: { Id 	: Id,
					},
			url: this.url+'&tipe=jaditd',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				document.getElementById("TablePenatausahaan").innerHTML = resp.content;
			}
		});
	},
	ChangeType:function(Id){
		$.ajax({
			type:'POST',
			data: { Id 	: Id,
					},
			url: this.url+'&tipe=jadiinput',
			success: function(data) {	
				var resp = eval('(' + data + ')');
				document.getElementById(Id).innerHTML = resp.content;
			}
		});
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
		var err='';

		if (err =='' ){
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			if(me.satuan_form==0){//baru dari satuan
				addCoverPage2(cover,1,true,false);
			}else{//baru dari barang
				addCoverPage2(cover,999,true,false);
			}
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;
					me.AfterFormBaru();
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
			addCoverPage2(cover,999,true,false);
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formEdit',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						me.AfterFormEdit(resp);
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

	UbahData: function(){
		var me=this;

		$.ajax({
			type:'POST',
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=UbahPengaturan',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					document.getElementById('DaftarPengaturan').innerHTML = resp.content;
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	changeidSetting: function(){
		var me = this;
		$.ajax({
			type:'POST',
			data:{
				idSetting: $("#idSetting").val()
			},
			url: this.url+'&tipe=changeidSetting',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					document.getElementById('labelSetting').value = resp.content.label;
					document.getElementById('nilaiSetting').value = resp.content.nilai;
					document.getElementById('urutSetting').value = resp.content.urut;
				}else{
					alert(resp.err);
				}
		  	}
		});
	},

	SimpanUbahData: function(){
		var me=this;
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=SimpanUbah',
		  	success: function(data) {
					delElem(cover);
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					settingDev.loading();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	imageChanged: function(){
  var me= this;
  var filesSelected = document.getElementById("imageFile").files;
  if (filesSelected.length > 0)
  {
    var fileToLoad = filesSelected[0];

    var fileReader = new FileReader();

    fileReader.onload = function(fileLoadedEvent)
    {
      var textAreaFileContents = document.getElementById
      (
        "siteImage"
      );

      textAreaFileContents.value = fileLoadedEvent.target.result;
			$("#imageView").attr("src", fileLoadedEvent.target.result);
    };

    fileReader.readAsDataURL(fileToLoad);
  }
}



});
