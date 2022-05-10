<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
     /**
     * @Route("/categories", name="categories_All")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {

        $categories = $categoryRepository->findAll();
        return $this->render('categories/categories.html.twig', [
            'controller_name' => 'CategoryController',
            'categories'        => $categories
        ]);
    }

    /**
     * @Route("/categories/new", name="categories_new")
     */
    public function categoryNew(Request $request, EntityManagerInterface $entityManager): Response
    {

        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('products_All');
        }


        return $this->renderForm('categories/newCategories.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/categories/edit/{id}", name="categories_edit")
     */
    public function categoryEdit(Request $request,CategoryRepository $categoryRepository, EntityManagerInterface $entityManager,$id): Response
    {

        $category = new Category();
        $category = $categoryRepository->find($id);

        $form = $this->createForm(CategoryFormType::class,  $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {

            
            $entityManager->flush();

            return $this->redirectToRoute('products_All');
        }

        return $this->renderForm('categories/editCategories.html.twig', [
            'form' => $form,
        ]);
    }


    
    /**
     * @Route("/categories/{id}", name="categories_show")
     */
    public function showCategory(Category $category): Response
    {
        return $this->render('categories/showCategory.html.twig', [
            'category' => $category
        ]);
    }
}
