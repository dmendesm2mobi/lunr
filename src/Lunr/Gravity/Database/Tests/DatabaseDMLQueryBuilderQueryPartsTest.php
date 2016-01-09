<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the query parts methods.
 *
 * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the select part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelect()
    {
        $method = $this->get_accessible_reflection_method('sql_select');

        $method->invokeArgs($this->class, [ 'col' ]);

        $string = 'col';

        $this->assertPropertyEquals('select', $string);
    }

    /**
     * Test specifying the select part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelect()
    {
        $method = $this->get_accessible_reflection_method('sql_select');

        $method->invokeArgs($this->class, [ 'col' ]);
        $method->invokeArgs($this->class, [ 'col' ]);

        $string = 'col, col';

        $this->assertPropertyEquals('select', $string);
    }

    /**
     * Test specifying the UNION part of a query.
     *
     * @param String $types Compound query operator
     *
     * @dataProvider compoundQueryTypeProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_compound
     */
    public function testCompoundQuery($types)
    {
        $method = $this->get_accessible_reflection_method('sql_compound');

        $method->invokeArgs($this->class, [ '(sql query)', $types ]);

        $string = $types . ' (sql query)';

        $this->assertPropertyEquals('compound', $string);
    }

    /**
     * Test specifying the UNION part of a query, when compound is set.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_compound
     */
    public function testCompoundQueryWhenCompoundIsSet()
    {
        $this->set_reflection_property_value('compound', 'QUERY');

        $method = $this->get_accessible_reflection_method('sql_compound');

        $method->invokeArgs($this->class, [ '(sql query)', 'UNION' ]);

        $this->assertPropertyEquals('compound', 'QUERY UNION (sql query)');
    }

    /**
     * Test creating a simple order by statement.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_order_by
     */
    public function testOrderByWithDefaultOrder()
    {
        $string = 'ORDER BY col1 ASC';

        $method = $this->get_accessible_reflection_method('sql_order_by');

        $method->invokeArgs($this->class, [ 'col1' ]);

        $this->assertPropertyEquals('order_by', $string);
    }

    /**
     * Test creating a order by statement with custom order.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_order_by
     */
    public function testOrderByWithCustomOrder()
    {
        $string = 'ORDER BY col1 DESC';

        $method = $this->get_accessible_reflection_method('sql_order_by');

        $method->invokeArgs($this->class, [ 'col1', FALSE ]);

        $this->assertPropertyEquals('order_by', $string);
    }

    /**
     * Test creating and extending a order by statement.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_order_by
     */
    public function testOrderByWithExtendedStatement()
    {
        $value = 'ORDER BY col1 DESC';

        $this->set_reflection_property_value('order_by', $value);

        $method = $this->get_accessible_reflection_method('sql_order_by');

        $method->invokeArgs($this->class, [ 'col2', FALSE ]);

        $string = 'ORDER BY col1 DESC, col2 DESC';

        $this->assertPropertyEquals('order_by', $string);
    }

    /**
     * Test creating a simple group by statement.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_by
     */
    public function testGroupBy()
    {
        $string = 'GROUP BY group1';

        $method = $this->get_accessible_reflection_method('sql_group_by');

        $method->invokeArgs($this->class, [ 'group1' ]);

        $this->assertPropertyEquals('group_by', $string);
    }

    /**
     * Test creating and extending a group by statement.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_by
     */
    public function testGroupByExtending()
    {
        $value = 'GROUP BY group1';

        $this->set_reflection_property_value('group_by', $value);

        $method = $this->get_accessible_reflection_method('sql_group_by');

        $method->invokeArgs($this->class, array('group2'));

        $string = 'GROUP BY group1, group2';

        $this->assertPropertyEquals('group_by', $string);
    }

    /**
     * Test creating a limit statement with default offset.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_limit
     */
    public function testLimitWithDefaultOffset()
    {
        $string = 'LIMIT 10';

        $method = $this->get_accessible_reflection_method('sql_limit');

        $method->invokeArgs($this->class, [ '10' ]);

        $this->assertPropertyEquals('limit', $string);
    }

    /**
     * Test creating a limit statement with custom offset.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_limit
     */
    public function testLimitWithCustomOffset()
    {
        $string = 'LIMIT 10 OFFSET 20';

        $method = $this->get_accessible_reflection_method('sql_limit');

        $method->invokeArgs($this->class, [ '10', '20' ]);

        $this->assertPropertyEquals('limit', $string);
    }

    /**
    * Test grouping condition start.
    *
    * @param String $keyword   The expected statement keyword
    * @param String $attribute The name of the property where the statement is stored
    *
    * @dataProvider conditionalKeywordProvider
    * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
    */
    public function testOpenGroup($keyword, $attribute)
    {
        $method = $this->get_accessible_reflection_method('sql_group_start');
        $method->invokeArgs($this->class, [ $keyword ]);

        $this->assertEquals('(', $this->get_reflection_property_value($attribute));
    }

    /**
    * Test grouping condition start with active join statement.
    *
    * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
    */
    public function testOpenGroupIfJoin()
    {
        $this->set_reflection_property_value('is_join', TRUE);

        $method = $this->get_accessible_reflection_method('sql_group_start');
        $method->invokeArgs($this->class, [ 'ON' ]);

        $this->assertEquals('ON (', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_join'));
    }

    /**
    * Test grouping condition start.
    *
    * @param String $keyword   The expected statement keyword
    * @param String $attribute The name of the property where the statement is stored
    *
    * @dataProvider conditionalKeywordProvider
    * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
    */
    public function testOpenGroupWithConnector($keyword, $attribute)
    {
        $this->set_reflection_property_value('connector', 'OR');

        $method = $this->get_accessible_reflection_method('sql_group_start');
        $method->invokeArgs($this->class, [ $keyword ]);

        $this->assertEquals(' OR (', $this->get_reflection_property_value($attribute));
        $this->assertEquals('', $this->get_reflection_property_value('connector'));
    }

    /**
    * Test incremental grouping condition start.
    *
    * @param String $keyword   The expected statement keyword
    * @param String $attribute The name of the property where the statement is stored
    *
    * @dataProvider conditionalKeywordProvider
    * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
    */
    public function testIncrementalOpenGroup($keyword, $attribute)
    {
        $method = $this->get_accessible_reflection_method('sql_group_start');
        $method->invokeArgs($this->class, [ $keyword ]);
        $method->invokeArgs($this->class, [ $keyword ]);

        $this->assertEquals('((', $this->get_reflection_property_value($attribute));
    }

    /**
    * Test grouping condition start uses AND connector by default if there is already a condition.
    *
    * @param String $keyword   The expected statement keyword
    * @param String $attribute The name of the property where the statement is stored
    *
    * @dataProvider conditionalKeywordProvider
    * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
    */
    public function testOpenGroupUsesDefaultConnector($keyword, $attribute)
    {
        $this->set_reflection_property_value($attribute, 'Condition');

        $method = $this->get_accessible_reflection_method('sql_group_start');
        $method->invokeArgs($this->class, [ $keyword ]);

        $this->assertEquals('Condition AND (', $this->get_reflection_property_value($attribute));
    }

    /**
     * Test closing the parentheses for grouped condition.
     *
     * @param String $keyword   The expected statement keyword
     * @param String $attribute The name of the property where the statement is stored
     *
     * @dataProvider conditionalKeywordProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_end
     */
    public function testCloseGroup($keyword, $attribute)
    {
        $this->set_reflection_property_value($attribute, '');

        $method = $this->get_accessible_reflection_method('sql_group_end');
        $method->invokeArgs($this->class, [ $keyword ]);

        $this->assertEquals(')', $this->get_reflection_property_value($attribute));
    }

}

?>
