<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Tietoa sivustosta') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1><?php echo $view['translator']->trans('Tietoa sivustosta') ?></h1>

<h2><?php echo $view['translator']->trans('Mitä ja miksi') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p>Pulupalsta on kokoelma tarinoita elämästäni, joita mielelläni muistelen. Parhaimmassa
tapauksessa tarinat kiinnostavat myös muita ihmisiä ja sen takia olen kirjoituksiani
julkaissut. Haaveilen, että kirjoituksillani olisi joskus laajempaakin merkittävyyttä, 
mutta nykymaailman informaatiotulvassa ei ole sijaa keskinkertaisille kirjoituksille. 
Pitää siis tavoitella priimaa!</p>
<?php else: ?>
<p>Pulupalsta (literally <em>column of the dove</em>) is a collection of stories
of my life which are, in my opionion, worth remembering. The reason to publish them
is my humble wish that the stories might interest other people too. My goal is to 
write something more relevant in the future but because the world is extremely
overfilled by very interesting information, there is no room for second rate stories.
So let's reach the top!</p>
<?php endif ?>

<?php if ($currentLocale == 'fi'): ?>
<p>Pidän web-sivujen tekemisestä, jota tämä projekti myös palvelee. Teen Pulupalstaa yksin ja
vain yksin, joten kukaan muu ei ole asettamassa projektille reunaehtoja. Voin siis tehdä 
sivustoa, milloin huvittaa ja kuten haluan.</p>
<?php else: ?>
<p>I like creating web sites which is the main reason for this site, if being honest. I'm 
making Pulupalsta alone and only alone and therefore no one else is setting limits or 
giving me deadlines. This is usually not the case.</p>
<?php endif ?>

<h2><?php echo $view['translator']->trans('Milloin') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p>Kirjoitin ensimmäisen artikkelini
(<a href="http://pulu.org/pro/1-1500-litraa-pepsia-ja-sony-vaio-s5">1500 litraa Pepsiä ja Sony Vaio S5</a>) 
tammikuussa 2006. Projekti, jota artikkeli käsittelee, oli pääasiallinen syy silloin
Puluprojects-nimellä kulkeneen sivuston tekemiselle. 
<a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'created')) ?>">Myöhemmin</a>
aloin kirjoitella artikkeleita myös muista aiheista. Halusin siis saada oman julkaisualustan 
projekteilleni.</p>
<?php else: ?>
<p>My first article was
(<a href="http://pulu.org/pro/1-1500-litraa-pepsia-ja-sony-vaio-s5">1500 litres of Pepsi and Sony Vaio S5</a>)
in January 2006. The project, which the article is discussing, was the primary reason to 
create this site. It was called Puluprojects back then.
<a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'created')) ?>">Later</a>
I've written texts about other subjects too. So I wanted to have own platform to publish 
my writings.</p>
<?php endif ?>

<?php if ($currentLocale == 'fi'): ?>
<p>Seuraavien vuosien aikana valmistuin, sain töitä web-alan ohjelmistosuunnittelijana
ja kirjoittelin noin neljän artikkelin vuosivauhdilla uusia tekstejä. Julkaisualusta oli
ollut alusta asti turhan kömpelö, mutta vasta vuoden 2012 jälkimmäisellä puoliskolla löysin
viimein aikaa alkaa uudistaa sivustoa. Oikeastaan halusin kokeilla 
<a href="http://symfony.com/">Symfony2 PHP Frameworkia</a> käytännössä ja valitsin ensimmäiseksi
testiprojektiksi tämän sivuston siirtämisen uudelle alustalle. Samalla sivuston uudeksi 
nimeksi vaihtui Pulupalsta.</p>
<?php else: ?>
<p>During the next years I graduated, got a full-time web developer job and wrote about
four articles each year. The platform wasn't great when I created it first time but it took
six years to finally improve the system. And actually even then the main reason was to try out
<a href="http://symfony.com/">Symfony2 PHP Framework</a> in practice. Upgrading Puluprojects
was a good test project. Then the name was also changed.</p>
<?php endif ?>

<h2><?php echo $view['translator']->trans('Miten') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p style="margin-bottom: 5px">Sivusto on rakennettu seuraavien teknologioiden varaan:</p>
<?php else: ?>
<p style="margin-bottom: 5px">The site is built on:</p>
<?php endif ?>
<ul class="square">
    <li><a href="http://www.debian.org/">Debian</a></li>
    <li><a href="http://www.apache.org/">Apache</a></li>
    <li><a href="http://php.net/">PHP</a>: <a href="http://symfony.com/">Symfony</a></li>
    <li><a href="http://www.postgresql.org/">PostgreSQL</a></li>
    <li><a href="http://en.wikipedia.org/wiki/HTML">HTML</a>: <a href="http://html5boilerplate.com/">HTML5 Boilerplate</a></li>
    <li><a href="http://en.wikipedia.org/wiki/CSS">CSS</a>: <a href="http://foundation.zurb.com/">Foundation</a></li>
    <li><a href="http://en.wikipedia.org/wiki/JavaScript">JavaScript</a>: <a href="http://jquery.com/">JQuery</a>, 
        <a href="http://fabien-d.github.com/alertify.js/">Alertify</a>, <a href="http://datatables.net/">DataTables</a></li>
</ul>

<?php if ($currentLocale == 'fi'): ?>
<p>Avoimen lähdekoodin ohjelmistot ovat ihailtavaa kansalaistoimintaa. Ne antavat uskoa ihmiskuntaan.</p>
<?php else: ?>
<p>Open source software is something to really admire. There's hope for humanity.</p>
<?php endif ?>

<?php
$tz  = new DateTimeZone('Europe/Helsinki');
$age = DateTime::createFromFormat('Y-m-d', '1983-02-25', $tz)
     ->diff(new DateTime('now', $tz))
     ->y;
?>

<h2><?php echo $view['translator']->trans('Kuka') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p>Nimeni on Lassi Heikkinen ja internet-maailmassa minut tunnetaan nimimerkillä Abula.
Olen <?php echo $age ?> vuotta vanha ja asun Kuopiossa yhdessä valittuni kanssa. Enemmän tietoa minusta
löytyy <a href="http://www.pulu.org/lassi">henkilökohtaisilta sivuiltani</a>.</p>
<?php else: ?>
<p>My name is Lassi Heikkinen and I'm known as Abula in the internet. I'm <?php echo $age ?> years 
old and living in Kuopio (Finland) with my beloved one. More about me you can read on my 
<a href="http://www.pulu.org/lassi/eng">personal page</a>.</p>
<?php endif ?>

<?php $view['slots']->stop() ?>