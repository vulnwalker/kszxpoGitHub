	
	$(document).ready(function() {
	  var bottom = 0; 
	   var pagNum = 2; 
	  $("tr:nth-child(20)").each(function() {
	    bottom -= 100;
	    botString = bottom.toString();
	    var $counter = $('h5.pag1').clone().removeClass('pag1');
	    $counter.css("bottom", botString + "vh");
	    numString = pagNum.toString();
	    $counter.addClass("pag" + numString);
	    ($counter).insertBefore('.insert');
	    pagNum = parseInt(numString);
	    pagNum++; 
	  });
	  var pagTotal = $('.pag').length; 
	  pagTotalString = pagTotal.toString();
	  $("h5[class^=pag]").each(function() {

	    var numId = this.className.match(/\d+/)[0];
	    document.styleSheets[0].addRule('h5.pag' + numId + '::before', 'content: "Hal. ' + numId + ' dari ' + pagTotalString + '";');

	  });
	});