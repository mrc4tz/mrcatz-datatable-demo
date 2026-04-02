<?php

namespace App\Livewire\Product;

use App\Models\Product;
use MrCatz\DataTable\MrCatzComponent;

class ProductPage extends MrCatzComponent
{
    public $name, $sku, $category_id, $subcategory_id, $price, $stock, $status, $description;

    public function mount()
    {
        $this->setTitle('Product');
    }

    public function render()
    {
        return view('livewire.product.product-page')
            ->layout('components.layouts.app');
    }

    public function prepareAddData()
    {
        $this->form_title = 'Add Product';
        $this->resetErrorBag();
        $this->reset(['name', 'sku', 'category_id', 'subcategory_id', 'price', 'stock', 'status', 'description']);
        $this->status = 'active';
    }

    public function prepareEditData($data)
    {
        $this->id = $data['id'];
        $this->form_title = 'Edit Product';
        $this->resetErrorBag();
        $this->name = $data['name'];
        $this->sku = $data['sku'];
        $this->category_id = $data['category_id'];
        $this->subcategory_id = $data['subcategory_id'];
        $this->price = $data['price'];
        $this->stock = $data['stock'];
        $this->status = $data['status'];
        $this->description = $data['description'];
    }

    public function prepareDeleteData($data)
    {
        $this->id = $data['id'];
        $this->deleted_text = $data['name'] . ' (' . $data['sku'] . ')';
    }

    public function saveData()
    {
        $this->validate([
            'name' => 'required|max:255',
            'sku' => 'required|max:50',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'name' => $this->name,
            'sku' => $this->sku,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id ?: null,
            'price' => $this->price,
            'stock' => $this->stock,
            'status' => $this->status,
            'description' => $this->description,
        ];

        if ($this->isEdit) {
            Product::find($this->id)->update($data);
            $this->dispatch_to_view(true, 'update');
        } else {
            $product = Product::create($data);
            $this->dispatch_to_view($product, 'insert');
        }
    }

    public function dropData()
    {
        $product = Product::find($this->id);
        if (!$product) {
            $this->show_notif('error', 'Product not found!');
            return;
        }
        $delete = $product->delete();
        $this->dispatch_to_view($delete, 'delete');
    }

    public function dropBulkData($selectedRows)
    {
        if (empty($selectedRows)) return;
        $count = Product::whereIn('id', $selectedRows)->delete();
        $this->dispatch('refresh-data', [
            'status' => true,
            'text' => $count . ' products deleted!'
        ]);
    }

    public function onInlineUpdate($rowData, $columnKey, $newValue)
    {
        Product::where('id', $rowData['id'])->update([$columnKey => $newValue]);
        $this->dispatch_to_view(true, 'update');
    }
}
