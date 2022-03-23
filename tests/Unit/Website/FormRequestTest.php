<?php

namespace Tests\Unit\Website;

use Tests\TestCase;
use App\Models\Template;
use App\Models\Account;
use App\Models\Website;
use Tests\ResetsDatabase;
use App\Http\Requests\WebsiteForm;
use Illuminate\Support\Facades\Validator;

class FormRequestTest extends TestCase
{
    use ResetsDatabase;

    protected $account = null;
    protected $name    = 'myWebsite';
    protected $request = null;

    protected function setUp(): void
    {
        $this->request = new WebsiteForm();

        parent::setUp();
    }

    /**
     * @dataProvider provideInvalidNameData
     */
    public function test_name_validation_fails(string $testCase, array $data)
    {
        if ($testCase === 'uniqueForAccount') {
            Website::factory()->create([
                'account_id' => $this->getAccount()->account_id,
                'name'       => $this->name,
            ]);

            $this->request['account'] = $this->getAccount();
        }

        $validator = Validator::make($data, $this->request->rules());

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
            ['specialChars', $this->getWebsiteData($specialName)],
            ['minChars', $this->getWebsiteData('ab')],
            ['maxChars', $this->getWebsiteData('itsoversixteenchars')],
            ['uniqueForAccount', $this->getWebsiteData($this->name)],
        ];
    }

    public function getWebsiteData($name)
    {
        return Website::factory()->make([
            'account_id' => $this->getAccount()->account_id,
            'name'       => $name,
        ])->toArray();
    }

    public function getAccount()
    {
        if (is_null($this->account)) {
            $this->account = Account::factory()->create();
        }

        return $this->account;
    }

    public function test_name_is_not_required()
    {
        $validator = Validator::make([], $this->request->rules());

        $this->assertTrue($validator->passes());
        $this->assertNotContains('name', $validator->errors()->keys());
    }

    public function test_does_not_fail_on_non_unique_name_for_different_accounts()
    {
        $existingWebsite = Website::factory()->create([
            'account_id' => $this->getAccount()->account_id,
            'name'       => $this->name,
        ]);

        $differentAccount = Account::factory()->create();
        $currentWebsite   = Website::factory()->create([
            'account_id' => $differentAccount->account_id,
            'name'       => $this->name,
        ]);

        $this->request['account'] = $differentAccount;
        $this->request['website'] = $currentWebsite;

        $validator = Validator::make(['name' => $existingWebsite->name], $this->request->rules());

        $this->assertTrue($validator->passes());

        $this->assertNotContains('name', $validator->errors()->keys());
    }

    public function test_does_not_fail_on_non_unique_name_for_the_same_website()
    {
        $this->request['account'] = $this->getAccount();
        $this->request['website'] = Website::factory()->create([
            'account_id' => $this->getAccount()->account_id,
            'name'       => $this->name,
        ]);

        $validator = Validator::make(['name' => $this->name], $this->request->rules());

        $this->assertTrue($validator->passes());
        $this->assertNotContains('name', $validator->errors()->keys());
    }

    public function test_template_id_is_not_required()
    {
        $validator = Validator::make([], $this->request->rules());

        $this->assertTrue($validator->passes());
        $this->assertNotContains('template_id', $validator->errors()->keys());
    }

    public function test_template_id_must_be_an_integer_grater_than_zero()
    {
        $invalidValues = ['a', 2.5, false, [], 0, -1];

        foreach ($invalidValues as $invalidValue) {
            $validator = Validator::make(['template_id' => $invalidValue], $this->request->rules());

            $this->assertFalse($validator->passes());
            $this->assertContains('template_id', $validator->errors()->keys());
        }
    }

    public function test_it_fails_when_template_id_does_not_exist()
    {
        $invalidTemplate  = 1000;

        $validator = Validator::make(['template_id' => $invalidTemplate], $this->request->rules());

        $this->assertFalse($validator->passes());
        $this->assertContains('template_id', $validator->errors()->keys());
    }

    public function test_it_does_not_fail_when_template_id_exists()
    {
        $existingTemplate = Template::factory()->create();

        $validator = Validator::make(['template_id' => $existingTemplate->template_id], $this->request->rules());

        $this->assertTrue($validator->passes());
        $this->assertNotContains('template_id', $validator->errors()->keys());
    }
}
