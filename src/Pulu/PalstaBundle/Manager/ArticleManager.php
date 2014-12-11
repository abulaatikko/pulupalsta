<?php 
namespace Pulu\PalstaBundle\Manager;

use Doctrine\ORM\EntityManager;
use \Pulu\PalstaBundle\Entity\Article;
use \Pulu\PalstaBundle\Entity\ArticleRevision;

class ArticleManager {

    protected $article;
    protected $entityManager;

    public function __construct(Article $article) {
        $this->article = $article;
    }

    protected function getArticle() {
        return $this->article;
    }

    public function setEntityManager(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    protected function getEntityManager() {
        return $this->entityManager;
    }

    public function saveRevision() {
        $article = $this->getArticle();

        $translations = $article->getLocalizations();
        foreach ($translations as $translation) {
            $lang = $translation->getLanguage();
            $previousArticleRevision = $article->getPreviousRevision($lang);
            $previousRevision = $previousArticleRevision->getRevision();            
            $articleRevision = clone $previousArticleRevision;

            $previousName = $this->getNameByRevision($lang, $previousRevision);
            $previousTeaser = $this->getTeaserByRevision($lang, $previousRevision);
            $previousBody = $this->getBodyByRevision($lang, $previousRevision);
            $currentName = $article->getName($lang);
            $currentTeaser = $article->getTeaser($lang);
            $currentBody = $article->getBody($lang);

            $work = array(
                'name' => array(
                    'previous' => $previousName,
                    'current' => $currentName,
                    'method' => 'setName'
                ),
                'teaser' => array(
                    'previous' => $previousTeaser,
                    'current' => $currentTeaser,
                    'method' => 'setTeaser'
                ),
                'body' => array(
                    'previous' => $previousBody,
                    'current' => $currentBody,
                    'method' => 'setBody'
                )
            );

            $noDiff = 0;
            foreach ($work as $type => $item) {
                $previousFile = '/tmp/PuluPalstaArticleRevisionPrevious.diff';
                $currentFile = '/tmp/PuluPalstaArticleRevisionCurrent.diff';
                $diffFile = '/tmp/PuluPalstaArticleRevisionDiff.diff';
                file_put_contents($previousFile, $item['previous']);
                file_put_contents($currentFile, $item['current']);
                file_put_contents($diffFile, '');
                exec('diff -u ' . $previousFile . ' ' . $currentFile . ' > ' . $diffFile);
                $method = $item['method'];
                $cnt = file_get_contents($diffFile);
                if (empty($cnt)) {
                    $noDiff++;
                }
                $articleRevision->$method($cnt);
                unlink($previousFile);
                unlink($currentFile);
                unlink($diffFile);
            }
            if ($noDiff == 3) {
                continue;
            }

            $articleRevision->setRevision($previousRevision + 1);
            $articleRevision->setCreated(new \DateTime('now'));

            $em = $this->getEntityManager();
            $em->persist($articleRevision);
            $em->flush();
        }
        
    }

    protected function getPreviousArticleRevision() {
        $repository = $this->getEntityManager()->getRepository('PuluPalstaBundle:Article');
        $repository->setArticle($this->getArticle());
        return $repository->findPreviousArticleRevision();
    }

    protected function getNameByRevision($lang, $revision) {
        return $this->getPropertyByRevision('getName', $lang, $revision);
    }

    protected function getTeaserByRevision($lang, $revision) {
        return $this->getPropertyByRevision('getTeaser', $lang, $revision);
    }

    protected function getBodyByRevision($lang, $revision) {
        return $this->getPropertyByRevision('getBody', $lang, $revision);
    }

    public function getPropertyByRevision($method, $lang, $revision) {

// whats the newest revision in cache
$newestRevisionCached = 0;
$newestRevisionData = '';
for ($i = $revision; $i > 0; $i--) {
// add article id
    $filename = $this->getArticle()->getId() . '-' . $method . '-' . $lang . '-' . $i . '.cache';
    $path = '/tmp/' . $filename;
    if (file_exists($path)) {
        if ($i == $revision) {
            return file_get_contents($path);
        }
        $newestRevisionCached = $i;
        $newestRevisionData = file_get_contents($path);
        break;
    }
    

}
        $returnFile = '/tmp/PuluPalstaArticleRevisionReturn.diff';        
        $tempFile = '/tmp/PuluPalstaArticleRevisionTemp.diff';
        file_put_contents($returnFile, '');
        file_put_contents($tempFile, '');
//die(var_dump($newestRevisionCached));

        $iterator = $this->getRevisionsByRevision();
        foreach ($iterator as $item) {
            $itemRevision = $item->getRevision();
            if ($item->getLanguage() != $lang) {
                continue;
            }
            if ($itemRevision > $revision) {
                continue;
            }
            if (! empty($newestRevisionCached)) {
                if ($itemRevision < $newestRevisionCached) {
                    continue;
                } else if ($itemRevision == $newestRevisionCached) {
//die(var_dump($itemRevision, $revision, $newestRevisionCached));
                    file_put_contents($returnFile, $newestRevisionData);
                    continue;
                } else {
                    // go through
                }
            }
            file_put_contents($tempFile, $item->$method());
            exec('patch ' . $returnFile . ' < ' . $tempFile);
if ($method == 'getBody' && $lang == 'fi') {
ob_start();var_dump(file_get_contents($returnFile));$s=ob_get_clean();file_put_contents('/tmp/jotain.log', $s, FILE_APPEND);
}
//if ($itemRevision == 5) {die(var_dump(file_get_contents($returnFile), $itemRevision));}
            copy($returnFile, '/tmp/' . $this->getArticle()->getId() . '-' . $method . '-' . $lang . '-' . $itemRevision . '.cache');
        }

        $return = file_get_contents($returnFile);
        unlink($returnFile);
        unlink($tempFile);

        return $return;
    }

    public function getRevisionsByRevision($order = 'asc') {
        $revisions = $this->getArticle()->getRevisions();
        $iterator = $revisions->getIterator();

        if ($order == 'asc') {
            $iterator->uasort(function($a, $b) {
                if ($a->getRevision() < $b->getRevision()) {
                    return -1;
                } elseif ($a->getRevision() > $b->getRevision()) {
                    return 1;
                }
                return 0;
            });
        } else {
            $iterator->uasort(function($a, $b) {
                if ($a->getRevision() < $b->getRevision()) {
                    return 1;
                } elseif ($a->getRevision() > $b->getRevision()) {
                    return -1;
                }
                return 0;
            });
        }

        return $iterator;
    }

}
