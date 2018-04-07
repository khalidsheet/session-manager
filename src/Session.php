<?php 


namespace Prog98rammer\Session;


class Session
{
	protected $_prefix = null;
	protected $sessionId;
	protected $sessionKey;
	protected $userEmail = [];
	protected $sessionsFromPrefix = [];
	protected $auth_prefix;
	protected $authToken;
	
	public function __construct($sessionPrefix = null, $cacheExpire = 90, $cacheLimiter = 'public')
	{
		// set the cache limiter.
		// nocache, private, private_no_expire, or public.
		session_cache_limiter($cacheLimiter);

		// set the session cache expire
		session_cache_expire($cacheExpire);

		// start the session 
		if(!isset($_SESSION))
			session_start();

		// store the session id
		$this->id();

		// store the session prefix 
		$this->_prefix = $sessionPrefix != null ? $sessionPrefix : $this->getPrefix();

		//$this->_prefix = is_null($sessionPrefix) ? $this->randomPrefix() : $sessionPrefix;
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

	public function prefix($prefix = 'app_')
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

	public function get($key, $prefix = null)
	{
		$prefix = !is_null($prefix) ? $prefix : $this->_prefix;

		$this->sessionKey = $_SESSION[$prefix.$key];
		return $this->sessionKey;
	}

	public static function has($key) {
		$session = (new self);
		return $session->search($key) != null ? true : false;
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

	public function fromPrefix($prefix)
	{
		foreach($this->all() as $key => $value)
	    {
	        if (strpos($key, $prefix) === 0)
	        {
	          	$this->sessionsFromPrefix[$key] = $value;
	        }
	    }

	    return $this->sessionsFromPrefix;
	}

	protected function search($key) {

		return $this->all()[$key];
	}

	public function destroy()
	{
		session_unset();
	}
}