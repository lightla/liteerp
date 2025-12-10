import React from 'react'
import BootstrapAlert from '../../BootstrapAlert'
export default function ShippingInformation({
    form = {
        formData: null
    }
}) {
    return <div className="p-4 rounded border mt-3">
        <div className="d-flex justify-content-between mb-3">
            <h5 className="fw-semibold">
                Shipping information
            </h5>
        </div>
        <BootstrapAlert
            message="If shipping fee actual has insert then system will use, 
                                                            but if it is empty will be shipping fee estimated."
        />
        <div className="mb-2">
            <div className="theme-title small">Name</div>
            <div className="theme-title">{form.formData?.receiver_name}</div>
        </div>
        <div className="mb-2">
            <div className="theme-title small">Email</div>
            <div className="theme-title">{form.formData?.receiver_email ?? '-'}</div>
        </div>
        <div className="mb-2">
            <div className="theme-title small">Address</div>
            <div className="theme-title">{form.formData?.receiver_address ?? '-'}</div>
        </div>
        <div className="mb-2">
            <div className="theme-title small">Tax code</div>
            <div className="theme-title">{form.formData?.tax_code ?? '-'}</div>
        </div>
        <div className="row mt-3">
            <div className="col-md-6">
                <div className="mb-2">
                    <div className="theme-title small">Shipping unit</div>
                    <div className="theme-title">{form.formData?.preferred_unit_name}</div>
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
        <div className="row mt-3">
            <div className="col-md-6">
                <div className="mb-2">
                    <div className="theme-title small">Shipping fee actual</div>
                    <div className="theme-title">
                        <Currencies amount={form.formData?.shipping_fee_actual}/></div>
                </div>
                {/* <SupplierRow label="Mã số thuế" value="0987654321" /> */}
            </div>
            <div className="col-md-6">
                {/* <SupplierRow label="Số điện thoại" value="0987 654 321" /> */}
                <div className="mb-2">
                    <div className="theme-title small">Shipping fee estimated</div>
                    <div className="theme-title">
                        <Currencies amount={form.formData?.shipping_fee_estimated}/></div>
                </div>
            </div>
        </div>
        <div className="row mt-3">
            <div className="col-md-6">
                <div className="mb-2">
                    <div className="theme-title small">Shipping code</div>
                    <div className="theme-title">{form.formData?.shipping_code ?? '-'}</div>
                </div>
                {/* <SupplierRow label="Mã số thuế" value="0987654321" /> */}
            </div>
            <div className="col-md-6">
                {/* <SupplierRow label="Số điện thoại" value="0987 654 321" /> */}
                <div className="mb-2">
                    <div className="theme-title small">Receiver note</div>
                    <div className="theme-title">{form.formData?.receiver_note ?? '-'}</div>
                </div>
            </div>
        </div>
    </div>
}