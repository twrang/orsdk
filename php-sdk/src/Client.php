<?php
/**
 * Copyright (c) 2021. Fakturaservice A/S - All Rights Reserved 
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Proprietary and confidential
 * Written by Torben Wrang Laursen <twl@fakturaservice.dk>, February 2021
 */

/**
 * Created by PhpStorm.
 * User: twl2
 * Date: 10-09-2020
 * Time: 13:26
 */

namespace OrSdk;

use OrSdk\Models\BaseModels;
use OrSdk\Util\ApiResponseCodes;
use OrSdk\Util\ORException;


/**
 * Class OrApiClient
 * @package Models
 */
class Client
{
    private $_ORApiHost;
    private $_ORApiToken;

    /**
     * Client constructor.
     * @param $host
     * @param $userName
     * @param $password
     * @param $ledgersId
     * @throws ORException
     */
    public function __construct($host, $userName, $password, $ledgersId)
    {
        $this->_ORApiHost   = $host;
        $this->_ORApiToken  = $this->login($userName, $password, $ledgersId);
    }

    /**
     * @param BaseModels $mod
     * @param bool $debug
     * @return mixed
     * @throws ORException
     */
    protected function modelPost(BaseModels &$mod, bool $debug=false)
    {
        
        $args   = array_filter($mod->getValues(true));

        $curl       = curl_init();
        $argStr     = (isset($this->_ORApiToken))?(array("token" => $this->_ORApiToken) + $args):$args;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_ORApiHost . "{$mod->getApiName(true)}/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $argStr,
            CURLINFO_HEADER_OUT => true
        ));

        $response   = curl_exec($curl);
        $err        = curl_error($curl);
        $info       = curl_getinfo($curl);
        curl_close($curl);

        if($debug)
            $this->debug($mod->getApiName(), $argStr, "POST", $response, $err, $info);

        $response = json_decode($response, true);
        if(
            ($response["error_code"] > ApiResponseCodes::OK) &&
            ($response["error_code"] < ApiResponseCodes::SYS_WARNING)
        )
            throw new ORException($response["message"]);
        if(isset($response["id"]))
            $mod->setValue("id", $response["id"]);
        return $response;
    }

    /**
     * @param BaseModels $mod
     * @param bool $debug
     * @return mixed
     * @throws ORException
     */
    protected function modelGet(BaseModels &$mod, bool $debug=false)
    {
        $curl       = curl_init();
        $argStr     = http_build_query((array("token" => $this->_ORApiToken) + $mod->getValues(true)));

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_ORApiHost . "{$mod->getApiName(true)}/?$argStr",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLINFO_HEADER_OUT => true
        ));

        $response   = curl_exec($curl);
        $err        = curl_error($curl);
        $info       = curl_getinfo($curl);
        curl_close($curl);

        if($debug)
        {
            $this->debug($mod->getApiName(), $argStr, "GET", $response, $err, $info);
        }

        $response = json_decode($response, true);
        if(
            ($response["error_code"] > ApiResponseCodes::OK) &&
            ($response["error_code"] < ApiResponseCodes::SYS_WARNING)
        )
            throw new ORException($response["message"]);
        $mod->setValues($response[$mod->getModelName(true)][0]);
        return $response;
    }

    /**
     * @param BaseModels $mod
     * @param bool $debug
     * @return mixed
     * @throws ORException
     */
    protected function modelPut(BaseModels $mod, bool $debug=false)
    {
        $curl       = curl_init();
        $argStr     = http_build_query(array("token" => $this->_ORApiToken) + $mod->getValues(true));


        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_ORApiHost . "{$mod->getApiName(true)}/?$argStr",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT"
        ));

        $response   = curl_exec($curl);
        $err        = curl_error($curl);
        $info       = curl_getinfo($curl);
        curl_close($curl);

        if($debug)
            $this->debug($mod->getApiName(), $argStr, "PUT", $response, $err, $info);

        $response = json_decode($response, true);
        if(
            ($response["error_code"] > ApiResponseCodes::OK) &&
            ($response["error_code"] < ApiResponseCodes::SYS_WARNING)
        )
            throw new ORException($response["message"]);

        return $response;
    }

    /**
     * @param BaseModels $mod
     * @param bool $debug
     * @return mixed
     * @throws ORException
     */
    protected function modelDelete(BaseModels $mod, bool $debug=false)
    {
        $curl       = curl_init();
        $argStr     = http_build_query(array("token" => $this->_ORApiToken) + $mod->getValues(true));

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_ORApiHost . "{$mod->getApiName(true)}/?$argStr",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE"
        ));

        $response   = curl_exec($curl);
        $err        = curl_error($curl);
        $info       = curl_getinfo($curl);
        curl_close($curl);

        if($debug)
            $this->debug($mod->getApiName(), $argStr, "DELETE", $response, $err, $info);

        $response = json_decode($response, true);
        if(
            ($response["error_code"] > ApiResponseCodes::OK) &&
            ($response["error_code"] < ApiResponseCodes::SYS_WARNING)
        )
            throw new ORException($response["message"]);

        return $response;
    }
    
    /**
     * @param $documentId
     * @param bool $dryRun
     * @param bool $debug
     * @return mixed
     * @throws ORException
     */
    protected function book($documentId, bool $dryRun=true, bool $debug=false)
    {
        $curl       = curl_init();
        $argStr     = http_build_query((array("token" => $this->_ORApiToken) + ["id" => $documentId]));

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->_ORApiHost . "ext/book/?$argStr",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => ($dryRun?"GET":"PUT"),
            CURLINFO_HEADER_OUT => $dryRun
        ]);

        $response   = curl_exec($curl);
        $err        = curl_error($curl);
        $info       = curl_getinfo($curl);
        curl_close($curl);

        if($debug)
        {
            $this->debug("ext/book", $argStr, ($dryRun?"GET":"PUT"), $response, $err, $info);
        }

        $response = json_decode($response, true);
        if(
            ($response["error_code"] > ApiResponseCodes::OK) &&
            ($response["error_code"] < ApiResponseCodes::SYS_WARNING)
        )
            throw new ORException($response["message"]);
        return $response;
    }

    /**
     * @throws ORException
     */
    private function login($userName, $password, $ledgersId, bool $debug=false)
    {
        $curl       = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_ORApiHost . "acc/token/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => ["userName" => $userName,
                                   "password" => $password,
                                   "ledgersId" => $ledgersId],
            CURLINFO_HEADER_OUT => true
        ));

        $response   = curl_exec($curl);
        $err        = curl_error($curl);
        $info       = curl_getinfo($curl);
        curl_close($curl);

        if($debug)
        {
            $this->debug("ext/login", "", "POST", $response, $err, $info);
        }

        $response = json_decode($response, true);
        if(
            ($response["error_code"] > ApiResponseCodes::OK) &&
            ($response["error_code"] < ApiResponseCodes::SYS_WARNING)
        )
            throw new ORException($response["message"]);
        return $response["token"];
    }


    /**
     * @param $api
     * @param $argStr
     * @param $restCmd
     * @param $response
     * @param $err
     * @param $info
     */
    private function debug($api, $argStr, $restCmd, $response, $err, $info=null)
    {
        if($err)
        {
            echo "Error $api: \n";
            print_r($err);
            echo "\n";
        }
        else
        {
            echo "\n\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n\n###################################\n";
            echo strtoupper("Debug $api $restCmd: \n");
            echo "###################################\n";
            echo "\nRequest:\n";
            echo "--------\n";
            if($restCmd == "POST")
            {
                echo "URL: " . $this->_ORApiHost . "$api/\n";
                print_r($argStr);
            }
            else
                print_r($this->_ORApiHost . "$api/?$argStr");
            if(($restCmd == "PUT") && (isset($response["updated"])))
            {
                $response["updated"] = ($response["updated"])?"true":"false";
            }
            echo "\n\n*****************\n";
            echo "\nResponse:\n";
            echo "--------\n";
            $responseArr            = json_decode($response, true);
            $responseArr["result"]  = ($responseArr["result"])?"true":"false";
            print_r($responseArr);
            if(isset($info))
            {
                echo "\n*****************\n";
                echo "\nInfo:\n";
                echo "-----\n";
                print_r($info);
            }
            echo "\n#################################\n";

        }
    }
}