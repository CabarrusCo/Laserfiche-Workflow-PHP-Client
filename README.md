# Laserfiche-Workflow-PHP-Client

### About Cabarrus County
---
Cabarrus is an ever-growing county in the southcentral area of North Carolina. Cabarrus is part of the Charlotte/Concord/Gastonia NC-SC Metropolitan Statistical Area and has a population of about 210,000. Cabarrus is known for its rich stock car racing history and is home to Reed Gold Mine, the site of the first documented commercial gold find in the United States.

### About our team
---
The Business & Location Innovative Services (BLIS) team for Cabarrus County consists of five members:

+ Joseph Battinelli - Team Supervisor
+ Mark McIntyre - Software Developer
+ Landon Patterson - Software Developer
+ Brittany Yoder - Software Developer
+ Marci Jones - Software Developer
+ Jared Poe - GIS Analyst

Our team is responsible for software development and support for the [County](https://www.cabarruscounty.us/departments/information-technology). We work under the direction of the Chief Information Officer.

### About
---
This is a minimalistic PHP class for the Laserfiche Workflow API.

### Download the file
---
No Composer needed. This class comes as a stand alone file. Download it however you perfer and put it in your PHP project.

### Spin up a new instance
---
Require the file in your PHP file using this syntax.

```
REQUIRE "myClassDir/LaserficheWorkflowClient.php";
```
From there, spin up a new instance. Instance will have ONE required field and three optional fields. If your Workflow server is setup for NTLM auth then you will need to provide the Username, Password, and Domain.

```
//Without NTLM Auth

$workflowClient = new LaserficheWorkflowClient("https://myworkflowserver");

```

```
//With NTLM Auth

$workflowClient = new LaserficheWorkflowClient("https://myworkflowserver", "XXXXXX", "XXXXXX", "XXXXXX");
```

### Starting a Workflow
---
Workflows can be Started programatically via the Client. The Workflow can either be CREATED or QUEUED. If the endpoint gives a successful 200 back, then the Client will return an Array from the Response given by Laserfiche, otherwise an exception will be thrown. 

If you wish to queue the workflow instead of directly creating the Workflow, then true must be passed for the last parameter.

```
<?php
    // Example # 1 for starting a workflow-- NTLM Auth, CREATE(No queue), WITH data

    REQUIRE "MyClassPath/LaserficheWorkflowClient.php";

    $workflowClient = new LaserficheWorkflowClient("https://myworkflowserver", "myusername", "mypassword", "mydomain");
    $data = ["ParameterCollection" => [["Name" => "Message","Value" => "Hello World!"]]];

    $workflowStatus = $workflowClient->startWorkflow("My Workflow Name Here", $data);
    print_r($workflowStatus);
```

```
<?php
    //Example #2 for starting a workflow -- No NTLM Auth, CREATE(No queue), NO Data
    
    REQUIRE "MyClassPath/LaserficheWorkflowClient.php";

    $workflowClient = new LaserficheWorkflowClient("https://myworkflowserver");
    
    $workflowStatus = $workflowClient->startWorkflow("My Workflow Name Here");
    print_r($workflowStatus);
```

```
<?php
    //Example #3 for starting a workflow -- NTLM Auth, CREATE(With queue), Data
    
    <?php

    REQUIRE "MyClassPath/LaserficheWorkflowClient.php";

    $workflowClient = new LaserficheWorkflowClient("https://myworkflowserver", "myusername", "mypassword", "mydomain");
    $data = ["ParameterCollection" => [["Name" => "Message","Value" => "Hello World!"]]];

    $workflowStatus = $workflowClient->startWorkflow("My Workflow Name Here", $data, true);
    print_r($workflowStatus);
 ```
 
  ### Retrieve Workflows
---
Workflows can be retrieved from the server using the Retrieve Workflows Endpoint. Examples below.

```
<?php
    //Example 1- Retrieve Workflows with NTLM Auth

    REQUIRE "MyClassPath/LaserficheWorkflowClient.php";

    $workflowClient = new LaserficheWorkflowClient("https://myworkflowserver", "myusername", "mypassword", "mydomain");
    $workflowStatus = $workflowClient->retrieveWorkflows();
    echo json_encode($workflowStatus); // OR print_r for array

```

```
<?php
    //Example 2- Retrieve Workflows No NTLM Auth

    REQUIRE "MyClassPath/LaserficheWorkflowClient.php";

    $workflowClient = new LaserficheWorkflowClient("https://myworkflowserver");
    $workflowStatus = $workflowClient->retrieveWorkflows();
    echo json_encode($workflowStatus); // OR print_r for array
```

### Retrieve Workflow Parameters
---

You can also use the Client to grab the Input and Output Parameters a Workflow takes.

```
<?php
    //Example 1- Retrieve Workflows Parameters with NTLM Auth
    
    REQUIRE "MyClassPath/LaserficheWorkflowClient.php";

    $workflowClient = new LaserficheWorkflowClient("https://myworkflowserver", "myusername", "mypassword", "mydomain");

    $workflowParams = $workflowClient->retrieveWorkflowParameters("My Workflow Name");
    echo json_encode($workflowParams); // OR print_r for array
```

```
<?php
    //Example 2- Retrieve Workflows Parameters no NTLM Auth
    
    REQUIRE "MyClassPath/LaserficheWorkflowClient.php";

    $workflowClient = new LaserficheWorkflowClient("https://myworkflowserver");

    $workflowParams = $workflowClient->retrieveWorkflowParameters("My Workflow Name");
    echo json_encode($workflowParams); // OR print_r for array
```
