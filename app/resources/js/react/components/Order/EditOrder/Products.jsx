import React, { useCallback, useEffect, useState } from 'react'
import ListProduct from './Products/ListProduct'
import ProductAdded from './Products/ProductAdded'
import { useForm } from '../../../libraries/handleInput'
import { PopupLayout } from '../../../layouts/PopupLayout'
import { InputForm } from '../../UI/Input/InputForm'
import OrderItemService from '../../../services/OrderItemService'
import { usePopup } from '../../popups/PopupContext'
import { useSearchParams } from 'react-router-dom'
import useTable from '../../../libraries/handleTable'
export default function Products({
    detail = null 
}) {
    const form = useForm();
    const [showForm, setShowForm] = useState(false);
    const [searchParams] = useSearchParams();
    const { openPopup } = usePopup();
    const add = useCallback((product) => {
        form.setFormData(product);
        setShowForm(true)
    }, [form]);
    const table = useTable();
    const addInventory = useCallback(() => {
        if (Number(form.formData?.buy_quantity ?? 0) === 0
            && Number(form.formData?.compensation_quantity ?? 0) === 0
            && Number(form.formData?.conversion_quantity ?? 0) === 0
            && Number(form.formData?.gift_quantity ?? 0) === 0) {
            openPopup({
                type: 'error',
                message: 'You need to choose at least 1 of the 4 options from buy, compensaction, conversion, gift'
            })
            return;
        }
        const submitData = {
            ...form.formData,
            order_id: searchParams.get('id'),
            inventory_id: form.formData?.id
        }
        OrderItemService.add(submitData)
            .then((resp) => {
                getOrderItem();
                openPopup({
                    type: 'success',
                    message: 'You has been added'
                })
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
            })
    }, [form.formData]);
    const getOrderItem = useCallback((page = 0) => {
        table.setLoading(true);
        OrderItemService.list({
            order_id: searchParams.get('id'),
            page: page
        })
            .then((resp) => {
                table.setData(resp.message.data);
                table.setLoading(false);
            })
            .catch((error) => {

            })
    }, [searchParams]);
    useEffect(() => {
        getOrderItem();
    }, [])
    return <div>
        <ProductAdded table={table} />
        <ListProduct detail={detail} add={add} />
        <div>
            {showForm ? <PopupLayout
                onClose={() => setShowForm(false)}
                title='Add product into order' onConfirm={addInventory}>
                <div>
                    <div>
                        <div className='row'>
                            <div className='form-group col-6'>
                                <label>Discount(%)</label>
                                <InputForm handleChange={form.handleChange}
                                    name='discount' value={form.formData?.discount}
                                    errorMessage={form.formErrors?.discount} />
                            </div>
                            <div className='form-group col-6'>
                                <label>Buy quantity</label>
                                <InputForm handleChange={form.handleChange}
                                    name='buy_quantity' value={form.formData?.buy_quantity}
                                    errorMessage={form.formErrors?.buy_quantity} />
                            </div>
                        </div>
                        <div className='row mt-3'>
                            <div className='form-group col-6'>
                                <label>Gift quantity</label>
                                <InputForm handleChange={form.handleChange}
                                    name='gift_quantity' value={form.formData?.gift_quantity}
                                    errorMessage={form.formErrors?.gift_quantity} />
                            </div>
                            <div className='form-group col-6'>
                                <label>Compensation quantity</label>
                                <InputForm handleChange={form.handleChange}
                                    name='compensation_quantity' value={form.formData?.compensation_quantity}
                                    errorMessage={form.formErrors?.compensation_quantity} />
                            </div>
                        </div>
                        <div className='row mt-3'>
                            <div className='form-group col-6'>
                                <label>Conversion quantity</label>
                                <InputForm handleChange={form.handleChange}
                                    name='conversion_quantity' value={form.formData?.conversion_quantity}
                                    errorMessage={form.formErrors?.conversion_quantity} />
                            </div>
                            <div className='form-group col-6'>
                                <label>Price</label>
                                <InputForm handleChange={form.handleChange}
                                    name='price' 
                                    value={form.formData?.price}
                                    errorMessage={form.formErrors?.price} />
                            </div>
                        </div>
                    </div>
                </div>
            </PopupLayout> : null}

        </div>
    </div>
}