<?php
class Destiny2API implements ICheckHasItem
{
    private $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function checkHasItem(string $user, string $itemId)
    {
        $info = $this->getUserInfo($user);
        if(!isset($info['Response'][0])){
            return false;
        }

        $response = $info['Response'][0];
        if (!isset($response['membershipType']) || !isset($response['membershipId'])){
            return false;
        }
        $membershipType = $response['membershipType'];
        $membershipId = $response['membershipId'];
        $collResult = $this->getUserCollectibles($membershipType, $membershipId);
        if(!isset($collResult['Response']['profileCollectibles'])){
            return false;
        }
        if (!isset($collResult['Response']['profileCollectibles']['data']['collectibles'])) {
            return 'no';
        }
        $collectibles = $collResult['Response']['profileCollectibles']['data']['collectibles'];
        $result = array_key_exists($itemId, $collectibles);
        return $result ? 'yes' : 'no';
    }

    private function getUserInfo($user)
    {
        $url = $this->config['urlSearchDestinyPlayer'].rawurlencode($user).'/';
        $result = $this->makeRequest($url);
        if(!isset($result['Response'])){
            return false;
        }
        return $result;
    }
    private function getUserCollectibles($membershipType, $membershipId)
    {
        $templateUrl = $this->config['urlGetCollectiblesByPlayer'];
        $membershipTypeTemplate = $this->config['membershipTypeTemplate'];
        $membershipIdTemplate = $this->config['membershipIdTemplate'];
        $url = str_replace($membershipIdTemplate, $membershipId, $templateUrl);
        $url = str_replace($membershipTypeTemplate, $membershipType, $url);
        $result = $this->makeRequest($url);
        if(!$result['Response']){
            return false;
        }
        return $result;
    }
    private function makeRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'x-api-key: '.$this->config['apiKey']
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}
