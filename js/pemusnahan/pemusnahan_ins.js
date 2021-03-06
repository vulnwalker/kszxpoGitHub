var pemusnahan_ins = new DaftarObj2({
	prefix : 'pemusnahan_ins',
	url : 'pages.php?Pg=pemusnahan_ins', 
	formName : 'pemusnahan_insForm',
	
	loading: function(){
		this.topBarRender();
		this.filterRender();
		//this.daftarRender();
		//this.sumHalRender();	
	},
	
	pemusnahanbaru: function(){
		var me = this; var errmsg ='';
		var c1 = document.getElementById('fmURUSAN').value;
		var c = document.getElementById('fmSKPD').value;
		var d = document.getElementById('fmUNIT').value;
		if(errmsg == '' && c1 == '00')errmsg = "URUSAN belum di pilih !";
		if(errmsg == '' && c == '00')errmsg = "BIDANG belum di pilih !";
		if(errmsg == '' && d == '00')errmsg = "SKPD belum di pilih !";
		
		var jmlcek = document.getElementById('boxchecked').value ;	
		if((errmsg=='') && ( (document.getElementById('boxchecked').value == 0)||(document.getElementById('boxchecked').value == '')  )){
			errmsg= 'Data belum dipilih!';
		}		
		if(errmsg ==''){ 
			var box = this.GetCbxCheckedBi();
			if(confirm('Pemusnahan '+jmlcek+' Data ?')){
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
	
	Simpan: function(urutan){
		var me = this;		
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
							setTimeout(function(){ alert('Pemusnahan Selesai !'); }, 1000);
							setTimeout(function(){ window.close(); }, 1000);					
							setTimeout(function(){ window.opener.location.reload(); }, 1000);							
						}
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	AftFilterRender: function(){ 			
		$('.datepicker').datepicker({
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
	
	AftFilterRender2: function(){ 			
		$('.datepicker2').datepicker({
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
});
