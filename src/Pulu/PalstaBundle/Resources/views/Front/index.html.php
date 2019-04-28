<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<div id="locale" data-locale="<?php echo $currentLocale ?>"></div>

<h1>Terve! <a style="float: right" href="<?php echo $view['router']->path('pulu_palsta_list') ?>#feeds" title="RSS Feeds"><img src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/32_feed.png') ?>" alt="RSS Feeds" /></a></h1>

<p>Hi, I'm Lassi in real life and Abula in internet life. I'm a web developer and this is my playground project to test things. I've also created some content for the universe. The top-10 most popular articles are in <strong>bold</strong>.</p>

<!-- Popular/Recent articles -->
<div class="row">
    <div class="six columns" id="visited-articles">

<h3>Research</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Paper</th>
</tr>
</thead>
<tbody>
<?php foreach ($researchArticles as $article): ?>
<tr>
    <td><?php echo $article->getPublished()->format('Y-m-d'); ?></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
</tr>
<?php endforeach ?>
</tbody>
</table>

    </div>
    <div class="six columns" id="recent-articles">

<h3>Expeditions</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Training</th>
</tr>
</thead>

<tbody>
<?php foreach ($expeditionArticles as $article): ?>
<tr>
    <td><?php echo $article->getPublished()->format('Y-m-d') ?></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
</tr>
<?php endforeach ?>
</tbody>
</table>

<p></p>

    </div>
</div><!-- Popular/Recent articles ends -->

<?php $view['slots']->stop() ?>
