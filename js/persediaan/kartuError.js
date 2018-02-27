var kartuError = new DaftarObj2({
	prefix : 'kartuError',
	url : 'pages.php?Pg=kartuError',
	formName : 'kartuErrorForm',


	loading: function(idPersediaan){
		//alert('loading');
		this.topBarRender();
		this.filterRender(idPersediaan);
		this.daftarRender(idPersediaan);
		this.sumHalRender();

	},
	filterRender:  function(idPersediaan){
		var me=this;
		//render filter
		$.ajax({
		  url: this.url+'&tipe=filter',
		  type:'POST',
		  data:$('#'+this.formName).serialize()+"&idPersediaan="+idPersediaan,
		  success: function(data) {
			var resp = eval('(' + data + ')');
			document.getElementById(me.prefix+'_cont_opsi').innerHTML = resp.content;
			me.filterRenderAfter()
		  },
		  error: ajaxError
		});
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

	formatCurrency:function(num) {
		num = num.toString().replace(/\$|\,/g,'');
		if(isNaN(num))
		num = "0";
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num*100+0.50000000001);
		cents = num%100;
		num = Math.floor(num/100).toString();
		if(cents<10)
		cents = "0" + cents;
		for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+'.'+
		num.substring(num.length-(4*i+3));
		return (((sign)?'':'-') + '' + num + ',' + cents);
	},


	formatCurrencyy:function(num) {
		num = num.toString().replace(/\$|\,/g,'');
		if(isNaN(num))
		num = "0";
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num*100+0.50000000001);
		cents = num%100;
		num = Math.floor(num/100).toString();
		if(cents<10)
		cents = "0" + cents;
		for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+'.'+
		num.substring(num.length-(4*i+3));
		return (((sign)?'':'-') + '' + num);
	},

 sum : function(id) {
 	  var id = id;
      var jumlah = document.getElementById('jumlah'+id).value;
      var satuan = document.getElementById('satuan'+id).value;
      var harga = document.getElementById('harga'+id).value;
      var result = parseInt(jumlah) * parseInt(harga);
      var testSymbol=/^[0-9\_\-]{0,100}$/;

      if (harga == ""){
      	document.getElementById('total'+id).value ="";
      	 document.getElementById('bantuan'+id).textContent = "";
      }else{
      	 document.getElementById('bantuan'+id).textContent = this.formatCurrency(harga);
      }

      if (jumlah < 0){
      	document.getElementById('jumlah'+id).value ="";
      	 document.getElementById('bantuanJ'+id).textContent = "";
      }else{
      	 document.getElementById('bantuanJ'+id).textContent = this.formatCurrencyy(jumlah);
      }

      if (!isNaN(result)) {
         document.getElementById('total'+id).value = this.formatCurrency(result);
      }

      		$.ajax({
			type:'POST',
			data:{
					id : id,
					harga : harga,
					jumlah : jumlah,
					satuan : satuan
				 },
		  	url: this.url+'&tipe=Simpantmp',
		  	success: function(data) {
				var resp = eval('(' + data + ')');

		  	}
		});
},

	isNumberKey: function(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))

		return false;
		return true;
	},


	daftarRender:function(idPersediaan){
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
			data:$('#'+this.formName).serialize()+"&idPersediaan="+idPersediaan,
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

	windowSave: function(){
		var me= this;


			$.ajax({
			type : 'POST',
				url: 'pages.php?Pg=kartuError&tipe=setValueTemplate',
				data:{id : document.getElementById('idTemplate').value,
					  c  : document.getElementById('c').value,
					  d  : document.getElementById('d').value,
					  e  : document.getElementById('cmbUnit').value,
					  currentPosition : document.getElementById("kartuError_hal_fmHAL").value
					 },
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					var limit = resp.cek;

/*					document.getElementById('totalData').value = resp.cek;*/
					var arrayPostIdAndValue = [];
					var jsonID = JSON.parse(resp.content);
					for(var i = 0; i <= limit  ; i++) {

					   var IDnya = jsonID[i]['id'];
					   var jumlah = document.getElementById(IDnya).value;
					   arrayPostIdAndValue[i] = { "id": IDnya, "value" : jumlah };

					}


					 $.ajax({
						type : 'POST',
						url: 'http://123.231.253.228/atisisbada_v2/curl/updateTemplate.php',
						data:	{ result : JSON.stringify(arrayPostIdAndValue)
							 	 },
					  	success: function(data) {

						}
							});



			  	}
			});

	},
});
