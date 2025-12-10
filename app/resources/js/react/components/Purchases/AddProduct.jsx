import React, { useState, useCallback, useEffect } from 'react';
import ListProducts from './AddProduct/ListProduct';
import VerticalCommonTable from '../VerticalCommonTable'
import Currencies from '../Currencies';
export default function AddProduct({
    detail = null
}) {

    return (
        <div className="">

            <div className="d-flex">
                <div className="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                    <div className='mt-4'>
                        <h5 className="fw-bold mb-2 theme-title">Summary</h5>
                    </div>
                    <VerticalCommonTable data={{
                        shipping_fee: detail?.shipping_fee 
                            ? <Currencies amount={detail?.shipping_fee}/> : 0,
                        quantity: detail?.quantity ?? 0,
                        subtotal: detail?.subtotal 
                            ? <Currencies amount={detail?.subtotal}/> : 0,
                        total_tax: detail?.total_tax 
                            ? <Currencies amount={detail?.total_tax}/> : 0,
                        total: detail?.total 
                            ? <Currencies amount={detail?.total}/> : 0,
                    }} />
                </div>

                <div className="col-xs-12 col-sm-8 col-md-10 col-lg-10">
                    <ListProducts purchase={detail} />
                </div>
            </div>
            <div>

            </div>
        </div>
    );
}
