<?php
use PHPUnit\Framework\TestCase;

final class LambdaContainerTest extends TestCase
{
    public function testRegisterThrowsExceptionWhenClassDoesNotExist()
    {
        $container = new LambdaContainer();

        $this->expectException(InvalidArgumentException::class);

        $container::register('BadClass', function(){});
    }

    public function testRegisterThrowsExceptionWhenLambdaIsNotFunction()
    {
        $container = new LambdaContainer();

        $this->expectException(InvalidArgumentException::class);

        $container::register('LambdaContainer', Array());
    }

    public function testGetThrowsExceptionWhenClassDoesNotExist()
    {
        $container = new LambdaContainer();

        $this->expectException(InvalidArgumentException::class);

        $container::get('BadClass');
    }

    public function testGetThrowsExceptionWhenLambdaHasNotBeenRegistered()
    {
        $container = new LambdaContainer();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('LambdaContainer has not been registered');
        $container::get('LambdaContainer');
    }

    public function testRegisterGetAndClearSuccess()
    {
        $container = new LambdaContainer();

        $container::register('LambdaContainer', function() {return 'success';});
        $this->assertEquals(
            'success',
            $container::get('LambdaContainer')
        );
        $container::clear('LambdaContainer');
        $this->expectException(Exception::class);
        $container::get('LambdaContainer');
    }
}