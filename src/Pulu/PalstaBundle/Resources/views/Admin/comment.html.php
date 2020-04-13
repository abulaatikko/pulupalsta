<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->start('body') ?>

<ul class="breadcrumbs">
  <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
  <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_comment') ?>" class="current">Kommentit</a></li>
</ul>

<h1>Kommentit</h1>

<table class="wide">
<thead>
<tr>
    <th>Artikkeli</th>
    <th>Kommentti</th>
    <th>Kirjoittaja</th>    
    <th>Kirjoitettu</th>
</tr>
</thead>

<tbody>
<?php foreach ($comments as $comment): ?>
<tr>
    <td class="nowrap"><a href="<?php echo $view['router']->path('pulu_palsta_admin_article_edit', array('id' => $comment->getArticle()->getId())) ?>">#<?php echo $comment->getArticle()->getId() ?></a></td>
    <td><a href="<?php echo $view['router']->path('pulu_palsta_admin_comment_edit', array('id' => $comment->getId())) ?>"><?php echo(mb_substr(htmlspecialchars($comment->getBody()), 0, 100)) ?></a></td>
    <td class="nowrap"><?php echo(htmlspecialchars($comment->getAuthorName())) ?></td>
    <td class="nowrap"><?php echo $comment->getCreated()->format('Y-m-d') ?></td>
</tr>
<?php endforeach ?>

</tbody>
</table>

<?php $view['slots']->stop() ?>
