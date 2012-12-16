<?php
namespace Pulu\PalstaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateArticleRatingCommand extends ContainerAwareCommand {

    protected function configure()     {
        $this->setName('pulupalsta:calculate-article-rating')->setDescription('Calculate article rating');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        // Get Articles
        $D = $this->getContainer()->get('doctrine');
        $em = $D->getManager();
        $articleRepository = $D->getRepository('PuluPalstaBundle:Article');
        $ratingRepository = $D->getRepository('PuluPalstaBundle:Rating');
        $articles = $articleRepository->findAllOrderedByName();
        foreach ($articles as $article) {
            // Calculate rating
            $articleRatingSum = 0;
            $articleRatingCount = 0;
            $ratingEntities = $ratingRepository->getArticleRatings($article);
            foreach ($ratingEntities as $ratingEntity) {
                $rating = $ratingEntity->getRating();
                if ($rating > 0 && $rating <= 5) {
                    $articleRatingCount++;
                    $articleRatingSum += $rating;
                }
            }
            if ($articleRatingCount > 0) {
                $articleRating = round(($articleRatingSum / $articleRatingCount), 2);
                $em->persist($article);
                $article->setRating($articleRating);
            }
        }
        $em->flush();
    }

}