<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Discord
{
    private const DISCORD_ACCESS_TOKEN_ENDPOINT = 'https://discord.com/api/oauth2/token';
    private const DISCORD_USER_DATA_ENDPOINT = 'https://discordapp.com/api/users/@me';
    private const DISCORD_GUILDS_DATA_ENDPOINT = 'https://discordapp.com/api/users/@me/guilds';
    
    private $discordClientID;
    private $discordClientSecret;

    private UrlGeneratorInterface $urlGenerator;
    private HttpClientInterface $httpClient;


    public function __construct(
        string $discordClientID,
        string $discordClientSecret,
        UrlGeneratorInterface $urlGenerator,
        HttpClientInterface $httpClient
    )
    {
        $this->discordClientID = $discordClientID;
        $this->discordClientSecret = $discordClientSecret;
        $this->urlGenerator = $urlGenerator;
        $this->httpClient = $httpClient;
    }

    public function loadDiscordUser(string $code)
    {
        $accessToken = $this->getAccesToken($code);
        // dd($accessToken);
        
        $userGuilds = $this->getGuildsInformation($accessToken['access_token']);
        // dd($userGuilds);
        foreach ($userGuilds as $key => $value) {
            if ($value["id"] == 536940955861909525) {
                return $accessToken;
            }
        }
        
    }

    public function getUser(string $acces)
    {
        $userData = $this->getUserInformation($acces);
        return $userData;
    }

    private function getAccesToken(string $code): array
    {
        $redirectUrl = $this->urlGenerator->generate('app_user_login', [
            'discord-oauth-provider' => true
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $options = [
            'headers'=>[
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'body'=>[
                'client_id' => $this->discordClientID,
                'client_secret' => $this->discordClientSecret,
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUrl,
                'scope' => 'identify email guilds'
            ]
        ];
        $response = $this->httpClient->request('POST', self::DISCORD_ACCESS_TOKEN_ENDPOINT, $options);
        
        $data = $response->toArray();

        return $data;
    }

    private function getUserInformation(string $accessToken): array
    {
        $options = [
            'headers'=>[
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$accessToken}"
            ]
        ];

        
        $response = $this->httpClient->request('GET', self::DISCORD_USER_DATA_ENDPOINT, $options);

        $data = $response->toArray();

        return $data;
    }

    private function getGuildsInformation(string $accessToken): array
    {
        $options = [
            'headers'=>[
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$accessToken}"
            ]
        ];

        
        $response = $this->httpClient->request('GET', self::DISCORD_GUILDS_DATA_ENDPOINT, $options);

        $data = $response->toArray();

        return $data;
    }
}
