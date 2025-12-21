import React, { useEffect, useRef, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import DashboardSummary from '../components/Dashboard/DashboardSummary'
import BusinessChart from '../components/Dashboard/BusinessChart'
import OverviewService from '../services/OverviewService';
import { BoxArrowUp, Cart, CurrencyDollar, People } from 'react-bootstrap-icons';
export default function Dashboard() {
    const [summaryData, setSummaryData] = useState([
        {
            title: "Total Revenue",
            value: 0,
            change: "0%",
            note: "compared to last month",
            icon: <CurrencyDollar size={20} color="#0ea5e9" />,
            iconBg: "#0ea5e933",
        },
        {
            title: "Total Orders",
            value: 0,
            change: "0%",
            note: "compared to last month",
            icon: <Cart size={20} color="#2563eb" />,
            iconBg: "#2563eb33",
        },
        {
            title: "Total Customers",
            value: 0,
            change: "0%",
            note: "compared to last month",
            icon: <People size={20} color="#9333ea" />,
            iconBg: "#9333ea33",
        },
        {
            title: "Total Products",
            value: 0,
            change: "0%",
            note: "compared to last month",
            icon: <BoxArrowUp size={20} color="#f59e0b" />,
            iconBg: "#f59e0b33",
        },
    ]);
    const [businessChart, setBusinessChart] = useState([]);
    useEffect(() => {
        OverviewService.list()
            .then((resp) => {
                if (resp.message?.month?.revenue?.current
                    && resp.message?.month?.order?.current
                    && resp.message?.month?.customer?.current
                    && resp.message?.month?.product?.current) {
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
                }

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