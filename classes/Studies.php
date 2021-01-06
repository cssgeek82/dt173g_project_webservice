<?php 
/* Class to read, add, edit and delete courses/programs from "studies"
 --made by Lena Tibbling 2020 */

class Studies {
    
    //Connect to database
    public function __construct($db) {
        $this->db = $db->connect(); 
    }   

    //SQL-queries

    // Show all courses/programs
    public function readStudies() {   
        $sql = "SELECT * FROM studies ORDER BY startdate ASC"; 
        $result = $this->db->query($sql); 
        return mysqli_fetch_all($result, MYSQLI_ASSOC); 
    }

    // Show one course/program based on id
    public function readStudy($id) {
        $sql= "SELECT * FROM studies WHERE id=$id";
        $result = $this->db->query($sql);
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    // Add new course/program       
    public function createStudy() {    
 
        $sql = "INSERT INTO studies(university, coursename, startdate, enddate) VALUES ('$this->university', '$this->coursename', '$this->startdate', '$this->enddate')";
        $result = $this->db->query($sql); 
        return $result;  
    }  
     
    //Update post  
    public function updateStudy(int $id) {       
        $sql = "UPDATE studies SET university='$this->university', coursename='$this->coursename', startdate='$this->startdate', enddate='$this->enddate' WHERE id=$id";
        $result = $this->db->query($sql);
        return $result;  
    }  

    // Delete course/program
        public function deleteStudy(int $id) {
            $sql = "DELETE FROM studies WHERE id=$id"; 
            $result = $this->db->query($sql); 
            return $result;
        }
}
?>