<?php

namespace Ivory\Tests\GoogleMap\Helper\Builder;

use Ivory\GoogleMap\Helper\Builder\JsonBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class JsonBuilderTest extends TestCase
{
    public function test_set_json_encode_options_sets_number_of_encode_options()
    {
        $jsonBuilder = $this->given_a_mock_json_builder();

        $jsonBuilder->setJsonEncodeOptions(5);

        $this->assertEquals(5, $jsonBuilder->getJsonEncodeOptions());
    }

    public function test_json_builder_has_values()
    {
        $jsonBuilder = $this->given_a_mock_json_builder();

        $jsonBuilder->setValues([
            'firstKey'  => 'firstValue',
            'secondKey' => 'secondValue',
            'thirdKey'  => [
                'thirdFirstKey' => 'thirdFirstValue'
            ]
        ], 'test');

        $this->assertTrue($jsonBuilder->hasValues());
        $this->assertArrayHasKey('test[firstKey]', $jsonBuilder->getValues());
        $this->assertArrayHasKey('test[secondKey]', $jsonBuilder->getValues());
    }

    public function test_set_value_without_escape_value()
    {
        $jsonBuilder = $this->given_a_mock_json_builder();

        $jsonBuilder->setValue('test[firstKey]', 'firstValue', false);

        $this->assertArrayHasKey('test[firstKey]', $jsonBuilder->getValues());
        $this->assertStringContainsString('ivory', $jsonBuilder->getValues()['test[firstKey]']);
    }

    public function test_remove_values_removes_the_values_for_the_specified_path()
    {
        $jsonBuilder = $this->given_a_mock_json_builder();

        $jsonBuilder->setValues([
            'firstKey'  => 'firstValue',
            'secondKey' => 'secondValue',
        ], 'test');

        $this->assertArrayHasKey('test[firstKey]', $jsonBuilder->getValues());
        $this->assertArrayHasKey('test[secondKey]', $jsonBuilder->getValues());

        $jsonBuilder->removeValue('test[firstKey]');
        $this->assertArrayNotHasKey('test[firstKey]', $jsonBuilder->getValues());

        $jsonBuilder->removeValue('test[secondKey]');
        $this->assertArrayNotHasKey('test[secondKey]', $jsonBuilder->getValues());
    }

    public function test_reset_values_resets_all_the_values()
    {
        $jsonBuilder = $this->given_a_mock_json_builder();

        $jsonBuilder->setValues([
            'firstKey'  => 'firstValue',
            'secondKey' => 'secondValue',
        ], 'test');

        $this->assertArrayHasKey('test[firstKey]', $jsonBuilder->getValues());
        $this->assertArrayHasKey('test[secondKey]', $jsonBuilder->getValues());

        $jsonBuilder->reset();

        $this->assertEmpty($jsonBuilder->getValues());
    }

    public function given_a_mock_json_builder(): JsonBuilder&MockObject
    {
        return $this->getMockBuilder(JsonBuilder::class)
            ->disableOriginalConstructor()
            ->addMethods([])
            ->getMock();
    }
}
