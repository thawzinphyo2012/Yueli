<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\ContentBlock;
use App\Models\Lookbook;
use App\Models\PortfolioProject;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@yuelistudio.com'],
            [
                'name' => 'Yueli Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'guest@example.com'],
            [
                'name' => 'Aya Min',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'phone' => '+95 9 123 456 789',
                'city' => 'Yangon',
                'country' => 'Myanmar',
                'email_verified_at' => now(),
            ]
        );

        $settings = [
            'site_name' => 'Yueli Studio',
            'tagline' => 'A feminine editorial house of cloth, image, and quiet form.',
            'contact_email' => 'studio@yuelistudio.com',
            'contact_phone' => '+95 1 234 5678',
            'address' => '12 Atelier Lane, Yangon',
            'instagram' => 'https://instagram.com/yuelistudio',
            'shipping_fee' => '5',
            'currency' => 'USD',
            'about_short' => 'Yueli Studio is a contemporary fashion house — part magazine, part atelier, part boutique.',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        ContentBlock::query()->updateOrCreate(
            ['key' => 'home_hero'],
            [
                'title' => 'Clothing shaped by light',
                'subtitle' => 'Season 26 — Soft Structure',
                'body' => 'Silence, form, and the discipline of cloth — made to be worn, not performed.',
                'image' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=2000&q=80',
                'cta_label' => 'Shop the edit',
                'cta_url' => '/shop',
                'page' => 'home',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        ContentBlock::query()->updateOrCreate(
            ['key' => 'home_about'],
            [
                'title' => 'An atelier of quiet precision',
                'subtitle' => 'Brand',
                'body' => 'We build small collections with lasting silhouettes — tailored cloth, considered proportion, and photography that feels like film stills.',
                'image' => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1400&q=80',
                'cta_label' => 'Our story',
                'cta_url' => '/about',
                'page' => 'home',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        ContentBlock::query()->updateOrCreate(
            ['key' => 'portfolio_intro'],
            [
                'title' => 'Designer portfolio',
                'subtitle' => 'Selected work',
                'body' => "Process, fittings, and collaborations — the artistic side of the house.\n\nFrom first muslin to campaign light, every study is treated as an editorial object. We document shoulder slope, soft volume, and the quiet discipline of cloth so the wardrobe can feel like a magazine spread — never louder than the person wearing it.",
                'page' => 'portfolio',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        ContentBlock::query()->updateOrCreate(
            ['key' => 'about_manifesto'],
            [
                'title' => 'Made to be worn, not performed',
                'subtitle' => 'Philosophy',
                'body' => 'Yueli Studio began as a private fitting room practice. Every piece is drafted for movement, then photographed as an editorial object — never louder than the person wearing it.',
                'image' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=1600&q=80',
                'page' => 'about',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        ContentBlock::query()->updateOrCreate(
            ['key' => 'about_process'],
            [
                'title' => 'From sketch to campaign',
                'subtitle' => 'Process',
                'body' => 'We prototype in natural fibers, refine through fittings, and finish with lookbook sessions that document texture before commerce.',
                'page' => 'about',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        $soft = Collection::query()->updateOrCreate(
            ['slug' => 'soft-structure'],
            [
                'name' => 'Soft Structure',
                'season' => 'SS26',
                'description' => "Architectural drape in washed linen and fluid wool.\n\nSoft Structure begins with the shoulder — a gentle slope that carries the rest of the silhouette without force. Linen is washed until it remembers the body; wool is chosen for movement rather than weight.\n\nThis chapter is for heat and long light: columns, wraps, and forms that hold presence without performance.",
                'cover_image' => 'https://images.unsplash.com/photo-1581044777550-4cfa60707c03?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ]
        );

        $night = Collection::query()->updateOrCreate(
            ['slug' => 'night-atelier'],
            [
                'name' => 'Night Atelier',
                'season' => 'AW25',
                'description' => "Evening pieces with deep petrol tones and muted metallics.\n\nNight Atelier is the hour after dusk — silk that catches a lamp, trousers with a quiet crease, shirts cut for the table and the walk home.\n\nPalette and proportion do the speaking; ornament stays nearly invisible.",
                'cover_image' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ]
        );

        $line = Collection::query()->updateOrCreate(
            ['slug' => 'studio-line'],
            [
                'name' => 'Studio Line',
                'season' => 'Essentials',
                'description' => "Everyday forms with precise seams and lasting cloth.\n\nStudio Line treats the wardrobe constant as an editorial object — dense jersey, canvas overshirts, and seams that stay honest after years of wear.\n\nBuilt to layer under campaigns and over quiet mornings alike.",
                'cover_image' => 'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ]
        );

        $products = [
            [
                'collection_id' => $soft->id,
                'name' => 'Ivory Crew Tee',
                'slug' => 'linen-column-dress',
                'sku' => 'YS-SSD-001',
                'short_description' => 'Soft cotton crew with a clean hem.',
                'description' => 'A heavyweight ivory tee cut with a narrow neck and a quiet, straight sleeve.',
                'price' => 248,
                'compare_at_price' => 290,
                'stock' => 18,
                'sizes' => ['XS', 'S', 'M', 'L'],
                'colors' => ['Ivory', 'Bone'],
                'primary_image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1523381294911-8d3cead13475?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=1200&q=80',
                ],
                'is_featured' => true,
            ],
            [
                'collection_id' => $soft->id,
                'name' => 'Ink Heavyweight Tee',
                'slug' => 'fluid-wool-wrap',
                'sku' => 'YS-SSD-002',
                'short_description' => 'Dense black jersey with a firm shoulder.',
                'description' => 'An ink cotton tee that keeps its shape, with a short sleeve and a clean crew.',
                'price' => 320,
                'stock' => 12,
                'sizes' => ['S', 'M', 'L'],
                'colors' => ['Ink', 'Black'],
                'primary_image' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
            ],
            [
                'collection_id' => $night->id,
                'name' => 'Stacked Studio Tees',
                'slug' => 'petrol-silk-shirt',
                'sku' => 'YS-NA-001',
                'short_description' => 'A folded set of everyday cotton tees.',
                'description' => 'Washed cotton tees in a small stack — easy color, easy layer.',
                'price' => 198,
                'stock' => 25,
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'colors' => ['White', 'Blue', 'Red'],
                'primary_image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
            ],
            [
                'collection_id' => $night->id,
                'name' => 'Bone Box Tee',
                'slug' => 'champagne-tailored-trouser',
                'sku' => 'YS-NA-002',
                'short_description' => 'A bright cotton tee with a square hem.',
                'description' => 'Crisp bone jersey, slightly boxy, made to sit clean under a jacket.',
                'price' => 210,
                'stock' => 16,
                'sizes' => ['S', 'M', 'L'],
                'colors' => ['Bone'],
                'primary_image' => 'https://images.unsplash.com/photo-1562157873-818bc0726f68?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
            ],
            [
                'collection_id' => $line->id,
                'name' => 'Studio Everyday Tee',
                'slug' => 'studio-everyday-tee',
                'sku' => 'YS-SL-001',
                'short_description' => 'Heavyweight cotton tee with refined sleeve.',
                'description' => 'A wardrobe constant — dense cotton jersey with a narrow crew and clean hem.',
                'price' => 68,
                'stock' => 40,
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'colors' => ['Ink', 'Bone'],
                'primary_image' => 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
            ],
            [
                'collection_id' => $line->id,
                'name' => 'Stone Oversized Tee',
                'slug' => 'structured-overshirt',
                'sku' => 'YS-SL-002',
                'short_description' => 'Loose cotton tee with a dropped shoulder.',
                'description' => 'An oversized stone tee for easy days, cut long through the body.',
                'price' => 175,
                'stock' => 22,
                'sizes' => ['S', 'M', 'L'],
                'colors' => ['Stone', 'Olive'],
                'primary_image' => 'https://images.unsplash.com/photo-1503341504253-dff4815485f1?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, ['is_published' => true])
            );
        }

        Lookbook::query()->updateOrCreate(
            ['slug' => 'soft-structure-campaign'],
            [
                'collection_id' => $soft->id,
                'title' => 'Soft Structure Campaign',
                'description' => "Shot at dawn on concrete and linen — a study of pale light on structure.\n\nThe Soft Structure campaign follows the garment as it moves through heat, shadow, and stillness. Each frame holds the drape a moment longer than commerce usually allows — cloth before catalogue, presence before product.\n\nWe photographed in quiet courtyards and open corridors, letting architecture answer the silhouette.",
                'cover_image' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=1600&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1581044777550-4cfa60707c03?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1200&q=80',
                ],
                'photographer' => 'M. Aung',
                'location' => 'Yangon',
                'is_campaign' => true,
                'is_published' => true,
                'sort_order' => 1,
            ]
        );

        Lookbook::query()->updateOrCreate(
            ['slug' => 'night-atelier-campaign'],
            [
                'collection_id' => $night->id,
                'title' => 'Night Atelier Campaign',
                'description' => "Evening cloth under low lamps — petrol silk, champagne wool, and the hush between rooms.\n\nNight Atelier is less about spectacle and more about the hour after dusk, when dressing becomes ritual. Long sleeves, soft metallics, and shadows that forgive the body.",
                'cover_image' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?auto=format&fit=crop&w=1600&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1200&q=80',
                ],
                'photographer' => 'L. Hnin',
                'location' => 'Indoor set · Yangon',
                'is_campaign' => true,
                'is_published' => true,
                'sort_order' => 2,
            ]
        );

        Lookbook::query()->updateOrCreate(
            ['slug' => 'night-atelier-lookbook'],
            [
                'collection_id' => $night->id,
                'title' => 'Night Atelier Lookbook',
                'description' => "Low light, long sleeves, and reflective champagne accents.\n\nAn editorial study of proportion — how a collar holds the face, how a crease travels down the leg, how fabric remembers the last fitting.",
                'cover_image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1600&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?auto=format&fit=crop&w=1200&q=80',
                ],
                'photographer' => 'Studio Team',
                'location' => 'Indoor set',
                'is_campaign' => false,
                'is_published' => true,
                'sort_order' => 3,
            ]
        );

        Lookbook::query()->updateOrCreate(
            ['slug' => 'linen-and-heat'],
            [
                'collection_id' => $soft->id,
                'title' => 'Linen & Heat',
                'description' => "A mid-season editorial on washed linen in open air.\n\nBreath, crease, and the honesty of natural fiber — photographed where the wind can touch the hem. No studio fog, only sun and the patience of cloth.",
                'cover_image' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=1600&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1566174053879-31528523f8ae?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=1200&q=80',
                ],
                'photographer' => 'M. Aung',
                'location' => 'Coastal terrace',
                'is_campaign' => false,
                'is_published' => true,
                'sort_order' => 4,
            ]
        );

        Lookbook::query()->updateOrCreate(
            ['slug' => 'studio-line-portraits'],
            [
                'collection_id' => $line->id,
                'title' => 'Studio Line Portraits',
                'description' => "Everyday forms, still treated as editorial objects.\n\nTees, overshirts, and precise seams — framed like magazine pages so the wardrobe constant feels considered, not invisible.",
                'cover_image' => 'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?auto=format&fit=crop&w=1600&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1581044777550-4cfa60707c03?auto=format&fit=crop&w=1200&q=80',
                ],
                'photographer' => 'Studio Team',
                'location' => 'Atelier daylight',
                'is_campaign' => false,
                'is_published' => true,
                'sort_order' => 5,
            ]
        );

        PortfolioProject::query()->updateOrCreate(
            ['slug' => 'seasonal-fitting-study'],
            [
                'title' => 'Seasonal Fitting Study',
                'client' => 'Yueli Internal',
                'role' => 'Design direction',
                'year' => '2025',
                'excerpt' => 'A research series on shoulder slope and soft volume — thirty fittings distilled into one silhouette language.',
                'body' => "We documented thirty fittings to refine the Soft Structure block. Pins, chalk, and daylight became the grammar of the season.\n\nThe outcome became the column dress and wrap coat now in the shop — garments that hold shape without announcing themselves.\n\nEvery study is archived as both process note and editorial still: fabric under window light, seams in profile, the quiet discipline of cloth.",
                'cover_image' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1581044777550-4cfa60707c03?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1200&q=80',
                ],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ]
        );

        PortfolioProject::query()->updateOrCreate(
            ['slug' => 'editorial-still-life'],
            [
                'title' => 'Editorial Still Life',
                'client' => 'Independent press',
                'role' => 'Styling & art direction',
                'year' => '2024',
                'excerpt' => 'Object photography for fabric stories without the body — cloth as memory, light as narrator.',
                'body' => "A collaboration exploring how cloth holds memory when removed from the silhouette.\n\nPinned sleeves, folded hems, and shadowed folds become the cast. The series was shot for independent press and later informed our campaign stills.\n\nWe treat each frame like a museum label: quiet, precise, and generous with negative space.",
                'cover_image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1200&q=80',
                ],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ]
        );

        PortfolioProject::query()->updateOrCreate(
            ['slug' => 'capsule-development'],
            [
                'title' => 'Capsule Development',
                'client' => 'Private client',
                'role' => 'Lead designer',
                'year' => '2024',
                'excerpt' => 'Twelve-look capsule for a quiet ceremony wardrobe — from first muslin to final light.',
                'body' => "From first muslin to final campaign, the project shaped Night Atelier’s petrol palette.\n\nTwelve looks, one private ceremony, endless fittings. We built a wardrobe that photographs like an editorial and wears like a whispered promise.\n\nThe capsule remains the house reference for soft structure under evening light.",
                'cover_image' => 'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=1200&q=80',
                ],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ]
        );
    }
}
