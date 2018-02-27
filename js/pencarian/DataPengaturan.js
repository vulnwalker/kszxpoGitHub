var DataPengaturan = new DaftarObj2({
	prefix : 'DataPengaturan',
	url : 'pages.php?Pg=DataPengaturan', 
	formName : 'DataPengaturanForm',
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
	
	SimpanUbahData: function(){
		var me=this;
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=SimpanUbah',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					DataPengaturan.loading();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	cekDcID_val : function(nama){
		var hasil = "";
		if(document.getElementById(nama))hasil = document.getElementById(nama).value;
		
		return hasil;
	},
	
	Set_cekDcID_val : function(nama, isi){
		if(document.getElementById(nama))document.getElementById(nama).value = isi;
		
	},
	
	Set_cekDcID_INNER : function(nama, isi){
		if(document.getElementById(nama))document.getElementById(nama).innerHTML = isi;
		
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
	
	nyalakandatepicker: function(){
		var me=this;
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
			onSelect: function(){
				me.AfterDatePicker1();
			},
		});	
	},
	
	nyalakandatepicker2: function(){
		var me =this;
		$( ".datepicker2" ).datepicker({ 
			dateFormat: "dd-mm", 
			showAnim: "slideDown",
			inline: true,
			showOn: "button",
			buttonImage: "datepicker/calender1.png",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+0",
			buttonText : "",
			onSelect: function(){
				me.AfterDatePicker2();
			},
		});	
		
		
	},
	
	nyalakandatepicker3: function(){
		var me =this;
		$( ".datepicker3" ).datepicker({ 
			dateFormat: "dd-mm", 
			showAnim: "slideDown",
			inline: true,
			showOn: "button",
			buttonImage: "datepicker/calender1.png",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+0",
			buttonText : "",
			onSelect: function(){
				me.AfterDatePicker3();
			},
		});	
		
		
	},
	
	AfterDatePicker1:function(){
		var me=this;
	},
	AfterDatePicker2:function(){
		var me=this;
	},
	AfterDatePicker3:function(){
		var me=this;
	},
	
	DataSkpd: function(SKPDname, widthnya='100px', c1='',c='',d=''){
		var me= this;	
			
		//document.body.style.overflow='hidden';
		var cover = this.prefix+'_formSKPD';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=DataSkpd&SKPDname='+SKPDname+'&widthnya='+widthnya+"&def_c1="+c1+"&def_c="+c+"&def_d="+d,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);	
				//document.body.style.overflow='auto';	
				if(resp.err==''){
					$("#"+SKPDname).html(resp.content);
					me.DataSkpd_After();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	DataSkpd_After: function(){
		var me= this;	
	},
	
});
