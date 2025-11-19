<?php

namespace src;
class SRApi
{
    const API_BASE_URL = 'https://de.backend.salesrender.com/companies/';
    const API_USER_SCOPE = '/CRM/user';
    const API_CRM_SCOPE = '/CRM';
    const API_CPA_SCOPE = '/CPA';
    private $token;
    private $companyId;
    private $scope;

    public function __construct($companyId, $token, $scope = self::API_CRM_SCOPE)
    {
        $this->companyId = $companyId;
        $this->token = $token;
        $this->scope = $scope;
    }

    public function sendRequest($query, ?array $vars = null)
    {
        if (empty($query)) {
            throw new \Exception('Query must not be empty');
        }

        $postFields = [
            'query' => $query
        ];

        if (!empty($vars)) {
            $postFields['variables'] = $vars;
        }

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->getApiUrl(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function getApiUrl()
    {
        return self::API_BASE_URL . $this->companyId . $this->scope . '?token=' . $this->token;
    }
}
