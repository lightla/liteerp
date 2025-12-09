import React, { useCallback, useState } from 'react'
import { InputForm } from '../../UI/Input/InputForm'
import TextArea from '../../UI/Input/Textarea'
import SearchSelect from '../../UI/Input/SearchSelect'
import ShippingService from '../../../services/ShippingService';
export default function FormUpdate({
    form = {
        formData: null,
        formErrors: null,
        handleChange: null,
        handleChangeByKey: null
    }
}) {
    const [shippings,setShippings] = useState([]);
    const getShippings = useCallback((keywords = '') => {
        ShippingService.list({
            page: 0,
            keywords: keywords
        })
            .then((resp) => {
                setShippings(resp.message.data);
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
        <div>
            <label>Receiver name</label>
            <InputForm
                errorMessage={form.formErrors?.receiver_name}
                value={form.formData?.receiver_name}
                name="receiver_name"
                handleChange={form.handleChange}
                type="text"
            />
        </div>
        <div>
            <label>Receiver phone</label>
            <InputForm
                errorMessage={form.formErrors?.receiver_phone}
                value={form.formData?.receiver_phone}
                name="receiver_phone"
                handleChange={form.handleChange}
                type="text"
            />
        </div>
        <div>
            <label>Receiver address</label>
            <TextArea
                errorMessage={form.formErrors?.receiver_address}
                value={form.formData?.receiver_address}
                name="receiver_address"
                handleChange={form.handleChange}
            />
        </div>
        <div>
            <label>Receiver note</label>
            <InputForm
                errorMessage={form.formErrors?.receiver_note}
                value={form.formData?.receiver_note}
                name="receiver_note"
                handleChange={form.handleChange}
                type="text"
            />
        </div>
        <div>
            <label>Shipping fee estimated</label>
            <InputForm
                errorMessage={form.formErrors?.shipping_fee_estimated}
                value={form.formData?.shipping_fee_estimated}
                name="shipping_fee_estimated"
                handleChange={form.handleChange}
                type="numeric"
            />
        </div>
        <div>
            <label>Shipping code</label>
            <InputForm
                errorMessage={form.formErrors?.shipping_code}
                value={form.formData?.shipping_code}
                name="shipping_code"
                handleChange={form.handleChange}
                type="text"
            />
        </div>
        <div>
            <label>Shipping fee actual</label>
            <InputForm
                errorMessage={form.formErrors?.shipping_fee_actual}
                value={form.formData?.shipping_fee_actual}
                name="shipping_fee_actual"
                handleChange={form.handleChange}
                type="numeric"
            />
        </div>
        <div>
            <label>Shipped at</label>
            <InputForm
                errorMessage={form.formErrors?.shipped_at}
                value={form.formData?.shipped_at}
                name="shipped_at"
                handleChange={form.handleChange}
                type="date"
            />
        </div>
        <div>
            <label>Delivered at</label>
            <InputForm
                errorMessage={form.formErrors?.delivered_at}
                value={form.formData?.delivered_at}
                name="delivered_at"
                handleChange={form.handleChange}
                type="date"
            />
        </div>
        <div>
            <label>Preferred unit</label>
            <SearchSelect
                search={getShippings}
                errorMessage={form.formErrors?.preferred_unit}
                value={form.formData?.preferred_unit}
                name="preferred_unit"
                handleChange={form.handleChangeByKey}
                options={shippings.map((item) => {
                    return {
                        value: item.id,
                        label: item.name
                    }
                })}
                defaultKeywords={form.formData?.preferred_unit_name}
            />
        </div>
    </div>
}