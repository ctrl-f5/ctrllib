<?php

namespace Ctrl\View\Helper;

use Ctrl\View\Helper\AbstractHtmlElement;

class FormatDate extends AbstractHtmlElement
{
    protected $defaultFormat = 'Y-m-d H:i';

    public function __invoke($date, $format = null)
    {
        if (!($date instanceof \DateTime))
            return '';

        if (!$format) $format = $this->defaultFormat;
        $html = $this->create($date, $format);

        return $html;
    }

    protected function create(\DateTime $date, $format)
    {
        return $date->format($format);
    }
}
