<?php

    namespace App\Controller;

    use App\Entity\Category;
    use App\Form\CategoryType;
    use App\Repository\ProductRepository;
    use App\Repository\CategoryRepository; 
    use Doctrine\ORM\EntityManagerInterface; 
    use Doctrine\Persistence\ManagerRegistry;
    use Knp\Component\Pager\PaginatorInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class CategoryController extends AbstractController
    {
        #[Route('/categories', name: 'categories.index', methods: ['GET'])]
        public function index(
            CategoryRepository $repository,
            PaginatorInterface $paginator,
            Request $request
        ): Response {
            $categories = $paginator->paginate(
                $repository->findBy(['active' => 1]),
                $request->query->getInt('page', 1),
                10
            );
    
            return $this->render('pages/categories/index.html.twig', [
                'categories' => $categories
            ]);
        }

        #[Route('/categories/add', name: 'categories.add', methods: ['GET','POST'])]
        public function add(  
            Request $request,
            EntityManagerInterface $manager 
        ): Response {
            $category = new Category();
            $form = $this->createForm(CategoryType::class, $category);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $category = $form->getData();
                $manager->persist($category);
                $manager->flush();

                $this->addFlash(
                    'success',
                    '¡Categoría Guardada!'
                );

                return $this->redirectToRoute('categories.index');
            }

            return $this->render('pages/categories/add.html.twig', [
                'form' => $form->createView()
            ]);
        }

        #[Route('/categories/edit/{id}', name: 'categories.edit', methods: ['GET','POST'])]
        public function edit(  
            Category $category,
            Request $request,
            EntityManagerInterface $manager 
        ): Response {
            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $product = $form->getData();
    
                $manager->persist($product);
                $manager->flush();

                $this->addFlash(
                    'success',
                    '¡Categoría Actualizada!'
                );

                return $this->redirectToRoute('categories.index');
            }

            return $this->render('pages/categories/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }

        #[Route('/categories/delete/{id}', name: 'categories.delete', methods: ['GET'])]
        public function delete(  
            EntityManagerInterface $manager,
            Category $category,
            Request $request
        ): Response {
            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);
            $category = $form->getData();
            $category->active = 0;
            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'success',
                'Categoría Eliminada!'
            );

            return $this->redirectToRoute('categories.index');
        }
    }

?>