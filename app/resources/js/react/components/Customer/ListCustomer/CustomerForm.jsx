import React, { useCallback, useState } from 'react'
import { InputForm } from '../../UI/Input/InputForm'
import { Select } from '../../UI/Input/Select'
import TextArea from '../../UI/Input/Textarea'
import useTable from '../../../libraries/handleTable'
import SearchSelect from '../../UI/Input/SearchSelect'
import CustomerGroupService from '../../../services/CustomerGroupService'
export default function CustomerForm({
    form = {
        handleChange: null,
        formErrors: null,
        handleChangeByKey: null,
        formData: null
    }
}) {
    const [group, setGroup] = useState([]);
    const getCustomers = useCallback((keywords = '', calblack = null) => {
        CustomerGroupService.list({
            keywords: keywords,
            page: 0
        })
            .then((resp) => {
                setGroup(resp.message.data);
                if (calblack) {
                    calblack();
                }
            })
            .catch((error) => {

            })
    }, []);
    return <div>
        <div>
            <div className='form-group'>
                <label>Name</label>
                <InputForm name='name'
                    handleChange={form.handleChange}
                    value={form.formData?.name}
                    errorMessage={form.formErrors?.name}
                    placeholder='customer name' />
            </div>
            <div className='row mt-2'>
                <div className='form-group col-6'>
                    <label>Contact name</label>
                    <InputForm name='contact_name'
                        handleChange={form.handleChange}
                        value={form.formData?.contact_name}
                        errorMessage={form.formErrors?.contact_name}
                        placeholder='Contact name' />
                </div>
                <div className='form-group col-6'>
                    <label>Email</label>
                    <InputForm name='email'
                        handleChange={form.handleChange}
                        value={form.formData?.email}
                        errorMessage={form.formErrors?.email}
                        placeholder='Email' />
                </div>
            </div>
            <div className='row mt-2'>
                <div className='form-group col-6'>
                    <label>Phone</label>
                    <InputForm name='phone'
                        handleChange={form.handleChange}
                        value={form.formData?.phone}
                        errorMessage={form.formErrors?.phone} placeholder='Number phone contact' />
                </div>
                <div className='form-group col-6'>
                    <label>Tax code</label>
                    <InputForm name='tax_code'
                        handleChange={form.handleChange}
                        value={form.formData?.tax_code}
                        errorMessage={form.formErrors?.tax_code} placeholder='Tax code number' />
                </div>
            </div>
            <div className='form-group mt-2'>
                <label>Bank name</label>
                <InputForm name='bank_name'
                    handleChange={form.handleChange}
                    value={form.formData?.bank_name}
                    errorMessage={form.formErrors?.bank_name} placeholder='Bank name' />
            </div>
            <div className='form-group mt-2'>
                <label>Bank account</label>
                <InputForm name='bank_account'
                    handleChange={form.handleChange}
                    value={form.formData?.bank_account}
                    errorMessage={form.formErrors?.bank_account} placeholder='Bank account' />
            </div>
            <div className='row mt-2'>
                <div className='form-group col-6'>
                    <label>Type</label>
                    <Select name='type'
                        handleChange={form.handleChange}
                        value={form.formData?.type}
                        errorMessage={form.formErrors?.type} placeholder="Individual or Company" options={[
                            { value: 'individual', label: 'Individual' },
                            { value: 'company', label: 'Company' }
                        ]} />
                </div>
                <div className='form-group col-6'>
                    <label>Group</label>
                    <SearchSelect
                        name='group'
                        value={form.formData?.group}
                        errorMessage={form.formErrors?.group}
                        search={getCustomers}
                        options={group.map((item) => {
                            return {
                                value: item.id,
                                label: item.name
                            }
                        })}
                        changeValue={form.handleChangeByKey}
                        defaultKeywords={form.formData?.group_name}
                    />
                </div>
            </div>
            <div className='form-group mt-2'>
                <label>Address</label>
                <TextArea name='address'
                    handleChange={form.handleChange}
                    value={form.formData?.address}
                    errorMessage={form.formErrors?.address} placeholder='Address' />
            </div>
            <div className='form-group mt-2'>
                <label>Active</label>
                <InputForm name='active'
                    width={20}
                    type='checkbox'
                    handleChange={form.handleChange}
                    value={form.formData?.active}
                    errorMessage={form.formErrors?.active} />
                <span>This mean customer can take a order or else</span>
            </div>
            {form?.hookRender.map((item, index) => {
                return <div key={index}>
                    <label>{item.label ?? 'label'}</label>
                    {item.type === 'textarea' ? <TextArea
                        name={item.key}
                        handleChange={form.handleChange}
                        value={form.formData?.[item.key]}
                        errorMessage={form.formErrors?.[item.key]}
                        placeholder={item.placeHolder}
                    />
                        : item.type === 'select' ? <Select
                            name={item.key}
                            handleChange={form.handleChange}
                            value={form.formData?.[item.key]}
                            errorMessage={form.formErrors?.[item.key]}
                            placeholder={item.placeHolder}
                            options={item.options}
                        />
                            : <InputForm 
                            name={item.key}
                            handleChange={form.handleChange}
                            value={form.formData?.[item.key]}
                            errorMessage={form.formErrors?.[item.key]}
                            placeholder={item.placeHolder}
                            />}
                </div>
            })}
        </div>
    </div>
}