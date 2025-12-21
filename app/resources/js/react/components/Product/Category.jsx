import React, { useCallback, useEffect, useMemo, useRef, useState } from 'react'
import CommonDataTable from '../CommonDataTable';
import ProductService from '../../services/ProductService';
import SearchInput from '../UI/Input/SearchInput';
import { useForm } from '../../libraries/handleInput';
import useTable from '../../libraries/handleTable';
import { PopupLayout } from '../../layouts/PopupLayout'
import { InputForm } from '../UI/Input/InputForm';
import TextArea from '../UI/Input/Textarea';
import { usePopup } from '../popups/PopupContext'
import { useSelector } from 'react-redux';
import TabsCommon from '../TabsCustom';
import PrimaryButton from '../UI/Buttons/PrimaryButton'
import { Select } from '../UI/Input/Select';
export default function Category() {
    const business = useSelector((state) => state.business.data);
    const [attributes, setAttributes] = useState([]);
    const attrAddForm = useForm();
    const attrForm = useForm();
    const { openPopup } = usePopup();
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
    
    const resetAttribute = () => {
        setAttributes([]);
        attrForm.setFormData(null)
    }
    const submit = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        ProductService.addCategory({
            ...form.formData,
            attributes: attributes.map((item) => {
                return {
                    ...item,
                    value: attrForm.formData?.[item.key] ?? ''
                }
            })
        })
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been created'
                })
                setShowAdd(false);
                getCategorires(0);
                form.setLoading(false)
                resetAttribute();
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
    }, [form.formData, attributes, attrForm.formData]);
    const update = useCallback(() => {
        form.setFormErrors(null);
        form.setLoading(true)
        ProductService.updateCategory({
            ...form.formData,
            attributes: attributes.map((item) => {
                return {
                    ...item,
                    value: attrForm.formData?.[item.key] ?? ''
                }
            })
        })
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                })
                setShowAdd(false);
                getCategorires(0);
                form.setLoading(false)
                resetAttribute();
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
    }, [form.formData, attributes, attrForm.formData]);
    const destroy = useCallback((row) => {
        ProductService.deleteCategory(row)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been deleted'
                })
                getCategorires();
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
    const handleDelete = useCallback((row) => {
        openPopup({
            type: 'warning',
            message: 'Are you sure to delete?',
            onConfirm: () => {
                destroy(row)
            }
        })
    }, [])
    const handleEdit = useCallback((row) => {
        form.setIsEdit(true);
        form.setFormData(row);
        setShowAdd(true)
        row.attributes.map((item) => {
            setAttributes((pre) => {
                return [
                    ...pre,
                    item
                ]
            });
            attrForm.handleChangeByKey(item.key, item.value)
        })
    }, [attrForm])
    const addAttribute = () => {
        if (attrAddForm.formData?.type === '' || !attrAddForm.formData?.type) {
            return openPopup({
                type: 'error',
                message: 'You are not select type'
            })
        }
        if (attrAddForm.formData?.key === '' || !attrAddForm.formData?.key) {
            return openPopup({
                type: 'error',
                message: 'You are not insert attribute name'
            })
        } else {
            if (attrAddForm.formData?.key?.toString().length >= 50) {
                return openPopup({
                    type: 'error',
                    message: 'Attribute name shuold not greater than 50 characters'
                })
            }
        }
        setAttributes(prev => {
            if (prev.find((item) => item?.key === attrAddForm.formData?.key)) {
                openPopup({
                    type: 'error',
                    message: 'This attribute has been used'
                })
                return prev;
            }
            if(prev.length >= 10) {
                openPopup({
                    type: 'error',
                    message: 'You have reached your limit'
                })
                return prev;
            }
            return [...prev, attrAddForm.formData]
        });
        attrAddForm.setFormData(null)
    };
    const removeAttribute = (attr) => {
        setAttributes(prev =>
            prev.filter(item => item.key !== attr.key)
        );
    };
    useEffect(() => {
        getCategorires();
    }, [])
    const columns = [
        { label: "ID", key: "id" },
        { label: "Name", key: "name" },
        {
            label: "Tax(%)", key: "tax", render: (value) => {
                return value
            }
        },
        { label: "Description", key: "description" },
        {
            label: "Created by", key: 'created_by_name', render: (name) => {
                return <span className='badge bg-primary'>{name}</span>
            }
        }
    ];
    const hasPermission = useMemo(() => {
        return business.role === 'manager'
            || business.role === 'admin' ? true : false
    }, [business]);
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
                add={!hasPermission ? null : () => {
                    setShowAdd(true);
                    form.setIsEdit(false);
                }}
                movePage={getCategorires}
                columns={columns}
                data={tableCategory?.data}
                links={tableCategory?.links}
                onEdit={!hasPermission ? null : handleEdit}
                onDelete={!hasPermission ? null : handleDelete}
            />
            {showAdd ? <PopupLayout
                loading={form.loading}
                confirmText='Save'
                onConfirm={form.isEdit ? update : submit}
                onClose={() => {
                    setShowAdd(false);
                    resetAttribute();
                }
                }
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
                        <label>Tax(%)</label>
                        <InputForm
                            errorMessage={form.formErrors?.tax}
                            type='number'
                            value={form.formData?.tax}
                            handleChange={form.handleChange} name='tax' />
                    </div>
                    <div className='form-group mt-3'>
                        <label>Description</label>
                        <TextArea
                            errorMessage={form.formErrors?.description}
                            value={form.formData?.description}
                            handleChange={form.handleChange} name='description'
                        />
                    </div>
                    {attributes?.map((item, index) => {
                        return <div className='form-group mt-3' key={index}>
                            <label className='text-capitalize'>{item?.key}</label>
                            <div className='row d-flex align-items-center'>
                                <div className='col-11'>
                                    {item?.type !== "textarea" ? <InputForm
                                        errorMessage={form.formErrors?.[`attributes.${index}.value`]}
                                        type={item?.type}
                                        value={attrForm.formData?.[item?.key]}
                                        handleChange={attrForm.handleChange} name={item?.key} />
                                        : <TextArea
                                            errorMessage={form.formErrors?.[`attributes.${index}.value`]}
                                            value={attrForm.formData?.[item?.key]}
                                            handleChange={attrForm.handleChange} name={item?.key}
                                        />}
                                </div>
                                <div className='col-1' onClick={() => removeAttribute(item)}>
                                    <i className="bi bi-x"></i>
                                </div>
                            </div>
                        </div>
                    })}
                    <div className='row mt-3'>
                        <h4 className='h6'>Attributes</h4>
                        <p>This is a part expanding for category, you can add maxium 10 fields for product on this category</p>
                        <div className='col-6'>
                            <label>Attribute name</label>
                            <InputForm
                                errorMessage={attrAddForm.formErrors?.key}
                                type='text'
                                value={attrAddForm.formData?.key}
                                handleChange={attrAddForm.handleChange} name='key' />
                        </div>
                        <div className='col-3'>
                            <label>Type</label>
                            <Select
                                errorMessage={attrAddForm.formErrors?.type}
                                value={attrAddForm.formData?.type}
                                handleChange={attrAddForm.handleChange} name='type'
                                options={[
                                    { value: 'number', label: 'Number' },
                                    { value: 'text', label: 'Character' },
                                    { value: 'textarea', label: 'Long text' },
                                    { value: 'date', label: 'Date' }
                                ]}
                            />
                        </div>
                        <div className='col-3'>
                            <PrimaryButton loading={form.loading} onClick={addAttribute} label='Add' />
                        </div>
                    </div>
                </div>
            </PopupLayout> : null}
        </div>
    </div>
}