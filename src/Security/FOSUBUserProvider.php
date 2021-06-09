<?php

namespace App\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Sluggable\Util as Sluggable;
use App\Service\AppServices as Services;

class FOSUBUserProvider extends BaseClass {

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response) {
        $property = $this->getProperty($response);
        $username = $response->getUsername();
        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($service);
        $setter_id = $setter . 'Id';
        $setter_token = $setter . 'AccessToken';
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }
        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
        $this->userManager->updateUser($user);
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
        $username = $response->getUsername();
        $email = $response->getEmail();
        $firstname = $response->getFirstName();
        $lastname = $response->getLastName();

        /** @var \AppBundle\Entity\User $user */
        $user = $this->userManager->findUserByEmail($email);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName);
        $setter_id = $setter . 'Id';
        $setter_token = $setter . 'AccessToken';
        $getter = 'get' . $serviceName;
        $getter_id = $getter . 'Id';
        $getter_token = $getter . 'AccessToken';

//when the user is registering
        if (null === $user) {

            // create new user here
            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            $user->setEmail($email);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setUsername(Sluggable\Urlizer::urlize($user->getFullName(), '-'));
            $user->setUsernameCanonical(Sluggable\Urlizer::urlize($user->getFullName(), '-'));
            $temporaryPassword = Services::generateReference(8);
            $user->setPlainPassword($temporaryPassword);
            if ($response->getProfilePicture() != null) {
                $user->setFacebookProfilePicture($response->getProfilePicture());
            }
            $user->setEnabled(true);
            $user->addRole("ROLE_ATTENDEE");
            $this->userManager->updateUser($user);
            return $user;
        }

        //if user exists
        if ($user->$getter_id() == "") {
            $user->$setter_id($username);
        }

        //update access token
        $user->$setter_token($response->getAccessToken());

        return $user;
    }

}
