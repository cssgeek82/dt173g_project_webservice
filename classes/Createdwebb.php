<?php 
/* Class to read, add, edit and delete webbpages from "createdwebb""
 --made by Lena Tibbling 2020 */

class Createdwebb {
    
    //Connect to database
    public function __construct($db) {
        $this->db = $db->connect(); 
    }   

    //SQL-queries

    // Show all webbpages
    public function readCreated() {   
        $sql = "SELECT * FROM createdwebb"; 
        $result = $this->db->query($sql); 
        return mysqli_fetch_all($result, MYSQLI_ASSOC); 
    }

    // Show one webbpage based on id
    public function readCreate($id) {
        $sql= "SELECT * FROM createdwebb WHERE id=$id";
        $result = $this->db->query($sql);
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    // Add new webbpages       
    public function createCreated() {    
 
        $sql = "INSERT INTO createdwebb(webbtitle, webburl, webbdesc, webbpicurl) VALUES ('$this->webbtitle', '$this->webburl', '$this->webbdesc', '$this->webbpicurl')";
        $result = $this->db->query($sql); 
        return $result;  
    }  
     
    //Update post  
    public function updateCreated(int $id) {       
        $sql = "UPDATE createdwebb SET webbtitle='$this->webbtitle', webburl='$this->webburl', webbdesc='$this->webbdesc', webbpicurl='$this->webbpicurl' WHERE id=$id";
        $result = $this->db->query($sql);
        return $result;  
    }  

    // Delete post
        public function deleteCreated(int $id) {
            $sql = "DELETE FROM createdwebb WHERE id=$id"; 
            $result = $this->db->query($sql); 
            return $result;
        }
}
?>