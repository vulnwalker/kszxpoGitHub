var popupSource = new DaftarObj2({
	prefix : 'popupSource',
	url : 'pages.php?Pg=popupSource',
	formName : 'popupSourceForm',
	el_namaModul : '',
	el_idModul: '',

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
		addCoverPage2(cover,999,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.formName).serialize(),
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

		var box = this.GetCbxChecked();
		var jsonID = JSON.stringify(box);
		var cover = 'popupSource_getdata';
		addCoverPage2(cover,1,true,false);
		var me = this;
		$.ajax({
		  url: this.url+'&tipe=getdata',
		  type : 'POST',
		  data : $('#'+this.formName).serialize(),
		  success: function(data) {
		  var resp = eval('('+data+')');

		  		if (resp.err != '') {
					alert(resp.err);
				}else{

		  	delElem(cover);
			$("#listUpdate").html(resp.content.listUpdate);
			$("#listItem").val(resp.content.arrayList);
			$("#listPosisi").val(resp.content.arrayPosisi);
			me.windowClose();
		}
		  }
		});






	},
	windowSaveAfter: function(){
		//alert('tes');
	},	

	thisChecked:function(idSource,idCheckBox){
		
		var status ="";
		if(document.getElementById(idCheckBox).checked ){
			status = "checked";
			 $("#cmbStatus"+idSource).removeAttr("disabled");
		}else{
			status = "";
			$("#cmbStatus"+idSource).attr('disabled',true);
			$("#cmbStatus"+idSource).val('');
		}
		$.ajax({
			type:'POST', 
			data:{
					id : idSource,
					jenis : status	
				 },
		  	url: this.url+'&tipe=checkboxChanged',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				
		  	}
		});
	},

		thisPosisi:function(idSource){
		
		var posisi = document.getElementById("cmbStatus"+idSource).value;
		$.ajax({
			type:'POST', 
			data:{
					posisi : posisi,
					idSource : idSource

				 },
		  	url: this.url+'&tipe=posisiChanged',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if (resp.err != '') {
					alert(resp.err);
					$("#cmbStatus"+idSource).val('');
				}
				
		  	}
		});
	},

	AfterSimpan : function(idSource){
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
