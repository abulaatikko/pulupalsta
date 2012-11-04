<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Luettelo - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1>Luettelo</h1>

<table class="wide">
<thead>
<tr>
    <th>#</th>
    <th>Kirjoitus</th>
    <th>Julkaistu</th>
</tr>
</thead>
<tbody>
<? $i = 1; ?>
<? foreach ($articles as $article): ?>
<tr>
    <td><?php echo $i++ ?>.</td>
    <td><a href=''><?php echo $article->getName(); ?> (<?php echo $article->getId() ?>)</a></td>
    <td class="nowrap"><?php echo $article->getCreated()->format('Y-m-d'); ?></td>
</tr>
<? endforeach ?>
</tbody>
</table>

<?php $view['slots']->stop() ?>