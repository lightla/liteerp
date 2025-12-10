import React from 'react'
import VerticalCommonTable from '../../VerticalCommonTable'
import { formatMoney } from '../../../libraries/common';
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
            total_quantity: summaryData.total_quantity,
            total_discount: formatMoney(summaryData.discount),
            subtotal: formatMoney(summaryData.subtotal),
            total_tax: formatMoney(summaryData.total_tax),
            shipping_fee: formatMoney(summaryData.shipping_fee),
            total: formatMoney(summaryData.total),
        }}/>
    </div>
}