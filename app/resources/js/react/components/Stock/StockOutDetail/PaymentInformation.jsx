import React from 'react'
export default function PaymentInformation({
    form = {
        formData: null
    }
}) {
    return <div className="p-4 rounded border">
        <h5 className="fw-semibold mb-3">Payment information</h5>
        <div className="mb-2">
            <div className="theme-title small">Payment method</div>
            <div className="theme-title badge 
                                bg-primary text-white text-uppercase">{form.formData?.payment_method}</div>
        </div>
        <div className="mb-2">
            <div className="theme-title small">Payment status</div>
            <div className={"theme-title badge text-white text-uppercase "
                + (form.formData?.payment_status === 'pending' ? 'bg-warning' : 'bg-success')}>{form.formData?.payment_status}</div>
        </div>
    </div>
}