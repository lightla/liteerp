import React, { useCallback, useState } from 'react'
import { InputForm } from '../../UI/Input/InputForm'
import { Select } from '../../UI/Input/Select'
import TextArea from '../../UI/Input/Textarea'
import SearchSelect from '../../UI/Input/SearchSelect'
import CustomerGroupService from '../../../services/CustomerGroupService'
import RenderFormFieldByList from '../../RenderFormFieldByList'
import { useI18n } from '../../../../i18n/useI18n'

export default function CustomerForm({
    form = {
        handleChange: null,
        formErrors: null,
        handleChangeByKey: null,
        formData: null,
        hookRender: [],
    },
}) {
    const { t } = useI18n()
    const [group, setGroup] = useState([])

    const getCustomers = useCallback((keywords = '', callback = null) => {
        CustomerGroupService.list({
            keywords,
            page: 0,
        })
            .then((resp) => {
                setGroup(resp.message.data)
                callback && callback()
            })
            .catch(() => {})
    }, [])

    return (
        <div>
            <div className="form-group">
                <label>{t('Name')}</label>
                <InputForm
                    name="name"
                    handleChange={form.handleChange}
                    value={form.formData?.name}
                    errorMessage={form.formErrors?.name}
                    placeholder={t('Customer name')}
                />
            </div>

            <div className="row mt-2">
                <div className="form-group col-6">
                    <label>{t('Contact name')}</label>
                    <InputForm
                        name="contact_name"
                        handleChange={form.handleChange}
                        value={form.formData?.contact_name}
                        errorMessage={form.formErrors?.contact_name}
                        placeholder={t('Contact name')}
                    />
                </div>

                <div className="form-group col-6">
                    <label>{t('Email')}</label>
                    <InputForm
                        name="email"
                        handleChange={form.handleChange}
                        value={form.formData?.email}
                        errorMessage={form.formErrors?.email}
                        placeholder={t('Email')}
                    />
                </div>
            </div>

            <div className="row mt-2">
                <div className="form-group col-6">
                    <label>{t('Phone')}</label>
                    <InputForm
                        name="phone"
                        handleChange={form.handleChange}
                        value={form.formData?.phone}
                        errorMessage={form.formErrors?.phone}
                        placeholder={t('Phone number')}
                    />
                </div>

                <div className="form-group col-6">
                    <label>{t('Tax code')}</label>
                    <InputForm
                        name="tax_code"
                        handleChange={form.handleChange}
                        value={form.formData?.tax_code}
                        errorMessage={form.formErrors?.tax_code}
                        placeholder={t('Tax code')}
                    />
                </div>
            </div>

            <div className="form-group mt-2">
                <label>{t('Bank name')}</label>
                <InputForm
                    name="bank_name"
                    handleChange={form.handleChange}
                    value={form.formData?.bank_name}
                    errorMessage={form.formErrors?.bank_name}
                    placeholder={t('Bank name')}
                />
            </div>

            <div className="form-group mt-2">
                <label>{t('Bank account')}</label>
                <InputForm
                    name="bank_account"
                    handleChange={form.handleChange}
                    value={form.formData?.bank_account}
                    errorMessage={form.formErrors?.bank_account}
                    placeholder={t('Bank account')}
                />
            </div>

            <div className="row mt-2">
                <div className="form-group col-6">
                    <label>{t('Type')}</label>
                    <Select
                        name="type"
                        handleChange={form.handleChange}
                        value={form.formData?.type}
                        errorMessage={form.formErrors?.type}
                        options={[
                            { value: 'individual', label: t('Individual') },
                            { value: 'company', label: t('Company') },
                        ]}
                    />
                </div>

                <div className="form-group col-6">
                    <label>{t('Group')}</label>
                    <SearchSelect
                        name="group"
                        value={form.formData?.group}
                        errorMessage={form.formErrors?.group}
                        search={getCustomers}
                        options={group.map((item) => ({
                            value: item.id,
                            label: item.name,
                        }))}
                        changeValue={form.handleChangeByKey}
                        defaultKeywords={form.formData?.group_name}
                    />
                </div>
            </div>

            <div className="form-group mt-2">
                <label>{t('Address')}</label>
                <TextArea
                    name="address"
                    handleChange={form.handleChange}
                    value={form.formData?.address}
                    errorMessage={form.formErrors?.address}
                    placeholder={t('Address')}
                />
            </div>

            <div className="form-group mt-2">
                <label>{t('Active')}</label>
                <InputForm
                    name="active"
                    width={20}
                    type="checkbox"
                    handleChange={form.handleChange}
                    value={form.formData?.active}
                    errorMessage={form.formErrors?.active}
                />
                <span className="d-block mt-1">
                    {t(
                        'This means the customer can place orders'
                    )}
                </span>
            </div>

            {form?.hookRender?.map((item, index) => (
                <div key={index}>
                    <RenderFormFieldByList item={item} form={form} />
                </div>
            ))}
        </div>
    )
}
