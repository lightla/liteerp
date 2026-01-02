import React, { useCallback, useEffect, useState } from 'react'
import InvoiceOutService from '../../services/InvoiceOutService';
import CommonDataTable from '../CommonDataTable';
import useTable from '../../libraries/handleTable';
import { isoToDateTime } from '../../libraries/common';
import { useForm } from '../../libraries/handleInput';
import { Select } from '../UI/Input/Select';
import { usePopup } from '../popups/PopupContext'
import { useNavigate } from 'react-router-dom';
import Currencies from '../Currencies';
import SearchInput from '../UI/Input/SearchInput';
import StatusBadge from '../StatusBadge';
import RenderFieldTableByList from '../RenderFieldTableByList'
import { RenderTableSearch } from '../RenderTableSearch';
import PrimaryButton from '../UI/Buttons/PrimaryButton';
export default function InvoiceOuts() {
    const navigate = useNavigate();
    const search = useForm();
    const table = useTable();
    const { openPopup } = usePopup();
    const getInvoices = useCallback((page = 0) => {
        table.setLoading(true);
        InvoiceOutService.list({
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
    const view = useCallback(() => {
        InvoiceOutService.view()
            .then((resp) => {
                table.addColums(resp.message.index,(item,data) => {
                    return <RenderFieldTableByList item={item} data={data}/>
                })
                search.setHookRender(resp.message.search)
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            })
    }, []);
    const onEdit = (row) => {
        navigate('/invoices?form=invoiceout&id=' + row.id)
    }
    useEffect(() => {
        table.setColums([
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
        },
        {
            label: "Order status",
            key: "order_status",
            render: (value) => {
                return <StatusBadge status={value} />
            }
        },
    ])
        getInvoices();
        view();
    }, [])
    return <div>
        <CommonDataTable
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
                <div className='col-3 ml-2'>
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
                {search.hookRender.map((item,index) => {
                    return <div className='col-3 ml-2' key={index}>
                        <RenderTableSearch item={item} search={search} />
                    </div>
                })}
                <div className="col-6 ml-2">
                    <label>Search</label>
                    <SearchInput
                        placeholder="Search by document"
                        submit={getInvoices}
                        value={search.formData?.keywords}
                        name="keywords"
                        handleChange={search.handleChange}
                    />
                </div>
                <div className="col-2 ml-2">
                    <PrimaryButton label='Search' onClick={() => getInvoices()} />
                </div>
            </div>}
            loading={table.loading}
            columns={table.colums}
            data={table.data}
            links={table.links}
            onEdit={onEdit}
            movePage={getInvoices}
        />

    </div>
}