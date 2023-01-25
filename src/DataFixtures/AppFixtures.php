<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Users;
use App\Entity\Articles;
use App\Entity\Booking;
use App\Entity\Categories;
use App\Entity\Comments;
use App\Entity\Factures;
use App\Entity\Paiements;
use App\Entity\Temoignages;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
        
    }
    
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        $adminUser = new Users();

        $adminUser->setPrenom('Frederic')
                  ->setNom('Husson')
                  ->setEmail('mega-services@hotmail.fr')
                  ->setPassword($this->encoder->hashPassword($adminUser, 'Laura@14111990'))
                  ->setAvatar('https://randomuser.me/api/portraits/men/29.jpg')
                  ->setRoles(['ROLE_ADMIN'])
                  ->setIsVerified(1)
                  ->setAdresse($faker->streetAddress)
                 ->setCodePostal($faker->postcode)
                 ->setVille($faker->city)
                 ->setPays($faker->country)
                 ->setSociete($faker->company)
                 ->setTelephone($faker->phoneNumber)
                 ->setCreatedAt($faker->dateTime())
                 ->setUsername($faker->userName())
                 ->setFullName('Husson Frederic');

        $manager->persist($adminUser);

        // Nous gérons les utilisateurs

        $users = [];
        $genres = ['male', 'female'];

        for ($i=1; $i<=500; $i++) {

            $user = new Users;

            $genre = $faker->randomElement($genres);
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';
            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->hashPassword($user, 'password');

            $nom = $faker->lastName($genre);
            $prenom = $faker->firstName($genre);

            $user->setEmail($faker->email)
                 ->setPassword($hash)
                 ->setIsVerified(1)
                 ->setAvatar($picture)
                 ->setNom($nom)
                 ->setPrenom($prenom)
                 ->setAdresse($faker->streetAddress)
                 ->setCodePostal($faker->postcode)
                 ->setVille($faker->city)
                 ->setPays($faker->country)
                 ->setSociete($faker->company)
                 ->setTelephone($faker->phoneNumber)
                 ->setCreatedAt($faker->dateTime())
                 ->setUsername($faker->userName())
                 ->setFullName($nom. ' '. $prenom);

            $manager->persist($user);
            $users[] = $user;        

        }

        // Nous gérons les Témoignages

        $temoignages = [];
        $note = ['0', '0.5', '1', '1.5', '2', '2.5', '3', '3.5', '4', '4.5', '5'];

        for ($i=1; $i<=500; $i++) {

            $temoignage = new Temoignages();

            $temoignage->setClient($faker->randomElement($users))
                       ->setDescription($faker->text(255))
                       ->setActif(1)
                       ->setCreatedAt($faker->dateTime())
                       ->setNote($faker->randomElement($note));

            $manager->persist($temoignage);
            $temoignages[] = $temoignage;
        }

        $categories = [];

        for ($i=1; $i<=10; $i++) {

            $categorie = new Categories;

            $mots = rand(1,3);

            $categorie->setName($faker->words($mots, true));

            $manager->persist($categorie);
            $categories[] = $categorie;


        }

        $interventions = [];

        for ($i=1; $i<=500; $i++) {

            $intervention = new Booking;

            $debut = $faker->dateTime('now');
            $fin = $debut->modify('+ 4 hour');

            $intervention->setUser($faker->randomElement($users))
                         ->setBeginAt($debut)
                         ->setEndAt($fin)
                         ->setTitle('Dépannage a distance')
                         ->setDescription('Une message de teste');

            $manager->persist($intervention);
            $interventions[] = $intervention;


        }

        $factures = [];

        for ($i=1; $i<=500; $i++) {

            $facture = new Factures;


            $facture->setClient($faker->randomElement($users))
                    ->setStatut('en_attente')
                    ->setUrl('http://www.google.fr')
                    ->setCreatedAt('123456789')
                    ->setTitle('Dépannage a distance')
                    ->setDate($faker->dateTime('now'))
                    ->setAmount($faker->randomNumber(5, false))
                    ->setSlug('mafacture')
                    ->setContent($faker->text('255'));

            $manager->persist($facture);
            $factures[] = $facture;

            $paiement = new Paiements;

            $paiement->setFacture($facture)
                    ->setMontant($faker->randomNumber(5, false))
                    ->setStatut('complete')
                    ->setDate($faker->dateTime('now'))
                    ->setClient($faker->randomElement($users));

            $manager->persist($paiement);

        }

        
        $articles = [];
        for ($i=1; $i<=500; $i++) {

            $article = new Articles();

            $article->setDate($faker->dateTime('now'))
                    ->setContent($faker->paragraph(5))
                    ->setTitle($faker->text(50))
                    ->setImg($faker->imageUrl(1024, 768))
                    ->setCategories($faker->randomElement($categories))
                    ->setAuteur($faker->randomElement($users));

            $manager->persist($article);
            $articles[] = $article;
        }

        $commentaires = [];
        for ($i=1; $i<=500; $i++) {

            $commentaire = new Comments();

            $commentaire->setArticles($faker->randomElement($articles))
                        ->setAuteur($faker->randomElement($users))
                        ->setContent($faker->paragraph(1))
                        ->setActive(true)
                        ->setCreatedAt($faker->dateTime('now'));

            $manager->persist($commentaire);
            $commentaires[] = $commentaire;
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
