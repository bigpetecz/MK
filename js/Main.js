$(document).ready(function() {
    
	var SLIDER_POSITION_HEIGHT=5;
	var SLIDER_MIN_OFFSET=-95;
	var SLIDER_MAX_OFFSET=-5;
    
    var mapaBtn = $( "#map" ),
        mapaBtns = $( "#map, .logo" ),
        compareBtn = $( "#compare" ),
        tableBtn = $( "#table" ),
        porovnaniPage = $( "#porovnaniPage" ),
        tabulkyPage = $( "#tabulkyPage" ),
        homepageTimeline = $( ".homepageTimeline" ),
        homepageLegendMain = $( ".homepageLegendMain" ),
        homepageInfoBox = $( ".homepageInfoBox" );

    /* SWITCH TO PAGE ACCORDING TO HASH */
    if( window.location.hash == "#porovnani" ) {
        switchToPorovnani( this, Application.selectedUnit );
    } else if ( window.location.hash == "#tabulky" ) {
        switchToTabulky();
    } else if ( window.location.hash == "#mapa" ) {
        switchToMapa();
    } 
   
    compareBtn.click(function(){
       switchToPorovnani( this, Application.selectedUnit );
    });

    mapaBtns.on( "click", function(evt) {
        switchToMapa();
    });

    tableBtn.on( "click", function() {
        switchToTabulky();
    });


    //bind "Porovnat s jinym" button
    $(".homepageInfoBox .compareBtn").on( "click", function() {
        switchToPorovnani( compareBtn, Application.selectedUnit );
    });

    $('.logIn').hide();
    $('.registration').hide();
    $('.userInfo').hide();
    $('.contact').hide();
    $('#login').click(function(){$('.logIn').toggle();$(this).toggleClass('activeLogin');});
    $('#newUser').click(function(){$('.logIn').toggle();$('.registration').toggle();});
    $('#forgetPass').click(function(){$('.forgetPasContent').toggle();});
    $('#userinfo').click(function(){$('.userInfo').toggle();});

    $('.close-registration').click(function(){$('.registration').hide();$('#login').toggleClass('activeLogin');});
    $('.close-userInfo').click(function(){$('.userInfo').hide();$('login').toggleClass('activeLogin');});
    
    //$('.contactBtn').click(function(){ $('.contact').toggle();});
    
    $(".zoomIn").on("click",function( evt ){
  		evt.preventDefault();

        var zoomed = Map.zoomIn();
  		if( zoomed ) $(".btn").css( {top:"-=" + 10} );
  	});

  	$(".zoomOut").on("click",function( evt ){
  		evt.preventDefault();

        var zoomed = Map.zoomOut();
  		if( zoomed ) $(".btn").css( {top:"+=" + 10} );
  	});
});


function switchToPorovnani( btn, selectedUnit ) {

  var mapaBtn = $( "#map" ),
      mapaBtns = $( "#map, .logo" ),
      compareBtn = $( "#compare" ),
      tableBtn = $( "#table" ),
      porovnaniPage = $( "#porovnaniPage" ),
      tabulkyPage = $( "#tabulkyPage" ),
      homepageTimeline = $( ".homepageTimeline" ),
      homepageLegendMain = $( ".homepageLegendMain" ),
      homepageInfoBox = $( ".homepageInfoBox" );

  MapDetailOverlay.close();
   
  homepageLegendMain.hide();
  homepageInfoBox.hide();
  homepageTimeline.show();
  homepageTimeline.addClass('porovnaniTimeline');

  FilterBox.switchToPorovnani();
  ZoomControl.switchToNormal();

  porovnaniPage.show();
  tabulkyPage.hide();
   
  Porovnani.init( selectedUnit );

  if( mapaBtn.hasClass( "active" ) ) mapaBtn.toggleClass("active");
  if( !compareBtn.hasClass( "active" ) ) compareBtn.toggleClass("active");
  if( tableBtn.hasClass( "active" ) ) tableBtn.toggleClass("active");
}

function switchToMapa( btn, selectedUnit ){

  var mapaBtn = $( "#map" ),
      mapaBtns = $( "#map, .logo" ),
      compareBtn = $( "#compare" ),
      tableBtn = $( "#table" ),
      porovnaniPage = $( "#porovnaniPage" ),
      tabulkyPage = $( "#tabulkyPage" ),
      homepageTimeline = $( ".homepageTimeline" ),
      homepageLegendMain = $( ".homepageLegendMain" ),
      homepageInfoBox = $( ".homepageInfoBox" );
      
  homepageLegendMain.show();
  homepageInfoBox.show();
  homepageTimeline.show();
  homepageTimeline.removeClass('porovnaniTimeline');

  FilterBox.switchToMapa();
  ZoomControl.switchToNormal();

  porovnaniPage.hide();
  tabulkyPage.hide();

  if( compareBtn.hasClass( "active" ) ) compareBtn.toggleClass("active");
  if( !mapaBtn.hasClass( "active" ) ) mapaBtn.toggleClass("active");
  if( tableBtn.hasClass( "active" ) ) tableBtn.toggleClass("active");

  if( Application.selectedUnit < 1 ) return;

  //update data to current selection
  DataProxy.getDataForArea( Application.selectedUnit, complete, Application.filtersString );

  function complete( data ) {
    Homepage.update( data );
   // if( Porovnani.isDisplayed() ) Porovnani.setLeftSelect( 1 );
  }
}

function switchToTabulky() {
    var mapaBtn = $( "#map" ),
      mapaBtns = $( "#map, .logo" ),
      compareBtn = $( "#compare" ),
      tableBtn = $( "#table" ),
      porovnaniPage = $( "#porovnaniPage" ),
      tabulkyPage = $( "#tabulkyPage" ),
      homepageTimeline = $( ".homepageTimeline" ),
      homepageLegendMain = $( ".homepageLegendMain" ),
      homepageInfoBox = $( ".homepageInfoBox" );
      
    MapDetailOverlay.close();
    
    homepageLegendMain.hide();
    homepageInfoBox.hide();
    homepageTimeline.addClass( 'porovnaniTimeline' );

    FilterBox.switchToTabulky();
    ZoomControl.switchToTabulky();

    porovnaniPage.hide();
    tabulkyPage.show();

    Tabulky.init();

    if( mapaBtn.hasClass( "active" ) ) mapaBtn.toggleClass("active");
    if( compareBtn.hasClass( "active" ) ) compareBtn.toggleClass("active");
    if( !tableBtn.hasClass( "active" ) ) tableBtn.toggleClass("active");
}

function addSpaces(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ' ' + '$2');
    }
    return x1 + x2;
}

function getElementsByClass( searchClass, domNode, tagName) { 
    if (domNode == null) domNode = document;
    if (tagName == null) tagName = '*';
    var el = new Array();
    var tags = domNode.getElementsByTagName(tagName);
    var tcl = " "+searchClass+" ";
    for(i=0,j=0; i<tags.length; i++) { 
        var test = " " + tags[i].className + " ";
        if (test.indexOf(tcl) != -1) 
            el[j++] = tags[i];
    } 
    return el;
}


function getMonthFromName(month) {
            switch( month ){
                    case "Leden":
                            index = 1;
                            break;
                    case "Únor":
                            index = 2;
                            break;
                    case "Březen":
                            index = 3;
                            break;
                    case "Duben":
                            index = 4;
                            break;
                    case "Květen":
                            index = 5;
                            break;
                    case "Červen":
                            index = 6;
                            break;
                    case "Červenec":
                            index = 7;
                            break;
                    case "Srpen":
                            index = 8;
                            break;
                    case "Září":
                            index = 9;
                            break;
                    case "Říjen":
                            index = 10;
                            break;
                    case "Listopad":
                            index = 11;
                            break;
            case "Prosinec":
                    index = 12;
                    break;
            }
            return index;
}

function getMonthFromIndex(month) {
            switch( month ){
                    case 1:
                            index = "Leden";
                            break;
                    case 2:
                            index = "Únor";
                            break;
                    case 3:
                            index = "Březen";
                            break;
                    case 4:
                            index = "Duben";
                            break;
                    case 5:
                            index = "Květen";
                            break;
                    case 6:
                            index = "Červen";
                            break;
                    case 7:
                            index = "Červenec";
                            break;
                    case 8:
                            index = "Srpen";
                            break;
                    case 9:
                            index = "Září";
                            break;
                    case 10:
                            index = "Říjen";
                            break;
                    case 11:
                            index = "Listopad";
                            break;
            case 12:
                    index = "Prosinec";
                    break;
            }
            return index;
}

function getCrimeTypeIdByKeyword( keyword ) {
    
    var id = 0;    

    switch( keyword ) {
        case "violent":
            id = 1;
            break;
        case "moral":
            id = 2;
            break;
        case "burglary":
            id = 3;
            break;
        case "theft":
            id = 4;
            break;
        case "property":
            id = 5;
            break;
        case "other":
            id = 6;
            break;
        case "rest":
            id = 7;
            break;
        case "economic":
            id = 8;
            break;
        case "military":
            id = 9;
            break;
    }

    return id;
}