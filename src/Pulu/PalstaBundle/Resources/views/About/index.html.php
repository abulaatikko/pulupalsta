<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'About - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1>?</h1>

<p>Pulupalsta is a playground project to practice web development, writing, reporting and life in general. Many texts are mostly personal memories, especially earlier ones (2006-2016).</p>

<p>The website was created and <a href="/fi/1-1500-litraa-pepsiC3A4-ja-sony-vaio-s5">the first article</a> was written in January 2006. The site got significant upgrades in 2012 and 2019. See <a href="<?php echo $view['assets']->getUrl('bundles/pulupalsta/text/CHANGELOG.txt') ?>">CHANGELOG.txt</a> for more history details.</p>

<p>The current version uses technologies such as PHP 7.2, Ubuntu 19.04, Symfony 3.4, PostgreSQL 10.6, CSS Foundation 2.0, jQuery 1.8.</p>

<?php
$tz  = new DateTimeZone('Europe/Helsinki');
$age = DateTime::createFromFormat('Y-m-d', '1983-02-25', $tz)
     ->diff(new DateTime('now', $tz))
     ->y;
?>

<?php $view['slots']->stop() ?>
