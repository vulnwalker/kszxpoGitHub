var SOTKBaruSkpd = new SkpdCls({
	prefix : 'SOTKBaruSkpd', formName:'SOTKBaruForm'
});


var SOTKBaru = new DaftarObj2({
	prefix : 'SOTKBaru',
	url : 'pages.php?Pg=sotkbaru', 
	formName : 'SOTKBaruForm',
	
	loading:function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
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
				document.getElementById('fmSKPDBidang2').innerHTML=resp.content;
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
				
				//.refreshList(true);
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
	
	sotkbaru: function(){
	var me =this;
		if(document.getElementById(this.prefix+'_jmlcek')){
			var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;	
		}else{
			var jmlcek = '';
		}
		
		if(jmlcek ==0){
			alert('Data Belum Dipilih!');
		}else{
			if(confirm('Mutasi '+jmlcek+' Data ?')){
				//errmsg = this.CekCheckbox();
				errmsg = '';
	
				c = document.getElementById('SOTKBaruSkpdfmSKPD');
				d = document.getElementById('SOTKBaruSkpdfmUNIT');
				e = document.getElementById('SOTKBaruSkpdfmSUBUNIT');
				e1 = document.getElementById('SOTKBaruSkpdfmSEKSI');
				
				if(errmsg == '' && c.value == '00')errmsg = "BIDANG SOTK LAMA Belum Diisi ! ";
				if(errmsg == '' && d.value == '00')errmsg = "SKPD SOTK LAMA Belum Diisi ! ";
				if(errmsg == '' && e.value == '00')errmsg = "UNIT SOTK LAMA Belum Diisi ! ";
				if(errmsg == '' && e1.value == '00')errmsg = "SUB SOTK LAMA UNIT Belum Diisi ! ";

				
				if(errmsg ==''){ 
					//var box = this.GetCbxChecked();
					
					//alert(box.value);
							
					var aForm = document.getElementById(this.formName);		
					aForm.action= this.url+'_ins&baru=1';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
					aForm.target='_blank';
					aForm.submit();	
					aForm.target='';
				}else{
						alert(errmsg);
				}	
			}
		}
		
	},
	
	Batal : function(){
		var me =this;
		if(document.getElementById(this.prefix+'_jmlcek')){
			var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;	
		}else{
			var jmlcek = '';
		}
		
		if(jmlcek ==0){
			alert('Data Belum Dipilih!');
		}else{
			if(confirm('Batalkan '+jmlcek+' Data ?')){
				//document.body.style.overflow='hidden'; 
				var cover = this.prefix+'_hapuscover';
				addCoverPage2(cover,1,true,false);
				$.ajax({
					type:'POST', 
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=batal',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');		
						delElem(cover);		
						if(resp.err==''){							
							alert('Data berhasil dibatalkan');
							//me.AfterHapus();	
						}else{
							alert(resp.err);
						}							
						
				  	}
				});
				
			}	
		}
	},
	
	Report : function(uid){
		var me = this;
		if(document.getElementById(this.formName)) formName = this.formName;
		if(document.getElementById('adminForm')) formName = 'adminForm';
		me.setCetakReport(uid);
/*		
		$.ajax({
			type:'POST', 
			data:$('#'+formName).serialize(),
		  	url: this.url+'&tipe=getjmlcetakkkerja&kib='+tipe,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					//document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru(resp);	
					//alert(resp.content.jmldata);
					me.setFormCetakKK(tipe, resp.content.jmldata, resp.content.vjmldata);
				}else{
					alert(resp.err);
					//delElem(cover);
					//document.body.style.overflow='auto';
				}			
				
		  	}
		});
*/		
	},
	setCetakReport: function(uid){
		
		var form_judul = 'CETAK REPORT';
		var form_width = '500';
		var form_height = '220';
		var cover ='SOTKBaru_formCetakCover';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		//var jmldata = 10;
		//document.body.style.overflow='hidden';
		addCoverPage2(cover,999,true,false);
		
		var form_menu =
			"<div style='padding: 0 8 9 8;height:22; '>"+
			"<div style='float:right;'>"+
				"<input type='button' value='Cetak' onclick='SOTKBaru.cetakReport()'>"+
				"<input type='button' value='Batal' onclick='SOTKBaru.formCetakClose()'>"+
				"<input type='hidden' id='Sensus_idplh' name='Sensus_idplh' value='109'><input type='hidden' id='Sensus_fmST' name='Sensus_fmST' value='1'>"+
				"<input type='hidden' id='sesi' name='sesi' value=''>"+
			"</div>"+
			"</div>";
		
		var content = 
			"<div id='Sensus_form_div' style='margin:9 8 8 8; overflow:auto; border:1px solid #E5E5E5;width:"+(form_width-20)+";height:"+(form_height-80)+";'>"+
				"<table style='width:100%' class='tblform'><tr><td style='padding:4'>"+
					"<table style='width:100%:height:100%'>"+
						"<tr>"+
							"<td style='width:100'>PILIH REPORT </td>"+
							"<td style='width:10'>:</td>"+
							"<td style='' colspan='3' >"+
								"<select name='cmbPilihReport' id='cmbPilihReport' style='width:200;' onchange='SOTKBaru.pilihreport()'>"+
								"<option value=''>--PILIH REPORT--</option>"+
									"<option value='1'>BAST</option>"+
									"<option value='2'>REKAPITULASI MUTASI</option>"+
									"<option value='3'>RINCIAN MUTASI BARANG</option>"+
								"</select>"+
							"</td>"+														
						"</tr>"+
						"<tr>"+
							"<td style='width:80'>NOMOR BAST </td>"+
							"<td style='width:10'>:</td>"+
							"<td style='' colspan='3' >"+
								"<select name='cmbPilihBast' id='cmbPilihBast' style='width:200;' disabled>"+
									"<option value=''>--NOMOR BAST--</option>"+
								"</select>"+	
							"</td>"+													
						"</tr>"+
						"<tr>"+
							"<td style='width:80'>TANGGAL CETAK</td>"+
							"<td style='width:10'>:</td>"+
							"<td>"+
								"<select name='cmbTglCetak' id='cmbTglCetak' disabled>"+
									"<option value="+dd+">"+dd+"</option>"+
								"</select>"+
								"&nbsp;"+
								"<select name='cmbBlnCetak' id='cmbBlnCetak' disabled>"+
									"<option value="+mm+">"+mm+"</option>"+
								"</select>"+
								"&nbsp;"+
								"<select name='cmbThnCetak' id='cmbThnCetak' disabled>"+
									"<option value="+yyyy+">"+yyyy+"</option>"+
								"</select>"+
							"</td>"+
						"</tr>"+						
						"<tr>"+
							"<td style='width:80'>USERNAME</td>"+
							"<td style='width:10'>:</td>"+
							"<td>"+
								"<input type='text' id='uid' name='uid' value="+uid+" style='width:200;' readonly>"+
							"</td>"+
						"</tr>"+
					"</table>"+
				"</td></tr></table>"+
			"</div>";
		
		
		document.getElementById(cover).innerHTML= 
			"<table width='100%' height='100%'><tbody><tr><td align='center'>"+
			//"rtera"+
			"<div id='div_border' style='width:"+form_width+";height:"+form_height+"; background-color:white; border-color: rgba(0, 0, 0, 0.3);   border-style: solid;  border-width:1; box-shadow: 6px 6px 5px rgba(0, 0, 0, 0.3);'>"+
			"<table class='' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td style='padding:0'>"+
				"<div class='menuBar2' style='height:20'>"+			
				"<span style='cursor:default;position:relative;left:6;top:2;color:White;font-size:12;font-weight:bold'>"+form_judul+"</span>"+
				"</div>"+
			"</td></tr></tbody></table>"+			
			content+
			form_menu+		
			"</div>"+
				
			"</td></tr>"+
			"</table>";
		
			
	},
	
	formCetakClose : function(){
		delElem('SOTKBaru_formCetakCover');	
	},
	
	pilihreport: function(){
		var me = this;
		
		this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=pilihreport',
		  type : 'POST',
		  data:$('#'+this.formName).serialize(),
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagian');
				
				if(document.getElementById('cmbPilihReport').value == 1){
					//me.refreshList(true);
					document.getElementById('cmbPilihBast').disabled=false;
					document.getElementById('cmbPilihBast').innerHTML=resp.content;
				}else{
					document.getElementById('cmbPilihBast').value='';
					document.getElementById('cmbPilihBast').disabled=true;
				}
				
				
		  }
		});
	},
	
	cetakReport : function(){
		alert('tes')
	},
	
});
