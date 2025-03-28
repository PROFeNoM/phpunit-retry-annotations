<?php

namespace PHPUnitRetry\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnitRetry\RetryAnnotationTrait;

/**
 * A class for testing RetryAnnotationTrait.
 *
 * @retryAttempts 2
 * @retryForSeconds 1
 * @retryDelaySeconds 1
 * @retryDelayMethod fakeDelayMethod1
 */
class RetryAnnotationTraitTest extends TestCase
{
    use RetryAnnotationTrait;

    public function testClassRetries()
    {
        $this->assertEquals(2, $this->getRetryAttemptsAnnotation());
    }

    /**
     * @retryAttempts 3
     */
    public function testMethodRetries()
    {
        $this->assertEquals(3, $this->getRetryAttemptsAnnotation());
    }

    /**
     * @retryAttempts
     */
    public function testNoArgumentToRetryAttemptsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryAttempts annotation requires an integer as an argument');
        $this->getRetryAttemptsAnnotation();
    }

    public function testEmptyStringToRetryAttemptsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryAttempts annotation requires an integer as an argument');
        $this->parseRetryAttemptsAnnotation('');
    }

    public function testInvalidStringArgumentTypeToRetryAttemptsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryAttempts annotation must be an integer but got "\'foo\'"');
        $this->parseRetryAttemptsAnnotation('foo');
    }

    public function testInvalidFloatArgumentTypeToRetryAttemptsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryAttempts annotation must be an integer but got "1.2"');
        $this->parseRetryAttemptsAnnotation('1.2');
    }

    public function testNonPositiveIntegerToRetryAttemptsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryAttempts annotation must be 0 or greater but got "-1"');
        $this->parseRetryAttemptsAnnotation(-1);
    }

    public function testValidRetryAttemptsAnnotations()
    {
        $this->assertEquals(0, $this->parseRetryAttemptsAnnotation('0'));
        $this->assertEquals(1, $this->parseRetryAttemptsAnnotation('1'));
        $this->assertEquals(1, $this->parseRetryAttemptsAnnotation('1.0'));
    }

    public function testClassRetryDelaySeconds()
    {
        $this->assertEquals(1, $this->getRetryDelaySecondsAnnotation());
    }

    /**
     * @retryDelaySeconds 2
     */
    public function testMethodRetryDelaySeconds()
    {
        $this->assertEquals(2, $this->getRetryDelaySecondsAnnotation());
    }

    /**
     * @retryDelaySeconds
     */
    public function testNoArgumentToRetryDelaySecondsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryDelaySeconds annotation requires an integer as an argument');
        $this->getRetryDelaySecondsAnnotation();
    }

    public function testEmptyStringToRetryDelaySecondsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryDelaySeconds annotation requires an integer as an argument');
        $this->parseRetryDelaySecondsAnnotation('');
    }

    public function testInvalidStringArgumentTypeToRetryDelaySecondsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryDelaySeconds annotation must be an integer but got "\'foo\'"');
        $this->parseRetryDelaySecondsAnnotation('foo');
    }

    public function testInvalidFloatArgumentTypeToRetryDelaySecondsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryDelaySeconds annotation must be an integer but got "1.2"');
        $this->parseRetryDelaySecondsAnnotation('1.2');
    }

    public function testNonPositiveIntegerToRetryDelaySecondsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryDelaySeconds annotation must be 0 or greater but got "-1"');
        $this->parseRetryDelaySecondsAnnotation(-1);
    }

    public function testValidRetryDelaySecondsAnnotations()
    {
        $this->assertEquals(0, $this->parseRetryDelaySecondsAnnotation('0'));
        $this->assertEquals(1, $this->parseRetryDelaySecondsAnnotation('1'));
        $this->assertEquals(1, $this->parseRetryDelaySecondsAnnotation('1.0'));
    }

    public function testClassRetryDelayMethod()
    {
        $this->assertEquals(
            ['fakeDelayMethod1', []],
            $this->getRetryDelayMethodAnnotation()
        );
    }

    /**
     * @retryDelayMethod fakeDelayMethod2
     */
    public function testMethodRetryDelayMethod()
    {
        $this->assertEquals(
            ['fakeDelayMethod2', []],
            $this->getRetryDelayMethodAnnotation()
        );
    }

    /**
     * @retryDelayMethod fakeDelayMethod2 foo1 foo2
     */
    public function testMethodRetryDelayMethodWithArguments()
    {
        $this->assertEquals(
            ['fakeDelayMethod2', ['foo1', 'foo2']],
            $this->getRetryDelayMethodAnnotation()
        );
    }

    /**
     * @retryDelayMethod
     */
    public function testNoArgumentToRetryDelayMethodAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryDelayMethod annotation requires a callable as an argument');
        $this->getRetryDelayMethodAnnotation();
    }

    public function testEmptyStringToRetryDelayMethodAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryDelayMethod annotation requires a callable as an argument');
        $this->parseRetryDelayMethodAnnotation('');
    }

    public function testInvalidCallableArgumentTypeToRetryDelayMethodAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryDelayMethod annotation must be a method in your test class but got "nonexistantDelayMethod"');
        $this->parseRetryDelayMethodAnnotation('nonexistantDelayMethod');
    }

    public function testClassRetryForSeconds()
    {
        $this->assertEquals(1, $this->getRetryForSecondsAnnotation());
    }

    /**
     * @retryForSeconds 2
     */
    public function testMethodRetryForSeconds()
    {
        $this->assertEquals(2, $this->getRetryForSecondsAnnotation());
    }

    /**
     * @retryForSeconds
     */
    public function testNoArgumentToRetryForSecondsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryForSeconds annotation requires an integer as an argument');
        $this->getRetryForSecondsAnnotation();
    }

    public function testEmptyStringToRetryForSecondsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryForSeconds annotation requires an integer as an argument');
        $this->parseRetryForSecondsAnnotation('');
    }

    public function testInvalidStringArgumentTypeToRetryForSecondsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryForSeconds annotation must be an integer but got "\'foo\'"');
        $this->parseRetryForSecondsAnnotation('foo');
    }

    public function testInvalidFloatArgumentTypeToRetryForSecondsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryForSeconds annotation must be an integer but got "1.2"');
        $this->parseRetryForSecondsAnnotation('1.2');
    }

    public function testNonPositiveIntegerToRetryForSecondsAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryForSeconds annotation must be 0 or greater but got "-1"');
        $this->parseRetryForSecondsAnnotation(-1);
    }

    public function testValidRetryForSecondsAnnotations()
    {
        $this->assertEquals(0, $this->parseRetryForSecondsAnnotation(0));
        $this->assertEquals(0, $this->parseRetryForSecondsAnnotation('0'));
        $this->assertEquals(1, $this->parseRetryForSecondsAnnotation(1));
        $this->assertEquals(1, $this->parseRetryForSecondsAnnotation('1'));
        $this->assertEquals(1, $this->parseRetryForSecondsAnnotation(1.0));
        $this->assertEquals(1, $this->parseRetryForSecondsAnnotation('1.0'));
    }

    /**
     * @retryIfMethod fakeIfMethod2
     */
    public function testMethodRetryIfMethod()
    {
        $this->assertEquals(
            ['fakeIfMethod2', []],
            $this->getRetryIfMethodAnnotation()
        );
    }

    /**
     * @retryIfMethod fakeIfMethod2 foo1 foo2
     */
    public function testMethodRetryIfMethodWithArguments()
    {
        $this->assertEquals(
            ['fakeIfMethod2', ['foo1', 'foo2']],
            $this->getRetryIfMethodAnnotation()
        );
    }

    /**
     * @retryIfMethod
     */
    public function testNoArgumentToRetryIfMethodAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryIfMethod annotation requires a callable as an argument');
        $this->getRetryIfMethodAnnotation();
    }

    public function testEmptyStringToRetryIfMethodAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryIfMethod annotation requires a callable as an argument');
        $this->validateRetryIfMethodAnnotation('');
    }

    public function testInvalidCallableArgumentTypeToRetryIfMethodAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryIfMethod annotation must be a method in your test class but got "nonexistantIfMethod"');
        $this->validateRetryIfMethodAnnotation('nonexistantIfMethod');
    }

    /**
     * @retryIfException InvalidArgumentException
     */
    public function testRetryIfException()
    {
        $this->assertEquals(
            ['InvalidArgumentException'],
            $this->getRetryIfExceptionAnnotations()
        );
    }

    /**
     * @retryIfException LogicException
     * @retryIfException InvalidArgumentException
     */
    public function testMultipleRetryIfException()
    {
        $this->assertEquals(
            ['LogicException', 'InvalidArgumentException'],
            $this->getRetryIfExceptionAnnotations()
        );
    }

    /**
     * @retryIfException
     */
    public function testNoArgumentToRetryIfExceptionAnnotation()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryIfException annotation requires a class name as an argument');
        $this->getRetryIfExceptionAnnotations();
    }

    /**
     * @retryIfException ThisClassDoesNotExist
     */
    public function testRetryIfExceptionWithInvalidClassname()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('The @retryIfException annotation must be an instance of Exception but got "ThisClassDoesNotExist"');
        $this->getRetryIfExceptionAnnotations();
    }

    private function fakeDelayMethod1()
    {
    }

    private function fakeDelayMethod2()
    {
    }

    private function fakeIfMethod1()
    {
    }

    private function fakeIfMethod2()
    {
    }
}
