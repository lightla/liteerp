import React, { useCallback, useEffect, useMemo, useState } from "react";
import StockInService from "../../services/StockInService";
import { useSearchParams } from "react-router-dom";
import { useForm } from "../../libraries/handleInput";
import { isoToDateTime } from "../../libraries/common";
import SummaryRow from "./StockInDetail/SummaryRow";
import TwoCol from "./StockInDetail/TwoCol";
import InfoBox from './StockInDetail/InfoBox'
import useTable from "../../libraries/handleTable";
import CommonDataTable from "../CommonDataTable";
import SecondaryButton from "../UI/Buttons/SecondaryButton";
import PrimaryButton from "../UI/Buttons/PrimaryButton";
import { PopupLayout } from "../../layouts/PopupLayout";
import { InputForm } from "../UI/Input/InputForm";
import { usePopup } from "../popups/PopupContext";
import PurchaseItemService from "../../services/PurchaseItemService";
import InventoryForm from "./StockInDetail/InventoryForm";
import StockMovementInService from '../../services/StockMovementInService'
import PageHead from "../PageHead";
import LoadingBox from '../LoadingBox'
export default function StockInDetail() {
    const [loading, setLoading] = useState(false);
    const [showForm, setShowForm] = useState(false);
    const [showFormInventory, setShowFormInventory] = useState(false);
    const form = useForm();
    const [detail, setDetail] = useState(null)
    const formAddInventory = useForm();
    const table = useTable();
    const inventoryTable = useTable();
    const { openPopup } = usePopup();
    const [searchParams] = useSearchParams();
    const navigate = useState();
    const getDetail = useCallback(() => {
        setLoading(true)
        StockInService.show(searchParams.get('stockin'))
            .then((resp) => {
                form.setFormData(resp.message);
                setDetail(resp.message)
                setLoading(false)
            })
            .catch((error) => {
                navigate('/stock')
            });
    }, []);
    const getProducts = useCallback((page = 0) => {
        table.setLoading(true);
        PurchaseItemService.list({
            keywords: '',
            active: 0,
            page: page,
            purchase_id: form.formData?.purchase_id
        })
            .then((resp) => {
                table.setLoading(false);
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
                table.setTotal(resp.message.total)
            })
            .catch((error) => {

            })
    }, [form.formData?.purchase_id]);
    const update = useCallback(() => {
        form.setLoading(true);
        form.setFormErrors(null)
        StockInService.update(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been confirmed'
                })
                getDetail();
                setShowForm(false)
                form.setLoading(false);
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
                form.handleChangeByKey('status', detail?.status);
                form.setLoading(false);
            })
    }, [form.formData, detail?.status]);
    const confirmRecieve = useCallback(() => {
        openPopup({
            type: 'warning',
            message: 'Are you sure to wanna confirm approved',
            onConfirm: () => {
                form.handleChangeByKey('status', 'received');
            }
        })
    }, [form]);
    useEffect(() => {
        if (form.formData?.status === 'received' &&
            detail?.status === 'pending') {
            update();
        }
    }, [form.formData?.status, detail?.status])
    const addInventory = (row) => {
        formAddInventory.setFormData(row);
        formAddInventory.setIsEdit(false)
        setShowFormInventory(true);
    }
    const createInventory = useCallback(() => {
        formAddInventory.setLoading(true);
        StockMovementInService.add({
            ...formAddInventory.formData,
            stock_in_id: searchParams.get('stockin'),
            purchase_item_id: formAddInventory.formData?.id
        })
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been added'
                })
                setShowFormInventory(false)
                formAddInventory.setLoading(false);
                getInventories();
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
                if (error.response.data?.errors) {
                    formAddInventory.setFormErrors(error.response?.data?.errors)
                }
                formAddInventory.setLoading(false);
            })
    }, [formAddInventory, searchParams])
    const getInventories = useCallback((page = 0) => {
        inventoryTable.setLoading(true);
        StockMovementInService.list({
            page: page,
            keywords: '',
            stock_in_id: searchParams.get('stockin')
        })
            .then((resp) => {
                inventoryTable.setLoading(false);
                inventoryTable.setData(resp.message.data)
                inventoryTable.setLinks(resp.message.links)
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            })
    }, [formAddInventory, searchParams, form.formData?.purchase_id])
    useEffect(() => {
        if (!searchParams.get('stockin')) {
            return;
        }
        getDetail();
    }, []);
    useEffect(() => {
        if (form.formData?.purchase_id) {
            getProducts();
            getInventories();
        }
    }, [form.formData?.purchase_id]);
    return (
        <div className="min-vh-100">
            <PageHead
                title="Detail stock in"
                subtitle="Manage and track details of the process of importing goods into the warehouse"
            />
            <div className="container mt-3">
            {loading ? <LoadingBox /> : 
                <div>
                    <div className="row g-3 mb-4">
                        <InfoBox label="Import voucher code" value={'PO' + form.formData?.purchase_id} />
                        <InfoBox label="Order code" value="PO-2024-001" />
                        <InfoBox label="Actual import date" value={isoToDateTime(form.formData?.import_date)} />
                        <InfoBox label="Expected date" value={form.formData?.due_date ?? '-'} />
                    </div>

                    <div className="row g-4">

                        <div className="col-lg-8">
                            <div className="p-4 rounded border">
                                <div className="d-flex justify-content-between mb-3">
                                    <h5 className="fw-semibold">Stock information</h5>
                                </div>

                                <TwoCol label="Supplier" left={form.formData?.unit_name}
                                    rightLabel={'Purchase approved'}
                                    right={form.formData?.purchase_approved_name} />

                                <TwoCol label="Staff" left={form.formData?.purchase_approved_name ?? '-'}
                                    rightLabel="Status"
                                    right={form.formData?.status === 'received'
                                        ? <span className="badge bg-success text-uppercase">{form.formData?.status}</span>
                                        : <span className="badge bg-warning text-dark text-uppercase">{form.formData?.status}</span>} />

                                <div className="mt-3">
                                    <div className="theme-title small">Note</div>
                                    <div>{form.formData?.purchase_note ?? '-'}</div>
                                </div>
                            </div>
                            {/* Product List */}
                            <div className="rounded mt-4 mb-5">
                                <div className="d-flex justify-content-between mb-3">
                                    <h5 className="fw-semibold">Purchase items</h5>
                                    <div className="theme-title small">{table.total} products</div>
                                </div>

                                {/** Table */}
                                <CommonDataTable
                                    columns={[
                                        {
                                            label: "ID", key: "id"
                                        },
                                        { label: "Supplier", key: "unit_name" },
                                        { label: "Name", key: "name" },
                                        { label: "Category", key: "category_name" },
                                        { label: "Quantity", key: "quantity" },
                                        { label: "Sku", key: "sku" },
                                        { label: "Unit", key: "unit" }
                                    ]}
                                    data={table.data}
                                    links={table.links}
                                    loading={table.loading}
                                    onEdit={form.formData?.status === 'pending'
                                        ? addInventory
                                        : null}
                                    iconEdit={<i className="bi bi-plus-circle-dotted"></i>}
                                />
                            </div>
                            {/* Inventory */}
                            <div className="rounded mt-4 mb-5">
                                <div className="d-flex justify-content-between mb-3">
                                    <h5 className="fw-semibold">Inventory</h5>
                                    <div className="theme-title small">{table.total} products</div>
                                </div>

                                {/** Table */}
                                <CommonDataTable
                                    movePage={getInventories}
                                    columns={[
                                        {
                                            label: "ID", key: "id"
                                        },
                                        { label: "Supplier", key: "unit_name" },
                                        { label: "Name", key: "name" },
                                        { label: "Category", key: "category" },
                                        { label: "Quantity", key: "qty_change" },
                                        { label: "Sku", key: "sku" },
                                        { label: "Unit", key: "unit" },
                                        { label: "Warehouses", key: "warehouse" }
                                    ]}
                                    data={inventoryTable.data}
                                    links={inventoryTable.links}
                                    loading={inventoryTable.loading}
                                />
                            </div>
                        </div>

                        {/* Summary Box */}
                        <div className="col-lg-4">
                            <div className="p-4 rounded mb-4 border">
                                <h5 className="fw-semibold mb-3">Warehouse</h5>
                                <SummaryRow label="Quantity" value={table.total} />
                                <SummaryRow label="Staff:" value={form.formData?.approved_name ?? '-'} />
                                <SummaryRow label="Import date:" value="15/01/2024" />
                            </div>

                            {/* Inspection box */}
                            {form.formData?.status === 'pending' ? <div className="row">
                                <div className="col-6">
                                    <PrimaryButton loading={form.loading} onClick={confirmRecieve} label="Received" />
                                </div>
                                <div className="col-6">
                                    <SecondaryButton loading={form.loading} onClick={() => setShowForm(true)} width={'100%'} label="Modifier" />
                                </div>
                            </div> : null}
                        </div>
                    </div>
                </div>
            }</div>
            {showForm ? <PopupLayout
                loading={form.loading}
                confirmText="Save change"
                onClose={() => setShowForm(false)}
                title="Update Stock In" onConfirm={() => update()}>
                <div>
                    <div>
                        <label>Import date</label>
                        <InputForm
                            errorMessage={form.formErrors?.import_date}
                            value={form.formData?.import_date}
                            name="import_date"
                            handleChange={form.handleChange}
                            type="date"
                        />
                    </div>
                </div>
            </PopupLayout> : null}
            {showFormInventory ? <PopupLayout
                loading={formAddInventory.loading}
                confirmText="Save"
                onClose={() => setShowFormInventory(false)}
                title={formAddInventory.isEdit
                    ? "Update Inventory"
                    : "Add Inventory"} onConfirm={createInventory}>
                <div>
                    <InventoryForm form={formAddInventory} />
                </div>
            </PopupLayout> : null}

        </div>
    );
}