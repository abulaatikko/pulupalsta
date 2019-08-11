<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'About - Pulupalsta') ?>
<?php $view['slots']->set('description', 'Technical and historical details of Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<br>
<p>Pulupalsta is an experiment. It's a project to learn web development, writing and life all-around.</p>

<p>The first article was written in 2006. The site got significant upgrades in 2012 and 2019. See <a href="<?php echo $view['assets']->getUrl('bundles/pulupalsta/text/CHANGELOG.txt') ?>">CHANGELOG.txt</a> for more history details.</p>

<!--<p>IRCnet channel #pulupalsta exists.</p>-->

<p>The current version uses technologies such as PHP 7.2, Ubuntu 19.04, Symfony 3.4, PostgreSQL 10.6, CSS Foundation 2.0, jQuery 1.8.</p>

<?php
$tz  = new DateTimeZone('Europe/Helsinki');
$age = DateTime::createFromFormat('Y-m-d', '1983-02-25', $tz)
     ->diff(new DateTime('now', $tz))
     ->y;
?>

<?php $view['slots']->stop() ?>
