<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php if ($comment->getId() > 0): ?>
<?php $view['slots']->set('title', 'Kommentti: #' . $comment->getId() . ' - Ylläpito - Pulupalsta') ?>
<?php else: ?>
<?php $view['slots']->set('title', 'Luo kommentti - Ylläpito - Pulupalsta') ?>
<?php endif ?>

<?php $view['slots']->start('body') ?>

<?php if ($comment->getId() > 0): ?>
<ul class="breadcrumbs">
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_comment') ?>">Kommentit</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_comment_edit', array('id' => $comment->getId())) ?>" class="current">#<?php echo $comment->getId() ?></a></li>
</ul>
<h1>Kommentti #<?php echo $comment->getId() ?></h1>
<?php $formUrl = 'pulu_palsta_admin_comment_edit'; ?>
<?php else: ?>
<ul class="breadcrumbs">
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_comment') ?>">Kommentit</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_comment_create') ?>" class="current">Luo uusi</a></li>
</ul>
<h1>Luo uusi kommentti</h1>
<?php $formUrl = 'pulu_palsta_admin_comment_create'; ?>
<?php endif ?>

<form action="<?php echo $view['router']->path($formUrl, array('id' => $comment->getId())) ?>" method="post">
    <?php $view['form']->setTheme($form, array('PuluPalstaBundle:Form')) ;?>

    <label>Artikkeli</label>
    <p><a href="<?php echo $view['router']->path('pulu_palsta_admin_article_edit', array('id' => $comment->getArticle()->getId())) ?>"><?php echo $comment->getArticle()->getName() ?> (#<?php echo $comment->getArticle()->getId() ?>)</a></p>

    <label>Kirjoitettu</label>
    <p><?php echo $comment->getCreated()->format('Y-m-d H:i:s') ?></p>

    <label>Muokattu</label>
    <p><?php echo $comment->getModified()->format('Y-m-d H:i:s') ?></p>

    <?php $deleted = $comment->getDeleted(); ?>
    <?php if (! empty($deleted)): ?>
    <label>Poistettu</label>    
    <p><?php echo $deleted->format('Y-m-d H:i:s') ?></p>
    <?php endif ?>

    <?php echo $view['form']->rest($form) ?>
    <?php if ($comment->getId() > 0): ?>
    <input type="hidden" name="id" value="<?php echo $comment->getId() ?>" />
    <?php endif ?>
    <input class="button" type="submit" value="Tallenna" />
    <?php if ($comment->getId() > 0): ?>
    <input class="alert button right" id="deleteConfirmation" type="submit" value="Poista" />
    <?php endif ?>
</form>

<?php $view['slots']->stop('body') ?>

<?php $view['slots']->start('reveal') ?>

<div id="deleteConfirmationModal" class="reveal-modal small">
    <h4>Oletko varma?</h4>
    <form action="<?php echo $view['router']->path($formUrl, array('id' => $comment->getId())) ?>" method="post">
        <input class="secondary button close" type="submit" value="Peruuta" />
        <input class="alert button right" name="delete" type="submit" value="Kyllä" />
    </form>
    <a class="close-reveal-modal">&#215;</a>
</div>

<?php $view['slots']->stop() ?>
