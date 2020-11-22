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
        $this->activator = new MemberActivatorRepository();
    }

    public function activate(int $memberId, string $code)
    {
        $insertData = [
            'member_id' => $memberId,
            'code' => $code,
            'type' => $this->type,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->activator->create($insertData);

        return true;
    }
}
