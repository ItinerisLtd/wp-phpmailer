<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use Codeception\Test\Unit;
use Itineris\WPPHPMailer\Exceptions\NotFoundException;
use WP_Mock;

class ConstantRepositoryTest extends Unit
{
    /** @var UnitTester */
    protected $tester;

    public function testGet()
    {
        $expected = 'my-constant-value';
        define('CONSTANT_REPOSITORY_TEST_TEST_GET_MY_CONSTANT', $expected);

        $constantRepo = new ConstantRepository();

        WP_Mock::expectFilter('constant_repository_test_test_get_my_constant', $expected);

        $actual = $constantRepo->get('constant-repository-test-test-get-my-constant');

        $this->assertSame($expected, $actual);
    }

    public function testGetFiltered()
    {
        $value = 'my-constant-value';
        $expected = 'my-filtered-value';
        define('CONSTANT_REPOSITORY_TEST_TEST_GET_FILTERED_MY_CONSTANT', $value);

        $constantRepo = new ConstantRepository();
        WP_Mock::onFilter('constant_repository_test_test_get_filtered_my_constant')
               ->with($value)
               ->reply($expected);

        $actual = $constantRepo->get('constant-repository-test-test-get-filtered-my-constant');

        $this->assertSame($expected, $actual);
    }

    public function testGetNotDefined()
    {
        $constantRepo = new ConstantRepository();

        WP_Mock::onFilter('constant_repository_test_test_get_not_defined_my_constant')
               ->with(null)
               ->reply(null);


        $actual = $constantRepo->get('constant-repository-test-test-get-not-defined-my-constant');

        $this->assertNull($actual);
    }

    public function testGetNotDefinedFiltered()
    {
        $expected = 'my-not-defined-filtered-value';

        $constantRepo = new ConstantRepository();

        WP_Mock::onFilter('constant_repository_test_test_get_not_defined_filtered_my_constant')
               ->with(null)
               ->reply($expected);

        $actual = $constantRepo->get('constant-repository-test-test-get-not-defined-filtered-my-constant');

        $this->assertSame($expected, $actual);
    }

    public function testGetRequired()
    {
        $expected = 'my-constant-value';
        define('CONSTANT_REPOSITORY_TEST_TEST_GET_REQUIRED_MY_CONSTANT', $expected);

        $constantRepo = new ConstantRepository();

        WP_Mock::expectFilter('constant_repository_test_test_get_required_my_constant', $expected);

        $actual = $constantRepo->getRequired('constant-repository-test-test-get-required-my-constant');

        $this->assertSame($expected, $actual);
    }

    public function testGetRequiredNotDefined()
    {
        $name = 'constant-repository-test-test-get-required-not-defined-my-constant';

        $constantRepo = new ConstantRepository();

        WP_Mock::onFilter('constant_repository_test_test_get_required_not_defined_my_constant')
               ->with(null)
               ->reply(null);

        $expected = new NotFoundException("Required constant '$name' not found. Please define it in wp-config.php.");

        $this->tester->expectThrowable($expected, function () use ($constantRepo, $name): void {
            $constantRepo->getRequired($name);
        });
    }
}
