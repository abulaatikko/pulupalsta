<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Artikkelit - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1>Artikkelit</h1>

<p><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article_create') ?>">Luo uusi artikkeli</a></p>

<ul>
<? foreach ($articles as $article): ?>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article_edit', array('id' => $article->getId())) ?>"><?php echo $article->getName() ?> (<?php echo $article->getId() ?>)</a></li>
<? endforeach ?>
</ul>

<?php $view['slots']->stop() ?>
