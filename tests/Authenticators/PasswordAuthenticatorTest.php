<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\GitHub\Authenticators;

use GrahamCampbell\GitHub\Authenticators\PasswordAuthenticator;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;
use Mockery;

/**
 * This is the password authenticator test class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class PasswordAuthenticatorTest extends AbstractTestCase
{
    public function testMakeWithMethod()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock('Github\Client');
        $client->shouldReceive('authenticate')->once()
            ->with('your-username', 'your-password', 'http_password');

        $return = $authenticator->with($client)->authenticate([
            'username' => 'your-username',
            'password' => 'your-password',
            'method'   => 'password',
        ]);

        $this->assertInstanceOf('Github\Client', $return);
    }

    public function testMakeWithoutMethod()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock('Github\Client');
        $client->shouldReceive('authenticate')->once()
            ->with('your-username', 'your-password', 'http_password');

        $return = $authenticator->with($client)->authenticate([
            'username' => 'your-username',
            'password' => 'your-password',
        ]);

        $this->assertInstanceOf('Github\Client', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The password authenticator requires a username and password.
     */
    public function testMakeWithoutUsername()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock('Github\Client');

        $return = $authenticator->with($client)->authenticate([
            'password' => 'your-password',
        ]);

        $this->assertInstanceOf('Github\Client', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The password authenticator requires a username and password.
     */
    public function testMakeWithoutPassword()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock('Github\Client');
        $return = $authenticator->with($client)->authenticate([
            'username' => 'your-username',
        ]);

        $this->assertInstanceOf('Github\Client', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The client instance was not given to the password authenticator.
     */
    public function testMakeWithoutSettingClient()
    {
        $authenticator = $this->getAuthenticator();

        $return = $authenticator->authenticate([
            'username' => 'your-username',
            'password' => 'your-password',
            'method'   => 'password',
        ]);
    }

    protected function getAuthenticator()
    {
        return new PasswordAuthenticator();
    }
}
