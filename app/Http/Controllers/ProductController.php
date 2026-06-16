<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService) {}

    public function home(): View
    {
        return view('home', $this->productService->homeProducts());
    }

    public function catalog(string $catalog): View
    {
        $catalogData = $this->productService->catalogProducts($catalog);

        abort_unless($catalogData !== null, Response::HTTP_NOT_FOUND);

        return view('catalog.show', $catalogData);
    }

    public function sales(): View
    {
        return view('catalog.show', [
            'title' => 'Saldi',
            'products' => $this->productService->salesProducts(),
        ]);
    }

    public function show(int $id): View
    {
        return view('products.show', [
            'product' => $this->productService->productById($id),
        ]);
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $limit = null;
        $type = null;

        if ($request->filled('type')) {
            if (! ctype_digit((string) $request->input('type'))) {
                return response()->json(['message' => 'Il parametro type deve essere un numero intero valido.'], Response::HTTP_BAD_REQUEST);
            }

            $type = (int) $request->input('type');
        }

        if ($request->filled('limit')) {
            if (! ctype_digit((string) $request->input('limit'))) {
                return response()->json(['message' => 'Il parametro limit deve essere un numero intero valido.'], Response::HTTP_BAD_REQUEST);
            }

            $limit = (int) $request->input('limit');
        }

        return response()->json($this->productService->apiProducts($type, $limit));
    }
}
