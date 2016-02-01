<?php
/**
 * Manages module service
 *
 * @author Ibrahim Azhar <azhar@iarmar.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace Oml\Zf2ApiService\Service\Twilio\SMS;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Oml\PHPAPIService\Twilio\SMS;

class ComposeService implements ServiceLocatorAwareInterface
{
    /**
     * Instance of service manager
     *
     * @var Zend\ServiceManager\ServiceManager
     */
    protected $serviceLocator;

    /**
     * Init SMS\Compose
     *
     * @return Oml\PHPAPIService\Twilio\SMS\Compose
     */
    public function init()
    {
        $config = $this->config();
        $sms = new SMS\Compose($config['account_sid'], $config['auth_token']);
        $sms->setFrom($config['from']);
        return $sms;
    }

    /**
     * Get module config
     *
     * @return array
     */
    protected function config()
    {
        $sm = $this->getServiceLocator();
        $config = $sm->get('Config');
        $twilioConfig = array();
        if (!array_key_exists('oml', $config) || empty($config['oml'])) {
            throw new \Exception(__NAMESPACE__.' : undefined config [oml], refer documentation for more information');
        }
        $omlConfig = $config['oml'];
        if (!array_key_exists('zf2-api-service', $omlConfig) || empty($omlConfig['zf2-api-service'])) {
            throw new \Exception(__NAMESPACE__.' : undefined config [zf2-api-service], refer documentation for more information');
        }
        $zf2ApiServiceConfig = $omlConfig['zf2-api-service'];
        if (!array_key_exists('twilio', $zf2ApiServiceConfig) || empty($zf2ApiServiceConfig['twilio'])) {
            throw new \Exception(__NAMESPACE__.' : undefined config [twilio], refer documentation for more information');
        }
        $twilioConfig = $zf2ApiServiceConfig['twilio'];
        foreach (array('account_sid', 'auth_token', 'from') as $param) {
            // Validate not empty
            if (empty($twilioConfig[$param])) {
                throw new \Exception(__NAMESPACE__.' : '.$param.' is required in {$config[oml][zf2-api-service][twilio]['.$param.']}');
            }
            // Validate data type
            if (!is_string($twilioConfig[$param])) {
                throw new \Exception(
                    __NAMESPACE__.' : '.$param.' must be of type "string" in {$config[oml][zf2-api-service][twilio]['.$param.']}, "'.
                    gettype($twilioConfig[$param]).'" given'
                );
            }
        }
        return $twilioConfig;
    }

    /**
     * Method applied from ServiceLocatorAwareInterface, required to inject service locator object
     *
     * @param ServiceLocatorInterface $sl
     * @return $this
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * Method applied from ServiceLocatorAwareInterface, required to retreive service locator object
     *
     * @return Zend\ServiceManager\ServiceManager
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
