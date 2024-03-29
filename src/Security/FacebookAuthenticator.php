<?php

namespace App\Security;

use App\Entity\Users; // your user entity
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class FacebookAuthenticator extends OAuth2Authenticator
{
    private $clientRegistry;
    private $entityManager;
    private $router;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $entityManager, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    public function supports(Request $request): ?bool
    {
        // continue ONLY if the current ROUTE matches the check ROUTE
        return $request->attributes->get('_route') === 'connect_facebook_check';
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('facebook');
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function() use ($accessToken, $client) {
                /** @var FacebookUser $facebookUser */
                $facebookUser = $client->fetchUserFromToken($accessToken);

                
                $email = $facebookUser->getEmail();

                
                // 1) have they logged in with Facebook before? Easy!
                $existingUser = $this->entityManager->getRepository(Users::class)->findOneBy(['facebookId' => $facebookUser->getId()]);

                if ($existingUser) {
                    return $existingUser;
                }

                else {
                    // 2) do we have a matching user by email?
                    $user = $this->entityManager->getRepository(Users::class)->findOneBy(['email' => $email]);

                    if (!$user) {
                        $user = new Users();

                        $username = $facebookUser->getFirstName() . $facebookUser->getLastName();


                        $user->setAvatar($facebookUser->getPictureUrl());


                        $user->setUsername($username);
                        $user->setPassword($accessToken->getToken());
                        $user->setEmail($facebookUser->getEmail());
                        $user->setIsVerified(1);
                        $user->setNom($facebookUser->getLastName());
                        $user->setPrenom($facebookUser->getFirstName());
                        $user->setFacebookId($facebookUser->getId());
                        $user->setFullName($facebookUser->getLastName(). " " .$facebookUser->getFirstName());
                        
                    }
                    else {
                        // 3) Maybe you just want to "register" them by creating
                        // a User object
                        $user->setFacebookId($facebookUser->getId());
                    }

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();

                    return $user;

                }

                
                
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // change "app_homepage" to some route in your app
        $targetUrl = $this->router->generate('app_home');


        return new RedirectResponse($targetUrl);
    
        // or, on success, let the request continue to be handled by the controller
        //return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }
}