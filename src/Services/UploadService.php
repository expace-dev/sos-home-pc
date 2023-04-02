<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UploadService {

    public function __construct(private ParameterBagInterface $params)
    {
        
    }

    public function send($fichier, $directory) {
        
        $nom = md5(uniqid()) . '.' . $fichier->guessExtension();

        
        $fichier->move(
            $this->params->get($directory),
            $nom
        );
        
        return $nom;
    }
}