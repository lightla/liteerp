<?php

namespace Core\Overview\Infrastructure\Services;

use Core\Overview\Domain\Entities\Overview;
use Core\Overview\Domain\Services\OverviewService;
use Core\Overview\Domain\Repositories\OverviewRepositoryInterface;

class OverviewServiceImpl implements OverviewService
{
    public function __construct(private OverviewRepositoryInterface $repo) {}
    public function index(array $data): array
    {

        return [
            'top' => [
                ...$this->repo->getCacheForMonth($data),
                ...$this->repo->getCacheRevenueByTime($data),
                ...$this->repo->getCacheExpenseByTime($data)
            ],
            'chart' => $this->repo->getCacheForYear($data),
        ];
    }

    public function createCacheForYear(array $data): array
    {
        $chart = [];
        $i = 0;
        foreach (
            [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December',
            ] as $key => $value
        ) {
            $chart[] = [
                ...$this->repo->businessChart([
                    'business_id' => $data['business_id'],
                    'month' => $i + 1
                ]),
                'name' => $value,
            ];
            $i++;
        }
        return $this->repo->createCacheForYear($chart, $data['business_id']);
    }

    public function createCacheForMonth(array $data): array
    {
        $array = [];
        $array[] = new Overview(
            current: $this->repo->getOrder([
                'month' => date('m', time()),
                'business_id' => $data['business_id']
            ]),
            prev: $this->repo->getOrder([
                'month' => now()->startOfMonth()->subMonth()->month,
                'business_id' => $data['business_id']
            ]),
            type: 'Monthly orders',
            compare_text: 'compared to last monthly',
            icon: 'bi bi-bag-plus'
        );
        $array[] = new Overview(
            current: $this->repo->getProduct([
                'month' => date('m', time()),
                'business_id' => $data['business_id']
            ]),
            prev: $this->repo->getProduct([
                'month' => now()->startOfMonth()->subMonth()->month,
                'business_id' => $data['business_id']
            ]),
            type: 'Monthly products',
            compare_text: 'compared to last monthly',
            icon: 'bi bi-file-earmark-binary'
        );
        $array[] = new Overview(
            current: $this->repo->getCustomer([
                'month' => date('m', time()),
                'business_id' => $data['business_id']
            ]),
            prev: $this->repo->getCustomer([
                'month' => now()->startOfMonth()->subMonth()->month,
                'business_id' => $data['business_id']
            ]),
            type: 'Monthly customers',
            compare_text: 'compared to last monthly',
            icon: 'bi bi-people'
        );
        $array[] = new Overview(
            current: $this->repo->getPurchase([
                'month' => date('m', time()),
                'business_id' => $data['business_id']
            ]),
            prev: $this->repo->getPurchase([
                'month' => now()->startOfMonth()->subMonth()->month,
                'business_id' => $data['business_id']
            ]),
            type: 'Monthly purchase',
            compare_text: 'compared to last monthly'
        );
        return $this->repo->createCacheForMonth($array, $data['business_id']);
    }
    public function createRevenueByTime(array $data): void
    {
        $array = [];
        /**
         * Daily
         */
        $array[] = new Overview(
            current: $this->repo->getRevenueByTime([
            'start' => now()->startOfDay(),
            'end'   => now()->endOfDay(),
            'business_id' => $data['business_id']
        ]),
            prev: $this->repo->getPurchase([
                'month' => now()->startOfMonth()->subMonth()->month,
                'business_id' => $data['business_id']
            ]),
            type: 'Dailly revenues',
            compare_text: 'compared to last day'
        );
        /**
         * Weekly
         */
        $array[] = new Overview(
            current: $this->repo->getRevenueByTime([
            'start' => now()->startOfWeek(),
            'end'   => now()->endOfWeek(),
            'business_id' => $data['business_id']
        ]),
            prev: $this->repo->getRevenueByTime([
            'start' => now()->subWeek()->startOfWeek(),
            'end'   => now()->subWeek()->endOfWeek(),
            'business_id' => $data['business_id']
        ]),
            type: 'Weekly revenues',
            compare_text: 'compared to last week'
        );
        /**
         * Monthly
         */
        $array[] = new Overview(
            current: $this->repo->getRevenueByTime([
            'start' => now()->startOfMonth(),
            'end'   => now()->endOfMonth(),
            'business_id' => $data['business_id']
        ]),
            prev: $this->repo->getRevenueByTime([
            'start' => now()->subMonth()->startOfMonth(),
            'end'   => now()->subMonth()->endOfMonth(),
            'business_id' => $data['business_id']
        ]),
            type: 'Monthly revenues',
            compare_text: 'compared to last month'
        );
        /**
         * Yearly
         */
        $array[] = new Overview(
            current: $this->repo->getRevenueByTime([
            'start' => now()->startOfYear(),
            'end'   => now()->endOfYear(),
            'business_id' => $data['business_id']
        ]),
            prev: $this->repo->getRevenueByTime([
            'start' => now()->subYear()->startOfYear(),
            'end'   => now()->subYear()->endOfYear(),
            'business_id' => $data['business_id']
        ]),
            type: 'Yearly revenues',
            compare_text: 'compared to last year'
        );
        $this->repo->createCacheRevenueByTime($array, $data['business_id']);
    }
    public function createExpenseByTime(array $data): void
    {
        $array = [];
        /**
         * Daily
         */
        $array[] = new Overview(
            current: $this->repo->getExpenseByTime([
            'start' => now()->startOfDay(),
            'end'   => now()->endOfDay(),
            'business_id' => $data['business_id']
        ]),
            prev: $this->repo->getExpenseByTime([
            'start' => now()->subDay()->startOfDay(),
            'end'   => now()->subDay()->endOfDay(),
            'business_id' => $data['business_id']
        ]),
            type: 'Dailly expenses',
            compare_text: 'compared to last day'
        );
        /**
         * Weekly
         */
        $array[] = new Overview(
            current: $this->repo->getExpenseByTime([
            'start' => now()->startOfWeek(),
            'end'   => now()->endOfWeek(),
            'business_id' => $data['business_id']
        ]),
            prev: $this->repo->getExpenseByTime([
            'start' => now()->subWeek()->startOfWeek(),
            'end'   => now()->subWeek()->endOfWeek(),
            'business_id' => $data['business_id']
        ]),
            type: 'Weekly expenses',
            compare_text: 'compared to last week'
        );
        /**
         * Monthly
         */
        $array[] = new Overview(
            current: $this->repo->getExpenseByTime([
            'start' => now()->startOfMonth(),
            'end'   => now()->endOfMonth(),
            'business_id' => $data['business_id']
        ]),
            prev: $this->repo->getExpenseByTime([
            'start' => now()->subMonth()->startOfMonth(),
            'end'   => now()->subMonth()->endOfMonth(),
            'business_id' => $data['business_id']
        ]),
            type: 'Monthly expenses',
            compare_text: 'compared to last month'
        );
        /**
         * Yearly
         */
        $array[] = new Overview(
            current: $this->repo->getExpenseByTime([
            'start' => now()->startOfYear(),
            'end'   => now()->endOfYear(),
            'business_id' => $data['business_id']
        ]),
            prev: $this->repo->getExpenseByTime([
            'start' => now()->subYear()->startOfYear(),
            'end'   => now()->subYear()->endOfYear(),
            'business_id' => $data['business_id']
        ]),
            type: 'Yearly expenses',
            compare_text: 'compared to last year'
        );
        $this->repo->createCacheExpenseByTime($array, $data['business_id']);
    }
}
