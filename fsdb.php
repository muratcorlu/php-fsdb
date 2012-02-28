<?php

class fsdb {
	
	private $db_path;
	
	function __construct($path='db') {
		$this->db_path = __DIR__ . DIRECTORY_SEPERATOR . trim($path, DIRECTORY_SEPERATOR);
	}
	
	/**
	 * get data from a collection by given id
	 */
	function get($collection, $id) {
	    $file = $this->db_path . DIRECTORY_SEPERATOR . $collection . DIRECTORY_SEPERATOR . "$id.txt";
	    if (! is_file($file) ) {
	        return false;
	    }
	    return unserialize(file_get_contents($file));
	}
		
	function list($collection, $offset=0, $size=10) {
	    
	} 
	
	function save($collection, $data) {
	    $id = is_exist($data['id']) ? $data['id'] : $this->get_next_id( $collection );
	    $data['id'] = $id;
	    
	    $folder = $this->db_path . DIRECTORY_SEPERATOR . $collection;
	    if (! is_dir($folder) ) {
	        mkdir( $folder );
	    }
	    
	    
	    $file = $folder . DIRECTORY_SEPERATOR . "$id.txt";
	    
	    return file_put_contents($file, serialize($data));
	    
	}
	
	function delete($collection, $id) {
	    
	}
	
}