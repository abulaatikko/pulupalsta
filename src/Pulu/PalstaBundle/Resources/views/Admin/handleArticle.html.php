<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Muokkaa artikkelia - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php if ($article->getId() > 0): ?>
<h1><?php echo $article->getName() ?></h1>
<?php $formUrl = 'pulu_palsta_admin_article_edit'; ?>
<?php else: ?>
    <h1>Luo uusi artikkeli</h1>
<?php $formUrl = 'pulu_palsta_admin_article_create'; ?>
<?php endif ?>

<form action="<?php echo $view['router']->generate($formUrl, array('id' => $article->getId())) ?>" method="post" <?php echo $view['form']->enctype($form) ?> >
    <?php echo $view['form']->widget($form) ?>

    <?php if ($article->getId() > 0): ?>
    <input type="hidden" name="id" value="<?php echo $article->getId() ?>" />
    <?php endif ?>
    <input class="button" type="submit" value="Tallenna" />
    <?php if ($article->getId() > 0): ?>
    <input class="alert button right" name="delete" type="submit" value="Poista" />
    <?php endif ?>
</form>

<?php $view['slots']->stop() ?>