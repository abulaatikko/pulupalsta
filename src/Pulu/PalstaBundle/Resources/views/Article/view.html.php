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

<style type="text/css">
/* Old Puluprojects settings */
ul          {list-style: square; margin: 5px 0px 0px 30px}

#table_of_contents ul {margin-left: 20px;}

.wide                   {width: 100%;}
.centered               {text-align: center;}
.left               {text-align: left;}
.u                      {text-decoration: underline;}
.clear          {clear: both;}
.tight                  {margin: 0px}
.font1                  {font-size: 80%}
.overlined      {text-decoration: line-through;}
.negative       {color: red;}
.ready, .positive   {color: green;}

.left img       {float: left; margin-right: 10px;}
div.imgContainer    {margin: 0 auto 20px auto;}
.imgContainer img,
.imgContainer iframe    {border: 2px solid #285EAE; padding: 2px; margin: 0 auto;}
.imgContainer p     {text-align: left; font-size: 80%; margin-top: 0}

#table_of_contents  {float: right; margin: 30px 0px 5px 5px;}

.code                   {margin-left: 15px; margin-right: 15px; padding: 4px; background-color: #F5EFF5; border: 1px solid #E2B2E4; font-family: 'courier new';}

table.norm {
        border: 2px solid #CC8ACE;
        background-color: #F5EFF5;
        margin: 0px 0 5px 0;
        font-size: 12px;
        border-spacing: 0px;}

table.norm td {
        padding: 3px;
        border-right: 1px solid #CC8ACE;
        border-bottom: 1px solid #CC8ACE;
        border-left: none;
        border-top: none;
        vertical-align: top;}

table.norm th {
        padding: 3px; 
        background-color: #E2B2E4;
        border-bottom: 1px solid #CC8ACE;
        border-right: 1px solid #CC8ACE;
        border-left: none; 
        border-top: none;
        text-align: left;}                                /* opera didnt align correctly */

.tfoot {
        border-top: 2px solid #000;
        font-weight: bold;}
</style>

<?php
// Old Puluprojects functions

global $id;
$id = $article->getArticleNumber();

function toFilename($string) {
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
}

function toWord($str) {
        static $bad = array(
                '\'', '"', '<', '>', '{', '}', '[', ']', '`', '!', '@', '#',
                '$', '%', '^', '&', '*', '(', ')', '=', '+', '|', '/', '\\',
                ';', ':', ',', '?', '/', ' '
        );
        return str_replace($bad, '', $str);
}

/* funktio tulostaa nimen ja siihen ig-linkin, jos sellainen löytyy
 * $nick käytä aina samaa, käyttäjän identifiointi
 * $word sana joka tulostetaan sivulle
 * $ig=1 jos halutaan irc-galleria linkki
 * esim: nick("px","pxlle",1);
 */
function nick($nick, $word, $ig=0) {
    
    switch($nick) {
        case "px":  $tmp = "px";        break;
        case "Abula":   $tmp = "Abula";     break;
        case "mr":  $tmp = "mr_fm";     break;
        case "mane":    $tmp = "Rrrage";    break;
        case "papu":    $tmp = "epätero";   break;
        case "Emo":     $tmp = false;       break;
        case "psy": $tmp = "psy^";      break;
        case "vender":  $tmp = "vender";    break;
        case "Stypid":  $tmp = "Stypid";    break;
        case "Malys":   $tmp = "Malys";     break;
        case "Kalle":   $tmp = "Kaaloppi";  break;
        case "Nina":    $tmp = "Ninneli";   break;
        case "Henga":   $tmp = "Henzhu";    break;
        case "Tuska":   $tmp = "Tuska";     break;
        case "Wikke":   $tmp = "_Wikke";    break;
        case "unskilo": $tmp = "unskilo";   break;
        case "Adamanta":$tmp = "Adamanta";  break;
        case "Safiira": $tmp = "Safiira";   break;
        case "Karlis":  $tmp = "Karlis";    break;
        case "Lappen":  $tmp = "Lappen";    break;
        case "tp8": $tmp = "tp8";       break;
        case "Shantar": $tmp = "Shantar";   break;
        case "emps":    $tmp = "emps";      break;
        case "Orcc":    $tmp = "Orcc";      break;
        case "Ismo":    $tmp = "Ismo-";     break;
        case "kimitys": $tmp = "kimitys";   break;
        case "skint0r": $tmp = "skint0r";   break;
        default:    $tmp = false;
    }

    if($tmp != false && $ig != 0) {
        print("<a href=\"http://irc-galleria.net/view.php?nick=".$tmp."\">");
    }

    print $word;

    if($tmp != false && $ig != 0) {
        print("</a>");
    }
}

function getImage($filename, $width = null, $height = null) {
        global $id;
        $dir = 'files/' . $id . '/img/';

        // return original
        if (empty($width) && empty($height)) {
                return $dir . $filename;
        }

        $basepath = '/home/abula/media.pulu.org/palsta/' . $dir;
        $dimensions = strval($width) . 'x' . strval($height);

        $source = $basepath . $filename;
        $destination = $basepath . $dimensions . '/' . $filename;

        if (! file_exists($destination)) {
                if (! file_exists(dirname($destination))) {
                        mkdir(dirname($destination), 0777, true);
                }

                $source_handle = imagecreatefromjpeg($source);

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
                imagejpeg($destination_handle, $destination, 90);
                imagedestroy($destination_handle);
                imagedestroy($source_handle);
        }
        return $dir . $dimensions . '/' . $filename;
}

function displayImage($filename, $width = null, $height = null, $caption = "", $alt = "", $is_thumb = false) {
    $original_url = getImage($filename);
    $display_url = getImage($filename, $width, $height);
    $out = '<div class="centered imgContainer" style="';
    if (! empty($width)) {
    $out .= 'width: ' . ($width + 8). 'px;';
    }
    if ($is_thumb) {
    $out .= 'float: left; margin: 0px 10px 10px 0px;';
    }
    $out .= '"><a href="http://media.pulu.org/palsta/' . $original_url . '" rel="gallery" class="fancybox" title="' . $caption . '"><img';
    if ($is_thumb) {
    $out .= ' style="margin: 0px;"';
    }
    if (is_null($alt)) {
    $alt = mb_substr($desc, 40);
    }
    $out .= ' src="http://media.pulu.org/palsta/' . $display_url . '" alt="' . $alt . '" /></a>';
    if (! $is_thumb) {
    $out .= '<p>' . $caption . '</p>';
    }
    $out .= '</div>';
    return $out;
}

function displayThumbs($images = array()) {
    $out = '<div class="thumbsContainer">';
    foreach ($images as $image) {
    $param1 = isset($image[0]) ? $image[0] : '';
    $param2 = isset($image[1]) ? $image[1] : '';
    $param3 = isset($image[2]) ? $image[2] : '';
    $param4 = isset($image[3]) ? $image[3] : '';
    $param5 = isset($image[4]) ? $image[4] : '';
    $out .= displayImage($param1, $param2, $param3, $param4, $param5, true);
    }
    $out .= '</div><div style="clear: both"></div>';
    return $out;
}
?>


<? eval('?>' . $body . '<?php '); ?>

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