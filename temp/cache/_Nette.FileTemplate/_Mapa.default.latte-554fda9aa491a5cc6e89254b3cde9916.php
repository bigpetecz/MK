<?php //netteCache[01]000403a:2:{s:4:"time";s:21:"0.87885000 1350372968";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:81:"/Users/petr/Sites/mapakriminality.cz/app/FrontModule/templates/Mapa/default.latte";i:2;i:1349963820;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"eb558ae released on 2012-04-04";}}}?><?php

// source file: /Users/petr/Sites/mapakriminality.cz/app/FrontModule/templates/Mapa/default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'hb77wmszep')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbc5faa0252e_content')) { function _lbc5faa0252e_content($_l, $_args) { extract($_args)
?><div id="mapWrapper"></div>
<div class="mapOverviewPopup">
        <div class="content">
        <h1>čr</h1>
        <dl class="value">
            <dt>trestných činů</dt>
            <dd>35 678</dd>
        </dl>
        <dl class="index">
            <dt>index kriminality</dt>
            <dd>234</dd>
        </dl>
    <div class="homepageLegend">
        <ol>
        <li class="a">0-200</li>
        <li class="b">201-300</li>
        <li class="c">301-400</li>
        <li class="d">401-500</li>
        <li class="e last">501-600</li>
        </ol>
    </div>
    </div>
    <div class="clearfix bottom">
</div>
</div>
<div class="zoomControl">
	<ol>
		<li class="country" onClick="showCountry()"><div><a href="#">ČR CELKEM</a></div></li>
		<li class="county" onClick="showCounty()"><div><a href="#">KRAJE</a></div></li>
		<li class="district" onClick="showDistrict()"><div><a href="#">UZEMNÍ ODBORY</a></div></li>
	</ol>
	<div class="scale">
		<a href="#" title="Přiblížit" class="zoomIn"></a>
		<div class="bar"> </div>
		<div class="btn" style="top: -5px; left: 0px; "> </div> 
		<a href="#" title="Oddálit" class="zoomOut"></a>
	</div>
</div>

<div class="homepageInfoBox infoBox insertedPageContent">
	<header>
			<div class="headerWrapper">
				<h1>KRAJE</h1>
				<div class="hideBtn"></div>
			</div>
			<div class="clearfix"></div>
	</header>
	<div class="content">
		<div class="title">
			<h1 id="county">Vyber kraj v mapě</h1>
			<div class="rank" title="Pořadí podle indexu kriminality (od nejvyššího k nejnižšímu)">0</div>
		</div>
		<section>
			<table>
				<tr>
					<th>index kriminality</th>
					<th>způsobená škoda</th>
				</tr>
				<tr>
                    <td id="ic">-</td>
					<td id="damage">-</td>
				</tr>
			</table>
			<table>
				<tr>
					<th>trestné činy celkem</th>
					<th>počet policistů</th>
				</tr>
				<tr>
					<td id="totalcrime">-</td>
					<td id="officers">-</td>
				</tr>
			</table>
		</section>
		<footer>
			<a href="#" target="_self" class="compareBtn" title="Porovnat"><div>POROVNAT S JINÝM</div></a>
			<a href="#" target="_self" class="contactBtn" title="Kontakt"><div>KONTAKTOVAT</div></a>
		</footer>
	</div>
</div>

 <div class="contact" style="display:hidden">
	<div class="arrow"></div>
	<a href="#" onClick="$('.contact').hide();" class="closeBtn" title="Zavřít"></a>
        <div class="contactInfo"> 
        </div>
<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("contactForm") ? "contactForm" : $_control["contactForm"]), array()) ?>
            <?php echo $_form["name"]->getControl()->addAttributes(array()) ?>

            <?php echo $_form["message"]->getControl()->addAttributes(array()) ?>

            <?php echo $_form["send"]->getControl()->addAttributes(array()) ?>

            <?php echo $_form["emailTo"]->getControl()->addAttributes(array()) ?>

<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ?>
	<div class="clearfix"></div>
</div>

<div class="homepageFilterBox infoBox insertedPageContent">
	<header>
		<div class="headerWrapper">
			<h1>Spáchané trestné činy</h1>
			<div class="hideBtn"></div>
		</div>
		<div class="clearfix"></div>
	</header>
	<div class="content">
		<ul>
			<li class="violent"><input type="checkbox" checked="checked" data-index="1" name="violent" />Násilné činy<sup class='upper' title='Nejčastěji úmyslné ublížení na zdraví, loupež, porušování domovní svobody, nebezpečné vyhrožování a vydírání.'>?</sup><span class="val">-</span></li>
			<li class="moral"> <input type="checkbox" checked="checked" data-index="2" name="moral" />Mravnostní činy<sup class='upper ui' title='Nejčastěji znásilnění a pohlavní zneužívání ostatní.'>?</sup><span class="val">-</span></li>
			<li class="burglary"><input type="checkbox" checked="checked" data-index="3" name="burglary" />Krádeže vloupáním<sup class='upper' title='Nejčastěji krádeže vloupáním do rodinných domků, víkendových chat, bytů, obchodů, restaurací a hostinců.'>?</sup><span class="val">-</span></li>
			<li class="theft"><input type="checkbox" checked="checked" data-index="4" name="theft" />Krádeže prosté<sup class='upper' title='Nejčastěji krádeže věcí z automobilů, krádeže kapesní, krádeže dvoustopých motorových vozidel, krádeže součástek motorových vozidel a krádeže jízdních kol.'>?</sup><span class="val">-</span></li>
			<li class="property"><input type="checkbox" checked="checked" data-index="5" name="property" />Ostatní majetkové činy<sup class='upper' title='Nejčastěji poškozování cizí věci a podvod.'>?</sup><span class="val">-</span></li>
			<li class="other"><input type="checkbox" checked="checked" data-index="6" name="other" />Ostatní činy<sup class='upper' title='Nejčastěji maření výkonu úředního rozhodnutí, výtržnictví, nedovolená výroba a držení psychotropních látek a jedů a sprejerství.'>?</sup><span class="val">-</span></li>
			<li class="rest"><input type="checkbox" checked="checked" data-index="7" name="rest" />Zbývající činy<sup class='upper' title='Nejčastěji zanedbání povinné výživy, ohrožení pod vlivem návykové látky a opilství a o nedbalostní dopravní nehody.'>?</sup><span class="val">-</span></li>
			<li class="economic"><input type="checkbox" checked="checked" data-index="8" name="economic" />Hospodářské činy<sup class='upper' title='Nejčastěji neoprávněné držení platební karty, úvěrový podvod, podvod, ochrana měny a zpronevěra.'>?</sup><span class="val">-</span></li>
			<li class="military"><input type="checkbox" checked="checked" data-index="9" name="military" />Vojenské činy<sup class='upper' title='Trestné činy páchané vojáky ve vztahu k výkonu vojenské služby, např. neuposlechnutí rozkazu, urážka mezi vojáky, vyhýbání se výkonu služby apod.'>?</sup><span class="val">-</span></li>
		</ul>
	</div>
</div>
<div class="homepageLegendMain infoBox insertedPageContent">
	<h1>INDEX KRIMINALITY <sup class="upper" title="Počet trestných činů na 10 000 obyvatel za zvolené období">?</sup></h1>
	<div class="value">-</div>
	<div class="clearfix"></div>
	<ol>
		<li class="a" data-color="#fadbde">0-200</li>
		<li class="b" data-color="#f5a6ab">201-300</li>
		<li class="c" data-color="#ee7079">301-400</li>
		<li class="d" data-color="#e93a46">401-500</li>
		<li class="e last" data-color="#e20613">501-600</li>
	</ol>
</div>

<div id="porovnaniPage" style="display:none;">
	<a href="#" class="closeBtn" title="Zavřít"></a>
	<div class="firstCol">
		<header>
			<div class="selectWrapper">
				<select class="firstSelect chzn-select county" data-placeholder="Vyber územní jednotku">
				      <option value=""></option>
			            <option data-rank="1">Hlavní město Praha</option>
			            <option data-rank="2">Středočeský</option>
			            <option data-rank="3">Jihočeský</option>
			            <option data-rank="4">Plzeňský</option>
			            <option data-rank="5">Ústecký</option>
			            <option data-rank="6">Královéhradecký</option>
			            <option data-rank="7">Jihomoravský</option>
			            <option data-rank="8">Moravskoslezský</option>
			            <option data-rank="9">Olomoucký</option>
			            <option data-rank="10">Zlínský</option>
			            <option data-rank="11">Vysočina</option>
			            <option data-rank="12">Pardubický</option>
                        <option data-rank="13">Liberecký</option>
                        <option data-rank="14">Karlovarský</option>        
        		</select>
			</div>
			<div class="rank">
				<a href="#" class="rankUp" title="Pořadí nahoru"></a>
				<p title="Pořadí podle indexu kriminality (od nejvyššího k nejnižšímu)">10</p>
				<a href="#" class="rankDown" title="Pořadí dolů"></a>
			</div>
		</header>
		<div class="clearfix"></div>
		<div class="content">
			<section class="staticData">
				<table>
					<tr>
						<th>způsobená škoda</th>
						<th>počet policistů</th>
					</tr>
					<tr class="total">
						<td>-</td>
						<td>-</td>
					</tr>
				</table>
			</section>
			<section class="total">
				<table>
					<tr>
						<th></th>
						<th class="first">Zjištěno</th>
						<th class="second">Objasněno</th>
						<th class="third">%</th>
					</tr>
					<tr class="values">
						<td>Trestné činy celkem</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
				</table>
			</section>
			<section class="index">
				<h1>index kriminality</h1>
				<h2 class="value">-</h2>
				<div class="bar">
					<div class="graph"></div>
				</div>
			</section>
			<div style="clearfix"></div>
			<section class="table">
				<table>
					<tr class="violent">
						<td class="title">Násilné činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
						<td class="bar"><div class="value"></div><div class="graph"></div></td>
					</tr>
					<tr class="moral">
						<td class="title">Mravnostní činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
						<td class="bar"><div class="value"></div><div class="graph"></div></td>
					</tr>
					<tr class="burglary">
						<td class="title">Krádeže vloupáním</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
						<td class="bar"><div class="value"></div><div class="graph"></div></td>
					</tr>
					<tr class="theft">
						<td class="title">Krádeže prosté</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
						<td class="bar"><div class="value"></div><div class="graph"></div></td>
					</tr>
					<tr class="property">
						<td class="title">Ostatní majetkové činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
						<td class="bar"><div class="value"></div><div class="graph"></div></td>
					</tr>
					<tr class="other">
						<td class="title">Ostatní činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
						<td class="bar"><div class="value"></div><div class="graph"></div></td>
					</tr>
					<tr class="rest">
						<td class="title">Zbývající činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
						<td class="bar"><div class="value"></div><div class="graph"></div></td>
					</tr>
					<tr class="economic">
						<td class="title">Hospodářské činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
						<td class="bar"><div class="value"></div><div class="graph"></div></td>
					</tr>
					<tr class="military last">
						<td class="title">Vojenské činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
						<td class="bar"><div class="value"></div><div class="graph"></div></td>
					</tr>
				</table>
			</section>
		</div>
	</div>
	<p class="compareNotice">Porovnávat je možné pouze zobrazení <a href="#" title="Zobrazit kraje" class="county">Kraje</a> nebo <a href="#" title="Zobrazit odbory" class="district">Územní odbory</a>.<p />
	<div class="secondCol">
		<header>
			<div class="selectWrapper">
				<select class="secondSelect chzn-select county" data-placeholder="Vyber územní jednotku">
				      <option value=""></option>
			            <option data-rank="1">Hlavní město Praha</option>
			            <option data-rank="2">Středočeský</option>
			            <option data-rank="3">Jihočeský</option>
			            <option data-rank="4">Plzeňský</option>
			            <option data-rank="5">Ústecký</option>
			            <option data-rank="6">Královéhradecký</option>
			            <option data-rank="7">Jihomoravský</option>
			            <option data-rank="8">Moravskoslezský</option>
			            <option data-rank="9">Olomoucký</option>
			            <option data-rank="10">Zlínský</option>
			            <option data-rank="11">Vysočina</option>
			            <option data-rank="12">Pardubický</option>
                        <option data-rank="13">Liberecký</option>
                        <option data-rank="14">Karlovarský</option>
                </select>
			</div>
			<div class="rank">
				<a href="#" class="rankUp" title="Pořadí nahoru"></a>
				<p title="Pořadí podle indexu kriminality (od nejvyššího k nejnižšímu)">10</p>
				<a href="#" class="rankDown" title="Pořadí dolů"></a>
			</div>
		</header>
		<div class="clearfix"></div>
		<div class="content">
			<section class="staticData">
				<table>
					<tr>
						<th>způsobená škoda</th>
						<th>počet policistů</th>
					</tr>
					<tr class="total">
						<td>-</td>
						<td>-</td>
					</tr>
				</table>
			</section>
			<div class="clearfix"></div>
			<section class="index">
				<h1>index kriminality</h1>
				<h2 class="value">-</h2>
				<div class="bar">
					<div class="graph"></div>
				</div>
			</section>
			<div class="clearfix"></div>
			<section class="total">
				<table>
					<tr>
						<th></th>
						<th class="first">Zjištěno</th>
						<th class="second">Objasněno</th>
						<th class="third">%</th>
					</tr>
					<tr class="values">
						<td>Trestné činy celkem</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
				</table>
			</section>
			<div class="clearfix"></div>
			<section class="table">
				<table>
					<tr class="violent">
						<td class="bar"><div class="graph"></div><div class="value"></div></td>
						<td class="title">Násilné činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
					<tr class="moral">
						<td class="bar"><div class="graph"></div><div class="value"></div></td>
						<td class="title">Mravnostní činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
					<tr class="burglary">
						<td class="bar"><div class="graph"></div><div class="value"></div></td>
						<td class="title">Krádeže vloupáním</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
					<tr class="theft">
						<td class="bar"><div class="graph"></div><div class="value"></div></td>
						<td class="title">Krádeže prosté</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
					<tr class="property">
						<td class="bar"><div class="graph"></div><div class="value"></div></td>
						<td class="title">Ostatní majetkové činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
					<tr class="other">
						<td class="bar"><div class="graph"></div><div class="value"></div></td>
						<td class="title">Ostatní činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
					<tr class="rest">
						<td class="bar"><div class="graph"></div><div class="value"></div></td>
						<td class="title">Zbývající činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
					<tr class="economic">
						<td class="bar"><div class="graph"></div><div class="value"></div></td>
						<td class="title">Hospodářské činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
					<tr class="military last">
						<td class="bar"><div class="graph"></div><div class="value"></div></td>
						<td class="title">Vojenské činy</td>
						<td class="first">-</td>
						<td class="second">-</td>
						<td class="third">-</td>
					</tr>
				</table>
			</section>
		</div>
	</div>
</div>


<div class="homepageTimeline">
	<div class="dateRange">
	       		<header>
	       			<span class="firstMonth"></span>
	       			<span class="firstYear"></span>
	       			<span class="white">-</span>
	       			<span class="secondMonth"></span>
	       			<span class="secondYear"></span>
	       			<div class="clearfix"></div>
	       		</header>
				<div class="content">
	       			<div class="firstDate">
	       				<ol class="month">
	       					<li data-month-index="1">Leden</li>
	       					<li data-month-index="2">Únor</li>
	       					<li data-month-index="3">Březen</li>
	       					<li data-month-index="4">Duben</li>
	       					<li data-month-index="5">Květen</li>
	       					<li data-month-index="6">Červen</li>
	       					<li data-month-index="7">Červenec</li>
	       					<li data-month-index="8">Srpen</li>
	       					<li data-month-index="9">Září</li>
	       					<li data-month-index="10">Říjen</li>
	       					<li data-month-index="11">Listopad</li>
	       					<li data-month-index="12">Prosinec</li>
	       				</ol>
	       				<ol class="year">
	       					<li>2010</li>
	       					<li>2011</li>
	       					<li>2012</li>
	       				</ol>
	       			</div>
	       			<div class="secondDate">
	       				<ol class="month">
	       					<li data-month-index="1">Leden</li>
	       					<li data-month-index="2">Únor</li>
	       					<li data-month-index="3">Březen</li>
	       					<li data-month-index="4">Duben</li>
	       					<li data-month-index="5">Květen</li>
	       					<li data-month-index="6">Červen</li>
	       					<li data-month-index="7">Červenec</li>
	       					<li data-month-index="8">Srpen</li>
	       					<li data-month-index="9">Září</li>
	       					<li data-month-index="10">Říjen</li>
	       					<li data-month-index="11">Listopad</li>
	       					<li data-month-index="12">Prosinec</li>
	       				</ol>
	       				<ol class="year">
<?php $iterations = 0; foreach ($years as $y): ?>
	       					<li><?php echo Nette\Templating\Helpers::escapeHtml($y, ENT_NOQUOTES) ?></li>
<?php $iterations++; endforeach ?>
	       				</ol>
	       			</div>
	       			<div class="clearfix" >
	       		</div>
		       	<footer>
		       		<div>
			       		<a href="#" class="ok" title="Potvrdit"><div></div></a>
			       		<a href="#" class="cancel" title="Zrušit"><div></div></a>
			       	</div>
		       	</footer>
			</div>
	</div>		
	<div class="dataView">
		<div class="leftArrow"></div>
		<div class="data">
			<div class="activeArea">
				<div class="left"></div>
				<div class="bar"></div>
				<div class="right"></div>
			</div>
			<ol>
			
			</ol>
		</div>
		<div class="rightArrow"></div>
	</div>
	
</div>
<div id="tabulkyPage" style="display:none;">
	<header class="select">
			<div class="left">
				<div class="unitsSelect">
					<p class="note">Přehled trestné činnosti za:</p>
					<div class="selectWrapper">
						<select class="chzn-select county" data-placeholder="Vyber územní jednotku">
						      <option value=""></option>
					            <option data-rank="1">Hlavní město Praha</option>
					            <option data-rank="2">Středočeský</option>
					            <option data-rank="3">Jihočeský</option>
					            <option data-rank="4">Plzeňský</option>
					            <option data-rank="5">Ústecký</option>
					            <option data-rank="6">Královéhradecký</option>
					            <option data-rank="7">Jihomoravský</option>
					            <option data-rank="8">Moravskoslezský</option>
					            <option data-rank="9">Olomoucký</option>
					            <option data-rank="10">Zlínský</option>
					            <option data-rank="11">Vysočina</option>
					            <option data-rank="12">Pardubický</option>
		                        <option data-rank="13">Liberecký</option>
		                        <option data-rank="14">Karlovarský</option>
		                </select>
					</div>
					<div class="rank">
						<a href="#" class="rankUp" title="Pořadí nahoru"></a>
						<p title="Pořadí podle indexu kriminality (od nejvyššího k nejnižšímu)">10</p>
						<a href="#" class="rankDown" title="Pořadí dolů"></a>
					</div>
				</div>
				<div class="crimesSelect">
					<p class="note">Žebříček krajů podle:</p>
					<div class="selectWrapper">
						<select class="chzn-select county" data-placeholder="Vyber typ trestného činu">
						      <option value=""></option>
					            <option data-type="violent">Násilné činy</option>
					            <option data-type="moral">Mravnostní činy</option>
					            <option data-type="burglary">Krádeže vloupáním</option>
					            <option data-type="theft">Krádeže prosté</option>
					            <option data-type="property">Ostatní majetkové činy</option>
					            <option data-type="other">Ostatní činy</option>
					            <option data-type="rest">Zbývající činy</option>
					            <option data-type="economic">Hospodářské činy</option>
					            <option data-type="military">Vojenské činy</option>
		                </select>
					</div>
				</div>
			</div>
			<div style="clear:both"></div>
	</header>
	<div class="content">
		<div class="firstCol">
			<section class="crimes">
				<header>
					<a href="#" class="downloadBtn"><div>Stáhnout data</div></a>
					<div class="first">Zjištěno</div>
					<div class="second">Objasněno</div>
				</header>
				<table class="total">
					<tr>
						<th class="first"></th>
						<th class="left">Počet</th>
						<th class="right">Index</th>
						<th class="left">Počet</th>
						<th class="right">%</th>
					</tr>
					<tr>
						<td class="first">Trestné činy</td>
						<td class="left">4 833 670</td>
						<td class="right">25</td>
						<td class="left">3 833 670</td>
						<td class="right">25</td>
					</tr>
				</table>
				<table class="types">
					<tr class="violent">
						<td class="first">Násilné činy</td>
						<td class="left">233 670</td>
						<td class="right">25</td>
						<td class="left">4 833 670</td>
						<td class="right">25</td>
						<td class="displayRank"><a href="*" class="displayRankBtn" title="Zobrazit žebříček"><div>Zobrazit žebříček</div></a></td>
					</tr>
					<tr class="moral">
						<td class="first">Mravnostní činy</td>
						<td class="left">533 670</td>
						<td class="right">25</td>
						<td class="left">433 670</td>
						<td class="right">25</td>
						<td class="displayRank"><a href="*" class="displayRankBtn" title="Zobrazit žebříček"><div>Zobrazit žebříček</div></a></td>
					</tr>
					<tr class="burglary">
						<td class="first">Krádeže vloupáním</td>
						<td class="left">833 670</td>
						<td class="right">25</td>
						<td class="left">633 670</td>
						<td class="right">25</td>
						<td class="displayRank"><a href="*" class="displayRankBtn" title="Zobrazit žebříček"><div>Zobrazit žebříček</div></a></td>
					</tr>
					<tr class="theft">
						<td class="first">Krádeže prosté</td>
						<td class="left">567 670</td>
						<td class="right">25</td>
						<td class="left">433 670</td>
						<td class="right">25</td>
						<td class="displayRank"><a href="*" class="displayRankBtn" title="Zobrazit žebříček"><div>Zobrazit žebříček</div></a></td>
					</tr>
					<tr class="property">
						<td class="first">Ostatní majetkové činy</td>
						<td class="left">87 670</td>
						<td class="right">25</td>
						<td class="left">33 670</td>
						<td class="right">25</td>
						<td class="displayRank"><a href="*" class="displayRankBtn" title="Zobrazit žebříček"><div>Zobrazit žebříček</div></a></td>
					</tr>
					<tr class="other">
						<td class="first">Ostatní činy</td>
						<td class="left">33 540</td>
						<td class="right">25</td>
						<td class="left">20 670</td>
						<td class="right">25</td>
						<td class="displayRank"><a href="*" class="displayRankBtn" title="Zobrazit žebříček"><div>Zobrazit žebříček</div></a></td>
					</tr>
					<tr class="rest">
						<td class="first">Zbývající činy</td>
						<td class="left">23 670</td>
						<td class="right">25</td>
						<td class="left">17 670</td>
						<td class="right">25</td>
						<td class="displayRank"><a href="*" class="displayRankBtn" title="Zobrazit žebříček"><div>Zobrazit žebříček</div></a></td>
					</tr>
					<tr class="economic">
						<td class="first">Hospodářské činy</td>
						<td class="left">13 670</td>
						<td class="right">25</td>
						<td class="left">8 670</td>
						<td class="right">25</td>
						<td class="displayRank"><a href="*" class="displayRankBtn" title="Zobrazit žebříček"><div>Zobrazit žebříček</div></a></td>
					</tr>
					<tr class="military">
						<td class="first">Vojenské činy</td>
						<td class="left">36 670</td>
						<td class="right">25</td>
						<td class="left">23 670</td>
						<td class="right">25</td>
						<td class="displayRank"><a href="*" class="displayRankBtn" title="Zobrazit žebříček"><div>Zobrazit žebříček</div></a></td>
					</tr>
				</table>
				<table class="general">
					<tr>
						<td class="first">Počet obyvatel</td>
						<td class="left">675 667</td>
					</tr>
					<tr>
						<td class="first">Počet policistů</td>
						<td class="left">675 667</td>
					</tr>
					<tr>
						<td class="first">Rozloha území</td>
						<td class="left">675 667</td>
					</tr>
					<tr>
						<td class="first">Index kriminality</td>
						<td class="left">675</td>
					</tr>
				</table>
			</section>
			<section class="rankings">
				<header>
					<a href="#" class="downloadBtn"><div>Stáhnout data</div></a>
					<div class="first">Zjištěno</div>
					<div class="second">Objasněno</div>
				</header>
				<table class="no-arrow">
					<tr class="header">
						<th class="index">#</th>
						<th class="first sortable">KRAJ</td>
						<th class="left hover sortable">Počet<span></span></th>
						<th class="right yellow hover sortable">Index<span></span></th>
						<th class="left sortable">Počet<span></span></th>
						<th class="right hover sortable">%<span></span></th>
					</tr>
					<tr class="first">
						<td>2</td>
						<td class="first">Jihomoravský kraj</td>
						<td class="left">3 833 670</td>
						<td class="right">21</td>
						<td class="left">2 833 670</td>
						<td class="right">25</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>13</td>
						<td class="first">Praha</td>
						<td class="left">4 833 670</td>
						<td class="right">250</td>
						<td class="left">3 25 670</td>
						<td class="right">150</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>15</td>
						<td class="first">Moravskoslezský kraj</td>
						<td class="left">2 033 670</td>
						<td class="right">10</td>
						<td class="left">1 833 670</td>
						<td class="right">12</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>16</td>
						<td class="first">Olomoucký kraj</td>
						<td class="left">3 833 670</td>
						<td class="right">12</td>
						<td class="left">1 342 670</td>
						<td class="right">25</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>10</td>
						<td class="first">Královéhradecký kraj</td>
						<td class="left">2 833 670</td>
						<td class="right">15</td>
						<td class="left">1 056 600</td>
						<td class="right">19</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>9</td>
						<td class="first">Středočeský kraj</td>
						<td class="left">4 032 400</td>
						<td class="right">28</td>
						<td class="left">3 023 500</td>
						<td class="right">25</td>
						<td class="displayRank"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>11</td>
						<td class="first">Ústecký kraj</td>
						<td class="left">3 234 000</td>
						<td class="right">21</td>
						<td class="left">1 432 340</td>
						<td class="right">25</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>6</td>
						<td class="first">Kraj Vysočina</td>
						<td class="left">2 321 670</td>
						<td class="right">20</td>
						<td class="left">1 213 670</td>
						<td class="right">20</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>3</td>
						<td class="first">Jihočeský kraj</td>
						<td class="left">4 833 670</td>
						<td class="right">25</td>
						<td class="left">4 833 670</td>
						<td class="right">25</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>7</td>
						<td class="first">Pardubický kraj</td>
						<td class="left">3 412 123</td>
						<td class="right">39</td>
						<td class="left">2 134 132</td>
						<td class="right">10</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>4</td>
						<td class="first">Zlínský kraj</td>
						<td class="left">2 421 412</td>
						<td class="right">32</td>
						<td class="left">1 754 521</td>
						<td class="right">20</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>8</td>
						<td class="first">Liberecký kraj</td>
						<td class="left">3 933 234</td>
						<td class="right">29</td>
						<td class="left">1 132 424</td>
						<td class="right">31</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>5</td>
						<td class="first">Plzeňský kraj</td>
						<td class="left">1 412 432</td>
						<td class="right">10</td>
						<td class="left">836 670</td>
						<td class="right">21</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
					<tr>
						<td>23</td>
						<td class="first">Karlovarský kraj</td>
						<td class="left">1 234 214</td>
						<td class="right">19</td>
						<td class="left">890 321</td>
						<td class="right">39</td>
						<td class="displayTypes"><a href="*" class="displayTypesBtn" title="Zobrazit přehled"><div>Zobrazit přehled</div></a></td>
					</tr>
				</table>
			</section>
		</div>
		<div class="secondCol">
			<h2>Další dokumenty ke stažení</h2>
			<section>
				<header>
					<div class="headerWrapper">
						<h3>ČR celkem</h3>
						<div class="hideBtn"></div>
					</div>
					<div class="clearfix"></div>
				</header>
				<div class="articleContent">
					<ul>
						<li class="pdf">
							<a href="http://www.google.com" target="_blank" title="Vraždy za minulý rok">
								<h4>Vraždy za minulý rok</h4>
								<p>Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu.</p>
							</a>
						</li>
						<li class="doc">
							<a href="http://www.google.com" target="_blank" title="Vraždy za minulý rok">
								<h4>Vraždy za minulý rok</h4>
								<p>Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu.</p>
							</a>
						</li>
					</ul>
				</div>
			</section>
			<section>
				<header>
					<div class="headerWrapper">
						<h3>Kraje</h3>
						<div class="hideBtn"></div>
					</div>
					<div class="clearfix"></div>
				</header>
				<div class="articleContent">
					<ul>
						<li class="pdf">
							<a href="http://www.google.com" target="_blank" title="Vraždy za minulý rok">
								<h4>Vraždy za minulý rok</h4>
								<p>Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu.</p>
							</a>
						</li>
						<li class="doc">
							<a href="http://www.google.com" target="_blank" title="Vraždy za minulý rok">
								<h4>Vraždy za minulý rok</h4>
								<p>Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu.</p>
							</a>
						</li>
					</ul>
				</div>
			</section>
			<section>
				<header>
					<div class="headerWrapper">
						<h3>Územní dokumenty</h3>
						<div class="hideBtn"></div>
					</div>
					<div class="clearfix"></div>
				</header>
				<div class="articleContent">
					<ul>
						<li class="pdf">
							<a href="http://www.google.com" target="_blank" title="Vraždy za minulý rok">
								<h4>Vraždy za minulý rok</h4>
								<p>Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu.</p>
							</a>
						</li>
						<li class="doc">
							<a href="http://www.google.com" target="_blank" title="Vraždy za minulý rok">
								<h4>Vraždy za minulý rok</h4>
								<p>Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu.</p>
							</a>
						</li>
					</ul>
				</div>
			</section>
			<section>
				<header>
					<div class="headerWrapper">
						<h3>Další odbory</h3>
						<div class="hideBtn"></div>
					</div>
					<div class="clearfix"></div>
				</header>
				<div class="articleContent">
					<ul>
						<li class="pdf">
							<a href="http://www.google.com" target="_blank" title="Vraždy za minulý rok">
								<h4>Vraždy za minulý rok</h4>
								<p>Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu.</p>
							</a>
						</li>
						<li class="doc">
							<a href="http://www.google.com" target="_blank" title="Vraždy za minulý rok">
								<h4>Vraždy za minulý rok</h4>
								<p>Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu. Policie je ozbrojená složka státu.</p>
							</a>
						</li>
					</ul>
				</div>
			</section>
		</div>
	</div>
</div>
<div class="mapDetailOverlayBack"></div>



 <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <!--<script>window.jQuery || document.write('<script src="<?php echo Nette\Templating\Helpers::escapeHtmlComment($basePath) ?>/js/libs/jquery-1.7.1.min.js"><\/script>')</script>-->
  <script>window.jQuery || document.write('<script src="<?php echo Nette\Templating\Helpers::escapeJs($basePath) ?>/js/libs/jquery-1.7.1.js"><\/script>')</script>
  <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB7MKCUedN9wCarH7GOll39ffkYwZjyHbk&sensor=false"> </script>

  
  <script type="text/javascript">
      
    function zoomOut()
    {
        if(fusionTable == countyTable)
        {
            $('.country').toggleClass('selected');
            $('.county').toggleClass('selected');
            fusionTable=countryTable; 
            Map.init(Config.map);
        }
        /*else if(fusionTable == '')
        {
            $('.district').toggleClass('selected');
            $('.county').toggleClass('selected');
            fusionTable=countyTable; 
            Map.init(Config.map);
        }*/
    }
    function zoomIn()
    {
        if(fusionTable == countryTable)
        {
            $('.country').toggleClass('selected');
            $('.county').toggleClass('selected');
            fusionTable=countyTable; 
            Map.init(Config.map);
        }
   /*     else if(fusionTable == countyTable)
        {
            $('.district').toggleClass('selected');
            $('.county').toggleClass('selected');
            fusionTable=''; 
            Map.init(Config.map);
        }*/
    }
    
    function showCountry()
    {
        Application.updateZoomLevel( 0 );
        
        $('.country div').addClass('selected');
        $('.county div').removeClass('selected');
        $('.district div').removeClass('selected');
        fusionTable=countryTable;
        $(".btn").css( { top: 0 } );
        Map.init(Config.map);

        storeTable("countryTable");
        
    }
    
    function showCounty()
    {
        Application.updateZoomLevel( 1 );
        
        $('.country div').removeClass('selected');
        $('.county div').addClass('selected');
        $('.district div').removeClass('selected');
        fusionTable=countyTable;
        $(".btn").css( { top: 0 } );
        Map.init(Config.map);

        storeTable("countyTable");
    }
    
    function showDistrict()
    {
        Application.updateZoomLevel( 2 );
       
        $('.country div').removeClass('selected');
        $('.county div').removeClass('selected');
        $('.district div').addClass('selected');
        fusionTable = districtTable;
        $(".btn").css( { top: 0 } );
        
        Map.init(Config.map);
 
        storeTable("districtTable");

        //call for populatin Porovnani selectBoxes
    }
  </script>
 
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/raphael-min.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/fusiontips_compiled.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/grid.locale-en.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/jquery.checkbox.min.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/jquery.event.drag-1.5.min.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/chosen.jquery.min.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/geostats.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/jenks.util.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/libs/sortable.js"></script>

  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/Config.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/DummyData.js"></script>

  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/Preloader.js"></script>

  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/model/DataProxy.js"></script>

  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/Infobox.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/Timeline.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/TimelineActiveArea.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/FilterBox.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/DynamicRange.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/Legend.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/DateModel.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/DateRange.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/ZoomControl.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/Homepage.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/homepage/Arc.js"></script>

  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/porovnani/PorovnaniSelectBox.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/porovnani/PorovnaniTable.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/porovnani/RankStepper.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/Porovnani.js"></script>

  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/tabulky/RankingSelectBox.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/tabulky/RankingsTable.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/tabulky/TypesTable.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/Tabulky.js"></script>
    
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/ContactForm.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/LogIn.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/AboutApplication.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/vypis/Vypis.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/MapDetailOverlay.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/MapOverviewPopUp.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/DynamicRange.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/Map.js"></script>      
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/Navigation.js"></script>

  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/Application.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/plugins.js"></script>
  <script src="<?php echo htmlSpecialChars($basePath) ?>/js/script.js"></script>
  
<?php
}}

//
// block head
//
if (!function_exists($_l->blocks['head'][] = '_lb9221c022ba_head')) { function _lb9221c022ba_head($_l, $_args) { extract($_args)
?><script type="text/javascript">
      var countryTable = "1HdmQ31tjhBya7sIebd0hC7J7SFCox1148ZpQJJc";
      var countyTable = "1rgNjSoo31Nvr9Ka7d6Jj5sK9WB3TObhr8w78Ptk";
      var districtTable = "18Xvwpslx0is1BO5orzDPW4km_Npayy1J1lnut2M";
      var area = <?php echo $area ?>;
      var dateFrom = { year: <?php echo $firstDate['year'] ?>, month: <?php echo $firstDate['month'] ?>};
      var dateTo = { year: <?php echo $secondDate['year'] ?>, month: <?php echo $secondDate['month'] ?>};
      var filters = "<?php echo $filters ?>";
      
      var fusionTable = <?php echo $table ?>;
</script>
  
<?php
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
if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars())  ?>


<?php call_user_func(reset($_l->blocks['head']), $_l, get_defined_vars()) ; 