var apbd_v2 = new DaftarObj2({
	prefix : 'apbd_v2',
	url : 'pages.php?Pg=apbd_v2', 
	formName : 'apbd_v2Form',
	apbd_v2_form : '0',//default js apbd_v2
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
/*		this.sumHalRender();*/ 
		/*$.ajax({
				type:'POST', 
			  	url: 'pages.php?Pg=tabelPembiayaanLampiran2&tipe=daftar',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
						
						document.getElementById('tabelKedua').innerHTML = resp.content;

				 }
			});*/
		

	
	},
	filterRenderAfter : function(){
		this.daftarRender();
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
		
	},pilihBidang: function(){
		apbd_v2.refreshList(true);

	},BidangAfter2: function(){
		apbd_v2.refreshList(true);

	},comboSKPDChanged: function(){
		apbd_v2.refreshList(true);

	},CariModul: function(){
		var me = this;	

		popupModul.el_namaModul= 'namaModul';		
		popupModul.el_idModul= 'idModul';																				
/*		RefBarangButuh.el_nama_barang= 'nama_barang';		*/																	
		popupModul.windowSaveAfter= function(){};
		popupModul.windowShow();	
	},
		
	histori: function(id){
		var me = this;	

		popupHistori.el_namaHistori= 'namaHistori';		
		popupHistori.el_idHistori= 'idHistori';											
		popupHistori.windowSaveAfter= function(){};
		popupHistori.windowShow(id);	
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
/*				me.sumHalRender();*/
		  	}
		});
	},
	Baru: function(){	
		
		var me = this;
		var err='';
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			if(me.apbd_v2_form==0){//baru dari apbd_v2
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
					$('.datepicker').datepicker({
						    dateFormat: 'dd-mm-yy',
							showAnim: 'slideDown',
						    inline: true,
							showOn: "button",
     						buttonImage: "images/calendar.gif",
      						buttonImageOnly: true,
							changeMonth: true,
      						changeYear: true,
							yearRange: "-20:+10",
							buttonText : '',
		});

			var status = document.getElementById("status");
			status.remove(0);
			var modul = document.getElementById("modul");
			modul.remove(0);
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	Info: function(){	
		tabelPembiayaanLampiran2_v2.windowShow();
	},
	
	BidangAfterform: function(){
		var me = this;
		
		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=BidangAfterForm',
		  type : 'POST',
		  data:{fmSKPDBidang: $("#cmbBidangForm").val(),
		  		 fmSKPDUrusan: $("#cmbUrusanForm").val() },
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagian');
				document.getElementById('cmbBidangForm').innerHTML=resp.content.bidang;
				document.getElementById('cmbSKPDForm').innerHTML=resp.content.skpd;
				

				
				
		  }
		});

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
						$('.datepicker').datepicker({
						    dateFormat: 'dd-mm-yy',
							showAnim: 'slideDown',
						    inline: true,
							showOn: "button",
     						buttonImage: "images/calendar.gif",
      						buttonImageOnly: true,
							changeMonth: true,
      						changeYear: true,
							yearRange: "-20:+10",
							buttonText : '',
		});
					var status = document.getElementById("status");
					status.remove(0);
					var modul = document.getElementById("modul");
					modul.remove(0);
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

	sesuai:function(id){
			$.ajax({
				type:'POST', 
				data:{idAwal : id},
				url: this.url+'&tipe=sesuai',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					$("#span"+id).text(resp.content.sesuai);
					apbd_v2.refreshList(true);
				 }
			  });

	},
	koreksi:function(id){
		$("#span"+id).html("<input type='text' name='"+id+"' id='"+id+"' onkeyup='return apbd_v2.submitKoreksi(event,id)'   style='text-align: right;'>  <span id='bantu"+id+"' ></span>");
	},
	submitKoreksi:function(e,id) {
	var angkaKoreksi = $("#"+id).val();
	    if (e.keyCode == 13) {
			
			if(angkaKoreksi <= '0'){
				alert("angka Salah");
			}else{
			  $.ajax({
				type:'POST', 
				data:{idAwal : id,
					  angkaKoreksi : angkaKoreksi},
				url: this.url+'&tipe=koreksi',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					apbd_v2.refreshList(true);
				 }
			  });
			}
	        return false;
	    }else if (e.keyCode == 27) {
				apbd_v2.refreshList(true);
		        return false;
	  	    }else{
			document.getElementById('bantu'+id).innerHTML = popupBarang.formatCurrency(angkaKoreksi);
		}
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
	catatan:function(id){
		var me = this;

			
			 var cover = this.prefix+'_formcover';

			$.ajax({
				type:'POST', 
				data:{idAwal : id },
			  	url: this.url+'&tipe=Catatan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
					   
						document.body.style.overflow='hidden';
						addCoverPage2(cover,999,true,false);	
						document.getElementById(cover).innerHTML = resp.content;
					}else{
					/*	delElem(cover);*/
						alert(resp.err);
					}			
					
					
			  	}
			});

		
	},
   Validasi:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
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
			  	url: this.url+'&tipe=Validasi',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						delElem(cover);
						alert(resp.err);
					}			
					
					//setTimeout(function myFunction() {pemasukan.jam()},100);	
					//me.AfterFormBaru();
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
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					if(me.apbd_v2_form==0){
						me.Close();
						me.AfterSimpan();						
					}else{
						me.Close();
						barang.refreshComboapbd_v2();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,	
   SaveValid: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=SaveValid',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					if(me.apbd_v2_form==0){
						me.Close();
						me.AfterSimpan();						
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,	
   SaveCatatan: function(id){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:{id : id,
				  catatan : $("#catatan").val()},
			url: this.url+'&tipe=SaveCatatan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					if(me.apbd_v2_form==0){
						me.Close();
						me.AfterSimpan();						
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	Laporan:function(){
			
			var url2 = this.url;
			
						window.open(url2+'&tipe=Laporan','_blank');
		}
	,
	Sync: function(){
		
		var me= this;	
		$.ajax({
			type:'POST',
			url: this.url+'&tipe=sync',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				if(resp.err==''){
					me.refreshList(true);
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
});
