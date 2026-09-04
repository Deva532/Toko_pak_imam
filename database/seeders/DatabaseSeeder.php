<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users
        $admin = User::create([
            'name' => 'Pak Imam (Admin)',
            'email' => 'admin@tokopakimam.com',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $customer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'customer@tokopakimam.com',
            'phone' => '089876543210',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Customer Addresses
        Address::create([
            'user_id' => $customer->id,
            'label' => 'Rumah',
            'recipient_name' => 'Budi Santoso',
            'phone' => '089876543210',
            'address' => 'Jl. Merdeka No. 45, RT 02/RW 05',
            'district' => 'Kebayoran Baru',
            'city' => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'postal_code' => '12110',
            'note' => 'Pagar warna hijau, dekat masjid Al-Ikhlas',
            'is_default' => true,
        ]);

        Address::create([
            'user_id' => $customer->id,
            'label' => 'Kantor',
            'recipient_name' => 'Budi Santoso (Lantai 3)',
            'phone' => '089876543210',
            'address' => 'Gedung Wisma Asri, Jl. Jend. Sudirman Kav. 12',
            'district' => 'Setiabudi',
            'city' => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'postal_code' => '12920',
            'note' => 'Titip di resepsionis lantai dasar',
            'is_default' => false,
        ]);

        // 2. Create Brands
        $brandsData = [
            ['name' => 'Indofood', 'slug' => 'indofood'],
            ['name' => 'Unilever', 'slug' => 'unilever'],
            ['name' => 'Mayora', 'slug' => 'mayora'],
            ['name' => 'Nestle', 'slug' => 'nestle'],
            ['name' => 'Wings', 'slug' => 'wings'],
            ['name' => 'Bimoli', 'slug' => 'bimoli'],
            ['name' => 'Ultra Jaya', 'slug' => 'ultra-jaya'],
            ['name' => 'Kapal Api', 'slug' => 'kapal-api'],
        ];

        $brands = [];
        foreach ($brandsData as $b) {
            $brands[$b['slug']] = Brand::create([
                'name' => $b['name'],
                'slug' => $b['slug'],
                'is_active' => true,
            ]);
        }

        // 3. Create Categories (10 Categories)
        $categoriesData = [
            ['name' => 'Sembako', 'slug' => 'sembako', 'icon' => 'shopping-bag', 'sort' => 1],
            ['name' => 'Minuman', 'slug' => 'minuman', 'icon' => 'coffee', 'sort' => 2],
            ['name' => 'Makanan Instant', 'slug' => 'makanan-instant', 'icon' => 'utensils', 'sort' => 3],
            ['name' => 'Snack & Biskuit', 'slug' => 'snack-biskuit', 'icon' => 'cookie', 'sort' => 4],
            ['name' => 'Perawatan Tubuh', 'slug' => 'perawatan-tubuh', 'icon' => 'sparkles', 'sort' => 5],
            ['name' => 'Perawatan Rumah', 'slug' => 'perawatan-rumah', 'icon' => 'home', 'sort' => 6],
            ['name' => 'Kebutuhan Bayi', 'slug' => 'kebutuhan-bayi', 'icon' => 'baby', 'sort' => 7],
            ['name' => 'Susu & Olahan', 'slug' => 'susu-olahan', 'icon' => 'milk', 'sort' => 8],
            ['name' => 'Elektronik & Alat Rumah', 'slug' => 'elektronik', 'icon' => 'zap', 'sort' => 9],
            ['name' => 'ATK & Kantor', 'slug' => 'atk', 'icon' => 'pen-tool', 'sort' => 10],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::create([
                'name' => $c['name'],
                'slug' => $c['slug'],
                'icon' => $c['icon'],
                'sort_order' => $c['sort'],
                'is_active' => true,
            ]);
        }

        // Helper image placeholders
        $bgColors = ['16a34a', '2563eb', 'd97706', 'dc2626', '7c3aed', '059669', 'ea580c', '4f46e5'];

        // 4. Create 30+ Realistic Products
        $productsData = [
            // Sembako
            [
                'name' => 'Minyak Goreng Bimoli Spesial 2 Liter',
                'category' => 'sembako',
                'brand' => 'bimoli',
                'price' => 38500,
                'discount_price' => 34900,
                'stock' => 50,
                'weight' => 2000,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 1240,
                'desc' => 'Minyak goreng Bimoli Spesial dibuat dari kelapa sawit pilihan berkualitas tinggi. Diproses dengan teknologi modern untuk hasil masakan renyah dan lezat.',
            ],
            [
                'name' => 'Beras Pandan Wangi Super 5kg',
                'category' => 'sembako',
                'brand' => null,
                'price' => 78000,
                'discount_price' => 74500,
                'stock' => 35,
                'weight' => 5000,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.8,
                'sold' => 850,
                'desc' => 'Beras Pandan Wangi asli tanpa bahan pengawet, aroma alami dan tekstur nasi pulen pas untuk keluarga.',
            ],
            [
                'name' => 'Gulaku Gula Pasir Putih Premium 1kg',
                'category' => 'sembako',
                'brand' => null,
                'price' => 17500,
                'discount_price' => 16000,
                'stock' => 80,
                'weight' => 1000,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 2100,
                'desc' => 'Gula pasir kristal putih murni terbuat dari tebu pilihan. Mudah larut dan manis alami.',
            ],
            [
                'name' => 'Garam Dapur Beriodium Cap Kapal 500g',
                'category' => 'sembako',
                'brand' => null,
                'price' => 4500,
                'discount_price' => null,
                'stock' => 120,
                'weight' => 500,
                'is_promo' => false,
                'is_best_seller' => false,
                'rating' => 4.7,
                'sold' => 430,
                'desc' => 'Garam dapur halus beriodium tinggi untuk kesehatan dan kelezatan hidangan sehari-hari.',
            ],

            // Makanan Instant
            [
                'name' => 'Indomie Goreng Spesial 85g (1 Dus / 40 Pcs)',
                'category' => 'makanan-instant',
                'brand' => 'indofood',
                'price' => 118000,
                'discount_price' => 109000,
                'stock' => 25,
                'weight' => 3500,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 5.0,
                'sold' => 3400,
                'desc' => 'Mie instant goreng legendaris Indonesia dengan bumbu gurih khas dan bawang goreng renyah.',
            ],
            [
                'name' => 'Indomie Kuah Rasa Ayam Bawang 75g',
                'category' => 'makanan-instant',
                'brand' => 'indofood',
                'price' => 3100,
                'discount_price' => 2900,
                'stock' => 300,
                'weight' => 80,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 5100,
                'desc' => 'Mie kuah aroma ayam bawang nikmat dan gurih hangat di setiap hirupan.',
            ],
            [
                'name' => 'Sedaap Mie Goreng Korea Spicy Chicken 87g',
                'category' => 'makanan-instant',
                'brand' => 'wings',
                'price' => 3500,
                'discount_price' => 3200,
                'stock' => 150,
                'weight' => 90,
                'is_promo' => true,
                'is_best_seller' => false,
                'rating' => 4.6,
                'sold' => 670,
                'desc' => 'Mie goreng pedas ala Korea dengan bumbu pedas mantap dan krispi pedas.',
            ],
            [
                'name' => 'Pop Mie Rasa Baso Sapi 75g',
                'category' => 'makanan-instant',
                'brand' => 'indofood',
                'price' => 5500,
                'discount_price' => null,
                'stock' => 90,
                'weight' => 85,
                'is_promo' => false,
                'is_best_seller' => true,
                'rating' => 4.8,
                'sold' => 1450,
                'desc' => 'Pop mie cup praktis rasa bakso sapi hangat lezat untuk camilan kapan saja.',
            ],

            // Minuman
            [
                'name' => 'Kopi Kapal Api Spesial Mix 10 Saset x 25g',
                'category' => 'minuman',
                'brand' => 'kapal-api',
                'price' => 16500,
                'discount_price' => 14800,
                'stock' => 70,
                'weight' => 260,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 1900,
                'desc' => 'Perpaduan biji kopi pilihan dan gula murni Kapal Api menghasilkan aroma kopi mantap.',
            ],
            [
                'name' => 'Teh Celup Sosri Kotak Isi 30 Kantong',
                'category' => 'minuman',
                'brand' => null,
                'price' => 7500,
                'discount_price' => 6800,
                'stock' => 100,
                'weight' => 120,
                'is_promo' => true,
                'is_best_seller' => false,
                'rating' => 4.7,
                'sold' => 780,
                'desc' => 'Teh celup aroma melati alami khas Sosro yang menyegarkan.',
            ],
            [
                'name' => 'Air Mineral Le Minerale Botol 600ml (1 Dus / 24 Botol)',
                'category' => 'minuman',
                'brand' => 'mayora',
                'price' => 52000,
                'discount_price' => 47900,
                'stock' => 40,
                'weight' => 15000,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 1100,
                'desc' => 'Air mineral gunung murni mengandung mineral alami dengan sensasi segar dingin.',
            ],
            [
                'name' => 'Coca-Cola Botol PET 1.5 Liter',
                'category' => 'minuman',
                'brand' => null,
                'price' => 16000,
                'discount_price' => 13900,
                'stock' => 60,
                'weight' => 1600,
                'is_promo' => true,
                'is_best_seller' => false,
                'rating' => 4.8,
                'sold' => 890,
                'desc' => 'Minuman berkarbonasi rasa cola segar dingin cocok untuk momen berkumpul keluarga.',
            ],

            // Susu & Olahan
            [
                'name' => 'Ultra Milk Susu UHT Plain Full Cream 1 Liter',
                'category' => 'susu-olahan',
                'brand' => 'ultra-jaya',
                'price' => 20500,
                'discount_price' => 18900,
                'stock' => 85,
                'weight' => 1050,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 2300,
                'desc' => 'Susu segar UHT berkualitas kaya akan kalsium, protein, dan vitamin lengkap.',
            ],
            [
                'name' => 'Ultra Milk Cokelat UHT 200ml (1 Karton / 24 Pcs)',
                'category' => 'susu-olahan',
                'brand' => 'ultra-jaya',
                'price' => 115000,
                'discount_price' => 105000,
                'stock' => 30,
                'weight' => 5200,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 950,
                'desc' => 'Susu cair rasa cokelat favorit anak-anak, bergizi tinggi dan praktis.',
            ],
            [
                'name' => 'Nestle Bear Brand Susu Steril 189ml',
                'category' => 'susu-olahan',
                'brand' => 'nestle',
                'price' => 10800,
                'discount_price' => 9900,
                'stock' => 110,
                'weight' => 220,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 5.0,
                'sold' => 4200,
                'desc' => 'Susu steril 100% murni kemasan kaleng untuk menjaga daya tahan tubuh.',
            ],

            // Snack & Biskuit
            [
                'name' => 'Roma Kelapa Biskuit Pack 300g',
                'category' => 'snack-biskuit',
                'brand' => 'mayora',
                'price' => 11500,
                'discount_price' => 9800,
                'stock' => 95,
                'weight' => 320,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.8,
                'sold' => 1670,
                'desc' => 'Biskuit dibuat dari kelapa pilihan yang renyah dan gurih disukai seluruh keluarga.',
            ],
            [
                'name' => 'Oreo Sandwich Biskuit Vanilla 133g',
                'category' => 'snack-biskuit',
                'brand' => null,
                'price' => 9500,
                'discount_price' => 8200,
                'stock' => 140,
                'weight' => 140,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.8,
                'sold' => 2400,
                'desc' => 'Biskuit cokelat renyah dengan krim vanilla lezat diputar, dijilat, dicelupin.',
            ],
            [
                'name' => 'Chitato Keripik Kentang Rasa Sapi Panggang 68g',
                'category' => 'snack-biskuit',
                'brand' => 'indofood',
                'price' => 12500,
                'discount_price' => 10900,
                'stock' => 75,
                'weight' => 80,
                'is_promo' => true,
                'is_best_seller' => false,
                'rating' => 4.7,
                'sold' => 1120,
                'desc' => 'Keripik kentang bergelombang dengan rasa daging sapi panggang khas Chitato.',
            ],

            // Perawatan Tubuh
            [
                'name' => 'Sabun Mandi Lifebuoy Total 10 Batang 4x110g',
                'category' => 'perawatan-tubuh',
                'brand' => 'unilever',
                'price' => 16800,
                'discount_price' => 14500,
                'stock' => 65,
                'weight' => 450,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 1890,
                'desc' => 'Sabun anti-bakteri melindungi keluarga dari kuman penyakit secara menyeluruh.',
            ],
            [
                'name' => 'Shampoo Pantene Hair Fall Control 290ml',
                'category' => 'perawatan-tubuh',
                'brand' => null,
                'price' => 42000,
                'discount_price' => 36500,
                'stock' => 45,
                'weight' => 320,
                'is_promo' => true,
                'is_best_seller' => false,
                'rating' => 4.8,
                'sold' => 640,
                'desc' => 'Shampo penguat akar rambut mengurangi rambut rontok hingga 98%.',
            ],
            [
                'name' => 'Pepsodent Pasta Gigi Pencegah Gigi Berlubang 225g',
                'category' => 'perawatan-tubuh',
                'brand' => 'unilever',
                'price' => 15500,
                'discount_price' => 13200,
                'stock' => 110,
                'weight' => 250,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 2900,
                'desc' => 'Pasta gigi mikro kalsium dan fluoride aktif menjaga kekuatan gigi hingga malam.',
            ],

            // Perawatan Rumah
            [
                'name' => 'Detergen Rinso Anti Noda Molto Powder 1.8kg',
                'category' => 'perawatan-rumah',
                'brand' => 'unilever',
                'price' => 46500,
                'discount_price' => 41900,
                'stock' => 40,
                'weight' => 1900,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 1400,
                'desc' => 'Deterjen bubuk hilangkan noda membandel 1x kucek dengan aroma harum segar Molto.',
            ],
            [
                'name' => 'Sabun Cuci Piring Sunlight Jeruk Nipis 755ml Refill',
                'category' => 'perawatan-rumah',
                'brand' => 'unilever',
                'price' => 18000,
                'discount_price' => 15500,
                'stock' => 90,
                'weight' => 800,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 3100,
                'desc' => 'Cairan pencuci piring ekstrak jeruk nipis asli bersihkan lemak 5x lebih cepat.',
            ],
            [
                'name' => 'Pembersih Lantai So Klin Aroma Citrus Lemon 780ml',
                'category' => 'perawatan-rumah',
                'brand' => 'wings',
                'price' => 13500,
                'discount_price' => 11800,
                'stock' => 70,
                'weight' => 820,
                'is_promo' => true,
                'is_best_seller' => false,
                'rating' => 4.7,
                'sold' => 890,
                'desc' => 'Cairan pembersih lantai kilap mengkilap dan kencang harum lemon bebas kuman.',
            ],

            // Kebutuhan Bayi
            [
                'name' => 'Popok Bayi MamyPoko Pants Standard Size M Isi 34',
                'category' => 'kebutuhan-bayi',
                'brand' => null,
                'price' => 64000,
                'discount_price' => 57500,
                'stock' => 35,
                'weight' => 1100,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 1250,
                'desc' => 'Popok celana bayi lembut dengan daya serap tinggi hingga 10 jam kering.',
            ],
            [
                'name' => 'Minyak Telon Lang Plus Anti Nyamuk 100ml',
                'category' => 'kebutuhan-bayi',
                'brand' => null,
                'price' => 29500,
                'discount_price' => 26000,
                'stock' => 60,
                'weight' => 130,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 980,
                'desc' => 'Minyak telon hangat dengan perlindungan alami dari gigitan nyamuk hingga 8 jam.',
            ],
            [
                'name' => 'Tisu Basah Mitu Baby Change Clothe Wipes 50s',
                'category' => 'kebutuhan-bayi',
                'brand' => null,
                'price' => 14000,
                'discount_price' => 12500,
                'stock' => 80,
                'weight' => 250,
                'is_promo' => true,
                'is_best_seller' => false,
                'rating' => 4.8,
                'sold' => 670,
                'desc' => 'Tisu basah ekstra lembut bebas alkohol teruji klinis ramah untuk kulit bayi sensitif.',
            ],

            // Elektronik & Alat Rumah
            [
                'name' => 'Lampu LED Philips MyCare 10 Watt Putih Cool Daylight',
                'category' => 'elektronik',
                'brand' => null,
                'price' => 45000,
                'discount_price' => 39000,
                'stock' => 50,
                'weight' => 150,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 1100,
                'desc' => 'Lampu LED hemat energi hingga 88% terang dan nyaman di mata keluarga.',
            ],
            [
                'name' => 'Baterai ABC Alkaline AA Pack Isi 6 Biji',
                'category' => 'elektronik',
                'brand' => null,
                'price' => 28000,
                'discount_price' => 24500,
                'stock' => 65,
                'weight' => 200,
                'is_promo' => true,
                'is_best_seller' => false,
                'rating' => 4.8,
                'sold' => 530,
                'desc' => 'Baterai tahan lama 1.5V untuk remote control, jam dinding, dan alat elektronik rumah.',
            ],

            // ATK & Kantor
            [
                'name' => 'Buku Tulis Sinar Dunia (Sidu) 38 Lembar 1 Pak (10 Buku)',
                'category' => 'atk',
                'brand' => null,
                'price' => 36000,
                'discount_price' => 31500,
                'stock' => 45,
                'weight' => 1200,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.8,
                'sold' => 890,
                'desc' => 'Buku tulis garis berkuakitas dengan kertas putih halus cocok untuk anak sekolah.',
            ],
            [
                'name' => 'Pulpen Standard AE7 Hitam 0.5mm 1 Box (12 Pcs)',
                'category' => 'atk',
                'brand' => null,
                'price' => 24000,
                'discount_price' => 21000,
                'stock' => 70,
                'weight' => 150,
                'is_promo' => true,
                'is_best_seller' => true,
                'rating' => 4.9,
                'sold' => 1450,
                'desc' => 'Pulpen cair lancar favorit sejuta umat dengan tinta pekat dan tahan lama.',
            ],
        ];

        foreach ($productsData as $idx => $p) {
            $cat = $categories[$p['category']]->id;
            $brd = isset($p['brand']) && isset($brands[$p['brand']]) ? $brands[$p['brand']]->id : null;
            $sku = 'TPI-' . strtoupper(substr($p['category'], 0, 3)) . '-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT);
            $bg = $bgColors[$idx % count($bgColors)];
            
            // Clean SVG data placeholder or dummy SVG URL
            $encodedName = urlencode(substr($p['name'], 0, 15));
            $mainImg = "https://placehold.co/500x500/{$bg}/ffffff?text={$encodedName}";

            Product::create([
                'sku' => $sku,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => $p['desc'],
                'price' => $p['price'],
                'discount_price' => $p['discount_price'],
                'stock' => $p['stock'],
                'weight' => $p['weight'],
                'category_id' => $cat,
                'brand_id' => $brd,
                'main_image' => $mainImg,
                'is_active' => true,
                'is_featured' => ($idx % 3 === 0),
                'is_promo' => $p['is_promo'],
                'is_best_seller' => $p['is_best_seller'],
                'rating' => $p['rating'],
                'sold_count' => $p['sold'],
            ]);
        }

        // 5. Shipping Methods
        ShippingMethod::create([
            'name' => 'Pengiriman Kurir Toko (Express 2 Jam)',
            'code' => 'express',
            'cost' => 10000,
            'estimated_days' => '2-3 Jam (Tiba Hari Ini)',
            'description' => 'Dikirim langsung oleh kurir resmi Toko Pak Imam khusus area terdekat.',
            'is_active' => true,
        ]);

        ShippingMethod::create([
            'name' => 'Pengiriman Reguler Harian',
            'code' => 'regular',
            'cost' => 5000,
            'estimated_days' => '1 Hari Kerja',
            'description' => 'Pengiriman ekonomis aman dan tepat waktu sampai ke depan pintu Anda.',
            'is_active' => true,
        ]);

        ShippingMethod::create([
            'name' => 'Ambil Sendiri di Toko (Pickup)',
            'code' => 'pickup',
            'cost' => 0,
            'estimated_days' => 'Siap dalam 30 Menit',
            'description' => 'Bebas ongkir! Ambil langsung pesanan Anda di outlet Toko Pak Imam terdekat.',
            'is_active' => true,
        ]);

        // 6. Coupons
        Coupon::create([
            'code' => 'PAKIMAMHEMAT',
            'type' => 'fixed',
            'amount' => 10000,
            'min_spend' => 50000,
            'expires_at' => now()->addMonths(3),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'PROMOBERKAHS10',
            'type' => 'percentage',
            'amount' => 10,
            'min_spend' => 100000,
            'max_discount' => 20000,
            'expires_at' => now()->addMonths(2),
            'is_active' => true,
        ]);

        // 7. Seed Sample Orders for Admin & Customer testing
        $sampleProducts = Product::take(3)->get();
        $regShipping = ShippingMethod::where('code', 'regular')->first();

        $order1 = Order::create([
            'order_number' => 'TPI-ORD-20260901-001',
            'user_id' => $customer->id,
            'recipient_name' => 'Budi Santoso',
            'phone' => '089876543210',
            'address_text' => 'Budi Santoso (089876543210) - Jl. Merdeka No. 45, Kebayoran Baru, Jakarta Selatan',
            'shipping_method_id' => $regShipping->id,
            'shipping_cost' => 5000,
            'subtotal' => 143900,
            'discount_amount' => 0,
            'total_amount' => 148900,
            'status' => 'completed',
            'courier_name' => 'Kurir Toko Pak Imam',
            'tracking_number' => 'TPI-RESI-982131',
            'notes' => 'Tolong antar sebelum jam 5 sore.',
        ]);

        foreach ($sampleProducts as $sp) {
            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $sp->id,
                'product_name' => $sp->name,
                'price' => $sp->effective_price,
                'quantity' => 2,
                'subtotal' => $sp->effective_price * 2,
            ]);
        }

        Payment::create([
            'order_id' => $order1->id,
            'payment_method' => 'qris',
            'payment_status' => 'paid',
            'paid_at' => now()->subDays(2),
        ]);

        // Order 2 (Processing)
        $order2 = Order::create([
            'order_number' => 'TPI-ORD-20260904-002',
            'user_id' => $customer->id,
            'recipient_name' => 'Budi Santoso',
            'phone' => '089876543210',
            'address_text' => 'Budi Santoso (089876543210) - Jl. Merdeka No. 45, Kebayoran Baru, Jakarta Selatan',
            'shipping_method_id' => $regShipping->id,
            'shipping_cost' => 5000,
            'subtotal' => 69800,
            'discount_amount' => 0,
            'total_amount' => 74800,
            'status' => 'processing',
            'courier_name' => 'Kurir Toko Pak Imam (Express)',
            'tracking_number' => 'TPI-RESI-984400',
            'notes' => 'Mohon dikemas rapi.',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $sampleProducts[0]->id,
            'product_name' => $sampleProducts[0]->name,
            'price' => $sampleProducts[0]->effective_price,
            'quantity' => 2,
            'subtotal' => $sampleProducts[0]->effective_price * 2,
        ]);

        Payment::create([
            'order_id' => $order2->id,
            'payment_method' => 'bank_transfer',
            'payment_status' => 'paid',
            'paid_at' => now()->subHours(4),
        ]);
    }
}
