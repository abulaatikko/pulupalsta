<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Palstan hoitoa jo vuodesta 2006') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<div id="locale" data-locale="<?php echo $currentLocale ?>"></div>

<h1><?php echo $view['translator']->trans('Tervetuloa') ?>! <a style="float: right" href="<?php echo $view['router']->generate('pulu_palsta_list') ?>#feeds" title="<?php echo $view['translator']->trans('RSS-syötteet') ?>"><img src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/32_feed.png') ?>" alt="<?php echo $view['translator']->trans('RSS-syötteet') ?>" /></a></h1>

<?php if ($currentLocale == 'fi'): ?>
<p><em>Pulupalsta</em> on kokoelma allekirjoittaneen eri aiheisia kirjoituksia eri elämänalueilta ja 
aikakausilta. Kirjoituksissa käsitellään pääasiassa henkilökohtaisia asioita, mutta tavoite 
on saada aikaiseksi myös laajempaa merkittävyyttä. Uudelle lukijalle suosittelen valitsemaan 
alla olevasta <a href="#cloud">pilvestä</a> kiinnostavan avainsanan tai lukemaan jonkin
<a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'visit')) ?>">suosituimmista kirjoituksista</a>.</p>

<p>Kiitän mielenkiinnosta, ja erityisesti jos heität arvosanan tai kommentin kirjoituksen 
luettuasi.</p>
<? else: ?>
<p><em>Pulupalsta</em> is a collection of articles which discuss topics ranging different aspects 
of life in different eras. At the moment the articles mainly discuss my personal life but 
the humble goal is to achieve more relevancy for other people as well. If you are a new 
visitor I recommend you to use your freedom to pick up an interesting topic in the keyword 
<a href="#cloud">cloud</a> below or read some of 
<a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'visit')) ?>">the most popular articles</a>.</p>

<p>Unfortunately most of the articles are only in Finnish so you need to rely on automatic 
translation or just look at the images.</p>

<p>I appreciate your interest and especially if you rate or comment the article after reading it.</p>
<? endif; ?>

<!-- Popular/Recent articles -->
<div class="row">
    <div class="six columns" id="visited-articles">

<h3><?php echo $view['translator']->trans('Suosituimmat kirjoitukset') ?></h3>

<table class="wide">
<thead>
<tr>
    <th>#</th>
    <th><?php echo $view['translator']->trans('Kirjoitus') ?></th>
    <th class="text-right"><?php echo $view['translator']->trans('Vierailuja') ?></th>
</tr>
</thead>

<tbody>
<? $i = 1; ?>
<? foreach ($visitedArticles as $article): ?>
<tr>
    <td><?php echo $i++ ?>.</td>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName($currentLocale)))) ?>'><?php echo $article->getName($currentLocale); ?></a></td>
    <td class="nowrap text-right"><?php echo $article->getVisits(); ?></td>
</tr>
<? endforeach ?>
</tbody>
</table>
<p><a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'visit')) ?>"><?php echo $view['translator']->trans('Lisää') ?></a></p>

    </div>
    <div class="six columns" id="recent-articles">

<h3><?php echo $view['translator']->trans('Uusimmat kirjoitukset') ?></h3> 

<table class="wide">
<thead>
<tr>
    <th>#</th>
    <th><?php echo $view['translator']->trans('Kirjoitus') ?></th>
    <th class="text-right"><?php echo $view['translator']->trans('Julkaistu') ?></th>
</tr>
</thead>
<tbody>
<? $i = 1; ?>
<? foreach ($recentArticles as $article): ?>
<tr>
    <td><?php echo $i++ ?>.</td>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName($currentLocale)))) ?>'><?php echo $article->getName($currentLocale); ?></a></td>
    <td class="nowrap text-right"><?php echo $article->getCreated()->format('Y-m-d'); ?></td>
</tr>
<? endforeach ?>
</tbody>
</table>
<p>
    <a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'published')) ?>"><?php echo $view['translator']->trans('Lisää') ?></a>
    <span class="feed-icon"><a title="<?php echo $view['translator']->trans('Pulupalstan uusimmat kirjoitukset') ?>" href="<?php echo $view['router']->generate('pulu_palsta_feed_recent_articles') ?>"><img src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/16_feed.png') ?>" alt="<?php echo $view['translator']->trans('Pulupalstan uusimmat kirjoitukset') ?>" /></a></span>
</p>

    </div>
</div><!-- Popular/Recent articles ends -->

<!-- Keyword cloud row -->
<section id="cloud"></section>
<div id="keyword-cloud-container">
<div class="row">
    <div class="six columns">

<div id="keyword-cloud">
<ul>
<?php foreach ($keywords as $keyword): ?>
    <li class="keyword<?php echo $keyword['normalized_weight'] ?>"><a href="javascript:void(0);" class="keyword" data-keyword_id="<?php echo $keyword['id'] ?>"><?php echo $keyword['name'] ?></a></li>
<?php endforeach ?>
</ul>
<p><a href="<?php echo $view['router']->generate('pulu_palsta_index') ?>"><?php echo $view['translator']->trans('Avainsanahakemisto') ?></a></p>
</div>

    </div>
    <div class="six columns" id="keyword-results">

<p id="select-keyword"><?php echo $view['translator']->trans('VALITSE') ?><br /><?php echo $view['translator']->trans('VAPAASTI') ?><br /><span>&#8592;</span></p>

    </div>
</div>
</div>

<?php $view['slots']->stop() ?>