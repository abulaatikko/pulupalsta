<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->set('title', 'Palstanhoitoa jo vuodesta 2006 - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>
<h1>Tervetuloa!</h1>

<p>Pulupalsta on kokoelma allekirjoittaneen eri aiheisia kirjoituksia eri elämänalueilta ja aikakausilta. Kirjoituksissa käsitellään pääasiassa henkilökohtaisia asioita, mutta tavoite on saada aikaiseksi myös laajempaa merkittävyyttä. Uudelle lukijalle suosittelen valitsemaan alla olevasta pilvestä kiinnostavan asiasanan tai lukemaan jonkin <a href="">suosituimmista</a> kirjoituksista.</p>

<p>Kiitän mielenkiinnosta, ja erityisesti jos heität arvosanan kirjoituksen luettuasi.</p>

<!-- Tag cloud row -->
<div class="row">
    <div class="six columns">

<div id="tag-cloud">
<ul>
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
</ul>
<p><a href="">Lisää</a></p>
</div>

    </div>
    <div class="six columns" id="tag-results">

<table id="table1" class="by-tag hide">
<thead>
<tr><th>#</th><th>Kirjoitus</th><th>Pojot</th></tr>
</thead>
<tbody>
<tr><td>1.</td><td><a href="">100 punnerrusta</a></td><td>95 %</td></tr>
<tr><td>2.</td><td><a href="">1500 litraa Pepsiä litraa litraa litraa litraa ja Sony litraa Vaio litraa S5 litraa</a></td><td>34 %</td></tr>
</tbody>
</table>

<table id="table2" class="by-tag hide">
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

<p id="select-tag">VALITSE<br />VAPAASTI<br /><span>&#8592;</span></p>

    </div>
</div>

<!-- Popular/Recent articles -->
<div class="row">
    <div class="six columns" id="popular-articles">

<h3>Suosituimpia</h3>

<table class="wide">
<thead>
<tr>
    <th>#</th>
    <th>Kirjoitus</th>
    <th>Pojot</th>
</tr>
</thead>

<tbody>
<? $i = 1; ?>
<? foreach ($popularArticles as $article): ?>
<tr>
    <td><?php echo $i++ ?>.</td>
    <td><a href=''><?php echo $article->getName(); ?></a></td>
    <td class="nowrap"><?php echo $article->getPoints(); ?></td>
</tr>
<? endforeach ?>
</tbody>
</table>
<p><a href="">Lisää</a></p>

    </div>
    <div class="six columns" id="recent-articles">

<h3>Tuoreimpia</h3> 

<table class="wide">
<thead>
<tr>
    <th>#</th>
    <th>Kirjoitus</th>
    <th>Julkaistu</th>
</tr>
</thead>
<tbody>
<? $i = 1; ?>
<? foreach ($recentArticles as $article): ?>
<tr>
    <td><?php echo $i++ ?>.</td>
    <td><a href=''><?php echo $article->getName(); ?></a></td>
    <td class="nowrap"><?php echo $article->getCreated()->format('Y-m-d'); ?></td>
</tr>
<? endforeach ?>
</tbody>
</table>
<p><a href="">Lisää</a></p>

    </div>
</div><!-- Tag cloud row ends -->
<?php $view['slots']->stop() ?>