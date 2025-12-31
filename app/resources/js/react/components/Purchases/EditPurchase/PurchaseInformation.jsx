import React, { useCallback, useMemo, useState } from 'react'
import SearchSelect from '../../UI/Input/SearchSelect'
import { InputForm } from '../../UI/Input/InputForm'
import { Select } from '../../UI/Input/Select'
import TextArea from '../../UI/Input/Textarea'
import SupplierService from '../../../services/SupplierService'
import { isoToDateTime } from '../../../libraries/common'
import RenderFormFieldByList from '../../RenderFormFieldByList'
export default function PurchaseInformation({
    form= {
        formData: null,
        handleChange: null,
        formErrors: null,
        handleChangeByKey: null    
    } 
}) {
    const [supplierData, setSupplierData] = useState([]);
    const getSuppliers = useCallback((keywords = '',callback = null) => {
        SupplierService.list({
            page: 0,
            keywords: keywords
        })
            .then((resp) => {
                setSupplierData(resp.message?.data);
                if(callback) {
                    callback();
                }
            })
            .catch((error) => {
                navigate('/')
            });
    }, [SupplierService]);
    const disabled = useMemo(() => {
        if(form.formData?.status && form.formData?.status !== 'draft') {
            return true;
        }
        return false;
    },[form.formData?.status]);
    return <div>
        <h5>Purchase information</h5>
        <div className='row'>
            <div className='col-6'>
                <label>Supplier</label>
                <SearchSelect
                    errorMessage={form.formErrors?.supplier_id}
                    disabled={disabled}
                    search={getSuppliers}
                    value={form.formData?.supplier_id}
                    changeValue={form.handleChangeByKey}
                    options={supplierData?.map((item) => {
                        return {
                            value: item.id,
                            label: item.unit_name
                        }
                    })} 
                    name='supplier_id'
                    defaultKeywords={form.formData?.supplier_name}
                    />
            </div>
            <div className='col-6'>
                <label>Purchase date</label>
                <InputForm
                    disabled={disabled}
                    type="date"
                    handleChange={form.handleChange}
                    value={isoToDateTime(form.formData?.purchase_date ?? new Date)}
                    errorMessage={form.formErrors?.purchase_date}
                    name="purchase_date"
                />
            </div>
        </div>
        <div className='row'>
            <div className='col-4'>
                <label>Expected date</label>
                <InputForm
                    disabled={disabled}
                    type="date"
                    handleChange={form.handleChange}
                    value={isoToDateTime(form.formData?.expected_date ?? new Date)}
                    errorMessage={form.formErrors?.expected_date}
                    name="expected_date"
                />
            </div>
            <div className='col-4'>
                <label>Method payment</label>
                <Select
                    disabled={disabled}
                    name="payment_method"
                    value={form.formData?.payment_method}
                    handleChange={form.handleChange}
                    errorMessage={form.formErrors?.payment_method}
                    options={[
                        { value: 'cash', label: 'Cash' },
                        { value: 'bank', label: 'Bank' },
                        { value: 'transfer', label: 'Transfer' },
                        { value: 'other', label: 'Other' }
                    ]}
                />
            </div>
            <div className='col-4'>
                <label>Shipping fee</label>
                <InputForm
                    disabled={disabled}
                    type="number"
                    handleChange={form.handleChange}
                    value={form.formData?.shipping_fee}
                    errorMessage={form.formErrors?.shipping_fee}
                    name="shipping_fee"
                    placeholder="Enter full shipping free"
                />
            </div>
        </div>
        <div className='row'>
            <div>
                <label>Note</label>
                <TextArea
                    disabled={disabled}
                    handleChange={form.handleChange}
                    value={form.formData?.note}
                    errorMessage={form.formErrors?.note}
                    name="note"
                    placeholder="Note purchase"
                />
            </div>
        </div>
        {form.hookRender.map((item,index) => {
            return <div className='row' key={index}>
                <RenderFormFieldByList item={item} form={form}/>
            </div>
        })}
    </div>
}