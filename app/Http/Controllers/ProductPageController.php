<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
  public function show(Request $request, ProductService $productService)
  {
    $productId = filter_var($request->query('id'), FILTER_VALIDATE_INT);
    $product = $productId ? $productService->findProductById((int) $productId) : null;

    if ($product === null) {
      return response()->view('product.not-found', [], 404);
    }

    $productName = $product->name;
    $productSubtitle = $product->subtitle;
    $productPrice = (float) $product->price;
    $productImage = $product->image_path !== '' ? $product->image_path : 'img/stampanti3d.png';

    return view('product.show', [
      'product' => $product,
      'productId' => (int) $product->getKey(),
      'productName' => $productName,
      'productSubtitle' => $productSubtitle,
      'productSubtitleFallback' => $productSubtitle !== '' ? $productSubtitle : 'Stampante 3D dinamica',
      'productPrice' => $productPrice,
      'productPriceFormatted' => number_format($productPrice, 2, ',', '.'),
      'productInstallmentFormatted' => number_format($productPrice / 3, 2, ',', '.'),
      'productImage' => $productImage,
      'productDescription' => $productSubtitle !== '' ? $productSubtitle : 'Stampante 3D disponibile nel catalogo.',
      'productSpecsSubtitle' => $productSubtitle !== '' ? $productSubtitle : '-',
      'collectionLabel' => $this->collectionLabel((int) $product->type),
      'collectionUrl' => $this->collectionUrl((int) $product->type),
    ]);
  }

  private function collectionLabel(int $type): string
  {
    return match ($type) {
      1 => 'Filamenti',
      2 => 'Accessori',
      3 => "Maker's Supply",
      4 => 'Materiali',
      5 => 'AMS',
      default => 'Stampanti 3D',
    };
  }

  private function collectionUrl(int $type): string
  {
    return match ($type) {
      1 => url('/filamenti'),
      2 => url('/accessori'),
      3 => url('/makersupply'),
      4 => url('/materiali'),
      5 => url('/ams'),
      default => url('/3d-printer'),
    };
  }
}
