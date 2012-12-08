<?php
namespace Pulu\PalstaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class KeywordRepository extends EntityRepository {

    protected static $language = 'fi';

    public function findAllOrderedByName() {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')->innerJoin('A.localizations', 'B')->where("B.language = '" . $lang . "'")->orderBy('B.name', 'ASC')->getQuery()->getResult();
    }

    public function findByArticleOrderedByWeight(Article $article) {
        $lang = $this->getLanguage();
        $article_id = $article->getId();
        return $this->createQueryBuilder('A')->innerJoin('A.articles', 'B')->where("B.article = " . $article_id)->orderBy('B.weight', 'DESC')->getQuery()->getResult();
    }

    public function setLanguage($lang = 'fi') {
        self::$language = $lang;
    }

    protected function getLanguage() {
        return self::$language;
    }

}
