<?php

class fsdb {
	
	private $db_path;
	
	function __construct($path='db') {
		$this->db_path = __DIR__ . DIRECTORY_SEPARATOR . trim($path, DIRECTORY_SEPARATOR);
		if (! is_dir($this->db_path) ) {
	        mkdir( $this->db_path );
	    }
	}
	
	/**
	 * get data from a collection by given id
	 */
	function get($collection, $id) {
	    $file = $this->db_path . DIRECTORY_SEPARATOR . $collection . DIRECTORY_SEPARATOR . "$id.txt";
	    if (! is_file($file) ) {
	        return false;
	    }
	    return unserialize(file_get_contents($file));
	}
		
	function select($collection, $offset=0, $size=10) {
	    $file_list = explode("\n", shell_exec('ls -l -C1 ' . $this->db_path . DIRECTORY_SEPARATOR . $collection.DIRECTORY_SEPARATOR . '*.txt'));
		$result =  array_slice($file_list, $offset, $size);

		$response = array();
		foreach($result as $row){
			if (!empty($row)){
				array_push($response, basename($row, '.txt'));
			}
		}
			
		return $response;
	} 
	
	function save($collection, $data) {
		$folder = $this->db_path . DIRECTORY_SEPARATOR . $collection;
	    if (! is_dir($folder) ) {
	        mkdir( $folder );
	    }

		if (!isset($data['id'])){
			$data['id'] = $this->generate_id($collection);
		}
	    $id = $data['id'];
	
	    $file = $folder . DIRECTORY_SEPARATOR . "$id.txt";
	
	    return file_put_contents($file, serialize($data)) === false ? false : $id;
	    
	}
	
	function delete($collection, $id) {
	    
    }

	private function generate_id( $collection ){
		$file = $this->db_path . DIRECTORY_SEPARATOR . $collection . DIRECTORY_SEPARATOR;
		$current_time =	date('Ymdhis');
		$iteration = 0;
		while(is_file($file . $current_time . $iteration . '.txt')){
			$iteration++;
		}
		
		return $current_time . $iteration;
	}
	
}