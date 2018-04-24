<?php

namespace RLI\StockBundle\Controller;

use RLI\StockBundle\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

use RLI\StockBundle\Entity\Produit;
use RLI\StockBundle\Entity\Categorie;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class produitController extends Controller
{
    public function indexAction()     {
		
        $this->get('session')->clear();
	return $this->render('index.html.twig');
    }
    
    public function addAction($idCat, Request $request) {
          
    // On crée un objet Produit	
    $prod = new Produit();

    // On crée le FormBuilder grâce au service form factory
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $prod);

    // On ajoute les champs de l'entité que l'on veut ajouter à notre formulaire
    $formBuilder
			->add('prod_des',  TextType::class, array('label'=>"Désignation : "))
			->add('prod_qte',  NumberType::class, array('label'=>"Quantité : "))
			->add('prod_pu', NumberType::class, array('label'=>"Prix unitaire : "))
			->add('Ajouter un produit', submitType::class);

      // À partir du formBuilder, on génère le formulaire      
	  $form = $formBuilder->getForm();

	 // La requête est en POST
          
       if ($request->isMethod('POST')) {
           
       if ($form->isSubmitted()) {
      // On vérifie que les valeurs entrées sont correctes

      if ($form->isValid()) {

        // On enregistre notre objet $livre dans la base de données :  
        
			$em = $this->getDoctrine()->getManager();                 
			$em->persist($prod);        
			$em->flush();                
			$request->getSession()->getFlashBag()->add('notice', 'Produit bien enregistré.');
			
			
	       // On redirige vers la page de visualisation du produit nouvellement créé  
	       
	        return $this->redirectToRoute('disp_produit', array('id' => $prod->getId()));
	
		}       
	}
       }
    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
    
		return $this->render('form.html.twig', array('form' => $form->createView(),));
}
	
public function displayAction($id) {
	
    /*
	// On récupère le repository
	$repo = $this->getDoctrine()->getManager()->getRepository('RLIStockBundle:produit');

	// On récupère l'entité correspondante à l'id $id
	$prod= $repo->find($id);

	// $prod est donc une instance de RLI\StockBundle\Entity\produit ou null si l'id $id  n'existe pas, d'où ce if :

        if (null === $prod) {
            throw new NotFoundHttpException("le produit d'id ".$id." n'existe pas.");
        }

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
         return $this->render('produit.html.twig', array('produit' => $prod));
    */
    
    $repo = $this->getDoctrine()->getManager()->getRepository('RLIStockBundle:Produit');
    $des = 'D';
    $pu = 1900 ;
    $liste = $repo->findParDesEtPu($des, $pu);
    foreach ($liste as $elem) {
        echo $elem->getId().'<br>';
    }
    return new Response('Fin des traitements');
   }

public function updateAction($id) {

	$em = $this->getDoctrine()->getManager();

	$prod = $em->getRepository(produit::class)->find($id);

	if (!$prod) {
		throw $this->createNotFoundException('Catégorie inexistante pour id '.$id);
	}

	$cat->setNomCat('Electrotech!');
		
	$em->flush();

	return $this->redirectToRoute('disp_prod', array('id' => $prod->getId()));
}


}




