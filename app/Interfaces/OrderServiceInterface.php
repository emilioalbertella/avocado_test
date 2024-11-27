<?php
declare(strict_types=1);

namespace App\Interfaces;

/**
 * @interface
 */
interface OrderServiceInterface
{
    /**
     * @param $startDate
     * @param $endDate
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getOrdersBetweenDates($startDate, $endDate = null): \Illuminate\Database\Eloquent\Collection|array;
}
