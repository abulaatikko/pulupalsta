<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Z') ?>
<?php $view['slots']->set('description', 'Front page of Project-Z') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<div id="locale" data-locale="<?php echo $currentLocale ?>"></div>

<h1>Intro <a style="float: right" href="<?php echo $view['router']->path('pulu_palsta_feed_articles') ?>" title="RSS Feed"><img src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/32_feed.png') ?>" alt="RSS Feed" /></a></h1>

<p>This is a collection of project reports. Primary focus is on TRAINING, GEAR and RANDOM RESEARCH. The most popular articles are in <strong>bold</strong> (top 25 %).</p>

<!-- Popular/Recent articles -->
<div class="row">
    <div class="six columns" id="visited-articles">

<h3>Training and Gear</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Article</th>
</tr>
</thead>
<tbody>
<?php foreach ($trainingArticles as $article): ?>
<tr>
    <td><?php echo $article->getPublished()->format('Y-m-d'); ?></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
</tr>
<?php endforeach ?>
</tbody>
</table>
<p><br /></p>

<h3>Exploration</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Article</th>
</tr>
</thead>

<tbody>
<tr>
    <td>TBA</td>
    <td>Kaukana Kaakossa (Uusi-Seelanti, Singapore, Vietnam)</td>
    <td>?</td>
</tr>
<?php $carbonCss = ''; ?>
<?php $isCarbonStartPrinted = false; ?>
<?php $isCarbonEndPrinted = false; ?>
<?php foreach ($explorationArticles as $article): ?>
<?php if (1 == 2 && $article->getPublished()->format('Y') === '2015' && !$isCarbonEndPrinted): ?>
<tr>
    <td colspan="3" class="zero-carbon-start-separator">ZERO CARBON SINCE 2016</td>
</tr>
<?php $isCarbonEndPrinted = true; ?>
<?php $carbonCss = ''; //' class="carbon"'; ?>
<?php endif; ?>
<tr<?php echo $carbonCss ?>>
    <td><?php echo $article->getPublished()->format('Y-m-d') ?></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
</tr>
<?php endforeach ?>
</tbody>
</table>
    <div class="six columns">
        <p></p>
    </div>

    </div>
    <div class="six columns" id="recent-articles">

<h3>Random Research</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Article</th>
</tr>
</thead>
<tbody>
<?php $carbonCss = ''; ?>
<?php $isCarbonStartPrinted = false; ?>
<?php $isCarbonEndPrinted = false; ?>
<?php foreach ($researchArticles as $article): ?>
<?php if (1 == 2 && $article->getPublished()->format('Y') === '2015' && !$isCarbonEndPrinted): ?>
<tr>
    <td colspan="3" class="zero-carbon-start-separator">ZERO CARBON SINCE 2016</td>
</tr>
<?php $isCarbonEndPrinted = true; ?>
<?php $carbonCss = ''; //' class="carbon"'; ?>
<?php endif; ?>
<tr<?php echo $carbonCss ?>>
    <td><?php echo $article->getPublished()->format('Y-m-d'); ?></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
</tr>
<?php endforeach ?>
</tbody>
</table>
<p></p>

<h3>Misc</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Article</th>
</tr>
</thead>
<tbody>
<?php foreach ($miscArticles as $article): ?>
<tr>
    <td><?php echo $article->getPublished()->format('Y-m-d'); ?></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
</tr>
<?php endforeach ?>
</tbody>
</table>

    </div>
    <div class="six columns">
        <p></p>
    </div>
</div><!-- Popular/Recent articles ends -->

<?php $view['slots']->stop() ?>
