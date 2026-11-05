<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'eyebrow',
        'body',
        'image',
        'cta_label',
        'cta_url',
        'cta2_label',
        'cta2_url',
        'page',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function imageUrl(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str_starts_with($this->image, 'http')
            ? $this->image
            : asset('storage/'.$this->image);
    }

    /**
     * Editable storefront pages and their section keys.
     *
     * @return array<string, array{label: string, description: string, sections: array<string, array{label: string, defaults: array<string, mixed>}>}>
     */
    public static function pageCatalog(): array
    {
        return [
            'home' => [
                'label' => 'Home',
                'description' => 'Hero image, shop intro, and brand closing section',
                'sections' => [
                    'home_hero' => [
                        'label' => 'Hero banner',
                        'defaults' => [
                            'title' => 'Cloth for a quiet silhouette.',
                            'subtitle' => 'Season 26 — Soft Structure',
                            'eyebrow' => 'Contemporary Atelier',
                            'body' => 'Silence, form, and the discipline of cloth — made to be worn, not performed.',
                            'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=2400&q=80',
                            'cta_label' => 'Shop the edit',
                            'cta_url' => '/shop',
                            'cta2_label' => 'Read the lookbook',
                            'cta2_url' => '/lookbook',
                            'sort_order' => 1,
                        ],
                    ],
                    'home_shop' => [
                        'label' => 'Shop section',
                        'defaults' => [
                            'title' => 'Shop',
                            'subtitle' => 'Boutique',
                            'body' => 'Soft tees and quiet staples from the atelier — select a piece, bag it, and wear it with ease. Clean lines, calm color, and cloth that feels light on the body.',
                            'cta_label' => 'Shop all pieces',
                            'cta_url' => '/shop',
                            'sort_order' => 2,
                        ],
                    ],
                    'home_about' => [
                        'label' => 'Brand closing',
                        'defaults' => [
                            'title' => 'An atelier of quiet precision',
                            'subtitle' => 'The house',
                            'body' => 'We build small collections with lasting silhouettes — tailored cloth, considered proportion, and photography that feels like film stills.',
                            'image' => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1400&q=80',
                            'cta_label' => 'Our story',
                            'cta_url' => '/about',
                            'sort_order' => 3,
                        ],
                    ],
                ],
            ],
            'about' => [
                'label' => 'About',
                'description' => 'Manifesto and three pillar cards with photos',
                'sections' => [
                    'about_manifesto' => [
                        'label' => 'Page intro / manifesto',
                        'defaults' => [
                            'title' => 'Made to be worn, not performed',
                            'subtitle' => 'Philosophy',
                            'body' => 'Yueli Studio began as a private fitting room practice. Every piece is drafted for movement, then photographed as an editorial object — never louder than the person wearing it.',
                            'image' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=1600&q=80',
                            'sort_order' => 1,
                        ],
                    ],
                    'about_pillar_cloth' => [
                        'label' => 'Pillar — The cloth',
                        'defaults' => [
                            'title' => 'The cloth',
                            'subtitle' => 'Pillar',
                            'body' => 'Natural fibers chosen for movement — linen that remembers the body, wool that holds soft structure without weight.',
                            'image' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1000&q=80',
                            'sort_order' => 2,
                        ],
                    ],
                    'about_pillar_fit' => [
                        'label' => 'Pillar — The fit',
                        'defaults' => [
                            'title' => 'The fit',
                            'subtitle' => 'Pillar',
                            'body' => 'We prototype, refine through fittings, and finish only when the silhouette feels honest to wear.',
                            'image' => 'https://images.unsplash.com/photo-1581044777550-4cfa60707c03?auto=format&fit=crop&w=1000&q=80',
                            'sort_order' => 3,
                        ],
                    ],
                    'about_pillar_edit' => [
                        'label' => 'Pillar — The edit',
                        'defaults' => [
                            'title' => 'The edit',
                            'subtitle' => 'Pillar',
                            'body' => 'Small collections. If a piece does not earn its place in the wardrobe, it does not leave the atelier.',
                            'image' => 'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?auto=format&fit=crop&w=1000&q=80',
                            'sort_order' => 4,
                        ],
                    ],
                ],
            ],
            'shop' => [
                'label' => 'Shop',
                'description' => 'Shop page title and description',
                'sections' => [
                    'shop_intro' => [
                        'label' => 'Shop intro',
                        'defaults' => [
                            'title' => 'Shop',
                            'subtitle' => 'Boutique',
                            'body' => 'Soft tees and quiet staples — clean lines, calm color, cloth that feels light on the body.',
                            'sort_order' => 1,
                        ],
                    ],
                ],
            ],
            'collections' => [
                'label' => 'Collections',
                'description' => 'Collections page intro text',
                'sections' => [
                    'collections_intro' => [
                        'label' => 'Collections intro',
                        'defaults' => [
                            'title' => 'Collections',
                            'subtitle' => 'Archive',
                            'body' => 'Seasonal chapters shaped with editorial discipline — each one a world of cloth, light, and quiet form.',
                            'sort_order' => 1,
                        ],
                    ],
                ],
            ],
            'lookbook' => [
                'label' => 'Lookbook',
                'description' => 'Lookbook page intro text',
                'sections' => [
                    'lookbook_intro' => [
                        'label' => 'Lookbook intro',
                        'defaults' => [
                            'title' => 'Lookbook',
                            'subtitle' => 'Fashion journal',
                            'body' => 'Campaign photography and editorials — the magazine pages of the house. Cloth, light, and quiet form told frame by frame.',
                            'sort_order' => 1,
                        ],
                    ],
                ],
            ],
            'portfolio' => [
                'label' => 'Portfolio / Studio',
                'description' => 'Studio intro used on home and portfolio',
                'sections' => [
                    'portfolio_intro' => [
                        'label' => 'Studio intro',
                        'defaults' => [
                            'title' => 'Designer portfolio',
                            'subtitle' => 'Selected work',
                            'body' => "Process, fittings, and collaborations — the artistic side of the house.\n\nFrom first muslin to campaign light, every study is treated as an editorial object.",
                            'sort_order' => 1,
                        ],
                    ],
                ],
            ],
            'contact' => [
                'label' => 'Contact',
                'description' => 'Contact page headline and supporting copy',
                'sections' => [
                    'contact_intro' => [
                        'label' => 'Contact intro',
                        'defaults' => [
                            'title' => 'Speak with the atelier',
                            'subtitle' => 'Contact',
                            'body' => 'Enquiries for fittings, press, and collaborations — we respond with care.',
                            'sort_order' => 1,
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function ensurePageDefaults(): void
    {
        foreach (static::pageCatalog() as $page => $meta) {
            foreach ($meta['sections'] as $key => $section) {
                static::query()->firstOrCreate(
                    ['key' => $key],
                    array_merge($section['defaults'], [
                        'page' => $page,
                        'is_active' => true,
                    ])
                );
            }
        }
    }

    public function sectionLabel(): string
    {
        foreach (static::pageCatalog() as $meta) {
            if (isset($meta['sections'][$this->key])) {
                return $meta['sections'][$this->key]['label'];
            }
        }

        return $this->title ?: $this->key;
    }
}
