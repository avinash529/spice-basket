import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
    },
});
```

---

## Fix 3 — Add ASSET_URL to Environment

In Render **Environment** tab, add this new variable:
```
ASSET_URL = https://spicebasket.onrender.com