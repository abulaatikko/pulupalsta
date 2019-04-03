<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php if ($module->getId() > 0): ?>
<?php $view['slots']->set('title', $module->getName() . ' - Ylläpito - Pulupalsta') ?>
<?php else: ?>
<?php $view['slots']->set('title', 'Luo moduuli - Ylläpito - Pulupalsta') ?>
<?php endif ?>

<?php $view['slots']->start('body') ?>

<?php if ($module->getId() > 0): ?>
<ul class="breadcrumbs">
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_module') ?>">Moduulit</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_module_edit', array('id' => $module->getId())) ?>" class="current"><?php echo $module->getName() ?></a></li>
</ul>
<h1><?php echo $module->getName() ?></h1>
<?php $formUrl = 'pulu_palsta_admin_module_edit'; ?>
<?php else: ?>
<ul class="breadcrumbs">
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_module') ?>">Moduulit</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_module_create') ?>" class="current">Luo uusi</a></li>
</ul>
<h1>Luo uusi moduuli</h1>
<?php $formUrl = 'pulu_palsta_admin_module_create'; ?>
<?php endif ?>

<form action="<?php echo $view['router']->path($formUrl, array('id' => $module->getId())) ?>" method="post">
    <?php $view['form']->setTheme($form, array('PuluPalstaBundle:Form')) ?>

    <div class="row">
        <div class="twelve columns">
            <?php echo $view['form']->row($form['name']) ?>
        </div>
    </div>
    <div class="row">
        <div class="six columns">
            <?php echo $view['form']->row($form['article']) ?>
        </div>
        <div class="six columns">
            <?php echo $view['form']->row($form['type']) ?>
        </div>
    </div>

    <?php echo $view['form']->rest($form) ?>

    <br />
    <?php if ($module->getId() > 0): ?>
    <input type="hidden" name="id" value="<?php echo $module->getId() ?>" />
    <?php endif ?>
    <input class="button" type="submit" value="Tallenna" />
    <?php if ($module->getId() > 0): ?>
    <input class="alert button right" id="deleteConfirmation" type="submit" value="Poista" />
    <?php endif ?>
</form>

<?php $view['slots']->stop('body') ?>

<?php $view['slots']->start('reveal') ?>

<div id="deleteConfirmationModal" class="reveal-modal small">
    <h4>Oletko varma?</h4>
    <form action="<?php echo $view['router']->path($formUrl, array('id' => $module->getId())) ?>" method="post">
        <input class="secondary button close" type="submit" value="Peruuta" />
        <input class="alert button right" name="delete" type="submit" value="Kyllä" />
    </form>
    <a class="close-reveal-modal">&#215;</a>
</div>

<?php $view['slots']->stop() ?>
