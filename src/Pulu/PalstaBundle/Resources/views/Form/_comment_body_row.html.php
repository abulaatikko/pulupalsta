<?php echo $view['form']->label($form, $label) ?>
<textarea style="height: 144px; margin-bottom: 2px"
    <?php echo $view['form']->block($form, 'widget_attributes') ?>
    ><?php if (!empty($value)): ?><?php echo $view->escape($value) ?><?php endif ?></textarea>
<small>HTML, Markdown etc. not supported.</small>
<?php echo $view['form']->errors($form) ?>
