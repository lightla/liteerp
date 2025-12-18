import React from 'react'
export default function PaymentMethod({
    value = null 
}) {
    return <span className={'badge text-uppercase badge-' + value}>
        {value}
    </span>
}