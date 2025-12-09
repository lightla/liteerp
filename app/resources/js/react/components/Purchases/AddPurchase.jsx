import React, { useCallback, useState } from 'react'
import FormStep from '../FormStep'
import { useNavigate } from 'react-router-dom';
import { usePopup } from '../popups/PopupContext';
import { useForm } from '../../libraries/handleInput';
import PrimaryButton from '../UI/Buttons/PrimaryButton'
import SecondaryButton from '../UI/Buttons/SecondaryButton';
import PurchaseService from '../../services/PurchaseService';
import PurchaseInformation from './EditPurchase/PurchaseInformation';
import PageHead from '../PageHead';
export default function AddPurchase() {
    const navigate = useNavigate();
    const { openPopup } = usePopup();
    
    const form = useForm();
    const create = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null);
        PurchaseService.add({
            ...form.formData
        })
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: "You has been created"
                });
                navigate('/purchases?form=edit&id=' + resp.message.id)
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
            });
    }, [form]);
    return <div>
        <PageHead 
                containerClass="mx-4"
                title='Add purchase'
                subtitle='Add new purchase'
                />
        <div className='mx-4 mt-3'>
            <FormStep list={[
                "Purchase information",
                "Add Products",
                "Send review",
                "Approve"
            ]} active={0} />
            <div className='theme-card p-4 shadow rounded-4'>
                <PurchaseInformation form={form}/>
            </div>
            <div className="row">
                <div className="col-2">
                    <SecondaryButton label='Back' />
                </div>
                <div className="col-2 ms-auto text-end">
                    <PrimaryButton loading={form.loading} onClick={create} label='Next' />
                </div>
            </div>


        </div>
    </div>
}