import React from "react";
import CommonDataTable from "../../../CommonDataTable";
import Currencies from '../../../Currencies';

export default function ProductAdded({ 
    table = null, 
    form=null, 
    movePage = (page) => {}, 
    loading = false, 
    disabled = false,
    setShowForm = (status) => {}, 
    onDelete = (value) => {}
    }) {
    
    const columns = [
        { label: "Name", key: "name" },
        { label: "Unit", key: "unit" },
        {
            label: 'Price',
            key: "price",
            render: (value) => {
                return <Currencies amount={value}/>
            }
        },

        {
            label: "Buy",
            key: "buy_quantity",
            render: (v) => Number(v)
        },

        {
            label: "Gift",
            key: "gift_quantity",
            render: (v) => Number(v)
        },

        {
            label: "Compensation",
            key: "compensation_quantity",
            render: (v) => Number(v)
        },

        {
            label: "Conversion",
            key: "conversion_quantity",
            render: (v) => Number(v)
        },

        {
            label: "Discount",
            key: "discount",
            render: (value) => {
                return <span>{value}%</span>
            }
        },

        { label: "Tax (%)", key: "tax" },
        { label: "Warehouse", key: "warehouse" }
    ];

    return (
        <div>
            <h4 className="h5">Added to order</h4>
            <CommonDataTable
                columns={columns}
                data={table?.data}
                links={table?.links}
                movePage={movePage}
                onEdit={ disabled ? null : (row) => {
                    form.setFormData(row);
                    form.setIsEdit(true);
                    setShowForm(true)
                }}
                onDelete={disabled ? null :(row) => {
                    onDelete(row)
                }}
                loading={loading}
            />
        </div>
    );
}
