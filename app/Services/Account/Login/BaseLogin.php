<?php

namespace App\Services\Account\Login;

use Illuminate\Support\Facades\Validator;
use App\Repositories\MemberRepository;

abstract class BaseLogin
{
    protected $member;

    public function __construct()
    {
        $this->member = new MemberRepository();
    }
}
