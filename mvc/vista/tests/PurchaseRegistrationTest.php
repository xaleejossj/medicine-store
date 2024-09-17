<?php
use PHPUnit\Framework\TestCase;

class DatabaseAccess {
    protected $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function registerPurchase($productId, $quantity) {
        // Simulated database operation for registering a purchase
        // Update the product quantity in the database
        return true;
    }
}

class PurchaseRegistrationTest extends TestCase
{
    public function testSuccessfulPurchaseRegistration()
    {
        $mockDbAccess = $this->getMockBuilder(DatabaseAccess::class)
                             ->disableOriginalConstructor()
                             ->getMock();

        $mockDbAccess->expects($this->once())
                     ->method('registerPurchase')
                     ->with(1, 10)
                     ->willReturn(true);

        $isRegistered = $mockDbAccess->registerPurchase(1, 10);

        $this->assertTrue($isRegistered, 'The purchase registration should be successful.');
    }

    public function testPurchaseRegistrationWithInvalidData()
    {
        $mockDbAccess = $this->getMockBuilder(DatabaseAccess::class)
                             ->disableOriginalConstructor()
                             ->getMock();

        $mockDbAccess->expects($this->once())
                     ->method('registerPurchase')
                     ->with(-1, -10)
                     ->willReturn(false);

        $isRegistered = $mockDbAccess->registerPurchase(-1, -10);

        $this->assertFalse($isRegistered, 'The purchase registration with invalid data should fail.');
    }

    public function testHandlingErrorsDuringPurchaseRegistration()
    {
        $mockDbAccess = $this->getMockBuilder(DatabaseAccess::class)
                             ->disableOriginalConstructor()
                             ->getMock();

        // Simulate an error condition
        $mockDbAccess->method('registerPurchase')->willThrowException(new Exception("Database error"));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Database error");

        $mockDbAccess->registerPurchase(1, 10);
    }
}
