<?php

namespace Core\Overview\Infrastructure\Services;

use Core\Overview\Domain\Services\OverviewService;
use Core\Overview\Domain\Repositories\OverviewRepositoryInterface;
use Core\Overview\Infrastructure\Helpers\Compare;
use Illuminate\Support\Facades\Log;

class OverviewServiceImpl implements OverviewService
{
    public function __construct(private OverviewRepositoryInterface $repo) {}
    public function index(array $data): array
    {

        return [
            'month' => $this->repo->getCacheForMonth($data) ?? [
                'order' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ],
                'product' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ],
                'customer' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ],
                'purchase'  => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ]
            ],
            'chart' => $this->repo->getCacheForYear($data),
            'revenue' => $this->repo->getCacheRevenueByTime($data) ?? [
                'dailly' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ],
                'weekly' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ],
                'monthly' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ],
                'yearly' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ]
            ],
            'expense' => $this->repo->getCacheExpenseByTime($data) ?? [
                'dailly' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ],
                'weekly' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ],
                'monthly' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ],
                'yearly' => [
                    'current' => 0,
                    'prev' => 0,
                    'compare' => 0
                ]
            ],
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
        $order = [];
        $order['current'] = $this->repo->getOrder([
            'month' => date('m', time()),
            'business_id' => $data['business_id']
        ]);
        $order['prev'] = $this->repo->getOrder([
            'month' => now()->startOfMonth()->subMonth()->month,
            'business_id' => $data['business_id']
        ]);
        $order['compare'] = Compare::handle($order['prev'], $order['current']);
        $product = [];
        $product['current'] = $this->repo->getProduct([
            'month' => date('m', time()),
            'business_id' => $data['business_id']
        ]);
        $product['prev'] = $this->repo->getProduct([
            'month' => now()->startOfMonth()->subMonth()->month,
            'business_id' => $data['business_id']
        ]);
        $product['compare'] = Compare::handle($product['prev'], $product['current']);

        $customer = [];
        $customer['current'] = $this->repo->getCustomer([
            'month' => date('m', time()),
            'business_id' => $data['business_id']
        ]);
        $customer['prev'] = $this->repo->getCustomer([
            'month' => now()->startOfMonth()->subMonth()->month,
            'business_id' => $data['business_id']
        ]);
        $customer['compare'] = Compare::handle($customer['prev'], $customer['current']);

        $purchase = [];
        $purchase['current'] = $this->repo->getPurchase([
            'month' => date('m', time()),
            'business_id' => $data['business_id']
        ]);
        $purchase['prev'] = $this->repo->getPurchase([
            'month' => now()->startOfMonth()->subMonth()->month,
            'business_id' => $data['business_id']
        ]);
        $purchase['compare'] = Compare::handle($purchase['prev'], $purchase['current']);

        $array = [
            'order' => $order,
            'product' => $product,
            'customer' => $customer,
            'purchase'  => $purchase
        ];
        return $this->repo->createCacheForMonth($array, $data['business_id']);
    }
    public function createRevenueByTime(array $data): void
    {
        $array = [
            'dailly' => [
                'current' => 0,
                'prev' => 0,
                'compare' => 0
            ],
            'weekly' => [
                'current' => 0,
                'prev' => 0,
                'compare' => 0
            ],
            'monthly' => [
                'current' => 0,
                'prev' => 0,
                'compare' => 0
            ],
            'yearly' => [
                'current' => 0,
                'prev' => 0,
                'compare' => 0
            ]
        ];
        /**
         * Daily
         */
        $today = $this->repo->getRevenueByTime([
            'start' => now()->startOfDay(),
            'end'   => now()->endOfDay(),
            'business_id' => $data['business_id']
        ]);
        $yesterday = $this->repo->getRevenueByTime([
            'start' => now()->subDay()->startOfDay(),
            'end'   => now()->subDay()->endOfDay(),
            'business_id' => $data['business_id']
        ]);
        $array['dailly'] = [
            'current' => $today,
            'prev' => $yesterday,
            'compare' => Compare::handle($yesterday, $today)
        ];
        /**
         * Weekly
         */
        $weekly = $this->repo->getRevenueByTime([
            'start' => now()->startOfWeek(),
            'end'   => now()->endOfWeek(),
            'business_id' => $data['business_id']
        ]);
        $lastWeek = $this->repo->getRevenueByTime([
            'start' => now()->subWeek()->startOfWeek(),
            'end'   => now()->subWeek()->endOfWeek(),
            'business_id' => $data['business_id']
        ]);
        $array['weekly'] = [
            'current' => $weekly,
            'prev' => $lastWeek,
            'compare' => Compare::handle($lastWeek, $weekly)
        ];
        /**
         * Monthly
         */
        $monthly = $this->repo->getRevenueByTime([
            'start' => now()->startOfMonth(),
            'end'   => now()->endOfMonth(),
            'business_id' => $data['business_id']
        ]);
        $lastMonth = $this->repo->getRevenueByTime([
            'start' => now()->subMonth()->startOfMonth(),
            'end'   => now()->subMonth()->endOfMonth(),
            'business_id' => $data['business_id']
        ]);
        $array['monthly'] = [
            'current' => $monthly,
            'prev' => $lastMonth,
            'compare' => Compare::handle($lastMonth, $monthly)
        ];
        /**
         * Yearly
         */
        $yearly = $this->repo->getRevenueByTime([
            'start' => now()->startOfYear(),
            'end'   => now()->endOfYear(),
            'business_id' => $data['business_id']
        ]);
        $lastYear = $this->repo->getRevenueByTime([
            'start' => now()->subYear()->startOfYear(),
            'end'   => now()->subYear()->endOfYear(),
            'business_id' => $data['business_id']
        ]);
        $array['yearly'] = [
            'current' => $yearly,
            'prev' => $lastYear,
            'compare' => Compare::handle($lastYear, $yearly)
        ];
        $this->repo->createCacheRevenueByTime($array, $data['business_id']);
    }
    public function createExpenseByTime(array $data): void
    {
        $array = [
            'dailly' => [
                'current' => 0,
                'prev' => 0,
                'compare' => 0
            ],
            'weekly' => [
                'current' => 0,
                'prev' => 0,
                'compare' => 0
            ],
            'monthly' => [
                'current' => 0,
                'prev' => 0,
                'compare' => 0
            ],
            'yearly' => [
                'current' => 0,
                'prev' => 0,
                'compare' => 0
            ]
        ];
        /**
         * Daily
         */
        $today = $this->repo->getExpenseByTime([
            'start' => now()->startOfDay(),
            'end'   => now()->endOfDay(),
            'business_id' => $data['business_id']
        ]);
        $yesterday = $this->repo->getExpenseByTime([
            'start' => now()->subDay()->startOfDay(),
            'end'   => now()->subDay()->endOfDay(),
            'business_id' => $data['business_id']
        ]);
        $array['dailly'] = [
            'current' => $today,
            'prev' => $yesterday,
            'compare' => Compare::handle($yesterday, $today)
        ];
        /**
         * Weekly
         */
        $weekly = $this->repo->getExpenseByTime([
            'start' => now()->startOfWeek(),
            'end'   => now()->endOfWeek(),
            'business_id' => $data['business_id']
        ]);
        $lastWeek = $this->repo->getExpenseByTime([
            'start' => now()->subWeek()->startOfWeek(),
            'end'   => now()->subWeek()->endOfWeek(),
            'business_id' => $data['business_id']
        ]);
        $array['weekly'] = [
            'current' => $weekly,
            'prev' => $lastWeek,
            'compare' => Compare::handle($lastWeek, $weekly)
        ];
        /**
         * Monthly
         */
        $monthly = $this->repo->getExpenseByTime([
            'start' => now()->startOfMonth(),
            'end'   => now()->endOfMonth(),
            'business_id' => $data['business_id']
        ]);
        $lastMonth = $this->repo->getExpenseByTime([
            'start' => now()->subMonth()->startOfMonth(),
            'end'   => now()->subMonth()->endOfMonth(),
            'business_id' => $data['business_id']
        ]);
        $array['monthly'] = [
            'current' => $monthly,
            'prev' => $lastMonth,
            'compare' => Compare::handle($lastMonth, $monthly)
        ];
        /**
         * Yearly
         */
        $yearly = $this->repo->getExpenseByTime([
            'start' => now()->startOfYear(),
            'end'   => now()->endOfYear(),
            'business_id' => $data['business_id']
        ]);
        $lastYear = $this->repo->getExpenseByTime([
            'start' => now()->subYear()->startOfYear(),
            'end'   => now()->subYear()->endOfYear(),
            'business_id' => $data['business_id']
        ]);
        $array['yearly'] = [
            'current' => $yearly,
            'prev' => $lastYear,
            'compare' => Compare::handle($lastYear, $yearly)
        ];
        $this->repo->createCacheExpenseByTime($array, $data['business_id']);
    }
}
