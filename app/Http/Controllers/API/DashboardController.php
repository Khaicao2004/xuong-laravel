<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getStatistics(Request $request)
    {
        $type = $request->query('type', 'day');

        // Xử lý thống kê tổng từ trước đến nay
        $totalRevenueAllTime = Order::where('status_order', Order::STATUS_ORDER_DELIVERED)
            ->where('status_payment', Order::STATUS_PAYMENT_PAID)
            ->sum('total_price');

        $totalOrdersAllTime = Order::where('status_order', Order::STATUS_ORDER_DELIVERED)
            ->where('status_payment', Order::STATUS_PAYMENT_PAID)
            ->count();

        $totalCanceledOrdersAllTime = Order::where('status_order', Order::STATUS_ORDER_CANCELED)
            ->count();

        $totalMembersAllTime = User::where('type', 'member')->count();
        $startDate = null;
        $endDate = Carbon::now();

        // Xử lý thống kê theo khoảng thời gian cụ thể
        switch ($type) {
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                break;
            default:
                $startDate = Carbon::now()->startOfDay();
                break;
        }
        // Tổng doanh thu
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status_order', Order::STATUS_ORDER_DELIVERED)
            ->where('status_payment', Order::STATUS_PAYMENT_PAID)
            ->sum('total_price');

        // Tổng số đơn hàng
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status_order', Order::STATUS_ORDER_DELIVERED)
            ->where('status_payment', Order::STATUS_PAYMENT_PAID)
            ->count();
        // Tổng số đơn hàng bị hủy
        $totalCanceledOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status_order', Order::STATUS_ORDER_CANCELED)
            ->count();
        // Tính tỷ lệ giao hàng thành công
        $deliverySuccessRatio = $totalOrdersAllTime > 0 ? ($totalOrders / $totalOrdersAllTime) * 100 : 0;
        return response()->json([
            'totalRevenueAllTime' => $totalRevenueAllTime,
            'totalOrdersAllTime' => $totalOrdersAllTime,
            'totalMembersAllTime' => $totalMembersAllTime,
            'totalCanceledOrdersAllTime' => $totalCanceledOrdersAllTime,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalCanceledOrders' => $totalCanceledOrders,
            'deliverySuccessRatio' => round($deliverySuccessRatio, 2)
        ]);
    }
    public function bestSellingProduct(Request $request)
    {
        $type = $request->query('type', 'today');
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();
        switch ($type) {
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'last_7_days':
                $startDate = now()->subDays(7)->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'last_30_days':
                $startDate = now()->subDays(30)->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'this_month':
                $startDate = now()->startOfMonth()->startOfDay();
                $endDate = now()->endOfMonth()->endOfDay();
                break;
            case 'last_month':
                $startDate = now()->subMonth()->startOfMonth()->startOfDay();
                $endDate = now()->subMonth()->endOfMonth()->endOfDay();
                break;
            case 'today':
            default:
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
        }
        $bestSellingProduct = OrderItem::select(
            'product_name',
            'product_img_thumbnail',
            'product_price_sale',
            DB::raw('SUM(quatity) as total_orders'),
            DB::raw('SUM(quatity * product_price_sale) as total_amount')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('product_name', 'product_img_thumbnail', 'product_price_sale')
            ->orderBy('total_orders', 'desc')
            ->take(5)
            ->get();

        return response()->json($bestSellingProduct);
    }
    public function recentOrders(){
        $recentOrders = Order::with('orderItems')
        ->where('created_at', '>=', now()->subDays(3))
        ->orderByDesc('created_at')
        ->get();    
        return response()->json($recentOrders);
    }
}
