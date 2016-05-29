<?
	include "config.php";
	/**
	* 
	*/
	class tree_aplication
	{
		
		function __construct()
		{

			global $config;

			$this->dbh = new PDO('mysql:host=localhost;dbname='.$config['db_name'], $config['db_user'], $config['db_pass']);
			$this->dbh->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
			$sql = "CREATE TABLE wooden_plaque (
	    	id int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	    	element_name text NOT NULL,
	    	parent_id INT(6) 
	    	)";
	    	$this->dbh->exec($sql);
		}

		function event_controller(){
			if (isset($_POST['action'])) {
				switch ($_POST['action']) {
					case 'main_parent_wiev':
						$this->main_parent_wiev();
						break;
					case 'insert_new_object':
						$this->insert_new_object();
						break;
					case 'create_brench':
						$this->create_brench();
						break;
					default:
						# code...
						break;
				}
			}
			else{
				include "wiev.html";
			}
		}
		function main_parent_wiev(){
			$parent_array=array();
			$sql="SELECT * FROM `wooden_plaque` WHERE `parent_id`=0";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			while ($result = $sth->fetch(PDO::FETCH_ASSOC)) 
			{
				$parent_array[]=$result;
			}
			echo json_encode($parent_array);
		}
		function insert_new_object(){
			$new_object="INSERT INTO `wooden_plaque`(`element_name`, `parent_id`) VALUES ('".$_POST['name']."','".$_POST['parent_id']."')";
			$this->dbh->exec($new_object);
			echo $new_object;
		}
		function create_brench(){
			$parent_array=array();
			$sql="SELECT * FROM `wooden_plaque` WHERE `parent_id`='".$_POST['parent_id']."'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			while ($result = $sth->fetch(PDO::FETCH_ASSOC)) 
			{
				$parent_array[]=$result;
			}
			echo json_encode($parent_array);
		}
	}
?>