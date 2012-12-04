<?php
namespace Pulu\PalstaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Pulu\PalstaBundle\Entity\ArticleRepository;

class PublicArticleRepository extends ArticleRepository {

    protected static $language = 'fi';

    public function findAllOrderedByName() {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')->innerJoin('A.localizations', 'B')->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = '" . $lang . "'")->orderBy('B.name', 'ASC')->getQuery()->getResult();
    }

    public function findOrderedByCreated($max = '10') {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = '" . $lang . "'")
            ->orderBy('A.created', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByPoint($max = 10) {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = '" . $lang . "'")
            ->orderBy('A.points', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function setLanguage($lang = 'fi') {
        self::$language = $lang;
    }

    protected function getLanguage() {
        return self::$language;
    }

}