function MM_showHideLayers() { //v9.0
    var i,p,v,obj,args=MM_showHideLayers.arguments;
    for (i=0; i<(args.length-2); i+=3)
        with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
            if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
            obj.visibility=v; }
}

function MM_setTextOfLayer(objId,x,newText) { //v9.0
    with (document) if (getElementById && ((obj=getElementById(objId))!=null))
        with (obj) innerHTML = unescape(newText);
}

function MM_changeProp(objId,x,theProp,theValue) { //v9.0
    var obj = null; with (document){ if (getElementById)
        obj = getElementById(objId); }
    if (obj){
        if (theValue == true || theValue == false)
            eval("obj.style."+theProp+"="+theValue);
        else eval("obj.style."+theProp+"='"+theValue+"'");
    }
}

$(document).ready(function() {
    var PrevMain = null;

    $("#mmap").click(function() {
        $("#Submenu").hide();
    });

    $("#mmap").mouseover(function() {
        $("#Submenu").hide();
    });

    $("#Accordion .sub_item").removeClass("Category_on");
    $("#Accordion .sub_item").addClass("Category_off");

    $(".OpenCloseAccordion").click(function() {
        if($('.accordion_main').is(':visible')) {
            $('.accordion_main').slideUp();
            $(this).html('<img src="templates/gal2/images/menuicons/open.png">');
            $("html, body").animate({ scrollTop: 650 }, "slow");
        } else {
            $('.accordion_main').slideDown();
            $(this).html('<img src="templates/gal2/images/menuicons/close.png">');
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
    });

    $('.toggle_content').hide();
    if(document.location.search.length) {
        $('.default_open').hide();
        $('.accordion_main').hide();
        $(".OpenCloseAccordion").html('<img src="templates/gal2/images/menuicons/open.png">');
    } else {
        $('.default_open').show();
        $('.accordion_main').show();
        $(".OpenCloseAccordion").html('<img src="templates/gal2/images/menuicons/close.png">');
    }

    $('.m_subtitle').click(function() {
        //$('.toggle_content').slideUp();
        $(this).next().slideToggle();
        //return true;
    });

    $("#mobile_menu").click(function() {
        var current_width = $(document).width();
        if($('.topcontainer .mainmenu').is(':visible')) {
            $(".topcontainer .mainmenu").css("display", 'none');
            $(".topcontainer .mainmenu_noevent").css("display", 'none');
            $("#Submenu").hide();
            $(this).html('<img src="templates/gal2/images/menuicons/menu-alt-256.png">');
            if (current_width < 620) {
                $("html, body").animate({ scrollTop: 750 }, "slow");
            }
        } else {
            $(".topcontainer .mainmenu").css("display", 'inline-block');
            $(".topcontainer .mainmenu_noevent").css("display", 'inline-block');
            $(this).html('<img src="templates/gal2/images/menuicons/menu-alt-256-off.png">');
            if (current_width < 620) {
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
        }
    });

    $(window).resize(function() {
        var updated_width = $(document).width();
        //alert(updated_width);
        $("#mobile_menu").html('<img src="templates/gal2/images/menuicons/menu-alt-256.png">');
        if ((updated_width <= 690) && (updated_width > 620)) {
            $(".topcontainer .mainmenu").css("display", 'inline-block');
            $(".topcontainer .mainmenu_noevent").css("display", 'inline-block');
            $("#Submenu").hide();
        } else if (updated_width < 620) {
            $(".topcontainer .mainmenu").css("display", 'none');
            $(".topcontainer .mainmenu_noevent").css("display", 'none');
            $("#Submenu").hide();
        } else {
            //$(".topcontainer .mainmenu").css("display", 'none');
            //$(".topcontainer .mainmenu_noevent").css("display", 'none');
            $(".topcontainer #Itinerari").css("display", 'none');
            $(".topcontainer #Punti").css("display", 'none');
            $(".topcontainer #Epoca").css("display", 'none');
            $(".topcontainer #Comuni").css("display", 'inline-block');
            $(".topcontainer #Eventi").css("display", 'inline-block');
            $(".topcontainer #Aziende").css("display", 'inline-block');
            $(".topcontainer #Informazioni").css("display", 'inline-block');
            $(".topcontainer .mainmenu_noevent").css("display", 'inline-block');
            $("#Submenu").hide();
        }
    });

    $(".mainmenu").click(function() {
        mainmenu = $(this).attr("id");
        var defaultwidth = 200;

        var left = (($(this).position().left) - 0) + 'px';
        var top = $(".topcontainer").position().top;
        var height = $(".topcontainer").height()
        var bottom = (top + height - 0) + 'px';

        var doc_width = $(document).width();
        //alert(doc_width);
        if (doc_width < 481) { left = 0 + 'px'; }
        if (doc_width < 1001) { defaultwidth = 165; }
        if (doc_width >= 1903) { defaultwidth = 320; }

        if ($(this).hasClass("doubled")) {
            defaultwidth = (defaultwidth * 2);
        }

        $("#Submenu").css("top", bottom);

        MM_changeProp('Submenu','','width',defaultwidth + 'px','DIV');
        MM_changeProp('Submenu','','left',left,'DIV');

        $('.sub_item').addClass("Category_off");

        if($('#Submenu').is(':visible')) {
            if (PrevMain == mainmenu) {
                $("#Submenu").hide();
            } else {
                $("#Submenu").show();
                PrevMain = mainmenu;
            }
        } else {
            $("#Submenu").show();
            PrevMain = mainmenu;
        }
    });
});

