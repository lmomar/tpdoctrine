<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 12/29/18
 * Time: 5:47 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="/products",name="products_list")
     */
    public function listAction(){
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $products = $repo->findAll();
        return $this->render('AppBundle::product/index.html.twig',array('products' => $products));
    }

    /**
     * @Route(path="/product/add",name="product_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request){
        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirect($this->generateUrl('products_list'));
        }
        return $this->render('AppBundle::product/add.html.twig',array('frmadd' => $form->createView()));
    }

    /**
     * @Route(path="/product/{id}/edit",name="product_edit",requirements={"id"="[0-9]+"})
     */
    public function editAction(Request $request,$id){

    }
}