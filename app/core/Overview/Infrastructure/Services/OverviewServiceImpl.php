<?php

namespace Core\Overview\Infrastructure\Services;

use App\Models\BusinessModel;
use Core\Overview\Domain\Services\OverviewService;
use Core\Overview\Domain\Repositories\OverviewRepositoryInterface;
use Illuminate\Support\Facades\Log;

class OverviewServiceImpl implements OverviewService
{
    public function __construct(private OverviewRepositoryInterface $repo) {}
    public function index(array $data): array
    {

        return [
            'month' => $this->repo->getCacheForMonth(),
            'chart' => $this->repo->getCacheForYear()
        ];
    }

    public function createCacheForYear(): array
    {
        $return = [];
        foreach (BusinessModel::get() as $key => $data) {
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
                        'business_id' => $data->business_id,
                        'month' => $i + 1
                    ]),
                    'name' => $value
                ];
                $i++;
            }
            $return[] = $this->repo->createCacheForYear($chart);
        }

        return $return;
    }

    public function createCacheForMonth(): array
    {
        $return = [];
        foreach (BusinessModel::get() as $key => $data) {
            $order = [];
            $order['current'] = $this->repo->getOrder([
                'month' => date('m', time()),
                'business_id' => $data->business_id
            ]);
            $order['prev'] = $this->repo->getOrder([
                'month' => now()->startOfMonth()->subMonth()->month,
                'business_id' => $data->business_id
            ]);
            $order['compare'] = $order['prev'] >= 1 ? ($order['prev'] / $order['current'] * 100) - 100 : 100;

            $product = [];
            $product['current'] = $this->repo->getProduct([
                'month' => date('m', time()),
                'business_id' => $data->business_id
            ]);
            $product['prev'] = $this->repo->getProduct([
                'month' => now()->startOfMonth()->subMonth()->month,
                'business_id' => $data->business_id
            ]);
            $product['compare'] = $product['prev'] >= 1
                ? ($product['prev'] / $product['current'] * 100) - 100
                : 100;

            $customer = [];
            $customer['current'] = $this->repo->getCustomer([
                'month' => date('m', time()),
                'business_id' => $data->business_id
            ]);
            $customer['prev'] = $this->repo->getCustomer([
                'month' => now()->startOfMonth()->subMonth()->month,
                'business_id' => $data->business_id
            ]);
            $customer['compare'] = $customer['prev'] >= 1
                ? ($customer['prev'] / $customer['current'] * 100) - 100
                : 100;

            $revenue = [];
            $revenue['current'] = $this->repo->getRevenue([
                'month' => date('m', time()),
                'business_id' => $data->business_id
            ]);
            $revenue['prev'] = $this->repo->getRevenue([
                'month' => now()->startOfMonth()->subMonth()->month,
                'business_id' => $data->business_id
            ]);
            $revenue['compare'] = $revenue['prev'] >= 1
                ? ($revenue['prev'] / $revenue['current'] * 100) - 100
                : 100;

            $array = [
                'order' => $order,
                'product' => $product,
                'customer' => $customer,
                'revenue'  => $revenue
            ];
            $return[] = $this->repo->createCacheForMonth($array);
        }

        return $return;
    }
}
