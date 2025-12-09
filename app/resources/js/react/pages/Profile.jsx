import React, { useCallback, useEffect } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import PageHead from '../components/PageHead'
import { InputForm } from '../components/UI/Input/InputForm'
import AuthencationService from '../services/AuthencationService';
import { useForm } from '../libraries/handleInput';
import PrimaryButton from '../components/UI/Buttons/PrimaryButton';
import TextArea from '../components/UI/Input/Textarea'
import {usePopup} from '../components/popups/PopupContext'
export default function Profile(){
    const {openPopup} = usePopup();
    const form = useForm();
    const profile = useCallback(() => {
        form.setLoading(true);
        AuthencationService.getProfile()
        .then((resp) => {
            form.setFormData(resp.message)
            form.setLoading(false);
        })
        .catch((error) => {
            form.setLoading(false);
        })
    },[]);
    const update = useCallback(() => {
        form.setFormErrors(null)
        form.setLoading(true);
        AuthencationService.updateProfile(form.formData)
        .then((resp) => {
            openPopup({
                    type: 'success',
                    message: 'You has been added'
                })
                form.setLoading(false);
                form.handleChangeByKey('password',null);
                form.handleChangeByKey('new_password',null)
        })
        .catch((error) => {
            form.setLoading(false);
            if(error.response?.data.message) {
                openPopup({
                    type: 'error',
                    message: error.response?.data.message
                })
            }
            if(error.response?.data.errors) {
                form.setFormErrors(error.response?.data.errors)
            }
        })
    },[form.formData]);
    useEffect(() => {
        profile();
    },[])
    return <DashboardLayout>
        <div>
            <PageHead
            title='Profile'
            subtitle='Update your information'
            />
            <div className='container mt-3'>
                <div className='card rounded-3 p-4 shadow-sm theme-sidebar-bg theme-title'>
                    <div className='row'>
                        <div className='col-6'>
                            <label>Name</label>
                            <InputForm
                            name='name'
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.name}
                            value={form.formData?.name}
                            />
                        </div>
                        <div className='col-6'>
                            <label>Email</label>
                            <InputForm
                            name='email'
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.email}
                            value={form.formData?.email}
                            />
                        </div>
                    </div>
                    <div className='row mt-1'>
                        <div className='col-4'>
                            <label>Phone</label>
                            <InputForm
                            name='phone'
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.phone}
                            value={form.formData?.phone}
                            />
                        </div>
                        <div className='col-4'>
                            <label>Password</label>
                            <InputForm
                            type='password'
                            name='password'
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.password}
                            value={form.formData?.password}
                            />
                        </div>
                        <div className='col-4'>
                            <label>New password</label>
                            <InputForm
                            type='password'
                            name='new_password'
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.new_password}
                            value={form.formData?.new_password}
                            />
                        </div>
                    </div>
                    <div className='row mt-1'>
                        <label>Bio</label>
                            <TextArea
                            name='bio'
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.bio}
                            value={form.formData?.bio ?? ''}
                            />
                    </div>
                    <div className='row mt-1'>
                        <label>Avatar</label>
                        <div className=''>
                            <img width={75} height={75} 
                                src={form.formData?.avatar ?? '/assets/icons/avatar-default.png'} alt=''/>
                        </div>
                    </div>
                    <div className='row mt-1'>
                        <div style={{
                            width: 200
                        }}>
                            <PrimaryButton
                            onClick={update}
                            label='Submit'
                            loading={form.loading}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
}