<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'About - Pulupalsta') ?>
<?php $view['slots']->set('description', 'Background information of Pulupalsta, The Public Archive of the Empire of Pulu') ?>

<?php $view['slots']->start('body') ?>

<h1>About</h1>

<p>Pulupalsta is a private platform to publish texts and other material. The first article was written in 2006: <a href="https://palsta.pulu.org/fi/1-1500-litraa-pepsia-ja-sony-vaio-s5">1500 litraa Pepsiä ja Sony Vaio S5</a>. World travelling started from London in 2011. A digital sub-cultural research was done in 2018: <a href="https://palsta.pulu.org/en/60-elasto-mania-1995-2018">Elasto Mania (1995&ndash;2018)</a></p>

<p>The site itself got significant upgrades in 2012 and 2019. <a href="<?php echo $view['assets']->getUrl('bundles/pulupalsta/text/CHANGELOG.txt') ?>">CHANGELOG.txt</a> exists.</p>

<p><em>Updated in 2020-02-28</em></p>

<?php
$tz  = new DateTimeZone('Europe/Helsinki');
$age = DateTime::createFromFormat('Y-m-d', '1983-02-25', $tz)
     ->diff(new DateTime('now', $tz))
     ->y;
?>

<?php $view['slots']->stop() ?>
