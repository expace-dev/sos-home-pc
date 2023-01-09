<?php

namespace App\Services;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AvatarService {

    private $params;
    private $users;
    private $manager;

    /**
     * Ont donne accès à getParameter
     * 
     * Ont y accède via -> $this->params->get
     *
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params, Users $users, EntityManagerInterface $manager)
    {
        $this->params = $params;
        $this->users = $users;
        $this->manager = $manager;
    }

    /**
     * Fonction permettant d'uploader des fichiers
     *
     * @param [type] $fichiers -> Ont doit donner la source en entrée
     * @param [type] $valideExt -> Ont précise les extensions autorisés
     * @param [type] $directory -> Ont précise le répertoire de destination
     * @return void
     */
    public function send($fichiers, $valideExt, $directory, $user) {

        // Ont initialise le nombre d'erreur à zéro
        $errorFormat = 0;

        // Ont vérifie que le format est valide
        foreach ($fichiers as $fichier) {
            if (!in_array($fichier->getMimetype(), $valideExt)) {
                // Si le format est invalide ont incrémente le compteur d'erreur
                $errorFormat++;
            }
        }
        // Si nous n'avons pas d'erreur
        if ($errorFormat === 0) {

            // Ont génère un nom de fichier unique
            $nom = md5(uniqid()) . '.' . $fichiers->guessExtension();

            $this->users->setAvatar($nom);
            $this->users->setEmail($user->getEmail());
            $this->users->setPassword($user->getPassword());

            //$this->manager->persist($this->users);
            $this->manager->flush();
            //$this->repo->save($user, true);


        }

        return $this->users;
    }
}