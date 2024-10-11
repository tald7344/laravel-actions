<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($blogs as $blog)
        <url>
            <loc>{{ env('APP_URL') }}/blog/{{ $blog->id }}</loc>
            <lastmod>{{ date('Y-m-d') }}</lastmod>
            <changefreq>{{ $options['period'] }}</changefreq>
            <priority>{{ $options['priority'] }}</priority>
        </url>
    @endforeach
</urlset>
