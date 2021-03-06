/*var UserManajemenSkpd = new SkpdCls({
	prefix : 'UserManajemenSkpd', 
	formName: 'UserManajemenForm',
	pilihBidangAfter:function(){
		UserManajemen.refreshList(true);
	},
	pilihUnitAfter:function(){
		UserManajemen.refreshList(true);
	},
	pilihSubUnitAfter:function(){
		UserManajemen.refreshList(true);
	}
});*/

/*var UserManajemenSkpd2 = new SkpdCls({
	prefix : 'UserManajemenSkpd2', 
	formName: 'UserManajemen_form',
	pilihBidangAfter:function(){
		//UserManajemen.refreshList(true);
	},
	pilihUnitAfter:function(){
		//UserManajemen.refreshList(true);
	},
	pilihSubUnitAfter:function(){
		//UserManajemen.refreshList(true);
	}
});*/

var UserManajemenSkpd = new SkpdCls({
	prefix : 'UserManajemenSkpd', formName:'UserManajemenForm'
});

var UserManajemen = new DaftarObj2({
	prefix : 'UserManajemen',
	url : 'pages.php?Pg=usermanajemen', 
	formName : 'UserManajemenForm',
	
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
	
	pilihUrusan : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=usermanajemen&tipe=pilihUrusan',
		  type : 'POST',
		  data:$('#UserManajemen_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
		
			document.getElementById('cont_c').innerHTML = resp.content.c;
			document.getElementById('cont_d').innerHTML = resp.content.d;
			document.getElementById('cont_e').innerHTML = resp.content.e;
			document.getElementById('cont_e1').innerHTML = resp.content.e1;
		
		  }
		});
	},
	
	
	pilihBidang : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=usermanajemen&tipe=pilihBidang',
		  type : 'POST',
		  data:$('#UserManajemen_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_d').innerHTML = resp.content.d;
			document.getElementById('cont_e').innerHTML = resp.content.e;
			document.getElementById('cont_e1').innerHTML = resp.content.e1;
		  }
		});
	},
	
	pilihSKPD : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=usermanajemen&tipe=pilihSKPD',
		  type : 'POST',
		  data:$('#UserManajemen_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('cont_e1').innerHTML = resp.content.e1;
		  }
		});
	},
	
	pilihUnit : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=usermanajemen&tipe=pilihUnit',
		  type : 'POST',
		  data:$('#UserManajemen_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
		//	document.getElementById('e1').value = resp.content.e1;
			document.getElementById('cont_e1').innerHTML = resp.content.e1;
			
		  }
		});
	},
	
	
	
	Baru: function(){	
		
		var me = this;
		var err='';
		/*var bidang =document.getElementById('skpd_usermanajemenfmBidang').value;
		var bagian =document.getElementById('skpd_usermanajemenfmBagian').value;
		var subbagian =document.getElementById('skpd_usermanajemenfmSubBagian').value;
		
		if(err=='' && bidang=='00')err='Satuan Kerja belum di pilih !';
		if(err=='' && bagian=='00')err='Bagian belum di pilih !';
		if(err=='' && subbagian=='00')err='Sub Bagian belum di pilih !';*/
		
		if (err =='' ){		
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;
					document.getElementById('uid').focus();
					
					setTimeout(
						function() {
        					//.. what to do after 10 seconds
							document.getElementById('nm_lengkap').value='';
							document.getElementById('password').value='';
						}
					, 500);
					
								
					me.AfterFormBaru();
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},
	
	Edit: function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
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
						//me.autocomplete_initial();
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
	/**
	autocomplete_initial:function (){
					//var id_bagian = document.getElementById('id_bagian').value;
					var bidang = document.getElementById('bdg').value;
					var bagian = document.getElementById('bgn').value;
					var subbagian = document.getElementById('sbgn').value;
						$(function() {							
							$( '#nm_pegawai' ).autocomplete({
						      source: function( request, response ) {
						        $.ajax({
								  url: 'pages.php?Pg=usermanajemen&tipe=autocomplete_getdata',
						          dataType: 'json',
						          data: {
						            //featureClass: 'P',
						            style: 'full',
						            maxRows: 12,
									name_startsWith: request.term,
									//id_bagian: id_bagian,
									bidang: bidang,
									bagian: bagian,
									subbagian: subbagian,
						          },
								  success: function( data ) {						         
									  response( $.map( data, function( item ) {
										    return {
												id: item.id,
										        label: item.label,
										        value: item.value
										    }
										}));
									}
						        });
						      },
						      minLength: 1,
						      select: function( event, ui ) {
						        console.log( ui.item ?
						          'Selected: id=' + ui.item.id+' label=' + ui.item.label  :
						          'Nothing selected, input was ' + this.value);
								  document.getElementById('id_pegawai').value=ui.item.id;
								  UserManajemen.getdata_pegawai();
								 //alert()
						      },
						      open: function() {
						        $( this ).removeClass( 'ui-corner-all' ).addClass( 'ui-corner-top' );
						      },
						      close: function() {
						        $( this ).removeClass( 'ui-corner-top' ).addClass( 'ui-corner-all' );
						      }
						    });
						});
	},
	**/
	getdata_pegawai:function(){	
		
		var me = this;
		var id_pegawai = document.getElementById('id_pegawai').value;  
		//var kota = document.getElementById('kota').value;
			
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			//addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'GET', 
				data:"id_pegawai="+id_pegawai,//$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=getdata_pegawai',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if(resp.err==''){		
						document.getElementById('nip').value = resp.content.nip;
						document.getElementById('gol').value = resp.content.gol;	
						document.getElementById('ruang').value = resp.content.ruang;
						document.getElementById('pangkat').value = resp.content.pangkat;			
						document.getElementById('jabatan').value = resp.content.jabatan;
					}else{
						alert(resp.err);
					}
				}
			});
		},

	LevelAdmin: function(){	
		
		var me = this;
		var err='';
		var fmLEVELPENGGUNA = document.getElementById('fmLEVELPENGGUNA').value; 
		
			if(fmLEVELPENGGUNA == 1){
				//document.getElementById('group').value='00.00.00';
				document.getElementById('fmMODUL01_1').checked=true;
				document.getElementById('fmMODUL02_1').checked=true;
				document.getElementById('fmMODUL03_1').checked=true;
				document.getElementById('fmMODUL04_1').checked=true;
				document.getElementById('fmMODUL05_1').checked=true;
				document.getElementById('fmMODUL06_1').checked=true;
				document.getElementById('fmMODUL07_1').checked=true;
				document.getElementById('fmMODUL08_1').checked=true;
				document.getElementById('fmMODUL09_1').checked=true;
				document.getElementById('fmMODUL10_1').checked=true;
				document.getElementById('fmMODUL11_1').checked=true;
				document.getElementById('fmMODUL12_1').checked=true;
				document.getElementById('fmMODUL13_1').checked=true;
				document.getElementById('fmMODUL14_1').checked=true;
				document.getElementById('fmMODUL15_1').checked=true;
				document.getElementById('fmMODUL16_1').checked=true;
				
			}
		
	},	
	
	LevelOperator: function(){	
		var me = this;
		var err='';
		var fmLEVELOPERATOR = document.getElementById('fmLEVELOPERATOR').value; 
		//var group = document.getElementById('group').value;
		
			if(fmLEVELOPERATOR == 2){
				/*if(group.substr(0,2) == '00'){
					alert('Dua digit pertama Group tidak boleh 00 !');
					document.getElementById('group').value='';
				}*/
				document.getElementById('fmMODUL01_2').checked=true;
				document.getElementById('fmMODUL02_2').checked=true;
				document.getElementById('fmMODUL03_2').checked=true;
				document.getElementById('fmMODUL04_2').checked=true;
				document.getElementById('fmMODUL05_2').checked=true;
				document.getElementById('fmMODUL06_2').checked=true;
				document.getElementById('fmMODUL07_2').checked=true;
				document.getElementById('fmMODUL08_2').checked=true;
				document.getElementById('fmMODUL09_2').checked=true;
				document.getElementById('fmMODUL10_2').checked=true;
				document.getElementById('fmMODUL11_2').checked=true;
				document.getElementById('fmMODUL12_2').checked=true;
				document.getElementById('fmMODUL13_2').checked=true;		
				document.getElementById('fmMODUL14_2').checked=true;		
				document.getElementById('fmMODUL15_2').checked=true;		
				document.getElementById('fmMODUL16_2').checked=true;		
			}
		
	},
	
	LevelTamu: function(){	
		var me = this;
		var err='';
		var fmLEVELTAMU = document.getElementById('fmLEVELTAMU').value; 
		//var group = document.getElementById('group').value;
		
			if(fmLEVELTAMU == 3){
				/*if(group.substr(0,2) == '00'){
					alert('Dua digit pertama Group tidak boleh 00 !');
					document.getElementById('group').value='';
				}*/
				document.getElementById('fmMODUL01_2').checked=true;
				document.getElementById('fmMODUL02_2').checked=true;
				document.getElementById('fmMODUL03_2').checked=true;
				document.getElementById('fmMODUL04_2').checked=true;
				document.getElementById('fmMODUL05_2').checked=true;
				document.getElementById('fmMODUL06_2').checked=true;
				document.getElementById('fmMODUL07_2').checked=true;
				/*document.getElementById('fmMODUL08_2').checked=true;
				document.getElementById('fmMODUL09_2').checked=true;
				document.getElementById('fmMODUL10_2').checked=true;
				document.getElementById('fmMODUL11_2').checked=true;
				document.getElementById('fmMODUL12_2').checked=true;
				document.getElementById('fmMODUL13_2').checked=true;*/
				
			}
		
	},	
	
	cek : function (){
	var uid=document.getElementById('uid').value;	
	
		pola=/^[a-z0-9_.]+$/gi;
		if(uid.match(/\ /)) {//cek inputan pake spasi/ga 
   			alert("Username tidak boleh menggunakan spasi !");
   			document.getElementById('uid').focus();
   			document.getElementById('uid').value="";
   			return false;
   		}
		else if (!pola.test(uid)){
			alert ("Username tidak valid !");
			document.getElementById('uid').focus();
			return false;
		}
		else{
			return true;
		}
	},
	
	reset_pegawai : function (){
		document.getElementById('nm_pegawai').value='';	
		document.getElementById('nip').value='';	
		document.getElementById('gol').value='';	
		document.getElementById('ruang').value='';	
		document.getElementById('pangkat').value='';	
		document.getElementById('jabatan').value='';	
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
	},
	
	resetPass: function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			if(confirm('Reset Password '+box.value+' ?')){
				//this.Show ('formedit',{idplh:box.value}, false, true);			
				var cover = this.prefix+'_formcover';
				addCoverPage2(cover,1,true,false);	
				document.body.style.overflow='hidden';
				$.ajax({
					type:'POST', 
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=resetPass',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');	
						delElem(cover);
						document.body.style.overflow='auto';
						if (resp.err ==''){		
							alert('ID Pengguna : '+resp.content.uid+' , Password : '+resp.content.pass);
							//me.AfterFormEdit(resp);
							//me.autocomplete_initial();
						}else{
							alert(resp.err);
							
						}
				  	}
				});
			}
		}else{
			alert(errmsg);
		}
		
	}
	
				
});

var skpd_usermanajemen = new SkpdCls({
	prefix : 'skpd_usermanajemen', formName:'UserManajemenForm', kolomWidth:120, semuaSatKer:1
	
});
