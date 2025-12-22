import React from 'react'
import { useCallback, useEffect, useState } from "react";
import StockInService from "../../../services/StockInService";
import useTable from '../../../libraries/handleTable'
import CommonDataTable from '../../CommonDataTable';
import { Link, useNavigate } from 'react-router-dom';
import { isoToDateTime } from '../../../libraries/common';
import {useForm} from '../../../libraries/handleInput'
import {Select} from '../../UI/Input/Select';
import SearchInput from '../../UI/Input/SearchInput'
import { usePopup } from '../../popups/PopupContext';
import StatusBadge from '../../StatusBadge'
export default function StockIns() {
    const navigate = useNavigate();
    const search = useForm();
    const table = useTable();
    const {openPopup} = usePopup();

    const getListStockIn = useCallback((page = 0) => {
        table.setLoading(true)
        StockInService.list({
            page: page,
            keywords: search.formData?.keywords ?? '',
            status: search.formData?.status ?? '',
            order_by: search.formData?.order_by ?? ''
        }).then((resp) => {
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
                table.setLoading(false)
            })
            .catch((error) => {
                if(error.response.message?.errors) {
                    openPopup({
                        type: 'error',
                        message: error.response.message?.errors
                    })
                }
            })
    }, [table]);

    const columns = [
        { label: "ID", key: "id", render: (id) => <Link to={'/stock?id=' + id}>{id}</Link> },
        {
            label: "Supplier", key: "supplier_name", render: (name) => {
                return <span>{name}</span>
            }
        },
        {
            label: "Purchase ID", key: "purchase_id", render: (name) => {
                return <span>PU{name}</span>
            }
        },
        {
            label: "Invoice no", key: "document_no", render: (document_no) => {
                return <span>{document_no}</span>
            }
        },
        {
            label: "Status", key: "status", render: (value) => {
                return <StatusBadge status={value} />
            }
        },

        {
            label: "Products", key: "total_product", render: (products) => {
                return <span>{products}</span>
            }
        },

        {
            label: "Approver",
            key: "approved_name",
            render: (name) => {
                return name ? <span className='badge bg-success'>{name}</span> : '-'
            }
        },
        {
            label: "Import date",
            key: "import_date",
            render: (date) => {
                return date ? isoToDateTime(date) : '-'
            }
        },
        {
            label: "Purchase status",
            key: "purchase_status",
            render: (value) => {
                return <StatusBadge status={value} />
            }
        }
    ];

    useEffect(() => {
        getListStockIn();
    }, [search.formData?.status,search.formData?.order_by]);
    return <div className='mt-3'>
        <CommonDataTable
            loading={table.loading}
            filter={<div>
                <div className='d-flex'>
                    <div className='col-3'>
                        <label>Status</label>
                        <Select
                        name='status'
                        handleChange={search.handleChange}
                        value={search.formData?.status}
                        options={[
                            {value: 'received', label: 'Received'},
                            {value: 'pending', label: 'Pending'},
                            {value: 'cancelled', label: 'Cancelled'}
                        ]}
                        />
                    </div>
                    <div className='col-3 mx-2'>
                        <label>Order by</label>
                        <Select
                            name='order_by'
                            value={search.formData?.order_by}
                            handleChange={search.handleChange}
                            errorMessage={search.formErrors?.order_by}
                            options={[
                                { value: 'ASC', label: 'Oldest' },
                                { value: 'DESC', label: 'Newest' }
                            ]} />
                    </div>
                    <div className='col-6'>
                        <label>Search</label>
                        <SearchInput
                        submit={getListStockIn}
                        placeholder='Search by invoice no'
                        name='keywords'
                        value={search.formData?.keywords}
                        handleChange={search.handleChange}
                        />
                    </div>
                </div>
            </div>}
            columns={columns}
            data={table.data}
            links={table.links}
            iconEdit={<i className="bi bi-eye"></i>}
            onEdit={(row) => {
                navigate('/stocks?stockin=' + row.id)
            }}
        />
    </div>
}