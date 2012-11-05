<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Muokkaa artikkelia - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php if ($article->getId() > 0): ?>
<ul class="breadcrumbs">
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin') ?>">Etusivu</a></li>
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article') ?>">Artikkelit</a></li>
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article_edit', array('id' => $article->getId())) ?>" class="current"><?php echo $article->getName() ?></a></li>
</ul>
<h1><?php echo $article->getName() ?></h1>
<?php $formUrl = 'pulu_palsta_admin_article_edit'; ?>
<?php else: ?>
<ul class="breadcrumbs">
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin') ?>">Etusivu</a></li>
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article') ?>">Artikkelit</a></li>
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article_create') ?>" class="current">Luo uusi</a></li>
</ul>
<h1>Luo uusi artikkeli</h1>
<?php $formUrl = 'pulu_palsta_admin_article_create'; ?>
<?php endif ?>

<form action="<?php echo $view['router']->generate($formUrl, array('id' => $article->getId())) ?>" method="post" <?php echo $view['form']->enctype($form) ?> >
    
    <?php $view['form']->setTheme($form, array('PuluPalstaBundle:Form')) ;?>
    <?php echo $view['form']->widget($form) ?>

    <?php if ($article->getId() > 0): ?>
    <input type="hidden" name="id" value="<?php echo $article->getId() ?>" />
    <?php endif ?>
    <input class="button success" type="submit" value="Tallenna" />
    <?php if ($article->getId() > 0): ?>
    <input class="alert button right" id="deleteConfirmation" type="submit" value="Poista" />
    <?php endif ?>
</form>

<?php $view['slots']->stop('stop') ?>

<?php $view['slots']->start('reveal') ?>

<div id="deleteConfirmationModal" class="reveal-modal small">
  <h4>Oletko varma?</h4>
  
  <form action="<?php echo $view['router']->generate($formUrl, array('id' => $article->getId())) ?>" method="post" <?php echo $view['form']->enctype($form) ?> >
    <input class="secondary button close" type="submit" value="Peruuta" />
    <input class="alert button right" name="delete" type="submit" value="Kyllä" />
  </form>
  <a class="close-reveal-modal">&#215;</a>
</div>

<?php $view['slots']->stop() ?>