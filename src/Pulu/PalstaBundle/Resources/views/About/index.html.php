<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Tietoa sivustosta') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1><?php echo $view['translator']->trans('Tietoa') ?></h1>

<h2><?php echo $view['translator']->trans('Mitä ja miksi') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p>Pulupalsta on kokoelma seikkailujani sekä erilaisista tutkielmia. Projekti palvelee myös ammatillista osaamistani, jonka keskiössä web-sivut ovat.</p>

<?php else: ?>
<p>Pulupalsta (lit. <em>dove's column</em>) is a collection of my adventures and different explorations. The project is also a playground for my professional skills.</p>

<?php endif ?>

<h2><?php echo $view['translator']->trans('Milloin') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p>Kirjoitin ensimmäisen artikkelini (<a href="http://palsta.pulu.org/fi/1-1500-litraa-pepsiC3A4-ja-sony-vaio-s5">1500 litraa Pepsiä ja Sony Vaio S5</a>) tammikuussa 2006. Projekti jota artikkeli käsittelee, oli pääasiallinen syy silloin <em>Puluprojects</em>-nimellä kulkeneen sivuston tekemiselle.</p>
<?php else: ?>
<p>My first article (<a href="http://palsta.pulu.org/fi/1-1500-litraa-pepsiC3A4-ja-sony-vaio-s5">1500 litres of Pepsi and Sony Vaio S5</a>) was written in January 2006. The Pepsi project was the primary reason to create this site, titled <em>Puluprojects</em> back then.</p>
<?php endif ?>

<?php if ($currentLocale == 'fi'): ?>
<p>Julkaisualusta siirrettiin PHP frameworkin päälle vuonna 2012, jolloin myös nimi vaihtui nykyiseksi.</p>
<?php else: ?>
<p>The platform was upgraded to PHP framework in 2012 when the name was also changed to the current one.</p>
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

<?php
$tz  = new DateTimeZone('Europe/Helsinki');
$age = DateTime::createFromFormat('Y-m-d', '1983-02-25', $tz)
     ->diff(new DateTime('now', $tz))
     ->y;
?>

<h2><?php echo $view['translator']->trans('Kuka') ?>?</h2>
<?php if ($currentLocale == 'fi'): ?>
<p>Nimeni on Lassi Heikkinen ja internet-maailmassa minut tunnetaan myös nimimerkillä Abula. Olen <?php echo $age ?> vuotta vanha ja asun Helsingissä. Enemmän tietoa minusta löytyy <a href="http://lassi.pulu.org/">henkilökohtaiselta sivultani</a>.</p>
<?php else: ?>
<p>My name is Lassi Heikkinen and I'm also known as Abula in the internet. I'm <?php echo $age ?> years old and living in Helsinki. More about me on my <a href="http://lassi.pulu.org/">personal page</a>.</p>
<?php endif ?>

<?php if ($currentLocale == 'fi'): ?>
<p>Projektia voi tukea: 19RoPRBgnUzWoQvaJ8hPx8m1yywVcxRs5W (bitcoin).</p>
<?php else: ?>
<p>It's possible to support the project: 19RoPRBgnUzWoQvaJ8hPx8m1yywVcxRs5W (bitcoin).</p>
<?php endif ?>


<?php $view['slots']->stop() ?>
