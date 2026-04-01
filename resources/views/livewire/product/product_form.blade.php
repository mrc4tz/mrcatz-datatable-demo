<div>
    @extends('mrcatz::components.ui.datatable-form')

    @section('forms')
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="form-control">
                    <div class="label"><span class="label-text">Product Name</span></div>
                    <input type="text" class="input input-bordered" wire:model="name" placeholder="e.g. iPhone 15 Pro" />
                    @error('name') <span class="text-error text-xs">{{ $message }}</span> @enderror
                </label>
                <label class="form-control">
                    <div class="label"><span class="label-text">SKU</span></div>
                    <input type="text" class="input input-bordered" wire:model="sku" placeholder="e.g. ELC-001" />
                    @error('sku') <span class="text-error text-xs">{{ $message }}</span> @enderror
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="form-control">
                    <div class="label"><span class="label-text">Category</span></div>
                    <select class="select select-bordered" wire:model="category_id">
                        <option value="">-- Select --</option>
                        @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-error text-xs">{{ $message }}</span> @enderror
                </label>
                <label class="form-control">
                    <div class="label"><span class="label-text">Subcategory</span></div>
                    <select class="select select-bordered" wire:model="subcategory_id">
                        <option value="">-- Select --</option>
                        @if($category_id)
                            @foreach(\App\Models\Subcategory::where('category_id', $category_id)->orderBy('name')->get() as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <label class="form-control">
                    <div class="label"><span class="label-text">Price</span></div>
                    <input type="number" class="input input-bordered" wire:model="price" placeholder="0" min="0" />
                    @error('price') <span class="text-error text-xs">{{ $message }}</span> @enderror
                </label>
                <label class="form-control">
                    <div class="label"><span class="label-text">Stock</span></div>
                    <input type="number" class="input input-bordered" wire:model="stock" placeholder="0" min="0" />
                    @error('stock') <span class="text-error text-xs">{{ $message }}</span> @enderror
                </label>
                <label class="form-control">
                    <div class="label"><span class="label-text">Status</span></div>
                    <select class="select select-bordered" wire:model="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </label>
            </div>

            <label class="form-control">
                <div class="label"><span class="label-text">Description</span></div>
                <textarea class="textarea textarea-bordered" wire:model="description" rows="3" placeholder="Product description..."></textarea>
            </label>
        </div>
    @endsection
</div>
