var saldo_awal_keuangan_loSKPD = new SkpdCls({
	prefix : 'saldo_awal_keuangan_loSKPD', formName:'saldo_awal_keuangan_loForm', kolomWidth:120,
	
	pilihUrusanfter : function(){saldo_awal_keuangan_lo.refreshList(true);},
	pilihBidangAfter : function(){saldo_awal_keuangan_lo.refreshList(true);},
	pilihUnitAfter : function(){saldo_awal_keuangan_lo.refreshList(true);},
	pilihSubUnitAfter : function(){saldo_awal_keuangan_lo.refreshList(true);},
	pilihSeksiAfter : function(){saldo_awal_keuangan_lo.refreshList(true);}
	
});

var saldo_awal_keuangan_lo = new DaftarObj2({
	prefix : 'saldo_awal_keuangan_lo',
	url : 'pages.php?Pg=saldo_awal_keuangan_lo', 
	formName : 'saldo_awal_keuangan_loForm',
	withPilih:true,
	elaktiv:'', //id elemen filter yang aktiv
	rowHead:2,
	
	leavePage : function(){
		this.Batal();
	},
	
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

	nyalakandatepicker: function(){
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
		});	
	},	
	
	Baru: function(){	
		var me = this;
		c1 = document.getElementById('saldo_awal_keuangan_loSKPDfmURUSAN').value;
		c = document.getElementById('saldo_awal_keuangan_loSKPDfmSKPD').value;
		d = document.getElementById('saldo_awal_keuangan_loSKPDfmUNIT').value;
		e = document.getElementById('saldo_awal_keuangan_loSKPDfmSUBUNIT').value;
		e1 = document.getElementById('saldo_awal_keuangan_loSKPDfmSEKSI').value;
		err='';
		if(err == '' && c1=='00')err = 'Urusan Belum Dipilih';
		if(err == '' && c=='00')err = 'Bidang Belum Dipilih';
		if(err == '' && d=='00')err = 'SKPD Belum Dipilih';
		if(err == '' && e=='00')err = 'Unit Belum Dipilih';
		if(err == '' && e1=='000')err = 'Sub Unit Belum Dipilih';
		
		if (err =='' ){		
			var aForm = document.getElementById(this.formName);		
			aForm.action= this.url+'_ins&YN=1';	
			aForm.target='_blank';
			aForm.submit();	
			aForm.target='';	
		
		}else{
		 	alert(err);
		}
	},
	
	Edit:function(){
		var me = this;
		c1 = document.getElementById('saldo_awal_keuangan_loSKPDfmURUSAN').value;
		c = document.getElementById('saldo_awal_keuangan_loSKPDfmSKPD').value;
		d = document.getElementById('saldo_awal_keuangan_loSKPDfmUNIT').value;
		e = document.getElementById('saldo_awal_keuangan_loSKPDfmSUBUNIT').value;
		e1 = document.getElementById('saldo_awal_keuangan_loSKPDfmSEKSI').value;
		
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formEdit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					//document.getElementById(cover).innerHTML = resp.content;
					if(resp.err==''){
						var aForm = document.getElementById(saldo_awal_keuangan_lo.formName);		
						aForm.action= saldo_awal_keuangan_lo.url+'_ins&YN=2';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
						aForm.target='_blank';
						aForm.submit();	
						aForm.target='';
					}else{
						alert(resp.err);
					}
			  	}
			});
	},
	
	Edit2:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			var aForm = document.getElementById(this.formName);
			$.ajax({
			  url: this.url+'&tipe=Edit',
			  type : 'POST',
			  data:$('#'+this.formName).serialize(),
			  success: function(data) {
					var resp = eval('(' + data + ')');	
					if(resp.err ==''){
						var Id_jurnal = Number(resp.content.Id_jurnal);
						aForm.action= 'pages.php?Pg=jurnal_keuangan_ins&id='+Id_jurnal;
						aForm.target='_blank';
						aForm.submit();	
						aForm.target='';
					}else{
						alert(resp.err);
					}
					
			  }
			});
		}else{
			alert(errmsg);
		}
	},
	
	Batal: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=batal',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					if(me.satuan_form==0){
						me.Close();						
					}else{
						me.Close();
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
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
				if(resp.err==''){
					me.Close();
					me.AfterSimpan();
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	GetCbxChecked : function(){
		var jmldata= document.getElementById( this.prefix+'_jmldatapage' ).value;
		for(var i=0; i < jmldata; i++){
			if( document.getElementById( this.prefix+'_cb' + i)){
				var box = document.getElementById( this.prefix+'_cb' + i);
				if( box.checked){ 
					break;
				}	
			}
		}
		return box;			
	},
	
});