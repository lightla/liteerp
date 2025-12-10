import React, { useCallback, useEffect, useMemo, useState } from "react";
import { useSearchParams } from "react-router-dom";
import { useForm } from "../../libraries/handleInput";
import { isoToDateTime } from "../../libraries/common";
import TwoCol from "./StockInDetail/TwoCol";
import InfoBox from './StockInDetail/InfoBox'
import useTable from "../../libraries/handleTable";
import CommonDataTable from "../CommonDataTable";
import SecondaryButton from "../UI/Buttons/SecondaryButton";
import PrimaryButton from "../UI/Buttons/PrimaryButton";
import { PopupLayout } from "../../layouts/PopupLayout";
import { usePopup } from "../popups/PopupContext";
import StockOutService from "../../services/StockOutService";
import FormUpdate from "./StockOutDetail/FormUpdate";
import CustomerInfo from "./StockOutDetail/CustomerInfo";
import OrderShippingService from "../../services/OrderShippingService";
import SuccessButton from "../UI/Buttons/SuccessButton";
import ShippingInformation from "./StockOutDetail/ShippingInformation";
import PaymentInformation from "./StockOutDetail/PaymentInformation";
import StockMovementOut from "../../services/StockMovementOut";
import PageHead from "../PageHead";
import LoadingBox from "../LoadingBox";
import Currencies from "../Currencies";
export default function StockOutDetail() {
    const [loading,setLoading] = useState(false)
    const [showForm, setShowForm] = useState(false);
    const tableInventory = useTable();
    const form = useForm();
    const { openPopup } = usePopup();
    const [searchParams] = useSearchParams();
    const navigate = useState();
    const [detail, setDetail] = useState(null);
    const getDetail = useCallback(() => {
        setLoading(true)
        StockOutService.show(searchParams.get('stockout'))
            .then((resp) => {
                form.setFormData(resp.message);
                setDetail(resp.message);
                setLoading(false)
            })
            .catch((error) => {
                navigate('/stock')
            });
    }, []);
    const update = useCallback(() => {
        StockOutService.update(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been confirmed'
                })
                setDetail(form.formData);
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
                if (error.response.data?.errors) {
                    form.setFormErrors(error.response?.data?.errors)
                }
            })
    }, [form.formData]);
    const updateShipping = useCallback(() => {
        OrderShippingService.update({
            ...form.formData,
            id: form.formData?.shipping_id
        })
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been update'
                })
                setDetail(form.formData);
                setShowForm(false);
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
                if (error.response.data?.errors) {
                    form.setFormErrors(error.response?.data?.errors)
                }
            })
    }, [form.formData]);
    const confirmSent = useCallback(() => {
        openPopup({
            type: 'warning',
            message: 'Are you sure to wanna confirm sent',
            onConfirm: () => {
                //update();
                form.handleChangeByKey('status', 'shipped')
            }
        })
    }, [form]);
    const confirmCompleted = useCallback(() => {
        openPopup({
            type: 'warning',
            message: 'Are you sure to wanna confirm completed',
            onConfirm: () => {
                //update();
                form.handleChangeByKey('status', 'completed')
            }
        })
    }, [form]);
    const getInventories = useCallback((keywords = '') => {
        StockMovementOut.list({
            page: 0,
            keywords: keywords,
            stock_out_id: searchParams.get('stockout')
        })
        .then((resp) => {
            tableInventory.setData(resp.message.data);
            tableInventory.setLinks(resp.message.links);
            tableInventory.setTotal(resp.message.total)
        })
        .catch((error) => {

        })
    },[searchParams]);
    useEffect(() => {
        if (!searchParams.get('stockout')) {
            return;
        }

        getDetail();
        getInventories();
    }, [detail?.order_id]);
    useEffect(() => {
        if (detail?.status !== form.formData?.status) {
            update();
        }
    }, [detail?.status, form.formData?.status]);
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
                label: 'Price', key: 'price',render: (value) => {
                    return <Currencies amount={value}/>
                }
            },
            {
                label: 'Total tax', key: 'total_tax',render: (value) => {
                    return <Currencies amount={value}/>
                }
            },
            {
                label: 'Discount', key: 'discount',render: (value) => {
                    return <Currencies amount={value}/>
                }
            },
            {
                label: 'Subtotal', key: 'subtotal',
                render: (value) => {
                    return <span>{<Currencies amount={value}/>}</span>
                }
            },
            {
                label: 'Total', key: 'total',
                render: (value) => {
                    return <span>{<Currencies amount={value}/>}</span>
                }
            },
            { label: "Warehouse", key: "warehouse" },
        ];
    }, []);
    return (
        <div className="min-vh-100">
            <PageHead
            containerClass="m-4"
            title="Detail stock out"
            subtitle="Manage and track details of the process of exporting goods from the warehouse"
            />
            <div className="m-4 mt-3">

                {loading ? <LoadingBox/> : <div>
                    <div className="row g-3 mb-4">
                    <InfoBox label="Import voucher code" value={'OD' + form.formData?.order_id} />
                    <InfoBox label="Order code" value={form.formData?.order_no} />
                    <InfoBox label="Order date" value={isoToDateTime(form.formData?.order_date)} />
                    <InfoBox label="expected delivery date" value={form.formData?.expected_delivery_date ?? '-'} />
                </div>

                <div className="row g-4">

                    <div className="col-lg-8">
                        <div className="p-4 rounded border">
                            <div className="d-flex justify-content-between mb-3">
                                <h5 className="fw-semibold">Stock information</h5>
                            </div>

                            <TwoCol label="Employee" left={form.formData?.approved_name ?? '-'}
                                rightLabel={'Status'}
                                right={form.formData?.status === 'received'
                                    ? <span className="badge bg-success text-uppercase">{form.formData?.status}</span>
                                    : <span className="badge bg-warning text-dark text-uppercase">{form.formData?.status}</span>} />

                            <div className="mt-3">
                                <div className="theme-title small">Note</div>
                                <div>{form.formData?.receiver_note ?? '-'}</div>
                            </div>
                        </div>
                        {/* Customer Info */}
                        <CustomerInfo form={form}/>
                        {/* Shipping Info */}
                        <ShippingInformation form={form} />
                        {/* Iventory */}
                        <div className="rounded mt-4 mb-5">
                            <div className="d-flex justify-content-between mb-3">
                                <h5 className="fw-semibold">Inventories</h5>
                                <div className="theme-title small">{tableInventory.total} products</div>
                            </div>

                            {/** Table */}
                            <CommonDataTable
                                columns={columns}
                                data={tableInventory.data}
                                links={tableInventory.links}
                                loading={tableInventory.loading}
                            />
                        </div>
                    </div>

                    {/* Summary Box */}
                    <div className="col-lg-4">
                        <PaymentInformation form={form} />
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
                                        <Currencies amount={detail?.total_adjusted}/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Inspection box */}
                        {form.formData?.status !== 'received' ? <div className="row">
                            <div className="col-6">
                                {detail?.status === 'pending'
                                ? <PrimaryButton onClick={confirmSent} label="Shipped" />
                                : null }
                                {detail?.status === 'shipped'
                                ? <SuccessButton 
                                width={'100%'}
                                onClick={confirmCompleted} label="Completed" />
                                : null }
                                {detail?.status === 'completed'
                                ? <PrimaryButton disabled={true} label="Completed" />
                                : null }
                            </div>
                            <div className="col-6">
                                <SecondaryButton 
                                disabled={detail?.status !== 'pending'}
                                onClick={() => setShowForm(true)} width={'100%'} label="Modifiner" />
                            </div>
                        </div> : null}

                    </div>
                </div></div>}
            </div>
            {showForm ? <PopupLayout
                confirmText="Save change"
                onClose={() => setShowForm(false)}
                title="Update shipping" onConfirm={() => updateShipping()}>
                <div>
                    <FormUpdate form={form}/>
                </div>
            </PopupLayout> : null}
        </div>
    );
}