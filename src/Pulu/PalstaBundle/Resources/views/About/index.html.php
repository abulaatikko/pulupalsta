<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Tietoa') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1><?php echo $view['translator']->trans('Tietoa sivustosta') ?></h1>

<h2><?php echo $view['translator']->trans('Mitä ja miksi') ?>?</h2>
<p>Pulupalsta on kokoelma tarinoita elämästäni, joita mielelläni muistelen. Parhaimmassa
tapauksessa tarinat kiinnostavat myös muita ihmisiä ja sen takia olen kirjoituksiani
julkaissut. Haaveilen, että kirjoituksillani olisi joskus laajempaakin merkittävyyttä, 
mutta nykymaailman informaatiotulvassa ei ole sijaa keskinkertaisille kirjoituksille. 
Pitää siis pyrkiä priimaan!</p>

<p>Pidän web-sivujen tekemisestä, jota tämä projekti myös palvelee. Teen sivustoa yksin ja
vain yksin, joten kukaan muu ei ole asettamassa projektille reunaehtoja. Voin siis tehdä 
sivustoa, milloin huvittaa ja kuten haluan.</p>

<h2><?php echo $view['translator']->trans('Milloin') ?>?</h2>
<p>Kirjoitin ensimmäisen artikkelini
(<a href="http://pulu.org/pro/1-1500-litraa-pepsia-ja-sony-vaio-s5">1500 litraa Pepsiä ja Sony Vaio S5</a>) 
tammikuussa 2006. Projekti, jota artikkeli käsittelee, oli pääasiallinen syy silloin
Puluprojects-nimellä kulkeneen sivuston tekemiselle. 
<a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'created')) ?>">Myöhemmin</a>
aloin kirjoitella artikkeleita myös muista aiheista. Halusin siis saada oman julkaisualustan 
projekteilleni.</p>

<p>Seuraavien vuosien aikana valmistuin, sain töitä web-alan ohjelmistosuunnittelijana
ja kirjoittelin noin neljän artikkelin vuosivauhdilla uusia tekstejä. Julkaisualusta oli
ollut alusta asti turhan kömpelö, mutta vasta vuoden 2012 jälkimmäisellä puoliskolla löysin
viimein aikaa alkaa uudistaa sivustoa. Oikeastaan halusin kokeilla 
<a href="http://symfony.com/">Symfony2 PHP Frameworkia</a> käytännössä ja valitsin ensimmäiseksi
testiprojektiksi tämän sivuston siirtämisen uudelle alustalle. Samalla sivuston uudeksi 
nimeksi vaihtui Pulupalsta.</p>

<h2><?php echo $view['translator']->trans('Miten') ?>?</h2>
<p style="margin-bottom: 5px">Sivusto on rakennettu seuraavien teknologioiden varaan:</p>
<ul class="disc">
    <li><a href="http://www.debian.org/">Debian</a></li>
    <li><a href="http://www.apache.org/">Apache</a></li>
    <li><a href="http://php.net/">PHP</a>: <a href="http://symfony.com/">Symfony</a></li>
    <li><a href="http://www.postgresql.org/">PostgreSQL</a></li>
    <li><a href="http://en.wikipedia.org/wiki/HTML">HTML</a>: <a href="http://html5boilerplate.com/">HTML5 Boilerplate</a></li>
    <li><a href="http://en.wikipedia.org/wiki/CSS">CSS</a>: <a href="http://foundation.zurb.com/">Foundation</a></li>
    <li><a href="http://en.wikipedia.org/wiki/JavaScript">JavaScript</a>: <a href="http://jquery.com/">JQuery</a>, 
        <a href="http://fabien-d.github.com/alertify.js/">Alertify</a>, <a href="http://datatables.net/">DataTables</a></li>
</ul>

<p>Suosin siis avoimen lähdekoodin ohjelmistoja, koska ne ovat ilmaisia ja edustavat 
ihailtavaa kansalaistoimintaa.</p>

<?php
$tz  = new DateTimeZone('Europe/Helsinki');
$age = DateTime::createFromFormat('Y-m-d', '1983-02-25', $tz)
     ->diff(new DateTime('now', $tz))
     ->y;
?>

<h2><?php echo $view['translator']->trans('Kuka') ?>?</h2>
<p>Nimeni on Lassi Heikkinen ja internet-maailmassa minut tunnetaan nimimerkillä Abula.
Olen <?php echo $age ?> vuotta vanha ja asun Kuopiossa yhdessä avopuolisoni kanssa. Enemmän tietoa minusta
löytyy <a href="http://www.pulu.org/lassi">henkilökohtaisilta sivuiltani</a>.</p>

<?php $view['slots']->stop() ?>