<?php

namespace RebelCode\Modular\Config\UnitTest;

use Xpmock\TestCase;
use RebelCode\Modular\Config\Validator;
use Dhii\Validation\Exception\ValidationFailedException;
use PHPUnit_Framework_AssertionFailedError as AssertionFailedError;
use RebelCode\Modular\Config\ConfigInterface as Cfg;

/**
 * Tests {@see \RebelCode\Modular\Config\Validator}.
 *
 * @since [*next-version*]
 */
class ValidatorTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\\Modular\\Config\\Validator';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Validator The new instance.
     */
    public function createInstance()
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
            ->__(function ($string) {return $string; })
            ->new();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(
            static::TEST_SUBJECT_CLASSNAME,
            $subject,
            'Subject is not a valid instance'
        );

        $this->assertInstanceOf(
            'Dhii\\Validation\\ValidatorInterface',
            $subject,
            'Subject does not implement required interface'
        );
    }

    /**
     * Tests that the validator can correctly determine wrong config format.
     *
     * @since [*next-version*]
     */
    public function testInvalidFormat()
    {
        $subject = $this->createInstance();

        try {
            $subject->validate((object) array(Cfg::K_KEY));
        } catch (ValidationFailedException $e) {
            $errors = $e->getValidationErrors();
            $this->assertContainsRegex('/must be a map/', $errors, 'Config format was not determined to be invalid');

            return;
        }

        $this->assertTrue(false, 'Validation must have failed');
    }

    /**
     * Tests that the validator can correctly determine that the module key is missing.
     *
     * @since [*next-version*]
     */
    public function testInvalidMissingKey()
    {
        $subject = $this->createInstance();
        $config = array(uniqid('some-config-key-') => '12313');

        try {
            $subject->validate($config);
        } catch (ValidationFailedException $e) {
            $errors = $e->getValidationErrors();
            $this->assertContainsRegex('/missing required key/', $errors, 'Module name was not determined to be missing');

            return;
        }

        $this->assertTrue(false, 'Validation must have failed');
    }

    /**
     * Tests that the validator can correctly determine wrong module key format.
     *
     * @since [*next-version*]
     */
    public function testInvalidKey()
    {
        $subject = $this->createInstance();
        $config = array(Cfg::K_KEY => '123_csd');

        try {
            $subject->validate($config);
        } catch (ValidationFailedException $e) {
            $errors = $e->getValidationErrors();
            $this->assertContainsRegex('/does not contain a valid module slug/', $errors, 'Module name was not determined to be invalid');

            return;
        }

        $this->assertTrue(false, 'Validation must have failed');
    }

    /**
     * Tests that the validator can correctly determine wrong dependency keys format.
     *
     * @since [*next-version*]
     */
    public function testInvalidDependency()
    {
        $subject = $this->createInstance();
        $config  =  array(
            Cfg::K_KEY          => 'test/module',
            Cfg::K_DEPENDENCIES => array(
                '-invalid-'
            )
        );

        try {
            $subject->validate($config);
        } catch (ValidationFailedException $e) {
            $errors = $e->getValidationErrors();
            $this->assertContainsRegex('/has an invalid dependency key/', $errors, 'Config format was not determined to be invalid');

            return;
        }

        $this->assertTrue(false, 'Validation must have failed');
    }

    /**
     * Fails if haystack does not contain a string that matches the given expression.
     *
     * @since [*next-version*]
     *
     * @param string   $expr     The regular expression.
     * @param string[] $haystack The strings to match.
     * @param string   $message  The failure message.
     *
     * @throws AssertionFailedError On failure.
     */
    protected function assertContainsRegex($expr, $haystack, $message = null)
    {
        foreach ($haystack as $_item) {
            if (preg_match($expr, $_item)) {
                return true;
            }
        }

        throw new AssertionFailedError($message);
    }
}
