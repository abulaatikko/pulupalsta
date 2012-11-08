<?php echo $view['form']->label($form, $label) ?>
<textarea
    <?php echo $view['form']->block($form, 'widget_attributes') ?>
    style="height: 500px"
    ><?php if (!empty($value)): ?><?php echo $view->escape($value) ?><?php endif ?></textarea>
<?php echo $view['form']->errors($form) ?>