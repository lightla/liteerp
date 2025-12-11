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
export default function PriceList() {
    const business = useSelector((state) => state.business.data);
    const { openPopup } = usePopup();
    const [showAdd, setShowAdd] = useState(false);
    const search = useForm();
        const form = useForm();
    const table = useTable();
    const [products,setProducts] = useState([]);
    const [groups,setGroups] = useState([]);
    const getPriceList = useCallback((page = 0) => {
        table.setLoading(true);
        PriceListService.list({
            page: page,
            keywords: search.formData?.keywords ?? ''
        })
            .then((resp) => {
                table.setData(resp.message.data)
                table.setLinks(resp.message.links)
                table.setLoading(false);
            })
            .catch((error) => {

            })
    }, [search.formData?.keywords]);
    const getProducts = useCallback((keywords = '') => {
        ProductService.list({
            page: 0,
            keywords: keywords
        })
            .then((resp) => {
                setProducts(resp.message.data);
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
    const getGroup = useCallback((keywords = '') => {
        CustomerGroupService.list({
            keywords: keywords,
            page: 0
        })
            .then((resp) => {
                setGroups(resp.message.data)
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
    const columns = [
        { label: "ID", key: "id" },
        { label: "Name", key: "name" },
        { label: "Price", key: "price", render: (value) => {
            return <strong>
                <Currency amount={value}/>
            </strong>
        } },
        { label: "Customer Group", key: "group" }
    ];
    useEffect(() => {
        getPriceList();
    },[])
    const hasPermission = useMemo(() => {
                return business.role === 'manager'
                    || business.role === 'admin' ? true : false
            },[business]);
    return <div>
        <div className='mt-3'>
            <CommonDataTable
                loading={table.loading}
                filter={<div>
                    <div className='col-4'>
                        <SearchInput
                            name='keywords'
                            value={search.formData?.keywords}
                            submit={getPriceList}
                            handleChange={search.handleChange}
                            placeholder='Search by name' />
                    </div>
                </div>}
                add={!hasPermission ? null : () => {
                    setShowAdd(true);
                    form.setIsEdit(false);
                }}
                movePage={getPriceList}
                columns={columns}
                data={table?.data}
                links={table?.links}
                onEdit={!hasPermission ? null : (row) => {
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
                </div>
            </PopupLayout> : null}
        </div>
    </div>
}