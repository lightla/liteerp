import React, { useCallback, useEffect, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import CommonDataTable from '../components/CommonDataTable';
import PrimaryButton from '../components/UI/Buttons/PrimaryButton';
import { PopupLayout } from '../layouts/PopupLayout';
import { InputForm } from '../components/UI/Input/InputForm';
import { Select } from '../components/UI/Input/Select';
import ShippingService from '../services/ShippingService'
import { usePopup } from '../components/popups/PopupContext';
import useTable from '../libraries/handleTable';
import { useForm } from '../libraries/handleInput';
import SearchInput from '../components/UI/Input/SearchInput';
import PageHead from '../components/PageHead';
import FlatIcon32 from '../components/UI/FlatIcons/FlatIcon32'
export default function Shipping() {
    const { openPopup } = usePopup();
    const table = useTable();
    const form = useForm();
    const search = useForm();
    const [showAdd, setShowAdd] = useState(false);
    const columns = [
        {
            label: "Logo", key: "logo", render: (value) => {
                return value ? <img width={45} height={45} src={value} alt='' /> :
                    <FlatIcon32/>
            }
        },
        { label: "ID", key: "id" },
        { label: "Name", key: "name" },
        { label: "Code", key: "code" },
        {
            label: "Status", key: "active", render: (active) => {
                return active ? <span className='badge bg-success'>
                    Working
                </span> : <span className='badge bg-secondary'>
                    Stop
                </span>
            }
        }
    ];
    const handEdit = (row) => {
        form.setFormData(row);
        form.setIsEdit(true);
        setShowAdd(true);
    }
    const handDelete = (row) => {

    }
    const submit = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        ShippingService.add(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been created'
                })
                getShippings();
                setShowAdd(false);
                form.setFormErrors(null)
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
        form.setLoading(true)
        form.setFormErrors(null);
        ShippingService.update(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been created'
                })
                getShippings();
                setShowAdd(false);
                form.setFormErrors(null)
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
    const getShippings = useCallback((page = 0) => {
        table.setLoading(true)
        ShippingService.list({
            page: page,
            keywords: form.formData?.keywords ?? ''
        })
            .then((resp) => {
                table.setData(resp.message.data)
                table.setLinks(resp.message.links);
                table.setLoading(false)
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            })
    }, [table, form.formData?.keywords]);
    useEffect(() => {
        getShippings();
    }, []);
    return <DashboardLayout>
        <div>
            <PageHead
                title='Shippings'
                subtitle='Manager unit provider service shipping'
            />
            <div className='container mt-4'>
                <CommonDataTable
                    add={() => {
                        setShowAdd(true);
                        form.setIsEdit(false);
                    }}
                    filter={<div>
                        <div>
                            <label>Keywords</label>
                            <SearchInput
                                submit={getShippings}
                                name='keywords'
                                handleChange={search.handleChange}
                                value={search.formData?.keywords}
                            />
                        </div>
                    </div>}
                    loading={table.loading}
                    movePage={getShippings}
                    data={table.data}
                    links={table.links}
                    columns={columns}
                    onEdit={handEdit} onDelete={handEdit} />
            </div>
            <div>
                {showAdd ? <PopupLayout
                    loading={form.loading}
                    confirmText='Save'
                    onClose={() => {
                        setShowAdd(false);
                        form.setIsEdit(false);
                    }}
                    onConfirm={form.isEdit ? update : submit} title={form.isEdit ? 'Update shipping unit' : 'Add shipping unit'}>
                    <div>
                        <div className='form-group mt-3'>
                            <label>Name</label>
                            <InputForm
                                type='text'
                                placeholder='Name unit'
                                name='name'
                                handleChange={form.handleChange}
                                errorMessage={form.formErrors?.name}
                                value={form.formData?.name} />
                        </div>
                        <div className='form-group mt-3'>
                            <label>Code</label>
                            <InputForm
                                type='text'
                                placeholder='Code unit'
                                name='code'
                                handleChange={form.handleChange}
                                errorMessage={form.formErrors?.code}
                                value={form.formData?.code} />
                        </div>
                        <div className='form-group mt-3'>
                            <label>Logo</label>
                            <InputForm
                                type='file'
                                name='logo'
                                handleChange={form.handleChange}
                                errorMessage={form.formErrors?.logo}
                                value={form.formData?.logo} />
                        </div>
                        <div className='form-group mt-3'>
                            <label>This is status for working</label>
                            <div className='d-flex'>
                                <InputForm
                                    width={20}
                                    name='active'
                                    handleChange={form.handleChange}
                                    errorMessage={form.formErrors?.active}
                                    value={form.formData?.active}
                                    type='checkbox'
                                />
                            </div>
                        </div>
                    </div>
                </PopupLayout> : null}

            </div>
        </div>
    </DashboardLayout>
}