<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Hakemisto') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1><?php echo $view['translator']->trans('Hakemisto') ?></h1>

<p><?php echo $view['translator']->trans('Lista artikkeleissa käytetyistä avainsanoista') ?>:</p>

<?php foreach ($keywords as $keyword): ?>

<?php $articles = $keyword->getArticles()->filter(function($article) {
    return $article->getArticle()->getIsPublic();
}); ?>
<?php $count = $articles->count(); ?>
<?php if ($count > 0): ?>

<a name="<?php echo $keyword->getName() ?>"></a>
<h2><?php echo $keyword->getName($currentLocale) ?></h2>

<ul class="square">
<? foreach ($articles as $article): ?>
<li><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('id' => $article->getArticle()->getId(), 'name' => $view['helper']->toFilename($article->getArticle()->getName($currentLocale)))) ?>'><?php echo $article->getArticle()->getName($currentLocale); ?></a></li>
<? endforeach ?>
</ul>

<?php endif ?>

<?php endforeach ?>

<?php $view['slots']->stop() ?>