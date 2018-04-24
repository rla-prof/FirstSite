<?php

namespace RLI\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="RLI\StockBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="prod_des", type="string", length=70)
     */
    private $prodDes;

    /**
     * @var int
     *
     * @ORM\Column(name="prod_qte", type="integer")
     */
    private $prodQte;

    /**
     * @var string
     *
     * @ORM\Column(name="prod_pu", type="decimal", precision=7, scale=2)
     */
    private $prodPu;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set prodDes
     *
     * @param string $prodDes
     *
     * @return Produit
     */
    public function setProdDes($prodDes)
    {
        $this->prodDes = $prodDes;
        return $this;
    }

    /**
     * Get prodDes
     *
     * @return string
     */
    public function getProdDes()
    {
        return $this->prodDes;
    }

    /**
     * Set prodQte
     *
     * @param integer $prodQte
     *
     * @return Produit
     */
    public function setProdQte($prodQte)
    {
        $this->prodQte = $prodQte;
        //return $this;
    }

    /**
     * Get prodQte
     *
     * @return int
     */
    public function getProdQte()
    {
        return $this->prodQte;
    }

    /**
     * Set prodPu
     *
     * @param string $prodPu
     *
     * @return Produit
     */
    public function setProdPu($prodPu)
    {
        $this->prodPu = $prodPu;
        return $this;
    }

    /**
     * Get prodPu
     *
     * @return string
     */
    public function getProdPu()
    {
        return $this->prodPu;
    }

    /**
     * Set categorie
     *
     * @param \RLI\StockBundle\Entity\Categorie $categorie
     *
     * @return Produit
     */
    public function setCategorie(\RLI\StockBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * Get categorie
     *
     * @return \RLI\StockBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
