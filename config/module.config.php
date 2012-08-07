<?php

namespace Ctrl;

return array(
    'phpSettings' => array(
        'date.timezone' => 'UTC',
    ),
    'service_manager' => array(
        'factories' => array(
            'DomainServiceLoader' => 'Ctrl\Service\DomainServiceLoaderFactory',
        ),
    ),
);
