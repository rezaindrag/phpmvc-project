<?php

/**
 * Core Class
 * 
 * Set the controller, method and params
 */
class Core {
	protected $currentController = 'Pages';
	protected $currentMethod = 'index';
	protected $params = [];
	
	/**
	 * __construct
	 *
	 * Set current controller, method and params
	 */
	public function __construct() {
		$url = $this->getUrl();

		// Set controller
		if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
			$this->currentController = ucwords($url[0]);
			unset($url[0]);
		}
		require_once '../app/controllers/' . $this->currentController . '.php'; 
		$this->currentController = new $this->currentController;

		// Set method
		if (isset($url[1])) {
			if (method_exists($this->currentController, $url[1])) {
				$this->currentMethod = $url[1];
				unset($url[1]);
			}
		}

		// Set params
		$this->params = $url ? array_values($url) : [];

		// Call a callback with an array of parameters
		call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
		/*
			Example:
			- call_user_func_array(['Blog', 'Category'], ['Reza', 'Indra']);
			- class Blog {
				function Category($fName, $lName) {
					echo $fName . ' ' . $lName; // Output: "Reza Indra"
				}
			  }
		*/
	}

	/**
	 * getUrl
	 *
	 * Get the value of url
	 */
	public function getUrl() {
		if (isset($_GET['url'])) {
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', $url);

			return $url;
		}
	}
}