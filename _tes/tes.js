

function get_tes(){
	$.ajax({
	  	//url: 'tes.php?tipe=get_tes',
	  	url: '/pages.php?Pg=05&SPg=03&opt={"idprs":1,"daftarProses":["list","sumhal"]}',
		
		type:'POST', 
		data:$('#'+this.formName).serialize(), 
		//contentType: "application/x-www-form-urlencoded;charset=ISO-8859-1",	
	  	success: function(data) {		
			try{ var resp = eval('('+ data + ')'); } catch(err2){ var resp = data; }
			alert( resp.content )	;
			//document.getElementById(me.prefix+'_cont_daftar').innerHTML = resp.content;
			//if(me.withPilih) me.cbTampil();	
			//me.daftarRenderAfter(resp);	
			//me.sumHalRender();
		
	  	},
		//error: ajaxError
	});
	
	
	
}


