<?php
/**
 * URL generator, mi crea un url HASH univoco
 * @version 0.1
 * @author Saverio
 */
class UrlGenerator{
    protected $_baseUrl;
    protected $_scheme;
    protected $_path;
    protected $_algo;
    protected $_timeLife;
    protected $_hash_url;
    protected $_salt;
    
    public function __construct($scheme,$host,$baseUrl,$path,$algo = null){
        $this->_baseUrl = $baseUrl;
        $this->_scheme = $scheme;
        $this->_host = $host;
        $this->_path = $path;
        $this->_algo = ($algo == null) ? 'crc32b' : $algo;
        $this->_timeLife = $this->_hash_url = null;
        $this->salt = base64_encode(mcrypt_create_iv(ceil(0.75*5), MCRYPT_DEV_URANDOM));
    }
    
    /**
     * Generatore URL univoco
     * @param [optional] $baseUrl
     * @param [optional] $path
     * @return string url convertito
     */
	public function urlGenerator($scheme=null,$host=null,$baseUrl=null,$path=null){
	    $bu = ($baseUrl == null) ? $this->_baseUrl : $baseUrl;
	    $h = ($host == null) ? $this->_host : $host;
	    $p = ($path == null) ? $this->_path : $path;
	    $s = ($scheme == null) ? $this->_scheme : $scheme;
	    $this->_hash_url = $s.'://'.$h.'/'.$bu.'/'.hash($this->_algo, $p.$this->salt);
	    return  $this->_hash_url;
	}
	
	/**
	 * Generatore dle tempo di vita per l'url
	 * @param int $hour ore di vita per l'url
	 * @return timestamp
	 */
	public function timeLifeGenerator($hour){
	    $dateTime = new DateTime();
	    $dateTime->add(new DateInterval('PT'.$hour.'H')); // + $hour
	    $this->_timeLife = $dateTime->getTimestamp();
	    return $this->_timeLife;
	}
}

?>