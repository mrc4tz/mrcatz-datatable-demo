# MrCatz DataTable — Demo

Live demo of [mrcatz/datatable](https://github.com/mrcatz/datatable) package showcasing all features with a Product Management page.

## Features Demonstrated

- Multi-keyword search with relevance scoring
- Dependent filters (Category → Subcategory)
- Export to Excel & PDF with filter scope
- Bulk select & delete with per-row control
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
git clone <repo-url> mrcatz-demo
cd mrcatz-demo
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

Open http://localhost:8000

## Deploy to Railway

1. Push to GitLab/GitHub
2. Connect repo on [railway.app](https://railway.app)
3. Add MySQL service
4. Set environment variables:
   ```
   APP_KEY=base64:...
   DB_CONNECTION=mysql
   DB_HOST=<from railway>
   DB_DATABASE=<from railway>
   DB_USERNAME=<from railway>
   DB_PASSWORD=<from railway>
   ```
5. Build command: `composer install && npm install && npm run build && php artisan migrate --seed --force`
6. Start command: `php artisan serve --host=0.0.0.0 --port=$PORT`
