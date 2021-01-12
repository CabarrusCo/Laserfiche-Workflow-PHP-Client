<?php

    class LFWorkflowParameters {
        private $parameterCollection;

        public function __construct() {
            $this->parameterCollection = ["ParameterCollection" => []];
        }

        public function addParameter(string $name, $value) {
            $parameterArray = ["Name" => $name, "Value" => $value];
            $this->parameterCollection["ParameterCollection"][] = $parameterArray;
        }

        public function generateParameters() {
            return $this->parameterCollection;
        }
    }

    class LaserficheWorkflowClient {
        private $workflowURL;
        private $username;
        private $password;
        private $domain;

        public function __construct($workflowURL, $username="", $password="", $domain="") {

            if($username !== "" || $password !== "" || $domain !== "") {

                if($username === "") {
                    throw new Exception("Username parameter is blank but other login information provided");
                }

                if($password === "") {
                    throw new Exception("Password parameter is blank but other login information provided");
                }

                if($domain === "") {
                    throw new Exception("Domain is blank but other login information provided");
                }
            }

            $this->workflowURL = $workflowURL;
            $this->username = $username;
            $this->password = $password;
            $this->domain = $domain;
        }

        private function performCURLRequest(string $url, array $headers, string $data="", bool $curlPOST=false) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            if($curlPOST === true) {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if($this->username !== "" && $this->password !== "" && $this->domain !== "") {
                $fullLogin = "$this->domain\\$this->username:$this->password";
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
                curl_setopt($ch, CURLOPT_USERPWD, $fullLogin);
            }

            $output = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if($statusCode !== 200) {
                throw new Exception("Unable to complete request successfully, received HTTP status code $statusCode");
            }

            $outputReturn = json_decode($output, true);
            return $outputReturn;
        }

        public function startWorkflow(string $workflowName, array $data=[], bool $queue=false) {
            $workflowNameEncoded = rawurlencode($workflowName);
            $fullWorkflowURL = "$this->workflowURL/Workflow/api/instances/$workflowNameEncoded";

            if($queue === true) {
                $fullWorkflowURL = "$this->workflowURL/Workflow/api/instances/queue/$workflowNameEncoded";
            }

            $data = json_encode($data);
            $headers = array("Content-Type: application/json", "Content-Length: ". strlen($data), "Accept: application/json");
            return $this->performCURLRequest($fullWorkflowURL, $headers, $data, true);
        }

        public function retrieveWorkflows() {
            $fullWorkflowURL = "$this->workflowURL/Workflow/api/workflow";
            $headers = array("Content-Type: application/json", "Accept: application/json");
            return $this->performCURLRequest($fullWorkflowURL,$headers);
        }

        public function retrieveWorkflowParameters(string $workflowName) {
            $workflowNameEncoded = rawurlencode($workflowName);
            $fullWorkflowURL = "$this->workflowURL/Workflow/api/workflow/parameters/$workflowNameEncoded";
            $headers = array("Content-Type: application/json", "Accept: application/json");
            return $this->performCURLRequest($fullWorkflowURL,$headers);
        }
    }
