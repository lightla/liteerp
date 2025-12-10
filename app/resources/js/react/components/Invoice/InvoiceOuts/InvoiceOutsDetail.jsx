import React, { useCallback, useEffect, useMemo, useState } from "react";
import SecondaryButton from '../../UI/Buttons/SecondaryButton'
import PrimaryButton from '../../UI/Buttons/PrimaryButton'
import { useSearchParams } from "react-router-dom";
import { useForm } from "../../../libraries/handleInput";
import { usePopup } from "../../popups/PopupContext";
import CommonDataTable from '../../CommonDataTable'
import useTable from '../../../libraries/handleTable'
import { PopupLayout } from '../../../layouts/PopupLayout'
import { InputForm } from "../../UI/Input/InputForm";
import { Select } from "../../UI/Input/Select";
import InvoiceOutService from "../../../services/InvoiceOutService";
import BootstrapAlert from "../../BootstrapAlert";
import OrderItemService from "../../../services/OrderItemService";
import PageHead from "../../PageHead";
import LoadingBox from "../../LoadingBox";
import Currencies from "../../Currencies";
export default function InvoiceOutDetail() {
    const [loading, setLoading] = useState(false)
    const { openPopup } = usePopup();
    const [searchParams] = useSearchParams();
    const form = useForm();
    const table = useTable();
    const [detail, setDetail] = useState(null);
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
                label: 'Price', key: 'price'
            },
            {
                label: 'Total tax', key: 'total_tax'
            },
            {
                label: 'Subtotal', key: 'subtotal',
                render: (value) => {
                    return <span><Currencies amount={value}/></span>
                }
            },
            {
                label: 'Total', key: 'total',
                render: (value) => {
                    return <span><Currencies amount={value}/></span>
                }
            },
            { label: "Warehouse", key: "warehouse" },
        ];
    }, []);
    const getDetail = useCallback(() => {
        setLoading(true)
        InvoiceOutService.show(searchParams.get('id'))
            .then((resp) => {
                form.setFormData(resp.message);
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

    const getOrderItems = useCallback((order_id = 0) => {
        table.setLoading(true)
        OrderItemService.list({
            keywords: '',
            page: 1,
            order_id: order_id
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
    useEffect(() => {
        if (detail?.order_id) {
            getOrderItems(detail?.order_id);
        }
    }, [detail?.order_id])
    const update = useCallback(() => {
        form.setFormErrors(null)
        InvoiceOutService.update(form.formData)
            .then((resp) => {
                setShowEdit(false);
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                });
                setDetail(form.formData);
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

    }, [form.handleChangeByKey]);
    useEffect(() => {
        if (!detail) {
            getDetail();
        }
        if (detail?.approved === false && form.formData?.approved === true) {
            update();
        }
    }, [form.formData?.approved, detail?.approved])
    return (
        <div className="text-light min-vh-100">
            <PageHead
                containerClass="mx-4"
                title="Detail order invoice"
                subtitle="Check and manage detailed order invoice information"
            />
            <div className="mx-4 mt-3">
                {loading ? <LoadingBox/> : <div>
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
                                <div className="theme-title small">Order ID</div>
                                <div className="fw-semibold theme-title">
                                    OD{form.formData?.id ?? '-'}
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


                        <div className="col-lg-8">
                            {/* Customer Info */}
                            <div className="p-4 rounded border">
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
                            {/* Shipping Info */}
                            <div className="p-4 rounded border mt-3">
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
                                                <Currencies amount={form.formData?.shipping_fee_actual}/>
                                                </div>
                                        </div>
                                        {/* <SupplierRow label="Mã số thuế" value="0987654321" /> */}
                                    </div>
                                    <div className="col-md-6">
                                        {/* <SupplierRow label="Số điện thoại" value="0987 654 321" /> */}
                                        <div className="mb-2">
                                            <div className="theme-title small">Shipping fee estimated</div>
                                            <div className="theme-title">
                                                <Currencies amount={form.formData?.shipping_fee_estimated}/>
                                                </div>
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
                            {/* Product List */}
                            <div className="p-4 rounded mt-4 border">
                                <div className="d-flex justify-content-between mb-3">
                                    <h5 className="fw-semibold">Products Order</h5>
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
                            </div>
                            {/* Summary */}
                            <div className=" mt-3">
                                <div className="ms-auto">
                                    <div className="p-4 rounded border">
                                        <h5 className="fw-semibold mb-3">Summary</h5>
                                        <div className="d-flex justify-content-between theme-title">
                                            <span>Type order</span>
                                            <span className="badge bg-primary">{form.formData?.type}</span>
                                        </div>
                                        <div className="d-flex justify-content-between theme-title">
                                            <span>Subtotal</span>
                                            <Currencies amount={detail?.subtotal}/>
                                            
                                        </div>

                                        <div className="d-flex justify-content-between theme-title">
                                            <span>Shipping fee</span>
                                            <Currencies amount={detail?.shipping_fee}/>
                                        </div>

                                        <div className="d-flex justify-content-between theme-title">
                                            <span>VAT</span>
                                            <Currencies amount={detail?.total_tax}/>
                                        </div>
                                        <div className="d-flex justify-content-between theme-title">
                                            <span>Discount</span>
                                            <Currencies amount={detail?.discount}/>
                                        </div>

                                        <div className="d-flex justify-content-between mt-3 fs-5 fw-semibold">
                                            <span className="theme-title">Total:</span>
                                            <span className="text-primary">
                                                <Currencies amount={detail?.total_adjusted}/></span>
                                                
                                        </div>

                                        {/* Buttons */}
                                        <div className="d-grid gap-2 mt-4">
                                            <SecondaryButton
                                                onClick={() => setShowEdit(true)}
                                                label="Edit invoice" width={'auto'} />
                                            <PrimaryButton
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