import React, { useCallback, useEffect, useState } from 'react'
import CommonDataTable from '../CommonDataTable';
import useTable from '../../libraries/handleTable';
import { useForm } from '../../libraries/handleInput';
import { usePopup } from '../popups/PopupContext';
import { Select } from '../UI/Input/Select';
import SearchInput from '../UI/Input/SearchInput';
import { PopupLayout } from '../../layouts/PopupLayout';
import { InputForm } from '../UI/Input/InputForm';
import CustomerGroupService from '../../services/CustomerGroupService';
export default function ListGroup() {
    const table = useTable();
    const search = useForm();
    const { openPopup } = usePopup();
    const form = useForm();
    const [showAdd, setShowAdd] = useState(false);
    const columns = [
        { label: "ID", key: "id" },
        { label: "Name", key: "name" }
    ];

    const handleEdit = (row) => {
        console.log("Edit clicked:", row);
        form.setIsEdit(true);
        form.setFormData(row);
        setShowAdd(true)
    };

    
    const submit = useCallback(() => {
        form.setFormErrors(null);
        form.setLoading(true);
        CustomerGroupService.add(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been created'
                });
                setShowAdd(false);
                getGroup();
                form.setLoading(false);
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
                form.setLoading(false);
            })
    }, [form.formData]);
    const update = useCallback(() => {
        form.setFormErrors(null);
        form.setLoading(true);
        CustomerGroupService.update(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                });
                setShowAdd(false);
                getGroup();
                form.setLoading(false);
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
                form.setLoading(false);
            })
    }, [form.formData]);
    const getGroup = useCallback((page = 0) => {
        table.setLoading(true)
        CustomerGroupService.list({
            keywords: search.formData?.keywords ?? '',
            page: page,
            type: search.formData?.type ?? ''
        })
            .then((resp) => {
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
                table.setLoading(false)
            })
            .catch((error) => {

            })
    }, [search.formData]);
    const destroy = useCallback((row) => {
        CustomerGroupService.delete(row)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been deleted'
                });
                getGroup();
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
    const handleDelete = (row) => {
        openPopup({
            type: 'warning',
            message: 'Are you sure to delete?',
            onConfirm: () => {
                destroy(row)
            }
        })
    };
    useEffect(() => {
        getGroup();
    }, []);
    return <div>
        <CommonDataTable
            add={() => setShowAdd(true)}
            filter={<div className='d-flex'>
                <div className='mx-2 col-4'>
                    <label>Search</label>
                    <SearchInput
                        submit={getGroup}
                        placeholder='Search by customer name'
                        value={search.formData?.keywords}
                        name='keywords'
                        handleChange={search.handleChange}
                    />
                </div>
            </div>}
            movePage={getGroup}
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
                }} title={form.isEdit ? 'Update group' : 'Add group'}>
                <div>
                    <div className='form-group'>
                        <label>Name</label>
                        <InputForm name='name'
                            handleChange={form.handleChange}
                            value={form.formData?.name}
                            errorMessage={form.formErrors?.name}
                            placeholder='Group name' />
                    </div>
                </div>
            </PopupLayout> : null}

        </div>
    </div>
}