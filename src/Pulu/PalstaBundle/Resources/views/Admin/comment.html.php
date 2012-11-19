<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Kommentit - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<ul class="breadcrumbs">
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin') ?>">Etusivu</a></li>
  <li><a href="<?php echo $view['router']->generate('pulu_palsta_admin_comment') ?>" class="current">Kommentit</a></li>
</ul>

<h1>Kommentit</h1>

<table class="wide">
<thead>
<tr>
    <th>Artikkeli</th>
    <th>Kirjoittaja</th>
    <th>Sisältö</th>
    <th>Kirjoitettu</th>
    <th>Muokattu</th>
</tr>
</thead>

<tbody>
<? foreach ($comments as $comment): ?>
<tr>
    <td class="nowrap"><a href="<?php echo $view['router']->generate('pulu_palsta_admin_article_edit', array('id' => $comment->getArticle()->getId())) ?>"><?php echo $comment->getArticle()->getName() ?></a></td>
    <td class="nowrap">
        <?php echo $comment->getAuthorName() ?><br />
        <?php echo $comment->getAuthorIpAddress() ?><br />
        <?php echo $comment->getAuthorUserAgent() ?>
    </td>
    <td><?php echo $comment->getContent() ?></td>
    <td class="nowrap"><?php echo $comment->getCreated()->format('Y-m-d') ?></td>
    <td class="nowrap"><?php echo $comment->getModified()->format('Y-m-d') ?></td>
</tr>
<? endforeach ?>

</tbody>
</table>

<?php $view['slots']->stop() ?>
