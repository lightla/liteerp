import React, { useCallback, useEffect, useMemo, useState } from 'react'
import CommonDataTable from '../CommonDataTable';
import ProductService from '../../services/ProductService';
import SearchInput from '../UI/Input/SearchInput';
import { useForm } from '../../libraries/handleInput';
import useTable from '../../libraries/handleTable';
import { PopupLayout } from '../../layouts/PopupLayout'
import { InputForm } from '../UI/Input/InputForm';
import { usePopup } from '../popups/PopupContext'
import PriceListService from '../../services/PriceListService';
import SearchSelect from '../UI/Input/SearchSelect';
import CustomerGroupService from '../../services/CustomerGroupService'
import Currency from '../../components/Currencies';
import { useSelector } from 'react-redux';
import RenderFormFieldByList from '../RenderFormFieldByList';
import RenderFieldTableByList from '../RenderFieldTableByList'
import { RenderTableSearch } from '../RenderTableSearch';
import PrimaryButton from '../UI/Buttons/PrimaryButton';
export default function PriceList() {
    const business = useSelector((state) => state.business.data);
    const { openPopup } = usePopup();
    const [showAdd, setShowAdd] = useState(false);
    const search = useForm();
    const form = useForm();
    const table = useTable();
    const [products, setProducts] = useState([]);
    const [groups, setGroups] = useState([]);
    const getPriceList = useCallback((page = 0) => {
        table.setLoading(true);
        PriceListService.list({
            page: page,
            ...search.formData
        })
            .then((resp) => {
                table.setData(resp.message.data)
                table.setLinks(resp.message.links)
                table.setLoading(false);
            })
            .catch((error) => {

            })
    }, [search.formData]);
    const getProducts = useCallback((keywords = '', callback = null) => {
        ProductService.list({
            page: 0,
            keywords: keywords
        })
            .then((resp) => {
                setProducts(resp.message.data);
                if (callback) {
                    callback();
                }
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
    const getGroup = useCallback((keywords = '', callback = null) => {
        CustomerGroupService.list({
            keywords: keywords,
            page: 0
        })
            .then((resp) => {
                setGroups(resp.message.data)
                if (callback) {
                    callback();
                }
            })
            .catch((error) => {

            })
    }, []);
    const submit = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        PriceListService.add(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been created'
                })
                setShowAdd(false);
                getPriceList();
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
        PriceListService.update(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                })
                setShowAdd(false);
                getPriceList(0);
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
        PriceListService.delete(row)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been deleted'
                });
                getPriceList();
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            })
    }, [form.formData]);
    const handleDelete = (row) => {
        openPopup({
            type: 'warning',
            message: 'Are you sure to delete?',
            onConfirm: () => {
                destroy(row)
            }
        })
    }
    const view = useCallback((row) => {
        PriceListService.view()
            .then((resp) => {
                form.setHookRender(resp.message.form)
                search.setHookRender(resp.message.search)
                table.addColums(resp.message.index,(item,data) => {
                    return <RenderFieldTableByList item={item} data={data}/>
                })
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
        getPriceList();
        view();
        table.setColums([
            { label: "ID", key: "id" },
            { label: "Name", key: "name" },
            {
                label: "Price", key: "price", render: (value) => {
                    return <strong>
                        <Currency amount={value} />
                    </strong>
                }
            },
            { label: "Customer Group", key: "group" }
        ]);
    }, [])
    const hasPermission = useMemo(() => {
        return business.role === 'manager'
            || business.role === 'admin' ? true : false
    }, [business]);
    return <div>
        <div className='mt-3'>
            <CommonDataTable
                loading={table.loading}
                filter={<div className='d-flex'>
                    
                    <div className='col-4'>
                        <label>Keywords</label>
                        <SearchInput
                            name='keywords'
                            value={search.formData?.keywords}
                            submit={getPriceList}
                            handleChange={search.handleChange}
                            placeholder='Search by name' />
                    </div>
                    {search.hookRender.map((item,index) => {
                        return <div className='col-4 ml-2' key={index}>
                            <RenderTableSearch item={item} search={search}/>
                        </div>
                    })}
                    <div className='col-2 ml-2'>
                        <PrimaryButton label='Search' onClick={() => getPriceList()} />
                    </div>
                </div>}
                add={!hasPermission ? null : () => {
                    setShowAdd(true);
                    form.setIsEdit(false);
                }}
                movePage={getPriceList}
                columns={table.colums}
                data={table?.data}
                links={table?.links}
                onEdit={!hasPermission ? null : (row) => {
                    form.setIsEdit(true);
                    form.setFormData(row);
                    setShowAdd(true)
                }}
                onDelete={!hasPermission ? null : handleDelete}
            />
            {showAdd ? <PopupLayout
                loading={form.loading}
                confirmText='Save'
                onConfirm={form.isEdit ? update : submit}
                onClose={() => setShowAdd(false)}
                title={form.isEdit ? 'Update Price' : 'Add Price'}>
                <div>
                    <div className='form-group'>
                        <label>Price</label>
                        <InputForm
                            errorMessage={form.formErrors?.price}
                            type='numeric'
                            value={form.formData?.price}
                            handleChange={form.handleChange} name='price' />
                    </div>
                    <div className='form-group mt-3'>
                        <label>Product</label>
                        <SearchSelect
                            name='product_id'
                            search={getProducts}
                            errorMessage={form.formErrors?.product_id}
                            value={form.formData?.product_id}
                            changeValue={form.handleChangeByKey}
                            options={products.map((item) => {
                                return {
                                    value: item.id,
                                    label: item.name
                                }
                            })}
                            defaultKeywords={form.formData?.name}
                        />
                    </div>
                    <div className='form-group mt-3'>
                        <label>Group</label>
                        <SearchSelect
                            name='customer_group_id'
                            search={getGroup}
                            errorMessage={form.formErrors?.customer_group_id}
                            value={form.formData?.customer_group_id}
                            changeValue={form.handleChangeByKey}
                            options={groups.map((item) => {
                                return {
                                    value: item.id,
                                    label: item.name
                                }
                            })}
                            defaultKeywords={form.formData?.group}
                        />
                    </div>
                    {form.hookRender.map((item,index) => {
                        return <div className='form-group mt-3' key={index}>
                            <RenderFormFieldByList item={item} form={form}/>
                        </div>
                    })}
                </div>
            </PopupLayout> : null}
        </div>
    </div>
}