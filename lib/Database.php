<?php 

class Database{
    public $host = DB_HOST;
    public $user = DB_USER;
    public $pass = DB_PASS;
    public $dbname = DB_NAME;

    public $link;
    public $error;

    public function __construct(){
        $this->connectDB();
    }

	private function connectDB(){
        $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if(!$this->link){
            $this->error ="Connection fail".$this->link->connect_error;
            return false;
        }
     }

    //  data select / read

    public function select($query){
        $result = $this->link->query($query) or die ($this->link->error.__LINE__);
        if($result->num_rows > 0){
            return $result;
        }else{
            return false;
        }
    }

    public function insert($query){
        $insert_row = $this->link->query($query) or die ($this->link->error.__LINE__);
        if($insert_row){
            // header("Location: index.php?msg=".urlencode('Data insert successfully'));
            // exit();
            return $insert_row;
        }else{
            // die("Error :(".$this->link->errno.")".$this->link->error);
            return false;
        }
    }

    public function update($query){
        $update_row = $this->link->query($query) or die ($this->link->error.__LINE__);
        if($update_row){
            // header("Location: index.php?msg=".urlencode('Data update successfully'));
            // exit();
            return $update_row;
        }else{
            // die("Error :(".$this->link->errno.")".$this->link->error);
            return false;
        }
    }

    public function delete($query){
        $delete_row = $this->link->query($query) or die ($this->link->error.__LINE__);

        if($delete_row){
            return $delete_row;
        }else{
            return false;
        }
    }

    // public function update($query){
    //     $update_row = $this->link->query($query) or die ($this->link->error.__LINE__);

    //     if($update_row){
    //         // header("Location: index.php?msg=".urlencode('Data Updated'));
    //         // exit();
    //         return $update_row;
    //     }else{
    //         // die("Error :(".$this->link->errno.")".$this->link->error);
    //         return false; 
    //     }
    // }
}

// ABdur rahman alom + Najmin jahan lupa + Muhasanah Jamila Binte Abdur Rahman ALom 
// Zakir husssain Selim + Tahmina AKter Tamanna
// Delowar hossain monju + RImjhim bristy
// Moynul hosain Akter + Maleha momtaz dina