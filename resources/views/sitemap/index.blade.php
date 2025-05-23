<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($items as $value)
        <url>
            <loc>{{url($value->path)}}</loc>
            <lastmod>{{$value->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>{{$value->changefreq}}</changefreq>
            <priority>{{$value->priority}}</priority>
        </url>
    @endforeach
</urlset>
