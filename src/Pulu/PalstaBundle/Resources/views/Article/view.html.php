<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Directory') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1><?php echo $article->getName($app->getRequest()->getLocale()) ?></h1>

<p><?php echo $article->getTeaser($app->getRequest()->getLocale()) ?></p>

<p><?php echo $article->getBody($app->getRequest()->getLocale()) ?></p>

<h2>Kommentit</h2>

<?php echo $view['form']->widget($form) ?>

<?php $view['slots']->stop() ?>