var Pembukuan2skpdSkpd = new SkpdCls({
	prefix : 'Pembukuan2skpdSkpd', formName:'adminForm'
});


var Pembukuan2skpd = new DaftarObj2({
	prefix : 'Pembukuan2skpd',
	url : 'pages.php?Pg=Rekap1_skpd', 
	formName : 'adminForm',// 'ruang_form',
	
	BidangAfter: function(){
		var me = this;
		
		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=BidangAfter',
		  type : 'POST',
		  data:$('#'+this.formName).serialize(),
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagian');
				
				document.getElementById('fmSKPDskpd').innerHTML=resp.content;
				
		  }
		});
	},
	SKPDAfter: function(){
		var me = this;
		
		//this.formName = 'adminForm';
		$.ajax({
		  url: this.url+'&tipe=SKPDAfter',
		  type : 'POST',
		  data:$('#'+this.formName).serialize(),
		  success: function(data) {
			var resp = eval('(' + data + ')');	//console.info(me);	//console.info('id='+me.prefix+'CbxBagian');
				
				
				
		  }
		});
	}, 
	
});
