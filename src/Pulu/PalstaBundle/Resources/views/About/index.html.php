<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Tietoa sivustosta') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1><?php echo $view['translator']->trans('Tietoa sivustosta') ?></h1>

<h2><?php echo $view['translator']->trans('Mitä ja miksi') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p><em>Pulupalsta</em> sisältää tarinoita elämästäni, joita mielelläni muistelen. Parhaimmassa tapauksessa tarinat kiinnostavat myös muita ihmisiä ja sen takia olen kirjoituksiani julkaissut. Haaveilen että kirjoituksillani olisi joskus laajempaakin merkittävyyttä, mutta nykymaailman informaatiotulvassa ei ole sijaa keskinkertaisille kirjoituksille. Pitää siis tavoitella priimaa!</p>
<?php else: ?>
<p><em>Pulupalsta</em> (literally <em>column of the dove</em>) contains stories of my life which are, in my opinion, worth remembering. The reason to publish them is my humble wish that the stories might interest other people too. My goal is to write something more remarkable in the future but because the world is overfilled by very interesting information, there is no room for second rate stories. So let's go for the top!</p>
<?php endif ?>

<?php if ($currentLocale == 'fi'): ?>
<p>Pidän web-sivujen tekemisestä, jota tämä projekti myös palvelee. Teen Pulupalstaa yksin ja vain yksin, joten kukaan muu ei ole asettamassa projektille reunaehtoja. Voin siis tehdä sivustoa milloin huvittaa ja kuten haluan.</p>
<?php else: ?>
<p>I love creating web sites which is the main reason for this site - to be honest. I'm making Pulupalsta alone and only alone and thereby no one else is setting limits or giving me deadlines. This is not always the case.</p>
<?php endif ?>

<h2><?php echo $view['translator']->trans('Milloin') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p>Kirjoitin ensimmäisen artikkelini (<a href="http://palsta.pulu.org/fi/1-1500-litraa-pepsiC3A4-ja-sony-vaio-s5">1500 litraa Pepsiä ja Sony Vaio S5</a>) tammikuussa 2006. Projekti, jota artikkeli käsittelee, oli pääasiallinen syy silloin <em>Puluprojects</em>-nimellä kulkeneen sivuston tekemiselle. Myöhemmin aloin kirjoitella artikkeleita myös <a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'published')) ?>">muista aiheista</a>. Halusin siis rakentaa julkaisualustan kirjoituksilleni.</p>
<?php else: ?>
<p>My first article (<a href="http://palsta.pulu.org/fi/1-1500-litraa-pepsiC3A4-ja-sony-vaio-s5">1500 litres of Pepsi and Sony Vaio S5</a>) was written in January 2006. The project, which the article is discussing, was a primary reason to create this site. It was called <em>Puluprojects</em> back then. Later I've written texts about <a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'published')) ?>">other subjects</a> too. So basically I wanted to build a platform to publish my own writings.</p>
<?php endif ?>

<?php if ($currentLocale == 'fi'): ?>
<p>Seuraavien vuosien aikana valmistuin, sain töitä web-alan ohjelmistosuunnittelijana ja kirjoittelin noin neljän artikkelin vuosivauhdilla uusia tekstejä. Julkaisualusta oli ollut alusta asti turhan kömpelö, mutta vasta vuoden 2012 jälkimmäisellä puoliskolla löysin viimein aikaa alkaa uudistaa sivustoa. Ja oikeastaan silloinkin ensisijainen syy oli halu kokeilla <a href="http://symfony.com/">Symfony2 PHP Frameworkia</a> käytännössä, jonka ensimmäiseksi harjoitusprojektiksi valitsin tämän sivuston siirtämisen uudelle alustalle. Samalla sivuston uudeksi nimeksi tuli Pulupalsta.</p>
<?php else: ?>
<p>During the next years I graduated, got a full-time web developer job and wrote circa four articles each year. The platform wasn't great from the maintaining point of view when I created it first time but it still took me six years to finally improve the system. And actually even then the main reason was to try out <a href="http://symfony.com/">Symfony2 PHP Framework</a> in practice. Upgrading Puluprojects was a good exercise. Then the name was also changed to Pulupalsta.</p>
<?php endif ?>

<p><a href="<?php echo $view['assets']->getUrl('bundles/pulupalsta/text/CHANGELOG.md') ?>">CHANGELOG.md</a></p>

<h2><?php echo $view['translator']->trans('Miten') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p style="margin-bottom: 5px">Pulupalstan lähdekoodi on <a href="https://github.com/lassiheikkinen/pulupalsta">GitHub</a>-palvelussa. Sivusto on rakennettu seuraavien teknologioiden varaan:</p>
<?php else: ?>
<p style="margin-bottom: 5px">The source of Pulupalsta can be read in <a href="https://github.com/lassiheikkinen/pulupalsta">GitHub</a>. The site is built on:</p>
<?php endif ?>
<ul class="square">
    <li><a href="http://www.debian.org/">Debian</a></li>
    <li><a href="http://www.apache.org/">Apache</a></li>
    <li><a href="http://php.net/">PHP</a>: <a href="http://symfony.com/">Symfony</a></li>
    <li><a href="http://www.postgresql.org/">PostgreSQL</a></li>
    <li><a href="http://en.wikipedia.org/wiki/HTML">HTML</a>: <a href="http://html5boilerplate.com/">HTML5 Boilerplate</a></li>
    <li><a href="http://en.wikipedia.org/wiki/CSS">CSS</a>: <a href="http://foundation.zurb.com/">Foundation</a></li>
    <li><a href="http://en.wikipedia.org/wiki/JavaScript">JavaScript</a>:
        <a href="http://jquery.com/">JQuery</a>,
        <a href="http://fabien-d.github.com/alertify.js/">Alertify</a>,
        <a href="http://datatables.net/">DataTables</a>,
        <a href="http://fancybox.net/">Fancybox</a></li>
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
<p>Nimeni on Lassi Heikkinen ja internet-maailmassa minut tunnetaan myös nimimerkillä Abula. Olen <?php echo $age ?> vuotta vanha ja asun Kuopiossa. Enemmän tietoa minusta löytyy <a href="http://lassi.pulu.org/">henkilökohtaisilta sivuiltani</a>.</p>
<?php else: ?>
<p>My name is Lassi Heikkinen and I'm also known as Abula in the internet. I'm <?php echo $age ?> years old and living in Kuopio. More about me you can read on my <a href="http://lassi.pulu.org/">personal page</a>.</p>
<?php endif ?>

<?php $view['slots']->stop() ?>
