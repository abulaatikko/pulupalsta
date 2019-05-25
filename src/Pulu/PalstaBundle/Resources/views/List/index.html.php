<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Articles - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1>Articles</h1>

<table class="wide" id="contents">
<thead>
<tr>
    <th colspan="3">Article</th>
    <th title="Number of Visits">Vis.</th>
    <th class="text-right nowrap" title="Average monthly visits since publication">Vis. / mon</th>
<!--    <th title="Rating">Rat.</th>-->
    <th title="Number of Comments">Com.</th>
    <th class="nowrap">Commented</th>
    <th class="nowrap">Modified</th>
    <th class="nowrap">Published</th>
</tr>
</thead>
<tbody>
<?php foreach ($articles as $article): ?>
<?php $typeText = isset($articleTypes[$article->getType()]) ? $articleTypes[$article->getType()] : '' ?>
<?php
$typeStyles = 'font-size: 60%; text-align: right; font-weight: bold';
if ($typeText == 'Expedition') { $typeStyles .= '; color: navy';}
if ($typeText == 'Research') { $typeStyles .= '; color: green';}
if ($typeText == 'Art') { $typeStyles .= '; color: art';}
if ($typeText == 'Essay') { $typeStyles .= '; color: black';}
?>
<tr>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
    <td style="<?php echo $typeStyles; ?>"><?php echo $typeText ?></td>
    <td class="text-right"><?php echo $article->getVisits() ?></td>
    <td class="nowrap text-right"><?php echo $article->getAverageMonthlyVisits(); ?></span></td>
<!--    <td class="text-right"><?php echo $article->getRating() ?></td>-->
    <td class="text-right"><?php echo $article->getCommentsCount() ?></td>
    <?php $lastCommented = $article->getLastCommented(); ?>
    <?php if ($lastCommented instanceof DateTime): ?>
    <td class="nowrap text-right"><?php echo $lastCommented->format('Y-m-d') ?></td>
    <?php else: ?>
    <td></td>
    <?php endif ?>
    <td class="nowrap text-right"><?php echo $article->getModifiedPublic()->format('Y-m-d') ?></td>
    <td class="nowrap text-right"><?php echo $article->getPublished()->format('Y-m-d'); ?></td>
</tr>
<?php endforeach ?>
</tbody>
</table>

<p class="table-notes">
    Vis. = Number of Visits<br />
    Vis. / mon = Average monthly visits since publication<br />
<!--    Rat. = Rating<br />-->
    Com. = Number of Comments
</p>

<!--
<h2><?php echo $view['translator']->trans('Suorat linkit') ?></h2>

<p style="margin-bottom: 5px"><?php echo $view['translator']->trans('Taulukko järjestetty') ?>:</p>
<ul class="square">
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'name')) ?>"><?php echo $view['translator']->trans('kirjoituksen otsikon') ?></a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'visit')) ?>"><?php echo $view['translator']->trans('vieraiden lukumäärän') ?></a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'rating')) ?>"><?php echo $view['translator']->trans('arvosanan') ?></a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'comments')) ?>"><?php echo $view['translator']->trans('kommenttien lukumäärän') ?></a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'commented')) ?>"><?php echo $view['translator']->trans('uusimman kommentin') ?></a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'modified')) ?>"><?php echo $view['translator']->trans('muokkauspäivämäärän') ?></a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'published')) ?>"><?php echo $view['translator']->trans('julkaisupäivämäärän') ?></a><?php echo $view['translator']->trans(' mukaan.') ?></li>
</ul>
-->

<!--<section id="feeds"></section>
<h2 style="margin-bottom: 5px"><img style="position: relative; top: 3px" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/32_feed.png') ?>" alt="RSS Feeds" /> RSS Feeds</h2>
<ul class="square">
    <li><a title="Pulupalsta Recent Articles" href="<?php echo $view['router']->path('pulu_palsta_feed_recent_articles') ?>">Recent Articles</a></li>
    <li><a title="Pulupalsta Recent Comments" href="<?php echo $view['router']->path('pulu_palsta_feed_recent_comments') ?>">Recent Comments</a></li>
</ul>-->

<?php $view['slots']->stop() ?>
