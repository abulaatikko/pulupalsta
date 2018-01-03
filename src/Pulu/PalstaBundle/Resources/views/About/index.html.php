<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Tietoa sivustosta') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1><?php echo $view['translator']->trans('Tietoa sivustosta') ?></h1>

<h2><?php echo $view['translator']->trans('Mitä ja miksi') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p><em>Pulupalsta</em> sisältää tarinoita elämästäni, joita mielelläni muistelen. Haaveilen että kirjoituksillani olisi joskus suurempaakin merkittävyyttä, mutta se ei ole nykymaailman informaatiotulvassa aivan helppoa. Tavoiteltakoon siis priimaa!</p>
<?php else: ?>
<p><em>Pulupalsta</em> (lit. <em>dove's column</em>) contains stories of my personal life which are, in my opinion, worth telling. The goal is to produce interesting information for wider audience too but it's not easy in the world which is already overfilled by high-quality information. The only way is to go for the top!</p>
<?php endif ?>

<?php if ($currentLocale == 'fi'): ?>
<p>Pidän web-sivujen tekemisestä, jota tämä projekti myös palvelee. Lisäksi kirjoittaminen on hyvä tapa jäsentää ajatuksia, mikä taas tukee oppimista.</p>
<?php else: ?>
<p>I love creating websites which is major reason for this site. Writing also helps to clarify thoughts which supports learning.</p>
<?php endif ?>

<h2><?php echo $view['translator']->trans('Milloin') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p>Kirjoitin ensimmäisen artikkelini (<a href="http://palsta.pulu.org/fi/1-1500-litraa-pepsiC3A4-ja-sony-vaio-s5">1500 litraa Pepsiä ja Sony Vaio S5</a>) tammikuussa 2006. Projekti, jota artikkeli käsittelee, oli pääasiallinen syy silloin <em>Puluprojects</em>-nimellä kulkeneen sivuston tekemiselle. Myöhemmin olen kirjoittanut myös monista muista aiheista.</p>
<?php else: ?>
<p>My first article (<a href="http://palsta.pulu.org/fi/1-1500-litraa-pepsiC3A4-ja-sony-vaio-s5">1500 litres of Pepsi and Sony Vaio S5</a>) was written in January 2006. The Pepsi project was the primary reason to create this site, titled <em>Puluprojects</em> back then. Later I've produced texts about many other topics too.</p>
<?php endif ?>

<?php if ($currentLocale == 'fi'): ?>
<p>Julkaisualusta oli aluksi hyvin kömpelö, mutta viimein vuonna 2012 sain aikaa uudistaa sivustoa isolla kädellä, kun oli myös kiinnostus kokeilla jotain modernia PHP-frameworkia käytännön työssä. Samalla sivuston nimi vaihtui Pulupalstaksi.</p>
<?php else: ?>
<p>The platform wasn't great in the beginning and it took me six years to finally improve the system. Upgrading the site was also a good exercise to try out a PHP framework in practice. The name was changed to Pulupalsta back then.</p>
<?php endif ?>

<p><a href="<?php echo $view['assets']->getUrl('bundles/pulupalsta/text/CHANGELOG.txt') ?>">CHANGELOG.txt</a></p>

<h2><?php echo $view['translator']->trans('Miten') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p style="margin-bottom: 5px">Pulupalstan lähdekoodi on <a href="https://github.com/lassiheikkinen/pulupalsta">GitHub</a>-palvelussa. Sivusto on rakennettu seuraavien teknologioiden varaan:</p>
<?php else: ?>
<p style="margin-bottom: 5px">The source of Pulupalsta can be viewed in <a href="https://github.com/lassiheikkinen/pulupalsta">GitHub</a>. The site is built on:</p>
<?php endif ?>
<ul class="square">
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
<p>Nimeni on Lassi Heikkinen ja internet-maailmassa minut tunnetaan myös nimimerkillä Abula. Olen <?php echo $age ?> vuotta vanha ja asun Helsingissä. Olen ammatiltani web-kehittäjä, mutta tällä sivustolla olennaisinta on kuitenkin sisältö. Enemmän tietoa minusta löytyy <a href="http://lassi.pulu.org/">henkilökohtaisilta sivuiltani</a>.</p>
<?php else: ?>
<p>My name is Lassi Heikkinen and I'm also known as Abula in the internet. I'm <?php echo $age ?> years old and living in Helsinki. My profession is a web developer, however, contents is the point of this site. More about me on my <a href="http://lassi.pulu.org/">personal page</a>.</p>
<?php endif ?>

<?php $view['slots']->stop() ?>
