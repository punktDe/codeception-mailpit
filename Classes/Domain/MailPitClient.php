<?php
namespace PunktDe\Codeception\MailPit\Domain;

/*
 * This file is part of the PunktDe\Codeception-MailPit package.
 *
 * This package is open source software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use GuzzleHttp\Client;
use PunktDe\Codeception\MailPit\Domain\Model\Mail;

class MailPitClient
{
    /**
     * @var Client
     */
    protected $client;

    protected const BASE_PATH = '/api/v1';

    /**
     * MailPitClient constructor.
     * @param string $baseUri
     * @param string $username
     * @param string $password
     * @param string $authenticationType
     */
    public function __construct(string $baseUri, string $username = '', string $password = '', string $authenticationType = 'basic')
    {
        $configuration = [
            'base_uri' => $baseUri,
            'cookies' => true,
            'headers' => [
                'User-Agent' => 'FancyPunktDeGuzzleTestingAgent'
            ],
        ];

        if($username !== '' && $password !== '') {
            $configuration = array_merge($configuration, ['auth' => [$username, $password, $authenticationType]]);
        }

        $this->client = new Client($configuration);
    }

    public function deleteAllMails(): void
    {
        $this->client->delete(self::BASE_PATH . '/messages');
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function countAll(): int
    {
        $data = $this->getDataFromMailPit('/messages');

        return $data['total'];
    }

    /**
     * @param $index
     * @return Mail
     */
    public function findOneByIndex(int $index): Mail
    {
        $list = $this->getDataFromMailPit('/messages');

        $id = $list['messages'][$index]['ID'];

        $data = $this->getDataFromMailPit('/message/' . $id);

        return new Mail($data);
    }

    /**
     * @param $apiCall
     * @return array
     * @throws \Exception
     */
    protected function getDataFromMailPit($apiCall): array
    {
        $result = $this->client->get(self::BASE_PATH . $apiCall)->getBody();

        $data = json_decode($result, true);

        if ($data === false) {
            throw new \Exception('The mailpit result could not be parsed to json', 1774452891);
        }

        return $data;
    }

    /**
     * @param array $data
     * @return Mail
     */
    protected function buildMailObjectFromJson(array $data): Mail
    {
        return new Mail($data);
    }

}
