import React, { useEffect, useRef, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import DashboardSummary from '../components/Dashboard/DashboardSummary'
import BusinessChart from '../components/Dashboard/BusinessChart'
import OverviewService from '../services/OverviewService';
import { BoxArrowUp, Cart, CurrencyDollar, People } from 'react-bootstrap-icons';
export default function Dashboard() {
    const [summaryData, setSummaryData] = useState([]);
    {/* [
        { name: "January", sales: 4000, importCost: 1500, shippingCost: 900, netProfit: 1600, inventory: 1200 },
        { name: "February", sales: 3000, importCost: 1100, shippingCost: 700, netProfit: 1200, inventory: 1000 },
        { name: "March", sales: 5000, importCost: 1900, shippingCost: 700, netProfit: 2400, inventory: 900 },
        { name: "April", sales: 4780, importCost: 2100, shippingCost: 1000, netProfit: 1680, inventory: 850 },
        { name: "May", sales: 5890, importCost: 2200, shippingCost: 1000, netProfit: 2690, inventory: 950 },
        { name: "June", sales: 6390, importCost: 2500, shippingCost: 1400, netProfit: 2490, inventory: 880 },
        { name: "July", sales: 6490, importCost: 2600, shippingCost: 1500, netProfit: 2390, inventory: 920 },
        { name: "August", sales: 6590, importCost: 2400, shippingCost: 1400, netProfit: 2790, inventory: 890 },
        { name: "September", sales: 6690, importCost: 2100, shippingCost: 1400, netProfit: 3190, inventory: 860 },
        { name: "October", sales: 6790, importCost: 2400, shippingCost: 1800, netProfit: 2590, inventory: 870 },
        { name: "November", sales: 6890, importCost: 2500, shippingCost: 1700, netProfit: 2690, inventory: 890 },
        { name: "December", sales: 6990, importCost: 2300, shippingCost: 1800, netProfit: 2890, inventory: 910 },
    ] */}
    const [businessChart, setBusinessChart] = useState([]);
    useEffect(() => {
        OverviewService.list()
            .then((resp) => {
                setSummaryData([
                    {
                        title: "Total Revenue",
                        value: resp.message.month.revenue.current,
                        change: resp.message.month.revenue.compare + "%",
                        note: "compared to last month",
                        icon: <CurrencyDollar size={20} color="#0ea5e9" />,
                        iconBg: "#0ea5e933",
                    },
                    {
                        title: "Total Orders",
                        value: resp.message.month.order.current,
                        change: resp.message.month.order.compare + "%",
                        note: "compared to last month",
                        icon: <Cart size={20} color="#2563eb" />,
                        iconBg: "#2563eb33",
                    },
                    {
                        title: "Total Customers",
                        value: resp.message.month.customer.current,
                        change: resp.message.month.customer.compare + "%",
                        note: "compared to last month",
                        icon: <People size={20} color="#9333ea" />,
                        iconBg: "#9333ea33",
                    },
                    {
                        title: "Total Products",
                        value: resp.message.month.product.current,
                        change: resp.message.month.product.compare + "%",
                        note: "compared to last month",
                        icon: <BoxArrowUp size={20} color="#f59e0b" />,
                        iconBg: "#f59e0b33",
                    },
                ]);
                setBusinessChart(resp.message.chart)
            })
            .catch((error) => {

            })
    }, []);
    return <DashboardLayout>
        <div className='dashboard-box'>
            <DashboardSummary summaryData={summaryData} />
            <BusinessChart data={businessChart} title='Business chart' />
        </div>
    </DashboardLayout>
}