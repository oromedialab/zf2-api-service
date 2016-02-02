<?php
/**
 * Module config file
 *
 * @author Ibrahim Azhar <azhar@iarmar.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

return [
	'service_manager' => [
        'invokables' => [
            'Oml\Zf2ApiService\Twilio\SMS\Compose' => 'Oml\Zf2ApiService\Service\Twilio\SMS\ComposeService',
        ],
    ],
	'oml' => [
		'zf2-api-service' => [
			'twilio' => [
				'account_sid' => null,
                'auth_token'  => null,
                'from' => null
			],
			'templates' => []
		]
	]
];
