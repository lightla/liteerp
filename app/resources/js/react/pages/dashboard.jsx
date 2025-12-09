import React, { useEffect } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import DashboardSummary from '../components/Dashboard/DashboardSummary'
import BusinessChart from '../components/Dashboard/BusinessChart'
export default function Dashboard(){
    return <DashboardLayout>
        <div className='dashboard-box'>
            <DashboardSummary/>
            <BusinessChart title='Business chart'/>
        </div>
    </DashboardLayout>
}