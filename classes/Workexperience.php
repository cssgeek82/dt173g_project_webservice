<?php 
/* Class to read, add, edit and delete "workexperience"
 --made by Lena Tibbling 2020 */

class Workexperience {
    
    //Connect to database
    public function __construct($db) {
        $this->db = $db->connect(); 
    }   

    //SQL-queries

    // Show all workexperiences
    public function readWorks() {   
        $sql = "SELECT * FROM workexperience ORDER BY datestart ASC"; 
        $result = $this->db->query($sql); 
        return mysqli_fetch_all($result, MYSQLI_ASSOC); 
    }

    // Show one work based on id
    public function readWork($id) {
        $sql= "SELECT * FROM workexperience WHERE id=$id";
        $result = $this->db->query($sql);
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    // Add new workexperience       
    public function createWork() {    
        $sql = "INSERT INTO workexperience(workplace, title, datestart, dateend) VALUES ('$this->workplace', '$this->title', '$this->datestart', '$this->dateend')";
        $result = $this->db->query($sql); 
        return $result;  
    }  
     
    //Update post  
    public function updateWork(int $id) {       
        $sql = "UPDATE workexperience SET workplace='$this->workplace', title='$this->title', datestart='$this->datestart', dateend='$this->dateend' WHERE id=$id";
        $result = $this->db->query($sql);
        return $result;  
    }  

    // Delete post
        public function deleteWork(int $id) {
            $sql = "DELETE FROM workexperience WHERE id=$id"; 
            $result = $this->db->query($sql); 
            return $result;
        }
}
?>