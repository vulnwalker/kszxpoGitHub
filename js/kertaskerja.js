var KertasKerjaSkpd = new SkpdCls({
	prefix : 'KertasKerjaSkpd', formName:'adminForm',
	style:'',
});


var KertasKerja = new DaftarObj2({
	prefix : 'KertasKerja',
	//url : 'pages.php?Pg=Rekap2Ajx', 
	//url : 'pages.php?Pg=Rekap2', 
	url : 'pages.php?Pg=KertasKerja', 
	formName : 'adminForm',// 'ruang_form',
	
	nodeList : null,
	iterator: 0,
	ajx:null,
	jmlgagal : 0,
	el_c1 :'',
	el_c : '',
	el_d : '',
	el_e : '',
	el_e1 : '',
	postCover : 'KertasKerja_postCover',
	//refreshMode : 1,
	awal : 1,
	
	loading : function(){
		//alert('loading');
		//this.topBarRender();
		//this.filterRender();
		var me=this;
		//render filter
		$.ajax({
		  url: this.url+'&tipe=filter',
		  type:'POST', 
		  data:$('#'+this.formName).serialize(),
		  success: function(data) {		
			var resp = eval('(' + data + ')');
			document.getElementById(me.prefix+'_cont_opsi').innerHTML = resp.content;
			me.topBarRender();
			me.filterRenderAfter();
		  },
		  error: ajaxError
		});
	},
	
	refreshList: function(resetPageNo, versi){
		if(versi == 'KOTA_BANDUNG'){
			if(document.getElementById('fmFiltThnBuku').value < '2015'){
				alert("Tidak ada data !");
			}else{
				if (resetPageNo && document.getElementById(this.prefix+'_hal') ) document.getElementById(this.prefix+'_hal').value=1;
				//this.daftarRender();
				this.filterRender();
			}
		}else{
			if (resetPageNo && document.getElementById(this.prefix+'_hal') ) document.getElementById(this.prefix+'_hal').value=1;
			//this.daftarRender();
			this.filterRender();
		}
		
		
	},
	filterRenderAfter : function () {
		Cekbi.cekInitial('cek1','cont_cekbi', this.prefix+'SkpdfmURUSAN', this.prefix+'SkpdfmSKPD',this.prefix+'SkpdfmUNIT', this.prefix+'SkpdfmSUBUNIT', this.prefix+'SkpdfmSEKSI');
		if(this.awal==1){
			//if(this.active==false){
				
				this.awal=0;
			//}
		}else{
			this.daftarRender();
		}
		
	},
	
	exportXls2 : function(){
		//getting data from our table
	    //var data_type = 'data:application/vnd.ms-excel';
	    //var table_div = document.getElementById(this.cekBiPrefix+'_wrap');
	    //var table_html = table_div.outerHTML.replace(/ /g, '%20');
		
		//var table_html = tableToExcel(this.cekBiPrefix+'_wrap','cek_barang');
		var div_cek = document.getElementById('div_cek').innerHTML;
		document.getElementById('div_cek').innerHTML = '';
		
		var str = document.getElementById( this.prefix+'_cont_daftar').innerHTML;
		//var re = new RegExp('"', 'g');
		str = replaceAll(str, '"', '');
		str = replaceAll(str, 'class=koptable', 'class=cetak');
		str = replaceAll(str, '<a ', '<span ');
		str = replaceAll(str, 'GarisDaftar', 'GarisCetak');
		str = str.replace(/[\n\r]/g, '');
		
		document.getElementById('divcetak').innerHTML =document.getElementById('divCetakHeader').innerHTML + str+ document.getElementById('divCetakFooter').innerHTML;
		
	    var a = document.createElement('a');
	    a.href = tableToExcel('divcetak','kertaskerja');
	    a.download = 'kertaskerja.xls';
		document.body.appendChild(a);
	    a.click();
		
		document.getElementById('div_cek').innerHTML = div_cek;
		document.getElementById('divcetak').innerHTML='';
		
	},
	
	exportXls : function(){
		var aForm = document.getElementById(this.formName);	
		
		var tmp = document.getElementById('div_cek').innerHTML;
		document.getElementById('div_cek').innerHTML = ''; 
		var str = document.getElementById( this.prefix+ '_cont_daftar').innerHTML;
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
		
	},
	
	cetakAll: function(){
		var aForm = document.getElementById(this.formName);
		
		var tmp = document.getElementById('div_cek').innerHTML;
		document.getElementById('div_cek').innerHTML = ''; 			
		var str = document.getElementById(this.prefix+ '_cont_daftar').innerHTML;
		//var re = new RegExp('"', 'g');
		str = replaceAll(str, '"', '');
		str = replaceAll(str, 'class=koptable', 'class=cetak');
		str = replaceAll(str, '<a ', '<span ');
		str = replaceAll(str, 'GarisDaftar', 'GarisCetak');
		
		//str = str.replace( '"', '' );
		 document.getElementById('daftarcetak').value = str;
		aForm.action=this.url+'&tipe=cetak_all';
		aForm.target='_blank';
		aForm.submit();	
		aForm.target='';
		document.getElementById('div_cek').innerHTML = tmp;
	},
	
	reqTotalbyIter:function(iterator_){
		var me=this;
		//me.iterator++;
		if(me.iterator < me.nodeList.length ){						
			var node = me.nodeList[me.iterator];
			var href ='';
			if (node.innerHTML==''){
				var node = me.nodeList[me.iterator];				
				var href = node.getAttribute('href');
				var idel = node.getAttribute('id');					
			}
			me.reqTotal(href,idel,me.iterator);	
		}else{ //selesai
			var btTampil = document.getElementById('btTampil');
			if(btTampil) btTampil.disabled=false; 
			
			if(me.jmlgagal==0){
				alert('Rekap selesai');
			}else{
				var jmlgagal= me.jmlgagal;
				me.jmlgagal=0;
				if(confirm('Ada '+jmlgagal+' data gagal dihitung! Coba lagi? ')){
					me.iterator=0; 
					me.reqTotalbyIter(me.iterator);					
				}
				
			}
		}
	},
	
	reqTotal : function(href_, idel_,iterator_){
		var me = this;		
		if(href_!=''){
			var href_ = href_.replace("Jurnal","KertasKerja");
			document.getElementById(idel_).innerHTML = "<img src='images/wait.gif' height='10px' >";
			this.ajx = $.ajax({
			  	url: href_+'&tipe=rekapNeraca&idel='+idel_+'&iter='+iterator_,
			 	type:'POST', 
				data:$('#'+this.formName).serialize(), 
			  	success: function(data) {		
					//var resp = eval('(' + data + ')');				
					var resp = JSON.parse(data);
					document.getElementById(resp.content.idel).innerHTML = resp.content.vtotal;
					var idel = resp.content.idel;
					var arrid = idel.split('_');
					
					/*for(i=0;i<21<i++){
						document.getElementById(arrid[0]+'_'+arrid[1]+'_'+i).innerHTML = 
							resp.content.vtotalN[arrid[1]-1][i];	
					}*/
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+1).innerHTML = resp.content.vtotal2 ;//+"<input type='hidden' value='"+resp.content.vtotal1+"'>";  //saldo aw	
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+1).setAttribute('title',resp.content.total1 );
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+2).innerHTML = resp.content.vtotal3 ; //susut awa
					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+3).innerHTML = resp.content.vtotalN[0][0];//+"<input type='hidden' value='"+resp.content.vtotalN[0][2]+			"'>"; //bm					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+3).setAttribute('title',resp.content.totalN[0][2] );
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+4).innerHTML = resp.content.vtotalN[1][0]; //atribusi
					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+5).innerHTML = resp.content.vtotalN[2][0];//+"<input type='hidden' value='"+resp.content.vtotalN[2][2]+"'>"; //kapitalisasi
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+5).setAttribute('title',resp.content.totalN[2][2] );
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+6).innerHTML = resp.content.vtotalN[2][1];//+"<input type='hidden' value='"+resp.content.vtotalN[2][3]+"'>"; 
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+6).setAttribute('title',resp.content.totalN[2][3] );
					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+7).innerHTML = resp.content.vtotalN[3][0];//+"<input type='hidden' value='"+resp.content.vtotalN[3][2]+"'>"; //hibah
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+7).setAttribute('title',resp.content.totalN[3][2] );
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+8).innerHTML = resp.content.vtotalN[3][1];//+"<input type='hidden' value='"+resp.content.vtotalN[3][3]+"'>";
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+8).setAttribute('title',resp.content.totalN[3][3] );
					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+9).innerHTML = resp.content.vtotalN[4][0];//+"<input type='hidden' value='"+resp.content.vtotalN[4][2]+"'>"; //pindah skpd
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+9).setAttribute('title',resp.content.totalN[4][2] );
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+10).innerHTML = resp.content.vtotalN[4][1];//+"<input type='hidden' value='"+resp.content.vtotalN[4][3]+"'>";
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+10).setAttribute('title',resp.content.totalN[4][3] );
					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+11).innerHTML = resp.content.vtotalN[5][0];//+"<input type='hidden' value='"+resp.content.vtotalN[5][2]+"'>"; //penilaian
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+11).setAttribute('title',resp.content.totalN[5][2] );
					//document.getElementById(arrid[0]+'_'+arrid[1]+'_'+12).innerHTML = resp.content.vtotalN[5][1];
						
					//document.getElementById(arrid[0]+'_'+arrid[1]+'_'+13).innerHTML = resp.content.vtotalN[6][0]; //penghapsuan
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+12).innerHTML = resp.content.vtotalN[6][1];//+"<input type='hidden' value='"+resp.content.vtotalN[6][3]+"'>";
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+12).setAttribute('title',resp.content.totalN[6][3] );
					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+13).innerHTML = resp.content.vtotalN[7][0];//+"<input type='hidden' value='"+resp.content.vtotalN[7][2]+"'>"; //koreksi
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+13).setAttribute('title',resp.content.totalN[7][2] );
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+14).innerHTML = resp.content.vtotalN[7][1];//+"<input type='hidden' value='"+resp.content.vtotalN[7][3]+"'>";
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+14).setAttribute('title',resp.content.totalN[7][3] );
					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+15).innerHTML = resp.content.vtotalN[8][0];//+"<input type='hidden' value='"+resp.content.vtotalN[8][2]+"'>"; //reklas
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+15).setAttribute('title',resp.content.totalN[8][2] );
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+16).innerHTML = resp.content.vtotalN[8][1];//+"<input type='hidden' value='"+resp.content.vtotalN[8][3]+"'>";
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+16).setAttribute('title',resp.content.totalN[8][3] );
					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+17).innerHTML = resp.content.vtotalN[9][0];//+"<input type='hidden' value='"+resp.content.vtotalN[9][2]+"'>"; //penyusutan
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+17).setAttribute('title',resp.content.totalN[9][2] );
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+18).innerHTML = resp.content.vtotalN[9][1];//+"<input type='hidden' value='"+resp.content.vtotalN[9][3]+"'>";
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+18).setAttribute('title',resp.content.totalN[9][3] );
					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+19).innerHTML = resp.content.vSaldoAk;//+"<input type='hidden' value='"+resp.content.vSaldoAkBrg+"'>"; //saldo akhit					
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+19).setAttribute('title', resp.content.saldoAkBrg );
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+20).innerHTML = resp.content.vSusutAk; //susut ak
					document.getElementById(arrid[0]+'_'+arrid[1]+'_'+21).innerHTML = resp.content.vNilaibukuAk; //nilai buku ak
					
					
					me.iterator+=21;
					me.reqTotalbyIter(me.iterator);
					
			  	},
				error: function(request, type, errorThrown){
					if(type != 'abort'){
						me.jmlgagal ++;	
						me.iterator+=21;
						document.getElementById(idel_).innerHTML = '';
						me.reqTotalbyIter(me.iterator);
					}
					
				}
				
			});	
		}else{
			me.iterator+=21;
			me.reqTotalbyIter(me.iterator);
			
		}
	},
	
	daftarRenderAfter : function(){
		var me= this;
		
		//alert('tes');
		var btTampil = document.getElementById('btTampil');
		if(btTampil) btTampil.disabled=true; 
				
		if(this.ajx) this.ajx.abort();
		this.nodeList= document.getElementsByName('vrekap');
		this.jmlgagal = 0;
		this.iterator=0;
		me.reqTotalbyIter(me.iterator);
		
	},
	
	
	daftarRender : function(){
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
				if(me.withPilih) me.cbTampil();				
				//me.sumHalRender();
				me.daftarRenderAfter();
		  	}
		});
	},
	
	s4: function() {
	  return Math.floor((1 + Math.random()) * 0x10000)
	    .toString(16)
	    .substring(1);
	},
	formPost: function(){
		this.el_c1 = 'KertasKerjaSkpdfmURUSAN';
		this.el_c = 'KertasKerjaSkpdfmSKPD';
		this.el_d = 'KertasKerjaSkpdfmUNIT';
		this.el_e = 'KertasKerjaSkpdfmSUBUNIT';
		this.el_e1 = 'KertasKerjaSkpdfmSEKSI';
		this.postCover = 'KertasKerja_PostCover';
		this.setFormPost();
	} ,
	setFormPost: function(){
		var me = this;
		//var form_judul = 'Posting ...';
		var form_judul = 'Cek Data ...';
		var form_width = '500';
		var form_height = '120';
		var cover = this.postCover ;//'kertasKerja_PostCover';
		//var jmldata = 10;
		//document.body.style.overflow='hidden';
		addCoverPage2(cover,999,true,false);
		
		var c1 = document.getElementById(this.el_c1).value;
		var c = document.getElementById(this.el_c).value;
		var d = document.getElementById(this.el_d).value;
		var e = document.getElementById(this.el_e).value;
		var e1 = document.getElementById(this.el_e1).value;
		
		/**		
		var currentdate = new Date(); 
		var datetime = currentdate.getDate().toString() 
                + (currentdate.getMonth()+1).toString() 
                + currentdate.getFullYear().toString() 
                + currentdate.getHours().toString()  
                + currentdate.getMinutes().toString()  
                + currentdate.getSeconds().toString();
		
		var sessionID = datetime+'-'+this.s4()+ this.s4()+ this.s4();
		**/
		var sessionID = genSessionID();
		
		var form_menu =
			"<div style='padding: 0 8 9 8;height:22; '>"+
			"<div style='float:right;'>"+
				//"<input type='button' value='Excel' onclick='Penatausaha.cetakKertasKerjaKib(\""+tipe+"\",1)'>"+
				"<input type='button' value='Posting' onclick='"+this.prefix+".posting()'>"+
				"<input type='button' value='Batal' onclick='"+this.prefix+".formPostClose()'>"+
				//"<input type='hidden' id='Sensus_idplh' name='Sensus_idplh' value='109'><input type='hidden' id='Sensus_fmST' name='Sensus_fmST' value='1'>"+
				//"<input type='hidden' id='sesi' name='sesi' value=''>"+
			"</div>"+
			"</div>";
		
		var content = 
			"<form id='kertaskerjapost' method='post' >"+
			//"<div id='post_form_div' style='margin:9 8 8 8; overflow:auto; border:1px solid #E5E5E5;width:"+(form_width-20)+";height:"+(form_height-80)+";'>"+
			"<div id='post_form_div' style='margin:9 8 8 8; overflow:auto;height:"+(form_height-80)+";margin:auto;'>"+
				"<table style='width:100%' class='tblform'><tr><td style='padding:4'>"+
					//"<table style='width:100%:height:100%'>"+
					"<table style='height:100%'>"+
						"<tr>"+
							"<td style='' colspan='3' >"+
							"<div id=\"progressbox\" style=\"display:block;\">"+
								"<div id=\"progressbck\" style=\"display:block;width:300px;height:4px;background-color:silver; margin: 6 5 0 0;float:left;border-radius: 3px;\">"+
									"<div id=\"progressbar\" style=\"height:2px;margin:1;width:0%;border-radius: 3px;background-color: green;\"></div>"+
								"</div>"+
								"<div id=\"progressloading\" name=\"progressloading\" style=\"float:left;\"></div>"+
								"<div id=\"progressmsg\" name=\"progressmsg\" style=\"float:left;\"></div>"+
								
								"<input type=\"hidden\" id=\"jmldata\" name=\"jmldata\" value=\"0\">"+								
								"<input type=\"hidden\" id=\"prog\" name=\"prog\" value=\"0\">"+
								"<input type=\"hidden\" id=\"c1\" name=\"c1\" value=\""+c1+"\">"+
								"<input type=\"hidden\" id=\"c\" name=\"c\" value=\""+c+"\">"+
								"<input type=\"hidden\" id=\"d\" name=\"d\" value=\""+d+"\">"+
								"<input type=\"hidden\" id=\"e\" name=\"e\" value=\""+e+"\">"+
								"<input type=\"hidden\" id=\"e1\" name=\"e1\" value=\""+e1+"\">"+
								"<input type=\"hidden\" id=\"awal\" name=\"awal\" value=\"1\">"+
								"<input type=\"hidden\" id=\"sessionID\" name=\"sessionID\" value=\""+sessionID+"\">"+
							"</div>"+
							"</td>"+
						"</tr>"+
											
					"</table>"+
				"</td></tr></table>"+
			"</div>"+
			"</form>";
		
		
		document.getElementById(cover).innerHTML= 
			//"<table width='100%' height='100%'><tbody><tr><td align='center'>"+
			"<table width='' height='100%' style='margin:auto;'><tbody><tr><td align='center'>"+
			//"rtera"+
			//"<div id='div_border' style='width:"+form_width+";height:"+form_height+"; background-color:white; border-color: rgba(0, 0, 0, 0.3);   border-style: solid;  border-width:1; box-shadow: 6px 6px 5px rgba(0, 0, 0, 0.3);'>"+
			"<div id='div_border' style='padding:15;background-color:white; border-color: rgba(0, 0, 0, 0.3);   border-style: solid;  border-width:1; box-shadow: 6px 6px 5px rgba(0, 0, 0, 0.3);'>"+
			//"<table class='' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td style='padding:0'>"+
			"<table class='' width='' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td style='padding:0'>"+
				//"<div class='menuBar2' style='height:20'>"+			
				"<div class='' style='height:20'>"+			
				//"<span style='cursor:default;position:relative;left:6;top:2;color:White;font-size:12;font-weight:bold'>"+form_judul+"</span>"+
				"<span id='span_title' style='cursor:default;position:relative;left:6;top:2;font-size:14;font-weight:bold'>"+form_judul+"</span>"+
				
				"</div>"+
			"</td></tr></tbody></table>"+			
			content+
			//form_menu+		
			"</div>"+
				
			"</td></tr>"+
			"</table>";
		
		
		$.ajax({
		  	url: this.url+'&tipe=getJmlDataPost',
		 	type:'POST', 
			data:$('#kertaskerjapost').serialize(), 
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if(resp.err == ''){
					/**document.getElementById('progressbox').style.display='block';
					var  jmldata = parseInt(document.getElementById('jmldata').value);
					var  prog = parseInt(document.getElementById('prog').value);
					prog = prog + resp.content.jml;
					if(prog>jmldata) prog = jmldata;
					document.getElementById('prog').value = prog;
					var persen = ((prog/jmldata)*100);
					document.getElementById('progressbar').style.width = persen +'%';			
					//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
					document.getElementById('progressmsg').innerHTML = formatNumber(prog,0,',','.')+'/'+formatNumber(jmldata,0,',','.');
					**/		
					document.getElementById('progressbox').style.display='block';
					var jmldata = resp.content.jmldata;
					var prog = 0;
					document.getElementById('jmldata').value = jmldata;
					document.getElementById('progressmsg').innerHTML = formatNumber(prog,0,',','.')+'/'+formatNumber(jmldata,0,',','.');
					//me.getJmlDataPostAfter(resp);
					if(resp.content.jmldata>0) {
						document.getElementById('span_title').innerHTML = 'Posting ...';
					}
					setTimeout(function(){me.getJmlDataPostAfter(resp);}, 1);
				}else{
					alert(resp.err);
					me.formPostClose();
				}
				
				
		  	},
			error: function(request, type, errorThrown){
				if(type != 'abort'){					
					alert('Gagal, silahkan coba lagi!');					
					me.formPostClose();
				}				
			}
		});
			
	},
	getJmlDataPostAfter : function(resp){
		var me = this;
		//**
		if(resp.content.jmldata>0) {
			me.posting();			
		}else{
			document.getElementById('progressbar').style.width = '100%';	
			setTimeout(function(){me.postingFinal();}, 2);
		}	
		//**/
	},
	posting : function(){
		var me = this;
		$.ajax({
		  	url: this.url+'&tipe=posting',
		 	type:'POST', 
			data:$('#kertaskerjapost').serialize(), 
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				if(resp.err == ''){
					document.getElementById('progressbox').style.display='block';
					var  jmldata = parseInt(document.getElementById('jmldata').value);
					var  prog = parseInt(document.getElementById('prog').value);
					prog = prog + parseInt(resp.content.jml);
					if(prog>jmldata) prog = jmldata;
					document.getElementById('prog').value = prog;
					var persen = ((prog/jmldata)*100);
					document.getElementById('progressbar').style.width = persen +'%';			
					//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
					document.getElementById('progressmsg').innerHTML = formatNumber(prog,0,',','.')+'/'+formatNumber(jmldata,0,',','.');
					document.getElementById('awal').value=1;
					if(persen < 100){
						setTimeout(function(){me.posting();}, 1500); //me.posting();
					}else{
						setTimeout(function(){me.postingFinal();}, 100);
					}
				}else{
					alert('Gagal, user lain sedang posting, coba lagi');
					//var cover = me.postCover; // 'kertasKerja_PostCover';
					me.formPostClose();
				}
		  	},
			error: function(request, type, errorThrown){
				if(type != 'abort'){
					/**
					me.jmlgagal ++;	
					me.iterator+=21;
					document.getElementById(idel_).innerHTML = '';
					me.reqTotalbyIter(me.iterator);
					**/
					alert('Gagal, silahkan coba lagi!');					
					me.formPostClose();
				}				
			}
			
		});
	},
	postingFinal : function(){
		var me = this;
		$.ajax({
		  	url: this.url+'&tipe=postingFinal',
		 	type:'POST', 
			data:$('#kertaskerjapost').serialize(), 
		  	success: function(data) {	
				var resp = eval('(' + data + ')');
				if(resp.err == ''){
					me.formPostClose();
					//me.refreshList(true,'');
					me.daftarRender();
				}else{
					alert(resp.err );
				}
			}
		});
		
		
		
	},
	formPostClose : function(){
		var cover = this.postCover;//'kertasKerja_PostCover';
		if(document.getElementById(cover)) delElem(cover);
	},
	
	
	
});
