var googlemapAPI;
var googlemapclass=new Array();
var googlemapclass = Class.create();
googlemapclass.prototype = {
	initialize: function(xml,div,trip,hideinfobulle,displayall,lieuxhotel,lieuxFiche) {
		
		
		this.lieuxhotel = lieuxhotel ? lieuxhotel : null;
		
		this.lieuxFiche = lieuxFiche ? lieuxFiche : null;
		
		this.zoommaxi=19;
		this.zoommini=10;
		this.xml=xml;
		this.div=$(div);
		this.displayall=(displayall) ?  displayall : false;
		this.hideinfobulle=(hideinfobulle) ?  hideinfobulle : false;
		this._iconBounds=new Array();
 	    this.placeMarks= new Array();
		this.trip=$(trip);
		this.map = new GMap2(this.div);
	    this.geocoder = new GClientGeocoder();
	    this.centerdefault=new GLatLng(48.85918110234517, 2.3437364196777344);
	    this.zoomdefault=12;
	    this.trimode=null;
	    this.map.setCenter(this.centerdefault, this.zoomdefault);
 	    this.dirn= new GDirections(this.map,this.trip);
 	    this.zoominit();
 	    this.Cluster=new Array();
 	    this.configInfoBulle;
 	    
 	    this.bounds = new GLatLngBounds(); 
 		GEvent.addListener(this.dirn,"load",this.updateResult.bind(this));
 		
 		Event.observe(window, 'unload', function(){
	 		GUnload();    
		});
 		
		GEvent.addListener(this.dirn,"error", this.errorDirn.bind(this));
		GEvent.addListener(this.map, 'zoomend', this.closeInfoHtmlZoomed.bind(this));
		//GEvent.addListener(this.map, 'moveend', this.move.bind(this));
 		GDownloadUrl(this.xml,this.readxml.bind(this));
 		
 		
 		
	},
	errorDirn:function(){
		var msg = ""; 
		switch(this.dirn.getStatus().code)
		{
		case 400:
			msg = "Bad request";break;
		case 500:
			msg = "Server error";break;
		case 601:
			msg = "Missing query";break;
		case 602:
			msg = "Unknown address";break;
		case 603:
			msg = "Unavailable address";break;
		case 604:
			msg = "Unknown directions";break;
		case 610:
			msg = "Bad API key";break;
		case 620:
			msg = "Too many queries";break;
		default:
			msg = "Generic error";break;
		}

		alert(this.dirn.getStatus().code+" : "+msg);
	},
	
	updateResult:function(){
		var distance = this.dirn.getDistance().html; 
		var duree = this.dirn.getDuration().html; 
		
		$('resulttime').update(duree);
		$('resultkm').update(distance);
		$('resultdiv').show();
	},
	
	move:function(){
		//this._filterIntersectingMapMarkers();
	},
	closeInfoHtmlZoomed:function(){
		if(this.lieuxhotel==null){
			this._filterIntersectingMapMarkers();
		}
		this.map.closeInfoWindow();
		this.zoomupdatejauge();
	},
	readxml:function(data,responseCode){
		if (responseCode == 200) {
			var ggeoXmlDatas = GXml.parse(data);
			var ggeoXmlPlaceMarks = ggeoXmlDatas.documentElement.getElementsByTagName("Placemark");
			this.placeMarks = new Array();
			
			for (var i=0;i<ggeoXmlPlaceMarks.length;i++) {
				var Icon 				= new GIcon();
				this.placeMarks[i]={
					name:GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("name")[0])
					,id:GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("id")[0])
					,coords:GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("coordinates")[0]).split(",")
					,type:GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("type")[0])
					,stars:GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("stars")[0])
					,adresse:GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("adresse")[0])
					
				};
				
				
				if(ggeoXmlPlaceMarks[i].getElementsByTagName("linkedhotels")){
					this.placeMarks[i].linkedhotels = GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("linkedhotels")[0]);
				}
				
				
				var point = new GLatLng(this.placeMarks[i].coords[0],this.placeMarks[i].coords[1]);
				var _type = GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("type")[0]);
				if(_type =="-1"){ // Hotel
					if (GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("hotel_open")[0])==1 && GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("selected")[0])==1){
						var imageIcon 			="skins/img/hotel_select.png";
						Icon.iconSize 			= new GSize(37,30);
						Icon.iconAnchor 		= new GPoint(19, 24);
						Icon.infoWindowAnchor 	= new GPoint(20, 1);
					}else if(GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("hotel_open")[0])==1){
						var imageIcon 			= "skins/img/icon_hotel.png";
						Icon.iconSize 			= new GSize(28,26);
						Icon.iconAnchor 		= new GPoint(11, 25);
						Icon.infoWindowAnchor 	= new GPoint(7, 1);
					}else{
						var imageIcon 			= "skins/img/icon_hotel_close.png";
						Icon.iconSize 			= new GSize(28,26);
						Icon.iconAnchor 		= new GPoint(11, 25);
						Icon.infoWindowAnchor 	= new GPoint(7, 1);
					}
					
				}else if(_type =="0"){ // Monuments
					var iconImage 			= GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("icon")[0]);
					var imageIcon 			= (iconImage!="") ? iconImage : "data/places/icons/icon_place.png";
					Icon.iconSize 			= new GSize(35, 38);
					Icon.iconAnchor 		= new GPoint(16, 30);
					Icon.infoWindowAnchor 	= new GPoint(16, 1);

				}else if(_type =="2"){ // Centres d'interet
					var imageIcon 			= "data/places/icons/icon_interet.png";
					Icon.iconSize 			= new GSize(35, 38);
					Icon.iconAnchor 		= new GPoint(16, 30);
					Icon.infoWindowAnchor 	= new GPoint(16, 1);

				}else if(_type =="4"){ // Musées
					var imageIcon 			= "data/places/icons/icon_musee.png";
					Icon.iconSize 			= new GSize(35, 38);
					Icon.iconAnchor 		= new GPoint(16, 30);
					Icon.infoWindowAnchor 	= new GPoint(16, 1);

				}else if(_type =="1"){ // Congres/Expos
					var imageIcon 			= "data/places/icons/icon_congres.png";
					Icon.iconSize 			= new GSize(35, 38);
					Icon.iconAnchor 		= new GPoint(16, 30);
					Icon.infoWindowAnchor 	= new GPoint(16, 1);
				}else if(_type =="5" || _type =="6"){ // Autres
					var imageIcon 			= GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("icon")[0]);
					Icon.iconSize 			= new GSize(35, 38);
					Icon.iconAnchor 		= new GPoint(16, 30);
					Icon.infoWindowAnchor 	= new GPoint(16, 1);
				}
				
				Icon.image				= imageIcon;
				
				
				if(_type =="-1"){
					var marker= new GMarker(point, {icon:Icon,zIndexProcess:importanceOrder});
					marker.importance=200;
				}else{
					var marker= new GMarker(point, {icon:Icon,zIndexProcess:importanceOrder});
					marker.importance=1;
				}
				this.placeMarks[i].marker=marker;
				this.placeMarks[i].marker.coords=this.placeMarks[i].coords;
				
				if(this.hideinfobulle==false){
					this.placeMarks[i].marker.desc=GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("description")[0]);
					this.placeMarks[i].marker.shortdesc=GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("shortdesc")[0]);
					this.configInfoBulle={maxWidth:325,maxHeight:170};
				}else{
					this.placeMarks[i].marker.desc=GXml.value(ggeoXmlPlaceMarks[i].getElementsByTagName("onlytext")[0]);
					this.placeMarks[i].marker.shortdesc=this.placeMarks[i].marker.desc;
					this.configInfoBulle={maxWidth:250,maxHeight:90};
				}
				this.placeMarks[i].marker.i=i;
				
				GEvent.addListener(this.placeMarks[i].marker, "click", function(){
				 	googlemapAPI.gotoCoords(this.coords[0],+this.coords[1],this.i);
				});
				
				
			}


			if(this.lieuxhotel!=null){
				this.foundHotelWidthId(this.lieuxhotel);
			}else{
				this.updatemap();
			}
 		} 	
	},
	updatemap:function(){
		this.lieuxhotel=null;
		this.removeMM();
		if(this.trimode==null){
			this.addAllmarkerDefault();
		}else if(this.trimode=="stars"){
			this.defaultposition();
			for (var i=0;i<this.placeMarks.length;i++) {
				if(((this.placeMarks[i].stars==this.id) && this.placeMarks[i].type==-1) || (this.id==0 && (this.placeMarks[i].type==-1 || this.placeMarks[i].type==0))  || (this.placeMarks[i].type==5 || this.placeMarks[i].type==6)){
					this.map.addOverlay(this.placeMarks[i].marker);
				}
			}
		}else{
			this.setDisplayMode();
		}
		this._filterIntersectingMapMarkers();
		if(this.lieuxFiche!=null){
			this.gotoCoordsPlaceZoomed(this.lieuxFiche);
			this.lieuxFiche=null;
		}
	},
	
	defaultposition:function(){
		this.map.setZoom(this.zoomdefault);
 		this.map.panTo(this.centerdefault);
	},
	
	setDisplayMode:function(){
		if(this.id==-1){
			this.defaultposition();
		}
		for (var i=0;i<this.placeMarks.length;i++) {
			if((this.placeMarks[i].type==-1 || (this.placeMarks[i].type==this.trimode && this.placeMarks[i].id==this.id) || (this.placeMarks[i].type==this.trimode && this.id==-1)) || (this.placeMarks[i].type==5 || this.placeMarks[i].type==6)){
				this.map.addOverlay(this.placeMarks[i].marker);
			}
			if(this.id!=-1 && (this.placeMarks[i].id==this.id && this.placeMarks[i].type==this.trimode)){
				googlemapAPI.gotoCoordszoomed(this.placeMarks[i].coords[0],this.placeMarks[i].coords[1],i);
			}
		}
	},
	
	addAllmarkerDefault:function(){
		for (var i=0;i<this.placeMarks.length;i++) {
			if(this.displayall==true){
				this.map.addOverlay(this.placeMarks[i].marker);
			}else if(this.placeMarks[i].type==-1 ||this.placeMarks[i].type==0 || this.placeMarks[i].type==5 || this.placeMarks[i].type==6){
				this.map.addOverlay(this.placeMarks[i].marker);
			}
		}
	},
	
	removeMM:function(){
		this.map.clearOverlays();
	},
	gotoCoords:function (lt,lg,offset) {
		$('resultdiv').hide();
		this.closeInfoHtmlZoomed();
 		this.placeMarks[offset].marker.openInfoWindowHtml(googlemapAPI.placeMarks[offset].marker.desc,  this.configInfoBulle);
	},
	gotoCoordszoomed:function (lt,lg,offset) {
		this.closeInfoHtmlZoomed();
		this.map.setZoom(16)
 		this.map.panTo(new GLatLng(lt,lg));
 		
 		setTimeout("googlemapAPI.placeMarks["+offset+"].marker.openInfoWindowHtml(googlemapAPI.placeMarks["+offset+"].marker.desc, googlemapAPI.configInfoBulle)",400);
	},
	gotoCoordsFichezoomed:function (id) {
 		for (var i=0;i<this.placeMarks.length;i++) {
	 		if(this.placeMarks[i].type==-1 && this.placeMarks[i].id==id){
		 		this.gotoCoordszoomed(this.placeMarks[i].coords[0],this.placeMarks[i].coords[1],i);
	 		}
 		}
	},
	gotoCoordsPlaceZoomed:function (id) {
 		for (var i=0;i<this.placeMarks.length;i++) {
	 		if(this.placeMarks[i].type!=-1 && this.placeMarks[i].id==id){
		 		this.gotoCoordszoomed(this.placeMarks[i].coords[0],this.placeMarks[i].coords[1],i);
	 		}
 		}
	},
	gotoCoordsFichezoomedAcces:function(lt,lg) {
		this.closeInfoHtmlZoomed();
		this.map.setZoom(20)
 		this.map.panTo(new GLatLng(lt,lg));
	},
	iti:function(from,to){
		for (var i=0;i<this.placeMarks.length;i++) {
			if(this.placeMarks[i].id==from[0] && this.placeMarks[i].type==from[1]){
				$('resultnamefrom').update( this.placeMarks[i].name);			
				start = new GLatLng(this.placeMarks[i].coords[0],this.placeMarks[i].coords[1]);
			}
			if(this.placeMarks[i].id==to[0] && this.placeMarks[i].type==to[1]){
				$('resultnameto').update( this.placeMarks[i].name);		
				end	= new GLatLng(this.placeMarks[i].coords[0],this.placeMarks[i].coords[1]);
			}
		}
		var pointsArray = [start,end];
        this.dirn.loadFromWaypoints(pointsArray,{travelMode:G_TRAVEL_MODE_WALKING,locale:localgooglemap}); 
	},
	tri:function(trimode,id){
		$('resultdiv').hide();
		this.removeMM();
 		this.trimode=trimode;
 		this.id=id;
 		this.updatemap();
 		this.defaultposition();
	},
	zoominit:function(){
		$('zoomminus').observe('click', 	this.zoomminus.bind(this));
 		$('zoomplus').observe('click', 		this.zoomplus.bind(this));
 		if (typeof G_NORMAL_MAP != 'undefined')
			$('zoomplan').observe('click', 		this.setMapType.bind(this,G_NORMAL_MAP));
		if (typeof G_SATELLITE_MAP != 'undefined')
			$('zoomsatellite').observe('click', this.setMapType.bind(this,G_SATELLITE_MAP));
      	if (typeof G_HYBRID_MAP != 'undefined')
			$('zoomrelief').observe('click', 	this.setMapType.bind(this,G_HYBRID_MAP));
		$('btns-reset').observe('click', function(){googlemapAPI.tri(0,-1);});	
		$('print').observe('click', 		this.printgoogle.bind(this));
	},
	
	zoomupdatejauge:function(){
		var pourcentage = Math.round(((this.map.getZoom()-this.zoommini)/(this.zoommaxi-this.zoommini))*100);
		$('zoomjauge').style.width=pourcentage+"%";
		if(this.map.getZoom()>this.zoommaxi)
			this.map.setZoom(this.zoommaxi);
	},
	
	zoomplus:function(){  
		if(this.zoommaxi>this.map.getZoom()) this.map.zoomIn();
	},
	zoomminus:function(){ 
		if(this.zoommini<this.map.getZoom()) this.map.zoomOut();
	},
	setMapType:function(mode){
		this.map.setMapType(mode);
	},
	printgoogle:function(){
		if($(this.trip).innerHTML!=""){
			var html = '<html>\n<head>\n';
			html += '\n</head>\n\n';
			html += '\n</body>\n\n';
			html += $(this.trip).innerHTML;
			html += '\n</body>\n</HTML>';
			
			var printWin = window.open("","printSpecial", "width=640,height=480,scrollbars=yes");
			printWin.document.open();
			printWin.document.write(html);
			
			printWin.print();
			//printWin.close();
		}

	},
	//----------------------------------------------------------------
	// Cluster 
	//--
	
	_filterIntersectingMapMarkers:function(){
		
		for (i=0;i<this.Cluster.length;i++) {
			
			this.map.removeOverlay(this.Cluster[i]);
		}
		var notToShow=new Array();
		var count=0,i, j, _isActive, mapMarkers, Bounds = this.map.getBounds();
		
		for (i=0;i<this.placeMarks.length;i++) { this.placeMarks[i].marker.show(); }
		for (i=0;i<this.placeMarks.length;i++) {
			
			mapMarkers = this.placeMarks[i].marker;
			
			var valideStars=true;
			if(this.trimode=="stars"){
				valideStars = ( this.placeMarks[i].stars==this.id && this.placeMarks[i].type==-1) ? true : false;
			}

			var savedMarkers = new Array();
			var _isActive  = Bounds.containsLatLng(mapMarkers.getLatLng()) ? true : false;
			if(_isActive && this.placeMarks[i].type==-1 && this.in_array(notToShow,this.placeMarks[i].marker)==false && valideStars==true){
				for (j=0;j<this.placeMarks.length;j++){
					_mapMarkers = this.placeMarks[j].marker;
					
					if (this.placeMarks[j].type==-1 && mapMarkers!=_mapMarkers && this.in_array(notToShow,this.placeMarks[j].marker)==false){
						_distance = Math.round(this.calculateRadius(mapMarkers.getLatLng(),_mapMarkers.getLatLng()));
						
						var _valideStars=true;
						if(this.trimode=="stars" && this.placeMarks[j].type==-1){
							_valideStars = ( this.placeMarks[j].stars==this.id && this.placeMarks[j].type==-1) ? true : false;
						}
						
						 if(_distance<30 & _valideStars==true) { 
							notToShow.push(_mapMarkers);
							this.placeMarks[j].marker.hide(); 
							savedMarkers.push(this.placeMarks[j].marker);
	 						count++;
	 					}
 					}
				}
 				if(savedMarkers.length>0){
	 				this.placeMarks[i].marker.hide(); 
					savedMarkers.push(this.placeMarks[i].marker);
					var info={
						name:this.placeMarks[i].name,
						markers:savedMarkers,
						latlong:this.placeMarks[i].marker.getLatLng()
					};
					markerInCluster = this.createGroupHotelMarker(info);
					this.Cluster.push(markerInCluster);
					this.map.addOverlay(markerInCluster);
 				}
		    }
		}
	},
	createGroupHotelMarker:function(info){
		var allshort 			= "";
		var Icon 				= new GIcon();
		Icon.iconSize 			= new GSize(28,26);
		Icon.iconAnchor 		= new GPoint(11, 25);
		Icon.infoWindowAnchor 	= new GPoint(7, 1);
		Icon.image				= "skins/img/hotel_n"+info.markers.length+".png";
		for (i=0;i<info.markers.length;i++) {
			allshort+=info.markers[i].shortdesc;
			info.markers[i].hide(); 
		}
		var _marker = new GMarker(info.latlong, {icon:Icon,zIndexProcess:importanceOrder});
		_marker.importance=200;
		_marker.allshort=allshort;
		GEvent.addListener(_marker, "click", this.openWindowGroupedHotel.bindAsEventListener(this,_marker));
		return _marker;
	},
	openWindowGroupedHotel:function(e,m){
		$('resultdiv').hide();
		this.map.closeInfoWindow();
		this.zoomupdatejauge();
		m.openInfoWindowHtml(m.allshort, {maxWidth:400,maxHeight:200,autoScroll:true,limitSizeToMap:true});
	},

	in_array:function(array,item){
		for(xx=0;xx<array.length;xx++){
			if(array[xx]==item){
				return true;
			}
		}
		return false;
	},
	calculateRadius:function(point1, point2) {
	    var point1 = this.map.fromLatLngToDivPixel(point1);
	    var point2 = this.map.fromLatLngToDivPixel(point2);
	    var radius = this.distanceFrom(point1,point2);
	    return radius;
	
	},
	distanceFrom:function(a2,a){
        var b=a2.x-a.x;
        var c=a2.y-a.y;
        return Math.sqrt(b*b+c*c)
	},
	foundHotelWidthId:function(id){
		var linked = this.getLinkedHotel(id);
		linked = linked.split(",");
		for (var i=0;i<this.placeMarks.length;i++) {
			for (var x=0;x<linked.length;x++) {
				var id = linked[x];
				var marker = this.placeMarks[i];
				if(marker.type==-1 && marker.id==id){
					this.map.addOverlay(this.placeMarks[i].marker);
				}
				
			}
		}

	},
	
	getLinkedHotel:function(id){
		for (var i=0;i<this.placeMarks.length;i++) {
			if(this.placeMarks[i].type!=-1 && this.placeMarks[i].id==id){
				this.map.addOverlay(this.placeMarks[i].marker);
				return this.placeMarks[i].linkedhotels;
			}
		}
	}


}

function importanceOrder (marker,b) {
	return GOverlay.getZIndex(marker.getPoint().lat()) + marker.importance*1000000;
}
