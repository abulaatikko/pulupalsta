<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->start('body') ?>

<ul class="breadcrumbs">
  <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
  <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_article') ?>" class="current">Artikkelit</a></li>
</ul>

<h1>Artikkelit</h1>

<p><a href="<?php echo $view['router']->path('pulu_palsta_admin_article_create') ?>">Luo uusi artikkeli</a></p>

<table class="wide">
<thead>
<tr>
    <th colspan="3">Kirjoitus</th>
    <th>Kirjoitettu</th>
    <th>Muokattu</th>
    <th>Commentable</th>
</tr>
</thead>

<tbody>
<?php foreach ($articles as $article): ?>
<?php $isPublicStyle = $article->isPublic() ? '' : ' text-decoration: line-through;'; ?>
<?php $isOpinionStyle = $article->getType() !== 4 ? '' : ' display: initial; opacity: 20%;'; ?>
<?php $typeText = $articleTypes[$article->getType()] ?? '' ?>
<?php $typeStyles = 'font-size: 60%; text-align: right; font-weight: bold; color: ' . $article->getTypeColor(); ?>
<tr>
    <td style="<?php echo $isPublicStyle ?>"><span style="<?php echo $isOpinionStyle ?>"><a href="<?php echo $view['router']->path('pulu_palsta_admin_article_edit', array('id' => $article->getId())) ?>"><?php echo $article->getIsOneOfBest() ? '<strong>' : '' ?><?php echo $article->getName(); ?><?php echo $article->getIsOneOfBest() ? '</strong>' : '' ?></a> (<?php echo $article->getArticleNumber() ?>)</span></td>
    <td class="centered" style="width: 30px"> <img class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" /></td>
    <td style="<?php echo $typeStyles; ?>"><?php echo $article->getTypeName() ?></td>

    <td class="nowrap"><?php echo $article->getCreated()->format('Y-m-d') ?></td>
    <td class="nowrap"><?php echo $article->getModified()->format('Y-m-d') ?></td>
    <td class="centered"><?php echo $article->getIsCommentable() ? 'X' : '' ?></td>
</tr>
<?php endforeach ?>

</tbody>
</table>

<?php $view['slots']->stop() ?>
