import React, { useState, useCallback, useEffect } from 'react';
import { useNavigate, useSearchParams } from 'react-router-dom';
import ListProducts from './AddProduct/ListProduct';
import { usePopup } from '../../components/popups/PopupContext';
import PurchaseService from '../../services/PurchaseService'
import { useForm } from '../../libraries/handleInput'
import VerticalCommonTable from '../VerticalCommonTable'
import { formatMoney, isoToDateTime } from '../../libraries/common';
import GradientButton from '../UI/Buttons/GradientButton';
import SecondaryButton from '../UI/Buttons/SecondaryButton';
import WarningButton from '../UI/Buttons/WarningButton';
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
                            ? formatMoney(detail?.shipping_fee) : 0,
                        quantity: detail?.quantity ?? 0,
                        subtotal: detail?.subtotal 
                            ? formatMoney(detail?.subtotal) : 0,
                        total_tax: detail?.total_tax 
                            ? formatMoney(detail?.total_tax) : 0,
                        total: detail?.total 
                            ? formatMoney(detail?.total) : 0,
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
