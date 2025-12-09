import React, { useCallback, useEffect, useState } from 'react'
import CommonDataTable from '../CommonDataTable';
import ProductService from '../../services/ProductService';
import SearchInput from '../UI/Input/SearchInput';
import { useForm } from '../../libraries/handleInput';
import useTable from '../../libraries/handleTable';
import {PopupLayout} from '../../layouts/PopupLayout'
import { InputForm } from '../UI/Input/InputForm';
import TextArea from '../UI/Input/Textarea';
import {usePopup} from '../popups/PopupContext'
export default function Category() {
    const {openPopup} = usePopup();
    const [showAdd, setShowAdd] = useState(false);
    const search = useForm();
        const form = useForm();
    const tableCategory = useTable();
    const getCategorires = useCallback((page = 0) => {
        tableCategory.setLoading(true);
        ProductService.listCategory({
            page: page,
            keywords: search.formData?.keywords ?? ''
        })
            .then((resp) => {
                tableCategory.setData(resp.message.data)
                tableCategory.setLinks(resp.message.links)
                tableCategory.setLoading(false);
            })
            .catch((error) => {

            })
    }, [search.formData?.keywords]);
    const submit = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        ProductService.addCategory(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been created'
                })
                setShowAdd(false);
                getCategorires(0);
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
        ProductService.updateCategory(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                })
                setShowAdd(false);
                getCategorires(0);
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
    useEffect(() => {
        getCategorires();
    }, [])
    const columns = [
        { label: "ID", key: "id" },
        { label: "Name", key: "name" },
        { label: "Description", key: "description" },
        {
            label: "Created by", key: 'created_by_name', render: (name) => {
                return <span className='badge bg-primary'>{name}</span>
            }
        }
    ];
    return <div>
        <div className='mt-3'>
            <CommonDataTable
                loading={tableCategory.loading}
                filter={<div>
                    <div className='col-4'>
                        <SearchInput
                    name='keywords'
                    value={search.formData?.keywords}
                    submit={getCategorires}
                    handleChange={search.handleChange}
                    placeholder='Search by name' />
                    </div>
                </div>}
                add={() => {
                    setShowAdd(true);
                    form.setIsEdit(false);
                }}
                movePage={getCategorires}
                columns={columns}
                data={tableCategory?.data}
                links={tableCategory?.links}
                onEdit={(row) => { 
                    form.setIsEdit(true);
                    form.setFormData(row);
                    setShowAdd(true)
                }}
                onDelete={(row) => { 

                }}
            />
            {showAdd ? <PopupLayout
                loading={form.loading}
                confirmText='Save'
                onConfirm={ form.isEdit ? update : submit}
                onClose={() => setShowAdd(false)}
                title={form.isEdit ? 'Update Category' : 'Add category'}>
                <div>
                    <div className='form-group'>
                        <label>Name</label>
                        <InputForm
                            errorMessage={form.formErrors?.name}
                            type='text'
                            value={form.formData?.name}
                            handleChange={form.handleChange} name='name' />
                    </div>
                    <div className='form-group mt-3'>
                        <label>Description</label>
                        <TextArea
                            errorMessage={form.formErrors?.description}
                            value={form.formData?.description}
                            handleChange={form.handleChange} name='description'
                        />
                    </div>
                </div>
            </PopupLayout> : null}
        </div>
    </div>
}