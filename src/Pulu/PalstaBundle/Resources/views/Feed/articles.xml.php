<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n"; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
    <title>Pulupalsta Articles</title>
    <description>A human being is writing texts</description>
    <link>https://palsta.pulu.org</link>
    <atom:link href="https://palsta.pulu.org/en/feed/articles" rel="self" type="application/rss+xml" />
    <lastBuildDate><?php echo date('D, d M Y H:i:s O'); ?></lastBuildDate>
    <pubDate><?php echo date('D, d M Y H:i:s O'); ?></pubDate>

<?php foreach ($articles as $article): ?>
    <item>
        <title><?php echo $article->getName() ?> (#<?php echo $article->getArticleNumber() ?>)</title>
        <link>https:<?php echo $view['router']->url('pulu_palsta_article', array('_locale' => $article->getLanguage(), 'article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName())), true) ?></link>
        <guid>https:<?php echo $view['router']->url('pulu_palsta_article', array('_locale' => $article->getLanguage(), 'article_number' => $article->getArticleNumber(), 'name' => $view['helper']->toFilename($article->getName())), true) ?></guid>
        <pubDate><?php echo $article->getPublished()->format('D, d M Y H:i:s O') ?></pubDate>
    </item>
<?php endforeach ?>

</channel>
</rss>
