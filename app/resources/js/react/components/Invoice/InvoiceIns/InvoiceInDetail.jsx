import React, { useCallback, useEffect, useMemo, useState } from "react";
import SecondaryButton from '../../UI/Buttons/SecondaryButton'
import PrimaryButton from '../../UI/Buttons/PrimaryButton'
import InvoiceInService from '../../../services/InvoiceInService'
import { useSearchParams } from "react-router-dom";
import { useForm } from "../../../libraries/handleInput";
import { usePopup } from "../../popups/PopupContext";
import { formatMoney } from '../../../libraries/common'
import PurchaseItemService from '../../../services/PurchaseItemService'
import CommonDataTable from '../../CommonDataTable'
import useTable from '../../../libraries/handleTable'
import { PopupLayout } from '../../../layouts/PopupLayout'
import { InputForm } from "../../UI/Input/InputForm";
import { Select } from "../../UI/Input/Select";
import PageHead from "../../PageHead";
import LoadingBox from "../../LoadingBox";
export default function InvoiceInDetail() {
    const [loading, setLoading] = useState(false);
    const { openPopup } = usePopup();
    const [searchParams] = useSearchParams();
    const form = useForm();
    const [detail, setDetail] = useState(null);
    const table = useTable();
    const [showEdit, setShowEdit] = useState(false);
    const columns = useMemo(() => {
        return [
            { label: "Name", key: "name" },
            { label: "Buy", key: "buy_quantity" },
            { label: "Compensation", key: "compensation_quantity" },
            { label: "Conversion", key: "conversion_quantity" },
            { label: "Gift", key: "gift_quantity" },
            {
                label: 'Sku', key: 'sku'
            },
            {
                label: 'Total tax', key: 'total_tax'
            },
            {
                label: 'Warehouse', key: 'warehouse_name'
            },
            {
                label: 'Unit cost', key: 'unit_cost',
                render: (value) => {
                    return <span>{formatMoney(value)}</span>
                }
            },
            {
                label: 'Total', key: 'total',
                render: (value) => {
                    return <span>{formatMoney(value)}</span>
                }
            }
        ];
    }, []);
    const getDetail = useCallback(() => {
        setLoading(true)
        InvoiceInService.show(searchParams.get('id'))
            .then((resp) => {
                form.setFormData(resp.message);
                getPurchaseItems(resp.message?.purchase_id);
                setDetail(resp.message);
                setLoading(false)
            })
            .catch((error) => {
                if (error.response?.data?.errors) {
                    form.setFormErrors(error.response?.data?.errors);
                }
                if (error.response?.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response?.data?.message
                    })
                }
                setLoading(false)
            })
    }, []);
    const getPurchaseItems = useCallback((purchase_id = 0) => {
        table.setLoading(true)
        PurchaseItemService.list({
            keywords: '',
            page: 1,
            purchase_id: purchase_id
        })
            .then((resp) => {
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
                table.setLoading(false);
                table.setTotal(resp.message.total)
            })
            .catch((error) => {

            })
    }, []);
    const update = useCallback(() => {
        form.setLoading(true);
        form.setFormErrors(null)
        InvoiceInService.update(form.formData)
            .then((resp) => {
                setShowEdit(false);
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                });
                setDetail(form.formData);
                form.setLoading(false);
            })
            .catch((error) => {
                if (error.response?.data?.errors) {
                    form.setFormErrors(error.response.data?.errors)
                }
                if (error.response?.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
                form.setLoading(false);
            })
    }, [form.formData]);
    const confirmApproved = useCallback(() => {
        openPopup({
            type: 'warning',
            message: 'Are you sure to take approve',
            onConfirm: () => {
                form.handleChangeByKey('approved', true);
            }
        })

    }, [form.formData]);
    useEffect(() => {
        if (form?.formData?.approved === true && detail?.approved === false) {
            update();
        }
    }, [form.formData?.approved, detail?.approved])
    useEffect(() => {
        getDetail();
    }, [])
    return (
        <div className="min-vh-100">
            <PageHead
                title="Detail purchase invoice"
                subtitle="Check and manage detailed purchase invoice information"
            />
            <div className="container mt-3">
                {loading ? <LoadingBox /> : <div>
                    {/* Invoice Info */}
                    <div className="row g-3 mb-4">
                        <div className="col-md-3">
                            <div className="p-3 rounded border">
                                <div className="theme-title small">Invoice No
                                    {form.formData?.approved
                                        ? <span className="badge bg-success text-uppercase">Approved</span>
                                        : <span className="badge bg-warning text-uppercase">Waiting</span>}

                                </div>
                                <div className="fw-semibold theme-title">
                                    {form.formData?.document_no ?? '-'}
                                </div>
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="p-3 rounded border">
                                <div className="theme-title small">Purchase ID</div>
                                <div className="fw-semibold theme-title">
                                    PO{form.formData?.id ?? '-'}
                                </div>
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="p-3 rounded border">
                                <div className="theme-title small">Invoice date</div>
                                <div className="fw-semibold theme-title">
                                    {form.formData?.invoice_date ?? '-'}
                                </div>
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="p-3 rounded border">
                                <div className="theme-title small">Due date</div>
                                <div className="fw-semibold theme-title">
                                    {form.formData?.due_date ?? '-'}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row g-4">

                        {/* Supplier Info */}
                        <div className="col-lg-8">
                            <div className="p-4 rounded border">
                                <div className="d-flex justify-content-between mb-3">
                                    <h5 className="fw-semibold">
                                        Supplier information
                                    </h5>

                                </div>
                                <div className="mb-2">
                                    <div className="theme-title small">Name</div>
                                    <div className="theme-title">{form.formData?.unit_name}</div>
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
                                            <div className="theme-title">{form.formData?.tax_code}</div>
                                        </div>
                                        {/* <SupplierRow label="Mã số thuế" value="0987654321" /> */}
                                    </div>
                                    <div className="col-md-6">
                                        {/* <SupplierRow label="Số điện thoại" value="0987 654 321" /> */}
                                        <div className="mb-2">
                                            <div className="theme-title small">Phone</div>
                                            <div className="theme-title">{form.formData?.phone}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {/* Product List */}
                            <div className="p-4 rounded mt-4 border">
                                <div className="d-flex justify-content-between mb-3">
                                    <h5 className="fw-semibold">Products</h5>
                                    <div className="theme-title small">{table.total} products</div>
                                </div>

                                {/* {products.map((p, idx) => {
                                return <ProductItem key={idx} product={p} />
                            })} */}
                                <CommonDataTable
                                    columns={columns}
                                    data={table.data}
                                    links={table.links}
                                    loading={table.loading}
                                />
                            </div>
                        </div>

                        {/* Payment Info */}
                        <div className="col-lg-4">
                            <div className="p-4 rounded border">
                                <h5 className="fw-semibold mb-3">Payment information</h5>
                                <div className="mb-2">
                                    <div className="theme-title small">Payment method</div>
                                    <div className="theme-title badge bg-primary text-white text-uppercase">{form.formData?.payment_method}</div>
                                </div>
                                <div className="mb-2">
                                    <div className="theme-title small">Payment status</div>
                                    <div className={"theme-title badge text-white text-uppercase "
                                        + (form.formData?.payment_status === 'pending' ? 'bg-warning' : 'bg-success')}>{form.formData?.payment_status}</div>
                                </div>

                                <div className="mt-3 theme-title small">
                                    <div>Bank name: {form.formData?.bank_name ?? 'Not found'}</div>
                                    <div>Bank account: {form.formData?.bank_account ?? 'Not found'}</div>
                                </div>
                            </div>
                            {/* Summary */}
                            <div className=" mt-3">
                                <div className="ms-auto">
                                    <div className="p-4 rounded border">
                                        <h5 className="fw-semibold mb-3">Summary</h5>
                                        <div className="d-flex justify-content-between theme-title">
                                            <span>Subtotal</span>
                                            <span>{formatMoney(form.formData?.subtotal)}</span>
                                        </div>

                                        <div className="d-flex justify-content-between theme-title">
                                            <span>Shipping fee</span>
                                            <span>{formatMoney(form.formData?.shipping_fee)}</span>
                                        </div>

                                        <div className="d-flex justify-content-between theme-title">
                                            <span>VAT</span>
                                            <span>{formatMoney(form.formData?.total_tax)}</span>
                                        </div>
                                        <div className="d-flex justify-content-between theme-title">
                                            <span>Discount</span>
                                            <span>{formatMoney(form.formData?.discount)}</span>
                                        </div>

                                        <div className="d-flex justify-content-between mt-3 fs-5 fw-semibold">
                                            <span>Tổng cộng:</span>
                                            <span className="text-primary">{formatMoney(form.formData?.total)}</span>
                                        </div>

                                        {/* Buttons */}
                                        <div className="d-grid gap-2 mt-4">
                                            <SecondaryButton
                                                loading={form.loading}
                                                onClick={() => setShowEdit(true)}
                                                label="Edit invoice" width={'auto'} />
                                            <PrimaryButton
                                                loading={form.loading}
                                                disabled={form.formData?.approved}
                                                onClick={confirmApproved} label="Take approved" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>}
            </div>
            {showEdit ? <PopupLayout
                loading={form.loading}
                onClose={() => setShowEdit(false)}
                title="Update invoice" onConfirm={() => {
                    update();
                }}>
                <div>
                    <div className="form-group">
                        <label>Invoice Number</label>
                        <InputForm
                            errorMessage={form.formErrors?.document_no}
                            handleChange={form.handleChange}
                            value={form.formData?.document_no} type="text"
                            name="document_no" placeholder="Enter invoice number" />
                    </div>
                    <div className="form-group mt-3">
                        <label>Invoice Date</label>
                        <InputForm
                            errorMessage={form.formErrors?.invoice_date}
                            handleChange={form.handleChange} value={form.formData?.invoice_date}
                            type="date" name="invoice_date" placeholder="Enter invoice date" />
                    </div>
                    <div className="form-group mt-3">
                        <label>Due Date</label>
                        <InputForm
                            errorMessage={form.formErrors?.due_date}
                            handleChange={form.handleChange} value={form.formData?.due_date}
                            type="date" name="due_date" placeholder="Enter due date" />
                    </div>
                    <div className="form-group mt-3">
                        <label>Payment status</label>
                        <Select
                            errorMessage={form.formErrors?.payment_status}
                            handleChange={form.handleChange}
                            value={form.formData?.payment_status}
                            name="payment_status" options={[
                                { value: 'pending', label: 'Pending' },
                                { value: 'paid', label: 'Paid' },
                                { value: 'partial_payment', label: 'Partial payment' }
                            ]} />
                    </div>
                </div>
            </PopupLayout> : null}

        </div>
    );
}