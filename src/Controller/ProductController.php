<?php

    namespace App\Controller;

    use App\Entity\Product;
    use App\Form\ProductType;
    use App\Repository\ProductRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Doctrine\Persistence\ManagerRegistry;
    use Knp\Component\Pager\PaginatorInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    
    class ProductController extends AbstractController
    {
        #[Route('/products', name: 'products.index', methods: ['GET'])]
        public function index(
            ProductRepository $repository,
            PaginatorInterface $paginator,
            Request $request
        ): Response {
            $products = $paginator->paginate(
                $repository->findAll(),
                $request->query->getInt('page', 1),
                10
            );
    
            return $this->render('pages/products/index.html.twig', [
                'products' => $products
            ]);
        }

        #[Route('/products/add', name: 'products.add', methods: ['GET','POST'])]
        public function add(  
            Request $request,
            EntityManagerInterface $manager 
        ): Response {
            $product = new Product();
            $form = $this->createForm(ProductType::class, $product);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $product = $form->getData();
                $manager->persist($product);
                $manager->flush();

                $this->addFlash(
                    'success',
                    '¡Producto Guardado!'
                );

                return $this->redirectToRoute('products.index');
            }

            return $this->render('pages/products/add.html.twig', [
                'form' => $form->createView()
            ]);
        }

        #[Route('/products/edit/{id}', name: 'products.edit', methods: ['GET','POST'])]
        public function edit(  
            Product $product,
            Request $request,
            EntityManagerInterface $manager 
        ): Response {
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $product = $form->getData();
    
                $manager->persist($product  );
                $manager->flush();

                $this->addFlash(
                    'success',
                    '¡Producto Actualizado!'
                );

                return $this->redirectToRoute('products.index');
            }

            return $this->render('pages/products/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }

        #[Route('/products/delete/{id}', name: 'products.delete', methods: ['GET'])]
        public function delete(  
            EntityManagerInterface $manager,
            Product $product
        ): Response {
            $manager->remove($product);
            $manager->flush();

            $this->addFlash(
                'success',
                'Producto Eliminado!'
            );

            return $this->redirectToRoute('products.index');
        }
    }

?>