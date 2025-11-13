<?php

namespace App\Http\Controllers;

use App\Models\Warehouse; 
use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\Support\Facades\DB; 
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{

    public function index(Request $request)
    {

        $selectedWarehouseId = $request->query('warehouse_id');
        $searchQuery = $request->query('search'); 

        $stockQuery = DB::table('product_warehouse')
            ->join('products', 'product_warehouse.product_id', '=', 'products.id')
            ->join('warehouses', 'product_warehouse.warehouse_id', '=', 'warehouses.id')
            ->select(
                'products.name as product_name',
                'products.sku as product_sku',
                'warehouses.name as warehouse_name',
                'product_warehouse.quantity'
            );

        if ($selectedWarehouseId) {
            $stockQuery->where('product_warehouse.warehouse_id', $selectedWarehouseId);
        }


        if ($searchQuery) {
            $stockQuery->where(function ($query) use ($searchQuery) {
                $query->where('products.name', 'LIKE', '%' . $searchQuery . '%')
                      ->orWhere('products.sku', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        $stocks = $stockQuery->orderBy('warehouses.name')->orderBy('products.name')->get();
        $warehouses = Warehouse::all();

        return view('stocks.index', [
            'stocks' => $stocks,
            'warehouses' => $warehouses,
            'selectedWarehouseId' => $selectedWarehouseId,
            'searchQuery' => $searchQuery 
        ]);
        
    }

    public function createTransfer()
    {
        $warehouses = Warehouse::all();
        $products = Product::orderBy('name')->get();

        return view('stocks.transfer', [
            'warehouses' => $warehouses,
            'products' => $products,
        ]);
    }


    public function storeTransfer(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|not_in:0',
            'notes' => 'nullable|string',
        ]);

        $warehouseId = $validated['warehouse_id'];
        $productId = $validated['product_id'];
        $inputQuantity = (int) $validated['quantity']; 

        try {
            $result = DB::transaction(function () use ($warehouseId, $productId, $inputQuantity, $validated) {
                
                $currentStockRow = DB::table('product_warehouse')
                    ->where('warehouse_id', $warehouseId)
                    ->where('product_id', $productId)
                    ->first();

                $currentStock = $currentStockRow ? (int) $currentStockRow->quantity : 0;
                
                $newStock = $currentStock + $inputQuantity;

                if ($inputQuantity < 0 && $newStock < 0) {
                    throw new \Exception("Stok tidak mencukupi. Stok saat ini: $currentStock, Anda mencoba mengeluarkan: " . abs($inputQuantity));
                }

                DB::table('product_warehouse')->updateOrInsert(
                    ['warehouse_id' => $warehouseId, 'product_id' => $productId],
                    ['quantity' => $newStock]
                );

                StockMovement::create([
                    'user_id' => Auth::id(), 
                    'product_id' => $productId,
                    'warehouse_id' => $warehouseId,
                    'type' => $inputQuantity > 0 ? 'in' : 'out',
                    'quantity' => $inputQuantity,
                    'notes' => $validated['notes'],
                    'created_at' => now(),
                ]);

                return true; 
            });

            return redirect()->route('stocks.index')
                             ->with('success', 'Stok berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'GAGAL: ' . $e->getMessage());
        }
    }
}