//# jQuery - Horizontal Accordion
//# Version 2.00.00 Alpha 1
//#
//# portalZINE(R) - New Media Network
//# http://www.portalzine.de
//#
//# Alexander Graef
//# portalzine@gmail.com
//#
//# Copyright 2007-2009

(function(jQuery) {
	jQuery.hrzAccordion = {
       
	   
	   setOnEvent: function(i, container, finalWidth, settings){
			jQuery("#"+container+"Handle"+i).bind(settings.eventTrigger,function() {			 
			   			
						var status = jQuery('[rel='+container+'ContainerSelected]').data('status');
						
						if(status ==1 && settings.eventWaitForAnim === true){
						 return false;	
						}
						
						if( jQuery("#"+container+"Handle"+i).attr("rel") != container+"HandleSelected"){
			    		
						  settings.eventAction;
							
							jQuery('[id*='+container+'Handle]').attr("rel","");			   				
			   				
							jQuery('[id*='+container+'Handle]').attr("class",settings.handleClass);
		
			   				jQuery("#"+container+"Handle"+i).addClass(settings.handleClassSelected);
										   
			   		
							jQuery("."+settings.contentWrapper).css({width: finalWidth+"px" });
							
							switch(settings.closeOpenAnimation)
							{
							case 1:
      
				   
						if(jQuery('[rel='+container+'ContainerSelected]').get(0)  ){
						jQuery('[rel='+container+'ContainerSelected]').data('status',1);
							
							//current_width = jQuery('[rel='+container+'ContainerSelected]').width();
							
							jQuery('[rel='+container+'ContainerSelected]').animate({width: "0px",opacity:"0"}, { queue:true, duration:settings.closeSpeed ,easing:settings.closeEaseAction,complete: function(){	
				 																																	
							jQuery('[rel='+container+'ContainerSelected]').data('status',0);																																											} ,step: function(now){
																																																		 							width = jQuery(this).width();
						
							//new_width = finalWidth- (finalWidth  * (width/current_width));
							new_width = finalWidth - width;
							jQuery('#'+container+'Content'+i).width(Math.ceil(new_width)).css("opacity","1");
							
							}});
		
						}else{
							jQuery('[rel='+container+'ContainerSelected]').data('status',1);
								
							jQuery('#'+container+'Content'+i).animate({width: finalWidth,opacity:"1"}, { queue:false, duration:settings.closeSpeed ,easing:settings.closeEaseAction,complete: function(){
																																																	  jQuery('[rel='+container+'ContainerSelected]').data('status',0);	
																																																	  }});
							
								
							}
							
							break;
							case 2:
								jQuery('[id*='+container+'Content]').css({width: "0px"});
								jQuery('#'+container+'Content'+i).animate({width: finalWidth+"px",opacity:"1"}, { queue:false, duration:settings.openSpeed ,easing:settings.openEaseAction, complete: 
 settings.completeAction																																																									});						
							
							break;
							}

							jQuery('[id*='+container+'Content]').attr("rel","");			
							jQuery("#"+container+"Handle"+i).attr("rel",container+"HandleSelected");
							jQuery("#"+container+"Content"+i).attr("rel",container+"ContainerSelected");					
							
						
						}
						
					});	
}
	    };
	
	jQuery.fn.extend({
	   
		hrzAccordionLoop: function(options) {
			return this.each(function(a){  
				
				var container = jQuery(this).attr("id") || jQuery(this).attr("class");
				var elementCount = jQuery('#'+container+' > li, .'+container+' > li').size();
				var settings = jQuery(this).data('settings');
				
				variable_holder="interval"+container ;
				var i =0;
				var loopStatus  = "start";
				
				variable_holder = window.setInterval(function(){							
				
				jQuery("#"+container+"Handle"+i).trigger(settings.eventTrigger);
				
				if(loopStatus =="start"){
						i = i + 1;
					}else{
						i = i-1;	
					}
					
					if(i==elementCount && loopStatus  == "start"){
						loopStatus  = "end";
						i=elementCount-1;

					}
					
					if(i==0 && loopStatus  == "end"){
						loopStatus  = "start";
						i=0;

					}
												},settings.cycleInterval);
				
				
				});
			},
		hrzAccordion: function(options) {
			this.settings = {
			eventTrigger	   		: "click",
			containerClass     		: "container",
			listItemClass      		: "listItem",					
			contentContainerClass  	: "contentContainer",
			contentWrapper     		: "contentWrapper",
			contentInnerWrapper		: "contentInnerWrapper",
			handleClass        		: "handle",
			handleClassOver    		: "handleOver",
			handleClassSelected		: "handleSelected",
			handlePosition     		: "right",
			handlePositionArray		: "", // left,left,right,right,right
			closeEaseAction    		: "swing",
			closeSpeed     			: 500,
			openEaseAction     		: "swing",
			openSpeed      			: 500,
			openOnLoad		   		: 2,
			hashPrefix		   		: "tab",
			eventAction		   		: function(){
								 	//add your own extra clickAction function here
								 	},
			completeAction	   		: function(){
								 	//add your own onComplete function here
								 	},
			closeOpenAnimation 		: 1,// 1 - open and close at the same time / 2- close all and than open next
			cycle			   		: false, // not integrated yet, will allow to cycle through tabs by interval
			cycleInterval	   		: 10000,
			fixedWidth				: "",
			eventWaitForAnim		: true
				
		};
	
		if(options){
			jQuery.extend(this.settings, options);
		}
			var settings = this.settings;
			
			
			
			return this.each(function(a){    		
				
				var container = jQuery(this).attr("id") || jQuery(this).attr("class");			
				
				jQuery(this).data('settings', settings);
				
				jQuery(this).wrap("<div class='"+settings.containerClass+"'></div>");
			
				var elementCount = jQuery('#'+container+' > li, .'+container+' > li').size();
												
				var containerWidth =  jQuery("."+settings.containerClass).width();
				
				var handleWidth = jQuery("."+settings.handleClass).css("width");
		
				handleWidth =  handleWidth.replace(/px/,"");
			    var finalWidth;
				var handle;
				
				if(settings.fixedWidth){
					finalWidth = settings.fixedWidth;
				}else{
					finalWidth = containerWidth-(elementCount*handleWidth)-handleWidth;
				}
				
				jQuery('#'+container+' > li, .'+container+' > li').each(function(i) {
			
					jQuery(this).attr('id', container+"ListItem"+i);
			   		jQuery(this).attr('class',settings.listItemClass);
		       		jQuery(this).html("<div class='"+settings.contentContainerClass+"' id='"+container+"Content"+i+"'>"
								 +"<div class=\""+settings.contentWrapper+"\">"
								 +"<div class=\""+settings.contentInnerWrapper+"\">"
								 +jQuery(this).html()
								 +"</div></div></div>");
			   		
					if(jQuery("div",this).hasClass(settings.handleClass)){
					
					var html = jQuery("div."+settings.handleClass,this).attr("id",""+container+"Handle"+i+"").html();
					jQuery("div."+settings.handleClass,this).remove();
					
					 handle = "<div class=\""+settings.handleClass+"\" id='"+container+"Handle"+i+"'>"+html+"</div>";
					}else{
					 handle = "<div class=\""+settings.handleClass+"\" id='"+container+"Handle"+i+"'></div>";
					}
					
				
					
					if(settings.handlePositionArray){
						splitthis 				= settings.handlePositionArray.split(",");
						settings.handlePosition = splitthis[i];
					}
					
					switch(settings.handlePosition ){
						case "left":
						jQuery(this).prepend( handle );
						break;
						case "right":	
						jQuery(this).append( handle );	
						break;
						case "top":	
						jQuery("."+container+"Top").append( handle );	
						break;
						case "bottom":	
						jQuery("."+container+"Bottom").append( handle );	
						break;
					}					
				
					jQuery("#"+container+"Handle"+i).bind("mouseover", function(){
						jQuery("#"+container+"Handle"+i).addClass(settings.handleClassOver);
					});
			    
					jQuery("#"+container+"Handle"+i).bind("mouseout", function(){
						if( jQuery("#"+container+"Handle"+i).attr("rel") != "selected"){
							jQuery("#"+container+"Handle"+i).removeClass(settings.handleClassOver);
						}
					});
					
				
					jQuery.hrzAccordion.setOnEvent(i, container, finalWidth, settings);				
					
					if(i == elementCount-1){
						jQuery('#'+container+",."+container).show();					
					}
					
					
								
					if(settings.openOnLoad !== false && i == elementCount-1){
							var location_hash = location.hash;
							location_hash  = location_hash.replace("#", "");	
							if(location_hash.search(settings.hashPrefix) != '-1' ){
							var tab = 1;
							location_hash  = location_hash.replace(settings.hashPrefix, "");
							}
							
							if(location_hash && tab ==1){
						 		jQuery("#"+container+"Handle"+(location_hash)).attr("rel",container+"HandleSelected");
								jQuery("#"+container+"Content"+(location_hash)).attr("rel",container+"ContainerSelected");		
								jQuery("#"+container+"Handle"+(location_hash-1)).trigger(settings.eventTrigger);
												
							}else{
								jQuery("#"+container+"Handle"+(settings.openOnLoad)).attr("rel",container+"HandleSelected");
							    jQuery("#"+container+"Content"+(settings.openOnLoad)).attr("rel",container+"ContainerSelected");	
								jQuery("#"+container+"Handle"+(settings.openOnLoad-1)).trigger(settings.eventTrigger);
							}					
					}	
				});	
				
				if(settings.cycle === true){
					jQuery(this).hrzAccordionLoop();
				}
			});				
		}		
	});
})(jQuery);	
