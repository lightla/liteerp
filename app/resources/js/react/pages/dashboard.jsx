import React, { useEffect, useRef, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import DashboardSummary from '../components/Dashboard/DashboardSummary'
import BusinessChart from '../components/Dashboard/BusinessChart'
import OverviewService from '../services/OverviewService';
import { BoxArrowUp, Cart, CurrencyDollar, People } from 'react-bootstrap-icons';
export default function Dashboard() {
    const [summaryData, setSummaryData] = useState([]);
    const [businessChart, setBusinessChart] = useState([]);
    useEffect(() => {
        OverviewService.list()
            .then((resp) => {
                setSummaryData([
                    {
                        title: "Total purchases",
                        value: resp.message.month.purchase.current,
                        change: resp.message.month.purchase.compare ,
                        note: "compared to last month",
                        icon: <CurrencyDollar size={20} color="#0ea5e9" />,
                        iconBg: "#0ea5e933",
                    },
                    {
                        title: "Total orders",
                        value: resp.message.month.order.current,
                        change: resp.message.month.order.compare ,
                        note: "compared to last month",
                        icon: <Cart size={20} color="#2563eb" />,
                        iconBg: "#2563eb33",
                    },
                    {
                        title: "Total customers",
                        value: resp.message.month.customer.current,
                        change: resp.message.month.customer.compare ,
                        note: "compared to last month",
                        icon: <People size={20} color="#9333ea" />,
                        iconBg: "#9333ea33",
                    },
                    {
                        title: "Total products",
                        value: resp.message.month.product.current,
                        change: resp.message.month.product.compare ,
                        note: "compared to last month",
                        icon: <BoxArrowUp size={20} color="#f59e0b" />,
                        iconBg: "#f59e0b33",
                    },
                    {
                        title: "Daily revenues",
                        value: resp.message.revenue.dailly.current,
                        change: resp.message.revenue.dailly.compare ,
                        note: "compared to last day",
                        icon: <CurrencyDollar size={20} color="#0ea5e9" />,
                        iconBg: "#0ea5e933",
                    },
                    {
                        title: "Weekly revenues",
                        value: resp.message.revenue.weekly.current,
                        change: resp.message.revenue.weekly.compare ,
                        note: "compared to last week",
                        icon: <CurrencyDollar size={20} color="#0ea5e9" />,
                        iconBg: "#0ea5e933",
                    },
                    {
                        title: "Monthly revenues",
                        value: resp.message.revenue.monthly.current,
                        change: resp.message.revenue.monthly.compare ,
                        note: "compared to last month",
                        icon: <CurrencyDollar size={20} color="#0ea5e9" />,
                        iconBg: "#0ea5e933",
                    },
                    {
                        title: "Yearly revenues",
                        value: resp.message.revenue.yearly.current,
                        change: resp.message.revenue.yearly.compare ,
                        note: "compared to last year",
                        icon: <CurrencyDollar size={20} color="#0ea5e9" />,
                        iconBg: "#0ea5e933",
                    },
                    {
                        title: "Daily expenses",
                        value: resp.message.expense.dailly.current,
                        change: resp.message.expense.dailly.compare ,
                        note: "compared to last day",
                        icon: <CurrencyDollar size={20} color="#0ea5e9" />,
                        iconBg: "#0ea5e933",
                    },
                    {
                        title: "Weekly expenses",
                        value: resp.message.expense.weekly.current,
                        change: resp.message.expense.weekly.compare ,
                        note: "compared to last week",
                        icon: <CurrencyDollar size={20} color="#0ea5e9" />,
                        iconBg: "#0ea5e933",
                    },
                    {
                        title: "Monthly expenses",
                        value: resp.message.expense.monthly.current,
                        change: resp.message.expense.monthly.compare ,
                        note: "compared to last month",
                        icon: <CurrencyDollar size={20} color="#0ea5e9" />,
                        iconBg: "#0ea5e933",
                    },
                    {
                        title: "Yearly expenses",
                        value: resp.message.expense.yearly.current,
                        change: resp.message.expense.yearly.compare ,
                        note: "compared to last year",
                        icon: <CurrencyDollar size={20} color="#0ea5e9" />,
                        iconBg: "#0ea5e933",
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