<?php
namespace Pulu\PalstaBundle\Entity;

use Pulu\PalstaBundle\Entity\Tag;

class TagLocalization {

    protected $tag;
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

    public function setTag(Tag $tag) {
        $this->tag = $tag;    
        return $this;
    }

    public function getTag() {
        return $this->tag;
    }

}