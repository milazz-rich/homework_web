<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use App\Services\AuthService;
use App\Services\ProductService;

class AppServiceProvider extends ServiceProvider
{
	public function boot(): void
	{
		View::composer('layouts.header', function ($view) {
			try {
				$authService = app(AuthService::class);
				$authUser = $authService->currentUser();
			} catch (\Throwable $e) {
				Log::error($e->getMessage());
				$authUser = null;
			}

			try {
				$productService = app(ProductService::class);

				$dropdownPrinters = $productService->getLatestProductsByType(0, 4);
				$dropdownSaldiFeatured = $productService->getLatestProductsByType(1, 1);
				$dropdownAms = $productService->getLatestProductsByType(5, 4);
				$dropdownFilaments = $productService->getLatestProductsByType(1, 4);
				$dropdownAccessories = $productService->getLatestProductsByType(2, 4);
				$dropdownMakerSupply = $productService->getLatestProductsByType(3, 8);
			} catch (\Throwable $e) {
				Log::error($e->getMessage());

				$dropdownPrinters = [];
				$dropdownSaldiFeatured = [];
				$dropdownAms = [];
				$dropdownFilaments = [];
				$dropdownAccessories = [];
				$dropdownMakerSupply = [];
			}

			$view->with([
				'authUser' => $authUser,
				'dropdownPrinters' => $dropdownPrinters,
				'dropdownSaldiFeatured' => $dropdownSaldiFeatured,
				'dropdownAms' => $dropdownAms,
				'dropdownFilaments' => $dropdownFilaments,
				'dropdownAccessories' => $dropdownAccessories,
				'dropdownMakerSupply' => $dropdownMakerSupply,
			]);
		});
	}
}