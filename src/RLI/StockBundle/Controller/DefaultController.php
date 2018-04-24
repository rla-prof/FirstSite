<?php

namespace RLI\StockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use RLI\StockBundle\Entity\produit;

class DefaultController extends Controller {
	
	public function indexAction()     {
		
	return $this->render('index.html.twig');
	}

    public function addAction(Request $request) {

		// On crée un objet produit
		$prod= new produit();

		// On crée le FormBuilder grâce au service form factory
		$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $prod);

		// On ajoute les champs de l'entité que l'on veut à notre formulaire
		$formBuilder
			->add('liv_ref',      TextType::class)
			->add('titre_ouv',     TextType::class)
			->add('Auteur_ouv',   TextType::class)
			->add('num_cat',    TextType::class)
			->add('Save', submitType::class);

		// À partir du formBuilder, on génère le formulaire
		$form = $formBuilder->getForm();

		// Si la requête est en POST
		if ($request->isMethod('POST')) {
			// Lien Requête <-> Formulaire
			// À partir de maintenant, la variable $livre contient les valeurs entrées dans le formulaire par le visiteur

			$form->handleRequest($request);

			// On vérifie que les valeurs entrées sont correctes
			// (Nous verrons la validation des objets en détail dans le prochain chapitre)

		if ($form->isValid()) {

			// On enregistre notre objet $livre dans la base de données : 

			$em = $this->getDoctrine()->getManager();
			$em->persist($livre);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Livre bien enregistré.');

			// On redirige vers la page de visualisation du livre nouvellement créé

			return $this->redirectToRoute('disp_livre', array('id' => $livre->getId()));

      }
    }

    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau

    return $this->render('form.html.twig', array('form' => $form->createView(),));

  }
  
	public function displayAction($id) {
	
		// On récupère le repository
		$repository = $this->getDoctrine()->getManager()->getRepository('RLIStockBundle:produit');

		// On récupère l'entité correspondante à l'id $id
		$prd= $repository->find($id);

		// $livre est donc une instance de SLAM\ForumBundle\Entity\Categorie
		// ou null si l'id $id  n'existe pas, d'où ce if :

    if (null === $prd) {
      throw new NotFoundHttpException("le livre d'id ".$id." n'existe pas.");
    }

    // Le render ne change pas, on passait avant un tableau, maintenant un objet

      return $this->render('livre.html.twig', array('livre' => $prd));

	// Si la requête est en POST

    if ($request->isMethod('POST')) {

      // Lien Requête <-> Formulaire
      // À partir de maintenant, la variable $livre contient les valeurs entrées dans le formulaire par le visiteur

      $form->handleRequest($request);

      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)

      if ($form->isValid()) {

        // On enregistre notre objet $livre dans la base de données : 

        $em = $this->getDoctrine()->getManager();
        $em->persist($livre);
        $em->flush();


        $request->getSession()->getFlashBag()->add('notice', 'Livre bien enregistré.');

        // On redirige vers la page de visualisation du livre nouvellement créé

        return $this->redirectToRoute('disp_livre', array('id' => $livre->getId()));

      }
    }

    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau

    return $this->render('form.html.twig', array('form' => $form->createView(),));

  }


public function displayActionbis($id) {

// On récupère le repository

  $repository = $this->getDoctrine()->getManager()->getRepository('RLIStockBundle:produit');

// On récupère l'entité correspondante à l'id $id

    $prd= $repository->find($id);


// $livre est donc une instance de SLAM\ForumBundle\Entity\Categorie
// ou null si l'id $id  n'existe pas, d'où ce if :

    if (null === $prd) {
      throw new NotFoundHttpException("le produit d'id ".$id." n'existe pas.");
    }

    // Le render ne change pas, on passait avant un tableau, maintenant un objet

      return $this->render('produit.html.twig', array('produit' => $liv));

}
}
