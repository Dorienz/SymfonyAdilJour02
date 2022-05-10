<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }


    /**
     * @Route("/products", name="products_All")
     */
    public function index(ProductRepository $productsRepository): Response
    {
        $products = $productsRepository->findAll();
        return $this->render('products/products.html.twig', [
            'products' => $products
        ]);
    }

     /**
     * @Route("/products/new", name="product_new")
     */
    public function productNew(Request $request, EntityManagerInterface $entityManager): Response
    {

        $product = new Product();

        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('products_All');
        }
        return $this->renderForm('products/newProduct.html.twig', [
            'form' => $form,
        ]);
    }
    


    /**
     * @Route("products/delete/{id}", name="products_delete",methods={"DELETE"})
     */
    public function deleteProduct(Request $request,EntityManagerInterface $entityManager,ProductRepository $productRepository, $id){
        $product = $productRepository->find($id);

        $entityManager->remove($product);
        $entityManager->flush();

        return new Response();
    }
    /**
     * @Route("/products/edit/{id}", name="products_edit")
     */
    public function productEdit(Request $request, ProductRepository $productRepository,EntityManagerInterface $entityManager,$id)
    {

        $product = new Product();

        $product = $productRepository->find($id);

        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('products_All');
        }
        return $this->renderForm('products/editProduct.html.twig', [
            'form' => $form,
        ]);
    }



    /**
     * @Route("/products/{id}", name="products_show")
     */
    public function showProduct(Product $product): Response
    {
        return $this->render('products/showProduct.html.twig', [
            'product' => $product
        ]);
    }
}
