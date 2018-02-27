var CekbiSkpd = new SkpdCls({
	prefix : 'CekbiSkpd', formName:'adminForm'
});



var Cekbi = new DaftarObj2({
	prefix : 'Cekbi',
	url : 'pages.php?Pg=Cekbi', 
	formName : 'adminForm',// 'ruang_form',
	cekElement : 'cont_cekbi',
	nourut : 0,
	jmlError: 0,
	active : false,
	
	
	getInfo : function(){
		var me = this;
		
		if(document.getElementById(me.urusanEl)) c1 = document.getElementById(me.urusanEl).value;
		if(document.getElementById(me.bidangEl)) c = document.getElementById(me.bidangEl).value;
		if(document.getElementById(me.skpdEl)) d = document.getElementById(me.skpdEl).value;
		if(document.getElementById(me.unitEl)) e = document.getElementById(me.unitEl).value;
		if(document.getElementById(me.subunitEl)) e1 = document.getElementById(me.subunitEl).value;
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=getInfo&prefix='+this.cekBiPrefix+'&params='+c1+'.'+c+'.'+d+'.'+e+'.'+e1,
		  	success: function(data) {		
				try{ var resp = eval('('+ data + ')'); } catch(err2){ var resp = data; }
				if (resp.err ==''){
					if ( document.getElementById(me.cekBiPrefix+'_info') ){
						document.getElementById(me.cekBiPrefix+'_info').innerHTML = resp.content;
					}
				}else{
					alert(resp.err);
					///delElem(cover);
					//document.body.style.overflow='auto';
				}			
				
		  	},
			error: ajaxError
		});
	},
	/***
	cekExportXls : function(){//chrome suport, modzilla ga
		//getting data from our table
	    var data_type = 'data:application/vnd.ms-excel';
	    var table_div = document.getElementById(this.cekBiPrefix+'_wrap');
	    var table_html = table_div.outerHTML.replace(/ /g, '%20');
	
	    var a = document.createElement('a');
	    a.href = data_type + ', ' + table_html;
	    a.download = 'cek_barang.xls';
	    a.click();
		
	},
	**/
	cekExportXls : function(){
		//getting data from our table
	    //var data_type = 'data:application/vnd.ms-excel';
	    //var table_div = document.getElementById(this.cekBiPrefix+'_wrap');
	    //var table_html = table_div.outerHTML.replace(/ /g, '%20');
		
		//var table_html = tableToExcel(this.cekBiPrefix+'_wrap','cek_barang');
		
	    var a = document.createElement('a');
	    a.href = tableToExcel(this.cekBiPrefix+'_wrap','cek_barang');
	    a.download = 'cek_barang.xls';
		document.body.appendChild(a);
	    a.click();
		
	},
	
	cekShowDaftar: function(){
		var heightmin = 64;
		var icon_up='images/tumbs/up_2.png';
		var icon_down = 'images/tumbs/down_2.png';
		var div_id = this.cekBiPrefix+'_wrap2';
		var div_slide = this.cekBiPrefix+'_colapse_img';
		
		var div= document.getElementById(div_id);
		var img = document.getElementById(div_slide);
		var img_src=img.getAttribute('src');
		//if( img_src =='images/tumbs/down.png' ){
		if( img_src == icon_down ){
			img.setAttribute('src', icon_up);
			div.style.display='block';
			this.cekDaftarShow=true;
		}else{
			img.setAttribute('src', icon_down);
			div.style.display='none';
			this.cekDaftarShow=false;
		}
	},
	cekInitial : function( prefix,cekElement, urusanEl, bidangEl, skpdEl, unitEl, subunitEl ){
		this.cekElement = cekElement;
		this.urusanEl = urusanEl;
		this.bidangEl = bidangEl;
		this.skpdEl = skpdEl;
		this.unitEl = unitEl;
		this.subunitEl = subunitEl;
		this.cekBiPrefix = prefix;
		if(document.getElementById(this.cekElement)){//jika element ada
			
		
			if(this.active==false ){
			
				this.cekDaftarShow=false;
				//document.getElementById(this.cekElement).style.float='left';
				document.getElementById(this.cekElement).innerHTML =
					//'<div style=\'text-align:left\'>'+
					'<div class="cekbi_container" >'+
					'<table style=\'width:100%\'>'+
						//'<tr><td>'+
							
						//'</td></tr>'+
						'<tr><td>'+
							'<div id=\"'+this.cekBiPrefix+'_progressbox\" style=\"display:none;\">'+
								'<div id=\"'+this.cekBiPrefix+'_progressbck\" class="cekbi_progress_bckgrnd" >'+
									'<div id=\"'+this.cekBiPrefix+'_progressbar\" class="cekbi_progress_bar">'+
								'</div>'+
							'</div>'+
							'<span id=\"'+this.cekBiPrefix+'_progressmsg\" name=\"'+this.cekBiPrefix+'_progressmsg\" class="cekbi_progress_msg"></span>'+
							'</div>'+
							'<span id=\"'+this.cekBiPrefix+'_info\" name=\"'+this.cekBiPrefix+'_info\" ></span>'+
							'&nbsp;&nbsp;<input type=button id=\"'+this.cekBiPrefix+'_btcek\" value=\"Cek\" onclick=\"'+this.prefix+'.cekOnClick(\''+this.cekBiPrefix+'\')\" title=\"Pengecekan Barang\">'+
							
							'&nbsp;<img id=\"'+this.cekBiPrefix+'_colapse_img\" src=\"images/tumbs/down_2.png\" onclick=\"'+this.prefix+'.cekShowDaftar()\" style=\"cursor:pointer;float:right;\" title=\"Show/Hide Daftar Pengecekan Barang\">'+
						'</td></tr>'+
						'<tr><td>'+
							'<div id="'+this.cekBiPrefix+'_wrap2" style="display:none;">'+
								'<div class="cekbi_table_title">'+
								'Daftar Pengecekan Barang ' +
								'&nbsp;<input type=button value=\"export\" onclick=\"'+this.prefix+'.cekExportXls()\" title=\"Export to Excel Daftar Pengecekan Barang\" style=\'float:right;\'> '+
								'</div>'+
								'<div id="'+this.cekBiPrefix+'_wrap"  style="height:200px;overflow:auto;">'+
									'<table id="cekTable" border="1" class="koptable" width=100%>'+
									'<thead><tr>'+
										'<th class="th01"  align="left">No</th><th class="th01" align="left">ID Barang</th><th class="th01" align="left">Pesan</th>'+
									'</tr></thead>'+
					  				'<tbody>'+
									//'<tr><td></td><td></td><td></td></tr>'+
									'</tbody>'+
									'</table>'+
								'</div>'+
							'</div>'+
						  	//'<textarea id=\"'+this.cekBiPrefix+'_memo\" style=\"width:600;height:100\"></textarea>'+
						  	'<input type=\"hidden\" id=\"'+this.cekBiPrefix+'_jmldata\" name=\"'+this.cekBiPrefix+'_jmldata\" value=\"0\"> '+
							'<input type=\"hidden\" id=\"'+this.cekBiPrefix+'_prog\" name=\"'+this.cekBiPrefix+'_prog\" value=\"0\"> '+
						'</td></tr>'+
						
					'</table>'+
					'</div>';
				
				document.getElementById(this.cekBiPrefix+'_wrap').addEventListener("scroll",function(){
				   var translate = "translate(0,"+(this.scrollTop-3)+"px)";
				   this.querySelector("thead").style.transform = translate;
				});
				
				this.getInfo();
				this.getDaftarCek();
				this.active = true;
				this.pause = false;
				this.proses = false;
			}
		}
	},
	
	getDaftarCek : function(){
		var me = this;
		
		if(document.getElementById(me.urusanEl)) c1 = document.getElementById(me.urusanEl).value;
		if(document.getElementById(me.bidangEl)) c = document.getElementById(me.bidangEl).value;
		if(document.getElementById(me.skpdEl)) d = document.getElementById(me.skpdEl).value;
		if(document.getElementById(me.unitEl)) e = document.getElementById(me.unitEl).value;
		if(document.getElementById(me.subunitEl)) e1 = document.getElementById(me.subunitEl).value;
		
	 	$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=getDaftarCek&prefix='+me.cekBiPrefix+'&params='+c1+'.'+c+'.'+d+'.'+e+'.'+e1,
		  	success: function(data) {		
				try{ var resp = eval('('+ data + ')'); } catch(err2){ var resp = data; }
				if (resp.err ==''){	
					var i=0;
					var nourut=1;
					//me.nourut = 0;
					if (resp.content.jmldata>0) me.cekShowDaftar();
					while(i<resp.content.jmldata){
						//var str =
						if(resp.content.hsl[i].ket !=''){
							
							if(nourut % 2 ==0){
								rowclass='row0';
							}else{
								rowclass='row1';
							}
							
							$("#cekTable tbody").append('<tr class="'+rowclass+'"><td class="GarisDaftar" >'+nourut+'</td>'+
								'<td class="GarisDaftar">'+resp.content.hsl[i].idbi+'</td>'+
								'<td class="GarisDaftar">'+ resp.content.hsl[i].ket+'</td></tr>'); 
							nourut++;
						}
						i++;
						
					}
				}else{
					alert(resp.err);
					///delElem(cover);
					//document.body.style.overflow='auto';
				}			
				
		  	},
			error: ajaxError
		});
	},
	cekOnClick:  function(prefix){
		
		if(this.proses==false){ //jika bukan dari kondisi pause / awal
			
			document.getElementById(this.cekBiPrefix+'_btcek').value = 'Pause';
			document.getElementById(this.cekBiPrefix+'_btcek').setAttribute('title', 'Pause Pengecekan Barang');
			document.getElementById(prefix+'_progressbox').style.display='block';
			document.getElementById(prefix+'_prog').value=0;
			document.getElementById(prefix+'_jmldata').value=0;
			//document.getElementById(prefix+'_memo').innerHTML='';
			document.getElementById(prefix+'_progressmsg').innerHTML='';
			document.getElementById(prefix+'_info').innerHTML='';
			$("#cekTable > tbody").html("");
			this.nourut = 1;
			this.jmlError = 0;
			this.pause = false;
			this.proses=true;
			this.cekOnClick_(prefix);
			
		}else{ //sedang berjalan
		    if(this.pause==false){ //di pause
				this.pause = true;
				//document.getElementById(this.cekBiPrefix+'_btcek').value = 'Lanjutkan';
				//document.getElementById(this.cekBiPrefix+'_btcek').setAttribute(title, 'Lanjutkan Pengecekan Barang');
			}else{
				this.pause = false;
				document.getElementById(this.cekBiPrefix+'_btcek').value = 'Pause';
				document.getElementById(this.cekBiPrefix+'_btcek').setAttribute('title', 'Pause Pengecekan Barang');
				this.cekOnClick_(prefix);
			}
			
			
		}
		
		
	},
	/***cekPause: function(prefix){
		this.pause = true;
		document.getElementById(this.cekBiPrefix+'_btcek').value = 'Cek';
			document.getElementById(this.cekBiPrefix+'_btcek').setAtribute(title, 'Pengecekan Barang');
			//document.getElementById(this.cekBiPrefix+'_btcek').onclick = 
	},***/
	cekOnClick_ : function(prefix){
		var me = this;
		//alert(prefix);
		
		if(document.getElementById(me.urusanEl)) c1 = document.getElementById(me.urusanEl).value;
		if(document.getElementById(me.bidangEl)) c = document.getElementById(me.bidangEl).value;
		if(document.getElementById(me.skpdEl)) d = document.getElementById(me.skpdEl).value;
		if(document.getElementById(me.unitEl)) e = document.getElementById(me.unitEl).value;
		if(document.getElementById(me.subunitEl)) e1 = document.getElementById(me.subunitEl).value;
		
		if(document.getElementById(prefix+'_prog').value) {
			awal=parseInt(document.getElementById(prefix+'_prog').value);
		}else{
			awal=0;
		}
		params = c1+'.'+c+'.'+d+'.'+e+'.'+e1;
		
		$.ajax({
			type:'POST', 
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=cekbi&prefix='+prefix+'&awal='+awal+'&params='+params,
		  	success: function(data) {		
				try{ var resp = eval('('+ data + ')'); } catch(err2){ var resp = data; }
				if (resp.err ==''){
					//document.getElementById(cover).innerHTML = resp.content;			
					//me.AfterFormBaru(resp);	
					//alert(resp.content.hsl[1].id);
					//alert(prefix)
					var  jmldata = resp.content.jmldata;//parseInt(document.getElementById('jmldata').value);
					var  prog = parseInt(document.getElementById(prefix+'_prog').value);
					prog = prog + resp.content.step;
					if(prog>jmldata) prog = jmldata;
					document.getElementById(prefix+'_prog').value = prog;
					var persen = ((prog/jmldata)*100);
					document.getElementById(prefix+'_progressbar').style.width = persen +'%';			
					//document.getElementById('progressmsg').innerHTML = prog+'/'+jmldata;			
					
					
					// document.getElementById(prefix+'_memo').innerHTML='';
					var i=0;
					//while(i<resp.content.step  ){
					while(i<resp.content.hsl.length  ){
						//var str =
						
						if(resp.content.hsl[i].cek !=''){
							
							me.jmlError++;
							//document.getElementById(prefix+'_memo').innerHTML += resp.content.hsl[i].id+ ': '+ resp.content.hsl[i].cek+'\n';
							/***
							$('#cekTable tr:last').after('<tr><td class="GarisDaftar" >'+me.nourut+'</td>'+
								'<td class="GarisDaftar">'+resp.content.hsl[i].id+'</td>'+
								'<td class="GarisDaftar">'+ resp.content.hsl[i].cek+'</td></tr>');
							**/	
							if(me.nourut % 2 ==0){
								rowclass='row0';
							}else{
								rowclass='row1';
							}
							$("#cekTable tbody").append(
								'<tr class="'+rowclass+'"><td class="GarisDaftar" >'+me.nourut+'</td>'+
								'<td class="GarisDaftar">'+resp.content.hsl[i].idbi+'</td>'+
								'<td class="GarisDaftar">'+ resp.content.hsl[i].cek+'</td></tr>'); 
							me.nourut++;
							//alert(' tes'+me.jmlError);	
						}
						i++;
						
					}
					
					//alert(' tes jmlError='+me.jmlError+' prog='+prog+' jmldata='+jmldata);	
					cErr = '';
					if(me.jmlError!=0 || me.jmlError>0){
						
						cErr = '  Untuk SKPD: '+ params+', ditemukan '+ me.jmlError+' kesalahan, harap hubungi admin!';
						//alert(' tes cerr='+cErr);
					}
					
					document.getElementById(prefix+'_progressmsg').innerHTML = formatNumber(prog,0,',','.')+'/'+formatNumber(jmldata,0,',','.')+cErr;
					objDiv = document.getElementById(prefix+'_wrap');
					objDiv.scrollTop = objDiv.scrollHeight;
					
					if(persen<100) {
							 
							if(me.pause==false){
								//setTimeout(function(){ me.cekOnClick_(prefix); }, 1);
								me.cekOnClick_(prefix);
							}else{
								alert('Dihentikan sementara');
								document.getElementById(me.cekBiPrefix+'_btcek').value = 'Lanjutkan';
								document.getElementById(me.cekBiPrefix+'_btcek').setAttribute('title', 'Lanjutkan Pengecekan Barang');
							}
						}else{ //selesai
							if(resp.err==''){
								alert(' Selesai Pengecekan '+cErr);
								if(cErr=='')document.getElementById(prefix+'_progressmsg').innerHTML ='Tidak Ditemukan Kesalahan';
								me.pause = true;
								me.proses = false;
								document.getElementById(me.cekBiPrefix+'_btcek').value = 'Cek';
								document.getElementById(me.cekBiPrefix+'_btcek').setAttribute('title', 'Pengecekan Barang');
								//me.Close();
								//Penatausaha.refreshList(true);
							}else{
								//alert('Ada '+resp.content.jml_error+' ID Barang yang gagal disusutkan!');
								//me.Close();
								//me.formErrorPenyusutan();		
								alert(resp.err);						
							}
						}
					
				}else{
					alert(resp.err);
					///delElem(cover);
					//document.body.style.overflow='auto';
				}			
				
		  	},
			//error: ajaxError
			error:function(){
				//alert('lanjut');
				me.cekOnClick_(prefix);
				//setTimeout(function(){ me.cekOnClick_(prefix); }, 1);
			}
		});
	},
	
	
	
	
	filterRenderAfter : function () {
		//if(this.active==false){
			this.cekInitial('cek1','cont_cekbi', 'CekbiSkpdfmURUSAN', 'CekbiSkpdfmSKPD','CekbiSkpdfmUNIT', 'CekbiSkpdfmSUBUNIT', 'CekbiSkpdfmSEKSI');
		//}
	},
	
	
	loading : function (){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		//this.sumHalRender();
		
	},
	
	
	
	
});



var tableToExcel = (
function() {
  //parameter div/table ID , worksheet name
  var uri = 'data:application/vnd.ms-excel;base64,', 
	
	template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>', 
	
	base64 = function(s) { 
		return window.btoa(unescape(encodeURIComponent(s))) 
	}, 
	
	format = function(s, c) { 
		return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) 
	}
    
	return function(table, name) {
	    if (!table.nodeType) table = document.getElementById(table)
	    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    	//window.location.href = uri + base64(format(template, ctx))
		return uri + base64(format(template, ctx))
  	}
}
)()