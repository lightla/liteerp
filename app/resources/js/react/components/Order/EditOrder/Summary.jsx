import React from 'react'
import VerticalCommonTable from '../../VerticalCommonTable'
import Currencies from '../../../components/Currencies';
export default function Summary({
    summaryData = null,
    reload = null
}){
    
    return <div className='p-2'>
        <div className='d-flex'>
            <h4>Summary</h4>
            <div className='mx-1 btn' onClick={() => {
                reload();
            }}>
                <i className="bi bi-arrow-clockwise text-success"></i>
            </div>
        </div>
        <VerticalCommonTable data={{
            total_quantity: summaryData?.total_quantity,
            total_discount: <Currencies amount={summaryData?.discount}/>,
            subtotal: <Currencies amount={summaryData?.subtotal}/>,
            total_tax: <Currencies amount={summaryData?.total_tax}/>,
            shipping_fee: <Currencies amount={summaryData?.shipping_fee}/>,
            total: <Currencies amount={summaryData?.total}/>,
        }}/>
    </div>
}