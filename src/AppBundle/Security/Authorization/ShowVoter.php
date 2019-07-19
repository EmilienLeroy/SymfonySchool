<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 20/02/2018
 * Time: 10:25
 */

namespace AppBundle\Security\Authorization;

use AppBundle\Entity\Show;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ShowVoter extends Voter
{
    public function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        //Get the user
        $user = $token->getUser();
        //Get the show => $show
        $show = $subject;
        //if the author of the show $show.author == user return true
        if($show->getAuthor() == $user){
            return true;
        }else{
            return false;
        }
        //else return false
    }

    public function supports($attribute, $subject)
    {
       if($subject instanceof Show){
           return true;
       }else{
           return false;
       }
    }
}