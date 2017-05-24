var fastbooking=new Array();
var fastbooking = Class.create();
fastbooking.prototype = {
	initialize: function(lg) {
		this.place=null;
		this.placeCode=null;
		this.bedroom=0;
		this.nights=0;
		this.adults=0;
		this.children=0;
		this.fromdate="//";
		this.fromdateObj=null;
		this.todate="//";
		this.todateObj=null;
		this.langue=lg;
		this._defaultValue();	
		
	},
	_defaultValue:function(){
		var today 	= new Date();
		var d 		= today.getDate();
		var m 		= today.getMonth()+1;
		var y 		= today.getFullYear();
		
		if(d<10)
			d = "0"+d.toString();
		if(m<10)
			m = "0"+m.toString();
		
		$('inputdatefrom').innerHTML= (uk_date==true) ? y+"/"+m+"/"+d : d+"/"+m+"/"+y;
		
		this.bedroom=1;
		$('inputlayer5').update(1);
		this.adults=1;
		this.updateDate();
		$('inputlayer7').update(1);
		this.setNights(1);
	},
	
	setPlace:function(v,f,o){
		this.place=v;
		
		this.placeCode=(v==-1) ? null : f;
		
		Hide('Layer1',false);
		if(o){
			$('inputlayer1').update(o.innerHTML);
		}
		$('inputlayer2').update(allHotelEmptyName);
		
		new Ajax.Request('includes/php/hotel.resa.php', {
			parameters:{id:v},
			onComplete: this.updateHotel.bind(this)
		});
	},
	updateDate:function(){
		this.fromdate=this.getDate('inputdatefrom');
		var fdate = this.fromdate.split("/");
		this.fromdateObj 	= new Date(fdate[2]+"/"+fdate[1]+"/"+fdate[0]);
		
		if(String(this.todate)==String(this.getDate('inputdateto'))){
			this.updateJourStartWithNight();
		}else{
			this.todate=this.getDate('inputdateto');
			var tdate 		= this.todate.split("/");	
			this.todateObj 	= new Date(tdate[2]+"/"+(tdate[1])+"/"+tdate[0]);
			
			this.setNights((this.fCompareDate(this.fromdateObj,this.todateObj)));
			if($(currentListInputCalendar) && $(currentListInputCalendar).id == 'Layer3' && this.todate==datedefault){
				this.updateJourStartWithNight();
			}
		}
	},
	
	getDate:function(d){
		var v = $(d).innerHTML;
		if(uk_date==true){
			v=v.split("/").reverse();
			v=v.join("/");
		}
		return v;
	},
	
	updateHotel:function(e){
		$('Layer2').update(e.responseText);
		
		this.hotelfastbooking=null;
		this.hotel=null;
	},
	setHotel:function(v,o,f){
		this.hotelfastbooking=(v==-1) ? null : f;
		this.hotel=v;
		Hide('Layer2',false);
		$('inputlayer2').update(o.innerHTML);
	},
	setHotelAndReserve:function(v,s,f){
		this.hotelfastbooking=(v==-1) ? null : f;
		this.hotel=v;
		Hide('Layer2',false);
		$('inputlayer2').update(s);
		this.submitResa();
	},
	setBedrooms:function(v,o){
		this.bedroom=v;
		Hide('Layer5',false);
		$('inputlayer5').update(o.innerHTML);
	},
	updateJourStartWithNight:function(){
		if(this.fromdateObj){
			var datedepart 	= this.fromdateObj.getTime();
			var datearrivee = new Date(this.fromdateObj.getFullYear()+"/"+(this.fromdateObj.getMonth()+1)+"/"+this.fromdateObj.getDate());
			
			datearrivee.setDate(datearrivee.getDate()+this.nights);
			
			this.todateObj 	= new Date(datearrivee);
			var d = this.todateObj.getDate();
			var m = this.todateObj.getMonth()+1;
			var y = this.todateObj.getFullYear();
			
			if(d<10)
				d = "0"+d.toString();
			if(m<10)
				m = "0"+m.toString();
			
			this.todate = (uk_date==true) ? y+"/"+m+"/"+d : d+"/"+m+"/"+y;
			
			$('inputdateto').update(this.todate);
		}
	},
	setNights:function(v,o){
		this.nights=v;
		Hide('Layer6',false);
		$('inputlayer6').update(v);
		this.updateJourStartWithNight();
	},
	setAdults:function(v,o){
		this.adults=v;
		Hide('Layer7',false);
		$('inputlayer7').update(o.innerHTML);
	},
	setChildren:function(v,o){
		this.children=v;
		Hide('Layer8',false);
		$('inputlayer8').update(o.innerHTML);
	},
	submitResa:function(){
		var fdate  = this.fromdate.split("/");
		var tdate  = this.todate.split("/");	
		var allVar = new Array();
		
		if(this.placeCode!=null){
			this.placeCode=this.placeCode.replace("'","\\'");
			allVar.push("region="+this.placeCode);
		}
		
		if(this.hotelfastbooking!=null){
			allVar.push("Clusternames="+this.hotelfastbooking);
			allVar.push("Hotelnames="+this.hotelfastbooking);
		}else{
			allVar.push("Clusternames=frparishcapital");
			allVar.push("Hotelnames=All");
		}
		
		if(fdate[0]!=""){
			allVar.push("fromday="+fdate[0]);
			allVar.push("frommonth="+fdate[1]);
			allVar.push("fromyear="+fdate[2]);
		}
		if(tdate[0]!=""){
			allVar.push("today="+tdate[0]);
			allVar.push("tomonth="+tdate[1]);
			allVar.push("toyear="+tdate[2]);
		}
		if(this.nights!=0)
			allVar.push("nbdays="+this.nights);
		if(this.adulteresa!=0)
			allVar.push("adulteresa="+this.adults);
		if(this.enfantresa!=0)
		allVar.push("enfantresa="+this.children);
		
		allVar.push("showPromotions=3");
		allVar.push("langue="+this.langue);
		allVar.push("rt=1222469286");
		allVar.push("redir=BIZ-so5523q0o4");
		
		//if(this.placeCode==null && this.hotelfastbooking==null){
		//	var waction = "http://216.109.148.45/00000001/032/023112/presearchv2.phtml?clusterName=frparishcapital&redir=BIZ&rt=1223594278&langue="+this.langue;
		//}else{

		// var waction = "http://216.109.148.45/00000001/032/023112/dispopricev2.phtml?"+allVar.join("&");
		
		var waction = "http://66.70.56.90/00000001/032/023112/dispopricev2.phtml?"+allVar.join("&");
			
		//}
		
		
		openresa(waction);
	},
	
	fCompareDate:function (pDateDebut,pDateFin) {
		var time = (pDateFin.getTime()-pDateDebut.getTime());
		if(isNaN(time)){
			return 0;
		}else if(time<=0){
			return 0;
		}else{
			var MILLISECONDS_PER_DAY = 1000 * 60 * 60 * 24; 
			var delta = Math.round((time / (MILLISECONDS_PER_DAY)));
			return delta;
		}
	},
	reserveHotel:function(hotel){
		var allVar = new Array();
		
		allVar.push("clusterName=frparishcapital");
		allVar.push("redir=BIZ");
		allVar.push("rt=1223594278");
		allVar.push("langue="+this.langue);
		allVar.push("clusterName="+hotel);
		//var waction = "http://216.109.148.45/00000001/032/023112/presearchv2.phtml?"+allVar.join("&");
		var waction = "http://66.70.56.90/00000001/032/023112/presearchv2.phtml?"+allVar.join("&");
		openresa(waction);
	}
	
}

function openresa(url){
	window.open(url,"reservation","toolbar=no,width=400,height=350,menubar=no,scrollbars=yes,resizable=yes,alwaysRaised=yes");
}




