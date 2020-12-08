<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Z: About') ?>

<?php $view['slots']->set('description', 'Background information of Project-Z') ?>

<?php $view['slots']->start('body') ?>

<h1>About</h1>

<p>Puluprojects aka Pulupalsta aka Pulu-Z aka Project-Z is a private platform to publish texts and other material. The first article was written in 2006: <a href="https://z.pulu.org/fi/1-1500-litraa-pepsia-ja-sony-vaio-s5">1500 litraa Pepsiä ja Sony Vaio S5</a>. Other popular articles are <a href="https://z.pulu.org/fi/10-mcdonalds-juustohampurilaisten-syontikilpailu">McDonald's-juustohampurilaisten syöntikilpailu</a>, <a href="https://z.pulu.org/fi/51-suomen-kunnantalot">Finnish Townhalls</a> and <a href="https://z.pulu.org/en/60-elasto-mania-1995-2018">Elasto Mania (1995&ndash;2018)</a>. World travelling started from London in 2011.</p>

<p>The site was created in 2006 and got significant upgrades in 2012 and 2019. <a href="<?php echo $view['assets']->getUrl('bundles/pulupalsta/text/CHANGELOG.txt') ?>">CHANGELOG.txt</a> exists.</p>

<p><em>Updated in 2020-02-28</em></p>

<?php
$tz  = new DateTimeZone('Europe/Helsinki');
$age = DateTime::createFromFormat('Y-m-d', '1983-02-25', $tz)
     ->diff(new DateTime('now', $tz))
     ->y;
?>

<?php $view['slots']->stop() ?>
