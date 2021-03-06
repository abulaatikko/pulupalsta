<?php $view->extend('PuluPalstaBundle:Admin:base.html.php') ?>

<?php $view['slots']->start('body') ?>

<ul class="breadcrumbs">
  <li><a href="<?php echo $view['router']->path('pulu_palsta_admin') ?>">Etusivu</a></li>
  <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_article') ?>">Artikkelit</a></li>
  <li><a href="<?php echo $view['router']->path('pulu_palsta_admin_article_edit', array('id' => $article->getId())) ?>" class="current"><?php echo htmlspecialchars($article->getName('fi')) ?></a> (historia)</li>
</ul>

<h1>Historia (<?php echo $language ?>)</h1>

<div class="row">
<div class="six columns">
    <ul>
        <?php $selectedRevisionCreated = null ?>
        <?php $revisionsFound = array(); ?>
        <?php foreach ($revisions as $rev): ?>
            <?php if ($rev->getLanguage() !== $language): ?>
                <?php continue; ?>
            <?php endif ?>
            <?php if (! empty($revision) && $rev->getRevision() == $revision['revision']): ?>
                <?php $selectedRevisionCreated = $rev->getCreated(); ?>
            <?php endif ?>
            <?php if (in_array($rev->getRevision(), $revisionsFound)): ?>
                <?php continue; ?>
            <?php endif ?>
            <?php $revisionsFound[] = $rev->getRevision(); ?>
        <li>
            <a href="<?php echo $view['router']->path('pulu_palsta_admin_article_history', array('id' => $article->getId(), 'revision' => $rev->getRevision(), 'language' => $rev->getLanguage())) ?>">r<?php echo $rev->getRevision() ?>: <?php echo $rev->getCreated()->format('Y-m-d H:i:s') ?></a>
            (<a href="<?php echo $view['router']->path('pulu_palsta_admin_article_diff', array('id' => $article->getId(), 'revision' => $rev->getRevision(), 'language' => $rev->getLanguage())) ?>">diff</a>)
        </li>
        <?php endforeach ?>
    </ul>
</div>
<div class="six columns"></div>
</div>

<?php if (! empty($revision)): ?>

<h2>r<?php echo $revision['revision'] ?>: <?php echo $selectedRevisionCreated->format('Y-m-d H:i:s') ?></h2>

<div>
Nimet:
<input type="text" name="" value="<?php echo htmlspecialchars($revision['name']) ?>">
</div>

<div>
Houkutustekstit:
<textarea name="" id=""><?php echo htmlspecialchars($revision['teaser']) ?></textarea>
</div>

<div>
Rungot:
<textarea name="body_fi" id="article_localizations_0_body"><?php echo htmlspecialchars($revision['body']) ?></textarea>
</div>

<?php endif ?>

<?php $view['slots']->stop() ?>
