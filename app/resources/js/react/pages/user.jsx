import React, { useCallback, useEffect, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import PageHead from '../components/PageHead'
import CommonDataTable from '../components/CommonDataTable'
import UserService from '../services/UserService'
import useTable from '../libraries/handleTable'
import { useForm } from '../libraries/handleInput'
import { PopupLayout } from '../layouts/PopupLayout'
import { InputForm } from '../components/UI/Input/InputForm'
import { usePopup } from '../components/popups/PopupContext'
import { Select } from '../components/UI/Input/Select'
import { useI18n } from '../../i18n/useI18n'

export default function User() {
    const { t } = useI18n()
    const { openPopup } = usePopup()
    const table = useTable()
    const form = useForm()
    const [showForm, setShowForm] = useState(false)

    const getUsers = useCallback(() => {
        table.setLoading(true)
        UserService.list({
            keywords: '',
            page: 0,
        })
            .then((resp) => {
                table.setLoading(false)
                table.setData(resp.message.data)
                table.setLinks(resp.message.links)
            })
            .catch(() => {})
    }, [])

    const handleEdit = (row) => {
        form.setIsEdit(true)
        form.setFormData(row)
        setShowForm(true)
    }

    const submit = useCallback(() => {
        form.setFormErrors(null)
        form.setLoading(true)
        UserService.add(form.formData)
            .then(() => {
                form.setFormData(null)
                openPopup({
                    type: 'success',
                    message: t('User added successfully'),
                })
                setShowForm(false)
                getUsers()
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
        UserService.update(form.formData)
            .then(() => {
                form.setFormData(null)
                openPopup({
                    type: 'success',
                    message: t('User updated successfully'),
                })
                setShowForm(false)
                getUsers()
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

    useEffect(() => {
        getUsers()
    }, [])

    return (
        <DashboardLayout>
            <div>
                <PageHead
                    title={t('Employees')}
                    subtitle={t(
                        'Employees must register their own accounts. This feature only assigns roles to users within the business.'
                    )}
                />

                <div className="container mt-3">
                    <CommonDataTable
                        loading={table.loading}
                        add={() => setShowForm(true)}
                        columns={[
                            { key: 'id', label: t('ID') },
                            {
                                key: 'avatar',
                                label: t('Avatar'),
                                render: (avatar) => (
                                    <img
                                        width={50}
                                        height={50}
                                        src={
                                            avatar ??
                                            '/assets/icons/avatar-default.png'
                                        }
                                        alt=""
                                    />
                                ),
                            },
                            {
                                key: 'bio',
                                label: t('Bio'),
                                render: (bio) => (
                                    <span>
                                        {bio?.toString().length >= 20
                                            ? bio
                                                  ?.toString()
                                                  .substring(0, 20) + '...'
                                            : bio}
                                    </span>
                                ),
                            },
                            { key: 'phone', label: t('Phone') },
                            { key: 'email', label: t('Email') },
                            { key: 'name', label: t('Name') },
                            {
                                key: 'role',
                                label: t('Role'),
                                render: (role) => (
                                    <span
                                        className={
                                            'badge text-uppercase ' +
                                            (role === 'admin'
                                                ? 'bg-success'
                                                : 'bg-warning text-dark')
                                        }
                                    >
                                        {t(role)}
                                    </span>
                                ),
                            },
                            {
                                key: 'last_seen',
                                label: t('Last seen'),
                            },
                        ]}
                        data={table.data}
                        links={table.links}
                        onEdit={handleEdit}
                        onDelete={() => {}}
                    />
                </div>

                {showForm && (
                    <PopupLayout
                        loading={form.loading}
                        onConfirm={form.isEdit ? update : submit}
                        onClose={() => {
                            setShowForm(false)
                            form.setIsEdit(false)
                        }}
                        title={
                            !form.isEdit
                                ? t('Add staff')
                                : t('Update staff')
                        }
                    >
                        <div>
                            <div className="form-group">
                                <label>{t('Email')}</label>
                                <InputForm
                                    name="email"
                                    errorMessage={
                                        form.formErrors?.email
                                    }
                                    value={form.formData?.email}
                                    handleChange={
                                        form.handleChange
                                    }
                                />
                            </div>

                            <div className="form-group mt-2">
                                <label>{t('Role')}</label>
                                <Select
                                    name="role"
                                    errorMessage={
                                        form.formErrors?.role
                                    }
                                    value={form.formData?.role}
                                    handleChange={
                                        form.handleChange
                                    }
                                    options={[
                                        {
                                            value: 'manager',
                                            label: t('Manager'),
                                        },
                                        {
                                            value: 'seller',
                                            label: t('Seller'),
                                        },
                                        {
                                            value: 'accountanter',
                                            label: t('Accountant'),
                                        },
                                        {
                                            value: 'warehouseman',
                                            label: t('Warehouseman'),
                                        },
                                        {
                                            value: 'purchaser',
                                            label: t('Purchaser'),
                                        },
                                        {
                                            value: 'admin',
                                            label: t('Admin'),
                                        },
                                    ]}
                                />
                            </div>
                        </div>
                    </PopupLayout>
                )}
            </div>
        </DashboardLayout>
    )
}
