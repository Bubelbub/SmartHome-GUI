<?php

namespace Bubelbub\SmartHomeGUIBundle\Entity;

use Bubelbub\SmartHomePHP\Request\LoginRequest;
use Bubelbub\SmartHomePHP\SmartHome;
use Doctrine\ORM\Mapping as ORM;

/**
 * Central
 *
 * @ORM\Table("centrals")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @author Bubelbub <bubelbub@gmail.com>
 */
class Central
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string the name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string the hostname
     *
     * @ORM\Column(name="hostname", type="string", length=255)
     */
    private $hostname;

    /**
     * @var string the username for login
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string the password for login
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string the session id
     *
     * @ORM\Column(name="session_id", type="string", length=255, nullable=true)
     */
    private $sessionId;

    /**
     * @var string the version
     *
     * @ORM\Column(name="version", type="string", length=255, nullable=true)
     */
    private $version;

    /**
     * @var string the configuration version
     *
     * @ORM\Column(name="config_version", type="string", length=255, nullable=true)
     */
    private $configVersion;

	/**
	 * @var SmartHome
	 */
	private $smartHome = null;

	/**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Central
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set hostname
     *
     * @param string $hostname
     * @return Central
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * Get hostname
     *
     * @return string 
     */
    public function getHostname()
    {
	    $address = explode(':', $this->hostname);
        return $address[0];
    }

	/**
	 * Get port
	 *
	 * @return integer
	 */
	public function getPort()
	{
		$address = explode(':', $this->hostname);
		return count($address) != 2 || !is_numeric($address[1]) ? 443 : $address[1];
	}

    /**
     * Set username
     *
     * @param string $username
     * @return Central
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Central
     */
    public function setPassword($password, $isEncrypted = false)
    {
	    if($password == null || strlen($password) < 1)
	    {
		    return $this;
	    }

	    if(!$isEncrypted)
	    {
		    $password = LoginRequest::encrypt($password);
	    }

        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set sessionId
     *
     * @param string $sessionId
     * @return Central
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string 
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return Central
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set configVersion
     *
     * @param string $configVersion
     * @return Central
     */
    public function setConfigVersion($configVersion)
    {
        $this->configVersion = $configVersion;

        return $this;
    }

    /**
     * Get configVersion
     *
     * @return string 
     */
    public function getConfigVersion()
    {
        return $this->configVersion;
    }

	/**
	 * @param \Bubelbub\SmartHomePHP\SmartHome $smartHome
	 */
	public function setSmartHome($smartHome)
	{
		$this->smartHome = $smartHome;
	}

	/**
	 * @return \Bubelbub\SmartHomePHP\SmartHome|null
	 */
	public function getSmartHome()
	{
		if($this->smartHome === null)
		{
			try
			{
				$this->smartHome = new SmartHome($this->getHostname(), $this->getUsername(), $this->getPassword(), $this->getSessionId(), $this->getVersion(), $this->getConfigVersion());
				$this->smartHome->setIsPasswordEncrypted(true);
			}
			catch(\Exception $ex)
			{
				// Cant create SmartHome
			}
		}
		return $this->smartHome;
	}

	/**
	 * @return bool
	 */
	public function isOnline()
	{
		$online = @fsockopen($this->getHostname(), $this->getPort(), $errorNumber, $errorString, 10);
		@fclose($online);
		return $online !== false;
	}

	/**
	 * Get the things of SmartHome and save it here
	 *
	 * @ORM\PrePersist
	 * @ORM\PreUpdate
	 */
	public function setSmartHomeValues()
	{
		$smartHome = $this->getSmartHome();
		if($smartHome instanceof SmartHome)
		{
			$this->setSessionId($smartHome->getSessionId());
			$this->setVersion($smartHome->getVersion());
			$this->setConfigVersion($smartHome->getConfigVersion());
		}
	}
}
