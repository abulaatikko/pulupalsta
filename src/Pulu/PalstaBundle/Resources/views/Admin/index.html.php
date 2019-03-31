<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h2>Kojelauta</h2>

<ul>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_article') ?>">Artikkelit</a>
        <ul>
            <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_article_create') ?>">Luo uusi</a></li>
        </ul>
    </li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_comment') ?>">Kommentit</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_keyword') ?>">Avainsanat</a>
        <ul>
            <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_keyword_create') ?>">Luo uusi</a></li>
        </ul>
    </li>
</ul>

<?php $view['slots']->stop() ?>
