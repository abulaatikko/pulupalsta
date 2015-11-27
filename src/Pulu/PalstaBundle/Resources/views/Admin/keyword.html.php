<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Avainsanat - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<ul class="breadcrumbs">
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin') ?>">Etusivu</a></li>
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_keyword') ?>" class="current">Avainsanat</a></li>
</ul>

<h1>Avainsanat</h1>

<p><a href="<?php echo $view['router']->generate('pulu_palsta_admin_keyword_create') ?>">Luo uusi avainsana</a></p>

<p><a href="javascript:void(0);" id="toggleKeywords" data-alt-text="Näytä vain yleisavainsanat">Näytä kaikki avainsanat</a></p>

<table class="wide">
<thead>
<tr>
    <th>Avainsana</th>
    <th>Painoarvo</th>
    <th>Luotu</th>
    <th>Muokattu</th>
</tr>
</thead>

<tbody>
<? foreach ($keywords as $keyword): ?>
<?php $name = $keyword->getName('fi'); ?>
<?php
if ($view['helper']->startsWithUppercase($name)) {
    $hidden = 'hide';
    $special = '1';
} else {
    $hidden = '';
    $special = 0;
}
?>
<tr data-special="<?= $special ?>" class="<?= $hidden ?>">
    <td class="nowrap"><a href="<?php echo $view['router']->generate('pulu_palsta_admin_keyword_edit', array('id' => $keyword->getId())) ?>"><?= $name ?></a></td>
    <td class="nowrap"><?php echo(sprintf("%.2f", $keyword->getWeight())) ?></td>
    <td class="nowrap"><?php echo $keyword->getCreated()->format('Y-m-d') ?></td>
    <td class="nowrap"><?php echo $keyword->getModified()->format('Y-m-d') ?></td>
</tr>
<? endforeach ?>

</tbody>
</table>

<?php $view['slots']->stop() ?>
