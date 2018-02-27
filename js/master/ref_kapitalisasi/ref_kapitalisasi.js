var ref_kapitalisasi = new DaftarObj2({
	prefix : 'ref_kapitalisasi',
	url : 'pages.php?Pg=ref_kapitalisasi&ajx=3', 
	formName : 'ref_kapitalisasiForm',
	
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
		var bidang = document.getElementById('fmBIDANG').value; 
		var kelompok = document.getElementById('fmKELOMPOK').value;
		var subkelompok = document.getElementById('fmSUBKELOMPOK').value;
		var subsubkelompok = document.getElementById('fmSUBSUBKELOMPOK').value;
		//if(err=='' && (bidang=='' || bidang=='0') ) err='Bidang belum dipilih!';
		//if(err=='' && (kelompok=='' || kelompok=='0') ) err='Kelompok belum dipilih!';
		//if(err=='' && (subkelompok=='' || subkelompok=='0') ) err='Sub Kelompok belum dipilih!';
		//if(err=='' && (subsubkelompok=='' || subsubkelompok=='0') ) err='Sub Sub Kelompok belum dipilih!';
		
		var cover = this.prefix+'_formcover';
		if(err==''){
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);	
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
						document.getElementById('kode1').focus();	
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
	Hapus:function(){
		
		var me =this;
		if(document.getElementById(this.prefix+'_jmlcek')){
			var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;	
		}else{
			var jmlcek = '';
		}
		
		if(jmlcek ==0){
			alert('Data Belum Dipilih!');
		}else{
			if(confirm('Hapus '+jmlcek+' Data ?')){
				//document.body.style.overflow='hidden'; 
				var cover = this.prefix+'_hapuscover';
				addCoverPage2(cover,1,true,false);
				$.ajax({
					type:'POST', 
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=hapus',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');		
						delElem(cover);		
						if(resp.err==''){							
							me.Close();
							me.refreshList(true)
						}else{
							alert(resp.err);
						}							
						
				  	}
				});
				
			}	
		}
	},
	
	pilihBidang : function(){
	var me = this; 
		
		$.ajax({
		  url: 'pages.php?Pg=ref_kapitalisasi&tipe=pilihBidang',
		  type : 'POST',
		  data:$('#ref_kapitalisasi_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_g').innerHTML = resp.content.g;
			document.getElementById('cont_h').innerHTML = resp.content.h;
			document.getElementById('cont_i').innerHTML = resp.content.i;
			document.getElementById('cont_j').innerHTML = resp.content.j;		
		  	/*document.getElementById('min_kapital').value = resp.content.min_kapital;
		  	document.getElementById('rp_kapital').innerHTML = resp.content.rp_kapital;*/
		  }
		});
	},
	
	
	
	pilihKelompok : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_kapitalisasi&tipe=pilihKelompok',
		  type : 'POST',
		  data:$('#ref_kapitalisasi_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_h').innerHTML = resp.content.h;
			document.getElementById('cont_i').innerHTML = resp.content.i;
			document.getElementById('cont_j').innerHTML = resp.content.j;
		  	/*document.getElementById('min_kapital').value = resp.content.min_kapital;
		  	document.getElementById('rp_kapital').innerHTML = resp.content.rp_kapital;*/
		  }
		});
	},
	
	pilihSubKelompok : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_kapitalisasi&tipe=pilihSubKelompok',
		  type : 'POST',
		  data:$('#ref_kapitalisasi_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_i').innerHTML = resp.content.i;
			document.getElementById('cont_j').innerHTML = resp.content.j;
		  	/*document.getElementById('min_kapital').value = resp.content.min_kapital;
		  	document.getElementById('rp_kapital').innerHTML = resp.content.rp_kapital;*/
		  }
		});
	},
	
	pilihSubSubKelompok : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_kapitalisasi&tipe=pilihSubSubKelompok',
		  type : 'POST',
		  data:$('#ref_kapitalisasi_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_j').innerHTML = resp.content.j;
			/*document.getElementById('min_kapital').value = resp.content.min_kapital;
		  	document.getElementById('rp_kapital').innerHTML = resp.content.rp_kapital;*/
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
					me.Close();
					me.AfterSimpan();
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
		
});
