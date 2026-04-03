<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\WithFileUploads;
use MrCatz\DataTable\MrCatzComponent;
use MrCatz\DataTable\MrCatzFormField;
class ProductPage extends MrCatzComponent
{
    use WithFileUploads;

    public $name, $sku, $category_id, $subcategory_id, $price, $stock, $status, $description;
    public $image_file, $imageUrl;

    public function setForm(): array
    {
        return [
            MrCatzFormField::text('name', label: 'Product Name', rules: 'required|max:255', icon: 'person'),
            MrCatzFormField::text('sku', label: 'SKU', rules: 'required|max:50', icon: 'alternate_email')->span(6),
            MrCatzFormField::number('price', label: 'Price', rules: 'required|numeric|min:0')
                ->prefix('Rp')->span(6),
            MrCatzFormField::select('category_id', label: 'Category',
                data: Category::all()->toArray(),
                value: 'id', option: 'name',
                rules: 'required',
            )->span(6)->live()->onChange('categoryChanged'),
            MrCatzFormField::select('subcategory_id', label: 'Subcategory',
                data: $this->category_id ? Subcategory::where('category_id', $this->category_id)->get()->toArray() : [],
                value: 'id', option: 'name',
            )->span(6)->dependsOn('category_id'),
            MrCatzFormField::number('stock', label: 'Stock', rules: 'required|integer|min:0')->span(6),
            MrCatzFormField::select('status', label: 'Status',
                data: [['value' => 'active', 'label' => 'Active'], ['value' => 'inactive', 'label' => 'Inactive']],
                value: 'value', option: 'label',
                rules: 'required',
            )->span(6),
            MrCatzFormField::textarea('description', label: 'Description', placeholder: 'Product description...'),
            MrCatzFormField::fileupload('image_file', label: 'Product Image',
                accept: 'image/jpg,image/jpeg,image/png,image/webp',
            )->preview($this->imageUrl, width: 80, height: 80)
              ->hint('Optional. JPG, PNG, WEBP. Max 2MB.'),
        ];
    }

    public function categoryChanged($value)
    {
        $this->subcategory_id = null;
    }

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
        $this->reset(['name', 'sku', 'category_id', 'subcategory_id', 'price', 'stock', 'status', 'description', 'image_file', 'imageUrl']);
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
        $this->imageUrl = $data['image'] ? asset($data['image']) : null;
        $this->image_file = null;
    }

    public function prepareDeleteData($data)
    {
        $this->id = $data['id'];
        $this->deleted_text = $data['name'] . ' (' . $data['sku'] . ')';
    }

    public function saveData()
    {
        $this->validate(
            $this->getFormValidationRules(),
            $this->getFormValidationMessages()
        );

        // Handle image upload to public/uploads/products
        $imagePath = null;
        if ($this->image_file) {
            $this->validate(['image_file' => 'image|mimes:jpg,png,jpeg,webp|max:2048']);
            $filename = 'product-' . time() . '.' . $this->image_file->getClientOriginalExtension();
            $dest = public_path('uploads/products/' . $filename);
            copy($this->image_file->getRealPath(), $dest);
            $imagePath = 'uploads/products/' . $filename;
        }

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
            $product = Product::find($this->id);
            if ($imagePath) {
                if ($product->image && file_exists(public_path($product->image))) @unlink(public_path($product->image));
                $data['image'] = $imagePath;
            }
            $product->update($data);
            $this->dispatch_to_view(true, 'update');
        } else {
            if ($imagePath) $data['image'] = $imagePath;
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
