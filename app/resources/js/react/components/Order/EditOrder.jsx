import React, { useCallback, useEffect, useMemo, useState } from 'react'
import PageHead from '../PageHead'
import FormStep from '../FormStep'
import { useForm } from '../../libraries/handleInput';
import SecondaryButton from '../UI/Buttons/SecondaryButton';
import PrimaryButton from '../UI/Buttons/PrimaryButton';
import OrderService from '../../services/OrderService';
import { useNavigate, useSearchParams } from 'react-router-dom';
import { usePopup } from '../popups/PopupContext';
import CustomerInformation from './EditOrder/CustomerInformation';
import Products from './EditOrder/Products';
import OrderShippingService from '../../services/OrderShippingService';
import ShippingForm from './EditOrder/ShippingForm';
import Summary from './EditOrder/Summary';
import OrderItemService from '../../services/OrderItemService';
import Completed from './EditOrder/Completed';
import BeforeApprove from './EditOrder/BeforeApprove';
import DangerButton from '../UI/Buttons/DangerButton';
export default function EditOrder() {
    const [currentStep, setCurrentStep] = useState(0);
    const [searchParams] = useSearchParams();
    const form = useForm(null);
    const shippingForm = useForm();
    const [detail, setDetail] = useState(null);
    const [shippingDetail, setShippingDetail] = useState(null);
    const [summaryData, setSummaryData] = useState([]);
    const { openPopup } = usePopup();
    const updateInformation = useCallback((callback = null) => {
        form.setFormErrors(null);
        OrderService.update(form.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been update'
                });
                setDetail(form.formData);
                if (callback) {
                    callback();
                }
            })
            .catch((error) => {
                if (error.response?.data?.errors) {
                    form.setFormErrors(error.response.data?.errors)
                }
                if (error.response?.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
                getDetail();
            })
    }, [form]);
    const confirmUpdateInformation = useCallback(() => {
        if (JSON.stringify(detail) !== JSON.stringify(form.formData)) {
            return openPopup({
                type: 'warning',
                message: 'Just change data, do you wanna to save?',
                onConfirm: () => {
                    updateInformation(() => {
                        setCurrentStep((pre) => pre + 1)
                    });
                },
                onCancel: () => {
                    setCurrentStep((pre) => pre + 1)
                }
            })
        } else {
            setCurrentStep((pre) => pre + 1)
        }
    }, [form.formData, detail]);
    const getDetail = useCallback(() => {
        OrderService.show(searchParams.get('id'))
            .then((resp) => {
                setDetail(resp.message);
                form.setFormData(resp.message);
            })
            .catch((error) => {

            })
    }, [searchParams]);
    const saveShipping = useCallback(() => {
        OrderShippingService.update(shippingForm.formData)
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been changed'
                });
                setShippingDetail(shippingForm.formData);
            })
            .catch((error) => {
                if (error.response.data?.errors) {
                    form.setFormErrors(error.response.data?.errors)
                }
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            })
    }, [shippingForm.formData, shippingDetail]);
    const confirmUpdateShipping = useCallback(() => {
        if (JSON.stringify(shippingDetail) !== JSON.stringify(shippingForm.formData)) {
            return openPopup({
                type: 'warning',
                message: 'Just change data, do you wanna to save?',
                onConfirm: () => {
                    saveShipping(() => {
                        setCurrentStep((pre) => pre + 1)
                    });
                },
                onCancel: () => {
                    setCurrentStep((pre) => pre + 1)
                }
            })
        } else {
            setCurrentStep((pre) => pre + 1)
        }
    }, [shippingForm.formData, shippingDetail]);
    const getSummary = useCallback(() => {
        OrderItemService.summary({
            order_id: searchParams.get('id')
        })
            .then((resp) => {
                setSummaryData(resp.message);
            })
            .catch((error) => {

            })
    }, [searchParams]);
    const confirmApprove = () => {
        openPopup({
            type: 'warning',
            message: 'Are you sure wanna to take approved',
            onConfirm: () => {
                form.handleChangeByKey('status','approved');
            }
        })
    };
    const confirmCancelled = () => {
        openPopup({
            type: 'warning',
            message: 'Are you sure wanna to take cancelled',
            onConfirm: () => {
                form.handleChangeByKey('status','cancelled');
            }
        })
    };
    useEffect(() => {
        if(detail?.status === 'pending' && form.formData?.status === 'approved') {
            updateInformation(() => {

            });
        }
        if(detail?.status === 'approved' && form.formData?.status === 'cancelled') {
            updateInformation(() => {

            });
        }
    },[form?.formData?.status, detail?.status])
    const nextStep = () => {
        if (currentStep >= 3) {
            return;
        }
        if (currentStep === 0) {
            return confirmUpdateInformation();
        }
        if (currentStep === 2) {
            return confirmUpdateShipping();
        }
        setCurrentStep((pre) => pre + 1)
    }
    const prevStep = () => {
        if (currentStep === 0) {
            return;
        }
        setCurrentStep((pre) => pre - 1)
    }
    const getDetailOrderShipping = useCallback(() => {
        OrderShippingService.show({
            order_id: detail?.id,
            id: detail?.shipping_id
        })
            .then((resp) => {
                shippingForm.setFormData(resp.message);
                setShippingDetail(resp.message);
            }).catch((error) => {

            })
    }, [detail])

    useEffect(() => {
        getDetail();
    }, []);
    useEffect(() => {
        if (detail) {
            getDetailOrderShipping();
            getSummary();
        }
    }, [detail])

    return <div>
        <PageHead 
        containerClass='mx-5'
        title='Order' subtitle='Add new order' />
        {detail ? <div>
            <div className='row mx-4'>
               <div className='mt-3'>
                 <FormStep
                    list={["Customer & Order", "Products", "Shipping", "Completed"]}
                    active={currentStep} />
               </div>
                <div className='col-9'>
                    <div className='mt-3'>
                        <div className='theme-card p-3 rounded-4 border'>
                            <div className={currentStep == 0 ? 'show' : 'hidden'}>
                                <CustomerInformation form={form} />
                            </div>
                            <div className={currentStep == 1 ? 'show' : 'hidden'}>
                                <Products />
                            </div>
                            <div className={currentStep == 2 ? 'show' : 'hidden'}>
                                <ShippingForm form={shippingForm} />
                            </div>
                            <div className={currentStep == 3 ? 'show' : 'hidden'}>
                                {detail?.status === 'approved' 
                                ? <Completed/>
                                : <BeforeApprove/>}
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-2">
                                <SecondaryButton onClick={prevStep} label='Back' />
                            </div>
                            <div className="col-2 ms-auto text-end">
                                
                                {currentStep <= 2 
                                ? <PrimaryButton onClick={nextStep} label='Next' />
                                : null}

                                {currentStep === 3 && detail?.status === 'pending' 
                                ? <PrimaryButton onClick={confirmApprove} label='Approved' />
                                : null }

                                {currentStep === 3 && detail?.status === 'approved' 
                                ? <DangerButton onClick={confirmCancelled} label='Cancelled' />
                                : null }
                            </div>
                        </div>
                    </div>
                </div>
                <div className='col-3'>
                    <Summary reload={getSummary} summaryData={summaryData} />
                </div>
            </div>
        </div> : null}
    </div>
}