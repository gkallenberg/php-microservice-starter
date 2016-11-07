<?php
namespace NYPL\Starter\Model\ModelTrait;

use NYPL\Starter\Config;
use NYPL\Starter\DB;
use NYPL\Starter\Model;
use NYPL\Starter\SierraHandler;

trait SierraTrait
{
    /**
     * @param string $id
     *
     * @return string
     */
    abstract public function getSierraPath($id = '');

    /**
     * @param resource $curl
     *
     * @return mixed
     */
    abstract public function applyCurlOptions($curl);

    /**
     * @param string $id
     *
     * @return string
     */
    public function getSierraId($id = '')
    {
        if (is_numeric(substr($id, 0, 1))) {
            return $id;
        }

        return substr($id, 1);
    }

    /**
     * @param string $path
     * @param array $headers
     *
     * @return resource
     */
    protected function getCurl($path = '', array $headers = [])
    {
        $curl = curl_init();

        $headers[] = 'Authorization: Bearer ' . $this->getAccessToken();

        curl_setopt($curl, CURLOPT_URL, SierraHandler::getBaseUrl() . '/' . $path);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $this->applyCurlOptions($curl);

        $response = curl_exec($curl);

        return $response;
    }

    /**
     * @param array $token
     */
    protected function saveToken(array $token = [])
    {
        $token["expire_time"] = time() + $token["expires_in"];

        $insertStatement = DB::getDatabase()->insert(array_keys($token))
            ->into("Token")
            ->values(array_values($token));

        $insertStatement->execute(true);
    }

    protected function getAccessToken()
    {
        $selectStatement = DB::getDatabase()->select()
            ->from("Token")
            ->where("expire_time", ">", time());

        $selectStatement = $selectStatement->execute();

        if ($selectStatement->rowCount()) {
            $token = $selectStatement->fetch();

            return $token['access_token'];
        }

        $token = json_decode($this->getNewToken(), true);

        $this->saveToken($token);

        return $token["access_token"];
    }


    protected function getNewToken()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, SierraHandler::getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, ["grant_type" => "client_credentials"]);
        curl_setopt($curl, CURLOPT_USERPWD, SierraHandler::getClientId() . ":" . SierraHandler::getClientSecret());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $tokenJson = curl_exec($curl);

        curl_close($curl);

        return $tokenJson;
    }
}
