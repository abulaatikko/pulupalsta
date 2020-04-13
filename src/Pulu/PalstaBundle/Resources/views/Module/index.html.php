<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->start('body') ?>

<ul class="breadcrumbs">
  <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
  <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_module') ?>" class="current">Moduulit</a></li>
</ul>

<h1>Moduulit</h1>

<p><a href="<?php echo $view['router']->path('pulu_palsta_admin_module_create') ?>">Luo uusi moduuli</a></p>

<table class="wide">
<thead>
<tr>
    <th>Moduuli</th>
    <th>Artikkeli</th>
</tr>
</thead>

<tbody>
<?php foreach ($modules as $module): ?>
<tr>
    <td><a href="<?php echo $view['router']->path('pulu_palsta_admin_module_use', array('id' => $module->getId())) ?>"><?php echo $module->getName() ?></a> (<a href="<?php echo $view['router']->path('pulu_palsta_admin_module_edit', array('id' => $module->getId())) ?>">muokkaa</a>)</td>
    <td><a href="<?php echo $view['router']->path('pulu_palsta_admin_article_edit', array('id' => $module->getArticle()->getId())) ?>"><?php echo $module->getArticle()->getName() ?></a></td>
</tr>
<?php endforeach ?>
</tbody>
</table>

<?php $view['slots']->stop() ?>
