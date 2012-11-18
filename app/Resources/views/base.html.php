<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta name="description" content="">
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width" />
    <title><?php $view['slots']->output('title', 'Pulupalsta') ?></title>
    <?php foreach ($view['assetic']->stylesheets(
        array(
            '@PuluPalstaBundle/Resources/public/css/foundation.css',
            '@PuluPalstaBundle/Resources/public/css/app.css'
            )
        ) as $url): ?>
    <link rel="stylesheet" href="<?php echo $view->escape($url) ?>" />
    <?php endforeach; ?>
    <?php foreach ($view['assetic']->javascripts(array('@PuluPalstaBundle/Resources/public/js/modernizr.foundation.js')) as $url): ?>
    <script src="<?php echo $view->escape($url) ?>"></script>
    <?php endforeach; ?>
    <!-- IE Fix for HTML5 Tags -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

<!-- Main row -->
<div class="row">
    <div class="twelve columns">

<?php if ($app->getRequest()->getLocale() == 'fi'): ?>
<div id="switch-language"><a href="<?php echo $view['router']->generate($app->getRequest()->get('_route'), (array('_locale' => 'en'))) ?>">in English</a></div>
<? else: ?>
<div id="switch-language"><a href="<?php echo $view['router']->generate($app->getRequest()->get('_route'), (array('_locale' => 'fi'))) ?>">suomeksi</a></div>
<? endif ?>

<p id="title">Pulupalsta</p>
<p id="slogan"><?php echo $view['translator']->trans('Palstan hoitoa jo vuodesta 2006') ?></p>

<ul id="navigation">
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_front') ?>"><?php echo $view['translator']->trans('Kansi') ?></a></li>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_list') ?>"><?php echo $view['translator']->trans('Luettelo') ?></a></li>
</ul>
<ul id="about">
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_about') ?>"><?php echo $view['translator']->trans('Hä') ?>?</a></li>
</ul>

<!-- Contents row -->
<div class="row">
    <div class="twelve columns" id="main-contents">

<?php $view['slots']->output('body') ?>

    </div><!-- twelve columns ends -->
</div><!-- Contents row ends -->

<p id="copyright">&copy; 2006-2012 Lassi Heikkinen</p>

    </div><!-- twelve columns ends -->
</div><!-- Main row ends -->

<!-- Included JS Files (Uncompressed) -->
<!--
<script src="javascripts/jquery.js"></script>
<script src="javascripts/jquery.foundation.mediaQueryToggle.js"></script>
<script src="javascripts/jquery.foundation.forms.js"></script>
<script src="javascripts/jquery.foundation.reveal.js"></script>
<script src="javascripts/jquery.foundation.orbit.js"></script>
<script src="javascripts/jquery.foundation.navigation.js"></script>
<script src="javascripts/jquery.foundation.buttons.js"></script>
<script src="javascripts/jquery.foundation.tabs.js"></script>
<script src="javascripts/jquery.foundation.tooltips.js"></script>
<script src="javascripts/jquery.foundation.accordion.js"></script>
<script src="javascripts/jquery.placeholder.js"></script>
<script src="javascripts/jquery.foundation.alerts.js"></script>
<script src="javascripts/jquery.foundation.topbar.js"></script>
-->
  
<!-- Included JS Files (Compressed) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<?php foreach ($view['assetic']->javascripts(array(
    '@PuluPalstaBundle/Resources/public/js/foundation.min.js',
    '@PuluPalstaBundle/Resources/public/js/app.js'
    )) as $url): ?>
    <script src="<?php echo $view->escape($url) ?>"></script>
    <?php endforeach; ?>
<!--<script src="javascripts/foundation.min.js"></script>
<script src="javascripts/app.js"></script>-->

<script type="text/javascript">
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>