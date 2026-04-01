<div>
    @extends('mrcatz::components.ui.datatable-form')

    @section('forms')

        <label class="form-control w-full mb-3">
            <div class="label"><span class="label-text">Product Name</span></div>
            <input type="text" class="input input-bordered w-full" wire:model="name" placeholder="e.g. iPhone 15 Pro" />
            @error('name') <span class="text-error text-xs">{{ $message }}</span> @enderror
        </label>

        <label class="form-control w-full mb-3">
            <div class="label"><span class="label-text">SKU</span></div>
            <input type="text" class="input input-bordered w-full" wire:model="sku" placeholder="e.g. ELC-001" />
            @error('sku') <span class="text-error text-xs">{{ $message }}</span> @enderror
        </label>

        <label class="form-control w-full mb-3">
            <div class="label"><span class="label-text">Category</span></div>
            <select class="select select-bordered w-full" wire:model.live="category_id">
                <option value="">-- Select --</option>
                @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-error text-xs">{{ $message }}</span> @enderror
        </label>

        <label class="form-control w-full mb-3">
            <div class="label"><span class="label-text">Subcategory</span></div>
            <select class="select select-bordered w-full" wire:model="subcategory_id">
                <option value="">-- Select --</option>
                @if($category_id)
                    @foreach(\App\Models\Subcategory::where('category_id', $category_id)->orderBy('name')->get() as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                @endif
            </select>
        </label>

        <label class="form-control w-full mb-3">
            <div class="label"><span class="label-text">Price</span></div>
            <input type="number" class="input input-bordered w-full" wire:model="price" placeholder="0" min="0" />
            @error('price') <span class="text-error text-xs">{{ $message }}</span> @enderror
        </label>

        <label class="form-control w-full mb-3">
            <div class="label"><span class="label-text">Stock</span></div>
            <input type="number" class="input input-bordered w-full" wire:model="stock" placeholder="0" min="0" />
            @error('stock') <span class="text-error text-xs">{{ $message }}</span> @enderror
        </label>

        <label class="form-control w-full mb-3">
            <div class="label"><span class="label-text">Status</span></div>
            <select class="select select-bordered w-full" wire:model="status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </label>

        <label class="form-control w-full">
            <div class="label"><span class="label-text">Description</span></div>
            <textarea class="textarea textarea-bordered w-full" wire:model="description" rows="3" placeholder="Product description..."></textarea>
        </label>

    @endsection
</div>
