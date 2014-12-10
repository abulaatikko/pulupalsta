<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->set('title', 'Ohjeet - Ylläpito - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h2>Ohjeet</h2>

<ol>
    <li>Artikkelin alkuun voi kirjoittaa artikkelikohtaista php-koodia. Esim:
<pre style="font-size: 80%">
    <?php echo htmlspecialchars('
<?php
use Pulu\PalstaBundle\Entity\Article;
$article = $doctrine->getRepository("PuluPalstaBundle:Article")->findOneBy(array("id" => 1311));
echo "<h1>1!!!!: " . $article->getName() . "</h1>";'); ?>
</pre>
    </li>
    <li>Myös artikkelin oma SQL-skeema (oluet, kunta) voidaan laittaa php-kommentteihin artikkelin alkuun</li>
    <li>Oikeudet artikkelin lukuun:
        <ol>
            <li><strong>IS_ADMIN</strong>: näkee aina</li>
            <li><strong>IS_FRIEND</strong>: näkee, jos published &lt; now (is_public = false/true)</li>
            <li><strong>ALL</strong>: näkee, jos is_public = true</li>
        </ol>
    </li>
</ol>

<?php $view['slots']->stop() ?>
