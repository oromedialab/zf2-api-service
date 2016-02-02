API Serives Library for Zend Framework 2
=============

API Services
* [Twilio](https://github.com/oromedialab/zf2-api-service#twilio-)

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
$twilio = $sm->get('Oml\Zf2ApiService\Twilio\SMS\Compose');
$sms = $twilio->init();
$sms->setTo('xxx-xxx-xxx');
$sms->setMessage('xxxx xxxx xxxx xxxx xxxx xxxxx');
$response = $sms->send();
// Get status
$response->status;
// Get message sid
$response->sid;
```

#### Message Template
You can reuse the message be defining templates in config file
```php

// Define template
return [
	'oml' => [
		'zf2-api-service' => [
			'templates' => [
				'registration-message' => 'Thank you for registering with us, we'll keep you posted with exciting offers'
			]
		]
	]
];

// Use template
$sm = $this->getServiceLocator();
$twilio = $sm->get('Oml\Zf2ApiService\Twilio\SMS\Compose');
$sms = $twilio->init();
$sms->setTo('xxx-xxx-xxx');
$sms->setTemplate('verification-message');
$response = $sms->send();
```

#### Template Placeholder
Placeholder allows you to dynamically replace value(s) in message templates, consider the following template
```php
// Define template
return [
	'oml' => [
		'zf2-api-service' => [
			'templates' => [
				'verification-message' => 'Your verfication code is %code% do not share this code with anyone for security reasons'
			]
		]
	]
];

// Replace placeholder and send message
$sm = $this->getServiceLocator();
$twilio = $sm->get('Oml\Zf2ApiService\Twilio\SMS\Compose');
$sms = $twilio->init();
$sms->setTo('+919916876761');
$sms->setTemplate('verification-message');
$sms->setPlaceholder('code', '7186');
$response = $sms->send();
```

In the message template, we have used `%code` as a placeholder, this value can be replaced using the method `setPlaceholder($name, $value)`. For example to replace the placeholder `%code` we can do it using `$sms->setPlaceholder('code', '7186')` it is important to note that while defining the placeholder we used '%' but while replacing we do not use this operator.
