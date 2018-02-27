/*var MutasiBaru_insSkpd = new SkpdCls({
	prefix : 'MutasiBaru_insSkpd', formName:'MutasiBaru_insForm'
});*/


var MutasiBaru_ins = new DaftarObj2({
	prefix : 'MutasiBaru_ins',
	url : 'pages.php?Pg=mutasibaru_ins', 
	formName : 'MutasiBaru_insForm',
	
	loading: function(){
		this.topBarRender();
		this.filterRender();
		//this.daftarRender();
		//this.sumHalRender();	
	},
	
	UrusanAfter: function(){
		var me = this;
		
		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=UrusanAfter',
		  type : 'POST',
		  data:$('#'+this.formName).serialize(),
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagian');
				
				//me.refreshList(true);
					document.getElementById('fmSKPDBidang2').innerHTML=resp.content.c2;
					me.BidangAfter2();
				
		  }
		});
	},
	BidangAfter2: function(){
		var me = this;
		
		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=BidangAfter2',
		  type : 'POST',
		  data:$('#'+this.formName).serialize(),
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagian');
				
				//me.refreshList(true);
				document.getElementById('fmSKPDskpd2').innerHTML=resp.content;
				me.SKPDAfter2();
				
		  }
		});
	},
	SKPDAfter2: function(){
		var me = this;
		
		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=SKPDAfter2',
		  type : 'POST',
		  data:$('#'+this.formName).serialize(),
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagian');
				
				//me.refreshList(true);
				document.getElementById('fmSKPDUnit2').innerHTML=resp.content;
				me.UnitAfter2();
				
		  }
		});
	},
	UnitAfter2: function(){
		var me = this;
		
		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=UnitAfter2',
		  type : 'POST',
		  data:$('#'+this.formName).serialize(),
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagian');
				
				//me.refreshList(true);
				document.getElementById('fmSKPDSubUnit2').innerHTML=resp.content;
				
		  }
		});
	},
	
	mutasibaru: function(){
	var me = this; var errmsg ='';
		
		var c1 = document.getElementById('fmURUSAN').value;
		var c = document.getElementById('fmSKPD').value;
		var d = document.getElementById('fmUNIT').value;
		var e = document.getElementById('fmSUBUNIT').value;
		var e1 = document.getElementById('fmSEKSI').value;
		if(errmsg == '' && c1 == '00')errmsg = "URUSAN belum di pilih !";
		if(errmsg == '' && c == '00')errmsg = "BIDANG belum di pilih !";
		if(errmsg == '' && d == '00')errmsg = "SKPD belum di pilih !";
		//if(errmsg == '' && e == '00')errmsg = "UNIT belum di pilih !";
		//if(errmsg == '' && e1 == '000')errmsg = "SUB UNIT belum di pilih !";
		
		var jmlcek = document.getElementById('boxchecked').value ;	
		if((errmsg=='') && ( (document.getElementById('boxchecked').value == 0)||(document.getElementById('boxchecked').value == '')  )){
			errmsg= 'Data belum dipilih!';
		}		
		
		if(errmsg ==''){ 
			var box = this.GetCbxCheckedBi();
			if(confirm('Mutasi '+jmlcek+' Data ?')){
				if(errmsg ==''){ 					
					//var aForm = document.getElementById(this.formName);		
					var aForm = document.getElementById('adminForm');		
					aForm.action= this.url+'&baru=1';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
					aForm.target='_blank';
					aForm.submit();	
					aForm.target='';					
				}
			}	
		}else{
			alert(errmsg);				
		}
	},
	
	BaruBAST : function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,999,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=formBaruBAST',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					document.getElementById(cover).innerHTML = resp.content;			
					me.AftFilterRender2();	
				}else{
					alert(resp.err);
					delElem(cover);
				}			
				
		  	}
		});
	},
	
	SimpanBAST : function(){
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
			url: this.url+'&tipe=simpanBAST',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					alert("Data sudah disimpan !");
					me.Close();
					document.getElementById('no_bast').innerHTML = resp.content.bast;
					document.getElementById('tgl_bast2').value = resp.content.tgl_bast2;
					//me.AfterSimpan();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},	
	
	EditBAST : function(){
		var me = this;
		var errmsg='';
		no_ba = document.getElementById('no_bast').value;
		if(errmsg == '' && no_ba == '')errmsg = "NOMOR BAST Belum Diisi ! ";
		//errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			//var box = this.GetCbxChecked();
			
			// this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,1,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formEditBAST',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						me.AftFilterRender2();
					}else{
						alert(resp.err);
						delElem(cover);
						//document.body.style.overflow='auto';
					}
			  	}
			});
		}else{
			alert(errmsg);
		}
		
	},	
		
	HapusBAST : function(){
		var me= this;	
		var no_bast = document.getElementById('no_bast').value;
		if(confirm('Hapus No Bast '+no_bast+' ?')){
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=hapusBAST',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if(resp.err==''){
						/*if(confirm('Tambah No Bast ?')){
							MutasiBaru_ins.BaruBAST();
						}*/
						document.getElementById('no_bast').innerHTML = resp.content.bast;
					}else{
						alert(resp.err);
					}
			  	}
			});
		}
	},	
		
	Simpan: function(urutan){
		var me = this;
		c1 = document.getElementById('fmSKPDUrusan').value;
		c2 = document.getElementById('fmSKPDBidang2').value;
		d2 = document.getElementById('fmSKPDskpd2').value;
		e2 = document.getElementById('fmSKPDUnit2').value;
		e12 = document.getElementById('fmSKPDSubUnit2').value;
		//noba = document.getElementById('no_bast').value;
		//tglba = document.getElementById('tgl_bast').value;
		var cover = this.prefix+'_formcover';
		addCoverPage2(cover,1,true,false);		
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=simpan',
				success: function(data) {	
					var resp = eval('(' + data + ')');
					delElem(cover);								
					/*if(resp.err==''){
						document.getElementById('progreserrormsg').innerHTML = "";
					}else{
						document.getElementById('progreserrormsg').innerHTML = resp.content.msg_error;
					}*/					
					if(resp.err==''){
						var  jmldata = parseInt(document.getElementById('jmldata').value);
						var  prog = parseInt(document.getElementById('prog').value);
						prog = prog + resp.content.jml;
						if(prog>jmldata) prog = jmldata;
						document.getElementById('prog').value = prog;
						//alert('prog='+prog);
						var persen = ((prog/jmldata)*100);
						document.getElementById('progressbar').style.width = persen +'%';			
						//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
						document.getElementById('progressmsg').innerHTML = formatNumber(prog,0,',','.')+'/'+formatNumber(jmldata,0,',','.');			
						if(persen<100) {
							setTimeout(function(){ me.Simpan(urutan); }, 50);
							urutan = urutan+1;
							//document.getElementById('progressbox').style.display='none';	
						}else{							
							document.getElementById('progressbar').style.width = persen +'%';				
							setTimeout(function(){ alert('Mutasi Selesai !'); }, 1000);
							setTimeout(function(){ window.close(); }, 1000);					
							setTimeout(function(){ window.opener.location.reload(); }, 1000);							
						}
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	ambilTglBA: function(){
		var me = this;
		var no_ba = document.getElementById('no_bast').value;
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=ambilTglBA&noba='+no_ba,
			success: function(data) {	
				var resp = eval('(' + data + ')');			
				if(resp.err==''){
						document.getElementById('tgl_bast2').value = resp.content;
						//document.getElementById('tgl_dok').value = '';
				}else{
					alert(resp.err);
				}
			}
		});
	},
	
	AftFilterRender: function(){ 			
		$('.datepicker').datepicker({
		    dateFormat: 'dd-mm-yy',
			showAnim: 'slideDown',
		    inline: true,
			showOn: "button",
			buttonImage: "datepicker/calender1.png",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+0",
			buttonText : '',
		});					
	},	
	AftFilterRender2: function(){ 			
		$('.datepicker2').datepicker({
		    dateFormat: 'dd-mm',
			showAnim: 'slideDown',
		    inline: true,
			showOn: "button",
			buttonImage: "datepicker/calender1.png",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+0",
			buttonText : '',
		});					
	},
});
