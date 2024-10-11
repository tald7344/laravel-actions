<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($data as $item)
        <url>
            <loc>{{ env('APP_URL') . $item['path'] }}</loc>
            <lastmod>{{ date('Y-m-d\TH:i:s+00:00') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1</priority>
        </url>
    @endforeach
</urlset>
