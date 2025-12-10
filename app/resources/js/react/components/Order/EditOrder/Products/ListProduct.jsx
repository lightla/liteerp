import React, { useCallback, useEffect } from "react";
import CommonDataTable from "../../../CommonDataTable";
import Currencies from "../../../Currencies";
import useTable from "../../../../libraries/handleTable";
import { useForm } from "../../../../libraries/handleInput";
import InventoryService from '../../../../services/InventoryService'
export default function ListProduct({
    add = (product) => { },
    loading = false
}) {
    const columns = [
        { label: "ID", key: "id" },
        { label: "Name", key: "name" },
        { label: "Quantity", key: "quantity" },
        { label: "Category", key: "category" },
        {
            label: "Price", key: "price", render: (value) => {
                return <Currencies amount={value}/>;
            }
        },
        {
            label: "Warehouse", key: "warehouse", render: (value) => {
                return value;
            }
        }
    ];
    const table = useTable();
    const search = useForm();
    const getInventories = useCallback((page = 0) => {
        table.setLoading(true);
        InventoryService.list({
            keywords: search.formData?.keywords ?? '',
            page: page,
            isOrder: 1
        })
            .then((resp) => {
                console.log(resp)
                table.setData(resp.message.data);
                table.setLinks(resp.message.links)
                table.setLoading(false);
            })
            .catch((error) => {

            })
    }, [search.formData?.keywords]);
    useEffect(() => {
        getInventories();
    },[])
    return <div>
        <h4 className="h5">Inventory</h4>
        <CommonDataTable
            loading={table.loading}
            columns={columns}
            data={table?.data}
            links={table?.links}
            iconEdit={<i className="bi bi-plus-square"></i>}
            onEdit={(row) => {
                add(row)
            }}
        />
    </div>
}