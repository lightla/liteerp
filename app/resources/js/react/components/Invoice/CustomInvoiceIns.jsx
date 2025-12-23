import React, { useCallback, useEffect, useRef, useState } from 'react'
import CommonDataTable from '../CommonDataTable';
import useTable from '../../libraries/handleTable';
import { isoToDateTime } from '../../libraries/common';
import { PopupLayout } from '../../layouts/PopupLayout'
import { InputForm } from '../UI/Input/InputForm'
import { useForm } from '../../libraries/handleInput';
import { Select } from '../UI/Input/Select';
import { usePopup } from '../popups/PopupContext'
import { useNavigate } from 'react-router-dom';
import Currencies from '../Currencies';
import SearchInput from '../UI/Input/SearchInput';
import StatusBadge from '../StatusBadge';
import TextArea from '../UI/Input/Textarea'
import SearchSelect from '../UI/Input/SearchSelect'
import SupplierService from '../../services/SupplierService';
import CustomInvoiceInService from '../../services/CustomInvoiceInService';
import ContentOnTable from '../ContentOnTable'
export default function CustomInvoiceIns() {
    const [suppliers,setSuppliers] = useState([]);
    const search = useForm();
    const form = useForm();
    const table = useTable();
    const { openPopup } = usePopup();
    const [showForm, setShowForm] = useState(false);
    const columns = [
        {
            label: "ID",
            key: "id"
        },
        {
            label: "Supplier",
            key: "unit_name"
        },
        {
            label: "Description",
            key: "description",
            render: (value) => {
                return <ContentOnTable value={value}/>
            }
        },
        {
            label: "Document No",
            key: "document_no"
        },
        {
            label: "Amount",
            key: "amount",
            render: (value) => <span><Currencies amount={value} /></span>,
        },
        {
            label: "Status",
            key: "approved",
            render: (value) => {
                return <StatusBadge status={value ? 'approved' : 'unapproved'} />
            }
        },
        {
            label: "Invoice date",
            key: "invoice_date",
            render: (value) =>
                value ? isoToDateTime(value) : "",
        },
        {
            label: "Payment",
            key: "payment_status",
            render: (value) => {
                return <StatusBadge status={value} />
            }
        }
    ];
    const getInvoices = useCallback((page = 0) => {
        table.setLoading(true);
        CustomInvoiceInService.list({
            page: page,
            keywords: search?.formData?.keywords ?? '',
            payment_status: search?.formData?.payment_status ?? '',
            order_by: search.formData?.order_by ?? ''
        })
            .then((resp) => {
                table.setData(resp.message.data)
                table.setLinks(resp.message.links)
                table.setLoading(false);
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            })
    }, [table, search.formData]);
    const update = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        CustomInvoiceInService.update(form.formData)
            .then((resp) => {
                getInvoices();
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                })
                setShowForm(false)
                form.setLoading(false)
                resetForm();
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
                 form.setLoading(false)
            })
    }, [form.formData]);
    const add = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        CustomInvoiceInService.add(form.formData)
            .then((resp) => {
                getInvoices();
                openPopup({
                    type: 'success',
                    message: 'You has been added'
                })
                setShowForm(false)
                form.setLoading(false)
                resetForm();
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
                form.setLoading(false)
            })
    }, [form.formData]);
    const onEdit = (row) => {
        form.setFormData(row)
        form.setIsEdit(true);
        setShowForm(true)
    }
    const resetForm = () => {
        form.setFormData(null)
        form.setIsEdit(null);
    }
    const destroy = useCallback((row) => {
        CustomInvoiceInService.delete(row)
            .then((resp) => {
                getInvoices();
                openPopup({
                    type: 'success',
                    message: 'You has been deleted'
                })
                resetForm();
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
            })
    }, []);
    const onDelete = (row) => {
        openPopup({
            type: 'warning',
            message: 'Do you wanna to delete?',
            onConfirm: () => {
                destroy(row)
            }
        })
    }
    const getSuppliers = useCallback((keywords = '',callback = null) => {
        SupplierService.list({
            keywords: keywords
        })
        .then((resp) => {
            if(callback) {
                callback();
            }
            setSuppliers(resp.message.data)
        })
        .catch((error) => {

        })
    },[])
    useEffect(() => {
        getInvoices();
    }, [search.formData?.payment_status, search.formData?.order_by])
    return <div>
        <CommonDataTable
            add={() => {
                setShowForm(true)
            }}
            filter={<div className="d-flex">
                <div className="col-3">
                    <label>Payment status</label>
                    <Select
                        name="payment_status"
                        value={search.formData?.payment_status}
                        handleChange={search.handleChange}
                        options={[
                            { value: '', label: 'All' },
                            { value: 'partial_payment', label: 'Partial' },
                            { value: 'paid', label: 'Paid' },
                            { value: 'pending', label: 'Pending' }
                        ]}
                    />
                </div>
                <div className='col-3 mx-2'>
                    <label>Order by</label>
                    <Select
                        name='order_by'
                        value={search.formData?.order_by}
                        handleChange={search.handleChange}
                        errorMessage={search.formErrors?.order_by}
                        options={[
                            { value: 'ASC', label: 'Oldest' },
                            { value: 'DESC', label: 'Newest' }
                        ]} />
                </div>
                <div className="col-6">
                    <label>Search</label>
                    <SearchInput
                        placeholder="Search by document"
                        submit={getInvoices}
                        value={search.formData?.keywords}
                        name="keywords"
                        handleChange={search.handleChange}
                    />
                </div>
            </div>}
            loading={table.loading}
            columns={columns}
            data={table.data}
            links={table.links}
            onEdit={onEdit}
            movePage={getInvoices}
            onDelete={onDelete}
        />
        {showForm ? <PopupLayout
            loading={form.loading}
            onClose={() => {
                setShowForm(false)
                resetForm();
            }}
            onConfirm={form.isEdit ? update :  add}
            confirmText={form.isEdit ? 'Save change' : 'Add new'}
            title='Custom invoice out'>
            <div>
                <div className='row'>
                    <div className='form-group col-6'>
                        <label>Document no</label>
                        <InputForm type='text'
                            value={form.formData?.document_no}
                            errorMessage={form.formErrors?.document_no}
                            name='document_no'
                            handleChange={form.handleChange}
                        />
                    </div>
                    <div className='form-group col-6'>
                        <label>Suppliers</label>
                        <SearchSelect 
                            search={getSuppliers}
                            value={form.formData?.supplier_id}
                            errorMessage={form.formErrors?.supplier_id}
                            name='supplier_id'
                            changeValue={form.handleChangeByKey}
                            options={suppliers.map((item) => {
                                return {
                                    value: item.id,
                                    label: item.unit_name
                                }
                            })}
                            defaultKeywords={form.formData?.unit_name}
                        />
                    </div>
                </div>
                <div className='form-group mt-3'>
                    <label>Invoice date</label>
                    <InputForm type='date'
                        value={isoToDateTime(form.formData?.invoice_date)}
                        errorMessage={form.formErrors?.invoice_date}
                        name='invoice_date'
                        handleChange={form.handleChange}
                    />
                </div>
                <div className='form-group mt-3'>
                    <label>Amount</label>
                    <InputForm type='number'
                        value={form.formData?.amount}
                        errorMessage={form.formErrors?.amount}
                        name='amount'
                        handleChange={form.handleChange}
                    />
                </div>
                <div className='form-group mt-3'>
                    <label>Description</label>
                    <TextArea
                        value={form.formData?.description}
                        errorMessage={form.formErrors?.description}
                        name='description'
                        handleChange={form.handleChange}
                    />
                </div>
                <div className='form-group mt-3'>
                    <label>Payment status</label>
                    <Select
                        value={form.formData?.payment_status}
                        errorMessage={form.formErrors?.payment_status}
                        name='payment_status'
                        handleChange={form.handleChange}
                        options={[
                            { value: 'paid', label: 'Paid' },
                            { value: 'partial_payment', label: 'Partial payment' },
                            { value: 'pending', label: 'Pending' }
                        ]}
                    />
                </div>
                <div className='form-group mt-3'>
                    <label>Status</label>
                    <InputForm
                        width={20}
                        value={form.formData?.approved}
                        errorMessage={form.formErrors?.approved}
                        name='approved'
                        type='checkbox'
                        handleChange={form.handleChange}
                    />
                    <span>This mean status invoice, if uncheck then system to understand is not working</span>
                </div>
            </div>
        </PopupLayout> : null}

    </div>
}