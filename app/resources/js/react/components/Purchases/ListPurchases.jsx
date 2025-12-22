import React, { useCallback, useEffect, useMemo, useState } from 'react';
import CommonDataTable from '../CommonDataTable';
import PurchaseService from '../../services/PurchaseService';
import { Select } from '../UI/Input/Select'
import { Link, useNavigate } from 'react-router-dom';
import { usePopup } from '../popups/PopupContext';
import SearchInput from '../UI/Input/SearchInput';
import useTable from '../../libraries/handleTable'
import { useForm } from '../../libraries/handleInput'
import PageHead from '../PageHead';
import Currencies from '../Currencies';
import { isoToDateTime } from '../../libraries/common';
import StatusBadge from '../StatusBadge';
import PaymentMethod from '../PaymentMethod';
import ContentOnTable from '../ContentOnTable';
export default function ListPurchases() {
    const navigate = useNavigate();
    const { openPopup } = usePopup();
    const search = useForm();
    const table = useTable();

    const columns = [
        {
            label: "ID", key: "id", render: (id) => {
                return <span>PU{id}</span>
            }
        },
        { label: "Supplier", key: "supplier_name",render: (value) => {
            return <ContentOnTable value={value} max={15}/>
        } },
        {
            label: "Purchase date", key: "purchase_date", render: (date) => {
                return isoToDateTime(date);
            }
        },
        {
            label: "Expected date", key: "expected_date", render: (date) => {
                return isoToDateTime(date);
            }
        },
        {
            label: "Shipping fee", key: "shipping_fee", render: (value) => {
                return <strong>
                    <Currencies amount={value} />
                </strong>
            }
        },
        { label: "Payment method", key: "payment_method", render:(value) => {
            return <PaymentMethod value={value}/>
        } },
        { label: "Buy", key: "buy_quantity" },
        { label: "Compensation", key: "compensation_quantity" },
        { label: "Conversion", key: "conversion_quantity" },
        { label: "Gift", key: "gift_quantity" },
        {
            label: "Tax", key: "tax", render: (value) => {
                return <strong>
                    <Currencies amount={value} />
                </strong>
            }
        },
        {
            label: "Status", key: "status", render: (value) => {
                return <StatusBadge status={value} />
            },
        },
        { label: "Approved by", key: "approved_name", render:(value) => {
            return <span className='badge bg-primary text-uppercase'>{value}</span>
        } },
        { label: "Created by", key: "created_name", render:(value) => {
            return <span className='badge bg-primary text-uppercase'>{value}</span>
        } },
    ];

    const handleEdit = (row) => {
        navigate('/purchases?form=edit&id=' + row.id)
    };
    const getPurchases = useCallback((page = 0) => {
        table.setLoading(true);
        PurchaseService.list({
            keywords: search.formData?.keywords ?? '',
            page: page,
            status: search.formData?.status ?? '',
            order_by: search.formData?.order_by ?? '',
        })
            .then((resp) => {
                //setPurchaseData(resp.message.data)
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
    useEffect(() => {
        getPurchases();
    }, [search.formData?.status,search.formData?.order_by])
    return <div>
        <div>
            <PageHead
                containerClass='mx-4'
                title='Purchases'
                subtitle='Track your offers, approval and payment status.'
            />
        </div>
        <div className="m-4">

            <CommonDataTable
                filter={<div className='d-flex'>
                    <div className='col-3'>
                        <label>Status</label>
                        <Select
                            name='status'
                            value={search.formData?.status}
                            handleChange={search.handleChange}
                            errorMessage={search.formErrors?.status}
                            options={[
                                { value: 'draft', label: 'Draft' },
                                { value: 'requested', label: 'Requested' },
                                { value: 'approved', label: 'Approved' },
                                { value: 'cancelled', label: 'Cancelled' }
                            ]} />
                    </div>
                    <div className='col-3 mx-2'>
                        <label>Order by</label>
                        <Select
                            name='order_by'
                            value={search.formData?.order_by}
                            handleChange={search.handleChange}
                            errorMessage={search.formErrors?.order_by}
                            options={[
                                { value: 'ASC', label: 'Old' },
                                { value: 'DESC', label: 'New' }
                            ]} />
                    </div>
                    <div className='col-6'>
                        <label>Search</label>
                        <SearchInput
                            submit={getPurchases}
                            name='keywords'
                            value={search.formData?.keywords}
                            handleChange={search.handleChange}
                            errorMessage={search.formErrors?.keywords}
                            placeholder='Search by supplier' />
                    </div>
                </div>}
                add={() => navigate('/purchases?form=add')}
                columns={columns}
                data={table.data}
                links={table.links}
                onEdit={handleEdit}
                movePage={getPurchases}
                loading={table.loading}
            />


        </div>
    </div>
}