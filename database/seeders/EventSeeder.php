<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hardstyleFestivals = [
            [
                'name' => 'Defqon.1 Festival',
                'description' => 'Het grootste hardstyle festival ter wereld keert terug naar Biddinghuizen. Vier dagen lang non-stop hardstyle, raw hardstyle en hardcore met de beste DJ\'s uit de scene. Met spectaculaire shows, vuurwerk en een unieke sfeer is dit hét festival voor elke hardstyle liefhebber.',
                'location' => 'Walibi Holland, Biddinghuizen',
                'date' => Carbon::now()->addMonths(3)->setTime(14, 0),
                'image_url' => 'https://cdn.q-dance.com/l6hfsc63q612/AfcikMGehqKP7h5DfbDPX/6ddcae95a069a9300f56de6950a32b86/STAGE_REVEAL.png?w=720',
                'categories' => ['hardstyle', 'raw-hardstyle', 'hardcore', 'festival', 'outdoor'],
            ],
            [
                'name' => 'Qlimax',
                'description' => 'De donkerste nacht van het jaar. Qlimax staat bekend om zijn unieke theming, spectaculaire lasershow en de beste hardstyle tracks. In de Gelredome ervaar je een audiovisuele show die je nooit meer vergeet. Een must-see voor elke echte hardstyle fan.',
                'location' => 'Gelredome, Arnhem',
                'date' => Carbon::now()->addMonths(5)->setTime(19, 0),
                'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9Nm9LVK9C6gDcIrr7zBS6mac8Jhzea_N9iQ&s',
                'categories' => ['hardstyle', 'indoor'],
            ],
            [
                'name' => 'Intents Festival',
                'description' => 'Het gezelligste hardstyle festival van Nederland met camping. Geniet van drie dagen lang de beste hardstyle in een relaxte festivalsfeer. Van euphoric tot raw, van classics tot nieuwe tracks - Intents heeft het allemaal.',
                'location' => 'Oisterwijk',
                'date' => Carbon::now()->addMonths(4)->setTime(12, 0),
                'image_url' => 'https://i.ytimg.com/vi/_a_oCdZRbHM/maxresdefault.jpg',
                'categories' => ['hardstyle', 'euphoric-hardstyle', 'raw-hardstyle', 'festival', 'outdoor'],
            ],
            [
                'name' => 'Decibel Outdoor',
                'description' => 'Het grootste outdoor hardstyle festival in Nederland. Met meerdere stages, camping en de dikste line-up biedt Decibel een compleet festivalweekend. Van mainstage madness tot raw rawness, hier vindt elk type hardstyle fan zijn geluk.',
                'location' => 'Beekse Bergen, Hilvarenbeek',
                'date' => Carbon::now()->addMonths(6)->setTime(13, 0),
                'image_url' => 'https://d2oiyt60aney7e.cloudfront.net/2ck28wkq03nm/5nU6rq83qVw4LIj7N3xbty/cea4d18e5d34320e53c0de8592eaad77/250815-220836-DB25_EDMKevin-_D4_4430-HR.jpg?w=720',
                'categories' => ['hardstyle', 'raw-hardstyle', 'festival', 'outdoor'],
            ],
            [
                'name' => 'Rebirth Festival',
                'description' => 'Herleef de golden era van hardstyle met klassiekers en oldskool tracks. Rebirth brengt je terug naar de roots van hardstyle met de legends en pioneers van het genre. Pure nostalgie gecombineerd met de beste sfeer.',
                'location' => 'Toverland, Sevenum',
                'date' => Carbon::now()->addMonths(2)->setTime(11, 0),
                'image_url' => 'https://www.rebirth-festival.nl/wp-content/uploads/2025/09/20250412_1917_REBiRTH_BobbiePhotography_124_HR-scaled.jpg',
                'categories' => ['hardstyle', 'classics', 'outdoor'],
            ],
            [
                'name' => 'The Qontinent',
                'description' => 'België\'s grootste hardstyle festival komt naar Nederland! Drie dagen camping, meerdere stages en een internationale line-up maken dit festival tot een Europees spektakel. Van hardstyle tot hardcore, alles komt samen op The Qontinent.',
                'location' => 'Puyenbroeck, Wachtebeke',
                'date' => Carbon::now()->addMonths(7)->setTime(14, 0),
                'image_url' => 'https://i.ytimg.com/vi/uP7vhPiwapc/maxresdefault.jpg',
                'categories' => ['hardstyle', 'hardcore', 'festival', 'outdoor'],
            ],
            [
                'name' => 'Supremacy',
                'description' => 'De hardste indoor battle tussen hardstyle en hardcore. Supremacy brengt de beste van beide werelden samen in één explosieve show. Met spectaculaire shows, pyrotechnics en de dikste beats is dit een festival dat je zindert navoelt.',
                'location' => 'Ziggo Dome, Amsterdam',
                'date' => Carbon::now()->addMonths(8)->setTime(18, 0),
                'image_url' => 'https://www.mastersofhardcore.com/wp-content/uploads/2024/09/240914-1634-KVDMPHOTOGRAPHY-SUPREMACY-HR-1280x853.jpg',
                'categories' => ['hardstyle', 'hardcore', 'indoor'],
            ],
            [
                'name' => 'Emporium',
                'description' => 'Een magische hardstyle ervaring in een fairytale setting. Emporium combineert de kracht van hardstyle met sprookjesachtige decoraties en shows. Perfect voor wie van melodic en euphoric hardstyle houdt.',
                'location' => 'Aquabest, Best',
                'date' => Carbon::now()->addMonths(1)->setTime(15, 0),
                'image_url' => 'https://emporium.nl/wp-content/uploads/240525-1642-EMPORIUM-KVDMPHOTOGRAPHY-06009-LR-1024x683.jpg',
                'categories' => ['hardstyle', 'euphoric-hardstyle', 'outdoor'],
            ],
            [
                'name' => 'Impaqt',
                'description' => 'Het festival waar hardstyle impaqt maakt! Met een perfect gebalanceerde line-up tussen euphoric en raw hardstyle is Impaqt het festival voor de échte kenner. Intieme sfeer, goede vibes en topkwaliteit productie.',
                'location' => 'Evenemententerrein Eindhoven',
                'date' => Carbon::now()->addMonths(9)->setTime(13, 0),
                'image_url' => 'https://cdn.q-dance.com/l6hfsc63q612/3sYxp0S0QkI58vN5k3NatH/79673f4b5d52178c1da7b068123df255/B83B15B9-068B-4C71-AD58-2445B266FA07.jpeg?w=720',
                'categories' => ['hardstyle', 'euphoric-hardstyle', 'raw-hardstyle', 'outdoor'],
            ],
            [
                'name' => 'X-Qlusive Holland',
                'description' => 'Een eerbetoon aan de Nederlandse hardstyle. X-Qlusive Holland viert alles wat Nederland te bieden heeft in de hardstyle scene. Van Headhunterz tot Wildstylez, van old tot new - dit is Nederlands trots in hardstylevorm.',
                'location' => 'Ziggo Dome, Amsterdam',
                'date' => Carbon::now()->addMonths(10)->setTime(19, 0),
                'image_url' => 'https://q-dance-network-images.akamaized.net/41347/1695294124-20220903_212345_xq-holland_hr_mno-photo.jpg?auto=compress&fit=max?w=1200',
                'categories' => ['hardstyle', 'classics', 'indoor'],
            ],
        ];

        foreach ($hardstyleFestivals as $index => $festival) {
            // Make first 2 events sold out (0 tickets available)
            $ticketsAvailable = ($index < 2) ? 0 : rand(5000, 50000);

            $event = Event::create([
                'name' => $festival['name'],
                'description' => $festival['description'],
                'location' => $festival['location'],
                'date' => $festival['date'],
                'total_tickets' => $ticketsAvailable,
                'price' => rand(35, 125) + (rand(0, 99) / 100), // Prices between €35.00 and €125.99
                'image_url' => $festival['image_url'],
            ]);

            // Attach categories to the event
            $categoryIds = Category::whereIn('slug', $festival['categories'])->pluck('id');
            $event->categories()->attach($categoryIds);
        }
    }
}
