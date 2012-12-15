<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', $view['translator']->trans('Palstan hoitoa jo vuodesta 2006') . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<h1><?php echo $view['translator']->trans('Tervetuloa') ?>!</h1>

<?php if ($currentLocale == 'fi'): ?>
<p>Pulupalsta on kokoelma allekirjoittaneen eri aiheisia kirjoituksia eri elämänalueilta ja aikakausilta. Kirjoituksissa käsitellään pääasiassa henkilökohtaisia asioita, mutta tavoite on saada aikaiseksi myös laajempaa merkittävyyttä. Uudelle lukijalle suosittelen valitsemaan alla olevasta pilvestä kiinnostavan asiasanan tai lukemaan jonkin <a href="">suosituimmista kirjoituksista</a>.</p>

<p>Kiitän mielenkiinnosta, ja erityisesti jos heität arvosanan kirjoituksen luettuasi.</p>
<? else: ?>
<p>Pulupalsta is a collection of articles which discuss topics ranging different aspects of life in different eras. At the moment the articles mainly discuss my personal life but the humble goal is to achieve more relevancy for other people as well. If you are a new visitor I recommend you to use your freedom to pick up an interesting topic in the tag cloud below or read some of <a href="">the most popular articles</a>.</p>

<p>Unfortunately most of the articles are only in Finnish so you need to rely on automatic translation or just look at the images.</p>

<p>I appreciate your interest and especially if you rate the article after reading it.</p>
<? endif; ?>

<!-- Tag cloud row -->
<div class="row">
    <div class="six columns">

<div id="tag-cloud">
<ul>
<?php foreach ($keywords as $keyword): ?>
    <li class="tag<?php echo $keyword['normalized_weight'] ?>"><a href="" data-tag_id="<?php echo $keyword['id'] ?>"><?php echo $keyword['name'] ?></a></li>
<?php endforeach ?>
<!--<li class="tag6"><a href="" data-tag_id="1">auto</a></li>
<li class="tag6"><a href="" data-tag_id="2">Budabest</a></li>
<li class="tag5"><a href="" data-tag_id="2">juustohampurilainen</a></li>
<li class="tag4"><a href="" data-tag_id="1">Espoo</a></li>
<li class="tag3"><a href="" data-tag_id="2">pyöräily</a></li>
<li class="tag2"><a href="" data-tag_id="2">kuntarajakilpi</a></li>
<li class="tag1"><a href="" data-tag_id="2">alkoholi</a></li>
<li class="tag6"><a href="" data-tag_id="1">Lontoo</a></li>
<li class="tag5"><a href="" data-tag_id="1">Praha</a></li>
<li class="tag4"><a href="" data-tag_id="2">matkustaminen</a></li>
<li class="tag3"><a href="" data-tag_id="1">vaeltaminen</a></li>
<li class="tag2"><a href="" data-tag_id="1">kunnantalo</a></li>
<li class="tag1"><a href="" data-tag_id="2">kunnantalo</a></li>
<li class="tag6"><a href="" data-tag_id="1">auto</a></li>
<li class="tag6"><a href="" data-tag_id="2">Budabest</a></li>
<li class="tag5"><a href="" data-tag_id="2">juustohampurilainen</a></li>
<li class="tag4"><a href="" data-tag_id="1">Espoo</a></li>
<li class="tag3"><a href="" data-tag_id="2">pyöräily</a></li>
<li class="tag2"><a href="" data-tag_id="2">kuntarajakilpi</a></li>
<li class="tag1"><a href="" data-tag_id="2">alkoholi</a></li>
<li class="tag6"><a href="" data-tag_id="1">Lontoo</a></li>
<li class="tag5"><a href="" data-tag_id="1">Praha</a></li>
<li class="tag4"><a href="" data-tag_id="2">matkustaminen</a></li>
<li class="tag3"><a href="" data-tag_id="1">vaeltaminen</a></li>
<li class="tag2"><a href="" data-tag_id="1">kunnantalo</a></li>
<li class="tag1"><a href="" data-tag_id="2">kunnantalo</a></li>
<li class="tag6"><a href="" data-tag_id="1">auto</a></li>
<li class="tag6"><a href="" data-tag_id="2">Budabest</a></li>
<li class="tag5"><a href="" data-tag_id="2">juustohampurilainen</a></li>
<li class="tag4"><a href="" data-tag_id="1">Espoo</a></li>
<li class="tag3"><a href="" data-tag_id="2">pyöräily</a></li>
<li class="tag2"><a href="" data-tag_id="2">kuntarajakilpi</a></li>
<li class="tag1"><a href="" data-tag_id="2">alkoholi</a></li>
<li class="tag6"><a href="" data-tag_id="1">Lontoo</a></li>
<li class="tag5"><a href="" data-tag_id="1">Praha</a></li>
<li class="tag4"><a href="" data-tag_id="2">matkustaminen</a></li>
<li class="tag3"><a href="" data-tag_id="1">vaeltaminen</a></li>
<li class="tag2"><a href="" data-tag_id="1">kunnantalo</a></li>
<li class="tag1"><a href="" data-tag_id="2">kunnantalo</a></li>-->
</ul>
<p><a href=""><?php echo $view['translator']->trans('Lisää') ?></a></p>
</div>

    </div>
    <div class="six columns" id="tag-results">

<table id="table1" class="by-tag hide wide">
<thead>
<tr><th>#</th><th>Kirjoitus</th><th>Pojot</th></tr>
</thead>
<tbody>
<tr><td>1.</td><td><a href="">100 punnerrusta</a></td><td>95 %</td></tr>
<tr><td>2.</td><td><a href="">1500 litraa Pepsiä litraa litraa litraa litraa ja Sony litraa Vaio litraa S5 litraa</a></td><td>34 %</td></tr>
</tbody>
</table>

<table id="table2" class="by-tag hide wide">
<thead>
<tr><th>#</th><th>Kirjoitus</th><th>Pojot</th></tr>
</thead>
<tbody>
<tr><td>1.</td><td><a href="">Malyksen muutto Kemistä Kuopioon</a></td><td>95 %</td></tr>
<tr><td>2.</td><td><a href="">McDonald's Juustohampurilaisten syöntikilpailu</a></td><td>91 %</td></tr>
<tr><td>3.</td><td><a href="">Asuntoani ympäri -kisa</a></td><td>65 %</td></tr>
<tr><td>4.</td><td><a href="">Kokkikerho 2 - Kiinalaista</a></td><td>55 %</td></tr>
<tr><td>5.</td><td><a href="">Karhunkierros 70km</a></td><td>51 %</td></tr>
</tbody>
</table>

<p id="select-tag"><?php echo $view['translator']->trans('VALITSE') ?><br /><?php echo $view['translator']->trans('VAPAASTI') ?><br /><span>&#8592;</span></p>

    </div>
</div>

<!-- Popular/Recent articles -->
<div class="row">
    <div class="six columns" id="popular-articles">

<h3><?php echo $view['translator']->trans('Suosituimpia') ?></h3>

<table class="wide">
<thead>
<tr>
    <th>#</th>
    <th><?php echo $view['translator']->trans('Kirjoitus') ?></th>
    <th><?php echo $view['translator']->trans('Pisteet') ?></th>
</tr>
</thead>

<tbody>
<? $i = 1; ?>
<? foreach ($popularArticles as $article): ?>
<tr>
    <td><?php echo $i++ ?>.</td>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('id' => $article->getId(), 'name' => $view['helper']->toFilename($article->getName($app->getRequest()->getLocale())))) ?>'><?php echo $article->getName($app->getRequest()->getLocale()); ?></a></td>
    <td class="nowrap"><?php echo $article->getRating(); ?></td>
</tr>
<? endforeach ?>
</tbody>
</table>
<p><a href=""><?php echo $view['translator']->trans('Lisää') ?></a></p>

    </div>
    <div class="six columns" id="recent-articles">

<h3><?php echo $view['translator']->trans('Tuoreimpia') ?></h3> 

<table class="wide">
<thead>
<tr>
    <th>#</th>
    <th><?php echo $view['translator']->trans('Kirjoitus') ?></th>
    <th><?php echo $view['translator']->trans('Julkaistu') ?></th>
</tr>
</thead>
<tbody>
<? $i = 1; ?>
<? foreach ($recentArticles as $article): ?>
<tr>
    <td><?php echo $i++ ?>.</td>
    <td><a href='<?php echo $view['router']->generate('pulu_palsta_article', array('id' => $article->getId(), 'name' => $view['helper']->toFilename($article->getName($app->getRequest()->getLocale())))) ?>'><?php echo $article->getName($app->getRequest()->getLocale()); ?></a></td>
    <td class="nowrap"><?php echo $article->getCreated()->format('Y-m-d'); ?></td>
</tr>
<? endforeach ?>
</tbody>
</table>
<p><a href=""><?php echo $view['translator']->trans('Lisää') ?></a></p>

    </div>
</div><!-- Tag cloud row ends -->
<?php $view['slots']->stop() ?>