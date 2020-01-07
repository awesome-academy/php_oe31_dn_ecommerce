<?php

use Illuminate\Database\Seeder;
use Goutte\Client;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Image;
use App\Models\Comment;
use App\Models\TrendProduct;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseUrl = 'https://justbasic.vn/collections/';
        $client = new Client();
        $getImages = array();
        $prefixParams = [
            'ao-thun',
            'ao-thu-dong',
            'ao-so-mi',
            'ao-polo',
            'quan-short',
            'quan-kaki',
            'quan-jogger',
            'quan-jeans',
            'quan-au',
            'set-quan-ao',
            'giay-dep',
            'balo-tui-xach',
            'mat-kinh',
            'non',
            'that-lung'
        ];

        foreach ($prefixParams as $prefixParam) {
            $crawler = $client->request('GET', $baseUrl . $prefixParam);

            $crawler->filter('img.img-loop.img-hover')
                ->each(function ($node) use (&$getImages) {
                    $src = substr_replace($node->attr('src'), 'https:/', 0, 1);
                    array_push($getImages, $src);
                });
        }
        $totalImage = sizeof($getImages);

        factory(Product::class, $totalImage)->create();

        /**
         * Storage images for product
         */
        for($i = 0; $i < sizeof($getImages); $i++) {
            $url = $getImages[$i];
            $productId = $i + 1;
            $contents = file_get_contents($url);
            $name = "product_" . $productId;
            $folder = "public/images/products/";
            Storage::put($folder . $name, $contents);

            //Seeding image
            Image::create([
                'name' => $name,
                'type' => Image::FIRST,
                'product_id' => $productId,
            ]);
        }

        /**
         * Seeding trend product
         */
        for($i = 0; $i < 30; $i++) {
            TrendProduct::create([
                'trend_id' => rand(1, 2),
                'product_id' => $i + 1,
            ]);
        }
    }
}
