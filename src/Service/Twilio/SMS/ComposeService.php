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
     * Instance SMS\Compose Object
     *
     * @var Oml\PHPAPIService\Twilio\SMS\Compose
     */
    protected $sms;

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
        $this->sms = $sms;
        return $this;
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
     * Set placeholder value in template
     *
     * @param string $name (palceholder name)
     * @param string $value (valeu to be replaced)
     */
    public function setPlaceholder($name, $value)
    {
        if (!is_string($name)) {
            throw new \Exception(__NAMESPACE__.' : name must be of type "string", "'.gettype($name). '" given');
        }
        if (!is_string($value)) {
            throw new \Exception(__NAMESPACE__.' : value must be of type "string", "'.gettype($name). '" given');
        }
        $sms = $this->getSms();
        $message = str_replace('%'.$name.'%', $value, $sms->getMessage());
        $sms->setMessage($message);
        return $this;
    }

    /**
     * Replace SMS message with given template
     *
     * @param string $template (template name)
     * @return $this
     */
    public function setTemplate($template)
    {
        $sm = $this->getServiceLocator();
        $config = $sm->get('Config');
        if (!array_key_exists('oml', $config) || empty($config['oml'])) {
            throw new \Exception(__NAMESPACE__.' : undefined config [oml], refer documentation for more information');
        }
        $omlConfig = $config['oml'];
        if (!array_key_exists('zf2-api-service', $omlConfig) || empty($omlConfig['zf2-api-service'])) {
            throw new \Exception(__NAMESPACE__.' : undefined config [zf2-api-service], refer documentation for more information');
        }
        $zf2ApiServiceConfig = $omlConfig['zf2-api-service'];
        if (!array_key_exists('templates', $zf2ApiServiceConfig) || empty($zf2ApiServiceConfig['templates'])) {
            throw new \Exception(__NAMESPACE__.' : undefined config [templates], refer documentation for more information');
        }
        $templatesConfig = $zf2ApiServiceConfig['templates'];
        if (!array_key_exists($template, $templatesConfig) || empty($templatesConfig[$template])) {
            throw new \Exception(__NAMESPACE__.' : undefined template ['.$template.'], make sure template is defined in config file before using');
        }
        $templateMessage = $templatesConfig[$template];
        $this->getSms()->setMessage($templateMessage);
        return $this;
    }

    /**
     * Route non existent methods to Oml\PHPAPIService\Twilio\SMS\Compose
     *
     * @param string $name (method name)
     * @param array $args (method arguments)
     */
    public function __call($name, $args)
    {
        if (method_exists($this->getSms(), $name)) {
            call_user_func_array(array($this->getSms(), $name), array($args));
        }
        return $this;
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

    /**
     * Return SMS Instance
     *
     * @return Oml\PHPAPIService\Twilio\SMS\Compose
     */
    protected function getSms()
    {
        return $this->sms;
    }
}
