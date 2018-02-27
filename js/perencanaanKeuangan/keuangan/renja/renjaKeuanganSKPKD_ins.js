var renjaKeuanganSKPKD_insSKPD = new SkpdCls({
	prefix : 'renjaKeuanganSKPKD_insSKPD', formName:'renjaKeuanganSKPKD_insForm', kolomWidth:120,

	a : function(){
		alert('dsf');
	},
});

var renjaKeuanganSKPKD_ins = new DaftarObj2({
	prefix : 'renjaKeuanganSKPKD_ins',
	url : 'pages.php?Pg=renjaKeuanganSKPKD_ins',
	formName : 'renjaKeuanganSKPKD_insForm',
	satuan_form : '0',//default js satuan
	


	loading: function(){

		this.topBarRender();
		this.filterRender();


	},

	closeTab : function(){
		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		$.ajax({
		  url: this.url+'&tipe=CekKosong',
		  type : 'POST',
		  data:{  c1 : c1,
		  		  c	  : c,
				  d : d,
				  tahunAnggaran : $("#tahunAnggaran").val()
				 },
		  success: function(data) {
		 	    window.opener.location.reload();
				var ww = window.open(window.location, '_self');
				ww.close();

		  }
		});

	},


	BidangAfterform: function(){
		var me = this;
		var arrayC1 = $("#urusan").val().split('.');
		var arrayC = $("#bidang").val().split('.');
		var arrayD = $("#skpd").val().split('.');
		var c1 = arrayC1[0];
		var c = arrayC[0];
		var d = arrayD[0];
		$.ajax({
		  url: this.url+'&tipe=BidangAfterForm',
		  type : 'POST',
		  data:{ fmSKPDBidang: c,
		  		 fmSKPDUrusan: c1,
		  		 fmSKPDskpd: d,
		  		 fmSKPDUnit: $("#cmbUnitForm").val(),
		  		 fmSKPDSubUnit: $("#cmbSubUnitForm").val() },
		  success: function(data) {
			var resp = eval('(' + data + ')');
				document.getElementById('cmbSubUnitForm').innerHTML=resp.content.subunit;
		  }
		});

	},


	rincianpenerimaan: function(){

		$('.datepicker').datepicker({
						    dateFormat: 'dd-mm-yy',
							showAnim: 'slideDown',
						    inline: true,
							showOn: "button",
     						buttonImage: "images/calendar.gif",
      						buttonImageOnly: true,
							changeMonth: true,
      						changeYear: true,
							yearRange: "+1:+5",
							buttonText : '',
							defaultDate: +365
		});
		var jenisKegiatan = document.getElementById("jenisKegiatan");
		jenisKegiatan.remove(0);
		$.ajax({
			type:'POST',
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=rincianpenerimaanDET',
			success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					document.getElementById('rinciandatabarangnya').innerHTML = resp.content;
					setTimeout(function myFunction() {renjaKeuanganSKPKD_ins.CekSesuai()},1000);
					$("#keyPP").text("Rp. "+popupProgram.formatCurrency($("#plus").val()));
					$("#keyMM").text("Rp. "+popupProgram.formatCurrency($("#minus").val()));
				}else{
					alert(resp.err);
				}
			}
		});

	},
    CariProgramKegiatan: function(){
		var me = this;
		popupProgramRenjaAset.windowShow();
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

	EDIT:function(){
		$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=EDIT',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						alert("Data Tersimpan");

							window.opener.location.reload();
							var ww = window.open(window.location, '_self');
		 					ww.close();


					}else{
						alert(resp.err);
					}
				}
			});

	},

	Simpan: function(){
		$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=Simpan',
				success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						alert("Data Tersimpan");
						if (confirm('Input Lagi ?')) {
							window.location.reload();
						}else{
							window.opener.location.reload();
							var ww = window.open(window.location, '_self');
		 					ww.close();

						}
					}else{
						alert(resp.err);
					}
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

	isNumberKey: function(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))

		return false;
		return true;
	},


	jenisChanged: function(){
		var me = this;
		$.ajax({
		  url: this.url+'&tipe=jenisChanged',
		  type : 'POST',
		  data:{ jenisKegiatan: $("#jenisKegiatan").val()},
		  success: function(data) {
			var resp = eval('(' + data + ')');
				document.getElementById('tempatPlus').innerHTML=resp.content.plus;
				document.getElementById('tempatMinus').innerHTML=resp.content.minus;
				document.getElementById('keyPP').textContent ="";
				document.getElementById('keyMM').textContent ="";
		  }
		});

	},



	newPlafon: function(){

		var me = this;
		var err='';

		if (err =='' ){
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
				addCoverPage2(cover,1,true,false);

			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize() ,
			  	url: this.url+'&tipe=newPlafon',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;

			  	}
			});

		}else{
		 	alert(err);
		}
	},



	saveNewPlafon: function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=saveNewPlafon',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
						$("#plafon").val($("#belanjaLangsung").val());
						$("#keyPlafon").text(document.getElementById(`belanjaLangsungSpan`).textContent = `Rp. ` + renjaKeuanganSKPKD_ins.formatCurrency($("#belanjaLangsung").val()));
						$("#editPlafon").attr("onclick","renjaKeuanganSKPKD_ins.editPlafon("+resp.content.idPlafon+");");
						me.Close();
						window.location.reload();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},


	editPlafon: function(id){

		var me = this;
		var err='';

		if (err =='' ){
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
				addCoverPage2(cover,1,true,false);

			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize()+'&idPlafon='+id,
			  	url: this.url+'&tipe=editPlafon',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;
			  	}
			});

		}else{
		 	alert(err);
		}
	},


	saveEditPlafon: function(id){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize()+"&id="+id,
			url: this.url+'&tipe=saveEditPlafon',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
						$("#plafon").val($("#belanjaLangsung").val());
						$("#keyPlafon").text(document.getElementById(`belanjaLangsungSpan`).textContent = `Rp. ` + renjaKeuanganSKPKD_ins.formatCurrency($("#belanjaLangsung").val()));
						$("#editPlafon").attr("onclick","renjaKeuanganSKPKD_ins.editPlafon("+resp.content.idPlafon+");");
						me.Close();
						window.location.reload();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},


	refreshPagu:function(num) {
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
		if($("#jenisKegiatan").val() == 'baru' ){
		var sisanya = $("#plafon").val() - $("#paguIndikatif").val() - $("#sisaPlafonDariDB").val();
			$("#sisaPlafon").val("Rp. " + renjaKeuanganSKPKD_ins.uang(sisanya));
		}else{
		var sisanya = $("#plafon").val() - $("#paguIndikatif").val() - $("#sisaPlafonDariDB").val() - $("#plus").val() - $("#minus").val();
			$("#sisaPlafon").val("Rp. " + renjaKeuanganSKPKD_ins.uang(sisanya));
		}

		return (((sign)?'':'-') + '' + num + ',' + cents);
	},


	uang:function(num) {
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



});
