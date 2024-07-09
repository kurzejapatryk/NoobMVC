<?php

use PHPUnit\Framework\TestCase;
use Core\ApiResponse;
use Core\Db;
use Core\Model;

class TestModel extends Model
{
    protected static $table = 'tests';
    protected static $schema = [
        'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
        'name' => 'VARCHAR(255) NOT NULL',
        'value' => 'VARCHAR(255) NOT NULL',
    ];

    public $id;
    public $name;
    public $value;
}

class ModelTest extends TestCase
{
   
    public function testCreateTable()
    {
        TestModel::createTable();
        $this->assertTrue(Db::tableExists('tests'));
    }

    public function test__construct()
    {
        $model = new TestModel(1);
        $this->assertInstanceOf(Model::class, $model);
        $this->assertEquals(1, $model->id);
    }

    public function test__get()
    {
        $model = new TestModel();
        $model->name = 'name';
        $this->assertEquals('name', $model->name);
    }

    public function test__set()
    {
        $model = new TestModel();
        $model->name = 'name';
        $this->assertEquals('name', $model->name);
    }

    public function test__isset()
    {
        $model = new TestModel();
        $model->name = 'name';
        $this->assertTrue(isset($model->name));
    }

    public function test__unset()
    {
        $model = new TestModel();
        $model->name = 'name';
        unset($model->name);
        $this->assertFalse(isset($model->name));
    }

    public function testgetTableName()
    {
        $model = new TestModel();
        $this->assertEquals('tests', $model->getTableName());
    }

    public function testgetTableSchema()
    {
        $model = new TestModel();
        $schema = [
            'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
            'name' => 'VARCHAR(255) NOT NULL',
            'value' => 'VARCHAR(255) NOT NULL',
        ];

        $this->assertEquals($schema, $model->getTableSchema());
    }

    public function testget()
    {
        $model = new TestModel();
        $model->name = 'name';
        $model->value = 'value';
        $model->save();

        $model = new TestModel($model->id);
        $this->assertEquals('name', $model->name);
        $this->assertEquals('value', $model->value);
    }

    public function testsave()
    {
        $model = new TestModel();
        $model->name = 'name';
        $model->value = 'value';
        $model->save();

        $model = new TestModel($model->id);
        $this->assertEquals('name', $model->name);
        $this->assertEquals('value', $model->value);
    }

    public function testdelete()
    {
        $model = new TestModel();
        $model->name = 'name';
        $model->value = 'value';
        $model->save();

        $model->del();

        $model = new TestModel($model->id);
        $this->assertNull($model->name);
        $this->assertNull($model->value);
    }

    public function testSearch()
    {
        $model = new TestModel();
        $model->name = 'name';
        $model->value = 'value';
        $model->save();

        $model = new TestModel();
        $model->name = 'name2';
        $model->value = 'value2';
        $model->save();

        $model = new TestModel();
        $model->name = 'name3';
        $model->value = 'value3';
        $model->save();

        $model = new TestModel();
        $model->name = 'name2';

        $model->search();

        $this->assertEquals('name2', $model->name);
        $this->assertEquals('value2', $model->value);
    }   

    public function testDropTable()
    {
        $model = new TestModel();
        $model->dropTable();
        $this->assertFalse(Db::tableExists('test'));
    }

    public function testgetAll()
    {
        TestModel::createTable();

        $model = new TestModel();
        $model->name = 'name';
        $model->value = 'value';
        $model->save();

        $model = new TestModel();
        $model->name = 'name2';
        $model->value = 'value2';
        $model->save();

        $model = new TestModel();
        $model->name = 'name3';
        $model->value = 'value3';
        $model->save();

        $result = TestModel::getAll();
        $this->assertCount(3, $result);

        $model->dropTable();
        
    }  
}