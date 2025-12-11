import React, { useCallback, useEffect, useState } from 'react'
import CommonDataTable from '../CommonDataTable';
import { Link, useNavigate, useSearchParams } from 'react-router-dom';
import { Select } from "../UI/Input/Select";
import OrderService from '../../services/OrderService';
import { usePopup } from '../popups/PopupContext';
import { useForm } from '../../libraries/handleInput';
import useTable from '../../libraries/handleTable'
import SearchInput from '../UI/Input/SearchInput';
import PageHead from '../PageHead';
export default function ListOrder() {
    const navigate = useNavigate();
    const { openPopup } = usePopup();
    const table = useTable();
    const search = useForm();
    const columns = [
        { label: "ID", key: "id" },
        { label: "Customer name", key: "customer_name" },
        { label: "Address shipping", key: "customer_address" },
        {
            label: "Order type", key: "type",render: (value) => {
                return <span className='badge bg-primary text-uppercase'>{value}</span>
            }
        },
        { label: "Order no", key: "order_no" },
        {
            label: "Products",
            key: "total_product",
            render: (value) => {
                return <span>{value}</span>
            }
        },
        {
            label: "Status",
            key: "status",
            render: (value) => (
                <span
                    className={`badge text-uppercase rounded-pill px-3 py-2 ${value === 'pending' ? 'bg-secondary' : 'bg-success'}`}>
                    {value}
                </span>
            ),
        }
    ];

    const handleEdit = (row) => {
        navigate('/orders?form=edit&id=' + row.id)
    };

    const handleDelete = (row) => {
        console.log("Delete clicked:", row);
    };
    const getOrders = useCallback((page = 0) => {
        table.setLoading(true);
        OrderService.list({
            page: page,
            keywords: search.formData?.keywords ?? '',
            status: search.formData?.status ?? ''
        })
        .then((resp) => {
            table.setData(resp.message.data);
            table.setLinks(resp.message.links);
            table.setLoading(false);
        })
        .catch((error) => {
            if(error.response.data?.message) {
                openPopup({
                    type: 'error',
                    message: error.response.data?.message
                })
            }
        })
    },[search.formData]);
    useEffect(() => {
        getOrders();
    }, [search.formData?.status]);
    return <div>
        <div>
            <PageHead
            containerClass='mx-4'
            title='Orders'
            subtitle='Manage orders'
            />
            <div className="m-4">
                <CommonDataTable
                    filter={<div className='d-flex'>
                        <div className='col-4'>
                            <label>Status</label>
                            <Select 
                            name='status'
                            handleChange={search.handleChange}
                            value={search.formData?.status}
                            options={[
                                {value:'pending',label: 'Pending'},
                                {value:'approved',label: 'Approved'},
                                {value:'cancelled',label: 'Cancelled'}
                            ]}
                            />
                        </div>
                        <div className='col-4 mx-2'>
                            <label>Search</label>
                            <SearchInput
                            submit={getOrders}
                            name='keywords'
                            handleChange={search.handleChange}
                            value={search.formData?.keywords}
                            placeholder='Search by customer name'
                            />
                        </div>
                    </div>}
                    add={() => navigate('/orders?form=add')}
                    columns={columns}
                    data={table?.data}
                    links={table?.links}
                    onEdit={handleEdit}
                    onDelete={handleDelete}
                    loading={table.loading}
                    movePage={getOrders}
                />
                <div>
                   
                </div>
            </div>
        </div>
    </div>
}