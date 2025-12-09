import React, { useCallback, useEffect, useState } from 'react';
import DashboardLayout from '../layouts/DashboardLayout';
import CommonDataTable from '../components/CommonDataTable';
import { PopupLayout } from '../layouts/PopupLayout';
import { InputForm } from '../components/UI/Input/InputForm';
import SupplierService from '../services/SupplierService'
import SearchInput from '../components/UI/Input/SearchInput'
import { useForm } from '../libraries/handleInput';
import useTable from '../libraries/handleTable'
import { Select } from '../components/UI/Input/Select'
import TextArea from '../components/UI/Input/Textarea'
import { usePopup } from '../components/popups/PopupContext'
import PageHead from '../components/PageHead';
import { substring } from '../libraries/common';
export default function Suppliers() {
    const { openPopup } = usePopup();
    const [addShow, setAddShow] = useState(false);
    const search = useForm();
    const form = useForm();
    const table = useTable();
    const columns = [
        { label: "ID", key: "id" },
        {
            label: "Unit Name", key: "unit_name", render: (name) => {
                return <span>
                    {substring(name, 0, 30)}
                </span>
            }
        },
        { label: "Email", key: "email" },
        { label: "Phone Number", key: "phone" },
        {
            label: "Address", key: "address", render: (address) => {
                return <span>
                    {substring(address, 0, 30)}
                </span>
            }
        },
        { label: "Tax Code", key: "tax_code" },
        { label: "Bank Name", key: "bank_name" },
        { label: "Bank Account", key: "bank_account" },
        {
            label: "Website", key: "website", render: (website) => {
                return <span>
                    {substring(website, 0, 30)}
                </span>
            }
        },
        {
            label: "Status",
            key: "active",
            render: (value) => (
                <span
                    className={`badge rounded-pill px-3 py-2 ${value ? 'bg-success' : 'bg-secondary'}`}
                >
                    {value ? 'Active' : 'Inactive'}
                </span>
            ),
        },
    ];


    const handleEdit = (row) => {
        console.log("Edit clicked:", row);
        form.setFormData(row);
        form.setIsEdit(true);
        setAddShow(true);
    };

    const handleDelete = (row) => {
        console.log("Delete clicked:", row);
    };
    const getSupliers = useCallback((page = 0) => {
        table.setLoading(true);
        SupplierService.list({
            page: page,
            keywords: search.formData?.keyword ?? '',
            active: search.formData?.active ?? ''
        })
            .then((resp) => {
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
                table.setLoading(false);
            })
            .catch((error) => {

            })
    }, [search.formData]);
    const submit = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null)
        SupplierService.add(form.formData)
            .then((resp) => {
                setAddShow(false);
                getSupliers();
                form.setLoading(false)
                openPopup({
                        type: 'success',
                        message: 'You has been added'
                    })
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
        form.setFormErrors(null)
        form.setLoading(true)
        SupplierService.update(form.formData)
            .then((resp) => {
                setAddShow(false);
                getSupliers();
                form.setLoading(false);
                openPopup({
                        type: 'success',
                        message: 'You has been updated'
                    })
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

    useEffect(() => {
        getSupliers();
    }, [search.formData?.active]);
    return (
        <DashboardLayout>
            <div>
                <PageHead
                    containerClass='mx-4'
                    title='Suppliers'
                    subtitle='List of suppliers for materials, accessories, and goods.'
                />
            </div>
            <div className="m-4">

                <div>
                    <CommonDataTable
                        filter={<div className='d-flex'>
                            <div className='col-6'>
                                <Select name='active'
                                    handleChange={search.handleChange}
                                    value={search.formData?.active ?? ''}
                                    options={[
                                        { value: 1, label: 'Active' },
                                        { value: 0, label: 'Inactive' }
                                    ]} />
                            </div>
                            <div className='col-6 mx-2'>
                                <SearchInput
                                    name='keywords'
                                    submit={getSupliers}
                                    value={search.formData?.keywords}
                                    handleChange={search.handleChange}
                                    placeholder='search by name' />
                            </div>
                        </div>}
                        add={() => {
                            setAddShow(true);
                            form.setIsEdit(false);
                        }}
                        loading={table.loading}
                        columns={columns}
                        data={table.data}
                        links={table.links}
                        onEdit={handleEdit}
                        onDelete={handleDelete}
                    />
                </div>
                <div>
                    {addShow ? <PopupLayout
                        loading={form.loading}
                        onClose={() => {
                            setAddShow(false);
                            form.setIsEdit(false);
                        }} title="Add new" onConfirm={form.isEdit ? update : submit}>
                        <div>
                            <div className='form-group'>
                                <label>Name</label>
                                <InputForm
                                    handleChange={form.handleChange}
                                    value={form.formData?.unit_name}
                                    errorMessage={form.formErrors?.unit_name}
                                    name='unit_name' placeholder='Unit name' />
                            </div>
                            <div className='row mt-1'>
                                <div className='form-group col-6'>
                                    <label>Email</label>
                                    <InputForm
                                        handleChange={form.handleChange}
                                        value={form.formData?.email}
                                        errorMessage={form.formErrors?.email}
                                        name='email' placeholder='Unit name' />
                                </div>
                                <div className='form-group col-6'>
                                    <label>Phone</label>
                                    <InputForm
                                        handleChange={form.handleChange}
                                        value={form.formData?.phone}
                                        errorMessage={form.formErrors?.phone}
                                        name='phone' placeholder='Unit name' />
                                </div>
                            </div>
                            <div className='form-group mt-1'>
                                <label>Address</label>
                                <TextArea
                                    handleChange={form.handleChange}
                                    value={form.formData?.address}
                                    errorMessage={form.formErrors?.address}
                                    name='address' placeholder='Address' />
                            </div>
                            <div className='form-group mt-1'>
                                <label>Tax code</label>
                                <InputForm
                                    handleChange={form.handleChange}
                                    value={form.formData?.tax_code}
                                    errorMessage={form.formErrors?.tax_code}
                                    name='tax_code' placeholder='Unit tax code' />
                            </div>
                            <div className='row mt-1'>
                                <div className='form-group col-6'>
                                    <label>Bank name</label>
                                    <InputForm
                                        handleChange={form.handleChange}
                                        value={form.formData?.bank_name}
                                        errorMessage={form.formErrors?.bank_name}
                                        name='bank_name' placeholder='Bank name' />
                                </div>
                                <div className='form-group col-6'>
                                    <label>Bank account</label>
                                    <InputForm
                                        handleChange={form.handleChange}
                                        value={form.formData?.bank_account}
                                        errorMessage={form.formErrors?.bank_account}
                                        name='bank_account' placeholder='Bank account number' />
                                </div>
                            </div>
                            <div className='form-group mt-1'>
                                <label>Website</label>
                                <InputForm
                                    handleChange={form.handleChange}
                                    value={form.formData?.website}
                                    errorMessage={form.formErrors?.website}
                                    name='website' placeholder='Website company' />
                            </div>
                            <div className='form-group mt-1'>
                                <label>Active</label>
                                <div className=''>
                                    <InputForm
                                        width={20}
                                        type='checkbox'
                                        handleChange={form.handleChange}
                                        value={form.formData?.active}
                                        errorMessage={form.formErrors?.active}
                                        name='active' />
                                </div>
                                <span className='text-warning'>
                                    If it is not active then you can not select on the purchases
                                </span>
                            </div>
                            <div className='form-group mt-1'>
                                <label>Note</label>
                                <TextArea
                                    handleChange={form.handleChange}
                                    value={form.formData?.note ?? ''}
                                    errorMessage={form.formErrors?.note}
                                    name='note' placeholder='Note information' />
                            </div>
                        </div>
                    </PopupLayout> : null}

                </div>
            </div>
        </DashboardLayout>
    );
}
