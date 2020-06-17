<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n"; ?>
<rss version="2.0">
<channel>
    <title>Palsta Articles</title>
    <description>Palsta Recent Articles</description>
    <link>https://palsta.pulu.org</link>
    <lastBuildDate><?php echo date('D, d M Y H:i:s T'); ?></lastBuildDate>
    <pubDate><?php echo date('D, d M Y H:i:s T'); ?></pubDate>

<?php foreach ($recentArticles as $article): ?>
    <item>
        <title><?php echo $article->getName($locale) ?> (#<?php echo $article->getArticleNumber() ?>)</title>
        <description><?php echo $article->getTeaser($locale) ?></description>
        <link>https:<?php echo $view['router']->url('pulu_palsta_article', array('article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName($locale))), true) ?></link>
        <guid><?php echo $article->getArticleNumber() ?></guid>
        <pubDate><?php echo $article->getPublished()->format('D, d M Y H:i:s T') ?></pubDate>
    </item>
<?php endforeach ?>

</channel>
</rss>
