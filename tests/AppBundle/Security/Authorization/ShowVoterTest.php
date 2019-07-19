<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 17/04/2018
 * Time: 14:15
 */

namespace Tests\AppBundle\Security\Authorization;


use AppBundle\Entity\Show;
use AppBundle\Entity\User;
use AppBundle\Security\Authorization\ShowVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ShowVoterTest extends TestCase
{
    public function testvoteOnAttributeWithAuthor()
    {
        $user = new User();
        $subject = new Show();
        $subject->setAuthor($user);
        $token = $this
            ->getMockBuilder(TokenInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $token->method('getUser')->willReturn($user);
        $showVoter = new ShowVoter();
        $result = $showVoter->voteOnAttribute('',$subject,$token);

        $this->assertSame(true,$result);
    }

    public function testvoteOnAttributeWithoutAuthor()
    {
        $user = new User();
        $subject = new Show();
        $token = $this
            ->getMockBuilder(TokenInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $token->method('getUser')->willReturn($user);
        $showVoter = new ShowVoter();
        $result = $showVoter->voteOnAttribute('',$subject,$token);

        $this->assertSame(false,$result);
    }
}