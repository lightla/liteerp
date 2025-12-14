import React from 'react'
import { useCallback, useEffect, useState } from "react";
import { useForm } from "../../libraries/handleInput";
import InvoiceInService from "../../services/InvoiceInService";
import CommonDataTable from "../CommonDataTable";
import SearchInput from "../UI/Input/SearchInput";
import useTable from "../../libraries/handleTable";
import { usePopup } from "../popups/PopupContext";
import { Select } from '../UI/Input/Select';
import { useNavigate } from 'react-router-dom';
import Currencies from '../../components/Currencies'
import StatusBadge from '../StatusBadge'
export default function InvoiceIns() {
    const navigate = useNavigate();
    const { openPopup } = usePopup();
    const table = useTable();
    const search = useForm();
    const form = useForm();

    const columns = [
        {
            label: "Supplier",
            key: "unit_name",
            render: (value) => value ?? <span className="text-muted fst-italic">{value}</span>,
        },
        {
            label: "Purchase ID",
            key: "purchase_id",
            render: (value) => {
                return <span className="">PU{value}</span>
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
            render: (value) => <span>
                <Currencies amount={value}/>
            </span>,
        },
        {
            label: "Tax",
            key: "tax",
            render: (value) => <span><Currencies amount={value}/></span>,
        },
        {
            label: "Total paid",
            key: "total",
            render: (value) => <strong><Currencies amount={value}/></strong>,
        },
        {
            label: "Status",
            key: "approved",
            render: (value) => {
                return <StatusBadge status={value ? 'approved' : 'unapproved'}/>
            },
        },
        {
            label: "Invoice date",
            key: "invoice_date",
            render: (value) =>
                value ?? "",
        },
        {
            label: "Payment",
            key: "payment_status",
            render: (value) => {
                return <StatusBadge status={value}/>
            }
        },
    ];

    const handleEdit = useCallback((row) => {
        navigate('/invoices?form=invoicein&id=' + row.id)
    }, []);
    const listInvoice = useCallback((page = 0) => {
        table.setLoading(true);
        InvoiceInService.list({
            page: page,
            keywords: search.formData?.keywords ?? '',
            payment_status: search.formData?.payment_status ?? ''
        })
            .then((resp) => {
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
        listInvoice();
    }, [search.formData?.payment_status]);
    return <div>
        <CommonDataTable
            loading={table.loading}
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
                        submit={listInvoice}
                        value={search.formData?.keywords}
                        name="keywords"
                        handleChange={search.handleChange}
                    />
                </div>
            </div>}
            columns={columns}
            data={table.data}
            links={table.links}
            onEdit={handleEdit}
            movePage={listInvoice}
        />
    </div>
}