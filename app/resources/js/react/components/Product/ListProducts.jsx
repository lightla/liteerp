import React, { useCallback, useEffect, useState } from 'react'
import { formatMoney } from '../../libraries/common';
import ProductService from '../../services/ProductService';
import CommonDataTable from '../CommonDataTable';
import { Select } from '../UI/Input/Select'
import { InputForm } from '../UI/Input/InputForm';
import { useForm } from '../../libraries/handleInput';
import useTable from '../../libraries/handleTable';
import SearchInput from '../UI/Input/SearchInput';
import { PopupLayout } from '../../layouts/PopupLayout';
import { usePopup } from '../popups/PopupContext';
import SearchSelect from '../UI/Input/SearchSelect'
import TextArea from '../UI/Input/Textarea';
export default function ListProducts() {
    const { openPopup } = usePopup();
    const [showForm, setShowForm] = useState(false);
    const form = useForm();
    const search = useForm();
    const table = useTable();
    const [category, setCategory] = useState([]);
    const [selectCategory, setSelectCategory] = useState(null);
    const columns = [
        { label: "ID", key: "id" },
        { label: "Name", key: "name" },
        { label: "Category", key: "category.name" }
    ];
    const getProducts = useCallback((page = 0) => {
        table.setLoading(true)
        ProductService.list({
            active: search.formData?.active ?? 0,
            page: page,
            keywords: search.formData?.keywords ?? ''
        })
            .then((resp) => {
                table.setData(resp.message.data);
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
    }, [search]);
    const getCategories = useCallback((keywords = '') => {
        ProductService.listCategory({
            page: 0,
            keywords: keywords,
        })
            .then((resp) => {
                setCategory(resp.message.data);

            })
            .catch((error) => {

            })
    }, []);
    const update = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        ProductService.update({
            ...form.formData,
            category_id: selectCategory.value
        })
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                })
                getProducts();
                setShowForm(false);
                form.setLoading(false)
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
    }, [form.formData, selectCategory]);
    const create = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        ProductService.add(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                })
                getProducts();
                setShowForm(false);
                form.setLoading(false)
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
    }, [form.formData, selectCategory]);
    const handEdit = (row) => {
        setShowForm(true);
        form.setIsEdit(true);
        form.setFormData(row);
        getCategories(row.category.name);
        setSelectCategory({
            value: row.category.id,
            label: row.category.name
        })
    }
    useEffect(() => {
        getProducts();
    }, [search.formData?.active]);
    return <div className='mt-3'>
        <CommonDataTable
            add={() => {
                setShowForm(true);
                form.setIsEdit(false);
            }}
            filter={<div>
                <div className='d-flex'>
                    <div className='col-4'>
                        <label>Status</label>
                        <Select
                            name='active'
                            handleChange={search.handleChange}
                            errorMessage={search.formErrors?.active}
                            value={search.formData?.active ?? 0}
                            options={[
                                { value: 0, label: 'Waiting for sale' },
                                { value: 1, label: 'Ready for sale' }
                            ]} />
                    </div>
                    <div className='col-4 mx-2'>
                        <label>Search</label>
                        <SearchInput
                            submit={getProducts}
                            name='keywords'
                            handleChange={search.handleChange}
                            errorMessage={search.formErrors?.keywords}
                            value={search.formData?.keywords}
                        />
                    </div>
                </div>
            </div>}
            loading={table.loading}
            movePage={getProducts}
            columns={columns}
            data={table?.data}
            links={table?.links}
            onEdit={handEdit}
        //onDelete={(row) => {}}
        />
        <div>
            {showForm ? <PopupLayout
                loading={form.loading}
                onConfirm={ form.isEdit ? update : create}
                onClose={() => setShowForm(false)}
                title={ form.isEdit ? 'Update product' : 'Add product'}>
                <div>
                    <div className='form-group'>
                        <label>Name</label>
                        <InputForm
                            type='text'
                            name='name'
                            handleChange={form.handleChange}
                            value={form.formData?.name}
                            errorMessage={form.formErrors?.name}
                        />
                    </div>
                    <div className='form-group'>
                        <label>Sku</label>
                        <InputForm
                            type='text'
                            name='sku'
                            handleChange={form.handleChange}
                            value={form.formData?.sku}
                            errorMessage={form.formErrors?.sku}
                        />
                    </div>
                    <div className='form-group'>
                        <label>Unit</label>
                        <Select
                            name='unit'
                            handleChange={form.handleChange}
                            value={form.formData?.unit}
                            errorMessage={form.formErrors?.unit}
                            options={[
                                { value: "pcs", label: "pcs" },
                                { value: "set", label: 'set' },
                                { value: "box", label: 'box' },
                                { value: "carton", label: 'carton' },
                                { value: "bag", label: 'bag' },
                                { value: "pack", label: 'pack' },
                                { value: "roll", label: 'roll' }
                            ]}
                        />
                    </div>
                    <div className='form-group mt-3'>
                        <label>Category</label>
                        <SearchSelect
                            name='category_id'
                            changeValue={form.handleChangeByKey}
                            value={form.formData?.category_id}
                            errorMessage={form.formErrors?.category_id}
                            search={getCategories}
                            options={category.map((item) => {
                                return {
                                    value: item.id,
                                    label: item.name
                                }
                            })} />
                    </div>
                    <div className='form-group mt-3'>
                        <label>Description</label>
                        <TextArea
                            name='description'
                            handleChange={form.handleChange}
                            value={form.formData?.description}
                            errorMessage={form.formErrors?.description}
                            placeholder='Description'
                        />
                    </div>
                </div>
            </PopupLayout> : null}
        </div>
    </div>
}