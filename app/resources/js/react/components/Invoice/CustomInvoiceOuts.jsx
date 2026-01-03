import React, { useCallback, useEffect, useRef, useState } from 'react'
import CommonDataTable from '../CommonDataTable';
import useTable from '../../libraries/handleTable';
import { isoToDateTime } from '../../libraries/common';
import { PopupLayout } from '../../layouts/PopupLayout'
import { InputForm } from '../UI/Input/InputForm'
import { useForm } from '../../libraries/handleInput';
import { Select } from '../UI/Input/Select';
import { usePopup } from '../popups/PopupContext'
import Currencies from '../Currencies';
import SearchInput from '../UI/Input/SearchInput';
import StatusBadge from '../StatusBadge';
import CustomInvoiceOutService from '../../services/CustomInvoiceOutService';
import TextArea from '../UI/Input/Textarea'
import SearchSelect from '../UI/Input/SearchSelect'
import CustomerService from '../../services/CustomerService';
import ContentOnTable from '../ContentOnTable';
import RenderFieldTableByList from '../RenderFieldTableByList';
import RenderFormFieldByList from '../RenderFormFieldByList';
import { RenderTableSearch } from '../RenderTableSearch';
import PrimaryButton from '../UI/Buttons/PrimaryButton';
export default function CustomInvoiceOuts() {
    const [customers, setCustomers] = useState([]);
    const search = useForm();
    const form = useForm();
    const table = useTable();
    const { openPopup } = usePopup();
    const [showForm, setShowForm] = useState(false);
    const getInvoices = useCallback((page = 0) => {
        table.setLoading(true);
        CustomInvoiceOutService.list({
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
        CustomInvoiceOutService.update(form.formData)
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
        CustomInvoiceOutService.add(form.formData)
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
        CustomInvoiceOutService.delete(row)
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
    const getCustomers = useCallback((keywords = '', callback = null) => {
        CustomerService.list({
            keywords: keywords
        })
            .then((resp) => {
                if (callback) {
                    callback();
                }
                setCustomers(resp.message.data)
            })
            .catch((error) => {

            })
    }, [])
    const view = useCallback((row) => {
        CustomInvoiceOutService.view(row)
            .then((resp) => {
                table.addColums(resp.message.index,(item,data) => {
                    return <RenderFieldTableByList item={item} data={data}/>
                })
                form.setHookRender(resp.message.form)
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
    useEffect(() => {
        getInvoices();
        table.setColums([
            {
                label: "ID",
                key: "id"
            },
            {
                label: "Customer",
                key: "customer_name"
            },
            {
                label: "Description",
                key: "description",
                render: (value) => {
                    return <ContentOnTable value={value} />
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
        ])
        view();
    }, [])
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
                        <RenderTableSearch item={item} search={search}/>
                    </div>
                })}
                <div className="col-6 mx-2">
                    <label>Search</label>
                    <SearchInput
                        placeholder="Search by document"
                        submit={getInvoices}
                        value={search.formData?.keywords}
                        name="keywords"
                        handleChange={search.handleChange}
                    />
                </div>
                <div className="col-2">
                    <PrimaryButton label='Search' onClick={() => getInvoices()}/>
                </div>
            </div>}
            loading={table.loading}
            columns={table.colums}
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
            onConfirm={form.isEdit ? update : add}
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
                        <label>Customer</label>
                        <SearchSelect
                            search={getCustomers}
                            value={form.formData?.customer_id}
                            errorMessage={form.formErrors?.customer_id}
                            name='customer_id'
                            changeValue={form.handleChangeByKey}
                            options={customers.map((item) => {
                                return {
                                    value: item.id,
                                    label: item.name
                                }
                            })}
                            defaultKeywords={form.formData?.customer_name}
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
                {form.hookRender.map((item,index) => {
                   return <div className='form-group mt-3' key={index}>
                    <RenderFormFieldByList item={item} form={form}/>
                   </div> 
                })}
            </div>
        </PopupLayout> : null}

    </div>
}