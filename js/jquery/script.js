jQuery(function(){
	
/*================================= SlideShow fiche hotel =================================*/
	
	jQuery('#product_tabs_additional_tabbed_contents').css('display','none');	
	jQuery('#product_tabs_upsell_products_tabbed_contents').css('display','none');
	jQuery('#product_tabs_description_tabbed').click(function(){
		jQuery('.padder > div').not('#product_tabs_description_tabbed_contents').css('display','none')
		jQuery('#product_tabs_description_tabbed_contents').css('display','block');	
	});
	
	jQuery('#product_tabs_additional_tabbed').click(function(){
		jQuery('.padder > div').not('#product_tabs_additional_tabbed_contents').css('display','none')
		jQuery('#product_tabs_additional_tabbed_contents').css('display','block');	
	});
	
	jQuery('#product_tabs_upsell_products_tabbed').click(function(){
		jQuery('.padder > div').not('#product_tabs_upsell_products_tabbed_contents').css('display','none')
		jQuery('#product_tabs_upsell_products_tabbed_contents').css('display','block');
	});
	
	

	jQuery(window).load(function() {		
	 jQuery('#overlayVirtualTour').fadeOut();
		 jQuery('#product_tabs_virtual_products_tabbed_contents').css('display','block');		
	});
	
	
	jQuery('#product_tabs_virtual_products_tabbed').click(function(){
		jQuery('.padder > div').not('#product_tabs_virtual_products_tabbed_contents').css('display','none')
		 jQuery('#product_tabs_virtual_products_tabbed_contents').css('display','block');		
		//jQuery('#panoflash1').css({'height':'600px', 'width':'328px'});
	});
	
	
	jQuery('#slidesFicheHotel').slides({
		preload: true,
		preloadImage: 'img/loading.gif',
		generatePagination: true,
		play: 3000,
		pause: 2500,
		hoverPause: true,
		slideSpeed: 600,
		effect: 'fade',
		crossfade: true,
		generateNextPrev: true,
		animationStart: function(current){
			jQuery('.caption').animate({'opacity':'0'},150);
		},
		animationComplete: function(current){
			jQuery('.caption').animate({'opacity':'1'},300);				
		}
	});
	
/*================================= Photo Quartier =================================*/

	jQuery('#quartiers-centre h2 a').hover(function(){
		jQuery(this).parent().parent().find('.corner').css('display','block');
	},function(){
		jQuery(this).parent().parent().find('.corner').css('display','none');
	});
	jQuery('.bloc-left-mini-quartier').hover(function(){
		jQuery(this).find('.corner').css('display','block');
	},function(){
		jQuery(this).find('.corner').css('display','none');
	});
	
	
	/*================================= Onglet fiche hotel =================================*/
	
	
	
	jQuery('#wrapperSliderhotel #product_tabs_additional_tabbed, #wrapperSliderhotel #product_tabs_upsell_products_tabbed, #wrapperSliderhotel #product_tabs_virtual_products_tabbed').click(function(){
		jQuery('.product-img-box').css('height','290px');
		jQuery('#wrapperSliderhotel').css('height','260px');
	});
	jQuery('#wrapperSliderhotel #product_tabs_virtual_products_tabbed').click(function(){
		jQuery('#product_tabs_virtual_products_tabbed_contents').css('height','328px');
	});
	jQuery('#wrapperSliderhotelGrand #product_tabs_virtual_products_tabbed').click(function(){
		jQuery('#product_tabs_virtual_products_tabbed_contents').css('height','328px');
	});
	jQuery('#wrapperSliderhotel #product_tabs_description_tabbed').click(function(){
		jQuery('.product-img-box').css('height','270px');
		jQuery('#wrapperSliderhotel').css('height','240px');
	});

	jQuery('#wrapperSliderhotelGrand #product_tabs_virtual_products_tabbed_contents').parent().find('#product_tabs_description_tabbed_contents').css('height','328px');
	jQuery('#wrapperSliderhotel #product_tabs_virtual_products_tabbed_contents').parent().find('#product_tabs_description_tabbed_contents').css('height','228px');
	
	
	
});
