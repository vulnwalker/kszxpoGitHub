

var ref_images = new DaftarObj2({
  prefix : 'ref_images',
  url : 'pages.php?Pg=ref_images', 
  //formName : 'ref_images_form',
  formName : 'ref_imagesForm',
  //ref_images_form
  loading: function(){
    //alert('loading');
    this.topBarRender();
    this.filterRender();
    this.daftarRender();
    this.sumHalRender();
  
  },
  
  find: function(){
    var me = this;
    me.refreshList(true); 
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

  Baru: function(){ 
    
    var me = this;
    var err='';
    
    if (err =='' ){   
      var cover = this.prefix+'_formcover';
      document.body.style.overflow='hidden';
      addCoverPage2(cover,1,true,false);  
      $.ajax({
        type:'POST', 
        data:$('#ref_images_form').serialize(),
          url: this.url+'&tipe=formBaru',
          success: function(data) {   
          var resp = eval('(' + data + ')');      
          document.getElementById(cover).innerHTML = resp.content;
          //document.getElementById('kode1').focus();     
          me.AfterFormBaru();
          $('#tanggal_update').datepicker({
                dateFormat: 'dd-mm-yy',
              showAnim: 'slideDown',
                inline: true,
              showOn: "button",
                buttonImage: "images/calendar.gif",
                  buttonImageOnly: true,
              changeMonth: true,
                  changeYear: true,
              buttonText : '',
              defaultDate: +0
          }); 
          $("#tanggal_update").datepicker({ dateFormat: "dd-mm-yy" });
          }
      });
    
    }else{
      alert(err);
    }
  },



  Edit:function(){
    var me = this;
    errmsg = this.CekCheckbox();
    if(errmsg ==''){ 
      var box = this.GetCbxChecked();   
      var cover = this.prefix+'_formcover';
      addCoverPage2(cover,1,true,false);  
      document.body.style.overflow='hidden';
      $.ajax({
        type:'POST', 
        data:$('#ref_imagesForm').serialize(),
        url: this.url+'&tipe=formEdit',
          success: function(data) {   
          var resp = eval('(' + data + ')');  
          if (resp.err ==''){   
            document.getElementById(cover).innerHTML = resp.content;
            me.AfterFormEdit(resp);
            $('#tanggal_update').datepicker({
                dateFormat: 'dd-mm-yy',
              showAnim: 'slideDown',
                inline: true,
              showOn: "button",
                buttonImage: "images/calendar.gif",
                  buttonImageOnly: true,
              changeMonth: true,
                  changeYear: true,
              buttonText : '',
              defaultDate: +0
          }); 
          $("#tanggal_update").datepicker({ dateFormat: "dd-mm-yy" });
          }else{
            alert(resp.err);
            delElem(cover);
            document.body.style.overflow='auto';
          }
          }
      });
    }else{
      alert(errmsg);
    }
    
  },

  Upload:function(){
    var me = this;
    errmsg = this.CekCheckbox();
    if(errmsg ==''){ 
      var box = this.GetCbxChecked();   
      var cover = this.prefix+'_formcover';
      addCoverPage2(cover,1,true,false);  
      document.body.style.overflow='hidden';
      $.ajax({
        type:'POST', 
        data:$('#ref_imagesForm').serialize(),
        url: this.url+'&tipe=formUpload',
          success: function(data) {   
          var resp = eval('(' + data + ')');  
          if (resp.err ==''){   
            document.getElementById(cover).innerHTML = resp.content;
            me.AfterFormEdit(resp);
            $('#tanggal_update').datepicker({
                dateFormat: 'dd-mm-yy',
              showAnim: 'slideDown',
                inline: true,
              showOn: "button",
                buttonImage: "images/calendar.gif",
                  buttonImageOnly: true,
              changeMonth: true,
                  changeYear: true,
              buttonText : '',
              defaultDate: +0
          }); 
          $("#tanggal_update").datepicker({ dateFormat: "dd-mm-yy" });
          }else{
            alert(resp.err);
            delElem(cover);
            document.body.style.overflow='auto';
          }
          }
      });
    }else{
      alert(errmsg);
    }
    
  },

  editKategori: function(idMerk){
    var me = this;
    var err='';
    if (err =='' ){   
      var cover = this.prefix+'_formcoverKB';
      document.body.style.overflow='hidden';
      addCoverPage2(cover,9,true,false);  
      $.ajax({
        type:'POST', 
        data:{
            cmbKategori : $("#cmbKategori").val(),    
           },
          url: this.url+'&tipe=editKategori',
          success: function(data) {   
          var resp = eval('(' + data + ')');      
          document.getElementById(cover).innerHTML = resp.content;  
          
          //me.AfterFormBaru();
          }
      });
    }else{
      alert(err);
    } 
    
  },

  saveEditKategori: function(idKategori){
    var me= this;
    var err='';
    
    this.OnErrorClose = false 
    document.body.style.overflow='hidden';
    var cover = this.prefix+'_formsimpanKB';
    addCoverPage2(cover,1,true,false);  
    
    $.ajax({
      type:'POST', 
      data:{

          nama_kategori : $("#nama_kategori").val(),
          cmbKategori : $("#cmbKategori").val(),

          },
      url: this.url+'&tipe=saveEditKategori',
        success: function(data) {   
        var resp = eval('(' + data + ')');  
        delElem(cover);   
        
        if(resp.err==''){

          //me.reloadTabel();

            document.getElementById('cmbKategori').innerHTML=resp.content.cmbKategori;
          me.Close2();        
        }else{
          alert(resp.err);
        }
        }
    });
    
  },

  SimpanKategori: function(dt){
    var me= this;
    var err='';
    
    this.OnErrorClose = false 
    document.body.style.overflow='hidden';
    var cover = this.prefix+'_formsimpanKB';
    addCoverPage2(cover,1,true,false);
    
    $.ajax({
      type:'POST', 
      data:$('#'+this.prefix+'_KBform').serialize(),
      url: this.url+'&tipe=SimpanKategori',
        success: function(data) {
        var resp = eval('(' + data + ')');  
        delElem(cover);   
        if(resp.err==''){
          document.getElementById('cmbKategori').innerHTML = resp.content.replacer;
          me.Close2();
        }else{
          alert(resp.err);
        }
        }
    }); 
  },
  
    newKategori: function(){
    var me = this;
    var err='';
    if (err =='' ){   
      var cover = this.prefix+'_formcoverKB';
      document.body.style.overflow='hidden';
      addCoverPage2(cover,9,true,false);  
      $.ajax({
        type:'POST', 
        data:{
            cmbKategori : $("#cmbKategori").val(),    
           },
          url: this.url+'&tipe=newKategori',
          success: function(data) {   
          var resp = eval('(' + data + ')');      
          document.getElementById(cover).innerHTML = resp.content;  
          
          //me.AfterFormBaru();
          }
      });
    }else{
      alert(err);
    } 
    
  },
  
  Modul:function(){
    var me = this;
    errmsg = this.CekCheckbox();
    if(errmsg ==''){ 
      var box = this.GetCbxChecked();   
      $.ajax({
        type:'POST', 
        data:$('#ref_imagesForm').serialize(),
        url: this.url+'&tipe=modul',
          success: function(data) {   
          var resp = eval('(' + data + ')');  

          popupOption.windowShow(resp.content.idAplikasi);

          }
      });
    }else{
      alert(errmsg);
    }
    
  },
  
  Hapus:function(){
    
    var me =this;
    if(document.getElementById(this.prefix+'_jmlcek')){
      var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ; 
    }else{
      var jmlcek = '';
    }
    
    if(jmlcek ==0){
      alert('Data Belum Dipilih!');
    }else{
      if(confirm('Hapus '+jmlcek+' Data ?')){
        //document.body.style.overflow='hidden'; 
        var cover = this.prefix+'_hapuscover';
        addCoverPage2(cover,1,true,false);
        $.ajax({
          type:'POST', 
          data:$('#'+this.formName).serialize(),
          url: this.url+'&tipe=hapus',
            success: function(data) {   
            var resp = eval('(' + data + ')');    
            delElem(cover);   
            if(resp.err==''){             
              me.Close();
              me.refreshList(true)
            }else{
              alert(resp.err);
            }             
            
            }
        });
        
      } 
    }
  },
  
  
  
  Close2:function(){//alert(this.elCover);
    var cover = this.prefix+'_formcoverKB';
    if(document.getElementById(cover)) delElem(cover);      
    if(tipe==null){
      document.body.style.overflow='auto';            
    }
  },
  
  Close3:function(){//alert(this.elCover);
    var cover = this.prefix+'_formcoverKC';
    if(document.getElementById(cover)) delElem(cover);      
    if(tipe==null){
      document.body.style.overflow='auto';            
    }
  },
  
  Close4:function(){//alert(this.elCover);
    var cover = this.prefix+'_formcoverKD';
    if(document.getElementById(cover)) delElem(cover);      
    if(tipe==null){
      document.body.style.overflow='auto';            
    }
  },
  
  Close5:function(){//alert(this.elCover);
    var cover = this.prefix+'_formcoverKE';
    if(document.getElementById(cover)) delElem(cover);      
    if(tipe==null){
      document.body.style.overflow='auto';            
    }
  },
  
  simpanMerek: function(dt){
    var me= this;
    var err='';
    
    this.OnErrorClose = false 
    document.body.style.overflow='hidden';
    var cover = this.prefix+'_formsimpanKB';
    addCoverPage2(cover,1,true,false);
    
    $.ajax({
      type:'POST', 
      data:$('#'+this.prefix+'_KBform').serialize(),
      url: this.url+'&tipe=SimpanKategori',
        success: function(data) {
        var resp = eval('(' + data + ')');  
        delElem(cover);   
        if(resp.err==''){
          document.getElementById('cmbKategori').innerHTML = resp.content.replacer;
          me.Close2();
        }else{
          alert(resp.err);
        }
        }
    }); 
  },
  
  
  
  SimpanEdit: function(){
    var me= this; 
    this.OnErrorClose = false 
    document.body.style.overflow='hidden';
    var cover = this.prefix+'_formsimpan';
    addCoverPage2(cover,1,true,false);  
    /*this.sendReq(
      this.url,
      { idprs: 0, daftarProses: new Array('simpan')},
      this.formDialog);*/
    $.ajax({
      type:'POST', 
      data:$('#ref_images_form').serialize(),
      url: this.url+'&tipe=simpanEdit',
        success: function(data) {   
        var resp = eval('(' + data + ')');  
        delElem(cover);   
        //document.getElementById(cover).innerHTML = resp.content;
        if(resp.err==''){
          alert('Data berhasil disimpan');
          me.Close();
          me.refreshList(true);
          me.AfterSimpan(); 
        }
        else{
          alert(resp.err);
        }
        }
    });
  },

    btfile_onchange: function(){
    $('#UploadForm').submit();  
  },

  SubModulEdit: function(){
    var me = this;
    var err='';
    if($("#cmbSubModul").val() == ''){
      err = "Pilih Sub Modul";
    }
    if (err =='' ){   
      var cover = this.prefix+'_formcoverKB';
      document.body.style.overflow='hidden';
      addCoverPage2(cover,1,true,false);  
      $.ajax({
        type:'POST', 
        data:{id_kategori:$('#cmbKategori').val()},
          url: this.url+'&tipe=formBaruSubModul',
          success: function(data) {   
          var resp = eval('(' + data + ')');      
          document.getElementById(cover).innerHTML = resp.content;      
          //me.AfterFormBaru();
          }
      });
    }else{
      alert(err);
    } 
    
  },

  btfile_onchange: function(){
    $('#UploadForm').submit();  
  },
  
  Simpan: function(id){
    var me= this; 
    this.OnErrorClose = false 
    document.body.style.overflow='hidden';
    var cover = this.prefix+'_formsimpan';
    addCoverPage2(cover,1,true,false);  
    $.ajax({
      type:'POST', 
      data:$('#'+this.prefix+'_form').serialize()+'&hubla='+id,
      url: this.url+'&tipe=simpan',
        success: function(data) {   
        var resp = eval('(' + data + ')');  
        delElem(cover);   
        //document.getElementById(cover).innerHTML = resp.content;
        if(resp.err==''){
          me.Close();
          me.AfterSimpan();
        }else{
          alert(resp.err);
        }
        }
    });
  }
  
  
    
});
