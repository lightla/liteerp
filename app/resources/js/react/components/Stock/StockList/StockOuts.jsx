import React from 'react'
import { useCallback, useEffect, useState } from "react";
import StockOutService from "../../../services/StockOutService";
import useTable from '../../../libraries/handleTable'
import CommonDataTable from '../../CommonDataTable';
import { Link } from 'react-router-dom';
import {useForm} from '../../../libraries/handleInput'
import {Select} from '../../UI/Input/Select';
import SearchInput from '../../UI/Input/SearchInput'
import { usePopup } from '../../popups/PopupContext';
import Currencies from '../../Currencies';
export default function StockOuts() {
    const search = useForm();
    const table = useTable();
    const {openPopup} = usePopup();

    const getListStockIn = useCallback((page = 0) => {
        table.setLoading(true)
        StockOutService.list({
            page: page,
            keywords: search.formData?.keywords ?? '',
            status: search.formData?.status ?? ''
        })
            .then((resp) => {
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
            label: "Customer", key: "customer_name", render: (name) => {
                return <span>{name}</span>
            }
        },
        {
            label: "Status", key: "status", render: (status) => {
                return <div className='theme-title'>
                    {status === 'invoiced' 
                    ? <span className='bg-warning badge'>Waiting for Shipping</span> 
                    : status === 'shipped' 
                    ? <span className='bg-primary badge'>Shipped</span>
                    : <span className='bg-success badge'>Completed</span>}
                </div>
            }
        },

        {
            label: "Invoice no", key: "document_no", render: (products) => {
                return <span>{products}</span>
            }
        },

        {
            label: "Quantity", key: "quantity", render: (products) => {
                return <span>{products}</span>
            }
        },

        {
            label: "Shipping fee",
            key: "shipping_fee",
            render: (name) => {
                return <span><Currencies amount={name}/></span>
            }
        },
        {
            label: "Expected delivery date",
            key: "expected_delivery_date",
            render: (date) => {
                return <span>{date}</span>
            }
        },
        {
            label: "View",
            key: "id",
            render: (id) => {
                return <Link to={'/stocks?stockout=' + id}>View</Link>
            }
        }
    ];
    useEffect(() => {
        getListStockIn();
    }, [search.formData?.status]);
    return <div className='mt-3'>
        <CommonDataTable
            loading={table.loading}
            filter={<div>
                <div className='d-flex'>
                    <div className='col-4'>
                        <label>Status</label>
                        <Select
                        name='status'
                        handleChange={search.handleChange}
                        value={search.formData?.status}
                        options={[
                            {value: 'invoiced', label: 'Waiting for shipping'},
                            {value: 'shipped', label: 'Shipped'}
                        ]}
                        />
                    </div>
                    <div className='col-4 mx-2'>
                        <label>Search</label>
                        <SearchInput
                        name='keywords'
                        value={search.formData?.keywords}
                        handleChange={search.handleChange}
                        placeholder='Search by invoice'
                        />
                    </div>
                </div>
            </div>}
            columns={columns}
            data={table.data}
            links={table.links}
        />
        
    </div>
}