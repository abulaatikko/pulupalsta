<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Sisällys') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1><?php echo $view['translator']->trans('Sisällys') ?></h1>

<table class="wide" id="contents">
<thead>
<tr>
    <th><?php echo $view['translator']->trans('Kirjoitus') ?></th>
    <th title="<?php echo $view['translator']->trans('Vierailujen lukumäärä') ?>"><?php echo $view['translator']->trans('Vier.') ?></span></th>
    <th title="<?php echo $view['translator']->trans('Arvosana') ?>"><?php echo $view['translator']->trans('Arv.') ?></th>
    <th title="<?php echo $view['translator']->trans('Kommenttien lukumäärä') ?>"><?php echo $view['translator']->trans('Kom.') ?></span></th>
    <th><?php echo $view['translator']->trans('Kommentoitu') ?></th>
    <th><?php echo $view['translator']->trans('Muokattu') ?></th>
    <th><?php echo $view['translator']->trans('Julkaistu') ?></th>
</tr>
</thead>
<tbody>
<? foreach ($articles as $article): ?>
<tr>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('id' => $article->getId(), 'name' => $view['helper']->toFilename($article->getName($app->getRequest()->getLocale())))) ?>'><?php echo $article->getName($currentLocale); ?></a></td>
    <td><?php echo $article->getVisits() ?></td>
    <td><?php echo $article->getRating() ?></td>
    <td><?php echo $article->getCommentsCount() ?></td>
    <?php $lastCommented = $article->getLastCommented(); ?>
    <?php if ($lastCommented instanceof DateTime): ?>
    <td><?php echo $lastCommented->format('Y-m-d') ?></td>
    <? else: ?>
    <td></td>
    <? endif ?>
    <td><?php echo $article->getModified()->format('Y-m-d') ?></td>
    <td class="nowrap"><?php echo $article->getCreated()->format('Y-m-d'); ?></td>
</tr>
<? endforeach ?>
</tbody>
</table>

<p>
    <?php echo $view['translator']->trans('Vier.') ?> = <?php echo $view['translator']->trans('Vierailujen lukumäärä') ?><br />
    <?php echo $view['translator']->trans('Arv.') ?> = <?php echo $view['translator']->trans('Arvosana') ?><br />
    <?php echo $view['translator']->trans('Kom.') ?> = <?php echo $view['translator']->trans('Kommenttien lukumäärä') ?>
</p>

<?php $view['slots']->stop() ?>