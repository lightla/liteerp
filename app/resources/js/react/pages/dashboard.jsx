import React, { useEffect, useRef, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import DashboardSummary from '../components/Dashboard/DashboardSummary'
import BusinessChart from '../components/Dashboard/BusinessChart'
import OverviewService from '../services/OverviewService';
import { usePopup } from '../components/popups/PopupContext'
import LoadingBox from '../components/LoadingBox'
export default function Dashboard() {
    const { openPopup } = usePopup();
    const [summaryData, setSummaryData] = useState([]);
    const [businessChart, setBusinessChart] = useState([]);
    const [loading,setLoading] = useState(true);
    useEffect(() => {
        setLoading(true)
        OverviewService.list()
            .then((resp) => {
                setSummaryData(resp.message.top);
                setBusinessChart(resp.message.chart)
                setLoading(false)
            })
            .catch((error) => {
                openPopup({
                    type: 'error',
                    message: error.response?.data?.message ?? 'Error'
                })
                setLoading(false)
            })
       
    }, []);
    return <DashboardLayout>
        <div className='dashboard-box'>
            {loading ? <div className='mt-5'>
                <LoadingBox/>
            </div> : <div>
                <DashboardSummary summaryData={summaryData} />
                <BusinessChart data={businessChart} title='Business chart' />
            </div> }
            
        </div>
    </DashboardLayout>
}