<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @for ($i = 1; $i <= $pagesNumber; $i++)
        <url>
            <loc>{{ env('APP_URL') }}/vendors?page={{ $i }}</loc>
            <lastmod>{{ date('Y-m-d') }}</lastmod>
            <changefreq>{{ $options['period'] }}</changefreq>
            <priority>{{ $options['priority'] }}</priority>
        </url>
    @endfor
</urlset>
