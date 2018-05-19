<?php
declare(strict_types=1);
namespace App\Socialite;

use Laravel\Socialite\Two\User;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;

class SlackProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    protected $scopes = [
        'identity.basic',
        'identity.team',
        'identity.email',
        'identity.avatar'
    ];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://slack.com/oauth/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://slack.com/api/oauth.access';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $options  = ['headers' => ['Accept' => 'application/json']];
        $endpoint = 'https://slack.com/api/users.identity?token=' . $token;
        $response = $this->getHttpClient()->get($endpoint, $options)->getBody()->getContents();

        return json_decode($response, true);
    }

    /**
     * TODO: mapping
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id'         => array_get($user, 'user.id'),
            'first_name' => array_get($user, 'user.first_name'),
            //'email'      => array_get($user, 'user.email'),
            //'avatar' => array_get($user, 'user.image_32'),
        ]);
    }
}
