var cariBarang = new DaftarObj2({
	prefix : 'cariBarang',
	url : 'pages.php?Pg=cariBarang', 
	formName : 'cariBarangForm',
	Bar : '',
	satuan_form : '0',//default js satuan
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
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	
	pilBar: function(p){
		var me = this;
		
		var kodeacountap = "";
		if(document.getElementById('kode_account_ap'))kodeacountap = document.getElementById('kode_account_ap');
		
		var cover = me.prefix+'_coverNya';
		//var idrekeningnya = document.getElementById('idrek').value;
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=getid&kodebarangambil='+p,
		  	success: function(data) {	
				var resp = eval('(' + data + ')');	
				delElem(cover);
				if(resp.err==''){
					document.getElementById('kodebarang'+me.Bar).value = resp.content.kodebarang;
					document.getElementById('namabarang'+me.Bar).value = resp.content.namabarang;					
					if(kodeacountap.value != "" || kodeacountap.value != "0"){
						if(document.getElementById('satuan'))document.getElementById('satuan').value = resp.content.satuan;
						if(document.getElementById('satuan2'))document.getElementById('satuan2').value = resp.content.satuan;
					}else{
						document.getElementById('satuan'+me.Bar).value = resp.content.satuan;						
					}
					me.windowClose();
				}else{
					alert(resp.err);
				}
					
				
		  	}
		});
	},
	
	GetData_pemasukan_v2: function(p){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formGetData_pemasukan_v2';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'Form').serialize(),
			url: this.url+'&tipe=GetData_pemasukan_v2&kode='+p,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					me.windowClose();
					me.GetData_pemasukan_v2_After();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	GetData_pemasukan_v2_After: function(){
		var me=this;	
	},
	
	pilBar2: function(p, DAR=''){
		var me = this;
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
			url: this.url+'&tipe=getid&kodebarangambil='+p,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				if(resp.err==''){
					//document.getElementById('kodebarang').value = resp.content.kodebarang;
					document.getElementById('namabarang'+DAR).value = resp.content.namabarang;
					document.getElementById('satuan'+DAR).value = resp.content.satuan;
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	windowShow: function(urlnya='', Darinya=''){
		var me = this;
		
		var cover = this.prefix+'_cover';
		
		if(urlnya == '')urlnya=this.formName;
		
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+urlnya).serialize(),
			url: this.url+'&tipe=windowshow&Darinya='+Darinya,
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
	
});
