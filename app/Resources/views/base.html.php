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
    <link rel="icon" type="image/png" href="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/favicon.png') ?>" />
    <link rel="alternate" title="<?php echo $view['translator']->trans('Pulupalstan kirjoitukset') ?>" href="<?php echo $view['router']->generate('pulu_palsta_feed_recent_articles') ?>" type="application/rss+xml" />
    <link rel="alternate" title="<?php echo $view['translator']->trans('Pulupalstan kommentit') ?>" href="<?php echo $view['router']->generate('pulu_palsta_feed_recent_comments') ?>" type="application/rss+xml" />
    <?php foreach ($view['assetic']->stylesheets(
        array(
            // https://github.com/kriswallsmith/assetic/issues/53
            //'@PuluPalstaBundle/Resources/public/css/foundation.css',
            //'@PuluPalstaBundle/Resources/public/css/app.css'
            'bundles/pulupalsta/css/foundation.css',
            'bundles/pulupalsta/css/app.css',
            'bundles/pulupalsta/css/alertify.core.css',
            'bundles/pulupalsta/css/alertify.default.css'
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

<!-- Language switch row -->
<div class="row">
    <div class="twelve columns">

<ul class="tabs-content" id="switch-language">
    <li class="active">
        <dl class="tabs pill">
<?php $route_params = $app->getRequest()->get('_route_params'); ?>
<?php if ($app->getRequest()->getLocale() == 'fi'): ?>
        <dd class="active switch-language" data-to="fi"><a href="<?php echo $view['router']->generate($app->getRequest()->get('_route'), array_merge($route_params, array('_locale' => 'en'))) ?>">in English</a></dd>
<? else: ?>
        <dd class="active switch-language" data-to="en"><a href="<?php echo $view['router']->generate($app->getRequest()->get('_route'), array_merge($route_params, array('_locale' => 'fi'))) ?>">suomeksi</a></dd>
<? endif ?>
        </dl>
    </li>
</ul>
    </div>
</div><!-- Language switch row ends -->

<!-- Main heading -->
<p id="title">Pulupalsta</p>
<p id="slogan"><?php echo $view['translator']->trans('Palstan hoitoa jo vuodesta 2006') ?></p>

<!-- Navigation row -->
<div class="row">
    <div class="twelve columns">

<ul id="navigation">
    <li <?php echo $app->getRequest()->get('_route') == 'pulu_palsta_front' ? 'class="current"' : '' ?>><a href="<?php echo $view['router']->generate('pulu_palsta_front') ?>"><?php echo $view['translator']->trans('Etusivu') ?></a></li>
    <li <?php echo $app->getRequest()->get('_route') == 'pulu_palsta_list' ? 'class="current"' : '' ?>><a href="<?php echo $view['router']->generate('pulu_palsta_list') ?>"><?php echo $view['translator']->trans('Sisällysluettelo') ?></a></li>
    <li <?php echo $app->getRequest()->get('_route') == 'pulu_palsta_index' ? 'class="current"' : '' ?>><a href="<?php echo $view['router']->generate('pulu_palsta_index') ?>"><?php echo $view['translator']->trans('Avainsanahakemisto') ?></a></li>
</ul>
<ul id="about">
    <li <?php echo $app->getRequest()->get('_route') == 'pulu_palsta_about' ? 'class="current"' : '' ?>><a href="<?php echo $view['router']->generate('pulu_palsta_about') ?>"><?php echo $view['translator']->trans('Hä') ?>?</a></li>
</ul>

    </div>
</div><!-- Navigation ends -->

<!-- Contents row -->
<div class="row">
    <div class="twelve columns" id="main-contents">

<? if ($view['session']->hasFlash('notice')): ?>
<div style="padding-top: 20px;" id="notice">
<?php foreach ($view['session']->getFlash('notice') as $message): ?>
    <?php echo "<div class='alert-box success'>$message</div>" ?>
<?php endforeach; ?>
</div>
<? endif ?>

<? if ($view['session']->hasFlash('error')): ?>
<div style="padding-top: 20px;" id="error">
<?php foreach ($view['session']->getFlash('error') as $message): ?>
    <?php echo "<div class='alert-box alert'>$message</div>" ?>
<?php endforeach; ?>
</div>
<? endif ?>

<?php $view['slots']->output('body') ?>

    </div><!-- twelve columns ends -->
</div><!-- Contents row ends -->

<p id="copyright">&copy; 2006-<?php echo date('Y'); ?> Lassi Heikkinen</p>

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
    "your_rating_failed": "<?php echo $view['translator']->trans('Arvosanasi hylättiin') ?>",
    "failed_to_send_your_comment": "<?php echo $view['translator']->trans('Kommentin lähetys epäonnistui') ?>",
    "article": "<?php echo $view['translator']->trans('Kirjoitus') ?>",
    "visits": "<?php echo $view['translator']->trans('Vierailuja') ?>"
}
</script>
  
<!-- Included JS Files (Compressed) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<?php foreach ($view['assetic']->javascripts(array(
    '@PuluPalstaBundle/Resources/public/js/foundation.min.js',
    '@PuluPalstaBundle/Resources/public/js/alertify.min.js',
    '@FOSJsRoutingBundle/Resources/public/js/router.js',
    '@PuluPalstaBundle/Resources/public/js/jquery.dataTables.js',
    '@PuluPalstaBundle/Resources/public/js/app.js'
    )) as $url): ?>
    <script src="<?php echo $view->escape($url) ?>"></script>
    <?php endforeach; ?>
<script type="text/javascript" src="<?php echo $view['router']->generate('fos_js_routing_js', array('callback' => 'fos.Router.setData')) ?>"></script>

<?php /*<!--<script src="javascripts/foundation.min.js"></script>
<script src="javascripts/app.js"></script>-->*/ ?>

<script type="text/javascript">
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>