import React, { useCallback, useEffect } from 'react'
import StockOutService from '../../../services/StockOutService'
import useTable from '../../../libraries/handleTable'
import CommonDataTable from '../../CommonDataTable'
import { Link, useNavigate } from 'react-router-dom'
import { useForm } from '../../../libraries/handleInput'
import { Select } from '../../UI/Input/Select'
import SearchInput from '../../UI/Input/SearchInput'
import { usePopup } from '../../popups/PopupContext'
import Currencies from '../../Currencies'
import StatusBadge from '../../StatusBadge'
import RenderFieldTableByList from '../../RenderFieldTableByList'
import { RenderTableSearch } from '../../RenderTableSearch'
import PrimaryButton from '../../UI/Buttons/PrimaryButton'
import { useI18n } from '../../../../i18n/useI18n'

export default function StockOuts() {
    const { t } = useI18n()
    const navigate = useNavigate()
    const search = useForm()
    const table = useTable()
    const { openPopup } = usePopup()

    const getListStockOut = useCallback(
        (page = 0) => {
            table.setLoading(true)
            StockOutService.list({
                page,
                ...search.formData,
            })
                .then((resp) => {
                    table.setData(resp.message.data)
                    table.setLinks(resp.message.links)
                    table.setLoading(false)
                })
                .catch((error) => {
                    if (error.response?.message?.errors) {
                        openPopup({
                            type: 'error',
                            message: error.response.message.errors,
                        })
                    }
                    table.setLoading(false)
                })
        },
        [search.formData]
    )

    const view = useCallback(() => {
        StockOutService.view()
            .then((resp) => {
                table.addColums(resp.message.index, (item, data) => {
                    return (
                        <RenderFieldTableByList
                            item={item}
                            data={data}
                        />
                    )
                })
                search.setHookRender(resp.message.search)
            })
            .catch((error) => {
                if (error.response?.message?.errors) {
                    openPopup({
                        type: 'error',
                        message: error.response.message.errors,
                    })
                }
            })
    }, [])

    useEffect(() => {
        table.setColums([
            {
                label: t('ID'),
                key: 'id',
                render: (id) => (
                    <Link to={`/stock?id=${id}`}>{id}</Link>
                ),
            },
            {
                label: t('Customer'),
                key: 'customer_name',
            },
            {
                label: t('Status'),
                key: 'status',
                render: (value) => <StatusBadge status={value} />,
            },
            {
                label: t('Invoice no'),
                key: 'document_no',
            },
            {
                label: t('Quantity'),
                key: 'quantity',
            },
            {
                label: t('Shipping fee'),
                key: 'shipping_fee',
                render: (value) => (
                    <Currencies amount={value} />
                ),
            },
            {
                label: t('Expected delivery date'),
                key: 'expected_delivery_date',
            },
            {
                label: t('Order status'),
                key: 'order_status',
                render: (value) => <StatusBadge status={value} />,
            },
        ])

        getListStockOut()
        view()
    }, [])

    return (
        <div className="mt-3">
            <CommonDataTable
                loading={table.loading}
                columns={table.colums}
                data={table.data}
                links={table.links}
                iconEdit={<i className="bi bi-eye"></i>}
                onEdit={(row) =>
                    navigate(`/stocks?stockout=${row.id}`)
                }
                filter={
                    <div className="row">
                        <div className="col-2">
                            <label>{t('Status')}</label>
                            <Select
                                name="status"
                                handleChange={search.handleChange}
                                value={search.formData?.status}
                                options={[
                                    {
                                        value: 'pending',
                                        label: t('Pending'),
                                    },
                                    {
                                        value: 'shipped',
                                        label: t('Shipped'),
                                    },
                                    {
                                        value: 'completed',
                                        label: t('Completed'),
                                    },
                                ]}
                            />
                        </div>

                        <div className="col-2 ml-2">
                            <label>{t('Order by')}</label>
                            <Select
                                name="order_by"
                                value={search.formData?.order_by}
                                handleChange={search.handleChange}
                                options={[
                                    {
                                        value: 'ASC',
                                        label: t('Oldest'),
                                    },
                                    {
                                        value: 'DESC',
                                        label: t('Newest'),
                                    },
                                ]}
                            />
                        </div>

                        {search.hookRender.map((item, index) => (
                            <div
                                className="col-2 ml-2"
                                key={index}
                            >
                                <RenderTableSearch
                                    item={item}
                                    search={search}
                                />
                            </div>
                        ))}

                        <div className="col-2 ml-2">
                            <label>{t('Search')}</label>
                            <SearchInput
                                submit={getListStockOut}
                                name="keywords"
                                value={search.formData?.keywords}
                                handleChange={search.handleChange}
                                placeholder={t(
                                    'Search by invoice'
                                )}
                            />
                        </div>

                        <div className="col-2 ml-2">
                            <PrimaryButton
                                label={t('Search')}
                                onClick={() => getListStockOut()}
                            />
                        </div>
                    </div>
                }
            />
        </div>
    )
}
