<?php $view->extend('::base.html.php') ?>

<?php global $currentLocale ?>
<?php $currentLocale = $app->getRequest()->getLocale(); ?>

<?php $view['slots']->set('title', $article->getName($currentLocale) . ' - Palsta') ?>
<?php $view['slots']->set('description', strip_tags($article->getTeaser($currentLocale))) ?>
<?php $view['slots']->set('canonical', $view['router']->url('pulu_palsta_article_without_name', array('article_number' => $article->getArticleNumber(), '_locale' => $article->getLanguage()), false)) ?>

<?php $view['slots']->start('body') ?>

<?php if (! $article->getIsPublic()): ?>
    <div class="alert-box secondary" id="hidden-article">PIILOTETTU</div>
<?php endif ?>

<h1><?php echo $article->getName() ?></h1>

<div id="article-metadata">
<?php if ($article->getArticleNumber() !== 117): ?>
<strong>Language:</strong> <img style="height: 12px" class="flag" src="<?php echo $view['assets']->getUrl('bundles/pulupalsta/images/icons/' . $article->getLanguage() . '.svg') ?>" alt="" />
&nbsp;&nbsp;
<strong>Published:</strong> <?php echo $article->getPublished()->format('Y-m-d') ?>
&nbsp;&nbsp;
<strong>Modified:</strong> <?php echo $article->getModified()->format('Y-m-d') ?>
&nbsp;&nbsp;
<strong>Views:</strong> <?php echo $article->getVisits() ?>
&nbsp;&nbsp;
<strong>Category:</strong> <em><?php echo $article->getTypeName() ?></em>
<?php endif; ?>
<!--<?php if (! empty($article_keywords)): ?>
&nbsp;&nbsp;<strong>Keywords:</strong>
<?php $printKeywords = array(); ?>
<?php foreach ($article_keywords as $article_keyword): ?>
    <?php $articleObjects = $article_keyword->getArticles();
    $count = 0;
    foreach ($articleObjects as $articleObject) {
        if ($articleObject->getArticle()->isPublic()) {
            $count++;
        }
    } ?>
    <?php if ($count > 1): ?>
        <?php $printKeywords[] = '<a href="' . $view['router']->path('pulu_palsta_index') . '#' . $article_keyword->getName() . '"><em>' . $article_keyword->getName($currentLocale) . '</em></a>'; ?>
    <?php else: ?>
        <?php $printKeywords[] = '<em>' . $article_keyword->getName($currentLocale) . '</em>'; ?>
    <?php endif ?>
<?php endforeach ?>
<?php echo implode(', ', $printKeywords) ?>
<?php endif; ?>
-->
</div>

<?php $body = $article->getBody(); ?>
<?php $route_params = $app->getRequest()->get('_route_params'); ?>

<?php if (empty($body)): ?>
    <?php if ($currentLocale == 'fi'): ?>
        <?php $body = $article->getBody('en'); ?>
<div class="alert-box">Valitettavasti artikkelista ei löydy suomenkielistä käännöstä<?php if ($article->getUseTranslator() === true): ?>, mutta ainahan voit avata sivun <a href="http://translate.google.com/translate?sl=en&tl=fi&ie=UTF-8&u=<?php echo urlencode($view['router']->path($app->getRequest()->get('_route'), array_merge($route_params, array('_locale' => 'en')), true)) ?>">Google Translatorin</a> kautta<?php endif ?>.</div>
    <?php else: ?>
        <?php $body = $article->getBody('fi'); ?>
<div class="alert-box">Unfortunately no English translation exist<?php if ($article->getUseTranslator() === true): ?> but you can probably get a clue by looking at the <a href="http://translate.google.com/translate?sl=fi&tl=en&ie=UTF-8&u=<?php echo urlencode($view['router']->path($app->getRequest()->get('_route'), array_merge($route_params, array('_locale' => 'fi')), true)) ?>">Google Translator</a> version<?php endif ?>.</div>
    <?php endif ?>
<?php endif ?>

<?php
// Old Puluprojects functions

global $articleNumber, $mediaPathGlobal, $mediaUrlGlobal;
$articleNumber = $article->getArticleNumber();
$mediaPathGlobal = $mediaPath;
$mediaUrlGlobal = $mediaUrl;

/*function toFilename($string) {
    $conversion_array = array(
        'ä' => 'a', 'Ä' => 'A', 'Ö' => 'O', 'ö' => 'o', 'å' => 'a', 'Å' => 'A',
        'á' => 'a', 'Á' => 'a', 'ó' => 'o', 'Ó' => 'o', 'ñ' => 'n', 'Ñ' => 'N',
        'š' => 's', 'Š' => 's', '€' => 'e', 'ž' => 'z', 'Ž' => 'z'
        );

    $string = strtr($string, $conversion_array);
    $string = toWord(str_replace(' ', '-', $string));
    $string = preg_replace('/-{2,}/', '-', strtolower($string));
    $string = trim(str_replace('-', ' ', $string));
    $string = str_replace(' ', '-', $string);
    $string = urlencode($string);
    $string = preg_replace('/%../', '', urlencode($string));
    return $string;
}*/

/*function toWord($str) {
    static $bad = array(
        '\'', '"', '<', '>', '{', '}', '[', ']', '`', '!', '@', '#',
        '$', '%', '^', '&', '*', '(', ')', '=', '+', '|', '/', '\\',
        ';', ':', ',', '?', '/', ' '
    );
    return str_replace($bad, '', $str);
}*/

function htmlize($line, $linebreak = true) {
    $return = '&lt;' . $line . '&gt;';
    if ($linebreak) {
        $return .= "\n";
    }
    return $return;
}

function evalize($body, $article, $doctrine) {
    global $mediaUrl;

    $hash = md5($body);
    $dir = '/tmp/palsta-evalized-cache/';
    if (! file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    $file = $dir . 'evalized-palsta-article-' . $article->getId() . '-' . $hash;
    if (! file_exists($file)) {
        ob_start();
        eval('?' . '> ' . $body . ' <?php '); // start tag in two parts fixes the syntax highlighting in vim
        $evalizedBody = ob_get_contents();
        ob_end_clean();
        file_put_contents($file, $evalizedBody);
    }
    return file_get_contents($file);
}


function getImage($filename, $width = null, $height = null) {
    global $articleNumber;
    global $mediaPathGlobal;
    $dir = 'files/' . $articleNumber . '/img/';

    // return original
    if (empty($width) && empty($height)) {
        return $dir . $filename;
    }

    $basepath = $mediaPathGlobal . $dir;
    $dimensions = strval($width) . 'x' . strval($height);

    $fileparts = explode('.', $filename);
    $extension = array_pop($fileparts);
    $source = $basepath . $filename;
    $destination = $basepath . $dimensions . '/' . $filename;

    if (! file_exists($source)) {
        return false;
    }

    if (! file_exists($destination)) {
        if (! file_exists(dirname($destination))) {
            mkdir(dirname($destination), 0777, true);
        }

        if (strtolower($extension) == 'png') {
            $source_handle = imagecreatefrompng($source);
        } else if (strtolower($extension) == 'gif') {
            $source_handle = imagecreatefromgif($source);
        } else {
            $source_handle = imagecreatefromjpeg($source);
        }

        $source_width = imageSX($source_handle);
        $source_height = imageSY($source_handle);
        $source_ratio = $source_width / $source_height;

        if (! empty($width) && ! empty($height)) {                
            $destination_ratio = $width / $height;
            if ($source_ratio == $destination_ratio) {
                $destination_width = $width;
                $destination_height = $height;
            } else if ($source_ratio < $destination_ratio) {
                $destination_height = $height;
                $destination_width = round($height * $source_ratio);
            } else {
                $destination_width = $width;
                $destination_height = round($width / $source_ratio);
            }
        } else if (empty($width)) {
            $destination_height = $height;
            $destination_width = round($height * $source_ratio);
        } else if (empty($height)) {
            $destination_width = $width;
            $destination_height = round($width / $source_ratio);
        }
        $destination_width = max(1, $destination_width);
        $destination_height = max(1, $destination_height);
        $destination_handle = ImageCreateTrueColor($destination_width, $destination_height);
        imagecopyresampled($destination_handle, $source_handle, 0, 0, 0, 0, $destination_width, $destination_height, $source_width, $source_height);
        if (strtolower($extension) == 'png') {
            imagepng($destination_handle, $destination, 0);
        } else {
            imagejpeg($destination_handle, $destination, 90);
        }
        imagedestroy($destination_handle);
        imagedestroy($source_handle);
    }

    return $dir . $dimensions . '/' . $filename;
}

function displayImage($filename, $width = null, $height = null, $caption = "", $alt = "", $is_thumb = false, $thumb_identifier = null, $show_caption = true) {
    global $currentLocale;
    global $mediaUrlGlobal;

    $original_url = getImage($filename);
    $display_url = getImage($filename, $width, $height);
    $mediaPath = $mediaUrlGlobal;
    $hash = md5($original_url);
    $shortHash = substr($hash, 0, 6);

    if (empty($original_url) || empty($display_url)) {
        return '';
    }

    $captionText = strip_tags($caption);
    $originalText = $currentLocale == 'fi' ? 'originaali' : 'original';
    $captionWithExtra = '<span class="right">(<a target="_blank" href="' . $mediaPath . $original_url . '">' . $originalText . '</a>, <a href="#img-' . $shortHash . '">§</a>)</span> ' . $caption;

    $out = '<div class="centered imgContainer" id="img-' . $shortHash . '" style="';
    $dimensions = getimagesize($mediaPath . $display_url);
    $width = ! empty($dimensions[0]) ? $dimensions[0] : $width;
    if (! empty($width)) {
        $out .= 'width: ' . $width. 'px;';
    }
    if ($is_thumb) {
        $out .= 'margin: 0px 10px 10px 0px; display: inline-block;';
    }
    $rel = ! empty($thumb_identifier) ? 'fancybox-group-' . substr($thumb_identifier, 0, 10) : 'fancybox-main';
    $out .= '"><a href="' . $mediaPath . $original_url . '" rel="' . $rel . '" class="fancybox" title="' . $captionText . '" data-title-id="fancybox-title-' . $hash . '"><img';
    if ($is_thumb) {
        $out .= ' style="margin: 0px;"';
    }
    if (is_null($alt)) {
        $alt = mb_substr($desc, 40);
    }
    if (!empty($dimensions[0])) {
        $out .= ' width="' . $dimensions[0] . '" ';
    } else if (!empty($dimensions[1])) {
        $out .= ' height="' . $dimensions[1] . '" ';
    }
    $out .= ' class="js-lazy-image" data-src="' . $mediaPath . $display_url . '" alt="' . $alt . '" /></a>';
    if (! $is_thumb || $show_caption) {
        $out .= '<p>' . $caption . '</p>';
    }
    $out .= '</div>';
    
    // html supported caption
    $out .= '<div id="fancybox-title-' . $hash . '" style="display: none">' . $captionWithExtra . '</div>';

    return $out;
}

function displayThumbs($images = array(), $clear = true) {
    $out = '<div class="thumbsContainer">';
    $thumb_identifier = md5(serialize($images));
    foreach ($images as $image) {
        $param1 = isset($image[0]) ? $image[0] : '';
        $param2 = isset($image[1]) ? $image[1] : '';
        $param3 = isset($image[2]) ? $image[2] : '';
        $param4 = isset($image[3]) ? $image[3] : '';
        $param5 = isset($image[4]) ? $image[4] : '';
        $param6 = isset($image[5]) ? $image[5] : false;
        $out .= displayImage($param1, $param2, $param3, $param4, $param5, true, $thumb_identifier, $param6);
    }
    $out .= '</div>';
    if ($clear) {
        $out .= '<div style="clear: both"></div>';
    }
    return $out;
}

function createRecplay($id, $replays, $level, $caption = '', $options = array()) {
    $width = !empty($options['width']) ? $options['width'] : 480;
    $height = !empty($options['height']) ? $options['height'] : 360;
    $zoom = !empty($options['zoom']) ? $options['zoom'] : 0;
    $cssWidth = $width + 8; // because of 2px border and 2px margin
    $cssHeight = $height + 8;

    $title = '';
    if (count($replays) > 1) {
        foreach ($replays as $replay) {
            $text = !empty($replay['text']) ? $replay['text'] : $replay['file'];
            if (isset($replay['checked'])) {
                $checked = !empty($replay['checked']) ? 'checked' : '';
            } else {
                $checked = 'checked';
            }
            $title .= '<span class="replay"><input type="checkbox" ' . $checked . ' value="' . $replay['file'] . '">' . $text . '</span> ';
        }
    } else {
        $text = !empty($replays[0]['text']) ? $replays[0]['text'] : $replays[0]['file'];
        $title .= $text . '<input type="hidden" value="' . $replays[0]['file'] . '">';
    }
    
    $levelFilename = is_integer($level) ? 'qwquu' . str_pad($level, 3, '0', STR_PAD_LEFT) . '.lev' : $level;

    $out = '';
    $out .= '<div class="recplay" id="' . $id . '" data-level="' . $levelFilename . '" data-width="' . $width . '" data-height="' . $height . '" data-zoom="' . $zoom . '">';
    $out .= '<div class="centered imgContainer" style="width: ' . $cssWidth . 'px;">';
    $out .= '<p class="header"><span class="title">' . $title . '</span></p>';
    $out .= '<div class="placeholder" style="height: ' . $cssHeight . 'px; width: ' . $cssWidth . 'px"><div class="toggle" style="width: ' . ($width) . 'px; height: ' . ($height - 14) . 'px; top: 14px; position: absolute;"></div></div>';
    $out .= '<p>' . $caption . '</p>';
    $out .= '</div></div>';
    
    return $out;
}
?>

<?php
    echo evalize($body, $article, $doctrine);
?>

<div id='info'></div>
<div id="article_id" data-id="<?php echo $article->getId() ?>"></div>
<div id="locale" data-locale="<?php echo $currentLocale ?>"></div>

<?php if ($article->getIsCommentable()): ?>
<?php $Parsedown = new Parsedown(); ?>

<a name="kommentointi"></a>
<div <?php echo empty($comments) ? 'style="display: none"' : '' ?> id="comments-container">
<h2>Comments</h2>
<table class="wide" id="comments">
<thead>
<tr>
    <th>Author</th>
    <th>Comment</th>
</tr>
</thead>
<tbody>
<?php foreach ($comments as $comment): ?>
<tr>
    <td style="width: 12%"><strong style="display: block"><?php echo $comment->getAuthorName() ?></strong><small><?php echo $comment->getCreated()->format('Y-m-d H:i') ?></small><?php if ($comment->isProtected()): ?><br><small>PROTECTED</small><?php endif; ?></td>
    <td><?php echo($Parsedown->text($comment->getBody())) ?></td>
</tr>
<?php endforeach ?>

</tbody>
</table>
</div>

<hr>
<form id="articleComment" action="<?php echo $view['router']->path('pulu_palsta_article_comment') ?>" method="post">
    <?php $view['form']->setTheme($form, array('PuluPalstaBundle:Form')) ;?>
    <div class="row">
    <div class="six columns">
    <?php echo $view['form']->row($form['body']) ?>
    </div>
    <div class="six columns">
        <div class="row">
            <div class="six columns">
                <?php echo $view['form']->row($form['author_name']) ?>
            </div>
            <div class="six columns">
                <?php echo $view['form']->row($form['author_key']) ?>
            </div>
        </div>
        <?php echo $view['form']->row($form['safety_question']) ?>
        <?php echo $view['form']->rest($form) ?>
        <input type="hidden" name="article_id" value="<?php echo $article->getId() ?>" />
        <p><input class="button" type="submit" value="Submit" /></p>
    </div>
    </div>
</form>
<?php endif; ?>

<?php $view['slots']->stop() ?>
