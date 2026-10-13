<?php

declare(strict_types=1);

return [
	[
		'core/columns',
		[],
		[
			[
				'core/column',
				['width' => '66.66%'],
				[
					[
						'core/paragraph',
						[
							'placeholder' => __('Veranstaltung beschreiben...', 'gmu'),
						],
					],
				],
			],
			[
				'core/column',
				['width' => '33.33%'],
				[
					[
						'ctx-events/details',
						[],
						[
							['ctx-events/details-audience', []],
							['ctx-events/details-date', []],
							['ctx-events/details-time', []],
							['ctx-events/details-person', []],
							['ctx-events/details-location', []],
							['ctx-events/details-price', []],
							['ctx-events/details-spaces', []],
							['ctx-events/details-shutdown', []],
						],
					],
					[
						'core/group',
						[
							'layout' => [
								'type' => 'flex',
								'flexWrap' => 'nowrap',
								'justifyContent' => 'right',
							],
						],
						[
							['ctx-events/booking', []],
						],
					],
				],
			],
		],
	],
];
