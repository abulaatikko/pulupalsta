<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Artikkelit - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<ul class="breadcrumbs">
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin') ?>">Etusivu</a></li>
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article') ?>" class="current">Artikkelit</a></li>
</ul>

<h1>Artikkelit</h1>

<p><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article_create') ?>">Luo uusi artikkeli</a></p>

<table class="wide">
<thead>
<tr>
    <th colspan="3">Kirjoitus</th>
    <th>Kirjoitettu</th>
    <th>Muokattu</th>
</tr>
</thead>

<tbody>
<? foreach ($articles as $article): ?>
<? $isPublicStyle = $article->isPublic() ? '' : ' style="text-decoration: line-through"'; ?>
<? $typeText = $articleTypes[$article->getType()] ?>
<?
$typeStyles = 'font-size: 60%; text-align: right; font-weight: bold';
if ($typeText == 'Adventure') { $typeStyles .= '; color: navy';}
if ($typeText == 'Research') { $typeStyles .= '; color: green';}
if ($typeText == 'Art') { $typeStyles .= '; color: red';}
?>
<tr>
    <td<?php echo $isPublicStyle ?>><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article_edit', array('id' => $article->getId())) ?>"><?php echo $article->getName() ?></a> (<?php echo $article->getArticleNumber() ?>)</td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
    <td style="<?php echo $typeStyles; ?>"><?php echo $typeText ?></td>

    <td class="nowrap"><?php echo $article->getCreated()->format('Y-m-d') ?></td>
    <td class="nowrap"><?php echo $article->getModified()->format('Y-m-d') ?></td>
</tr>
<? endforeach ?>

</tbody>
</table>

<?php $view['slots']->stop() ?>
