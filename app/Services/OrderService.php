<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\OrderInterface;
use App\Interfaces\OrderServiceInterface;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * @class OrderService
 * @package App\Services
 */
class OrderService implements OrderServiceInterface
{
    /**
     * @param $startDate
     * @param $endDate
     * @return Collection|array
     */
    public function getOrdersBetweenDates($startDate, $endDate = null): Collection|array
    {
        $query = Order::query();

        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // If only start_date is provided, filter by that specific date
        else if ($startDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();

            $query->whereDate('created_at', '=', $startDate);
        }

        return $query->with('items')->get();
    }
}
