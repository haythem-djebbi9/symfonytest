<?php
namespace App\Controller;

use App\Repisotery\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

Use Symfony\Component\Routing\Annotation\Route;



class IndexController extends AbstractController
{
   private $entityManager;
    


   public function __construct(EntityManagerInterface $entityManager) {
       $this->entityManager = $entityManager;
       
   }


  public function home(Request $request)
  {
    
      //si si aucun nom n'est fourni on affiche tous les taches
      $taches= $this->entityManager->getRepository(Tache::class)->findAll();
      
      return $this->render('tache/index.html.twig'); 
  }


public function new(Request $request,FormFactoryInterface $formFactory)
{





  $tache = new Tache();
  $form = $this->createForm(ArticleType::class,$tache);
  $form->handleRequest($request);
  if($form->isSubmitted() && $form->isValid()) {
      $article = $form->getData();
      $this->entityManager->persist($article);
      $this->entityManager->flush();
      return $this->redirectToRoute('tache_list');
  }
  return $this->render('taches/new.html.twig',['form' => $form->createView()]);
}

public function show($id) {
  $article = $this->entityManager->getRepository(Tache::class)->find($id);
  return $this->render('taches/show.html.twig',array('tache' => $tache));
   }






   public function edit(Request $request, $id,FormFactoryInterface $formFactory) {
    $tache = new Tache();
        $tache = $this->entityManager->getRepository(Tache::class)->find($id);
        $form = $this->createForm(ArticleType::class,$tache);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
        $this->entityManager->flush();
        return $this->redirectToRoute('tache_list');
        }
        return $this->render('taches/edit.html.twig', ['form' =>$form->createView()]);
}





public function delete(Request $request, $id) {
  $article = $this->entityManager->getRepository(Article::class)->find($id);

  //$entityManager = $this->getDoctrine()->getManager();
  $this->entityManager->remove($tache);
  $this->entityManager->flush();

  $response = new Response();
  $response->send();
  return $this->redirectToRoute('tache_list');
}



}
  


