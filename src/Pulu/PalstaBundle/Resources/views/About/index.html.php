<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'About - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1>?</h1>

<p>Pulupalsta is a playground project to practice web development, writing and life in general. Also personal memories and some fun.</p>

<p>The first article (<a href="http://palsta.pulu.org/fi/1-1500-litraa-pepsiC3A4-ja-sony-vaio-s5">1500 litres of Pepsi and Sony Vaio S5</a>) was written in January 2006. The Pepsi project was a primary reason to create this web site, titled <em>Puluprojects</em> back then. The site was heavily updated in 2012 and 2019. See <a href="<?php echo $view['assets']->getUrl('bundles/pulupalsta/text/CHANGELOG.txt') ?>">CHANGELOG.txt</a> for more history details.</p>

<?php
$tz  = new DateTimeZone('Europe/Helsinki');
$age = DateTime::createFromFormat('Y-m-d', '1983-02-25', $tz)
     ->diff(new DateTime('now', $tz))
     ->y;
?>

<?php $view['slots']->stop() ?>
