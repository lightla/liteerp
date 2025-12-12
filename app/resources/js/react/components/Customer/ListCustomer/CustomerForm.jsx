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
        handleChangeByKey: null
    }
}) {
    const [group,setGroup] = useState([]);
    const getCustomers = useCallback((keywords = '',calblack = null) => {
        CustomerGroupService.list({
            keywords: keywords,
            page: 0
        })
            .then((resp) => {
                setGroup(resp.message.data);
                if(calblack) {
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
            <div className='form-group mt-2'>
                <label>Contact name</label>
                <InputForm name='contact_name'
                    handleChange={form.handleChange}
                    value={form.formData?.contact_name}
                    errorMessage={form.formErrors?.contact_name}
                    placeholder='Contact name' />
            </div>
            <div className='form-group mt-2'>
                <label>Email</label>
                <InputForm name='email'
                    handleChange={form.handleChange}
                    value={form.formData?.email}
                    errorMessage={form.formErrors?.email}
                    placeholder='Email' />
            </div>
            <div className='form-group mt-2'>
                <label>Phone</label>
                <InputForm name='phone'
                    handleChange={form.handleChange}
                    value={form.formData?.phone}
                    errorMessage={form.formErrors?.phone} placeholder='Number phone contact' />
            </div>
            <div className='form-group mt-2'>
                <label>Tax code</label>
                <InputForm name='tax_code'
                    handleChange={form.handleChange}
                    value={form.formData?.tax_code}
                    errorMessage={form.formErrors?.tax_code} placeholder='Tax code number' />
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
            <div className='form-group mt-2'>
                <label>Type</label>
                <Select name='type'
                    handleChange={form.handleChange}
                    value={form.formData?.type}
                    errorMessage={form.formErrors?.type} placeholder="Individual or Company" options={[
                        { value: 'individual', label: 'Individual' },
                        { value: 'company', label: 'Company' }
                    ]} />
            </div>
            <div className='form-group mt-2'>
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
            <div className='form-group mt-2'>
                <label>Address</label>
                <TextArea name='address'
                    handleChange={form.handleChange}
                    value={form.formData?.address}
                    errorMessage={form.formErrors?.address} placeholder='Address' />
            </div>
        </div>
    </div>
}