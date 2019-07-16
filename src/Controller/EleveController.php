<?php

namespace App\Controller;

use App\Entity\Eleves;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 *
 */
class EleveController extends Controller {

  public function liste(){
    $eleves=$this->getDoctrine()->getRepository(Eleves::class)->findAll();
    return new Response($this->renderView('eleves/eleves.html.twig',['liste'=>$eleves]));
  }

  public function add(Request $request){
    $eleve = new Eleves();

    $form=$this->createFormBuilder()
      ->add('nom',TextType::class)
      ->add('prenom',TextType::class)
      ->add('ajouter',SubmitType::class)
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $formData=$form->getData();
      $eleve->setNom($formData['nom']);
      $eleve->setPrenom($formData['prenom']);
      $entityManager=$this->getDoctrine()->getManager();
      $entityManager->persist($eleve);
      $entityManager->flush();
    }

    return new Response($this->renderView('eleves/addEleve.html.twig',['form'=>$form->createView()]));

  }

  public function delete($id){
    $eleve=$this->getDoctrine()->getRepository(Eleves::class)->find($id);
    $entityManager=$this->getDoctrine()->getManager();
    $entityManager->remove($eleve);
    $entityManager->flush();
    return new Response($this->renderView('eleves/delEleve.html.twig'));
  }

  public function read($id){
    $eleve=$this->getDoctrine()->getRepository(Eleves::class)->find($id);
    return new Response($this->renderView('eleves/ReadEleve.html.twig',['eleve'=>$eleve]));
  }

  public function update($id, Request $request){
    $eleve = $this->getDoctrine()->getRepository(Eleves::class)->find($id);

    $form=$this->createFormBuilder()
      ->add('nom',TextType::class,['data'=>$eleve->getNom()])
      ->add('prenom',TextType::class,['data'=>$eleve->getPrenom()])
      ->add('modifier',SubmitType::class)
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $formData=$form->getData();
      $eleve->setNom($formData['nom']);
      $eleve->setPrenom($formData['prenom']);
      $entityManager=$this->getDoctrine()->getManager();
      $entityManager->flush();
    }

    return new Response($this->renderView('eleves/updateEleve.html.twig',['form'=>$form->createView()]));

  }
}
