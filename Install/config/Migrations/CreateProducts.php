<?php
use Migrations\AbstractMigration;

class CreateProductsTable extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {
        $table = $this->table('products');
        $table
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11
            ])
            ->addPrimaryKey('id')
            ->addColumn('name', 'string')
            ->addColumn('description', 'text')
            ->create();
    }
}