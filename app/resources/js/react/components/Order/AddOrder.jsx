import React, { useCallback, useState } from 'react'
import PageHead from '../PageHead'
import FormStep from '../FormStep'
import CustomerService from '../../services/CustomerService';
import { useForm } from '../../libraries/handleInput';
import SearchSelect from '../UI/Input/SearchSelect';
import { Select } from '../UI/Input/Select';
import { InputForm } from '../UI/Input/InputForm';
import TextArea from '../UI/Input/Textarea';
import SecondaryButton from '../UI/Buttons/SecondaryButton';
import PrimaryButton from '../UI/Buttons/PrimaryButton';
import OrderService from '../../services/OrderService';
import { useNavigate } from 'react-router-dom';
import { usePopup } from '../popups/PopupContext';
import CustomerInformation from './EditOrder/CustomerInformation';
export default function AddOrder() {
    const form = useForm(null);
    const {openPopup} = usePopup();
    const navigate = useNavigate();
    const create = useCallback(() => {
        form.setFormErrors(null);
        OrderService.add(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been created',
                    onCancel: () => {
                        navigate('/orders?form=edit&id=' + resp.message.id);
                    }
                })
            })
            .catch((error) => {
                if (error.response?.data?.errors) {
                    form.setFormErrors(error.response.data?.errors)
                }
                if (error.response?.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            })
    }, [form.formData]);
    return <div>
        <PageHead title='Order' subtitle='Add new order' />
        <div className='container mt-3'>
            <FormStep list={["Customer & Order", "Products","Shipping", "Complete","Print"]} />
            <div className='theme-card p-3 rounded-4'>
                <CustomerInformation form={form}/>
            </div>
            <div className="row">
                <div className="col-2">
                    <SecondaryButton label='Back' />
                </div>
                <div className="col-2 ms-auto text-end">
                    <PrimaryButton onClick={create} label='Next' />
                </div>
            </div>
        </div>
    </div>
}