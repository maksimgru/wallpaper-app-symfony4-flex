<?php

namespace App\Controller;

use App\Entity\Wallpaper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * Class GalleryController
 * @package App\Controller
 *
 */
class GalleryController extends Controller
{
    /**
     * @Route("/gallery", name="gallery")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        $images = $em->getRepository(Wallpaper::class)->findAllImagesOrderBySlug([
            'order' => 'ASC'
        ]);

        /*if (!$images) {
            throw $this->createNotFoundException(
                'No images found!!!'
            );
        }*/

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $images,
            $request->query->getInt('page', 1), // current page number
            6 // images per page
        );

        return $this->render('gallery/index.html.twig', [
            'images' => $pagination
        ]);
    }

    /**
     * @Route("/category/{cslug}", name="category", defaults={"cslug": ""})
     *
     * @param string $cslug
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response|RedirectResponse
     */
    public function categoryAction($cslug, Request $request, EntityManagerInterface $em)
    {
        $images = $em->getRepository(Wallpaper::class)->findImagesByCategorySlug([
            'cat_slug' => $cslug,
            'order' => 'ASC'
        ]);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $images,
            $request->query->getInt('page', 1), // current page number
            6 // images per page
        );

        return $this->render('gallery/category.html.twig', [
            'images' => $pagination,
            'cslug' => $cslug,
        ]);
    }

}