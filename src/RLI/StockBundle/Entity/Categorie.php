<?php

namespace RLI\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="RLI\StockBundle\Repository\CategorieRepository")
 */
class Categorie
{
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
     * @ORM\Column(name="cat_nom", type="string", length=50)
     */
    private $catNom;


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
     * Set catNom
     *
     * @param string $catNom
     *
     * @return Categorie
     */
    public function setCatNom($catNom)
    {
        $this->catNom = $catNom;

        return $this;
    }

    /**
     * Get catNom
     *
     * @return string
     */
    public function getCatNom()
    {
        return $this->catNom;
    }
}
