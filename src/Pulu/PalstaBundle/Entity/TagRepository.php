<?php
namespace Pulu\PalstaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository {

    protected static $language = 'fi';

    public function findAllOrderedByName() {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')->innerJoin('A.localizations', 'B')->where("B.language = '" . $lang . "'")->orderBy('B.name', 'ASC')->getQuery()->getResult();
    }

    public function setLanguage($lang = 'fi') {
        self::$language = $lang;
    }

    protected function getLanguage() {
        return self::$language;
    }

}
