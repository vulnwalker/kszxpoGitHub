var ref_skpdSkpd = new SkpdCls({
	prefix : 'ref_skpdSkpd', formName:'ref_skpdForm',
	
	pilihUrusanAfter : function(){ref_skpd.refreshList(true);},
	pilihBidangAfter : function(){ref_skpd.refreshList(true);},
	pilihUnitAfter : function(){ref_skpd.refreshList(true);},
	pilihSubUnitAfter : function(){ref_skpd.refreshList(true);},
	pilihSeksiAfter : function(){ref_skpd.refreshList(true);}
});

var ref_skpd = new DaftarObj2({
	prefix : 'ref_skpd',
	url : 'pages.php?Pg=ref_skpd&ajx=3', 
	formName : 'ref_skpdForm',
	
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
		  url: 'pages.php?Pg=ref_skpd&tipe=pilihUrusan',
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
		//	document.getElementById('fmc1').innerHTML = resp.content.dat;
			document.getElementById('cont_c').innerHTML = resp.content.c;
			document.getElementById('cont_d').innerHTML = resp.content.d;
			document.getElementById('cont_e').innerHTML = resp.content.e;
		//	document.getElementById('cont_e1').innerHTML = resp.content.e1;
			document.getElementById('e1').value = resp.content.e1;
			
			
		  }
		});
	},
	
	
	
	pilihBidang : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=pilihBidang',
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_d').innerHTML = resp.content.d;
			document.getElementById('cont_e').innerHTML = resp.content.e;
			document.getElementById('e1').value = resp.content.e1;
		  }
		});
	},
	
	pilihSKPD : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=pilihSKPD',
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e').innerHTML = resp.content.skp;
			document.getElementById('e1').value = resp.content.e1;
		  }
		});
	},
	
	pilihUnit : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=pilihUnit',
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('e1').value = resp.content.e1;
			
			//document.getElementById('cont_ke').innerHTML = resp.content.unit;
			//document.getElementById('j').value = resp.content.j;
		  }
		});
	},
	
	pilihBidang4 : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=pilihBidang4',
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_d').innerHTML = resp.content.d4;
			document.getElementById('cont_e').innerHTML = resp.content.e4;
			document.getElementById('cont_e1').innerHTML = resp.content.e14;
		  }
		});
	},
	
	pilihSKPD4 : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=pilihSKPD4',
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e').innerHTML = resp.content.e4;
			document.getElementById('cont_e1').innerHTML = resp.content.e14;
		  }
		});
	},
	
	pilihUnit4 : function(){
	var me = this; 
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=pilihUnit4',
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('e1').value = resp.content.e14;
			
			//document.getElementById('cont_ke').innerHTML = resp.content.unit;
			//document.getElementById('j').value = resp.content.j;
		  }
		});
	},
	
	BaruUrusan: function(){	
		var me = this;
		var err='';
		var kdc1 =document.getElementById('datac1').value;
		if(err=='' && (kdc1=='9') ) err='Tidak bisa tambah baru urusan sudah batas maximal 9 !!';
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKA';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_skpd_form').serialize(),
			  	url: this.url+'&tipe=BaruUrusan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		
	},		
	
	BaruBidang: function(){	
		var me = this;
		var err='';
		var kdc1 =document.getElementById('fmc1').value;
		if (kdc1==''){
			alert('Kode Urusan belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_skpd_form').serialize(),
			  	url: this.url+'&tipe=BaruBidang',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
			  	}
			});
		}else{
		 	alert(err);
		}
		}		
	},		
	
	BaruBidang4: function(){	
		var me = this;
		var err='';
	
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKB';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_skpd_form').serialize(),
			  	url: this.url+'&tipe=BaruBidang4',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
			  	}
			});
		}else{
		 	alert(err);
		}
		
	},		
	
	BaruSKPD: function(){	
		var me = this;
		var err='';
		var kdc1 =document.getElementById('fmc1').value;
		var kdc =document.getElementById('fmc').value;
		if (kdc1=='' && kdc==''){
			alert('Kode Urusan dan BIdang belum terpilih !!');
		}else if (kdc==''){
			alert('Bidang belum terpilih !!');
		}else{
		
		/*var kdc =document.getElementById('fmc').value;
		if (kdc==''){
			alert('Kode Bidang belum terpilih !!');
		}else{*/
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKC';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_skpd_form').serialize(),
			  	url: this.url+'&tipe=BaruSKPD',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		}
	},
	
	BaruSKPD4: function(){	
		var me = this;
		var err='';
	//	var kda =document.getElementById('fmc1').value;
		var kdc =document.getElementById('fmc').value;
		if (fmc==''){
			alert('Kode Bidang belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKC';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_skpd_form').serialize(),
			  	url: this.url+'&tipe=BaruSKPD4',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		}
	},
	
	BaruUnit: function(){	
		var me = this;
		var err='';
		
		var kdc1 =document.getElementById('fmc1').value;
		var kdc =document.getElementById('fmc').value;
		var kdd =document.getElementById('fmd').value;
		if (kdc1=='' && kdc=='' && kdd==''){
			alert('Kode Urusan ,Bidang dan SKPD belum terpilih !!');
		}else if (kdc==''  && kdd==''){
			alert('Bidang dan SKPD belum terpilih !!');
		}else if (kdd==''){
			alert('SKPD belum terpilih !!');
		}
		else{
		
	//	var kda =document.getElementById('fmc1').value;
		/*var kdb =document.getElementById('fmc').value;
		var kdc =document.getElementById('fmd').value;
		
		if (kdb==''|| kdc==''){
			alert('Kode BIDANG / Kode SKPD belum terpilih !!');
		}else{*/
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKD';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_skpd_form').serialize(),
			  	url: this.url+'&tipe=BaruUnit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		}
	},	
	
	BaruUnit4: function(){	
		var me = this;
		var err='';
	//	var kda =document.getElementById('fmc1').value;
		var kdb =document.getElementById('fmc').value;
		var kdc =document.getElementById('fmd').value;
		
		if (kdb==''|| kdc==''){
			alert('Kode BIDANG / Kode SKPD belum terpilih !!');
		}else{
		if (err =='' ){		
			var cover = this.prefix+'_formcoverKD';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#ref_skpd_form').serialize(),
			  	url: this.url+'&tipe=BaruUnit4',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru();
			  	}
			});
		}else{
		 	alert(err);
		}	
		}
	},	
	
	Close1:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKA';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close2:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKB';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close3:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKC';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close4:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKD';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	Close5:function(){//alert(this.elCover);
		var cover = this.prefix+'_formcoverKE';
		if(document.getElementById(cover)) delElem(cover);			
		if(tipe==null){
			document.body.style.overflow='auto';						
		}
	},
	
	
	
	
	SimpanUrusan: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KAform').serialize(),
			url: this.url+'&tipe=simpanUrusan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshUrusan(resp.content);
					me.Close1();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanUrusanEdit: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanUrusanEdit',
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
	},
	
	SimpanUrusanEdit4: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanUrusanEdit4',
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
	},
	
	SimpanBidangEdit: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanBidangEdit',
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
	},
	
	SimpanBidangEdit4: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanBidangEdit4',
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
	},
	
	SimpanSKPDEdit: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanSKPDEdit',
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
	},
	
	SimpanSKPDEdit4: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanSKPDEdit4',
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
	},
	
	SimpanUnitEdit: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanUnitEdit',
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
	},
	
	
	SimpanUnitEdit4: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanUnitEdit4',
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
	},
	
	SimpanEdit: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanEdit',
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
	},
	
	SimpanEdit4: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKA';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpanEdit4',
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
	},
	
	
	SimpanBidang: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize(),
			url: this.url+'&tipe=simpanBidang',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshBidang(resp.content);
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanBidang4: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKB';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KBform').serialize(),
			url: this.url+'&tipe=simpanBidang4',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshBidang4(resp.content);
					me.Close2();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanSKPD: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKC';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KCform').serialize(),
			url: this.url+'&tipe=simpanSKPD',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshSKPD(resp.content);
					me.Close3();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanSKPD4: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKC';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KCform').serialize(),
			url: this.url+'&tipe=simpanSKPD4',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshSKPD4(resp.content);
					me.Close3();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanUnit: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKD';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KDform').serialize(),
			url: this.url+'&tipe=simpanUnit',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshUnit(resp.content);
					me.Close4();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SimpanUnit4: function(){
		var me= this;
		var err='';
		
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpanKD';
		addCoverPage2(cover,1,true,false);	
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_KDform').serialize(),
			url: this.url+'&tipe=simpanUnit4',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				
				if(resp.err==''){
					me.refreshUnit4(resp.content);
					me.Close4();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	refreshUrusan : function(id_UrusanBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=refreshUrusan&id_UrusanBaru='+id_UrusanBaru,
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_c1').innerHTML = resp.content.c1;
			document.getElementById('cont_c').innerHTML = resp.content.c;
			document.getElementById('cont_d').innerHTML = resp.content.d;
			document.getElementById('cont_e').innerHTML = resp.content.e;
			document.getElementById('cont_e1').innerHTML = resp.content.e1;
		  }
		});
	},
	
	
	refreshBidang : function(id_BidangBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=refreshBidang&id_BidangBaru='+id_BidangBaru,
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_c').innerHTML = resp.content.c;
			document.getElementById('cont_d').innerHTML = resp.content.d;
			document.getElementById('cont_e').innerHTML = resp.content.e;
			document.getElementById('cont_e1').innerHTML = resp.content.e1;
		  }
		});
	},
	
	refreshBidang4 : function(id_BidangBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=refreshBidang4&id_BidangBaru='+id_BidangBaru,
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			
			document.getElementById('cont_c').innerHTML = resp.content.c4;
			document.getElementById('cont_d').innerHTML = resp.content.d4;
			document.getElementById('cont_e').innerHTML = resp.content.e4;
			document.getElementById('cont_e1').innerHTML = resp.content.e14;
		  }
		});
	},
	
	refreshSKPD4 : function(id_SKPDBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=refreshSKPD4&id_SKPDBaru='+id_SKPDBaru,
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_d').innerHTML = resp.content.d4;
			document.getElementById('cont_e').innerHTML = resp.content.e4;
			document.getElementById('cont_e1').innerHTML = resp.content.e14;
		  }
		});
	},
	
	refreshSKPD : function(id_SKPDBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=refreshSKPD&id_SKPDBaru='+id_SKPDBaru,
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_d').innerHTML = resp.content.d;
			document.getElementById('cont_e').innerHTML = resp.content.e;
		  }
		});
	},
	
	refreshUnit : function(id_UnitBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=refreshUnit&id_UnitBaru='+id_UnitBaru,
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e').innerHTML = resp.content.e;
		me.getKode_e1();
		  }
		});
	},
	
	refreshUnit4 : function(id_UnitBaru){
	var me = this; //alert('tes');	//alert(this.prefix);
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=refreshUnit4&id_UnitBaru='+id_UnitBaru,
		  type : 'POST',
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('cont_e').innerHTML = resp.content.e4;
		me.getKode_e1();
		  }
		});
	},
	
	getKode_e1 : function(){
	var me = this; //alert('tes');	//alert(this.prefix);
		
		$.ajax({
		  url: 'pages.php?Pg=ref_skpd&tipe=getKode_e1',
		  type : 'POST',
		  //data:$('#adminForm').serialize(),
		  data:$('#ref_skpd_form').serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');			
			document.getElementById('e1').value = resp.content.e1;
		  }
		});
	
	},		
	
	Baru: function(){	
		
		var me = this;
		var err='';
		var dat_urusan = document.getElementById('dat_urusan').value;
		if (dat_urusan=='0'){
			
			var skpd = document.getElementById('ref_skpdSkpdfmSKPD').value; 
			var unit = document.getElementById('ref_skpdSkpdfmUNIT').value;
			var subunit = document.getElementById('ref_skpdSkpdfmSUBUNIT').value;
			var seksi = document.getElementById('ref_skpdSkpdfmSEKSI').value;
		
			/*if(err=='' && (skpd=='' || skpd=='00') ) err='BIDANG belum dipilih!';
			if(err=='' && (unit=='' || unit=='00') ) err='SKPD belum dipilih!';
			if(err=='' && (subunit=='' || subunit=='00') ) err='UNIT belum dipilih!';
			if(err=='' && (seksi=='' || seksi=='000' || seksi=='000') ) err='SUB UNIT belum dipilih!';*/
				
		}else{
		
			var urusan = document.getElementById('ref_skpdSkpdfmURUSAN').value; 
			var skpd = document.getElementById('ref_skpdSkpdfmSKPD').value; 
			var unit = document.getElementById('ref_skpdSkpdfmUNIT').value;
			var subunit = document.getElementById('ref_skpdSkpdfmSUBUNIT').value;
			var seksi = document.getElementById('ref_skpdSkpdfmSEKSI').value;
			
			/*if(err=='' && (urusan=='' || urusan=='0') ) err='URUSAN belum dipilih!';
			if(err=='' && (skpd=='' || skpd=='00') ) err='BIDANG belum dipilih!';
			if(err=='' && (unit=='' || unit=='00') ) err='SKPD belum dipilih!';
			if(err=='' && (subunit=='' || subunit=='00') ) err='UNIT belum dipilih!';
			if(err=='' && (seksi=='' || seksi=='000' || seksi=='000') ) err='SUB UNIT belum dipilih!';	*/
		}
				
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
					document.getElementById('kode1').focus();			
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
	
	Simpan4: function(){
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
			url: this.url+'&tipe=simpan4',
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
