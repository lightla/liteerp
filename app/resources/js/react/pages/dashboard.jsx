import React, { useEffect, useRef, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import DashboardSummary from '../components/Dashboard/DashboardSummary'
import BusinessChart from '../components/Dashboard/BusinessChart'
import OverviewService from '../services/OverviewService';
import { usePopup } from '../components/popups/PopupContext'
import LoadingBox from '../components/LoadingBox'
import BootstrapAlert from '../components/BootstrapAlert';
import { useI18n } from '../../i18n/useI18n';
export default function Dashboard() {
    const {t} = useI18n();
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
                {summaryData.length === 0 && businessChart.length === 0 ? <div className='mt-5 pt-5'>
                    <div className='theme-title text-center'>
                        <i className="bi bi-database-fill-check h1"></i>
                        <p>{t("overview_nodata")}</p>
                    </div>
                </div> : <div>
                    <DashboardSummary summaryData={summaryData} />
                <BusinessChart data={businessChart} title='Business chart' />
                </div> }
                
            </div> }
            
        </div>
    </DashboardLayout>
}