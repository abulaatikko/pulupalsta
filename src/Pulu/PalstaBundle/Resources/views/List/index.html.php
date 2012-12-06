<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Luettelo') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1><?php echo $view['translator']->trans('Luettelo') ?></h1>

<table class="wide">
<thead>
<tr>
    <th>#</th>
    <th><?php echo $view['translator']->trans('Kirjoitus') ?></th>
    <th><?php echo $view['translator']->trans('Julkaistu') ?></th>
</tr>
</thead>
<tbody>
<? $i = 1; ?>
<? foreach ($articles as $article): ?>
<tr>
    <td><?php echo $i++ ?>.</td>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('id' => $article->getId(), 'name' => $view['helper']->toFilename($article->getName($app->getRequest()->getLocale())))) ?>'><?php echo $article->getName($app->getRequest()->getLocale()); ?> (<?php echo $article->getId() ?>)</a></td>
    <td class="nowrap"><?php echo $article->getCreated()->format('Y-m-d'); ?></td>
</tr>
<? endforeach ?>
</tbody>
</table>

<?php $view['slots']->stop() ?>