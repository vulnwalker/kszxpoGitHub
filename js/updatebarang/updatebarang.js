var updatebarang = new DaftarObj2({
	prefix : 'updatebarang',
	url : 'pages.php?Pg=updatebarang', 
	formName : 'updatebarangForm',
	
	loading: function(){
		this.topBarRender();
		this.filterRender();
		//this.daftarRender();
		//this.sumHalRender();	
	},
	
	formUpdate: function(){
	var me = this; var errmsg ='';		
		
		/*var jmlcek = document.getElementById('boxchecked').value ;	
		if((errmsg=='') && ( (document.getElementById('boxchecked').value == 0)||(document.getElementById('boxchecked').value == '')  )){
			errmsg= 'Data belum dipilih!';
		}*/		
		errmsg = this.CekCheckboxBi();		
		if(errmsg ==''){ 
			var box = this.GetCbxCheckedBi();
				if(errmsg ==''){ 							
					//var aForm = document.getElementById(this.formName);		
					var aForm = document.getElementById('adminForm');		
					aForm.action= this.url;//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
					aForm.target='_blank';
					aForm.submit();	
					aForm.target='';
				}
		}else{
			alert(errmsg);				
		}
	},
	
	PilihTrans : function(){
		var trans = document.getElementById('trans').value;
		var me = this;		
		var prefix2 = 'updatebarang';	
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=PilihTrans',
				success: function(data) {	
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						
						if(trans==1){//KOREKSI HARGA
							document.getElementById('areakoreksi').style="display:block;";
							document.getElementById('areakondisi').style="display:none;";		
							document.getElementById('areakapitalisasi').style="display:none;";				
							document.getElementById('areaasetlain2').style="display:none;";
							document.getElementById('areadbcct').style="display:none;";
							document.getElementById('areagabung').style="display:none;";
							document.getElementById('areahpsbagian').style="display:none;";
							document.getElementById("btsave").setAttribute("href", "javascript:"+prefix2+".SimpanKoreksi()");			
						}else if(trans==2){//KONDISI
							document.getElementById('areakoreksi').style="display:none;";
							document.getElementById('areakondisi').style="display:block;";		
							document.getElementById('areakapitalisasi').style="display:none;";				
							document.getElementById('areaasetlain2').style="display:none;";
							document.getElementById('areadbcct').style="display:none;";
							document.getElementById('areagabung').style="display:none;";
							document.getElementById('areahpsbagian').style="display:none;";
							document.getElementById("btsave").setAttribute("href", "javascript:"+prefix2+".SimpanKondisi()");	
						}else if(trans==3){//KAPITALISASI
							document.getElementById('areakoreksi').style="display:none;";
							document.getElementById('areakondisi').style="display:none;";	
							document.getElementById('areakapitalisasi').style="display:block;";				
							document.getElementById('areaasetlain2').style="display:none;";
							document.getElementById('areadbcct').style="display:none;";
							document.getElementById('areagabung').style="display:none;";
							document.getElementById('areahpsbagian').style="display:none;";
							document.getElementById("btsave").setAttribute("href", "javascript:"+prefix2+".SimpanKapitalisasi()");			
						}else if(trans==4){//ASETLAIN2
							document.getElementById('areakoreksi').style="display:none;";
							document.getElementById('areakondisi').style="display:none;";		
							document.getElementById('areakapitalisasi').style="display:none;";
							document.getElementById('areaasetlain2').style="display:block;";
							document.getElementById('areadbcct').style="display:none;";
							document.getElementById('areagabung').style="display:none;";
							document.getElementById('areahpsbagian').style="display:none;";
							document.getElementById("btsave").setAttribute("href", "javascript:"+prefix2+".SimpanAsetLainLain()");			
						}else if(trans==5){//DOUBLECACAT
							document.getElementById('areakoreksi').style="display:none;";
							document.getElementById('areakondisi').style="display:none;";		
							document.getElementById('areakapitalisasi').style="display:none;";
							document.getElementById('areaasetlain2').style="display:none;";
							document.getElementById('areadbcct').style="display:block;";
							document.getElementById('areagabung').style="display:none;";
							document.getElementById('areahpsbagian').style="display:none;";
							document.getElementById("btsave").setAttribute("href", "javascript:"+prefix2+".simpanpenghapusan()");			
						}else if(trans==6){//PENGGABUNGAN
							document.getElementById('areakoreksi').style="display:none;";
							document.getElementById('areakondisi').style="display:none;";		
							document.getElementById('areakapitalisasi').style="display:none;";
							document.getElementById('areaasetlain2').style="display:none;";
							document.getElementById('areadbcct').style="display:none;";
							document.getElementById('areagabung').style="display:block;";
							document.getElementById('areahpsbagian').style="display:none;";
							document.getElementById("btsave").setAttribute("href", "javascript:"+prefix2+".simpanpenghapusan()");			
						}else if(trans==7){//PENGHAPUSAN SEBAGIAN
							document.getElementById('areakoreksi').style="display:none;";
							document.getElementById('areakondisi').style="display:none;";		
							document.getElementById('areakapitalisasi').style="display:none;";
							document.getElementById('areaasetlain2').style="display:none;";
							document.getElementById('areadbcct').style="display:none;";
							document.getElementById('areagabung').style="display:none;";
							document.getElementById('areahpsbagian').style="display:block;";
							document.getElementById("btsave").setAttribute("href", "javascript:"+prefix2+".simpanhpsbagian()");			
						}else{
							document.getElementById('areakoreksi').style="display:none;";
							document.getElementById('areakondisi').style="display:none;";		
							document.getElementById('areakapitalisasi').style="display:none;";				
							document.getElementById('areaasetlain2').style="display:none;";
							document.getElementById('areadbcct').style="display:none;";
							document.getElementById('areagabung').style="display:none;";
							document.getElementById('areahpsbagian').style="display:none;";
							document.getElementById("btsave").setAttribute("href", "");
							
						}
					}else{
						alert(resp.err);
					}
				}
			});	
		
	},
	
	SimpanKoreksi: function(){
		var me = this;			
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=simpankoreksi',
				success: function(data) {	
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						alert('Data berhasil di simpan !');
						window.close();
						window.opener.location.reload();	
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	SimpanKondisi: function(){
		var me = this;			
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=simpankondisi',
				success: function(data) {	
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						alert('Data berhasil di simpan !');
						window.close();
						window.opener.location.reload();	
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	SimpanKapitalisasi: function(){
		var me = this;			
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=simpankapitalisasi',
				success: function(data) {	
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						alert('Data berhasil di simpan !');
						window.close();
						window.opener.location.reload();	
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	SimpanAsetLainLain: function(){
		var me = this;			
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=simpanasetlainlain',
				success: function(data) {	
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						alert('Data berhasil di simpan !');
						window.close();
						window.opener.location.reload();	
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
	simpanpenghapusan: function(){
		var me = this;			
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=simpanpenghapusan',
				success: function(data) {	
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						alert('Data berhasil di simpan !');
						window.close();
						window.opener.location.reload();	
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	simpanhpsbagian: function(){
		var me = this;			
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=simpanhpsbagian',
				success: function(data) {	
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						alert('Data berhasil di simpan !');
						window.close();
						window.opener.location.reload();	
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
			yearRange: "1945:+nn",
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
			yearRange: "1945:+nn",
			buttonText : '',
		});					
	},	
	AftFilterRender3: function(){ 			
		$('.datepicker3').datepicker({
		    dateFormat: 'dd-mm-yy',
			showAnim: 'slideDown',
		    inline: true,
			showOn: "button",
			buttonImage: "datepicker/calender1.png",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: "1945:+nn",
			buttonText : '',
			onSelect: function(dateText, inst) { 
		      updatebarang.GetHrg_Asal();
			}
		});				
	},		
	/*AftFilterRender2: function(thn_anggaran){ 			
		$('.datepicker2').datepicker({
		    dateFormat: 'dd-mm-'+thn_anggaran+'',
			showAnim: 'slideDown',
		    inline: true,
			showOn: "button",
			buttonImage: "datepicker/calender1.png",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: thn_anggaran+":"+thn_anggaran,
			buttonText : '',
		});					
	},	*/	
	
	GetHrg_Asal : function (){
		var me = this;
		var formName = document.getElementById('updatebarangForm');
		//var idbukuinduk = this.GetCbxCheckedBi().value;
		//var tgl=document.getElementById('tgl').value;
		//var tgl_perolehan=document.getElementById('tgl_perolehan').value;
		//var idbi=document.getElementById('idbi').value;
		var trans=document.getElementById('trans').value;
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	//url: this.url+'&tipe=GetHrg_Asal&tgl='+tgl+'&tgl_perolehan='+tgl_perolehan+'&idbukuinduk='+idbukuinduk,
			  	url: this.url+'&tipe=GetHrg_Asal&trans='+trans,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					if (resp.err ==''){
						if(trans==1){
							document.getElementById('hrg').value = resp.content.hrg;
							document.getElementById('hrg2').innerHTML = resp.content.hrg2;
						}else{
							document.getElementById('fmHARGA_AWAL').value = resp.content.hrg;
							document.getElementById('fmHARGA_BUKU2').value = resp.content.fmHARGA_BUKU2;
							document.getElementById('fmHARGA_BUKU').value = resp.content.fmHARGA_BUKU;
							document.getElementById('fmAKUMSUSUT2').value = resp.content.fmAKUMSUSUT2;
							document.getElementById('fmAKUMSUSUT').value = resp.content.fmAKUMSUSUT;
						}
						
					}else{
						alert(resp.err);						
					}	
					
				}
			});	
		//var hrg = document.getElementById('hrg2').value;
		//document.getElementById('hrg_baru').value=hrg;
	},
	
	GetHrg_Buku : function (){
		var me = this;
		var formName = document.getElementById('updatebarangForm');
		//var idbukuinduk = this.GetCbxCheckedBi().value;
		//var tgl=document.getElementById('tgl').value;
		//var tgl_perolehan=document.getElementById('tgl_perolehan').value;
		//var idbi=document.getElementById('idbi').value;
		var trans=document.getElementById('trans').value;
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	//url: this.url+'&tipe=GetHrg_Asal&tgl='+tgl+'&tgl_perolehan='+tgl_perolehan+'&idbukuinduk='+idbukuinduk,
			  	url: this.url+'&tipe=GetHrg_Buku&trans='+trans,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					if (resp.err ==''){
						if(trans==1){
							document.getElementById('hrg').value = resp.content.hrg;
							document.getElementById('hrg2').innerHTML = resp.content.hrg2;
						}else{
							document.getElementById('fmHARGA_Buku').value = resp.content.hrg;
							//document.getElementById('fmHARGA_AWAL2').innerHTML = resp.content.hrg2;
						}
						
					}else{
						alert(resp.err);						
					}	
					
				}
			});	
		//var hrg = document.getElementById('hrg2').value;
		//document.getElementById('hrg_baru').value=hrg;
	},	
		
	formatCurrency:function(num){
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
	
	GetNilaiScarp : function(){
		var hrg_awal = document.getElementById('fmHARGA_AWAL').value; 
		var hrg_hapus = document.getElementById('fmHARGA_HAPUS').value;
		var num =  hrg_awal - hrg_hapus;
		num = num.toString().replace(/\$|\,/g,'');
		if(isNaN(num))
		num = '0';
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num*100+0.50000000001);
		cents = num%100;
		num = Math.floor(num/100).toString();
		if(cents<10)
		cents = '0' + cents;
		for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+'.'+
		num.substring(num.length-(4*i+3));
		//return (((sign)?'':'-') + '' + num + ',' + cents);
		document.getElementById('fmHARGA_SCRAP').value = hrg_awal - hrg_hapus;
		document.getElementById('fmHARGA_SCRAP2').innerHTML = (((sign)?'':'-') + '' + num);
					
	}
	
});
