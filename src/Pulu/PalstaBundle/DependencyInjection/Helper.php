<?php
namespace Pulu\PalstaBundle\DependencyInjection;
use Symfony\Component\Templating\Helper\Helper as BaseHelper;

class Helper extends BaseHelper {

    #http://stackoverflow.com/questions/8791715/symfony2-global-variables-in-php-templating-engine
    protected $name = 'Helper';

    public function toFilename($string) {
        $string = str_replace(' ', '-', $string);
        $bad = array(
            '\'', '"', '<', '>', '{', '}', '[', ']', '`', '!', '@', '#',
            '$', '%', '^', '&', '*', '(', ')', '=', '+', '|', '/', '\\',
            ';', ':', ',', '?', '/', ' '
        );
        $string = str_replace($bad, '', $string);        
        $string = preg_replace('/-{2,}/', '-', strtolower($string));
        $string = trim(str_replace('-', ' ', $string));
        $string = str_replace(' ', '-', $string);
        $string = urlencode($string);
        $string = preg_replace('/%../', '', urlencode($string));
        return $string;
    }



    public function getName(){
        return $this->name;
    }


}
