<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Z: Intro') ?>
<?php $view['slots']->set('description', 'Front page of Project-Z') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<div id="locale" data-locale="<?php echo $currentLocale ?>"></div>

<h1>Intro <a style="float: right" href="<?php echo $view['router']->path('pulu_palsta_feed_articles') ?>" title="RSS Feed"><img src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/32_feed.png') ?>" alt="RSS Feed" /></a></h1>

<p></p>
<p>This is a collection of projects started since 2006. Focus is on GEAR, TRAVEL and RESEARCH. The most popular ones are in <strong>bold</strong>.</p>

<p></p>

<div class="row">
    <div class="six columns">
        <div class="scroller-wrapper">

<h3 style="margin-bottom: 12px; text-align: center">Newest</h3>

<table class="wide">
<thead>
<tr>
    <th></th>
    <th></th>
    <th colspan="1">Project</th>
    <th style="width: 1%;">Published</th>
</tr>
</thead>
<tbody>
<?php foreach ($newArticles as $article): ?>
<?php $typeStyles = 'font-size: 60%; width: 1%; white-space: nowrap; text-align: right; font-weight: bold; color: ' . $article->getTypeColor(); ?>
<tr>
    <td style="<?php echo $typeStyles; ?>"><?php echo $article->getTypeName() ?></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td><?php echo $article->getPublished()->format('Y-m-d'); ?></td>
</tr>
<?php endforeach ?>
<tr>
    <td colspan="4" style="text-align: center"><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'published')) ?>">See all</a></td>
</tr>
</tbody>
</table>

        </div>
    </div>
    <div class="six columns">
        <div class="scroller-wrapper">

<h3 style="margin-bottom: 12px; text-align: center">Most viewed</h3>

<table class="wide">
<thead>
<tr>
    <th></th>
    <th></th>
    <th colspan="1">Project</th>
    <th style="width: 1%">Views</th>
</tr>
</thead>
<tbody>
<?php foreach ($viewedArticles as $article): ?>
<?php $typeStyles = 'font-size: 60%; width: 1%; white-space: nowrap; text-align: right; font-weight: bold; color: ' . $article->getTypeColor(); ?>
<tr>
    <td style="<?php echo $typeStyles; ?>"><?php echo $article->getTypeName() ?></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td><?php echo $article->getVisits(); ?></td>
</tr>
<?php endforeach ?>
<tr>
    <td colspan="4" style="text-align: center"><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'views')) ?>">See all</a></td>
</tr>
</tbody>
</table>
<p></p>

        </div>
    </div>
</div>

<?php $view['slots']->stop() ?>
