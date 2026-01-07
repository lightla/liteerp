import React, { useCallback, useEffect, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import CommonDataTable from '../components/CommonDataTable'
import PrimaryButton from '../components/UI/Buttons/PrimaryButton'
import { PopupLayout } from '../layouts/PopupLayout'
import { InputForm } from '../components/UI/Input/InputForm'
import ShippingService from '../services/ShippingService'
import { usePopup } from '../components/popups/PopupContext'
import useTable from '../libraries/handleTable'
import { useForm } from '../libraries/handleInput'
import SearchInput from '../components/UI/Input/SearchInput'
import PageHead from '../components/PageHead'
import FlatIcon32 from '../components/UI/FlatIcons/FlatIcon32'
import UploadImage from '../components/UI/Input/UploadImage'
import RenderFormTableByList from '../components/RenderFieldTableByList'
import RenderFormFieldByList from '../components/RenderFormFieldByList'
import { RenderTableSearch } from '../components/RenderTableSearch'
import { useI18n } from '../../i18n/useI18n'

export default function Shipping() {
    const { t } = useI18n()
    const { openPopup } = usePopup()
    const table = useTable()
    const form = useForm()
    const search = useForm()
    const [showAdd, setShowAdd] = useState(false)

    const handEdit = (row) => {
        form.setFormData(row)
        form.setIsEdit(true)
        setShowAdd(true)
    }

    const submit = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null)

        ShippingService.add(form.formData)
            .then(() => {
                openPopup({
                    type: 'success',
                    message: t('Created successfully'),
                })
                getShippings()
                setShowAdd(false)
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
        form.setLoading(true)
        form.setFormErrors(null)

        ShippingService.update(form.formData)
            .then(() => {
                openPopup({
                    type: 'success',
                    message: t('Updated successfully'),
                })
                getShippings()
                setShowAdd(false)
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

    const getShippings = useCallback(
        (page = 0) => {
            table.setLoading(true)
            ShippingService.list({
                page,
                ...search.formData,
            })
                .then((resp) => {
                    table.setData(resp.message.data)
                    table.setLinks(resp.message.links)
                    table.setLoading(false)
                })
                .catch((error) => {
                    if (error.response?.data?.message) {
                        openPopup({
                            type: 'error',
                            message: error.response.data.message,
                        })
                    }
                })
        },
        [search.formData]
    )

    const getView = useCallback(() => {
        ShippingService.view()
            .then((resp) => {
                table.addColums(resp.message.index, (item, data) => (
                    <RenderFormTableByList item={item} data={data} />
                ))
                form.setHookRender(resp.message.form)
                search.setHookRender(resp.message.search)
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

    const destroy = useCallback((row) => {
        ShippingService.delete(row)
            .then(() => {
                openPopup({
                    type: 'success',
                    message: t('Deleted successfully'),
                })
                getShippings()
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

    useEffect(() => {
        getShippings()
        getView()
        table.setColums([
            {
                label: t('Logo'),
                key: 'logo',
                render: (value) =>
                    value ? (
                        <img
                            width={45}
                            height={45}
                            src={value}
                            alt=""
                        />
                    ) : (
                        <FlatIcon32 />
                    ),
            },
            { label: t('ID'), key: 'id' },
            { label: t('Name'), key: 'name' },
            { label: t('Code'), key: 'code' },
            {
                label: t('Status'),
                key: 'active',
                render: (active) =>
                    active ? (
                        <span className="badge bg-success">
                            {t('Working')}
                        </span>
                    ) : (
                        <span className="badge bg-secondary">
                            {t('Stopped')}
                        </span>
                    ),
            },
        ])
    }, [])

    return (
        <DashboardLayout>
            <div>
                <PageHead
                    title={t('Shippings')}
                    subtitle={t(
                        'Manage shipping service providers'
                    )}
                />

                <div className="container mt-4">
                    <CommonDataTable
                        add={() => {
                            setShowAdd(true)
                            form.setIsEdit(false)
                        }}
                        loading={table.loading}
                        movePage={getShippings}
                        data={table.data}
                        links={table.links}
                        columns={table.colums}
                        onEdit={handEdit}
                        onDelete={handleDelete}
                        filter={
                            <div className="row">
                                {search.hookRender.map(
                                    (item, index) => (
                                        <div
                                            className="col-2"
                                            key={index}
                                        >
                                            <RenderTableSearch
                                                item={item}
                                                search={search}
                                            />
                                        </div>
                                    )
                                )}

                                <div className="col-2">
                                    <label>{t('Keywords')}</label>
                                    <SearchInput
                                        submit={getShippings}
                                        name="keywords"
                                        handleChange={
                                            search.handleChange
                                        }
                                        value={
                                            search.formData?.keywords
                                        }
                                    />
                                </div>

                                <div className="col-2">
                                    <PrimaryButton
                                        label={t('Search')}
                                        onClick={() =>
                                            getShippings(0)
                                        }
                                    />
                                </div>
                            </div>
                        }
                    />
                </div>

                {showAdd && (
                    <PopupLayout
                        loading={form.loading}
                        confirmText={t('Save')}
                        onClose={() => {
                            setShowAdd(false)
                            form.setIsEdit(false)
                        }}
                        onConfirm={
                            form.isEdit ? update : submit
                        }
                        title={
                            form.isEdit
                                ? t('Update shipping unit')
                                : t('Add shipping unit')
                        }
                    >
                        <div>
                            <div className="form-group mt-3">
                                <label>{t('Name')}</label>
                                <InputForm
                                    name="name"
                                    handleChange={
                                        form.handleChange
                                    }
                                    errorMessage={
                                        form.formErrors?.name
                                    }
                                    value={form.formData?.name}
                                    placeholder={t('Name')}
                                />
                            </div>

                            <div className="form-group mt-3">
                                <label>{t('Code')}</label>
                                <InputForm
                                    name="code"
                                    handleChange={
                                        form.handleChange
                                    }
                                    errorMessage={
                                        form.formErrors?.code
                                    }
                                    value={form.formData?.code}
                                    placeholder={t('Code')}
                                />
                            </div>

                            <div className="form-group mt-3">
                                <label>{t('Logo')}</label>
                                <UploadImage
                                    name="logo"
                                    handleChangeByKey={
                                        form.handleChangeByKey
                                    }
                                    errorMessage={
                                        form.formErrors?.logo
                                    }
                                    value={form.formData?.logo}
                                />
                            </div>

                            <div className="form-group mt-3">
                                <label>
                                    {t(
                                        'This shipping provider is active'
                                    )}
                                </label>
                                <InputForm
                                    width={20}
                                    name="active"
                                    handleChange={
                                        form.handleChange
                                    }
                                    value={form.formData?.active}
                                    errorMessage={
                                        form.formErrors?.active
                                    }
                                    type="checkbox"
                                />
                            </div>

                            {form.hookRender.map(
                                (item, index) => (
                                    <div
                                        className="form-group mt-3"
                                        key={index}
                                    >
                                        <RenderFormFieldByList
                                            item={item}
                                            form={form}
                                        />
                                    </div>
                                )
                            )}
                        </div>
                    </PopupLayout>
                )}
            </div>
        </DashboardLayout>
    )
}
