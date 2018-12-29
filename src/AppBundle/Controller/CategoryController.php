<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 12/29/18
 * Time: 5:47 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route(path="/categories",name="category_list")
     */
    public function listAction(){
        $repo=$this->getDoctrine()->getRepository("AppBundle:Category");
        $categories = $repo->findBy(array('disabled' => false));
        return $this->render('AppBundle::category/index.html.twig',array('categories' => $categories));
    }

    /**
     * @Route(path="/catgeory/add",name="category_add")
     */
    public function addAction(Request $request){
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);
        //var_dump($request->request->all());die('req');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirect($this->generateUrl('category_list'));
        }
        return $this->render('AppBundle::category/add.html.twig',array('frmadd' => $form->createView()));
    }

    /**
     * @param Request $request
     * @param $id
     * @Route(path="/category/{id}/edit",name="category_edit",requirements={"id"="[0-9]+"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Category::class);
        $category = $repo->find($id);

        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirect($this->generateUrl('category_list'));
        }
        //var_dump($category);die('id');
        return $this->render('AppBundle::category/edit.html.twig',array('form' => $form->createView()));

    }


}