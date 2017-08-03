<?php 
/**
 * DB
 *
 * @package default
 * @author 
 **/
date_default_timezone_set('Asia/Shanghai'); 
chdir(dirname(__FILE__));
class DB_class{
	private $conn;
	private $table;
	public function __construct(){
		require('db_config.php');
		$this->conn = new mysqli($db_host,$db_user,$db_password,$db_name);
		$this->conn->query('set names utf8');
	}

	public function query($sql){
		return $this->conn->query($sql);
	}

	public function setTable($table){
		$this->table = $table;
	}

	public function fetch($sql){
		return $this->fetch_all($sql);
	}

	public function find_all($where=''){
		$sql = 'select * from '.$this->table.' '.$where;
		return $this->fetch_all($sql);
	}

	public function find($key,$where){
		$sql = 'select '.$key.' from '.$this->table.' '.$where;
		return $this->fetch_all($sql);
	}

	public function fetch_all($sql)
	{
		$result = $this->query($sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function add($data){
		$i = 0;
		$sql = 'insert into '.$this->table.' (';
		foreach ($data as $key => $value) {
			$keys[$i] = $key;
			$values[$i] = $value;
			$i++;
		}
		foreach ($keys as $value) {
			$sql .= $value.',';
		}
		$sql = substr($sql, 0,-1);
		$sql .= ')values(';

		foreach ($values as $value) {
			$sql .= '"'.$value.'",';
		}
		$sql = substr($sql, 0,-1);
		$sql .= ')';
		return $this->query($sql);
	}

	public function save($data,$where){
		$sql = 'update '.$this->table.' set ';
		foreach ($data as $key => $value) {
			$sql .= $key.'="'.$value.'", ';
		}
		$sql = substr($sql, 0,-2);
		$sql .= ' where '.$where;
		return $this->query($sql);
	}

	public function delete($where){
		$sql = 'delete from '.$this->table.$where;
		return $this->query($sql);
	}
}
?>