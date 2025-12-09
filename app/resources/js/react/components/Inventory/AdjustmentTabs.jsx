import React, { useCallback, useEffect, useState } from 'react'
import useTable from '../../libraries/handleTable';
import InventoryAdjustmentService from '../../services/InventoryAdjustmentService';
import CommonDataTable from '../CommonDataTable';
import SearchInput from '../UI/Input/SearchInput';
import ProductService from '../../services/ProductService';
import WarehouseService from '../../services/WarehouseService'
import { PopupLayout } from '../../layouts/PopupLayout';
import SearchSelect from '../UI/Input/SearchSelect';
import { InputForm } from '../UI/Input/InputForm';
import { useForm } from '../../libraries/handleInput';
import { usePopup } from '../popups/PopupContext';
import TextArea from '../UI/Input/Textarea';
import { isoToDateTime } from '../../libraries/common';
export default function AdjustmentTabs() {
    const table = useTable();
    const form = useForm();
    const {openPopup} = usePopup();
    const [products, setProducts] = useState([]);
    const [warehouses, setWarehouses] = useState([]);
    const [showForm, setShowForm] = useState(false);
    const search = useForm();
    const getAdjustment = useCallback((page = 0) => {
        table.setLoading(true);
        InventoryAdjustmentService.list({
            keywords: search.formData?.keywords ?? '',
            page: page
        })
            .then((resp) => {
                table.setLoading(false);
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
            })
    }, [search]);

    const getProducts = useCallback((keywords = '') => {
        ProductService.list({
            keywords: keywords,
            page: 0
        }).then((resp) => {
            setProducts(resp.message.data);
        })
            .catch((error) => {

            })
    }, []);
    const getWarehouses = useCallback((keywords = '') => {
        WarehouseService.list({
            keywords: '',
            page: 0
        }).then((resp) => {
            setWarehouses(resp.message.data);
        })
            .catch((error) => {

            })
    }, []);
    const add = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        InventoryAdjustmentService.add(form.formData)
        .then((resp) => {
            getAdjustment();
            openPopup({
                    type: 'success',
                    message: 'You has been added'
                })
            setShowForm(false);
            form.setFormData(null)
            form.setLoading(false)
        })
        .catch((error) => {
            if(error.response.data?.errors) {
                form.setFormErrors(error.response.data?.errors)
            }
            if(error.response.data?.message) {
                openPopup({
                    type: 'error',
                    message: error.response.data?.message
                })
            }
            form.setLoading(false)
        })
    }, [form.formData])
    useEffect(() => {
        getAdjustment();
    }, []);
    return <div>
        <CommonDataTable
            add={() => setShowForm(true)}
            filter={<div>
                <div className='row'>
                    <div className='col-6'>
                        <SearchInput submit={getAdjustment} 
                        name='keywords'
                        handleChange={search.handleChange}
                        value={search.formData?.keywords}
                        errorMessage={search?.formErrors?.keywords}
                        placeholder='Search by name' />
                    </div>
                </div>
            </div>}
            columns={[
                { key: "id", label: "ID" },
                { key: "product_name", label: "Name" },
                { key: "qty_adjusted", label: "Quantity", render:(quantity) => {
                    return quantity >= 1 ? <span>
                        <i class="bi bi-arrow-up-short text-success"></i> +{quantity}
                    </span> : <span>
                        <i class="bi bi-arrow-down-short text-danger"></i> {quantity}
                    </span>
                } },
                { key: "reason", label: "Reason" },
                { key: "warehouse", label: "Warehouse" },
                { key: "created_by", label: "Created by",render:(name) => {
                    return <span className='badge bg-primary'>{name}</span>
                } },
                { key: "created_at", label: "Created at",render:(date) => {
                    return <span className='badge bg-warning text-dark'>{isoToDateTime(date)}</span>
                } }
            ]}
            data={table.data}
            links={table.links}
            movePage={getAdjustment}
            loading={table.loading}
        />

        {showForm ? <PopupLayout
            loading={form.loading}
            onClose={() => {
                setShowForm(false);
                form.setFormData(null)
            }}
            onConfirm={add}
            title='Add adjustment'>
            <div>
                <div className='form-group'>
                    <label>Product</label>
                    <SearchSelect
                        name='product_id'
                        search={getProducts}
                        changeValue={form.handleChangeByKey}
                        value={form.formData?.product_id}
                        errorMessage={form.formErrors?.product_id}
                        options={products.map((item) => {
                            return {
                                value: item.id,
                                label: item.name
                            }
                        })}
                    />
                </div>
                <div className='form-group'>
                    <label>Warehouse</label>
                    <SearchSelect
                        name='warehouse_id'
                        search={getWarehouses}
                        value={form.formData?.warehouse_id}
                        changeValue={form.handleChangeByKey}
                        errorMessage={form.formErrors?.warehouse_id}
                        options={warehouses.map((item) => {
                            return {
                                value: item.id,
                                label: item.name
                            }
                        })}
                    />
                </div>
                <div className='form-group'>
                    <label>Quantity</label>
                    <InputForm
                        name='qty_adjusted'
                        value={form.formData?.qty_adjusted}
                        handleChange={form.handleChange}
                        errorMessage={form.formErrors?.qty_adjusted}
                    />
                </div>
                <div className='form-group'>
                    <label>Reason</label>
                    <TextArea
                        name='reason'
                        value={form.formData?.reason}
                        handleChange={form.handleChange}
                        errorMessage={form.formErrors?.reason}
                    />
                </div>
            </div>
        </PopupLayout> : null}

    </div>
}