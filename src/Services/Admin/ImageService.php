<?php

namespace App\Services\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Entity\Animal;
use App\Entity\Categorie;

class ImageService
{
    private $animalDirectory;
    private $categorieDirectory;
    private $produitDirectory;
    private $slugger;

    public function __construct($animalDirectory, $produitDirectory, $categorieDirectory, SluggerInterface $slugger)
    {
        $this->animalDirectory = $animalDirectory;
        $this->produitDirectory = $produitDirectory;
        $this->categorieDirectory = $categorieDirectory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file, $categorie)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        if ($categorie == 'animal') {
            $file->move($this->getAnimalDirectory(), $fileName);
        } else if ($categorie == 'produit') {
            $file->move($this->getProduitDirectory(), $fileName);
        } else if ($categorie == 'categorie') {
            $file->move($this->getCategorieDirectory(), $fileName);
        }
        return $fileName;

    }

    public function getAnimalDirectory()
    {
        return $this->animalDirectory;
    }

    public function getProduitDirectory()
    {
        return $this->produitDirectory;
    }
    public function getCategorieDirectory()
    {
        return $this->categorieDirectory;
    }
}