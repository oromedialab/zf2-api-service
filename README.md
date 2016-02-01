API Serives Library for Zend Framework 2
=============

Twilio 
------
URL : (http://twilio.com/)

#### Compose SMS

Define config
```php
return [
	'oml' => [
		'zf2-api-service' => [
			'twilio' => [
				'account_sid' => 'xxx-xxx-xxx',
				'auth_token'  => 'xxx-xxx-xxx',
				'from' => 'xxx-xxx-xxx'
			]
		]
	]
];
```
Send SMS using service manager

```php
// Init service manager
$sm = $this->getServiceLocator();
// Init SMS\Compose
$sms = $sm->get('Oml\Zf2ApiService\Twilio\SMS\Compose')->init();
// Set From
$sms->setTo('+919916876761');
// Set Message
$sms->setMessage('Lorem ipsum dolor sit amet, consectetur adipisicing elit.');
// Send Message
if($sms->send()) {
	// Get sent message id
    echo $sms->getMessageSid();
}
```
