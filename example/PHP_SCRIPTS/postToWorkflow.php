<?php
    REQUIRE "WorkflowClient.php";

    header('Content-Type: application/json');

    if($_POST["userDecision"] !== "YES" && $_POST["userDecision"] !== "NO" && $_POST["userDecision"] !== "MAYBE") {
        http_response_code(400);
        exit;
    }

    if(strlen($_POST["userReason"]) === 0) {
        http_response_code(400);
        exit;
    }

    $workflowClient = new LaserficheWorkflowClient("https://myworkflowurl", "myusername", "mypassword", "mydomain");
    $parameterCollection = new LFWorkflowParameters();

    $parameterCollection->addParameter("Decision", $_POST["userDecision"]);
    $parameterCollection->addParameter("Reason", $_POST["userReason"]);

    $postData = $parameterCollection->generateParameters();

    $workflowResponse = $workflowClient->startWorkflow("Workflow Name", $postData);
    echo json_encode($workflowResponse);


