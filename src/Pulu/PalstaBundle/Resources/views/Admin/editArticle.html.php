<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Muokkaa artikkelia - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>


<h1><?php echo $article->getName() ?></h1>

<?php $view['slots']->stop() ?>