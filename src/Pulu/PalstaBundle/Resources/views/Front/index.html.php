<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Palstan hoitoa jo vuodesta 2006') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<div id="locale" data-locale="<?php echo $currentLocale ?>"></div>

<h1><?php echo $view['translator']->trans('Terve') ?>! <a style="float: right" href="<?php echo $view['router']->generate('pulu_palsta_list') ?>#feeds" title="<?php echo $view['translator']->trans('RSS-syötteet') ?>"><img src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/32_feed.png') ?>" alt="<?php echo $view['translator']->trans('RSS-syötteet') ?>" /></a></h1>

<?php if ($currentLocale == 'fi'): ?>
<p>Pulupalsta on kokoelma seikkailuja ja tutkielmia, joita yhden aktiivisen miehen elämä on eteen tuonut.</p>

<? else: ?>
<p>Pulupalsta is a collection of adventures and explorations which one active man has met during his life.</p>

<? endif; ?>

<!-- Popular/Recent articles -->
<div class="row">
    <div class="six columns" id="visited-articles">

<h3><?php echo $view['translator']->trans('Suosituimmat') ?></h3>

<table class="wide">
<thead>
<tr>
    <th>#</th>
    <th colspan="2"><?php echo $view['translator']->trans('Kirjoitus') ?></th>
    <th class="text-right nowrap" title="<?php echo $view['translator']->trans('Vierailut yhteensä (Keskimääräiset kuukausivierailut julkaisusta lähtien)') ?>"><?php echo $view['translator']->trans('Vier. (kk)') ?></th>
</tr>
</thead>

<tbody>
<? $i = 1; ?>
<? foreach ($visitedArticles as $article): ?>
<? $averageMonthlyVisits = $article->getAverageMonthlyVisits(); ?>
<tr>
    <td><?php echo $i++ ?>.</td>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()))) ?>'><?php echo $article->getName(); ?></a></td>
    <td class="centered"><?php echo $article->getLanguage() === 'fi' ? '🇫🇮' :'🇬🇧' ?></td>
    <td class="nowrap text-right"><?php echo $article->getVisits(); ?> (<?php echo floor($averageMonthlyVisits); ?>)</td>
</tr>
<? endforeach ?>
</tbody>
</table>
<p><a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'visit')) ?>"><?php echo $view['translator']->trans('Lisää') ?></a></p>

    </div>
    <div class="six columns" id="recent-articles">

<h3><?php echo $view['translator']->trans('Uusimmat') ?></h3> 

<table class="wide">
<thead>
<tr>
    <th>#</th>
    <th colspan="2"><?php echo $view['translator']->trans('Kirjoitus') ?></th>
    <th class="text-right"><?php echo $view['translator']->trans('Julkaistu') ?></th>
</tr>
</thead>
<tbody>
<? $i = 1; ?>
<? foreach ($recentArticles as $article): ?>
<tr>
    <td><?php echo $i++ ?>.</td>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()))) ?>'><?php echo $article->getName(); ?></a></td>
    <td class="centered"><?php echo $article->getLanguage() === 'fi' ? '🇫🇮' :'🇬🇧' ?></td>
    <td class="nowrap text-right"><?php echo $article->getPublished()->format('Y-m-d'); ?></td></tr>
<? endforeach ?>
</tbody>
</table>
<p>
    <a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'published')) ?>"><?php echo $view['translator']->trans('Lisää') ?></a>
    <span class="feed-icon"><a title="<?php echo $view['translator']->trans('Pulupalstan uusimmat kirjoitukset') ?>" href="<?php echo $view['router']->generate('pulu_palsta_feed_recent_articles') ?>"><img src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/16_feed.png') ?>" alt="<?php echo $view['translator']->trans('Pulupalstan uusimmat kirjoitukset') ?>" /></a></span>
</p>

    </div>
</div><!-- Popular/Recent articles ends -->

<?php $view['slots']->stop() ?>
