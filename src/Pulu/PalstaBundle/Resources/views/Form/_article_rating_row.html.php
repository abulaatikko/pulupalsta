<?php echo $view['form']->label($form, $label) ?>
<input
    type="<?php echo isset($type) ? $view->escape($type) : 'text' ?>"
    <?php if (!empty($value)): ?>value="<?php echo $view->escape($value) ?>"<?php endif ?>
    <?php echo $view['form']->block($form, 'widget_attributes') ?>
    style="width: 150px"
/>
<?php echo $view['form']->errors($form) ?>