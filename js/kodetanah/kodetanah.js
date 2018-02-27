var kodetanahSkpd = new SkpdCls({
	prefix : 'kodetanahSkpd', formName:'kodetanahForm'
});

var kodetanah = new DaftarObj2({
	prefix : 'kodetanah',
	url : 'pages.php?Pg=kodetanah', 
	formName : 'kodetanahForm',
	el_kode : '',
	
	CariKdTanah: function(kib){
		if(kib==3){//kibc			
			kodetanah.el_kode = 'fmNOKODETANAH_KIB_C';
			kodetanah.el_alamat = 'fmLETAK_KIB_C';			
			kodetanah.el_luas = 'fmLUAS_KIB_C';
			
		}else{//kibd
			kodetanah.el_kode = 'fmNOKODETANAH_KIB_D';
			kodetanah.el_alamat = 'fmALAMAT_KIB_D';
			kodetanah.el_luas = 'fmLUAS_KIB_D';
		}
			kodetanah.el_kampung = 'kampung';
			kodetanah.el_rt = 'rt';
			kodetanah.el_rw = 'rw';
			kodetanah.el_alamatb = 'WilayahfmxKotaKab';
			kodetanah.el_alamatc = 'WilayahfmxKecamatan';
			kodetanah.el_kota = 'WilayahfmxKotaKabtxt';
			kodetanah.el_kec = 'WilayahfmxKecamatantxt';
			kodetanah.el_kel = 'alamat_kel';
			kodetanah.el_koorgps = 'koordinat_gps';
			kodetanah.el_koorbidang = 'koord_bidang';
			var c1 = document.getElementById('fmURUSAN').value;
			var c = document.getElementById('fmSKPD').value;
			var d = document.getElementById('fmUNIT').value;
			var e = document.getElementById('fmSUBUNIT').value;
			var e1 = document.getElementById('fmSEKSI').value;
			kodetanah.windowShow(kib,c1,c,d,e,e1);
	},
	
	//el_c1 = fmURUSAN;
	windowShow: function(kib,c1,c,d,e,e1){
		var me = this;
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);	
		var formName = 'adminForm';
		$.ajax({
			type:'POST', 
			data:$('#'+formName).serialize(),
			url: this.url+'&tipe=windowshow&kib='+kib+'&c1='+c1+'&c='+c+'&d='+d+'&e='+e+'&e1='+c1,
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				if(resp.err==''){
					document.getElementById(cover).innerHTML = resp.content;	
					me.daftarRender();
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}
		  	}
		});
	},		
	
	windowSaveAfter: function(){
		//alert('tes');
	},
		
	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},
	
	windowSave: function(kib){
		var me= this;
		//alert('save');
		var errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			this.idpilih = box.value;
			
			var cover = 'kodetanah_getdata';
			addCoverPage2(cover,1,true,false);				
			$.ajax({
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=getdata&id='+this.idpilih,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					delElem(cover);
					if(resp.err==''){
						if(document.getElementById(me.el_kode)) document.getElementById(me.el_kode).value= resp.content.el_kode;
						if(document.getElementById(me.el_alamat)) document.getElementById(me.el_alamat).value= resp.content.el_alamat;
						if(document.getElementById(me.el_kampung)) document.getElementById(me.el_kampung).value= resp.content.el_kampung;
						if(document.getElementById(me.el_rt)) document.getElementById(me.el_rt).value= resp.content.el_rt;
						if(document.getElementById(me.el_rw)) document.getElementById(me.el_rw).value= resp.content.el_rw;
						if(document.getElementById(me.el_alamatb)) document.getElementById(me.el_alamatb).value= resp.content.el_alamatb;
						if(document.getElementById(me.el_alamatc)) document.getElementById(me.el_alamatc).innerHTML= resp.content.el_alamatc;
						if(document.getElementById(me.el_kota)) document.getElementById(me.el_kota).value= resp.content.el_kota;
						if(document.getElementById(me.el_kel)) document.getElementById(me.el_kel).value= resp.content.el_kel;
						if(document.getElementById(me.el_koorgps)) document.getElementById(me.el_koorgps).value= resp.content.el_koorgps;
						if(document.getElementById(me.el_koorbidang)) document.getElementById(me.el_koorbidang).value= resp.content.el_koorbidang;
						if(document.getElementById(me.el_luas)) document.getElementById(me.el_luas).value= resp.content.el_luas;
						if(kib == 3){//kib c
							document.getElementById('fmSTATUSTANAH_KIB_C').value= 1;
						}else{//kib d
							document.getElementById('fmSTATUSTANAH_KIB_D').value= 1;
							
						}						
						me.windowClose();
					}else{
						alert(resp.err)	
					}
			  	}
			});
		}else{
			alert(errmsg);
		}
	},	
	lodingdaftar: function(){
		//alert('lodingdaftar');
		this.daftarRender();
		this.sumHalRender();
	},
});
