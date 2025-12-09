import React, { useEffect, useState } from 'react'
import BusinessLayout from "../layouts/BusinessLayout";
import { useNavigate, useSearchParams } from 'react-router-dom';
import businessService from '../services/businessService'
import { usePopup } from "../components/popups/PopupContext";
import BusinessListItem from '../components/Business/BusinessListItem';
import PreniumTrial from '../components/Business/PreniumTrial';
import PreniumStarter from '../components/Business/PreniumStarter';
import PreniumProfessional from '../components/Business/PreniumProfessional';
import PreniumEnterprise from '../components/Business/PreniumEnterprise';
export default function membership() {
    const navigate = useNavigate();
    const { openPopup } = usePopup();
    const [searchParams] = useSearchParams();
    const [business, setBusiness] = useState(null);
    useEffect(() => {
        businessService.show(searchParams.get('id'))
            .then((data) => {
                setBusiness(data.message.business);
                localStorage.setItem('business-access', data.message.token);
            })
            .catch((error) => {
                openPopup({
                    message: error.response.data?.message,
                    type: 'error',
                    onConfirm: () => {
                        navigate('/business');
                    }
                })
            })
    }, []);
    return <div>
        <BusinessLayout>
            <div>
                <div className="business-topbar theme-sidebar-bg">
                    <div className="container pt-4 pb-2">
                        <div className="d-flex justify-content-between align-items-center">
                            <div className="d-flex">
                                <div className="">
                                    <img className="thumbnail" 
                                        src={"/assets/logo-icon.png"} alt=''/>
                                </div>
                                <div className="mx-2">
                                    <h2 className="business-topbar-title theme-title-highlight h5">Quản lý công ty</h2>
                                    <p className="theme-title">Quản lý hệ thống công ty của bạn</p>
                                </div>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
                <div className='container mt-4 mb-4'>
                    {business ? <BusinessListItem
                        buttonTopText='Gia hạn ngay'
                        planName={business.name}
                        address={business.address}
                        startDate={business.start_contract_term}
                        endDate={business.end_contract_term}
                        planType={business.membership}
                        onViewDetail={() => {
                            navigate('/')
                        }}
                        onRenew={() => {
                            navigate('/membership?id=' + item.id)
                        }} /> : null}
                </div>
                <div className='container mt-4 mb-4'>
                    <div className='row'>
                        <div className='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                            <PreniumTrial />
                        </div>
                        <div className='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                            <PreniumStarter />
                        </div>
                    </div>
                    <div className='row mt-4'>
                        <div className='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                            <PreniumProfessional />
                        </div>
                        <div className='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                            <PreniumEnterprise />
                        </div>
                    </div>
                </div>
            </div>
        </BusinessLayout>
    </div>
}