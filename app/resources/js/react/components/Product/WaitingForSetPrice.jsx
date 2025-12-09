import React, { useCallback, useEffect, useState } from 'react'
import { formatMoney } from '../../libraries/common';
import ProductService from '../../services/ProductService';
import CommonDataTable from '../CommonDataTable';
import { PopupLayout } from '../../layouts/PopupLayout';
import { InputForm } from '../UI/Input/InputForm';
import { Select } from '../UI/Input/Select';
import TextArea from '../UI/Input/Textarea'
import { usePopup } from '../popups/PopupContext'
export default function WaitingForSetPrice() {
    const { openPopup } = usePopup();
    const [data, setData] = useState(null);
    const [selectItem, setSelectItem] = useState(null);
    const [selectItemError, setSelectItemError] = useState(null);
    const handleChange = (e) => {
        const { name, value } = e.target;
        setSelectItem((prev) => ({ ...prev, [name]: value }));
    };
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
        openPopup({
            type: 'warning',
            message: 'Are you sure modify product',
            onConfirm: () => {
                setSelectItem(row);
            }
        })

    };

    const handleDelete = (row) => {
        console.log("Delete clicked:", row);
    };
    const getProducts = useCallback(() => {
        ProductService.listForType({
            type: 'wait',
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
    const submit = useCallback(() => {
        setSelectItemError(null);
        ProductService.update(selectItem)
            .then((resp) => {
                getProducts();
                setSelectItem(null);
                openPopup({
                    type: 'success',
                    message: 'You has been modified'
                })
            })
            .catch((error) => {
                if (error.response.data?.errors) {
                    setSelectItemError(error.response.data?.errors);
                }
                if (error.response.data?.message) {
                    openPopup({
                        type: 'success',
                        message: 'You has been modified'
                    })
                }


            })
    }, [selectItem])
    return <div>
        <CommonDataTable
            columns={columns}
            data={data?.data}
            onEdit={handleEdit} />
        <div>
            {selectItem ? <PopupLayout onClose={() => {
                setSelectItem(null);
            }} title='Modify product' onConfirm={submit} >
                <div>
                    <div className='form-group mt-2'>
                        <label>Retail price	</label>
                        <InputForm handleChange={handleChange} name='retail_price' errorMessage={selectItemError?.retail_price} value={selectItem?.retail_price} />
                    </div>
                    <div className='form-group mt-2'>
                        <label>Wholesale price	</label>
                        <InputForm handleChange={handleChange} name='wholesale_price' errorMessage={selectItemError?.wholesale_price} value={selectItem?.wholesale_price} />
                    </div>
                    <div className='form-group mt-2'>
                        <label>Image </label>
                        <InputForm handleChange={handleChange} name='image' errorMessage={selectItemError?.image} type='file' value={selectItem?.image} />
                    </div>
                    <div className='form-group mt-2'>
                        <label>Status</label>
                        <Select
                            name='active'
                            errorMessage={selectItemError?.active}
                            handleChange={handleChange}
                            value={selectItem?.active}
                            options={[
                                { value: 0, label: 'Pendding' },
                                { value: 1, label: 'Ready for sale' }
                            ]}
                        />
                    </div>
                    <div className='form-group mt-2'>
                        <label>Desciption </label>
                        <TextArea handleChange={handleChange} name='description' errorMessage={selectItemError?.description} value={selectItem?.description} />
                    </div>
                </div>
            </PopupLayout> : null}

        </div>
    </div>
}