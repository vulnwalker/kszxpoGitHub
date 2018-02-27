var RekapPenyusutanSkpd = new SkpdCls({
	prefix : 'RekapPenyusutanSkpd', formName:'adminForm'
});


var RekapPenyusutan = new DaftarObj2({
	prefix : 'RekapPenyusutan',
	//url : 'pages.php?Pg=Rekap2Ajx', 
	url : 'pages.php?Pg=RekapPenyusutan', 
	formName : 'adminForm',// 'ruang_form',
	
	nodeList : null,
	iterator: 0,
	ajx:null,
	jmlgagal : 0,
	jmlkol: 18,
	
	loading : function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		//this.daftarRender();
		//this.sumHalRender();
	},
	
	refreshList: function(resetPageNo){
		if (resetPageNo && document.getElementById(this.prefix+'_hal') ) document.getElementById(this.prefix+'_hal').value=1;
		this.daftarRender();
		this.filterRender();		
	},
	
	exportXls2 : function(){
		//getting data from our table
	    //var data_type = 'data:application/vnd.ms-excel';
	    //var table_div = document.getElementById(this.cekBiPrefix+'_wrap');
	    //var table_html = table_div.outerHTML.replace(/ /g, '%20');
		
		//var table_html = tableToExcel(this.cekBiPrefix+'_wrap','cek_barang');
		var tmp = document.getElementById('div_cek').innerHTML;
		document.getElementById('div_cek').innerHTML = ''; 
		var str = document.getElementById( this.prefix+'_cont_daftar').innerHTML;
		//var re = new RegExp('"', 'g');
		str = replaceAll(str, '"', '');
		str = replaceAll(str, 'class=koptable', 'class=cetak');
		str = replaceAll(str, '<a ', '<span ');
		str = replaceAll(str, 'GarisDaftar', 'GarisCetak');
		str = str.replace(/[\n\r]/g, '');
		
		document.getElementById('divcetak').innerHTML =document.getElementById('divCetakHeader').innerHTML + str+ document.getElementById('divCetakFooter').innerHTML;
		//alert(document.getElementById('divcetak').innerHTML);
		var a = document.createElement('a');
	    a.href = tableToExcel('divcetak','rekappenyusutan');
	    a.download = 'rekappenyusutan.xls';
		document.body.appendChild(a);
	    a.click();
		document.getElementById('div_cek').innerHTML = tmp; 
		
	},
	
	exportXls : function(){
		var aForm = document.getElementById(this.formName);	
		
		var tmp = document.getElementById('div_cek').innerHTML;
		document.getElementById('div_cek').innerHTML = ''; 
		var str = document.getElementById(this.prefix + '_cont_daftar').innerHTML;
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
	exportXls : function(){
		var aForm = document.getElementById(this.formName);	
		
		var tmp = document.getElementById('div_cek').innerHTML;
		document.getElementById('div_cek').innerHTML = ''; 
		var str = document.getElementById('RekapPenyusutan_cont_daftar').innerHTML;
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
		var str = document.getElementById('RekapPenyusutan_cont_daftar').innerHTML;
		//var re = new RegExp('"', 'g');
		str = replaceAll(str, '"', '');
		str = replaceAll(str, 'class=koptable', 'class=cetak');
		str = replaceAll(str, '<a ', '<span ');
		str = replaceAll(str, 'GarisDaftar', 'GarisCetak');
		str = str.replace(/[\n\r]/g, '');
		
		document.getElementById('daftarcetak').value = str;
		
		//str = str.replace( '"', '' );
		 document.getElementById('daftarcetak').value = str;
		aForm.action=this.url+'&tipe=cetak_all';
		aForm.target='_blank';
		aForm.submit();	
		aForm.target='';
	},	
	
	/*cetakAll: function(){
		var aForm = document.getElementById(this.formName);	
		var str = document.getElementById( this.prefix+'_cont_daftar').innerHTML;
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
	},*/
	
	reqTotalbyIter:function(iterator_){
		var me=this;
		//me.iterator++;
		if(me.iterator < me.nodeList.length ){						
			var node = me.nodeList[me.iterator];
			var href_ ='';
			if (node.innerHTML==''){
				var node = me.nodeList[me.iterator];				
				var href_ = node.getAttribute('href');
				var idel = node.getAttribute('id');					
			}
			me.reqTotal(href_,idel,me.iterator);
			//alert(me.nodeList.length);	
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
		var href__ = href_.replace("JurnalPenyusutan", "RekapPenyusutan");		
		//alert(iterator_);
		if(href_!=''){
			document.getElementById(idel_).innerHTML = "<img src='images/wait.gif' height='10px' >";
			this.ajx = $.ajax({
			  	url: href__+'&tipe=rekapNeraca&idel='+idel_+'&iter='+iterator_,
			 	type:'POST', 
				data:$('#'+this.formName).serialize(), 
			  	success: function(data) {		
					var resp = eval('(' + data + ')');				
					document.getElementById(resp.content.idel).innerHTML = resp.content.vtotal;
					var idel = resp.content.idel;
					var arrid = idel.split('_');
					//alert($('#row_'+arrid[0]+'_'+arrid[1]).attr("class")+" and "+resp.content.totalkosong);
					//if((resp.content.totalkosong=="kosong") && ($('#row_'+arrid[0]+'_'+arrid[1]).attr("class")=="rw0")){
					if($('#row_'+arrid[0]+'_'+arrid[1]).attr("class") != "row1" && resp.content.totalkosong=="kosong"){
						//delete tr yang kosong
						$('#row_'+arrid[0]+'_'+arrid[1]).remove();
						var jmlRow = (parseInt($('.koptable tr').length)-6); //ambil jumlah row yang tamppil di class koptable
						//lakukan perulangan untuk merubah idel dan no urut, dimulai dari no urut yang dihapus
						for(i = arrid[1]; i <= jmlRow; i++){
							document.getElementById("row_"+arrid[0]+'_'+(parseInt(i)+1)).setAttribute("id","row_"+arrid[0]+'_'+i);							
							//proses mengganti idel yang gejlok agar kembali berurutan							
							if(document.getElementById('fmTplDetail').checked){
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+1)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+1).setAttribute("id",arrid[0]+'_'+i+'_'+1); //+"<input type='hidden' value='"+resp.content.vSaldoAkBrg+"'>"; //saldo akhit					
								//if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+1)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+1).setAttribute('title', resp.content.vSaldoAk );
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+2)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+2).setAttribute("id",arrid[0]+'_'+i+'_'+2); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+3)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+3).setAttribute("id",arrid[0]+'_'+i+'_'+3); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+4)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+4).setAttribute("id",arrid[0]+'_'+i+'_'+4); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+5)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+5).setAttribute("id",arrid[0]+'_'+i+'_'+5); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+6)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+6).setAttribute("id",arrid[0]+'_'+i+'_'+6); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+7)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+7).setAttribute("id",arrid[0]+'_'+i+'_'+7); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+8)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+8).setAttribute("id",arrid[0]+'_'+i+'_'+8); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+9)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+9).setAttribute("id",arrid[0]+'_'+i+'_'+9); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+10)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+10).setAttribute("id",arrid[0]+'_'+i+'_'+10); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+11)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+11).setAttribute("id",arrid[0]+'_'+i+'_'+11); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+12)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+12).setAttribute("id",arrid[0]+'_'+i+'_'+12); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+13)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+13).setAttribute("id",arrid[0]+'_'+i+'_'+13); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+14)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+14).setAttribute("id",arrid[0]+'_'+i+'_'+14); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+15)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+15).setAttribute("id",arrid[0]+'_'+i+'_'+15); 											if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+18)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+18).setAttribute("id",arrid[0]+'_'+i+'_'+18); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+19)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+19).setAttribute("id",arrid[0]+'_'+i+'_'+19); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+20)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+20).setAttribute("id",arrid[0]+'_'+i+'_'+20); 
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+21)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+21).setAttribute("id",arrid[0]+'_'+i+'_'+21); 			
							}else{
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+1)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+1).setAttribute("id",arrid[0]+'_'+i+'_'+1); //+"<input type='hidden' value='"+resp.content.vSaldoAkBrg+"'>"; //saldo akhit
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+16)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+16).setAttribute("id",arrid[0]+'_'+i+'_'+16); //+"<input type='hidden' value='"+resp.content.vSaldoAkBrg+"'>"; //saldo akhit					
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+17)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+17).setAttribute("id",arrid[0]+'_'+i+'_'+17); 									
								if(document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+15)) document.getElementById(arrid[0]+'_'+(parseInt(i)+1)+'_'+15).setAttribute("id",arrid[0]+'_'+i+'_'+15); 
							}
						
						//proses mengganti no urut yang gejlok agar kembali berurutan							
						if(document.getElementById("row_"+arrid[0]+'_'+i)) document.getElementById("row_"+arrid[0]+'_'+i).cells[0].innerHTML=(parseInt(document.getElementById("row_"+arrid[0]+'_'+(i-1)).cells[0].innerHTML)+1)+'.';
						}						

					}else{
						if(document.getElementById('fmTplDetail').checked){
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+1)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+1).innerHTML = resp.content.vtotal1;//+"<input type='hidden' value='"+resp.content.vSaldoAkBrg+"'>"; //saldo akhit					
							//if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+1)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+1).setAttribute('title', resp.content.vSaldoAk );
							
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+2)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+2).innerHTML = resp.content.vtotal2;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+3)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+3).innerHTML = resp.content.vtotal3;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+4)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+4).innerHTML = resp.content.vtotal4;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+5)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+5).innerHTML = resp.content.vtotal5;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+6)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+6).innerHTML = resp.content.vtotal6;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+7)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+7).innerHTML = resp.content.vtotal7;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+8)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+8).innerHTML = resp.content.vtotal8;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+9)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+9).innerHTML = resp.content.vtotal9;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+10)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+10).innerHTML = resp.content.vtotal10;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+11)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+11).innerHTML = resp.content.vtotal11;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+12)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+12).innerHTML = resp.content.vtotal12;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+13)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+13).innerHTML = resp.content.vtotal13;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+14)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+14).innerHTML = resp.content.vtotal14;
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+15)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+15).innerHTML = resp.content.vtotal15;																	if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+18)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+18).innerHTML = resp.content.vtotal18;	
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+19)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+19).innerHTML = resp.content.vtotal19;	
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+20)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+20).innerHTML = resp.content.vtotal20;	
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+21)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+21).innerHTML = resp.content.vtotal21;																}else{
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+1)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+1).innerHTML = resp.content.vtotal1;//+"<input type='hidden' value='"+resp.content.vSaldoAkBrg+"'>"; //saldo akhit
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+16)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+16).innerHTML = resp.content.vtotal16;//+"<input type='hidden' value='"+resp.content.vSaldoAkBrg+"'>"; //saldo akhit					
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+17)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+17).innerHTML = resp.content.vtotal17;											
							if(document.getElementById(arrid[0]+'_'+arrid[1]+'_'+15)) document.getElementById(arrid[0]+'_'+arrid[1]+'_'+15).innerHTML = resp.content.vtotal15;
						}
						me.iterator+=me.jmlkol;
						
						
											
					}									
						
						me.reqTotalbyIter(me.iterator);	
					
			  	},
				error: function(request, type, errorThrown){
					if(type != 'abort'){
						me.jmlgagal ++;	
						me.iterator+=me.jmlkol;
						document.getElementById(idel_).innerHTML = '';
						me.reqTotalbyIter(me.iterator);
					}
					
				}
				
			});	
		}else{
			me.iterator+=me.jmlkol;
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
		//set jml kolom jika tampil detail dipilih
		if(document.getElementById('fmTplDetail').checked){
			this.jmlkol = 18;
		}else{
			this.jmlkol = 4;	
		}		
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
	}
	
	
});
