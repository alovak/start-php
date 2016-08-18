<?php
class Start_CustomerTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        Start::$fallback = false;
        Start::setApiKey('test_sec_k_2b99b969196bece8fa7fd');

        if (getenv("CURL") == "1") {
            Start::$useCurl = true;
        }
    }

    private $success_data = array(
        "name" => "Test Customer",
        "email" => "test@customer.com",
        "description" => "Signed up at the fair"
    );

    function testCreateCustomerWithoutCardToken()
    {
        $customer = Start_Customer::create($this->success_data);

        $this->assertEquals($customer["email"], "test@customer.com");
        $this->assertEquals($customer["name"], "Test Customer");
        $this->assertEquals($customer["description"], "Signed up at the fair");

        $this->assertCount(0, $customer["cards"]);

        return $customer;
    }

    /**
     * @depends testCreateCustomerWithoutCardToken
     */
    function testGetCustomer($existing_customer)
    {
        $customer = Start_Customer::get($existing_customer["id"]);

        $this->assertEquals($customer["email"], "test@customer.com");
    }

    /**
     * @depends testCreateCustomerWithoutCardToken
     */
    function testGetAllCustomers($existing_customer)
    {
        $all = Start_Customer::all();

        $this->assertNotEmpty($all["customers"]);
    }

    function testCreateCustomerWithCardToken()
    {
        /* Token should be created via JavaScipt library Beautiful.js */
        /* more info here: https://docs.start.payfort.com/guides/beautiful.js/ */
        Start::setApiKey('test_open_k_fcd2be7651c659bbdfc2');

        $token = Start_Token::create(array(
            "number" => "4242424242424242",
            "exp_month" => 11,
            "exp_year" => 2020,
            "cvc" => "123"
        ));

        Start::setApiKey('test_sec_k_2b99b969196bece8fa7fd');

        $customer = Start_Customer::create(array(
            "email" => "new@customer.com",
            "card"  => $token["id"]
        ));

        $this->assertEquals($customer["email"], "new@customer.com");
        $this->assertEquals($customer["default_card_id"], $token["card"]["id"]);

        $this->assertCount(1, $customer["cards"]);

        $this->assertEquals($customer["cards"][0]["id"], $token["card"]["id"]);
    }

}
