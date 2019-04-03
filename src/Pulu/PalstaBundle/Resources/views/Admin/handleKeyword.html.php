<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php if ($keyword->getId() > 0): ?>
<?php $view['slots']->set('title', $keyword->getName() . ' - Ylläpito - Pulupalsta') ?>
<?php else: ?>
<?php $view['slots']->set('title', 'Luo avainsana - Ylläpito - Pulupalsta') ?>
<?php endif ?>

<?php $view['slots']->start('body') ?>

<?php if ($keyword->getId() > 0): ?>
<ul class="breadcrumbs">
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_keyword') ?>">Avainsanat</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_keyword_edit', array('id' => $keyword->getId())) ?>" class="current"><?php echo $keyword->getName() ?></a></li>
</ul>
<h1><?php echo $keyword->getName() ?></h1>
<?php $formUrl = 'pulu_palsta_admin_keyword_edit'; ?>
<?php else: ?>
<ul class="breadcrumbs">
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_keyword') ?>">Avainsanat</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_keyword_create') ?>" class="current">Luo uusi</a></li>
</ul>
<h1>Luo uusi avainsana</h1>
<?php $formUrl = 'pulu_palsta_admin_keyword_create'; ?>
<?php endif ?>

<ul class="tabs-content" id="admin-switch-language">
    <li class="active">
    <dl class="tabs pill">
        <dd class="active"><a href="javascript:void(0);" class="switch-language" data-to="fi">suomeksi</a></dd>
        <dd><a href="javascript:void(0);" class="switch-language" data-to="en">englanniksi</a></dd>
    </dl>
</li>
</ul>

<form action="<?php echo $view['router']->path($formUrl, array('id' => $keyword->getId())) ?>" method="post">
    <?php $view['form']->setTheme($form, array('PuluPalstaBundle:Form')) ;?>

<?php if (! empty($form['localizations'])): ?>
        <?php foreach ($form['localizations'] as $row): ?>
            <div id="language-<?php echo $row['language']->vars['value'] ?>">
            <?php echo $view['form']->row($row['language']) // skip printing ?>
            <?php echo $view['form']->row($row['name']) ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>

    <?php echo $view['form']->rest($form) ?>
    <?php if ($keyword->getId() > 0): ?>
    <input type="hidden" name="id" value="<?php echo $keyword->getId() ?>" />
    <?php endif ?>
    <input class="button" type="submit" value="Tallenna" />
    <?php if ($keyword->getId() > 0): ?>
    <input class="alert button right" id="deleteConfirmation" type="submit" value="Poista" />
    <?php endif ?>
</form>

    <div>
        <p>Käytössä artikkeleissa:</p>
        <ul>
        <? foreach($keyword->getArticles() as $keywordArticle): ?>
        <? $article = $keywordArticle->getArticle(); ?>
        <li><a href="<? echo $view['router']->generate('pulu_palsta_admin_article_edit', array('id' => $article->getId())) ?>"><? echo $article->getName() ?> (#<? echo $article->getId() ?>)</a></li>
        <? endforeach ?>
        </ul>
    </div>

<?php $view['slots']->stop('body') ?>

<?php $view['slots']->start('reveal') ?>

<div id="deleteConfirmationModal" class="reveal-modal small">
    <h4>Oletko varma?</h4>
    <form action="<?php echo $view['router']->path($formUrl, array('id' => $keyword->getId())) ?>" method="post">
        <input class="secondary button close" type="submit" value="Peruuta" />
        <input class="alert button right" name="delete" type="submit" value="Kyllä" />
    </form>
    <a class="close-reveal-modal">&#215;</a>
</div>

<?php $view['slots']->stop() ?>
