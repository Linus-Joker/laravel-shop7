<?php

namespace Tests\Unit\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Services\MessageService;

use App\Exceptions\InvalidParameterException;

/**
 * class register service unit test .
 *
 * @return void
 */
class MessageServiceTest extends TestCase
{
    public function testValidate()
    {
        $testData = [
            'product_id'    => 1,
            'user_id'       => 1,
            'message_content' => 'hello test message1.',
        ];

        $message = new MessageService();

        $dataResult = $message->validate($testData);

        $this->assertTrue($dataResult);
    }

    public function testProductIdValidateException()
    {
        $testExceptionProductIdData = [
            'product_id'    => 'abc',
            'user_id'       => 1,
            'message_content' => 'hello test message1.',
        ];

        $this->expectException(InvalidParameterException::class);

        $message = new MessageService();

        $message->validate($testExceptionProductIdData);
    }

    public function testUserIdValidateException()
    {
        $testExceptionUserIdData = [
            'product_id'    => 1,
            'user_id'       => 'abc',
            'message_content' => 'hello test message1.',
        ];

        $this->expectException(InvalidParameterException::class);

        $message = new MessageService();

        $message->validate($testExceptionUserIdData);
    }

    public function testContentValidateException()
    {
        $testExceptionContentData = [
            'product_id'    => 1,
            'user_id'       => 'abc',

        ];

        $this->expectException(InvalidParameterException::class);

        $message = new MessageService();

        $message->validate($testExceptionContentData);
    }
}
