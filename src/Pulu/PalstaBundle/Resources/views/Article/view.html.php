<?php $view->extend('::base.html.php') ?>

<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<?php $view['slots']->set('title', $article->getName($currentLocale) . ' - Pulupalsta') ?>

<?php $view['slots']->start('body') ?>

<h1><?php echo $article->getName($currentLocale) ?></h1>

<p><strong><?php echo $view['translator']->trans('Avainsanat') ?>:</strong>
<?php $printKeywords = array(); ?>
<?php foreach ($article_keywords as $article_keyword): ?>
    <?php $printKeywords[] = '<a href="' . $view['router']->generate('pulu_palsta_index') . '#' . $article_keyword->getName() . '"><em>' . $article_keyword->getName($currentLocale) . '</em></a>'; ?>
<?php endforeach ?>
<?php echo implode(', ', $printKeywords) ?>
&nbsp;&nbsp;<strong><?php echo $view['translator']->trans('Arvosana') ?>:</strong> <?php echo $article->getRating() ?>/5
&nbsp;&nbsp;<strong><?php echo $view['translator']->trans('Vierailuja') ?>:</strong> <?php echo $article->getVisits() ?>
&nbsp;&nbsp;<strong><?php echo $view['translator']->trans('Julkaistu') ?>:</strong> <?php echo $article->getCreated()->format('Y-m-d') ?>
&nbsp;&nbsp;<strong><?php echo $view['translator']->trans('Muokattu') ?>:</strong> <?php echo $article->getModified()->format('Y-m-d') ?>
</p>

<?php $body = $article->getBody($currentLocale); ?>

<? if (empty($body)): ?>
    <? if ($currentLocale == 'fi'): ?>
        <? $body = $article->getBody('en'); ?>
<div class="alert-box">Valitettavasti artikkelista ei löydy suomenkielistä käännöstä<?php if ($article->getUseTranslator() === true): ?>, mutta ainahan voit avata sivun <a href="http://translate.google.com/translate?sl=en&tl=fi&ie=UTF-8&u=<?php echo urlencode($view['router']->generate($app->getRequest()->get('_route'), array('_locale'=> 'en'), true)) ?>">Google Translatorin</a> kautta<? endif ?>.</div>
    <? else: ?>
        <? $body = $article->getBody('fi'); ?>
<div class="alert-box">Unfortunately an English translation doesn't exist<?php if ($article->getUseTranslator() === true): ?> but you can probably get a clue from looking at the <a href="http://translate.google.com/translate?sl=fi&tl=en&ie=UTF-8&u=<?php echo urlencode($view['router']->generate($app->getRequest()->get('_route'), array('_locale'=> 'fi'), true)) ?>">Google Translator</a> version<? endif ?>.</div>
    <? endif ?>
<? endif ?>
<?php echo $body ?>

<h2 style="margin-bottom: 5px"><?php echo $view['translator']->trans('Arvioi lukemasi') ?></h2>

<div id="rating" data-rating="<?php echo $rating ?>">
    <div></div><div></div><div></div><div></div><div></div>
</div>
<div id='info'></div>
<div id="article_id" data-id="<?php echo $article->getId() ?>"></div>
<div id="locale" data-locale="<?php echo $currentLocale ?>"></div>

<div <?php echo empty($comments) ? 'style="display: none"' : '' ?>>
<h2><?php echo $view['translator']->trans('Kommentit') ?></h2>
<table class="wide" id="comments">
<thead>
<tr>
    <th><?php echo $view['translator']->trans('Kirjoittaja') ?></th>
    <th><?php echo $view['translator']->trans('Kommentti') ?></th>
</tr>
</thead>
<tbody>
<? foreach ($comments as $comment): ?>
<tr>
    <td style="width: 12%"><strong><?php echo $comment->getAuthorName() ?></strong><br /><small><?php echo $comment->getCreated()->format('Y-m-d H:i') ?></small></td>
    <td><?php echo(nl2br($view['helper']->convertUrlsToLinks(htmlspecialchars($comment->getBody())))) ?></td>
</tr>
<? endforeach ?>

</tbody>
</table>
</div>
<? //endif ?>

<h3><?php echo $view['translator']->trans('Kirjoita uusi kommentti') ?></h3>

<form id="articleComment" action="<?php echo $view['router']->generate('pulu_palsta_article_comment') ?>" method="post" <?php echo $view['form']->enctype($form) ?> >
    <?php $view['form']->setTheme($form, array('PuluPalstaBundle:Form')) ;?>
    <div class="row">
    <div class="six columns">
    <?php echo $view['form']->row($form['body']) ?>
    </div>
    <div class="six columns">
    <?php echo $view['form']->row($form['author_name']) ?>
    <?php echo $view['form']->row($form['safety_question']) ?>
    <?php echo $view['form']->rest($form) ?>
    <input type="hidden" name="article_id" value="<?php echo $article->getId() ?>" />
    <p><input class="button" type="submit" value="<?php echo $view['translator']->trans('Lähetä') ?>" /></p>
    </div>
    </div>
</form>

<?php $view['slots']->stop() ?>