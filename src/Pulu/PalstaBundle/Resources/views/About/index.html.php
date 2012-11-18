<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Tietoa') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1><?php echo $view['translator']->trans('Tietoa') ?></h1>

<h2><?php echo $view['translator']->trans('Mitä') ?>?</h2>

<h2><?php echo $view['translator']->trans('Miksi') ?>?</h2>

<h2><?php echo $view['translator']->trans('Miten') ?>?</h2>

<h2><?php echo $view['translator']->trans('Kuka') ?>?</h2>

<h2><?php echo $view['translator']->trans('Milloin') ?>?</h2>

<?php $view['slots']->stop() ?>