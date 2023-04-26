<?php

namespace Tests\Feature;


use App\Models\Customer;
use App\Models\CustomerPoint;
use App\Models\Merchant;
use App\Services\Point;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Exception;

class PointTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test add point with three customer points
     *
     * @return void
     */
    public function testAddPointWithThreeCustomerPoints()
    {
        $customer = Customer::factory()->create();
        $merchant = Merchant::factory()->create();

        // create customer points
        CustomerPoint::factory()->create(['customer_id' => $customer->id, 'points' => 10]);
        CustomerPoint::factory()->create(['customer_id' => $customer->id, 'points' => 10]);
        CustomerPoint::factory()->create(['customer_id' => $customer->id, 'points' => 10]);

        Point::addPoint($customer->id, $merchant->id);

        $this->assertEquals(20, $customer->fresh()->points);
    }

    /**
     * Test add point with less than three customer points
     *
     * @return void
     */
    public function testAddPointWithLessThanThreeCustomerPoints()
    {
        $customer = Customer::factory()->create();
        $merchant = Merchant::factory()->create();

        // create customer points
        CustomerPoint::factory()->create(['customer_id' => $customer->id, 'points' => 10]);
        CustomerPoint::factory()->create(['customer_id' => $customer->id, 'points' => 10]);

        Point::addPoint($customer->id, $merchant->id);

        $this->assertEquals(10, $customer->fresh()->points);
    }

    /**
     * Test add point with no customer points
     *
     * @return void
     */
    public function testAddPointWithNoCustomerPoints()
    {
        $customer = Customer::factory()->create();
        $merchant = Merchant::factory()->create();

        Point::addPoint($customer->id, $merchant->id);

        $this->assertEquals(10, $customer->fresh()->points);
    }

   /**
    * This function tests if adding points to a customer's account is successful.
    * @return void
    */
    public function testAddsCustomerPointsSuccessfully()
    {
        $customer = Customer::factory()->create();
        $merchantId = 1;

        Point::addPoint($customer->id, $merchantId);

        $this->assertEquals(10, $customer->fresh()->points);
    }

    /**
     * The function tests if a database transaction is rolled back when an exception is thrown.
     * @return void
     */
    public function testRollsBackDatabaseTransactionIfExceptionIsThrown()
    {
        $customer = Customer::factory()->create(['points' => 5]);
        $merchantId = 1;

        // Make sure an exception is thrown by providing an invalid merchant ID
        $this->expectException(Exception::class);

        Point::addPoint($customer->id, $merchantId + 600);

        $this->assertEquals(5, $customer->fresh()->points);
    }
}
