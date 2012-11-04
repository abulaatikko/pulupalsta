<?php if ($errors): ?>
<div class="error">
<?php foreach ($errors as $error): ?>
    <small><?php
        if (null === $error->getMessagePluralization()) {
            echo $view['translator']->trans(
                $error->getMessageTemplate(),
                $error->getMessageParameters(),
                'validators'
            );
        } else {
            echo $view['translator']->transChoice(
                $error->getMessageTemplate(),
                $error->getMessagePluralization(),
                $error->getMessageParameters(),
                'validators'
            );
        }?></small>
<?php endforeach; ?>
</div>
<?php endif ?>