(function(jQuery){
	 
	returnEnDateAjaxBookAssist = function(selector)
	{
		var datePicker = jQuery('#arrivalDate').val();
		var nbNuits = parseInt(jQuery(selector).val());
		
		jQuery.ajax({
			type: "POST",
			dataType: "text",
			url: "http://www.hotelsgrandparis.com/homeslide/index/calculdate/date/" + datePicker + "/nbNuits/" + nbNuits,
			success: function(data){
				jQuery("#resasSynxis").attr("href", "de=" + data + "&adult=");
			}
		});
	};

	majDateBookAssist = function(dateFin)
	{
		jQuery("#resasSynxis").attr("href", "date_out=" + data);
	}

})(jQuery)

function ouvre(fichier) {
    ff=window.open(fichier,"popup", "width=830,height=545,left=30,top=20,scrollbars=yes")
}
function ouvreGrand(fichier) {
    ff=window.open(fichier,"popup", "width=1000,height=900,left=30,top=20,scrollbars=yes")
}
function ouvreFullScreen(fichier) {
    ff=window.open(fichier,"popup") 
}