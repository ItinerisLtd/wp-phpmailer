<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use Codeception\Test\Unit;

class ConfigTest extends Unit
{
    public function testInstanceOfConfigInterface()
    {
        $subject = new Config();

        $this->assertInstanceOf(ConfigInterface::class, $subject);
    }

    public function testSetHasGet()
    {
        // Review: Necessary?
        $providers = [
            'array-empty' => [],
            'array-int-1-int-2-string-3-bool-false-bool-true' => [1, 2, '3', false, true],
            'array-indexed' => [
                'a' => 1,
                'b' => 2,
                'c' => '3',
                'd' => false,
                'e' => true,
            ],
            'bool-false' => false,
            'bool-true' => true,
            'int-0' => 0,
            'int-1' => 1,
            'int-minus-one' => -1,
            'string-0' => '0',
            'string-1' => '1',
            'string-empty' => '',
            'string-false' => 'false',
            'string-hello-world' => 'hello-world',
            'string-null' => 'null',
            'string-true' => 'true',
        ];

        $subject = new Config();

        foreach($providers as $key => $value) {
            $subject->set($key, $value);
        }

        foreach($providers as $key => $value) {
            $this->assertTrue($subject->has($key), "Subject has no $key");
            $this->assertSame($value, $subject->get($key), "Subject doesn't has correct $key");
        }
    }

    public function testUnset()
    {
        $key = 'my-key';
        $value = 'my-value';

        $subject = new Config();

        $subject->set($key, $value);

        $this->assertTrue($subject->has($key));
        $this->assertSame($value, $subject->get($key));

        $subject->unset($key);

        $this->assertFalse($subject->has($key));
        $this->assertNull($subject->get($key));
    }
}
