if (typeof (FB_useGoogleAnalytics) == "undefined") var FB_useGoogleAnalytics = false;
var FB_book_image = new Image();
FB_book_image.src = FBRESA + "trans.gif";
var FB_code_interface = "";
var FB_profil = "";

function hhotelProfil(code_interface, profil) {
    FB_code_interface = code_interface;
    FB_profil = profil
}
function start() {
    var nbm = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    thisform = document.idForm;
    build_year_select(thisform);
    MD = new Date();
    nday = MD.getDate();
    aday = MD.getDay();
    amois = MD.getMonth();
    ayear = takeYear(MD);
    cur_year = ayear;
    nday += FB_nb_day_delay;
    if (nday > nbm[amois]) {
        nday -= nbm[amois];
        amois++;
        if (amois > 11) {
            ayear++;
            amois = 0
        }
    }
    indexDay = nday - 1;
    indexMois = amois;
    indexYear = ayear - cur_year;
    if (indexDay < 0 || indexDay > 30) indexDay = 0;
    if (indexMois < 0 || indexMois > 11) indexMois = 0;
    if (indexYear < 0 || indexYear > 1) indexDay = 0;
    thisform.fromday.selectedIndex = indexDay;
    thisform.frommonth.selectedIndex = indexMois;
    thisform.fromyear.selectedIndex = indexYear;
    update_departure()
}
function generateSession() {
    var time = new Date();
    var sec = time.getSeconds();
    f = Math.floor(Math.random() * 1000000000) + '';
    var sess = '' + sec + f;
    return sess
}
function transferGAdata(sessId, cname) {
    var waction = FBRESA + "ga.phtml?clusterName=" + cname + "&id=" + sessId;
    pageTracker._initData();
    new Image().src = pageTracker._getLinkerUrl(waction);
    pageTracker._trackPageview('/FastBooking/ClicBook')
}
function fbOpenWindow(cname, waction, title, width, height) {
    if (FB_useGoogleAnalytics) {
        sessId = generateSession();
        hhotelProfil("GoogleAnalytics", escape("SESSION=" + sessId))
    }
    if (FB_profil != "") {
        waction += "&code=" + FB_code_interface;
        waction += "&profil=" + FB_profil
    }
    window.open(waction, title, "toolbar=no,width=" + width + ",height=" + height + ",menubar=no,scrollbars=yes,resizable=yes,alwaysRaised=yes");
    if (FB_useGoogleAnalytics) transferGAdata(sessId, cname)
}
function hhotelPTC(cname, lg, codeprice, codetrack, cluster) {
    hhotelResa(cname, lg, codeprice, "", "", codetrack, cluster, "", "")
}
function hhotelPromo(cname, lg, theme) {
    hhotelResa(cname, lg, "DYNPROMO", "", "", "", "", theme, "")
}
function hhotelOnePromo(cname, lg, codeprice, codetrack, cluster) {
    hhotelResa(cname, lg, codeprice, "", "", codetrack, cluster, "", "style=DIRECTPROMO")
}
function hhotelNegociated(cname, lg, codeprice, codetrack, cluster) {
    hhotelResa(cname, lg, codeprice, "", "", codetrack, cluster, "", "negociated=1")
}
function hhotelResaDirect(cname, lg, codeprice, firstroom, codetrack, firstdate) {
    hhotelResa(cname, lg, codeprice, firstroom, firstdate, codetrack, "", "", "style=DIRECT")
}
function hhotelSearchGroup(cluster, lg, price, nights, title) {
    hhotelSearch(cluster, lg, price, nights, title, "", "")
}
function hhotelSearchPartner(cluster, lg, price, codetrack, title) {
    if (codetrack != "") args = "&from=" + codetrack;
    else args = "";
    hhotelSearch(cluster, lg, price, "", title, "", args)
}
function hhotelSearchPriceDate(cluster, price, nights, title, firstdate) {
    var args = "";
    if (firstdate != "") args = "FirstDate=" + firstdate;
    hhotelSearch(cluster, "", price, nights, title, "", args)
}
function hhotelSearchPriceDateTrack(cluster, lg, price, codetrack, nights, title, firstdate, site) {
    var args = "";
    if (codetrack != "") args = "from=" + codetrack;
    if (firstdate != "") args += "&FirstDate=" + firstdate;
    if (site != "") args += "&FSTBKNGTrackLink=" + site;
    hhotelSearch(cluster, lg, price, nights, title, "", args)
}
function hhotelSearchPromo(cluster, lg, theme) {
    hhotelSearch(cluster, lg, "", "", "", theme, "")
}
function hhotelSearchExtra(cluster, lg, price, codetrack, extratitle, extraval, extrashow) {
    var args = "Extrafield=" + escape(extratitle) + ";" + extraval + ";" + extrashow;
    if (codetrack != "") args += "&from=" + codetrack;
    hhotelSearch(cluster, lg, price, "", "", "", args)
}
function hhotelcancel(cname, lg) {
    var waction = FBRESA + "cancel.phtml?state=77&Hotelnames=" + cname;
    if (lg != "") waction += "&langue=" + lg;
    fbOpenWindow(cname, waction, "reservation", 400, 350)
}
function hhotelExtract(cname, lg) {
    var waction = FBRESA + "getresa.phtml?Hotelnames=" + cname + "&langue=" + lg;
    fbOpenWindow(cname, waction, "getresa", 700, 300);
    return false
}
function hhotelcheckrates(cname, lg) {
    var waction = FBRESA + "crs.phtml?clusterName=" + cname;
    if (lg != "") waction += "&langue=" + lg;
    waction += "&checkPromo=1";
    fbOpenWindow(cname, waction, "search", 800, 550)
}
function hhotelResaMSP(cname, lg, codeprice, firstroom, firstdate, codetrack, cluster, theme, args, mastercluster, cartID) {
    if (mastercluster != "") args += "&mastercluster=" + mastercluster;
    if (cartID != "") args += "&cartID=" + cartID;
    hhotelResa(cname, lg, codeprice, firstroom, firstdate, codetrack, cluster, theme, args)
}
function hhotelSearchMSP(cluster, lg, price, nights, title, theme, args, mastercluster, cartID) {
    if (mastercluster != "") args += "&mastercluster=" + mastercluster;
    if (cartID != "") args += "&cartID=" + cartID;
    hhotelSearch(cluster, lg, price, nights, title, theme, args)
}
function hhotelResa(cname, lg, codeprice, firstroom, firstdate, codetrack, cluster, theme, args) {
    var waction = FBRESA + "preresa.phtml?Hotelnames=" + cname;
    if (lg != "") waction += "&langue=" + lg;
    if (firstroom != "") {
        waction += "&FirstRoomName=" + firstroom;
        if (codeprice == "") codeprice = "DIRECT"
    }
    if (firstdate != "") {
        waction += "&FirstDate=" + firstdate;
        if (codeprice == "") codeprice = "DIRECT"
    }
    if (codeprice != "") waction += "&FSTBKNGCode=" + codeprice;
    if (codetrack != "") waction += "&FSTBKNGTrackLink=" + codetrack;
    if (cluster != "") waction += "&clustername=" + cluster;
    if (theme != "") waction += "&theme=" + theme;
    if (args != "" && (args.indexOf("=") != -1)) waction += "&" + args;
    waction += "&HTTP_REFERER=" + escape(document.location.href);
    fbOpenWindow(cname, waction, "reservation", 400, 350)
}
function hhotelSearch(cluster, lg, price, nights, title, theme, args) {
    var waction = FBRESA + "crs.phtml?clusterName=" + cluster;
    if (lg != "") waction += "&langue=" + lg;
    if (price != "") waction += "&FSTBKNGCode=" + price;
    if (nights != "") waction += "&nights=" + nights;
    if (title != "") waction += "&title=" + escape(title);
    if (theme != "") waction += "&theme=" + theme;
    if (args != "" && (args.indexOf("=") != -1)) waction += "&" + args;
    fbOpenWindow(cluster, waction, "search", 800, 550)
}
function hhotelSearchMultCode(cluster, lg, clecode, title, codetrack) {
    var waction = FBRESA + "crs.phtml?clusterName=" + cluster;
    if (lg != "") waction += "&langue=" + lg;
    if (clecode != "") waction += "&AccessCode=" + clecode;
    if (title != "") waction += "&title=" + escape(title);
    if (codetrack != "") waction += "&FSTBKNGTrackLink=" + codetrack;
    waction += "&crossSelling=NO";
    fbOpenWindow(cluster, waction, "search", 800, 550)
}
function hhotelSearchCrossSell(cluster, lg, codetrack, crossSelling) {
    var waction = FBRESA + "crs.phtml?clusterName=" + cluster;
    if (lg != "") waction += "&langue=" + lg;
    if (codetrack != "") waction += "&FSTBKNGTrackLink=" + codetrack;
    if (crossSelling != "") waction += "&crossSelling=" + crossSelling;
    fbOpenWindow(cluster, waction, "search", 800, 550)
}
function hhotelDispopriceFHP(cname, lg, codetrack, year, month, day, nights, currency) {
    var waction = FBRESA + "dispoprice.phtml?clusterName=" + cname + "&Hotelnames=" + cname;
    if (lg != "") waction += "&langue=" + lg;
    if (codetrack != "") waction += "&FSTBKNGTrackLink=" + codetrack;
    if (year != "") waction += "&fromyear=" + year;
    if (month != "") waction += "&frommonth=" + month;
    if (day != "") waction += "&fromday=" + day;
    if (nights != "") waction += "&nbdays=" + nights;
    if (currency != "") waction += "&CurrencyLabel=" + currency;
    waction += "&showPromotions=3";
    fbOpenWindow(cname, waction, "reservation", 750, 600)
}
function hhotelDispoprice(myForm) {
    hhotelFormValidation(myForm, 0)
}
function hhotelFormValidation(myForm, mandatoryCode) {
    if (mandatoryCode == 1 && myForm.AccessCode.value == "") {
        alert("You must type in your code ID");
        return (false)
    }
    myForm.action = FBRESA + "dispoprice.phtml";
    if (FB_useGoogleAnalytics) {
        sessId = generateSession();
        profilValue = escape("SESSION=" + sessId + "&CODE=GoogleAnalytics");
        if ((typeof myForm.profil) == "undefined") {
            var newInput = document.createElement("input");
            newInput.setAttribute("type", "hidden");
            newInput.setAttribute("name", "profil");
            newInput.setAttribute("value", profilValue);
            myForm.appendChild(newInput)
        } else {
            myForm.profil.value = profilValue
        }
    }
    window.open('', 'dispoprice', 'toolbar=no,width=800,height=550,menubar=no,scrollbars=yes,resizable=yes');
    myForm.submit();
    if (FB_useGoogleAnalytics) {
        var cname = "";
        if ((typeof myForm.AccountName) != "undefined" && myForm.AccountName.value != "") cname = myForm.AccountName.value;
        else cname = myForm.Clusternames.value;
        transferGAdata(sessId, cname)
    }
    return (true)
}
function hhotelFormUpdateHotelnames(myForm) {
    menuNum = myForm.HotelList.selectedIndex;
    if (menuNum == null) return;
    myForm.Hotelnames.value = myForm.HotelList.options[menuNum].value
}
function hhotelFormCancel(myForm) {
    var CName = myForm.Hotelnames.value;
    var languetype = typeof myForm.langue;
    var langue;
    if (languetype == "undefined") langue = "";
    else langue = myForm.langue.value;
    if (CName == null || CName == 'All' || CName == '') {
        alert('Please select a hotel first');
        return (false)
    }
    return hhotelcancel(CName, langue)
}
function hhotelFormExtract(myForm) {
    var CName = myForm.Hotelnames.value;
    var languetype = typeof myForm.langue;
    var langue;
    if (languetype == "undefined") langue = "";
    else langue = myForm.langue.value;
    if (CName == null || CName == 'All' || CName == '') {
        alert('Please select a hotel first');
        return (false)
    }
    return hhotelExtract(CName, langue)
}
function hhotelShowLang(lang) {
    hhotelShowLang__(this.document, lang)
}
function hhotelShowLangOpener(lang) {
    hhotelShowLang__(window.opener.document, lang);
    window.close()
}
function hhotelShowLang__(mydoc, lang) {
    mydoc.idForm.langue.value = lang;
    var imgLang = hhotelLang2Img(lang);
    if (imgLang != "") {
        var formFlag = mydoc.selLgFlag;
        if (formFlag != null) mydoc.selLgFlag.src = "fastbooking/flags/" + imgLang + ".gif";
        var formFlag = mydoc.selLgTxt;
        if (formFlag != null) mydoc.selLgTxt.src = "fastbooking/flags/" + imgLang + "lg.gif"
    }
}
var FBLangCode = new Array("uk", "france", "germany", "spain", "portuguese", "italy", "nether", "russian", "dansk", "svensk", "islensk", "norsk", "turk", "hungria", "greek", "arab", "china", "coreen", "japan", "croate", "czech", "poland");
var FBLangImg = new Array("grandbret", "france", "germany", "spain", "portuguese", "italy", "nether", "russia", "denmark", "sweeden", "iceland", "norway", "turkey", "hungary", "greek", "arab", "china", "coreen", "japan", "croate", "czech", "poland");

function hhotelLang2Img(lang) {
    for (i = 0; i < FBLangCode.length; i++) {
        if (FBLangCode[i] == lang) break
    }
    return FBLangImg[i]
}
function hhotelLangSelector() {
    window.open('fastbooking/flags/langSelector.html', '', 'width=330,height=180')
}
var langcodes = new Array("en", "uk", "fr", "france", "de", "germany", "es", "spain ", "pt", "portuguese", "it", "italy", "nl", "nether", "ja", "japan ", "ko", "coreen", "zh", "china", "ar", "arab", "ru", "russian", "tr", "turk", "el", "greek", "hu", "hungria", "da", "dansk", "sv", "svensk", "is", "islensk", "no", "norsk", "hr", "croate", "cs", "czech", "pl", "poland", "iw", "hebrew");

function selectLang() {
    if (navigator.appName == "Microsoft Internet Explorer") UL = navigator.userLanguage.substring(0, 2);
    else if (navigator.appName == "Netscape") UL = navigator.language;
    else return;
    for (i = 0; i < langcodes.length; i += 2) if (UL == langcodes[i]) break;
    lang = (i < langcodes.length) ? langcodes[i + 1] : "uk";
    hhotelShowLang(lang)
}
function build_year_select(thisform) {
    var cur_date = new Date();
    var cur_year = takeYear(cur_date);
    cur_y = new Option(cur_year, cur_year, true, true);
    thisform.fromyear.options[0] = cur_y;
    if (thisform.toyear != null) {
        cur_yb = new Option(cur_year, cur_year, true, true);
        thisform.toyear.options[0] = cur_yb
    }
    next_y = new Option(cur_year + 1, cur_year + 1, false, false);
    thisform.fromyear.options[1] = next_y;
    next_yb = new Option(cur_year + 1, cur_year + 1, false, false);
    if (thisform.toyear != null) {
        thisform.toyear.options[1] = next_yb
    }
}
function check_departure() {
    thisform = document.idForm;
    if (thisform.today == null) return;
    var nbm = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    var ar_day = parseInt(thisform.fromday.value) + 1;
    var ar_month = parseInt(thisform.frommonth.value);
    var ar_year = parseInt(thisform.fromyear.value);
    if (ar_day > nbm[ar_month - 1]) {
        ar_day = 1;
        ar_month += 1;
        if (ar_month > 12) {
            ar_month = 1;
            ar_year += 1
        }
    }
    var cur_date = new Date();
    var cur_year = takeYear(cur_date);
    thisform.today.selectedIndex = ar_day - 1;
    thisform.tomonth.selectedIndex = ar_month - 1;
    thisform.toyear.selectedIndex = ar_year - cur_year
}
function update_departure() {
    thisform = document.idForm;
    if (thisform.today == null) return;
    var ar_day = parseInt(thisform.fromday.value) + 1;
    var ar_month = parseInt(thisform.frommonth.value);
    var ar_year = parseInt(thisform.fromyear.value);
    var de_day = parseInt(thisform.today.value) + 1;
    var de_month = parseInt(thisform.tomonth.value);
    var de_year = parseInt(thisform.toyear.value);
    if (de_year < ar_year) {
        check_departure()
    } else {
        if (de_year == ar_year) {
            if (de_month < ar_month) {
                check_departure()
            } else {
                if (de_month == ar_month) {
                    if (de_day <= ar_day) {
                        check_departure()
                    }
                }
            }
        }
    }
}
function takeYear(theDate) {
    x = theDate.getYear();
    var y = x % 100;
    y += (y < 38) ? 2000 : 1900;
    return y
}
function popup(url) {
    fbOpenWindow("", url, "", 800, 550)
}