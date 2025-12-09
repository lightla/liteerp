import React, { useCallback, useEffect, useRef, useState } from 'react'
import OrderService from '../../services/OrderService';
import { useNavigate, useSearchParams } from 'react-router-dom';
import CustomerDetail from './DetailOrder/CustomerDetail';
import ProductService from '../../services/ProductService';
import ProductAdded from './DetailOrder/ProductAdded';
import ListProduct from './DetailOrder/ListProduct';
import { PopupLayout } from '../../layouts/PopupLayout';
import { InputForm } from '../UI/Input/InputForm';
import OrderItemService from '../../services/OrderItemService'
import { usePopup } from '../popups/PopupContext';
import SearchInput from '../UI/Input/SearchInput';
import { formatMoney, isoToDateTime } from '../../libraries/common';
import ShippingForm from './DetailOrder/ShippingForm';
import { useReactToPrint } from "react-to-print";
import {useForm} from '../../libraries/handleInput'
export default function A() {
    const navigate = useNavigate();
    const [showAdd, setShowAdd] = useState(false);
    const { openPopup } = usePopup();
    const form = useForm();
    const [shippingReady, setShippingReady] = useState(false);
    const search = useForm();
    const [showConfirm, setShowConfirm] = useState(false);
    const [searchParams] = useSearchParams();
    const [order, setOrder] = useState(null);
    const [productAdded, setProductAdded] = useState([]);
    const [loadingProductAdded, setLoadingProductAdded] = useState(true);
    const [productList, setProductList] = useState([]);
    const [loadingProductTable, setLoadingProductTable] = useState(false);
    const getDetail = useCallback(() => {
        OrderService.show(searchParams.get('id'))
            .then((resp) => {
                setOrder(resp.message);
            })
            .catch((error) => {
                navigate('/orders')
            })
    }, [searchParams, OrderService]);
    const getProducts = useCallback((page = 0) => {
        setLoadingProductTable(true);
        ProductService.list({
            keywords: search.formData?.keywords ?? '',
            page: page,
            active: 1
        })
            .then((resp) => {
                console.log(resp)
                setProductList(resp.message);
                setLoadingProductTable(false);
            })
            .catch((error) => {

            })
    }, [search.formData]);
    const getOrderItem = useCallback((page = 0) => {
        setLoadingProductAdded(true);
        OrderItemService.list({
            order_id: searchParams.get('id'),
            page: page
        })
            .then((resp) => {
                setProductAdded(resp.message);
                setLoadingProductAdded(false);
            })
            .catch((error) => {

            })
    }, [searchParams]);
    const submit = useCallback(() => {
        if (Number(form.formData?.buy_quantity ?? 0) === 0
            && Number(form.formData?.compensation_quantity ?? 0) === 0
            && Number(form.formData?.conversion_quantity ?? 0) === 0
            && Number(form.formData?.gift_quantity ?? 0) === 0) {
            openPopup({
                type: 'error',
                message: 'You need to choose at least 1 of the 4 options from buy, compensaction, conversion, gift'
            })
            return;
        }
        const submitData = {
            ...form.formData,
            product_id: form.formData?.id,
            order_id: searchParams.get('id')
        }
        OrderItemService.add(submitData)
            .then((resp) => {
                getOrderItem();
                openPopup({
                    type: 'success',
                    message: 'You has been added'
                })
            })
            .catch((error) => {
                if (error.response.data?.errors) {
                    form.setFormErrors(error.response.data?.errors);
                }
                if(error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            })
    }, [form.formData]);

    useEffect(() => {
        getDetail();
        getProducts();
        getOrderItem();
    }, [getDetail]);
    const printRef = useRef(null);

    const handlePrint = useReactToPrint({
        contentRef: printRef,
        documentTitle: "Invoice",
    });
    const update = useCallback(() => {
        OrderService.update({
            id: searchParams.get('id'),
            status: 'approved'
        })
            .then((resp) => {
                getDetail();
            })
            .catch((error) => {

            })
    }, [searchParams]);
    return <div className="m-4">
        <div>
            <div className="d-flex justify-content-between align-items-center">
                <div>
                    <h5 className="fw-bold mb-2 theme-title">Take a order</h5>
                </div>
                <div>
                    {order?.status === 'pending' ? <div>
                        <span onClick={() => {
                            if (!shippingReady) {
                                openPopup({
                                    type: 'error',
                                    message: 'You has not yet set shipping information'
                                })
                                return;
                            }
                            if (!productAdded) {
                                openPopup({
                                    type: 'error',
                                    message: 'You has not yet add products'
                                })
                                return;
                            }
                            setShowConfirm(showConfirm ? false : true);
                        }} className="h6 badge bg-primary btn mx-2"><strong>{showConfirm ? 'Back' : 'Next step'}</strong></span>
                        {showConfirm ? <span onClick={update} className="h6 badge bg-success btn mx-2">Approved</span> : null}
                    </div> : order?.status === 'approved' ? <span onClick={handlePrint} className="h6 badge bg-success btn mx-2">Print</span> : null}
                </div>
            </div>
            <div ref={printRef}>
                <div className='d-flex theme-card p-4 mb-4 mt-2 rounded-4 border'>
                    <div className='col-xs-12 col-sm-3 col-md-2 col-lg-2'>
                        <label>Order Number</label>
                        <h6>{order?.order_no}</h6>
                    </div>
                    <div className='col-xs-12 col-sm-3 col-md-2 col-lg-2'>
                        <label>Order date</label>
                        <h6>{order?.order_date ? isoToDateTime(order?.order_date) : ''}</h6>
                    </div>
                    <div className='col-xs-12 col-sm-3 col-md-2 col-lg-2'>
                        <label>Type Order</label>
                        <h6>{order?.type}</h6>
                    </div>
                    <div className='col-xs-12 col-sm-3 col-md-2 col-lg-2'>
                        <label>Expected delivery date</label>
                        <h6>{order?.expected_delivery_date ? isoToDateTime(order?.expected_delivery_date) : ''}</h6>
                    </div>
                    <div className='col-xs-12 col-sm-3 col-md-2 col-lg-2'>
                        <label>Seller</label>
                        <h6>{order?.creator?.name}</h6>
                    </div>
                    <div className='col-xs-12 col-sm-3 col-md-2 col-lg-2'>
                        <label>Department</label>
                        <h6>SALE</h6>
                    </div>
                </div>
                <div className='d-flex'>
                    <div className='col-xs-12 col-sm-6 col-md-3 col-lg-3'>
                        {showConfirm || order?.status !== 'pending' ? <div className='theme-card p-2 rounded-4 border'>
                            <h2 className='h5'>Summary</h2>
                            <div className="table-responsive">
                                <table className="table table-bordered table-striped">
                                    <tbody>

                                        <tr>
                                            <th>Total quantity</th>
                                            <td>{productAdded?.summary?.total_quantity}</td>
                                        </tr>

                                        <tr>
                                            <th>Total tax</th>
                                            <td>{formatMoney(productAdded?.summary?.total_tax)}</td>
                                        </tr>

                                        <tr>
                                            <th>Discount</th>
                                            <td>{formatMoney(productAdded?.summary?.total_discount)}</td>
                                        </tr>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>{formatMoney(productAdded?.summary?.subtotal)}</td>
                                        </tr>
                                        <tr>
                                            <th>Fee shipping</th>
                                            <td>{formatMoney(0)}</td>
                                        </tr>
                                        <tr>
                                            <th>Total after tax</th>
                                            <td>{formatMoney(productAdded?.summary?.total_after_tax)}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div> : <div className='theme-card p-2 rounded-4 border'>
                            <h2 className='h5'>Customer info</h2>
                            <CustomerDetail data={order?.customer} />
                        </div>}

                        <div className='theme-card p-2 rounded-4 mt-3 border'>
                            {order ? <ShippingForm setShippingReady={setShippingReady} order={order} /> : null}
                        </div>
                    </div>
                    <div className='col-xs-12 col-sm-6 col-md-9 col-lg-9'>
                        <div className='mx-2'>
                            <div className='theme-card rounded-4 p-2 border'>
                                <h2 className='h5'>Ordered</h2>
                                <ProductAdded disabled={order?.status !== 'pending'}
                                    loading={loadingProductAdded}
                                    orderType={order?.type}
                                    data={productAdded.index} 
                                    />
                            </div>
                            {order?.status === 'pending' ? <div className='theme-card rounded-4 p-2 mt-3 border'>
                                <h2 className='h5'>Products</h2>
                                <div className='mx-4 row'>
                                    <div className='col-md-6'></div>
                                    <div className='col-md-6 mb-4'>
                                        <SearchInput
                                            name='keywords'
                                            value={search.formData?.keywords}
                                            placeholder='Search by name'
                                            handleChange={search.handleChange}
                                            submit={getProducts}
                                        />
                                    </div>
                                </div>
                                <ListProduct
                                    movePage={getProducts}
                                    loading={loadingProductTable}
                                    data={productList} add={(items) => {
                                        //console.log('id',id);
                                        //setSelectProduct(id);
                                        form.setFormData(items)
                                        setShowAdd(true)
                                    }} />
                            </div> : <div>

                            </div>}
                        </div>
                        {showAdd ? <PopupLayout onClose={() => {
                            setShowAdd(false)
                        }} onConfirm={submit} title='Add product to order'>
                            <div>
                                <div className='form-group'>
                                    <label>Discount</label>
                                    <InputForm handleChange={form.handleChange}
                                        name='discount' value={form.formData?.discount}
                                        errorMessage={form.formErrors?.discount} />
                                </div>
                                <div className='form-group mt-3'>
                                    <label>Tax(%)</label>
                                    <InputForm handleChange={form.handleChange}
                                        name='tax' value={form.formData?.tax}
                                        errorMessage={form.formErrors?.tax} />
                                </div>
                                <div className='form-group mt-3'>
                                    <label>Buy quantity</label>
                                    <InputForm handleChange={form.handleChange}
                                        name='buy_quantity' value={form.formData?.buy_quantity}
                                        errorMessage={form.formErrors?.buy_quantity} />
                                </div>
                                <div className='form-group mt-3'>
                                    <label>Gift quantity</label>
                                    <InputForm handleChange={form.handleChange}
                                        name='gift_quantity' value={form.formData?.gift_quantity}
                                        errorMessage={form.formErrors?.gift_quantity} />
                                </div>
                                <div className='form-group mt-3'>
                                    <label>Compensation quantity</label>
                                    <InputForm handleChange={form.handleChange}
                                        name='compensation_quantity' value={form.formData?.compensation_quantity}
                                        errorMessage={form.formErrors?.compensation_quantity} />
                                </div>
                                <div className='form-group mt-3'>
                                    <label>Conversion quantity</label>
                                    <InputForm handleChange={form.handleChange}
                                        name='conversion_quantity' value={form.formData?.conversion_quantity}
                                        errorMessage={form.formErrors?.conversion_quantity} />
                                </div>
                                <div className='form-group mt-3'>
                                    <label>Retail price</label>
                                    <InputForm handleChange={form.handleChange}
                                        name='retail_price' 
                                        value={form.formData?.retail_price}
                                        errorMessage={form.formErrors?.retail_price} />
                                </div>
                                <div className='form-group mt-3'>
                                    <label>Wholesale price</label>
                                    <InputForm handleChange={form.handleChange}
                                        name='wholesale_price' value={form.formData?.wholesale_price}
                                        errorMessage={form.formErrors?.wholesale_price} />
                                </div>
                            </div>
                        </PopupLayout> : null}

                    </div>
                </div>
            </div>
        </div>
    </div>
}