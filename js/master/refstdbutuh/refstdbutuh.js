var refstdbutuhSkpd = new SkpdCls({
	prefix : 'refstdbutuhSkpd', 
	formName: 'refstdbutuhForm',
	pilihBidangAfter : function(){refstdbutuh.refreshList(true);},
	pilihUnitAfter : function(){refstdbutuh.refreshList(true);},
	pilihSubUnitAfter : function(){refstdbutuh.refreshList(true);},
	pilihSeksiAfter : function(){refstdbutuh.refreshList(true);}
});

var refstdbutuh = new DaftarObj2({
	prefix : 'refstdbutuh',
	url : 'pages.php?Pg=ref_std_butuh', 
	formName : 'refstdbutuhForm',
	
	loading:function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();
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
	
	Baru:function(){
		var me = this;
		var err ='';
		if($("#refstdbutuhSkpdfmUrusan").val() =='0'){
			err = "Pilih Urusan";
		}else if($("#refstdbutuhSkpdfmSKPD").val() =='00'){
			err = "Pilih Bidang";
		}else if($("#refstdbutuhSkpdfmUNIT").val() =='00'){
			err = "Pilih SKPD";
		}else if($("#refstdbutuhSkpdfmSUBUNIT").val() =='00'){
			err = "Pilih UNIT";
		}else if($("#refstdbutuhSkpdfmSEKSI").val() =='000'){
			err = "Pilih SUB UNIT";
		}
	
		if (err =='' ){				
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,2,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;			
						//me.AfterFormBaru(resp);	
						listBarangMax.loading();

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

	editData:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,2,true,false);	
			$.ajax({
			  url: this.url+'&tipe=editData',
			  type : 'POST',
			  data:$('#'+this.formName).serialize(),
			  success: function(data) {
					var resp = eval('(' + data + ')');	
					if(resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);
					}
					
			  }
			});
		}else{
			alert(errmsg);
		}
		
	},
	BidangAfterform: function(){
		var me = this;
		
		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=BidangAfterForm',
		  type : 'POST',
		  data:{fmSKPDBidang: $("#cmbBidangForm").val(),
		  		fmSKPDUrusan: $("#cmbUrusanForm").val(),
				fmSKPDskpd: $("#cmbSKPDForm").val(), 
				fmSKPDUnit: $("#cmbUnitForm").val(), 
				fmSKPDSubUnit: $("#cmbSubUnitForm").val(), 
				},
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagian');
				document.getElementById('cmbBidangForm').innerHTML=resp.content.bidang;
				document.getElementById('cmbSKPDForm').innerHTML=resp.content.skpd;
				document.getElementById('cmbUnitForm').innerHTML=resp.content.unit;
				document.getElementById('cmbSubUnitForm').innerHTML=resp.content.subUnit;
				

				
				
		  }
		});

	},
	Cari: function(){
		popupBarang_v2.kodeBarang = 'kodeBarang';
		popupBarang_v2.namaBarang = 'namaBarang'; 
		popupBarang_v2.satuanBarang = 'satuan'; 
		popupBarang_v2.windowShow();
		
	},		
		
	AfterSimpan : function(){
		if(document.getElementById('Kunjungan_cont_daftar')){
		this.refreshList(true);}
	},
	
	Simpan: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#listBarangMaxForm').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					alert('Data berhasil disimpan');
					me.Close();
					me.refreshList(true);
				}
				else{
					alert(resp.err);
				}
		  	}
		});
	},
	saveData: function(kode){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:{
					kode : kode,
					jumlahBarang : $("#jumlahBarang").val()
				 },
			url: this.url+'&tipe=saveData',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					alert('Data berhasil disimpan');
					me.Close();
					me.refreshList(true);
				}
				else{
					alert(resp.err);
				}
		  	}
		});
	}
});
