<script type="text/javascript">
		
	function openresaAP(url){
		window.open(url,"reservation","toolbar=no,width=724,height=350,menubar=no,scrollbars=yes,resizable=yes,alwaysRaised=yes");
	}

		var objs_list = new Object();
	
		// initial delta from 
		var g_offset_x = 32;
		var g_offset_y = -16;
		
		//
		// calcPos
		function calcPos(obj) {
			this.x = g_offset_x;
			this.y = g_offset_y;
			if(obj) {
				//obj
				if (obj.offsetParent) {
					this.x += obj.offsetLeft;
					this.y += obj.offsetTop;
					while (obj = obj.offsetParent) {
						this.x += obj.offsetLeft;
						this.y += obj.offsetTop;
					}
				}
			}
		}
	
		//
		// get a property for an element given its id
		function getIdProperty(id, property) {
		
			var styleObject = document.getElementById(id);
			if (styleObject != null)
			{
				styleObject = styleObject.style;
				if(styleObject[property])
					return styleObject[property];
			}
			return null;
		
		}
		
		//
		// set a property to an element given its id
		function setIdProperty( id, property, value )
		{
			var styleObject = document.getElementById(id);
			if (styleObject != null)
			{
				styleObjectStyle = styleObject.style;
				if(styleObjectStyle[property]) {
					styleObjectStyle[property] = value;
				}
			}
		
		}
		
		//
		// show the calc
		function doShowCalc() {
			if(getIdProperty("calc", "display") != 'block')
				setIdProperty("calc", "display", "block");
		}
		
		//
		// hide the calc
		function doHideCalc() {
			if(getIdProperty("calc", "display") == 'block')
				setIdProperty("calc", "display", "none");
		}
		
		//
		// function to display a calc
		function show_text(a_event, a_elt, a_text, a_class) {
			a_point = new calcPos(a_elt);
			delta_y = a_point.y;
			setIdProperty("calc", "top", delta_y + "px");
			delta_x = a_point.x;
			delta_x += a_elt.clientWidth;
			setIdProperty("calc", "left", delta_x + "px");
			if(a_class != undefined) {
				obj = document.getElementById("calc");
				obj.className = a_class;
			}
			
			doShowCalc();
			
			document.getElementById("calc").innerHTML = a_text;
		}
		
		//
		// function to hide a calc
		function hide_text() {
			doHideCalc();
		}
		
		//************************************************
		// TABLEAU DES HOTELS	
		arrHotel = new Array(10);//[CodeResa+++++NomHotel+++++CapaciteMaxChambre+++++CapaciteMaxAdult+++++CapaciteMaxChildren]
		arrRegion = new Array(5);

		arrHotel[1] = new Array( 
								"1|<?php echo $this->__('Tous')?>|0|0|0",
								"FRPMercedes|<?php echo $this->__('Hotel Mercedes')?>***|4|3|3",
								"SVFRHTLEPark|<?php echo $this->__('Hotel Elysee Park')?>***|2|2|1", 
								"FRPHCHTLMathis|<?php echo $this->__('Hotel Mathis Elysees')?>****|2|2|1",
								"FRPHCHTLMarigny|<?php echo $this->__('Hotel Opera Marigny')?>|2|2|2", 
								"FRPHCHTLTonic|<?php echo $this->__('Hotel Alexandrie')?>***|5|4|3", 
								"FRPHCHTLMMahon|<?php echo $this->__('Residence Mac Mahon')?>|2|2|2", 
								"FRPHCHTLOpal|<?php echo $this->__('Best Western Premier Opal')?>****|4|2|2", 
								"FRPHCHTLODiamond|<?php echo $this->__('Best Western Premier Opera Diamond')?>****|2|2|0",
								"FRPHCHTLBretagne|<?php echo $this->__('Best Western Bretagne Montparnasse')?>***|5|4|3",
								"FRPHCHTLGDLyon|<?php echo $this->__('Paris Hotel Gare de Lyon')?>**|3|2|1",
								"FRPHCHTLEiffel|<?php echo $this->__('Hotel Eiffel Kennedy')?>***|2|2|0",
								"FRPHCHTLAurore|<?php echo $this->__('Hotel Best Western Aurore')?>***|4|4|2",
								"SVFRHTLSevresmont|<?php echo $this->__('Hotel Sevres Montparnasse')?>**|3|3|1",
								"FRPHCHTLSTLouvre|<?php echo $this->__('Best Western Premier Louvre Saint Honore')?>****|3|2|1",
								"FRPHCHTLDeneuville|<?php echo $this->__('Hotel de Neuville')?>***|2|2|1",
								"FRPHCHTLStlouis|<?php echo $this->__('Best Western St Louis')?>***|2|2|0",
								"FRMMahon|<?php echo $this->__('Hotel Mac Mahon')?>***|3|3|0",
								"FRPHCHTLDDBourgogne|<?php echo $this->__('Best Western aux Ducs de Bourgogne')?>***|2|2|0",
								"FRPHCHTLFEurope|<?php echo $this->__('Best Western France Europe')?>***|3|2|2",
								"FRPHCHTLChamps|<?php echo $this->__('Hotel des Champs Elysees')?>****|4|4|2",
								"SVFRHTLSevresmont|<?php echo $this->__('Hotel Sevres Montparnasse')?>**|3|3|1"
								);
		
		arrHotel[2] = new Array( 
								"2|<?php echo $this->__('Tous')?>|0|0|0",
								"FRPHCHTLDDBourgogne|<?php echo $this->__('Best Western aux Ducs de Bourgogne')?>***|2|2|0",
								"FRPHCHTLSTLouvre|<?php echo $this->__('Best Western Premier Louvre Saint Honore')?>****|3|2|1",								
								"FRPHCHTLFEurope|<?php echo $this->__('Best Western France Europe')?>***|3|2|2"
								);
		
		arrHotel[3] = new Array( 			
								"3|<?php echo $this->__('Tous')?>|0|0|0",
								"FRPHCHTLODiamond|<?php echo $this->__('Best Western Premier Opera Diamond')?>****|2|2|0",
								"FRPHCHTLOpal|<?php echo $this->__('Best Western Premier Opal')?>****|4|2|2",
								"FRPHCHTLMarigny|<?php echo $this->__('Hotel Opera Marigny')?>|2|2|2"
								);
		
		arrHotel[4] = new Array( 			
								"4|<?php echo $this->__('Tous')?>|0|0|0",
								"FRPHCHTLMathis|<?php echo $this->__('Hotel Mathis Elysees')?>****|2|2|1",
								"FRMMahon|<?php echo $this->__('Hotel Mac Mahon')?>***|3|3|0",
								"SVFRHTLEPark|<?php echo $this->__('Hotel Elysee Park')?>***|2|2|1",
								"FRPHCHTLMMahon|<?php echo $this->__('Residence Mac Mahon')?>|2|2|2",
								"FRPHCHTLChamps|<?php echo $this->__('Hotel des Champs Elysees')?>****|4|4|2"
								);
	    
		arrHotel[5] = new Array( 			
								"5|<?php echo $this->__('Tous')?>|0|0|0",
								"FRPMercedes|<?php echo $this->__('Hotel Mercedes')?>***|4|3|3",
								"FRPHCHTLDeneuville|<?php echo $this->__('Hotel de Neuville')?>***|2|2|1"
								);
		
		arrHotel[6] = new Array( 			
								"6|<?php echo $this->__('Tous')?>|0|0|0",
								"FRPHCHTLBretagne|<?php echo $this->__('Best Western Bretagne Montparnasse')?>***|5|4|3",
								"SVFRHTLSevresmont|<?php echo $this->__('Hotel Sevres Montparnasse')?>**|3|3|1"
								);
		
		arrHotel[7] = new Array( 			
								"7|<?php echo $this->__('Tous')?>|0|0|0",
								"FRPHCHTLGDLyon|<?php echo $this->__('Paris Hotel Gare de Lyon')?>**|3|2|1",
								"FRPHCHTLTonic|<?php echo $this->__('Hotel Alexandrie')?>***|5|4|3",
								"FRPHCHTLAurore|<?php echo $this->__('Hotel Best Western Aurore')?>***|4|4|2"
								);
		
		arrHotel[8] = new Array( 			
								"FRPHCHTLEiffel|<?php echo $this->__('Hotel Eiffel Kennedy')?>***|2|2|0"
								);
		
		arrHotel[9] = new Array( 			
								"FRPHCHTLStlouis|<?php echo $this->__('Best Western St Louis')?>***|2|2|0"
								);
		
		arrHotel[10] = new Array( 			
								"FRVALHTLMediagar|<?php echo $this->__('Hotel & Restaurant Media Garden')?>***|4|4|2"
								);

		arrRegion = new Array(
								"",
								"",
								"Louvre, Rivoli & Marais",
								"Opera, Madeleine & St Lazare",
								"Champs Elysees & Arc de Triomphe",
								"Wagram & Parc Monceau",
								"Montparnasse-St Germain des Pres",
								"Gare de Lyon & Bastille"
							  );
		
		//************************************************
		// AFFICHE LA LISTE DES HOTELS EN FONCTION DE LA VILLE SELECTIONNE

		function ChangeHotel() 
		{

			var aux = 0;
			var  reg=new  RegExp("[|]+", "g");
			aux = (document.idForm.ville.selectedIndex) ? document.idForm.ville.selectedIndex:0;

			//console.log("AUX vaut ==> %d", aux);
			//console.log("arrHotel vaut ==> %s", arrHotel);

			if (typeof(arrHotel[aux]) != "undefined") {
				tailleArr = arrHotel[aux].length;
			}else{
				tailleArr = 0;
			}

			if (aux==0){
				document.idForm.HotelList.options[0] = new Option('<?php echo $this->__('Select your hotel')?>', 0, true, true);
				document.idForm.HotelList.length = 1;
			}		
			
			if ((navigator.appVersion.indexOf("MSIE 3") <= 0) && (arrHotel[aux])) {
				for (var i=0;i<arrHotel[aux].length;i++) {
					var chaine = arrHotel[aux][i];
					var tableau=chaine.split(reg);
					var ligne2 = new Option(tableau[1], tableau[0]+'|'+tableau[2]+'|'+tableau[3]+'|'+tableau[4], false, false);
					document.idForm.HotelList.options[i] = ligne2;
				}
				document.idForm.HotelList.length = tailleArr;
			}
            
            UpdateAdult();
		}

		//************************************************
		// Affichage du nombre d'adultes

		function UpdateAdult() 
		{
            var values = decoupeValue(hotelCombo.value);
            var maxAdult = parseInt(values[2]);

            //console.log('maxAdult %s', maxAdult);
            //console.log('values %s', values);

            //On masque la combox Hotel si vide
            if(hotelCombo.value==0){
            	//hotelCombo.style.display = "none";
            	hotelCombo.style.backgroundColor = "#c4c4c4";
            	hotelCombo.style.color = "#a2a2a2";
            	hotelCombo.visible = false;
            }else{
            	//hotelCombo.style.display = "block";
            	hotelCombo.style.backgroundColor = "#fff";
            	hotelCombo.style.color = "#333";
            	hotelCombo.visible = true;
            }
            
			adultCombo.length = 0; // detruire les options
			for(i=1;i<=maxAdult;i++){
				adultCombo.options[(i - 1)] = new Option([i], [i], false, false);
				//console.log('test %s', (i - 1));				
			}
			
			// update childs
			UpdateChild();
			
			// update BookingEngine
			updateBookingEngine();
		}
		
		//************************************************
		// Recuperation des values

		function decoupeValue(maValeur) 
		{	
            var defaultValue = ["", 6, 4, 2]; // name, max, adults, childs
            var reg          = new  RegExp("[0-9][|]0[|]0[|]0","g");
            var regex        = new  RegExp("[|]+", "g");

            //console.log("Ma valeur ==> %s", maValeur);
            
			//Si on ne prend rien, on retourne la valeur par defaut
            if (0 == maValeur) {
                 return defaultValue;
            }
            
            //Si on une region, on retourne la valeur par defaut
            if (reg.test(maValeur)) {
				//alert(reg);
                return defaultValue;
            }

			return maValeur.split(regex);
		}

		//************************************************
		// Affichage du nombre d'enfants
		
		function UpdateChild() 
		{
            var values = decoupeValue(hotelCombo.value);
            var maxCapacity = parseInt(values[1]);
            var nbAdult = adultCombo.value;
            var maxChildren = parseInt(values[3]);
            
			childCombo.length = 0; // detruire les options

			var NewMax = (maxCapacity - nbAdult);
			NewMax = (NewMax >= maxChildren) ? maxChildren : NewMax;
			// 0 value
			childCombo.options[0] = new Option(0, 0, false, false);

			for(i=1;i<=NewMax;i++){
				childCombo.options[i] = new Option([i], [i], false, false);
			}
		}
				
		//************************************************
		// Mise a jour du code Booking Engine
		
		function updateBookingEngine()
		{			
			
			tableau     = Array();
			reg         = new  RegExp("[|]+", "g");
			maNewChaine = hotelCombo.value;
			tableau     = maNewChaine.split(reg);
			var reg     = new  RegExp("[0-9][|]0[|]0[|]0","g");

			if(tableau[0] != "undefined"){
				
				if(tableau[0] == HotelOP_Ap){
					openresaAP('http://www.secure-hotel-booking.com/Opera-Batignolles/2MBN/search?property=' + HotelOP_Ap);
					return true;
				}
				
				if(tableau[0] == HotelNi_MG){
					document.idForm.Clusternames.value = document.idForm.Hotelnames.value = encodeURIComponent(HotelNi_MG);
					return true;
				}

				if ((reg.test(maNewChaine)) && (!isNaN(tableau[0]))){ 
	                document.idForm.region.value = encodeURIComponent(arrRegion[tableau[0]]);
	                document.idForm.Hotelnames.value = 'All';
	            }else{					
					document.idForm.Hotelnames.value = (tableau[0] != 0) ? tableau[0]:'All';
	            }
				document.idForm.Clusternames.value = encodeURIComponent('crsfrparishcapital');
				return true;

				/**
				* Debuguages
				*/
				//console.log("Clusternames ==> %s", decodeURIComponent(document.idForm.Clusternames.value));
				//console.log("Region ==> %s", decodeURIComponent(document.idForm.region.value));
				//console.log("Hotelnames ==> %s", decodeURIComponent(document.idForm.Hotelnames.value));
			}
		}



		//************************************************
		// Initialisation des variables
		
        var hotelCombo = null;
        var adultCombo = null;
        var childCombo = null;
        var HotelOP_Ap = 10410;
        var HotelNi_MG = "FRVALHTLMediagar";

        function initBooking()
        {
            hotelCombo = document.getElementById("HotelList");
            adultCombo = document.getElementById("adulteresa");
            childCombo = document.getElementById("enfantresa");

            document.idForm.Clusternames.value = encodeURIComponent('crsfrparishcapital');
            document.idForm.Hotelnames.value = 'All';
            document.idForm.region.value = '';
                        
            UpdateAdult();
        }
        
        Event.observe(window, 'load', initBooking);  

        //****
        //Info bulle pour l'aide
        jQuery(function() {
        	jQuery(".aide > a").tooltip({
        	delay: 5,
        	showURL: false,
        	left: 10,
        	top: 10,
        	fade: 250,
        	track: true
          });
        });

        //************************************************
		// Alert sur combo Hotels

        function informeUser(elem) 
        { 
            if (!elem.visible) {
				alert("<?php echo addslashes($this->__('Please select a location first'))?>");
            }

      	}       		
	</script>