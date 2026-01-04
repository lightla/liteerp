import React, { useEffect, useRef, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import DashboardSummary from '../components/Dashboard/DashboardSummary'
import BusinessChart from '../components/Dashboard/BusinessChart'
import OverviewService from '../services/OverviewService';
import { usePopup } from '../components/popups/PopupContext'
export default function Dashboard() {
    const { openPopup } = usePopup();
    const [summaryData, setSummaryData] = useState([]);
    const [businessChart, setBusinessChart] = useState([]);

    useEffect(() => {
        OverviewService.list()
            .then((resp) => {
                setSummaryData(resp.message.top);
                setBusinessChart(resp.message.chart)
            })
            .catch((error) => {
                openPopup({
                    type: 'error',
                    message: error.response?.data?.message ?? 'Error'
                })
            })
       
    }, []);
    return <DashboardLayout>
        <div className='dashboard-box'>
            <DashboardSummary summaryData={summaryData} />
            <BusinessChart data={businessChart} title='Business chart' />
        </div>
    </DashboardLayout>
}