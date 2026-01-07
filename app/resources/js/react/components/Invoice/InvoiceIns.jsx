import React from 'react'
import { useCallback, useEffect, useState } from "react";
import { useForm } from "../../libraries/handleInput";
import InvoiceInService from "../../services/InvoiceInService";
import CommonDataTable from "../CommonDataTable";
import SearchInput from "../UI/Input/SearchInput";
import useTable from "../../libraries/handleTable";
import { usePopup } from "../popups/PopupContext";
import { Select } from '../UI/Input/Select';
import { useNavigate } from 'react-router-dom';
import Currencies from '../../components/Currencies'
import StatusBadge from '../StatusBadge'
import RenderFieldTableByList from '../RenderFieldTableByList'
import { RenderTableSearch } from '../RenderTableSearch';
import PrimaryButton from '../UI/Buttons/PrimaryButton';
import { useI18n } from '../../../i18n/useI18n';

export default function InvoiceIns() {
    const { t } = useI18n();
    const navigate = useNavigate();
    const { openPopup } = usePopup();
    const table = useTable();
    const search = useForm();

    const handleEdit = useCallback((row) => {
        navigate('/invoices?form=invoicein&id=' + row.id)
    }, []);

    const listInvoice = useCallback((page = 0) => {
        table.setLoading(true);
        InvoiceInService.list({
            page: page,
            ...search.formData
        })
            .then((resp) => {
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
                table.setLoading(false);
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            });
    }, [search.formData]);

    const view = useCallback((page = 0) => {
        InvoiceInService.view()
            .then((resp) => {
                table.addColums(resp.message.index, (item, data) => {
                    return <RenderFieldTableByList item={item} data={data} />
                })
                search.setHookRender(resp.message.search)
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            });
    }, []);

    useEffect(() => {
        listInvoice();
        view();
        table.setColums([
            {
                label: t("Supplier"),
                key: "unit_name",
                render: (value) => value ?? <span className="text-muted fst-italic">{value}</span>,
            },
            {
                label: t("Purchase ID"),
                key: "purchase_id",
                render: (value) => {
                    return <span className="">PU{value}</span>
                },
            },
            {
                label: t("Invoice no"), // Đổi từ Document no để khớp với các key trước đó của bạn
                key: "document_no",
                render: (value) => value ?? <span className="text-muted fst-italic">{value}</span>,
            },
            {
                label: t("Subtotal"),
                key: "subtotal",
                render: (value) => <span>
                    <Currencies amount={value} />
                </span>,
            },
            {
                label: t("Tax"),
                key: "tax",
                render: (value) => <span><Currencies amount={value} /></span>,
            },
            {
                label: t("Total price"), // Đổi từ Total paid để khớp key t("Total price")
                key: "total",
                render: (value) => <strong><Currencies amount={value} /></strong>,
            },
            {
                label: t("Status"),
                key: "approved",
                render: (value) => {
                    return <StatusBadge status={value ? 'approved' : 'unapproved'} />
                },
            },
            {
                label: t("Import date"), // Đổi từ Invoice date để khớp key t("Import date")
                key: "invoice_date",
                render: (value) =>
                    value ?? "",
            },
            {
                label: t("Payment"),
                key: "payment_status",
                render: (value) => {
                    return <StatusBadge status={value} />
                }
            },
            {
                label: t("Purchase status"),
                key: "purchase_status",
                render: (value) => {
                    return <StatusBadge status={value} />
                }
            },
        ])
    }, []);

    return <div>
        <CommonDataTable
            loading={table.loading}
            filter={<div className="row">
                <div className="col-2">
                    <label>{t("Status")}</label>
                    <Select
                        name="payment_status"
                        value={search.formData?.payment_status}
                        handleChange={search.handleChange}
                        options={[
                            { value: '', label: t('All') },
                            { value: 'partial_payment', label: t('Partial') },
                            { value: 'paid', label: t('Paid') },
                            { value: 'pending', label: t('Pending') }
                        ]}
                    />
                </div>
                <div className='col-2'>
                    <label>{t("Order by")}</label>
                    <Select
                        name='order_by'
                        value={search.formData?.order_by}
                        handleChange={search.handleChange}
                        errorMessage={search.formErrors?.order_by}
                        options={[
                            { value: 'ASC', label: t('Oldest') },
                            { value: 'DESC', label: t('Newest') }
                        ]} />
                </div>
                {search.hookRender.map((item, index) => {
                    return <div className='col-2' key={index}>
                        <RenderTableSearch item={item} search={search} />
                    </div>
                })}
                <div className="col-2">
                    <label>{t("Search")}</label>
                    <SearchInput
                        placeholder={t("Search by invoice no")}
                        submit={listInvoice}
                        value={search.formData?.keywords}
                        name="keywords"
                        handleChange={search.handleChange}
                    />
                </div>
                <div className="col-2">
                    <PrimaryButton label={t('Search')} onClick={() => listInvoice()} />
                </div>
            </div>}
            columns={table.colums}
            data={table.data}
            links={table.links}
            onEdit={handleEdit}
            movePage={listInvoice}
        />
    </div>
}