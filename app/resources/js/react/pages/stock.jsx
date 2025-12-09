import React, { useCallback, useEffect, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import { formatToDateTime, formatMoney, isoToDateTime } from '../libraries/common';
import { Link, useNavigate, useSearchParams } from 'react-router-dom';
import StockList from '../components/Stock/StockList';
import StockInDetail from '../components/Stock/StockInDetail'
import StockOutDetail from '../components/Stock/StockOutDetail';
export default function Stock() {
    const navigate = useNavigate();
    const [searchParams] = useSearchParams();
    return <DashboardLayout>
        <div>
            {searchParams.get('stockin') ? <StockInDetail /> : searchParams.get('stockout') 
            ? <StockOutDetail/> : <StockList/>}
        </div>
    </DashboardLayout>
}