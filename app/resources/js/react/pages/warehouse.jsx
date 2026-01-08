import React, { useCallback, useEffect, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import CommonDataTable from '../components/CommonDataTable'
import { PopupLayout } from '../layouts/PopupLayout'
import { InputForm } from '../components/UI/Input/InputForm'
import WarehouseService from '../services/WarehouseService'
import { Select } from '../components/UI/Input/Select'
import { usePopup } from '../components/popups/PopupContext'
import SearchInput from '../components/UI/Input/SearchInput'
import { useForm } from '../libraries/handleInput'
import useTable from '../libraries/handleTable'
import PageHead from '../components/PageHead'
import { useI18n } from '../../i18n/useI18n'
import { useSelector } from 'react-redux'
import PERMISSIONS from '../common/permission'

export default function Warehouse() {
    const { t } = useI18n()
    const { openPopup } = usePopup()
    const roles = useSelector((state) => state.businessRole.role);
    const table = useTable()
    const form = useForm()
    const search = useForm(null)

    const [showPopup, setShowPopup] = useState(false)

    const getList = useCallback(
        (page = 0) => {
            table.setLoading(true)
            WarehouseService.list({
                active: search.formData?.active ?? '',
                keywords: search.formData?.keywords ?? '',
                page,
            })
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

    useEffect(() => {
        table.setColums([
            { label: t('ID'), key: 'id' },
            { label: t('Name'), key: 'name' },
            { label: t('Address'), key: 'address' },
            {
                label: t('Products'),
                key: 'product_count',
                render: (value) => <span>{value}</span>,
            },
            {
                label: t('Status'),
                key: 'active',
                render: (value) => (
                    <span
                        className={`badge rounded-pill px-3 py-2 ${value === 1
                                ? 'bg-success bg-opacity-75'
                                : 'bg-secondary'
                            }`}
                    >
                        {value === 1 ? t('Active') : t('Inactive')}
                    </span>
                ),
            },
        ])
        getList()
    }, [search.formData?.active])

    const submit = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null)

        WarehouseService.add(form.formData)
            .then(() => {
                getList()
                openPopup({
                    type: 'success',
                    message: t('Warehouse has been created'),
                })
                setShowPopup(false)
                form.setFormData(null)
                form.setLoading(false)
            })
            .catch((error) => {
                if (error.response?.data?.errors) {
                    form.setFormErrors(error.response.data.errors)
                }
                form.setLoading(false)
            })
    }, [form])

    const edit = useCallback(() => {
        form.setFormErrors(null)
        form.setLoading(true)

        WarehouseService.update(form.formData)
            .then(() => {
                getList()
                openPopup({
                    type: 'success',
                    message: t('Warehouse has been updated'),
                })
                setShowPopup(false)
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
    }, [form])

    const destroy = useCallback((row) => {
        WarehouseService.delete(row)
            .then(() => {
                getList()
                openPopup({
                    type: 'success',
                    message: t('Warehouse has been deleted'),
                })
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

    const handleDelete = useCallback((row) => {
        openPopup({
            type: 'warning',
            message: t('Are you sure to delete?'),
            onConfirm: () => destroy(row),
        })
    }, [])

    return (
        <DashboardLayout>
            <PageHead
                containerClass="mx-4"
                title={t('Warehouse')}
                subtitle={t(
                    'warehouse_desc'
                )}
            />

            <div className="m-4">
                <CommonDataTable
                    add={roles?.includes(PERMISSIONS.WAREHOUSE.CREATE) ? () => {
                        setShowPopup(true)
                        form.setIsEdit(false)
                    } : null}
                    loading={table.loading}
                    movePage={getList}
                    columns={table.colums}
                    data={table.data}
                    links={table.links}
                    onEdit={roles?.includes(PERMISSIONS.WAREHOUSE.UPDATE) ? (row) => {
                        setShowPopup(true)
                        form.setFormData(row)
                        form.setIsEdit(true)
                    } : null}
                    onDelete={roles?.includes(PERMISSIONS.WAREHOUSE.DELETE) ? handleDelete : null}
                    filter={
                        <div className="d-flex">
                            <div className="col-6">
                                <label>{t('Status')}</label>
                                <Select
                                    name="active"
                                    value={search.formData?.active ?? ''}
                                    handleChange={search.handleChange}
                                    options={[
                                        { value: 0, label: t('Inactive') },
                                        { value: 1, label: t('Active') },
                                    ]}
                                />
                            </div>
                            <div className="col-6 mx-2">
                                <label>{t('Search')}</label>
                                <SearchInput
                                    name="keywords"
                                    submit={getList}
                                    placeholder={t('Search by name')}
                                    value={search.formData?.keywords}
                                    handleChange={search.handleChange}
                                />
                            </div>
                        </div>
                    }
                />
            </div>

            {showPopup && (
                <PopupLayout
                    loading={form.loading}
                    confirmText={t('Save')}
                    title={
                        !form.isEdit
                            ? t('New warehouse')
                            : t('Update warehouse')
                    }
                    onClose={() => {
                        setShowPopup(false)
                        form.setIsEdit(false)
                    }}
                    onConfirm={!form.isEdit ? submit : edit}
                >
                    <div className="form-group">
                        <label>{t('Name')}</label>
                        <InputForm
                            name="name"
                            value={form.formData?.name}
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.name}
                            placeholder={t('Warehouse name')}
                        />
                    </div>

                    <div className="form-group mt-3">
                        <label>{t('Address')}</label>
                        <InputForm
                            name="address"
                            value={form.formData?.address}
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.address}
                            placeholder={t('Warehouse address')}
                        />
                    </div>

                    <div className="form-group mt-3">
                        <label>{t('Active')}</label>
                        <div className="d-flex">
                            <InputForm
                                width={10}
                                type="checkbox"
                                name="active"
                                value={form.formData?.active}
                                handleChange={form.handleChange}
                                errorMessage={form.formErrors?.active}
                            />
                            <span className="mx-2">
                                {t(
                                    'If inactive, products cannot be moved to this warehouse'
                                )}
                            </span>
                        </div>
                    </div>
                </PopupLayout>
            )}
        </DashboardLayout>
    )
}
