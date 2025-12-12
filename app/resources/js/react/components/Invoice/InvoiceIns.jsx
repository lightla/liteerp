import React from 'react'
import { useCallback, useEffect, useState } from "react";
import { useForm } from "../../libraries/handleInput";
import InvoiceInService from "../../services/InvoiceInService";
import CommonDataTable from "../CommonDataTable";
import SearchInput from "../UI/Input/SearchInput";
import useTable from "../../libraries/handleTable";
import { usePopup } from "../popups/PopupContext";
import { Select } from '../UI/Input/Select';
import { PopupLayout } from '../../layouts/PopupLayout';
import { InputForm } from '../UI/Input/InputForm';
import { useNavigate } from 'react-router-dom';
import Currencies from '../../components/Currencies'
export default function InvoiceIns() {
    const navigate = useNavigate();
    const { openPopup } = usePopup();
    const table = useTable();
    //const [selectRow, setSelectRow] = useState(null);
    const [showEdit, setShowEdit] = useState(false);
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
            render: (value) => (
                <span
                    className={`badge rounded-pill 
                        px-3 py-2 text-uppercase ` + (value ? 'bg-success' : 'bg-primary')}
                >
                    {value ? 'Approved' : 'Wait'}
                </span>
            ),
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
                return <div className='text-uppercase'>
                    {value === 'pending' ? <span className='badge bg-warning'>{value}</span> : null}
                    {value === 'paid' ? <span className='badge bg-success'>{value}</span> : null}
                    {value === 'partial_payment' ? <span className='badge bg-primary'>{value}</span> : null}
                </div>
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
    const submit = useCallback(() => {
        form.setFormErrors(null)
        InvoiceInService.update(form.formData)
            .then((resp) => {
                setShowEdit(false);
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                });
                listInvoice();
            })
            .catch((error) => {
                if (error.response.data?.errors) {
                    form.setFormErrors(error.response.data?.errors)
                }
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            })
    }, [form.formData, listInvoice]);

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
        />
        {showEdit ? <PopupLayout title="Purchase information" onClose={() => setShowEdit(false)} onConfirm={submit} confirmText="Update">
            <div>
                <div>
                    <div>
                        <div className="table-responsive">
                            <table className="table table-bordered table-striped align-middle">
                                <tbody>
                                    <tr>
                                        <th>Company / Unit</th>
                                        <td>{form.formData?.unit_name ?? <span className="text-muted fst-italic">N/A</span>}</td>
                                    </tr>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td><Currencies amount={form.formData?.subtotal}/></td>
                                    </tr>
                                    <tr>
                                        <th>Tax (VAT)</th>
                                        <td>
                                            <Currencies amount={form.formData?.tax}/></td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td><Currencies amount={form.formData?.discount}/></td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        <td>
                                            <strong><Currencies amount={form.formData?.total}/></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>
                                            {form.formData?.created_at
                                                ? new Date(form.formData.created_at).toLocaleString("en-GB")
                                                : "-"}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>
                                            {form.formData?.updated_at
                                                ? new Date(form.formData.updated_at).toLocaleString("en-GB")
                                                : "-"}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{form.formData?.email ?? <span className="text-muted fst-italic">N/A</span>}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{form.formData?.phone ?? <span className="text-muted fst-italic">N/A</span>}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{form.formData?.address ?? <span className="text-muted fst-italic">N/A</span>}</td>
                                    </tr>
                                    <tr>
                                        <th>Tax Code</th>
                                        <td>{form.formData?.tax_code ?? <span className="text-muted fst-italic">N/A</span>}</td>
                                    </tr>
                                    <tr>
                                        <th>Bank Name</th>
                                        <td>{form.formData?.bank_name ?? <span className="text-muted fst-italic">N/A</span>}</td>
                                    </tr>
                                    <tr>
                                        <th>Bank Account</th>
                                        <td>{form.formData?.bank_account ?? <span className="text-muted fst-italic">N/A</span>}</td>
                                    </tr>
                                    <tr>
                                        <th>Website</th>
                                        <td>{form.formData?.website ?? <span className="text-muted fst-italic">N/A</span>}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th>
                                        <td>{form.formData?.note ?? <span className="text-muted fst-italic">N/A</span>}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
                <div className="form-group">
                    <label>Invoice Number</label>
                    <InputForm
                        errorMessage={form.formErrors?.document_no}
                        handleChange={form.handleChange}
                        value={form.formData?.document_no} type="text"
                        name="document_no" placeholder="Enter invoice number" />
                </div>
                <div className="form-group">
                    <label>Invoice Date</label>
                    <InputForm
                        errorMessage={form.formErrors?.invoice_date}
                        handleChange={form.handleChange} value={form.formData?.invoice_date}
                        type="date" name="invoice_date" placeholder="Enter invoice date" />
                </div>
            </div>
        </PopupLayout> : null}
    </div>
}