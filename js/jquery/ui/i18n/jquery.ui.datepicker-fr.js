/* French initialisation for the jQuery UI date picker plugin. */
/* Written by Keith Wood (kbwood@virginbroadband.com.au) and St�phane Nahmani (sholby@sholby.net). */
jQuery(function($){
	$.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: '&#x3c;Pr�c',
		nextText: 'Suiv&#x3e;',
		currentText: 'Courant',
		monthNames: ['Janvier','F�vrier','Mars','Avril','Mai','Juin',
		'Juillet','Ao�t','Septembre','Octobre','Novembre','D�cembre'],
		monthNamesShort: ['Jan','F�v','Mar','Avr','Mai','Jun',
		'Jul','Ao�','Sep','Oct','Nov','D�c'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		dateFormat: 'dd/mm/yy', firstDay: 1};
		//isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
});