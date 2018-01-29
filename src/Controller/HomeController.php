<?php

namespace App\Controller;

use App\Entity\Wallpaper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        $latestImages = $em->getRepository(Wallpaper::class)->findLatestImages([
            'number' => 2
        ]);

        $randomisedImages = $em->getRepository(Wallpaper::class)->findRandomImages([
            'number' => 8
        ]);

        return $this->render('home/index.html.twig', [
            'request'           => $request,
            'randomised_images' => $randomisedImages,
            'latest_images'          => $latestImages,
        ]);
    }

}
