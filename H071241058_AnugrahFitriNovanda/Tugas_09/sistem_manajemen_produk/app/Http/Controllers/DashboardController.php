<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil Data KPI (Kartu Atas) ---
        $data['product_count'] = Product::count();
        $data['warehouse_count'] = Warehouse::count();
        $data['category_count'] = Category::count();
        // Menghitung total semua unit stok di semua gudang
        $data['total_stock_value'] = DB::table('product_warehouse')->sum('quantity');

        // Mengambil nama gudang dan total stok di gudang tersebut
        $stockPerWarehouse = Warehouse::withSum('products as total_stok', 'product_warehouse.quantity')
            ->get();

        // Format data untuk Chart.js
        $data['warehouseChart']['labels'] = $stockPerWarehouse->pluck('name');
        $data['warehouseChart']['data'] = $stockPerWarehouse->pluck('total_stok');
        
        // Pergerakan Stok 7 Hari Terakhir (Line Chart) ---
        $stockMovements = StockMovement::where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(CASE WHEN type = "in" THEN quantity ELSE 0 END) as stok_masuk'),
                DB::raw('SUM(CASE WHEN type = "out" THEN quantity ELSE 0 END) as stok_keluar')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Format data untuk Chart.js
        $data['movementChart']['labels'] = $stockMovements->pluck('tanggal')->map(function ($date) {
            return date('d M', strtotime($date)); 
        });
        $data['movementChart']['stok_masuk'] = $stockMovements->pluck('stok_masuk');
        $data['movementChart']['stok_keluar'] = $stockMovements->pluck('stok_keluar')->map(fn ($val) => abs($val));


        $data['low_stock_products'] = DB::table('product_warehouse')
            ->join('products', 'product_warehouse.product_id', '=', 'products.id')
            ->join('warehouses', 'product_warehouse.warehouse_id', '=', 'warehouses.id')
            ->select('products.name as product_name', 'warehouses.name as warehouse_name', 'product_warehouse.quantity')
            ->where('product_warehouse.quantity', '<=', 50) 
            ->orderBy('product_warehouse.quantity', 'asc')
            ->limit(5)
            ->get();

        $data['recent_movements'] = StockMovement::with(['product', 'warehouse', 'user'])
            ->latest() 
            ->limit(5)
            ->get();


        return view('dashboard', [
            'user' => $user,
            'data' => $data
        ]);
    }
}