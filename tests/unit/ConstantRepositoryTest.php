<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use Codeception\Test\Unit;
use Itineris\WPPHPMailer\Exceptions\NotFoundException;

class ConstantRepositoryTest extends Unit
{
    /** @var UnitTester */
    protected $tester;

    public function testGet()
    {
        $name = __NAMESPACE__ . __CLASS__ . __FUNCTION__ . '-my-constant';
        $expected = 'my-constant-value';
        define($name, $expected);

        $constantRepo = new ConstantRepository();

        $actual = $constantRepo->get($name);

        $this->assertSame($expected, $actual);
    }

    public function testGetNotDefined()
    {
        $name = __NAMESPACE__ . __CLASS__ . __FUNCTION__ . '-my-constant';

        $constantRepo = new ConstantRepository();

        $actual = $constantRepo->get($name);

        $this->assertNull($actual);
    }

    public function testGetRequired()
    {
        $name = __NAMESPACE__ . __CLASS__ . __FUNCTION__ . '-my-constant';
        $expected = 'my-constant-value';
        define($name, $expected);

        $constantRepo = new ConstantRepository();

        $actual = $constantRepo->getRequired($name);

        $this->assertSame($expected, $actual);
    }

    public function testGetRequiredNotDefined()
    {
        $name = __NAMESPACE__ . __CLASS__ . __FUNCTION__ . '-my-constant';

        $constantRepo = new ConstantRepository();

        $expected = new NotFoundException("Required constant '$name' not found. Please define it in wp-config.php.");

        $this->tester->expectThrowable($expected, function () use ($constantRepo, $name): void {
            $constantRepo->getRequired($name);
        });
    }
}
