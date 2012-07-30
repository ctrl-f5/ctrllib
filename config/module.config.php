<?php

namespace Ctrl;

return array(
    'service_manager' => array(
        'factories' => array(
            'DomainServiceLoader' => 'Ctrl\Service\DomainServiceLoaderFactory',
        ),
    )
);
