<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Keywords - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1>Keywords</h1>

<p>An alphabetic list of the keywords used at least in two articles. The articles under the keywords are sorted by the publish dates of the articles.</p>

<?php $keywordsCount = count($keywords); ?>
<?php $i = 0; ?>
<?php foreach ($keywords as $keyword): ?>

<?php 
// sort articles by published DESC
$iterator = $keyword->getArticles()->getIterator();
$iterator->uasort(function ($first, $second) {
    return strtotime($first->getArticle()->getPublished()->format('r')) > strtotime($second->getArticle()->getPublished()->format('r')) ? -1 : 1;
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
        <?php foreach ($articles as $article): ?>
        <li><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticle()->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getArticle()->getName()), '_locale' => $article->getArticle()->getLanguage())) ?>'><?php echo $article->getArticle()->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getArticle()->getName(); ?><?php echo $article->getArticle()->getIsOneOfBest() ? '</strong>' : '' ?></a></li>
        <?php endforeach ?>
        </ul>
    </div>
    
    <?php if (($i % 3) == 2 || $i == $keywordsCount): ?>
</div>
    <?php endif ?>
    <?php $i++; ?>

<?php endif ?>    
    
<?php endforeach ?>

<?php $view['slots']->stop() ?>
