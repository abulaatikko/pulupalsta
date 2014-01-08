<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Avainsanahakemisto') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1><?php echo $view['translator']->trans('Avainsanahakemisto') ?></h1>

<?php if ($currentLocale == 'fi'): ?>
<p>Vähintään kahdessa artikkelissa käytetyt avainsanat listattuna aakkosjärjestykseen. Avainsanan alla
artikkelit on järjestetty julkaisuajankohdan mukaan.</p>
<? else: ?>
<p>An alphabetic list of the keywords used at least in two articles. The article lists under the keywords
are sorted by the publish dates of the articles.</p>
<? endif ?>

<?php $keywordsCount = count($keywords); ?>
<?php $i = 0; ?>
<?php foreach ($keywords as $keyword): ?>

<?php 
// sort articles by created DESC
$iterator = $keyword->getArticles()->getIterator();
$iterator->uasort(function ($first, $second) {
    return strtotime($first->getArticle()->getCreated()->format('r')) > strtotime($second->getArticle()->getCreated()->format('r')) ? -1 : 1;
});
$array = new Doctrine\Common\Collections\ArrayCollection(iterator_to_array($iterator));

$articles = $array->filter(function($article) {
    return $article->getArticle()->getIsPublic() && ! $article->getArticle()->getDeleted();
}); ?>
<?php $count = $articles->count(); ?>
<?php if ($count > 1): ?>

    <?php if ($i % 3 == 0): ?>
<div class="row">
    <?php endif ?>

    <div class="four columns">
        <section id="<?php echo $keyword->getName() ?>"></section>
        <h4><?php echo $keyword->getName($currentLocale) ?></h4>
        <ul class="square">
        <? foreach ($articles as $article): ?>
        <li><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('article_number' => $article->getArticle()->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getArticle()->getName($currentLocale)))) ?>'><?php echo $article->getArticle()->getName($currentLocale); ?></a></li>
        <? endforeach ?>
        </ul>
    </div>
    
    <?php if (($i % 3) == 2 || $i == $keywordsCount): ?>
</div>
    <?php endif ?>
    <?php $i++; ?>

<?php endif ?>    
    
<?php endforeach ?>

</div>

<?php $view['slots']->stop() ?>