import React, { useCallback, useEffect } from 'react';
import CommonDataTable from '../CommonDataTable';
import PurchaseService from '../../services/PurchaseService';
import { Select } from '../UI/Input/Select';
import { useNavigate } from 'react-router-dom';
import { usePopup } from '../popups/PopupContext';
import SearchInput from '../UI/Input/SearchInput';
import useTable from '../../libraries/handleTable';
import { useForm } from '../../libraries/handleInput';
import PageHead from '../PageHead';
import Currencies from '../Currencies';
import { isoToDateTime } from '../../libraries/common';
import StatusBadge from '../StatusBadge';
import PaymentMethod from '../PaymentMethod';
import ContentOnTable from '../ContentOnTable';
import RenderFormTableByList from '../RenderFieldTableByList';
import { RenderTableSearch } from '../RenderTableSearch';
import PrimaryButton from '../UI/Buttons/PrimaryButton';
import { useI18n } from '../../../i18n/useI18n';

export default function ListPurchases() {
    const { t } = useI18n();
    const navigate = useNavigate();
    const { openPopup } = usePopup();
    const search = useForm();
    const table = useTable();

    const view = useCallback(() => {
        PurchaseService.view()
            .then((resp) => {
                table.addColums(resp.message.index, (item, data) => {
                    return <RenderFormTableByList item={item} data={data} />;
                });
                search.setHookRender(resp.message.search);
            })
            .catch((error) => {
                if (error.response?.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data.message,
                    });
                }
            });
    }, []);

    const handleEdit = (row) => {
        navigate('/purchases?form=edit&id=' + row.id);
    };

    const getPurchases = useCallback(
        (page = 0) => {
            table.setLoading(true);
            PurchaseService.list({
                page: page,
                ...search.formData,
            })
                .then((resp) => {
                    table.setData(resp.message.data);
                    table.setLinks(resp.message.links);
                    table.setLoading(false);
                })
                .catch((error) => {
                    if (error.response?.data?.message) {
                        openPopup({
                            type: 'error',
                            message: error.response.data.message,
                        });
                    }
                });
        },
        [search.formData]
    );

    useEffect(() => {
        getPurchases();
        view();

        table.setColums([
            {
                label: t('ID'),
                key: 'id',
                render: (id) => <span>PU{id}</span>,
            },
            {
                label: t('Supplier'),
                key: 'supplier_name',
                render: (value) => <ContentOnTable value={value} max={15} />,
            },
            {
                label: t('Purchase date'),
                key: 'purchase_date',
                render: (date) => isoToDateTime(date),
            },
            {
                label: t('Expected date'),
                key: 'expected_date',
                render: (date) => isoToDateTime(date),
            },
            {
                label: t('Shipping fee'),
                key: 'shipping_fee',
                render: (value) => (
                    <strong>
                        <Currencies amount={value} />
                    </strong>
                ),
            },
            {
                label: t('Payment method'),
                key: 'payment_method',
                render: (value) => <PaymentMethod value={value} />,
            },
            { label: t('Buy'), key: 'buy_quantity' },
            { label: t('Compensation'), key: 'compensation_quantity' },
            { label: t('Conversion'), key: 'conversion_quantity' },
            { label: t('Gift'), key: 'gift_quantity' },
            {
                label: t('Tax'),
                key: 'tax',
                render: (value) => (
                    <strong>
                        <Currencies amount={value} />
                    </strong>
                ),
            },
            {
                label: t('Status'),
                key: 'status',
                render: (value) => <StatusBadge status={value} />,
            },
            {
                label: t('Approved by'),
                key: 'approved_name',
                render: (value) => (
                    <span className="badge bg-primary text-uppercase">
                        {value}
                    </span>
                ),
            },
            {
                label: t('Created by'),
                key: 'created_name',
                render: (value) => (
                    <span className="badge bg-primary text-uppercase">
                        {value}
                    </span>
                ),
            },
        ]);
    }, []);

    return (
        <div>
            <PageHead
                containerClass="mx-4"
                title={t('Purchases')}
                subtitle={t(
                    'Track your offers, approval and payment status.'
                )}
            />

            <div className="m-4">
                <CommonDataTable
                    filter={
                        <div className="d-flex flex-wrap gap-3">
                            <div className="col-2">
                                <label>{t('Status')}</label>
                                <Select
                                    name="status"
                                    value={search.formData?.status}
                                    handleChange={search.handleChange}
                                    errorMessage={search.formErrors?.status}
                                    options={[
                                        { value: 'draft', label: t('Draft') },
                                        {
                                            value: 'requested',
                                            label: t('Requested'),
                                        },
                                        {
                                            value: 'approved',
                                            label: t('Approved'),
                                        },
                                        {
                                            value: 'cancelled',
                                            label: t('Cancelled'),
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
                                    errorMessage={
                                        search.formErrors?.order_by
                                    }
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
                                <div key={index} className="col-2">
                                    <RenderTableSearch
                                        item={item}
                                        search={search}
                                    />
                                </div>
                            ))}

                            <div className="col-2">
                                <label>{t('Search')}</label>
                                <SearchInput
                                    submit={getPurchases}
                                    name="keywords"
                                    value={search.formData?.keywords}
                                    handleChange={search.handleChange}
                                    errorMessage={
                                        search.formErrors?.keywords
                                    }
                                    placeholder={t(
                                        'Search by supplier'
                                    )}
                                />
                            </div>

                            <div className="col-2">
                                <PrimaryButton
                                    label={t('Search')}
                                    onClick={() => getPurchases()}
                                />
                            </div>
                        </div>
                    }
                    add={() => navigate('/purchases?form=add')}
                    columns={table.colums}
                    data={table.data}
                    links={table.links}
                    onEdit={handleEdit}
                    movePage={getPurchases}
                    loading={table.loading}
                />
            </div>
        </div>
    );
}
