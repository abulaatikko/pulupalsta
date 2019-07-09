<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Pulupalsta - Full power') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<div id="locale" data-locale="<?php echo $currentLocale ?>"></div>

<h1>Welcome, a user of internet!</h1>

<p>Hi, I'm Lassi in real life and Abula in internet life. Pulupalsta is a self-made platform to publish cultural material for the universe. I travel a lot and do other random things. The most popular articles are in <strong>bold</strong>.</p>

<!-- Popular/Recent articles -->
<div class="row">
    <div class="six columns" id="visited-articles">

<h3>Expeditions</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Report</th>
</tr>
</thead>

<tbody>
<?php $carbonCss = ' class="carbon"'; ?>
<?php $isCarbonStartPrinted = false; ?>
<?php $isCarbonEndPrinted = false; ?>
<?php foreach ($expeditionArticles as $article): ?>
<?php if ($article->getPublished()->format('Y') === '2018' && !$isCarbonStartPrinted): ?>
<tr>
    <td colspan="3" class="zero-carbon-end-separator">PROJECT PAUSED</td>
</tr>
<?php $isCarbonStartPrinted = true; ?>
<?php $carbonCss = ''; ?>
<?php endif; ?>
<?php if ($article->getPublished()->format('Y') === '2015' && !$isCarbonEndPrinted): ?>
<tr>
    <td colspan="3" class="zero-carbon-start-separator">ZERO CARBON SINCE 2016</td>
</tr>
<?php $isCarbonEndPrinted = true; ?>
<?php $carbonCss = ' class="carbon"'; ?>
<?php endif; ?>
<tr<?php echo $carbonCss ?>>
    <td><?php echo $article->getPublished()->format('Y-m-d') ?></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
</tr>
<?php endforeach ?>
</tbody>
</table>
<p></p>

    </div>
    <div class="six columns" id="recent-articles">

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

<h3>Essays</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Text</th>
</tr>
</thead>
<tbody>
<?php foreach ($essayArticles as $article): ?>
<tr>
    <td><?php echo $article->getPublished()->format('Y-m-d'); ?></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
</tr>
<?php endforeach ?>
</tbody>
</table>

<h3>Art</h3>

<table class="wide">
<thead>
<tr>
    <th>Published</th>
    <th colspan="2">Work</th>
</tr>
</thead>
<tbody>
<?php foreach ($artArticles as $article): ?>
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
