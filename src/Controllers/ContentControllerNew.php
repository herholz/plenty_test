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
                'imageId',
                'url'
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
        foreach ($resultItems as $item)
        {
            //$img = $imageRepository->show($item['variationImageList']['imageId']);
            //$item->url = $img.url
            $items[] = $item;

        }
        $templateData = array(
            'resultCount' => $resultItems->count(),
            'currentItems' => $items
        );
 
        return $twig->render('HelloWorld::content.test', $templateData);
    }
}