<?php //netteCache[01]000398a:2:{s:4:"time";s:21:"0.95276000 1350390034";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:76:"/Users/petr/Sites/mapakriminality.cz/app/FrontModule/templates/@layout.latte";i:2;i:1350390008;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"eb558ae released on 2012-04-04";}}}?><?php

// source file: /Users/petr/Sites/mapakriminality.cz/app/FrontModule/templates/@layout.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '7wbey54drd')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block head
//
if (!function_exists($_l->blocks['head'][] = '_lb9b5cb0e8d7_head')) { function _lb9b5cb0e8d7_head($_l, $_args) { extract($_args)
;
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/i/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>MAPAKRIMINALITY.CZ</title>
  <meta name="description" content="" />

  <!-- Mobile viewport optimized: h5bp.com/viewport -->
  <meta name="viewport" content="width=device-width" />

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/ui.jqgrid.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/jquery-ui-1.8.18.custom.css" />

  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/contactForm.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/boilerplate.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/fontFace.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/main.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/chosen.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/homepage.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/autorizace.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/porovnani.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/tabulky.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/kontakty.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/oAplikaci.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/map.css" />
  <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/popups.css" />

 <!-- <link rel="stylesheet" href="<?php echo Nette\Templating\Helpers::escapeHtmlComment($basePath) ?>/css/styles.css"> -->

  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/netteForms.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/jquery.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/jshashset.js" type="text/javascript"></script>  
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/jshashtable.js" type="text/javascript"></script>  
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/jquery.numberformatter-1.2.3.min.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/Main.js" type="text/javascript"></script>
  <scriloadDapt id="facebook-jssdk" src="//connect.facebook.net/en_US/all.js#xfbml=1&amp;appId=272071086197256"></script>
  
<?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['head']), $_l, get_defined_vars())  ?>


  
    <script type="text/javascript">
        
      var templateDir = <?php echo Nette\Templating\Helpers::escapeJs($basePath) ?> + "/templates";
      var appKey = "AIzaSyD6OPC_IU0jGYhX0lUzgMsfn-D1yQvJfxY";
      
      function getData(table) {
          // Builds a Fusion Tables SQL query and hands the result to dataHandler()

          var queryUrlHead = 'http://www.google.com/fusiontables/api/query?sql=';
          var queryUrlTail = '&jsonCallback=?'; // ? could be a function name
          
          // write your SQL as normal, then encode it
          var query = "SELECT Name, TotalDamage,Acreage,Population,Officers,Rank,ContactFormContent,ContactFormEmail FROM " + table + " WHERE ID=1";
          var queryurl = encodeURI(queryUrlHead + query + queryUrlTail);

          var jqxhr = $.get(queryurl, dataHandler, "jsonp");
      }

      function dataHandler(d) {
        var data = d.table.rows;
        var acreage = data[0][2];

        var temp = queryCrimes(1);
        var total = queryLocal(1);

        var d = {};
        var solv = 0;
        var com = 0;
        var index = total[2];
        for (var i = 0; i < Application.filters.length; i++) {  
            d[Application.filters[i]] = temp[Application.filters[i]];  
            solv += temp[Application.filters[i]].solv.val;
            com += temp[Application.filters[i]].com.val;
        } 
        
        //append necessary data from elsewhere
        data[0].com = com;
        data[0].index = index;

        Homepage.update( data[0] );

        $('.contactInfo').html(data[0][6]);
        $('#frmcontactForm-emailTo').val(data[0][7]);
      }


      //getData(fusionTable);

function queryGoogle(query) {
        var queryUrlHead = 'https://www.googleapis.com/fusiontables/v1/query?sql=';
        var queryurl = encodeURI(queryUrlHead + query);
        var data;
        $.ajax({
            async: false,
            type: 'GET',
            dataType: 'json',
            url: queryurl,
            data: { key: appKey},
            success: function(d) {
                data = d;
            }
        });

        return data;
}

function queryGoogleColumns(table,id) {
        var queryUrlHead = 'https://www.googleapis.com/fusiontables/v1/tables/' + table +'/columns/';
        var queryurl = encodeURI(queryUrlHead);
        var data;
        $.ajax({
            async: false,
            type: 'GET',
            dataType: 'json',
            url: queryurl,
            data: { key: appKey},
            success: function(d) {
                data = d;
            }
        });

        return data;
}

function queryLocal(area, crime, filters ) {
        var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_control->link("loadData!")) ?>;
        var data;
        var isDistrict = ( Application.zoomLevel == 2 ) ? true : false;

        $.ajax({
            async: false,
            type: 'GET',
            dataType: 'json',
            data: { area: area, crime: crime, yearFrom: dateFrom.year, monthFrom: dateFrom.month, yearTo: dateTo.year, monthTo: dateTo.month, crimeTypes:Application.filtersString(), isDistrict: isDistrict },
            url: queryurl,
            success: function(d) {
              data = d;
            }
        });

        return data;
}

function queryCrimes(area, filtersString )
{
        var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_control->link("loadData!")) ?>;
        var data;
        var isDistrict = ( Application.zoomLevel == 2 ) ? true : false;
        log("queryCrimes is district");
        log( isDistrict ); 
        $.ajax({
            async: false,
            type: 'GET',
            dataType: 'json',
            data: { area: area, crime: 1, yearFrom: dateFrom.year, monthFrom: dateFrom.month, yearTo: dateTo.year, monthTo: dateTo.month, filters:Application.filtersString(),isDistrict: isDistrict },
            url: queryurl,
            success: function(d) {
                log("queryCrimes success");
                log( d );
                data = d;
            },
            error: function(xhr) {
              log("queryCrimes error");
              log( xhr );
            }
        });

        //temporary check for missing data with crime type 2
        if( !data[2] ) {
           data[2] = [ 0,0,"BR",0];
        }

        var temp = 
        {                            
            name: data[1][2],
            violent:{ name:"Násilné činy", index: data[1][3], solv:{ col:"#def5af", val:parseInt(data[1][1]) }, com:{ col:"#d2f193", val:parseInt(data[1][0]) }},
            moral:{ name:"Mravnostní činy", index: data[2][3], solv:{ col:"#c6e2a5", val:parseInt(data[2][1]) }, com:{ col:"#b7dc8e", val:parseInt(data[2][0]) }},
            burglary:{ name:"Krádeže vloupáním", index: data[3][3], solv:{ col:"#b3d0a2", val:parseInt(data[3][1]) }, com:{ col:"#9cc384", val:parseInt(data[3][0]) }},
            theft:{ name:"Krádeže prosté", index: data[4][3], solv:{ col:"#9fbd9b", val:parseInt(data[4][1]) }, com:{ col:"#89b084", val:parseInt(data[4][0]) }},
            property:{ name:"Ostatní majetkové činy", index: data[5][3], solv:{ col:"#8db09a", val:parseInt(data[5][1]) }, com:{ col:"#719d82", val:parseInt(data[5][0]) }},
            other:{ name:"Ostatní činy", index: data[6][3], solv:{ col:"#8db09a", val:parseInt(data[6][1]) }, com:{ col:"#5b867c", val:parseInt(data[6][0]) }},
            rest:{ name:"Zbývající činy", index: data[7][3], solv:{ col:"#678d90", val:parseInt(data[7][1]) }, com:{ col:"#446e7a", val:parseInt(data[7][0]) }},
            economic:{ name:"Hospodářské činy", index: data[8][3], solv:{ col:"#537e8f", val:parseInt(data[8][1]) }, com:{ col:"#2c5a71", val:parseInt(data[8][0]) }},
            military:{ name:"Vojenské činy", index: data[9][3], solv:{ col:"#406b8b", val:parseInt(data[9][1]) }, com:{ col:"#12466d", val:parseInt(data[9][0]) }}
        };
        return temp;
}

function loadTimeline()
{
    var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_control->link("loadTimeline!")) ?>;
    var data;
    $.ajax({
        async: false,
        type: 'GET',
        data: { crimeTypes:Application.filtersString() },
        dataType: 'json',
        url: queryurl,
        success: function(d) {
            data = d;
        }
    });
    return data;
}


function loadMapStyles( zoomLevel )
{
    //var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_control->link("loadMapStyles!")) ?>;
    var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_control->link("loadMapValuesStyles!")) ?>;
    
    var data;
    $.ajax({
        async: false,
        type: 'GET',
        dataType: 'json',
        url: queryurl,
        data: { zoomLevel: zoomLevel, table: fusionTable, yearFrom: dateFrom.year, monthFrom: dateFrom.month, yearTo: dateTo.year, monthTo: dateTo.month, crimeTypes:Application.filtersString() },
        success: function(d) {
            data = d;
        }
    });

    return data;
}

function getNamesAndIndexes( zoomLevel ) {

      var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_control->link("findNamesIndexesForIdsRange!")) ?>;
      var data;
      $.ajax( {
          async: false,
          type: 'GET',
          dataType: 'json',
          data: { zoomLevel: zoomLevel, area: area, crime: 1, yearFrom: dateFrom.year, monthFrom: dateFrom.month, yearTo: dateTo.year, monthTo: dateTo.month, crimeTypes: Application.filtersString()  },
          url: queryurl,
          success: function(d) {
              data = d;
          },
          error: function() {
            log("error");
          }
      });
      
      return data;
  }
  
  function getDamage()
  {
    var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_control->link("loadMapValuesStyles!")) ?>;
    var data;
    $.ajax({
        async: false,
        type: 'GET',
        dataType: 'json',
        url: queryurl,
        data: { table: fusionTable, yearFrom: dateFrom.year, monthFrom: dateFrom.month, yearTo: dateTo.year, monthTo: dateTo.month, crimeTypes: Application.filtersString },
        success: function(d) {
            data = d;
        }
    });

    return data;
  }
  
function storeDate(yearFrom,monthFrom,yearTo,monthTo) {
        var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_presenter->link("storeDate!")) ?>;
        $.ajax({
            async: false,
            type: 'GET',
            dataType: 'json',
            data: { yearFrom: yearFrom, monthFrom: monthFrom, yearTo: yearTo, monthTo: monthTo},
            url: queryurl,
            error: function() {
              log("error");
            }
        });

        return null;
}

function storeTable(table) {
        var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_presenter->link("storeTable!")) ?>;
    $.ajax({
        async: false,
        type: 'GET',
        dataType: 'json',
        url: queryurl,
        data: { table: table },
        success: function(d) {
            data = d;
        }
    });

    return data;
}

function storeArea(area) {
        var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_presenter->link("storeArea!")) ?>;
        $.ajax({
            async: false,
            type: 'GET',
            dataType: 'json',
            data: { area: area},
            url: queryurl,
            error: function() {
              log("error");
            }
        });

        return null;
}

function storeFilters(filters) {
        var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_presenter->link("storeFilters!")) ?>;
        $.ajax({
            async: false,
            type: 'GET',
            dataType: 'json',
            data: { filters: filters},
            url: queryurl,
            error: function() {
              log("error");
            }
        });

        return null;
}

function getRankingsForCrimeType( zoomLevel, crimeTypeId ) {
        var queryurl = <?php echo Nette\Templating\Helpers::escapeJs($_control->link("getRankingsForCrimeType!")) ?>;

        $.ajax({
            async: false,
            type: 'GET',
            dataType: 'json',
            data: { zoomLevel: zoomLevel, crimeTypeId: crimeTypeId,  yearFrom: dateFrom.year, monthFrom: dateFrom.month, yearTo: dateTo.year, monthTo: dateTo.month },
            url: queryurl,
            success: function(d) {
              data = d;
            },
            error: function() {
              log("getRankingsForCrimeType error");
            }
        });

        return data;
}
  </script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/cs_CZ/all.js#xfbml=1&appId=272071086197256";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <header class="mainBar">
      <a href="<?php if ($presenter->getName() != 'Mapa'): echo htmlSpecialChars($_presenter->link("Mapa:#mapa")) ;else: ?>
#<?php endif ?>" class="logo"><img src="<?php echo htmlSpecialChars($basePath) ?>/images/logo.png" alt="logo" class="logo" /></a>
      <h2>Projekt Otevřené společnosti</h2>
      <div class="fb-like" data-href="http://www.mapakriminality.cz" data-layout="button_count" data-width="350"></div>
      <nav id="pagesNav">
        <ul>
          <li><a id="map" href="<?php if ($presenter->getName() != 'Mapa'): echo htmlSpecialChars($_presenter->link("Mapa:#mapa")) ;else: ?>
#<?php endif ?>" alt="homepage"<?php if ($presenter->name == 'Front:Mapa'): ?> class="active"<?php endif ?>><span>MAPA</span></a></li>
          <li><a id="compare" href="<?php if ($presenter->getName() != 'Mapa'): echo htmlSpecialChars($_presenter->link("Mapa:#porovnani")) ;else: ?>
#<?php endif ?>" alt="porovnani"<?php if ($presenter->name == 'Front:Porovnani'): ?>
 class="active"<?php endif ?>><span>POROVNÁNÍ</span></a></li>
          <li><a id="table" href="<?php if ($presenter->getName() != 'Mapa'): echo htmlSpecialChars($_presenter->link("Mapa:#tabulky")) ;else: ?>
#<?php endif ?>" alt="tabulky"<?php if ($presenter->name == 'Front:Tabulky'): ?>
 class="active"<?php endif ?>><span>TABULKY</span></a></li>
         <!-- <li><a n:href="Kontakty:" alt="kontakty"<?php if ($presenter->name == 'Front:Kontakty'): ?>
 class="active"<?php endif ?>><span>KONTAKTY</span></a></li>-->
          <li><a alt="oAplikaci"<?php if ($presenter->name == 'Front:OAplikaci'): ?>
 class="active"<?php endif  ?> href="<?php echo htmlSpecialChars($_control->link("OAplikaci:")) ?>
"><span>O APLIKACI</span></a></li>
          <span>|</span>
          <li><?php if ($user->isLoggedIn()): ?><a href="#" id="userinfo"><span><?php $data = $user->getIdentity()->getData(); echo Nette\Templating\Helpers::escapeHtml($data['email'], ENT_NOQUOTES) ?>
</spam></a><?php else: ?><a id="login" href="#"><span>PŘIHLÁŠENÍ</span></a><?php endif ?></li>
        </ul>
      </nav>
  </header>
  <div id="main" role="main">
<?php $iterations = 0; foreach ($flashes as $flash): ?>	<div class="popup check">
		<a href="#" onClick="$('.popup').hide();" class="close"></a>
		<img src="images/popup-<?php echo htmlSpecialChars($flash->type) ?>.png" alt="varování" />
		<p><?php echo Nette\Templating\Helpers::escapeHtml($flash->message, ENT_NOQUOTES) ?></p>
	</div>
<?php $iterations++; endforeach ?>
        
    
     
<div class="authorization">
		<section class="logIn">
			<div class="top"></div>
			<div class="content">
				<header>
					<h1>PŘIHLÁŠENÍ DO APLIKACE</h1>
				</header>
<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("signInForm") ? "signInForm" : $_control["signInForm"]), array()) ?>
					<?php echo $_form["email"]->getControl()->addAttributes(array()) ?>

					<?php echo $_form["password"]->getControl()->addAttributes(array()) ?>

					<a href="#" id="newUser" title="nový uživatel">Nový uživatel</a>
					<a href="#" id="forgetPass" title="nevím heslo" class="lostPass">Nevím heslo</a>
					<?php echo $_form["login"]->getControl()->addAttributes(array()) ?>

<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ?>
			</div>
			<div class="forgetPasContent">
<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("forgetPassForm") ? "forgetPassForm" : $_control["forgetPassForm"]), array()) ;if ($_label = $_form["email"]->getLabel()) echo $_label->addAttributes(array()) ?>
					<?php echo $_form["email"]->getControl()->addAttributes(array()) ?>

					<?php echo $_form["submit"]->getControl()->addAttributes(array()) ?>

<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ?>
			</div>
		</section>
                <section class="registration">
			<div class="top"></div>
			<div class="content">
                            <a href="#" class="close-registration">x</a>
				<header>
					<h1>NOVÝ UŽIVATEL</h1>
				</header>

<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("registrationForm") ? "registrationForm" : $_control["registrationForm"]), array()) ?>
					<?php echo $_form["email"]->getControl()->addAttributes(array()) ?>

					<?php echo $_form["password"]->getControl()->addAttributes(array()) ?>

                            <?php echo $_form["pswdCheck"]->getControl()->addAttributes(array()) ?>

                                        <div class="selectWrapper">
					<?php echo $_form["sector"]->getControl()->addAttributes(array()) ?>

                                        </div>
					<?php echo $_form["newsletter"]->getControl()->addAttributes(array()) ?> <label for="frmregistrationForm-newsletter">Informujte mě <br /> o aktualizacích</label>
                                        <?php echo $_form["register"]->getControl()->addAttributes(array()) ?>

<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ?>
				</form>
			</div>
		</section>
                <section class="userInfo">
			<div class="top"></div>
			<div class="content">
				<header>
					<h1>UŽIVATELSKÉ JMÉNO</h1>
					<a title="odhlásit" href="<?php echo htmlSpecialChars($_control->link("Sign:out")) ?>
">odhlásit</a>
					<div class="clearfix"></div>
				</header>
<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("userInfoForm") ? "userInfoForm" : $_control["userInfoForm"]), array()) ?>
                                    <fieldset>
<?php if ($_label = $_form["email"]->getLabel()) echo $_label->addAttributes(array()) ?>
                                        <?php echo $_form["email"]->getControl()->addAttributes(array()) ?>

                                    </fieldset>
                                    <fieldset>
<?php if ($_label = $_form["password"]->getLabel()) echo $_label->addAttributes(array()) ?>
					<?php echo $_form["password"]->getControl()->addAttributes(array()) ?>

                                    </fieldset>
                                    <fieldset>
<?php if ($_label = $_form["checkPassword"]->getLabel()) echo $_label->addAttributes(array()) ?>
                                        <?php echo $_form["checkPassword"]->getControl()->addAttributes(array()) ?>

                                    </fieldset>
                                    <fieldset>
<?php if ($_label = $_form["sector"]->getLabel()) echo $_label->addAttributes(array()) ?>
                                        <div class="selectWrapper">
						<?php echo $_form["sector"]->getControl()->addAttributes(array()) ?>

                                        </div>
                                    </fieldset>
                                    <hr />
                                    <?php echo $_form["newsletter"]->getControl()->addAttributes(array()) ?> <label for="frmuserInfoForm-newsletter">Informujte mě o<br /> aktualizacích</label>
                                    <?php echo $_form["save"]->getControl()->addAttributes(array()) ?>

                                    <div class="clearfix"></div>
<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ?>
			</div>
		</section>
</div>
<?php Nette\Latte\Macros\UIMacros::callBlock($_l, 'content', $template->getParameters()) ?>
  </div>

  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){ var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
</body>
</html>