<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n"; ?>
<rss version="2.0">
<channel>
    <title><?php echo $view['translator']->trans('Pulupalstan kommentit') ?></title>
    <description><?php echo $view['translator']->trans('Pulupalstan uusimmat kommentit') ?></description>
    <link>http://palsta.pulu.org</link>
    <lastBuildDate><?php echo date('D, d M Y H:i:s T'); ?></lastBuildDate>
    <pubDate><?php echo date('D, d M Y H:i:s T'); ?></pubDate>

<?php foreach ($recentComments as $comment): ?>
    <item>
        <title><?php echo $comment->getAuthorName() ?> (<?php echo $comment->getArticle()->getName($locale) ?>)</title>
        <description><?php echo $comment->getBody($locale) ?></description>
        <link><?php echo $view['router']->path('pulu_palsta_article', array('article_number' => $comment->getArticle()->getArticleNumber(), 'name' => $view['helper']->toFilename($comment->getArticle()->getName($locale))), true) ?></link>
        <author><?php echo $comment->getAuthorName() ?></author>
        <category><?php echo $comment->getArticle()->getName($locale) ?></category>
        <guid><?php echo $comment->getId() ?></guid>
        <pubDate><?php echo $comment->getCreated()->format('D, d M Y H:i:s T') ?></pubDate>
    </item>
<?php endforeach ?>

</channel>
</rss>
