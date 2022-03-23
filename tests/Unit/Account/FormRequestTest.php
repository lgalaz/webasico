<?php

namespace Tests\Unit\Account;

use Tests\TestCase;
use App\Models\Account;
use Tests\ResetsDatabase;
use App\Http\Requests\AccountForm;
use Illuminate\Support\Facades\Validator;

class FormRequestTest extends TestCase
{
    use ResetsDatabase;

    /**
     * @dataProvider provideInvalidNameData
     */
    public function test_name_validation_fails(string $testCase, array $data)
    {
        if ($testCase === 'unique') {
            Account::factory()->create(['name' => $data['name']]);
        }

        $request = new AccountForm();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertContains('name', $validator->errors()->keys());
    }

    public function provideInvalidNameData()
    {
        $specialChars = '[]{}()<>%!#$&*+,./=@|~\\';
        // this will have a random special char every time that tests are run.
        $index       = rand(0, strlen($specialChars) - 1);
        $specialName =  "validName{$specialChars[$index]}";

        return [
            ['empty', []],
            ['specialChars', Account::factory()->make(['name' => $specialName])->toArray()],
            ['minChars', Account::factory()->make(['name' => 'min'])->toArray()],
            ['maxChars', Account::factory()->make(['name' => 'itsoversixteenchars'])->toArray()],
            ['unique', Account::factory()->make(['name' => 'myAccount'])->toArray()],
        ];
    }

    public function test_does_not_fail_on_non_unique_name_for_the_same_account()
    {
        $name               = 'myAccount';
        $request            = new AccountForm();
        $request['account'] = Account::factory()->create(['name' => $name]);
        $updateData         = Account::factory()->make(['name' => $name])->toArray();
        $validator          = Validator::make($updateData, $request->rules());

        $this->assertTrue($validator->passes());
        $this->assertNotContains('name', $validator->errors()->keys());
    }
}
