<?php

/**
 * This file contains the DatabaseDMLQueryBuilderGetUpdateQueryTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the setup and the final query creation.
 *
 * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderGetUpdateQueryTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test getting an update query without specifying a table.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateUpdateModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryWithNoTable(): void
    {
        $this->expectException('\Lunr\Gravity\Database\Exceptions\MissingTableReferenceException');
        $this->expectExceptionMessage('No update() in update query!');

        $this->set_reflection_property_value('update_mode', [ 'LOW_PRIORITY', 'IGNORE' ]);
        $this->set_reflection_property_value('set', 'SET col1 = val1, col2 = val2');
        $this->set_reflection_property_value('where', 'WHERE 1 = 1');
        $this->set_reflection_property_value('order_by', 'ORDER BY col1');
        $this->set_reflection_property_value('limit', 'LIMIT 10');

        $this->class->get_update_query();
    }

    /**
     * Test getting an update query for single table.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateUpdateModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryForSingleTable(): void
    {
        $this->set_reflection_property_value('update', 'table1');
        $this->set_reflection_property_value('update_mode', [ 'LOW_PRIORITY', 'IGNORE' ]);
        $this->set_reflection_property_value('set', 'SET col1 = val1, col2 = val2');
        $this->set_reflection_property_value('where', 'WHERE 1 = 1');
        $this->set_reflection_property_value('order_by', 'ORDER BY col1');
        $this->set_reflection_property_value('limit', 'LIMIT 10');

        $string = 'UPDATE LOW_PRIORITY IGNORE table1 SET col1 = val1, col2 = val2 WHERE 1 = 1 ORDER BY col1 LIMIT 10';

        $this->assertEquals($string, $this->class->get_update_query());
    }

    /**
     * Test getting an update query for multiple tables.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateUpdateModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryForMultipleTables(): void
    {
        $this->set_reflection_property_value('update', 'table1, table2');
        $this->set_reflection_property_value('update_mode', [ 'LOW_PRIORITY', 'IGNORE' ]);
        $this->set_reflection_property_value('set', 'SET col1 = val1, col2 = val2');
        $this->set_reflection_property_value('where', 'WHERE 1 = 1');
        $this->set_reflection_property_value('order_by', 'ORDER BY col1');
        $this->set_reflection_property_value('limit', 'LIMIT 10');

        $string = 'UPDATE LOW_PRIORITY IGNORE table1, table2 SET col1 = val1, col2 = val2 WHERE 1 = 1';

        $this->assertEquals($string, $this->class->get_update_query());
    }

    /**
     * Test getting an update query for multiple tables using JOIN.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateUpdateModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryForMultipleTablesWithJoin(): void
    {
        $this->set_reflection_property_value('update', 'table1');
        $this->set_reflection_property_value('join', 'INNER JOIN table2');
        $this->set_reflection_property_value('update_mode', [ 'LOW_PRIORITY', 'IGNORE' ]);
        $this->set_reflection_property_value('set', 'SET col1 = val1, col2 = val2');
        $this->set_reflection_property_value('where', 'WHERE 1 = 1');
        $this->set_reflection_property_value('order_by', 'ORDER BY col1');
        $this->set_reflection_property_value('limit', 'LIMIT 10');

        $string = 'UPDATE LOW_PRIORITY IGNORE table1 INNER JOIN table2 SET col1 = val1, col2 = val2 WHERE 1 = 1';

        $this->assertEquals($string, $this->class->get_update_query());
    }

}

?>
