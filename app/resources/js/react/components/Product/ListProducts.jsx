import React, { useCallback, useEffect, useMemo, useState } from 'react'
import ProductService from '../../services/ProductService'
import CommonDataTable from '../CommonDataTable'
import { Select } from '../UI/Input/Select'
import { InputForm } from '../UI/Input/InputForm'
import { useForm } from '../../libraries/handleInput'
import useTable from '../../libraries/handleTable'
import SearchInput from '../UI/Input/SearchInput'
import { PopupLayout } from '../../layouts/PopupLayout'
import { usePopup } from '../popups/PopupContext'
import SearchSelect from '../UI/Input/SearchSelect'
import TextArea from '../UI/Input/Textarea'
import { useSelector } from 'react-redux'
import UploadImage from '../UI/Input/UploadImage'
import LoadImage from '../LoadImage'
import { useI18n } from '../../../i18n/useI18n'
import PERMISSIONS from '../../common/permission'

export default function ListProducts() {
    const { t } = useI18n()
    const roles = useSelector((state) => state.businessRole.role);
    const business = useSelector((state) => state.business.data)
    const { openPopup } = usePopup()

    const [showForm, setShowForm] = useState(false)
    const [category, setCategory] = useState([])

    const form = useForm()
    const search = useForm()
    const table = useTable()

    const columns = [
        { label: t('ID'), key: 'id' },
        {
            label: t('Thumbnail'),
            key: 'image',
            render: (url) => <LoadImage width={35} height={35} url={url} />,
        },
        { label: t('Name'), key: 'name' },
        { label: t('SKU'), key: 'sku' },
        { label: t('Unit'), key: 'unit' },
        { label: t('Category'), key: 'category' },
    ]

    const getProducts = useCallback(
        (page = 0) => {
            table.setLoading(true)
            ProductService.list({
                page,
                keywords: search.formData?.keywords ?? '',
                order_by: search.formData?.order_by ?? '',
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
        [search]
    )

    const getCategories = useCallback((keywords = '', callback = null) => {
        ProductService.listCategory({
            page: 0,
            keywords,
        }).then((resp) => {
            setCategory(resp.message.data)
            callback && callback()
        })
    }, [])

    const update = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null)

        ProductService.update(form.formData)
            .then(() => {
                openPopup({
                    type: 'success',
                    message: t('Product has been updated'),
                })
                getProducts()
                setShowForm(false)
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

    const create = useCallback(() => {
        form.setLoading(true)
        form.setFormErrors(null)

        ProductService.add(form.formData)
            .then(() => {
                openPopup({
                    type: 'success',
                    message: t('Product has been created'),
                })
                getProducts()
                setShowForm(false)
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

    const handEdit = (row) => {
        setShowForm(true)
        form.setIsEdit(true)
        form.setFormData(row)
        getCategories(row.category?.name)
    }

    const destroy = useCallback((row) => {
        ProductService.delete(row).then(() => {
            openPopup({
                type: 'success',
                message: t('Product has been deleted'),
            })
            getProducts()
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
        getProducts()
    }, [search.formData?.order_by])

    return (
        <div className="mt-3">
            <CommonDataTable
                add={
                    roles?.includes(PERMISSIONS.PRODUCT.CREATE) ? () => {
                              setShowForm(true)
                              form.setIsEdit(false)
                          } : null
                }
                filter={
                    <div className="d-flex">
                        <div className="col-3 mx-2">
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

                        <div className="col-4">
                            <label>{t('Search')}</label>
                            <SearchInput
                                submit={getProducts}
                                name="keywords"
                                handleChange={search.handleChange}
                                value={search.formData?.keywords}
                            />
                        </div>
                    </div>
                }
                loading={table.loading}
                movePage={getProducts}
                columns={columns}
                data={table.data}
                links={table.links}
                onEdit={roles?.includes(PERMISSIONS.PRODUCT.UPDATE) ? handEdit : null}
                onDelete={ roles?.includes(PERMISSIONS.PRODUCT.DELETE) ? handleDelete : null}
            />

            {showForm && (
                <PopupLayout
                    loading={form.loading}
                    onConfirm={form.isEdit ? update : create}
                    onClose={() => setShowForm(false)}
                    title={
                        form.isEdit
                            ? t('Update product')
                            : t('Add product')
                    }
                >
                    <div className="form-group">
                        <label>{t('Name')}</label>
                        <InputForm
                            name="name"
                            handleChange={form.handleChange}
                            value={form.formData?.name}
                            errorMessage={form.formErrors?.name}
                        />
                    </div>

                    <div className="form-group">
                        <label>{t('SKU')}</label>
                        <InputForm
                            name="sku"
                            handleChange={form.handleChange}
                            value={form.formData?.sku}
                            errorMessage={form.formErrors?.sku}
                        />
                    </div>

                    <div className="form-group">
                        <label>{t('Unit')}</label>
                        <Select
                            name="unit"
                            handleChange={form.handleChange}
                            value={form.formData?.unit}
                            options={[
                                { value: 'pcs', label: 'pcs' },
                                { value: 'set', label: 'set' },
                                { value: 'box', label: 'box' },
                                { value: 'carton', label: 'carton' },
                                { value: 'bag', label: 'bag' },
                                { value: 'pack', label: 'pack' },
                                { value: 'roll', label: 'roll' },
                            ]}
                        />
                    </div>

                    <div className="form-group mt-3">
                        <label>{t('Category')}</label>
                        <SearchSelect
                            name="category_id"
                            changeValue={form.handleChangeByKey}
                            value={form.formData?.category_id}
                            search={getCategories}
                            options={category.map((item) => ({
                                value: item.id,
                                label: item.name,
                            }))}
                        />
                    </div>

                    <div className="form-group mt-3">
                        <label>{t('Thumbnail')}</label>
                        <UploadImage
                            name="image"
                            handleChangeByKey={form.handleChangeByKey}
                            value={form.formData?.image}
                        />
                    </div>

                    <div className="form-group mt-3">
                        <label>{t('Description')}</label>
                        <TextArea
                            name="description"
                            handleChange={form.handleChange}
                            value={form.formData?.description}
                            placeholder={t('Description')}
                        />
                    </div>
                </PopupLayout>
            )}
        </div>
    )
}
