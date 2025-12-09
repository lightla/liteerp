import React from 'react'
export default function CustomerInfo({
    form = {
        formData: null 
    }
}) {
    return <div className="p-4 rounded border mt-3">
        <div className="d-flex justify-content-between mb-3">
            <h5 className="fw-semibold">
                Customer information
            </h5>

        </div>
        <div className="mb-2">
            <div className="theme-title small">Name</div>
            <div className="theme-title">{form.formData?.customer_name}</div>
        </div>
        <div className="mb-2">
            <div className="theme-title small">Email</div>
            <div className="theme-title">{form.formData?.email}</div>
        </div>
        <div className="mb-2">
            <div className="theme-title small">Address</div>
            <div className="theme-title">{form.formData?.address}</div>
        </div>
        <div className="row mt-3">
            <div className="col-md-6">
                <div className="mb-2">
                    <div className="theme-title small">Tax code</div>
                    <div className="theme-title">{form.formData?.tax_code ?? '-'}</div>
                </div>
                {/* <SupplierRow label="Mã số thuế" value="0987654321" /> */}
            </div>
            <div className="col-md-6">
                {/* <SupplierRow label="Số điện thoại" value="0987 654 321" /> */}
                <div className="mb-2">
                    <div className="theme-title small">Phone</div>
                    <div className="theme-title">{form.formData?.phone ?? '-'}</div>
                </div>
            </div>
        </div>
    </div>
}