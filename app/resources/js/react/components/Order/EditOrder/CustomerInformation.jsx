import React, { useCallback, useMemo, useState } from 'react'
import SearchSelect from '../../UI/Input/SearchSelect';
import { Select } from '../../UI/Input/Select';
import { InputForm } from '../../UI/Input/InputForm';
import TextArea from '../../UI/Input/Textarea';
import CustomerService from '../../../services/CustomerService';
export default function CustomerInformation({
    form = {
        formData: null,
        formErrors: null
    }
}) {
    const [customers, setCustomers] = useState([]);
    const getCustomers = useCallback((keywords = '',callback = null) => {
        CustomerService.list({
            keywords: keywords,
            page: 1,
            type: ''
        })
            .then((resp) => {
                setCustomers(resp.message.data);
                if(callback) {
                    callback();
                }
            })
            .catch((error) => {

            })
    }, []);
    return <div>
        <h4 className='h5'>Customer information</h4>
        <div>
            <div className='row'>
                <div className='px-2'>
                    <div className="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Note!</strong> You can keep empty to system automatic create order no
                        <button type="button" className="btn-close" 
                        data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <div className='form-group col-6'>
                    <label>Customer</label>
                    <SearchSelect
                        name='customer_id'
                        search={getCustomers}
                        changeValue={form.handleChangeByKey}
                        value={form.formData?.customer_id}
                        errorMessage={form.formErrors?.customer_id}
                        options={customers.map((item) => {
                            return {
                                value: item.id,
                                label: item.name
                            }
                        })}
                        defaultKeywords={form.formData?.customer_name}
                    />
                </div>
                <div className='form-group col-6'>
                    <label>Type</label>
                    <Select name='type'
                        handleChange={form.handleChange}
                        value={form.formData?.type}
                        errorMessage={form.formErrors?.type}
                        options={[
                            { value: 'retail', label: 'Retail' },
                            { value: 'wholesale', label: 'Wholesale' }
                        ]}
                    />
                </div>
            </div>
            <div className='row mt-3'>
                <div className='form-group col-4'>
                    <label>Expected delivery date</label>
                    <InputForm type='date' name='expected_delivery_date'
                        handleChange={form.handleChange}
                        value={form.formData?.expected_delivery_date}
                        errorMessage={form.formErrors?.expected_delivery_date} />
                </div>
                <div className='form-group col-4'>
                    <label>Order date</label>
                    <InputForm type='date' name='order_date'
                        handleChange={form.handleChange}
                        value={form.formData?.order_date}
                        errorMessage={form.formErrors?.order_date} />
                </div>
                <div className='form-group col-4'>
                    <label>Order no</label>
                    <InputForm type='text' name='order_no'
                        handleChange={form.handleChange}
                        value={form.formData?.order_no}
                        errorMessage={form.formErrors?.order_no} />
                </div>
            </div>
            <div className='form-group mt-3'>
                <label>Note</label>
                <TextArea name='note' handleChange={form.handleChange}
                    value={form.formData?.note}
                    errorMessage={form.formErrors?.note} />
            </div>
        </div>
    </div>
}