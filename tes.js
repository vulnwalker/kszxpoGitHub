

function get_tes(){
	/**
	$.ajax({
	  	//url: 'tes.php?tipe=get_tes',
	  	url: 'pages.php?Pg=05&SPg=03&opt={"idprs":1,"daftarProses":["list","sumhal"]}',
		
		type:'POST', 
		data:$('#'+this.formName).serialize(), 
		//contentType: "application/x-www-form-urlencoded;charset=ISO-8859-1",	
	  	success: function(data) {		
			try{ var resp = eval('('+ data + ')'); } catch(err2){ var resp = data; }
			
			document.getElementById('_cont_hal').innerHTML = resp.content.hal;
			//alert( resp.content )	;
			//document.getElementById(me.prefix+'_cont_daftar').innerHTML = resp.content;
			//if(me.withPilih) me.cbTampil();	
			//me.daftarRenderAfter(resp);	
			//me.sumHalRender();
		
	  	},
		//error: ajaxError
	});
	**/
	get_daftar();
	
	
	
	
}

function get_hall(){
	$.ajax({
	  	//url: 'tes.php?tipe=get_tes',
	  	//url: 'pages.php?Pg=05&SPg=03&opt={"idprs":1,"daftarProses":["list","sumhal"]}',
	  	url: 'pages.php?Pg=pemusnahanba&ajx=1&tipe=sumhal',
		
		type:'POST', 
		data:$('#'+this.formName).serialize(), 
		//contentType: "application/x-www-form-urlencoded;charset=ISO-8859-1",	
	  	success: function(data) {		
			try{ var resp = eval('('+ data + ')'); } catch(err2){ var resp = data; }
			
			document.getElementById('_cont_hal').innerHTML = resp.content.hal;
			
			//alert( resp.content )	;
			//document.getElementById(me.prefix+'_cont_daftar').innerHTML = resp.content;
			//if(me.withPilih) me.cbTampil();	
			//me.daftarRenderAfter(resp);	
			//me.sumHalRender();
			get_filter();
		
	  	},
		error: ajaxError
	});
	
}

function get_daftar(){
	$.ajax({
	  	//url: 'tes.php?tipe=get_tes',
	  	//url: 'pages.php?Pg=05&SPg=03&opt={"idprs":0,"daftarProses":["list","sumhal"]}',
	  	url: 'pages.php?Pg=pemusnahanba&ajx=1&tipe=daftar',
		
		type:'POST', 
		data:$('#'+this.formName).serialize(), 
		//contentType: "application/x-www-form-urlencoded;charset=ISO-8859-1",	
	  	success: function(data) {		
			try{ var resp = eval('('+ data + ')'); } catch(err2){ var resp = data; }
			
			//document.getElementById('_cont_daftar').innerHTML = resp.content.list;
			document.getElementById('_cont_daftar').innerHTML = resp.content;
			//alert( resp.content )	;
			//document.getElementById(me.prefix+'_cont_daftar').innerHTML = resp.content;
			//if(me.withPilih) me.cbTampil();	
			//me.daftarRenderAfter(resp);	
			//me.sumHalRender();
			//get_hall();
			get_hall();
	  	},
		error: ajaxError
	});
	
}


function get_filter(){
	$.ajax({
	  	//url: 'tes.php?tipe=get_tes',
	  	//url: 'pages.php?Pg=05&SPg=03&opt={"idprs":0,"daftarProses":["list","sumhal"]}',
	  	url: 'pages.php?Pg=pemusnahanba&ajx=1&tipe=filter',
		
		type:'POST', 
		data:$('#'+this.formName).serialize(), 
		//contentType: "application/x-www-form-urlencoded;charset=ISO-8859-1",	
	  	success: function(data) {		
			try{ var resp = eval('('+ data + ')'); } catch(err2){ var resp = data; }
			
			//document.getElementById('_cont_daftar').innerHTML = resp.content.list;
			document.getElementById('_cont_opsi').innerHTML = resp.content;
			//alert( resp.content )	;
			//document.getElementById(me.prefix+'_cont_daftar').innerHTML = resp.content;
			//if(me.withPilih) me.cbTampil();	
			//me.daftarRenderAfter(resp);	
			//me.sumHalRender();
			//get_hall();
	  	},
		error: ajaxError
	});
	
}


