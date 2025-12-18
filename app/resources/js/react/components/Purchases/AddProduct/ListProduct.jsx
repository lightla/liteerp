import React, { useCallback, useEffect, useMemo, useRef, useState } from 'react';
import CommonDataTable from '../../CommonDataTable';
import ProductService from '../../../services/ProductService';
import { Link, useNavigate, useSearchParams } from 'react-router-dom';
import { usePopup } from '../../popups/PopupContext';
import PrimaryButton from '../../UI/Buttons/PrimaryButton'
import { useForm } from '../../../libraries/handleInput';
import useTable from '../../../libraries/handleTable';
import PurchaseItemService from '../../../services/PurchaseItemService';
import { PopupLayout } from '../../../layouts/PopupLayout';
import { InputForm } from '../../UI/Input/InputForm';
import SearchSelect from '../../UI/Input/SearchSelect';
import PurchaseTaxService from '../../../services/PurchaseTaxService';
import Currencies from '../../Currencies';
import PurchaseService from '../../../services/PurchaseService';
import { useDispatch } from 'react-redux';
import { setPurchaseDetail } from '../../../redux/purchase/detailSlice';
export default function ListProducts({
    purchase = null
}) {
    const dispatch = useDispatch();
    const [checkList, setCheckList] = useState([]);
    const [isCheckAll, setIsCheckAll] = useState(false);
    const [showForm, setShowForm] = useState(false);
    const [showTaxForm, setShowTaxForm] = useState(false);
    const table = useTable();
    const [searchParams] = useSearchParams();
    const form = useForm();
    const taxForm = useForm();
    const { openPopup } = usePopup();
    const [products, setProducts] = useState([])
    const navigate = useNavigate();
    const getPurchaseDetail = useCallback(() => {
        PurchaseService.show(searchParams.get('id'))
            .then((resp) => {
                dispatch(setPurchaseDetail(resp.message))
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message,
                        onCancel: () => {
                            navigate('/purchases')
                        }
                    })
                }
            })
    }, []);
    const addToCheckList = (id) => {
        setCheckList(prev => {
            if (prev.includes(id)) {
                return prev.filter(x => x !== id);
            }
            return [...prev, id];
        });
    };

    const removeFromCheckList = (id) => {
        setCheckList(prev => prev.filter(item => item !== id));
    };
    const columns = useMemo(() => {
        return [
            {
                label: "Select",
                key: "id",
                render: (id) => (
                    <input
                        disabled={purchase.status !== 'draft'}
                        type="checkbox"
                        checked={checkList.includes(id)}
                        onChange={(e) => {
                            if (e.target.checked) {
                                addToCheckList(id);
                            } else {
                                removeFromCheckList(id);
                            }
                        }}
                    />
                )
            },
            {
                label: "Image", key: "image", render: (src) => (
                    src ? (
                        <img
                            src={src}
                            alt="product"
                            style={{ width: 50, height: 50, borderRadius: 8, objectFit: 'cover' }}
                        />
                    ) : (
                        <img src='/assets/icons/default_image.png' width={50} height={50} alt='' />
                    )
                )
            },
            { label: "Name", key: "name" },
            { label: "SKU", key: "sku" },
            { label: "Category", key: "category_name" },
            { label: "Buy", key: "buy_quantity" },
            { label: "Gift", key: "gift_quantity" },
            { label: "Compensation", key: "compensation_quantity" },
            { label: "Conversion", key: "conversion_quantity" },
            {
                label: "Unit cost", key: "unit_cost", render: (value) => {
                    return <span>{<Currencies amount={value} />}</span>
                }
            },
            {
                label: "Subtotal", key: "subtotal", render: (value) => (
                    <span>{<Currencies amount={value} />}</span>
                )
            },
            {
                label: "Tax", key: "tax", render: (value) => {
                    return <span>{value}%</span>
                }
            },
            {
                label: "Total tax", key: "total_tax", render: (value) => {
                    return <span>{<Currencies amount={value} />}</span>
                }
            },
            {
                label: "Total price", key: "total", render: (value) => (
                    <span>{<Currencies amount={value} />}</span>
                )
            }
        ]
    }, [checkList]);

    const handleEdit = (row) => {
        console.log("Edit clicked:", row);
        //navigate(`/products?edit=${row.id}`);
        form.setFormData(row);
        form.setIsEdit(true);
        setShowForm(true);
    };


    const create = useCallback(() => {
        form.setLoading(true);
        form.setFormErrors(null);
        PurchaseItemService.add({
            ...form.formData,
            purchase_id: searchParams.get('id')
        })
            .then(() => {
                getPurchaseItems();
                openPopup({
                    type: 'success',
                    message: 'You has been created',
                    onConfirm: () => {
                        setShowForm(false);
                    }
                });
                form.setFormData(null)
                form.setLoading(false);
                getPurchaseDetail();
            })
            .catch((error) => {
                if (error.response?.data?.errors) {
                    form.setFormErrors(error.response.data.errors);
                }
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
                form.setLoading(false);
            });
    }, [form.formData, searchParams]);
    const update = useCallback(() => {
        form.setLoading(true);
        form.setFormErrors(null);
        PurchaseItemService.update(form.formData)
            .then(() => {
                getPurchaseItems();
                openPopup({
                    type: 'success',
                    message: 'You has been update',
                    onConfirm: () => {
                        setShowForm(false);
                    }
                });
                form.setFormData(null);
                setShowForm(false);
                form.setLoading(false);
                getPurchaseDetail();
            })
            .catch((error) => {
                if (error.response?.data?.errors) {
                    form.setFormErrors(error.response.data.errors);
                }
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
                form.setLoading(false);
            });
    }, [form.formData, searchParams]);

    const destroy = useCallback((row) => {
        PurchaseItemService.delete(row)
            .then(() => {
                getPurchaseItems();
                openPopup({
                    type: 'success',
                    message: 'You has been update',
                    onConfirm: () => {
                        setShowForm(false);
                    }
                });
                getPurchaseDetail();
            })
            .catch((error) => {
                if (error.response?.data?.errors) {
                    form.setFormErrors(error.response.data.errors);
                }
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            });
    }, []);

    const handleDelete = (row) => {
        openPopup({
            type: 'warning',
            message: 'Are you sure to delete?',
            onConfirm: () => {
                destroy(row)
            }
        })
    };

    const getPurchaseItems = useCallback((page = 0) => {
        table.setLoading(true);
        PurchaseItemService.list({
            purchase_id: searchParams.get('id'),
            page: page
        })
            .then((resp) => {
                table.setData(resp.message.data);
                table.setLinks(resp.message.links);
                table.setLoading(false);
            })
            .catch((error) => {

            });
    }, [searchParams]);
    const getProducts = useCallback((keywords = '', callback = null) => {
        ProductService.list({
            keywords: keywords,
            page: 0,
            active: 1
        })
            .then((resp) => {
                setProducts(resp.message.data)
                if (callback) {
                    callback();
                }
            })
            .catch((error) => {

            });
    }, [searchParams]);
    const checkAll = useCallback(() => {
        setIsCheckAll(true)
        openPopup({
            type: 'warning',
            message: 'Are you sure select all',
            onConfirm: () => {
                let l = [];
                table.data?.map((item) => {
                    l.push(item.id)
                })
                setCheckList(l);
            }
        })
    }, [table.data]);
    const uncheckAll = useCallback(() => {
        setIsCheckAll(false)
        setCheckList([]);
    }, []);
    const setTax = () => {
        if (checkList.length === 0) {
            return;
        }
        PurchaseTaxService.add({
            id: searchParams.get('id'),
            purchase_item_id: checkList,
            tax: taxForm.formData?.tax
        })
            .then((resp) => {
                setIsCheckAll(false);
                setCheckList([]);
                openPopup({
                    type: 'success',
                    message: 'You has been updated'
                });
                setShowTaxForm(false);
                getPurchaseItems();
                taxForm.setFormData(null);
            })
            .catch((error) => {

            })
    };
    useEffect(() => {
        getPurchaseItems();
    }, []);
    return (
        <div className="m-4">
            <div className="d-flex justify-content-between align-items-center">
                <div>
                    <h5 className="fw-bold mb-2 theme-title">List products</h5>
                </div>
                {/* {purchase?.status === 'draft' ? <div>
                    <GradientButton callback={() => submit('requested')} text={'Send to approve'} />
                </div> : <div>
                    <GradientButton callback={() => submit('approved')} text={'Take a approve'} />
                </div>} */}
            </div>

            <CommonDataTable
                filter={<div className='row'>
                    <div className='col-3'>
                        <PrimaryButton disabled={purchase?.status !== 'draft' || table.data.length === 0} onClick={!isCheckAll ? checkAll : uncheckAll} label={'Check all'} />
                    </div>
                    <div className='col-3'>
                        <PrimaryButton
                            disabled={checkList.length >= 1 ? false : true}
                            onClick={() => {
                                if (checkList.length >= 1) {
                                    return setShowTaxForm(true)
                                }
                            }} label='Tax (%)' />
                    </div>
                </div>}
                movePage={getPurchaseItems}
                loading={table.loading}
                add={purchase?.status !== 'draft' ? null : () => setShowForm(true)}
                links={table.links}
                columns={columns}
                data={table.data}
                onEdit={purchase?.status !== 'draft' ? null : handleEdit}
                onDelete={purchase?.status !== 'draft' ? null : handleDelete}
            />
            {showForm ? <PopupLayout
                loading={form.loading}
                confirmText='Save change'
                onClose={() => {
                    setShowForm(false);
                    form.setIsEdit(false);
                }}
                onConfirm={form.isEdit ? update : create} title='Add product'>
                <h4>Information</h4>
                <div className="mb-3 form-group">
                    <label className='theme-title'>Product</label>
                    <SearchSelect
                        placeholder='Search by name or sku'
                        name="product_id"
                        value={form.formData?.product_id}
                        changeValue={form.handleChangeByKey}
                        errorMessage={form.formErrors?.product_id}
                        search={getProducts}
                        options={products.map((item) => {
                            return {
                                value: item.id,
                                label: item.name
                            }
                        })}
                        defaultKeywords={form.formData?.name ?? ''}
                    />
                </div>

                <div className='row'>
                    <div className="mb-3 form-group col-6">
                        <label className='theme-title'>Discount</label>
                        <InputForm
                            name="discount"
                            type='number'
                            value={form.formData?.discount}
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.discount}
                        />
                    </div>

                    <div className="mb-3 form-group col-6">
                        <label className='theme-title'>Tax</label>
                        <InputForm
                            name="tax"
                            type='number'
                            value={form.formData?.tax}
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.tax}
                        />
                    </div>
                </div>
                <div className="mb-3 form-group">
                    <label className='theme-title'>Product link</label>
                    <InputForm
                        name="product_link"
                        type='text'
                        value={form.formData?.product_link}
                        handleChange={form.handleChange}
                        errorMessage={form.formErrors?.product_link}
                    />
                </div>
                <div className='row'>
                    <div className="mb-3 form-group col-6">
                        <label className='theme-title'>Buy quantity</label>
                        <InputForm
                            name="buy_quantity"
                            type='text'
                            value={form.formData?.buy_quantity}
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.buy_quantity}
                        />
                    </div>
                    <div className="mb-3 form-group col-6">
                        <label className='theme-title'>Gift quantity</label>
                        <InputForm
                            name="gift_quantity"
                            type='number'
                            value={form.formData?.gift_quantity}
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.gift_quantity}
                        />
                    </div>
                    <div className="mb-3 form-group col-6">
                        <label className='theme-title'>Compensation quantity</label>
                        <InputForm
                            name="compensation_quantity"
                            type='number'
                            value={form.formData?.compensation_quantity}
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.compensation_quantity}
                        />
                    </div>
                    <div className="mb-3 form-group col-6">
                        <label className='theme-title'>Conversion quantity</label>
                        <InputForm
                            name="conversion_quantity"
                            type='number'
                            value={form.formData?.conversion_quantity}
                            handleChange={form.handleChange}
                            errorMessage={form.formErrors?.conversion_quantity}
                        />
                    </div>
                </div>
                <div className="mb-3 form-group">
                    <label className='theme-title'>Unit cost</label>
                    <InputForm
                        name="unit_cost"
                        type='number'
                        value={form.formData?.unit_cost}
                        handleChange={form.handleChange}
                        errorMessage={form.formErrors?.unit_cost}
                    />
                </div>
            </PopupLayout> : null}
            {showTaxForm ? <PopupLayout
                onConfirm={setTax}
                title='Set tax products'
                confirmText='Change'
                onClose={() => {
                    setShowTaxForm(false)
                }}>
                <div>
                    <label>Tax (%)</label>
                    <InputForm
                        name='tax'
                        errorMessage={taxForm.formErrors?.tax}
                        handleChange={taxForm.handleChange}
                        value={taxForm.formData?.tax}
                        placeholder='Enter tax for products selected'
                    />
                </div>
            </PopupLayout> : null}
        </div>
    );
}
