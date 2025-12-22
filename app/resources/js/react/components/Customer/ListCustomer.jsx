import React, { useCallback, useEffect, useState } from 'react'
import CommonDataTable from '../CommonDataTable';
import useTable from '../../libraries/handleTable';
import { useForm } from '../../libraries/handleInput';
import { usePopup } from '../popups/PopupContext';
import { Select } from '../UI/Input/Select';
import SearchInput from '../UI/Input/SearchInput';
import { PopupLayout } from '../../layouts/PopupLayout';
import CustomerService from '../../services/CustomerService';
import CustomerForm from './ListCustomer/CustomerForm';
export default function ListCustomer() {
    const table = useTable();
    const search = useForm();
    const { openPopup } = usePopup();
    const form = useForm();
    const [showAdd, setShowAdd] = useState(false);
    const columns = [
        { label: "ID", key: "id" },
        { label: "Name", key: "name" },
        { label: "Email", key: "email" },
        { label: "Number phone", key: "phone" },
        { label: "Ordered", key: "total_order" },
        { label: "Group", key: "group_name" },
        {
            label: 'Type', key: 'type', render: (value) => {
                return <span className={'badge text-uppercase ' + (value === 'company' ? 'bg-primary' : 'bg-secondary')}>
                    {value}
                </span>
            }
        }
    ];

    const handleEdit = (row) => {
        console.log("Edit clicked:", row);
        form.setIsEdit(true);
        form.setFormData(row);
        setShowAdd(true)
    };


    const submit = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        CustomerService.add(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been created'
                });
                setShowAdd(false);
                getCustomers();
                form.setLoading(false)
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
                form.setLoading(false)
            })
    }, [form.formData]);
    const update = useCallback(() => {
        form.setFormErrors(null);
        form.setLoading(true)
        CustomerService.update(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been created'
                });
                setShowAdd(false);
                getCustomers();
                form.setLoading(false)
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
                form.setLoading(false)
            })
    }, [form.formData]);
    const destroy = useCallback((row) => {
        CustomerService.delete(row)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been deleted'
                });
                getCustomers();
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            })
    }, [])
    const handleDelete = (row) => {
        openPopup({
            type: 'warning',
            message: 'Are your sure to delete?',
            onConfirm: () => {
                destroy(row);
            }
        })
    };
    const getCustomers = useCallback((page = 0) => {
        table.setLoading(true)
        CustomerService.list({
            keywords: search.formData?.keywords ?? '',
            page: page,
            type: search.formData?.type ?? '',
            order_by: search.formData?.order_by ?? ''
        })
            .then((resp) => {
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
                table.setLoading(false)
            })
            .catch((error) => {

            })
    }, [search.formData]);
    useEffect(() => {
        getCustomers();
    }, [search.formData?.type,search.formData?.order_by]);
    return <div>
        <CommonDataTable
            add={() => setShowAdd(true)}
            filter={<div className='d-flex'>
                <div className='col-3'>
                    <label>Type</label>
                    <Select
                        value={search.formData?.type}
                        name='type'
                        handleChange={search.handleChange}
                        options={[
                            { value: 'individual', label: 'Individual' },
                            { value: 'company', label: 'Company' }
                        ]} />
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
                <div className='col-6'>
                    <label>Search</label>
                    <SearchInput
                        submit={getCustomers}
                        placeholder='Search by customer name'
                        value={search.formData?.keywords}
                        name='keywords'
                        handleChange={search.handleChange}
                    />
                </div>
            </div>}
            movePage={getCustomers}
            columns={columns}
            data={table?.data}
            links={table?.links}
            onEdit={handleEdit}
            onDelete={handleDelete}
            loading={table.loading}
        />
        <div>
            {showAdd ? <PopupLayout
                loading={form.loading}
                confirmText='Save'
                onConfirm={form.isEdit ? update : submit}
                onClose={() => {
                    setShowAdd(false);
                    form.setIsEdit(false);
                }} title={form.isEdit ? 'Update customer' : 'Add customer'}>
                <CustomerForm form={form} />
            </PopupLayout> : null}

        </div>
    </div>
}