<?php
  
  class DB{
    
    private $conn;
    
    function connect_db(){
      $hostname = ""; 
      $username = "";
      $password = "";
      $dbname = "";
      
      $this->conn = mysqli_connect($hostname, $username, $password, $dbname) or die("Unable to connect to MySQL");
    }

    function get_text_notes(){
      $sql = "select * from text_notes order by id desc";
      $result = mysqli_query($this->conn, $sql);
      
      $res = [];
      while ($row = mysqli_fetch_array($result)) {
        $res[] = $row;
      }
      
      return $res;
    }
    
    function save_text_note($text){
      $sql = "insert into text_notes(text) values('$text')";
      $result = mysqli_query($this->conn, $sql);
      if(!$result) die("Database insert error: " . mysqli_error($this->conn));
    }
    
    function get_files(){
      $sql = "select * from files order by id desc";
      $result = mysqli_query($this->conn, $sql);
      
      $res = [];
      while ($row = mysqli_fetch_array($result)) {
        $res[] = $row;
      }
      
      return $res;
    }
    
    function save_file_data($file_name, $dir_path){
      $file_path = '/' . $dir_path . '/' . $file_name;
      $file_size = filesize($_SERVER['DOCUMENT_ROOT'].$file_path);
      
      $sql = "insert into files(name, dir_path, size) values('$file_name', '$dir_path', '$file_size')";
      $result = mysqli_query($this->conn, $sql);
      if(!$result) die("Database insert error: " . mysqli_error($this->conn));
    }
    
    function update_file_size($file_id, $file_size){
      $sql = "update files set size='$file_size' where id='$file_id'";
      $result = mysqli_query($this->conn, $sql);
      if(!$result) die("Database insert error: " . mysqli_error($this->conn));
    }
    
    function delete_file($file_id){
      $sql = "delete from files where id='$file_id'";
      $result = mysqli_query($this->conn, $sql);
      if(!$result) die("Database insert error: " . mysqli_error($this->conn));
    }
    
    function close(){
      mysqli_close($this->conn);
    }
    
  }
  
?>