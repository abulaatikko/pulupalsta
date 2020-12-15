<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Z: Collection') ?>
<?php $view['slots']->set('description', 'Collection of articles in Project-Z') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1>Collection</h1>

<table class="wide" id="contents">
<thead>
<tr>
    <th></th>
    <th></th>
    <th>Project</th>
    <th class="text-right nowrap" title="Average monthly views since published">Popularity</th>
    <th class="text-right" title="Number of views">Views</th>
    <th class="nowrap text-right">Published</th>
    <th class="nowrap text-right">Modified</th>
    <th class="nowrap text-right" title="Start moment of the project">Started</th>
    <!--<th title="Number of Comments">Com.</th>
    <th class="nowrap">Commented</th>-->
</tr>
</thead>
<tbody>
<?php foreach ($articles as $article): ?>
<?php $typeStyles = 'font-size: 60%; width: 1%; white-space: nowrap; text-align: right; font-weight: bold; color: ' . $article->getTypeColor(); ?>
<tr>
    <td style="<?php echo $typeStyles; ?>"><?php echo $article->getTypeName() ?></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
    <td><a href='<?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName()), '_locale' => $article->getLanguage())) ?>'><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a></td>
    <td class="nowrap text-right"><?php echo $article->getAverageMonthlyVisits(); ?></span></td>
    <td class="text-right"><?php echo $article->getVisits() ?></td>
    <td class="nowrap text-right"><?php echo $article->getPublished()->format('Y-m-d'); ?></td>
    <td class="nowrap text-right"><?php echo $article->getModified()->format('Y-m-d'); ?></td>
    <td class="nowrap text-right"><?php echo $article->getStarted()->format('Y-m-d'); ?></td>
    <!--<td class="text-right"><?php echo $article->getCommentsCount() ?></td>
    <?php $lastCommented = $article->getLastCommented(); ?>
    <?php if ($lastCommented instanceof DateTime): ?>
    <td class="nowrap text-right"><?php echo $lastCommented->format('Y-m-d') ?></td>
    <?php else: ?>
    <td></td>
    <?php endif ?>-->
</tr>
<?php endforeach ?>
</tbody>
</table>

<p class="table-notes">
    Views = Number of views<br />
    Popularity = Average monthly views since published<br />
    Started = Start moment of the project
<!--    Rat. = Rating<br />-->
<!--    Com. = Number of Comments-->
</p>

<!--
<h2><?php echo $view['translator']->trans('Suorat linkit') ?></h2>

<p style="margin-bottom: 5px"><?php echo $view['translator']->trans('Taulukko järjestetty') ?>:</p>
<ul class="square">
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'name')) ?>"><?php echo $view['translator']->trans('kirjoituksen otsikon') ?></a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'views')) ?>"><?php echo $view['translator']->trans('vieraiden lukumäärän') ?></a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'popularity')) ?>"><?php echo $view['translator']->trans('arvosanan') ?></a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'modified')) ?>"><?php echo $view['translator']->trans('muokkauspäivämäärän') ?></a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_list', array('sort' => 'published')) ?>"><?php echo $view['translator']->trans('julkaisupäivämäärän') ?></a><?php echo $view['translator']->trans(' mukaan.') ?></li>
</ul>
-->

<?php $view['slots']->stop() ?>
