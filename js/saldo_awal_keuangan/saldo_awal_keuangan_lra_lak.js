var saldo_awal_keuangan_lra_lakSKPD = new SkpdCls({
	prefix : 'saldo_awal_keuangan_lra_lakSKPD', formName:'saldo_awal_keuangan_lra_lakForm', kolomWidth:120,
	
	pilihUrusanfter : function(){saldo_awal_keuangan_lra_lak.refreshList(true);},
	pilihBidangAfter : function(){saldo_awal_keuangan_lra_lak.refreshList(true);},
	pilihUnitAfter : function(){saldo_awal_keuangan_lra_lak.refreshList(true);},
	pilihSubUnitAfter : function(){saldo_awal_keuangan_lra_lak.refreshList(true);},
	pilihSeksiAfter : function(){saldo_awal_keuangan_lra_lak.refreshList(true);}
	
});

var saldo_awal_keuangan_lra_lak = new DaftarObj2({
	prefix : 'saldo_awal_keuangan_lra_lak',
	url : 'pages.php?Pg=saldo_awal_keuangan_lra_lak', 
	formName : 'saldo_awal_keuangan_lra_lakForm',
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
	
	/*Baru: function(){	
		var me = this;
		c1 = document.getElementById('saldo_awal_keuangan_neracaSKPDfmURUSAN').value;
		c = document.getElementById('saldo_awal_keuangan_neracaSKPDfmSKPD').value;
		d = document.getElementById('saldo_awal_keuangan_neracaSKPDfmUNIT').value;
		e = document.getElementById('saldo_awal_keuangan_neracaSKPDfmSUBUNIT').value;
		e1 = document.getElementById('saldo_awal_keuangan_neracaSKPDfmSEKSI').value;
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
	},*/
	
	Edit:function(){
		var me = this;
		c1 = document.getElementById('saldo_awal_keuangan_lra_lakSKPDfmURUSAN').value;
		c = document.getElementById('saldo_awal_keuangan_lra_lakSKPDfmSKPD').value;
		d = document.getElementById('saldo_awal_keuangan_lra_lakSKPDfmUNIT').value;
		e = document.getElementById('saldo_awal_keuangan_lra_lakSKPDfmSUBUNIT').value;
		e1 = document.getElementById('saldo_awal_keuangan_lra_lakSKPDfmSEKSI').value;
		/*err='';
		if(err == '' && c1=='00')err = 'Urusan Belum Dipilih';
		if(err == '' && c=='00')err = 'Bidang Belum Dipilih';
		if(err == '' && d=='00')err = 'SKPD Belum Dipilih';
		if(err == '' && e=='00')err = 'Unit Belum Dipilih';
		if(err == '' && e1=='000')err = 'Sub Unit Belum Dipilih';
		
		if (err =='' ){	*/		
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formEdit',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					//document.getElementById(cover).innerHTML = resp.content;
					if(resp.err==''){
						var aForm = document.getElementById(saldo_awal_keuangan_lra_lak.formName);		
						aForm.action= saldo_awal_keuangan_lra_lak.url+'_ins&YN=2';//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
						aForm.target='_blank';
						aForm.submit();	
						aForm.target='';
					}else{
						alert(resp.err);
					}
			  	}
			});
		/*}else{
			alert(err);
		}*/
	},
	
	/*Edit2:function(){
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
					//	var ID_EDIT = Number(resp.content.ID_EDIT);
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
	},*/
	
	
	/*Baru2: function(){
	var me = this;
		errmsg = '';
			c1n = document.getElementById('ref_jurnal_keuanganSKPDfmURUSAN');
			cn = document.getElementById('ref_jurnal_keuanganSKPDfmSKPD');
			dn = document.getElementById('ref_jurnal_keuanganSKPDfmUNIT');
			en = document.getElementById('ref_jurnal_keuanganSKPDfmSUBUNIT');
			e1n = document.getElementById('ref_jurnal_keuanganSKPDfmSEKSI');
		
		if(c1n != '' && skpd != 1){
			if(errmsg == '' && c1n.value == '0')errmsg = "URUSAN Belum di Pilih ! ";
		}
		if(errmsg == '' && cn.value == '00')errmsg = "BIDANG Belum di Pilih ! ";
		if(errmsg == '' && dn.value == '00')errmsg = "SKPD Belum di Pilih ! ";
		if(errmsg == '' && en.value == '00')errmsg = "UNIT Belum di Pilih ! ";
		if(errmsg == '' && e1n.value == '000')errmsg = "SUB UNIT Belum di Pilih ! ";
		
		if(errmsg ==''){ 
							
			var aForm = document.getElementById(this.formName);		
			aForm.action= this.url+'_ins';	
			aForm.target='_blank';
			aForm.submit();	
			aForm.target='';
		}else{
				alert(errmsg);
		}	
	},*/

/*cekJumlahData: function(datamulai,persenakhir){
		
		document.getElementById('statustxt').style.width="0%";
		persen = document.getElementById('statustxt');
		jumlahdata = document.getElementById('jumlahdata').value;// =100%
		
		if(document.getElementById('persediaanclossing')){
			var myprefix = 'refclosingdata';
		}else{
			var myprefix = this.prefix;
		}
		
		jumdat = 0;
		if(datamulai == 0){
			datamulai=1;
		 	mulaidata = 0;
		}else{
		 	mulaidata = datamulai;
		}
		 
	    var elem = document.getElementById("progressbox"); 
	    var persen = Math.round((datamulai*100)/jumlahdata);
		
		document.getElementById("statustxt").style.width = persenakhir+"%"; 	  	
			
		if(persen <= 100){
			var me= this;	
			this.OnErrorClose = false	
			document.body.style.overflow='hidden';
			var cover = this.prefix+'_formsimpan';
			addCoverPage2(cover,1,true,false);	*/
			
		/*this.sendReq(
			this.url,
			{ idprs: 0, daftarProses: new Array('simpan')},
			this.formDialog);*/
			/*$.ajax({
				type:'POST', 
				data:$('#'+myprefix+'_form').serialize(),
				url: this.url+'&tipe=simpan&jumdat='+mulaidata,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					delElem(cover);		
					//document.getElementById(cover).innerHTML = resp.content;
					if(resp.err==''){
						//alert(persen);
					 	//elem.style.width = persen + '%';
						elem.innerHTML = "<div id='progressbar'></div ><div id='statustxt' style='width:"+persen+"%;background:green;height:10px;text-align:right;color:white;font-size:8px;'>"+persen+"%</div><div id='output'></div>"; 		 			
					 	datamulai = mulaidata+100;
						persenakhir = persen;
						if(persen < 100)me.cekJumlahData(datamulai,persenakhir);
						if(persen >= 100){*/
							//setTimeout(function myFunction() {alert("Berhasil Menghitung Ulang")}, 100)	;
						//	if(document.getElementById('persediaanclossing'))setTimeout(function myFunction2() {refclosingdata.Simpan()},5000);
							//me.Close();
						/*}
					}else{
						alert(resp.err);
					}
			  	}
			});	
		}else{
			setTimeout(function myFunction() {alert("Berhasil Menghitung Ulang");}, 100)	;
			document.getElementById("statustxt").style.width = "100%"; 
			document.getElementById("statustxt").innerHTML = "100%"; 
		//	if(document.getElementById('persediaanclossing'))setTimeout(function myFunction2() {refclosingdata.Simpan()},200);
			
		}	 
	},*/
	
	
	
	/*Hapus:function(){
		
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
	},*/
	
	
	
	
	
	/*AfterFormBaru:function(){  
		idp = document.getElementById('ref_jurnal_keuangan_idplh').value;
		
		document.getElementById('jurnalkeuangandetail').innerHTML = 
			//"<div id='DaftarBarangDetail_cont_title' style='position:relative'></div>"+
			"<div id='jurnalkeuangan_cont_opsi' style='position:relative'>"+
			"<input type='hidden' name='idp' id='idp' value='"+idp+"'>"+
			"</div>"+
			"<div align='right'>"+					
			"<input type='button' name='tambah' id='tambah' value='Tambah'  onclick=\"javascript:jurnalkeuangandetail.Baru()\" >"+
			"<input type='button' name='edit' id='edit' value='Edit'  onclick=\"javascript:jurnalkeuangandetail.Edit()\" >"+	
			"<input type='button' name='hapus' id='hapus' value='Hapus'  onclick=\"javascript:jurnalkeuangandetail.Hapus()\" >"+
			"</div>"+
			"<div id='jurnalkeuangandetail_cont_daftar' style='position:relative'></div>"+
			"<div id='jurnalkeuangandetail_cont_hal' style='position:relative'></div>"
			;
		//generate data
	   jurnalkeuangandetail.loading();
	},*/
	
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
		
		//document.getElementById('ref_jenis').disabled = false;
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