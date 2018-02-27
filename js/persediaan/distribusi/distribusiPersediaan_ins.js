var distribusiPersediaan_ins = new DaftarObj2({
	prefix : 'distribusiPersediaan_ins',
	url : 'pages.php?Pg=distribusiPersediaan_ins',
	formName : 'distribusiPersediaan_insForm',
	distribusiPersediaan_ins_form : '0',
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
						var IDdistribusiPersediaan_ins = Number(resp.content.iddistribusiPersediaan_ins);
						aForm.action= 'pages.php?Pg=distribusiPersediaan_ins&YN=1&id='+IDdistribusiPersediaan_ins;
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
						$( "#tanggalDistribusi" ).datepicker({
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
					aForm.action= 'pages.php?Pg=distribusiPersediaan_ins&id='+ID_PLAFON+"&ID_distribusiPersediaan_ins="+ID_EDIT;
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
						document.getElementById('tabelDetailRincianBarang').innerHTML = resp.content.tabelDetailRincianBarang;
						$("#currentRincianDistribusi").val("");
						$("#sisaBarang").val("");
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
						document.getElementById('tabelDetailRincianBarang').innerHTML = resp.content.tabelDetailRincianBarang;
						$("#currentRincianDistribusi").val("");
						$("#sisaBarang").val("");
					}else{
						alert(resp.err);
					}


			  	}
			});
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
						document.getElementById('tabelDetailRincianBarang').innerHTML = resp.content.tabelDetailRincianBarang;
						$("#currentRincianDistribusi").val("");
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
								keterangan : $("#keterangan").val(),
								merk : $("#merk").val(),
								kodeSKPD : $("#kodeSKPD").val()

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
								keterangan : $("#keterangan").val(),
								merk : $("#merk").val(),
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
	saveDistribusi:function(){
		var me = this;
				$.ajax({
							type:'POST',
							data : {
										nomorDistribusi : $("#nomorDistribusi").val(),
										tanggalDistribusi : $("#tanggalDistribusi").val(),
										bk : $("#bk").val(),
										ck : $("#ck").val(),
										dk : $("#dk").val(),
										p : $("#p").val(),
										q : $("#cmbKegiatan").val(),
										untukKeperluan : $("#untukKeperluan").val(),
										yangMenyerahkan : $("#yangMenyerahkan").val(),
										tanggalBuku : $("#tanggalBuku").val(),
							},
					  	url: this.url+'&tipe=saveDistribusi',
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
	bantuDetailRincianDistribusi : function(idEdit){
		var me = this;
		$.ajax({
					type:'POST',
					data : {
								idEdit : idEdit,
								jumlahBarang : $("#jumlahBarang").val(),
								idSelected : $("#currentRincianDistribusi").val()
					},
					url: this.url+'&tipe=bantuDetailRincianDistribusi',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
							$("#sisaBarang").val(me.formatCurrency(resp.content.sisaBarang));
							$("#bantuJumlah").text(me.formatCurrency($("#jumlahBarang").val())  );
					}else{
						alert(resp.err);
					}
				}
		});

	},


	selectedTabelBarang:function(idSelected){
		var me = this;
				$.ajax({
							type:'POST',
							data : {
										idSelected : idSelected,
							},
					  	url: this.url+'&tipe=selectedTabelBarang',
					  	success: function(data) {
							var resp = eval('(' + data + ')');
							if(resp.err == ''){
									$("#tabelBarang").html(resp.content.tabelBarang);
									$("#tabelDetailRincianBarang").html(resp.content.tabelDetailRincianBarang);
									$("#currentRincianDistribusi").val(idSelected);
									$("#sisaBarang").val(me.formatCurrency(resp.content.sisaBarang));
									$("#filterUnit").val("");
									$("#filterSubUnit").val("");
							}else{
								alert(resp.err);
							}
				  	}
				});
	},
	filterUnitChanged:function(){
		var me = this;
				$.ajax({
							type:'POST',
							data : {
										idSelected : $("#currentRincianDistribusi").val(),
										filterUnit : $("#filterUnit").val(),
										kodeSKPD : $("#kodeSKPD").val(),
							},
					  	url: this.url+'&tipe=filterUnitChanged',
					  	success: function(data) {
							var resp = eval('(' + data + ')');
							if(resp.err == ''){
									$("#tabelDetailRincianBarang").html(resp.content.tabelDetailRincianBarang);
									$("#filterSubUnit").html(resp.content.filterSubUnit);
									$("#sisaBarang").val(me.formatCurrency(resp.content.sisaBarang));
							}else{
								alert(resp.err);
							}
				  	}
				});
	},
	filterSubUnitChanged:function(){
		var me = this;
				$.ajax({
							type:'POST',
							data : {
										idSelected : $("#currentRincianDistribusi").val(),
										filterUnit : $("#filterUnit").val(),
										filterSubUnit : $("#filterSubUnit").val(),
										kodeSKPD : $("#kodeSKPD").val(),
							},
					  	url: this.url+'&tipe=filterSubUnitChanged',
					  	success: function(data) {
							var resp = eval('(' + data + ')');
							if(resp.err == ''){
									$("#tabelDetailRincianBarang").html(resp.content.tabelDetailRincianBarang);
									$("#sisaBarang").val(me.formatCurrency(resp.content.sisaBarang));
							}else{
								alert(resp.err);
							}
				  	}
				});
	},
	editDetailRincianDistribusi:function(idEdit,pageKe){
		var me = this;
				$.ajax({
							type:'POST',
							data : {
										idRincianDistribusi : $("#currentRincianDistribusi").val(),
										filterUnit : $("#filterUnit").val(),
										filterSubUnit : $("#filterSubUnit").val(),
										kodeSKPD : $("#kodeSKPD").val(),
										idEdit : idEdit,
										pageKe : pageKe,
							},
					  	url: this.url+'&tipe=editDetailRincianDistribusi',
					  	success: function(data) {
							var resp = eval('(' + data + ')');
							if(resp.err == ''){
									$("#tabelDetailRincianBarang").html(resp.content.tabelDetailRincianBarang);
							}else{
								alert(resp.err);
							}
				  	}
				});
	},
	saveEditDetailRincianDistribusi:function(idEdit,pageKe){
		var me = this;
				$.ajax({
							type:'POST',
							data : {
										idRincianDistribusi : $("#currentRincianDistribusi").val(),
										filterUnit : $("#filterUnit").val(),
										filterSubUnit : $("#filterSubUnit").val(),
										kodeSKPD : $("#kodeSKPD").val(),
										idEdit : idEdit,
										pageKe : pageKe,
										jumlahBarang : $("#jumlahBarang").val()

							},
					  	url: this.url+'&tipe=saveEditDetailRincianDistribusi',
					  	success: function(data) {
							var resp = eval('(' + data + ')');
							if(resp.err == ''){
									$("#tabelDetailRincianBarang").html(resp.content.tabelDetailRincianBarang);
									$("#sisaBarang").val(me.formatCurrency(resp.content.sisaBarang));
							}else{
								alert(resp.err);
							}
				  	}
				});
	},
	cancelEditDetailRincianDistribusi:function(idEdit,pageKe){
		var me = this;
				$.ajax({
							type:'POST',
							data : {
										idRincianDistribusi : $("#currentRincianDistribusi").val(),
										filterUnit : $("#filterUnit").val(),
										filterSubUnit : $("#filterSubUnit").val(),
										kodeSKPD : $("#kodeSKPD").val(),
										pageKe : pageKe,
										// idEdit : idEdit,
										// jumlahBarang : $("#jumlahBarang").val()

							},
					  	url: this.url+'&tipe=cancelEditDetailRincianDistribusi',
					  	success: function(data) {
							var resp = eval('(' + data + ')');
							if(resp.err == ''){
									$("#tabelDetailRincianBarang").html(resp.content.tabelDetailRincianBarang);
									$("#sisaBarang").val(me.formatCurrency(resp.content.sisaBarang));
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
				data : {id : id,kodeSKPD : $("#kodeSKPD").val()},
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


});
