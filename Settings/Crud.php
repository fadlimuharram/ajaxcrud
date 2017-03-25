<?php
namespace Settings;

class Crud extends Koneksi{

  public $kondisi;
  public $query = "";
  protected $setbindparam=[];//menampung untuk selanjutnya di lakukan bindparam

  public function select($data){
    $this->query = "SELECT " . $data;
    $this->kondisi="select";
    return $this;
  }

  public function from($table){
    $this->query .= " FROM " . $table;
    return $this;
  }

  public function where($str=array()){
    $this->query .= " WHERE ";

    foreach ($str as $keystr) {
      foreach ($keystr as $key => $value) {

          echo $value;
      
      }
    }
    $this->setbindparam = $str;
    return $this;
  }

  public function update($table){
    $this->query = "UPDATE ".$table;
    $this->kondisi = "update";
    return $this;
  }

  public function set($data=array()){
    $loop = 0;
    $this->query .= " SET ";

    foreach ($data as $key => $value) {
      $this->query .= $value . "=:" . $key;
      if ($loop<count($data)-1) {
        $this->query .= ",";
      }

      array_push($this->setbindparam,$value);
      $loop++;
    }

    return $this;

  }

  public function insert($table,$val=array(array())){
    $this->query = "INSERT INTO ".$table;
    $this->kondisi = "insert";

    $str = '';
    $loop1 = 0;
    $loop2 = 0;
    // menampung dinamis values ex : (?,?,?),(?,?,?)
    foreach ($val as $keyinsert) {
      $loop2 = 0;
      $str .= '(';
      foreach ($keyinsert as $key => $value) {
        $str .= '?';
        array_push($this->setbindparam,$value);
        if ($loop2<count($keyinsert)-1) {
          $str .= ',';
        }
        $loop2++;
      }

      $str .= ')';

      if ($loop1<count($val)-1) {
        $str .= ',';
      }
      $loop1++;

    }
    $this->query .= " VALUES" . $str;

    $this->setbindparam = $val;
    return $this;
  }


  //saat kondisi insert
  protected function kondisiinsert(){
    try {
      $stmt = $this->db->prepare($this->query);

      $loop = 1;
      foreach ($this->setbindparam as $keyinsert) {

        foreach ($keyinsert as $key => $value) {
          $stmt->bindValue($loop++,$value);
        }

      }
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return $e->getMessage();
      return false;
    }

  }


  protected function kondisiselect(){
    foreach ($this->setbindparam as $key => $value) {

    }
  }

  public function execute(){
    if ($this->kondisi=='select') {
      echo'<hr />';
      return $this->query;
    }elseif ($this->kondisi == 'update') {
      return $this->query;
    }elseif ($this->kondisi=='insert') {
      return $this->kondisiinsert();
    }

  }




}

 ?>
