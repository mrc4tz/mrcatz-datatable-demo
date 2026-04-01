# MrCatz DataTable — Live Demo

**[View Live Demo](https://mrcatz-datatables-demo.xo.je)**

Product Management demo showcasing all features of the [mrcatz/datatable](https://github.com/mrc4tz/mrcatz-datatables) package.

## Features Demonstrated

- Multi-keyword search with relevance scoring & highlight
- Dependent filters (Category → Subcategory)
- Status filter (Active / Inactive)
- Export to Excel & PDF with filter scope and count preview
- Bulk select & delete with per-row control and modal confirmation
- Expandable rows (product details inline)
- Keyboard navigation (Arrow, Enter, Delete, Esc)
- Column resize & reorder (drag & drop)
- URL persistence (search, sort, filter, page, per_page)
- Filter presets (save/load from localStorage)
- Zebra table, sort indicators, loading overlay
- Toast notifications
- Multi-language support (EN/ID via config)

## Local Setup

```bash
git clone https://github.com/mrc4tz/mrcatz-datatable-demo.git
cd mrcatz-datatable-demo
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

Open http://localhost:8000

## Built With

- [Laravel](https://laravel.com) 12
- [Livewire](https://livewire.laravel.com) 3
- [mrcatz/datatable](https://github.com/mrc4tz/mrcatz-datatables) — the package being demoed
- [Tailwind CSS](https://tailwindcss.com) + [DaisyUI](https://daisyui.com)

## License

MIT
