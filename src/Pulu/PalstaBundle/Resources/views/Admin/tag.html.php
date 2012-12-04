<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Asiasanat - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<ul class="breadcrumbs">
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin') ?>">Etusivu</a></li>
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_tag') ?>" class="current">Asiasanat</a></li>
</ul>

<h1>Asiasanat</h1>

<p><a href="<?php echo $view['router']->generate('pulu_palsta_admin_tag_create') ?>">Luo uusi asiasana</a></p>

<table class="wide">
<thead>
<tr>
    <th>Asiasana</th>
    <th>Painoarvo</th>
    <th>Luotu</th>
    <th>Muokattu</th>
</tr>
</thead>

<tbody>
<? foreach ($tags as $tag): ?>
<tr>
    <td class="nowrap"><a href="<?php echo $view['router']->generate('pulu_palsta_admin_tag_edit', array('id' => $tag->getId())) ?>"><?php echo $tag->getName('fi') ?></a></td>
    <td class="nowrap"><?php echo(sprintf("%.2f", $tag->getWeight())) ?></td>
    <td class="nowrap"><?php echo $tag->getCreated()->format('Y-m-d') ?></td>
    <td class="nowrap"><?php echo $tag->getModified()->format('Y-m-d') ?></td>
</tr>
<? endforeach ?>

</tbody>
</table>

<?php $view['slots']->stop() ?>
