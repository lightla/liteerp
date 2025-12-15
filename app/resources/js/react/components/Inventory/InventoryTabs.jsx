import React, { useCallback, useEffect } from 'react'
import useTable from '../../libraries/handleTable';
import InventoryService from '../../services/InventoryService';
import CommonDataTable from '../CommonDataTable';
import SearchInput from '../UI/Input/SearchInput';
import { useForm } from '../../libraries/handleInput';
export default function InventoryTabs() {
    const table = useTable();
    const search = useForm();
    const getInventory = useCallback((page = 0) => {
        table.setLoading(true);
        InventoryService.list({
            keywords: search.formData?.keywords ?? '',
            page: page
        })
            .then((resp) => {
                table.setLoading(false);
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
            })
    }, [search.formData?.keywords]);
    useEffect(() => {
        getInventory();
    }, []);
    return <div>
        <CommonDataTable
            filter={<div>
                <div className='row'>
                    <div className='col-6'>
                        <SearchInput 
                        submit={getInventory}
                        value={search.formData?.keywords}
                        name='keywords'
                        handleChange={search.handleChange}
                        placeholder='Search by name' />
                    </div>
                </div>
            </div>}
            columns={[
                { key: "id", label: "ID" },
                { key: "name", label: "Name" },
                { key: "quantity", label: "Quantity" },
                { key: "reserved_qty", label: "Reserved qty" },
                { key: "sku", label: "Sku" },
                { key: "unit", label: "Unit" },
                { key: "warehouse", label: "Warehouse" },
                { key: "category", label: "Category" }
            ]}
            data={table.data}
            links={table.links}
            movePage={getInventory}
            loading={table.loading}
        />
    </div>
}