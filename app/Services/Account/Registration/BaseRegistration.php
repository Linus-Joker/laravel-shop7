<?php

namespace App\Services\Account\Registration;

use DB;
use App\Repositories\MemberRepository;
use App\Repositories\MemberActivatorRepository;

abstract class BaseRegistration
{
    protected $type;
    protected $member;
    protected $activator;

    public function __construct()
    {
        $this->member = new MemberRepository();
    }

    public function activate()
    {
        $message = "hello activate";
        return $message;
    }
}
