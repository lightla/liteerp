import React, { useCallback, useEffect, useState } from 'react'
import CommonDataTable from '../CommonDataTable'
import useTable from '../../libraries/handleTable'
import { useForm } from '../../libraries/handleInput'
import { usePopup } from '../popups/PopupContext'
import { Select } from '../UI/Input/Select'
import SearchInput from '../UI/Input/SearchInput'
import { PopupLayout } from '../../layouts/PopupLayout'
import CustomerService from '../../services/CustomerService'
import CustomerForm from './ListCustomer/CustomerForm'
import StatusBadge from '../StatusBadge'
import RenderFormTableByList from '../RenderFieldTableByList'
import ButtonPrimary from '../../components/UI/Buttons/PrimaryButton'
import { RenderTableSearch } from '../RenderTableSearch'
import { useI18n } from '../../../i18n/useI18n'
import { useSelector } from 'react-redux'
import PERMISSIONS from '../../common/permission'

export default function ListCustomer() {
    const { t } = useI18n()
    const roles = useSelector((state) => state.businessRole.role);
    const table = useTable()
    const search = useForm()
    const form = useForm()
    const { openPopup } = usePopup()

    const [showAdd, setShowAdd] = useState(false)

    const handleEdit = (row) => {
        form.setIsEdit(true)
        form.setFormData(row)
        setShowAdd(true)
    }

    const submit = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null)

        CustomerService.add(form.formData)
            .then(() => {
                openPopup({
                    type: 'success',
                    message: t('Customer has been created'),
                })
                setShowAdd(false)
                getCustomers()
                form.setLoading(false)
            })
            .catch((error) => {
                if (error.response?.data?.errors) {
                    form.setFormErrors(error.response.data.errors)
                }
                if (error.response?.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data.message,
                    })
                }
                form.setLoading(false)
            })
    }, [form.formData])

    const update = useCallback(() => {
        form.setFormErrors(null)
        form.setLoading(true)

        CustomerService.update(form.formData)
            .then(() => {
                openPopup({
                    type: 'success',
                    message: t('Customer has been updated'),
                })
                setShowAdd(false)
                getCustomers()
                form.setLoading(false)
            })
            .catch((error) => {
                if (error.response?.data?.errors) {
                    form.setFormErrors(error.response.data.errors)
                }
                if (error.response?.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data.message,
                    })
                }
                form.setLoading(false)
            })
    }, [form.formData])

    const destroy = useCallback((row) => {
        CustomerService.delete(row)
            .then(() => {
                openPopup({
                    type: 'success',
                    message: t('Customer has been deleted'),
                })
                getCustomers()
            })
            .catch((error) => {
                if (error.response?.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data.message,
                    })
                }
            })
    }, [])

    const handleDelete = (row) => {
        openPopup({
            type: 'warning',
            message: t('Are you sure to delete?'),
            onConfirm: () => destroy(row),
        })
    }

    const getCustomers = useCallback(
        (page = 0) => {
            table.setLoading(true)
            CustomerService.list(search.formData)
                .then((resp) => {
                    table.setData(resp.message.data)
                    table.setLinks(resp.message.links)
                    table.setLoading(false)
                })
                .catch(() => {
                    table.setLoading(false)
                })
        },
        [search.formData]
    )

    const renderForm = useCallback(() => {
        CustomerService.view().then((resp) => {
            form.setHookRender(resp.message?.form)
            table.addColums(resp.message.index, (item, data) => (
                <RenderFormTableByList item={item} data={data} />
            ))
            search.setHookRender(resp.message?.search ?? [])
        })
    }, [])

    useEffect(() => {
        table.setColums([
            { label: t('ID'), key: 'id' },
            { label: t('Name'), key: 'name' },
            { label: t('Email'), key: 'email' },
            { label: t('Phone'), key: 'phone' },
            { label: t('Total orders'), key: 'total_order' },
            { label: t('Group'), key: 'group_name' },
            {
                label: t('Type'),
                key: 'type',
                render: (value) => (
                    <span
                        className={
                            'badge text-uppercase ' +
                            (value === 'company'
                                ? 'bg-primary'
                                : 'bg-secondary')
                        }
                    >
                        {t(value === 'company' ? 'Company' : 'Individual')}
                    </span>
                ),
            },
            {
                label: t('Status'),
                key: 'active',
                render: (value) => (
                    <StatusBadge
                        status={value ? 'active' : 'inactive'}
                    />
                ),
            },
        ])

        renderForm()
        getCustomers()
    }, [])

    return (
        <div>
            <CommonDataTable
                add={ roles?.includes(PERMISSIONS.CUSTOMER.CREATE) 
                    ? () => setShowAdd(true)
                    : null}
                loading={table.loading}
                movePage={getCustomers}
                columns={table.colums}
                data={table.data}
                links={table.links}
                onEdit={roles?.includes(PERMISSIONS.CUSTOMER.UPDATE) ? handleEdit : null}
                onDelete={ roles?.includes(PERMISSIONS.CUSTOMER.DELETE) ? handleDelete : null}
                filter={
                    <div className="row">
                        <div className="col-2">
                            <label>{t('Status')}</label>
                            <Select
                                name="active"
                                value={search.formData?.active}
                                handleChange={search.handleChange}
                                options={[
                                    { value: 0, label: t('Inactive') },
                                    { value: 1, label: t('Active') },
                                ]}
                            />
                        </div>

                        <div className="col-2">
                            <label>{t('Type')}</label>
                            <Select
                                name="type"
                                value={search.formData?.type}
                                handleChange={search.handleChange}
                                options={[
                                    {
                                        value: 'individual',
                                        label: t('Individual'),
                                    },
                                    {
                                        value: 'company',
                                        label: t('Company'),
                                    },
                                ]}
                            />
                        </div>

                        <div className="col-2">
                            <label>{t('Order by')}</label>
                            <Select
                                name="order_by"
                                value={search.formData?.order_by}
                                handleChange={search.handleChange}
                                options={[
                                    { value: 'ASC', label: t('Oldest') },
                                    { value: 'DESC', label: t('Newest') },
                                ]}
                            />
                        </div>

                        {search.hookRender.map((item, index) => (
                            <div className="col-2" key={index}>
                                <RenderTableSearch
                                    item={item}
                                    search={search}
                                />
                            </div>
                        ))}

                        <div className="col-2">
                            <label>{t('Search')}</label>
                            <SearchInput
                                submit={getCustomers}
                                placeholder={t(
                                    'Search by customer name'
                                )}
                                value={search.formData?.keywords}
                                name="keywords"
                                handleChange={search.handleChange}
                            />
                        </div>

                        <div className="col-2">
                            <ButtonPrimary
                                onClick={getCustomers}
                                label={t('Search')}
                            />
                        </div>
                    </div>
                }
            />

            {showAdd && (
                <PopupLayout
                    loading={form.loading}
                    confirmText={t('Save')}
                    onConfirm={form.isEdit ? update : submit}
                    onClose={() => {
                        setShowAdd(false)
                        form.setIsEdit(false)
                    }}
                    title={
                        form.isEdit
                            ? t('Update customer')
                            : t('Add customer')
                    }
                >
                    <CustomerForm form={form} />
                </PopupLayout>
            )}
        </div>
    )
}
