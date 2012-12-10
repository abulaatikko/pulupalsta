<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Kirjautuminen - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1>Kirjautuminen</h1>

<?php /*if ($error): ?>
    <div><?php echo $error->getMessage() ?></div>
<?php endif; */ ?>

<form action="<?php echo $view['router']->generate('pulu_palsta_login_check') ?>" method="post">
    <label for="username">Käyttäjä:</label>
    <input style="width: 200px" type="text" id="username" name="_username" value="<?php echo $last_username ?>" />

    <label for="password">Salasana:</label>
    <input style="width: 200px" type="password" id="password" name="_password" />

    <input class="button" type="submit" value="Kirjaudu" />
</form>

<?php $view['slots']->stop() ?>