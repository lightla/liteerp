import React, { useCallback, useEffect, useState } from 'react'
import { formatMoney } from '../../libraries/common';
import ProductService from '../../services/ProductService';
import CommonDataTable from '../CommonDataTable';
export default function ReadyForSale() {
    const [data, setData] = useState(null);
    const columns = [
        { label: "ID", key: "id" },
        { label: "Name", key: "name" },
        { label: "Quantity", key: "quantity" },
        { label: "Category", key: "category.name" },
        {
            label: "Giá lẻ", key: "retail_price", render: (value) => {
                return formatMoney(value);
            }
        },
        {
            label: "Giá sỉ", key: "wholesale_price", render: (value) => {
                return formatMoney(value);
            }
        },
        {
            label: "Kho", key: "warehouse.name", render: (value) => {
                return value;
            }
        }
    ];

    const handleEdit = (row) => {
        console.log("Edit clicked:", row);
    };

    const handleDelete = (row) => {
        console.log("Delete clicked:", row);
    };
    const getProducts = useCallback(() => {
        ProductService.listForType({
            type: 'sale',
            page: 0,
            keywords: ''
        })
            .then((resp) => {
                setData(resp.message)
            })
            .catch((error) => {

            })
    }, []);
    useEffect(() => {
        getProducts();
    }, [getProducts]);
    return <div>
        <CommonDataTable
            columns={columns}
            data={data?.data}
            onEdit={handleEdit}
            onDelete={handleDelete} />
    </div>
}