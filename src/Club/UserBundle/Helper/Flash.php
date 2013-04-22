<?php

namespace Club\UserBundle\Helper;

class Flash
{
    private $session;
    private $trans;
    private $log;

    public function __construct($session, $trans, $log)
    {
        $this->session = $session;
        $this->trans = $trans;
        $this->log = $log;
    }

    public function addError($message)
    {
        $this->session->getFlashBag()->add('error', $this->trans->trans('Operation did not finish, an error occur.'));
        $this->log->error($message);
    }
}
