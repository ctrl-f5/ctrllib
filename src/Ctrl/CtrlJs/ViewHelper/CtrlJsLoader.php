<?php

namespace Ctrl\CtrlJs\ViewHelper;

use Zend\View\Helper\HeadScript;

class CtrlJsLoader extends HeadScript
{
    /**
     * Registry key for placeholder
     * @var string
     */
    protected $_regKey = 'Ctrl_CtrlJs_ViewHelper_CtrlJsLoader';

    public function __invoke($mode = HeadScript::FILE, $spec = null, $placement = 'APPEND', array $attrs = array(), $type = 'text/javascript')
    {
        parent::__invoke($mode, $spec, $placement, $attrs, $type);
        return $this;
    }

    public function loadScripts($useDefaultInit = false)
    {
        $this->appendFile($this->view->basePath() . '/js/vendor/ctrl-f5/ctrljs/src/jquery.min.js');
        $this->appendFile($this->view->basePath() . '/js/vendor/ctrl-f5/ctrljs/src/bootstrap.min.js');
        $this->appendFile($this->view->basePath() . '/js/vendor/ctrl-f5/ctrljs/src/ctrl.js');

        if ($useDefaultInit) {
            $this->appendFile($this->view->basePath() . '/js/vendor/ctrl-f5/ctrljs/src/ctrl.init.default.js');
        }

        return $this;
    }
}
