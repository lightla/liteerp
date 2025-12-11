import React, { useCallback, useEffect, useState } from 'react'
import InvoiceOutService from '../../services/InvoiceOutService';
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
export default function InvoiceOuts() {
    const navigate = useNavigate();
    const search = useForm();
    const form = useForm();
    const table = useTable();
    const { openPopup } = usePopup();
    const [showForm, setShowForm] = useState(false);
    const columns = [
        {
            label: "Customer",
            key: "customer_name",
            render: (value) => value ?? <span className="text-muted fst-italic">{value}</span>,
        },
        {
            label: "Order ID",
            key: "order_id",
            render: (value) => {
                return <span className="">OD{value}</span>
            },
        },
        {
            label: "Document no",
            key: "document_no",
            render: (value) => value ?? <span className="text-muted fst-italic">{value}</span>,
        },
        {
            label: "Subtotal",
            key: "subtotal",
            render: (value) => <span><Currencies amount={value} /></span>,
        },
        {
            label: "Tax",
            key: "tax",
            render: (value) => <span><Currencies amount={value} /></span>,
        },
        {
            label: "Total paid",
            key: "total_adjusted",
            render: (value) => <strong><Currencies amount={value} /></strong>,
        },
        {
            label: "Status",
            key: "status",
            render: (value) => {
                return value === 'approved' ? <span
                    className={`badge rounded-pill px-3 py-2 bg-warning text-uppercase`}
                >
                    Waiting
                </span> : <span
                    className={`badge rounded-pill px-3 py-2 bg-primary text-uppercase`}
                >
                    Approved
                </span>
            },
        },
        {
            label: "Invoice date",
            key: "invoice_date",
            render: (value) =>
                value ? isoToDateTime(value) : "",
        },
    ];
    const getInvoices = useCallback((page = 0) => {
        table.setLoading(true);
        InvoiceOutService.list({
            page: page,
            keywords: search?.formData?.keywords ?? '',
            payment_status: search?.formData?.payment_status ?? ''
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
    }, [table,search.formData]);
    const update = useCallback(() => {
        form.setFormErrors(null);
        InvoiceOutService.update(form.formData)
            .then((resp) => {
                getInvoices();
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                })
                setShowForm(false)
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
    }, [form.formData]);
    const onEdit = (row) => {
        {/* setShowForm(true);
        form.setFormData(row) */}
        navigate('/invoices?form=invoiceout&id=' + row.id)
    }
    useEffect(() => {
        getInvoices();
    }, [search.formData?.payment_status])
    return <div>
        <CommonDataTable
            filter={<div className="d-flex">
                <div className="col-4">
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
                <div className="col-4 mx-2">
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
        />
        {showForm ? <PopupLayout
            onClose={() => setShowForm(false)}
            onConfirm={update}
            title='Update invoice out'>
            <div>
                <div className='form-group'>
                    <label>Document no</label>
                    <InputForm type='text'
                        value={form.formData?.document_no}
                        errorMessage={form.formErrors?.document_no}
                        name='document_no'
                        handleChange={form.handleChange}
                    />
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
                    <label>Due date</label>
                    <InputForm type='date'
                        value={isoToDateTime(form.formData?.due_date)}
                        errorMessage={form.formErrors?.due_date}
                        name='due_date'
                        handleChange={form.handleChange}
                    />
                </div>
                <div className='form-group mt-3'>
                    <label>Status</label>
                    <Select
                        value={form.formData?.status}
                        errorMessage={form.formErrors?.due_date}
                        name='status'
                        handleChange={form.handleChange}
                        options={[
                            { value: 'approved', label: 'Not change' },
                            { value: 'invoiced', label: 'Approved' }
                        ]}
                    />
                </div>
            </div>
        </PopupLayout> : null}

    </div>
}