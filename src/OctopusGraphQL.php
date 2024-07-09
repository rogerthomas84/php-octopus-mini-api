<?php

namespace Rt\OctopusAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * @class OctopusGraphQL
 * @package Rt\OctopusAPI
 */
class OctopusGraphQL
{
    /**
     * @var string
     */
    protected string $email;

    /**
     * @var string
     */
    protected string $password;

    /**
     * @var string
     */
    protected string $token;

    /**
     * @var string
     */
    protected string $accountNumber;

    /**
     * @var string
     */
    protected string $meterDeviceId;

    /**
     * OctopusGraphQL constructor.
     * @param string $email
     * @param string $password
     * @param string $accountNumber
     * @param string|null $token (optional)
     * @throws GuzzleException
     */
    public function __construct(string $email, string $password, string $accountNumber, ?string $token = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->accountNumber = $accountNumber;
        if ($token) {
            $this->token = $token;
        }
        $this->getToken();
    }

    /**
     * @return string
     */
    protected function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    protected function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    protected function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    /**
     * @return string
     * @throws GuzzleException
     */
    public function getToken(): string
    {
        if (isset($this->token) && $this->token !== null) {
            return $this->token;
        }

        $client = new Client();
        $response = $client->post('https://api.octopus.energy/v1/graphql/', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                "variables" => [
                    "email" => $this->getEmail(),
                    "password" => $this->getPassword(),
                ],
                "query" => 'mutation krakenTokenAuthentication($email: String!, $password: String!) {obtainKrakenToken(input: {email: $email, password: $password}) {token}}',
            ])
        ]);

        $decoded = json_decode($response->getBody()->getContents(), true);
        $this->token = $decoded['data']['obtainKrakenToken']['token'];
        return $this->token;
    }

    /**
     * Get the live consumption of the meter, usually where an Octopus Mini is installed.
     *
     * @param string|null $meterDeviceId (optional)
     * @return int
     * @throws GuzzleException
     */
    public function getLiveConsumption(string|null $meterDeviceId = null): int
    {
        if ($meterDeviceId === null) {
            $meterDeviceId = $this->getMeterDeviceId();
        }

        $client = new Client();
        $response = $client->post(
            'https://api.octopus.energy/v1/graphql/',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->getToken(),
                ],
                'body' => json_encode([
                    'variables' => [
                        'meterDeviceId' => $meterDeviceId,
                    ],
                    "query" => 'query getSmartMeterTelemetry($meterDeviceId: String!, $start: DateTime, $end: DateTime, $grouping: TelemetryGrouping) {smartMeterTelemetry(deviceId: $meterDeviceId, start: $start, end: $end, grouping: $grouping) {demand}}',
                ])
            ]
        );

        $decoded = json_decode($response->getBody()->getContents(), true);
        $data = $decoded['data']['smartMeterTelemetry'];
        $data = $data[0];
        return intval($data['demand']);
    }

    /**
     * @return string
     * @throws GuzzleException
     */
    public function getMeterDeviceId(): string
    {
        if (isset($this->meterDeviceId)) {
            return $this->meterDeviceId;
        }

        $client = new Client();
        $response = $client->post(
            'https://api.octopus.energy/v1/graphql/',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->getToken(),
                ],
                'body' => json_encode([
                    'variables' => [
                        'accountNumber' => $this->getAccountNumber(),
                    ],
                    "query" => 'query octocareUsageInfo($accountNumber: String!) {octocareUsageInfo(accountNumber: $accountNumber) {meterDeviceId}}',
                ])
            ]
        );

        $decoded = json_decode($response->getBody()->getContents(), true);
        $data = $decoded['data']['octocareUsageInfo'];
        $this->meterDeviceId = $data['meterDeviceId'];
        return $this->meterDeviceId;
    }
}
