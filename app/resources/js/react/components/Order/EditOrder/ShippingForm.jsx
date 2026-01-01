import React, { useCallback, useEffect, useMemo, useRef, useState } from 'react'
import { usePopup } from '../../popups/PopupContext';
import { InputForm } from '../../UI/Input/InputForm';
import SearchSelect from '../../UI/Input/SearchSelect';
import ShippingService from '../../../services/ShippingService';
import RenderFormFieldByList from '../../RenderFormFieldByList';
export default function ShippingForm({
    form = {
        formData: null,
        formErrors: null,
        handleChange: null,
        handleChangeByKey: null
    }
}) {
    const disabled = false;
    const { openPopup } = usePopup();
    //const form = useForm();
    const [shippings, setShippings] = useState([]);
    const getShippings = useCallback((keywords = '', callback = null) => {
        ShippingService.list({
            page: 0,
            keywords: keywords
        })
            .then((resp) => {
                setShippings(resp.message.data);
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
    return <div>
        <h2 className='h5'>Shipping information</h2>
        <div className='row  mt-3'>
            <div className='form-group col-4'>
                <label>Receiver name</label>
                <InputForm
                    disabled={disabled}
                    value={form.formData?.receiver_name}
                    handleChange={form.handleChange}
                    name='receiver_name'
                    errorMessage={form.formErrors?.receiver_name}
                    type='text'
                />
            </div>
            <div className='form-group col-4'>
                <label>Receiver phone</label>
                <InputForm
                    disabled={disabled}
                    value={form.formData?.receiver_phone}
                    handleChange={form.handleChange}
                    name='receiver_phone'
                    errorMessage={form.formErrors?.receiver_phone}
                    type='text'
                />
            </div>
            <div className='form-group col-4'>
                <label>Shipping fee estimated</label>
                <InputForm
                    disabled={disabled}
                    value={form.formData?.shipping_fee_estimated}
                    handleChange={form.handleChange}
                    name='shipping_fee_estimated'
                    errorMessage={form.formErrors?.shipping_fee_estimated}
                    type='number'
                />
            </div>
        </div>
        <div className='form-group mt-3'>
            <label>Receiver address</label>
            <InputForm
                disabled={disabled}
                value={form.formData?.receiver_address}
                handleChange={form.handleChange}
                name='receiver_address'
                errorMessage={form.formErrors?.receiver_address}
                type='text'
            />
        </div>
        <div className='form-group mt-3'>
            <label>Receiver note</label>
            <InputForm
                disabled={disabled}
                value={form.formData?.receiver_note}
                handleChange={form.handleChange}
                name='receiver_note'
                errorMessage={form.formErrors?.receiver_note}
                type='text'
            />
        </div>
        <div className='form-group mt-3'>
            <label>Preferred unit </label>

            <SearchSelect
                errorMessage={form.formErrors?.preferred_unit}
                disabled={disabled}
                value={form.formData?.preferred_unit}
                search={getShippings}
                options={shippings?.map((item) => {
                    return {
                        value: item.id,
                        label: item.name
                    }
                })}
                changeValue={form.handleChangeByKey}
                name='preferred_unit'
                defaultKeywords={form.formData?.shipping_provider_name ?? ''}
            />
        </div>
        {form.hookRender.map((item,index) => {
            return <div className='form-group mt-3' key={index}>
                <RenderFormFieldByList item={item} form={form}/>
            </div>
        })}        
    </div>
}