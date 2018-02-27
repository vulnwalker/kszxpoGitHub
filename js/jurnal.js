var JurnalSkpd = new SkpdCls({
	prefix : 'JurnalSkpd', formName:'adminForm'
});


var Jurnal = new DaftarObj2({
	prefix : 'Jurnal',
	url : 'pages.php?Pg=Jurnal', 
	formName : 'adminForm',// 'ruang_form',
	
	BaruBI : function(){
		var me = this; var errmsg ='';
		errmsg = this.CekCheckboxBi();
		if(errmsg ==''){ 
			var box = this.GetCbxCheckedBi();
			//if(confirm("Reclass Aset Lain-lain?")){
				
			
				var cover = this.prefix+'_formcover';
				addCoverPage2(cover,1,true,false);	
				document.body.style.overflow='hidden';
				$.ajax({
					type:'POST', 
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=formBaruBI',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');	
						if (resp.err ==''){		
							document.getElementById(cover).innerHTML = resp.content;
							//me.AfterFormBaru(resp);	
						}else{
							alert(resp.err);
							delElem(cover);
							document.body.style.overflow='auto';
						}
				  	}
				});
			//}
		}else{
			alert(errmsg);
		}
		
	},
	
	AfterSimpan : function(){
		//
		if(document.getElementById('penatausaha_cont_list') ) {
			Penatausaha.refreshList(false);
		}else{
			this.refreshList(false);
		}
			
	},
	
	/*exportXls : function(){
		var aForm = document.getElementById(this.formName);	
		
		var tmp = document.getElementById('div_cek').innerHTML;
		document.getElementById('div_cek').innerHTML = ''; 
		var str = document.getElementById('Jurnal_cont_daftar').innerHTML;
		//var re = new RegExp('"', 'g');
		str = replaceAll(str, '"', '');
		str = replaceAll(str, 'class=koptable', 'class=cetak');
		str = replaceAll(str, '<a ', '<span ');
		str = replaceAll(str, 'GarisDaftar', 'GarisCetak');
		str = str.replace(/[\n\r]/g, '');
		
		document.getElementById('daftarcetak').value = str;
		
		aForm.action=this.url+'&tipe=exportXls';
		//aForm.target='_blank';
		aForm.submit();	
		aForm.target='';
		document.getElementById('div_cek').innerHTML = tmp; 
		
	},*/
	
	
	
});
