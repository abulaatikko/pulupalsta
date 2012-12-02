<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Luettelo') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1><?php echo $article->getName($app->getRequest()->getLocale()) ?></h1>

<p><?php echo $article->getTeaser($app->getRequest()->getLocale()) ?></p>

<?php echo $article->getBody($app->getRequest()->getLocale()) ?>

<?php if (! empty($comments)): ?>
<h2><?php echo $view['translator']->trans('Kommentit') ?></h2>

<table class="wide">
<thead>
<tr>
    <th><?php echo $view['translator']->trans('Kirjoittaja') ?></th>
    <th><?php echo $view['translator']->trans('Kommentti') ?></th>
</tr>
</thead>
<tbody>
<? foreach ($comments as $comment): ?>
<tr>
    <td style="width: 20%"><strong><?php echo $comment->getAuthorName() ?></strong><br /><?php echo $comment->getCreated()->format('Y-m-d H:i') ?></td>
    <td><?php echo(nl2br($view['helper']->convertUrlsToLinks(htmlspecialchars($comment->getBody())))) ?></td>
</tr>
<? endforeach ?>

</tbody>
</table>
<? endif ?>

<h3><?php echo $view['translator']->trans('Kirjoita uusi kommentti') ?></h3>

<form action="<?php echo $view['router']->generate($app->getRequest()->get('_route'), $app->getRequest()->get('_route_params')) ?>" method="post" <?php echo $view['form']->enctype($form) ?> >
    <?php $view['form']->setTheme($form, array('PuluPalstaBundle:Form')) ;?>
    <div class="row">
    <div class="six columns">
    <?php echo $view['form']->row($form['body']) ?>
    </div>
    <div class="six columns">
    <?php echo $view['form']->row($form['author_name']) ?>
    <?php echo $view['form']->row($form['safe_question']) ?>
    <?php echo $view['form']->rest($form) ?>
    <p><input class="button success" type="submit" value="<?php echo $view['translator']->trans('Lähetä') ?>" /></p>
    </div>
    </div>
</form>

<?php $view['slots']->stop() ?>