<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<?php if ($app->getRequest()->getLocale() == 'fi'): ?>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="fi"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="fi"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="fi"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fi"> <!--<![endif]-->
<?php else: ?>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php endif ?>
<head>
    <meta charset="utf-8" />
    <meta name="description" content="<?php $view['slots']->output('description', '') ?>">
    <meta name="author" content="Lassi Heikkinen">
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="nosnippet">
    <title><?php $view['slots']->output('title', 'Puluprojects') ?></title>
    <link rel="icon" type="image/png" href="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/favicon.png') ?>" />
    <link rel="canonical" href="<?php echo ! empty($view['slots']->get('canonical')) ? $view['slots']->get('canonical') : $app->getRequest()->getUri() ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="<?php echo $view['router']->path('pulu_palsta_feed_articles') ?>">
    <?php foreach ($view['assetic']->stylesheets(
        array(
            // https://github.com/kriswallsmith/assetic/issues/53
            //'@PuluPalstaBundle/Resources/public/css/foundation.css',
            //'@PuluPalstaBundle/Resources/public/css/app.css'
            'bundles/pulupalsta/css/foundation.css',
            'bundles/pulupalsta/css/app.css',
            'bundles/pulupalsta/css/alertify.core.css',
            'bundles/pulupalsta/css/alertify.default.css',
            'bundles/pulupalsta/fancybox/jquery.fancybox.css'
            )
        ,
        array('cssrewrite')
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
        <!-- Main wrapper -->
        <div id="main-wrapper">

<!-- Main heading -->
<p id="title" style="margin: 25px 0 5px;">Random Projects</p>
<p id="slogan"></p>

<!-- Navigation row -->
<div class="row">
    <div class="twelve columns">
        <div id="navigation-row">

<ul id="navigation">
<li <?php echo $app->getRequest()->get('_route') == 'pulu_palsta_front' ? 'class="current"' : '' ?>><a href="<?php echo $view['router']->path('pulu_palsta_front') ?>">Front</a></li>
    <li <?php echo $app->getRequest()->get('_route') == 'pulu_palsta_list' ? 'class="current"' : '' ?>><a href="<?php echo $view['router']->path('pulu_palsta_list') ?>">List</a></li>
    <li <?php echo $app->getRequest()->get('_route') == 'pulu_palsta_index' ? 'class="current"' : '' ?>><a href="<?php echo $view['router']->path('pulu_palsta_index') ?>">Index</a></li>
<!--    <li <?php echo $app->getRequest()->get('_route') == 'pulu_palsta_about' ? 'class="current"' : '' ?>><a href="<?php echo $view['router']->path('pulu_palsta_about') ?>">About</a></li>-->
</ul>
<ul id="about">
    <!--<li><a href="/en/71">Plop</a></li>-->
</ul>

        </div>
    </div>
</div><!-- Navigation ends -->

<!-- Contents row -->
<div class="row">
    <div class="twelve columns" id="main-contents">

<?php if ($view['session']->hasFlash('notice')): ?>
<div style="padding-top: 20px;" id="notice">
<?php foreach ($view['session']->getFlash('notice') as $message): ?>
    <?php echo "<div class='alert-box success'>$message</div>" ?>
<?php endforeach; ?>
</div>
<?php endif ?>

<?php if ($view['session']->hasFlash('error')): ?>
<div style="padding-top: 20px;" id="error">
<?php foreach ($view['session']->getFlash('error') as $message): ?>
    <?php echo "<div class='alert-box alert'>$message</div>" ?>
<?php endforeach; ?>
</div>
<?php endif ?>

<?php $view['slots']->output('body') ?>

    </div><!-- twelve columns ends -->
</div><!-- Contents row ends -->

<!-- Bottom navigation row -->
<div class="row">
    <div class="twelve columns">
        <div id="bottom-navigation-row">

<ul id="bottom-navigation">
    <li><a href="javascript:void(0)" onclick="goToTop()">Back to Top</a></li>
</ul>
<p id="copyright">&copy; <a href="https://lassi.pulu.org">Abulaatikko</a>, 2006&ndash;<?php echo date('Y'); ?></p>

        </div>
    </div>
</div><!-- Navigation ends -->


        </div><!-- Main wrapper ends -->
    </div><!-- twelve columns ends -->
</div><!-- Main row ends -->

<?php /*
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
*/ ?>

<script type="text/javascript">
var translations = {
    "your_rating_failed": "Rating failed",
    "failed_to_send_your_comment": "Commenting failed",
    "article": "Article",
    "visits": "Visits"
}
</script>
  
<!-- Included JS Files (Compressed) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<?php foreach ($view['assetic']->javascripts(array(
    '@PuluPalstaBundle/Resources/public/js/foundation.min.js',
    '@PuluPalstaBundle/Resources/public/js/alertify.min.js',
    '@FOSJsRoutingBundle/Resources/public/js/router.js',
    '@PuluPalstaBundle/Resources/public/js/jquery.dataTables.js',
    '@PuluPalstaBundle/Resources/public/fancybox/jquery.fancybox.pack.js',
    '@PuluPalstaBundle/Resources/public/js/lazy-load.js',
    '@PuluPalstaBundle/Resources/public/js/lazy-load-youtube.js',
    '@PuluPalstaBundle/Resources/public/js/app.js'
    )) as $url): ?>
    <script src="<?php echo $view->escape($url) ?>"></script>
    <?php endforeach; ?>
<script type="text/javascript" src="<?php echo $view['router']->path('fos_js_routing_js', array('callback' => 'fos.Router.setData')) ?>"></script>

<?php /*<!--<script src="javascripts/foundation.min.js"></script>
<script src="javascripts/app.js"></script>-->*/ ?>

<script type="text/javascript">
function goToTop() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
</script>

<script type="text/javascript">
var _gaq=[['_setAccount','UA-10351274-1'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>
