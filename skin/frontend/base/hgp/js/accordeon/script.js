var TINY={};

function Tsgl(i){return document.getElementById(i)}
function Tdbl(e,p){return p.getElementsByTagName(e)}

TINY.accordion=function(){
	function slider(n){this.n=n; this.a=[];}
	slider.prototype.init=function(t,e,m,o,k,z,w){
		var a=Tsgl(t), i=s=0, n=a.childNodes, l=n.length; this.s=k||0; this.m=m||0;
		for(i;i<l;i++){
			var v=n[i];
			if(v.nodeType!=3){
				this.a[s]={}; this.a[s].h=h=Tdbl(e,v)[0]; this.a[s].c=c=Tdbl('div',v)[0]; h.onclick=new Function(this.n+'.pr(0,'+s+',\''+z+'\',\''+w+'\')');
				
				if(o==s){										
					h.className=this.s; 
					c.style.height='auto'; 
					c.d=1;
					}else{
						c.style.height=0; 
						c.d=-1;
					} s++
			}
		}
		this.l=s
	};
	slider.prototype.pr=function(f,d,z,w){
		
		for(var i=0;i<this.l;i++){
			var h=this.a[i].h, c=this.a[i].c, k=c.style.height; k=k=='auto'?1:parseInt(k); clearInterval(c.t);			

			//Quand k==0 la div est repliee donc on affiche la mini et vice versa
			if (k){
				document.getElementById(z).style.display = "block";
				document.getElementById(w).innerHTML = "&nbsp;&gt;&nbsp;Liste compl&egrave;te";
			} else {
				document.getElementById(z).style.display = "none";
				document.getElementById(w).innerHTML = "&nbsp;&gt;&nbsp;Liste r&eacute;duite";			
			}
			
			if((k!=1&&c.d==-1)&&(f==1||i==d)){
				c.style.height=''; c.m=c.offsetHeight; c.style.height=k+'px'; c.d=1; h.className=this.s; su(c,1)
			}else if(k>0&&(f==-1||this.m||i==d)){
				c.d=-1; h.className=''; su(c,-1)
			}
		}
	};
	function su(c){c.t=setInterval(function(){sl(c)},20)};
	function sl(c){
		var h=c.offsetHeight, d=c.d==1?c.m-h:h; c.style.height=h+(Math.ceil(d/5)*c.d)+'px';
		c.style.opacity=h/c.m; c.style.filter='alpha(opacity='+h*100/c.m+')';
		if((c.d==1&&h>=c.m)||(c.d!=1&&h==1)){if(c.d==1){c.style.height='auto'} clearInterval(c.t)}
	};
	return{slider:slider}
}();