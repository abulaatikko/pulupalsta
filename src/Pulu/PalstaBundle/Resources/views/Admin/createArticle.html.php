<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Luo uusi artikke - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1>Luo uusi artikkeli</h1>

<form action="<?php echo $view['router']->generate('pulu_palsta_admin_article_create') ?>" method="post" <?php echo $view['form']->enctype($form) ?> >
    <?php echo $view['form']->widget($form) ?>

    <input class="button" type="submit" value="Luo" />
</form>

<?php $view['slots']->stop() ?>