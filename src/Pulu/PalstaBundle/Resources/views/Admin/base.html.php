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
    <title><?php $view['slots']->output('title', 'Ylläpito - Pulupalsta') ?></title>
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
    <style type="text/css">
    .row { width: 100%; max-width: 100%; min-width: 768px; margin: 0 auto; }
    body { margin: 10px; }
    #title { margin: 30px; }
    </style>
</head>
<body>

<p id="title">Ylläpito</p>
<!--<p id="slogan">palstanhoitoa jo vuodesta 2006</p>-->

<!-- Main area -->
<div class="row">
    <!-- Naviation area -->
    <div class="two columns" style="border-top: 4px solid #285EAE; border-bottom: 4px solid #285EAE; border-right: 4px dashed #285EAE; background: #fff">

<h3>Navigaatio</h3>

<ul>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article') ?>">Artikkelit</a></li>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_comment') ?>">Kommentit</a></li>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_account') ?>">Käyttäjät</a></li>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_setting') ?>">Asetukset</a></li>
</ul>

    </div><!-- Navigation area ends -->
    <!-- Body -->
    <div class="ten columns" style="border-top: 4px solid #285EAE; border-bottom: 4px solid #285EAE; background: #fff">

<?php $view['slots']->output('body') ?>

    </div><!-- Body ends -->
</div>
<!-- Main area ends -->


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

</body>
</html>