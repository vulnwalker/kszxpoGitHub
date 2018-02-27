var NeracaSkpdSkpd = new SkpdCls({
	prefix : 'NeracaSkpdSkpd', formName:'adminForm'
});


var NeracaSkpd = new DaftarObj2({
	prefix : 'NeracaSkpd',
	url : 'pages.php?Pg=NeracaSkpd', 
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
