import React from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import PageHead from '../components/PageHead'
import { InputForm } from '../components/UI/Input/InputForm'
import { Select } from '../components/UI/Input/Select'
import PrimaryButton from '../components/UI/Buttons/PrimaryButton'
export default function Setting() {
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
                            <InputForm />
                        </div>
                        <div className='form-group col-6'>
                            <label>Company address</label>
                            <InputForm />
                        </div>
                    </div>
                    <div className='row mt-1'>
                        <div className='form-group col-6'>
                            <label>Phone</label>
                            <InputForm />
                        </div>
                        <div className='form-group col-6'>
                            <label>Email</label>
                            <InputForm />
                        </div>
                    </div>
                    <div className='row mt-1'>
                        <div className='form-group col-6'>
                            <label>Timezone</label>
                            <Select />
                        </div>
                        <div className='form-group col-6'>
                            <label>Language</label>
                            <Select />
                        </div>
                    </div>
                    <div className='row mt-1'>
                        <div className='form-group col-4'>
                            <label>Bank name</label>
                            <InputForm />
                        </div>
                        <div className='form-group col-4'>
                            <label>Bank account number</label>
                            <InputForm />
                        </div>
                        <div className='form-group col-4'>
                            <label>Bank account name</label>
                            <InputForm />
                        </div>
                    </div>
                    <div style={{
                        width: 200
                    }}>
                        <PrimaryButton 
                        label='Save change'
                        />
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
}