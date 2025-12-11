import React, { useCallback, useEffect, useMemo, useState } from 'react';
import CommonDataTable from '../CommonDataTable';
import { PopupLayout } from '../../layouts/PopupLayout';
import { InputForm } from '../UI/Input/InputForm';
import PurchaseService from '../../services/PurchaseService';
import SupplierService from '../../services/SupplierService';
import { Select } from '../UI/Input/Select'
import { Link, useNavigate } from 'react-router-dom';
import { usePopup } from '../popups/PopupContext';
import SearchSelect from '../UI/Input/SearchSelect';
import SearchInput from '../UI/Input/SearchInput';
import useTable from '../../libraries/handleTable'
import { useForm } from '../../libraries/handleInput'
import PageHead from '../PageHead';
import Currencies from '../Currencies';
import { isoToDateTime } from '../../libraries/common';
export default function ListPurchases() {
    const navigate = useNavigate();
    const { openPopup } = usePopup();
    const [addShow, setAddShow] = useState(false);
    const [supplierData, setSupplierData] = useState([]);
    const form = useForm();
    const search = useForm();
    const table = useTable();

    const columns = [
        {
            label: "ID", key: "id", render: (id) => {
                return <span>PU{id}</span>
            }
        },
        { label: "Supplier", key: "supplier_name" },
        {
            label: "Purchase date", key: "purchase_date", render: (date) => {
                return isoToDateTime(date);
            }
        },
        {
            label: "Expected date", key: "expected_date", render: (date) => {
                return isoToDateTime(date);
            }
        },
        {
            label: "Shipping fee", key: "shipping_fee", render: (value) => {
                return <strong>
                    <Currencies amount={value}/>
                </strong>
            }
        },
        { label: "Payment method", key: "payment_method" },
        { label: "Buy", key: "buy_quantity" },
        { label: "Compensation", key: "compensation_quantity" },
        { label: "Conversion", key: "conversion_quantity" },
        { label: "Gift", key: "gift_quantity" },
        { label: "Tax", key: "tax", render: (value) => {
            return <strong>
                <Currencies amount={value}/>
            </strong>
        } },
        {
            label: "Status", key: "status", render: (value) => {
                const badgeMap = {
                    draft: 'bg-secondary',
                    requested: 'bg-info',
                    approved: 'bg-primary',
                    ordered: 'bg-warning',
                    paid: 'bg-success',
                    received: 'bg-success',
                    cancelled: 'bg-danger'
                };
                return (
                    <span className={`badge rounded-pill text-uppercase px-3 py-2 ${badgeMap[value] || 'bg-secondary'}`}>
                        {value}
                    </span>
                );
            }
        },
    ];

    const handleEdit = (row) => {
        navigate('/purchases?form=edit&id=' + row.id)
    };

    const handleDelete = (row) => {
        console.log("Delete clicked:", row);
    };
    const getSuppliers = useCallback((keywords = '') => {
        SupplierService.list({
            page: 0,
            keywords: keywords,
            active: ''
        })
            .then((resp) => {
                setSupplierData(resp.message.data)
            })
            .catch((error) => {
                navigate('/')
            });
    }, [SupplierService]);
    const submit = useCallback(() => {
        form.setFormErrors(null);
        PurchaseService.add({
            ...form.formData,
            supplier_id: form.formData?.supplier_id?.value
        })
            .then((resp) => {
                setAddShow(false);
                getSuppliers();
                openPopup({
                    type: 'success',
                    message: "You has been created"
                })
            })
            .catch((error) => {
                if (error.response.data?.errors) {
                    form.setFormErrors(error.response.data?.errors);
                }
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            });
    }, [form, getSuppliers]);
    const getPurchases = useCallback((page = 0) => {
        table.setLoading(true);
        PurchaseService.list({
            keywords: search.formData?.keywords ?? '',
            page: page,
            status: search.formData?.status ?? ''
        })
            .then((resp) => {
                //setPurchaseData(resp.message.data)
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
                table.setLoading(false);
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            });
    }, [search.formData]);
    useEffect(() => {
        getPurchases();
    }, [search.formData?.status])
    return <div>
        <div>
                <PageHead
                containerClass='mx-4'
                title='Purchases'
                subtitle='Track your offers, approval and payment status.'
                />
            </div>
        <div className="m-4">
            
            <CommonDataTable
                filter={<div className='d-flex'>
                    <div className='col-6'>
                        <label>Status</label>
                        <Select
                            name='status'
                            value={search.formData?.status}
                            handleChange={search.handleChange}
                            errorMessage={search.formErrors?.status}
                            options={[
                                { value: 'draft', label: 'Draft' },
                                { value: 'requested', label: 'Requested' },
                                { value: 'approved', label: 'Approved' },
                                { value: 'cancelled', label: 'Cancelled' }
                            ]} />
                    </div>
                    <div className='col-6 mx-2'>
                        <label>Search</label>
                        <SearchInput
                            submit={getPurchases}
                            name='keywords'
                            value={search.formData?.keywords}
                            handleChange={search.handleChange}
                            errorMessage={search.formErrors?.keywords}
                            placeholder='Search by supplier' />
                    </div>
                </div>}
                add={() => navigate('/purchases?form=add')}
                columns={columns}
                data={table.data}
                links={table.links}
                onEdit={handleEdit}
                onDelete={handleDelete}
                movePage={getPurchases}
                loading={table.loading}
            />

            {addShow ? (
                <PopupLayout
                    onClose={() => setAddShow(false)}
                    title="Thêm phiếu nhập hàng"
                    onConfirm={submit}
                >
                    <div className="space-y-2">
                        <div>
                            <label>Nhà cung cấp</label>
                            <SearchSelect
                                search={getSuppliers}
                                value={form.formData?.supplier_id}
                                changeValue={(item) => form.handleChangeByKey('supplier_id', item)}
                                options={supplierData?.map((item) => {
                                    return {
                                        value: item.id,
                                        label: item.unit_name
                                    }
                                })} />
                        </div>
                        <div>
                            <label>Ngày mua</label>
                            <InputForm
                                type="date"
                                handleChange={form.handleChange}
                                value={form.formData?.purchase_date}
                                errorMessage={form.formErrors?.purchase_date}
                                name="purchase_date"
                            />
                        </div>
                        <div>
                            <label>Ngày dự kiến</label>
                            <InputForm
                                type="date"
                                handleChange={form.handleChange}
                                value={form.formData?.expected_date}
                                errorMessage={form.formErrors?.expected_date}
                                name="expected_date"
                            />
                        </div>
                        <div>
                            <label>Phương thức thanh toán</label>
                            <Select
                                name="payment_method"
                                value={form.formData?.payment_method}
                                handleChange={form.handleChange}
                                errorMessage={form.formErrors?.payment_method}
                                options={[
                                    { value: 'cash', label: 'Cash' },
                                    { value: 'bank', label: 'Bank' },
                                    { value: 'transfer', label: 'Transfer' },
                                    { value: 'other', label: 'Other' }
                                ]}
                            />
                        </div>
                        <div>
                            <label>Phí vận chuyển</label>
                            <InputForm
                                type="number"
                                handleChange={form.handleChange}
                                value={form.formData?.shipping_fee}
                                errorMessage={form.formErrors?.shipping_fee}
                                name="shipping_fee"
                                placeholder="Nhập phí vận chuyển"
                            />
                        </div>
                        <div>
                            <label>Ghi chú</label>
                            <InputForm
                                handleChange={form.handleChange}
                                value={form.formData?.note}
                                errorMessage={form.formErrors?.note}
                                name="note"
                                placeholder="Ghi chú thêm"
                            />
                        </div>
                    </div>
                </PopupLayout>
            ) : null}
        </div>
    </div>
}