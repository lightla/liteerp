import React from 'react'
import { useCallback, useEffect, useState } from "react";
import StockOutService from "../../../services/StockOutService";
import useTable from '../../../libraries/handleTable'
import CommonDataTable from '../../CommonDataTable';
import { Link, useNavigate } from 'react-router-dom';
import { useForm } from '../../../libraries/handleInput'
import { Select } from '../../UI/Input/Select';
import SearchInput from '../../UI/Input/SearchInput'
import { usePopup } from '../../popups/PopupContext';
import Currencies from '../../Currencies';
import StatusBadge from '../../StatusBadge';
import RenderFieldTableByList from '../../RenderFieldTableByList';
import { RenderTableSearch } from '../../RenderTableSearch';
export default function StockOuts() {
    const navigate = useNavigate();
    const search = useForm();
    const table = useTable();
    const { openPopup } = usePopup();

    const getListStockIn = useCallback((page = 0) => {
        table.setLoading(true)
        StockOutService.list({
            page: page,
            ...search.formData
        })
            .then((resp) => {
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
                table.setLoading(false)
            })
            .catch((error) => {
                if (error.response.message?.errors) {
                    openPopup({
                        type: 'error',
                        message: error.response.message?.errors
                    })
                }
            })
    }, [table, search.formData]);

    const view = useCallback(() => {
        StockOutService.view()
            .then((resp) => {
                table.addColums(resp.message.index,(item,data) => {
                    return <RenderFieldTableByList item={item} data={data}/>
                });
                search.setHookRender(resp.message.search)
            })
            .catch((error) => {
                if (error.response.message?.errors) {
                    openPopup({
                        type: 'error',
                        message: error.response.message?.errors
                    })
                }
            })
    }, []);

    useEffect(() => {
        table.setColums([
        { label: "ID", key: "id", render: (id) => <Link to={'/stock?id=' + id}>{id}</Link> },
        {
            label: "Customer", key: "customer_name", render: (name) => {
                return <span>{name}</span>
            }
        },
        {
            label: "Status", key: "status", render: (value) => {
                return <StatusBadge status={value} />
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
                return <span><Currencies amount={name} /></span>
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
            label: "Order status", key: "order_status", render: (value) => {
                return <StatusBadge status={value} />
            }
        },
    ])
        getListStockIn();
        view();
    }, []);
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
                                { value: 'pending', label: 'Pending' },
                                { value: 'shipped', label: 'Shipped' },
                                { value: 'completed', label: 'Completed' }
                            ]}
                        />
                    </div>
                    <div className='col-3 ml-2'>
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
                    {search.hookRender.map((item,index) => {
                        return <div className='col-3 ml-2'>
                            <RenderTableSearch item={item} search={search}/>
                        </div>
                    })}
                    <div className='col-6 ml-2'>
                        <label>Search</label>
                        <SearchInput
                            submit={getListStockIn}
                            name='keywords'
                            value={search.formData?.keywords}
                            handleChange={search.handleChange}
                            placeholder='Search by invoice'
                        />
                    </div>
                </div>
            </div>}
            columns={table.colums}
            data={table.data}
            links={table.links}
            iconEdit={<i className="bi bi-eye"></i>}
            onEdit={(row) => {
                navigate('/stocks?stockout=' + row.id)
            }}
        />

    </div>
}