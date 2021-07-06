<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Services\Account\Registration\RegistrationFactory;

class RegistrationFactoryTest extends TestCase
{
    //假設會使用的類別名稱
    protected $emailType = "email";
    protected $generalType = "general";

    /**
     * A registration factory create class test
     *
     * @return void
     */
    public function testRegistrationFactoryCreateTest()
    {
        //要測試的類別
        $Emailclass = 'App\Services\Account\Registration\\' . "Email";
        $Generalclass = 'App\Services\Account\Registration\\' . "General";

        //向註冊工廠傳入參數後返回相關類別
        $rf = new RegistrationFactory();
        $emailClassResult =  $rf->create($this->emailType);
        $generalClassResult =  $rf->create($this->generalType);

        //斷言回傳的類別和設定的是否相同
        $this->assertEquals(new $Emailclass, $emailClassResult);
        $this->assertEquals(new $Generalclass, $generalClassResult);
    }
}
