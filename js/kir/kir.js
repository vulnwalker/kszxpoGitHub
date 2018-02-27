var kir = new DaftarObj2({
	prefix : 'kir',
	url : 'pages.php?Pg=kir', 
	formName : 'kirForm',
	
	loading: function(){
		this.topBarRender();
		this.filterRender();
		//this.daftarRender();
		//this.sumHalRender();	
	},
	
	kirBaru: function(){
	var me = this; var errmsg ='';
		var jmlcek = document.getElementById('boxchecked').value ;	
		if((errmsg=='') && ( (document.getElementById('boxchecked').value == 0)||(document.getElementById('boxchecked').value == '')  )){
			errmsg= 'Data belum dipilih!';
		}		
		if(errmsg ==''){ 
			var box = this.GetCbxCheckedBi();
			if(confirm('KIR '+jmlcek+' Data ?')){
				if(errmsg ==''){ 							
					//var aForm = document.getElementById(this.formName);		
					var aForm = document.getElementById('adminForm');		
					aForm.action= this.url;//'?Op='+op+'&Pg=2&idprs=cetak_hal';		
					aForm.target='_blank';
					aForm.submit();	
					aForm.target='';
				}
			}	
		}else{
			alert(errmsg);				
		}
	},
	
	pilihRuang : function(){		
					var me = this;	
					/*if( document.getElementById('fmURUSAN')) RuangPilih.fmURUSAN = document.getElementById('fmURUSAN').value;	
					RuangPilih.fmSKPD = document.getElementById('fmSKPD').value;
					RuangPilih.fmUNIT = document.getElementById('fmUNIT').value;
					RuangPilih.fmSUBUNIT = document.getElementById('fmSUBUNIT').value;
					RuangPilih.fmSEKSI = document.getElementById('fmSEKSI').value;
					*/
					RuangPilih.fmIDBARANG = document.getElementById('idplh').value;
					RuangPilih.el_idruang= 'ref_idruang';
					RuangPilih.el_nmgedung= 'nm_gedung';
					RuangPilih.el_nmruang= 'nm_ruang';
					RuangPilih.windowShow();
				},
	
	Simpan: function(){
		var me = this;			
		$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=simpan',
				success: function(data) {	
					var resp = eval('(' + data + ')');
					if(resp.err==''){
						alert("Sukses Simpan data !")
						window.close();
						window.opener.location.reload();	
					}else{
						alert(resp.err);
					}
				}
			});	
	},
	
});
