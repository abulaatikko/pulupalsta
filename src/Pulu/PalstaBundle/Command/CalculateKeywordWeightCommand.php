<?php
namespace Pulu\PalstaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateKeywordWeightCommand extends ContainerAwareCommand {

    protected function configure()     {
        $this->setName('pulupalsta:calculate-keyword-weight')->setDescription('Calculate keyword weight');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        // Get Keywords
        $D = $this->getContainer()->get('doctrine');
        $em = $D->getManager();
        $keywordRepository = $D->getRepository('PuluPalstaBundle:Keyword');
        $keywords = $keywordRepository->findAllOrderedByName();
        foreach ($keywords as $keyword) {
            // Calculate weight
            $keywordWeight = 0;
            $keywordArticles = $keyword->getArticles();
            foreach ($keywordArticles as $keywordArticle) {
                $article = $keywordArticle->getArticle();
                if (! $article->getIsPublic()) {
                    continue;
                }
                $visits = $article->getVisits();
                $rating = $article->getRating();
                $weight = $keywordArticle->getWeight();
                $keywordWeight += $weight * $rating * pow($visits, 0.7);
            }
            $em->persist($keyword);
            $keyword->setWeight($keywordWeight);
        }
        $em->flush();
    }

}
