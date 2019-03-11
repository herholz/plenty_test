<?php
 
namespace PivotPlugin\Controllers;
 
 
use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;
use Plenty\Modules\Item\DataLayer\Contracts\ItemDataLayerRepositoryContract;
use Plenty\Modules\Item\ItemImage\Contracts\ItemImageRepositoryContract;
use Plenty\Modules\Plugin\Libs\Contracts\LibraryCallContract;
use Plenty\Plugin\Http\Request;
use Plenty\Modules\Order\Contracts\OrderRepositoryContract;
use Plenty\Repositories\Models\PaginatedResult;

 
class ContentControllerNew extends Controller
{

    public function showPivot(Twig $twig, OrderRepositoryContract $orderRepository):string
    {
        $filters = ["outgoingItemsBookedAtFrom" => "2019-01-01T00:00:00+00:00", "outgoingItemsBookedAtTo" => "2019-01-31T00:00:00+00:00", "statusFrom" => 7.4, "statusTo" => 7.4, "warehouseId" => 1];

        $orderRepository->setFilters($filters);

        $result = $orderRepository->searchOrders(1, 100, ["orderItems.variation"]);

        $templateData = array(
            'resultCount' => $result->getTotalCount(),
            'item1' => $result
        );
 
        return $twig->render('PivotPlugin::content.pivot', $templateData);
    }

    public function showTopItems(Twig $twig, ItemDataLayerRepositoryContract $itemRepository, ItemImageRepositoryContract $imageRepository, LibraryCallContract $libCall,
        Request $request):string
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
               /* $url = 'https://im2.io/kjtlgmzqks/quality=medium/'.$i["url"];

                // use key 'http' even if you send the request to https://...
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST'
                    )
                );
                $context  = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                if ($result === FALSE) { }*/

                

                $result =
                    $libCall->call(
                        'HelloWorld::guzzle_connector',
                        ['imageUrl' => $i["url"]]
                    );

                $type = $i["fileType"];
                $base64 = 'data:image/' . $type . ';base64,' . json_encode($result);
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