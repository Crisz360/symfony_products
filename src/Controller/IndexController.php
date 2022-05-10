<?php

    namespace App\Controller;

    
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    
    class IndexController extends AbstractController
    {

        #[Route('/index', name: 'index.index', methods: ['GET'])]
        public function index(): Response {
            return $this->render('pages/index/index.html.twig');
        }
    }

?>