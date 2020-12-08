<?php
namespace Pulu\PalstaBundle\Entity;

use Pulu\PalstaBundle\Entity\Article;
use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository {

	protected $language = 'fi';
    protected $article;

    public function setLanguage($lang = 'fi') {
        $this->language = $lang;
        return $this;
    }

    protected function getLanguage() {
        return $this->language;
    }

    public function setArticle(Article $article) {
        $this->article = $article;
        return $this;
    }

    protected function getArticle() {
        return $this->article;
    }

    public function findAllOrderedByName() {
    	$lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.deleted IS NULL AND B.language = :language")
            ->setParameter("language", $lang)
            ->orderBy('B.name', 'ASC')
            ->getQuery()->getResult();
    }

    public function findAllOrderedByNameForPublic() {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = :language")
            ->setParameter("language", $lang)
            ->orderBy('B.name', 'ASC')
            ->getQuery()->getResult();
    }

    public function findNextArticleNumber() {
        return (int) $this->createQueryBuilder('A')
            ->select('MAX(A.article_number)')
            ->getQuery()->getSingleScalarResult() + 1;
    }

    public function findOrderedByPublished($max = '10') {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.deleted IS NULL AND B.language = :language")
            ->setParameter("language", $lang)
            ->orderBy('A.published', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByPublishedForPublic($max = '10') {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = :language")
            ->setParameter("language", $lang)
            ->orderBy('A.published', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findArticlesForFeed($max = '10') {
        $dateTimeMin = new \DateTime('2006-01-01');
        $dateTimeMax = new \DateTime();
        $dateTimeMax->modify('-1 week');

        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = A.language AND A.published BETWEEN :dateMin AND :dateMax")
            ->setParameter("dateMin", $dateTimeMin->format('Y-m-d 00:00:00'))
            ->setParameter("dateMax", $dateTimeMax->format('Y-m-d 23:59:59'))
            ->orderBy('A.published', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByRating($max = 10) {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.deleted IS NULL AND B.language = :language AND A.rating IS NOT NULL")
            ->setParameter("language", $lang)
            ->orderBy('A.rating', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByRatingForPublic($max = 10) {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = :language AND A.rating IS NOT NULL")
            ->setParameter("language", $lang)
            ->orderBy('A.rating', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByVisitsForPublic($max = 10, $keyword_id = null) {
        $lang = $this->getLanguage();
        $builder = $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B');
        if (! empty($keyword_id)) {
            $builder->innerJoin('A.keywords', 'C');
        }
        $where = "A.is_public = TRUE AND A.deleted IS NULL AND B.language = :language AND A.visits IS NOT NULL";
        if (! empty($keyword_id)) {
            $where .= " AND C.keyword = :keyword_id";
        }
        $builder
            ->where($where)
            ->setParameter("language", $lang);
        if (! empty($keyword_id)) {
            $builder->setParameter("keyword_id", $keyword_id);
        }
        $query = $builder
            ->orderBy('A.visits', 'DESC')
            ->setMaxResults($max)
            ->getQuery();
        return $query->getResult();
    }

    public function findOrderedByAverageMonthlyVisitsForPublic($max = 10, $keyword_id = null) {
        $lang = $this->getLanguage();
        $builder = $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B');
        if (! empty($keyword_id)) {
            $builder->innerJoin('A.keywords', 'C');
        }
        $where = "A.is_public = TRUE AND A.deleted IS NULL AND B.language = :language AND A.average_monthly_visits IS NOT NULL";
        if (! empty($keyword_id)) {
            $where .= " AND C.keyword = :keyword_id";
        }
        $builder
            ->where($where)
            ->setParameter("language", $lang);
        if (! empty($keyword_id)) {
            $builder->setParameter("keyword_id", $keyword_id);
        }
        $query = $builder
            ->orderBy('A.average_monthly_visits', 'DESC')
            ->setMaxResults($max)
            ->getQuery();
        return $query->getResult();
    }

    public function findPreviousArticleRevision() {
        $article = $this->getArticle();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.revisions', 'B')
            ->where('B.article = :article')
            ->setParameter('article', $article->getId())
            ->orderBy('B.revision', 'DESC')
            ->setMaxResults(1)
            ->getQuery()->getSingleResult();
    }

    public function findExplorationsOrderedByPublishedForPublic() {
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND A.type = :type AND B.language = :language")
            ->setParameter("type", Article::TYPE_EXPLORATION)
            ->setParameter("language", $this->getLanguage())
            ->orderBy('A.published', 'DESC')
            ->getQuery()->getResult();
    }

    public function findResearchesOrderedByPublishedForPublic() {
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND A.type = :type")
            ->setParameter("type", Article::TYPE_RESEARCH)
            ->orderBy('A.published', 'DESC')
            ->getQuery()->getResult();
    }

    public function findOpinionsOrderedByPublishedForPublic() {
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND A.type = :type")
            ->setParameter("type", Article::TYPE_OPINION)
            ->orderBy('A.published', 'DESC')
            ->getQuery()->getResult();
    }

    public function findMiscsOrderedByPublishedForPublic() {
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND A.type = :type")
            ->setParameter("type", Article::TYPE_MISC)
            ->orderBy('A.published', 'DESC')
            ->getQuery()->getResult();
    }

    public function findTrainingsOrderedByPublishedForPublic() {
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND A.type = :type")
            ->setParameter("type", Article::TYPE_TRAINING)
            ->orderBy('A.published', 'DESC')
            ->getQuery()->getResult();
    }

}
