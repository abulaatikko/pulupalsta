<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'About - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1>About</h1>

<h2>What and why?</h2>
<p>Pulupalsta is a sandbox project to practice web development skills. Additionally it's a platform to publish random texts like travel reports, training logs, essays and different kind of studies. And why? It's fun.</p>

<h2>When it started?</h2>
<p>The first article (<a href="http://palsta.pulu.org/fi/1-1500-litraa-pepsiC3A4-ja-sony-vaio-s5">1500 litres of Pepsi and Sony Vaio S5</a>) was written in January 2006. The Pepsi project was a primary reason to create this web site, titled <em>Puluprojects</em> back then. The platform was upgraded to Symfony PHP framework in 2012. Check out the <a href="<?php echo $view['assets']->getUrl('bundles/pulupalsta/text/CHANGELOG.txt') ?>">CHANGELOG.txt</a> for more history details.</p>

<?php
$tz  = new DateTimeZone('Europe/Helsinki');
$age = DateTime::createFromFormat('Y-m-d', '1983-02-25', $tz)
     ->diff(new DateTime('now', $tz))
     ->y;
?>

<h2>And you?</h2>
<p>I'm Lassi (aka Abula), <?php echo $age ?> years old, living in Helsinki. I've got an <a href="https://lassi.pulu.org/">online CV</a>.</p>

<?php $view['slots']->stop() ?>
