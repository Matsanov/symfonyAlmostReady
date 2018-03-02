<?php

namespace AppBundle\Controller;

use AppBundle\Service\ImageServiceInterface;
use AppBundle\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var ImageServiceInterface
     */
    private $imageService;

    /**
     * UserController constructor.
     * @param UserServiceInterface $userService
     * @param ImageServiceInterface $imageService
     */
    public function __construct(UserServiceInterface $userService, ImageServiceInterface $imageService)
    {
        $this->userService = $userService;
        $this->imageService = $imageService;
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function dashboard()
    {
        $lastFiveUsers = $this->userService->lastFiveUsers();
        $lastFiveImages = $this->imageService->lastFiveImages();

        return $this->render('admin/admin_dashboard.html.twig',['lastFiveUsers' => $lastFiveUsers, 'lastFiveImages' => $lastFiveImages]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/images", name="admin_all_images")
     */
    public function allImages(Request $request){

        $allImages = $this->imageService->allImages();

        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate($allImages,$request->query->getInt('page',1),$request->query->getInt('limit',10));

        return $this->render(':Admin:admin_all_pictures.html.twig',['allImages' => $result]);

    }
}
