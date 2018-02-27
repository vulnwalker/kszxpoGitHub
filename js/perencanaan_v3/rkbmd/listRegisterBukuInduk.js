var listRegisterBukuInduk = new DaftarObj2({
	prefix : 'listRegisterBukuInduk',
	url : 'pages.php?Pg=listRegisterBukuInduk',
	formName : 'listRegisterBukuIndukForm',
	c1 : '',
	c : '',
	d : '',
	e : '',
	e1 : '',
	kodeBarang : '',


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
			//UserAktivitasDet.genDetail();

		}else{

			alert(errmsg);
		}

	},

	 checkSemua : function(  n, fldName ,elHeaderChecked, elJmlCek) {

			if (!fldName) {
				fldName = 'cb';
			}
			if (!elHeaderChecked) {
				elHeaderChecked = 'toggle';
			}
			var c = document.getElementById(elHeaderChecked).checked;
			var n2 = 0;
			for (i=0; i < n ; i++) {
			 cb = document.getElementById(fldName+i);
			 if (cb) {
				 cb.checked = c;

				  this.thisChecked($("#"+fldName+i).val(),fldName+i);
				 n2++;
			 }
			}
			if (c) {
			 document.getElementById(elJmlCek).value = n2;
			} else {
			 document.getElementById(elJmlCek).value = 0;
			}
			},
	findRekening : function(){
		var me = this;
		var filterRek = "BELANJA MODAL";

		popupRekening.el_kode_rekening = 'kodeRekening';
		popupRekening.el_nama_rekening = 'namaRekening';
		popupRekening.windowSaveAfter= function(){};
		popupRekening.filterAkun=filterRek;
		popupRekening.windowShow();

	},
	thisChecked:function(idSource,idCheckBox){

		var status ="";
		if(document.getElementById(idCheckBox).checked ){
			status = "checked";
		}else{
			status = "";
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
			data:$('#'+this.formName).serialize()+"&c1="+me.c1+"&c="+me.c+"&d="+me.d+"&e="+me.e+"&e1="+me.e1+"&kodeBarang="+me.kodeBarang,
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				document.getElementById(me.prefix+'_cont_daftar').innerHTML = resp.content;
				me.sumHalRender();
		  	}
		});
	},

		windowShow: function(id){
		var me = this;

		var cover = this.prefix+'_cover';


		document.body.style.overflow='hidden';
		addCoverPage2(cover,10,true,false);
		$.ajax({
			type:'POST',
			data:{id : id},
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
		template.refreshList(true);
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');

	},

	


});
