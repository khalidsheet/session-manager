<?php 


namespace Prog98rammer\Session;


class Session
{
	public $_prefix;
	public $session_id;
	public $sessionKey;
	
	public function __construct($prefix = 'session_')
	{
		session_start();
		$this->id();
		$this->_prefix = $prefix;
	}

	public function id()
	{
		$this->session_id = session_id();
		return $this;
	}

	public function regenerate_id()
	{
		session_regenerate_id();
		$this->id();

		 return session_id();
	}

	public function prefix($prefix = 'iq_framework_')
	{
		if (is_string($prefix)) {
			$this->_prefix = $prefix;
			return $this;
		} else {
			throw new \Exception("Prefix {$prefix} must be a String", 1);
		}
	}

	public function getPrefix()
	{
		return $this->_prefix;
	}

	public function all()
	{
		return $_SESSION;
	}

	public function set($key, $value = null) {
		if (empty($key) && !isset($key)) {
			throw new \Exception("Key or Value cannot be empty", 1);
		}

		if (is_array($key)) {
			foreach($key as $arrayIndex => $arrayValue) {
				if (is_array($key[$arrayIndex])) {
					$_SESSION[$this->_prefix.$arrayIndex] = $key[$arrayIndex];
				} else {
					$_SESSION[$this->_prefix.$arrayIndex] = $key[$arrayIndex];
				}
			}
		} else {
			$_SESSION[$this->_prefix.$key] = $value;
		}

		return $this;
	}

	public function get($key)
	{
		$this->sessionKey = $_SESSION[$this->_prefix.$key];
		return $this->sessionKey;
	}



	public function remove(...$key) 
	{
		if (is_array($key)) {
			foreach ($key as $sessionKey => $value) {
				unset($_SESSION[$this->_prefix.$key[$sessionKey]]);
			}
		} else {
			unset($_SESSION[$this->_prefix.$key[$sessionKey]]);
		}
		
		return $this;
	}

	public function destroy()
	{
		session_unset();
	}
}