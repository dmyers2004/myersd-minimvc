<?php 

class Mockapp {

	public function __construct($raw_uri,$raw_request) {
		$this->uri = $this->raw_uri = $raw_uri;
		$this->request = $this->raw_request = $raw_request;
	}
	
} /* end Mockapp */
