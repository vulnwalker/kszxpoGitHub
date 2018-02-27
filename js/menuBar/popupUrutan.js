var popupUrutan = new DaftarObj2({
	prefix : 'popupUrutan',
	url : 'pages.php?Pg=popupUrutan',
	formName : 'popupUrutanForm',
	el_kode_rekening : '',
	el_nama_rekening: '',
	el_tahun_rekening:'',
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
	up:function(id){
		var me = this;

		$.ajax({
			type:'POST',
			data:{id:id},
		  	url: this.url+'&tipe=up',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					me.refreshList(true);
				}else{
					alert(resp.err);
				}

		  	}
		});
	},
	down:function(id){
		var me = this;

		$.ajax({
			type:'POST',
			data:{id:id},
		  	url: this.url+'&tipe=down',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					me.refreshList(true);
				}else{
					alert(resp.err);
				}

		  	}
		});
	},

	windowShow: function(idUpline){
		var me = this;
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=windowshow&upline='+idUpline,
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


			var cover = 'popupUrutan_getdata';
			addCoverPage2(cover,1,true,false);
			$.ajax({
				type : 'POST',
				url: 'pages.php?Pg=popupUrutan&tipe=getdata&id='+id,
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					delElem(cover);
					if(resp.err==''){
						me.windowClose();
						menuBar.refreshList(true);
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
	}
});
