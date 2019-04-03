<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', $module->getName() . ' - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1><?php echo $module->getName() ?></h1>
<ul class="breadcrumbs">
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_module') ?>">Moduulit</a></li>
    <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_module_use', array('id' => $module->getId())) ?>" class="current"><?php echo $module->getName() ?></a></li>
</ul>

    <?php if (empty($tables_exist)): ?>
    <div class="row">
        <div class="twelve columns">
            <div>
                <label>SQL-skeema</label>
                
<textarea style="height: 300px" class="fixed-font"><?php echo $sql ?></textarea>

            </div>
        </div>
    </div>
    <?php else: ?>

        <?php if ($module->getType() == $module::TYPE_ADMIN_BEER_TASTING): ?>
    <div class="row">
        <div class="twelve columns">
    
    <select style="margin: 15px 0px 30px 0px" id="beer-select" data-module_id="<?php echo $module->getId() ?>" data-init_beer="<?php echo ! empty($data['beer_id']) ? $data['beer_id'] : '' ?>">
        <option value="">Lisää uusi olut...</option>
        <?php foreach ($data['beers'] as $beer): ?>
        <option value="<?php echo $beer['id'] ?>"><?php echo date('Y-m-d', strtotime($beer['drunk_date'])) ?> (#<?php echo $beer['row_number'] ?>): <?php echo $beer['name'] ?></option>
        <?php endforeach ?>
    </select>

        </div>
    </div>

    <form action="<?php echo $view['router']->path('pulu_palsta_admin_module_use', array('id' => $module->getId())) ?>" method="post" id="beer-edit">

    <div class="row">
        <div class="two columns">
            <label>Id</label>
        </div>
        <div class="ten columns">
            <input type="text" name="id" disabled="disabled" value="" />
        </div>
    </div>
    <div class="row">
        <div class="two columns">
            <label>Nimi <span class="required">*</span></label>
        </div>
        <div class="ten columns">
            <input type="text" name="name" value="" required />
        </div>
    </div>
    <div class="row">
        <div class="two columns">
            <label>Hinta (9.99)</label>
        </div>
        <div class="ten columns">
            <input type="text" name="price"  value="" />
        </div>
    </div>
    <div class="row">
        <div class="two columns">
            <label>Alc (9.9)</label>
        </div>
        <div class="ten columns">
            <input type="text" name="alc" value="" />
        </div>
    </div>
    <div class="row">
        <div class="two columns">
            <label>Pisteet (0-5)</label>
        </div>
        <div class="ten columns">
            <input type="text" name="grade" value="" />
        </div>
    </div>
    <div class="row">
        <div class="two columns">
            <label>Juotu (VVVV-KK-PP) <span class="required">*</span></label>
        </div>
        <div class="ten columns">
            <input type="text" name="drunk" value="" required />
        </div>
    </div>
    <div class="row">
        <div class="two columns">
            <label>Tyyli</label>
        </div>
        <div class="ten columns">
            <select name="style">
                <option></option>
                <?php foreach ($form_data['styles'] as $style): ?>
                    <option value="<?php echo $style['id'] ?>"><?php echo $style['name'] ?></option>
                <?php endforeach ?>
            </select>
            <input type="text" name="new_style" />
        </div>
    </div>
    <div class="row">
        <div class="two columns">
            <label>Maa</label>
        </div>
        <div class="ten columns">
            <select name="country">
                <option></option>
                <?php foreach ($form_data['countries'] as $country): ?>
                    <option value="<?php echo $country['id'] ?>"><?php echo $country['name'] ?></option>
                <?php endforeach ?>
            </select>
            <input type="text" name="new_country" />
        </div>
    </div>
    <div class="row">
        <div class="two columns">
            <label>Tarina</label>
        </div>
        <div class="ten columns">
            <textarea name="desc" style="height: 100px"></textarea>
        </div>
    </div>

    <input type="hidden" name="beer_id" value="" />
    <input class="button" type="submit" value="Tallenna" />
    <input class="alert button right" id="deleteConfirmation" type="submit" value="Poista" style="display: none" />
    </form>
        <?php endif ?>
    <?php endif ?>

<?php $view['slots']->stop('body') ?>

<?php $view['slots']->start('reveal') ?>

<div id="deleteConfirmationModal" class="reveal-modal small">
    <h4>Oletko varma?</h4>
    <form action="<?php echo $view['router']->path('pulu_palsta_admin_module_use', array('id' => $module->getId())) ?>" method="post">
        <input class="secondary button close" type="submit" value="Peruuta" />
        <input class="alert button right" name="delete" type="submit" value="Kyllä" />
        <input type="hidden" name="beer_id" value="" />
    </form>
    <a class="close-reveal-modal">&#215;</a>
</div>

<?php $view['slots']->stop() ?>
