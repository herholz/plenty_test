<?php
 
namespace HelloWorld\Controllers;
 
 
use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;
use Plenty\Modules\Item\DataLayer\Contracts\ItemDataLayerRepositoryContract;
use Plenty\Modules\Item\ItemImage\Contracts\ItemImageRepositoryContract;
 
class ContentControllerNew extends Controller
{
    public function showTopItems(Twig $twig, ItemDataLayerRepositoryContract $itemRepository, ItemImageRepositoryContract $imageRepository):string
    {
        $itemColumns = [
            'itemDescription' => [
                'name1',
                'description'
            ],
            'variationBase' => [
                'id'
            ],
            'variationRetailPrice' => [
                'price'
            ],
            'variationImageList' => [
                'path',
                'cleanImageName',
                'imageId'
            ]
        ];
 
        $itemFilter = [
            'itemBase.isStoreSpecial' => [
                'shopAction' => [3]
            ]
        ];
 
        $itemParams = [
            'language' => 'en'
        ];
 
        $resultItems = $itemRepository
            ->search($itemColumns, $itemFilter, $itemParams);
 
        $items = array();
        $images = array();
        foreach ($resultItems as $item)
        {
            $img = $imageRepository->findByVariationId($item["variationBase"]["id"]);

            foreach($img as $i){
                $url = 'https://im2.io/kjtlgmzqks/quality=medium/'.$i["url"];

                // use key 'http' even if you send the request to https://...
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data)
                    )
                );
                $context  = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                if ($result === FALSE) { /* Handle error */ }

                $type = $i["fileType"];
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($result);
                $images[] = $base64;

            }
            //$img = $imageRepository->show($item['variationImageList']['imageId']);
            //$img = $imageRepository->show($item['variationImageList']['imageId']);
            //$item->url = $img.url
            $items[] = $item;
            //$images[] = $img;

        }
        $templateData = array(
            'resultCount' => $resultItems->count(),
            'currentItems' => $items,
            'images' => $images
        );
 
        return $twig->render('HelloWorld::content.test', $templateData);
    }
}