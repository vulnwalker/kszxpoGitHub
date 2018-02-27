var pengeluaranPersediaan_ins = new DaftarObj2({
	prefix : 'pengeluaranPersediaan_ins',
	url : 'pages.php?Pg=pengeluaranPersediaan_ins',
	formName : 'pengeluaranPersediaan_insForm',
	pengeluaranPersediaan_ins_form : '0',
	loading: function(){
		this.topBarRender();
		this.filterRender();
		//this.daftarRender();
		//this.sumHalRender();

	},

	detail: function(){
		//alert('detail');
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();
			//UserAktivitasDet.genDetail();

		}else{

			alert(errmsg);
		}

	},
	InputBaru: function(){
	var me = this;

		errmsg = '';

		if($("#fmSKPDUrusan").val() == '00'){
			errmsg = "Pilih Urusan";
		}else if($("#fmSKPDBidang").val() == '00'){
			errmsg = "Pilih Bidang";
		}else if($("#fmSKPDskpd").val() == '00'){
			errmsg = "Pilih SKPD";
		}


		if(errmsg ==''){

			var me = this;
			var aForm = document.getElementById(this.formName);
			$.ajax({
			  url: this.url+'&tipe=newTab',
			  type : 'POST',
			  data:$('#'+this.formName).serialize(),
			  success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == "") {
						var IDpengeluaranPersediaan_ins = Number(resp.content.idpengeluaranPersediaan_ins);
						aForm.action= 'pages.php?Pg=pengeluaranPersediaan_ins&YN=1&id='+IDpengeluaranPersediaan_ins;
						aForm.target='_blank';
						aForm.submit();
						aForm.target='';
					}else{
						alert(resp.err);
					}

			  }
			});


		}else{
				alert(errmsg);
		}
	},
	setDatePicker: function(){
		$.ajax({
			type:'POST',
				url: this.url+'&tipe=getYearRange',
				success: function(data) {
				var resp = eval('(' + data + ')');
						$( "#tanggalPengeluaran" ).datepicker({
							dateFormat: "dd-mm-yy",
							showAnim: "slideDown",
							inline: true,
							showOn: "button",
							buttonImage: "datepicker/calender1.png",
							buttonImageOnly: true,
							changeMonth: true,
							changeYear: false,
							yearRange: resp.content.yearRange,
							buttonText : "",
						});
						$( "#tanggalBuku" ).datepicker({
							dateFormat: "dd-mm-yy",
							showAnim: "slideDown",
							inline: true,
							showOn: "button",
							buttonImage: "datepicker/calender1.png",
							buttonImageOnly: true,
							changeMonth: true,
							changeYear: false,
							yearRange: resp.content.yearRange,
							buttonText : "",
						});
				}
		});

	},

	formatCurrency:function(num) {
		num = num.toString().replace(/\$|\,/g,'');
		if(isNaN(num))
		num = "0";
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num*100+0.50000000001);
		cents = num%100;
		num = Math.floor(num/100).toString();
		if(cents<10)
		cents = "0" + cents;
		for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+'.'+
		num.substring(num.length-(4*i+3));
		return (((sign)?'':'-') + '' + num );
	},
	newPenyerah:function(){
		var me = this;
			 var cover = this.prefix+'_formcover';
			$.ajax({
				type:'POST',
			  	url: this.url+'&tipe=newPenyerah',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.body.style.overflow='hidden';
						addCoverPage2(cover,999,true,false);
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},
	editPenyerah:function(){
		var me = this;
			 var cover = this.prefix+'_formcover';
			if($("#yangMenyerahkan").val() ==''){
				alert("Pilih Yang Menyerahkan");
			}else{
				$.ajax({
					type:'POST',
					data :{idEdit : $("#yangMenyerahkan").val()},
						url: this.url+'&tipe=editPenyerah',
						success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == ''){
							document.body.style.overflow='hidden';
							addCoverPage2(cover,999,true,false);
							document.getElementById(cover).innerHTML = resp.content;
						}else{
							alert(resp.err);
						}


						}
				});
			}
	},
	deletePenyerah:function(){
		var me = this;

			if($("#yangMenyerahkan").val() ==''){
				alert("Pilih Yang Menyerahkan");
			}else{
					if(confirm("Yakin hapus data ?")){
							$.ajax({
								type:'POST',
								data :{idEdit : $("#yangMenyerahkan").val()},
									url: this.url+'&tipe=deletePenyerah',
									success: function(data) {
									var resp = eval('(' + data + ')');
									if(resp.err == ''){
										$("#yangMenyerahkan").html(resp.content.yangMenyerahkan);
									}else{
										alert(resp.err);
									}


									}
							});
					}
			}
	},

	saveNewPenyerah: function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=saveNewPenyerah',
				success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					$("#yangMenyerahkan").html(resp.content.yangMenyerahkan);
					me.Close();
				}else{
					alert(resp.err);
				}
				}
		});
	},
	saveEditPenyerah: function(idEdit){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize()+"&idEdit="+idEdit,
			url: this.url+'&tipe=saveEditPenyerah',
				success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					$("#yangMenyerahkan").html(resp.content.yangMenyerahkan);
					me.Close();
				}else{
					alert(resp.err);
				}
				}
		});
	},


	Edit:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();

			var aForm = document.getElementById(this.formName);
			$.ajax({
			  url: this.url+'&tipe=editTab',
			  type : 'POST',
			  data:$('#'+this.formName).serialize(),
			  success: function(data) {
					var resp = eval('(' + data + ')');
					var ID_PLAFON = Number(resp.content.ID_PLAFON);
					var ID_EDIT = Number(resp.content.ID_EDIT);
					aForm.action= 'pages.php?Pg=pengeluaranPersediaan_ins&id='+ID_PLAFON+"&ID_pengeluaranPersediaan_ins="+ID_EDIT;
					aForm.target='_blank';
					aForm.submit();
					aForm.target='';
			  }
			});
		}else{
			alert(errmsg);
		}

	},

	findProgramDPA : function(){
			 popupProgramPersediaan.filterSKPD = $("#kodeSKPD").val();
		 	 popupProgramPersediaan.windowShow();
	},
	findProgram : function(){
		 	 popupProgramREF.windowShow();
	},
	findBarang : function(){
		 	 popupBarangPersediaan.windowShow();
	},
	addBarang:function(){
		var me = this;
			$.ajax({
				type:'POST',
			  	url: this.url+'&tipe=addBarang',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelBarang').innerHTML = resp.content.tabelBarang;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},
	editBarang:function(id){
		var me = this;
			$.ajax({
				type:'POST',
				data : {id : id},
			  	url: this.url+'&tipe=editBarang',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelBarang').innerHTML = resp.content.editBarang;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},
	gandakanBarang:function(id){
		var me = this;
		if(confirm("Yakin gandakan barang ?")){
			$.ajax({
				type:'POST',
				data : {id : id},
			  	url: this.url+'&tipe=gandakanBarang',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelBarang').innerHTML = resp.content.tabelBarang;
					}else{
						alert(resp.err);
					}
			  	}
			});
		}

	},
	cancelBarang:function(){
		var me = this;
			$.ajax({
				type:'POST',
			  	url: this.url+'&tipe=cancelBarang',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelBarang').innerHTML = resp.content.tabelBarang;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},
	saveNewBarang:function(){
		var me = this;
			$.ajax({
					type:'POST',
					data : {
								kodeBarang : $("#kodeBarang").val(),
								jumlahBarang : $("#jumlahBarang").val(),
								merk : $("#merk").val(),
								keterangan : $("#keterangan").val(),

					},
			  	url: this.url+'&tipe=saveNewBarang',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelBarang').innerHTML = resp.content.tabelBarang;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},
	saveEditBarang:function(id){
		var me = this;
			$.ajax({
					type:'POST',
					data : {
								kodeBarang : $("#kodeBarang").val(),
								jumlahBarang : $("#jumlahBarang").val(),
								merk : $("#merk").val(),
								keterangan : $("#keterangan").val(),
								id : id

					},
			  	url: this.url+'&tipe=saveEditBarang',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById('tabelBarang').innerHTML = resp.content.tabelBarang;
					}else{
						alert(resp.err);
					}


			  	}
			});
	},
	deleteBarang:function(id){
		var me = this;
			if(confirm("Yakin hapus barang ?")){
				$.ajax({
						type:'POST',
						data : {
									id : id

						},
				  	url: this.url+'&tipe=deleteBarang',
				  	success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err == ''){
							document.getElementById('tabelBarang').innerHTML = resp.content.tabelBarang;
						}else{
							alert(resp.err);
						}


				  	}
				});
			}
	},
	savePengeluaran:function(){
		var me = this;
				$.ajax({
							type:'POST',
							data : {
										nomorPengeluaran : $("#nomorPengeluaran").val(),
										tanggalPengeluaran : $("#tanggalPengeluaran").val(),
										bk : $("#bk").val(),
										ck : $("#ck").val(),
										dk : $("#dk").val(),
										p : $("#p").val(),
										q : $("#cmbKegiatan").val(),
										untukKeperluan : $("#untukKeperluan").val(),
										yangMenyerahkan : $("#yangMenyerahkan").val(),
										tanggalBuku : $("#tanggalBuku").val(),
							},
					  	url: this.url+'&tipe=savePengeluaran',
					  	success: function(data) {
							var resp = eval('(' + data + ')');
							if(resp.err == ''){
									alert("Data Tersimpan");
									me.closeTab();
							}else{
								alert(resp.err);
							}
				  	}
				});
	},

	closeTab : function(){
			window.opener.location.reload();
			var ww = window.open(window.location, '_self');
			ww.close();

	},

	bantu : function(){
		$("#bantuJumlah").text(this.formatCurrency($("#jumlahBarang").val())  );
	},



});
