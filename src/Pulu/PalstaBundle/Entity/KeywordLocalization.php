<?php
namespace Pulu\PalstaBundle\Entity;

use Pulu\PalstaBundle\Entity\Keyword;

class KeywordLocalization {

    protected $keyword;
    protected $language = 'fi';
    protected $name;

    public function setLanguage($language) {
        $this->language = $language;
        return $this;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setKeyword(Keyword $keyword) {
        $this->keyword = $keyword;    
        return $this;
    }

    public function getKeyword() {
        return $this->keyword;
    }

}