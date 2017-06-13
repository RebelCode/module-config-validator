<?php

namespace RebelCode\Modular\Config\UnitTest;

use Xpmock\TestCase;
use RebelCode\Modular\Config\AbstractValidator;

/**
 * Tests {@see \RebelCode\Modular\Config\AbstractValidator}.
 *
 * @since [*next-version*]
 */
class AbstractValidatorTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\\Modular\\Config\\AbstractValidator';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return AbstractValidator
     */
    public function createInstance()
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
            ->_getValidationErrors()
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
    }

    /**
     * Tests that a correct simple version of a slug is determined to be valid.
     *
     * @since [*next-version*]
     */
    public function testValidSlugSimple()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);
        $slug = 'rebel-code123';

        $result = $reflection->_isValidSlug($slug);

        $this->assertTrue($result, sprintf('The valid slug "%1$s" was determined to be invalid', $slug));
    }

    /**
     * Tests that a correct vendor version of a slug is determined to be valid.
     *
     * @since [*next-version*]
     */
    public function testValidSlugVendor()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);
        $slug = 'rebel-code123/package-987';

        $result = $reflection->_isValidSlug($slug);

        $this->assertTrue($result, sprintf('The valid slug "%1$s" was determined to be invalid', $slug));
    }

    /**
     * Tests that an incorrect simple version of a slug is determined to be invalid.
     *
     * @since [*next-version*]
     */
    public function testInvalidSlugSimple()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);
        $slug = 'rebel-co_de123';

        $result = $reflection->_isValidSlug($slug);

        $this->assertFalse($result, sprintf('The invalid slug "%1$s" was determined to be valid', $slug));
    }

    /**
     * Tests that an incorrect vendor version of a slug is determined to be invalid.
     *
     * @since [*next-version*]
     */
    public function testInvalidSlugVendor()
    {
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);
        $slug = 'rebel-code123/package_987';

        $result = $reflection->_isValidSlug($slug);

        $this->assertFalse($result, sprintf('The invalid slug "%1$s" was determined to be valid', $slug));
    }
}
