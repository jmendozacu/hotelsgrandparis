var id;
var currentRub;
var resaList;
var googleList;
var googleBtn;
var timeout;
var timeoutmap;
var currentDate = new Date();
var isIE6 = (navigator.appVersion.indexOf('MSIE 6')!=-1) ?true :false;
function NameDiv(id){
	if(document.all){ doc = document.all[id]; }
	if(document.getElementById){ doc = document.getElementById(id);}
	return doc;
}

function SetObjDisplay(id, prop){
	NameDiv(id);
	doc.style.display=prop;
}

function SetObjCss(id, cssName){
	NameDiv(id);
	doc.className=cssName;
}
//------------------
// Resa
//-- 

function Show(id) {
	stopTimer();
	if(resaList)
		$(resaList).style.visibility = 'hidden';
	for (var i = 1; i<=8; i++) {
		if ($('Layer'+i)) {
			$('Layer'+i).style.visibility = 'hidden';
		}
	}
	resaList=id;
	$(resaList).style.visibility = 'visible';
}
function stopTimer(){
	clearTimeout(timeout);
}
var objToClean;
function Hide(id,o) {
	if($(id)){
		$(id).style.visibility = 'hidden';
		if(o==true)
 			$(id).update("");
	}
}

function starthide (o){
	stopTimer();
	timeout = setTimeout("Hide('"+resaList+"','"+o+"');",300);
}

//------------------
// Googlemap Btn
//--
var oldNavON = "";
var navButtons = new Array();
function Showssrub(id,objrub) {
	stopTimerMap();
	if(googleBtn)
		$(googleBtn).className="";
	for (var i = 1; i<=5; i++) {
		if ($('SSrub'+i)) {
			$('SSrub'+i).style.visibility = 'hidden';
			$('Rub'+i).className="";
			oldNavON = "";
		}
	}
	if ($(id)) {
		$(id).style.visibility = 'visible';
		googleList=id;
		googleBtn=objrub.id;
		var check = $$('.simpleTpl');
		if(check.length>0) {
			var top = Position.cumulativeOffset(objrub)[1] - 124;			
			if (top>200) {
				top = top - $(id).offsetHeight - 29;
				if (isIE6) {
					top += 5;
				}
			}
			objrub.className = "on";
			oldNavON = objrub;
			Element.setStyle($(id).parentNode,{ 
				top: top + 'px'				
			});
		}

		else {

			$(objrub.id).className="on";
			oldNavON = $(objrub.id);
			
		}

		

	}

}

function RollBotRub (id,o) {
	var check = $$('.simpleTpl');
	if(check.length>0) {
		var top = Position.cumulativeOffset(oldNavON)[1] - 124;			
		if (top>200) {
			if (oldNavON!="") {
				if (!navButtons[id.charAt(id.length-1)]) {
					navButtons[id.charAt(id.length-1)] = Element.getStyle(oldNavON,'backgroundImage');
				}
				oldNavON.setStyle({ backgroundImage:'none' });
			}
		}
	}
}

function HideList(){

	if($(googleList)) $(googleList).style.visibility = 'hidden';

	if($(googleBtn)) $(googleBtn).className="";
	
	var id = oldNavON.id;
	if (navButtons[id.charAt(id.length-1)]&&oldNavON) {
		oldNavON.setStyle({ backgroundImage:navButtons[id.charAt(id.length-1)] });
	}
}



function stopTimerMap(){

	clearTimeout(timeoutmap);

}



function starthideMap (){

	stopTimer();

	timeoutmap = setTimeout("HideList('"+googleList+"');",300);

}



//------------------

// Calendrier

//--



var currentInputCalendar;

var currentListInputCalendar;



function getCalendrier (o,n){

	currentInputCalendar=o;

	currentListInputCalendar="Layer"+n;

	var month = currentDate.getMonth()+1;

	if(month<10){

		month = "0"+month.toString();

	}

	setDateCalendar(month,currentDate.getFullYear());

}



function setDateCalendar(month,year){

	new Ajax.Request('includes/php/class.calendrier.php', {

		parameters:{month:month,year:year},

		onComplete: function(e){

			$(currentListInputCalendar).update(e.responseText);
			
		}

	});

}

function selectdate(v){
	if(uk_date==true){
		v=v.split("/").reverse();
		v=v.join("/");
	}
	currentInputCalendar.innerHTML=v;
	fastresa.updateDate();
	Hide(currentListInputCalendar,true);
}

//------------------
// Newsletter
//--

var oldvalue = null;
function focusnewsletter(obj){
	if(oldvalue==null){
		oldvalue=obj.value;
		obj.value="";
	}else if(obj.value==""){
		obj.value=oldvalue;
		oldvalue=null;
	}
}

function checkletter(){
	var email = $('email').value;
	if(email ==""){
		_alert(messageAlertEmail);
		return false;
	 }else if(checkemail(email)==false){
		 _alert(messageAlertEmailInvalid);
		return false;	
	}else{
		return true;	
	}
}

function checkemail(str){
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(str)){
		return true;
	}else{
		return false;
	}
}

var subContentNav = Class.create({
	initialize: function (tabopen) {
		this._oldId = -1;
		this._idLabel = 'contentSubSwitch';
		this._content = new Array();
		var tabopenOffset=null;
		if($(this._idLabel)) {
			this._content = $$('#'+this._idLabel+' .cont');
			for (var i=0;i<this._content.length;i++) {
				this._setEvents(i);	
				var divitem = this._setEvents(i);	
				if(tabopen && divitem.id==tabopen){
					tabopenOffset=i;
				}
			}
			this.view(0,0);
		}
		if ($('servicesMenuSimple')) {
			var btn = $$('#servicesMenuSimple a')[0];
			var view = $$('#servicesMenuSimple p')[0];
			Event.observe(btn,'mouseover',this.viewMenuSimple.bind(this,view,'visible'));
			Event.observe(btn,'mouseout',this.viewMenuSimple.bind(this,view,'hidden'));
			Event.observe(view,'mouseover',this.viewMenuSimple.bind(this,view,'visible'));
			Event.observe(view,'mouseout',this.viewMenuSimple.bind(this,view,'hidden'));
		}
		if(tabopen && tabopenOffset!=null)
			this.view(tabopenOffset);
	},
	directTabView:function(tab){
		for (var i=0;i<this._content.length;i++) {
			this._setEvents(i);	
			var divitem = this._setEvents(i);	
			if(tab && divitem.id==tab){
				tabopenOffset=i;
			}
		}
		this.view(tabopenOffset);
	},
	_setEvents: function (id) {
		var a = this._content[id].parentNode.getElementsByTagName('a')[0];
		Event.observe(a,'click',this.view.bind(this,id));
		return this._content[id];
	},
	view: function (id) {
		if (this._oldId!=id) {
			if (this._oldId!=-1) {
				var a = this._content[this._oldId].parentNode.getElementsByTagName('a')[0];
				Element.removeClassName(a.parentNode,'on');
				this._content[this._oldId].setStyle({ display:'none' });
			}
			var a = this._content[id].parentNode.getElementsByTagName('a')[0];
			Element.addClassName(a.parentNode,'on');		
			this._content[id].setStyle({ display:'block' });
			$(this._idLabel).setStyle({ height:this._content[id].offsetHeight+26+'px' });
			this._oldId = id;
		}
	},
	viewMenuSimple: function (view,visibility) {
		view.setStyle({ visibility:visibility });
	}
});



var ContentSwitcher = Class.create({
	initialize: function (id,label) {
		this._id = id;
		this._label = label;
		this._hasSwitch = $$("#"+id+" .viewMoreContent");
		this._oldOpen = -1;
		for (var i=0;i<this._hasSwitch.length;i++) {
			this._hasSwitch[i].parentNode.parentNode.parentNode.id = id + i;
			Event.observe(this._hasSwitch[i],'click',this.view.bind(this,i));
		}
	},
	view: function (id) {
		var toViewText =  $$("#"+this._id+id+" .boxInfosDynMore")[0];
		var toViewRight =  $$("#"+this._id+id+" .moreText")[0];
		toViewText.setStyle({ display:"block" });
		toViewRight.setStyle({ display:"block" });
		this._hasSwitch[id].innerHTML = this._label.less;
		var autoHack = $$('.itemsToBot');
		if (autoHack.length>0) {
			autoHack[0].setStyle({ bottom:'auto' });
		}
		if (this._oldOpen!=-1) {
			var toViewText =  $$("#"+this._id+this._oldOpen+" .boxInfosDynMore")[0];
			var toViewRight =  $$("#"+this._id+this._oldOpen+" .moreText")[0];
			toViewText.setStyle({ display:"none" });
			toViewRight.setStyle({ display:"none" });
			this._hasSwitch[this._oldOpen].innerHTML = this._label.more;
		}
		this._oldOpen = (this._oldOpen!=id) ?id :-1;
	}
});

function voirChambre (o) {
	/ * TO TEST */
	$('contentHtmlPop').setStyle({ display:'block' });
}

var myPopHtml;
var o = this;
// function viewPopRooms () {
// 	myPopHtml = new PopHtml("Rooms",$("myHtmlPop"),"templates/popup/rooms.tpl","POST",{},o.eventsPopHtml);
// }
function viewPopRooms (service,a,b) {
	if(a && b){
		myPopHtml = new PopHtml("popup",$("myHtmlPop"),service,"POST",{id1:a,id2:b},o.eventsPopHtml);
	}else if(a){
		myPopHtml = new PopHtml("popup",$("myHtmlPop"),service,"POST",{id1:a},o.eventsPopHtml);
	}else{
		myPopHtml = new PopHtml("popup",$("myHtmlPop"),service,"POST",{},o.eventsPopHtml);
	}
}

function _alert(msg){
	myPopHtml = new PopHtml("popup",$("myHtmlPop"),"includes/php/alert.php","POST",{msg:msg},o.eventsPopHtml);
}


function displayImage(image){
	myPopHtml = new PopHtml("popup",$("myHtmlPop"),"includes/php/imageviewer.php","POST",{image:image});
}

function viewVideoPopRooms (service,a,b) {
	myPopHtml = new PopHtml("popup",$("myHtmlPop"),service,"POST",{id1:a,id2:b},o.eventsPopHtmlFlv);
}

function updateVideoGalerie(i,s,o){
	$$('.popStyle ol li').each(function(ob){ ob.className=""; }); // Reset Btn
	o.addClassName("on");
	$('titleGalerie').update(s);
	$('imageDisplay').update("&nbsp;");
	var s2 = new SWFObject("skins/swf/flvplayer.swf","imageDisplay","432","332","9");
	s2.addParam("allowfullscreen","true");
	s2.addVariable("file","../../"+i);
	s2.addVariable("autostart","true");
	s2.useExpressInstall("skins/swf/expressinstall.swf");
	s2.write("imageDisplay");
}

function eventsPopHtmlFlv (event,name) {
	if (event=="onReady") {
		$$('.popStyle ol li').each(function(ob){ 
			ob.observe('click',function(){
				var fileName 	= this.down(0).down(0).src.replace("96x86","496x394");
				fileName 		= fileName.replace(".jpg",".flv");
				var posCrop		= fileName.indexOf("data/");
				fileName		= fileName.substr(posCrop,fileName.length);
				updateVideoGalerie(fileName,this.down(0).down(0).alt,this);	
			});		
		});
	}
}


function updateImageGalerie(i,s,o){
	$$('.popStyle ol li').each(function(ob){ ob.className=""; }); // Reset Btn
	o.addClassName("on");
	$('titleGalerie').update(s);
    $('imageDisplay').src=i;
}

function eventsPopHtml (event,name) {
	if (event=="onReady") {
		$$('.popStyle ol li').each(function(ob){ 
			ob.observe('click',function(){
				updateImageGalerie(this.down(0).down(0).src.replace("96x86","496x394"),this.down(0).down(0).alt,this);	
			});		
		});
	}
}



function comingSoon(lg){

	if(lg=="en"){

		_alert("We are currently translating our web portal into your langage.\nPlease come back soon and book your room in Paris in english/american");

	}else if(lg=="sp"){

		_alert("We are currently translating our web portal into your langage.\nPlease come back soon and book your room in Paris in spanish");

	}else if(lg=="de"){

		_alert("We are currently translating our web portal into your langage.\nPlease come back soon and book your room in Paris in german");

	}

}

Event.observe(window,"load",function(){
	
	var hackTxt = $$('.simpleTplWho');
	if (hackTxt.length>0) {
		var hack = $$('.topText');
		if (hack.length>0) {
			var content = new Array();
			content = hack[0].innerHTML.split('<br><br>');
			if (content.length==1) {
				content = hack[0].innerHTML.split('<BR><BR>');
			}
			var str = '';
			for (var i=0;i<content.length;i++) {
				if (i>2) {
					str += content[i];
				}
				else {
					str += '<span class="small">' + content[i] + '</span>';
				}
				if (i<content.length-1) {
					str += '<br /><br />';
				}
			}
			hack[0].innerHTML = str;
		}
	}
	
});

function setPositionFrom(from,to,position){
	var dimensions 	= $(from).getDimensions();
	var positions	= $(from).positionedOffset();
	var topositions	= $(to).getDimensions();
	if(position=='right'){
		$(to).setStyle({
			left:(positions[0]+dimensions.width-topositions.width)+"px"
		});
	}else if(position=='left'){
		$(to).setStyle({
			left:positions[0]+"px"
		});
	}
}