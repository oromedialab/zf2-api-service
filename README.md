API Serives Library for Zend Framework 2
=============

Installation
------------

#### Install using composer
```
composer require oromedialab/zf2-api-service dev-master
```

#### Install using GIT clone
```
git clone https://github.com/oromedialab/zf2-api-service.git
```

#### Enable Zf2 Module
Enable the module by adding `Oml\Zf2ApiService` in your `config/application.config.php` file.

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
$sentMessageId = $sms->getMessageSid();
```
