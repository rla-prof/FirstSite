<?php

namespace RLI\StockBundle\Controller;

use Doctrine\ORM\Mapping as ORM;

use RLI\StockBundle\Entity\Categorie;
use RLI\StockBundle\Entity\Produit;

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


class categorieController extends Controller
{
    public function indexAction()     {
		
        $this->get('session')->clear();
	return $this->render('index.html.twig');
    }
    
    public function addAction(Request $request) {

     // Création de l'entité Categorie
    $cat = new Categorie();
    $cat->setCatNom('Serveurs');
    
    // Création d'un premier produit

    $prod1 = new Produit();
    $prod1->setProdDes('Proliant BDD');
    $prod1->SetProdQte(15);
    $prod1->SetProdPu(1350);

    // Création d'un deuxième produit

    $prod2 = new Produit();
    $prod2->setProdDes('DELL PowerEdge T430');
    $prod2->SetProdQte(5);
    $prod2->SetProdPu(1750);

    // On lie les produits à la catégorie

    $prod1->setCategorie($cat);
    $prod2->setCategorie($cat);

    // On récupère l'EntityManager

    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité

    $em->persist($cat);

    // Étape 1 bis : pour cette relation pas de cascade lorsqu'on persiste Categorie, car la relation est
    // définie dans l'entité Peoduit. On doit donc tout persister à la main ici.

   $em->persist($prod1);
   $em->persist($prod2);
   
   // Étape 2 : On « flush » tout ce qui a été persisté avant

   $em->flush();
    
   //return new Response('Nouvelle catégorie '.$cat->getId());
    return $this->redirectToRoute('disp_categ', array('id' => $cat->getId()));

  }
    /*
    // On crée un objet Catégorie
    $cat = new Categorie();

    // On crée le FormBuilder grâce au service form factory
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $cat);

    // On ajoute les champs de l'entité que l'on veut ajouter à notre formulaire
    $formBuilder
			->add('cat_nom',  TextType::class)
                        ->add('Ajouter un produit', submitType::class);

      // À partir du formBuilder, on génère le formulaire      
	  $form = $formBuilder->getForm();

	 // La requête est en POST	
	 $form->handleRequest($request);
	
    if ($form->isSubmitted()) {
      // On vérifie que les valeurs entrées sont correctes

      if ($form->isValid()) {

        // On enregistre notre objet $livre dans la base de données :  
        
			$em = $this->getDoctrine()->getManager();                 
			$em->persist($cat);        
			$em->flush();                
			$request->getSession()->getFlashBag()->add('notice', 'Catégorie bien enregistrée.');
			
		// On redirige vers la page de visualisation du produit nouvellement créé  
	       
	        return $this->redirectToRoute('disp_categ', array('id' => $cat->getId()));
	
		}       
	}

    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
    
		return $this->render('form.html.twig', array('form' => $form->createView(),));
}
*/
        
public function displayAction($id) {
    
     $em = $this->getDoctrine()->getManager();

      // On récupère la catégorie (id)
     $cat = $em->getRepository('RLIStockBundle:Categorie')->find($id);

    if (null === $cat) {
      throw new NotFoundHttpException("La catégorie d'id ".$id." n'existe pas.");
    }

    // On récupère la liste des produits de cette catégorie
    $listeProduits = $em->getRepository('RLIStockBundle:Produit')->findBy(array('id' => $cat->getId()));
   
    return $this->render('categorie.html.twig', array('cat'=>$cat,'Produits'=>$listeProduits));

  }
            
}




