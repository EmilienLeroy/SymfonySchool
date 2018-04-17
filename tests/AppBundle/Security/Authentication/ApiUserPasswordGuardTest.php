<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 17/04/2018
 * Time: 09:51
 */

namespace Tests\AppBundle\Security\Authentication;


use AppBundle\Entity\User;
use AppBundle\Security\Authentication\ApiUserPasswordGuard;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class ApiUserPasswordGuardTest extends TestCase
{
    public function testGetCredentialsWithoutUsernameInRequest()
    {
        $encoderFactory = new EncoderFactory([]);
        $request = new Request();
        $request->headers->add(['X-PASSWORD' => 'mypass']);
        $authenticator = new ApiUserPasswordGuard($encoderFactory);
        $result = $authenticator->getCredentials($request);

        $this->assertSame(null, $result);
    }

    public function testGetCredentialWithoutPasswordInRequest()
    {
        $encoderFactory = new EncoderFactory([]);
        $request = new Request();
        $request->headers->add(['X-USERNAME' => 'ME']);
        $authenticator = new ApiUserPasswordGuard($encoderFactory);
        $result = $authenticator->getCredentials($request);

        $this->assertSame(null, $result);
    }


    public function testGetCredentialWithoutAnyHeaders()
    {
        $encoderFactory = new EncoderFactory([]);
        $request = new Request();
        $authenticator = new ApiUserPasswordGuard($encoderFactory);
        $result = $authenticator->getCredentials($request);

        $this->assertSame(null, $result);
    }

    public function testGetCredentialWithUsernameAndPassword()
    {
        $encoderFactory = new EncoderFactory([]);
        $request = new Request();
        $request->headers->add(['X-USERNAME' => 'ME']);
        $request->headers->add(['X-PASSWORD' => 'mypass']);
        $authenticator = new ApiUserPasswordGuard($encoderFactory);
        $result = $authenticator->getCredentials($request);

        $this->assertSame(['username' => 'ME','password' => 'mypass'], $result);
    }

    public function testCheckCredentialAreCorrect()
    {
        $encoder = new BCryptPasswordEncoder(10);

        /*
        $encoderFactory = $this
            ->createMock(EncoderFactory::class)
            ->method('getEncoder')->willReturn($encoder)
            ->expects($this->once())
        ;*/
        //$encoderFactory = new EncoderFactory([]);

        $encoderFactory = $this
            ->getMockBuilder(EncoderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $encoderFactory->method('getEncoder')->willReturn($encoder);

        $user = new User();
        $user->setPassword('$2y$13$pKcKIVkwUe0/xi.vuvK0MOxIMvcqWyOadmEiWLdfDS5aNoH2mPND2');
        $credentials = ['username' => 'ME','password' => 'test'];

        $authenticator = new ApiUserPasswordGuard($encoderFactory);
        $result = $authenticator->checkCredentials($credentials,$user);
        $this->assertSame(true,$result);
    }

    /**
     * @expectedException Symfony\Component\Security\Core\Exception\AuthenticationException
     */
    public function testCheckCredentialAreWrong()
    {
        $encoder = new BCryptPasswordEncoder(10);

        $encoderFactory = $this
            ->getMockBuilder(EncoderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $user = new User();
        $user->setPassword('$2y$13$pKcKIVkwUe0/xi.vuvK0MOxIMvcqWyOadmEiWLdfDS5aNoH2mPND2');
        $credentials = ['username' => 'ME','password' => 'testfr'];

        $encoderFactory->method('getEncoder')->willReturn($encoder);
        $authenticator = new ApiUserPasswordGuard($encoderFactory);
        $result = $authenticator->checkCredentials($credentials,$user);
    }
}