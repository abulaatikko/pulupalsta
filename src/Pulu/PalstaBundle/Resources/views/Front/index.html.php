<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<div id="locale" data-locale="<?php echo $currentLocale ?>"></div>

<h1>Welcome my Friend! <a style="float: right" href="<?php echo $view['router']->generate('pulu_palsta_list') ?>#feeds" title="RSS Feeds"><img src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/32_feed.png') ?>" alt="RSS Feeds" /></a></h1>

<p>Hi, I'm Lassi in real life and Abula in internet life. I created this website in 2006 to publish reports of my random projects. The most popular ones are: <a href="/en/51">Townhalls</a> (2003), <a href="/fi/1">Pepsi</a> (2006), <a href="/fi/60">Elasto Mania</a> (2018). Yes, seen the light, I have.</p>

<!-- Popular/Recent articles -->
<div class="row">
    <div class="six columns" id="visited-articles">

<h3>Research and analysis</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Paper</th>
</tr>
</thead>
<tbody>
<? foreach ($researchArticles as $article): ?>
<tr>
    <td class="nowrap text-right"><?php echo $article->getPublished()->format('Y-m-d'); ?></td>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getName(); ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
</tr>
<? endforeach ?>
</tbody>
</table>

    </div>
    <div class="six columns" id="recent-articles">

<h3>Abula Adventures</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Adventure</th>
</tr>
</thead>

<tbody>
<? foreach ($adventureArticles as $article): ?>
<tr>
    <td><?php echo $article->getPublished()->format('Y-m-d') ?></td>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getName(); ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
</tr>
<? endforeach ?>
</tbody>
</table>

<p></p>

    </div>
</div><!-- Popular/Recent articles ends -->

<?php $view['slots']->stop() ?>
