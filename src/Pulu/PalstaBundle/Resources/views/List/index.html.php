<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Sisällysluettelo') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1><?php echo $view['translator']->trans('Sisällysluettelo') ?></h1>

<table class="wide" id="contents">
<thead>
<tr>
    <th colspan="2"><?php echo $view['translator']->trans('Kirjoitus') ?></th>
    <th title="<?php echo $view['translator']->trans('Vierailujen lukumäärä') ?>"><?php echo $view['translator']->trans('Vier.') ?></th>
    <th class="text-right nowrap" title="<?php echo $view['translator']->trans('Kuukausivierailujen keskimääräinen lukumäärä julkaisusta lähtien') ?>"><?php echo $view['translator']->trans('Vier. (kk)') ?></th>
    <th title="<?php echo $view['translator']->trans('Arvosana') ?>"><?php echo $view['translator']->trans('Arv.') ?></th>
    <th title="<?php echo $view['translator']->trans('Kommenttien lukumäärä') ?>"><?php echo $view['translator']->trans('Kom.') ?></th>
    <th class="nowrap"><?php echo $view['translator']->trans('Kommentoitu') ?></th>
    <th class="nowrap"><?php echo $view['translator']->trans('Muokattu') ?></th>
    <th class="nowrap"><?php echo $view['translator']->trans('Julkaistu') ?></th>
</tr>
</thead>
<tbody>
<? foreach ($articles as $article): ?>
<tr>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getName(); ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
    <td class="text-right"><?php echo $article->getVisits() ?></td>
    <td class="nowrap text-right"><?php echo $article->getAverageMonthlyVisits(); ?></span></td>
    <td class="text-right"><?php echo $article->getRating() ?></td>
    <td class="text-right"><?php echo $article->getCommentsCount() ?></td>
    <?php $lastCommented = $article->getLastCommented(); ?>
    <?php if ($lastCommented instanceof DateTime): ?>
    <td class="nowrap text-right"><?php echo $lastCommented->format('Y-m-d') ?></td>
    <? else: ?>
    <td></td>
    <? endif ?>
    <td class="nowrap text-right"><?php echo $article->getModifiedPublic()->format('Y-m-d') ?></td>
    <td class="nowrap text-right"><?php echo $article->getPublished()->format('Y-m-d'); ?></td>
</tr>
<? endforeach ?>
</tbody>
</table>

<p class="table-notes">
    <?php echo $view['translator']->trans('Vier.') ?> = <?php echo $view['translator']->trans('Vierailujen lukumäärä') ?><br />
    <?php echo $view['translator']->trans('Vier. (kk)') ?> = <?php echo $view['translator']->trans('Kuukausivierailujen keskimääräinen lukumäärä julkaisusta lähtien') ?><br />
    <?php echo $view['translator']->trans('Arv.') ?> = <?php echo $view['translator']->trans('Arvosana') ?><br />
    <?php echo $view['translator']->trans('Kom.') ?> = <?php echo $view['translator']->trans('Kommenttien lukumäärä') ?>
</p>

<!--
<h2><?php echo $view['translator']->trans('Suorat linkit') ?></h2>

<p style="margin-bottom: 5px"><?php echo $view['translator']->trans('Taulukko järjestetty') ?>:</p>
<ul class="square">
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'name')) ?>"><?php echo $view['translator']->trans('kirjoituksen otsikon') ?></a></li>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'visit')) ?>"><?php echo $view['translator']->trans('vieraiden lukumäärän') ?></a></li>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'rating')) ?>"><?php echo $view['translator']->trans('arvosanan') ?></a></li>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'comments')) ?>"><?php echo $view['translator']->trans('kommenttien lukumäärän') ?></a></li>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'commented')) ?>"><?php echo $view['translator']->trans('uusimman kommentin') ?></a></li>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'modified')) ?>"><?php echo $view['translator']->trans('muokkauspäivämäärän') ?></a></li>
    <li><a href="<?php echo $view['router']->generate('pulu_palsta_list', array('sort' => 'published')) ?>"><?php echo $view['translator']->trans('julkaisupäivämäärän') ?></a><?php echo $view['translator']->trans(' mukaan.') ?></li>
</ul>
-->

<section id="feeds"></section>
<h2 style="margin-bottom: 5px"><img style="position: relative; top: 3px" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/32_feed.png') ?>" alt="<?php echo $view['translator']->trans('RSS-syötteet') ?>" /> <?php echo $view['translator']->trans('RSS-syötteet') ?></h2>
<ul class="square">
    <li><a title="<?php echo $view['translator']->trans('Pulupalstan uusimmat kirjoitukset') ?>" href="<?php echo $view['router']->generate('pulu_palsta_feed_recent_articles') ?>"><?php echo $view['translator']->trans('Uusimmat kirjoitukset') ?></a></li>
    <li><a title="<?php echo $view['translator']->trans('Pulupalstan uusimmat kommentit') ?>" href="<?php echo $view['router']->generate('pulu_palsta_feed_recent_comments') ?>"><?php echo $view['translator']->trans('Uusimmat kommentit') ?></a></li>
</ul>

<?php $view['slots']->stop() ?>
