<?php

return [

	'version' => '2.6.7',

	'api_base_url' => 'http://dedicatedresource.net/api/v2/',

	'defaults' => [

		'exchange' => [

			'sale_comm_rate' => 1000,
			'purchase_comm_rate' => 1000,
			'customer_ref_comm_rate' => 1000,
			'merchant_ref_comm_rate' => 1000,
			'customer_sale_comm_rate' => 1000,
			'merchant_sale_comm_rate' => 1000,
			'giftcard_comm_rate' => 1000,
			'use_giftcards' => true,
			'member_accept_giftcards' => true,
			'min_cra_deposit' => 5000,
		],
	],

	'billing' => [

		'gateway' => [
			
			'accounts' => [

				'225trade' => [
					'id' => '1092139',
					'key' => '1k8hV6VMWCJm',
					'production' => true,
				],

				'504trade' => [
					'id' => '1086146',
					'key' => 'UvZJBD2ZwNlm',
					'production' => true,
				],

				'713trade' => [
					'id' => '1086439',
					'key' => 'kgWPxrfZp/i/',
					'production' => true,
				],

				'985trade' => [
					'id' => '1086145',
					'key' => 'ozHQ21tp7yeq',
					'production' => true,
				],

				'337la' => [
					'id' => '1090381',
					'key' => 'wBt8zTZTzcJt',
					'production' => true,
				],
				
				'sandbox' => [
					'id' => '8003652',
					'key' => 'XLGL3G5IkZGp',
				],

			],

			'url' => [
				'development' => 'https://gwapi.demo.securenet.com/api/',
				'production' => 'https://gwapi.securenet.com/api/',
			],
		],
		
	],

	'communication' => [

		'mailchimp' => [
			
			'225trade' => [
				
				'apikey' => '32a9521abce00da12facb843cc21d07b-us10',

				'activeNewsletterIds' => ['42dce6df3d'],

			],

			// '504trade' => [
				
			// 	'apikey' => '32a9521abce00da12facb843cc21d07b-us10',

			// 	'activeNewsletterIds' => [],

			// ],

			'713trade' => [
				
				'apikey' => 'c2e39cf2d3df2f31d4600ddf9d3567af-us13',

				'activeNewsletterIds' => ['5e6de1cf40'],

			],

			'985trade' => [
				
				'apikey' => 'd77706693b82a77504679049f12b84fe-us12',

				'activeNewsletterIds' => ['c92e96f9e3'],

			],

			'337la' => [
				
				'apikey' => '043763e1d70ac4bdcca33da754ed8e74-us13',

				'activeNewsletterIds' => ['bf707b25b3'],

			],

		],

		'texter' => [
			
			'225trade' => [
				
				'sid' => 'AC31f81ce2947559d179a6dbbcb24f78f1',

				'authToken' => 'd1b267974485f850d19b04fd401b1702',

				'number' => '+12253721160',
			],

			'504trade' => [
				
				'sid' => 'AC8f1a73eb92334f7ae714e59aa2676fc3',

				'authToken' => 'ac8085cc453c142caac036e8beba2fc9',

				'number' => '+19852008600',
			],

			'713trade' => [
				
				'sid' => 'AC31f81ce2947559d179a6dbbcb24f78f1',

				'authToken' => 'd1b267974485f850d19b04fd401b1702',

				'number' => '+12253721160',
			],

			'985trade' => [
				
				'sid' => 'AC3dc7e7833c4b3dc645f215800a8e9f0a',

				'authToken' => '1924cb9a74b942a2568b2f780eec1c6c',

				'number' => '+19852008551',
			],

			'337la' => [
				
				'sid' => 'AC31f81ce2947559d179a6dbbcb24f78f1',

				'authToken' => 'd1b267974485f850d19b04fd401b1702',

				'number' => '+12253721160',
			],

		],
		
	],

];
