<?php 

require 'classes/Database.php';
require 'classes/Createdwebb.php';

// Headers to make webservice avaliable from all domains
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 

// Check if id as param is in the url
if(isset($_GET['id'])) {            
    $id = $_GET['id']; 
}

// Connection to database -calls class Database in Database.php
$db = new Database();

$webb = new Createdwebb($db); 

$method = $_SERVER['REQUEST_METHOD'];  

// Switch
switch($method) {
    // Read webbpage-posts
    case "GET":         
        if(isset($id)) {                        // If id exists 
            $result = $webb->readCreate($id);   // Read one from id
        } else {
            $result = $webb->readCreated();         // Read all 
        }

        if(sizeof($result) > 0) {               // If exists (bigger than 0)
            http_response_code(200);            // 200 = ok
        } else {                                // Else: If not exist 
            http_response_code(404);            // 404 = not found
            $result = array("message" => "Inga webbplatser hittades"); 
        }
    break; 

    // Write new webbpages-post
    case 'POST':        
        $data = json_decode(file_get_contents("php://input"));
        $webb->webbtitle = $data->webbtitle;
        $webb->webburl = $data->webburl;
        $webb->webbdesc = $data->webbdesc;
        $webb->webbpicurl = $data->webbpicurl; 

        if($webb->createCreated()) { 
            http_response_code(201);            //201 = created
            $result = array("message" => "En till webbplats har lagts till!");
        } else {
            http_response_code(503);            // 503 = service unavailable
            $result = array("message" => "Webbplatsen kunde inte läggas till.");
        }
    break;

    // Update one webbpage-post
    case 'PUT':                                                     
        if(!isset($id)) {               // If no id
            http_response_code(510);
            $result = array("message" => "Inget id har skickats med");
        } else {                        // else = id sent
            $data = json_decode(file_get_contents("php://input"));           
            $webb->webbtitle = $data->webbtitle;
            $webb->webburl = $data->webburl;
            $webb->webbdesc = $data->webbdesc;
            $webb->webbpicurl = $data->webbpicurl; 

            if($webb->updateCreated($id)) {
                http_response_code(200);            // 200 = ok
                $result = array("message" => "Webbplatsen är uppdaterat.");
            } else {
                http_response_code(503);            // 503 = service unavailable
                $result = array("message" => "Webbplatsen kunde inte uppdateras."); 
            }
        }
    break; 

    // Delete one webbpage-post
    case 'DELETE':       
        if(!isset($id)) {
            http_response_code(510);        // 510 = not extended
            $result = array("message" => "Inget id är medskickat.");
        } else {
            if($webb->deleteCreated($id)) {
                http_response_code(200);    // 200 = ok
                $result = array("message" => "Webbplatsen har blivit raderad.");
            } else {
                http_response_code(503);    // 503 = service unavailable
                $result = array("message" => "Webbplatsen kunde inte raderas.");
            }
        }
    break;        
}

echo json_encode($result);      // Return result as JSON

$db->close();       // Close database