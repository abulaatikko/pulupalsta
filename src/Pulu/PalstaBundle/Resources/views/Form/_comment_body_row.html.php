<?php echo $view['form']->label($form, $label) ?>
<textarea style="height: 144px"
    <?php echo $view['form']->block($form, 'widget_attributes') ?>
    ><?php if (!empty($value)): ?><?php echo $view->escape($value) ?><?php endif ?></textarea>
<?php echo $view['form']->errors($form) ?>