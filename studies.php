<?php 

require 'classes/Database.php';
require 'classes/Studies.php';

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

$studies = new Studies($db); 

$method = $_SERVER['REQUEST_METHOD'];  

// Switch
switch($method) {
    // Read courses/programs
    case "GET":         
        if(isset($id)) {                        // If id exists 
            $result = $studies->readStudy($id);   // Read one from id
        } else {
            $result = $studies->readStudies();         // Read all 
        }

        if(sizeof($result) > 0) {               // If exists (bigger than 0)
            http_response_code(200);            // 200 = ok
        } else {                                // Else: If not exist 
            http_response_code(404);            // 404 = not found
            $result = array("message" => "Inga kurser/program hittades"); 
        }
    break; 

    // Write new course/program
    case 'POST':        
        $data = json_decode(file_get_contents("php://input"));
        $studies->university = $data->university;
        $studies->coursename = $data->coursename;
        $studies->startdate = $data->startdate;
        $studies->enddate = $data->enddate; 

        if($studies->createStudy()) {
            http_response_code(201);            //201 = created
            $result = array("message" => "En till kurs/program har lagts till!");
        } else {
            http_response_code(503);            // 503 = service unavailable
            $result = array("message" => "Kursen/programmet kunde inte läggas till.");
        }
    break;

    // Update one course/program
    case 'PUT':                                                     
        if(!isset($id)) {               // If no id
            http_response_code(510);
            $result = array("message" => "Inget id har skickats med");
        } else {                        // else = id sent
            $data = json_decode(file_get_contents("php://input"));           
            $studies->university = $data->university;
            $studies->coursename = $data->coursename;
            $studies->startdate = $data->startdate;
            $studies->enddate = $data->enddate; 

            if($studies->updateStudy($id)) {
                http_response_code(200);            // 200 = ok
                $result = array("message" => "Kursen/programmet är uppdaterat.");
            } else {
                http_response_code(503);            // 503 = service unavailable
                $result = array("message" => "Kursen/programmet kunde inte uppdateras."); 
            }
        }
    break; 

    // Delete one course/program
    case 'DELETE':       
        if(!isset($id)) {
            http_response_code(510);        // 510 = not extended
            $result = array("message" => "Inget id är medskickat.");
        } else {
            if($studies->deleteStudy($id)) {
                http_response_code(200);    // 200 = ok
                $result = array("message" => "Kursen har blivit raderad.");
            } else {
                http_response_code(503);    // 503 = service unavailable
                $result = array("message" => "Kursen kunde inte raderas.");
            }
        }
    break;        
}

echo json_encode($result);      // Return result as JSON

$db->close();       // Close database