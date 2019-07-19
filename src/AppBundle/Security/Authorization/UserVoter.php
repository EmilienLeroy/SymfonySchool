<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 20/02/2018
 * Time: 10:54
 */

namespace AppBundle\Security\Authorization;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    const ROLE_ADMIN = 'ROLE_ADMIN';

    public function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if(!$user instanceof User){
            return false;
        }

        if('ROLE_ADMIN' === $attribute && in_array(self::ROLE_ADMIN,$user->getRoles)){
            return true;
        }

        return false;
    }

    public function supports($attribute, $subject)
    {
        if($attribute != self::ROLE_ADMIN ){
            return true;
        }

        return false;

    }
}