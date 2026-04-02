<?php

namespace App\Livewire\Product;

use MrCatz\DataTable\MrCatzDataTableFilter;
use MrCatz\DataTable\MrCatzDataTables;
use MrCatz\DataTable\MrCatzDataTablesComponent;
use Illuminate\Support\Facades\DB;

class ProductTable extends MrCatzDataTablesComponent
{
    public $showSearch = true;
    public $showAddButton = true;
    public $showExportButton = true;
    public $exportTitle = 'Product Data';
    public $bulkPrimaryKey = 'id';
    public $showBulkButton = true;
    public $expandableRows = true;
    public $withLoading = false;

    public function configTable()
    {
        return ['table_name' => 'products', 'table_id' => 'id'];
    }

    public function baseQuery()
    {
        return DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'subcategories.name as subcategory_name'
            );
    }

    public function setTable()
    {
        return $this->CreateMrCatzTable()
            ->enableBulk(fn($data, $i) => true)
            ->enableExpand(function ($data, $i) {
                return MrCatzDataTables::getExpandView($data, [
                    'SKU' => 'sku',
                    'Category' => 'category_name',
                    'Subcategory' => 'subcategory_name',
                    'Stock' => 'stock',
                    'Description' => 'description',
                    'Created' => 'created_at',
                ]);
            })
            ->enableEditable(function ($data, $i, $column_key) {
                return $data->category_id === 1;
            })
            ->withColumnIndex('No')
            ->withColumn('Product', 'products.name', editable: true, rules: 'required|max:255')
            ->withColumn('SKU', 'sku')
        ->withCustomColumn('Category', function ($data, $i) {

            $sub =  $this->setSearchWord( $data->subcategory_name ? ' / ' . $data->subcategory_name : '');
            return '<span class="text-xs">' .  $this->setSearchWord($data->category_name) . '<span class="text-base-content/40">' . $sub . '</span></span>';
        }, 'categories.name', true)
        ->withCustomColumn('Price', function ($data, $i) {
            return '<span class="font-mono text-sm">Rp ' . number_format($data->price, 0, ',', '.') . '</span>';
        }, 'products.price', true)
        ->withCustomColumn('Status', function ($data, $i) {
            $badge = $data->status === 'active' ? 'badge-success' : 'badge-error';
            $label = ucfirst($data->status);
            return '<span class="badge ' . $badge . ' badge-sm text-white">' . $label . '</span>';
        }, 'products.status', false)
        ->withCustomColumn('Actions', function ($data, $i) {
            return MrCatzDataTables::getActionView($data, $i, true, true);
        });
    }

    public function setFilter()
    {
        // Category filter
        $categories = json_decode(json_encode(
            DB::table('categories')->orderBy('name')->get()->toArray()
        ), true);

        $categoryFilter = MrCatzDataTableFilter::create(
            'filter_category', 'Category', $categories, 'id', 'name', 'products.category_id'
        )->get();

        // Subcategory filter — hidden by default, shown when category selected
        $subcategoryFilter = MrCatzDataTableFilter::create(
            'filter_subcategory', 'Subcategory', [], 'id', 'name', 'products.subcategory_id', false
        )->get();

        // Status filter
        $statusFilter = MrCatzDataTableFilter::create(
            'filter_status', 'Status',
            [['value' => 'active', 'label' => 'Active'], ['value' => 'inactive', 'label' => 'Inactive']],
            'value', 'label', 'products.status'
        )->get();

        return [$categoryFilter, $subcategoryFilter, $statusFilter];
    }

    public function onFilterChanged($id, $value)
    {
        if ($id === 'filter_category') {
            $this->resetFilter('filter_subcategory');

            if (!empty($value)) {
                $subs = json_decode(json_encode(
                    DB::table('subcategories')->where('category_id', $value)->orderBy('name')->get()->toArray()
                ), true);
                $this->setFilterData('filter_subcategory', $subs);
                $this->setFilterShow('filter_subcategory', true);
            } else {
                $this->setFilterShow('filter_subcategory', false);
            }
        }
    }

    public function getRowPerPageOption()
    {
        return [10, 15, 25, 50];
    }
}
