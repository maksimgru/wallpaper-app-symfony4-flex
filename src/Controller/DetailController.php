<?php

namespace App\Controller;

use App\Entity\Wallpaper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DetailController
 * @package App\Controller
 *
 */
class DetailController extends Controller
{
    /**
     * @Route("/view/{slug}", name="view")
     *
     * @param string $slug
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function indexAction($slug='', EntityManagerInterface $em)
    {
        $image = $em->getRepository(Wallpaper::class)->findOneImageBy([
            'slug' => $slug
        ]);

        /*if (!$image) {
            throw $this->createNotFoundException(
                'No images found for slug = ' . $slug
            );
        }*/

        return $this->render('detail/index.html.twig', [
            'image' => $image
        ]);
    }

}