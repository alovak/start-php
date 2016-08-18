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


    function setUp()
    {
        // Data for a successful customer
        $this->success_data = array(
            "name" => "Test Customer",
            "email" => "test@customer.com",
            "description" => "Signed up at the fair"
        );
    }

    function testCreateCustomer()
    {
        $customer = Start_Customer::create($this->success_data);

        $this->assertEquals($customer["email"], "test@customer.com");
        $this->assertEquals($customer["name"], "Test Customer");
        $this->assertEquals($customer["description"], "Signed up at the fair");

        $this->assertCount(0, $customer["cards"]);

        return $customer;
    }

    /**
     * @depends testCreateCustomer
     */
    function testGetCustomer($existing_customer)
    {
        $customer = Start_Customer::get($existing_customer["id"]);

        $this->assertEquals($customer["email"], "test@customer.com");
    }

    /**
     * @depends testCreateCustomer
     */
    function testGetAllCustomers($existing_customer)
    {
        $all = Start_Customer::all();

        $this->assertNotEmpty($all["customers"]);
    }
}
