<?php 


namespace Prog98rammer\Session;


class Session
{
	protected $_prefix;
	protected $_randomPrefix;
	protected $sessionId;
	protected $sessionKey;
	
	public function __construct($cacheExpire = 90, $cacheLimiter = 'private', $sessionPrefix = 'iq_framework_')
	{
		// set the cache limiter
		session_cache_limiter($cacheLimiter);

		// set the session cache expire
		session_cache_expire($cacheExpire);

		// start the session 
		session_start();

		// store the session id
		$this->id();

		// store the session prefix 
		$this->_prefix = $sessionPrefix;
	}

	public function status()
	{
		return session_status();
	}

	public function id()
	{
		$this->sessionId = session_id();
		return $this->sessionId;
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

	public function randomPrefix($length = 15)
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_$';
	    $charactersLength = strlen($characters);
	    $randomPrefix = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomPrefix .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $this->_prefix = $randomPrefix . '_';
	    return $this;
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