import React, { useCallback, useEffect } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import PageHead from '../components/PageHead'
import { InputForm } from '../components/UI/Input/InputForm'
import { Select } from '../components/UI/Input/Select'
import PrimaryButton from '../components/UI/Buttons/PrimaryButton'
import businessService from '../services/businessService'
import {useForm} from '../libraries/handleInput'
import { useDispatch, useSelector } from 'react-redux'
import {usePopup} from '../components/popups/PopupContext'
import { setBusinessInfo } from '../redux/businessInfoSlice'
export default function Setting() {
    const dispatch = useDispatch();
    const business = useSelector((state) => state.business.data);
    const form = useForm();
    const {openPopup} = usePopup();
    const update = useCallback(() => {
        form.setLoading(true)
        businessService.update(form.formData)
        .then((resp) => {
            form.setLoading(false);
            getDetail();
            openPopup({
                    type: 'success',
                    message: 'You has been updated'
                })
        })
        .catch((error) => {
            form.setLoading(false);
            if(error.response?.data?.errors) {
                form.setFormErrors(error.response?.data?.errors)
            }
            if(error.response?.data?.message) {
                openPopup({
                    type: 'error',
                    message: error.response?.data?.message
                })
            }
        })
    },[form.formData]);
    const getDetail = useCallback(() => {
        form.setLoading(true)
        businessService.show(business?.id)
        .then((resp) => {
            form.setLoading(false)
            form.setFormData(resp.message.business);
            localStorage.setItem('business-access', resp.message.token);
            localStorage.setItem('business', JSON.stringify(resp.message.business));
            dispatch(setBusinessInfo(resp.message.business))
        })
        .catch((error) => {
            form.setLoading(false)
        })
    },[]);
    useEffect(() => {
        getDetail();
    },[]);
    return <DashboardLayout>
        <div>
            <PageHead
                title='Settings'
                subtitle='All setting of business'
            />
            <div className='container mt-3'>
                <div className='card rounded-3 p-4 shadow-sm theme-sidebar-bg theme-title'>
                    <h4>Information</h4>
                    <div className='row'>
                        <div className='form-group col-6'>
                            <label>Company name</label>
                            <InputForm 
                            name='name'
                            errorMessage={form.formErrors?.name}
                            value={form.formData?.name}
                            handleChange={form.handleChange}
                            />
                        </div>
                        <div className='form-group col-6'>
                            <label>Company address</label>
                            <InputForm 
                            name='address'
                            errorMessage={form.formErrors?.address}
                            value={form.formData?.address}
                            handleChange={form.handleChange}
                            />
                        </div>
                    </div>
                    <div className='row mt-1'>
                        <div className='form-group col-4'>
                            <label>Phone</label>
                            <InputForm 
                            name='phone'
                            errorMessage={form.formErrors?.phone}
                            value={form.formData?.phone}
                            handleChange={form.handleChange}
                            />
                        </div>
                        <div className='form-group col-4'>
                            <label>Email</label>
                            <InputForm 
                            name='email'
                            errorMessage={form.formErrors?.email}
                            value={form.formData?.email}
                            handleChange={form.handleChange}
                            />
                        </div>
                        <div className='form-group col-4'>
                            <label>Tax code</label>
                            <InputForm 
                            name='tax_code'
                            errorMessage={form.formErrors?.tax_code}
                            value={form.formData?.tax_code}
                            handleChange={form.handleChange}
                            />
                        </div>
                    </div>
                    <div className='row mt-1'>
                        <div className='form-group col-4'>
                            <label>Bank name</label>
                            <InputForm 
                            name='bank_name'
                            errorMessage={form.formErrors?.bank_name}
                            value={form.formData?.bank_name}
                            handleChange={form.handleChange}
                            />
                        </div>
                        <div className='form-group col-4'>
                            <label>Bank account number</label>
                            <InputForm 
                            name='bank_account_number'
                            errorMessage={form.formErrors?.bank_account_number}
                            value={form.formData?.bank_account_number}
                            handleChange={form.handleChange}
                            />
                        </div>
                        <div className='form-group col-4'>
                            <label>Bank account name</label>
                            <InputForm 
                            name='bank_account_name'
                            errorMessage={form.formErrors?.bank_account_name}
                            value={form.formData?.bank_account_name}
                            handleChange={form.handleChange}
                            />
                        </div>
                    </div>
                    <div style={{
                        width: 200
                    }}>
                        <PrimaryButton 
                        loading={form.loading}
                        onClick={update}
                        label='Save change'
                        />
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
}