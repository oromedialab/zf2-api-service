API Serives Library for Zend Framework 2
=============

Twilio 
------
URL : (http://twilio.com/)

#### Compose SMS
```php
// Define config in your config file
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
// Init Twilio\SMS\Compose service to send message
$sm = $this->getServiceLocator();
$sms = $sm->get('Oml\Zf2ApiService\Twilio\SMS\Compose')->init();
$sms->setTo('xxx-xxx-xxx');
$sms->setMessage('xxxx xxxx xxxx xxxx xxxx xxxxx');
$sms->send()
// Get sent message id
$sms->getMessageSid();
```
