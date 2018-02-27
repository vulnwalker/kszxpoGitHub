function closePopup(){
  window.location.href = "tesmenuv5.php";
}

function postRKA(){
      $.ajax({
          type : 'POST',
          url  : "pages.php?Pg=postingPerencanaan&tipe=postRKA" ,
          data : {tujuanPosting : $("#cmbPosting").val()},
          success : function(response){
              var dataJSON = $.parseJSON(response);
              var err = dataJSON['err'];
              var cek = dataJSON['cek'];

              if(err == ""){
                  var jsonContent = dataJSON['content'];
                  makeTahap($("#cmbPosting").val(),jsonContent['jenisForm'],jsonContent['jenisAnggaran'],jsonContent['tahunAnggaran'],jsonContent['namaModul'],jsonContent['namaTahap']);
                  alert("Posting Berhasil");


              }else{
                alert(err);
              }
          }
      });
}
function postAnggaranKas(){
      $.ajax({
          type : 'POST',
          url  : "pages.php?Pg=postingPerencanaan&tipe=postAnggaranKas" ,
          data : {tujuanPosting : $("#cmbPostingAnggaranKas").val()},
          success : function(response){
              var dataJSON = $.parseJSON(response);
              var err = dataJSON['err'];
              var cek = dataJSON['cek'];

              if(err == ""){
                  var jsonContent = dataJSON['content'];
                  makeTahap($("#cmbPostingAnggaranKas").val(),jsonContent['jenisForm'],jsonContent['jenisAnggaran'],jsonContent['tahunAnggaran'],jsonContent['namaModul'],jsonContent['namaTahap']);
                  alert("Posting Berhasil");


              }else{
                alert(err);
              }
          }
      });
}

function makeTahap(tujuanPosting,jenisForm,jenisAnggaran,tahunAnggaran,namaModul,namaTahap){
  $.ajax({
    type:'POST',
    data: {	idModul : tujuanPosting,
            jenisForm : jenisForm,
            anggaran : jenisAnggaran,
            tahun : tahunAnggaran,
            namaModul : namaModul,
            nama_tahap : namaTahap,
            status : "AKTIF",
            bypassTahap_v2_fmST : 0
          },
    url: "pages.php?Pg=bypassTahap_v2&tipe=simpan",
      success: function(data) {
        if($("#cmbPosting").val() == "9"){
          syncDPASKPD221();
        }

      }
  });

function syncDPASKPD221(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaSKPD221&tipe=sync",
      success: function(data) {
          syncDPASKPD21();
      }
  });
}

function syncDPASKPD21(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaSKPD21&tipe=sync",
      success: function(data) {
        syncDPASKPD1PAD();
      }
  });
}

function syncDPASKPD1PAD(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaSKPD1PAD&tipe=sync",
      success: function(data) {
        syncDPASKPD1DP();
      }
  });
}

function syncDPASKPD1DP(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaSKPD1DP&tipe=sync",
      success: function(data) {
        syncDPASKPD1LP();
      }
  });
}

function syncDPASKPD1LP(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaSKPD1LP&tipe=sync",
      success: function(data) {
        syncDPASKPD31();
      }
  });
}


function syncDPASKPD31(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaSKPD31&tipe=sync",
      success: function(data) {
      syncDPASKPD32();
      }
  });
}

function syncDPASKPD32(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaSKPD32&tipe=sync",
      success: function(data) {
        syncDPAPPKD21();
      }
  });
}

function syncDPAPPKD21(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaPPKD21&tipe=sync",
      success: function(data) {
        syncDPAPPKD1PAD();
      }
  });
}

function syncDPAPPKD1PAD(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaPPKD1PAD&tipe=sync",
      success: function(data) {
        syncDPAPPKD1DP();
      }
  });
}

function syncDPAPPKD1DP(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaPPKD1DP&tipe=sync",
      success: function(data) {
        syncDPAPPKD1LP();
      }
  });
}

function syncDPAPPKD1LP(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaPPKD1LP&tipe=sync",
      success: function(data) {
        syncDPAPPKD31();
      }
  });
}

function syncDPAPPKD31(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaPPKD31&tipe=sync",
      success: function(data) {
        syncDPAPPKD32();
      }
  });
}

function syncDPAPPKD32(){
  $.ajax({
    type:'POST',
    url: "pages.php?Pg=dpaPPKD32&tipe=sync",
      success: function(data) {

      }
  });
}


}
